@php($orgs = items('affiliations'))
@if ($orgs->isNotEmpty())
<section class="affil" aria-label="{{ content('home.affiliations_label') }}">
    <p class="affil-label"><span>{{ content('home.affiliations_label') }}</span></p>
    <div class="affil-viewport">
        @foreach ([false, true] as $copy)
            <ul class="affil-row" @if ($copy) aria-hidden="true" @endif>
                @foreach ($orgs as $org)
                    <li>
                        @if ($org->url && ! $copy)<a href="{{ $org->url }}" target="_blank" rel="noopener noreferrer">@endif
                        @if ($org->imageUrl())
                            <img src="{{ $org->imageUrl() }}" alt="{{ $copy ? '' : $org->title }}" loading="lazy">
                        @else
                            <span class="affil-name">{{ $org->title }}</span>
                        @endif
                        @if ($org->subtitle)<span class="affil-role">{{ $org->subtitle }}</span>@endif
                        @if ($org->url && ! $copy)</a>@endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
</section>
@endif
