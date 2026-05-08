@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';

    // SEO values — all settings are already localized via Setting::localizedAll()
    $seoTitle       = $settings['meta_title']       ?? __('site.meta_title');
    $seoDescription = $settings['meta_description'] ?? __('site.meta_description');
    $seoKeywords    = $settings['meta_keywords']    ?? '';
    $author         = $settings['site_author']      ?? 'Nawaf Asag';
    $jobTitle       = $settings['job_title_en']     ?? 'Full Stack Developer';
    $twitterHandle  = $settings['twitter_handle']   ?? '';

    // Open Graph (falls back to meta_*)
    $ogTitle        = ($settings['og_title']       ?? '') ?: $seoTitle;
    $ogDescription  = ($settings['og_description'] ?? '') ?: $seoDescription;
    $ogImagePath    = $settings['og_image']        ?? null;
    $ogImage        = $ogImagePath ? asset('storage/'.$ogImagePath) : null;

    // Favicon
    $faviconPath = $settings['site_favicon'] ?? null;
    $faviconUrl  = $faviconPath ? asset('storage/'.$faviconPath) : asset('favicon.ico');

    $canonical    = url()->current();
    $alternateUrl = route('lang.switch', $locale === 'ar' ? 'en' : 'ar');
    $ogLocale     = $locale === 'ar' ? 'ar_SA' : 'en_US';
    $ogLocaleAlt  = $locale === 'ar' ? 'en_US' : 'ar_SA';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#f8fafc" media="(prefers-color-scheme: light)">

    {{-- ===== Primary SEO ===== --}}
    <title>{{ $seoTitle }}</title>
    <meta name="description"   content="{{ $seoDescription }}">
    @if($seoKeywords)
        <meta name="keywords"  content="{{ $seoKeywords }}">
    @endif
    <meta name="author"        content="{{ $author }}">
    <meta name="robots"        content="index, follow, max-image-preview:large">
    <meta name="googlebot"     content="index, follow">

    {{-- Canonical + Hreflang --}}
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" hreflang="{{ $locale === 'ar' ? 'en' : 'ar' }}" href="{{ $alternateUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- ===== Open Graph (Facebook, LinkedIn, WhatsApp...) ===== --}}
    <meta property="og:type"        content="profile">
    <meta property="og:site_name"   content="{{ $author }}">
    <meta property="og:title"       content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url"         content="{{ $canonical }}">
    <meta property="og:locale"      content="{{ $ogLocale }}">
    <meta property="og:locale:alternate" content="{{ $ogLocaleAlt }}">
    @if($ogImage)
        <meta property="og:image"        content="{{ $ogImage }}">
        <meta property="og:image:width"  content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt"    content="{{ $author }}">
    @endif

    {{-- ===== Twitter Card ===== --}}
    <meta name="twitter:card"        content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title"       content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    @if($ogImage)
        <meta name="twitter:image"   content="{{ $ogImage }}">
    @endif
    @if($twitterHandle)
        <meta name="twitter:site"    content="@{{ ltrim($twitterHandle, '@') }}">
        <meta name="twitter:creator" content="@{{ ltrim($twitterHandle, '@') }}">
    @endif

    {{-- ===== Favicons (one source, multiple link sizes) ===== --}}
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">

    {{-- ===== Structured Data (JSON-LD) — Person schema for Google rich result ===== --}}
    <script type="application/ld+json">
    @php
        $structured = array_filter([
            '@context'    => 'https://schema.org',
            '@type'       => 'Person',
            'name'        => $author,
            'alternateName' => $locale === 'ar' ? ($settings['hero_name'] ?? null) : null,
            'jobTitle'    => $jobTitle,
            'description' => $seoDescription,
            'url'         => url('/'),
            'image'       => isset($settings['hero_image']) ? asset('storage/'.$settings['hero_image']) : ($ogImage ?: null),
            'email'       => $settings['contact_email']    ?? null,
            'telephone'   => $settings['contact_phone']    ?? null,
            'address'     => isset($settings['contact_location']) ? [
                '@type' => 'PostalAddress',
                'addressLocality' => $settings['contact_location'],
            ] : null,
            'sameAs'      => isset($socialLinks) ? $socialLinks->pluck('url')->filter()->values()->all() : null,
        ]);
    @endphp
    {!! json_encode($structured, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- ===== Performance: preconnect to external origins ===== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">

    @if($dir === 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Apply stored theme before paint to avoid flash --}}
    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                var prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
                var theme = stored || (prefersLight ? 'light' : 'dark');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();
    </script>
</head>
<body>

{{-- ==================== PRELOADER ==================== --}}
<div id="preloader" aria-hidden="true">
    <div class="preloader-terminal">
        <div class="preloader-terminal-bar">
            <span class="dot dot-r"></span>
            <span class="dot dot-y"></span>
            <span class="dot dot-g"></span>
            <span class="preloader-terminal-title">~/{{ $author ?? 'nawafcode' }} — bash</span>
        </div>
        <div class="preloader-terminal-body" dir="ltr">
            <div class="preloader-line"><span class="prompt">$</span> <span class="cmd">npm run dev</span></div>
            <div class="preloader-line muted">→ initializing modules...</div>
            <div class="preloader-line muted">→ compiling assets...</div>
            <div class="preloader-line muted">→ starting server on :8000</div>
            <div class="preloader-line success">✓ ready in <span class="preloader-ms">312</span>ms</div>
            <div class="preloader-line"><span class="prompt">$</span> <span class="cursor-blink"></span></div>
        </div>
    </div>
</div>

{{-- ==================== SCROLL PROGRESS BAR ==================== --}}
<div id="scrollProgress" aria-hidden="true"></div>

{{-- ==================== FLOATING CODE PARTICLES ==================== --}}
<div class="code-particles" aria-hidden="true">
    <span class="cp" style="top:8%;left:5%;animation-delay:0s;">&lt;/&gt;</span>
    <span class="cp" style="top:18%;right:8%;animation-delay:1s;">{ }</span>
    <span class="cp" style="top:35%;left:12%;animation-delay:2s;">=&gt;</span>
    <span class="cp" style="top:55%;right:5%;animation-delay:0.5s;">[ ]</span>
    <span class="cp" style="top:70%;left:7%;animation-delay:1.5s;">&amp;&amp;</span>
    <span class="cp" style="top:85%;right:12%;animation-delay:2.5s;">||</span>
    <span class="cp" style="top:25%;right:35%;animation-delay:3s;">( )</span>
    <span class="cp" style="top:62%;left:42%;animation-delay:0.8s;">::</span>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#hero">{{ $displayName }}</a>

        <!-- زر القائمة للموبايل -->
        <button class="navbar-toggler border-0 p-1" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="القائمة">
            <span class="hamburger">
                <span></span><span></span><span></span>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#about">{{ __('site.nav_about') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">{{ __('site.nav_services') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#projects">{{ __('site.nav_projects') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#brands">{{ __('site.nav_brands') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">{{ __('site.nav_contact') }}</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
                <!-- Language toggle -->
                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                   class="lang-toggle" aria-label="{{ __('site.toggle_language') }}">
                    <i class="bi bi-translate" aria-hidden="true"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}</span>
                </a>

                <!-- Theme toggle -->
                <button type="button" class="theme-toggle" data-theme-toggle aria-label="{{ __('site.toggle_theme') }}">
                    <i class="bi bi-moon-stars-fill icon-dark" aria-hidden="true"></i>
                    <i class="bi bi-sun-fill icon-light" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-brand">{{ $displayName }}</div>
        <div class="d-flex justify-content-center gap-3 mb-3">
            @foreach($socialLinks as $link)
            <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener" title="{{ $link->platform }}">
                <i class="bi {{ $link->icon }}"></i>
            </a>
            @endforeach
        </div>
        <p>
            &copy; {{ date('Y') }} {{ __('site.footer_rights') }}
            <span style="color:var(--primary);">{{ $displayName }}</span>
        </p>
    </div>
</footer>

<!-- Scroll Top -->
<button id="scrollTop" type="button" aria-label="العودة للأعلى">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

@yield('scripts')
</body>
</html>
