@extends('layouts.admin')
@section('title', $service->exists ? 'تعديل الخدمة' : 'إضافة خدمة')
@section('breadcrumb') / <a href="{{ route('admin.services.index') }}">الخدمات</a> / {{ $service->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<form action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('PUT') @endif

    {{-- Tabs --}}
    <ul class="nav nav-pills service-tabs mb-4" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-basic" type="button"><i class="bi bi-info-circle me-1"></i> الأساسيات</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-content" type="button"><i class="bi bi-file-richtext me-1"></i> المحتوى الغني</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-seo" type="button"><i class="bi bi-search me-1"></i> SEO والأرشفة</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-faq" type="button"><i class="bi bi-patch-question me-1"></i> الأسئلة الشائعة</button></li>
    </ul>

    <div class="tab-content">

        {{-- ============== BASICS ============== --}}
        <div class="tab-pane fade show active" id="tab-basic">
            <div class="admin-card">
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">عنوان الخدمة — عربي *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" placeholder="مثال: تطوير الويب" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title — English</label>
                            <input type="text" name="title_en" class="form-control" dir="ltr" value="{{ old('title_en', $service->title_en) }}" placeholder="e.g. Web Development">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">الرابط (Slug)</label>
                            <input type="text" name="slug" class="form-control" dir="ltr" value="{{ old('slug', $service->slug) }}" placeholder="يُولّد تلقائياً من العنوان إن تُرك فارغاً">
                            <small style="color:var(--text-muted);">
                                رابط الصفحة: <code dir="ltr">/services/{{ $service->slug ?: 'اسم-الخدمة' }}</code>
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $service->order ?? 0) }}" min="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label">أيقونة Bootstrap Icons *</label>
                            <div class="d-flex gap-2">
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon ?? 'bi-code-slash') }}" placeholder="مثال: bi-code-slash" id="iconInput" required>
                                <div id="iconPreview" style="width:46px;height:46px;border-radius:10px;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--primary);flex-shrink:0;">
                                    <i class="bi {{ old('icon', $service->icon ?? 'bi-code-slash') }}" id="iconEl"></i>
                                </div>
                            </div>
                            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.4rem;">
                                تصفح الأيقونات على: <a href="https://icons.getbootstrap.com" target="_blank" style="color:var(--primary);">icons.getbootstrap.com</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الوصف المختصر — عربي *</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="وصف قصير يظهر في الكرت ونتائج البحث..." required>{{ old('description', $service->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Short description — English</label>
                            <textarea name="description_en" class="form-control" rows="4" dir="ltr" placeholder="Short description...">{{ old('description_en', $service->description_en) }}</textarea>
                            <small style="color:var(--text-muted);">يستخدم العربي إذا تركتها فارغة</small>
                        </div>

                        <div class="col-12">
                            @include('admin.partials.image-picker', [
                                'name'    => 'cover_image',
                                'current' => $service->cover_image,
                                'label'   => 'صورة الغلاف (تظهر في صفحة الخدمة والمشاركة)',
                            ])
                            <small style="color:var(--text-muted);">اختياري — 1200×630 موصى به</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $service->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل الخدمة (تظهر في الموقع وتُؤرشف)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== RICH CONTENT ============== --}}
        <div class="tab-pane fade" id="tab-content">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-file-richtext me-2"></i>المحتوى التفصيلي للصفحة</span>
                    <span style="font-size:0.78rem;color:var(--text-muted);">محتوى غني وطويل = تصدّر أفضل في جوجل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">المحتوى التفصيلي — عربي</label>
                            <textarea name="content" class="form-control" rows="12" placeholder="اكتب شرحاً وافياً للخدمة... يمكنك استخدام HTML مثل &lt;h2&gt; و&lt;p&gt; و&lt;ul&gt;&lt;li&gt;">{{ old('content', $service->content) }}</textarea>
                            <small style="color:var(--text-muted);">مسموح بوسوم HTML: عناوين h2/h3، فقرات p، قوائم ul/li، روابط، صور. ادمج كلماتك المفتاحية طبيعياً داخل النص.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Detailed content — English</label>
                            <textarea name="content_en" class="form-control" rows="12" dir="ltr" placeholder="Full service description (HTML allowed)...">{{ old('content_en', $service->content_en) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== SEO ============== --}}
        <div class="tab-pane fade" id="tab-seo">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-search me-2"></i>إعدادات ظهور الصفحة في جوجل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">عنوان الصفحة (Meta Title) — عربي</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $service->meta_title) }}" placeholder="يأخذ عنوان الخدمة إن تُرك فارغاً" maxlength="200">
                            <small style="color:var(--text-muted);">يُفضّل 50-60 حرف</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Title — English</label>
                            <input type="text" name="meta_title_en" class="form-control" dir="ltr" value="{{ old('meta_title_en', $service->meta_title_en) }}" maxlength="200">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وصف الصفحة (Meta Description) — عربي</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="500" placeholder="يأخذ الوصف المختصر إن تُرك فارغاً">{{ old('meta_description', $service->meta_description) }}</textarea>
                            <small style="color:var(--text-muted);">يُفضّل 150-160 حرف</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Description — English</label>
                            <textarea name="meta_description_en" class="form-control" rows="3" dir="ltr" maxlength="500">{{ old('meta_description_en', $service->meta_description_en) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الكلمات المفتاحية — عربي</label>
                            <textarea name="keywords" class="form-control" rows="4" placeholder="كلمة1, كلمة2, كلمة3...">{{ old('keywords', $service->keywords) }}</textarea>
                            <small style="color:var(--text-muted);">افصل بينها بفاصلة. تظهر كوسوم في الصفحة وضمن البيانات المنظمة.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keywords — English</label>
                            <textarea name="keywords_en" class="form-control" rows="4" dir="ltr" placeholder="keyword1, keyword2, keyword3...">{{ old('keywords_en', $service->keywords_en) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== FAQ ============== --}}
        <div class="tab-pane fade" id="tab-faq">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-patch-question me-2"></i>الأسئلة الشائعة (تظهر كـ FAQ في جوجل)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الأسئلة والأجوبة — عربي</label>
                            <textarea name="faq" class="form-control" rows="8" placeholder="السؤال | الجواب&#10;سؤال آخر | جواب آخر">{{ old('faq', $service->faq) }}</textarea>
                            <small style="color:var(--text-muted);">كل سطر: <code>السؤال | الجواب</code></small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">FAQ — English</label>
                            <textarea name="faq_en" class="form-control" rows="8" dir="ltr" placeholder="Question | Answer&#10;Another question | Another answer">{{ old('faq_en', $service->faq_en) }}</textarea>
                            <small style="color:var(--text-muted);">Each line: <code>Question | Answer</code></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex gap-3 mt-4 sticky-bottom" style="background:var(--dark);padding:1rem 0;bottom:0;">
        <button type="submit" class="btn-primary-admin">
            <i class="bi bi-check-circle"></i>
            {{ $service->exists ? 'حفظ التغييرات' : 'إضافة الخدمة' }}
        </button>
        <a href="{{ route('admin.services.index') }}" class="btn-outline-admin">
            <i class="bi bi-x"></i> إلغاء
        </a>
    </div>
</form>
@endsection

@section('scripts')
<style>
    .service-tabs .nav-link { color: var(--text-muted); border:1px solid rgba(99,102,241,0.15); background:var(--dark-2); font-family:'Cairo',sans-serif; font-weight:600; font-size:0.88rem; margin-inline-end:0.5rem; }
    .service-tabs .nav-link.active { background: var(--gradient); color:#fff; border-color:transparent; }
    .service-tabs .nav-link:hover:not(.active) { color: var(--primary); }
</style>
<script>
document.getElementById('iconInput').addEventListener('input', function() {
    document.getElementById('iconEl').className = 'bi ' + this.value;
});
</script>
@endsection
