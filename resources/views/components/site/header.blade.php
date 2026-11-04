@php($pages = site_pages())
<header class="page-header">
    <div class="editorial-header">
        <a class="editorial-brand" href="{{ route('home') }}" aria-label="{{ content('seo.site_name') }} home"><span class="brand-mark">{{ mb_substr(content('profile.given_name'), 0, 1) }}{{ mb_substr(content('profile.surname'), 0, 1) }}</span><span class="brand-name">{{ content('profile.given_name') }} {{ content('profile.surname') }}</span></a>
        <nav class="editorial-nav" aria-label="Main navigation">
            @foreach ($pages as $page)
                @if ($page['header'])<a href="{{ $page['url'] }}" @if ($page['active']) aria-current="page" @endif>{{ $page['label'] }}</a>@endif
            @endforeach
        </nav>
        <a class="connect-button" href="{{ content_url('navigation.cta_link') }}">{{ content('navigation.cta_label') }} <x-icon name="arrow-right" /></a>
        <details class="mobile-nav"><summary aria-label="Open navigation"><x-icon name="menu" /></summary><nav aria-label="Mobile navigation">
            @foreach ($pages as $page)
                <a href="{{ $page['url'] }}" @if ($page['active']) aria-current="page" @endif>{{ $page['label'] }}</a>
            @endforeach
        </nav></details>
    </div>
</header>
