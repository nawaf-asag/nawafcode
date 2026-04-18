@extends('layouts.admin')
@section('title','الرسائل')
@section('breadcrumb') / <span>الرسائل</span> @endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title">
            <i class="bi bi-envelope me-2"></i>الرسائل الواردة ({{ $contacts->total() }})
        </span>
        @php $unread = \App\Models\Contact::where('is_read',false)->count(); @endphp
        @if($unread > 0)
            <span style="background:rgba(245,158,11,0.2);color:var(--accent);padding:0.3rem 0.8rem;border-radius:50px;font-size:0.85rem;font-weight:700;">{{ $unread }} رسائل غير مقروءة</span>
        @endif
    </div>
    <div style="padding:0;">
        @if($contacts->isEmpty())
        <div style="padding:4rem;text-align:center;color:var(--text-muted);">
            <i class="bi bi-inbox fs-1 d-block mb-2" style="opacity:0.3;"></i>
            لا توجد رسائل
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المرسل</th>
                    <th>الموضوع</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr style="{{ !$contact->is_read ? 'background:rgba(245,158,11,0.03);' : '' }}">
                    <td style="color:var(--text-muted);">{{ $contact->id }}</td>
                    <td>
                        <div style="font-weight:{{ !$contact->is_read ? '700' : '500' }};">{{ $contact->name }}</div>
                        <div style="font-size:0.8rem;color:var(--text-muted);">{{ $contact->email }}</div>
                    </td>
                    <td style="font-weight:{{ !$contact->is_read ? '600' : '400' }};">{{ Str::limit($contact->subject, 50) }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ $contact->created_at->format('Y/m/d H:i') }}</td>
                    <td>
                        @if($contact->is_read)
                            <span class="badge-read">مقروءة</span>
                        @else
                            <span class="badge-unread">جديدة</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-edit-admin">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-admin"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
