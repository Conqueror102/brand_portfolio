@php($stats = items('proof_stats'))
@if ($stats->isNotEmpty())
<section class="proof" id="record" aria-labelledby="proof-title">
    <div class="proof-art" aria-hidden="true" style="--art: url('{{ content_image('home.idea_image') }}')"></div>
    <div class="proof-inner wrap">
        <header class="proof-head">
            <p class="eyebrow eyebrow-light">{{ content('home.proof_eyebrow') }}</p>
            <h2 id="proof-title" class="display h-xl">{{ content_html('home.proof_title') }}</h2>
            <p class="proof-text">{{ content('home.proof_text') }}</p>
        </header>
        <ol class="proof-grid">
            @foreach ($stats as $i => $stat)
                <li class="proof-stat {{ $i === 0 ? 'proof-stat-lead' : '' }}" data-reveal>
                    <span class="proof-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <strong class="proof-figure" data-count="{{ $stat->title }}">{{ $stat->title }}</strong>
                    <span class="proof-rule" aria-hidden="true"></span>
                    <p>{{ $stat->subtitle }}</p>
                    @if ($stat->body)<small>{{ $stat->body }}</small>@endif
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endif
