@extends('layouts.admin')
@section('title', $service->exists ? 'تعديل الخدمة' : 'إضافة خدمة')
@section('breadcrumb') / <a href="{{ route('admin.services.index') }}">الخدمات</a> / {{ $service->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $service->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $service->exists ? 'تعديل الخدمة' : 'إضافة خدمة جديدة' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST">
                    @csrf
                    @if($service->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">عنوان الخدمة — عربي *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" placeholder="مثال: تطوير الويب" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Title — English</label>
                            <input type="text" name="title_en" class="form-control" dir="ltr" value="{{ old('title_en', $service->title_en) }}" placeholder="e.g. Web Development">
                        </div>
                        <div class="col-md-2">
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
                            <label class="form-label">الوصف — عربي *</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="وصف الخدمة..." required>{{ old('description', $service->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description — English</label>
                            <textarea name="description_en" class="form-control" rows="5" dir="ltr" placeholder="Service description...">{{ old('description_en', $service->description_en) }}</textarea>
                            <small style="color:var(--text-muted);">يستخدم العربي إذا تركتها فارغة</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $service->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل الخدمة (تظهر في الموقع)</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $service->exists ? 'حفظ التغييرات' : 'إضافة الخدمة' }}
                            </button>
                            <a href="{{ route('admin.services.index') }}" class="btn-outline-admin">
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

@section('scripts')
<script>
document.getElementById('iconInput').addEventListener('input', function() {
    document.getElementById('iconEl').className = 'bi ' + this.value;
});
</script>
@endsection
