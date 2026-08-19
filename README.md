# Sistem Rekomendasi Paket Wisata Berbasis Content-Based Filtering

Repository ini merupakan source code **Tugas Akhir** yang dikembangkan oleh:

| Informasi | Keterangan |
|---|---|
| **Nama** | Achmad Yogi Firdani |
| **NIM** | 362258302019 |
| **Program Studi** | Teknologi Rekayasa Perangkat Lunak |
| **Institusi** | Politeknik Negeri Banyuwangi |
| **Tahun** | 2026 |

Project ini mengembangkan sebuah **sistem rekomendasi paket wisata berbasis web** yang membantu pengguna memperoleh rekomendasi paket wisata berdasarkan preferensi yang diberikan.

Sistem terdiri dari aplikasi web utama menggunakan **Laravel** dan *recommendation engine* berbasis **Python dan Flask**. Proses rekomendasi menggunakan pendekatan **Content-Based Filtering** dengan metode **TF-IDF (Term Frequency-Inverse Document Frequency)** dan **Cosine Similarity**.

---

## 📌 Tentang Project

Banyaknya pilihan paket dan destinasi wisata dapat menyulitkan wisatawan dalam menentukan pilihan yang sesuai dengan kebutuhan dan preferensi mereka.

Sistem ini dirancang untuk membantu proses tersebut dengan memberikan rekomendasi berdasarkan karakteristik paket wisata dan preferensi pengguna.

Secara umum, proses rekomendasi dilakukan melalui tahapan:

1. Pengguna memasukkan preferensi wisata.
2. Sistem menyimpan data preferensi pengguna.
3. Data teks melalui tahap *text preprocessing*.
4. Informasi paket wisata direpresentasikan menjadi vektor menggunakan **TF-IDF**.
5. Preferensi pengguna ditransformasikan ke dalam ruang vektor TF-IDF yang sama.
6. Sistem menghitung tingkat kemiripan menggunakan **Cosine Similarity**.
7. Paket wisata diurutkan berdasarkan nilai kemiripan.
8. Paket dengan nilai kemiripan tertinggi diberikan sebagai rekomendasi.

---

## 🏗️ Arsitektur Sistem

Project dibagi menjadi dua aplikasi utama:

```text
tugas-akhir-2026-yogifirdani/
│
├── Project-TA-Sistem-Rekomendasi-Paket-Wisata/
│   └── Aplikasi utama berbasis Laravel
│
└── recommendation-engine/
    └── Recommendation Engine berbasis Python/Flask
```

Arsitektur sistem secara sederhana:

```text
┌──────────────────────┐
│       Pengguna       │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   Laravel Web App    │
│ UI / Authentication  │
│ Data Paket Wisata    │
│ Preferensi Pengguna  │
│ Transaksi / Payment  │
└──────────┬───────────┘
           │ HTTP Request / API
           ▼
┌──────────────────────┐
│      Flask API       │
│ Recommendation      │
│ Engine              │
└──────────┬───────────┘
           ▼
┌──────────────────────┐
│ Text Preprocessing   │
│         ↓            │
│       TF-IDF         │
│         ↓            │
│ Cosine Similarity    │
└──────────┬───────────┘
           ▼
┌──────────────────────┐
│ Recommendation Rank  │
└──────────────────────┘
```

Laravel bertindak sebagai aplikasi utama yang berinteraksi dengan pengguna, sedangkan Flask bertindak sebagai layanan rekomendasi yang menangani pengolahan teks, vektorisasi, dan perhitungan kemiripan.

---

## ✨ Fitur Utama

### 👤 Pengguna

- Melihat informasi paket wisata.
- Melihat detail paket wisata.
- Memasukkan preferensi wisata.
- Mendapatkan rekomendasi paket wisata.
- Melihat hasil rekomendasi berdasarkan tingkat kemiripan.
- Melakukan pemesanan paket wisata.
- Mengakses informasi transaksi dan pembayaran.

### 🧠 Recommendation Engine

- Mengambil data paket wisata dari database.
- Melakukan *text preprocessing*.
- Membersihkan data teks.
- Melakukan *stopword removal* Bahasa Indonesia.
- Melakukan *stemming*.
- Membentuk fitur paket wisata.
- Melakukan vektorisasi menggunakan TF-IDF.
- Menyimpan dan memuat model TF-IDF.
- Mengubah preferensi pengguna menjadi representasi vektor.
- Menghitung nilai Cosine Similarity.
- Mengurutkan paket berdasarkan similarity score.
- Menghasilkan rekomendasi paket wisata.
- Menyediakan API untuk aplikasi Laravel.

### 💳 Transaksi

Sistem memiliki integrasi dengan **Midtrans** untuk mendukung proses pembayaran.

---

## 🧠 Metode Rekomendasi

Sistem menggunakan pendekatan **Content-Based Filtering**.

### 1. Text Preprocessing

```text
Raw Text
   ↓
Cleaning
   ↓
Case Folding
   ↓
Stopword Removal
   ↓
Stemming
   ↓
Processed Text
```

