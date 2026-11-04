@props(['title', 'description' => null, 'bodyClass' => '', 'ogType' => 'website'])
<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head', ['title' => $title, 'description' => $description ?? content('home.meta'), 'ogType' => $ogType])
</head>
<body class="site-page {{ $bodyClass }}">
@include('partials.preview-bar')
<a class="skip-link" href="#main">Skip to content</a>
<x-site.header />
<main id="main">
    {{ $slot }}
</main>
<x-site.footer />
</body>
</html>
