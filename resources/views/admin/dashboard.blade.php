<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin — BUTAGI SMKN 1 Subang</title>
    <script>
        (function() {
            const saved = localStorage.getItem('butagi_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/mrc-theme.css') }}">
    <style>
        .dashboard-layout {
            min-height: 100vh;
            background-color: transparent;
        }

        .dashboard-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.025em;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        /* Top 4 Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-main);
            border-radius: var(--radius-xl);
            padding: 1.35rem 1.5rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            transition: all 0.2s ease;
            backdrop-filter: blur(16px);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #818cf8, #4f46e5);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-medium);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .stat-val {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 0.35rem;
        }

        .stat-desc {
            font-size: 0.75rem;
            color: #64748b;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Tab Switcher */
        .tabs-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border-main);
            margin-bottom: 1.5rem;
            padding-bottom: 0.25rem;
        }

        .tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #94a3b8;
            border: none;
            background: transparent;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .tab-btn:hover {
            color: #ffffff;
            background: rgba(49, 46, 129, 0.35);
        }

        .tab-btn.active {
            color: #ffffff;
            background: var(--accent-gradient);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        .tab-counter {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: var(--radius-full);
            background: rgba(30, 41, 59, 0.8);
            color: #c7d2fe;
            border: 1px solid rgba(129, 140, 248, 0.25);
        }

        .tab-btn.active .tab-counter {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            border: none;
        }

        /* Filter Toolbar */
        .toolbar-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-main);
            border-radius: var(--radius-xl);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(16px);
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
            min-width: 280px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 360px;
        }

        .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #818cf8;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 0.5625rem 1rem 0.5625rem 2.35rem;
            font-size: 0.875rem;
            background: rgba(30, 41, 59, 0.65);
            border: 1.5px solid var(--border-main);
            border-radius: var(--radius-lg);
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            background: rgba(30, 41, 59, 0.95);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-ring), 0 0 15px rgba(99, 102, 241, 0.25);
        }

        .search-input::placeholder {
            color: #64748b;
        }

        .select-filter {
            padding: 0.5625rem 2rem 0.5625rem 0.875rem;
            font-size: 0.875rem;
            background-color: rgba(30, 41, 59, 0.65);
            border: 1.5px solid var(--border-main);
            border-radius: var(--radius-lg);
            color: #ffffff;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23818cf8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.6rem center;
            transition: all 0.2s ease;
        }

        .select-filter:focus {
            border-color: var(--accent);
            background-color: rgba(30, 41, 59, 0.95);
        }

        .select-filter option {
            background-color: #0f172a;
            color: #ffffff;
        }

        /* Modern Table Card */
        .table-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-main);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(16px);
        }

        .mrc-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .mrc-table th {
            background: rgba(30, 27, 75, 0.65);
            padding: 0.875rem 1.25rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #c7d2fe;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-main);
        }

        .mrc-table td {
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            color: #e2e8f0;
            border-bottom: 1px solid var(--border-subtle);
            vertical-align: middle;
        }

        .mrc-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .mrc-table tbody tr:hover {
            background-color: rgba(49, 46, 129, 0.35);
        }

        .mrc-table tbody tr:last-child td {
            border-bottom: none;
        }

        .td-num {
            font-weight: 600;
            color: #94a3b8;
            font-size: 0.8125rem;
        }
        .td-nama {
            font-weight: 700;
            color: #ffffff;
            font-size: 0.875rem;
        }
        .td-instansi {
            font-weight: 600;
            color: #cbd5e1;
            font-size: 0.875rem;
        }
        .badge-ulasan-senang {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.4);
            font-weight: 700;
        }
        .badge-ulasan-menarik,
        .badge-ulasan-biasa {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(129, 140, 248, 0.4);
            font-weight: 700;
        }
        .badge-ulasan-unik {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
            border: 1px solid rgba(251, 191, 36, 0.4);
            font-weight: 700;
        }
        .badge-ulasan-sedih {
            background: rgba(225, 29, 72, 0.2);
            color: #fda4af;
            border: 1px solid rgba(251, 113, 133, 0.4);
            font-weight: 700;
        }

        /* Table Action Buttons */
        .action-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-table-action {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-main);
            background: rgba(30, 41, 59, 0.7);
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-table-action:hover {
            background: rgba(49, 46, 129, 0.8);
            color: #ffffff;
            border-color: var(--border-hover);
        }

        .btn-table-action.btn-del:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-color: #ef4444;
        }

        /* Modal Backdrop & Dialog */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 15, 30, 0.75);
            backdrop-filter: blur(8px);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-card {
            background: rgba(15, 23, 42, 0.95);
            border-radius: var(--radius-2xl);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 40px rgba(99, 102, 241, 0.3);
            border: 1px solid var(--border-main);
            color: #ffffff;
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: modalFadeUp 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(20px);
        }

        @keyframes modalFadeUp {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(8px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid var(--border-main);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #ffffff;
        }

        .modal-close-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        .modal-body {
            padding: 1.75rem;
        }

        .modal-footer {
            padding: 1rem 1.75rem;
            border-top: 1px solid var(--border-main);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            background: transparent;
            border-bottom-left-radius: var(--radius-2xl);
            border-bottom-right-radius: var(--radius-2xl);
        }

        /* Preview layout inside modal */
        .preview-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .preview-img-container {
            border-radius: var(--radius-xl);
            overflow: hidden;
            border: 1px solid var(--border-main);
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
        }

        .preview-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-meta-item {
            margin-bottom: 0.875rem;
        }

        .preview-meta-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.2rem;
        }

        .preview-meta-value {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #ffffff;
        }

        .preview-sig-container {
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-main);
            background: #ffffff;
            padding: 0.5rem;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-sig-container img {
            max-height: 90px;
            max-width: 100%;
            object-fit: contain;
        }

        /* ══════════════════════════════════════════════
           LIGHT MODE — Modern Clean
        ══════════════════════════════════════════════ */
        [data-theme="light"] .dashboard-layout {
            background-color: #f8fafc;
        }

        [data-theme="light"] .page-title {
            color: #0f172a;
        }

        [data-theme="light"] .page-subtitle {
            color: #64748b;
        }

        [data-theme="light"] .stat-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        }

        [data-theme="light"] .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        [data-theme="light"] .stat-card::before {
            background: linear-gradient(to right, #090a0f, #475569);
        }

        [data-theme="light"] .stat-val {
            color: #0f172a;
        }

        [data-theme="light"] .stat-label {
            color: #64748b;
        }

        [data-theme="light"] .stat-desc {
            color: #94a3b8;
        }

        [data-theme="light"] .stat-icon-wrapper {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Tabs */
        [data-theme="light"] .tabs-header {
            border-bottom-color: #e2e8f0;
        }

        [data-theme="light"] .tab-btn {
            color: #64748b;
        }

        [data-theme="light"] .tab-btn:hover {
            color: #0f172a;
            background: #f1f5f9;
        }

        [data-theme="light"] .tab-btn.active {
            color: #ffffff;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }

        [data-theme="light"] .tab-counter {
            background: #f1f5f9;
            color: #475569;
            border-color: #e2e8f0;
        }

        [data-theme="light"] .tab-btn.active .tab-counter {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border: none;
        }

        /* Toolbar */
        [data-theme="light"] .toolbar-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        }

        [data-theme="light"] .search-icon {
            color: #64748b;
        }

        [data-theme="light"] .search-input {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        [data-theme="light"] .search-input:focus {
            background: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        [data-theme="light"] .search-input::placeholder {
            color: #94a3b8;
        }

        [data-theme="light"] .select-filter {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        }

        [data-theme="light"] .select-filter:focus {
            background-color: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        [data-theme="light"] .select-filter option {
            background-color: #ffffff;
            color: #0f172a;
        }

        /* Table */
        [data-theme="light"] .table-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        }

        [data-theme="light"] .mrc-table th {
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #cbd5e1;
        }

        [data-theme="light"] .mrc-table td {
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            padding: 0.95rem 1.25rem;
        }

        [data-theme="light"] .mrc-table tbody tr:hover {
            background-color: #f8fafc;
        }

        [data-theme="light"] .td-num {
            color: #64748b;
            font-weight: 700;
        }

        [data-theme="light"] .td-nama {
            color: #0f172a;
            font-weight: 800;
            font-size: 0.9rem;
        }

        [data-theme="light"] .td-instansi {
            color: #334155;
            font-weight: 600;
            font-size: 0.875rem;
        }

        [data-theme="light"] .badge-guru {
            background-color: #eef2ff !important;
            color: #312e81 !important;
            border: 1px solid #c7d2fe !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .badge-siswa {
            background-color: #faf5ff !important;
            color: #581c87 !important;
            border: 1px solid #e9d5ff !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .badge-ulasan-senang {
            background: #ecfdf5 !important;
            color: #065f46 !important;
            border: 1px solid #a7f3d0 !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .badge-ulasan-menarik,
        [data-theme="light"] .badge-ulasan-biasa {
            background: #eff6ff !important;
            color: #1e40af !important;
            border: 1px solid #bfdbfe !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .badge-ulasan-unik {
            background: #fffbeb !important;
            color: #92400e !important;
            border: 1px solid #fde68a !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .badge-ulasan-sedih {
            background: #fff1f2 !important;
            color: #9f1239 !important;
            border: 1px solid #fecdd3 !important;
            font-weight: 700 !important;
        }

        [data-theme="light"] .btn-table-action {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }

        [data-theme="light"] .btn-table-action:hover {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
        }

        [data-theme="light"] .btn-table-action.btn-del:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }

        /* Modals in Admin */
        [data-theme="light"] .modal-backdrop {
            background: rgba(15, 23, 42, 0.5);
        }

        [data-theme="light"] .modal-card {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.2);
            color: #0f172a;
        }

        [data-theme="light"] .modal-header {
            border-bottom: 1px solid #f1f5f9;
        }

        [data-theme="light"] .modal-title {
            color: #0f172a;
        }

        [data-theme="light"] .modal-close-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }

        [data-theme="light"] .modal-close-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        [data-theme="light"] .modal-footer {
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
        }

        [data-theme="light"] .preview-img-container {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        [data-theme="light"] .preview-sig-container {
            background: #ffffff;
            border-color: #e2e8f0;
        }

        [data-theme="light"] .preview-meta-label {
            color: #64748b;
        }

        [data-theme="light"] .preview-meta-value {
            color: #0f172a;
        }
    </style>
</head>
<body class="dashboard-layout">

    <!-- Sticky Navbar -->
    <header class="mrc-navbar">
        <a href="/admin/dashboard" class="mrc-nav-brand">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo SMKN 1 Subang" class="mrc-brand-logo">
                <img src="{{ asset('img/logomrc.png') }}" alt="Logo MRC" class="mrc-brand-logo" style="height: 38px; width: auto; object-fit: contain;">
            </div>
            <div class="mrc-brand-text">
                <div class="mrc-brand-title">
                    <span>BUTAGI</span>
                    <span class="mrc-brand-badge">ADMIN PANEL</span>
                </div>
                <span class="mrc-brand-sub">SMKN 1 Subang</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <!-- Theme Toggle Button -->
            <button type="button" class="theme-btn" id="themeToggle" onclick="toggleTheme()" aria-label="Ganti Tema (Dark / Light)" title="Ganti Tema">
                <svg class="icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                </svg>
                <svg class="icon-sun" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                </svg>
                <span class="theme-btn-text">Dark</span>
            </button>

            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: #ffffff; padding: 0.35rem 0.75rem; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.18); border-radius: var(--radius-full);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span style="font-weight: 600; color: #ffffff;">{{ session('admin_username') ?? 'Admin' }}</span>
            </div>

            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-mrc btn-mrc-outline" style="padding: 0.42rem 0.85rem; font-size: 0.8125rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <main class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard Rekapitulasi</h1>
                <p class="page-subtitle">Pantau dan kelola kehadiran pengunjung pameran secara real-time</p>
            </div>

            <div style="display: flex; gap: 0.75rem;">
                <button type="button" onclick="exportData()" class="btn-mrc btn-mrc-accent">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span>Ekspor Laporan PDF</span>
                </button>
            </div>
        </div>

        <!-- 4 Stat Cards ala MRC -->
        <div class="stats-grid">
            <!-- Card 1: Total Tamu -->
            <div class="stat-card">
                <div>
                    <div class="stat-label">TOTAL PENGUNJUNG</div>
                    <div class="stat-val" id="stat-total-count">0</div>
                    <div class="stat-desc">Akumulasi Instansi & Sekolah</div>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(129, 140, 248, 0.3);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: Total Instansi -->
            <div class="stat-card stat-guru">
                <div>
                    <div class="stat-label">TAMU INSTANSI</div>
                    <div class="stat-val" id="stat-instansi-count">0</div>
                    <div class="stat-desc">Perusahaan, Industri & Umum</div>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(79, 70, 229, 0.25); color: #a5b4fc; border: 1px solid rgba(129, 140, 248, 0.3);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                        <path d="M9 22v-4h6v4"/>
                        <path d="M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3: Total Sekolah -->
            <div class="stat-card stat-siswa">
                <div>
                    <div class="stat-label">TAMU SEKOLAH</div>
                    <div class="stat-val" id="stat-sekolah-count">0</div>
                    <div class="stat-desc">Siswa, Guru & Sekolah Lain</div>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(168, 85, 247, 0.25); color: #d8b4fe; border: 1px solid rgba(192, 132, 252, 0.3);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4: Kepuasan Pengunjung -->
            <div class="stat-card stat-kelas">
                <div>
                    <div class="stat-label">ULASAN SENANG</div>
                    <div class="stat-val" id="stat-ulasan-count">0</div>
                    <div class="stat-desc">Pengunjung Sangat Puas 😊</div>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.3);">
                    <span style="font-size: 1.35rem;">😊</span>
                </div>
            </div>
        </div>

        <!-- Tab Header -->
        <div class="tabs-header">
            <button type="button" class="tab-btn active" id="tabInstansiBtn" onclick="switchTab('instansi')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                    <path d="M9 22v-4h6v4"/>
                </svg>
                <span>Tamu Instansi</span>
                <span class="tab-counter" id="instansi-tab-count">0</span>
            </button>

            <button type="button" class="tab-btn" id="tabSekolahBtn" onclick="switchTab('sekolah')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
                <span>Tamu Sekolah</span>
                <span class="tab-counter" id="sekolah-tab-count">0</span>
            </button>
        </div>

        <!-- Filter Toolbar -->
        <div class="toolbar-card">
            <!-- Left Filter Controls -->
            <div class="toolbar-left">
                <!-- Instansi Search -->
                <div class="search-box" id="instansiSearchBox">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="instansi-search" class="search-input" placeholder="Cari nama atau instansi...">
                </div>

                <!-- Sekolah Search & Asal Sekolah Filter -->
                <div class="search-box" id="sekolahSearchBox" style="display: none;">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="sekolah-search-nama" class="search-input" placeholder="Cari nama pengunjung...">
                </div>

                <select id="sekolah-search-filter" class="select-filter" style="display: none;">
                    <option value="">Semua Asal Sekolah</option>
                </select>

                <!-- Sort Toggle -->
                <button type="button" id="sortToggleBtn" class="btn-mrc btn-mrc-outline" style="padding: 0.5rem 0.875rem;" title="Urutkan Nama A-Z">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 16 4 4 4-4M7 20V4 M16 10V6a2 2 0 0 1 4 0v4 M16 8h4 M16 14h4l-4 6h4"/>
                    </svg>
                    <span id="sortLabelText">Urutkan: Normal</span>
                </button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <!-- Instansi Table -->
            <div id="instansiTableContainer">
                <table class="mrc-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">No</th>
                            <th>Nama Pengunjung</th>
                            <th>Instansi / Lembaga</th>
                            <th style="width: 140px;">Ulasan</th>
                            <th style="width: 130px;">Status</th>
                            <th style="width: 140px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="instansi-tbody">
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Memuat data instansi...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Sekolah Table -->
            <div id="sekolahTableContainer" style="display: none;">
                <table class="mrc-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">No</th>
                            <th>Nama Pengunjung</th>
                            <th>Asal Sekolah</th>
                            <th style="width: 140px;">Ulasan</th>
                            <th style="width: 130px;">Status</th>
                            <th style="width: 140px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sekolah-tbody">
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Memuat data sekolah...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Preview Modal -->
    <div class="modal-backdrop" id="previewModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Detail Pengunjung</h3>
                <button type="button" class="modal-close-btn" onclick="closePreviewModal()" aria-label="Tutup modal">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body" id="previewBody">
                <!-- Filled via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-mrc btn-mrc-outline" onclick="closePreviewModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal-backdrop" id="editModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Ubah Data Tamu</h3>
                <button type="button" class="modal-close-btn" onclick="closeEditModal()" aria-label="Tutup modal">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="editForm" onsubmit="submitEdit(event)">
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="mrc-form-group">
                        <label class="mrc-label" for="editNama">Nama Lengkap</label>
                        <input type="text" id="editNama" class="mrc-input" required>
                    </div>

                    <div class="mrc-form-group">
                        <label class="mrc-label" for="editStatus">Status</label>
                        <select id="editStatus" class="select-filter" style="width: 100%;" onchange="toggleEditFields()">
                            <option value="instansi">Instansi</option>
                            <option value="sekolah">Sekolah</option>
                        </select>
                    </div>

                    <div class="mrc-form-group" id="editInstansiGroup">
                        <label class="mrc-label" for="editInstansi">Nama Instansi</label>
                        <input type="text" id="editInstansi" class="mrc-input" placeholder="Nama Instansi / Perusahaan">
                    </div>

                    <div class="mrc-form-group" id="editSekolahGroup" style="display: none;">
                        <label class="mrc-label" for="editAsalSekolah">Asal Sekolah</label>
                        <input type="text" id="editAsalSekolah" class="mrc-input" placeholder="SMKN 1 Subang">
                    </div>

                    <div class="mrc-form-group">
                        <label class="mrc-label" for="editUlasan">Ulasan Pengunjung</label>
                        <select id="editUlasan" class="select-filter" style="width: 100%;">
                            <option value="senang">😊 Senang</option>
                            <option value="menarik">🤩 Menarik</option>
                            <option value="unik">🤔 Unik</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-mrc btn-mrc-outline" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-mrc btn-mrc-accent">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Logic -->
    <script>
        let currentSection = 'instansi';
        let currentSort = '';
        let totalInstansi = 0;
        let totalSekolah = 0;
        let totalSenang = 0;

        function switchTab(section) {
            currentSection = section;

            const tabInstansiBtn = document.getElementById('tabInstansiBtn');
            const tabSekolahBtn = document.getElementById('tabSekolahBtn');
            const instansiTable = document.getElementById('instansiTableContainer');
            const sekolahTable = document.getElementById('sekolahTableContainer');
            const instansiSearchBox = document.getElementById('instansiSearchBox');
            const sekolahSearchBox = document.getElementById('sekolahSearchBox');
            const filterSekolah = document.getElementById('sekolah-search-filter');

            if (section === 'instansi') {
                tabInstansiBtn.classList.add('active');
                tabSekolahBtn.classList.remove('active');
                instansiTable.style.display = 'block';
                sekolahTable.style.display = 'none';
                instansiSearchBox.style.display = 'block';
                sekolahSearchBox.style.display = 'none';
                filterSekolah.style.display = 'none';
                loadInstansi();
            } else {
                tabSekolahBtn.classList.add('active');
                tabInstansiBtn.classList.remove('active');
                sekolahTable.style.display = 'block';
                instansiTable.style.display = 'none';
                instansiSearchBox.style.display = 'none';
                sekolahSearchBox.style.display = 'block';
                filterSekolah.style.display = 'inline-block';
                loadSekolah();
                loadSchools();
            }
        }

        // Helper Emoji Ulasan
        function getUlasanBadge(val) {
            if (val === 'senang') {
                return '<span class="badge-pill badge-ulasan-senang">😊 Senang</span>';
            } else if (val === 'menarik' || val === 'biasa') {
                return '<span class="badge-pill badge-ulasan-menarik">🤩 Menarik</span>';
            } else if (val === 'unik' || val === 'sedih') {
                return '<span class="badge-pill badge-ulasan-unik">🤔 Unik</span>';
            } else {
                return '-';
            }
        }

        // Load Instansi
        function loadInstansi() {
            const search = document.getElementById('instansi-search').value;
            fetch(`/api/instansi?search=${encodeURIComponent(search)}&sort=${currentSort}`)
                .then(r => r.json())
                .then(data => {
                    totalInstansi = data.count;
                    document.getElementById('stat-instansi-count').innerText = data.count;
                    document.getElementById('instansi-tab-count').innerText = data.count;
                    calculateTotalStats(data.data, 'instansi');
                    renderInstansi(data.data);
                })
                .catch(err => console.error('Error loading instansi:', err));
        }

        // Load Sekolah
        function loadSekolah() {
            const searchNama = document.getElementById('sekolah-search-nama').value;
            const searchSekolah = document.getElementById('sekolah-search-filter').value;
            fetch(`/api/sekolah?search_nama=${encodeURIComponent(searchNama)}&search_sekolah=${encodeURIComponent(searchSekolah)}&sort=${currentSort}`)
                .then(r => r.json())
                .then(data => {
                    totalSekolah = data.count;
                    document.getElementById('stat-sekolah-count').innerText = data.count;
                    document.getElementById('sekolah-tab-count').innerText = data.count;
                    calculateTotalStats(data.data, 'sekolah');
                    renderSekolah(data.data);
                })
                .catch(err => console.error('Error loading sekolah:', err));
        }

        let instansiItemsCache = [];
        let sekolahItemsCache = [];

        function calculateTotalStats(items, source) {
            if (source === 'instansi') instansiItemsCache = items || [];
            if (source === 'sekolah') sekolahItemsCache = items || [];

            document.getElementById('stat-total-count').innerText = totalInstansi + totalSekolah;

            const allItems = [...instansiItemsCache, ...sekolahItemsCache];
            const senangCount = allItems.filter(i => (i.ulasan || '') === 'senang').length;
            document.getElementById('stat-ulasan-count').innerText = senangCount;
        }

        function loadSchools() {
            fetch('/api/schools')
                .then(r => r.json())
                .then(schools => {
                    const select = document.getElementById('sekolah-search-filter');
                    const currentValue = select.value;
                    select.innerHTML = '<option value="">Semua Asal Sekolah</option>';
                    schools.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s;
                        opt.textContent = s;
                        if (s === currentValue) opt.selected = true;
                        select.appendChild(opt);
                    });
                })
                .catch(err => console.error('Error loading schools list:', err));
        }

        function renderInstansi(data) {
            const tbody = document.getElementById('instansi-tbody');
            if (!data || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data tamu instansi ditemukan.</td></tr>`;
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr>
                    <td class="td-num">${item.id}</td>
                    <td class="td-nama">${escapeHtml(item.nama)}</td>
                    <td class="td-instansi">${escapeHtml(item.instansi || '-')}</td>
                    <td>${getUlasanBadge(item.ulasan)}</td>
                    <td><span class="badge-pill badge-guru">Instansi</span></td>
                    <td>
                        <div class="action-cell" style="justify-content: flex-end;">
                            <button type="button" class="btn-table-action" onclick="openPreview(${item.db_id})" title="Lihat Foto & TTD">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <button type="button" class="btn-table-action" onclick="openEdit(${item.db_id})" title="Edit Data">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </button>
                            <button type="button" class="btn-table-action btn-del" onclick="deleteData(${item.db_id})" title="Hapus Data">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderSekolah(data) {
            const tbody = document.getElementById('sekolah-tbody');
            if (!data || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data tamu sekolah ditemukan.</td></tr>`;
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr>
                    <td class="td-num">${item.id}</td>
                    <td class="td-nama">${escapeHtml(item.nama)}</td>
                    <td class="td-instansi">${escapeHtml(item.asal_sekolah || '-')}</td>
                    <td>${getUlasanBadge(item.ulasan)}</td>
                    <td><span class="badge-pill badge-siswa">Sekolah</span></td>
                    <td>
                        <div class="action-cell" style="justify-content: flex-end;">
                            <button type="button" class="btn-table-action" onclick="openPreview(${item.db_id})" title="Lihat Foto & TTD">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <button type="button" class="btn-table-action" onclick="openEdit(${item.db_id})" title="Edit Data">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </button>
                            <button type="button" class="btn-table-action btn-del" onclick="deleteData(${item.db_id})" title="Hapus Data">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function escapeHtml(text) {
            if (!text) return '';
            return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        // Toggle Sort
        document.getElementById('sortToggleBtn').addEventListener('click', function() {
            const label = document.getElementById('sortLabelText');
            if (currentSort === '') {
                currentSort = 'asc';
                label.innerText = 'Urutan: A - Z';
            } else if (currentSort === 'asc') {
                currentSort = 'desc';
                label.innerText = 'Urutan: Z - A';
            } else {
                currentSort = '';
                label.innerText = 'Urutan: Normal';
            }

            if (currentSection === 'instansi') loadInstansi();
            else loadSekolah();
        });

        // Modals
        function openPreview(id) {
            fetch(`/api/data/${id}`)
                .then(r => r.json())
                .then(data => {
                    const fotoHTML = data.foto ? `
                        <div class="preview-img-container">
                            <img src="/storage/${data.foto}" alt="Foto">
                        </div>
                    ` : `
                        <div class="preview-img-container" style="background:#f1f5f9; color:#94a3b8; font-size:0.8125rem;">
                            Tidak ada foto
                        </div>
                    `;

                    const ttdHTML = data.tanda_tangan ? `
                        <div class="preview-sig-container">
                            <img src="/storage/${data.tanda_tangan}" alt="Tanda Tangan">
                        </div>
                    ` : `
                        <div class="preview-sig-container" style="background:#f8fafc; color:#94a3b8; font-size:0.8125rem;">
                            Tanda tangan dilewati
                        </div>
                    `;

                    document.getElementById('previewBody').innerHTML = `
                        <div class="preview-grid">
                            <div>
                                <div class="preview-meta-label">Foto Pengunjung</div>
                                ${fotoHTML}
                            </div>
                            <div>
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Nama Lengkap</div>
                                    <div class="preview-meta-value">${escapeHtml(data.nama)}</div>
                                </div>
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Status</div>
                                    <div class="preview-meta-value">${data.status === 'instansi' ? '<span class="badge-pill badge-guru">Instansi</span>' : '<span class="badge-pill badge-siswa">Sekolah</span>'}</div>
                                </div>
                                ${data.status === 'instansi' ? `
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Instansi / Lembaga</div>
                                    <div class="preview-meta-value">${escapeHtml(data.instansi || '-')}</div>
                                </div>` : `
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Asal Sekolah</div>
                                    <div class="preview-meta-value">${escapeHtml(data.asal_sekolah || '-')}</div>
                                </div>`}
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Penilaian Ulasan</div>
                                    <div class="preview-meta-value">${getUlasanBadge(data.ulasan)}</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="preview-meta-label" style="margin-bottom: 0.35rem;">Tanda Tangan</div>
                            ${ttdHTML}
                        </div>
                    `;

                    document.getElementById('previewModal').classList.add('show');
                });
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.remove('show');
        }

        function openEdit(id) {
            fetch(`/api/data/${id}`)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('editId').value = id;
                    document.getElementById('editNama').value = data.nama;
                    document.getElementById('editStatus').value = data.status === 'guru' ? 'instansi' : (data.status === 'siswa' ? 'sekolah' : data.status);
                    document.getElementById('editInstansi').value = data.instansi || '';
                    document.getElementById('editAsalSekolah').value = data.asal_sekolah || '';
                    let ulasanVal = data.ulasan || 'senang';
                    if (ulasanVal === 'biasa') ulasanVal = 'menarik';
                    if (ulasanVal === 'sedih') ulasanVal = 'unik';
                    document.getElementById('editUlasan').value = ulasanVal;
                    toggleEditFields();
                    document.getElementById('editModal').classList.add('show');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        function toggleEditFields() {
            const status = document.getElementById('editStatus').value;
            const instansiGroup = document.getElementById('editInstansiGroup');
            const sekolahGroup = document.getElementById('editSekolahGroup');
            if (status === 'instansi') {
                instansiGroup.style.display = 'block';
                sekolahGroup.style.display = 'none';
            } else {
                sekolahGroup.style.display = 'block';
                instansiGroup.style.display = 'none';
            }
        }

        function submitEdit(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const status = document.getElementById('editStatus').value;
            const payload = {
                nama: document.getElementById('editNama').value,
                status: status,
                instansi: status === 'instansi' ? document.getElementById('editInstansi').value : null,
                asal_sekolah: status === 'sekolah' ? document.getElementById('editAsalSekolah').value : null,
                ulasan: document.getElementById('editUlasan').value
            };

            fetch(`/api/data/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    closeEditModal();
                    loadInstansi();
                    loadSekolah();
                    loadSchools();
                }
            })
            .catch(err => alert('Gagal memperbarui data: ' + err.message));
        }

        function deleteData(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data pengunjung ini?')) return;

            fetch(`/api/data/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    loadInstansi();
                    loadSekolah();
                    loadSchools();
                }
            })
            .catch(err => alert('Gagal menghapus data: ' + err.message));
        }

        function exportData() {
            const params = new URLSearchParams();
            params.set('section', currentSection);
            if (currentSection === 'instansi') {
                const search = document.getElementById('instansi-search')?.value || '';
                if (search) params.set('search', search);
            } else {
                const searchNama = document.getElementById('sekolah-search-nama')?.value || '';
                const searchSekolah = document.getElementById('sekolah-search-filter')?.value || '';
                if (searchNama) params.set('search_nama', searchNama);
                if (searchSekolah) params.set('search_sekolah', searchSekolah);
            }
            if (currentSort) params.set('sort', currentSort);

            window.location.href = `/admin/export-pdf?${params.toString()}`;
        }

        // Theme switcher logic
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

        // Init & Search Debounce
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('butagi_theme') || 'dark';
            applyTheme(savedTheme);

            loadInstansi();
            loadSekolah();
            loadSchools();

            let timer;
            function debounce(fn) {
                clearTimeout(timer);
                timer = setTimeout(fn, 250);
            }

            document.getElementById('instansi-search').addEventListener('keyup', () => debounce(loadInstansi));
            document.getElementById('sekolah-search-nama').addEventListener('keyup', () => debounce(loadSekolah));
            document.getElementById('sekolah-search-filter').addEventListener('change', () => loadSekolah());

            document.getElementById('previewModal').addEventListener('click', function(e) {
                if (e.target === this) closePreviewModal();
            });
            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) closeEditModal();
            });
        });
    </script>

</body>
</html>

