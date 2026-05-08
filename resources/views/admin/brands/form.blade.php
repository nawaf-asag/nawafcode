@extends('layouts.admin')
@section('title', $brand->exists ? 'تعديل البراند' : 'إضافة براند')
@section('breadcrumb') / <a href="{{ route('admin.brands.index') }}">البراندات</a> / {{ $brand->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $brand->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $brand->exists ? 'تعديل البراند' : 'إضافة براند جديد' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $brand->exists ? route('admin.brands.update', $brand) : route('admin.brands.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($brand->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">اسم البراند *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" placeholder="مثال: STC" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $brand->order ?? 0) }}" min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">المساهمة — عربي</label>
                            <input type="text" name="contribution" class="form-control"
                                   value="{{ old('contribution', $brand->contribution) }}"
                                   placeholder="مثال: تطوير لوحة التحكم الداخلية">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contribution — English</label>
                            <input type="text" name="contribution_en" class="form-control" dir="ltr"
                                   value="{{ old('contribution_en', $brand->contribution_en) }}"
                                   placeholder="e.g. Internal admin dashboard development">
                            <small style="color:var(--text-muted);">يستخدم العربي إذا تركته فارغاً</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label">رابط الموقع</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website', $brand->website) }}" placeholder="https://...">
                            <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.4rem;">
                                إذا أُضيف، تظهر علامة الرابط عند تمرير الماوس على الشعار في الموقع.
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">شعار البراند (صورة) *</label>
                            @if($brand->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}"
                                         style="max-width:140px;max-height:80px;background:#fff;padding:6px;border-radius:8px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*" {{ $brand->exists && $brand->logo ? '' : 'required' }}>
                            <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.4rem;">
                                PNG / SVG / JPG / WEBP — حتى 2 ميجا. (يُفضّل صورة شفافة بخلفية فارغة)
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $brand->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل البراند (يظهر في الموقع)</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $brand->exists ? 'حفظ التغييرات' : 'إضافة البراند' }}
                            </button>
                            <a href="{{ route('admin.brands.index') }}" class="btn-outline-admin">
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

