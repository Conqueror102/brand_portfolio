@php($offers = items('offers'))
@if ($offers->isNotEmpty())
<section class="offers wrap" id="offers" aria-labelledby="offers-title">
    <header class="offers-head">
        <p class="eyebrow">{{ content('home.offers_eyebrow') }}</p>
        <h2 id="offers-title" class="display h-xl">{{ content_html('home.offers_title') }}</h2>
        <p class="lede">{{ content('home.offers_text') }}</p>
    </header>
    <div class="offers-grid">
        @foreach ($offers as $i => $offer)
            <article class="offer {{ $i === 0 ? 'offer-lead' : 'offer-'.($i % 4) }}" data-tilt data-reveal>
                @if ($i === 0)<span class="offer-art" aria-hidden="true" style="--art: url('{{ content_image('home.idea_image') }}')"></span>@endif
                <div class="offer-top">
                    <span class="icon-chip"><x-line-icon :name="$offer->icon ?: 'compass'" /></span>
                    @if ($offer->category)<span class="offer-format">{{ $offer->category }}</span>@endif
                </div>
                @if ($i > 0 && $offer->imageUrl())<figure class="offer-illus" aria-hidden="true"><img src="{{ $offer->imageUrl() }}" alt="" loading="lazy"></figure>@endif
                <h3>{{ $offer->title }}</h3>
                @if ($offer->subtitle)<p class="offer-for"><span>For</span> {{ $offer->subtitle }}</p>@endif
                @if ($offer->body)<p class="offer-body">{{ $offer->body }}</p>@endif
                @if ($offer->url)
                    <a class="offer-link" href="{{ str_starts_with($offer->url, '/') ? url($offer->url) : $offer->url }}">{{ $i === 0 ? 'Start a conversation' : 'Enquire' }} <x-line-icon name="arrow" /></a>
                @endif
            </article>
        @endforeach
    </div>
</section>
@endif
