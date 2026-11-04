@php($offers = items('offers'))
@if ($offers->isNotEmpty())
<section class="offers wrap" id="offers" aria-labelledby="offers-title">
    <header class="offers-head">
        <p class="eyebrow">{{ content('home.offers_eyebrow') }}</p>
        <h2 id="offers-title" class="display h-xl">{{ content_html('home.offers_title') }}</h2>
        <p class="lede">{{ content('home.offers_text') }}</p>
    </header>

    {{-- One rail of panels, full width. The open panel widens to tell its story; the rest stand as spines. --}}
    <div class="eng-rail" data-eng data-reveal>
        @foreach ($offers as $i => $offer)
            @php($num = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT))
            @php($href = $offer->url ? (str_starts_with($offer->url, '/') ? url($offer->url) : $offer->url) : null)
            <article class="eng eng-tone-{{ $i === 0 ? 'lead' : $i % 4 }} {{ $loop->first ? 'is-open' : '' }}" data-eng-item>
                <button type="button" class="eng-spine" data-eng-toggle aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="eng-panel-{{ $i }}">
                    <span class="eng-num">{{ $num }}</span>
                    <span class="icon-chip"><x-line-icon :name="$offer->icon ?: 'compass'" /></span>
                    <span class="eng-spine-title">{{ $offer->title }}</span>
                    @if ($offer->category)<span class="eng-spine-format">{{ $offer->category }}</span>@endif
                    <span class="eng-plus" aria-hidden="true"><x-line-icon name="arrow" /></span>
                </button>
                <div class="eng-panel" id="eng-panel-{{ $i }}">
                    @if ($i === 0 && content_image('home.idea_image'))
                        <span class="eng-art" aria-hidden="true" style="--art: url('{{ content_image('home.idea_image') }}')"></span>
                    @elseif ($offer->imageUrl())
                        <figure class="eng-illus" aria-hidden="true"><img src="{{ $offer->imageUrl() }}" alt="" loading="lazy"></figure>
                    @endif
                    <div class="eng-top">
                        <span class="eng-num">{{ $num }}</span>
                        @if ($offer->category)<span class="eng-format">{{ $offer->category }}</span>@endif
                    </div>
                    <div class="eng-copy">
                        <h3>{{ $offer->title }}</h3>
                        @if ($offer->subtitle)<p class="eng-for"><span>For</span> {{ $offer->subtitle }}</p>@endif
                        @if ($offer->body)<p class="eng-body">{{ $offer->body }}</p>@endif
                        @if ($href)<a class="eng-link" href="{{ $href }}">{{ $i === 0 ? 'Start a conversation' : 'Enquire' }} <span class="eng-link-go"><x-line-icon name="arrow" /></span></a>@endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif
