@extends('layouts.admin')
@section('title','إعدادات الموقع')
@section('breadcrumb') / <span>الإعدادات</span> @endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">

        <!-- Hero Section -->
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
                            <label class="form-label">المسمى الوظيفي (عربي)</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">المسمى الوظيفي (إنجليزي)</label>
                            <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف القصير</label>
                            <textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">صورة الملف الشخصي</label>
                            @if($settings['hero_image'] ?? null)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$settings['hero_image']) }}" style="height:80px;border-radius:50%;object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رابط السيرة الذاتية (CV)</label>
                            <input type="text" name="cv_url" class="form-control" value="{{ old('cv_url', $settings['cv_url'] ?? '') }}" placeholder="https://...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-person-lines-fill me-2"></i>قسم من أنا (About)</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">النص التعريفي</label>
                            <textarea name="about_text" class="form-control" rows="5">{{ old('about_text', $settings['about_text'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">صورة قسم "من أنا"</label>
                            @if($settings['about_image'] ?? null)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$settings['about_image']) }}" style="height:80px;border-radius:8px;object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="about_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title"><i class="bi bi-telephone-fill me-2"></i>معلومات التواصل</span>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
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

        <!-- SEO -->
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

        <!-- Save -->
        <div class="col-12">
            <button type="submit" class="btn-primary-admin" style="padding:0.8rem 2.5rem;font-size:1rem;">
                <i class="bi bi-check-circle-fill"></i> حفظ جميع الإعدادات
            </button>
        </div>
    </div>
</form>
@endsection
