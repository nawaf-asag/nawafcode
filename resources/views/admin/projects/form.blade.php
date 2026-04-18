@extends('layouts.admin')
@section('title', $project->exists ? 'تعديل المشروع' : 'إضافة مشروع')
@section('breadcrumb') / <a href="{{ route('admin.projects.index') }}">الأعمال</a> / {{ $project->exists ? 'تعديل' : 'إضافة' }} @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="bi bi-{{ $project->exists ? 'pencil' : 'plus-circle' }} me-2"></i>
                    {{ $project->exists ? 'تعديل المشروع' : 'إضافة مشروع جديد' }}
                </span>
            </div>
            <div class="admin-card-body">
                <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($project->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">عنوان المشروع *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الترتيب</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $project->order ?? 0) }}" min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الفئة *</label>
                            <select name="category" class="form-select">
                                <option value="web" {{ old('category', $project->category) === 'web' ? 'selected' : '' }}>مواقع ويب</option>
                                <option value="mobile" {{ old('category', $project->category) === 'mobile' ? 'selected' : '' }}>تطبيقات موبايل</option>
                                <option value="api" {{ old('category', $project->category) === 'api' ? 'selected' : '' }}>API</option>
                                <option value="other" {{ old('category', $project->category) === 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">التقنيات المستخدمة</label>
                            <input type="text" name="technologies" class="form-control" value="{{ old('technologies', $project->technologies) }}" placeholder="Laravel, Vue.js, MySQL">
                            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.3rem;">افصل بين التقنيات بفاصلة ","</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">وصف المشروع *</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $project->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">رابط المشروع</label>
                            <input type="url" name="project_url" class="form-control" value="{{ old('project_url', $project->project_url) }}" placeholder="https://...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رابط GitHub</label>
                            <input type="url" name="github_url" class="form-control" value="{{ old('github_url', $project->github_url) }}" placeholder="https://github.com/...">
                        </div>

                        <div class="col-12">
                            <label class="form-label">صورة المشروع</label>
                            @if($project->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$project->image) }}" style="height:100px;border-radius:8px;object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.3rem;">الحجم الأقصى: 2MB - الصيغ: JPG, PNG, WebP</div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="activeCheck" value="1"
                                    {{ old('active', $project->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeCheck" style="color:var(--text);">تفعيل (يظهر في الموقع)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck" value="1"
                                    {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featuredCheck" style="color:var(--text);">
                                    <i class="bi bi-star-fill" style="color:var(--accent);"></i> مشروع مميز
                                </label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3 mt-2">
                            <button type="submit" class="btn-primary-admin">
                                <i class="bi bi-check-circle"></i>
                                {{ $project->exists ? 'حفظ التغييرات' : 'إضافة المشروع' }}
                            </button>
                            <a href="{{ route('admin.projects.index') }}" class="btn-outline-admin">
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
