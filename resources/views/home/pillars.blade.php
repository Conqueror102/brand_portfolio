@php($pillars = items('pillars'))
@if ($pillars->isNotEmpty())
{{-- Three pillars standing between a shared top beam and a shared base, like the front of an institution. --}}
<section class="pillars wrap" id="pillars" aria-labelledby="pillars-title">
    <header class="pillars-head">
        <div>
            <p class="eyebrow">{{ content('home.pillars_eyebrow') }}</p>
            <h2 id="pillars-title" class="display h-lg">{{ content_html('home.pillars_title') }}</h2>
        </div>
        @if (content('home.pillars_text'))<p class="lede">{{ content('home.pillars_text') }}</p>@endif
    </header>

    <div class="pillars-temple" style="--count: {{ $pillars->count() }}" data-reveal>
        <span class="pillars-beam" aria-hidden="true"></span>
        <ol class="pillars-row">
            @foreach ($pillars as $i => $pillar)
                <li class="pillar">
                    <span class="pillar-numeral" aria-hidden="true">{{ ['I', 'II', 'III', 'IV', 'V', 'VI'][$i] ?? $i + 1 }}</span>
                    <span class="pillar-icon"><x-line-icon :name="$pillar->icon ?: 'columns'" /></span>
                    <h3>{{ $pillar->title }}</h3>
                    @if ($pillar->body)<p>{{ $pillar->body }}</p>@endif
                    @if ($pillar->subtitle)
                        <div class="pillar-focus-wrap"><ul class="pillar-focus" aria-label="Focus areas">
                            @foreach (array_filter(array_map('trim', explode(',', $pillar->subtitle))) as $focus)
                                <li>{{ $focus }}</li>
                            @endforeach
                        </ul></div>
                    @endif
                    <span class="pillar-shaft" aria-hidden="true"></span>
                </li>
            @endforeach
        </ol>
        <span class="pillars-base" aria-hidden="true"></span>
    </div>
</section>
@endif
