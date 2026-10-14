<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Modupe Olusoga — institutional leader, professional services executive, speaker and certified coach.">
<title>Modupe Olusoga — Leadership with lasting impact</title>
@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="portfolio-page">
<a class="skip-link" href="#main">Skip to content</a>
<div class="site-shell">
<header class="site-header">
<a class="wordmark" href="/" aria-label="Modupe Olusoga home">modupe<span>olusoga.</span></a>
<nav class="desktop-nav" aria-label="Main navigation">
<a href="#main" aria-current="page">Home</a>
@foreach (['About', 'Insights', 'Speaking', 'Programmes'] as $section)
<button type="button" data-interest="{{ $section }}">{{ $section }}</button>
@endforeach
</nav>
<button class="pill header-cta" type="button" data-interest="Book a session">Book a session <span class="arrow-disc"><x-icon name="arrow-up-right" /></span></button>
<details class="mobile-nav"><summary aria-label="Open navigation"><x-icon name="menu" /></summary><nav aria-label="Mobile navigation">
<a href="#main">Home</a>
@foreach (['About', 'Insights', 'Speaking', 'Programmes', 'Book a session'] as $section)
<button type="button" data-interest="{{ $section }}">{{ $section }}</button>
@endforeach
</nav></details>
</header>
<main id="main">
<section class="hero" aria-labelledby="hero-title">
<div class="hero-intro">
<p class="eyebrow">Clarity. Purpose. Lasting impact.</p>
<h1 id="hero-title">MODUPE<br><span>OLUSOGA</span></h1>
<p class="hero-description">Building institutions that thrive beyond individuals. Helping people turn aspiration into intentional action.</p>
<button class="pill hero-cta" type="button" data-interest="Invite me to speak">Invite me to speak <span class="arrow-disc"><x-icon name="arrow-up-right" /></span></button>
<button class="text-link" type="button" data-interest="Insights">Explore my insights</button>
</div>
<figure class="portrait-card">
@if (config('brand.portrait'))
<img class="hero-portrait" src="{{ asset(config('brand.portrait')) }}" alt="Modupe Olusoga" fetchpriority="high" width="640" height="800">
@else
<div class="portrait-placeholder" role="img" aria-label="Portrait of Modupe Olusoga to be added"><span class="portrait-initials" aria-hidden="true">MO</span><span class="portrait-note">PORTRAIT FORTHCOMING</span></div>
@endif
<figcaption>Leadership with a longer view.</figcaption>
</figure>
<div class="hero-positioning">
<p class="role-kicker">Professional services executive<br>Speaker & certified coach</p>
<h2>INSTITUTIONAL<br>LEADER.<br><span>INTENTIONAL<br>IMPACT.</span></h2>
<div class="hero-perspective"><span class="small-label">THE WORK THAT MATTERS</span><p>Stronger institutions.<br>More purposeful people.<br>Outcomes that endure.</p></div>
</div>
</section>
<div class="leadership-strip" aria-label="Selected leadership roles">
<p class="strip-label">Leadership in<br>practice.</p>
<div><span class="affiliation">Streamsowers & Köhn</span><span class="affiliation-role">Chief Operating Officer</span></div>
<div><span class="affiliation">ALAN</span><span class="affiliation-role">President · 2026–2029</span></div>
<p class="strip-thought">Building people.<br>Strengthening institutions.</p>
</div>
</main>
<footer class="preview-footer"><span>Modupe Olusoga</span><a href="https://icons8.com" target="_blank" rel="noopener noreferrer">Icons by Icons8</a></footer>
</div>
<dialog id="section-dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description">
<form method="dialog"><button class="dialog-close" aria-label="Close">Close</button></form>
<p class="eyebrow">The platform is taking shape</p><h2 id="dialog-title" class="brand-heading"></h2>
<p id="dialog-description">This section is part of the next build stage. Enquiries and applications are not open on this preview yet.</p>
</dialog>
</body>
</html>
