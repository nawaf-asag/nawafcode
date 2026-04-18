<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['meta_description'] ?? 'نواف عساج - مطور برمجيات' }}">
    <title>{{ $settings['meta_title'] ?? 'نواف عساج - مطور برمجيات' }}</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
            --card-bg: rgba(30, 41, 59, 0.8);
            --gradient: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%);
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--dark);
            color: var(--text);
            overflow-x: hidden;
            max-width: 100vw;
        }

        *, *::before, *::after {
            max-width: 100%;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s;
            padding: 1rem 0;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(99, 102, 241, 0.15);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: var(--text-muted) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background: rgba(99, 102, 241, 0.1);
        }

        /* ===== HERO ===== */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: var(--dark);
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 100vw;
        }

        .hero-row {
            min-height: 100vh;
            padding-top: 5rem;
            padding-bottom: 3rem;
            width: 100%;
        }

        #hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        #hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            color: var(--primary);
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .hero-name {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .hero-title {
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .hero-desc {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.8;
            max-width: 540px;
        }

        .hero-btns { gap: 1rem; margin-top: 2.5rem; }

        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            color: #fff;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(99,102,241,0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid rgba(99,102,241,0.5);
            color: var(--primary);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-custom:hover {
            background: rgba(99,102,241,0.1);
            border-color: var(--primary);
            transform: translateY(-3px);
            color: var(--primary);
        }

        .hero-avatar {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin: 0 auto;
        }

        .hero-avatar::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: var(--gradient);
            z-index: -1;
            animation: rotate 4s linear infinite;
        }

        .hero-avatar-inner {
            width: 304px;
            height: 304px;
            border-radius: 50%;
            background: var(--dark-2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8rem;
            color: var(--primary);
        }

        .hero-stats {
            display: flex;
            gap: 0;
            margin-top: 3rem;
            flex-wrap: nowrap;
            max-width: 100%;
        }

        .stat-item {
            text-align: center;
            padding: 0 1.5rem;
            flex: 1;
        }

        .stat-item:first-child { padding-right: 0; }
        .stat-item:last-child  { padding-left: 0; }

        .stat-divider {
            border-right: 1px solid rgba(99,102,241,0.25) !important;
            border-left:  1px solid rgba(99,102,241,0.25) !important;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            white-space: nowrap;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        /* ===== SECTIONS ===== */
        section { padding: 5rem 0; }

        .section-header { text-align: center; margin-bottom: 4rem; }

        .section-tag {
            display: inline-block;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.3);
            color: var(--primary);
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .section-divider {
            width: 60px;
            height: 4px;
            background: var(--gradient);
            border-radius: 2px;
            margin: 0 auto;
        }

        /* ===== ABOUT ===== */
        #about { background: var(--dark-2); }

        .about-img-wrapper {
            position: relative;
            padding-bottom: 1.5rem;
            padding-right: 1rem;
        }

        .about-img-box {
            width: 100%;
            padding-bottom: 88%;
            background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(6,182,212,0.2));
            border-radius: 24px;
            border: 1px solid rgba(99,102,241,0.2);
            overflow: hidden;
            position: relative;
        }

        .about-img-placeholder {
            font-size: 6rem;
            color: var(--primary);
            opacity: 0.5;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .about-badge-box {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 108px;
            height: 108px;
            border-radius: 16px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            box-shadow: 0 8px 25px rgba(99,102,241,0.4);
        }

        .about-badge-num {
            font-size: 1.7rem;
            font-weight: 800;
            line-height: 1;
        }

        .about-badge-lbl {
            font-size: 0.65rem;
            text-align: center;
            margin-top: 0.25rem;
            line-height: 1.3;
        }

        .skill-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.2rem;
            background: rgba(99,102,241,0.08);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 10px;
            margin-bottom: 0.8rem;
            transition: all 0.3s;
        }

        .skill-item:hover {
            background: rgba(99,102,241,0.15);
            border-color: rgba(99,102,241,0.3);
            transform: translateX(-5px);
        }

        .skill-icon {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* ===== SERVICES ===== */
        #services { background: var(--dark); }

        .service-card {
            background: var(--card-bg);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient);
            transform: scaleX(0);
            transition: transform 0.4s;
            transform-origin: right;
        }

        .service-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99,102,241,0.4);
            box-shadow: 0 20px 40px rgba(99,102,241,0.15);
        }

        .service-card:hover::before { transform: scaleX(1); }

        .service-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(99,102,241,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .service-card:hover .service-icon {
            background: var(--gradient);
            color: #fff;
        }

        .service-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.8rem;
        }

        .service-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* ===== PROJECTS ===== */
        #projects { background: var(--dark-2); }

        .filter-btns { display: flex; gap: 0.8rem; flex-wrap: wrap; justify-content: center; margin-bottom: 3rem; }

        .filter-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            border: 1px solid rgba(99,102,241,0.3);
            background: transparent;
            color: var(--text-muted);
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .filter-btn.active, .filter-btn:hover {
            background: var(--gradient);
            border-color: transparent;
            color: #fff;
        }

        .project-card {
            background: var(--card-bg);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s;
            height: 100%;
        }

        .project-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99,102,241,0.4);
            box-shadow: 0 20px 40px rgba(99,102,241,0.15);
        }

        .project-img {
            height: 200px;
            background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(6,182,212,0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary);
            position: relative;
            overflow: hidden;
        }

        .project-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .project-img .project-overlay {
            position: absolute;
            inset: 0;
            background: rgba(99,102,241,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .project-card:hover .project-overlay { opacity: 1; }

        .project-overlay a {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            text-decoration: none;
            transition: background 0.3s;
        }

        .project-overlay a:hover { background: rgba(255,255,255,0.4); }

        .project-body { padding: 1.5rem; }

        .project-category {
            display: inline-block;
            background: rgba(6,182,212,0.15);
            color: var(--secondary);
            padding: 0.2rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .project-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.6rem;
        }

        .project-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .tech-tag {
            display: inline-block;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            color: var(--primary);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            margin: 0.2rem;
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--accent);
            color: #000;
            padding: 0.2rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* ===== CONTACT ===== */
        #contact { background: var(--dark); }

        .contact-card {
            background: var(--card-bg);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(99,102,241,0.1);
        }

        .contact-info-item:last-child { border-bottom: none; }

        .contact-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(99,102,241,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .form-control, .form-select {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(99,102,241,0.2) !important;
            color: var(--text) !important;
            border-radius: 10px !important;
            padding: 0.8rem 1.2rem !important;
            font-family: 'Cairo', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08) !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(99,102,241,0.25) !important;
        }

        .form-control::placeholder { color: var(--text-muted) !important; }

        textarea.form-control { resize: vertical; min-height: 140px; }

        .btn-submit {
            background: var(--gradient);
            border: none;
            color: #fff;
            padding: 0.9rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(99,102,241,0.4);
        }

        /* ===== SOCIAL LINKS ===== */
        .social-links-section {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .social-link {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: var(--gradient);
            border-color: transparent;
            color: #fff;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(99,102,241,0.3);
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--dark-2);
            border-top: 1px solid rgba(99,102,241,0.15);
            padding: 2.5rem 0;
            text-align: center;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        /* ===== SCROLL TOP ===== */
        #scrollTop {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gradient);
            color: #fff;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #scrollTop.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-15px); }
        }

        .float-anim { animation: float 4s ease-in-out infinite; }

        /* ===== TYPED CURSOR ===== */
        .typed-cursor { color: var(--primary); }

        /* ===== RESPONSIVE - MOBILE ===== */

        /* تحسينات عامة للموبايل (أقل من 992px) */
        @media (max-width: 991.98px) {
            .navbar-collapse .navbar-nav { padding: 0.5rem 0; }
            .navbar-collapse .nav-link { border-radius: 8px; margin-bottom: 0.2rem; }

            /* Hero - النص يُمركَز على الموبايل */
            .hero-row {
                min-height: auto !important;
                padding-top: 5rem !important;
                padding-bottom: 3rem !important;
            }
            .hero-text-col { text-align: center; }
            .hero-desc { margin: 0 auto; max-width: 100% !important; }
            .hero-btns { justify-content: center; }
            .hero-stats { justify-content: center; margin-top: 2rem; }
            .social-links-section { justify-content: center !important; }
            .about-img-col { padding-bottom: 2rem; }
            .section-header { margin-bottom: 3rem; }

            /* إخفاء العناصر الزخرفية التي تسبب overflow */
            .hero-deco { display: none !important; }
        }

        /* MD - 768px إلى 991px */
        @media (min-width: 768px) and (max-width: 991.98px) {
            section { padding: 4rem 0; }
            .hero-avatar { width: 240px; height: 240px; }
            .hero-avatar-inner { width: 228px; height: 228px; font-size: 5.5rem; }
            .contact-card { padding: 2rem; }
        }

        /* SM - 576px إلى 767px */
        @media (min-width: 576px) and (max-width: 767.98px) {
            section { padding: 3.5rem 0; }
            .hero-avatar { width: 200px; height: 200px; }
            .hero-avatar-inner { width: 190px; height: 190px; font-size: 4.5rem; }
            .btn-primary-custom, .btn-outline-custom { padding: 0.75rem 1.5rem; font-size: 0.95rem; }
            .contact-card { padding: 2rem; }
            .stat-number { font-size: 1.7rem; }
            .stat-label { font-size: 0.8rem; }
            .stat-item { padding: 0 1rem; }
        }

        /* XS - أقل من 576px */
        @media (max-width: 575.98px) {
            section { padding: 3rem 0; }

            /* Navbar */
            .navbar { padding: 0.6rem 0; }
            .navbar-brand { font-size: 1.15rem; }
            #navMenu { margin-top: 0.5rem; padding: 0.5rem 0; border-top: 1px solid rgba(99,102,241,0.15); }
            .nav-link { padding: 0.6rem 0.8rem !important; font-size: 0.9rem; }

            /* Hero */
            .hero-row { padding-top: 4.5rem !important; padding-bottom: 2rem !important; }
            .hero-badge { font-size: 0.78rem; padding: 0.3rem 0.9rem; margin-bottom: 1rem; }
            .hero-name { font-size: 2rem; }
            .hero-title { font-size: 1rem; }
            .hero-desc { font-size: 0.92rem; }
            .hero-btns { margin-top: 1.5rem; gap: 0.6rem; }
            .btn-primary-custom, .btn-outline-custom {
                padding: 0.65rem 1.2rem;
                font-size: 0.88rem;
                width: 100%;
                justify-content: center;
            }

            /* Stats */
            .hero-stats { margin-top: 1.8rem; }
            .stat-item { padding: 0 0.6rem; }
            .stat-number { font-size: 1.5rem; }
            .stat-label { font-size: 0.72rem; }

            /* Avatar */
            .hero-avatar { width: 160px; height: 160px; }
            .hero-avatar-inner { width: 152px; height: 152px; font-size: 3.5rem; }
            .float-anim { animation: none; }

            /* Social links */
            .social-links-section { gap: 0.5rem; }
            .social-link { width: 40px; height: 40px; font-size: 1.05rem; border-radius: 10px; }

            /* About */
            .about-badge-box { width: 85px !important; height: 85px !important; }
            .skill-item { padding: 0.55rem 0.7rem; }
            .skill-item span { font-size: 0.8rem !important; }

            /* Services */
            .service-card { padding: 1.4rem; }
            .service-icon { width: 50px; height: 50px; font-size: 1.4rem; margin-bottom: 1rem; }
            .service-title { font-size: 1rem; }
            .service-desc { font-size: 0.87rem; }

            /* Projects */
            .filter-btns { gap: 0.4rem; margin-bottom: 1.8rem; }
            .filter-btn { padding: 0.38rem 0.85rem; font-size: 0.82rem; }
            .project-img { height: 160px; }
            .project-body { padding: 1.1rem; }
            .project-title { font-size: 1rem; }
            .project-desc { font-size: 0.85rem; }

            /* Contact */
            .contact-card { padding: 1.3rem; }
            .contact-info-item { padding: 0.7rem 0; }
            .contact-icon { width: 38px; height: 38px; font-size: 0.95rem; }

            /* Section header */
            .section-header { margin-bottom: 2.2rem; }
            .section-title { font-size: 1.6rem; }
            .section-tag { font-size: 0.78rem; }

            /* Scroll top */
            #scrollTop { left: 0.8rem; bottom: 0.8rem; width: 38px; height: 38px; font-size: 0.95rem; }
        }

        /* ===== ALERT ===== */
        .alert-success {
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.3);
            color: #6ee7b7;
            border-radius: 10px;
        }

        .alert-danger {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#hero">{{ $settings['hero_name'] ?? 'نواف عساج' }}</a>

        <!-- زر القائمة للموبايل -->
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="القائمة">
            <span style="display:flex;flex-direction:column;gap:5px;width:24px;">
                <span style="display:block;height:2px;background:var(--primary);border-radius:2px;transition:all 0.3s;"></span>
                <span style="display:block;height:2px;background:var(--primary);border-radius:2px;transition:all 0.3s;"></span>
                <span style="display:block;height:2px;background:var(--primary);border-radius:2px;transition:all 0.3s;"></span>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#about">من أنا</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">خدماتي</a></li>
                <li class="nav-item"><a class="nav-link" href="#projects">أعمالي</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">تواصل</a></li>
                <!-- زر لوحة التحكم داخل القائمة على الموبايل -->
                <li class="nav-item d-lg-none mt-2">
                    <a href="{{ route('admin.login') }}" class="nav-link" style="background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);border-radius:10px;color:var(--primary) !important;">
                        <i class="bi bi-shield-lock me-1"></i> لوحة التحكم
                    </a>
                </li>
            </ul>
            <!-- زر لوحة التحكم للسطح المكتب -->
            <a href="{{ route('admin.login') }}" class="btn btn-sm d-none d-lg-inline-flex align-items-center gap-1" style="background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:var(--primary);border-radius:50px;padding:0.4rem 1.2rem;font-family:'Cairo',sans-serif;">
                <i class="bi bi-shield-lock"></i> لوحة التحكم
            </a>
        </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-brand">{{ $settings['hero_name'] ?? 'نواف عساج' }}</div>
        <div class="d-flex justify-content-center gap-3 mb-3">
            @foreach($socialLinks as $link)
            <a href="{{ $link->url }}" class="social-link" target="_blank" title="{{ $link->platform }}">
                <i class="bi {{ $link->icon }}"></i>
            </a>
            @endforeach
        </div>
        <p class="text-muted mb-0" style="font-size:0.9rem;">
            &copy; {{ date('Y') }} جميع الحقوق محفوظة لـ <span style="color:var(--primary);">{{ $settings['hero_name'] ?? 'نواف عساج' }}</span>
        </p>
    </div>
</footer>

<!-- Scroll Top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ duration: 800, easing: 'ease-in-out', once: true, offset: 100 });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('mainNav');
        const btn = document.getElementById('scrollTop');
        if (window.scrollY > 80) {
            nav.classList.add('scrolled');
            btn.classList.add('visible');
        } else {
            nav.classList.remove('scrolled');
            btn.classList.remove('visible');
        }

        // Active nav link
        document.querySelectorAll('section[id]').forEach(sec => {
            const top = sec.offsetTop - 100;
            const bottom = top + sec.offsetHeight;
            const link = document.querySelector(`.nav-link[href="#${sec.id}"]`);
            if (link) {
                if (window.scrollY >= top && window.scrollY < bottom) link.classList.add('active');
                else link.classList.remove('active');
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
