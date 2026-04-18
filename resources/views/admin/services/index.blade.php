@extends('layouts.admin')
@section('title','الخدمات')
@section('breadcrumb') / <span>الخدمات</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-briefcase me-2"></i>إدارة الخدمات ({{ $services->count() }})</span>
        <a href="{{ route('admin.services.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة خدمة
        </a>
    </div>
    <div style="padding:0;">
        @if($services->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-briefcase fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد خدمات بعد
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الأيقونة</th>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td style="color:var(--text-muted);">{{ $service->id }}</td>
                    <td>
                        <div style="width:40px;height:40px;border-radius:10px;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--primary);">
                            <i class="bi {{ $service->icon }}"></i>
                        </div>
                    </td>
                    <td style="font-weight:600;">{{ $service->title }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ Str::limit($service->description, 60) }}</td>
                    <td style="color:var(--text-muted);">{{ $service->order }}</td>
                    <td>
                        @if($service->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-admin"><i class="bi bi-trash"></i> حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
