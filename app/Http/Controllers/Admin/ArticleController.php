<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::query()
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.form', ['article' => new Article(['status' => 'draft', 'category' => 'institution-building'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $article = Article::create($this->validated($request));

        return to_route('admin.articles.edit', $article)->with('status', 'Article created.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $article->update($this->validated($request, $article));

        return to_route('admin.articles.edit', $article)->with('status', 'Article saved.');
    }

    /** Shows the article exactly as visitors will see it, even while it is a draft. */
    public function preview(Article $article): View
    {
        return view('pages.insights.show', [
            'article' => $article,
            'related' => Article::published()->whereKeyNot($article->id)->latest('published_at')->take(3)->get(),
        ]);
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->cover_image && ! str_starts_with($article->cover_image, 'images/')) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return to_route('admin.articles.index')->with('status', 'Article deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', 'alpha_dash'],
            'category' => ['required', Rule::in(array_keys(config('site.article_categories')))],
            'excerpt' => ['required', 'string', 'max:400'],
            'body' => ['required', 'string'],
            'references' => ['nullable', 'string', 'max:5000'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date'],
            'seo_description' => ['nullable', 'string', 'max:300'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_cover' => ['nullable', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_sample'] = false;

        if ($request->hasFile('cover')) {
            $this->deleteCover($article);
            $data['cover_image'] = $request->file('cover')->store('articles', 'public');
        } elseif ($request->boolean('remove_cover')) {
            $this->deleteCover($article);
            $data['cover_image'] = null;
        }

        if ($data['is_featured']) {
            Article::where('is_featured', true)->when($article, fn ($q) => $q->whereKeyNot($article->id))->update(['is_featured' => false]);
        }

        unset($data['cover'], $data['remove_cover']);

        return $data;
    }

    private function deleteCover(?Article $article): void
    {
        if ($article?->cover_image && ! str_starts_with($article->cover_image, 'images/')) {
            Storage::disk('public')->delete($article->cover_image);
        }
    }
}
