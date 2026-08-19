<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TourPackage;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    /**
     * Menampilkan form input preferensi wisatawan.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        return view('recommendation', compact('categories'));
    }

    /**
     * Memproses preferensi wisatawan, mengirimkan ke Python API,
     * dan menampilkan rekomendasi hasil Cosine Similarity.
     */
    public function getRecommendations(Request $request)
    {
        $notGibberish = function ($attribute, $value, $fail) {
            if (!$value) return; 

            // 1. Cek minimal 1 huruf vokal
            if (!preg_match('/[aiueo]/i', $value)) {
                $fail(app()->getLocale() == 'en' 
                    ? 'The input seems invalid (contains no vowels).' 
                    : 'Input sepertinya tidak valid (mengandung karakter acak/ngawur tanpa huruf vokal).');
                return;
            }
            // 2. Cek karakter berulang tidak wajar (misal "aaaaaa")
            if (preg_match('/(.)\1{4,}/', $value)) {
                $fail(app()->getLocale() == 'en' 
                    ? 'The input contains unnatural repeating characters.' 
                    : 'Input mengandung karakter berulang yang tidak wajar.');
                return;
            }
            
            // 3. Pengecekan per kata untuk pola yang lebih detail
            $words = explode(' ', $value);
            foreach ($words as $word) {
                // Hapus tanda baca di ujung kata untuk pengecekan yang lebih akurat
                $cleanWord = trim($word, ".,!?\"'()[]{}");

                $hasLetter = preg_match('/[a-zA-Z]/', $cleanWord);
                $hasDigit = preg_match('/[0-9]/', $cleanWord);
                
                // Tolak kata campuran huruf dan angka jika panjangnya > 5 
                // (Ini mengizinkan 2D1N, H-1, dsb. tapi menolak adiawj3e23)
                if ($hasLetter && $hasDigit && strlen($cleanWord) > 5) {
                    $fail(app()->getLocale() == 'en' 
                        ? 'The input contains random alphanumeric combinations.' 
                        : 'Input sepertinya tidak valid (mengandung campuran huruf dan angka acak).');
                    return;
                }
                
                // Cek konsonan berderet lebih dari 4 dalam satu kata
                if (preg_match('/[^aiueo\s0-9]{5,}/i', $cleanWord)) {
                    $fail(app()->getLocale() == 'en' 
                        ? 'The input contains too many consecutive consonants.' 
                        : 'Input sepertinya tidak valid (terlalu banyak huruf mati/konsonan berurutan).');
                    return;
                }
                
                // Cek kata yang terlalu panjang
                if (strlen($cleanWord) > 20 && !filter_var($cleanWord, FILTER_VALIDATE_URL)) {
                    $fail(app()->getLocale() == 'en' 
                        ? 'The input contains abnormally long words.' 
                        : 'Input mengandung kata yang terlalu panjang dan tidak wajar.');
                    return;
                }
            }
        };

        $request->validate([
            'tour_category'        => 'required|string|in:Culture Trip,Nature Trip,Culinary Trip,Adventure Trip',
            'description'          => ['nullable', 'string', 'min:10', $notGibberish],
            'budget'               => 'required|numeric|min:0',
            'duration'             => ['required', 'string', 'max:100', $notGibberish],
            'facilities'           => ['required', 'string', 'min:5', $notGibberish],
        ]);

        try {
            // 1. Simpan/Update preferensi wisatawan berdasarkan session_id ke tabel 'user_preferences'
            $preference = UserPreference::updateOrCreate(
                ['session_id' => session()->getId()],
                [
                    'category_id'          => null,
                    'tour_category'        => $request->tour_category,
                    'description'          => $request->description,
                    'budget'               => $request->budget,
                    'preferred_duration'   => $request->duration,
                    'preferred_facilities' => $request->facilities,
                ]
            );

            // 2. Panggil API Python untuk memproses Cosine Similarity
            $response = Http::timeout(15)->post('https://recommendation-engine-production-3089.up.railway.app/recommend', [
                'preference_id' => $preference->id
            ]);

            $packages = collect();
            if ($response->successful()) {
                $data = $response->json();
                // Mendukung list of objects (e.g. [{'id': 1}, ...]) atau list of IDs (e.g. [1, 2, ...])
                $rekomendasiPaket = $data['data'] ?? [];

                $packageIds = [];
                if (is_array($rekomendasiPaket)) {
                    foreach ($rekomendasiPaket as $item) {
                        if (is_numeric($item)) {
                            $packageIds[] = (int) $item;
                        } elseif (is_array($item) && isset($item['package_id'])) {
                            $packageIds[] = (int) $item['package_id'];
                        }
                    }
                }

                if (!empty($packageIds)) {
                    $idsString = implode(',', $packageIds);
                    $packages = TourPackage::with(['category', 'packageType'])
                        ->whereIn('id', $packageIds)
                        ->orderByRaw("FIELD(id, {$idsString})")
                        ->get();
                }
            } else {
                Log::warning('Python recommend API returned error: ' . $response->status() . ' - ' . $response->body());
                return back()->withInput()->with('error', app()->getLocale() == 'en' 
                    ? 'Failed to fetch recommendations from AI engine. Please make sure the AI server is running.' 
                    : 'Gagal mendapatkan rekomendasi dari AI engine. Pastikan server AI telah dijalankan.');
            }

            $categories = Category::where('is_active', true)->get();
            return view('recommendation', compact('categories', 'packages', 'preference'));

        } catch (\Exception $e) {
            Log::error('Recommendation system error: ' . $e->getMessage());
            return back()->withInput()->with('error', app()->getLocale() == 'en'
                ? 'An error occurred while connecting to the recommendation server: ' . $e->getMessage()
                : 'Terjadi kesalahan saat menghubungkan ke server rekomendasi: ' . $e->getMessage());
        }
    }
}
