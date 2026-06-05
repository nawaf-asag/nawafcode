@extends('layouts.admin')
@section('title', $experience->exists ? 'تعديل الخبرة' : 'إضافة خبرة')
@section('breadcrumb') / <a href="{{ route('admin.experiences.index') }}">الخبرة المهنية</a> / {{ $experience->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $experience->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $experience->exists ? 'تعديل الخبرة' : 'إضافة خبرة جديدة' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $experience->exists ? route('admin.experiences.update', $experience) : route('admin.experiences.store') }}" method="POST">
                    @csrf
                    @if($experience->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">المسمى الوظيفي — عربي *</label>
                            <input type="text" name="role" class="form-control" value="{{ old('role', $experience->role) }}" placeholder="مثال: مهندس دعم فني أول" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $experience->order ?? 0) }}" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Job Title — English</label>
                            <input type="text" name="role_en" class="form-control" dir="ltr" value="{{ old('role_en', $experience->role_en) }}" placeholder="e.g. Senior Support Engineer">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الجهة / الشركة — عربي *</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company', $experience->company) }}" placeholder="مثال: شركة الحلول النهائية — جدة" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company — English</label>
                            <input type="text" name="company_en" class="form-control" dir="ltr" value="{{ old('company_en', $experience->company_en) }}" placeholder="e.g. Final Solutions Co. — Jeddah">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">سنة البداية</label>
                            <input type="number" name="year_from" class="form-control" value="{{ old('year_from', $experience->year_from) }}" placeholder="2023" min="1990" max="2100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">سنة النهاية</label>
                            <input type="number" name="year_to" class="form-control" value="{{ old('year_to', $experience->year_to) }}" placeholder="2024" min="1990" max="2100">
                            <small style="color:var(--text-muted);">اتركها فارغة إذا كانت سنة واحدة</small>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="is_current" id="currentCheck" value="1"
                                    {{ old('is_current', $experience->is_current ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="currentCheck" style="color:var(--text);">وظيفة حالية (حتى الآن)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الوصف — عربي</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="وصف المهام والإنجازات...">{{ old('description', $experience->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description — English</label>
                            <textarea name="description_en" class="form-control" rows="5" dir="ltr" placeholder="Role description...">{{ old('description_en', $experience->description_en) }}</textarea>
                            <small style="color:var(--text-muted);">يستخدم العربي إذا تركتها فارغة</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label">التقنيات / الكلمات المفتاحية</label>
                            <input type="text" name="technologies" class="form-control" value="{{ old('technologies', $experience->technologies) }}" placeholder="مثال: Onyx ERP, Oracle, SQL Server">
                            <small style="color:var(--text-muted);">افصل بينها بفاصلة (,) — تظهر كوسوم</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $experience->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل (تظهر في الموقع)</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $experience->exists ? 'حفظ التغييرات' : 'إضافة الخبرة' }}
                            </button>
                            <a href="{{ route('admin.experiences.index') }}" class="btn-outline-admin">
                                <i class="bi bi-x"></i> إلغاء
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
