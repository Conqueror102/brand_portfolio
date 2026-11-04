<x-admin-layout title="Blog & Insights">
    <x-slot:actions><a class="btn" href="{{ route('admin.articles.create') }}">New article <span class="btn-icon"><x-line-icon name="plus" /></span></a></x-slot:actions>
    <nav class="admin-tabs">
        @foreach (['' => 'All', 'published' => 'Published', 'draft' => 'Drafts', 'archived' => 'Archived'] as $value => $label)
            <a class="{{ request('status', '') === $value ? 'is-active' : '' }}" href="{{ route('admin.articles.index', array_filter(['status' => $value])) }}">{{ $label }}</a>
        @endforeach
    </nav>
    <section class="admin-panel admin-table-panel">
        @if ($articles->isEmpty())
            <p class="admin-empty">No articles here yet. <a href="{{ route('admin.articles.create') }}">Write the first one</a>.</p>
        @else
            <table class="admin-table">
                <thead><tr><th>Article</th><th>Category</th><th>Status</th><th>Published</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>
                            <a class="admin-cell-title" href="{{ route('admin.articles.edit', $article) }}">
                                <span class="admin-thumb" @if ($article->coverUrl()) style="background-image: url('{{ $article->coverUrl() }}')" @endif></span>
                                <span><strong>{{ $article->title }}</strong>
                                    <small>@if ($article->is_featured)<span class="admin-tag">Featured</span>@endif @if ($article->is_sample)<span class="sample-badge">Sample</span>@endif {{ $article->readMinutes() }} min read</small></span>
                            </a>
                        </td>
                        <td>{{ config('site.article_categories.'.$article->category) }}</td>
                        <td><x-admin-status :status="$article->status" /></td>
                        <td>{{ $article->published_at?->format('j M Y') ?? '—' }}</td>
                        <td class="admin-cell-actions">
                            @if ($article->status === 'published')<a href="{{ route('insights.show', $article) }}" target="_blank" rel="noopener" aria-label="View"><x-line-icon name="eye" /></a>@endif
                            <a href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
    {{ $articles->links('partials.pager') }}
</x-admin-layout>
