<nav class="navbar-form">
    <div class="nav-left">
        <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo Nesasa" class="nav-logo">
        <span class="nav-title">PAMERAN TKI</span>
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
        <button id="themeToggleBtn" type="button" class="btn-theme-toggle" title="Toggle Dark/Light Mode" aria-label="Toggle tema">
            <!-- Sun icon (shown in dark mode) -->
            <svg id="iconSun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/>
                <line x1="12" y1="1" x2="12" y2="3"/>
                <line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/>
                <line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
            <!-- Moon icon (shown in light mode) -->
            <svg id="iconMoon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </button>
        <a href="/login" class="btn-login">Login Admin</a>
    </div>
</nav>

<script>
    (function() {
        const saved = localStorage.getItem('themeMode');
        if (saved === 'light') document.documentElement.classList.add('light-mode');
    })();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('themeToggleBtn');
        const iconSun = document.getElementById('iconSun');
        const iconMoon = document.getElementById('iconMoon');

        function updateIcon() {
            const isLight = document.documentElement.classList.contains('light-mode');
            iconSun.style.display  = isLight ? 'none'  : 'block';
            iconMoon.style.display = isLight ? 'block' : 'none';
        }

        updateIcon();

        btn.addEventListener('click', function() {
            document.documentElement.classList.toggle('light-mode');
            const isLight = document.documentElement.classList.contains('light-mode');
            localStorage.setItem('themeMode', isLight ? 'light' : 'dark');
            updateIcon();
        });
    });
</script>
