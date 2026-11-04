@php($cases = items('case_studies'))
@if ($cases->isNotEmpty())
@php($quoteOf = function ($case) {
    if (preg_match('/^>\s*(.+)$/m', (string) $case->body, $m)) return trim($m[1]);
    foreach (preg_split('/\R{2,}/', (string) $case->body) as $para) {
        $para = trim($para);
        if ($para !== '' && ! str_starts_with($para, '#')) return \Illuminate\Support\Str::limit($para, 150);
    }
    return '';
})
<section class="stack" id="work" aria-labelledby="work-title" data-stack style="--count: {{ $cases->count() }}">
    <div class="stack-sticky">
        <span class="stack-glow" aria-hidden="true"></span>
        <header class="stack-head wrap">
            <p class="eyebrow">{{ content('home.work_eyebrow') }}</p>
            <h2 id="work-title" class="display h-xl">{{ content_html('home.work_title') }}</h2>
            <p class="stack-lede">{{ content('home.work_text') }}</p>
        </header>
        <div class="stack-stage" data-stack-stage role="region" aria-roledescription="carousel" aria-label="{{ strip_tags(content('home.work_title')) }}">
            @foreach ($cases as $i => $case)
                <article class="stack-card" data-stack-card aria-roledescription="slide" aria-label="{{ $i + 1 }} of {{ $cases->count() }}">
                    <a class="stack-link" href="{{ route('work.show', $case->slug) }}" data-stack-link>
                        <div class="stack-copy">
                            @if ($case->category)<p class="stack-metric">{{ $case->category }}</p>@endif
                            <h3>{{ $case->title }}</h3>
                            @if ($q = $quoteOf($case))<blockquote>“{{ $q }}”</blockquote>@endif
                            <p class="stack-meta">@foreach (explode('·', (string) $case->subtitle) as $part)<span>{{ trim($part) }}</span>@endforeach</p>
                        </div>
                        <figure class="stack-img">
                            @if ($case->imageUrl())<img src="{{ $case->imageUrl() }}" alt="" loading="lazy">@endif
                            <span class="stack-num" aria-hidden="true">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="stack-go" aria-hidden="true"><x-line-icon name="arrow-up-right" /></span>
                        </figure>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="stack-controls wrap">
            <button type="button" class="stack-btn" data-stack-prev aria-label="Previous case study"><x-line-icon name="arrow" /></button>
            <div class="stack-dots" role="tablist">
                @foreach ($cases as $i => $case)
                    <button type="button" class="stack-dot" data-stack-dot="{{ $i }}" role="tab" aria-label="Show {{ $case->title }}"><span></span></button>
                @endforeach
            </div>
            <button type="button" class="stack-btn" data-stack-next aria-label="Next case study"><x-line-icon name="arrow" /></button>
            <a class="link-arrow stack-all" href="{{ route('work.index') }}">All case studies <x-line-icon name="arrow" /></a>
        </div>
    </div>
</section>
@endif
