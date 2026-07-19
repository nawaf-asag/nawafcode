@extends('layouts.admin')
@section('title','التحليلات والإحصائيات')
@section('breadcrumb') / <span>التحليلات</span> @endsection

@section('content')

{{-- ===== Connection status ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-body d-flex align-items-center gap-3 flex-wrap">
                <div class="stat-icon" style="margin:0;background:rgba(245,158,11,0.15);color:var(--accent);"><i class="bi bi-graph-up-arrow"></i></div>
                <div style="flex:1;min-width:180px;">
                    <div style="font-weight:700;">Google Analytics 4</div>
                    @if($ga4Id)
                        <div style="font-size:0.82rem;color:#6ee7b7;"><i class="bi bi-check-circle-fill"></i> مُفعّل — <span dir="ltr">{{ $ga4Id }}</span></div>
                    @else
                        <div style="font-size:0.82rem;color:var(--text-muted);"><i class="bi bi-exclamation-circle"></i> غير مربوط بعد</div>
                    @endif
                </div>
                @if($ga4Id)
                    <a href="https://analytics.google.com" target="_blank" class="btn-primary-admin"><i class="bi bi-box-arrow-up-left"></i> فتح جوجل أناليتكس</a>
                @else
                    <a href="{{ route('admin.seo') }}" class="btn-outline-admin"><i class="bi bi-plug"></i> ربط الآن</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-body d-flex align-items-center gap-3 flex-wrap">
                <div class="stat-icon" style="margin:0;"><i class="bi bi-search"></i></div>
                <div style="flex:1;min-width:180px;">
                    <div style="font-weight:700;">Google Search Console</div>
                    @if($gscVerified)
                        <div style="font-size:0.82rem;color:#6ee7b7;"><i class="bi bi-check-circle-fill"></i> كود التحقق مضبوط</div>
                    @else
                        <div style="font-size:0.82rem;color:var(--text-muted);"><i class="bi bi-exclamation-circle"></i> أضف كود التحقق</div>
                    @endif
                </div>
                <a href="https://search.google.com/search-console" target="_blank" class="btn-outline-admin"><i class="bi bi-box-arrow-up-left"></i> فتح Search Console</a>
            </div>
        </div>
    </div>
</div>

{{-- ===== Content KPIs ===== --}}
<div class="row g-4 mb-4">
    @foreach([
        ['label' => 'الخدمات',   'value' => $stats['services'],    'icon' => 'bi-briefcase-fill',    'c' => 'var(--primary)'],
        ['label' => 'الأعمال',   'value' => $stats['projects'],    'icon' => 'bi-grid-3x3-gap-fill', 'c' => 'var(--secondary)'],
        ['label' => 'الرسائل',   'value' => $stats['contacts'],    'icon' => 'bi-envelope-fill',     'c' => 'var(--accent)'],
        ['label' => 'البراندات', 'value' => $stats['brands'],      'icon' => 'bi-award-fill',        'c' => '#34d399'],
    ] as $kpi)
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $kpi['c'] }}1f;color:{{ $kpi['c'] }};"><i class="bi {{ $kpi['icon'] }}"></i></div>
            <div class="stat-number">{{ $kpi['value'] }}</div>
            <div class="stat-label">{{ $kpi['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== Charts ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-bar-chart-line me-2"></i>الرسائل خلال آخر 12 شهراً</span>
            </div>
            <div class="admin-card-body">
                <canvas id="messagesChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title"><i class="bi bi-pie-chart me-2"></i>توزيع المحتوى</span>
            </div>
            <div class="admin-card-body d-flex align-items-center justify-content-center">
                <canvas id="contentChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ===== Recent messages ===== --}}
<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title"><i class="bi bi-envelope me-2"></i>آخر الرسائل</span>
        <a href="{{ route('admin.contacts.index') }}" class="btn-outline-admin" style="padding:0.3rem 0.8rem;font-size:0.8rem;">عرض الكل</a>
    </div>
    <div class="admin-card-body" style="padding:0;">
        @if($recentContacts->isEmpty())
            <div style="padding:2.5rem;text-align:center;color:var(--text-muted);"><i class="bi bi-inbox fs-1 d-block mb-2" style="opacity:0.3;"></i> لا توجد رسائل بعد</div>
        @else
        <table class="admin-table">
            <thead><tr><th>المرسل</th><th>الموضوع</th><th>التاريخ</th><th>الحالة</th></tr></thead>
            <tbody>
                @foreach($recentContacts as $contact)
                <tr>
                    <td><div style="font-weight:600;">{{ $contact->name }}</div><div style="font-size:0.8rem;color:var(--text-muted);">{{ $contact->email }}</div></td>
                    <td>{{ Str::limit($contact->subject, 40) }}</td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ $contact->created_at->diffForHumans() }}</td>
                    <td>@if($contact->is_read)<span class="badge-read">مقروءة</span>@else<span class="badge-unread">جديدة</span>@endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    if (typeof Chart === 'undefined') return;
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = 'Cairo, sans-serif';

    var months = @json($months);
    var mix    = @json($contentMix);

    var mc = document.getElementById('messagesChart');
    if (mc) {
        var grad = mc.getContext('2d').createLinearGradient(0, 0, 0, 260);
        grad.addColorStop(0, 'rgba(99,102,241,0.35)');
        grad.addColorStop(1, 'rgba(99,102,241,0.02)');
        new Chart(mc, {
            type: 'line',
            data: {
                labels: months.map(function (m) { return m.label; }),
                datasets: [{
                    label: 'الرسائل',
                    data: months.map(function (m) { return m.value; }),
                    borderColor: '#6366f1',
                    backgroundColor: grad,
                    fill: true, tension: 0.4, borderWidth: 2,
                    pointBackgroundColor: '#6366f1', pointRadius: 3
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(148,163,184,0.08)' } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(148,163,184,0.08)' } }
                }
            }
        });
    }

    var cc = document.getElementById('contentChart');
    if (cc) {
        new Chart(cc, {
            type: 'doughnut',
            data: {
                labels: mix.map(function (m) { return m.label; }),
                datasets: [{
                    data: mix.map(function (m) { return m.value; }),
                    backgroundColor: ['#6366f1', '#06b6d4', '#f59e0b', '#34d399', '#a78bfa'],
                    borderColor: 'rgba(30,41,59,0.6)', borderWidth: 2
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: true, cutout: '62%',
                plugins: { legend: { position: 'bottom', labels: { padding: 14, boxWidth: 12 } } }
            }
        });
    }
})();
</script>
@endsection
