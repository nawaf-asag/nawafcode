@extends('layouts.admin')
@section('title','إعدادات الموقع')
@section('breadcrumb') / <span>الإعدادات</span> @endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">

        {{-- ====== HERO ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-circle me-2"></i>قسم الرئيسية (Hero)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" name="hero_name" class="form-control" value="{{ old('hero_name', $settings['hero_name'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">المسمى الوظيفي (عربي) — أول نص في Typed</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الشارة (Badge) — Full Stack Developer</label>
                            <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">النصوص المتحركة (Typed.js) — افصل بين كل نص بـ <code>|</code></label>
                            <input type="text" name="typed_strings" class="form-control" value="{{ old('typed_strings', $settings['typed_strings'] ?? '') }}" placeholder="مطور برمجيات|Full Stack Developer|Web Developer|Laravel Expert">
                            <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.3rem;">مثال: مطور برمجيات|Full Stack Developer|Web & Mobile Developer</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف القصير (تحت الاسم)</label>
                            <textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص زر "أعمالي"</label>
                            <input type="text" name="hero_btn_projects" class="form-control" value="{{ old('hero_btn_projects', $settings['hero_btn_projects'] ?? 'مشاهدة أعمالي') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص زر "السيرة الذاتية"</label>
                            <input type="text" name="hero_btn_cv" class="form-control" value="{{ old('hero_btn_cv', $settings['hero_btn_cv'] ?? 'تحميل السيرة الذاتية') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">رابط السيرة الذاتية (CV)</label>
                            <input type="text" name="cv_url" class="form-control" value="{{ old('cv_url', $settings['cv_url'] ?? '') }}" placeholder="https://...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">صورة الملف الشخصي</label>
                            @if($settings['hero_image'] ?? null)
                                <div class="mb-2"><img src="{{ asset('storage/'.$settings['hero_image']) }}" style="height:70px;border-radius:50%;object-fit:cover;"></div>
                            @endif
                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== STATS ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-123 me-2"></i>الإحصائيات (Hero Stats)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">سنوات الخبرة (الرقم فقط)</label>
                            <input type="number" name="years_experience" class="form-control" value="{{ old('years_experience', $settings['years_experience'] ?? '3') }}" min="0" max="99">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تسمية الخبرة</label>
                            <input type="text" name="stat_years_label" class="form-control" value="{{ old('stat_years_label', $settings['stat_years_label'] ?? 'سنوات خبرة') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تسمية المشاريع</label>
                            <input type="text" name="stat_projects_label" class="form-control" value="{{ old('stat_projects_label', $settings['stat_projects_label'] ?? 'مشروع منجز') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تسمية الخدمات</label>
                            <input type="text" name="stat_services_label" class="form-control" value="{{ old('stat_services_label', $settings['stat_services_label'] ?? 'خدمة متخصصة') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== ABOUT ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-lines-fill me-2"></i>قسم من أنا (About)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">نص الشارة (Tag)</label>
                            <input type="text" name="about_tag" class="form-control" value="{{ old('about_tag', $settings['about_tag'] ?? 'من أنا') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص التحية</label>
                            <input type="text" name="about_greeting" class="form-control" value="{{ old('about_greeting', $settings['about_greeting'] ?? 'مرحباً، أنا') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص زر "تواصل معي"</label>
                            <input type="text" name="about_btn_contact" class="form-control" value="{{ old('about_btn_contact', $settings['about_btn_contact'] ?? 'تواصل معي') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص زر "أعمالي"</label>
                            <input type="text" name="about_btn_projects" class="form-control" value="{{ old('about_btn_projects', $settings['about_btn_projects'] ?? 'أعمالي') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">النص التعريفي</label>
                            <textarea name="about_text" class="form-control" rows="5">{{ old('about_text', $settings['about_text'] ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">المهارات التقنية</label>
                            <textarea name="skills" class="form-control" rows="7" dir="ltr" placeholder="bi-filetype-php|PHP & Laravel&#10;bi-filetype-js|JavaScript & Vue.js&#10;bi-database|MySQL & PostgreSQL&#10;bi-git|Git & DevOps&#10;bi-phone|Flutter & Mobile&#10;bi-server|REST API & GraphQL">{{ old('skills', $settings['skills'] ?? '') }}</textarea>
                            <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.4rem;">
                                كل مهارة في سطر منفصل بصيغة: <code>اسم-الأيقونة|اسم المهارة</code><br>
                                مثال: <code>bi-filetype-php|PHP & Laravel</code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">صورة قسم "من أنا"</label>
                            @if($settings['about_image'] ?? null)
                                <div class="mb-2"><img src="{{ asset('storage/'.$settings['about_image']) }}" style="height:70px;border-radius:8px;object-fit:cover;"></div>
                            @endif
                            <input type="file" name="about_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== SECTIONS TITLES ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-type me-2"></i>عناوين الأقسام</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">شارة قسم الخدمات</label>
                            <input type="text" name="services_tag" class="form-control" value="{{ old('services_tag', $settings['services_tag'] ?? 'ماذا أقدم') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان قسم الخدمات</label>
                            <input type="text" name="services_title" class="form-control" value="{{ old('services_title', $settings['services_title'] ?? 'خدماتي المتخصصة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">شارة قسم الأعمال</label>
                            <input type="text" name="projects_tag" class="form-control" value="{{ old('projects_tag', $settings['projects_tag'] ?? 'معرض الأعمال') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان قسم الأعمال</label>
                            <input type="text" name="projects_title" class="form-control" value="{{ old('projects_title', $settings['projects_title'] ?? 'أبرز أعمالي') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">شارة قسم التواصل</label>
                            <input type="text" name="contact_tag" class="form-control" value="{{ old('contact_tag', $settings['contact_tag'] ?? 'تواصل معي') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">عنوان قسم التواصل</label>
                            <input type="text" name="contact_title" class="form-control" value="{{ old('contact_title', $settings['contact_title'] ?? 'لنتحدث عن مشروعك') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نص عنوان فورم التواصل</label>
                            <input type="text" name="contact_form_title" class="form-control" value="{{ old('contact_form_title', $settings['contact_form_title'] ?? 'أرسل لي رسالة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نص زر الإرسال</label>
                            <input type="text" name="contact_btn" class="form-control" value="{{ old('contact_btn', $settings['contact_btn'] ?? 'إرسال الرسالة') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تصفية: الكل</label>
                            <input type="text" name="filter_all" class="form-control" value="{{ old('filter_all', $settings['filter_all'] ?? 'الكل') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تصفية: ويب</label>
                            <input type="text" name="filter_web" class="form-control" value="{{ old('filter_web', $settings['filter_web'] ?? 'مواقع ويب') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تصفية: موبايل</label>
                            <input type="text" name="filter_mobile" class="form-control" value="{{ old('filter_mobile', $settings['filter_mobile'] ?? 'تطبيقات موبايل') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تسمية "مميز" في المشاريع</label>
                            <input type="text" name="featured_label" class="form-control" value="{{ old('featured_label', $settings['featured_label'] ?? 'مميز') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">نص منصات التواصل الاجتماعي</label>
                            <input type="text" name="social_label" class="form-control" value="{{ old('social_label', $settings['social_label'] ?? 'تابعني على منصات التواصل الاجتماعي') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== CONTACT INFO ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-telephone-fill me-2"></i>معلومات التواصل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">عنوان كارت التواصل</label>
                            <input type="text" name="contact_info_title" class="form-control" value="{{ old('contact_info_title', $settings['contact_info_title'] ?? 'معلومات التواصل') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الموقع الجغرافي</label>
                            <input type="text" name="contact_location" class="form-control" value="{{ old('contact_location', $settings['contact_location'] ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== SEO ====== --}}
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-search me-2"></i>إعدادات SEO</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">عنوان الصفحة (Meta Title)</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">وصف الصفحة (Meta Description)</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== SAVE ====== --}}
        <div class="col-12">
            <button type="submit" class="btn-primary-admin" style="padding:0.85rem 2.5rem;font-size:1rem;">
                <i class="bi bi-check-circle-fill"></i> حفظ جميع الإعدادات
            </button>
        </div>
    </div>
</form>
@endsection
