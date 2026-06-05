@extends('layouts.admin')
@section('title','التعليم الأكاديمي')
@section('breadcrumb') / <span>التعليم الأكاديمي</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-mortarboard me-2"></i>التعليم الأكاديمي ({{ $education->count() }})</span>
        <a href="{{ route('admin.education.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة مؤهل
        </a>
    </div>
    <div style="padding:0;">
        @if($education->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-mortarboard fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد مؤهلات بعد
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المؤهل</th>
                    <th>الجهة</th>
                    <th>الفترة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($education as $edu)
                <tr>
                    <td style="color:var(--text-muted);">{{ $edu->id }}</td>
                    <td style="font-weight:600;">{{ $edu->degree }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ $edu->institution }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $edu->year_from }}@if($edu->is_current) — حتى الآن @elseif($edu->year_to && $edu->year_to != $edu->year_from) — {{ $edu->year_to }} @endif
                    </td>
                    <td style="color:var(--text-muted);">{{ $edu->order }}</td>
                    <td>
                        @if($edu->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.education.edit', $edu) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.education.destroy', $edu) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
