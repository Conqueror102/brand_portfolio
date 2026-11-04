<section class="idea" id="idea" aria-label="Big idea">
    <div class="wrap idea-grid">
        <figure class="idea-quote">
            @if (content_image('home.idea_image'))<img class="idea-art" src="{{ content_image('home.idea_image') }}" alt="" loading="lazy" data-parallax>@endif
            <span class="idea-mark" aria-hidden="true">“</span>
            <blockquote class="display" data-reveal="words"><p>{{ content_html('home.idea_quote') }}</p></blockquote>
            <figcaption>
                <span>{{ content('home.idea_source') }}</span>
                @if (content('home.idea_link_label') && content('home.idea_link'))
                    <a class="link-arrow" href="{{ content_url('home.idea_link') }}" @if (str_starts_with(content('home.idea_link'), 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ content('home.idea_link_label') }} <x-line-icon name="arrow-up-right" /></a>
                @endif
            </figcaption>
        </figure>
        @if (items('recognition')->isNotEmpty())
            <aside class="recognition" aria-labelledby="recognition-title">
                <h2 id="recognition-title" class="display h-md">{{ content_html('home.recognition_title') }}</h2>
                <ul>
                    @foreach (items('recognition') as $r)
                        <li data-reveal>
                            <span class="recognition-year">{{ $r->category }}</span>
                            <span class="icon-chip"><x-line-icon :name="$r->icon ?: 'star'" /></span>
                            <span class="recognition-text"><strong>{{ $r->title }}</strong>{{ $r->subtitle }}</span>
                        </li>
                    @endforeach
                </ul>
            </aside>
        @endif
    </div>
</section>
