<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        $query = Article::with('author')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 5);
        if (!in_array($perPage, [5, 25, 50, 100])) {
            $perPage = 5;
        }
        $articles = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('admin.kelola_artikel._table', compact('articles'))->render();
        }

        return view('admin.kelola_artikel.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('admin.kelola_artikel.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'title_en'   => 'nullable|string|max:255',
            'content'    => 'required|string',
            'content_en' => 'nullable|string',
            'image'      => 'nullable|image|mimes:webp|max:150', // Strict WebP and 150KB
            'status'     => 'required|in:active,draft',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['author_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $disk = env('FILESYSTEM_DISK', 'public');
            
            // Fallback to public if S3 is not configured
            if ($disk === 's3' && !env('AWS_ACCESS_KEY_ID')) {
                $disk = 'public';
            }

            try {
                $imagePath = $request->file('image')->store('articles', $disk);
                $validated['image'] = $imagePath;
            } catch (\Exception $e) {
                \Log::error('Upload Error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        Article::create($validated);

        return redirect()->route('admin.kelola-artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $kelolaArtikel)
    {
        return view('admin.kelola_artikel.edit', compact('kelolaArtikel'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $kelolaArtikel)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'title_en'   => 'nullable|string|max:255',
            'content'    => 'required|string',
            'content_en' => 'nullable|string',
            'image'      => 'nullable|image|mimes:webp|max:150',
            'status'     => 'required|in:active,draft',
        ]);

        // Update slug if title changed
        if ($validated['title'] !== $kelolaArtikel->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        }

        if ($request->hasFile('image')) {
            $disk = env('FILESYSTEM_DISK', 'public');
            if ($disk === 's3' && !env('AWS_ACCESS_KEY_ID')) {
                $disk = 'public';
            }

            try {
                // Delete old image
                if ($kelolaArtikel->image) {
                    Storage::disk($disk)->delete($kelolaArtikel->image);
                }
                $imagePath = $request->file('image')->store('articles', $disk);
                $validated['image'] = $imagePath;
            } catch (\Exception $e) {
                \Log::error('Update Upload Error: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal memperbarui gambar: ' . $e->getMessage());
            }
        } else {
            // Remove image from validated data so it doesn't overwrite existing path with null
            unset($validated['image']);
        }

        $kelolaArtikel->update($validated);

        return redirect()->route('admin.kelola-artikel.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $kelolaArtikel)
    {
        if ($kelolaArtikel->image) {
            $disk = env('FILESYSTEM_DISK', 'public');
            Storage::disk($disk)->delete($kelolaArtikel->image);
        }
        $kelolaArtikel->delete();
        return redirect()->route('admin.kelola-artikel.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
