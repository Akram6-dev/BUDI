<header class="mrc-navbar">
    <a href="/" class="mrc-nav-brand">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo SMKN 1 Subang" class="mrc-brand-logo">
            <img src="{{ asset('img/logomrc.png') }}" alt="Logo MRC" class="mrc-brand-logo" style="height: 38px; width: auto; object-fit: contain;">
        </div>
        <div class="mrc-brand-text">
            <div class="mrc-brand-title">
                <span>BUTAGI</span>
            </div>
            <span class="mrc-brand-sub">Buku Tamu Digital SMKN 1 Subang</span>
        </div>
    </a>

    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <button type="button" class="theme-btn" id="mrcThemeToggle" onclick="toggleMrcTheme()" aria-label="Ganti tema" style="padding: 0.45rem 0.8rem; font-size: 0.8125rem;">
            <svg id="mrcIconMoon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
            </svg>
            <svg id="mrcIconSun" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
            </svg>
            <span id="mrcThemeLabel">Light</span>
        </button>
        <a href="/" class="btn-mrc btn-mrc-outline" style="padding: 0.5rem 0.875rem; font-size: 0.8125rem;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Beranda</span>
        </a>
    </div>
</header>
<script>
    function updateMrcThemeUI(theme) {
        const isDark = theme === 'dark';
        const moon = document.getElementById('mrcIconMoon');
        const sun = document.getElementById('mrcIconSun');
        const lbl = document.getElementById('mrcThemeLabel');
        if (moon) moon.style.display = isDark ? 'block' : 'none';
        if (sun) sun.style.display = isDark ? 'none' : 'block';
        if (lbl) lbl.textContent = isDark ? 'Light' : 'Dark';
    }
    function toggleMrcTheme() {
        const cur = document.documentElement.getAttribute('data-theme') || 'dark';
        const next = cur === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('butagi_theme', next);
        updateMrcThemeUI(next);
    }
    (function() {
        const saved = localStorage.getItem('butagi_theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
        updateMrcThemeUI(saved);
    })();
</script>
