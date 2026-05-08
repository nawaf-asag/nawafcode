{{-- Single shared picker modal — included once in admin layout --}}
<div id="mediaPickerModal" class="mp-modal" hidden>
    <div class="mp-overlay" data-close-picker></div>
    <div class="mp-dialog" role="dialog" aria-modal="true" aria-labelledby="mpTitle">
        <div class="mp-header">
            <h3 id="mpTitle"><i class="bi bi-images me-2"></i>اختر صورة من المكتبة</h3>
            <button type="button" class="mp-close" data-close-picker aria-label="إغلاق"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="mp-toolbar">
            <label class="mp-upload">
                <i class="bi bi-cloud-upload"></i> رفع صورة جديدة
                <input type="file" accept="image/*" id="mpUploadInput" hidden>
            </label>
            <input type="search" id="mpSearch" placeholder="ابحث بالاسم..." class="form-control" style="max-width:240px;">
            <span id="mpStatus" class="mp-status"></span>
        </div>

        <div class="mp-grid" id="mpGrid">
            <div class="mp-loader">جاري التحميل...</div>
        </div>
    </div>
</div>

{{-- CSRF token used by the picker JS --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.mp-modal {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
}
.mp-modal[hidden] { display: none; }

.mp-overlay {
    position: absolute; inset: 0;
    background: rgba(15, 23, 42, 0.78);
    backdrop-filter: blur(4px);
}

.mp-dialog {
    position: relative;
    background: var(--dark-2, #1e293b);
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 14px;
    width: min(900px, 95vw);
    max-height: 88vh;
    display: flex; flex-direction: column;
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    overflow: hidden;
}

.mp-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(99,102,241,0.15);
}
.mp-header h3 { margin: 0; color: var(--text, #e2e8f0); font-size: 1.05rem; font-weight: 700; font-family: 'Cairo', sans-serif; }
.mp-close {
    background: transparent; border: none; color: var(--text-muted, #94a3b8);
    font-size: 1.1rem; cursor: pointer; padding: 0.4rem; border-radius: 6px;
}
.mp-close:hover { background: rgba(99,102,241,0.15); color: var(--primary); }

.mp-toolbar {
    display: flex; gap: 0.75rem; padding: 0.85rem 1.25rem;
    border-bottom: 1px solid rgba(99,102,241,0.1);
    align-items: center; flex-wrap: wrap;
}
.mp-upload {
    background: var(--gradient, linear-gradient(135deg,#6366f1,#06b6d4));
    color: #fff; padding: 0.5rem 1rem; border-radius: 8px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-family: 'Cairo', sans-serif;
}
.mp-upload:hover { opacity: 0.9; }
.mp-status { color: var(--text-muted); font-size: 0.85rem; }

.mp-grid {
    padding: 1rem 1.25rem 1.25rem;
    overflow-y: auto; flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 0.8rem;
}
.mp-loader, .mp-empty {
    grid-column: 1 / -1;
    text-align: center; padding: 2.5rem; color: var(--text-muted);
}

.mp-tile {
    cursor: pointer;
    background: rgba(99,102,241,0.06);
    border: 2px solid transparent;
    border-radius: 10px;
    overflow: hidden;
    aspect-ratio: 1;
    position: relative;
    transition: all 0.2s ease;
}
.mp-tile:hover {
    border-color: var(--primary, #6366f1);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.3);
}
.mp-tile img { width: 100%; height: 100%; object-fit: cover; }
.mp-tile-name {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.85));
    color: #fff; padding: 1.5rem 0.5rem 0.4rem;
    font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    font-family: 'Cairo', sans-serif;
}

/* Image-picker preview (in form) */
.image-picker-preview {
    display: flex; align-items: center; justify-content: center;
    width: 100%; min-height: 110px;
    background: rgba(99,102,241,0.06);
    border: 2px dashed rgba(99,102,241,0.25);
    border-radius: 10px;
    overflow: hidden;
    padding: 0.5rem;
}
.image-picker-preview img {
    max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 6px;
}
.image-picker-empty { color: var(--text-muted); font-size: 0.88rem; }

.btn-outline-admin.btn-sm {
    padding: 0.35rem 0.85rem; font-size: 0.82rem;
}
</style>

<script>
(function () {
    const modal     = document.getElementById('mediaPickerModal');
    const grid      = document.getElementById('mpGrid');
    const status    = document.getElementById('mpStatus');
    const search    = document.getElementById('mpSearch');
    const upInput   = document.getElementById('mpUploadInput');
    if (!modal) return;

    let activePicker = null;   // the .image-picker container that opened the modal
    let cachedItems  = null;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const listUrl   = "{{ route('admin.media.picker.list') }}";
    const uploadUrl = "{{ route('admin.media.picker.upload') }}";
    const storageBase = "{{ asset('storage') }}";

    function open(picker) {
        activePicker = picker;
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        if (!cachedItems) loadList();
        else renderItems(cachedItems, '');
        search.value = '';
        search.focus();
    }
    function close() {
        modal.hidden = true;
        activePicker = null;
        document.body.style.overflow = '';
    }

    async function loadList() {
        grid.innerHTML = '<div class="mp-loader">جاري التحميل...</div>';
        try {
            const res = await fetch(listUrl, { credentials: 'same-origin' });
            const items = await res.json();
            cachedItems = items;
            renderItems(items, '');
        } catch (e) {
            grid.innerHTML = '<div class="mp-empty">تعذّر تحميل المكتبة</div>';
        }
    }

    function renderItems(items, q) {
        const filtered = q ? items.filter(it => (it.name || '').toLowerCase().includes(q.toLowerCase())) : items;
        if (!filtered.length) {
            grid.innerHTML = '<div class="mp-empty"><i class="bi bi-image fs-2 d-block mb-2" style="opacity:0.3;"></i>لا توجد صور. ارفع واحدة من الزر بالأعلى.</div>';
            return;
        }
        grid.innerHTML = filtered.map(it => `
            <div class="mp-tile" data-pick="${it.path}" data-url="${it.url}">
                <img src="${it.url}" alt="${(it.alt || it.name || '').replace(/"/g,'&quot;')}" loading="lazy">
                <div class="mp-tile-name">${it.name || ''}</div>
            </div>
        `).join('');
    }

    function pick(path, url) {
        if (!activePicker) return;
        const hidden = activePicker.querySelector('[data-picker-hidden]');
        const file   = activePicker.querySelector('[data-picker-file]');
        const preview= activePicker.querySelector('.image-picker-preview');

        if (hidden) hidden.value = path;
        if (file)   file.value = '';        // clear any pending file
        if (preview) preview.innerHTML = `<img src="${url}" alt="">`;
        close();
    }

    async function uploadNew(file) {
        if (!file) return;
        status.textContent = 'جاري الرفع...';
        const fd = new FormData();
        fd.append('file', file);
        try {
            const res = await fetch(uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: fd, credentials: 'same-origin',
            });
            if (!res.ok) throw new Error('Upload failed');
            const data = await res.json();
            cachedItems = [data, ...(cachedItems || [])];
            renderItems(cachedItems, '');
            status.textContent = '✓ تم الرفع';
            setTimeout(() => status.textContent = '', 2000);
        } catch (e) {
            status.textContent = '✗ فشل الرفع';
            setTimeout(() => status.textContent = '', 2500);
        }
    }

    // Open modal
    document.addEventListener('click', (e) => {
        const opener = e.target.closest('[data-open-picker]');
        if (opener) {
            const picker = opener.closest('[data-image-picker]');
            if (picker) open(picker);
            return;
        }
        const closer = e.target.closest('[data-close-picker]');
        if (closer) { close(); return; }

        // Clear button on individual picker
        const clr = e.target.closest('[data-clear-picker]');
        if (clr) {
            const picker = clr.closest('[data-image-picker]');
            if (picker) {
                const hidden = picker.querySelector('[data-picker-hidden]');
                const file   = picker.querySelector('[data-picker-file]');
                const preview= picker.querySelector('.image-picker-preview');
                if (hidden) hidden.value = '';
                if (file)   file.value   = '';
                if (preview) preview.innerHTML = '<span class="image-picker-empty"><i class="bi bi-image"></i> لا توجد صورة</span>';
                clr.remove();
            }
            return;
        }

        // Pick a tile
        const tile = e.target.closest('.mp-tile');
        if (tile) pick(tile.dataset.pick, tile.dataset.url);
    });

    // Update preview when a file is selected directly (without library)
    document.addEventListener('change', (e) => {
        const file = e.target.closest('[data-picker-file]');
        if (file && file.files && file.files[0]) {
            const picker = file.closest('[data-image-picker]');
            const preview = picker?.querySelector('.image-picker-preview');
            const hidden  = picker?.querySelector('[data-picker-hidden]');
            if (hidden) hidden.value = '';   // a freshly uploaded file overrides library pick
            if (preview) {
                const url = URL.createObjectURL(file.files[0]);
                preview.innerHTML = `<img src="${url}" alt="">`;
            }
        }
    });

    // Search
    search?.addEventListener('input', () => {
        if (cachedItems) renderItems(cachedItems, search.value.trim());
    });

    // Upload from picker toolbar
    upInput?.addEventListener('change', () => uploadNew(upInput.files[0]));

    // Esc to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.hidden) close();
    });
})();
</script>
