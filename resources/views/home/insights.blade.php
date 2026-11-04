@if ($featured)
<section class="insights" id="insights" aria-labelledby="insights-title">
    <header class="insights-head">
        <div>
            <p class="insights-eyebrow">{{ content('home.insights_eyebrow') }}</p>
            <h2 id="insights-title">{{ content_html('home.insights_title') }}</h2>
        </div>
        <a class="insights-all" href="{{ route('insights.index') }}">View all insights <x-icon name="arrow-right" /></a>
    </header>
    <div class="insights-grid">
        <article class="insight-feature">
            <div class="insight-feature-art" aria-hidden="true" @if ($featured->coverUrl()) style="--cover: url('{{ $featured->coverUrl() }}')" @endif><span>“</span></div>
            <div class="insight-feature-body">
                <p class="insight-meta"><span class="insight-tag">{{ config('site.article_categories.'.$featured->category) }}</span><span>{{ $featured->readMinutes() }} min read</span>@if ($featured->is_sample)<span class="insight-draft">Sample</span>@endif</p>
                <h3>{{ $featured->title }}</h3>
                <p>{{ $featured->excerpt }}</p>
                <a class="insight-read" href="{{ $featured->external_url ?: route('insights.show', $featured) }}">Read the article <span><x-icon name="arrow-right-white" /></span></a>
            </div>
        </article>
        <ol class="insight-list">
            @foreach ($insights as $article)
                <li>
                    <a href="{{ $article->external_url ?: route('insights.show', $article) }}">
                        <span class="insight-meta"><span class="insight-tag">{{ config('site.article_categories.'.$article->category) }}</span><span>{{ $article->readMinutes() }} min read</span>@if ($article->is_sample)<span class="insight-draft">Sample</span>@endif</span>
                        <span class="insight-title">{{ $article->title }}</span>
                        <span class="insight-arrow" aria-hidden="true"><x-icon name="arrow-right" /></span>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endif
