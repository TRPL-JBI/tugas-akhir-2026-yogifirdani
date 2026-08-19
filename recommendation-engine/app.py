import logging
import os
import hashlib
import json
from flask import Flask, request, jsonify
import pandas as pd
import numpy as np

from database import (
    get_active_destinations,
    get_preference_by_id,
    get_all_vectors,
    save_package_vector,
    save_recommendation_result,
    clear_package_vectors
)
from preprocessor import (
    build_combined_features,
    build_preference_features,
    preprocess
)
from vectorizer import (
    fit_and_save_vectorizer,
    load_vectorizer,
    transform_preference,
    calculate_similarity,
    get_top_n,
    MODEL_PATH
)
from config import FLASK_HOST, FLASK_PORT, FLASK_DEBUG


# Konfigurasi logging dasar ke console
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

# Inisialisasi aplikasi Flask
app = Flask(__name__)

def auto_update_excel(query_text, similarity_scores, destination_ids, active_dest_dict):
    """
    Menyimpan hasil perhitungan similarity dari query baru ke sheet baru di file Excel secara otomatis.
    Menjamin sheet/query terdahulu TIDAK hilang.
    """
    excel_path = "hasil_similarity_rekomendasi_sheets.xlsx"
    try:
        # Preprocessing input pengguna
        processed_query = preprocess(query_text)
        # Jika query kosong setelah di-preprocess, abaikan
        if not processed_query or len(processed_query) < 2:
            return
            
        # Bersihkan nama sheet (Maks 31 karakter, tidak boleh memuat karakter terlarang Excel)
        sheet_name = "".join([c for c in processed_query if c.isalnum() or c in " _-"])[:30]
        if not sheet_name:
            sheet_name = "pencarian"
            
        # Urutkan destinasi berdasarkan similarity score
        query_results = []
        for dest_id, score in zip(destination_ids, similarity_scores):
            if dest_id in active_dest_dict:
                dest_info = active_dest_dict[dest_id]
                query_results.append({
                    "name": dest_info['name'],
                    "category": dest_info['category'],
                    "score": float(score) * 100
                })
        
        query_results = sorted(query_results, key=lambda x: x['score'], reverse=True)
        
        # Susun data baris
        sheet_rows = []
        for rank, item in enumerate(query_results, start=1):
            sheet_rows.append({
                "No": rank,
                "Input Pengguna": query_text,
                "Input Terproses (Stemming AI)": processed_query,
                "Nama Destinasi Wisata": item['name'],
                "Kategori Wisata": item['category'],
                "Skor Similarity (%)": round(item['score'], 2),
                "Peringkat (Rank)": rank
            })
            
        df_new = pd.DataFrame(sheet_rows)
        
        # Baca semua sheet yang sudah ada sebelumnya agar tidak terhapus
        existing_sheets = {}
        if os.path.exists(excel_path):
            try:
                xls = pd.ExcelFile(excel_path)
                for sheet in xls.sheet_names:
                    # Baca sheet lama
                    existing_sheets[sheet] = pd.read_excel(xls, sheet_name=sheet)
            except Exception as read_err:
                logger.warning(f"Gagal membaca sheet lama: {str(read_err)}. Membuat file baru.")
                
        # Masukkan sheet baru (timpa jika nama sheet sama)
        existing_sheets[sheet_name] = df_new
        
        # Tulis ulang seluruh sheet ke file Excel
        with pd.ExcelWriter(excel_path, engine='openpyxl') as writer:
            for s_name, s_df in existing_sheets.items():
                s_df.to_excel(writer, sheet_name=s_name, index=False)
                
        logger.info(f"Otomatisasi Excel: Berhasil menambahkan/memperbarui sheet '{sheet_name}' di '{excel_path}'.")
    except Exception as exc_err:
        # Kita gunakan try-except agar jika file excel sedang di-lock oleh admin, API utama web tidak ikutan crash (fail-safe)
        logger.error(f"Gagal mengupdate Excel hasil similarity secara otomatis: {str(exc_err)}")


# PENTING: Mengembalikan JSON dengan format yang rapi saat didebug
app.config['JSONIFY_PRETTYPRINT_REGULAR'] = True

