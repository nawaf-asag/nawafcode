@extends('layouts.app')

@section('content')

<!-- ===== HERO ===== -->
<section id="hero">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row align-items-center min-vh-100 g-5">
            <div class="col-lg-7" data-aos="fade-right">
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
                        <i class="bi bi-eye"></i> مشاهدة أعمالي
                    </a>
                    @if($settings['cv_url'] ?? '#')
                    <a href="{{ $settings['cv_url'] }}" class="btn-outline-custom" target="_blank">
                        <i class="bi bi-download"></i> تحميل السيرة الذاتية
                    </a>
                    @endif
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $projects->count() }}+</span>
                        <span class="stat-label">مشروع منجز</span>
                    </div>
                    <div class="stat-item" style="border-right:1px solid rgba(99,102,241,0.2);padding-right:2rem;border-left:1px solid rgba(99,102,241,0.2);padding-left:2rem;">
                        <span class="stat-number">{{ $services->count() }}+</span>
                        <span class="stat-label">خدمة متخصصة</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">3+</span>
                        <span class="stat-label">سنوات خبرة</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center" data-aos="fade-left" data-aos-delay="200">
                <div class="float-anim">
                    <div class="hero-avatar mx-auto">
                        <div class="hero-avatar-inner">
                            @if($settings['hero_image'] ?? null)
                                <img src="{{ asset('storage/'.$settings['hero_image']) }}" alt="{{ $settings['hero_name'] }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Social Icons -->
                <div class="social-links-section justify-content-center mt-4">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-link" target="_blank" title="{{ $link->platform }}">
                        <i class="bi {{ $link->icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Decorative code elements -->
    <div style="position:absolute;top:20%;left:5%;opacity:0.06;font-size:10rem;color:var(--primary);font-family:monospace;">&lt;/&gt;</div>
    <div style="position:absolute;bottom:15%;right:5%;opacity:0.04;font-size:8rem;color:var(--secondary);font-family:monospace;">{}</div>
</section>