Project menggunakan **PySastrawi** untuk membantu pengolahan Bahasa Indonesia.

### 2. TF-IDF

Data teks dikonversikan menjadi representasi numerik menggunakan **TF-IDF**.

```text
TF-IDF = TF × IDF
```

**Term Frequency (TF)** mengukur seberapa sering suatu kata muncul pada sebuah dokumen, sedangkan **Inverse Document Frequency (IDF)** mengukur seberapa penting kata tersebut dibandingkan dengan seluruh dokumen.

### 3. Cosine Similarity

Preferensi pengguna dan paket wisata dibandingkan menggunakan **Cosine Similarity**.

```text
                     A · B
cosine(A, B) = ─────────────────
                  ||A|| ||B||
```

Keterangan:

```text
A = vektor preferensi pengguna
B = vektor paket wisata
```

Nilai similarity yang semakin tinggi menunjukkan paket wisata semakin sesuai dengan preferensi pengguna.

---

## 🛠️ Teknologi yang Digunakan

### Backend Web Application

| Teknologi | Kegunaan |
|---|---|
| Laravel 12 | Framework aplikasi web |
| PHP 8.2+ | Bahasa pemrograman backend |
| MySQL | Database |
| Composer | Dependency manager PHP |
| Midtrans PHP SDK | Integrasi pembayaran |
| Intervention Image | Pemrosesan gambar |
| Flysystem AWS S3 | Integrasi object storage |

### Frontend

| Teknologi | Kegunaan |
|---|---|
| Blade | Template engine Laravel |
| Tailwind CSS | Styling |
| Vite | Frontend build tool |
| Alpine.js | Interaksi frontend |
| Axios | HTTP request |
| ApexCharts | Visualisasi data |
| FullCalendar | Komponen kalender |
| Flatpickr | Date/time picker |
| JSVectorMap | Visualisasi peta |

### Recommendation Engine

| Teknologi | Kegunaan |
|---|---|
| Python | Recommendation engine |
| Flask | REST API |
| Pandas | Manipulasi data |
| NumPy | Operasi numerik |
| Scikit-learn | TF-IDF dan Cosine Similarity |
| PySastrawi | Stemming dan stopword Bahasa Indonesia |
| SQLAlchemy | Akses database |
| PyMySQL | Driver MySQL |
| Joblib | Penyimpanan model |
| BeautifulSoup | Cleaning teks |
| python-dotenv | Environment configuration |

---

## 📁 Struktur Project

```text
tugas-akhir-2026-yogifirdani/
├── Project-TA-Sistem-Rekomendasi-Paket-Wisata/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── artisan
│   ├── composer.json
│   ├── package.json
│   └── vite.config.js
│
└── recommendation-engine/
    ├── models/
    ├── app.py
    ├── config.py
    ├── database.py
    ├── preprocessor.py
    ├── vectorizer.py
    ├── train_model.py
    ├── read_pdf.py
    ├── migration.sql
    ├── requirements.txt
    ├── demo_cosine.py
    ├── demo_evaluasi.py
    ├── demo_laporan.py
    ├── demo_matrix.py
    ├── demo_preprocess.py
    └── demo_tfidf_breakdown.py
```

---

## ⚙️ Persyaratan Sistem

Pastikan perangkat telah memiliki:

```text
PHP >= 8.2
Composer
Node.js
NPM
Python
pip
MySQL
Git
```

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/TRPL-JBI/tugas-akhir-2026-yogifirdani.git
cd tugas-akhir-2026-yogifirdani
```

### 2. Instalasi Laravel

```bash
cd Project-TA-Sistem-Rekomendasi-Paket-Wisata
composer install
npm install
```

Salin environment file:

**Windows**
```bash
copy .env.example .env
```

**Linux/macOS**
```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 3. Konfigurasi Database

Contoh konfigurasi `.env` Laravel:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_kutamasya
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration dan storage link:

```bash
php artisan migrate
php artisan storage:link
```

Jika menggunakan seeder:

```bash
php artisan db:seed
```

### 4. Instalasi Recommendation Engine

```bash
cd ../recommendation-engine
python -m venv venv
```

Aktifkan virtual environment pada Windows:

```bash
venv\Scripts\activate
```

Linux/macOS:

```bash
source venv/bin/activate
```

Install dependencies:

```bash
pip install -r requirements.txt
```

Contoh `.env` recommendation engine:

```env
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=
DB_NAME=db_kutamasya

FLASK_HOST=0.0.0.0
FLASK_PORT=5000
FLASK_DEBUG=True
```

---

## ▶️ Menjalankan Project

### Terminal 1 - Laravel

```bash
cd Project-TA-Sistem-Rekomendasi-Paket-Wisata
php artisan serve
```

Laravel secara default dapat diakses melalui:

```text
http://127.0.0.1:8000
```

### Terminal 2 - Vite

```bash
cd Project-TA-Sistem-Rekomendasi-Paket-Wisata
npm run dev
```

### Terminal 3 - Recommendation Engine

