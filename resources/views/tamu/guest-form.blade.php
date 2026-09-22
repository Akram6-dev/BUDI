<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Formulir Kehadiran Tamu - BUTAGI SMKN 1 Subang">
    <title>Formulir Kehadiran — BUTAGI</title>
    <!-- Web App & Fullscreen / PWA meta tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Buku Tamu">
    <meta name="theme-color" content="#090a0f">
    <!-- Anti-flash inline theme loader -->
    <script>
        (function() {
            var theme = localStorage.getItem('butagi_theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ═══════════════════════════════════════════
           DESIGN TOKENS
        ═══════════════════════════════════════════ */
        :root {
            --font:      'Plus Jakarta Sans', system-ui, sans-serif;
            --bg:        #080c18;
            --surface:   rgba(11, 16, 30, 0.92);
            --surface-h: rgba(14, 21, 40, 0.95);
            --indigo:    #6366f1;
            --indigo-l:  #818cf8;
            --violet:    #8b5cf6;
            --accent-g:  linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --emerald:   #10b981;
            --rose:      #f43f5e;
            --text:      #f1f5f9;
            --text-m:    #94a3b8;
            --text-s:    #64748b;
            --border:    rgba(129,140,248,0.16);
            --border-b:  rgba(129,140,248,0.28);
            --border-f:  rgba(129,140,248,0.60);
            --radius-sm: 0.625rem;
            --radius-md: 0.875rem;
            --radius-lg: 1.125rem;
            --radius-xl: 1.375rem;
            --radius-p:  9999px;
            --radius-pill: 9999px;
            --nav-h:     clamp(44px, 6.2vh, 68px);
            --foot-h:    clamp(28px, 4.2vh, 44px);
        }

        /* ═══════════════════════════════════════════
           LIGHT MODE — Refined Neo-Monochrome Minimalist
        ═══════════════════════════════════════════ */
        [data-theme="light"] {
            --bg:        #f8fafc;
            --surface:   #ffffff;
            --surface-h: #f1f5f9;
            --text:      #090a0f;
            --text-m:    #475569;
            --text-s:    #94a3b8;
            --border:    #e2e8f0;
            --border-b:  #cbd5e1;
            --border-f:  #090a0f;
            --indigo:    #090a0f;
            --indigo-l:  #334155;
        }
        [data-theme="light"] body {
            background-color: #f8fafc;
            background-image:
                radial-gradient(circle at 100% 0%, rgba(9, 10, 15, 0.02) 0%, transparent 40%),
                radial-gradient(circle at 0% 100%, rgba(9, 10, 15, 0.015) 0%, transparent 40%);
        }
        [data-theme="light"] .orb-tl {
            background: radial-gradient(circle, rgba(9, 10, 15, 0.025) 0%, transparent 70%);
        }
        [data-theme="light"] .orb-br {
            background: radial-gradient(circle, rgba(9, 10, 15, 0.02) 0%, transparent 70%);
        }
        [data-theme="light"] .navbar {
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid #e2e8f0;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        [data-theme="light"] .nav-name {
            background: linear-gradient(135deg, #090a0f 0%, #1e293b 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        [data-theme="light"] .nav-school {
            color: #64748b;
        }
        [data-theme="light"] .nav-logo-divider {
            background: #e2e8f0;
        }
        [data-theme="light"] .nav-logo-img {
            filter: drop-shadow(0 1px 3px rgba(0, 0, 0, 0.08));
        }
        [data-theme="light"] .nav-logo-img:hover {
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.15));
        }
        [data-theme="light"] .theme-btn {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #334155;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border-radius: var(--radius-p);
        }
        [data-theme="light"] .theme-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #090a0f;
        }
        [data-theme="light"] .nav-home {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #334155;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border-radius: var(--radius-p);
        }
        [data-theme="light"] .nav-home:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #090a0f;
        }
        [data-theme="light"] .footer {
            background: rgba(255, 255, 255, 0.85);
            border-top: 1px solid #e2e8f0;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        [data-theme="light"] .footer span { color: #64748b; }
        [data-theme="light"] .footer span strong { color: #090a0f; }
        [data-theme="light"] .glass-card {
            background: transparent;
            border: none;
            box-shadow: none;
            border-radius: 0;
            padding: 0;
        }
        [data-theme="light"] .card-title { color: #4e9fdf; }
        [data-theme="light"] .card-sub { color: #64748b; }
        [data-theme="light"] .card-title-icon svg { stroke: #090a0f; }
        [data-theme="light"] .field-lbl { 
            color: #0f172a; 
            font-weight: 600; 
            font-size: 0.98rem;
            letter-spacing: -0.01em;
        }
        [data-theme="light"] .field-lbl svg { color: #475569; }
        [data-theme="light"] .field-icon { color: #64748b; }
        [data-theme="light"] .field-wrap {
            position: relative;
        }
        [data-theme="light"] .field-input {
            background: #ffffff !important;
            border: 1.5px solid #cbd5e1 !important;
            color: #090a0f !important;
            font-weight: 400 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.2s ease;
        }
        [data-theme="light"] .field-input:focus {
            background: #ffffff !important;
            border-color: #090a0f !important;
            box-shadow: 0 0 0 3px rgba(9, 10, 15, 0.06) !important;
        }
        [data-theme="light"] .field-input::placeholder { color: #64748b !important; font-size: 0.98rem !important; opacity: 0.9 !important; }
        [data-theme="light"] .field-wrap:focus-within .field-icon { color: #090a0f; }
        [data-theme="light"] .field-wrap .field-icon + .field-input,
        [data-theme="light"] #inputInstansi,
        [data-theme="light"] #inputSekolah {
            padding-left: 2.9rem !important;
        }

        [data-theme="light"] .status-btn {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #090a0f;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }
        [data-theme="light"] .status-btn:hover {
            background: #ffffff;
            border-color: #090a0f;
            box-shadow: 0 6px 16px -4px rgba(9, 10, 15, 0.08);
        }
        [data-theme="light"] #btnInstansi .sbt-icon,
        [data-theme="light"] #btnSekolah .sbt-icon,
        [data-theme="light"] #btnPhoto .sbt-icon,
        [data-theme="light"] #btnSig .sbt-icon {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #090a0f;
        }
        [data-theme="light"] .status-btn:hover .sbt-icon {
            background: #e2e8f0;
        }
        [data-theme="light"] .sbt-name { color: #090a0f; font-weight: 700; }
        [data-theme="light"] .sbt-desc { color: #64748b; }

        [data-theme="light"] .status-pill {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }
        [data-theme="light"] .status-pill:hover {
            background: #f8fafc;
            border-color: #090a0f;
        }
        [data-theme="light"] .status-pill-left {
            color: #334155;
        }
        [data-theme="light"] #pillLabel { color: #090a0f !important; font-weight: 700; }
        [data-theme="light"] .status-pill-change {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        [data-theme="light"] .status-pill:hover .status-pill-change {
            color: #090a0f;
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        /* Light mode card styling for Photo and Signature */
        [data-theme="light"] .media-card-btn {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #090a0f;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }
        [data-theme="light"] .media-card-btn:hover {
            background: #ffffff;
            border-color: #090a0f;
            box-shadow: 0 6px 16px -4px rgba(9, 10, 15, 0.08);
        }
        [data-theme="light"] .media-card-btn.has-value,
        [data-theme="light"] .trigger-btn.has-value {
            background: #f0fdf4 !important;
            border-style: solid !important;
            border-color: #10b981 !important;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.12) !important;
        }
        [data-theme="light"] .media-card-btn.has-value .sbt-icon,
        [data-theme="light"] .trigger-btn.has-value .sbt-icon {
            background: #dcfce7 !important;
            border-color: #86efac !important;
            color: #059669 !important;
        }
        [data-theme="light"] .media-badge {
            background: #059669;
            color: #ffffff;
        }

        /* Rating section in light mode */
        [data-theme="light"] .rating-q { color: #0f172a; font-weight: 600; font-size: clamp(0.82rem, 1.05vh, 0.92rem); text-align: center; }
        [data-theme="light"] .rating-bar {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 4px;
            box-shadow: none;
            border-radius: clamp(0.55rem, 0.9vh, 0.75rem);
        }
        [data-theme="light"] .rating-opt {
            background: transparent;
            color: #64748b;
            border-radius: var(--radius-sm);
        }
        [data-theme="light"] .rating-opt:not(:last-child) {
            border-right: none;
        }
        [data-theme="light"] .rating-opt:hover:not(.active) {
            background: #ffffff;
            color: #090a0f;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        [data-theme="light"] .rating-opt.active,
        [data-theme="light"] .rating-opt[data-v="senang"].active,
        [data-theme="light"] .rating-opt[data-v="menarik"].active,
        [data-theme="light"] .rating-opt[data-v="biasa"].active,
        [data-theme="light"] .rating-opt[data-v="unik"].active,
        [data-theme="light"] .rating-opt[data-v="sedih"].active {
            background: #4e9fdf !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(78, 159, 223, 0.4) !important;
        }

        [data-theme="light"] .btn-submit {
            background: #4e9fdf !important;
            color: #ffffff !important;
            border: 1px solid #418ec8 !important;
            box-shadow: 0 10px 25px -5px rgba(78, 159, 223, 0.4), 0 2px 6px rgba(78, 159, 223, 0.15) !important;
            border-radius: var(--radius-p) !important;
        }
        [data-theme="light"] .btn-submit:hover {
            background: #3e8fc9 !important;
            border-color: #357eb6 !important;
            transform: translateY(-2px);
            box-shadow: 0 16px 36px -6px rgba(78, 159, 223, 0.55), 0 4px 12px rgba(78, 159, 223, 0.2) !important;
        }
        [data-theme="light"] .btn-submit:active {
            transform: translateY(0);
        }

        /* Modals in light mode */
        [data-theme="light"] .modal-win {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 60px -15px rgba(9, 10, 15, 0.15), 0 0 0 1px rgba(9, 10, 15, 0.03);
            border-radius: 1.25rem;
        }
        [data-theme="light"] .modal-head {
            border-bottom: 1px solid #f1f5f9;
        }
        [data-theme="light"] .modal-head-title {
            color: #090a0f;
            font-weight: 700;
        }
        [data-theme="light"] .modal-head-icon {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #090a0f;
        }
        [data-theme="light"] .modal-close {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        [data-theme="light"] .modal-close:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #090a0f;
        }
        [data-theme="light"] .modal-foot {
            border-top: 1px solid #f1f5f9;
            background: #ffffff;
        }
        [data-theme="light"] .btn-ghost {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        [data-theme="light"] .btn-ghost:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #090a0f;
        }
        [data-theme="light"] .btn-danger-ghost {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
        }
        [data-theme="light"] .btn-danger-ghost:hover {
            background: #ffe4e6;
            border-color: #fda4af;
            color: #be123c;
        }
        [data-theme="light"] .btn-primary {
            background: #090a0f;
            color: #ffffff;
            border: 1px solid #18181b;
            box-shadow: 0 4px 14px rgba(9, 10, 15, 0.18);
        }
        [data-theme="light"] .btn-primary:hover {
            background: #000000;
            box-shadow: 0 6px 18px rgba(9, 10, 15, 0.25);
        }
        [data-theme="light"] .cam-screen {
            border-color: #e2e8f0;
        }
        [data-theme="light"] .cam-hint {
            color: #64748b;
        }
        [data-theme="light"] .sig-box {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
        }
        [data-theme="light"] .sig-hint {
            color: #94a3b8;
        }
        [data-theme="light"] .success-win {
            background: #ffffff !important;
            border-color: #a7f3d0 !important;
            box-shadow: 0 25px 60px -15px rgba(9, 10, 15, 0.15) !important;
        }
        [data-theme="light"] .success-title { color: #090a0f !important; }
        [data-theme="light"] .success-desc { color: #475569 !important; }
        [data-theme="light"] .success-countdown {
            background: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
            color: #334155 !important;
        }
        [data-theme="light"] .btn-success-home {
            background: #090a0f !important;
            color: #ffffff !important;
        }
        [data-theme="light"] .btn-success-home:hover {
            background: #1e293b !important;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            overflow-wrap: anywhere;
        }

        html, body {
            height: 100dvh;
            max-height: 100dvh;
            width: 100%;
            max-width: 100vw;
            overflow: hidden;
            font-family: var(--font);
            background-color: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        img, video {
            max-width: 100%;
            height: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ═══════════════════════════════════════════
           AMBIENT ORBS (background depth)
        ═══════════════════════════════════════════ */
        .orb {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(100px);
            z-index: 0;
            max-width: 100vw;
        }
        .orb-tl { width:500px; height:400px; top:-120px; left:-100px;
            background:radial-gradient(circle, rgba(79,70,229,0.42) 0%, transparent 65%); }
        .orb-br { width:440px; height:360px; bottom:-100px; right:-80px;
            background:radial-gradient(circle, rgba(139,92,246,0.35) 0%, transparent 65%); }

        /* ═══════════════════════════════════════════
           ROOT WRAPPER — 100dvh flex column (No-Scroll Kiosk)
        ═══════════════════════════════════════════ */
        .root {
            position: relative;
            z-index: 1;
            height: 100dvh;
            max-height: 100dvh;
            width: 100%;
            max-width: 100vw;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ═══════════════════════════════════════════
           COMPACT NAVBAR
        ═══════════════════════════════════════════ */
        .navbar {
            position: relative;
            z-index: 50;
            height: var(--nav-h);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(1rem, 3vw, 3.5rem);
            background: rgba(8,12,24,0.80);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: clamp(0.6rem, 1vw, 1rem);
            text-decoration: none;
            color: var(--text);
        }
        .nav-logos {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }
        .nav-logo-img {
            height: clamp(26px, 4vh, 42px);
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 0 6px rgba(129,140,248,0.35));
            transition: filter 0.2s;
        }
        .nav-logo-img:hover { filter: drop-shadow(0 0 10px rgba(129,140,248,0.6)); }
        .nav-logo-divider {
            width: 1px;
            height: clamp(18px, 2.6vh, 26px);
            background: var(--border-b);
        }
        .nav-wordmark {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }
        .nav-name {
            font-size: clamp(0.95rem, 1.25vw, 1.45rem);
            font-weight: 900;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #ffffff 30%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }
        .nav-school {
            font-size: clamp(0.62rem, 0.75vw, 0.85rem);
            font-weight: 500;
            color: var(--text-m);
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: clamp(0.35rem, 0.7vw, 0.6rem);
            flex-shrink: 0;
        }

        .nav-home, .theme-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem;
            font-size: 0.78rem; font-weight: 600; color: var(--text-m);
            text-decoration: none;
            min-height: 36px;
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-p);
            border: 1px solid var(--border-b);
            background: rgba(15,23,42,0.5);
            transition: all 0.2s;
            backdrop-filter: blur(10px);
            font-family: var(--font);
            line-height: 1.3;
            cursor: pointer;
            flex-shrink: 0;
            box-sizing: border-box;
        }
        .nav-home svg, .theme-btn svg {
            width: 15px;
            height: 15px;
        }
        .nav-home:hover, .theme-btn:hover { color: var(--text); border-color: var(--border-f); background: rgba(49,46,129,0.3); }

        /* ═══════════════════════════════════════════
           KIOSK HERO / WELCOME VIEW (No-Reload SPA)
        ═══════════════════════════════════════════ */
        .hero {
            position: relative;
            z-index: 1;
            flex: 1 1 0;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0;
            width: 100%;
            padding: clamp(0.5rem, 2vh, 1.5rem) 0;
            box-sizing: border-box;
            overflow: hidden;
        }

        .hero-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: clamp(1rem, 2.5vh, 2.2rem);
            padding: 0 clamp(1rem, 3vw, 3rem);
        }

        .hero-title {
            font-size: clamp(2rem, min(6.5vw, 8vh), 4.8rem);
            font-weight: 900;
            letter-spacing: -0.045em;
            line-height: 1.15;
            padding-bottom: 0.1em;
            max-width: min(94vw, 1100px);
            animation: fadeDown 0.6s ease both;
        }

        .title-gradient {
            background: linear-gradient(145deg, #ffffff 0%, #c7d2fe 45%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            padding-bottom: 0.12em;
        }

        [data-theme="light"] .title-gradient {
            background: linear-gradient(145deg, #090a0f 0%, #1e293b 60%, #475569 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: clamp(0.5rem, 0.8vw, 0.9rem);
            min-height: 48px;
            padding: clamp(0.75rem, 1.6vh, 1.35rem) clamp(1.75rem, 3vw, 3.75rem);
            font-size: clamp(0.95rem, min(1.2vw, 2vh), 1.35rem);
            font-weight: 700;
            font-family: var(--font);
            color: #ffffff;
            text-decoration: none;
            border-radius: var(--radius-pill);
            background: var(--accent-g);
            border: 1px solid rgba(165,180,252,0.25);
            box-sizing: border-box;
            box-shadow:
                0 0 0 1px rgba(79,70,229,0.35) inset,
                0 12px 32px -4px rgba(79,70,229,0.55),
                0 0 24px rgba(139,92,246,0.35);
            cursor: pointer;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeUp 0.6s 0.15s ease both;
            position: relative;
            overflow: hidden;
        }
        [data-theme="light"] .cta-btn {
            background: #090a0f;
            color: #ffffff;
            border: 1px solid #18181b;
            box-shadow: 0 10px 25px -5px rgba(9, 10, 15, 0.22), 0 2px 6px rgba(9, 10, 15, 0.08);
        }
        [data-theme="light"] .cta-btn:hover {
            background: #000000;
            transform: translateY(-3px) scale(1.025);
            box-shadow: 0 16px 36px -6px rgba(9, 10, 15, 0.35), 0 4px 12px rgba(9, 10, 15, 0.12);
        }
        .cta-btn:hover { 
            transform: translateY(-3px) scale(1.025);
            box-shadow:
                0 0 0 1px rgba(165,180,252,0.4) inset,
                0 18px 42px -4px rgba(79,70,229,0.7),
                0 0 36px rgba(139,92,246,0.5);
        }
        .cta-btn:active { transform: translateY(0) scale(0.985); }

        .cta-icon {
            width: clamp(18px, 1.4vw, 26px);
            height: clamp(18px, 1.4vw, 26px);
            transition: transform 0.25s;
        }
        .cta-btn:hover .cta-icon { transform: translateX(3px); }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════════
           MAIN STAGE — center the card
        ═══════════════════════════════════════════ */
        .stage {
            flex: 1 1 0;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(0.35rem, 1vh, 0.75rem) clamp(0.75rem, 2vw, 1.5rem);
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }
        .stage::-webkit-scrollbar {
            width: 5px;
        }
        .stage::-webkit-scrollbar-track {
            background: transparent;
        }
        .stage::-webkit-scrollbar-thumb {
            background: rgba(129, 140, 248, 0.25);
            border-radius: 9999px;
        }

        /* ═══════════════════════════════════════════
           FORM CONTENT CONTAINER (Direct Content, Seamless)
        ═══════════════════════════════════════════ */
        .glass-card {
            width: 100%;
            max-width: clamp(300px, 94vw, 700px);
            background: transparent;
            border: none;
            border-radius: 0;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            box-shadow: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: clamp(0.45rem, 1.3vh, 0.95rem);
            margin: auto 0;
            box-sizing: border-box;
        }

        /* Form header */
        .card-header { 
            text-align: center;
        }
        .card-title {
            font-size: clamp(1.55rem, min(2.3vw, 3.2vh), 2rem);
            font-weight: 800; letter-spacing: -0.03em;
            color: #4e9fdf; line-height: 1.2;
            display: flex; align-items: center; justify-content: center;
        }
        .card-title-icon { display: none; }
        .card-sub {
            font-size: clamp(0.85rem, 1vw, 0.95rem);
            color: var(--text-m);
            margin-top: 0.45rem;
            font-weight: 500;
            text-align: center;
        }

        /* ═══════════════════════════════════════════
           FORM STACK
        ═══════════════════════════════════════════ */
        .form-stack {
            display: flex;
            flex-direction: column;
            gap: clamp(1.05rem, 2.3vh, 1.55rem);
        }

        /* Field group */
        .field {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }
        .field-lbl {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.98rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: var(--text);
            line-height: 1.3;
        }
        .field-lbl .lbl-emoji {
            font-size: 1.05em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        .field-lbl .lbl-text {
            line-height: 1.2;
        }
        .field-lbl svg {
            color: var(--indigo-l);
            flex-shrink: 0;
            width: 18px;
            height: 18px;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute; left: 0.95rem; top: 50%;
            transform: translateY(-50%); pointer-events: none;
            color: var(--indigo-l);
            width: 16px;
            height: 16px;
        }
        .field-input {
            width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.98rem;
            font-weight: 400; font-family: var(--font);
            color: var(--text);
            background: rgba(15,23,42,0.7);
            border: 1.5px solid var(--border-b);
            border-radius: 0.55rem;
            min-height: 48px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            box-sizing: border-box;
        }
        .field-wrap .field-icon + .field-input,
        #inputInstansi,
        #inputSekolah {
            padding-left: 2.9rem !important;
        }
        .field-input::placeholder { color: var(--text-s); font-weight: 400; font-size: 0.98rem; opacity: 0.9; }
        .field-input:focus {
            border-color: var(--border-f);
            background: rgba(15,23,42,0.9);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2), 0 0 16px rgba(99,102,241,0.15);
        }

        /* ═══════════════════════════════════════════
           STATUS SELECTOR (morphing big buttons → pill)
        ═══════════════════════════════════════════ */
        .status-big-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: clamp(0.55rem, 1.2vh, 0.85rem);
            width: 100%;
        }

        .status-btn {
            display: flex; flex-direction: column; align-items: flex-start;
            gap: clamp(0.3rem, 0.6vh, 0.45rem);
            padding: clamp(0.6rem, 1.2vh, 0.85rem) clamp(0.75rem, 1.1vw, 1rem);
            background: rgba(15,23,42,0.65);
            border: 1.5px solid var(--border-b);
            border-radius: clamp(0.45rem, 0.8vh, 0.65rem);
            cursor: pointer; color: var(--text);
            font-family: var(--font);
            transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
            text-align: left;
            min-height: 52px;
            box-sizing: border-box;
        }
        .status-btn:hover {
            background:rgba(49,46,129,0.35);
            border-color:var(--border-f);
            transform:translateY(-1px);
            box-shadow:0 6px 20px rgba(79,70,229,0.25);
        }
        .status-btn:active { transform:translateY(0); }

        .sbt-icon {
            width: clamp(24px, 3.2vh, 34px);
            height: clamp(24px, 3.2vh, 34px);
            border-radius: clamp(0.35rem, 0.65vh, 0.55rem);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        #btnInstansi .sbt-icon {
            background: rgba(79, 70, 229, 0.22);
            border: 1px solid rgba(129, 140, 248, 0.3);
            color: #818cf8;
        }
        #btnSekolah .sbt-icon {
            background: rgba(168, 85, 247, 0.22);
            border: 1px solid rgba(192, 132, 252, 0.3);
            color: #c084fc;
        }
        #btnPhoto .sbt-icon {
            background: rgba(56, 189, 248, 0.22);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: #38bdf8;
        }
        #btnSig .sbt-icon {
            background: rgba(168, 85, 247, 0.22);
            border: 1px solid rgba(192, 132, 252, 0.35);
            color: #c084fc;
        }
        .sbt-svg {
            width: clamp(14px, 1.8vh, 18px);
            height: clamp(14px, 1.8vh, 18px);
            display: block;
        }
        .pill-svg { width: 16px; height: 16px; vertical-align: middle; flex-shrink: 0; }

        html[data-theme="dark"] .sbt-svg-dark  { display: inline-block !important; }
        html[data-theme="dark"] .sbt-svg-light { display: none !important; }
        html[data-theme="light"] .sbt-svg-dark  { display: none !important; }
        html[data-theme="light"] .sbt-svg-light { display: inline-block !important; }

        .sbt-name {
            font-size: clamp(0.88rem, 1.1vh, 0.98rem);
            font-weight: 700; letter-spacing: -0.01em;
            color: var(--text);
        }
        .sbt-desc {
            font-size: clamp(0.72rem, 0.9vh, 0.82rem);
            color: var(--text-m); font-weight: 500;
        }

        /* Selected pill */
        .status-pill {
            display: none;
            align-items: center; justify-content: space-between;
            padding: clamp(0.35rem, 0.7vh, 0.5rem) clamp(0.65rem, 1vw, 0.85rem);
            border-radius: var(--radius-p);
            border: 1.5px solid var(--border-f);
            background: rgba(79,70,229,0.15);
            cursor: pointer;
            transition: all 0.2s;
        }
        .status-pill:hover { background: rgba(79,70,229,0.25); }
        .status-pill-left {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: clamp(0.9rem, 1.15vh, 1.05rem);
            font-weight: 700; color: #c7d2fe;
        }
        .status-pill-emoji { font-size: 1rem; }
        .status-pill-change {
            display: inline-flex; align-items: center; gap: 0.25rem;
            font-size: clamp(0.78rem, 0.95vh, 0.88rem);
            font-weight: 600; color: var(--text-m);
            padding: 0.25rem 0.65rem;
            border-radius: var(--radius-p);
            background: rgba(15,23,42,0.6);
            border: 1px solid var(--border-b);
            transition: all 0.15s;
        }
        .status-pill:hover .status-pill-change { color: var(--text); }

        /* Conditional input (slides in) */
        .cond-input {
            display: none;
            overflow: hidden;
            margin-top: clamp(0.5rem, 1vh, 0.75rem);
            animation: slideIn 0.22s ease;
        }
        .cond-input.visible { display: block; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════════
           PHOTO & SIGNATURE BUTTONS (Matches status-btn card style)
        ═══════════════════════════════════════════ */
        .media-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(0.55rem, 1.2vh, 0.85rem);
            width: 100%;
        }

        .media-card-btn {
            position: relative;
            width: 100%;
        }

        .media-btn-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .media-card-btn.has-value {
            border-color: rgba(16,185,129,0.55);
            background: rgba(16,185,129,0.08);
        }
        .media-card-btn.has-value .sbt-icon {
            background: rgba(16,185,129,0.22);
            border-color: rgba(16,185,129,0.45);
            color: var(--emerald);
        }
        .media-card-btn.has-value .sbt-name {
            color: var(--text);
        }

        .media-thumb-img {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }

        .media-badge {
            display: none;
            position: absolute;
            top: clamp(6px, 1vh, 8px);
            right: clamp(8px, 1.1vw, 10px);
            font-size: clamp(0.54rem, 0.74vh, 0.64rem);
            font-weight: 700;
            color: #ffffff;
            background: var(--emerald);
            padding: 0.12rem 0.45rem;
            border-radius: var(--radius-p);
            letter-spacing: 0.02em;
        }
        .media-card-btn.has-value .media-badge {
            display: inline-flex;
            align-items: center;
        }

        /* Fallback aliases for legacy trigger-btn */
        .trigger-btn {
            position: relative;
        }
        .trigger-thumb {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }
        .trigger-badge {
            display: none;
            position: absolute;
            top: 6px;
            right: 8px;
            font-size: 0.6rem;
            font-weight: 700;
            color: #fff;
            background: var(--emerald);
            padding: 0.1rem 0.4rem;
            border-radius: var(--radius-p);
        }
        .trigger-btn.has-value .trigger-badge { display: block; }

        /* ═══════════════════════════════════════════
           EMOJI RATING TRACK BAR
        ═══════════════════════════════════════════ */
        .rating-section {
            display: flex; flex-direction: column;
            gap: clamp(0.5rem, 1vh, 0.72rem);
        }
        .rating-q {
            font-size: clamp(0.98rem, 1.35vh, 1.15rem);
            font-weight: 700; color: var(--text);
            text-align: center;
            line-height: 1.3; letter-spacing: -0.01em;
        }
        .rating-bar {
            display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
            border-radius: clamp(0.45rem, 0.8vh, 0.65rem);
            overflow: hidden;
            border: 1.5px solid var(--border-b);
            width: 100%;
        }
        .rating-opt {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: clamp(0.18rem, 0.38vh, 0.3rem);
            padding: clamp(0.45rem, 1vh, 0.65rem) clamp(0.35rem, 0.7vw, 0.65rem);
            cursor: pointer;
            font-size: clamp(0.62rem, 0.78vh, 0.7rem);
            font-weight: 600; color: var(--text-m);
            background: rgba(15,23,42,0.6);
            border: none; font-family: var(--font);
            transition: all 0.18s;
            min-height: 44px;
            box-sizing: border-box;
        }
        .rating-opt:not(:last-child) { border-right: 1px solid var(--border); }
        .rating-opt .r-emoji {
            font-size: clamp(0.92rem, 1.45vh, 1.25rem);
            line-height: 1.1;
            transition: transform 0.2s; filter: grayscale(1) opacity(0.5);
        }

        /* Senang, Menarik, Unik when active - styled #4e9fdf */
        .rating-opt.active,
        .rating-opt[data-v="senang"].active,
        .rating-opt[data-v="menarik"].active,
        .rating-opt[data-v="biasa"].active,
        .rating-opt[data-v="unik"].active,
        .rating-opt[data-v="sedih"].active { 
            background: #4e9fdf !important; 
            color: #ffffff !important; 
            border: 1px solid #418ec8 !important;
            box-shadow: 0 4px 14px rgba(78, 159, 223, 0.4) !important;
        }
        .rating-opt.active .r-emoji { filter: none !important; transform: scale(1.18); }
        .rating-opt[data-v="senang"]:hover:not(.active),
        .rating-opt[data-v="menarik"]:hover:not(.active),
        .rating-opt[data-v="biasa"]:hover:not(.active),
        .rating-opt[data-v="unik"]:hover:not(.active),
        .rating-opt[data-v="sedih"]:hover:not(.active) { background: rgba(255,255,255,0.06); }

        /* ═══════════════════════════════════════════
           SUBMIT BUTTON
        ═══════════════════════════════════════════ */
        .btn-submit {
            width: 100%;
            margin-top: clamp(0.45rem, 1.1vh, 0.8rem);
            min-height: 48px;
            padding: clamp(0.65rem, 1.3vh, 0.85rem) clamp(1rem, 1.6vw, 1.4rem);
            font-size: clamp(0.76rem, 0.95vh, 0.85rem);
            font-weight: 800; font-family: var(--font);
            color: #fff;
            background: #4e9fdf;
            border: 1px solid #418ec8;
            border-radius: clamp(0.45rem, 0.8vh, 0.65rem);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            gap: clamp(0.3rem, 0.6vw, 0.55rem);
            box-shadow:
                0 0 0 1px rgba(78,159,223,0.3) inset,
                0 8px 24px -4px rgba(78,159,223,0.5),
                0 0 16px rgba(78,159,223,0.25);
            transition:all 0.25s cubic-bezier(0.4,0,0.2,1);
            position:relative; overflow:hidden;
            box-sizing: border-box;
        }
        .btn-submit::before {
            content:''; position:absolute; inset:0;
            background:linear-gradient(135deg,rgba(255,255,255,0.15) 0%,transparent 55%);
            opacity:0; transition:opacity 0.2s;
        }
        .btn-submit:hover {
            transform:translateY(-2px);
            background: #3e8fc9;
            border-color: #357eb6;
            box-shadow:
                0 0 0 1px rgba(78,159,223,0.35) inset,
                0 14px 36px -4px rgba(78,159,223,0.65),
                0 0 28px rgba(78,159,223,0.4);
        }
        .btn-submit:hover::before { opacity:1; }
        .btn-submit:active { transform:translateY(0) scale(0.987); }
        .btn-submit:disabled { opacity:0.6; pointer-events:none; }

        /* ═══════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════ */
        .footer {
            position: relative;
            z-index: 50;
            min-height: var(--foot-h);
            height: auto;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.45rem clamp(0.75rem, 3vw, 3.5rem);
            border-top: 1px solid var(--border);
            background: rgba(8, 12, 24, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-sizing: border-box;
            overflow-wrap: anywhere;
        }
        .footer span {
            font-size: clamp(0.68rem, 0.85vw, 0.92rem);
            font-weight: 500;
            color: var(--text-m);
            letter-spacing: 0.02em;
            text-align: center;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        @keyframes spin { to { transform:rotate(360deg); } }
        .spin { animation:spin 0.9s linear infinite; }

        /* ═══════════════════════════════════════════
           MODAL BACKDROP & WINDOW
        ═══════════════════════════════════════════ */
        .modal-backdrop {
            display:none;
            position:fixed; inset:0; z-index:200;
            background:rgba(4,7,16,0.82);
            backdrop-filter:blur(8px);
            align-items:center; justify-content:center;
        }
        .modal-backdrop.open { display:flex; }

        .modal-win {
            width: min(calc(100% - 24px), 520px);
            max-width: 100%;
            max-height: calc(100dvh - 24px);
            display: flex; flex-direction: column;
            background: rgba(11,16,30,0.97);
            border: 1px solid var(--border-b);
            border-radius: var(--radius-xl);
            box-shadow: 0 32px 80px -12px rgba(0,0,0,0.85), 0 0 40px rgba(79,70,229,0.2);
            overflow: hidden;
            animation: modalIn 0.28s cubic-bezier(0.34,1.56,0.64,1);
            box-sizing: border-box;
        }
        @keyframes modalIn {
            from { opacity:0; transform:scale(0.9) translateY(16px); }
            to   { opacity:1; transform:scale(1)   translateY(0); }
        }

        .modal-head {
            display:flex; align-items:center; justify-content:space-between;
            padding:1rem 1.25rem;
            border-bottom:1px solid var(--border);
        }
        .modal-head-title {
            display:flex; align-items:center; gap:0.5rem;
            font-size:0.9375rem; font-weight:800; color:var(--text);
        }
        .modal-head-icon {
            width:30px; height:30px; border-radius:0.5rem;
            background:rgba(99,102,241,0.2);
            display:flex; align-items:center; justify-content:center;
            color:var(--indigo-l);
        }
        .modal-head-actions {
            display: flex; align-items: center; gap: 0.45rem;
        }
        .modal-action-btn,
        .modal-close {
            width: 44px; height: 44px; min-width: 44px; min-height: 44px;
            border-radius: 50%; border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.05);
            color: var(--text-m); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
            box-sizing: border-box;
        }
        .modal-action-btn:hover,
        .modal-close:hover {
            color:#ffffff;
            background:rgba(255,255,255,0.12);
            border-color:rgba(255,255,255,0.2);
            transform:scale(1.05);
        }

        .modal-body { padding:1.125rem 1.25rem; }
        .modal-foot {
            display:flex; align-items:center; justify-content:space-between;
            gap:0.5rem; padding:0.875rem 1.25rem;
            border-top:1px solid rgba(255,255,255,0.08);
            background:transparent;
        }
        .modal-foot-right { display:flex; gap:0.5rem; margin-left:auto; }

        /* ═══════════════════════════════════════════
           CAMERA MODAL
        ═══════════════════════════════════════════ */
        .cam-screen {
            position:relative;
            background:#000;
            border-radius:var(--radius-lg);
            overflow:hidden;
            aspect-ratio:4/3;
            width:100%;
            border:1px solid var(--border);
        }
        .cam-screen video {
            width:100%; height:100%;
            object-fit:cover;
            display:block;
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
        }
        .cam-screen img {
            width:100%; height:100%;
            object-fit:cover;
            display:none;
        }


        /* ═══════════════════════════════════════════
           CAMERA 3S COUNTDOWN OVERLAY
        ═══════════════════════════════════════════ */
        .cam-countdown {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
            z-index: 10;
            pointer-events: none;
        }
        .countdown-badge {
            width: clamp(72px, 13vh, 104px);
            height: clamp(72px, 13vh, 104px);
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.85);
            border: 3px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 0 35px rgba(99, 102, 241, 0.7), inset 0 0 20px rgba(99, 102, 241, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .countdown-num {
            font-size: clamp(2.6rem, 5.5vh, 4rem);
            font-weight: 900;
            color: #ffffff;
            font-family: var(--font);
            line-height: 1;
            text-shadow: 0 0 24px rgba(99, 102, 241, 0.9);
            animation: countPulse 0.95s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        @keyframes countPulse {
            0%   { transform: scale(0.6); opacity: 0; }
            45%  { transform: scale(1.18); opacity: 1; }
            100% { transform: scale(1); opacity: 0.9; }
        }

        /* Flash effect */
        .cam-flash {
            position:absolute; inset:0;
            background:#fff; opacity:0;
            pointer-events:none;
            transition:opacity 0.05s;
        }
        .cam-flash.flash { opacity:0.85; }

        .cam-hint {
            margin-top:0.5rem; text-align:center;
            font-size:0.75rem; color:var(--text-m); font-weight:500;
        }

        /* Small action button */
        .btn-sm {
            display:inline-flex; align-items:center; gap:0.35rem;
            padding:0.45rem 0.9rem;
            font-size:0.8rem; font-weight:700; font-family:var(--font);
            border-radius:var(--radius-p); cursor:pointer;
            transition:all 0.18s; border:1px solid transparent;
        }
        .btn-ghost {
            background:rgba(15,23,42,0.55);
            color:var(--text-m); border-color:var(--border-b);
        }
        .btn-ghost:hover { color:var(--text); border-color:var(--border-f); background:rgba(49,46,129,0.3); }
        .btn-primary {
            background:var(--accent-g); color:#fff;
            box-shadow:0 4px 14px rgba(79,70,229,0.4);
        }
        .btn-primary:hover { box-shadow:0 6px 20px rgba(79,70,229,0.6); transform:translateY(-1px); }
        .btn-danger-ghost { background:rgba(244,63,94,0.1); color:#fb7185; border-color:rgba(244,63,94,0.3); }
        .btn-danger-ghost:hover { background:rgba(244,63,94,0.2); }

        /* ═══════════════════════════════════════════
           SIGNATURE MODAL
        ═══════════════════════════════════════════ */
        .sig-box {
            position:relative;
            border-radius:var(--radius-lg);
            overflow:hidden;
            border:1.5px solid var(--border-b);
            background:#ffffff;
            height: clamp(130px, 24vh, 200px);
            cursor:crosshair;
        }
        .sig-box canvas {
            width:100%; height:100%; display:block;
        }
        .sig-hint {
            position:absolute; inset:0;
            display:flex; align-items:center; justify-content:center; gap:0.5rem;
            font-size:0.8rem; font-weight:600; color:#94a3b8;
            pointer-events:none;
            transition:opacity 0.2s;
        }
        .sig-hint.hidden { opacity:0; }

        /* ═══════════════════════════════════════════
           TOAST NOTIFICATION
        ═══════════════════════════════════════════ */
        .toast {
            position:fixed; top:calc(var(--nav-h) + 10px);
            left:50%; transform:translateX(-50%);
            z-index:999;
            display:none;
            align-items:center; gap:0.5rem;
            padding:0.55rem 1.1rem;
            border-radius:var(--radius-p);
            font-size:0.8125rem; font-weight:700;
            backdrop-filter:blur(16px);
            box-shadow:0 8px 28px rgba(0,0,0,0.4);
            animation:toastIn 0.25s ease;
        }
        .toast.visible { display:flex; }
        .toast.success {
            background:rgba(5,150,105,0.95);
            border:1px solid #10b981; color:#fff;
        }
        .toast.error {
            background:rgba(220,38,38,0.95);
            border:1px solid #ef4444; color:#fff;
        }
        @keyframes toastIn {
            from { opacity:0; transform:translate(-50%,-8px); }
            to   { opacity:1; transform:translate(-50%,0); }
        }

        /* ═══════════════════════════════════════════
           SUCCESS POPUP MODAL STYLES
        ═══════════════════════════════════════════ */
        .success-win {
            width: min(calc(100% - 24px), 460px) !important;
            max-width: 100% !important;
            text-align: center;
            border-color: rgba(16, 185, 129, 0.35) !important;
            box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.85), 0 0 45px rgba(16, 185, 129, 0.18) !important;
            box-sizing: border-box;
        }
        .success-body {
            padding: clamp(1.75rem, 4vh, 2.4rem) clamp(1.25rem, 3.5vw, 2.2rem);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.85rem;
        }
        .success-icon-wrap {
            position: relative;
            width: clamp(68px, 11vh, 88px);
            height: clamp(68px, 11vh, 88px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.35rem;
        }
        .success-icon-pulse {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.28);
            animation: successPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .success-icon-circle {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 28px -4px rgba(16, 185, 129, 0.55);
            animation: successPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes successPulse {
            0%   { transform: scale(0.95); opacity: 0.85; }
            50%  { transform: scale(1.38); opacity: 0; }
            100% { transform: scale(0.95); opacity: 0; }
        }
        @keyframes successPop {
            0%   { transform: scale(0.4) rotate(-20deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .success-title {
            font-size: clamp(1.3rem, 2.4vw, 1.65rem);
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--text);
            margin: 0;
            line-height: 1.2;
        }
        .success-desc {
            font-size: clamp(0.85rem, 1.1vw, 0.95rem);
            color: var(--text-m);
            line-height: 1.55;
            margin: 0;
            max-width: 360px;
        }
        .success-countdown {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--indigo-l);
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(129, 140, 248, 0.2);
            padding: 0.4rem 1rem;
            border-radius: var(--radius-p);
            margin-top: 0.2rem;
        }
        .btn-success-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.75rem 1.75rem;
            border-radius: var(--radius-p);
            font-size: 0.875rem;
            font-weight: 700;
            color: #ffffff;
            background: var(--accent-g);
            text-decoration: none;
            box-shadow: 0 4px 18px rgba(79, 70, 229, 0.45);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .btn-success-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 26px rgba(79, 70, 229, 0.6);
            color: #ffffff;
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE BREAKPOINTS (Mobile-First Architecture)
        ═══════════════════════════════════════════ */
        
        /* ─── Compact Mobile (<= 480px, e.g. 360px, 390px, 414px) ─── */
        @media (max-width: 480px) {
            .navbar {
                padding: 0 clamp(0.5rem, 2vw, 0.75rem);
                gap: 0.35rem;
            }
            .nav-brand {
                gap: 0.35rem;
                min-width: 0;
            }
            .nav-logos {
                gap: 0.25rem;
            }
            .nav-logo-img {
                height: 25px;
            }
            .nav-logo-divider {
                height: 15px;
            }
            .nav-name {
                font-size: 1rem;
            }
            .nav-school {
                font-size: 0.62rem;
            }
            .nav-text {
                display: none !important;
            }
            .nav-home, .theme-btn {
                padding: 0 0.5rem;
                min-height: 36px;
                min-width: 36px;
                justify-content: center;
            }
            .stage {
                padding: clamp(0.25rem, 0.8vh, 0.5rem) clamp(0.5rem, 2vw, 0.85rem);
            }
            .glass-card {
                max-width: 100%;
                margin: 0;
                gap: clamp(0.35rem, 1vh, 0.65rem);
            }
            .card-title {
                font-size: clamp(1.3rem, 5.5vw, 1.6rem);
                line-height: 1.15;
            }
            .card-sub {
                font-size: 0.78rem;
                margin-top: 0.15rem;
                line-height: 1.25;
            }
            .form-stack {
                gap: clamp(0.3rem, 0.9vh, 0.55rem);
            }
            .field {
                gap: 0.15rem;
            }
            .field-lbl {
                font-size: 0.84rem;
                font-weight: 600;
                gap: 0.3rem;
            }
            .field-lbl svg {
                width: 15px;
                height: 15px;
            }
            .field-input {
                padding: 0.35rem 0.8rem;
                font-size: 0.85rem;
                min-height: clamp(36px, 4.5vh, 42px);
                border-radius: 0.5rem;
            }
            .field-input::placeholder {
                font-size: 0.85rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 14px;
                height: 14px;
                left: 0.75rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 2.6rem !important;
            }
            .status-big-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.4rem;
            }
            .status-btn {
                padding: 0.35rem 0.6rem;
                min-height: clamp(42px, 5.2vh, 48px);
                border-radius: 0.5rem;
                gap: 0.25rem;
            }
            .sbt-icon {
                width: 24px;
                height: 24px;
            }
            .sbt-name {
                font-size: 0.84rem;
                line-height: 1.2;
            }
            .sbt-desc {
                font-size: 0.68rem;
                line-height: 1.15;
            }
            .media-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.4rem;
            }
            .media-card-btn, .trigger-btn {
                padding: 0.35rem 0.6rem;
                min-height: clamp(42px, 5.2vh, 48px);
                border-radius: 0.5rem;
                gap: 0.25rem;
            }
            .trigger-lbl {
                font-size: 0.84rem;
            }
            .rating-section {
                gap: 0.25rem;
            }
            .rating-q {
                font-size: 0.82rem;
            }
            .rating-bar {
                border-radius: 0.5rem;
                padding: 0.2rem;
                gap: 0.35rem;
            }
            .rating-opt {
                min-height: clamp(32px, 4vh, 38px);
                padding: 0.2rem 0.4rem;
                font-size: 0.68rem;
                gap: 0.25rem;
            }
            .rating-opt .r-emoji {
                font-size: 1.1rem;
            }
            .btn-submit {
                font-size: 0.88rem;
                min-height: clamp(38px, 4.6vh, 44px);
                border-radius: 0.55rem;
                padding: 0.45rem 1.2rem;
                margin-top: 0.15rem;
            }
            .footer {
                padding: 0.35rem 0.8rem;
                gap: 0.5rem;
            }
            .footer span {
                font-size: 0.68rem;
                line-height: 1.4;
            }
        }

        /* ─── Very Small Mobile (<= 360px) ─── */
        @media (max-width: 360px) {
            .navbar {
                padding: 0 0.75rem;
            }
            .nav-logos { gap: 0.35rem; }
            .nav-logo-img { height: 26px; }
            .nav-school {
                display: none;
            }
            .theme-btn span, .nav-home span {
                font-size: 0.72rem;
            }
            .stage {
                padding: 0.4rem 0.6rem;
            }
            .glass-card {
                gap: 0.65rem;
            }
            .card-title {
                font-size: 1.45rem;
            }
            .form-stack {
                gap: 0.7rem;
            }
            .field-lbl {
                font-size: 1.02rem;
            }
            .field-input {
                font-size: 0.9rem;
                min-height: 42px;
            }
            .status-btn {
                padding: 0.5rem 0.45rem;
                min-height: 50px;
            }
            .sbt-desc {
                font-size: 0.58rem;
                line-height: 1.25;
            }
            .trigger-btn {
                padding: 0.5rem 0.4rem;
                font-size: 0.7rem;
            }
        }

        /* ─── Phablets & Small Tablets (>= 640px) ─── */
        @media (min-width: 640px) and (max-width: 767px) {
            .glass-card {
                max-width: 580px;
            }
            .card-title {
                font-size: clamp(2.2rem, 4.8vw, 2.65rem);
                font-weight: 900;
                letter-spacing: -0.025em;
                line-height: 1.12;
            }
            .card-sub {
                font-size: 1.05rem;
                margin-top: 0.85rem;
            }
            .navbar {
                padding: 0 1.5rem;
            }
            .field-lbl {
                font-size: 1.02rem;
                font-weight: 600;
                gap: 0.45rem;
            }
            .field-lbl svg {
                width: 18px;
                height: 18px;
            }
            .rating-q {
                font-size: 1.25rem;
                font-weight: 700;
            }
            .status-big-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }
            .media-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }
        }

        /* ─── Tablets (iPad Mini / Standard: 768px - 899px) ─── */
        @media (min-width: 768px) and (max-width: 899px) {
            .navbar {
                padding: 0 1.5rem;
            }
            .nav-logos { gap: 0.5rem; }
            .nav-logo-img { height: 32px; }
            .nav-logo-divider { height: 18px; }
            .nav-name { font-size: 1.15rem; }
            .nav-school { font-size: 0.78rem; }
            .nav-text { display: inline !important; }
            .theme-btn, .nav-home { padding: 0.4rem 0.95rem; min-height: 40px; font-size: 0.82rem; }
            .stage { padding: clamp(0.35rem, 1vh, 0.75rem) 1.5rem; }
            .glass-card {
                max-width: 640px;
                gap: clamp(0.45rem, 1.2vh, 0.85rem);
            }
            .card-header {
                padding-bottom: 0.15rem;
            }
            .card-title {
                font-size: clamp(1.65rem, 3.5vw, 2.15rem);
                font-weight: 800;
                letter-spacing: -0.025em;
                line-height: 1.15;
                width: 100%;
                justify-content: center;
                text-align: center;
            }
            .card-sub {
                font-size: 0.92rem;
                margin-top: clamp(0.2rem, 0.5vh, 0.4rem);
                line-height: 1.35;
            }
            .form-stack { gap: clamp(0.4rem, 1.1vh, 0.75rem); }
            .field { gap: clamp(0.18rem, 0.4vh, 0.3rem); }
            .field-lbl { font-size: 0.96rem; font-weight: 600; gap: 0.4rem; }
            .field-lbl svg { width: 17px; height: 17px; }
            .field-input {
                padding: clamp(0.4rem, 0.75vh, 0.6rem) 1rem;
                font-size: 0.96rem;
                min-height: clamp(40px, 4.8vh, 48px);
                border-radius: 0.6rem;
            }
            .field-input::placeholder {
                font-size: 0.96rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 17px;
                height: 17px;
                left: 1rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 3rem !important;
            }
            .status-big-grid { grid-template-columns: 1fr 1fr; gap: clamp(0.45rem, 1vh, 0.8rem); }
            .status-btn, .media-card-btn, .trigger-btn { padding: clamp(0.45rem, 0.85vh, 0.7rem) clamp(0.7rem, 1vw, 1rem); min-height: clamp(48px, 5.8vh, 60px); gap: 0.45rem; border-radius: 0.65rem; }
            .sbt-icon { width: clamp(28px, 3.6vh, 36px); height: clamp(28px, 3.6vh, 36px); }
            .sbt-svg { width: 20px; height: 20px; }
            .sbt-name { font-size: 0.96rem; }
            .sbt-desc { font-size: 0.78rem; }
            .status-pill { padding: 0.45rem 1rem; font-size: 0.95rem; min-height: clamp(34px, 4.4vh, 42px); }
            .status-pill-change { font-size: 0.82rem; padding: 0.25rem 0.65rem; }
            .media-grid { grid-template-columns: 1fr 1fr; gap: clamp(0.45rem, 1vh, 0.8rem); }
            .rating-section { gap: clamp(0.25rem, 0.5vh, 0.4rem); }
            .rating-q { font-size: 1.05rem; font-weight: 700; }
            .rating-bar { gap: 0.5rem; border-radius: 0.65rem; padding: 0.25rem; }
            .rating-opt { padding: clamp(0.25rem, 0.5vh, 0.45rem) 0.65rem; min-height: clamp(38px, 4.6vh, 48px); gap: 0.35rem; }
            .rating-opt .r-emoji { font-size: 1.35rem; }
            .rating-opt span:last-child { font-size: 0.85rem; font-weight: 700; }
            .btn-submit { min-height: clamp(40px, 5vh, 48px); padding: clamp(0.45rem, 0.9vh, 0.7rem) 1.8rem; font-size: 1rem; border-radius: 0.65rem; }
            #submitIcon { width: 19px; height: 19px; }
            .modal-win { max-width: 600px; }
            .footer span { font-size: 0.8rem; }
        }

        /* ─── Large & Pro Tablets (iPad Pro 1032x1376, Surface Pro 960x1440: tall portrait tablets ONLY) ─── */
        @media (min-width: 900px) and (max-width: 1200px) and (orientation: portrait), (min-width: 900px) and (min-height: 951px) and (max-width: 1300px) {
            .navbar {
                padding: 0 clamp(1.5rem, 3vw, 2.5rem);
            }
            .nav-logos { gap: 0.6rem; }
            .nav-logo-img { height: 36px; }
            .nav-logo-divider { height: 20px; }
            .nav-name { font-size: 1.25rem; }
            .nav-school { font-size: 0.82rem; }
            .nav-text { display: inline !important; }
            .theme-btn, .nav-home {
                padding: 0.45rem 1.1rem;
                min-height: 42px;
                font-size: 0.88rem;
            }
            .stage {
                padding: clamp(0.45rem, 1.2vh, 1rem) 2rem;
            }
            .glass-card {
                max-width: 680px;
                gap: clamp(0.55rem, 1.4vh, 1rem);
            }
            .card-header {
                padding-bottom: 0.2rem;
            }
            .card-title {
                font-size: clamp(1.85rem, 4vw, 2.45rem);
                font-weight: 800;
                letter-spacing: -0.025em;
                line-height: 1.15;
                width: 100%;
                justify-content: center;
                text-align: center;
            }
            .card-sub {
                font-size: 1rem;
                margin-top: clamp(0.25rem, 0.6vh, 0.45rem);
                line-height: 1.4;
            }
            .form-stack {
                gap: clamp(0.45rem, 1.2vh, 0.85rem);
            }
            .field {
                gap: clamp(0.2rem, 0.5vh, 0.35rem);
            }
            .field-lbl {
                font-size: 1rem;
                font-weight: 600;
                gap: 0.45rem;
            }
            .field-lbl svg {
                width: 18px;
                height: 18px;
            }
            .field-input {
                padding: clamp(0.45rem, 0.85vh, 0.65rem) 1.1rem;
                font-size: 1rem;
                min-height: clamp(42px, 5vh, 50px);
                border-radius: 0.65rem;
            }
            .field-input::placeholder {
                font-size: 1rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 18px;
                height: 18px;
                left: 1.05rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 3.1rem !important;
            }
            .status-big-grid {
                grid-template-columns: 1fr 1fr;
                gap: clamp(0.5rem, 1.1vh, 0.9rem);
            }
            .status-btn, .media-card-btn, .trigger-btn {
                padding: clamp(0.5rem, 0.9vh, 0.75rem) clamp(0.8rem, 1vw, 1.1rem);
                min-height: clamp(50px, 6vh, 64px);
                gap: 0.5rem;
                border-radius: 0.7rem;
            }
            .sbt-icon {
                width: clamp(30px, 3.8vh, 38px);
                height: clamp(30px, 3.8vh, 38px);
                border-radius: 0.55rem;
            }
            .sbt-svg {
                width: 22px;
                height: 22px;
            }
            .sbt-name {
                font-size: 1rem;
            }
            .sbt-desc {
                font-size: 0.82rem;
            }
            .status-pill {
                padding: 0.5rem 1.1rem;
                font-size: 1rem;
                min-height: clamp(36px, 4.6vh, 44px);
            }
            .status-pill-change {
                font-size: 0.85rem;
                padding: 0.25rem 0.7rem;
            }
            .media-grid {
                grid-template-columns: 1fr 1fr;
                gap: clamp(0.5rem, 1.1vh, 0.9rem);
            }
            .trigger-icon svg {
                width: 24px;
                height: 24px;
            }
            .trigger-lbl {
                font-size: 1rem;
                font-weight: 700;
            }
            .rating-section {
                gap: clamp(0.3rem, 0.6vh, 0.45rem);
            }
            .rating-q {
                font-size: 1.12rem;
                font-weight: 700;
            }
            .rating-bar {
                gap: 0.6rem;
                border-radius: 0.75rem;
                padding: 0.3rem;
            }
            .rating-opt {
                padding: clamp(0.3rem, 0.6vh, 0.5rem) 0.8rem;
                min-height: clamp(40px, 4.8vh, 50px);
                gap: 0.4rem;
            }
            .rating-opt .r-emoji {
                font-size: 1.45rem;
            }
            .rating-opt span:last-child {
                font-size: 0.92rem;
                font-weight: 700;
            }
            .btn-submit {
                min-height: clamp(42px, 5vh, 50px);
                padding: clamp(0.5rem, 1vh, 0.75rem) 2rem;
                font-size: 1.05rem;
                border-radius: 0.7rem;
            }
            #submitIcon {
                width: 20px;
                height: 20px;
            }
            .modal-win {
                max-width: 640px;
            }
            .footer span {
                font-size: 0.85rem;
            }
        }

        /* ─── Laptops & Landscape Screens (Width >= 900px, Height <= 950px in Landscape) ─── */
        @media (min-width: 900px) and (max-height: 950px) and (orientation: landscape), (min-width: 1000px) and (max-height: 950px) {
            .navbar {
                padding: 0 1.5rem;
            }
            .nav-actions {
                gap: 0.45rem;
            }
            .nav-home, .theme-btn {
                min-height: 36px;
                padding: 0.35rem 0.75rem;
                font-size: 0.78rem;
                border-radius: 9999px;
            }
            .nav-home svg, .theme-btn svg {
                width: 15px;
                height: 15px;
            }
            .glass-card {
                max-width: 640px;
                gap: clamp(1rem, 2.2vh, 1.45rem);
            }
            .stage {
                padding: clamp(0.5rem, 1.5vh, 1.2rem) 1.5rem;
                overflow-y: auto;
            }
            .card-title {
                font-size: 2.35rem;
                font-weight: 900;
                letter-spacing: -0.025em;
                line-height: 1.15;
            }
            .card-sub {
                font-size: 1.05rem;
                margin-top: 0.75rem;
            }
            .field {
                gap: 0.45rem;
            }
            .field-lbl {
                font-size: 0.98rem;
                font-weight: 600;
                gap: 0.45rem;
            }
            .field-lbl svg {
                width: 17px;
                height: 17px;
            }
            .field-input {
                padding: 0.6rem 1rem;
                font-size: 0.98rem;
                min-height: 46px;
                border-radius: 0.55rem;
            }
            .field-input::placeholder {
                font-size: 0.98rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 16px;
                height: 16px;
                left: 0.95rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 2.9rem !important;
            }
            .status-big-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.85rem;
            }
            .status-btn {
                padding: 0.75rem 1rem;
                min-height: 64px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .sbt-icon {
                width: 36px;
                height: 36px;
                border-radius: 0.5rem;
            }
            .sbt-svg {
                width: 20px;
                height: 20px;
            }
            .sbt-name {
                font-size: 0.95rem;
            }
            .sbt-desc {
                font-size: 0.8rem;
            }
            .media-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.85rem;
            }
            .trigger-btn {
                padding: 0.8rem 1rem;
                min-height: 72px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .trigger-icon svg {
                width: 24px;
                height: 24px;
            }
            .trigger-lbl {
                font-size: 0.95rem;
            }
            .rating-section {
                gap: 0.7rem;
            }
            .rating-q {
                font-size: 1.15rem;
            }
            .rating-opt {
                padding: 0.65rem 0.85rem;
                min-height: 56px;
                gap: 0.35rem;
            }
            .rating-opt .r-emoji {
                font-size: 1.45rem;
            }
            .rating-opt span:last-child {
                font-size: 0.92rem;
            }
            .btn-submit {
                min-height: 48px;
                font-size: 1rem;
                padding: 0.8rem 2rem;
                border-radius: 0.65rem;
            }
            #submitIcon {
                width: 20px;
                height: 20px;
            }
            .footer span {
                font-size: 0.8rem;
            }
        }

        @media (min-width: 900px) and (max-height: 950px) {
            .root {
                min-height: 100dvh;
            }
            .stage {
                overflow-y: auto;
                overflow-x: hidden;
            }
        }

        /* ─── Standard Desktop / Wide (>= 1280px and height > 950px) ─── */
        @media (min-width: 1280px) and (min-height: 951px) {
            .glass-card {
                max-width: 680px;
                gap: 1.45rem;
            }
            .card-title {
                font-size: 2rem;
            }
            .card-sub {
                font-size: 0.95rem;
            }
            .field {
                gap: 0.45rem;
            }
            .field-lbl {
                font-size: 1rem;
                font-weight: 600;
                gap: 0.45rem;
            }
            .field-lbl svg {
                width: 18px;
                height: 18px;
            }
            .field-input {
                padding: 0.65rem 1.15rem;
                font-size: 1rem;
                min-height: 48px;
                border-radius: 0.6rem;
            }
            .field-input::placeholder {
                font-size: 1rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 16px;
                height: 16px;
                left: 0.95rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 2.95rem !important;
            }
            .status-btn {
                padding: 0.75rem 1rem;
                min-height: 64px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .sbt-name { font-size: 0.95rem; }
            .sbt-desc { font-size: 0.8rem; }
            .trigger-btn {
                padding: 0.8rem 1rem;
                min-height: 72px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .trigger-lbl { font-size: 0.95rem; }
            .rating-q { font-size: 1.18rem; }
            .rating-opt {
                padding: 0.65rem 0.85rem;
                min-height: 56px;
                gap: 0.35rem;
            }
            .rating-opt .r-emoji { font-size: 1.45rem; }
            .rating-opt span:last-child { font-size: 0.92rem; }
            .btn-submit {
                min-height: 48px;
                font-size: 1rem;
                padding: 0.8rem 2rem;
                border-radius: 0.65rem;
            }
        }

        /* ─── Ultra-wide Desktop & TV Displays (>= 1920px) ─── */
        @media (min-width: 1920px) {
            .navbar {
                padding: 0 2.5rem;
            }
            .glass-card {
                max-width: 800px;
                gap: 1.5rem;
            }
            .nav-name {
                font-size: 1.35rem;
            }
            .nav-school {
                font-size: 0.85rem;
            }
            .card-title {
                font-size: 2.1rem;
            }
            .card-sub {
                font-size: 0.98rem;
            }
            .field {
                gap: 0.45rem;
            }
            .field-lbl {
                font-size: 1.05rem;
                font-weight: 600;
                gap: 0.45rem;
            }
            .field-lbl svg {
                width: 19px;
                height: 19px;
            }
            .field-input {
                padding: 0.75rem 1.25rem;
                font-size: 1.05rem;
                min-height: 52px;
                border-radius: 0.65rem;
            }
            .field-input::placeholder {
                font-size: 1.05rem;
                opacity: 0.9;
            }
            .field-icon {
                width: 17px;
                height: 17px;
                left: 1rem;
            }
            .field-wrap .field-icon + .field-input,
            #inputInstansi,
            #inputSekolah {
                padding-left: 3.1rem !important;
            }
            .status-big-grid {
                gap: 0.85rem;
            }
            .status-btn {
                padding: 0.75rem 1rem;
                min-height: 64px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .sbt-icon {
                width: 36px;
                height: 36px;
            }
            .sbt-svg {
                width: 20px;
                height: 20px;
            }
            .sbt-name {
                font-size: 0.98rem;
            }
            .sbt-desc {
                font-size: 0.82rem;
            }
            .trigger-btn {
                padding: 0.8rem 1rem;
                min-height: 72px;
                gap: 0.55rem;
                border-radius: 0.65rem;
            }
            .trigger-icon svg {
                width: 24px;
                height: 24px;
            }
            .trigger-lbl {
                font-size: 0.98rem;
            }
            .rating-q {
                font-size: 1.25rem;
            }
            .rating-opt {
                padding: 0.65rem 0.85rem;
                min-height: 56px;
                gap: 0.35rem;
            }
            .rating-opt .r-emoji {
                font-size: 1.45rem;
            }
            .rating-opt span:last-child {
                font-size: 0.92rem;
            }
            .btn-submit {
                font-size: 1rem;
                min-height: 50px;
                padding: 0.8rem 2rem;
                border-radius: 0.65rem;
            }
            #submitIcon {
                width: 20px;
                height: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient orbs -->
    <div class="orb orb-tl" aria-hidden="true"></div>
    <div class="orb orb-br" aria-hidden="true"></div>

    <!-- Toast notification -->
    <div class="toast" id="toast" role="alert" aria-live="polite">
        <span id="toastMsg">—</span>
    </div>

    <!-- ─── Root wrapper ─── -->
    <div class="root">

        <!-- ─── Navbar ─── -->
        <header class="navbar" role="banner">
            <a href="/" class="nav-brand" onclick="transitionToHero(event)" aria-label="BUTAGI - Beranda">
                <div class="nav-logos">
                    <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo SMKN 1 Subang" class="nav-logo-img">
                    <div class="nav-logo-divider" aria-hidden="true"></div>
                    <img src="{{ asset('img/logomrc.png') }}" alt="Logo MRC" class="nav-logo-img">
                </div>
                <div class="nav-wordmark">
                    <span class="nav-name">BUTAGI</span>
                    <span class="nav-school">SMKN 1 Subang</span>
                </div>
            </a>
            <div class="nav-actions">
                <!-- Fullscreen toggle button -->
                <button class="theme-btn" id="fsToggle" onclick="toggleFullscreen()" aria-label="Layar penuh" title="Layar penuh">
                    <!-- Enter fullscreen icon -->
                    <svg id="iconEnterFs" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                    <!-- Exit fullscreen icon -->
                    <svg id="iconExitFs" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/></svg>
                    <span id="fsLabel" class="nav-text">Layar Penuh</span>
                </button>
                <!-- Theme toggle button -->
                <button class="theme-btn" id="themeToggle" onclick="toggleTheme()" aria-label="Ganti tema terang/gelap" title="Ganti tema">
                    <!-- Moon icon (shown in dark mode) -->
                    <svg id="iconMoon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    <!-- Sun icon (shown in light mode) -->
                    <svg id="iconSun" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    <span id="themeLabel" class="nav-text">Dark</span>
                </button>
                <button type="button" class="nav-home" id="btnNavHome" onclick="transitionToHero()" aria-label="Kembali ke beranda" style="display:none; cursor:pointer;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="nav-text">Beranda</span>
                </button>
            </div>
        </header>

        <!-- ─── Kiosk Hero / Beranda View (Seamless Fullscreen SPA) ─── -->
        <section class="hero" id="kioskHero" style="display:none;" aria-label="Layar Sambutan">
            <div class="hero-inner">
                <h1 class="hero-title title-gradient">BUKU TAMU DIGITAL</h1>
                <button type="button" id="btnGoToForm" class="cta-btn" onclick="transitionToForm()" aria-label="Mulai mengisi buku tamu">
                    <span>Isi buku tamu</span>
                    <svg class="cta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </section>

        <!-- ─── Main Stage (Form View) ─── -->
        <main class="stage" id="main-content" role="main">
            <div class="glass-card" role="region" aria-label="Formulir Kehadiran Tamu">

                <!-- Card header -->
                <div class="card-header">
                    <h1 class="card-title">BUKU TAMU DIGITAL</h1>
                    <p class="card-sub">Silakan isi identitas, ambil foto, tanda tangan, dan berikan penilaian.</p>
                </div>

                <!-- Form -->
                <form id="tamuForm" method="POST" action="/guest-form" autocomplete="off" novalidate>
                    @csrf
                    <input type="hidden" id="statusVal"   name="status"             required>
                    <input type="hidden" id="fotoBase64"  name="foto_base64"        required>
                    <input type="hidden" id="ttdBase64"   name="tanda_tangan_base64">
                    <input type="hidden" id="ulasanVal"   name="ulasan"  value="senang" required>

                    <div class="form-stack">

                        {{-- ① NAMA LENGKAP --}}
                        <div class="field">
                            <label for="inputNama" class="field-lbl">
                                <span class="lbl-emoji" aria-hidden="true">👤</span>
                                <span class="lbl-text">Nama Lengkap</span>
                            </label>
                            <div class="field-wrap">
                                <input type="text" id="inputNama" name="nama" class="field-input" placeholder="Masukkan nama lengkap Anda..." required aria-required="true">
                            </div>
                        </div>

                        {{-- ② STATUS SELECTOR (Instansi / Sekolah) --}}
                        <div class="field">
                            <div class="field-lbl" aria-hidden="true">
                                <span class="lbl-emoji" aria-hidden="true">👥</span>
                                <span class="lbl-text">Status Pengunjung</span>
                            </div>

                            <!-- Big buttons (initial state) -->
                            <div class="status-big-grid" id="statusBigGrid" role="group" aria-label="Pilih status pengunjung">
                                <button type="button" class="status-btn" id="btnInstansi" onclick="selectStatus('instansi')" aria-label="Pilih status Instansi">
                                    <div class="sbt-icon" aria-hidden="true">
                                        {{-- Dark mode icon --}}
                                        <img src="{{ asset('img/instansi-dark.svg') }}" alt="Instansi" class="sbt-svg sbt-svg-dark" width="22" height="22">
                                        {{-- Light mode icon --}}
                                        <img src="{{ asset('img/instansi-light.svg') }}" alt="Instansi" class="sbt-svg sbt-svg-light" width="22" height="22">
                                    </div>
                                    <div>
                                        <div class="sbt-name">Instansi</div>
                                        <div class="sbt-desc">Lembaga, Industri, Tamu Umum</div>
                                    </div>
                                </button>
                                <button type="button" class="status-btn" id="btnSekolah" onclick="selectStatus('sekolah')" aria-label="Pilih status Sekolah">
                                    <div class="sbt-icon" aria-hidden="true">
                                        {{-- Dark mode icon --}}
                                        <img src="{{ asset('img/sekolah-dark.svg') }}" alt="Sekolah" class="sbt-svg sbt-svg-dark" width="22" height="22">
                                        {{-- Light mode icon --}}
                                        <img src="{{ asset('img/sekolah-light.svg') }}" alt="Sekolah" class="sbt-svg sbt-svg-light" width="22" height="22">
                                    </div>
                                    <div>
                                        <div class="sbt-name">Sekolah</div>
                                        <div class="sbt-desc">Siswa, Guru, Civitas Sekolah</div>
                                    </div>
                                </button>
                            </div>

                            <!-- Selected pill (morphed state) -->
                            <div class="status-pill" id="statusPill" onclick="resetStatus()" role="button" tabindex="0" aria-label="Ubah pilihan status" style="display:none;">
                                <div class="status-pill-left">
                                    <span class="status-pill-emoji" id="pillEmoji">
                                        <img src="{{ asset('img/instansi-dark.svg') }}" id="pillSvgDark" alt="" class="pill-svg sbt-svg-dark" width="18" height="18">
                                        <img src="{{ asset('img/instansi-light.svg') }}" id="pillSvgLight" alt="" class="pill-svg sbt-svg-light" width="18" height="18">
                                    </span>
                                    <span>Status: <strong id="pillLabel">Instansi</strong></span>
                                </div>
                                <span class="status-pill-change" aria-hidden="true">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                    Ganti Pilihan
                                </span>
                            </div>

                            <!-- Conditional inputs -->
                            <div class="cond-input" id="condInstansi">
                                <div class="field-wrap">
                                    <svg class="field-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg>
                                    <input type="text" id="inputInstansi" name="instansi" class="field-input" placeholder="Nama instansi / perusahaan / lembaga..." aria-label="Nama instansi">
                                </div>
                            </div>
                            <div class="cond-input" id="condSekolah">
                                <div class="field-wrap">
                                    <svg class="field-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                    <input type="text" id="inputSekolah" name="asal_sekolah" class="field-input" placeholder="Asal sekolah Anda (mis. SMKN 1 Subang)..." aria-label="Asal sekolah">
                                </div>
                            </div>
                        </div>

                        {{-- ③ PHOTO + SIGNATURE (2-col grid, matches status-btn card style) --}}
                        <div class="field">
                            <div class="field-lbl" aria-hidden="true">
                                <span class="lbl-emoji" aria-hidden="true">📷</span>
                                <span class="lbl-text">Foto & Tanda Tangan</span>
                            </div>
                            <div class="media-grid" role="group" aria-label="Ambil foto dan tanda tangan">
                                <!-- Photo trigger -->
                                <button type="button" class="status-btn media-card-btn" id="btnPhoto" onclick="openPhotoModal()" aria-label="Buka kamera untuk ambil foto">
                                    <div class="sbt-icon" id="photoIconWrap" aria-hidden="true">
                                        <img id="thumbPhoto" class="media-thumb-img" src="" alt="Thumbnail foto" style="display:none;">
                                        <svg id="photoSvg" class="sbt-svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                            <circle cx="12" cy="13" r="3"/>
                                        </svg>
                                    </div>
                                    <div class="media-btn-text">
                                        <div class="sbt-name" id="photoLbl">Ambil Foto</div>
                                        <div class="sbt-desc" id="photoDesc">Kamera Pengunjung</div>
                                    </div>
                                    <span class="media-badge" id="photoBadge" aria-label="Foto sudah diambil">✓ Terambil</span>
                                </button>

                                <!-- Signature trigger -->
                                <button type="button" class="status-btn media-card-btn" id="btnSig" onclick="openSigModal()" aria-label="Buka kanvas tanda tangan">
                                    <div class="sbt-icon" id="sigIconWrap" aria-hidden="true">
                                        <img id="thumbSig" class="media-thumb-img" src="" alt="Thumbnail tanda tangan" style="display:none;">
                                        <svg id="sigSvg" class="sbt-svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 19l7-7 3 3-7 7-3-3z"/>
                                            <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                            <circle cx="11" cy="11" r="2"/>
                                        </svg>
                                    </div>
                                    <div class="media-btn-text">
                                        <div class="sbt-name" id="sigLbl">Tanda Tangan</div>
                                        <div class="sbt-desc" id="sigDesc">Goreskan Digital</div>
                                    </div>
                                    <span class="media-badge" id="sigBadge" aria-label="Tanda tangan sudah diisi">✓ Terisi</span>
                                </button>
                            </div>
                        </div>

                        {{-- ④ EMOJI RATING TRACK BAR --}}
                        <div class="rating-section">
                            <p class="rating-q">Bagaimana pengalaman Anda dengan MRC?</p>
                            <div class="rating-bar" role="group" aria-label="Penilaian kepuasan">
                                <button type="button" class="rating-opt active" data-v="senang" onclick="setRating('senang')" aria-pressed="true" aria-label="Senang">
                                    <span class="r-emoji" aria-hidden="true">😊</span>
                                    <span>Senang</span>
                                </button>
                                <button type="button" class="rating-opt" data-v="menarik" onclick="setRating('menarik')" aria-pressed="false" aria-label="Menarik">
                                    <span class="r-emoji" aria-hidden="true">🤩</span>
                                    <span>Menarik</span>
                                </button>
                                <button type="button" class="rating-opt" data-v="unik" onclick="setRating('unik')" aria-pressed="false" aria-label="Unik">
                                    <span class="r-emoji" aria-hidden="true">🤔</span>
                                    <span>Unik</span>
                                </button>
                            </div>
                        </div>

                        {{-- ⑤ SUBMIT --}}
                        <button type="submit" id="btnSubmit" class="btn-submit" aria-label="Kirim data kehadiran">
                            <span id="submitLabel">Kirim Data Kehadiran</span>
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" id="submitIcon" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>

                    </div>{{-- /form-stack --}}
                </form>

            </div>{{-- /glass-card --}}
        </main>

        <!-- ─── Footer ─── -->
        <footer class="footer" role="contentinfo">
            <span>© {{ date('Y') }} SMKN 1 Subang</span>
        </footer>

    </div>{{-- /root --}}

    <!-- ══════════════════════════════════════════
         MODAL 1: CAMERA / PHOTO
    ══════════════════════════════════════════ -->
    <div class="modal-backdrop" id="photoModal" aria-modal="true" role="dialog" aria-label="Ambil Foto Pengunjung">
        <div class="modal-win">
            <div class="modal-head">
                <div class="modal-head-title">
                    <div class="modal-head-icon" aria-hidden="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                    </div>
                    Ambil Foto Pengunjung
                </div>
                <button type="button" class="modal-close" onclick="closePhotoModal()" aria-label="Tutup modal foto">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="cam-screen" id="camScreen">
                    <video id="camVideo" autoplay playsinline muted></video>
                    <img  id="camImg"   alt="Hasil foto" style="display:none;">
                    <div class="cam-flash" id="camFlash"></div>
                    <!-- 3-Second Countdown Overlay -->
                    <div class="cam-countdown" id="camCountdown" style="display:none;" aria-live="assertive">
                        <div class="countdown-badge">
                            <span class="countdown-num" id="countdownNum">3</span>
                        </div>
                    </div>
                </div>
                <p class="cam-hint" id="camHint">Posisikan wajah Anda di tengah layar.</p>
            </div>
            <div class="modal-foot">
                <button class="btn-sm btn-ghost" id="btnRetake" onclick="retakePhoto()" style="display:none;" aria-label="Ulangi foto">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    Ulangi
                </button>
                <div class="modal-foot-right">
                    <button class="btn-sm btn-ghost" onclick="closePhotoModal()" aria-label="Batal">Batal</button>
                    <button class="btn-sm btn-primary" id="btnCapture" onclick="startPhotoCountdown()" aria-label="Ambil foto dengan timer 3 detik">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Ambil Foto (3s)</span>
                    </button>
                    <button class="btn-sm btn-primary" id="btnSavePhoto" onclick="confirmPhoto()" style="display:none;" aria-label="Gunakan foto ini">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        Gunakan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         MODAL 2: SIGNATURE CANVAS
    ══════════════════════════════════════════ -->
    <div class="modal-backdrop" id="sigModal" aria-modal="true" role="dialog" aria-label="Tanda Tangan Digital">
        <div class="modal-win">
            <div class="modal-head">
                <div class="modal-head-title">
                    <div class="modal-head-icon" aria-hidden="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/></svg>
                    </div>
                    Tanda Tangan Digital
                </div>
                <button type="button" class="modal-close" onclick="closeSigModal()" aria-label="Tutup modal tanda tangan">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="sig-box" id="sigBox">
                    <div class="sig-hint" id="sigHint" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/></svg>
                        Goreskan tanda tangan Anda di sini
                    </div>
                    <canvas id="sigCanvas" aria-label="Area tanda tangan"></canvas>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-sm btn-danger-ghost" onclick="clearSig()" aria-label="Bersihkan tanda tangan">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
                    Bersihkan
                </button>
                <div class="modal-foot-right">
                    <button class="btn-sm btn-ghost" onclick="closeSigModal()" aria-label="Batal">Batal</button>
                    <button class="btn-sm btn-primary" onclick="confirmSig()" aria-label="Simpan tanda tangan">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Tanda Tangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         SUCCESS MODAL (Terima Kasih)
    ══════════════════════════════════════════ -->
    <div class="modal-backdrop" id="successModal" role="dialog" aria-modal="true" aria-labelledby="successTitle">
        <div class="modal-win success-win">
            <div class="success-body">
                <div class="success-icon-wrap" aria-hidden="true">
                    <div class="success-icon-pulse"></div>
                    <div class="success-icon-circle">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                </div>
                <h2 id="successTitle" class="success-title">Terima Kasih! ✨</h2>
                <p class="success-desc">
                    Terima kasih telah berkunjung dan meluangkan waktu untuk mengisi buku tamu SMKN 1 Subang. Kehadiran Anda telah tercatat dengan baik!.
                </p>
                <div class="success-countdown" aria-live="polite">
                    <span>Kembali ke beranda dalam <strong id="successTimer">4</strong> detik...</span>
                </div>
                <div class="success-actions" style="margin-top:0.4rem; width:100%;">
                    <button type="button" class="btn-success-home" id="btnSuccessHome" style="width:100%; border:none; cursor:pointer;">
                        <span>Selesai & Kembali</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         JAVASCRIPT ENGINE
    ══════════════════════════════════════════ -->
    <script>
    'use strict';

    // ─── State ───────────────────────────────────
    let _status   = '';
    let _rating   = 'senang';
    let _stream   = null;
    let _tempPhoto = '';
    let _sigCtx, _sigCanvas, _sigDrawing = false, _sigHasData = false;

    // ─── Theme Toggle ─────────────────────────────
    function applyTheme(theme) {
        const html = document.documentElement;
        html.setAttribute('data-theme', theme);
        const isDark = theme === 'dark';
        document.getElementById('iconMoon').style.display  = isDark ? 'block' : 'none';
        document.getElementById('iconSun').style.display   = isDark ? 'none'  : 'block';
        document.getElementById('themeLabel').textContent  = isDark ? 'Light' : 'Dark';
        localStorage.setItem('butagi_theme', theme);
    }
    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }
    // Restore saved preference on load (defaults to light mode)
    (function() {
        const saved = localStorage.getItem('butagi_theme') || 'light';
        applyTheme(saved);
    })();

    // ─── Fullscreen Toggle ─────────────────────────
    function toggleFullscreen() {
        const isFs = !!(document.fullscreenElement || document.webkitFullscreenElement);
        if (!isFs) {
            const el = document.documentElement;
            localStorage.setItem('butagi_fullscreen', '1');
            if (el.requestFullscreen) {
                el.requestFullscreen().catch(err => console.warn('Fullscreen:', err));
            } else if (el.webkitRequestFullscreen) {
                el.webkitRequestFullscreen();
            }
        } else {
            localStorage.removeItem('butagi_fullscreen');
            if (document.exitFullscreen) {
                document.exitFullscreen().catch(err => console.warn('Exit fullscreen:', err));
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }
    }

    function updateFullscreenUi() {
        const isFs = !!(document.fullscreenElement || document.webkitFullscreenElement);
        if (isFs) {
            localStorage.setItem('butagi_fullscreen', '1');
        }
        const iconEnter = document.getElementById('iconEnterFs');
        const iconExit  = document.getElementById('iconExitFs');
        const fsLabel   = document.getElementById('fsLabel');
        if (iconEnter) iconEnter.style.display = isFs ? 'none' : 'block';
        if (iconExit)  iconExit.style.display  = isFs ? 'block' : 'none';
        if (fsLabel)   fsLabel.textContent    = isFs ? 'Kecilkan' : 'Layar Penuh';
    }

    document.addEventListener('fullscreenchange', updateFullscreenUi);
    document.addEventListener('webkitfullscreenchange', updateFullscreenUi);

    // Auto-resume fullscreen if user previously enabled fullscreen
    (function initAutoFullscreen() {
        if (localStorage.getItem('butagi_fullscreen') === '1') {
            const tryFs = () => {
                if (!document.fullscreenElement && !document.webkitFullscreenElement) {
                    const el = document.documentElement;
                    if (el.requestFullscreen) el.requestFullscreen().catch(() => {});
                    else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                }
            };
            tryFs();
            ['pointerdown', 'touchend', 'click', 'focusin'].forEach(evt => {
                window.addEventListener(evt, tryFs, { once: true });
            });
        }
    })();


    // ─── Toast ───────────────────────────────────
    function toast(msg, type = 'error') {
        const el = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = msg;
        el.className = `toast visible ${type}`;
        clearTimeout(el._t);
        el._t = setTimeout(() => { el.className = 'toast'; }, 3800);
    }

    // ─── Status Selector (morph behavior) ────────
    function selectStatus(val) {
        _status = val;
        document.getElementById('statusVal').value = val;

        // Hide big buttons, show pill
        document.getElementById('statusBigGrid').style.display = 'none';
        const pill = document.getElementById('statusPill');
        pill.style.display = 'flex';
        // Swap pill SVG icons (dark & light variants)
        const baseUrl = '{{ asset("img") }}';
        document.getElementById('pillSvgDark').src  = val === 'instansi' ? baseUrl + '/instansi-dark.svg'  : baseUrl + '/sekolah-dark.svg';
        document.getElementById('pillSvgLight').src = val === 'instansi' ? baseUrl + '/instansi-light.svg' : baseUrl + '/sekolah-light.svg';
        document.getElementById('pillLabel').textContent = val === 'instansi' ? 'Instansi' : 'Sekolah';

        // Show correct conditional input
        const ci = document.getElementById('condInstansi');
        const cs = document.getElementById('condSekolah');
        const ii = document.getElementById('inputInstansi');
        const is = document.getElementById('inputSekolah');

        if (val === 'instansi') {
            ci.classList.add('visible'); cs.classList.remove('visible');
            ii.required = true;  is.required = false; is.value = '';
            setTimeout(() => ii.focus(), 80);
        } else {
            cs.classList.add('visible'); ci.classList.remove('visible');
            is.required = true;  ii.required = false; ii.value = '';
            setTimeout(() => is.focus(), 80);
        }
    }

    function resetStatus() {
        _status = '';
        document.getElementById('statusVal').value = '';
        document.getElementById('statusBigGrid').style.display = 'grid';
        document.getElementById('statusPill').style.display   = 'none';
        document.getElementById('condInstansi').classList.remove('visible');
        document.getElementById('condSekolah').classList.remove('visible');
        document.getElementById('inputInstansi').required = false;
        document.getElementById('inputSekolah').required  = false;
    }

    // Keyboard accessibility on pill
    document.getElementById('statusPill').addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); resetStatus(); }
    });

    // ─── Rating Track Bar ─────────────────────────
    function setRating(val) {
        _rating = val;
        document.getElementById('ulasanVal').value = val;
        document.querySelectorAll('.rating-opt').forEach(o => {
            const active = o.dataset.v === val;
            o.classList.toggle('active', active);
            o.setAttribute('aria-pressed', active);
        });
    }

    // ─── Photo Modal & 3-Second Timer ─────────────
    let _countdownTimer = null;
    let _countdownVal = 3;

    function playBeep(freq = 880, duration = 0.08) {
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (!AudioCtx) return;
            const audioCtx = new AudioCtx();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.12, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + duration);
        } catch(e) {}
    }

    function cancelCountdown() {
        if (_countdownTimer) {
            clearInterval(_countdownTimer);
            _countdownTimer = null;
        }
        const overlay = document.getElementById('camCountdown');
        if (overlay) overlay.style.display = 'none';
        const btnCap = document.getElementById('btnCapture');
        if (btnCap) {
            btnCap.disabled = false;
            btnCap.innerHTML = `
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Ambil Foto (3s)</span>
            `;
        }
    }

    async function openPhotoModal() {
        document.getElementById('photoModal').classList.add('open');
        resetCam();
        try {
            _stream = await navigator.mediaDevices.getUserMedia({
                video: { width:{ideal:1280}, height:{ideal:720}, facingMode:'user' },
                audio: false
            });
            const v = document.getElementById('camVideo');
            v.srcObject = _stream;
            await v.play();
        } catch(err) {
            document.getElementById('camHint').textContent = 'Kamera tidak dapat diakses. Pastikan izin kamera telah diberikan.';
        }
    }

    function closePhotoModal() {
        cancelCountdown();
        stopStream();
        document.getElementById('photoModal').classList.remove('open');
    }

    function stopStream() {
        if (_stream) { _stream.getTracks().forEach(t => t.stop()); _stream = null; }
    }

    function resetCam() {
        cancelCountdown();
        const v = document.getElementById('camVideo');
        const i = document.getElementById('camImg');
        v.style.display = 'block'; i.style.display = 'none';
        const btnCap = document.getElementById('btnCapture');
        if (btnCap) {
            btnCap.style.display  = 'inline-flex';
            btnCap.disabled = false;
            btnCap.innerHTML = `
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Ambil Foto (3s)</span>
            `;
        }
        document.getElementById('btnRetake').style.display   = 'none';
        document.getElementById('btnSavePhoto').style.display= 'none';
        document.getElementById('camHint').textContent = 'Posisikan wajah Anda di tengah layar.';
        _tempPhoto = '';
    }

    function startPhotoCountdown() {
        const v = document.getElementById('camVideo');
        if (!v.videoWidth) { toast('Kamera belum siap, harap tunggu.'); return; }
        if (_countdownTimer) return; // already counting down

        _countdownVal = 3;
        const overlay = document.getElementById('camCountdown');
        const numEl   = document.getElementById('countdownNum');
        const btnCap  = document.getElementById('btnCapture');
        const hint    = document.getElementById('camHint');

        overlay.style.display = 'flex';
        btnCap.disabled = true;

        function step() {
            if (_countdownVal > 0) {
                numEl.textContent = _countdownVal;
                // trigger restart animation
                numEl.style.animation = 'none';
                void numEl.offsetWidth;
                numEl.style.animation = 'countPulse 0.95s cubic-bezier(0.4, 0, 0.2, 1)';

                hint.textContent = `Bersiap! Mengambil foto dalam ${_countdownVal} detik...`;
                btnCap.innerHTML = `
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="spin" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <span>Bersiap (${_countdownVal}s)</span>
                `;
                playBeep(780, 0.09);
                _countdownVal--;
            } else {
                clearInterval(_countdownTimer);
                _countdownTimer = null;
                overlay.style.display = 'none';
                hint.textContent = 'Senyum! 📸';
                playBeep(1200, 0.16);
                executeCapturePhoto();
            }
        }

        step();
        _countdownTimer = setInterval(step, 1000);
    }

    function executeCapturePhoto() {
        const v = document.getElementById('camVideo');
        // Flash
        const flash = document.getElementById('camFlash');
        flash.classList.add('flash');
        setTimeout(() => flash.classList.remove('flash'), 220);

        // Capture to canvas (optimized to max 640px for instant upload)
        const cvs = document.createElement('canvas');
        let targetW = v.videoWidth || 640;
        let targetH = v.videoHeight || 480;
        const maxW = 640;
        if (targetW > maxW) {
            targetH = Math.round((targetH * maxW) / targetW);
            targetW = maxW;
        }
        cvs.width  = targetW; 
        cvs.height = targetH;
        const ctx = cvs.getContext('2d');

        ctx.translate(cvs.width, 0); 
        ctx.scale(-1, 1);
        ctx.drawImage(v, 0, 0, cvs.width, cvs.height);
        _tempPhoto = cvs.toDataURL('image/jpeg', 0.82);

        const i = document.getElementById('camImg');
        i.src = _tempPhoto; 
        i.style.display = 'block'; 
        v.style.display = 'none';

        const btnCap = document.getElementById('btnCapture');
        btnCap.disabled = false;
        btnCap.style.display   = 'none';
        btnCap.innerHTML = `
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Ambil Foto (3s)</span>
        `;
        document.getElementById('btnRetake').style.display    = 'inline-flex';
        document.getElementById('btnSavePhoto').style.display = 'inline-flex';
        document.getElementById('camHint').textContent = 'Foto Anda. Klik "Gunakan Foto" untuk menyimpan.';
    }

    function capturePhoto() {
        startPhotoCountdown();
    }

    function retakePhoto() {
        resetCam();
        // Re-open stream if lost
        if (!_stream) openPhotoModal();
    }

    function confirmPhoto() {
        if (!_tempPhoto) { toast('Belum ada foto yang diambil.'); return; }
        document.getElementById('fotoBase64').value = _tempPhoto;

        // Update trigger button visuals
        const btn   = document.getElementById('btnPhoto');
        const thumb = document.getElementById('thumbPhoto');
        const svg   = document.getElementById('photoSvg');
        const desc  = document.getElementById('photoDesc');

        btn.classList.add('has-value');
        if (thumb) {
            thumb.src = _tempPhoto;
            thumb.style.display = 'block';
        }
        if (svg) svg.style.display = 'none';
        document.getElementById('photoLbl').textContent = 'Ubah Foto';
        if (desc) desc.textContent = 'Foto tersimpan ✓';

        closePhotoModal();
        toast('Foto berhasil diambil!', 'success');
    }

    // ─── Signature Modal ─────────────────────────
    function openSigModal() {
        document.getElementById('sigModal').classList.add('open');
        initSig();
    }

    function closeSigModal() {
        document.getElementById('sigModal').classList.remove('open');
    }

    function initSig() {
        _sigCanvas = document.getElementById('sigCanvas');
        _sigCtx    = _sigCanvas.getContext('2d');
        _sigCanvas.width  = _sigCanvas.offsetWidth  || 440;
        _sigCanvas.height = _sigCanvas.offsetHeight || 200;

        _sigCtx.fillStyle = '#ffffff';
        _sigCtx.fillRect(0, 0, _sigCanvas.width, _sigCanvas.height);
        _sigCtx.strokeStyle = '#111827';
        _sigCtx.lineWidth   = 2.5;
        _sigCtx.lineCap     = 'round';
        _sigCtx.lineJoin    = 'round';

        // Restore existing
        const existing = document.getElementById('ttdBase64').value;
        if (existing) {
            const img = new Image();
            img.onload = () => {
                _sigCtx.fillStyle = '#ffffff';
                _sigCtx.fillRect(0, 0, _sigCanvas.width, _sigCanvas.height);
                _sigCtx.drawImage(img, 0, 0);
                _sigHasData = true;
                document.getElementById('sigHint').classList.add('hidden');
            };
            img.src = existing;
        } else {
            _sigHasData = false;
            document.getElementById('sigHint').classList.remove('hidden');
        }

        bindSigEvents();
    }

    function bindSigEvents() {
        function pos(e) {
            const r  = _sigCanvas.getBoundingClientRect();
            const cx = e.touches ? e.touches[0].clientX : e.clientX;
            const cy = e.touches ? e.touches[0].clientY : e.clientY;
            return { x: cx - r.left, y: cy - r.top };
        }
        function start(e) {
            _sigDrawing = true;
            const p = pos(e);
            _sigCtx.beginPath(); _sigCtx.moveTo(p.x, p.y);
            _sigHasData = true;
            document.getElementById('sigHint').classList.add('hidden');
        }
        function move(e) {
            if (!_sigDrawing) return;
            const p = pos(e);
            _sigCtx.lineTo(p.x, p.y); _sigCtx.stroke();
        }
        function end() { _sigDrawing = false; }

        _sigCanvas.onmousedown  = start;
        _sigCanvas.onmousemove  = move;
        window.onmouseup        = end;
        _sigCanvas.ontouchstart = e => { e.preventDefault(); start(e); };
        _sigCanvas.ontouchmove  = e => { e.preventDefault(); move(e); };
        _sigCanvas.ontouchend   = e => { e.preventDefault(); end(); };
    }

    function clearSig() {
        if (!_sigCtx) return;
        _sigCtx.fillStyle = '#ffffff';
        _sigCtx.fillRect(0, 0, _sigCanvas.width, _sigCanvas.height);
        _sigHasData = false;
        document.getElementById('sigHint').classList.remove('hidden');
    }

    function confirmSig() {
        const dataUrl = _sigHasData ? _sigCanvas.toDataURL('image/png') : '';
        document.getElementById('ttdBase64').value = dataUrl;
        const btn   = document.getElementById('btnSig');
        const thumb = document.getElementById('thumbSig');
        const svg   = document.getElementById('sigSvg');
        const desc  = document.getElementById('sigDesc');

        if (_sigHasData) {
            btn.classList.add('has-value');
            if (thumb) {
                thumb.src = dataUrl;
                thumb.style.display = 'block';
            }
            if (svg) svg.style.display = 'none';
            document.getElementById('sigLbl').textContent = 'Ubah Tanda Tangan';
            if (desc) desc.textContent = 'Tersimpan ✓';
            toast('Tanda tangan berhasil disimpan!', 'success');
        } else {
            btn.classList.remove('has-value');
            if (thumb) {
                thumb.style.display = 'none';
                thumb.src = '';
            }
            if (svg) svg.style.display = 'block';
            document.getElementById('sigLbl').textContent = 'Tanda Tangan';
            if (desc) desc.textContent = 'Goreskan Digital';
        }
        closeSigModal();
    }

    // ─── Form Validation & Submission ────────────
    let _submitting = false;
    let _redirectInterval = null;

    document.getElementById('tamuForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        if (_submitting) return;

        const nama   = document.getElementById('inputNama').value.trim();
        const status = document.getElementById('statusVal').value;
        const foto   = document.getElementById('fotoBase64').value;
        const inst   = document.getElementById('inputInstansi').value.trim();
        const skl    = document.getElementById('inputSekolah').value.trim();

        if (!nama)   { toast('Silakan isi nama lengkap Anda.'); document.getElementById('inputNama').focus(); return; }
        if (!status) { toast('Silakan pilih status pengunjung (Instansi atau Sekolah).'); return; }
        if (status === 'instansi' && !inst) { toast('Silakan isi nama instansi / lembaga Anda.'); document.getElementById('inputInstansi').focus(); return; }
        if (status === 'sekolah'  && !skl)  { toast('Silakan isi nama asal sekolah Anda.'); document.getElementById('inputSekolah').focus(); return; }
        if (!foto)   { toast('Foto pengunjung wajib diambil.'); openPhotoModal(); return; }

        // Loading state
        _submitting = true;
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        document.getElementById('submitLabel').textContent = 'Menyimpan Data...';
        document.getElementById('submitIcon').outerHTML = `<svg id="submitIcon" class="spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.2"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/></svg>`;

        try {
            const formData = new FormData(this);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/guest-form', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // Show Success Pop-Up Modal
                showSuccessPopup();
            } else {
                const errMsg = result.message || (result.errors ? Object.values(result.errors)[0][0] : 'Gagal menyimpan data.');
                toast(errMsg, 'error');
                resetSubmitBtn();
            }
        } catch (err) {
            console.error('Submit error:', err);
            // Fallback submission if unexpected network/JSON error
            toast('Terjadi kendala jaringan, mencoba mengirim ulang...', 'error');
            setTimeout(() => {
                document.getElementById('tamuForm').submit();
            }, 800);
        }
    });

    function resetSubmitBtn() {
        _submitting = false;
        const btn = document.getElementById('btnSubmit');
        btn.disabled = false;
        document.getElementById('submitLabel').textContent = 'Kirim Data Kehadiran';
        const spinIcon = document.getElementById('submitIcon');
        if (spinIcon) {
            spinIcon.outerHTML = `<svg id="submitIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>`;
        }
    }

    function resetFormFields() {
        const form = document.getElementById('tamuForm');
        if (form) form.reset();

        document.getElementById('inputNama').value = '';
        resetStatus();

        document.getElementById('fotoBase64').value = '';
        document.getElementById('ttdBase64').value = '';

        const btnPhoto = document.getElementById('btnPhoto');
        const thumbPhoto = document.getElementById('thumbPhoto');
        const photoSvg = document.getElementById('photoSvg');
        const photoDesc = document.getElementById('photoDesc');
        const photoLbl = document.getElementById('photoLbl');
        if (btnPhoto) btnPhoto.classList.remove('has-value');
        if (thumbPhoto) { thumbPhoto.style.display = 'none'; thumbPhoto.src = ''; }
        if (photoSvg) photoSvg.style.display = 'block';
        if (photoLbl) photoLbl.textContent = 'Ambil Foto';
        if (photoDesc) photoDesc.textContent = 'Kamera Pengunjung';
        _tempPhoto = '';

        const btnSig = document.getElementById('btnSig');
        const thumbSig = document.getElementById('thumbSig');
        const sigSvg = document.getElementById('sigSvg');
        const sigDesc = document.getElementById('sigDesc');
        const sigLbl = document.getElementById('sigLbl');
        if (btnSig) btnSig.classList.remove('has-value');
        if (thumbSig) { thumbSig.style.display = 'none'; thumbSig.src = ''; }
        if (sigSvg) sigSvg.style.display = 'block';
        if (sigLbl) sigLbl.textContent = 'Tanda Tangan';
        if (sigDesc) sigDesc.textContent = 'Goreskan Digital';
        clearSig();

        setRating('senang');
        resetSubmitBtn();
    }

    // ─── Seamless In-Page Navigation (Keeps Fullscreen Uninterrupted) ───
    function transitionToForm() {
        // If tablet was not yet in fullscreen, entering the form via user tap triggers fullscreen cleanly
        if (!document.fullscreenElement && !document.webkitFullscreenElement) {
            const el = document.documentElement;
            try {
                if (el.requestFullscreen) el.requestFullscreen().catch(() => {});
                else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
            } catch (e) {}
        }
        const hero = document.getElementById('kioskHero');
        const form = document.getElementById('main-content');
        const btnHome = document.getElementById('btnNavHome');
        if (hero) hero.style.display = 'none';
        if (form) form.style.display = 'flex';
        if (btnHome) btnHome.style.display = 'inline-flex';
        if (window.location.pathname !== '/guest-form') {
            history.pushState({ view: 'form' }, '', '/guest-form');
        }
        window.scrollTo(0, 0);
    }

    function transitionToHero(e) {
        if (e && e.preventDefault) e.preventDefault();
        const hero = document.getElementById('kioskHero');
        const form = document.getElementById('main-content');
        const btnHome = document.getElementById('btnNavHome');
        if (form) form.style.display = 'none';
        if (hero) hero.style.display = 'flex';
        if (btnHome) btnHome.style.display = 'none';
        if (window.location.pathname !== '/' && window.location.pathname !== '') {
            history.pushState({ view: 'hero' }, '', '/');
        }
        window.scrollTo(0, 0);
    }

    function syncKioskView() {
        const path = window.location.pathname;
        const hero = document.getElementById('kioskHero');
        const form = document.getElementById('main-content');
        const btnHome = document.getElementById('btnNavHome');
        if (path === '/guest-form') {
            if (hero) hero.style.display = 'none';
            if (form) form.style.display = 'flex';
            if (btnHome) btnHome.style.display = 'inline-flex';
        } else {
            if (form) form.style.display = 'none';
            if (hero) hero.style.display = 'flex';
            if (btnHome) btnHome.style.display = 'none';
        }
    }

    // Initialize view based on current URL and listen to browser history changes
    syncKioskView();
    window.addEventListener('popstate', syncKioskView);

    function showSuccessPopup() {
        const modal = document.getElementById('successModal');
        modal.classList.add('open');

        let secondsLeft = 4;
        const timerEl = document.getElementById('successTimer');
        if (timerEl) timerEl.textContent = secondsLeft;
        
        if (_redirectInterval) clearInterval(_redirectInterval);
        _redirectInterval = setInterval(() => {
            secondsLeft -= 1;
            if (timerEl) timerEl.textContent = secondsLeft;
            if (secondsLeft <= 0) {
                clearInterval(_redirectInterval);
                _redirectInterval = null;
                modal.classList.remove('open');
                resetFormFields();
                transitionToHero();
            }
        }, 1000);

        document.getElementById('btnSuccessHome').onclick = function(e) {
            e.preventDefault();
            if (_redirectInterval) {
                clearInterval(_redirectInterval);
                _redirectInterval = null;
            }
            modal.classList.remove('open');
            resetFormFields();
            transitionToHero();
        };
    }

    // Close modals on backdrop click
    document.getElementById('photoModal').addEventListener('click', e => { if(e.target === e.currentTarget) closePhotoModal(); });
    document.getElementById('sigModal').addEventListener('click',   e => { if(e.target === e.currentTarget) closeSigModal(); });
    document.getElementById('successModal').addEventListener('click', e => { 
        if(e.target === e.currentTarget) {
            if (_redirectInterval) {
                clearInterval(_redirectInterval);
                _redirectInterval = null;
            }
            document.getElementById('successModal').classList.remove('open');
            resetFormFields();
            transitionToHero();
        } 
    });

    // Keyboard ESC closes modals
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { 
            closePhotoModal(); 
            closeSigModal(); 
            if (document.getElementById('successModal').classList.contains('open')) {
                if (_redirectInterval) {
                    clearInterval(_redirectInterval);
                    _redirectInterval = null;
                }
                document.getElementById('successModal').classList.remove('open');
                resetFormFields();
                transitionToHero();
            }
        }
    });
    </script>

</body>
</html>
