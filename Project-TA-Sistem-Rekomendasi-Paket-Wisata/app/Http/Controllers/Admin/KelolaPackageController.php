<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Category;
use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KelolaPackageController extends Controller
{
    /**
     * Menampilkan daftar paket wisata dengan fitur pencarian dan pagination AJAX.
     */
    public function index(Request $request)
    {
        // Query dasar dengan eager loading untuk optimasi performa
        $query = TourPackage::with(['category', 'packageType'])->latest();

        // Logika pencarian berdasarkan nama, kota, atau kategori
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('package_name', 'like', "%{$search}%")
                  ->orWhere('package_name_en', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('category_name', 'like', "%{$search}%")
                        ->orWhere('category_name_en', 'like', "%{$search}%");
                  });
            });
        }

        // Ambil data dengan pagination dinamis (default 5 item per halaman)
        $perPage = (int) $request->get('per_page', 5);
        if (!in_array($perPage, [5, 25, 50, 100])) {
            $perPage = 5;
        }
        $packages = $query->paginate($perPage)->withQueryString();

        // Jika request via AJAX (pencarian/pagination), return partial view tabel saja
        if ($request->ajax()) {
            return view('admin.kelola_paket._table', compact('packages'))->render();
        }

        return view('admin.kelola_paket.index', compact('packages'));
    }

    /**
     * Menampilkan form untuk membuat paket wisata baru.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $packageTypes = PackageType::all();
        return view('admin.kelola_paket.create', compact('categories', 'packageTypes'));
    }

    /**
     * Menyimpan data paket wisata baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name'        => 'required|string|max:255',
            'package_name_en'     => 'nullable|string|max:255',
            'package_type_id'     => 'required|exists:package_types,id',
            'category_id'         => 'required|exists:categories,id',
            'tour_category'       => 'nullable|string|max:255',
            'duration'            => 'required|string|max:100',
            'duration_en'         => 'nullable|string|max:100',
            'city'                => 'required|string|max:255',
            'destination'         => 'nullable|string',
            'description'         => 'nullable|string',
            'description_en'      => 'nullable|string',
            'price_1pax'          => 'nullable|integer',
            'price_1pax_foreign'  => 'nullable|integer',
            'price_2pax'          => 'nullable|integer',
            'price_2pax_foreign'  => 'nullable|integer',
            'price_3pax'          => 'nullable|integer',
            'price_3pax_foreign'  => 'nullable|integer',
            'price_4pax'          => 'nullable|integer',
            'price_4pax_foreign'  => 'nullable|integer',
            'price_5pax'          => 'nullable|integer',
            'price_5pax_foreign'  => 'nullable|integer',
            'price_8pax'          => 'nullable|integer',
            'price_8pax_foreign'  => 'nullable|integer',
            'price_10pax'         => 'nullable|integer',
            'price_10pax_foreign' => 'nullable|integer',
            'meeting_point'       => 'nullable|string',
            'meeting_point_en'    => 'nullable|string',
            'daily_schedule'      => 'nullable|string',
            'daily_schedule_en'   => 'nullable|string',
            'itinerary'           => 'nullable|string',
            'itinerary_en'        => 'nullable|string',
            'persyaratan'         => 'nullable|string',
            'persyaratan_en'      => 'nullable|string',
            'facilities_included' => 'nullable|string',
            'facilities_included_en' => 'nullable|string',
            'facilities_excluded' => 'nullable|string',
            'facilities_excluded_en' => 'nullable|string',
            'information'         => 'nullable|string',
            'information_en'      => 'nullable|string',
            'dp_days_before'      => 'nullable|integer',
            'payment'             => 'nullable|string',
            'payment_en'          => 'nullable|string',
            'image'               => 'nullable|image|mimes:webp|max:150',
            'is_active'           => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['package_name']) . '-' . time();
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $disk = env('FILESYSTEM_DISK', 'public');
            
            if ($disk === 's3' && !env('AWS_ACCESS_KEY_ID')) {
                $disk = 'public';
            }

            try {
                $imagePath = $request->file('image')->store('tour_packages', $disk);
                $validated['image'] = $imagePath;
            } catch (\Exception $e) {
                \Log::error('Upload Error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        $package = TourPackage::create($validated);

        if (!empty($package->destination)) {
            $this->saveDestinationsToTable($package->destination, $package->city);
        }

        app()->terminating(function () {
            try {
                \Illuminate\Support\Facades\Http::timeout(3)->post('http://localhost:5000/vectorize');
            } catch (\Throwable $e) {
                \Log::warning('Vectorize request failed: ' . $e->getMessage());
            }
        });

        $url = route('admin.kelola-paket-wisata.index');
        session()->flash('success', 'Paket wisata berhasil ditambahkan!');
        return response("<script>window.location.href='{$url}';</script>");
    }

    /**
     * Menampilkan detail lengkap sebuah paket wisata.
     */
    public function show(TourPackage $kelolaPackage)
    {
        $kelolaPackage->load(['category', 'packageType']);
        return view('admin.kelola_paket.show', compact('kelolaPackage'));
    }

    /**
     * Menampilkan form edit untuk paket wisata.
     */
    public function edit(TourPackage $kelolaPackage)
    {
        $categories = Category::where('is_active', true)->get();
        $packageTypes = PackageType::all();
        return view('admin.kelola_paket.edit', compact('kelolaPackage', 'categories', 'packageTypes'));
    }

    /**
     * Memperbarui data paket wisata di database.
     */
    public function update(Request $request, TourPackage $kelolaPackage)
    {
        $validated = $request->validate([
            'package_name'        => 'required|string|max:255',
            'package_name_en'     => 'nullable|string|max:255',
            'package_type_id'     => 'required|exists:package_types,id',
            'category_id'         => 'required|exists:categories,id',
            'tour_category'       => 'nullable|string|max:255',
            'duration'            => 'required|string|max:100',
            'duration_en'         => 'nullable|string|max:100',
            'city'                => 'required|string|max:255',
            'destination'         => 'nullable|string',
            'description'         => 'nullable|string',
            'description_en'      => 'nullable|string',
            'price_1pax'          => 'nullable|integer',
            'price_1pax_foreign'  => 'nullable|integer',
            'price_2pax'          => 'nullable|integer',
            'price_2pax_foreign'  => 'nullable|integer',
            'price_3pax'          => 'nullable|integer',
            'price_3pax_foreign'  => 'nullable|integer',
            'price_4pax'          => 'nullable|integer',
            'price_4pax_foreign'  => 'nullable|integer',
            'price_5pax'          => 'nullable|integer',
            'price_5pax_foreign'  => 'nullable|integer',
            'price_8pax'          => 'nullable|integer',
            'price_8pax_foreign'  => 'nullable|integer',
            'price_10pax'         => 'nullable|integer',
            'price_10pax_foreign' => 'nullable|integer',
            'meeting_point'       => 'nullable|string',
            'meeting_point_en'    => 'nullable|string',
            'daily_schedule'      => 'nullable|string',
            'daily_schedule_en'   => 'nullable|string',
            'itinerary'           => 'nullable|string',
            'itinerary_en'        => 'nullable|string',
            'persyaratan'         => 'nullable|string',
            'persyaratan_en'      => 'nullable|string',
            'facilities_included' => 'nullable|string',
            'facilities_included_en' => 'nullable|string',
            'facilities_excluded' => 'nullable|string',
            'facilities_excluded_en' => 'nullable|string',
            'information'         => 'nullable|string',
            'information_en'      => 'nullable|string',
            'dp_days_before'      => 'nullable|integer',
            'payment'             => 'nullable|string',
            'payment_en'          => 'nullable|string',
            'image'               => 'nullable|image|mimes:webp|max:150',
            'is_active'           => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $disk = env('FILESYSTEM_DISK', 'public');
            if ($disk === 's3' && !env('AWS_ACCESS_KEY_ID')) {
                $disk = 'public';
            }

            try {
                // Delete old image
                if ($kelolaPackage->image) {
                    Storage::disk($disk)->delete($kelolaPackage->image);
                }
                $imagePath = $request->file('image')->store('tour_packages', $disk);
                $validated['image'] = $imagePath;
            } catch (\Exception $e) {
                \Log::error('Update Upload Error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal memperbarui gambar: ' . $e->getMessage());
            }
        } else {
            // Remove image from validated data so it doesn't overwrite existing path with null
            unset($validated['image']);
        }

        $kelolaPackage->update($validated);

        if (!empty($kelolaPackage->destination)) {
            $this->saveDestinationsToTable($kelolaPackage->destination, $kelolaPackage->city);
        }

        app()->terminating(function () {
            try {
                \Illuminate\Support\Facades\Http::timeout(3)->post('http://localhost:5000/vectorize');
            } catch (\Throwable $e) {
                \Log::warning('Vectorize request failed: ' . $e->getMessage());
            }
        });

        $url = route('admin.kelola-paket-wisata.index');
        session()->flash('success', 'Paket wisata berhasil diperbarui!');
        return response("<script>window.location.href='{$url}';</script>");
    }

    /**
     * Menghapus paket wisata dari database.
     */
    public function destroy(TourPackage $kelolaPackage)
    {
        if ($kelolaPackage->image) {
            $disk = env('FILESYSTEM_DISK', 'public');
            Storage::disk($disk)->delete($kelolaPackage->image);
        }
        $kelolaPackage->delete();

        app()->terminating(function () {
            try {
                \Illuminate\Support\Facades\Http::timeout(3)->post('http://localhost:5000/vectorize');
            } catch (\Throwable $e) {
                \Log::warning('Vectorize request failed: ' . $e->getMessage());
            }
        });

        $url = route('admin.kelola-paket-wisata.index');
        session()->flash('success', 'Paket wisata berhasil dihapus!');
        return response("<script>window.location.href='{$url}';</script>");
    }

    /**
     * Parse the destination string from CKEditor/text and save unique destinations to destinations table.
     */
    private function saveDestinationsToTable($destinationStr, $city)
    {
        if (empty($destinationStr)) {
            return;
        }

        // Convert HTML linebreaks/list tags into newlines instead of commas
        $cleanStr = str_replace(
            ['<li>', '</li>', '<p>', '</p>', '<br>', '<br/>', '<br />', '<div>', '</div>'],
            ["\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n"],
            $destinationStr
        );

        // Strip remaining HTML tags and decode entities
        $cleanStr = strip_tags($cleanStr);
        $cleanStr = html_entity_decode($cleanStr);

        // JANGAN memisahkan berdasarkan koma jika koma digunakan untuk dua versi bahasa (Kawah Ijen, Ijen Crater)
        // Split hanya berdasarkan baris baru atau titik koma jika memang ingin lebih dari satu.
        $names = preg_split('/[;\n\r\t]+/', $cleanStr);

        foreach ($names as $name) {
            $name = trim($name);
            if (empty($name)) {
                continue;
            }

            // Gunakan pencocokan persis (exact match) agar tidak tumpang tindih
            $existing = \App\Models\Destination::whereRaw('LOWER(destination_name) = ?', [strtolower($name)])->first();

            if (!$existing) {
                // Save as a new destination
                \App\Models\Destination::create([
                    'destination_name' => $name,
                    'city' => $city,
                    'is_active' => true,
                ]);
            }
        }
    }
}
