<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in · Modupe Olusoga</title>
    @fonts
    @include('partials.image-vars')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-login">
<main class="login-shell">
    <section class="login-art" aria-hidden="true">
        <span class="brand-mark">MO</span>
        <p class="display">Clarity for people. <em>Continuity for institutions.</em></p>
    </section>
    <section class="login-panel">
        <div class="login-card">
            <p class="eyebrow">Website studio</p>
            <h1 class="display h-md">Welcome back.</h1>
            <p class="body-copy">Sign in to manage enquiries, applications and content.</p>
            <form class="form" method="POST" action="{{ route('admin.login.store') }}" data-once>
                @csrf
                <x-field name="email" label="Email" type="email" autocomplete="username" required autofocus />
                <label class="field">
                    <span>Password</span>
                    <input type="password" name="password" autocomplete="current-password" required>
                </label>
                <label class="check"><input type="checkbox" name="remember" value="1"> <span>Keep me signed in</span></label>
                <button class="btn" type="submit">Sign in <span class="btn-icon"><x-line-icon name="arrow" /></span></button>
            </form>
            <a class="login-back" href="{{ route('home') }}">← Back to the website</a>
        </div>
    </section>
</main>
</body>
</html>
