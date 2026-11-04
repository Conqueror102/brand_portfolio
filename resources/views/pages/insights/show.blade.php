<x-layouts.page :title="$article->title" :description="$article->seo_description ?: $article->excerpt" og-type="article">
    @if ($article->status !== 'published')<div class="preview-bar" role="status"><x-line-icon name="eye" /> <span>Preview of an unpublished article. Visitors cannot see this page yet.</span><a href="{{ route('admin.articles.edit', $article) }}">Back to editing</a></div>@endif
    <article>
        <header class="wrap article-head">
            <a class="link-arrow back-link" href="{{ route('insights.index') }}"><x-line-icon name="arrow" /> All insights</a>
            <p class="insight-meta"><span class="insight-tag">{{ config('site.article_categories.'.$article->category) }}</span><span>{{ $article->readMinutes() }} min read</span>@if ($article->is_sample)<span class="insight-draft">Sample</span>@endif</p>
            <h1 class="display h-xl">{{ $article->title }}</h1>
            @if ($article->excerpt)<p class="lede">{{ $article->excerpt }}</p>@endif
            <div class="byline">
                <span class="avatar"><img src="{{ content_image('profile.portrait') }}" alt=""></span>
                <div><strong>{{ content('profile.given_name') }} {{ content('profile.surname') }}</strong><span>{{ $article->published_at?->format('j F Y') }}</span></div>
            </div>
        </header>
        @if ($article->coverUrl())
            <figure class="wrap article-cover"><img class="frame" src="{{ $article->coverUrl() }}" alt=""></figure>
        @endif
        <div class="wrap article-layout">
            <div class="prose article-body">{!! $article->bodyHtml() !!}
                @if ($article->references)<div class="references"><h2>References</h2>{{ block_text($article->references) }}</div>@endif
            </div>
            <aside class="article-aside">
                <div class="card card-cream">
                    <p class="stat-label">Share</p>
                    <div class="share">
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"><x-line-icon name="linkedin" /></a>
                        <a href="mailto:?subject={{ rawurlencode($article->title) }}&body={{ rawurlencode(url()->current()) }}" aria-label="Share by email"><x-line-icon name="mail" /></a>
                    </div>
                </div>
                <div class="card card-navy card-glow">
                    <p class="eyebrow">Bring this to your team</p>
                    <p style="margin-top: 12px">Invite Modupe to explore these ideas with your leaders.</p>
                    <a class="btn btn-light" style="margin-top: 20px" href="{{ route('contact', ['type' => 'speaking']) }}">Invite me to speak <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                </div>
            </aside>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="wrap section-tight">
            <header class="section-head">
                <div>
                    <p class="eyebrow">Keep reading</p>
                    <h2 class="display h-lg">Related <em>insights.</em></h2>
                </div>
            </header>
            <div class="article-grid">
                @foreach ($related as $item)
                    <a class="article-card" href="{{ route('insights.show', $item) }}" data-reveal>
                        <span class="article-card-art" @if ($item->coverUrl()) style="background-image: url('{{ $item->coverUrl() }}')" @endif></span>
                        <span class="article-card-body">
                            <span class="insight-meta"><span class="insight-tag">{{ config('site.article_categories.'.$item->category) }}</span><span>{{ $item->readMinutes() }} min read</span></span>
                            <span class="article-card-title">{{ $item->title }}</span>
                            <span class="article-card-foot">{{ $item->published_at?->format('j F Y') }} <span class="insight-arrow"><x-line-icon name="arrow" /></span></span>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.page>
