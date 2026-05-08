@extends('layouts.admin')
@section('title','إعدادات الموقع')
@section('breadcrumb') / <span>الإعدادات</span> @endsection

@php
    /**
     * Helper to get value or value_en for a key (no localized resolution here — this is admin)
     */
    $val   = fn($key, $default = '') => old($key,    $rows[$key]->value    ?? $default);
    $valEn = fn($key, $default = '') => old($key.'_en', $rows[$key]->value_en ?? $default);
    $img   = fn($key) => $rows[$key]->value ?? null;
@endphp

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">

        {{-- ============== SEO + ICONS ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-search me-2"></i>إعدادات SEO والأيقونة</span>
                    <span style="font-size:0.78rem;color:var(--text-muted);">يتحكم في كيفية ظهور موقعك في جوجل ووسائل التواصل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">عنوان الصفحة (Title) — عربي</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ $val('meta_title', 'نواف عساج - مطور برمجيات Full Stack') }}"
                                   placeholder="نواف عساج - مطور برمجيات">
                            <small style="color:var(--text-muted);">يُفضّل 50-60 حرف</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان الصفحة (Title) — English</label>
                            <input type="text" name="meta_title_en" class="form-control" dir="ltr"
                                   value="{{ $valEn('meta_title', 'Nawaf Asag - Full Stack Developer') }}"
                                   placeholder="Nawaf Asag - Full Stack Developer">
                            <small style="color:var(--text-muted);">Keep under 60 chars</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وصف الموقع (Description) — عربي</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="170">{{ $val('meta_description', 'نواف عساج — مطور برمجيات متخصص في Laravel وReact وFlutter. أبني تطبيقات ويب وموبايل احترافية وعالية الأداء.') }}</textarea>
                            <small style="color:var(--text-muted);">يُفضّل 150-160 حرف</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">وصف الموقع (Description) — English</label>
                            <textarea name="meta_description_en" class="form-control" rows="3" dir="ltr" maxlength="170">{{ $valEn('meta_description', 'Nawaf Asag — Full Stack Developer specialized in Laravel, React, and Flutter. Building professional, high-performance web and mobile applications.') }}</textarea>
                            <small style="color:var(--text-muted);">Keep under 160 chars</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">كلمات مفتاحية (Keywords) — عربي</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="{{ $val('meta_keywords', 'مطور برمجيات, Laravel, React, تطوير ويب, تطبيقات موبايل, Full Stack') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">كلمات مفتاحية (Keywords) — English</label>
                            <input type="text" name="meta_keywords_en" class="form-control" dir="ltr"
                                   value="{{ $valEn('meta_keywords', 'software developer, Laravel, React, web development, mobile apps, Full Stack') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">اسم المؤلف</label>
                            <input type="text" name="site_author" class="form-control" dir="ltr"
                                   value="{{ $val('site_author', 'Nawaf Asag') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">حساب تويتر (بدون @)</label>
                            <input type="text" name="twitter_handle" class="form-control" dir="ltr"
                                   value="{{ $val('twitter_handle', '') }}" placeholder="username">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">المسمى الوظيفي (للـ Schema)</label>
                            <input type="text" name="job_title_en" class="form-control" dir="ltr"
                                   value="{{ $val('job_title_en', 'Full Stack Developer') }}">
                        </div>

                        <hr style="border-color:rgba(99,102,241,0.15);margin:0.5rem 0;">

                        <div class="col-md-6">
                            <label class="form-label">أيقونة الموقع (Favicon)</label>
                            @if($img('site_favicon'))
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/'.$img('site_favicon')) }}" alt="favicon"
                                         style="width:48px;height:48px;background:#fff;padding:4px;border-radius:8px;object-fit:contain;">
                                    <small style="color:var(--text-muted);">الأيقونة الحالية</small>
                                </div>
                            @endif
                            <input type="file" name="site_favicon" class="form-control" accept="image/png,image/jpeg,image/svg+xml,image/webp,image/x-icon">
                            <small style="color:var(--text-muted);">PNG/SVG شفاف، 512×512 موصى به</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">صورة المشاركة الاجتماعية (OG Image)</label>
                            @if($img('og_image'))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$img('og_image')) }}" alt="OG"
                                         style="max-width:160px;max-height:90px;border-radius:6px;">
                                </div>
                            @endif
                            <input type="file" name="og_image" class="form-control" accept="image/*">
                            <small style="color:var(--text-muted);">1200×630 — تظهر عند مشاركة الرابط في وسائل التواصل</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">عنوان OG (اختياري) — عربي</label>
                            <input type="text" name="og_title" class="form-control"
                                   value="{{ $val('og_title') }}" placeholder="يأخذ من Title إن تُرك فارغاً">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان OG (اختياري) — English</label>
                            <input type="text" name="og_title_en" class="form-control" dir="ltr"
                                   value="{{ $valEn('og_title') }}" placeholder="Falls back to Title if empty">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وصف OG (اختياري) — عربي</label>
                            <textarea name="og_description" class="form-control" rows="2">{{ $val('og_description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">وصف OG (اختياري) — English</label>
                            <textarea name="og_description_en" class="form-control" rows="2" dir="ltr">{{ $valEn('og_description') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ============== HERO ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-circle me-2"></i>قسم الرئيسية (Hero)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">الاسم الكامل — عربي</label>
                            <input type="text" name="hero_name" class="form-control" value="{{ $val('hero_name', 'نواف عساج') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Full name — English (يستخدم Nawaf Asag إن تُرك فارغاً)</label>
                            <input type="text" name="hero_name_en" class="form-control" dir="ltr" value="{{ $valEn('hero_name', 'Nawaf Asag') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الشارة (Badge) — عربي</label>
                            <input type="text" name="hero_subtitle" class="form-control" value="{{ $val('hero_subtitle', 'مطور برمجيات Full Stack') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Badge — English</label>
                            <input type="text" name="hero_subtitle_en" class="form-control" dir="ltr" value="{{ $valEn('hero_subtitle', 'Full Stack Developer') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">النصوص المتحركة (Typed) — عربي <small style="color:var(--text-muted);">افصل بـ <code>|</code></small></label>
                            <input type="text" name="typed_strings" class="form-control"
                                   value="{{ $val('typed_strings', 'مطور برمجيات|Full Stack Developer|Laravel Expert') }}"
                                   placeholder="نص1|نص2|نص3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Typed strings — English</label>
                            <input type="text" name="typed_strings_en" class="form-control" dir="ltr"
                                   value="{{ $valEn('typed_strings', 'Full Stack Developer|Web & Mobile Developer|Laravel Expert') }}"
                                   placeholder="text1|text2|text3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الوصف القصير — عربي</label>
                            <textarea name="hero_description" class="form-control" rows="3">{{ $val('hero_description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Short description — English</label>
                            <textarea name="hero_description_en" class="form-control" rows="3" dir="ltr">{{ $valEn('hero_description') }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">زر "أعمالي" — عربي</label>
                            <input type="text" name="hero_btn_projects" class="form-control" value="{{ $val('hero_btn_projects', 'مشاهدة أعمالي') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"View work" — EN</label>
                            <input type="text" name="hero_btn_projects_en" class="form-control" dir="ltr" value="{{ $valEn('hero_btn_projects', 'View My Work') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">زر "السيرة" — عربي</label>
                            <input type="text" name="hero_btn_cv" class="form-control" value="{{ $val('hero_btn_cv', 'تحميل السيرة الذاتية') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"Download CV" — EN</label>
                            <input type="text" name="hero_btn_cv_en" class="form-control" dir="ltr" value="{{ $valEn('hero_btn_cv', 'Download CV') }}">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">رابط السيرة الذاتية (CV)</label>
                            <input type="text" name="cv_url" class="form-control" value="{{ $val('cv_url') }}" placeholder="https://...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">صورة الملف الشخصي</label>
                            @if($img('hero_image'))
                                <div class="mb-2"><img src="{{ asset('storage/'.$img('hero_image')) }}" alt="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;"></div>
                            @endif
                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ============== STATS ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-bar-chart-fill me-2"></i>الإحصائيات</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">سنوات الخبرة</label>
                            <input type="number" name="years_experience" class="form-control" value="{{ $val('years_experience', '3') }}" min="0" max="99">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">سنوات خبرة (AR)</label>
                            <input type="text" name="stat_years_label" class="form-control" value="{{ $val('stat_years_label', 'سنوات خبرة') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Years (EN)</label>
                            <input type="text" name="stat_years_label_en" class="form-control" dir="ltr" value="{{ $valEn('stat_years_label', 'Years of Experience') }}">
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                            <label class="form-label">مشاريع (AR)</label>
                            <input type="text" name="stat_projects_label" class="form-control" value="{{ $val('stat_projects_label', 'مشروع منجز') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Projects (EN)</label>
                            <input type="text" name="stat_projects_label_en" class="form-control" dir="ltr" value="{{ $valEn('stat_projects_label', 'Projects Completed') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">خدمات (AR)</label>
                            <input type="text" name="stat_services_label" class="form-control" value="{{ $val('stat_services_label', 'خدمة متخصصة') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Services (EN)</label>
                            <input type="text" name="stat_services_label_en" class="form-control" dir="ltr" value="{{ $valEn('stat_services_label', 'Specialized Services') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== ABOUT ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-fill me-2"></i>قسم "من أنا" (About)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">شارة "من أنا" — عربي</label>
                            <input type="text" name="about_tag" class="form-control" value="{{ $val('about_tag', 'من أنا') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">"About me" — EN</label>
                            <input type="text" name="about_tag_en" class="form-control" dir="ltr" value="{{ $valEn('about_tag', 'About me') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">نص التحية — عربي</label>
                            <input type="text" name="about_greeting" class="form-control" value="{{ $val('about_greeting', 'مرحباً، أنا') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">"Hi, I'm" — EN</label>
                            <input type="text" name="about_greeting_en" class="form-control" dir="ltr" value="{{ $valEn('about_greeting', "Hi, I'm") }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">النص التعريفي — عربي</label>
                            <textarea name="about_text" class="form-control" rows="5">{{ $val('about_text') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">About text — English</label>
                            <textarea name="about_text_en" class="form-control" rows="5" dir="ltr">{{ $valEn('about_text') }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">زر تواصل — AR</label>
                            <input type="text" name="about_btn_contact" class="form-control" value="{{ $val('about_btn_contact', 'تواصل معي') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"Contact" — EN</label>
                            <input type="text" name="about_btn_contact_en" class="form-control" dir="ltr" value="{{ $valEn('about_btn_contact', 'Contact Me') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">زر أعمال — AR</label>
                            <input type="text" name="about_btn_projects" class="form-control" value="{{ $val('about_btn_projects', 'أعمالي') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"My Work" — EN</label>
                            <input type="text" name="about_btn_projects_en" class="form-control" dir="ltr" value="{{ $valEn('about_btn_projects', 'My Work') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">المهارات (نسخة عربي + إنجليزي)</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <textarea name="skills" class="form-control" rows="6" dir="ltr">{{ $val('skills', "bi-filetype-php|PHP & Laravel\nbi-filetype-js|JavaScript & Vue.js\nbi-database|MySQL & PostgreSQL\nbi-git|Git & DevOps\nbi-phone|Flutter & Mobile\nbi-server|REST API & GraphQL") }}</textarea>
                                    <small style="color:var(--text-muted);">صيغة: <code>icon|اسم بالعربية</code></small>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="skills_en" class="form-control" rows="6" dir="ltr">{{ $valEn('skills', "bi-filetype-php|PHP & Laravel\nbi-filetype-js|JavaScript & Vue.js\nbi-database|MySQL & PostgreSQL\nbi-git|Git & DevOps\nbi-phone|Flutter & Mobile\nbi-server|REST API & GraphQL") }}</textarea>
                                    <small style="color:var(--text-muted);">Format: <code>icon|English name</code></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">صورة قسم "من أنا"</label>
                            @if($img('about_image'))
                                <div class="mb-2"><img src="{{ asset('storage/'.$img('about_image')) }}" alt="" style="max-width:160px;border-radius:8px;"></div>
                            @endif
                            <input type="file" name="about_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== SECTION TITLES ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-card-heading me-2"></i>عناوين الأقسام</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">شارة الخدمات — AR</label>
                            <input type="text" name="services_tag" class="form-control" value="{{ $val('services_tag', 'ماذا أقدم') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Services tag — EN</label>
                            <input type="text" name="services_tag_en" class="form-control" dir="ltr" value="{{ $valEn('services_tag', 'What I Offer') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان الخدمات — AR</label>
                            <input type="text" name="services_title" class="form-control" value="{{ $val('services_title', 'خدماتي المتخصصة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Services title — EN</label>
                            <input type="text" name="services_title_en" class="form-control" dir="ltr" value="{{ $valEn('services_title', 'My Specialized Services') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">شارة الأعمال — AR</label>
                            <input type="text" name="projects_tag" class="form-control" value="{{ $val('projects_tag', 'معرض الأعمال') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Projects tag — EN</label>
                            <input type="text" name="projects_tag_en" class="form-control" dir="ltr" value="{{ $valEn('projects_tag', 'Portfolio') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان الأعمال — AR</label>
                            <input type="text" name="projects_title" class="form-control" value="{{ $val('projects_title', 'أبرز أعمالي') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Projects title — EN</label>
                            <input type="text" name="projects_title_en" class="form-control" dir="ltr" value="{{ $valEn('projects_title', 'Featured Projects') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">شارة التواصل — AR</label>
                            <input type="text" name="contact_tag" class="form-control" value="{{ $val('contact_tag', 'تواصل معي') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact tag — EN</label>
                            <input type="text" name="contact_tag_en" class="form-control" dir="ltr" value="{{ $valEn('contact_tag', 'Get in touch') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان التواصل — AR</label>
                            <input type="text" name="contact_title" class="form-control" value="{{ $val('contact_title', 'لنتحدث عن مشروعك') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact title — EN</label>
                            <input type="text" name="contact_title_en" class="form-control" dir="ltr" value="{{ $valEn('contact_title', "Let's discuss your project") }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">معلومات التواصل (عنوان) — AR</label>
                            <input type="text" name="contact_info_title" class="form-control" value="{{ $val('contact_info_title', 'معلومات التواصل') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact info title — EN</label>
                            <input type="text" name="contact_info_title_en" class="form-control" dir="ltr" value="{{ $valEn('contact_info_title', 'Contact information') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">عنوان نموذج الرسالة — AR</label>
                            <input type="text" name="contact_form_title" class="form-control" value="{{ $val('contact_form_title', 'أرسل لي رسالة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Form title — EN</label>
                            <input type="text" name="contact_form_title_en" class="form-control" dir="ltr" value="{{ $valEn('contact_form_title', 'Send me a message') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">زر الإرسال — AR</label>
                            <input type="text" name="contact_btn" class="form-control" value="{{ $val('contact_btn', 'إرسال الرسالة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Send button — EN</label>
                            <input type="text" name="contact_btn_en" class="form-control" dir="ltr" value="{{ $valEn('contact_btn', 'Send Message') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">"الكل" — AR</label>
                            <input type="text" name="filter_all" class="form-control" value="{{ $val('filter_all', 'الكل') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"All" — EN</label>
                            <input type="text" name="filter_all_en" class="form-control" dir="ltr" value="{{ $valEn('filter_all', 'All') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"مواقع ويب" — AR</label>
                            <input type="text" name="filter_web" class="form-control" value="{{ $val('filter_web', 'مواقع ويب') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"Web" — EN</label>
                            <input type="text" name="filter_web_en" class="form-control" dir="ltr" value="{{ $valEn('filter_web', 'Web') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"تطبيقات" — AR</label>
                            <input type="text" name="filter_mobile" class="form-control" value="{{ $val('filter_mobile', 'تطبيقات موبايل') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"Mobile" — EN</label>
                            <input type="text" name="filter_mobile_en" class="form-control" dir="ltr" value="{{ $valEn('filter_mobile', 'Mobile') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"مميز" — AR</label>
                            <input type="text" name="featured_label" class="form-control" value="{{ $val('featured_label', 'مميز') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">"Featured" — EN</label>
                            <input type="text" name="featured_label_en" class="form-control" dir="ltr" value="{{ $valEn('featured_label', 'Featured') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">عبارة "تابعني" — AR</label>
                            <input type="text" name="social_label" class="form-control" value="{{ $val('social_label', 'تابعني على منصات التواصل الاجتماعي') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">"Follow me" — EN</label>
                            <input type="text" name="social_label_en" class="form-control" dir="ltr" value="{{ $valEn('social_label', 'Follow me on social media') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== CONTACT INFO ============== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-telephone-fill me-2"></i>معلومات التواصل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="contact_email" class="form-control" dir="ltr" value="{{ $val('contact_email') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="contact_phone" class="form-control" dir="ltr" value="{{ $val('contact_phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الموقع — عربي</label>
                            <input type="text" name="contact_location" class="form-control" value="{{ $val('contact_location', 'المملكة العربية السعودية') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location — English</label>
                            <input type="text" name="contact_location_en" class="form-control" dir="ltr" value="{{ $valEn('contact_location', 'Saudi Arabia') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex gap-3 sticky-bottom" style="background:var(--dark);padding:1rem 0;bottom:0;">
            <button type="submit" class="btn-primary-admin">
                <i class="bi bi-check-circle"></i> حفظ كل الإعدادات
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-outline-admin">
                <i class="bi bi-x"></i> إلغاء
            </a>
        </div>

    </div>
</form>
@endsection
