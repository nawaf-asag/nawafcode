@extends('layouts.admin')
@section('title','إدارة SEO')
@section('breadcrumb') / <span>إدارة SEO</span> @endsection

@php
    $val   = fn($key, $default = '') => old($key,        $rows[$key]->value    ?? $default);
    $valEn = fn($key, $default = '') => old($key.'_en',   $rows[$key]->value_en ?? $default);
    $img   = fn($key) => $rows[$key]->value ?? null;
    $siteUrl = url('/');
@endphp

@section('content')
<form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <ul class="nav nav-pills seo-tabs mb-4" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#seo-basics" type="button"><i class="bi bi-google me-1"></i> نتيجة جوجل</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#seo-social" type="button"><i class="bi bi-share me-1"></i> مشاركة اجتماعية</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#seo-identity" type="button"><i class="bi bi-person-badge me-1"></i> الهوية والأيقونة</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#seo-verify" type="button"><i class="bi bi-patch-check me-1"></i> التحقق والربط</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#seo-archive" type="button"><i class="bi bi-diagram-3 me-1"></i> الأرشفة</button></li>
    </ul>

    <div class="tab-content">

        {{-- ============== BASICS + LIVE SERP ============== --}}
        <div class="tab-pane fade show active" id="seo-basics">
            {{-- Live Google preview --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-eye me-2"></i>معاينة حيّة لنتيجة جوجل</span>
                    <span style="font-size:0.78rem;color:var(--text-muted);">هكذا يظهر موقعك تقريباً في نتائج البحث</span>
                </div>
                <div class="admin-card-body">
                    <div class="serp-preview">
                        <div class="serp-url">{{ $siteUrl }}</div>
                        <div class="serp-title" id="serpTitle">{{ $val('meta_title', 'نواف عساج - مطور برمجيات Full Stack') }}</div>
                        <div class="serp-desc" id="serpDesc">{{ $val('meta_description', 'نواف عساج — مطور برمجيات متخصص في Laravel وReact وFlutter.') }}</div>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-input-cursor-text me-2"></i>العناوين والأوصاف</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">عنوان الصفحة (Title) — عربي</label>
                            <input type="text" name="meta_title" id="metaTitle" class="form-control seo-count" data-max="60"
                                   value="{{ $val('meta_title', 'نواف عساج - مطور برمجيات Full Stack') }}" placeholder="نواف عساج - مطور برمجيات">
                            <small class="seo-counter" style="color:var(--text-muted);">0/60</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title — English</label>
                            <input type="text" name="meta_title_en" class="form-control seo-count" data-max="60" dir="ltr"
                                   value="{{ $valEn('meta_title', 'Nawaf Asag - Full Stack Developer') }}" placeholder="Nawaf Asag - Full Stack Developer">
                            <small class="seo-counter" style="color:var(--text-muted);">0/60</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وصف الموقع (Description) — عربي</label>
                            <textarea name="meta_description" id="metaDesc" class="form-control seo-count" data-max="160" rows="3">{{ $val('meta_description', 'نواف عساج — مطور برمجيات متخصص في Laravel وReact وFlutter. أبني تطبيقات ويب وموبايل احترافية وعالية الأداء.') }}</textarea>
                            <small class="seo-counter" style="color:var(--text-muted);">0/160</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description — English</label>
                            <textarea name="meta_description_en" class="form-control seo-count" data-max="160" rows="3" dir="ltr">{{ $valEn('meta_description', 'Nawaf Asag — Full Stack Developer specialized in Laravel, React, and Flutter. Building professional, high-performance web and mobile applications.') }}</textarea>
                            <small class="seo-counter" style="color:var(--text-muted);">0/160</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">كلمات مفتاحية (Keywords) — عربي</label>
                            <textarea name="meta_keywords" class="form-control" rows="2">{{ $val('meta_keywords', 'مطور برمجيات, Laravel, React, تطوير ويب, تطبيقات موبايل, Full Stack') }}</textarea>
                            <small style="color:var(--text-muted);">افصل بفاصلة. الأهم هو محتوى الصفحات، لا حشو الكلمات.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keywords — English</label>
                            <textarea name="meta_keywords_en" class="form-control" rows="2" dir="ltr">{{ $valEn('meta_keywords', 'software developer, Laravel, React, web development, mobile apps, Full Stack') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== SOCIAL ============== --}}
        <div class="tab-pane fade" id="seo-social">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-window me-2"></i>معاينة بطاقة المشاركة</span>
                </div>
                <div class="admin-card-body">
                    <div class="social-card-preview">
                        <div class="social-card-img">
                            @if($img('og_image'))
                                <img src="{{ asset('storage/'.$img('og_image')) }}" alt="">
                            @else
                                <span><i class="bi bi-image"></i> 1200×630</span>
                            @endif
                        </div>
                        <div class="social-card-body">
                            <div class="social-card-domain" dir="ltr">{{ parse_url($siteUrl, PHP_URL_HOST) }}</div>
                            <div class="social-card-title" id="ogTitlePv">{{ $val('og_title') ?: $val('meta_title', 'نواف عساج') }}</div>
                            <div class="social-card-desc" id="ogDescPv">{{ $val('og_description') ?: $val('meta_description') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-share me-2"></i>Open Graph & Twitter</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            @include('admin.partials.image-picker', [
                                'name'    => 'og_image',
                                'current' => $img('og_image'),
                                'label'   => 'صورة المشاركة الاجتماعية (OG Image)',
                            ])
                            <small style="color:var(--text-muted);">1200×630 — تظهر عند مشاركة الرابط في تويتر/فيسبوك/واتساب</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">حساب تويتر / X (بدون @)</label>
                            <input type="text" name="twitter_handle" class="form-control" dir="ltr"
                                   value="{{ $val('twitter_handle') }}" placeholder="username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">عنوان OG — عربي</label>
                            <input type="text" name="og_title" id="ogTitle" class="form-control" value="{{ $val('og_title') }}" placeholder="يأخذ من Title إن تُرك فارغاً">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OG Title — English</label>
                            <input type="text" name="og_title_en" class="form-control" dir="ltr" value="{{ $valEn('og_title') }}" placeholder="Falls back to Title if empty">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وصف OG — عربي</label>
                            <textarea name="og_description" id="ogDesc" class="form-control" rows="2">{{ $val('og_description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OG Description — English</label>
                            <textarea name="og_description_en" class="form-control" rows="2" dir="ltr">{{ $valEn('og_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== IDENTITY ============== --}}
        <div class="tab-pane fade" id="seo-identity">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-badge me-2"></i>هوية الموقع</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            @include('admin.partials.image-picker', [
                                'name'    => 'site_favicon',
                                'current' => $img('site_favicon'),
                                'label'   => 'أيقونة الموقع (Favicon)',
                                'accept'  => 'image/png,image/jpeg,image/svg+xml,image/webp,image/x-icon',
                            ])
                            <small style="color:var(--text-muted);">PNG/SVG شفاف، 512×512 موصى به</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اسم المؤلف / العلامة</label>
                            <input type="text" name="site_author" class="form-control" dir="ltr" value="{{ $val('site_author', 'Nawaf Asag') }}">

                            <label class="form-label mt-3">المسمى الوظيفي (للبيانات المنظمة Schema)</label>
                            <input type="text" name="job_title_en" class="form-control" dir="ltr" value="{{ $val('job_title_en', 'Full Stack Developer') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== VERIFY + ANALYTICS ============== --}}
        <div class="tab-pane fade" id="seo-verify">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-patch-check me-2"></i>التحقق من الملكية والتحليلات</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Google Search Console — كود التحقق</label>
                            <input type="text" name="gsc_verification" class="form-control" dir="ltr"
                                   value="{{ $val('gsc_verification') }}" placeholder="google-site-verification content">
                            <small style="color:var(--text-muted);">من <a href="https://search.google.com/search-console" target="_blank" style="color:var(--primary);">Search Console</a> → طريقة وسم HTML — انسخ قيمة <code>content</code> فقط.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bing Webmaster — كود التحقق</label>
                            <input type="text" name="bing_verification" class="form-control" dir="ltr"
                                   value="{{ $val('bing_verification') }}" placeholder="msvalidate.01 content">
                        </div>

                        <div class="col-12"><hr style="border-color:rgba(99,102,241,0.15);"></div>

                        <div class="col-md-6">
                            <label class="form-label">Google Analytics 4 — معرّف القياس</label>
                            <input type="text" name="ga4_id" class="form-control" dir="ltr"
                                   value="{{ $val('ga4_id') }}" placeholder="G-XXXXXXXXXX">
                            <small style="color:var(--text-muted);">من <a href="https://analytics.google.com" target="_blank" style="color:var(--primary);">Google Analytics</a> → Admin → Data Streams. يبدأ بـ <code>G-</code>.</small>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <a href="{{ route('admin.analytics') }}" class="btn-outline-admin">
                                <i class="bi bi-graph-up-arrow"></i> فتح صفحة التحليلات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== ARCHIVE ============== --}}
        <div class="tab-pane fade" id="seo-archive">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-diagram-3 me-2"></i>خريطة الموقع وملف الروبوت</span>
                </div>
                <div class="admin-card-body">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn-outline-admin"><i class="bi bi-filetype-xml"></i> عرض sitemap.xml</a>
                        <a href="{{ url('/robots.txt') }}" target="_blank" class="btn-outline-admin"><i class="bi bi-robot"></i> عرض robots.txt</a>
                    </div>
                    <p style="color:var(--text-muted);font-size:0.85rem;margin:1rem 0 0;">
                        تُحدَّث خريطة الموقع تلقائياً وتشمل الصفحة الرئيسية وكل صفحة خدمة (عربي + إنجليزي). قدّم الرابط <code dir="ltr">{{ url('/sitemap.xml') }}</code> في Search Console لتسريع الأرشفة.
                    </p>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-collection me-2"></i>صفحات الخدمات المؤرشفة ({{ $services->count() }})</span>
                </div>
                <div class="admin-card-body">
                    @if($services->count())
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead><tr><th>الخدمة</th><th>الرابط</th><th></th></tr></thead>
                            <tbody>
                                @foreach($services as $s)
                                <tr>
                                    <td>{{ $s->title }}</td>
                                    <td dir="ltr"><code>/services/{{ $s->slug }}</code></td>
                                    <td class="text-end">
                                        <a href="{{ url('/services/'.$s->slug) }}" target="_blank" class="btn-edit-admin"><i class="bi bi-box-arrow-up-left"></i> فتح</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p style="color:var(--text-muted);margin:0;">لا توجد خدمات فعّالة بعد. أضف خدمات من قسم <a href="{{ route('admin.services.index') }}" style="color:var(--primary);">الخدمات</a> لتظهر هنا كصفحات مؤرشفة.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex gap-3 mt-4 sticky-bottom" style="background:var(--dark);padding:1rem 0;bottom:0;">
        <button type="submit" class="btn-primary-admin"><i class="bi bi-check-circle"></i> حفظ إعدادات SEO</button>
        <a href="{{ route('admin.dashboard') }}" class="btn-outline-admin"><i class="bi bi-x"></i> إلغاء</a>
    </div>
</form>
@endsection

@section('scripts')
<style>
    .seo-tabs .nav-link { color: var(--text-muted); border:1px solid rgba(99,102,241,0.15); background:var(--dark-2); font-family:'Cairo',sans-serif; font-weight:600; font-size:0.86rem; margin-inline-end:0.4rem; margin-bottom:0.4rem; }
    .seo-tabs .nav-link.active { background: var(--gradient); color:#fff; border-color:transparent; }
    .seo-tabs .nav-link:hover:not(.active) { color: var(--primary); }

    /* Google SERP preview */
    .serp-preview { background:#fff; border-radius:12px; padding:1.2rem 1.4rem; max-width:600px; direction:ltr; text-align:left; }
    .serp-url { color:#202124; font-size:0.82rem; }
    .serp-title { color:#1a0dab; font-size:1.25rem; line-height:1.3; margin:0.15rem 0; font-family:arial,sans-serif; }
    .serp-desc { color:#4d5156; font-size:0.88rem; line-height:1.5; font-family:arial,sans-serif; }

    /* Social card preview */
    .social-card-preview { max-width:500px; border:1px solid rgba(99,102,241,0.2); border-radius:14px; overflow:hidden; background:var(--dark); }
    .social-card-img { aspect-ratio:1200/630; background:rgba(99,102,241,0.08); display:flex; align-items:center; justify-content:center; color:var(--text-muted); }
    .social-card-img img { width:100%; height:100%; object-fit:cover; }
    .social-card-body { padding:0.9rem 1.1rem; }
    .social-card-domain { color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; }
    .social-card-title { color:var(--text); font-weight:700; font-size:1rem; margin:0.2rem 0; }
    .social-card-desc { color:var(--text-muted); font-size:0.85rem; }

    .seo-counter.warn { color:#fcd34d !important; }
    .seo-counter.over { color:#fca5a5 !important; }
</style>
<script>
(function () {
    // Live SERP + social preview
    var bind = function (inputId, targetId, fallback) {
        var i = document.getElementById(inputId), t = document.getElementById(targetId);
        if (!i || !t) return;
        var upd = function () { t.textContent = (i.value || fallback || '').trim(); };
        i.addEventListener('input', upd);
    };
    bind('metaTitle', 'serpTitle', 'عنوان الموقع');
    bind('metaDesc',  'serpDesc',  'وصف الموقع');

    var ogT = document.getElementById('ogTitle'), ogTpv = document.getElementById('ogTitlePv'), mt = document.getElementById('metaTitle');
    var ogD = document.getElementById('ogDesc'),  ogDpv = document.getElementById('ogDescPv'),  md = document.getElementById('metaDesc');
    var syncOgT = function () { if (ogTpv) ogTpv.textContent = (ogT.value || (mt ? mt.value : '') || '').trim(); };
    var syncOgD = function () { if (ogDpv) ogDpv.textContent = (ogD.value || (md ? md.value : '') || '').trim(); };
    if (ogT) ogT.addEventListener('input', syncOgT);
    if (ogD) ogD.addEventListener('input', syncOgD);

    // Character counters
    document.querySelectorAll('.seo-count').forEach(function (el) {
        var counter = el.parentElement.querySelector('.seo-counter');
        if (!counter) return;
        var max = parseInt(el.getAttribute('data-max'), 10) || 60;
        var upd = function () {
            var n = el.value.length;
            counter.textContent = n + '/' + max;
            counter.classList.toggle('warn', n > max && n <= max + 15);
            counter.classList.toggle('over', n > max + 15);
        };
        el.addEventListener('input', upd);
        upd();
    });
})();
</script>
@endsection