```bash
cd recommendation-engine
python app.py
```

Flask secara default berjalan pada:

```text
http://localhost:5000
```

---

## 🔄 Alur Integrasi Laravel dan Flask

```text
User
 │
 │ Input Preferensi
 ▼
Laravel
 │
 │ Simpan Data
 ▼
MySQL
 │
 ▼
Laravel
 │
 │ POST /recommend
 ▼
Flask Recommendation Engine
 │
 ├── Ambil Preferensi
 ├── Text Preprocessing
 ├── Load TF-IDF
 ├── Transform Preference
 ├── Cosine Similarity
 ├── Ranking
 │
 ▼
Recommendation Result
 │
 ▼
Laravel
 │
 ▼
User
```

---

## 🔌 Recommendation API

### POST `/recommend`

Digunakan untuk menghasilkan rekomendasi paket wisata.

Contoh request:

```json
{
    "preference_id": 1
}
```

### GET `/health`

Digunakan untuk mengecek status recommendation engine.

```bash
curl http://localhost:5000/health
```

---

## 🧪 Pengujian

### Recommendation Engine

```bash
python demo_preprocess.py
python demo_cosine.py
python demo_matrix.py
python demo_tfidf_breakdown.py
python demo_evaluasi.py
```

### Laravel

```bash
php artisan test
```

atau:

```bash
composer test
```

---

## 🏗️ Build Frontend

Development:

```bash
npm run dev
```

Production:

```bash
npm run build
```

---

## 🔒 Environment & Security

File `.env` **tidak boleh dipublikasikan ke repository** karena dapat mengandung informasi sensitif seperti database password, API key, dan credential layanan eksternal.

Contoh `.gitignore`:

```gitignore
.env
venv/
__pycache__/
*.pyc
```

Gunakan `.env.example` untuk mendokumentasikan environment variable tanpa menyimpan credential asli.

---

## 🔧 Troubleshooting

### Composer tidak ditemukan

```bash
composer --version
```

### Python tidak ditemukan

```bash
python --version
```

atau:

```bash
python3 --version
```

### Laravel tidak terhubung ke database

Periksa konfigurasi `.env`, kemudian:

```bash
php artisan optimize:clear
```

### Recommendation Engine tidak berjalan

```bash
python app.py
```

Kemudian periksa endpoint:

```text
http://localhost:5000/health
```

### Storage Laravel tidak dapat diakses

```bash
php artisan storage:link
```

---

## 📊 Alur Algoritma

```text
             DATA PAKET WISATA
                     │
                     ▼
            TEXT PREPROCESSING
                     │
        ┌────────────┼────────────┐
        │            │            │
     Cleaning    Stopword      Stemming
                     │
                     ▼
              COMBINED FEATURES
                     │
                     ▼
                  TF-IDF
                     │
                     ▼
              PACKAGE VECTORS
                     │
                     │
USER PREFERENCE ─────┤
       │             │
       ▼             │
 PREPROCESSING       │
       │             │
       ▼             │
TF-IDF TRANSFORM     │
       │             │
       ▼             ▼
 PREFERENCE ───► COSINE SIMILARITY
   VECTOR              │
                       ▼
               SIMILARITY SCORE
                       │
                       ▼
                    RANKING
                       │
                       ▼
                TOP-N PACKAGES
                       │
                       ▼
                 RECOMMENDATION
```

---

## 📝 Development Commands

### Laravel

```bash
php artisan serve
php artisan migrate
php artisan migrate:fresh
php artisan db:seed
php artisan storage:link
php artisan optimize:clear
php artisan test
```

### Composer

```bash
composer install
composer update
composer test
```

### Frontend

```bash
npm install
npm run dev
npm run build
```

### Recommendation Engine

```bash
pip install -r requirements.txt
python app.py
python train_model.py
```

---

## 📚 Repository

Repository project:

https://github.com/TRPL-JBI/tugas-akhir-2026-yogifirdani

---

## 👨‍💻 Pengembang

**Achmad Yogi Firdani**  
**NIM 362258302019**

Program Studi Teknologi Rekayasa Perangkat Lunak  
Politeknik Negeri Banyuwangi  
2026

---

## 🎓 Tugas Akhir

Project ini dikembangkan sebagai bagian dari **Tugas Akhir Program Studi Teknologi Rekayasa Perangkat Lunak, Politeknik Negeri Banyuwangi**.

Sistem mengintegrasikan pengembangan aplikasi web dengan penerapan **Content-Based Filtering**, **Natural Language Processing**, **TF-IDF**, dan **Cosine Similarity** untuk menghasilkan rekomendasi paket wisata berdasarkan preferensi pengguna.

---

## 📄 Catatan

Repository ini digunakan untuk keperluan akademik dan dokumentasi pengembangan Tugas Akhir.

Konfigurasi aplikasi dapat berbeda tergantung environment yang digunakan. Pastikan seluruh dependency, database, environment variable, Laravel Application, dan Flask Recommendation Engine telah dikonfigurasi sebelum menjalankan sistem.
