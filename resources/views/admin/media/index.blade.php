@extends('layouts.admin')
@section('title','مكتبة الصور')
@section('breadcrumb') / <span>مكتبة الصور</span> @endsection

@section('content')
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <span class="admin-card-title">
            <i class="bi bi-cloud-upload me-2"></i>رفع صور جديدة
        </span>
        <span style="font-size:0.78rem;color:var(--text-muted);">يمكن اختيار عدة ملفات دفعة واحدة</span>
    </div>
    <div class="admin-card-body">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-3 align-items-end flex-wrap">
            @csrf
            <div class="flex-grow-1" style="min-width:240px;">
                <label class="form-label">اختر صورة (أو عدة صور)</label>
                <input type="file" name="files[]" class="form-control" accept="image/*" multiple required>
            </div>
            <div style="min-width:200px;">
                <label class="form-label">نص بديل (Alt) — اختياري</label>
                <input type="text" name="alt" class="form-control" placeholder="وصف مختصر للصورة">
            </div>
            <button type="submit" class="btn-primary-admin">
                <i class="bi bi-upload"></i> رفع
            </button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title">
            <i class="bi bi-images me-2"></i>الصور المرفوعة ({{ $items->total() }})
        </span>
    </div>

    <div class="admin-card-body">
        @if($items->isEmpty())
            <div style="padding:3rem;text-align:center;color:var(--text-muted);">
                <i class="bi bi-image fs-1 d-block mb-2" style="opacity:0.3;"></i>
                لا توجد صور بعد. ابدأ برفع صورتك الأولى.
            </div>
        @else
            <div class="media-grid">
                @foreach($items as $m)
                    <div class="media-tile">
                        <div class="media-tile-thumb">
                            <img src="{{ $m->url() }}" alt="{{ $m->alt ?: $m->original_name }}" loading="lazy">
                        </div>
                        <div class="media-tile-meta">
                            <div class="media-tile-name" title="{{ $m->original_name }}">{{ \Str::limit($m->original_name, 22) }}</div>
                            <div class="media-tile-size">{{ $m->humanSize() }}</div>
                        </div>
                        <div class="media-tile-actions">
                            <button type="button"
                                    class="btn-copy-admin"
                                    data-copy="{{ $m->path }}"
                                    title="نسخ المسار">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            <a href="{{ $m->url() }}" target="_blank" class="btn-view-admin" title="فتح الصورة">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <form action="{{ route('admin.media.destroy', $m) }}" method="POST"
                                  onsubmit="return confirm('حذف هذه الصورة؟ لا يمكن التراجع.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-admin" title="حذف"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: 1rem;
}
.media-tile {
    background: rgba(99, 102, 241, 0.06);
    border: 1px solid rgba(99, 102, 241, 0.15);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.media-tile-thumb {
    aspect-ratio: 1;
    background: rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.media-tile-thumb img {
    width: 100%; height: 100%; object-fit: cover;
}
.media-tile-meta {
    padding: 0.5rem 0.7rem;
    border-top: 1px solid rgba(99, 102, 241, 0.1);
    font-size: 0.78rem;
}
.media-tile-name {
    color: var(--text);
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.media-tile-size { color: var(--text-muted); font-size: 0.72rem; margin-top: 2px; }
.media-tile-actions {
    display: flex;
    gap: 0.3rem;
    padding: 0.5rem 0.6rem 0.7rem;
    justify-content: space-between;
    align-items: center;
}
.media-tile-actions form { display: inline; }
.btn-copy-admin, .btn-view-admin {
    background: rgba(99, 102, 241, 0.12);
    border: 1px solid rgba(99, 102, 241, 0.25);
    color: var(--primary);
    padding: 0.3rem 0.55rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.78rem;
    text-decoration: none;
    display: inline-flex; align-items: center; justify-content: center;
}
.btn-copy-admin:hover, .btn-view-admin:hover { background: var(--primary); color: #fff; }
.btn-copy-admin.copied { background: #10b981; border-color: #10b981; color: #fff; }
</style>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.btn-copy-admin').forEach(btn => {
    btn.addEventListener('click', async () => {
        const text = btn.dataset.copy;
        try {
            await navigator.clipboard.writeText(text);
            btn.classList.add('copied');
            const icon = btn.querySelector('i');
            const old = icon.className;
            icon.className = 'bi bi-check-lg';
            setTimeout(() => {
                btn.classList.remove('copied');
                icon.className = old;
            }, 1400);
        } catch (e) { console.error(e); }
    });
});
</script>
@endsection
