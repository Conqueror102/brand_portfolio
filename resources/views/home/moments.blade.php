@php($moments = items('moments')->filter(fn ($m) => $m->image)->values())
@if ($moments->isNotEmpty())
@php($tilts = [-7, 4, -3, 6, -5, 3, -6, 5, -2, 7])
@php($drops = [18, -10, 26, 0, 14, -16, 22, 4, -8, 12])
<section class="moments" id="moments" aria-labelledby="moments-title" data-prints>
    <header class="moments-head">
        <p class="moments-eyebrow">{{ content('home.moments_eyebrow') }}</p>
        <h2 id="moments-title">{{ content_html('home.moments_title') }}</h2>
        <p class="prints-hint">Hover a print to turn it over · open it to see it full size</p>
    </header>

    {{-- A loose pile of prints. Each lifts and turns over on hover; the corner button opens the viewer. --}}
    <ul class="prints" style="--count: {{ $moments->count() }}">
        @foreach ($moments as $moment)
            @php($meta = collect([$moment->subtitle, $moment->date?->format('F Y')])->filter()->join(' · '))
            <li class="print {{ $loop->index % 3 === 1 ? 'is-tall' : '' }}" style="--tilt: {{ $tilts[$loop->index % 10] }}deg; --drop: {{ $drops[$loop->index % 10] }}px; --i: {{ $loop->index }}"
                data-print data-src="{{ $moment->imageUrl() }}" data-title="{{ $moment->title }}" data-meta="{{ $meta }}" data-body="{{ $moment->body }}" data-url="{{ $moment->url }}">
                <div class="print-card" tabindex="0" aria-label="{{ $moment->title }}">
                    <figure class="print-face is-front">
                        <img src="{{ $moment->imageUrl() }}" alt="{{ $moment->imageAlt() ?: $moment->title }}" loading="lazy">
                        <figcaption>{{ $moment->title }}</figcaption>
                    </figure>
                    <div class="print-face is-back">
                        <p class="print-meta">{{ $meta ?: content('home.moments_eyebrow') }}</p>
                        <h3>{{ $moment->title }}</h3>
                        @if ($moment->body)<p class="print-body">{{ $moment->body }}</p>@endif
                        <span class="print-stamp" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                <button type="button" class="print-open" data-print-open aria-label="Open {{ $moment->title }} full size"><x-line-icon name="expand" /></button>
            </li>
        @endforeach
    </ul>

    {{-- Full-size viewer --}}
    <div class="viewer" data-viewer hidden role="dialog" aria-modal="true" aria-label="Photo viewer">
        <div class="viewer-backdrop" data-viewer-close></div>
        <div class="viewer-frame">
            <figure class="viewer-img"><img alt="" data-viewer-img></figure>
            <div class="viewer-copy">
                <p class="viewer-count"><b data-viewer-index>01</b> / {{ str_pad($moments->count(), 2, '0', STR_PAD_LEFT) }}</p>
                <p class="viewer-meta" data-viewer-meta></p>
                <h3 class="viewer-title" data-viewer-title></h3>
                <p class="viewer-body" data-viewer-body></p>
                <a class="link-arrow viewer-link" data-viewer-link hidden target="_blank" rel="noopener noreferrer">Read more <x-line-icon name="arrow" /></a>
                <div class="viewer-nav">
                    <button type="button" class="viewer-btn" data-viewer-prev aria-label="Previous photo"><x-line-icon name="arrow" /></button>
                    <button type="button" class="viewer-btn" data-viewer-next aria-label="Next photo"><x-line-icon name="arrow" /></button>
                </div>
            </div>
            <button type="button" class="viewer-close" data-viewer-close aria-label="Close viewer"><x-line-icon name="close" /></button>
        </div>
    </div>
</section>
@endif
