@php($honours = items('recognition'))
<section class="honours" id="idea" aria-label="Big idea and recognition">
    @if (content_image('home.idea_band_art'))<img class="mf-art" src="{{ content_image('home.idea_band_art') }}" alt="" aria-hidden="true" loading="lazy">@endif
    <div class="wrap">
        {{-- The big idea, set like a manifesto. Words light up as you read down the page. --}}
        <figure class="mf" data-mf>
            <p class="mf-eyebrow"><span class="mf-rule" aria-hidden="true"></span>In her words</p>
            <blockquote class="mf-quote" data-split="1" data-mf-quote><p>{{ content_html('home.idea_quote') }}</p></blockquote>
            <figcaption class="mf-cap">
                <x-brand-mark variant="plain" class="mf-mark" />
                <span class="mf-source">{{ content('home.idea_source') }}</span>
                @if (content('home.idea_link_label') && content('home.idea_link'))
                    <a class="mf-link" href="{{ content_url('home.idea_link') }}" @if (str_starts_with(content('home.idea_link'), 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ content('home.idea_link_label') }} <x-line-icon name="arrow-up-right" /></a>
                @endif
            </figcaption>
        </figure>

        @if ($honours->isNotEmpty())
            {{-- Recognition: each honour gets its own small editorial card, with the body's real logo where one exists. --}}
            <div class="hon" aria-labelledby="recognition-title">
                <header class="hon-head">
                    <h2 id="recognition-title" class="hon-title" data-split="1">{{ content_html('home.recognition_title') }}</h2>
                    <p class="hon-count"><b>{{ str_pad($honours->count(), 2, '0', STR_PAD_LEFT) }}</b> honours &amp; appointments</p>
                </header>
                <ol class="hon-list" style="--n: {{ $honours->count() }}">
                    @foreach ($honours as $r)
                        <li class="hon-card" data-hon style="--d: {{ $loop->index }}">
                            <div class="hon-top">
                                @if ($r->imageUrl())
                                    <span class="hon-plate"><img class="hon-logo" src="{{ $r->imageUrl() }}" alt="{{ $r->subtitle }}" loading="lazy"></span>
                                @else
                                    <span class="hon-icon"><x-line-icon :name="$r->icon ?: 'star'" /></span>
                                @endif
                                <span class="hon-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <p class="hon-year">{{ $r->category }}</p>
                            <h3>{{ $r->title }}</h3>
                            @if ($r->subtitle)<p class="hon-org">{{ $r->subtitle }}</p>@endif
                            @if ($r->body)<p class="hon-body">{{ $r->body }}</p>@endif
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</section>
