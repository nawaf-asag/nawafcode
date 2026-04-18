@extends('layouts.admin')
@section('title','لوحة التحكم')

@section('content')

<!-- Stats -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
            <div class="stat-number">{{ $stats['services'] }}</div>
            <div class="stat-label">الخدمات</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(6,182,212,0.15);color:var(--secondary);"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <div class="stat-number">{{ $stats['projects'] }}</div>
            <div class="stat-label">الأعمال والمشاريع</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:var(--accent);"><i class="bi bi-envelope-fill"></i></div>
            <div class="stat-number">{{ $stats['contacts'] }}</div>
            <div class="stat-label">
                الرسائل
                @if($stats['unread'] > 0)
                    <span style="font-size:0.75rem;background:rgba(245,158,11,0.2);color:var(--accent);padding:0.1rem 0.5rem;border-radius:50px;">{{ $stats['unread'] }} غير مقروءة</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#34d399;"><i class="bi bi-share-fill"></i></div>
            <div class="stat-number">{{ $stats['socials'] }}</div>
            <div class="stat-label">روابط التواصل الاجتماعي</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-lightning-fill me-2" style="color:var(--accent);"></i>إجراءات سريعة</span>
            </div>
            <div class="admin-card-body">
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('admin.services.create') }}" class="btn-primary-admin">
                        <i class="bi bi-plus-circle"></i> إضافة خدمة
                    </a>
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary-admin">
                        <i class="bi bi-plus-circle"></i> إضافة مشروع
                    </a>
                    <a href="{{ route('admin.socials.create') }}" class="btn-primary-admin">
                        <i class="bi bi-plus-circle"></i> إضافة رابط اجتماعي
                    </a>
                    <a href="{{ route('admin.settings') }}" class="btn-outline-admin">
                        <i class="bi bi-gear"></i> إعدادات الموقع
                    </a>
                    <a href="{{ route('home') }}" class="btn-outline-admin" target="_blank">
                        <i class="bi bi-eye"></i> معاينة الموقع
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<div class="row g-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-envelope me-2"></i>آخر الرسائل</span>
                <a href="{{ route('admin.contacts.index') }}" class="btn-outline-admin" style="padding:0.3rem 0.8rem;font-size:0.8rem;">عرض الكل</a>
            </div>
            <div class="admin-card-body" style="padding:0;">
                @if($recentContacts->isEmpty())
                    <div style="padding:3rem;text-align:center;color:var(--text-muted);">
                        <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity:0.3;"></i>
                        لا توجد رسائل بعد
                    </div>
                @else
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>المرسل</th>
                            <th>الموضوع</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentContacts as $contact)
                        <tr>
                            <td>
                                <div style="font-weight:600;">{{ $contact->name }}</div>
                                <div style="font-size:0.8rem;color:var(--text-muted);">{{ $contact->email }}</div>
                            </td>
                            <td>{{ Str::limit($contact->subject, 40) }}</td>
                            <td style="color:var(--text-muted);font-size:0.85rem;">{{ $contact->created_at->diffForHumans() }}</td>
                            <td>
                                @if($contact->is_read)
                                    <span class="badge-read">مقروءة</span>
                                @else
                                    <span class="badge-unread">جديدة</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-edit-admin">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