<!-- ===== ABOUT ===== -->
<section id="about">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div style="position:relative;">
                    <div style="width:100%;padding-bottom:90%;background:linear-gradient(135deg,rgba(99,102,241,0.2),rgba(6,182,212,0.2));border-radius:24px;border:1px solid rgba(99,102,241,0.2);display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;">
                        @if($settings['about_image'] ?? null)
                            <img src="{{ asset('storage/'.$settings['about_image']) }}" alt="About" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="bi bi-person-workspace" style="font-size:8rem;color:var(--primary);opacity:0.5;position:absolute;top:50%;transform:translateY(-50%);"></i>
                        @endif
                    </div>
                    <div style="position:absolute;bottom:-20px;right:-20px;width:120px;height:120px;border-radius:16px;background:var(--gradient);display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;">
                        <span style="font-size:1.8rem;font-weight:800;">3+</span>
                        <span style="font-size:0.7rem;text-align:center;">سنوات<br>خبرة</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="section-tag"><i class="bi bi-person me-1"></i> من أنا</div>
                <h2 class="section-title mb-3" style="text-align:right;">مرحباً، أنا <span style="background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $settings['hero_name'] ?? 'نواف عساج' }}</span></h2>
                <p style="color:var(--text-muted);line-height:2;margin-bottom:2rem;">{{ $settings['about_text'] ?? '' }}</p>

                <div class="row g-2">
                    @php
                        $skills = [
                            ['icon'=>'bi-filetype-php','name'=>'PHP & Laravel'],
                            ['icon'=>'bi-filetype-js','name'=>'JavaScript & Vue.js'],
                            ['icon'=>'bi-database','name'=>'MySQL & PostgreSQL'],
                            ['icon'=>'bi-git','name'=>'Git & DevOps'],
                            ['icon'=>'bi-phone','name'=>'Flutter & Mobile'],
                            ['icon'=>'bi-server','name'=>'REST API & GraphQL'],
                        ];
                    @endphp
                    @foreach($skills as $skill)
                    <div class="col-6">
                        <div class="skill-item">
                            <i class="bi {{ $skill['icon'] }} skill-icon"></i>
                            <span style="font-weight:600;color:var(--text);font-size:0.9rem;">{{ $skill['name'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="#contact" class="btn-primary-custom"><i class="bi bi-chat-dots"></i> تواصل معي</a>
                    <a href="#projects" class="btn-outline-custom"><i class="bi bi-grid-3x3-gap"></i> أعمالي</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICES ===== -->
<section id="services">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag"><i class="bi bi-briefcase me-1"></i> ماذا أقدم</div>
            <h2 class="section-title">خدماتي المتخصصة</h2>
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
            <div class="section-tag"><i class="bi bi-grid me-1"></i> معرض الأعمال</div>
            <h2 class="section-title">أبرز أعمالي</h2>
            <div class="section-divider"></div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-btns" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">الكل</button>
            <button class="filter-btn" data-filter="web">مواقع ويب</button>
            <button class="filter-btn" data-filter="mobile">تطبيقات موبايل</button>
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
                            <div class="featured-badge"><i class="bi bi-star-fill me-1"></i>مميز</div>
                        @endif
                        <div class="project-overlay">
                            @if($project->project_url && $project->project_url !== '#')
                            <a href="{{ $project->project_url }}" target="_blank" title="معاينة المشروع">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif
                            @if($project->github_url && $project->github_url !== '#')
                            <a href="{{ $project->github_url }}" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
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
            <div class="section-tag"><i class="bi bi-envelope me-1"></i> تواصل معي</div>
            <h2 class="section-title">لنتحدث عن مشروعك</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-4" data-aos="fade-right">
                <div class="contact-card">
                    <h3 style="font-weight:700;margin-bottom:1.5rem;color:var(--text);">معلومات التواصل</h3>

                    @if($settings['contact_email'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div style="font-weight:600;color:var(--text);font-size:0.9rem;">البريد الإلكتروني</div>
                            <a href="mailto:{{ $settings['contact_email'] }}" style="color:var(--text-muted);font-size:0.9rem;text-decoration:none;">{{ $settings['contact_email'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_phone'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div style="font-weight:600;color:var(--text);font-size:0.9rem;">رقم الهاتف</div>
                            <span style="color:var(--text-muted);font-size:0.9rem;">{{ $settings['contact_phone'] }}</span>
                        </div>
                    </div>
                    @endif

                    @if($settings['contact_location'] ?? null)
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div style="font-weight:600;color:var(--text);font-size:0.9rem;">الموقع</div>
                            <span style="color:var(--text-muted);font-size:0.9rem;">{{ $settings['contact_location'] }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Social Links -->
                    <div class="mt-3">
                        <p style="color:var(--text-muted);font-size:0.85rem;margin-bottom:1rem;">تابعني على منصات التواصل الاجتماعي</p>
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

            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-card">
                    <h3 style="font-weight:700;margin-bottom:1.5rem;color:var(--text);">أرسل لي رسالة</h3>

                    @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.9rem;">الاسم الكامل</label>
                                <input type="text" name="name" class="form-control" placeholder="اكتب اسمك..." value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.9rem;">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" placeholder="بريدك الإلكتروني..." value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.9rem;">الموضوع</label>
                                <input type="text" name="subject" class="form-control" placeholder="موضوع رسالتك..." value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="color:var(--text-muted);font-size:0.9rem;">الرسالة</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send-fill me-2"></i> إرسال الرسالة
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
<!-- Typed.js -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>
<script>
    new Typed('#typed-text', {
        strings: [
            '{{ $settings['hero_title'] ?? 'مطور برمجيات' }}',
            'Full Stack Developer',
            'Web & Mobile Developer',
            'Laravel Expert',
        ],
        typeSpeed: 60,
        backSpeed: 40,
        loop: true,
        backDelay: 2000,
    });

    // Project Filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;

            projectItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
