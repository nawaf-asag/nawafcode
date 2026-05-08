import './../css/app.css';

/* ============================================
   Theme Switcher (Light / Dark)
   ============================================ */
(function initTheme() {
    const root = document.documentElement;
    const stored = localStorage.getItem('theme');
    const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
    const initial = stored || (prefersLight ? 'light' : 'dark');
    root.setAttribute('data-theme', initial);

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-theme-toggle]');
        if (!btn) return;
        const current = root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
        const next = current === 'light' ? 'dark' : 'light';
        root.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
    });
})();

/* ============================================
   Navbar Scroll Effect + Active Section
   ============================================ */
(function initNavbar() {
    const nav = document.getElementById('mainNav');
    const scrollBtn = document.getElementById('scrollTop');
    const sections = document.querySelectorAll('section[id]');
    const links = new Map();
    sections.forEach(s => {
        const link = document.querySelector(`.nav-link[href="#${s.id}"]`);
        if (link) links.set(s.id, link);
    });

    let ticking = false;
    function onScroll() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            const y = window.scrollY;
            if (nav) nav.classList.toggle('scrolled', y > 80);
            if (scrollBtn) scrollBtn.classList.toggle('visible', y > 300);

            sections.forEach(sec => {
                const top = sec.offsetTop - 120;
                const bottom = top + sec.offsetHeight;
                const link = links.get(sec.id);
                if (!link) return;
                if (y >= top && y < bottom) link.classList.add('active');
                else link.classList.remove('active');
            });
            ticking = false;
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
})();

/* ============================================
   Scroll Top Button
   ============================================ */
(function initScrollTop() {
    const btn = document.getElementById('scrollTop');
    if (!btn) return;
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
})();

/* ============================================
   Project Filter
   ============================================ */
(function initProjectFilter() {
    const buttons = document.querySelectorAll('.filter-btn');
    if (!buttons.length) return;
    const items = document.querySelectorAll('.project-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            items.forEach(item => {
                const show = filter === 'all' || item.dataset.category === filter;
                item.style.display = show ? '' : 'none';
            });
        });
    });
})();

/* ============================================
   AOS Init + Bootstrap Tooltips (after libs load)
   ============================================ */
window.addEventListener('load', () => {
    if (window.AOS) {
        window.AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            disable: () => window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        });
    }

    if (window.bootstrap?.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new window.bootstrap.Tooltip(el);
        });
    }
});

/* ============================================
   Preloader — hide after page is ready
   ============================================ */
(function initPreloader() {
    const pre = document.getElementById('preloader');
    if (!pre) return;

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const minDelay = reduced ? 200 : 1900;

    const start = performance.now();
    function hide() {
        const elapsed = performance.now() - start;
        const wait = Math.max(0, minDelay - elapsed);
        setTimeout(() => {
            pre.classList.add('hidden');
            // Remove from DOM after fade
            setTimeout(() => pre.remove(), 700);
        }, wait);
    }

    if (document.readyState === 'complete') {
        hide();
    } else {
        window.addEventListener('load', hide, { once: true });
    }
})();

/* ============================================
   Scroll Progress Bar
   ============================================ */
(function initScrollProgress() {
    const bar = document.getElementById('scrollProgress');
    if (!bar) return;

    let ticking = false;
    function update() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            const h = document.documentElement;
            const scrolled = h.scrollTop;
            const max = h.scrollHeight - h.clientHeight;
            const pct = max > 0 ? (scrolled / max) * 100 : 0;
            bar.style.width = pct + '%';
            ticking = false;
        });
    }
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
})();

/* ============================================
   Animated Counters (stat numbers count up when in view)
   ============================================ */
(function initCounters() {
    const els = document.querySelectorAll('.stat-number');
    if (!els.length || !('IntersectionObserver' in window)) return;

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function parseTarget(text) {
        const m = text.match(/(\d+)/);
        return m ? parseInt(m[1], 10) : null;
    }

    function animate(el) {
        const original = el.textContent.trim();
        const target = parseTarget(original);
        if (target === null || target <= 0) return;

        const suffix = original.replace(/\d+/, '');
        if (reduced) { el.textContent = target + suffix; return; }

        const duration = 1400;
        const start = performance.now();
        function step(now) {
            const t = Math.min(1, (now - start) / duration);
            // ease-out cubic
            const eased = 1 - Math.pow(1 - t, 3);
            const value = Math.round(target * eased);
            el.textContent = value + suffix;
            if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                animate(e.target);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.4 });

    els.forEach(el => io.observe(el));
})();

