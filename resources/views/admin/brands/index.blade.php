@extends('layouts.admin')
@section('title','البراندات')
@section('breadcrumb') / <span>البراندات</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-award-fill me-2"></i>إدارة البراندات ({{ $brands->count() }})</span>
        <a href="{{ route('admin.brands.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة براند
        </a>
    </div>
    <div style="padding:0;">
        @if($brands->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-award fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا يوجد براندات بعد
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الشعار</th>
                    <th>الاسم</th>
                    <th>المساهمة</th>
                    <th>الموقع</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td style="color:var(--text-muted);">{{ $brand->id }}</td>
                    <td>
                        <div style="width:60px;height:48px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;color:var(--text-muted);overflow:hidden;padding:4px;">
                            @if($brand->logo)
                                <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                            @else
                                <i class="bi bi-image" style="font-size:1.2rem;opacity:0.4;"></i>
                            @endif
                        </div>
                    </td>
                    <td style="font-weight:600;">{{ $brand->name }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ Str::limit($brand->contribution, 50) }}</td>
                    <td style="color:var(--text-muted);font-size:0.8rem;">
                        @if($brand->website && $brand->website !== '#')
                            <a href="{{ $brand->website }}" target="_blank" rel="noopener" style="color:var(--primary);">{{ Str::limit($brand->website, 30) }}</a>
                        @else &mdash; @endif
                    </td>
                    <td style="color:var(--text-muted);">{{ $brand->order }}</td>
                    <td>
                        @if($brand->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
