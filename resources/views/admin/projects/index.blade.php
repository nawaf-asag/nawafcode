@extends('layouts.admin')
@section('title','الأعمال')
@section('breadcrumb') / <span>الأعمال</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-grid-3x3-gap me-2"></i>إدارة الأعمال ({{ $projects->count() }})</span>
        <a href="{{ route('admin.projects.create') }}" class="btn-primary-admin">
            <i class="bi bi-plus-circle"></i> إضافة مشروع
        </a>
    </div>
    <div style="padding:0;">
        @if($projects->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-grid fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد مشاريع بعد
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>الفئة</th>
                    <th>السنة</th>
                    <th>التقنيات</th>
                    <th>مميز</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td style="color:var(--text-muted);">{{ $project->id }}</td>
                    <td>
                        @if($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}" style="width:48px;height:48px;border-radius:8px;object-fit:cover;">
                        @else
                            <div style="width:48px;height:48px;border-radius:8px;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;color:var(--primary);">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600;">{{ $project->title }}</td>
                    <td>
                        @switch($project->category)
                            @case('web') <span style="color:var(--secondary);font-size:0.85rem;">ويب</span> @break
                            @case('mobile') <span style="color:var(--accent);font-size:0.85rem;">موبايل</span> @break
                            @case('api') <span style="color:#a78bfa;font-size:0.85rem;">API</span> @break
                            @case('support') <span style="color:#34d399;font-size:0.85rem;"><i class="bi bi-headset me-1"></i>دعم فني</span> @break
                            @default {{ $project->category }}
                        @endswitch
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;white-space:nowrap;">
                        @if($project->year_from && $project->year_to)
                            {{ $project->year_from }} – {{ $project->year_to }}
                        @elseif($project->year_from)
                            {{ $project->year_from }} – <span style="color:var(--accent);">الآن</span>
                        @else
                            &mdash;
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.8rem;max-width:150px;">{{ Str::limit($project->technologies, 40) }}</td>
                    <td>
                        @if($project->featured)
                            <i class="bi bi-star-fill" style="color:var(--accent);"></i>
                        @else
                            <i class="bi bi-star" style="color:var(--text-muted);"></i>
                        @endif
                    </td>
                    <td>
                        @if($project->active)
                            <span class="badge-active">مفعّل</span>
                        @else
                            <span class="badge-inactive">معطّل</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-edit-admin">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
