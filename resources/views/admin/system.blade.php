@extends('layouts.admin')
@section('title','تحديث النظام')
@section('breadcrumb') / <span>تحديث النظام</span> @endsection

@section('content')

{{-- Error flash (layout already renders success) --}}
@if(session('error'))
<div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- Command output --}}
@if(session('cmd_output'))
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-terminal me-2"></i>مخرجات الأمر: <code dir="ltr">{{ session('cmd_title') }}</code></span>
    </div>
    <div class="admin-card-body" style="padding:0;">
        <pre class="cmd-output" dir="ltr">{{ session('cmd_output') }}</pre>
    </div>
</div>
@endif

<div class="row g-4">

    {{-- ============== SYSTEM INFO ============== --}}
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-info-circle me-2"></i>معلومات النظام</span>
            </div>
            <div class="admin-card-body">
                <table class="sys-table">
                    <tr><td>الإصدار (Laravel)</td><td dir="ltr">{{ $env['laravel'] }}</td></tr>
                    <tr><td>PHP</td><td dir="ltr">{{ $env['php'] }}</td></tr>
                    <tr><td>البيئة</td><td dir="ltr">{{ $env['env'] }} @if($env['debug'])<span class="badge-unread">debug</span>@endif</td></tr>
                    <tr><td>قاعدة البيانات</td><td dir="ltr">{{ $env['db_conn'] }} — {{ $env['db_name'] }}</td></tr>
                    @if($git['available'])
                    <tr><td>الفرع (Branch)</td><td dir="ltr">{{ $git['branch'] }}</td></tr>
                    <tr><td>الإصدار الحالي</td><td dir="ltr"><code>{{ $git['commit'] }}</code></td></tr>
                    <tr><td>آخر تحديث</td><td>{{ $git['subject'] }} <span style="color:var(--text-muted);">({{ $git['when'] }})</span></td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- ============== FETCH UPDATE ============== --}}
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-cloud-download me-2"></i>جلب التحديث من GitHub</span>
            </div>
            <div class="admin-card-body d-flex flex-column">
                @if(! $git['available'])
                    <div class="sys-note warn"><i class="bi bi-exclamation-triangle"></i> Git غير متاح على الخادم أو المجلد ليس مستودعاً. لا يمكن الجلب تلقائياً هنا.</div>
                @else
                    @if($git['behind'] === null)
                        <div class="sys-note"><i class="bi bi-question-circle"></i> اضغط «فحص التحديثات» لمعرفة إن توفّرت تحديثات جديدة.</div>
                    @elseif($git['behind'] > 0)
                        <div class="sys-note info"><i class="bi bi-arrow-down-circle"></i> يتوفّر <strong>{{ $git['behind'] }}</strong> تحديث/تحديثات جديدة بانتظار الجلب.</div>
                    @else
                        <div class="sys-note ok"><i class="bi bi-check-circle"></i> نسختك محدّثة — لا توجد تحديثات جديدة.</div>
                    @endif

                    <div class="d-flex gap-2 flex-wrap mt-auto pt-3">
                        <form action="{{ route('admin.system.check') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-outline-admin"><i class="bi bi-arrow-repeat"></i> فحص التحديثات</button>
                        </form>
                        <form action="{{ route('admin.system.pull') }}" method="POST"
                              onsubmit="return confirm('سيتم جلب آخر إصدار من الكود من GitHub. متابعة؟');">
                            @csrf
                            <button type="submit" class="btn-primary-admin"><i class="bi bi-cloud-download"></i> جلب التحديث الآن</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============== DATABASE UPDATE ============== --}}
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-database-gear me-2"></i>تحديث قاعدة البيانات (الترحيلات)</span>
                @if($pendingCount > 0)
                    <span class="badge-unread">{{ $pendingCount }} ترحيل معلّق</span>
                @else
                    <span class="badge-read">محدّثة</span>
                @endif
            </div>
            <div class="admin-card-body">
                <p style="color:var(--text-muted);font-size:0.88rem;margin-bottom:1rem;">
                    شغّل هذا بعد جلب تحديث يحتوي على تعديلات في بنية قاعدة البيانات. آمن للتشغيل حتى لو لم توجد ترحيلات معلّقة.
                </p>

                @if($migrateStatus)
                <pre class="cmd-output mb-3" dir="ltr">{{ $migrateStatus }}</pre>
                @endif

                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('admin.system.migrate') }}" method="POST"
                          onsubmit="return confirm('سيتم تشغيل ترحيلات قاعدة البيانات. متابعة؟');">
                        @csrf
                        <button type="submit" class="btn-primary-admin"
                            @if($pendingCount === 0) style="opacity:0.75;" @endif>
                            <i class="bi bi-database-check"></i> تحديث قاعدة البيانات
                        </button>
                    </form>
                    <form action="{{ route('admin.system.optimize') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-outline-admin"><i class="bi bi-stars"></i> مسح الذاكرة المؤقتة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============== HINT ============== --}}
    <div class="col-12">
        <div class="sys-note info">
            <i class="bi bi-lightbulb"></i>
            <span>الترتيب الموصى به للتحديث: <strong>جلب التحديث</strong> ← <strong>تحديث قاعدة البيانات</strong> ← <strong>مسح الذاكرة المؤقتة</strong>. إن كان التحديث يتضمّن حزماً جديدة (composer) أو أصولاً (npm)، فقد تحتاج تشغيلها على الخادم يدوياً.</span>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<style>
    .sys-table { width:100%; border-collapse:collapse; }
    .sys-table td { padding:0.6rem 0.2rem; border-bottom:1px solid rgba(99,102,241,0.08); font-size:0.9rem; }
    .sys-table td:first-child { color:var(--text-muted); width:42%; }
    .sys-table tr:last-child td { border-bottom:none; }

    .cmd-output {
        background:#0b1220; color:#cbd5e1; font-family:ui-monospace,Menlo,Consolas,monospace;
        font-size:0.82rem; line-height:1.6; padding:1rem 1.2rem; margin:0; white-space:pre-wrap;
        word-break:break-word; max-height:340px; overflow:auto; border-radius:0 0 16px 16px;
    }
    .mb-3.cmd-output { border-radius:12px; }

    .sys-note {
        display:flex; align-items:flex-start; gap:0.6rem; padding:0.8rem 1rem; border-radius:12px;
        font-size:0.88rem; background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.18); color:var(--text);
    }
    .sys-note i { font-size:1.05rem; margin-top:0.1rem; }
    .sys-note.info { background:rgba(6,182,212,0.1);  border-color:rgba(6,182,212,0.25); }
    .sys-note.ok   { background:rgba(16,185,129,0.1); border-color:rgba(16,185,129,0.25); color:#6ee7b7; }
    .sys-note.warn { background:rgba(245,158,11,0.1); border-color:rgba(245,158,11,0.25); color:#fcd34d; }
</style>
@endsection
