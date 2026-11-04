<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function index(Request $request): View
    {
        $categories = config('site.article_categories');
        $category = array_key_exists((string) $request->query('category'), $categories) ? $request->query('category') : null;
        $search = trim((string) $request->query('q'));

        $articles = Article::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                ->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.insights.index', compact('articles', 'categories', 'category', 'search'));
    }

    public function show(Article $article): View
    {
        abort_unless($article->status === 'published' && $article->published_at?->isPast(), 404);

        $related = Article::published()
            ->whereKeyNot($article->id)
            ->orderByRaw('category = ? desc', [$article->category])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.insights.show', compact('article', 'related'));
    }
}
