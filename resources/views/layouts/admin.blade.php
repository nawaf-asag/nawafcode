<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','لوحة التحكم') - نواف عساج</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #0f172a;
            --dark-2: #1e293b;
            --dark-3: #334155;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --sidebar-w: 260px;
            --gradient: linear-gradient(135deg,#6366f1 0%,#06b6d4 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Cairo', sans-serif; background: var(--dark); color: var(--text); min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--dark-2);
            border-left: 1px solid rgba(99,102,241,0.15);
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(99,102,241,0.15);
            text-align: center;
        }

        .sidebar-brand-name {
            font-size: 1.3rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }

        .sidebar-brand-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .sidebar-nav { padding: 1.5rem 1rem; flex: 1; overflow-y: auto; }

        .nav-section-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            padding: 0 0.5rem;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            margin-bottom: 0.3rem;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(99,102,241,0.15);
            color: var(--primary);
        }

        .sidebar-link.active {
            background: rgba(99,102,241,0.2);
            color: var(--primary);
        }

        .sidebar-link i { font-size: 1.1rem; width: 20px; text-align: center; }

        .sidebar-link .badge-count {
            margin-right: auto;
            background: var(--accent);
            color: #000;
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 50px;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(99,102,241,0.15);
        }

        /* ===== MAIN ===== */
        .main-content {
            margin-right: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: var(--dark-2);
            border-bottom: 1px solid rgba(99,102,241,0.15);
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: #fff;
        }

        /* ===== CONTENT ===== */
        .page-content { padding: 2rem; flex: 1; }

        /* ===== CARDS ===== */
        .admin-card {
            background: var(--dark-2);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 16px;
            overflow: hidden;
        }

        .admin-card-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(99,102,241,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .admin-card-body { padding: 1.5rem; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: var(--dark-2);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .stat-card:hover {
            border-color: rgba(99,102,241,0.35);
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(99,102,241,0.1);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(99,102,241,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .stat-label { color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem; }

        /* ===== TABLE ===== */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; }

        .admin-table th {
            padding: 0.9rem 1.2rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(99,102,241,0.1);
            background: rgba(99,102,241,0.05);
        }

        .admin-table td {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid rgba(99,102,241,0.07);
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text);
        }

        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover { background: rgba(99,102,241,0.05); }

        /* ===== BUTTONS ===== */
        .btn-primary-admin {
            background: var(--gradient);
            border: none;
            color: #fff;
            padding: 0.55rem 1.3rem;
            border-radius: 10px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-primary-admin:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 6px 20px rgba(99,102,241,0.3);
        }

        .btn-outline-admin {
            background: transparent;
            border: 1px solid rgba(99,102,241,0.3);
            color: var(--primary);
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-outline-admin:hover {
            background: rgba(99,102,241,0.1);
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-danger-admin {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn-danger-admin:hover {
            background: rgba(239,68,68,0.25);
            color: #f87171;
        }

        .btn-edit-admin {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            color: var(--primary);
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn-edit-admin:hover { background: rgba(99,102,241,0.2); color: var(--primary); }

        /* ===== FORM ===== */
        .form-control, .form-select, .form-check-input {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(99,102,241,0.2) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: 0.7rem 1rem !important;
            font-family: 'Cairo', sans-serif;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(99,102,241,0.25) !important;
        }

        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-label { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; }
        textarea.form-control { resize: vertical; }

        .form-select option { background: var(--dark-2); }

        /* ===== BADGE ===== */
        .badge-active { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; }
        .badge-inactive { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; }
        .badge-unread { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; }
        .badge-read { background: rgba(99,102,241,0.1); color: var(--text-muted); border: 1px solid rgba(99,102,241,0.15); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; }

        /* ===== ALERTS ===== */
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; border-radius: 10px; }
        .alert-danger  { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; border-radius: 10px; }

        /* ===== MOBILE ===== */
        .sidebar-toggle {
            display: none;
            background: transparent;
            border: 1px solid rgba(99,102,241,0.3);
            color: var(--primary);
            border-radius: 8px;
            padding: 0.4rem 0.7rem;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-right: 0; }
            .sidebar-toggle { display: flex; align-items: center; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.active { display: block; }
        }

        /* ===== BREADCRUMB ===== */
        .admin-breadcrumb { color: var(--text-muted); font-size: 0.85rem; }
        .admin-breadcrumb a { color: var(--primary); text-decoration: none; }
        .admin-breadcrumb a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="sidebar-brand-name">نواف عساج</span>
        <span class="sidebar-brand-sub">لوحة التحكم</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">الرئيسية</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> لوحة التحكم
        </a>

        <div class="nav-section-label">المحتوى</div>
        <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> الخدمات
        </a>
        <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> الأعمال
        </a>
        <a href="{{ route('admin.brands.index') }}" class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="bi bi-award"></i> البراندات
        </a>

        <div class="nav-section-label">التفاعل</div>
        <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> الرسائل
            @php $unread = \App\Models\Contact::where('is_read',false)->count(); @endphp
            @if($unread > 0)
                <span class="badge-count">{{ $unread }}</span>
            @endif
        </a>
        <a href="{{ route('admin.socials.index') }}" class="sidebar-link {{ request()->routeIs('admin.socials.*') ? 'active' : '' }}">
            <i class="bi bi-share"></i> التواصل الاجتماعي
        </a>

        <div class="nav-section-label">الإعدادات</div>
        <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> إعدادات الموقع
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-eye"></i> معاينة الموقع
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link w-100 border-0" style="background:none;text-align:right;color:var(--text-muted);">
                <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <div class="topbar-title">@yield('title', 'لوحة التحكم')</div>
                <div class="admin-breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">الرئيسية</a>
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
        <div class="topbar-user">
            <div class="user-avatar">{{ substr(auth()->user()->name ?? 'N', 0, 1) }}</div>
            <div>
                <div style="font-weight:700;font-size:0.9rem;">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div style="font-size:0.75rem;color:var(--text-muted);">مدير الموقع</div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="page-content">
        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
}
</script>
@yield('scripts')
</body>
</html>