def perform_vectorization():
    """
    Fungsi internal untuk mengeksekusi proses re-vektorisasi destinasi.
    Mengambil data dari database, melatih model TF-IDF baru, dan mengupdate database.
    """
    df_destinations = get_active_destinations()
    if df_destinations.empty:
        raise ValueError("Tidak ada data destinasi wisata aktif untuk divektorisasi.")
        
    corpus = []
    destination_ids = []
    for idx, row in df_destinations.iterrows():
        combined_feat = build_combined_features(row)
        corpus.append(combined_feat)
        destination_ids.append(int(row['id']))
        
    vectorizer, tfidf_matrix = fit_and_save_vectorizer(corpus)
    
    vocab_json_str = json.dumps(vectorizer.vocabulary_, sort_keys=True)
    vocab_hash = hashlib.sha256(vocab_json_str.encode('utf-8')).hexdigest()
    
    clear_package_vectors()
    
    for i, dest_id in enumerate(destination_ids):
        vector_dense = tfidf_matrix[i].toarray()[0].tolist()
        combined_text = corpus[i]
        save_package_vector(dest_id, combined_text, vector_dense, vocab_hash)
        
    return vectorizer, destination_ids, len(vectorizer.vocabulary_)


@app.route('/')
@app.route('/vectorize', methods=['POST'])
def vectorize():
    """
    Endpoint 1: POST /vectorize
    Dipanggil Laravel saat admin melakukan tambah/edit/hapus destinasi.
    Melakukan ekstraksi teks destinasi, pembobotan TF-IDF baru, dan menyimpan ke database.
    """
    logger.info("Menerima permintaan /vectorize untuk melatih ulang model TF-IDF destinasi...")
    try:
        vectorizer, destination_ids, vocab_size = perform_vectorization()
        
        return jsonify({
            "status": "success",
            "message": "Proses vektorisasi destinasi dan pelatihan ulang TF-IDF selesai dengan sukses.",
            "total_destinasi": len(destination_ids),
            "vocabulary_size": vocab_size,
            "destinations_vectorized": destination_ids
        }), 200
        
    except ValueError as ve:
        logger.warning(str(ve))
        return jsonify({
            "status": "error",
            "message": str(ve)
        }), 404
    except Exception as e:
        logger.error(f"Error pada endpoint /vectorize: {str(e)}")
        return jsonify({
            "status": "error",
            "message": f"Terjadi kesalahan sistem saat vektorisasi destinasi: {str(e)}"
        }), 500


