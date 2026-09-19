<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — BUTAGI SMKN 1 Subang</title>
    <script>
        (function() {
            const saved = localStorage.getItem('butagi_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/mrc-theme.css') }}">
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            position: relative;
        }

        .login-top-bar {
            position: absolute;
            top: 1.25rem;
            right: 1.5rem;
            z-index: 10;
        }

        .login-ambient {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translateX(-50%);
            width: 550px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, rgba(139, 92, 246, 0.18) 45%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            height: 56px;
            width: auto;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .login-title {
            font-size: 1.625rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.025em;
            margin-bottom: 0.35rem;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .password-wrap {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle-btn:hover {
            color: var(--text-main);
        }

        /* ══════════════════════════════════════════════
           LIGHT MODE — Admin Login
        ══════════════════════════════════════════════ */
        [data-theme="light"] body {
            background: #f8fafc;
        }

        [data-theme="light"] .login-ambient {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.04) 45%, transparent 70%);
        }

        [data-theme="light"] .login-title {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="light"] .login-subtitle {
            color: #64748b;
        }

        [data-theme="light"] .mrc-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.04);
        }

        [data-theme="light"] .mrc-label {
            color: #334155;
        }

        [data-theme="light"] .mrc-input {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        [data-theme="light"] .mrc-input:focus {
            background-color: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        [data-theme="light"] .btn-mrc-primary {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
        }

        [data-theme="light"] .btn-mrc-primary:hover {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        }

        [data-theme="light"] .btn-mrc-outline {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
        }

        [data-theme="light"] .btn-mrc-outline:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        [data-theme="light"] .theme-btn-standalone {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .theme-btn-standalone:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }
    </style>
</head>
<body>

    <main class="login-page">
        <!-- Top bar with theme toggle -->
        <div class="login-top-bar">
            <button type="button" class="theme-btn theme-btn-standalone" id="themeToggle" onclick="toggleTheme()" aria-label="Ganti Tema (Dark / Light)" title="Ganti Tema">
                <svg class="icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                </svg>
                <svg class="icon-sun" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                </svg>
                <span class="theme-btn-text">Dark</span>
            </button>
        </div>

        <div class="login-ambient"></div>

        <div class="login-container">
            <!-- Header -->
            <div class="login-brand-header">
                <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1rem;">
                    <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="SMKN 1 Subang" class="login-logo" style="margin-bottom: 0;">
                    <img src="{{ asset('img/logomrc.png') }}" alt="Logo MRC" class="login-logo" style="height: 50px; margin-bottom: 0;">
                </div>
                <h1 class="login-title">Admin BUTAGI</h1>
                <p class="login-subtitle">Masuk ke akun Anda untuk mengelola data buku tamu</p>
            </div>

            <!-- Login Card -->
            <div class="mrc-card" style="width: 100%; padding: 2.25rem; box-shadow: var(--shadow-xl);">
                @if($errors->any())
                <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.75rem 1rem; border-radius: var(--radius-lg); background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; font-size: 0.8125rem; margin-bottom: 1.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form action="/login" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mrc-form-group">
                        <label for="username" class="mrc-label">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Username</span>
                        </label>
                        <input 
                            id="username" 
                            type="text" 
                            name="username" 
                            value="{{ old('username') }}" 
                            class="mrc-input" 
                            placeholder="Masukkan username" 
                            required 
                            autofocus
                        >
                    </div>

                    <!-- Password -->
                    <div class="mrc-form-group">
                        <label for="password" class="mrc-label">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <span>Password</span>
                        </label>
                        <div class="password-wrap">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                class="mrc-input" 
                                style="padding-right: 2.75rem;" 
                                placeholder="••••••••" 
                                required
                            >
                            <button type="button" id="togglePasswordBtn" class="password-toggle-btn" title="Lihat password">
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eyeOffIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                    <line x1="2" y1="2" x2="22" y2="22"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div style="margin-top: 1.75rem;">
                        <button type="submit" class="btn-mrc btn-mrc-primary" style="width: 100%; padding: 0.8125rem; font-size: 0.9375rem; border-radius: var(--radius-xl);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>
                            </svg>
                            <span>Masuk ke Dashboard</span>
                        </button>
                    </div>
                </form>

                <div style="margin-top: 1.5rem; text-align: center; border-top: 1px solid var(--border-main); padding-top: 1.25rem;">
                    <a href="/" class="btn-mrc btn-mrc-outline" style="width: 100%; font-size: 0.8125rem; padding: 0.6rem;">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('butagi_theme', theme);
            const moon = document.querySelector('.icon-moon');
            const sun  = document.querySelector('.icon-sun');
            const txt  = document.querySelector('.theme-btn-text');
            if (moon && sun) {
                if (theme === 'light') {
                    moon.style.display = 'block';
                    sun.style.display  = 'none';
                    if (txt) txt.textContent = 'Dark';
                } else {
                    moon.style.display = 'none';
                    sun.style.display  = 'block';
                    if (txt) txt.textContent = 'Light';
                }
            }
        }

        function toggleTheme() {
            const cur = document.documentElement.getAttribute('data-theme') || 'dark';
            applyTheme(cur === 'dark' ? 'light' : 'dark');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const saved = localStorage.getItem('butagi_theme') || 'dark';
            applyTheme(saved);

            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.style.display = isPassword ? 'none' : 'block';
                eyeOffIcon.style.display = isPassword ? 'block' : 'none';
            });
        });
    </script>

</body>
</html>