/* ============================================
   Magnetic Buttons — subtle pull toward cursor
   ============================================ */
(function initMagnetic() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.matchMedia('(pointer: coarse)').matches) return; // skip on touch

    const STRENGTH = 0.25;
    const targets = document.querySelectorAll('.btn-primary-custom, .btn-outline-custom, .btn-submit');

    targets.forEach(btn => {
        btn.addEventListener('mousemove', e => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * STRENGTH}px, ${y * STRENGTH}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = '';
        });
    });
})();

/* ============================================
   Hero name — set data-text for glitch effect
   ============================================ */
(function initGlitch() {
    const el = document.querySelector('.hero-name');
    if (!el) return;
    el.setAttribute('data-text', el.textContent.trim());
})();

/* ============================================
   Brands Slider — auto-scroll, draggable, seamless loop
   ============================================ */
(function initBrandsSlider() {
    const slider = document.querySelector('.brands-slider');
    const track  = document.querySelector('.brands-track');
    if (!slider || !track) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // Force LTR scroll math regardless of page direction (logos are direction-neutral)
    slider.setAttribute('dir', 'ltr');

    const SPEED = 1.5;                  // px per frame ≈ 90 px/sec @60fps
    const PAUSE_AFTER_DRAG = 1500;      // ms

    let halfWidth   = 0;
    let isDown      = false;
    let startX      = 0;
    let scrollStart = 0;
    let pausedUntil = 0;
    let hovering    = false;
    let dragMoved   = false;            // track whether a drag actually happened

    function recalc() {
        // The track contains 2 identical sets — half = one set width
        halfWidth = track.scrollWidth / 2;
    }

    function normalize() {
        if (!halfWidth) return;
        // Wrap scrollLeft into [0, halfWidth) seamlessly
        if (slider.scrollLeft >= halfWidth) slider.scrollLeft -= halfWidth;
        else if (slider.scrollLeft < 0)     slider.scrollLeft += halfWidth;
    }

    function tick() {
        if (!isDown && !hovering && Date.now() > pausedUntil) {
            slider.scrollLeft += SPEED;
            normalize();
        }
        requestAnimationFrame(tick);
    }

    // ===== Pointer drag =====
    slider.addEventListener('pointerdown', (e) => {
        isDown    = true;
        dragMoved = false;
        slider.classList.add('grabbing');
        startX      = e.pageX;
        scrollStart = slider.scrollLeft;
        try { slider.setPointerCapture(e.pointerId); } catch (_) {}
    });

    slider.addEventListener('pointermove', (e) => {
        if (!isDown) return;
        const dx = e.pageX - startX;
        if (Math.abs(dx) > 3) dragMoved = true;
        slider.scrollLeft = scrollStart - dx;
        normalize();
    });

    function endDrag(e) {
        if (!isDown) return;
        isDown = false;
        slider.classList.remove('grabbing');
        pausedUntil = Date.now() + PAUSE_AFTER_DRAG;
        try { slider.releasePointerCapture(e.pointerId); } catch (_) {}
    }
    slider.addEventListener('pointerup',     endDrag);
    slider.addEventListener('pointercancel', endDrag);

    // Prevent click-through after a drag (so brand-visit-link doesn't trigger)
    slider.addEventListener('click', (e) => {
        if (dragMoved) {
            e.preventDefault();
            e.stopPropagation();
            dragMoved = false;
        }
    }, true);

    // ===== Hover pause (desktop) =====
    if (!window.matchMedia('(pointer: coarse)').matches) {
        slider.addEventListener('mouseenter', () => { hovering = true; });
        slider.addEventListener('mouseleave', () => { hovering = false; });
    }

    // ===== Wheel scroll (horizontal) =====
    slider.addEventListener('wheel', (e) => {
        // Convert vertical wheel to horizontal scroll
        if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
            slider.scrollLeft += e.deltaY;
            normalize();
            pausedUntil = Date.now() + 1000;
            e.preventDefault();
        }
    }, { passive: false });

    // ===== Init =====
    function start() {
        recalc();
        slider.scrollLeft = 0;
        requestAnimationFrame(tick);
    }
    if (document.readyState === 'complete') start();
    else window.addEventListener('load', start);

    window.addEventListener('resize', recalc);
})();