@app.route('/recommend', methods=['POST'])
def recommend():
    """
    Endpoint 2: POST /recommend
    Dipanggil Laravel saat wisatawan memasukkan preferensi pencarian.
    Menerima preference_id, menghitung Cosine Similarity terhadap destinasi, dan menyimpan hasilnya.
    """
    logger.info("Menerima permintaan rekomendasi destinasi wisata...")
    
    # 1. Validasi input request body
    data = request.get_json(silent=True) or {}
    preference_id = data.get('preference_id')
    
    if not preference_id:
        logger.warning("Permintaan ditolak: parameter 'preference_id' tidak ada dalam request.")
        return jsonify({
            "status": "error",
            "message": "Parameter 'preference_id' wajib diisi."
        }), 400
        
    try:
        # 2. Ambil preferensi pengguna berdasarkan ID
        preference = get_preference_by_id(preference_id)
        if not preference:
            logger.warning(f"Data preferensi dengan ID {preference_id} tidak ditemukan.")
            return jsonify({
                "status": "error",
                "message": f"Data preferensi dengan ID {preference_id} tidak ditemukan."
            }), 404
            
        # 3. Muat model TF-IDF dari penyimpanan PKL
        try:
            vectorizer = load_vectorizer()
        except FileNotFoundError as fnf_err:
            return jsonify({
                "status": "error",
                "message": f"Model belum diinisialisasi. Silakan jalankan /vectorize terlebih dahulu. Error: {str(fnf_err)}"
            }), 503
            
        # 4. Ambil semua vektor destinasi yang ada di database
        df_vectors = get_all_vectors()
        if df_vectors.empty:
            logger.warning("Tabel vektor destinasi kosong.")
            return jsonify({
                "status": "error",
                "message": "Proses vektorisasi destinasi belum pernah dijalankan. Jalankan /vectorize terlebih dahulu."
            }), 404
            
        # 5. Gabungkan fitur preferensi pengguna (deskripsi minat)
        preference_text = build_preference_features(preference)
        logger.info(f"Teks preferensi terproses: '{preference_text}'")
        
        # 6. Transformasikan teks preferensi ke bentuk Vektor TF-IDF
        preference_vector = transform_preference(vectorizer, preference_text)
        
        # 7. Siapkan data vektor destinasi untuk kalkulasi
        destination_ids = []
        destination_vectors = []
        
        for idx, row in df_vectors.iterrows():
            vec_data = row['tfidf_vector']
            if isinstance(vec_data, str):
                vec_list = json.loads(vec_data)
            else:
                vec_list = list(vec_data)
            
            destination_vectors.append(vec_list)
            destination_ids.append(int(row['destination_id']))
            
        # 8. Hitung Cosine Similarity antara preferensi dan semua destinasi
        try:
            similarity_scores = calculate_similarity(preference_vector, destination_vectors)
        except ValueError as ve:
            if "Incompatible dimension" in str(ve):
                logger.warning("Terdeteksi Incompatible dimension (Data vektor di database dan model PKL tidak sinkron). Melakukan auto-sync...")
                # Otomatis lakukan re-vektorisasi agar sinkron
                vectorizer, _, _ = perform_vectorization()
                
                # Transformasi ulang preferensi dengan model baru
                preference_vector = transform_preference(vectorizer, preference_text)
                
                # Ambil ulang vektor destinasi dari database yang sudah diperbarui
                df_vectors = get_all_vectors()
                destination_ids = []
                destination_vectors = []
                for idx, row in df_vectors.iterrows():
                    vec_data = row['tfidf_vector']
                    if isinstance(vec_data, str):
                        vec_list = json.loads(vec_data)
                    else:
                        vec_list = list(vec_data)
                    destination_vectors.append(vec_list)
                    destination_ids.append(int(row['destination_id']))
                    
                # Hitung ulang similarity
                similarity_scores = calculate_similarity(preference_vector, destination_vectors)
            else:
                raise ve
        
        # 9. Terapkan Penyaringan Konten Terstruktur (Kategori Destinasi)
        df_active_dest = get_active_destinations()
        active_dest_dict = df_active_dest.set_index('id').to_dict(orient='index')
        
        pref_category = str(preference.get('tour_category') or '').lower().strip()
        
        filtered_destinations = []
        for dest_id, score in zip(destination_ids, similarity_scores):
            if dest_id not in active_dest_dict:
                continue
            dest_info = active_dest_dict[dest_id]
            
            # Penyaringan Kategori (Jika kategori diinputkan dan tidak bernilai 'semua kategori')
            dest_category = str(dest_info.get('category') or '').lower()
            if pref_category and pref_category != 'semua kategori':
                # Normalisasi teks kategori (misal: membuang whitespace dan mencocokkan kata kunci utama)
                # Contoh: 'nature trip' harus bisa cocok dengan 'wisata alam / nature trip'
                if pref_category not in dest_category:
                    continue
                
            filtered_destinations.append({
                "destination_id": dest_id,
                "similarity_score": round(float(score), 4)
            })
            
        # 10. Pengurutan Akhir (Ranking) berdasarkan skor kemiripan tertinggi
        sorted_destinations = sorted(filtered_destinations, key=lambda x: x["similarity_score"], reverse=True)
        
        # Ambil Top-5 Destinasi Rekomendasi jika similarity score > 0
        # Catatan: Laravel yang mengontrol berapa yang ditampilkan:
        # - Menu Rekomendasi: hanya pakai index [0] → Top 1
        # - Halaman Home: pakai ->take(4) → Top 4
        top_recommendations = []
        for i, item in enumerate(sorted_destinations[:5], start=1):
            if item["similarity_score"] > 0:
                item["rank"] = i
                top_recommendations.append(item)
        
        enriched_data = []
        results_list = []      # ID destinasi terpilih
        scores_dict = {}       # Skor similarity
        
        for item in top_recommendations:
            dest_id = item['destination_id']
            score = item['similarity_score']
            rank = item['rank']
            
            results_list.append(dest_id)
            scores_dict[str(dest_id)] = score
            
            if dest_id in active_dest_dict:
                dest_info = active_dest_dict[dest_id]
                enriched_data.append({
                    "rank": rank,
                    "destination_id": dest_id,
                    "name": dest_info['name'],
                    "category": dest_info['category'],
                    "city": dest_info['city'],
                    "description": dest_info['description'],
                    "image": dest_info.get('image'),
                    "similarity_score": score,
                    "slug": dest_info['slug']
                })
                
        # 11. Simpan hasil rekomendasi ke tabel 'recommendations'
        session_id = preference.get('session_id', 'unknown')
        save_recommendation_result(preference_id, session_id, results_list, scores_dict)
        
        # 12. Update Excel hasil similarity secara otomatis secara real-time
        user_query = preference.get('description') or ""
        if user_query:
            auto_update_excel(user_query, similarity_scores, destination_ids, active_dest_dict)
        
        return jsonify({
            "status": "success",
            "preference": {
                "category": preference.get('tour_category') or "Semua Kategori",
                "budget": float(preference.get('budget') or 0),
                "duration": preference.get('preferred_duration') or "Semua Durasi",
                "facilities": preference.get('preferred_facilities') or "",
                "description": preference.get('description') or ""
            },
            "data": enriched_data
        }), 200
        
    except Exception as e:
        logger.error(f"Error pada endpoint /recommend: {str(e)}")
        return jsonify({
            "status": "error",
            "message": f"Terjadi kesalahan sistem saat pemrosesan rekomendasi: {str(e)}"
        }), 500


