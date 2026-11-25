@php
    $siteName = content('seo.site_name');
    $pageTitle = $title ? $title.' — '.$siteName : content('seo.home_title');
    $shareImage = ! empty($image) ? $image : content_image('seo.share_image');
    $analyticsId = trim((string) \App\Models\Setting::get('analytics_id'));
@endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ $description }}">
<meta name="theme-color" content="#FCFAF7">
@unless (content_on('seo.allow_indexing'))<meta name="robots" content="noindex, nofollow">@endunless
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $description }}">
@if ($shareImage)<meta property="og:image" content="{{ $shareImage }}"><meta name="twitter:image" content="{{ $shareImage }}"><meta name="twitter:card" content="summary_large_image">@endif
@include('partials.favicon')
<link rel="canonical" href="{{ url()->current() }}">
<title>{{ $pageTitle }}</title>
@fonts
@include('partials.image-vars')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@if ($analyticsId && preg_match('/^G-[A-Z0-9]+$/', $analyticsId) && ! request()->is('admin*'))
{{-- Google Analytics 4: page views, plus a "generate_lead" event when a form is sent (see the conversion flags below). --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $analyticsId }}', { anonymize_ip: true });
    @foreach (['enquiry_saved' => 'enquiry', 'application_saved' => 'mentorship_application', 'subscribed' => 'newsletter', 'waitlist_saved' => 'book_waitlist'] as $flag => $form)
        @if (session($flag)) gtag('event', 'generate_lead', { form_name: '{{ $form }}' }); @endif
    @endforeach
    document.addEventListener('click', function (e) {
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a) return;
        var href = a.getAttribute('href') || '';
        if (/\.pdf($|\?)/i.test(href)) gtag('event', 'file_download', { file_name: href });
        else if (/^mailto:/i.test(href)) gtag('event', 'contact_email_click');
        else if (/\/contact/.test(href)) gtag('event', 'cta_click', { link_text: (a.textContent || '').trim().slice(0, 60), link_url: href });
    });
</script>
@endif
