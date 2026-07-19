@extends('layouts.app')

@php
    $isEn        = app()->getLocale() === 'en';
    $homeUrl     = $isEn ? route('en.home') : route('home');
    $servicesUrl = $homeUrl . '#services';
    $contactUrl  = $homeUrl . '#contact';
    $relatedUrl  = fn ($s) => $isEn ? route('en.services.show', $s->slug) : route('services.show', $s->slug);

    $title       = $service->localized('title');
    $content     = $service->localized('content');
    $description = $service->localized('description');
    $faqs        = $service->faqPairs();
    $keywords    = $service->keywordsList();
    $cover       = $service->cover_image ? asset('storage/'.$service->cover_image) : null;
@endphp

@section('content')
<article class="service-detail">

    {{-- ===== HEADER ===== --}}
    <section class="service-detail-hero">
        <div class="hero-blob" aria-hidden="true"></div>
        <div class="container" style="position:relative;z-index:1;">

            {{-- Breadcrumb --}}
            <nav class="service-breadcrumb" aria-label="breadcrumb">
                <a href="{{ $homeUrl }}">{{ __('site.nav_home') }}</a>
                <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }}" aria-hidden="true"></i>
                <a href="{{ $servicesUrl }}">{{ __('site.nav_services') }}</a>
                <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }}" aria-hidden="true"></i>
                <span aria-current="page">{{ $title }}</span>
            </nav>

            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-{{ $cover ? '7' : '12' }}" data-aos="fade-up">
                    <div class="section-tag"><i class="bi bi-briefcase me-1"></i> {{ __('site.services_tag') }}</div>
                    <h1 class="service-detail-title">
                        <span class="service-detail-icon"><i class="bi {{ $service->icon }}"></i></span>
                        {{ $title }}
                    </h1>
                    <p class="service-detail-lead">{{ $description }}</p>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ $contactUrl }}" class="btn-primary-custom">
                            <i class="bi bi-chat-dots"></i> {{ __('site.service_cta_btn') }}
                        </a>
                        <a href="{{ $servicesUrl }}" class="btn-outline-custom">
                            <i class="bi bi-grid"></i> {{ __('site.service_all') }}
                        </a>
                    </div>
                </div>

                @if($cover)
                <div class="col-lg-5 text-center" data-aos="fade-left" data-aos-delay="150">
                    <div class="service-detail-cover">
                        <img src="{{ $cover }}" alt="{{ $title }}" loading="eager" decoding="async">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===== BODY ===== --}}
    <section class="service-detail-body">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="service-content">
                        @if(filled($content))
                            {!! $content !!}
                        @else
                            <p>{{ $description }}</p>
                        @endif
                    </div>

                    @if(count($keywords))
                    <div class="service-keywords">
                        <h2 class="service-block-title">{{ __('site.service_keywords_title') }}</h2>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($keywords as $kw)
                                <span class="service-chip">{{ $kw }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(count($faqs))
                    <div class="service-faq">
                        <h2 class="service-block-title">{{ __('site.service_faq_title') }}</h2>
                        <div class="accordion" id="faqAccordion">
                            @foreach($faqs as $i => $faq)
                            <div class="service-faq-item">
                                <button class="service-faq-q" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}"
                                        aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="faq{{ $i }}">
                                    <span>{{ $faq['q'] }}</span>
                                    <i class="bi bi-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div id="faq{{ $i }}" class="collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                    <div class="service-faq-a">{{ $faq['a'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <aside class="service-sidebar">
                        <div class="service-cta-card">
                            <h3>{{ __('site.service_cta_title') }}</h3>
                            <p>{{ __('site.service_cta_text') }}</p>
                            <a href="{{ $contactUrl }}" class="btn-primary-custom w-100 justify-content-center">
                                <i class="bi bi-send"></i> {{ __('site.service_cta_btn') }}
                            </a>
                        </div>

                        @if($related->count())
                        <div class="service-related-card">
                            <h3>{{ __('site.service_related') }}</h3>
                            <ul class="service-related-list">
                                @foreach($related as $r)
                                <li>
                                    <a href="{{ $relatedUrl($r) }}">
                                        <span class="service-related-icon"><i class="bi {{ $r->icon }}"></i></span>
                                        <span>{{ $r->localized('title') }}</span>
                                        <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-auto" aria-hidden="true"></i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
</article>

{{-- ===== Structured data: Service + Breadcrumb + FAQ ===== --}}
@push('structured-data')
@php
    $author   = $settings['site_author'] ?? 'Nawaf Asag';
    $personId = url('/') . '#person';
    $svcNodes = [];

    $svcNodes[] = array_filter([
        '@type'       => 'Service',
        'name'        => $title,
        'serviceType' => $title,
        'description' => $seo['description'],
        'url'         => $seo['canonical'],
        'image'       => $seo['image'] ?: null,
        'provider'    => [
            '@type' => 'Person',
            '@id'   => $personId,
            'name'  => $author,
            'url'   => url('/'),
        ],
        'areaServed'  => $settings['contact_location'] ?? null,
    ]);

    $svcNodes[] = [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('site.nav_home'),     'item' => $homeUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('site.nav_services'), 'item' => $servicesUrl],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $title,                  'item' => $seo['canonical']],
        ],
    ];

    if (count($faqs)) {
        $svcNodes[] = [
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => [
                '@type'          => 'Question',
                'name'           => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ], $faqs),
        ];
    }

    $svcStructured = ['@context' => 'https://schema.org', '@graph' => $svcNodes];
