@php
    $siteName = content('seo.site_name');
    $pageTitle = $title ? $title.' — '.$siteName : content('seo.home_title');
    $shareImage = content_image('seo.share_image');
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
@if ($shareImage)<meta property="og:image" content="{{ $shareImage }}"><meta name="twitter:card" content="summary_large_image">@endif
@include('partials.favicon')
<link rel="canonical" href="{{ url()->current() }}">
<title>{{ $pageTitle }}</title>
@fonts
@include('partials.image-vars')
@vite(['resources/css/app.css', 'resources/js/app.js'])
