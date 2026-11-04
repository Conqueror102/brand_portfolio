@props(['title', 'heading' => null, 'actions' => null])
@php
    $user = auth()->user();
    $newEnquiries = $user->can('manage-inbox') ? \App\Models\Enquiry::where('status', 'new')->count() : 0;
    $newApplications = $user->can('manage-inbox') ? \App\Models\MentorshipApplication::where('status', 'submitted')->count() : 0;
    $link = fn (string $route, string $pattern) => request()->routeIs($pattern) ? 'is-active' : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} · Admin · Modupe Olusoga</title>
    @fonts
    @include('partials.image-vars')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-side" id="admin-side">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}"><span class="brand-mark">MO</span><span>Studio</span></a>
        <nav class="admin-nav" aria-label="Admin">
            <a class="{{ $link('admin.dashboard', 'admin.dashboard') }}" href="{{ route('admin.dashboard') }}"><x-line-icon name="home" /> Overview</a>
            @can('manage-inbox')
                <p class="admin-nav-label">Inbox</p>
                <a class="{{ $link('', 'admin.enquiries.*') }}" href="{{ route('admin.enquiries.index') }}"><x-line-icon name="inbox" /> Enquiries @if ($newEnquiries)<span class="admin-count">{{ $newEnquiries }}</span>@endif</a>
                <a class="{{ $link('', 'admin.applications.*') }}" href="{{ route('admin.applications.index') }}"><x-line-icon name="steps" /> Applications @if ($newApplications)<span class="admin-count">{{ $newApplications }}</span>@endif</a>
                <a class="{{ $link('', 'admin.waitlist.*') }}" href="{{ route('admin.waitlist.index') }}"><x-line-icon name="book" /> Book waiting list</a>
                <a class="{{ $link('', 'admin.subscribers.*') }}" href="{{ route('admin.subscribers.index') }}"><x-line-icon name="mail" /> Subscribers</a>
            @endcan
            @can('manage-content')
                <p class="admin-nav-label">Website</p>
                <a class="{{ $link('', 'admin.pages.*') }}" href="{{ route('admin.pages.index') }}"><x-line-icon name="home" /> Pages &amp; content</a>
                <a class="{{ $link('', 'admin.items.*') }}" href="{{ route('admin.items.overview') }}"><x-line-icon name="columns" /> Lists</a>
                <a class="{{ $link('', 'admin.media.*') }}" href="{{ route('admin.media.index') }}"><x-line-icon name="eye" /> Media library</a>
                <a class="{{ $link('', 'admin.cohort.*') }}" href="{{ route('admin.cohort.edit') }}"><x-line-icon name="calendar" /> Mentorship cohort</a>
                <a class="{{ $link('', 'admin.articles.*') }}" href="{{ route('admin.articles.index') }}"><x-line-icon name="file" /> Blog &amp; Insights</a>
                <a class="{{ $link('', 'admin.testimonials.*') }}" href="{{ route('admin.testimonials.index') }}"><x-line-icon name="quote" /> Testimonials</a>
            @endcan
            @can('manage-settings')
                <p class="admin-nav-label">Site</p>
                <a class="{{ $link('', 'admin.settings.*') }}" href="{{ route('admin.settings.edit') }}"><x-line-icon name="settings" /> Settings</a>
                <a class="{{ $link('', 'admin.team.*') }}" href="{{ route('admin.team.index') }}"><x-line-icon name="people" /> Team</a>
            @endcan
        </nav>
        <div class="admin-side-foot">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"><x-line-icon name="globe" /> View website</a>
            <a class="{{ $link('', 'admin.account.*') }}" href="{{ route('admin.account.edit') }}"><span class="admin-avatar">{{ mb_substr($user->name, 0, 1) }}</span><span><strong>{{ $user->name }}</strong><small>{{ ucfirst($user->role) }}</small></span></a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit"><x-line-icon name="logout" /> Sign out</button></form>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            <details class="admin-menu"><summary aria-label="Menu"><x-line-icon name="menu" /></summary>
                <nav>
                    <a href="{{ route('admin.dashboard') }}">Overview</a>
                    @can('manage-inbox')<a href="{{ route('admin.enquiries.index') }}">Enquiries</a><a href="{{ route('admin.applications.index') }}">Applications</a><a href="{{ route('admin.waitlist.index') }}">Book waiting list</a><a href="{{ route('admin.subscribers.index') }}">Subscribers</a>@endcan
                    @can('manage-content')<a href="{{ route('admin.pages.index') }}">Pages &amp; content</a><a href="{{ route('admin.items.overview') }}">Lists</a><a href="{{ route('admin.media.index') }}">Media library</a><a href="{{ route('admin.cohort.edit') }}">Mentorship cohort</a><a href="{{ route('admin.articles.index') }}">Blog &amp; Insights</a><a href="{{ route('admin.testimonials.index') }}">Testimonials</a>@endcan
                    @can('manage-settings')<a href="{{ route('admin.settings.edit') }}">Settings</a><a href="{{ route('admin.team.index') }}">Team</a>@endcan
                    <a href="{{ route('admin.account.edit') }}">My account</a>
                </nav>
            </details>
            <div>
                <h1 class="admin-title">{{ $heading ?? $title }}</h1>
            </div>
            @if ($actions)<div class="admin-actions">{{ $actions }}</div>@endif
        </header>
        @if (session('status'))
            <div class="alert alert-success admin-flash" role="status"><x-line-icon name="check" /> {{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error admin-flash" role="alert"><x-line-icon name="close" /> <span>@foreach ($errors->all() as $error){{ $error }}@if (! $loop->last)<br>@endif @endforeach</span></div>
        @endif
        {{ $slot }}
    </div>
</div>
</body>
</html>
