@props(['cases'])
<ol class="work-list" data-work-list>
    @foreach ($cases as $i => $case)
        <li data-reveal>
            <a class="work-row" href="{{ route('work.show', $case->slug) }}" data-peek="{{ $case->imageUrl() }}">
                <span class="work-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="work-main">
                    <span class="work-title">{{ $case->title }}</span>
                    <span class="work-org">{{ $case->subtitle }}</span>
                </span>
                @if ($case->category)<span class="work-result">{{ $case->category }}</span>@endif
                <span class="work-go" aria-hidden="true"><x-line-icon name="arrow-up-right" /></span>
                @if ($case->imageUrl())<img class="work-thumb" src="{{ $case->imageUrl() }}" alt="" loading="lazy">@endif
            </a>
        </li>
    @endforeach
</ol>
<figure class="work-peek" aria-hidden="true" data-work-peek><img alt=""></figure>
