@extends('layouts.app')

@section('content')

<!-- ===== HERO ===== -->
<section id="hero">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row align-items-center hero-row g-4 g-lg-5">

            <!-- الصورة: تظهر أولاً على الموبايل -->
            <div class="col-lg-5 text-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="200">
                <div class="float-anim">
                    <div class="hero-avatar mx-auto">
                        <div class="hero-avatar-inner">
                            @if($settings['hero_image'] ?? null)
                                <img src="{{ asset('storage/'.$settings['hero_image']) }}" alt="{{ $settings['hero_name'] ?? '' }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="social-links-section justify-content-center mt-3">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-link" target="_blank" title="{{ $link->platform }}">
                        <i class="bi {{ $link->icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- النص -->
            <div class="col-lg-7 hero-text-col order-2 order-lg-1" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="bi bi-stars me-1"></i>
                    {{ $settings['hero_subtitle'] ?? 'Full Stack Developer' }}
                </div>
                <h1 class="hero-name">{{ $settings['hero_name'] ?? 'نواف عساج' }}</h1>
                <div class="hero-title">
                    <span id="typed-text"></span>
                </div>
                <p class="hero-desc">{{ $settings['hero_description'] ?? '' }}</p>

                <div class="hero-btns d-flex flex-wrap">
                    <a href="#projects" class="btn-primary-custom">
                        <i class="bi bi-eye"></i>
                        {{ $settings['hero_btn_projects'] ?? 'مشاهدة أعمالي' }}
                    </a>
                    @if(!empty($settings['cv_url']) && $settings['cv_url'] !== '#')
                    <a href="{{ $settings['cv_url'] }}" class="btn-outline-custom" target="_blank">
                        <i class="bi bi-download"></i>
                        {{ $settings['hero_btn_cv'] ?? 'تحميل السيرة الذاتية' }}
                    </a>
                    @endif
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $projects->count() }}+</span>
                        <span class="stat-label">{{ $settings['stat_projects_label'] ?? 'مشروع منجز' }}</span>
                    </div>
                    <div class="stat-item stat-divider">
                        <span class="stat-number">{{ $services->count() }}+</span>
                        <span class="stat-label">{{ $settings['stat_services_label'] ?? 'خدمة متخصصة' }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $settings['years_experience'] ?? '3' }}+</span>
                        <span class="stat-label">{{ $settings['stat_years_label'] ?? 'سنوات خبرة' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- عناصر زخرفية - مخفية على الموبايل -->
    <div class="hero-deco" style="position:absolute;top:20%;left:5%;opacity:0.06;font-size:10rem;color:var(--primary);font-family:monospace;pointer-events:none;user-select:none;">&lt;/&gt;</div>
    <div class="hero-deco" style="position:absolute;bottom:15%;right:5%;opacity:0.04;font-size:8rem;color:var(--secondary);font-family:monospace;pointer-events:none;user-select:none;">{}</div>
</section>

<!-- ===== ABOUT ===== -->
<section id="about">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-5 about-img-col" data-aos="fade-right">
                <div class="about-img-wrapper">
                    <div class="about-img-box">
                        @if($settings['about_image'] ?? null)
                            <img src="{{ asset('storage/'.$settings['about_image']) }}" alt="About" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="bi bi-person-workspace about-img-placeholder"></i>
                        @endif
                    </div>
                    <div class="about-badge-box">
                        <span class="about-badge-num">{{ $settings['years_experience'] ?? '3' }}+</span>
                        <span class="about-badge-lbl">{{ $settings['stat_years_label'] ?? 'سنوات خبرة' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="section-tag"><i class="bi bi-person me-1"></i> {{ $settings['about_tag'] ?? 'من أنا' }}</div>
                <h2 class="section-title mb-3">
                    {{ $settings['about_greeting'] ?? 'مرحباً، أنا' }}
                    <span style="background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $settings['hero_name'] ?? 'نواف عساج' }}</span>
                </h2>
                <p style="color:var(--text-muted);line-height:2;margin-bottom:1.5rem;font-size:0.97rem;">{{ $settings['about_text'] ?? '' }}</p>

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
                            <span style="font-weight:600;color:var(--text);font-size:0.88rem;">{{ $skill['name'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="#contact" class="btn-primary-custom"><i class="bi bi-chat-dots"></i> {{ $settings['about_btn_contact'] ?? 'تواصل معي' }}</a>
                    <a href="#projects" class="btn-outline-custom"><i class="bi bi-grid-3x3-gap"></i> {{ $settings['about_btn_projects'] ?? 'أعمالي' }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICES ===== -->
<section id="services">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-briefcase me-1"></i> {{ $settings['services_tag'] ?? 'ماذا أقدم' }}</div>
            <h2 class="section-title">{{ $settings['services_title'] ?? 'خدماتي المتخصصة' }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4">
            @foreach($services as $index => $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi {{ $service->icon }}"></i>
                    </div>
                    <h3 class="service-title">{{ $service->title }}</h3>
                    <p class="service-desc">{{ $service->description }}</p>
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
            <div class="section-tag"><i class="bi bi-grid me-1"></i> {{ $settings['projects_tag'] ?? 'معرض الأعمال' }}</div>
            <h2 class="section-title">{{ $settings['projects_title'] ?? 'أبرز أعمالي' }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="filter-btns" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">{{ $settings['filter_all'] ?? 'الكل' }}</button>
            <button class="filter-btn" data-filter="web">{{ $settings['filter_web'] ?? 'مواقع ويب' }}</button>
            <button class="filter-btn" data-filter="mobile">{{ $settings['filter_mobile'] ?? 'تطبيقات موبايل' }}</button>
            <button class="filter-btn" data-filter="api">APIs</button>
        </div>

        <div class="row g-4" id="projectsGrid">
            @foreach($projects as $index => $project)
            <div class="col-lg-4 col-md-6 project-item" data-category="{{ $project->category }}" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div class="project-card">
                    <div class="project-img">
                        @if($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">
                        @else
                            <i class="bi bi-code-square"></i>
                        @endif
                        @if($project->featured)
                            <div class="featured-badge"><i class="bi bi-star-fill me-1"></i>{{ $settings['featured_label'] ?? 'مميز' }}</div>
                        @endif
                        <div class="project-overlay">
                            @if($project->project_url && $project->project_url !== '#')
                            <a href="{{ $project->project_url }}" target="_blank" title="معاينة المشروع"><i class="bi bi-eye"></i></a>
                            @endif
                            @if($project->github_url && $project->github_url !== '#')
                            <a href="{{ $project->github_url }}" target="_blank" title="GitHub"><i class="bi bi-github"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="project-body">
                        <span class="project-category">
                            @switch($project->category)
                                @case('web') مواقع ويب @break
                                @case('mobile') تطبيقات موبايل @break
                                @case('api') API @break
                                @default {{ $project->category }}
                            @endswitch
                        </span>
                        <h3 class="project-title">{{ $project->title }}</h3>
                        <p class="project-desc">{{ $project->description }}</p>
                        <div>
                            @foreach($project->technologies_array as $tech)
                                <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section id="contact">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-envelope me-1"></i> {{ $settings['contact_tag'] ?? 'تواصل معي' }}</div>
            <h2 class="section-title">{{ $settings['contact_title'] ?? 'لنتحدث عن مشروعك' }}</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="contact-card h-100">
                    <h3 style="font-weight:700;margin-bottom:1.5rem;color:var(--text);">{{ $settings['contact_info_title'] ?? 'معلومات التواصل' }}</h3>

                    @if($settings['contact_email'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div style="min-width:0;">
                            <div style="font-weight:600;color:var(--text);font-size:0.88rem;">البريد الإلكتروني</div>
                            <a href="mailto:{{ $settings['contact_email'] }}" style="color:var(--text-muted);font-size:0.85rem;text-decoration:none;word-break:break-all;">{{ $settings['contact_email'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_phone'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div style="font-weight:600;color:var(--text);font-size:0.88rem;">رقم الهاتف</div>
                            <span style="color:var(--text-muted);font-size:0.85rem;">{{ $settings['contact_phone'] }}</span>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_location'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div style="font-weight:600;color:var(--text);font-size:0.88rem;">الموقع</div>
                            <span style="color:var(--text-muted);font-size:0.85rem;">{{ $settings['contact_location'] }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <p style="color:var(--text-muted);font-size:0.83rem;margin-bottom:0.8rem;">{{ $settings['social_label'] ?? 'تابعني على منصات التواصل الاجتماعي' }}</p>
                        <div class="social-links-section">
                            @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" class="social-link" target="_blank" title="{{ $link->platform }}">
                                <i class="bi {{ $link->icon }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-card">
                    <h3 style="font-weight:700;margin-bottom:1.5rem;color:var(--text);">{{ $settings['contact_form_title'] ?? 'أرسل لي رسالة' }}</h3>

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
                                <label class="form-label" style="color:var(--text-muted);font-size:0.88rem;">الاسم الكامل</label>
                                <input type="text" name="name" class="form-control" placeholder="اكتب اسمك..." value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.88rem;">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" placeholder="بريدك الإلكتروني..." value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.88rem;">الموضوع</label>
                                <input type="text" name="subject" class="form-control" placeholder="موضوع رسالتك..." value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.88rem;">الرسالة</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send-fill me-2"></i>
                                    {{ $settings['contact_btn'] ?? 'إرسال الرسالة' }}
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
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>
<script>
    @php
        $typedRaw = $settings['typed_strings'] ?? '';
        $typedArr = $typedRaw
            ? array_map(fn($s) => trim($s), explode('|', $typedRaw))
            : [$settings['hero_title'] ?? 'مطور برمجيات', 'Full Stack Developer', 'Web & Mobile Developer', 'Laravel Expert'];
    @endphp
    new Typed('#typed-text', {
        strings: @json($typedArr),
        typeSpeed: 60,
        backSpeed: 40,
        loop: true,
        backDelay: 2000,
    });

    // Project Filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            document.querySelectorAll('.project-item').forEach(item => {
                item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
            });
        });
    });
</script>
@endsection
