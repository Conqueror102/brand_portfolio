@php($status = mentorship_status())
<section class="home-mentorship wrap section-tight" aria-labelledby="mentorship-title">
    <div class="card card-cream home-mentorship-copy" data-reveal>
        <div class="home-mentorship-top">
            <p class="eyebrow">{{ content('home.mentorship_eyebrow') }}</p>
            <span class="status-pill status-{{ $status }}">{{ mentorship_status_label($status) }}</span>
        </div>
        <h2 id="mentorship-title" class="display h-lg">{{ content_html('home.mentorship_title') }}</h2>
        @php($who = array_slice(array_filter(array_map('trim', explode("\n", (string) content('mentorship.audience_profiles')))), 0, 3))
        @if ($who)
            <div class="mentor-for">
                <p class="mentor-for-label">{{ content('home.mentorship_for_label') }}</p>
                <ul>
                    @foreach ($who as $row)
                        @php([$person, $why] = array_pad(array_map('trim', explode('|', $row, 2)), 2, ''))
                        <li><strong>{{ $person }}</strong>@if ($why)<span>{{ $why }}</span>@endif</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <ol class="journey" aria-label="The programme journey" style="--steps: {{ max(1, items('journey')->count()) }}">
            @foreach (items('journey') as $i => $stage)
                <li><i class="journey-icon"><x-line-icon :name="$stage->icon ?: (['star', 'eye', 'steps', 'calendar', 'check'][$i] ?? 'check')" /></i><span>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $stage->title }}</li>
            @endforeach
        </ol>
        <dl class="facts">
            <div><dt>Programme</dt><dd>{{ cohort('period') }}</dd></div>
            <div><dt>Weekly</dt><dd>{{ cohort('sessions') }}</dd></div>
            <div><dt>Investment</dt><dd>{{ cohort('fee') }}</dd></div>
        </dl>
        <div class="actions">
            @if ($status === 'open')
                <a class="btn" href="{{ route('mentorship') }}#apply">Apply for the programme <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @else
                <a class="btn" href="{{ route('mentorship') }}">About the programme <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @endif
            <a class="link-arrow" href="{{ route('mentorship') }}">How it works <x-line-icon name="arrow" /></a>
        </div>
    </div>
    <figure class="frame home-mentorship-art" data-reveal>
        <img src="{{ content_image('home.mentorship_image') }}" alt="" loading="lazy">
        <div class="frame-badge"><x-line-icon name="calendar" /><div><strong>{{ cohort('opening') }}</strong>Opening session</div></div>
        <div class="frame-badge frame-badge-top"><x-line-icon name="people" /><div><strong>{{ cohort('capacity') ?: 'Limited cohort' }}</strong>Application based</div></div>
    </figure>
</section>
