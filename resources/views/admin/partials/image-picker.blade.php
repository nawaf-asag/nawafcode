{{--
    Reusable image picker.
    Props:
      $name      — base form name (e.g. "hero_image" or "logo" or "image")
      $current   — current stored relative path or null
      $label     — label text
      $accept    — accept attribute (default: image/*)
--}}
@php
    $current = $current ?? null;
    $accept  = $accept ?? 'image/*';
    $label   = $label ?? 'الصورة';
    $previewId = 'pv_' . md5($name);
@endphp
<div class="image-picker" data-image-picker>
    <label class="form-label">{{ $label }}</label>

    {{-- Preview --}}
    <div class="image-picker-preview" id="{{ $previewId }}">
        @if($current)
            <img src="{{ asset('storage/'.$current) }}" alt="">
        @else
            <span class="image-picker-empty"><i class="bi bi-image"></i> لا توجد صورة</span>
        @endif
    </div>

    {{-- Hidden input that holds the chosen library path --}}
    <input type="hidden" name="{{ $name }}_path" value="{{ $current }}" data-picker-hidden>

    {{-- Direct upload (still works) --}}
    <input type="file" name="{{ $name }}" class="form-control mt-2" accept="{{ $accept }}" data-picker-file>

    <div class="d-flex gap-2 mt-2 flex-wrap">
        <button type="button" class="btn-outline-admin btn-sm" data-open-picker="{{ $name }}">
            <i class="bi bi-images"></i> اختر من المكتبة
        </button>
        @if($current)
            <button type="button" class="btn-outline-admin btn-sm" data-clear-picker>
                <i class="bi bi-x-circle"></i> إزالة
            </button>
        @endif
    </div>
</div>
