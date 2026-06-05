@extends('layouts.admin')
@section('title', $education->exists ? 'تعديل المؤهل' : 'إضافة مؤهل')
@section('breadcrumb') / <a href="{{ route('admin.education.index') }}">التعليم الأكاديمي</a> / {{ $education->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $education->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $education->exists ? 'تعديل المؤهل' : 'إضافة مؤهل جديد' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $education->exists ? route('admin.education.update', $education) : route('admin.education.store') }}" method="POST">
                    @csrf
                    @if($education->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">المؤهل / الدرجة — عربي *</label>
                            <input type="text" name="degree" class="form-control" value="{{ old('degree', $education->degree) }}" placeholder="مثال: بكالوريوس في هندسة البرمجيات" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $education->order ?? 0) }}" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Degree — English</label>
                            <input type="text" name="degree_en" class="form-control" dir="ltr" value="{{ old('degree_en', $education->degree_en) }}" placeholder="e.g. Bachelor's in Software Engineering">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الجامعة / الجهة — عربي *</label>
                            <input type="text" name="institution" class="form-control" value="{{ old('institution', $education->institution) }}" placeholder="مثال: جامعة العلوم والتكنولوجيا — صنعاء" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Institution — English</label>
                            <input type="text" name="institution_en" class="form-control" dir="ltr" value="{{ old('institution_en', $education->institution_en) }}" placeholder="e.g. University of Science & Technology">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">سنة البداية</label>
                            <input type="number" name="year_from" class="form-control" value="{{ old('year_from', $education->year_from) }}" placeholder="2020" min="1990" max="2100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">سنة النهاية</label>
                            <input type="number" name="year_to" class="form-control" value="{{ old('year_to', $education->year_to) }}" placeholder="2021" min="1990" max="2100">
                            <small style="color:var(--text-muted);">اتركها فارغة إذا كانت سنة واحدة</small>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="is_current" id="currentCheck" value="1"
                                    {{ old('is_current', $education->is_current ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="currentCheck" style="color:var(--text);">ما زال مستمراً (حتى الآن)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">التقدير / ملاحظة — عربي</label>
                            <input type="text" name="note" class="form-control" value="{{ old('note', $education->note) }}" placeholder="مثال: تقدير امتياز مع مرتبة الشرف 92%">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Note / Grade — English</label>
                            <input type="text" name="note_en" class="form-control" dir="ltr" value="{{ old('note_en', $education->note_en) }}" placeholder="e.g. Excellent with Honors — GPA 92%">
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $education->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل (يظهر في الموقع)</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $education->exists ? 'حفظ التغييرات' : 'إضافة المؤهل' }}
                            </button>
                            <a href="{{ route('admin.education.index') }}" class="btn-outline-admin">
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
