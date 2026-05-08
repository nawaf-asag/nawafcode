@extends('layouts.app')

@section('content')

<!-- ===== HERO ===== -->
<section id="hero">
    <div class="hero-blob" aria-hidden="true"></div>
    <div class="container" style="position:relative;z-index:1;">
        <div class="row align-items-center hero-row g-4 g-lg-5">

            <!-- الصورة: تظهر أولاً على الموبايل -->
            <div class="col-lg-5 text-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="200">
                <div class="float-anim">
                    <div class="hero-avatar mx-auto">
                        <div class="hero-avatar-inner">
                            @if($settings['hero_image'] ?? null)
                                <img src="{{ asset('storage/'.$settings['hero_image']) }}" alt="{{ $displayName }}" loading="eager" decoding="async">
                            @else
                                <i class="bi bi-person-circle" aria-hidden="true"></i>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="social-links-section justify-content-center mt-3">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener" title="{{ $link->platform }}">
                        <i class="bi {{ $link->icon }}" aria-hidden="true"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- النص -->
            <div class="col-lg-7 hero-text-col order-2 order-lg-1" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="bi bi-stars me-1"></i>
                    {{ $settings['hero_subtitle'] ?? __('site.hero_subtitle') }}
                </div>
                <h1 class="hero-name" data-text="{{ $displayName }}">{{ $displayName }}</h1>
                <div class="hero-title">
                    <span id="typed-text"></span>
                </div>
                <p class="hero-desc">{{ $settings['hero_description'] ?? '' }}</p>

                <div class="hero-btns d-flex flex-wrap">
                    <a href="#projects" class="btn-primary-custom">
                        <i class="bi bi-eye"></i>
                        {{ __('site.hero_btn_projects') }}
                    </a>
                    @if(!empty($settings['cv_url']) && $settings['cv_url'] !== '#')
                    <a href="{{ $settings['cv_url'] }}" class="btn-outline-custom" target="_blank" rel="noopener">
                        <i class="bi bi-download"></i>
                        {{ __('site.hero_btn_cv') }}
                    </a>
                    @endif
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $projects->count() }}+</span>
                        <span class="stat-label">{{ __('site.stat_projects') }}</span>
                    </div>
                    <div class="stat-item stat-divider">
                        <span class="stat-number">{{ $services->count() }}+</span>
                        <span class="stat-label">{{ __('site.stat_services') }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $settings['years_experience'] ?? '3' }}+</span>
                        <span class="stat-label">{{ __('site.stat_years') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- عناصر زخرفية - مخفية على الموبايل -->
    <div class="hero-deco" style="top:18%;inset-inline-start:4%;">&lt;/&gt;</div>
    <div class="hero-deco" style="bottom:12%;inset-inline-end:4%;color:var(--secondary);">{ }</div>
</section>

<!-- ===== ABOUT ===== -->
<section id="about">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-5 about-img-col" data-aos="fade-right">
                <div class="about-img-wrapper">
                    <div class="about-img-box">
                        @if($settings['about_image'] ?? null)
                            <img src="{{ asset('storage/'.$settings['about_image']) }}" alt="About" loading="lazy" decoding="async">
                        @else
                            <i class="bi bi-person-workspace about-img-placeholder" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div class="about-badge-box">
                        <span class="about-badge-num">{{ $settings['years_experience'] ?? '3' }}+</span>
                        <span class="about-badge-lbl">{{ $settings['stat_years_label'] ?? 'سنوات خبرة' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="section-tag"><i class="bi bi-person me-1"></i> {{ __('site.about_tag') }}</div>
                <h2 class="section-title mb-3">
                    {{ __('site.about_greeting') }}
                    <span class="gradient-text">{{ $displayName }}</span>
                </h2>
                <p class="about-text">{{ $settings['about_text'] ?? '' }}</p>

                @php
                    $skillsRaw = $settings['skills'] ?? '';
                    $skills = [];
                    if ($skillsRaw) {
                        foreach (explode("\n", trim($skillsRaw)) as $line) {
                            $parts = explode('|', trim($line));
                            if (count($parts) === 2) {
                                $skills[] = ['icon' => trim($parts[0]), 'name' => trim($parts[1])];
                            }
                        }
                    }
                    if (empty($skills)) {
                        $skills = [
                            ['icon'=>'bi-filetype-php','name'=>'PHP & Laravel'],
                            ['icon'=>'bi-filetype-js','name'=>'JavaScript & Vue.js'],
                            ['icon'=>'bi-database','name'=>'MySQL & PostgreSQL'],
                            ['icon'=>'bi-git','name'=>'Git & DevOps'],
                            ['icon'=>'bi-phone','name'=>'Flutter & Mobile'],
                            ['icon'=>'bi-server','name'=>'REST API & GraphQL'],
                        ];
                    }
                @endphp

                <div class="row g-2">
                    @foreach($skills as $skill)
                    <div class="col-6">
                        <div class="skill-item">
                            <i class="bi {{ $skill['icon'] }} skill-icon"></i>
                            <span class="skill-name">{{ $skill['name'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="#contact" class="btn-primary-custom"><i class="bi bi-chat-dots"></i> {{ __('site.about_btn_contact') }}</a>
                    <a href="#projects" class="btn-outline-custom"><i class="bi bi-grid-3x3-gap"></i> {{ __('site.about_btn_projects') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICES ===== -->
<section id="services">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-briefcase me-1"></i> {{ __('site.services_tag') }}</div>
            <h2 class="section-title">{{ __('site.services_title') }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4">
            @foreach($services as $index => $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi {{ $service->icon }}"></i>
                    </div>
                    <h3 class="service-title">{{ $service->localized('title') }}</h3>
                    <p class="service-desc">{{ $service->localized('description') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== PROJECTS ===== -->
<section id="projects">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-grid me-1"></i> {{ __('site.projects_tag') }}</div>
            <h2 class="section-title">{{ __('site.projects_title') }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="filter-btns" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">{{ __('site.filter_all') }}</button>
            <button class="filter-btn" data-filter="web">{{ __('site.filter_web') }}</button>
            <button class="filter-btn" data-filter="mobile">{{ __('site.filter_mobile') }}</button>
            <button class="filter-btn" data-filter="api">{{ __('site.filter_api') }}</button>
            <button class="filter-btn" data-filter="support">
                <i class="bi bi-headset me-1"></i>{{ __('site.filter_support') }}
            </button>
        </div>

        <div class="row g-4" id="projectsGrid">
            @foreach($projects as $index => $project)
                @php
                    $isSupport = $project->category === 'support';
                    $period = null;
                    if ($project->year_from && $project->year_to) {
                        $period = $project->year_from . ' – ' . $project->year_to;
                    } elseif ($project->year_from) {
                        $period = $project->year_from . ' – ' . __('site.year_present');
                    }
                @endphp

                @if($isSupport)
                    {{-- ===== Support card variant ===== --}}
                    <div class="col-lg-4 col-md-6 project-item" data-category="support" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="support-card">
                            <div class="support-card-head">
                                <div class="support-logo">
                                    @if($project->image)
                                        <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->localized('title') }}" loading="lazy" decoding="async">
                                    @else
                                        <i class="bi bi-headset" aria-hidden="true"></i>
                                    @endif
                                </div>
                                @if(!$project->year_to && $project->year_from)
                                    <span class="support-status-badge">
                                        <span class="support-status-dot"></span>
                                        {{ __('site.support_active') }}
                                    </span>
                                @endif
                            </div>

                            <div class="support-card-body">
                                <span class="support-category-tag">
                                    <i class="bi bi-headset me-1"></i>{{ __('site.cat_support') }}
                                </span>
                                <h3 class="support-title">{{ $project->localized('title') }}</h3>
                                @if($period)
                                    <div class="support-period">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $period }}
                                    </div>
                                @endif
                                <p class="support-desc">{{ $project->localized('description') }}</p>
                                @if($project->technologies_array)
                                    <div class="support-techs">
                                        @foreach($project->technologies_array as $tech)
                                            <span class="tech-tag">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if(($project->project_url && $project->project_url !== '#') || ($project->github_url && $project->github_url !== '#'))
                                <div class="support-card-footer">
                                    @if($project->project_url && $project->project_url !== '#')
                                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="support-link">
                                            <i class="bi bi-link-45deg"></i> {{ __('site.brand_visit') }}
                                        </a>
                                    @endif
                                    @if($project->github_url && $project->github_url !== '#')
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="support-link">
                                            <i class="bi bi-github"></i> GitHub
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- ===== Standard project card ===== --}}
                    <div class="col-lg-4 col-md-6 project-item" data-category="{{ $project->category }}" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="project-card">
                            <div class="project-img">
                                @if($project->image)
                                    <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->localized('title') }}" loading="lazy" decoding="async">
                                @else
                                    <i class="bi bi-code-square" aria-hidden="true"></i>
                                @endif
                                @if($project->featured)
                                    <div class="featured-badge"><i class="bi bi-star-fill me-1"></i>{{ __('site.featured_label') }}</div>
                                @endif
                                <div class="project-overlay">
                                    @if($project->project_url && $project->project_url !== '#')
                                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener" title="{{ __('site.brand_visit') }}"><i class="bi bi-eye"></i></a>
                                    @endif
                                    @if($project->github_url && $project->github_url !== '#')
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" title="GitHub"><i class="bi bi-github"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="project-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <span class="project-category">
                                        @switch($project->category)
                                            @case('web')    {{ __('site.cat_web') }}    @break
                                            @case('mobile') {{ __('site.cat_mobile') }} @break
                                            @case('api')    {{ __('site.cat_api') }}    @break
                                            @default {{ $project->category }}
                                        @endswitch
                                    </span>
                                    @if($project->year_from)
                                        <span class="project-year"><i class="bi bi-calendar3 me-1"></i>{{ $project->year_from }}</span>
                                    @endif
                                </div>
                                <h3 class="project-title">{{ $project->localized('title') }}</h3>
                                <p class="project-desc">{{ $project->localized('description') }}</p>
                                <div>
                                    @foreach($project->technologies_array as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- ===== BRANDS ===== -->
@if($brands->count())
<section id="brands">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-award me-1"></i> {{ __('site.brands_tag') }}</div>
            <h2 class="section-title">{{ __('site.brands_title') }}</h2>
            <p class="brands-subtitle">{{ __('site.brands_subtitle') }}</p>
            <div class="section-divider"></div>
        </div>

        <div class="brands-slider" data-aos="fade-up">
            <div class="brands-track">
                {{-- Render the list twice for seamless infinite scrolling --}}
                @for($i = 0; $i < 2; $i++)
                    @foreach($brands as $brand)
                        @php
                            $hasUrl       = $brand->website && $brand->website !== '#';
                            $contribLocal = $brand->localized('contribution');
                            $tooltip      = $brand->name . ($contribLocal ? ' — ' . $contribLocal : '');
                        @endphp
                        <div class="brand-card"
                             data-bs-toggle="tooltip"
                             data-bs-placement="top"
                             data-bs-custom-class="brand-tooltip"
                             title="{{ $tooltip }}"
                             @if($i === 1) aria-hidden="true" @endif>
                            <div class="brand-logo">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" loading="lazy" decoding="async">
                                @else
                                    <i class="bi bi-image" aria-hidden="true"></i>
                                @endif
                            </div>

                            @if($hasUrl)
                                <a class="brand-visit-link"
                                   href="{{ $brand->website }}"
                                   target="_blank"
                                   rel="noopener"
                                   aria-label="{{ __('site.brand_visit') }} — {{ $brand->name }}"
                                   @if($i === 1) tabindex="-1" @endif>
                                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</section>
@endif

<!-- ===== CONTACT ===== -->
<section id="contact">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-envelope me-1"></i> {{ __('site.contact_tag') }}</div>
            <h2 class="section-title">{{ __('site.contact_title') }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="contact-card h-100">
                    <h3 class="contact-card-title">{{ __('site.contact_info_title') }}</h3>

                    @if($settings['contact_email'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div style="min-width:0;">
                            <div class="contact-info-label">{{ __('site.contact_label_email') }}</div>
                            <a href="mailto:{{ $settings['contact_email'] }}" class="contact-info-value">{{ $settings['contact_email'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_phone'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="contact-info-label">{{ __('site.contact_label_phone') }}</div>
                            <span class="contact-info-value">{{ $settings['contact_phone'] }}</span>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_location'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="contact-info-label">{{ __('site.contact_label_location') }}</div>
                            <span class="contact-info-value">{{ $settings['contact_location'] }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <p class="contact-info-value mb-2">{{ __('site.social_label') }}</p>
                        <div class="social-links-section">
                            @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener" title="{{ $link->platform }}">
                                <i class="bi {{ $link->icon }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-card">
                    <h3 class="contact-card-title">{{ __('site.contact_form_title') }}</h3>

                    @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('site.contact_form_name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ __('site.contact_form_name_ph') }}" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('site.contact_form_email') }}</label>
                                <input type="email" name="email" class="form-control" placeholder="{{ __('site.contact_form_email_ph') }}" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('site.contact_form_subject') }}</label>
                                <input type="text" name="subject" class="form-control" placeholder="{{ __('site.contact_form_subject_ph') }}" value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('site.contact_form_message') }}</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="{{ __('site.contact_form_message_ph') }}" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send-fill me-2"></i>
                                    {{ __('site.contact_btn') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js" defer></script>
<script>
    @php
        $typedRaw = $settings['typed_strings'] ?? '';
        $typedArr = $typedRaw
            ? array_map(fn($s) => trim($s), explode('|', $typedRaw))
            : [$settings['hero_title'] ?? 'مطور برمجيات', 'Full Stack Developer', 'Web & Mobile Developer', 'Laravel Expert'];
    @endphp
    window.addEventListener('load', () => {
        if (window.Typed && document.getElementById('typed-text')) {
            new Typed('#typed-text', {
                strings: @json($typedArr),
                typeSpeed: 60,
                backSpeed: 40,
                loop: true,
                backDelay: 2000,
                cursorChar: '',
                showCursor: true,
            });
        }
    });
</script>
@endsection
