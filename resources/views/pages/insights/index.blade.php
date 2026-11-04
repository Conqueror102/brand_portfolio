<x-layouts.page :title="content('navigation.insights_label')" description="Ideas on institution building, governance, succession, leadership and the future of professional services.">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">{{ content('navigation.insights_label') }}</p>
        <h1 class="display h-xl">{{ content_html('home.insights_title') }}</h1>
        <p class="lede">Perspectives on institution building, leadership and the discipline of turning aspiration into results.</p>
    </section>

    <section class="wrap section-tight insights-index">
        <div class="filter-bar">
            <nav class="tags" aria-label="Categories">
                <a class="tag {{ $category ? '' : 'is-active' }}" href="{{ route('insights.index', array_filter(['q' => $search])) }}">All</a>
                @foreach ($categories as $key => $label)
                    <a class="tag {{ $category === $key ? 'is-active' : '' }}" href="{{ route('insights.index', array_filter(['category' => $key, 'q' => $search])) }}">{{ $label }}</a>
                @endforeach
            </nav>
            <form class="search" method="GET" action="{{ route('insights.index') }}" role="search">
                @if ($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                <x-line-icon name="search" />
                <input type="search" name="q" value="{{ $search }}" placeholder="Search insights" aria-label="Search insights">
            </form>
        </div>

        @if ($articles->isEmpty())
            <div class="empty-state card card-mist-soft">
                <span class="success-icon success-icon-muted"><x-line-icon name="search" /></span>
                <h2 class="display h-md">No insights found.</h2>
                <p class="body-copy">{{ $search !== '' || $category ? 'Try another search or category.' : 'New articles will be published here soon.' }}</p>
                @if ($search !== '' || $category)<a class="link-arrow" href="{{ route('insights.index') }}">Clear filters <x-line-icon name="arrow" /></a>@endif
            </div>
        @else
            <div class="article-grid">
                @foreach ($articles as $article)
                    <a class="article-card {{ $loop->first && $articles->onFirstPage() && ! $category && $search === '' ? 'article-card-lead' : '' }}" href="{{ $article->external_url ?: route('insights.show', $article) }}" @if ($article->external_url) target="_blank" rel="noopener noreferrer" @endif data-reveal>
                        <span class="article-card-art" @if ($article->coverUrl()) style="background-image: url('{{ $article->coverUrl() }}')" @endif></span>
                        <span class="article-card-body">
                            <span class="insight-meta"><span class="insight-tag">{{ $categories[$article->category] ?? $article->category }}</span><span>{{ $article->readMinutes() }} min read</span>@if ($article->is_sample)<span class="insight-draft">Sample</span>@endif</span>
                            <span class="article-card-title">{{ $article->title }}</span>
                            <span class="article-card-excerpt">{{ $article->excerpt }}</span>
                            <span class="article-card-foot">{{ $article->published_at?->format('j F Y') }} <span class="insight-arrow"><x-line-icon :name="$article->external_url ? 'arrow-up-right' : 'arrow'" /></span></span>
                        </span>
                    </a>
                @endforeach
            </div>
            <div class="pager">{{ $articles->links('partials.pager') }}</div>
        @endif
    </section>
</x-layouts.page>
