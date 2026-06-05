@extends('layouts.admin')
@section('title','الخبرة المهنية')
@section('breadcrumb') / <span>الخبرة المهنية</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-briefcase me-2"></i>الخبرة المهنية ({{ $experiences->count() }})</span>
        <a href="{{ route('admin.experiences.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة خبرة
        </a>
    </div>
    <div style="padding:0;">
        @if($experiences->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-briefcase fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد خبرات بعد
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المسمى الوظيفي</th>
                    <th>الجهة</th>
                    <th>الفترة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($experiences as $exp)
                <tr>
                    <td style="color:var(--text-muted);">{{ $exp->id }}</td>
                    <td style="font-weight:600;">{{ $exp->role }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ $exp->company }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $exp->year_from }}@if($exp->is_current) — حتى الآن @elseif($exp->year_to && $exp->year_to != $exp->year_from) — {{ $exp->year_to }} @endif
                    </td>
                    <td style="color:var(--text-muted);">{{ $exp->order }}</td>
                    <td>
                        @if($exp->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
