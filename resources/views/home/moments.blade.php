@php($moments = items('moments')->filter(fn ($m) => $m->image)->values())
@if ($moments->isNotEmpty())
<section class="moments" id="moments" aria-labelledby="moments-title">
    <header class="moments-head">
        <p class="moments-eyebrow">{{ content('home.moments_eyebrow') }}</p>
        <h2 id="moments-title">{{ content_html('home.moments_title') }}</h2>
    </header>
    <div class="moments-viewport">
        {{-- The list is repeated once so the reel can loop without a gap; the copy is hidden from screen readers. --}}
        <div class="moments-track" style="--moment-count: {{ $moments->count() }}">
            @foreach ([false, true] as $copy)
                <ul class="moments-list" @if ($copy) aria-hidden="true" @endif>
                    @foreach ($moments as $moment)
                        <li class="moment {{ $loop->index % 3 === 1 ? 'moment-tall' : '' }}">
                            @if ($moment->url)<a href="{{ $moment->url }}" @if (str_starts_with($moment->url, 'http')) target="_blank" rel="noopener noreferrer" @endif @if ($copy) tabindex="-1" @endif>@endif
                            <figure>
                                <img src="{{ $moment->imageUrl() }}" alt="{{ $copy ? '' : ($moment->imageAlt() ?: $moment->title) }}" loading="lazy">
                                <figcaption><strong>{{ $moment->title }}</strong>@if ($moment->subtitle || $moment->date)<span>{{ collect([$moment->subtitle, $moment->date?->format('M Y')])->filter()->join(' · ') }}</span>@endif</figcaption>
                            </figure>
                            @if ($moment->url)</a>@endif
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</section>
@endif
