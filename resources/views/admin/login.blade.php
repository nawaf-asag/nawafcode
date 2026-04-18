<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --gradient: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
            --dark: #0f172a;
            --dark-2: #1e293b;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,0.08) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }
        .login-card {
            background: var(--dark-2);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .login-logo-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            margin: 0 auto 1rem;
        }
        .login-title {
            font-size: 1.6rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .login-sub { color: var(--text-muted); font-size: 0.9rem; }
        .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(99,102,241,0.2) !important;
            color: var(--text) !important;
            border-radius: 12px !important;
            padding: 0.8rem 1.2rem !important;
            font-family: 'Cairo', sans-serif;
        }
        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(99,102,241,0.25) !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-label { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; }
        .input-group-text {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(99,102,241,0.2) !important;
            border-left: none !important;
            color: var(--text-muted) !important;
            border-radius: 0 12px 12px 0 !important;
        }
        .input-group .form-control { border-right: none !important; border-radius: 12px 0 0 12px !important; }
        .btn-login {
            background: var(--gradient);
            border: none;
            color: #fff;
            padding: 0.85rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99,102,241,0.4);
        }
        .alert-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; border-radius: 10px; }
        .back-link { color: var(--text-muted); text-decoration: none; font-size: 0.85rem; }
        .back-link:hover { color: var(--primary); }
        .form-check-input { background-color: rgba(255,255,255,0.05) !important; border-color: rgba(99,102,241,0.3) !important; }
        .form-check-input:checked { background-color: var(--primary) !important; border-color: var(--primary) !important; }
        .form-check-label { color: var(--text-muted); font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="login-title">لوحة التحكم</div>
            <div class="login-sub">نواف عساج - موقع شخصي</div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">كلمة المرور</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" id="pwdInput" required>
                    <button type="button" class="input-group-text" onclick="togglePwd()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">تذكرني</label>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i> تسجيل الدخول
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="back-link">
                <i class="bi bi-arrow-right me-1"></i> العودة للموقع
            </a>
        </div>
    </div>

    <script>
    function togglePwd() {
        const inp = document.getElementById('pwdInput');
        const ico = document.getElementById('eyeIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            ico.className = 'bi bi-eye-slash';
        } else {
            inp.type = 'password';
            ico.className = 'bi bi-eye';
        }
    }
    </script>
</body>
</html>
