@extends('layouts.admin')
@section('title', $link->exists ? 'تعديل رابط' : 'إضافة رابط')
@section('breadcrumb') / <a href="{{ route('admin.socials.index') }}">التواصل الاجتماعي</a> / {{ $link->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $link->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $link->exists ? 'تعديل الرابط' : 'إضافة رابط جديد' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $link->exists ? route('admin.socials.update', $link) : route('admin.socials.store') }}" method="POST">
                    @csrf
                    @if($link->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المنصة *</label>
                            <input type="text" name="platform" class="form-control" value="{{ old('platform', $link->platform) }}" placeholder="مثال: GitHub" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $link->order ?? 0) }}" min="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label">رابط الصفحة *</label>
                            <input type="url" name="url" class="form-control" value="{{ old('url', $link->url) }}" placeholder="https://..." required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">أيقونة Bootstrap Icons *</label>
                            <div class="d-flex gap-2">
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $link->icon ?? 'bi-link') }}" placeholder="مثال: bi-github" id="iconInput" required>
                                <div style="width:46px;height:46px;border-radius:10px;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--primary);flex-shrink:0;">
                                    <i class="bi {{ old('icon', $link->icon ?? 'bi-link') }}" id="iconEl"></i>
                                </div>
                            </div>
                            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.4rem;">
                                أمثلة: bi-github, bi-linkedin, bi-twitter-x, bi-whatsapp, bi-telegram, bi-instagram, bi-youtube
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $link->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل الرابط</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $link->exists ? 'حفظ التغييرات' : 'إضافة الرابط' }}
                            </button>
                            <a href="{{ route('admin.socials.index') }}" class="btn-outline-admin">
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