@app.route('/health', methods=['GET'])
def health():
    """
    Endpoint 3: GET /health
    Memeriksa kesehatan sistem (health check) dan ketersediaan model TF-IDF.
    """
    try:
        model_exists = os.path.exists(MODEL_PATH)
        df_vectors = get_all_vectors()
        total_vectors = len(df_vectors)
        
        return jsonify({
            "status": "ok",
            "model_exists": model_exists,
            "total_vectors_in_db": total_vectors
        }), 200
    except Exception as e:
        logger.error(f"Error pada endpoint /health: {str(e)}")
        return jsonify({
            "status": "error",
            "message": f"Layanan database atau sistem bermasalah: {str(e)}"
        }), 500


@app.route('/evaluate', methods=['POST'])
def evaluate():
    """
    Endpoint 4: POST /evaluate (Opsional / Tambahan)
    Mengukur performa rekomendasi (Precision, Recall, F1-Score) secara simulasi
    menggunakan minimal 3 skenario preferensi wisatawan yang berbeda.
    """
    logger.info("Memulai proses evaluasi performa sistem rekomendasi...")
    try:
        # 1. Ambil seluruh paket aktif dari database untuk dibandingkan
        df_packages = get_active_packages()
        if df_packages.empty:
            return jsonify({
                "status": "error",
                "message": "Tidak ada data paket wisata aktif untuk dievaluasi."
            }), 404
            
        # 2. Muat model TF-IDF
        try:
            vectorizer = load_vectorizer()
        except FileNotFoundError:
            return jsonify({
                "status": "error",
                "message": "Model belum dilatih. Lakukan /vectorize terlebih dahulu."
            }), 503
            
        # 3. Ambil seluruh vektor paket dari DB
        df_vectors = get_all_vectors()
        if df_vectors.empty:
            return jsonify({
                "status": "error",
                "message": "Tidak ada vektor paket wisata tersimpan."
            }), 404
            
        package_ids = []
        package_vectors = []
        for idx, row in df_vectors.iterrows():
            vec = row['tfidf_vector']
            vec_list = json.loads(vec) if isinstance(vec, str) else list(vec)
            package_vectors.append(vec_list)
            package_ids.append(int(row['package_id']))

        # 4. Definisikan minimal 3 skenario preferensi wisatawan sebagai data uji
        scenarios = [
            {
                "id": 1,
                "skenario": "Wisatawan Ekonomis Budget Terbatas",
                "tour_category": "Nature Trip",
                "budget": 300000.0,
                "preferred_duration": "7 Jam",
                "preferred_facilities": "jeep tiket masuk guide jeep",
                "description": "ingin melihat matahari terbit di bromo dengan budget hemat"
            },
            {
                "id": 2,
                "skenario": "Wisatawan Snorkeling Petualang",
                "tour_category": "Adventure Trip",
                "budget": 500000.0,
                "preferred_duration": "1 Day",
                "preferred_facilities": "snorkeling kapal konsumsi guide",
                "description": "mencari petualangan snorkeling dan menyeberang dengan kapal"
            },
            {
                "id": 3,
                "skenario": "Wisatawan Premium Tour Lengkap",
                "tour_category": "Culture Trip",
                "budget": 3000000.0,
                "preferred_duration": "2D1N",
                "preferred_facilities": "mobil driver bbm ijen guide air mineral senter",
                "description": "wisata sejarah dan budaya banyuwangi dengan mobil dan driver lengkap"
            }
        ]
        
        evaluation_results = []
        total_precision = 0.0
        total_recall = 0.0
        total_f1 = 0.0
        
        # 5. Evaluasi masing-masing skenario
        for sc in scenarios:
            # A. Tentukan Himpunan Ground Truth Paket Wisata RELEVAN (R)
            # Aturan relevansi:
            # 1. tour_category paket SAMA dengan tour_category preferensi, ATAU
            # 2. harga paket (pax1) <= budget preferensi * 1.3 (toleransi 30% di atas budget)
            relevant_package_ids = set()
            for idx, pkg in df_packages.iterrows():
                pkg_id = int(pkg['id'])
                pkg_tour_cat = pkg.get('tour_category')
                pax1_val = pkg.get('pax1')
                pax1_float = float(pax1_val) if pd.notna(pax1_val) else 0.0
                
                # Cek kriteria relevansi
                match_category = (pkg_tour_cat is not None and pkg_tour_cat == sc['tour_category'])
                match_budget = (pax1_float <= sc['budget'] * 1.3)
                
                if match_category or match_budget:
                    relevant_package_ids.add(pkg_id)
            
            # B. Jalankan Rekomendasi TF-IDF + Cosine Similarity untuk Skenario Ini
            pref_text = build_preference_features(sc)
            pref_vector = transform_preference(vectorizer, pref_text)
            scores = calculate_similarity(pref_vector, package_vectors)
            top_rec = get_top_n(scores, package_ids, n=5)
            recommended_ids = [item['package_id'] for item in top_rec]
            
            # C. Hitung Metrik Kebenaran Evaluasi (TP, FP, FN)
            recommended_set = set(recommended_ids)
            
            # TP (True Positives): Paket direkomendasikan yang MEMANG RELEVAN
            tp = len(recommended_set.intersection(relevant_package_ids))
            
            # FP (False Positives): Paket direkomendasikan tapi TIDAK RELEVAN
            fp = len(recommended_set.difference(relevant_package_ids))
            
            # FN (False Negatives): Paket RELEVAN tapi TIDAK direkomendasikan
            fn = len(relevant_package_ids.difference(recommended_set))
            
            # D. Hitung Precision, Recall, dan F1-Score
            precision = tp / (tp + fp) if (tp + fp) > 0 else 0.0
            recall = tp / (tp + fn) if (tp + fn) > 0 else 0.0
            f1 = 2 * (precision * recall) / (precision + recall) if (precision + recall) > 0 else 0.0
            
            total_precision += precision
            total_recall += recall
            total_f1 += f1
            
            evaluation_results.append({
                "skenario_id": sc['id'],
                "nama_skenario": sc['skenario'],
                "preferensi": {
                    "kategori": sc['tour_category'],
                    "budget": sc['budget'],
                    "fasilitas": sc['preferred_facilities'],
                    "deskripsi": sc['description']
                },
                "jumlah_relevan_aktual": len(relevant_package_ids),
                "paket_relevan_aktual": list(relevant_package_ids),
                "paket_direkomendasikan": recommended_ids,
                "metrik": {
                    "true_positives_tp": tp,
                    "false_positives_fp": fp,
                    "false_negatives_fn": fn,
                    "precision": round(precision, 4),
                    "recall": round(recall, 4),
                    "f1_score": round(f1, 4)
                }
            })
            
        # 6. Hitung rata-rata keseluruhan (Average Metrics)
        avg_precision = total_precision / len(scenarios)
        avg_recall = total_recall / len(scenarios)
        avg_f1 = total_f1 / len(scenarios)
        
        return jsonify({
            "status": "success",
            "message": "Proses evaluasi sistem rekomendasi selesai.",
            "metrik_rata_rata": {
                "average_precision": round(avg_precision, 4),
                "average_recall": round(avg_recall, 4),
                "average_f1_score": round(avg_f1, 4)
            },
            "detail_skenario": evaluation_results
        }), 200
        
    except Exception as e:
        logger.error(f"Error pada endpoint /evaluate: {str(e)}")
        return jsonify({
            "status": "error",
            "message": f"Terjadi kesalahan sistem saat evaluasi: {str(e)}"
        }), 500