@endphp
<script type="application/ld+json">
{!! json_encode($svcStructured, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@push('page-styles')
<style>
    .service-detail-hero { padding-top: clamp(7rem, 12vw, 9.5rem); padding-bottom: clamp(2rem, 6vw, 3.5rem); position: relative; overflow: hidden; }
    .service-breadcrumb { display: flex; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; }
    .service-breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .service-breadcrumb a:hover { color: var(--primary); }
    .service-breadcrumb i { font-size: 0.7rem; opacity: 0.6; }
    .service-breadcrumb span[aria-current] { color: var(--primary); font-weight: 600; }

    .service-detail-title { font-size: clamp(1.9rem, 5vw, 3rem); font-weight: 800; line-height: 1.2; margin: 0.5rem 0 1rem; display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap; }
    .service-detail-icon { width: clamp(48px, 8vw, 64px); height: clamp(48px, 8vw, 64px); border-radius: 16px; background: rgba(34,119,172,0.12); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; font-size: clamp(1.4rem, 3vw, 1.9rem); flex-shrink: 0; }
    .service-detail-lead { font-size: clamp(1rem, 2.2vw, 1.15rem); color: var(--text-muted); line-height: 1.9; max-width: 60ch; }

    .service-detail-cover { border-radius: 20px; overflow: hidden; border: 1px solid var(--card-border); box-shadow: 0 20px 50px rgba(0,0,0,0.25); }
    .service-detail-cover img { width: 100%; height: auto; display: block; }

    .service-detail-body { padding-top: clamp(1rem, 4vw, 2rem); }
    .service-content { color: var(--text); line-height: 2; font-size: 1.02rem; }
    .service-content h2, .service-content h3 { font-weight: 800; margin: 2rem 0 0.9rem; line-height: 1.3; }
    .service-content h2 { font-size: clamp(1.35rem, 3vw, 1.7rem); }
    .service-content h3 { font-size: clamp(1.15rem, 2.5vw, 1.35rem); color: var(--primary); }
    .service-content p { margin-bottom: 1.1rem; color: var(--text-muted); }
    .service-content ul, .service-content ol { margin: 0 0 1.2rem; padding-inline-start: 1.4rem; color: var(--text-muted); }
    .service-content li { margin-bottom: 0.5rem; }
    .service-content a { color: var(--primary); text-decoration: underline; }
    .service-content img { max-width: 100%; height: auto; border-radius: 14px; margin: 1rem 0; }
    .service-content strong { color: var(--text); }

    .service-block-title { font-size: clamp(1.3rem, 3vw, 1.6rem); font-weight: 800; margin: 2.5rem 0 1.2rem; }
    .service-chip { background: rgba(34,119,172,0.1); border: 1px solid var(--card-border); color: var(--text); padding: 0.4rem 0.9rem; border-radius: 50px; font-size: 0.85rem; font-weight: 500; }

    .service-faq-item { border: 1px solid var(--card-border); border-radius: 14px; margin-bottom: 0.8rem; overflow: hidden; background: var(--card-bg); }
    .service-faq-q { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 1rem; background: transparent; border: 0; padding: 1.1rem 1.3rem; font-weight: 700; color: var(--text); font-family: inherit; font-size: 1rem; cursor: pointer; text-align: start; }
    .service-faq-q i { transition: transform 0.3s; color: var(--primary); flex-shrink: 0; }
    .service-faq-q[aria-expanded="true"] i { transform: rotate(180deg); }
    .service-faq-a { padding: 0 1.3rem 1.2rem; color: var(--text-muted); line-height: 1.9; }

    .service-sidebar { position: sticky; top: 100px; display: flex; flex-direction: column; gap: 1.2rem; }
    .service-cta-card, .service-related-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 1.6rem; }
    .service-cta-card h3, .service-related-card h3 { font-size: 1.15rem; font-weight: 800; margin-bottom: 0.6rem; }
    .service-cta-card p { color: var(--text-muted); font-size: 0.92rem; line-height: 1.8; margin-bottom: 1.2rem; }
    .service-related-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem; }
    .service-related-list a { display: flex; align-items: center; gap: 0.7rem; padding: 0.7rem 0.8rem; border-radius: 12px; color: var(--text); text-decoration: none; font-weight: 600; font-size: 0.92rem; transition: background 0.2s, color 0.2s; }
    .service-related-list a:hover { background: rgba(34,119,172,0.1); color: var(--primary); }
    .service-related-icon { width: 34px; height: 34px; border-radius: 10px; background: rgba(34,119,172,0.12); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

    @media (max-width: 991.98px) { .service-sidebar { position: static; } }
</style>
@endpush
@endsection
