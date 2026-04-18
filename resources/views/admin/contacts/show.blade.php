@extends('layouts.admin')
@section('title','عرض الرسالة')
@section('breadcrumb') / <a href="{{ route('admin.contacts.index') }}">الرسائل</a> / عرض @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-envelope-open me-2"></i>تفاصيل الرسالة</span>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-admin"><i class="bi bi-trash"></i> حذف</button>
                </form>
            </div>
            <div class="admin-card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div style="color:var(--text-muted);font-size:0.8rem;margin-bottom:0.3rem;font-weight:700;text-transform:uppercase;">الاسم</div>
                        <div style="font-weight:700;font-size:1.1rem;">{{ $contact->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="color:var(--text-muted);font-size:0.8rem;margin-bottom:0.3rem;font-weight:700;text-transform:uppercase;">البريد الإلكتروني</div>
                        <a href="mailto:{{ $contact->email }}" style="color:var(--primary);font-weight:600;text-decoration:none;">{{ $contact->email }}</a>
                    </div>
                    <div class="col-md-8">
                        <div style="color:var(--text-muted);font-size:0.8rem;margin-bottom:0.3rem;font-weight:700;text-transform:uppercase;">الموضوع</div>
                        <div style="font-weight:600;">{{ $contact->subject }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="color:var(--text-muted);font-size:0.8rem;margin-bottom:0.3rem;font-weight:700;text-transform:uppercase;">التاريخ</div>
                        <div style="color:var(--text-muted);">{{ $contact->created_at->format('Y/m/d H:i') }}</div>
                    </div>
                </div>

                <div style="border-top:1px solid rgba(99,102,241,0.1);padding-top:1.5rem;">
                    <div style="color:var(--text-muted);font-size:0.8rem;margin-bottom:0.8rem;font-weight:700;text-transform:uppercase;">الرسالة</div>
                    <div style="background:rgba(99,102,241,0.05);border:1px solid rgba(99,102,241,0.1);border-radius:12px;padding:1.5rem;line-height:2;white-space:pre-wrap;">{{ $contact->message }}</div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn-primary-admin">
                        <i class="bi bi-reply"></i> الرد عبر البريد
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="btn-outline-admin">
                        <i class="bi bi-arrow-right"></i> العودة للرسائل
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