@app.route('/download-excel', methods=['GET'])
def download_excel():
    """
    Endpoint: GET /download-excel
    Mengenerate file Excel berisi skor similarity dari riwayat pencarian pengguna (real-time)
    dan langsung mendownloadnya ke browser pengguna.
    """
    import io
    import pandas as pd
    from flask import send_file
    from sqlalchemy import text
    from sklearn.feature_extraction.text import TfidfVectorizer
    from sklearn.metrics.pairwise import cosine_similarity
    from database import get_connection
    
    try:
        logger.info("Menerima permintaan download Excel riwayat similarity...")
        conn = get_connection()
        
        # 1. Ambil maksimal 20 riwayat pencarian terakhir (unik) yang diinputkan pengguna
        query = text("""
            SELECT description 
            FROM user_preferences 
            WHERE description IS NOT NULL AND description != '' 
            GROUP BY description
            ORDER BY MAX(id) DESC LIMIT 20
        """)
        rows = conn.execute(query).mappings().fetchall()
        test_queries = [r['description'] for r in rows]
        
        # Fallback jika belum ada pencarian sama sekali di database
        if not test_queries:
            test_queries = ["gunung", "pantai", "budaya"]
            
        # 2. Ambil destinasi aktif secara real-time
        df_active = get_active_destinations()
        if df_active.empty:
            return jsonify({"status": "error", "message": "Tidak ada destinasi aktif"}), 404
            
        dest_names = []
        dest_categories = []
        dest_features = []
        for idx, row in df_active.iterrows():
            combined_text = build_combined_features(row)
            dest_features.append(combined_text)
            dest_names.append(row['name'])
            dest_categories.append(row['category'])
            
        # 3. Latih TF-IDF secara real-time untuk menjamin dimensi matriks selalu valid
        vectorizer = TfidfVectorizer(sublinear_tf=True, norm='l2')
        tfidf_matrix = vectorizer.fit_transform(dest_features).toarray()
        
        # 4. Siapkan output Excel di dalam Memory (RAM) agar sangat cepat
        output = io.BytesIO()
        with pd.ExcelWriter(output, engine='openpyxl') as writer:
            for q in test_queries:
                processed_query = preprocess(q)
                if not processed_query or len(processed_query) < 2:
                    continue
                    
                # Bersihkan nama sheet (Hanya huruf dan angka, maks 31 karakter untuk Excel)
                sheet_name = "".join([c for c in processed_query if c.isalnum() or c in " _-"])[:30]
                if not sheet_name:
                    sheet_name = "pencarian"
                    
                query_vector = vectorizer.transform([processed_query]).toarray()
                scores = cosine_similarity(query_vector, tfidf_matrix)[0]
                
                query_results = []
                for i, score in enumerate(scores):
                    query_results.append({
                        "name": dest_names[i],
                        "category": dest_categories[i],
                        "score": float(score) * 100
                    })
                    
                query_results = sorted(query_results, key=lambda x: x['score'], reverse=True)
                
                sheet_data = []
                for rank, item in enumerate(query_results, start=1):
                    sheet_data.append({
                        "No": rank,
                        "Input Pengguna": q,
                        "Input Terproses (Stemming AI)": processed_query,
                        "Nama Destinasi Wisata": item['name'],
                        "Kategori Wisata": item['category'],
                        "Skor Similarity (%)": round(item['score'], 2),
                        "Peringkat (Rank)": rank
                    })
                    
                # Buat Sheet untuk setiap inputan
                pd.DataFrame(sheet_data).to_excel(writer, sheet_name=sheet_name, index=False)
                
        # Pindahkan kursor memory ke awal file
        output.seek(0)
        
        # Kirim file langsung ke browser pengguna sebagai unduhan (Download)
        return send_file(
            output, 
            download_name="Laporan_Similarity_Realtime.xlsx", 
            as_attachment=True,
            mimetype="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        )
        
    except Exception as e:
        logger.error(f"Error pada /download-excel: {str(e)}")
        return jsonify({"status": "error", "message": str(e)}), 500


if __name__ == '__main__':
    # Menjalankan aplikasi Flask
    logger.info(f"Memulai server Flask di http://{FLASK_HOST}:{FLASK_PORT}")
    app.run(host=FLASK_HOST, port=FLASK_PORT, debug=FLASK_DEBUG)