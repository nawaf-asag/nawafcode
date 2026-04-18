@extends('layouts.admin')
@section('title','التواصل الاجتماعي')
@section('breadcrumb') / <span>التواصل الاجتماعي</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-share me-2"></i>روابط التواصل الاجتماعي ({{ $links->count() }})</span>
        <a href="{{ route('admin.socials.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة رابط
        </a>
    </div>
    <div style="padding:0;">
        @if($links->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-share fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد روابط
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الأيقونة</th>
                    <th>المنصة</th>
                    <th>الرابط</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($links as $link)
                <tr>
                    <td>
                        <div style="width:40px;height:40px;border-radius:10px;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--primary);">
                            <i class="bi {{ $link->icon }}"></i>
                        </div>
                    </td>
                    <td style="font-weight:600;">{{ $link->platform }}</td>
                    <td><a href="{{ $link->url }}" target="_blank" style="color:var(--primary);font-size:0.85rem;text-decoration:none;">{{ Str::limit($link->url, 40) }}</a></td>
                    <td style="color:var(--text-muted);">{{ $link->order }}</td>
                    <td>
                        @if($link->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.socials.edit', $link) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.socials.destroy', $link) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
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
