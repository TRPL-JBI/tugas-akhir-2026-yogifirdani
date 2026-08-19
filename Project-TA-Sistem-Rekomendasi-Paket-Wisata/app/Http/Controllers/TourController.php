<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Category;
use App\Models\PackageType;
use App\Models\Article;
use Illuminate\Http\Request;

class TourController extends Controller
{
    //home bagian top tour
    public function home()
    {
        $topPackages = TourPackage::where('is_active', true)
            ->with(['category', 'packageType'])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(4)
            ->get();

        $latestArticles = Article::where('status', 'active')
            ->with('author')
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('topPackages', 'latestArticles'));
    }

    public function index(Request $request)
    {
        $query = TourPackage::where('is_active', true)->with(['category', 'packageType']);

        $selectedType = null;
        $selectedCategory = null;

        if ($request->has('tipe')) {
            $slug = $request->query('tipe');
            $selectedType = PackageType::where('slug', $slug)->first();
            
            if ($selectedType) {
                $query->where('package_type_id', $selectedType->id);
            }
        }

        if ($request->has('kategori')) {
            $catSlug = $request->query('kategori');
            $selectedCategory = Category::where('slug', $catSlug)->first();
            
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $packages = $query->latest()->paginate(9);
        $packageTypes = PackageType::all();

        return view('paket.index', compact('packages', 'packageTypes', 'selectedType', 'selectedCategory'));
    }

    public function show($slug)
    {
        $package = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'packageType'])
            ->firstOrFail();

        // Rekomendasi paket lain (opsional, untuk bagian bawah detail)
        $relatedPackages = TourPackage::where('is_active', true)
            ->where('id', '!=', $package->id)
            ->where('package_type_id', $package->package_type_id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('paket.detail', compact('package', 'relatedPackages'));
    }
}
