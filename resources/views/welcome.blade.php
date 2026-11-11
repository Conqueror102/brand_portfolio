@php($pages = site_pages())
<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head', ['title' => null, 'description' => content('home.meta')])
</head>
<body class="editorial-page">
@include('partials.preview-bar')
<a class="skip-link" href="#main">Skip to content</a>
<div class="editorial-shell">
<header class="editorial-header">
    <a class="editorial-brand" href="{{ route('home') }}" aria-label="{{ content('seo.site_name') }} home"><x-brand-mark class="brand-mark" /><span class="brand-name">{{ content('profile.given_name') }} {{ content('profile.surname') }}</span></a>
    <nav class="editorial-nav" aria-label="Main navigation">
        @foreach ($pages as $page)
            @if ($page['header'])<a href="{{ $page['url'] }}">{{ $page['label'] }}</a>@endif
        @endforeach
    </nav>
    <a class="connect-button" href="{{ content_url('navigation.cta_link') }}">{{ content('navigation.cta_label') }} <x-icon name="arrow-right" /></a>
    <details class="mobile-nav"><summary aria-label="Open navigation"><x-icon name="menu" /></summary><nav aria-label="Mobile navigation">
        @foreach ($pages as $page)
            <a href="{{ $page['url'] }}">{{ $page['label'] }}</a>
        @endforeach
    </nav></details>
</header>
<main id="main" class="editorial-hero">
    <div class="hero-copy">
        @if (content('home.hero_title_line'))
            <p class="hero-titles"><span class="hero-titles-row">@foreach (array_filter(array_map('trim', explode('|', (string) content('home.hero_title_line')))) as $title)<span>{{ $title }}</span>@endforeach</span></p>
        @endif
        <h1><span class="given-name">{{ content('profile.given_name') }}</span><span class="surname">{{ content('profile.surname') }}<span class="name-dot">.</span></span></h1>
        <h2>{{ content('home.hero_line1') }}<br><em>{{ content('home.hero_line2') }}</em></h2>
        <p class="hero-summary">{{ content('home.hero_summary') }}</p>
        <div class="hero-actions">
            <a class="speaking-button" href="{{ content_url('home.hero_cta_link') }}">{{ content('home.hero_cta_label') }} <x-icon name="arrow-right-white" /></a>
            @if (content('home.hero_link_label'))<a class="insights-button" href="{{ content_url('home.hero_link_link') }}">{{ content('home.hero_link_label') }} <x-icon name="arrow-right" /></a>@endif
        </div>
    </div>
    <figure class="hero-figure"><img src="{{ content_image('profile.portrait') }}" alt="{{ content('profile.portrait_alt') }}" fetchpriority="high" width="1100" height="1429">@if (content('profile.portrait_note'))<figcaption>{{ content('profile.portrait_note') }}</figcaption>@endif</figure>
</main>
</div>
<div id="after-hero"></div>
@foreach (home_sections() as [$section, $visible])
    @if ($visible && view()->exists('home.'.$section))
        @include('home.'.$section)
    @endif
@endforeach
<x-site.footer />
</body>
</html>
