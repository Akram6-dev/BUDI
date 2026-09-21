<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BUTAGI — Buku Tamu Digital SMKN 1 Subang. Sistem pencatatan tamu modern berbasis web.">
    <title>BUTAGI — Buku Tamu Digital SMKN 1 Subang</title>
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
        /* ══════════════════════════════════════════════
           GLOBAL RESET & DESIGN TOKENS
        ══════════════════════════════════════════════ */
        :root {
            --font: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
            --bg:        #080c18;
            --bg-deep:   #0a0e1a;
            --surface:   rgba(13, 19, 36, 0.88);
            --indigo:    #6366f1;
            --violet:    #8b5cf6;
            --indigo-l:  #818cf8;
            --violet-l:  #a78bfa;
            --accent-g:  linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --text:      #f1f5f9;
            --text-muted:#94a3b8;
            --border:    rgba(129, 140, 248, 0.18);
            --border-b:  rgba(129, 140, 248, 0.30);
            --radius-lg: 1rem;
            --radius-xl: 1.375rem;
            --radius-pill: 9999px;
            --nav-h:     clamp(44px, 6.2vh, 68px);
            --foot-h:    clamp(28px, 4.2vh, 44px);
        }

        /* ══════════════════════════════════════════════
           LIGHT MODE — Refined Neo-Monochrome Minimalist
        ══════════════════════════════════════════════ */
        [data-theme="light"] {
            --bg:        #f8fafc;
            --bg-deep:   #ffffff;
            --surface:   rgba(255, 255, 255, 0.85);
            --indigo:    #090a0f;
            --violet:    #1e293b;
            --indigo-l:  #334155;
            --violet-l:  #475569;
            --accent-g:  linear-gradient(135deg, #090a0f 0%, #1e293b 100%);
            --text:      #090a0f;
            --text-muted:#64748b;
            --border:    #e2e8f0;
            --border-b:  #cbd5e1;
        }
        [data-theme="light"] body {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(circle at 100% 0%, rgba(9, 10, 15, 0.02) 0%, transparent 40%),
                radial-gradient(circle at 0% 100%, rgba(9, 10, 15, 0.015) 0%, transparent 40%);
        }
        [data-theme="light"] .orb-1 {
            background: radial-gradient(circle, rgba(9, 10, 15, 0.025) 0%, transparent 70%);
        }
        [data-theme="light"] .orb-2 {
            background: radial-gradient(circle, rgba(9, 10, 15, 0.02) 0%, transparent 70%);
        }
        [data-theme="light"] .orb-3 { opacity: 0; }
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
        [data-theme="light"] .eyebrow {
            border: 1px solid #e2e8f0;
            background: rgba(241, 245, 249, 0.85);
            color: #475569;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        [data-theme="light"] .eyebrow-dot {
            background: #090a0f;
            box-shadow: 0 0 0 3px rgba(9, 10, 15, 0.12);
        }
        [data-theme="light"] .title-gradient {
            background: linear-gradient(145deg, #090a0f 0%, #1e293b 60%, #475569 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        [data-theme="light"] .cta-btn {
            background: #090a0f;
            color: #ffffff;
            border: 1px solid #18181b;
            box-shadow: 0 10px 25px -5px rgba(9, 10, 15, 0.22), 0 2px 6px rgba(9, 10, 15, 0.08);
        }
        [data-theme="light"] .cta-btn:hover {
            background: #000000;
            transform: translateY(-2px);
            box-shadow: 0 16px 36px -6px rgba(9, 10, 15, 0.35), 0 4px 12px rgba(9, 10, 15, 0.12);
        }
        [data-theme="light"] .footer {
            background: rgba(255, 255, 255, 0.85);
            border-top: 1px solid #e2e8f0;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        [data-theme="light"] .footer span { color: #64748b; }
        [data-theme="light"] .footer span strong { color: #090a0f; }

        /* Theme toggle button */
        .theme-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            font-size: 0.8rem; font-weight: 600;
            min-height: 36px;
            padding: 0.35rem 0.8rem;
            border-radius: 9999px;
            border: 1px solid var(--border-b);
            background: rgba(15,23,42,0.45);
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.22s ease;
            backdrop-filter: blur(10px);
            box-sizing: border-box;
        }
        .theme-btn:hover { color: var(--text); border-color: rgba(129,140,248,0.5); background: rgba(49,46,129,0.3); }
        [data-theme="light"] .theme-btn {
            background: #ffffff;
            border-color: #e2e8f0;
            color: #334155;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border-radius: 9999px;
        }
        [data-theme="light"] .theme-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #090a0f;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            overflow-wrap: anywhere;
        }

        html, body {
            min-height: 100dvh;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            font-family: var(--font);
            background-color: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        img, video {
            max-width: 100%;
            height: auto;
        }

        /* ══════════════════════════════════════════════
           CANVAS BACKGROUND — animated noise + particles
        ══════════════════════════════════════════════ */
        #bgCanvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
        }

        /* ══════════════════════════════════════════════
           ROOT LAYOUT — min-height: 100dvh
        ══════════════════════════════════════════════ */
        .root-layout {
            position: relative;
            z-index: 1;
            min-height: 100dvh;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ══════════════════════════════════════════════
           AMBIENT GLOW ORBS
        ══════════════════════════════════════════════ */
        .orb {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(90px);
            z-index: 0;
        }
        .orb-1 {
            width: 520px; height: 420px;
            top: -140px; left: -80px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.38) 0%, transparent 70%);
        }
        .orb-2 {
            width: 480px; height: 380px;
            bottom: -120px; right: -80px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.32) 0%, transparent 70%);
        }
        .orb-3 {
            width: 340px; height: 280px;
            top: 42%; left: 50%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(67, 56, 202, 0.25) 0%, transparent 70%);
        }

        /* ══════════════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════════════ */
        .navbar {
            position: relative;
            z-index: 50;
            height: var(--nav-h);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(1rem, 3vw, 3.5rem);
            background: rgba(8, 12, 24, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
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
            color: var(--text-muted);
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        /* ══════════════════════════════════════════════
           HERO SECTION
        ══════════════════════════════════════════════ */
        .hero {
            position: relative;
            z-index: 1;
            flex: 1 0 auto;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0;
            width: 100%;
            padding: clamp(1rem, 3.5vh, 3.5rem) 0;
        }

        .hero-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: clamp(1.1rem, 3.5vh, 3.5rem);
            padding: 0 clamp(1rem, 3vw, 4rem);
        }

        /* Eyebrow tag */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: clamp(0.25rem, 0.6vh, 0.45rem) clamp(0.65rem, 1vw, 1.25rem);
            border-radius: var(--radius-pill);
            border: 1px solid rgba(129,140,248,0.3);
            background: rgba(79,70,229,0.12);
            backdrop-filter: blur(10px);
            font-size: clamp(0.7rem, 0.9vw, 1rem);
            font-weight: 600;
            color: #a5b4fc;
            letter-spacing: 0.02em;
            animation: fadeDown 0.6s ease both;
        }
        .eyebrow-dot {
            width: clamp(6px, 0.8vh, 9px);
            height: clamp(6px, 0.8vh, 9px);
            border-radius: 50%;
            background: var(--indigo);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.3);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 3px rgba(99,102,241,0.3); }
            50%       { box-shadow: 0 0 0 6px rgba(99,102,241,0.12); }
        }

        /* Headline */
        .hero-title {
            font-size: clamp(2.3rem, min(6.5vw, 9.5vh), 5.6rem);
            font-weight: 900;
            letter-spacing: -0.045em;
            line-height: 1.2;
            padding-bottom: 0.18em;
            max-width: min(94vw, 1200px);
            animation: fadeDown 0.7s 0.1s ease both;
        }

        .title-gradient {
            background: linear-gradient(145deg, #ffffff 0%, #c7d2fe 45%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            padding-bottom: 0.12em;
        }

        /* CTA Button — Standalone (no wrapper card) */
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
            animation: fadeUp 0.7s 0.2s ease both;
            position: relative;
            overflow: hidden;
        }
        .cta-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.25s;
        }
        .cta-btn:hover { 
            transform: translateY(-3px) scale(1.025);
            box-shadow:
                0 0 0 1px rgba(165,180,252,0.4) inset,
                0 18px 42px -4px rgba(79,70,229,0.7),
                0 0 36px rgba(139,92,246,0.5);
        }
        .cta-btn:hover::before { opacity: 1; }
        .cta-btn:active { transform: translateY(0) scale(0.985); }

        .cta-icon {
            width: clamp(18px, 1.4vw, 26px);
            height: clamp(18px, 1.4vw, 26px);
            transition: transform 0.25s;
        }
        .cta-btn:hover .cta-icon { transform: translateX(3px); }

        /* ══════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════ */
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
            color: var(--text-muted);
            letter-spacing: 0.02em;
            text-align: center;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        /* ══════════════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════════════ */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══════════════════════════════════════════════
           SONNER TOAST
        ══════════════════════════════════════════════ */
        .toast {
            position: fixed;
            top: calc(var(--nav-h) + 12px);
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.25rem;
            border-radius: var(--radius-pill);
            background: rgba(16,185,129,0.95);
            color: #fff;
            font-size: 0.875rem;
            font-weight: 600;
            backdrop-filter: blur(12px);
            border: 1px solid #10b981;
            box-shadow: 0 8px 28px rgba(16,185,129,0.4);
            animation: toastIn 0.3s ease;
        }
        @keyframes toastIn {
            from { opacity: 0; transform: translate(-50%, -8px); }
            to   { opacity: 1; transform: translate(-50%, 0); }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS (Mobile-First Architecture)
        ══════════════════════════════════════════════ */
        @media (max-width: 480px) {
            .navbar { padding: 0 clamp(0.5rem, 2vw, 0.75rem); gap: 0.35rem; }
            .nav-brand { min-width: 0; }
            .nav-logos { gap: 0.25rem; }
            .nav-logo-img { height: 25px; }
            .nav-logo-divider { height: 15px; }
            .nav-name { font-size: 1rem; }
            .nav-school { font-size: 0.62rem; }
            .nav-text { display: none !important; }
            .theme-btn { padding: 0 0.5rem; min-height: 44px; min-width: 44px; justify-content: center; }
            .hero-inner { gap: 1.25rem; padding: 0 1rem; }
            .hero-title { font-size: clamp(1.85rem, 8vw, 2.8rem); }
            .cta-btn { width: 100%; max-width: 320px; font-size: 1rem; padding: 0.85rem 1.5rem; }
            .footer { padding: 0.5rem 0.75rem; }
            .footer span { font-size: 0.65rem; line-height: 1.4; }
        }

        @media (max-width: 360px) {
            .navbar { padding: 0 0.5rem; }
            .nav-school { display: none; }
            .hero-title { font-size: 1.85rem; }
        }

        @media (min-width: 640px) {
            .navbar { padding: 0 1.5rem; }
            .hero-inner { gap: 2rem; }
            .hero-title { font-size: clamp(2.4rem, 6.5vw, 3.2rem); }
            .cta-btn { font-size: 1.05rem; padding: 0.95rem 2.5rem; }
        }

        /* ─── Standard Tablets (iPad Mini / 768px - 899px) ─── */
        @media (min-width: 768px) and (max-width: 899px) {
            .navbar { padding: 0 2rem; }
            .nav-logos { gap: 0.5rem; }
            .nav-logo-img { height: 34px; }
            .nav-name { font-size: 1.25rem; }
            .nav-school { font-size: 0.78rem; }
            .nav-text { display: inline !important; }
            .theme-btn { padding: 0.45rem 1.1rem; min-height: 44px; font-size: 0.88rem; }
            .hero-inner { gap: clamp(2.5rem, 5vh, 4rem); max-width: 820px; }
            .hero-title {
                font-size: clamp(3.2rem, 7.5vw, 4.8rem);
                line-height: 1.15;
            }
            .cta-btn {
                font-size: 1.25rem;
                padding: 1.15rem 3.5rem;
                min-height: 60px;
                max-width: 440px;
                box-shadow:
                    0 0 0 1px rgba(79,70,229,0.35) inset,
                    0 16px 40px -6px rgba(79,70,229,0.55),
                    0 0 32px rgba(139,92,246,0.35);
            }
            .footer span { font-size: 0.78rem; }
        }

        /* ─── Large & Pro Tablets (iPad Pro 1032x1376, Surface Pro 960x1440: 900px - 1180px or tall portrait tablets) ─── */
        @media (min-width: 900px) and (max-width: 1180px), (min-width: 900px) and (min-height: 1000px) and (max-width: 1300px) {
            .navbar { padding: 0 clamp(2rem, 3.5vw, 3.5rem); }
            .nav-logos { gap: 0.65rem; }
            .nav-logo-img { height: 42px; }
            .nav-logo-divider { height: 26px; }
            .nav-name { font-size: 1.4rem; }
            .nav-school { font-size: 0.88rem; }
            .nav-text { display: inline !important; }
            .theme-btn { padding: 0.55rem 1.35rem; min-height: 48px; font-size: 0.95rem; }
            .hero-inner {
                gap: clamp(3.5rem, 6.5vh, 5.5rem);
                max-width: 960px;
            }
            .hero-title {
                font-size: clamp(4.2rem, 8.5vw, 6.2rem);
                line-height: 1.12;
            }
            .cta-btn {
                font-size: 1.45rem;
                padding: 1.35rem 4.5rem;
                min-height: 72px;
                max-width: 520px;
                border-radius: var(--radius-pill);
                box-shadow:
                    0 0 0 1px rgba(79,70,229,0.35) inset,
                    0 20px 48px -6px rgba(79,70,229,0.6),
                    0 0 40px rgba(139,92,246,0.4);
            }
            .cta-icon {
                width: 28px;
                height: 28px;
            }
            .footer span { font-size: 0.88rem; }
        }

        /* ─── Compact Laptop Screens (Height <= 670px, e.g. 100% zoom on 14" laptop) ─── */
        @media (min-width: 1181px) and (max-height: 670px) {
            .navbar { padding: 0 2rem; }
            .hero-inner { gap: clamp(1.5rem, 3.5vh, 2.5rem); max-width: 800px; }
            .hero-title { font-size: clamp(2.8rem, 5.5vw, 4rem); }
            .cta-btn { font-size: 1.15rem; padding: 0.95rem 3rem; min-height: 52px; max-width: 400px; }
        }

        /* ─── Normal Laptops & Comfortable Landscape (Height 671px - 950px, e.g. 75%-80% zoom or 1080p) ─── */
        @media (min-width: 1181px) and (min-height: 671px) and (max-height: 950px) {
            .navbar { padding: 0 clamp(2rem, 3.5vw, 3.5rem); }
            .hero-inner { gap: clamp(2.5rem, 5.5vh, 4.2rem); max-width: 880px; }
            .hero-title { font-size: clamp(3.8rem, 6.8vw, 5.2rem); }
            .cta-btn { font-size: 1.35rem; padding: 1.25rem 4rem; min-height: 66px; max-width: 460px; }
        }

        @media (min-width: 1024px) and (min-height: 600px) and (max-height: 950px) {
            .root-layout {
                height: 100dvh;
                max-height: 100vh;
                overflow: hidden !important;
            }
            .hero {
                overflow: hidden !important;
            }
        }

        @media (min-width: 1280px) and (min-height: 951px) {
            .hero-inner { gap: clamp(2.5rem, 4.5vh, 4rem); }
            .hero-title { font-size: 5.2rem; }
            .cta-btn { font-size: 1.35rem; padding: 1.25rem 4rem; min-height: 66px; }
        }

        @media (min-width: 1920px) {
            .nav-name { font-size: 1.45rem; }
            .nav-school { font-size: 0.85rem; }
            .hero-title { font-size: 5.6rem; }
            .cta-btn { font-size: 1.4rem; padding: 1.35rem 4.5rem; min-height: 70px; }
        }
    </style>
</head>
<body>

    @if(session('success'))
    <div class="toast" id="successToast">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    <script>
        setTimeout(() => { const t = document.getElementById('successToast'); if(t) t.remove(); }, 4000);
    </script>
    @endif

    <!-- Ambient orbs -->
    <div class="orb orb-1" aria-hidden="true"></div>
    <div class="orb orb-2" aria-hidden="true"></div>
    <div class="orb orb-3" aria-hidden="true"></div>

    <!-- Particle canvas -->
    <canvas id="bgCanvas" aria-hidden="true"></canvas>

    <!-- Root layout -->
    <div class="root-layout">

        <!-- ─── Navbar ─── -->
        <header class="navbar" role="banner">
            <a href="/" class="nav-brand" aria-label="BUTAGI - Beranda">
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
            <!-- Theme toggle button -->
            <button class="theme-btn" id="themeToggle" onclick="toggleTheme()" aria-label="Toggle dark/light mode">
                <svg id="iconMoon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg id="iconSun" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                <span id="themeLabel" class="nav-text">Dark</span>
            </button>
        </header>

        <!-- ─── Hero ─── -->
        <main class="hero" role="main" id="main-content">
            <div class="hero-inner">

                <!-- Headline -->
                <h1 class="hero-title title-gradient">
                    Buku Tamu Digital
                </h1>

                <!-- Standalone CTA — NO card wrapper -->
                <a href="/guest-form" id="ctaBtn" class="cta-btn" role="button" aria-label="Mulai mengisi buku tamu">
                    <span>Isi buku tamu</span>
                    <svg class="cta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>

            </div>
        </main>

        <!-- ─── Footer ─── -->
        <footer class="footer" role="contentinfo">
            <span>© {{ date('Y') }} SMKN 1 Subang</span>
        </footer>

    </div>

    <!-- Particle / star field canvas engine -->
    <script>
    // ── Theme toggle (shared with guest-form via localStorage) ──
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const isDark = theme === 'dark';
        document.getElementById('iconMoon').style.display = isDark ? 'block' : 'none';
        document.getElementById('iconSun').style.display  = isDark ? 'none'  : 'block';
        document.getElementById('themeLabel').textContent = isDark ? 'Light' : 'Dark';
        localStorage.setItem('butagi_theme', theme);
        // Update particle color
        window._particleColor = isDark ? '#a5b4fc' : '#cbd5e1';
    }
    function toggleTheme() {
        const cur = document.documentElement.getAttribute('data-theme') || 'light';
        applyTheme(cur === 'dark' ? 'light' : 'dark');
    }
    // Restore preference on load (defaults to light mode)
    (function() {
        const saved = localStorage.getItem('butagi_theme') || 'light';
        applyTheme(saved);
    })();

    // ── Particle / star field canvas engine ──
    (function() {
        const canvas = document.getElementById('bgCanvas');
        const ctx    = canvas.getContext('2d');
        let W, H, particles = [], rafId;

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', () => { resize(); spawnParticles(); });

        function rand(a, b) { return a + Math.random() * (b - a); }

        function spawnParticles() {
            particles = [];
            const count = Math.floor((W * H) / 11000);
            for (let i = 0; i < count; i++) {
                particles.push({
                    x:     rand(0, W),
                    y:     rand(0, H),
                    r:     rand(0.4, 1.5),
                    a:     rand(0.06, 0.32),
                    phase: rand(0, Math.PI * 2),
                    spd:   rand(0.003, 0.009),
                    drift: rand(-0.08, 0.08),
                    rise:  rand(-0.06, -0.02),
                });
            }
        }
        spawnParticles();

        function draw() {
            ctx.clearRect(0, 0, W, H);
            const color = window._particleColor || '#a5b4fc';
            particles.forEach(p => {
                p.phase += p.spd;
                p.x    += p.drift;
                p.y    += p.rise;
                if (p.y < -4)     p.y = H + 4;
                if (p.x < -4)     p.x = W + 4;
                if (p.x > W + 4)  p.x = -4;

                const a = p.a * (0.45 + 0.55 * Math.sin(p.phase));
                ctx.globalAlpha = a;
                ctx.fillStyle   = color;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fill();
            });
            ctx.globalAlpha = 1;
            rafId = requestAnimationFrame(draw);
        }
        draw();
    })();
    </script>

</body>
</html>
