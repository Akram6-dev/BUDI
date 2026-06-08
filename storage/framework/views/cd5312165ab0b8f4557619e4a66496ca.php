<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Dashboard - Pameran TKI</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/guest-form.css')); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            /* Override global styles from public/css/welcome.css */
            display: block !important;
            flex-direction: initial !important;
            overflow-x: hidden;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        .admin-navbar {
            background: #ffffff;
            color: #111827;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
            /* Override global nav { position: fixed; left:0; right:0 } */
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            width: auto !important;
            z-index: 1;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .sidebar-toggle:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .sidebar-toggle svg {
            width: 18px;
            height: 18px;
        }

        .admin-container.sidebar-collapsed .sidebar-toggle {
            display: inline-flex;
        }

        .navbar-left img {
            height: 50px;
        }

        .navbar-left span {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .admin-username {
            font-size: 0.95rem;
            color: #374151;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white;
            border: 1px solid #ef4444;
            padding: 0.6rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-logout:hover {
            background-color: #dc2626;
            border-color: #dc2626;
        }

        .admin-sidebar {
            width: 260px;
            background: #f3f4f6;
            color: #111827;
            padding: 1.25rem 0;
            border-right: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: auto;
            transition: width 0.2s ease;
        }

        .admin-container.sidebar-collapsed .admin-sidebar {
            width: 0;
            padding: 0;
            border-right: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .admin-container.sidebar-collapsed .sidebar-title,
        .admin-container.sidebar-collapsed .sidebar-btn span,
        .admin-container.sidebar-collapsed .btn-export span {
            display: none;
        }

        .admin-container.sidebar-collapsed .sidebar-btn {
            justify-content: center;
            padding: 0.9rem 0.75rem;
        }

        .admin-container.sidebar-collapsed .btn-export {
            justify-content: center;
            padding: 0.8rem 0.75rem;
        }

        .admin-container.sidebar-collapsed .admin-main {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .sidebar-title {
            padding: 0 1rem;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            color: #111827;
        }

        .sidebar-title-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0.75rem;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            color: inherit;
            cursor: pointer;
            font-size: inherit;
            font-weight: inherit;
            text-align: left;
        }

        .sidebar-title-btn:hover {
            background: #ffffff;
            border-color: #e5e7eb;
        }

        .sidebar-title-btn:active {
            transform: translateY(0.5px);
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .sidebar-btn {
            background: #ffffff;
            color: #111827;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
            border: 1px solid #e5e7eb;
        }

        .sidebar-btn:hover {
            background: #f9fafb;
        }

        .sidebar-btn.active {
            background: #111827;
            color: #ffffff;
            border-color: #111827;
        }

        .sidebar-export {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-export {
            width: 100%;
            background: #2563eb;
            color: #ffffff;
            border: 1px solid #2563eb;
            padding: 0.8rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-export:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        .admin-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
        }

        .admin-main {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background: #ffffff;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2d3436;
            margin-bottom: 2rem;
            border-bottom: 3px solid #e5e7eb;
            padding-bottom: 1rem;
        }

        .summary-and-filters {
            display: flex;
            gap: 1rem;
            align-items: stretch;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .summary-and-filters .count-box {
            flex: 0 0 260px;
            min-width: 240px;
            margin-bottom: 0;
        }

        .summary-and-filters .filter-group {
            flex: 1;
            margin-bottom: 0;
        }

        .filter-group {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            border: 1px solid #e5e7eb;
        }

        .filter-item {
            flex: 1;
            min-width: 250px;
        }

        .filter-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.5rem;
        }

        .filter-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .count-box {
            background: #ffffff;
            color: #111827;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
            border: 1px solid #e5e7eb;
        }

        .count-box h3 {
            font-size: 0.95rem;
            opacity: 0.85;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .count-box .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #111827;
        }

        .table-wrapper {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
            border: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #2d3436;
            font-size: 0.9rem;
        }

        table tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.2s;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        table td {
            padding: 1rem;
            font-size: 0.9rem;
            color: #495057;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-action {
            border: none;
            padding: 0.6rem 0.8rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .btn-preview {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-preview:hover {
            background: #bbdefb;
        }

        .btn-edit {
            background: #fff3e0;
            color: #f57c00;
        }

        .btn-edit:hover {
            background: #ffe0b2;
        }

        .btn-delete {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete:hover {
            background: #ffcdd2;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2d3436;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #2d3436;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .preview-item {
            margin-bottom: 1.5rem;
        }

        .preview-label {
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .preview-value {
            color: #495057;
            font-size: 0.95rem;
            padding: 0.5rem 0;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) minmax(280px, 1.4fr);
            gap: 1.5rem;
            align-items: start;
            margin-bottom: 1.75rem;
        }

        .preview-left,
        .preview-right {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .preview-photo-box,
        .preview-signature-box {
            border-radius: 16px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 0 rgba(17,24,39,0.04);
        }

        .preview-photo-box img,
        .preview-signature-box img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .preview-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .preview-label {
            font-weight: 700;
            color: #1f2937;
            font-size: 0.95rem;
        }

        .preview-value {
            color: #374151;
            font-size: 1.05rem;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .preview-signature {
            margin-top: 0.5rem;
        }

        .preview-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .form-input,
        .modal select.form-input,
        .modal input.form-input {
            color: #111827;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-modal {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save {
            background: #667eea;
            color: white;
        }

        .btn-save:hover {
            background: #5568d3;
        }

        .btn-cancel {
            background: #e9ecef;
            color: #495057;
        }

        .btn-cancel:hover {
            background: #dee2e6;
        }

        .admin-footer {
            background: #ffffff;
            color: #6b7280;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.85rem;
            border-top: 1px solid #e5e7eb;
            /* Override global footer styles */
            position: relative !important;
        }
    </style>
</head>
<body>
    <div class="admin-container" id="adminContainer">
        <!-- Sidebar -->
        <aside class="admin-sidebar" aria-label="Sidebar">
            <div class="sidebar-title">
                <button type="button" class="sidebar-title-btn" onclick="collapseSidebar()" title="Kecilkan sidebar">
                    Dashboard Admin
                </button>
            </div>
            <div class="sidebar-menu">
                <button class="sidebar-btn active" onclick="switchSection('teacher', event)">
                    <span>Teacher</span>
                </button>
                <button class="sidebar-btn" onclick="switchSection('student', event)">
                    <span>Student</span>
                </button>
            </div>
            <div class="sidebar-export">
                <button class="btn-export" onclick="exportData()">
                    <span>Export Data</span>
                </button>
            </div>
        </aside>

        <div class="admin-content">
            <!-- Navbar (only for content area width) -->
            <nav class="admin-navbar">
                <div class="navbar-left">
                    <button type="button" class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Buka sidebar" title="Buka sidebar">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="#111827" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <img src="<?php echo e(asset('img/Gambar_SMKN_1SUBANG.png')); ?>" alt="Logo SMKN 1 Subang">
                    <span>PAMERAN TKI - ADMIN</span>
                </div>
                <div class="navbar-right">
                    <form action="/logout" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="admin-main">
                <!-- Teacher Section -->
                <section id="teacher" class="section active">
                    <h1 class="section-title">KEHADIRAN GURU</h1>

                    <div class="summary-and-filters">
                        <div class="count-box">
                            <h3>Total Guru</h3>
                            <div class="number" id="teacher-count">0</div>
                        </div>

                        <div class="filter-group">
                            <div class="filter-item">
                                <label class="filter-label">Cari Nama Guru</label>
                                <input type="text" class="filter-input" id="teacher-search" placeholder="Masukkan nama guru">
                            </div>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table id="teacher-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="teacher-tbody">
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Student Section -->
                <section id="student" class="section">
                    <h1 class="section-title">KEHADIRAN SISWA</h1>

                    <div class="summary-and-filters">
                        <div class="count-box">
                            <h3>Total Siswa</h3>
                            <div class="number" id="student-count">0</div>
                        </div>

                        <div class="filter-group">
                            <div class="filter-item">
                                <label class="filter-label">Cari Nama Siswa</label>
                                <input type="text" class="filter-input" id="student-search-nama" placeholder="Masukkan nama siswa">
                            </div>
                            <div class="filter-item">
                                <label class="filter-label">Cari Kelas</label>
                                <input type="text" class="filter-input" id="student-search-kelas" placeholder="Masukkan kelas">
                            </div>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table id="student-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="student-tbody">
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>

            <!-- Footer (only for content area width) -->
            <footer class="admin-footer">
                <p>&copy; 2026 SMKN 1 Subang - Pameran TKI. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Detail Data</h2>
                <button class="modal-close" onclick="closePreviewModal()">&times;</button>
            </div>
            <div class="modal-body" id="previewBody">
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Data</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm" onsubmit="submitEdit(event)">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="editSection">

                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-input" id="editNama" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-input" id="editStatus" onchange="toggleClassField()" required>
                            <option value="">Pilih Status</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>

                    <div class="form-group" id="classFieldGroup" style="display: none;">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-input" id="editKelas" list="classList" placeholder="Pilih atau ketik kelas">
                        <datalist id="classList">
                            <option value="X PPLG 1"></option>
                            <option value="X PPLG 2"></option>
                            <option value="X TJKT 1"></option>
                            <option value="X TJKT 2"></option>
                            <option value="XI TKJ 2"></option>
                        </datalist>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-cancel" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-modal btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentData = [];
        let currentSection = 'teacher';

        // Switch between sections
        function switchSection(section, evt) {
            currentSection = section;
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.getElementById(section).classList.add('active');
            document.querySelectorAll('.sidebar-btn').forEach(btn => btn.classList.remove('active'));
            const targetBtn = evt?.currentTarget || evt?.target;
            if (targetBtn) targetBtn.classList.add('active');

            if (section === 'teacher') {
                loadTeachers();
            } else {
                loadStudents();
            }
        }

        function toggleSidebar() {
            const container = document.getElementById('adminContainer');
            if (!container) return;
            container.classList.toggle('sidebar-collapsed');
            try {
                localStorage.setItem('adminSidebarCollapsed', container.classList.contains('sidebar-collapsed') ? '1' : '0');
            } catch (e) {}
        }

        function collapseSidebar() {
            const container = document.getElementById('adminContainer');
            if (!container) return;
            if (!container.classList.contains('sidebar-collapsed')) {
                container.classList.add('sidebar-collapsed');
                try {
                    localStorage.setItem('adminSidebarCollapsed', '1');
                } catch (e) {}
            }
        }

        // Load teachers
        function loadTeachers() {
            const search = document.getElementById('teacher-search').value;
            fetch(`/api/teachers?search=${search}`)
                .then(r => r.json())
                .then(data => {
                    currentData = data.data;
                    document.getElementById('teacher-count').innerText = data.count;
                    renderTeachersTable(data.data);
                });
        }

        // Load students
        function loadStudents() {
            const searchNama = document.getElementById('student-search-nama').value;
            const searchKelas = document.getElementById('student-search-kelas').value;
            fetch(`/api/students?search_nama=${searchNama}&search_kelas=${searchKelas}`)
                .then(r => r.json())
                .then(data => {
                    currentData = data.data;
                    document.getElementById('student-count').innerText = data.count;
                    renderStudentsTable(data.data);
                });
        }

        // Render teachers table
        function renderTeachersTable(data) {
            const tbody = document.getElementById('teacher-tbody');
            tbody.innerHTML = data.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.status}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-preview" onclick="openPreview(${item.db_id}, 'teacher')">👁️</button>
                            <button class="btn-action btn-edit" onclick="openEdit(${item.db_id}, 'teacher')">✏️</button>
                            <button class="btn-action btn-delete" onclick="deleteData(${item.db_id})">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Render students table
        function renderStudentsTable(data) {
            const tbody = document.getElementById('student-tbody');
            tbody.innerHTML = data.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.kelas}</td>
                    <td>${item.status}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-preview" onclick="openPreview(${item.db_id}, 'student')">👁️</button>
                            <button class="btn-action btn-edit" onclick="openEdit(${item.db_id}, 'student')">✏️</button>
                            <button class="btn-action btn-delete" onclick="deleteData(${item.db_id})">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Preview modal
        function openPreview(id, section) {
            fetch(`/api/data/${id}`)
                .then(r => r.json())
                .then(data => {
                    const fotoHTML = data.foto ? `
                        <div class="preview-photo-box">
                            <img src="/storage/${data.foto}" alt="Foto" class="preview-image" style="max-height: 340px;">
                        </div>
                    ` : `
                        <div class="preview-photo-box" style="padding: 2rem; text-align: center; color: #6b7280;">
                            Foto belum tersedia
                        </div>
                    `;

                    let infoHTML = `
                        <div class="preview-item">
                            <div class="preview-label">Nama</div>
                            <div class="preview-value">${data.nama}</div>
                        </div>
                        <div class="preview-item">
                            <div class="preview-label">Status</div>
                            <div class="preview-value">${data.status}</div>
                        </div>
                    `;

                    if (data.kelas && section === 'student') {
                        infoHTML += `
                            <div class="preview-item">
                                <div class="preview-label">Kelas</div>
                                <div class="preview-value">${data.kelas}</div>
                            </div>
                        `;
                    }

                    const signatureHTML = data.tanda_tangan ? `
                        <div class="preview-signature-box">
                            <img src="/storage/${data.tanda_tangan}" alt="Tanda Tangan" class="preview-image" style="max-height: 260px;">
                        </div>
                    ` : `
                        <div class="preview-signature-box" style="padding: 1.25rem; color: #6b7280; text-align: center;">
                            Tanda tangan belum tersedia
                        </div>
                    `;

                    const previewHTML = `
                        <div class="preview-grid">
                            <div class="preview-left">
                                <div class="preview-label">Foto</div>
                                ${fotoHTML}
                            </div>
                            <div class="preview-right">
                                ${infoHTML}
                            </div>
                        </div>
                        <div class="preview-signature">
                            <div class="preview-label">Tanda Tangan</div>
                            ${signatureHTML}
                        </div>
                    `;

                    document.getElementById('previewBody').innerHTML = previewHTML;
                    document.getElementById('previewModal').classList.add('show');
                });
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.remove('show');
        }

        // Edit modal
        function openEdit(id, section) {
            fetch(`/api/data/${id}`)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('editId').value = id;
                    document.getElementById('editSection').value = section;
                    document.getElementById('editNama').value = data.nama;
                    document.getElementById('editStatus').value = data.status;
                    document.getElementById('editKelas').value = data.kelas || '';
                    toggleClassField();
                    document.getElementById('editModal').classList.add('show');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        function toggleClassField() {
            const status = document.getElementById('editStatus').value;
            const classField = document.getElementById('classFieldGroup');
            if (status === 'siswa') {
                classField.style.display = 'block';
            } else {
                classField.style.display = 'none';
                document.getElementById('editKelas').value = '';
            }
        }

        function submitEdit(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const data = {
                nama: document.getElementById('editNama').value,
                status: document.getElementById('editStatus').value,
                kelas: document.getElementById('editStatus').value === 'siswa' ? document.getElementById('editKelas').value : null,
            };

            fetch(`/api/data/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    closeEditModal();
                    if (currentSection === 'teacher') {
                        loadTeachers();
                    } else {
                        loadStudents();
                    }
                    alert('Data berhasil diperbarui');
                }
            })
            .catch(err => alert('Error: ' + err.message));
        }

        // Delete data
        function deleteData(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

            fetch(`/api/data/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    if (currentSection === 'teacher') {
                        loadTeachers();
                    } else {
                        loadStudents();
                    }
                    alert('Data berhasil dihapus');
                }
            })
            .catch(err => alert('Error: ' + err.message));
        }

        // Export data
        function exportData() {
            const params = new URLSearchParams();
            params.set('section', currentSection);

            if (currentSection === 'teacher') {
                const search = document.getElementById('teacher-search')?.value || '';
                if (search) params.set('search', search);
            } else {
                const searchNama = document.getElementById('student-search-nama')?.value || '';
                const searchKelas = document.getElementById('student-search-kelas')?.value || '';
                if (searchNama) params.set('search_nama', searchNama);
                if (searchKelas) params.set('search_kelas', searchKelas);
            }

            window.location.href = `/admin/export-pdf?${params.toString()}`;
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const collapsed = localStorage.getItem('adminSidebarCollapsed') === '1';
                if (collapsed) document.getElementById('adminContainer')?.classList.add('sidebar-collapsed');
            } catch (e) {}

            loadTeachers();

            let searchTimer;
            function debounce(fn) {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(fn, 300);
            }
            document.getElementById('teacher-search').addEventListener('keyup', () => debounce(loadTeachers));
            document.getElementById('student-search-nama').addEventListener('keyup', () => debounce(loadStudents));
            document.getElementById('student-search-kelas').addEventListener('keyup', () => debounce(loadStudents));

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
<?php /**PATH D:\PROJECT\LARAVEL\BUDI\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>