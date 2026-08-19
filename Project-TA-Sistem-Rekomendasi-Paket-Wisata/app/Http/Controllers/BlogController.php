<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index()
    {
        $articles = Article::where('status', 'active')
            ->with('author')
            ->latest()
            ->paginate(12);

        return view('article', compact('articles'));
    }

    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'active')
            ->with('author')
            ->firstOrFail();

        // Get related articles
        $relatedArticles = Article::where('status', 'active')
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('article_show', compact('article', 'relatedArticles'));
    }
}
