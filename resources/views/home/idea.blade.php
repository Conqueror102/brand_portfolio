@php($honours = items('recognition'))
<section class="idea" id="idea" aria-label="Big idea">
    <div class="wrap idea-grid">
        {{-- The quote card, after the Figma "Award recipient" card: photo fading into paper on the left, the quote set like a name on the right. --}}
        <figure class="idea-quote is-feature">
            @if (content_image('home.idea_photo'))
                <span class="idea-side" aria-hidden="true"><img src="{{ content_image('home.idea_photo') }}" alt="" loading="lazy"></span>
            @endif
            <div class="idea-body">
                <p class="idea-kicker"><x-line-icon name="star" /> The big idea</p>
                <blockquote class="idea-text" data-split="1" data-mf-quote><p>{{ content_html('home.idea_quote') }}</p></blockquote>
                <p class="idea-source">— {{ content('home.idea_source') }}</p>
                @if (content('home.idea_context'))<p class="idea-context">{{ content('home.idea_context') }}</p>@endif
                <div class="idea-meta">
                    @if (content('home.idea_event'))<span>{{ content('home.idea_event') }}</span>@endif
                    @if (content('home.idea_link_label') && content('home.idea_link'))
                        <a class="idea-btn" href="{{ content_url('home.idea_link') }}" @if (str_starts_with(content('home.idea_link'), 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ content('home.idea_link_label') }} <span><x-line-icon name="arrow-up-right" /></span></a>
                    @endif
                </div>
            </div>
        </figure>

        {{-- Recognition: a dated column. Each row shows the body's real logo; open a row to read the story behind it. --}}
        @if ($honours->isNotEmpty())
            <aside class="recognition" aria-labelledby="recognition-title">
                <header class="recognition-head">
                    <h2 id="recognition-title" class="display h-md">{{ content_html('home.recognition_title') }}</h2>
                    <span class="recognition-count">{{ str_pad($honours->count(), 2, '0', STR_PAD_LEFT) }}</span>
                </header>
                <ul data-rec>
                    @foreach ($honours as $r)
                        <li class="{{ $loop->first ? 'is-open' : '' }}" data-rec-item>
                            <button type="button" class="rec-row" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-rec-toggle>
                                <span class="recognition-year">{{ $r->category }}</span>
                                @if ($r->imageUrl())
                                    <span class="rec-logo"><img src="{{ $r->imageUrl() }}" alt="" loading="lazy"></span>
                                @else
                                    <span class="rec-logo is-icon"><x-line-icon :name="$r->icon ?: 'star'" /></span>
                                @endif
                                <span class="recognition-text"><strong>{{ $r->title }}</strong><span>{{ $r->subtitle }}</span></span>
                                @if ($r->body)<span class="rec-plus" aria-hidden="true"></span>@endif
                            </button>
                            @if ($r->body)<div class="rec-story"><p>{{ $r->body }}</p></div>@endif
                        </li>
                    @endforeach
                </ul>
            </aside>
        @endif
    </div>
</section>
