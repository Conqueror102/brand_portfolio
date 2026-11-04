@php($stops = items('career'))
@if ($stops->isNotEmpty())
@php($roman = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii', 'xiii', 'xiv', 'xv'])
@php($artTurn = 0)
<section class="career" id="journey" aria-labelledby="journey-title" data-journey>
    <div class="career-sticky">
        <header class="career-head">
            <p class="eyebrow">{{ content('home.journey_eyebrow') }}</p>
            <h2 id="journey-title" class="display">{{ content_html('home.journey_title') }}</h2>
            <p class="career-intro">{{ content('home.journey_text') }}</p>
            <p class="career-count" aria-hidden="true"><span data-journey-current>01</span> / {{ str_pad($stops->count(), 2, '0', STR_PAD_LEFT) }}</p>
            <p class="career-hint" aria-hidden="true"><span></span>Keep scrolling</p>
        </header>
        <div class="career-rail">
            <ol class="career-track" data-journey-track>
                @foreach ($stops as $i => $stop)
                    @php($figure = preg_match('/\b\d+(?:[.,]\d+)?\s?(?:%|\+)?/u', (string) $stop->body, $m) ? trim($m[0]) : null)
                    @php($kind = $loop->last ? 'now' : ($figure ? 'figure' : (($artTurn++ % 2) ? 'scene' : 'art')))
                    <li class="career-stop is-{{ $kind }}" data-journey-stop data-year="{{ mb_substr($stop->category, 0, 4) }}">
                        <article class="career-card">
                            <div class="career-card-top">
                                <span class="career-chip"><x-line-icon :name="$stop->icon ?: 'steps'" /></span>
                                <span class="career-years">{{ $stop->category }}</span>
                                <span class="career-roman" aria-hidden="true">{{ $roman[$i] ?? ($i + 1) }}.</span>
                            </div>
                            @if ($kind === 'figure')
                                <p class="career-figure" data-count="{{ $figure }}">{{ $figure }}</p>
                                <p class="career-figure-label">{{ \Illuminate\Support\Str::limit($stop->body, 90) }}</p>
                            @elseif ($kind === 'scene' && $stop->imageUrl())
                                <figure class="career-scene"><img src="{{ $stop->imageUrl() }}" alt="" loading="lazy">
                                    <span class="career-toast"><span class="career-toast-dot"></span><span><strong>{{ $stop->subtitle }}</strong><small>{{ $stop->category }}</small></span></span>
                                </figure>
                            @elseif ($stop->imageUrl())
                                <figure class="career-art"><img src="{{ $stop->imageUrl() }}" alt="" loading="lazy"></figure>
                            @endif
                            @if ($kind === 'now')<p class="career-now"><span class="pulse-dot"></span>Now</p>@endif
                            <div class="career-text">
                                <h3>{{ $stop->title }}</h3>
                                <p class="career-org">{{ $stop->subtitle }}</p>
                                @if ($stop->body && $kind !== 'figure')<p class="career-body">{{ $stop->body }}</p>@endif
                            </div>
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="career-progress" aria-hidden="true"><span data-journey-fill></span></div>
    </div>
</section>
@endif
