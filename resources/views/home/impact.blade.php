<section class="impact" id="impact" aria-labelledby="impact-title">
    <article class="impact-story">
        <p class="impact-eyebrow">{{ content('home.impact_eyebrow') }}</p>
        <h2 id="impact-title">{{ content_html('home.impact_title') }}</h2>
        <div class="impact-milestone">
            <p class="impact-year">{{ content('home.impact_year') }}</p>
            <p>{{ content('home.impact_milestone') }}</p>
        </div>
    </article>
    <div class="impact-evidence">
        <div class="impact-row">
            <h3>{{ content('home.impact_row1_title') }}</h3>
            <div>
                @foreach (preg_split("/\R{2,}/", trim((string) content('home.impact_row1_text'))) as $paragraph)
                    <p>{!! bold_text($paragraph) !!}</p>
                @endforeach
                @if ($tags = array_filter(array_map('trim', explode("\n", (string) content('home.impact_tags')))))
                    <ul class="impact-tags" aria-label="Focus areas">
                        @foreach ($tags as $tag)<li>{{ $tag }}</li>@endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="impact-row">
            <h3>{{ content('home.impact_row2_title') }}</h3>
            <div>
                @foreach (preg_split("/\R{2,}/", trim((string) content('home.impact_row2_text'))) as $paragraph)
                    <p>{!! bold_text($paragraph) !!}</p>
                @endforeach
            </div>
        </div>
        <a class="impact-cta" href="{{ content_url('home.impact_button_link') }}">{{ content('home.impact_button_label') }} <span><x-icon name="arrow-right-white" /></span></a>
    </div>
</section>
