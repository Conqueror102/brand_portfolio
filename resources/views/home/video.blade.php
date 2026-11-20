@php($video = video_embed(content('home.video_url')))
<section class="home-video wrap" id="video" aria-labelledby="video-title">
    <div class="home-video-copy" data-reveal>
        <p class="eyebrow">{{ content('home.video_eyebrow') }}</p>
        <h2 id="video-title" class="display h-lg">{{ content_html('home.video_title') }}</h2>
        <p class="body-copy">{{ content('home.video_text') }}</p>
    </div>
    <figure class="home-video-screen {{ $video ? '' : 'is-pending' }}" data-video="{{ $video ? json_encode($video) : '' }}" data-reveal>
        <img src="{{ content_image('home.video_poster') }}" alt="" loading="lazy">
        @if ($video)
            <button class="home-video-play" type="button" aria-label="Play the video: {{ strip_tags(content_html('home.video_title')) }}">
                <span class="home-video-ring"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5.5v13l11-6.5-11-6.5Z" fill="currentColor"/></svg></span>
                <span class="home-video-cta">Play video @if (content('home.video_length'))<em>{{ content('home.video_length') }}</em>@endif</span>
            </button>
        @else
            <div class="home-video-pending"><span class="home-video-ring"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5.5v13l11-6.5-11-6.5Z" fill="currentColor"/></svg></span><span>{{ content('home.video_pending') }}</span></div>
        @endif
        @if (content('home.video_caption'))<figcaption>{{ content('home.video_caption') }}</figcaption>@endif
    </figure>
</section>
