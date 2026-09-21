# 📖 BUTAGI — Buku Tamu Digital (SMKN 1 Subang)

<p align="center">
  <img src="public/img/Gambar_SMKN_1SUBANG.png" alt="Logo SMKN 1 Subang" width="90" style="vertical-align: middle; margin-right: 15px;" />
  <img src="public/img/logomrc.png" alt="Logo MRC" width="90" style="vertical-align: middle;" />
</p>

<p align="center">
  <strong>Sistem Buku Tamu Digital Modern, Interaktif, dan Responsif</strong><br>
  Dikembangkan untuk <strong>SMK Negeri 1 Subang</strong> dan Pameran <strong>MRC (Mekatronika Robotics Club)</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Responsive-Mobile_to_TV-4E9FDF?style=for-the-badge" alt="Responsive" />
</p>

---

## 🌟 Tentang Proyek

**BUTAGI (Buku Tamu Digital)** adalah aplikasi pencatatan kehadiran tamu berbasis web yang dirancang khusus untuk kemudahan registrasi pengunjung pameran sekolah, civitas akademika, dan instansi umum. 

Dilengkapi dengan antarmuka futuristik, dukungan kamera langsung (webcam capture), tanda tangan digital interaktif di layar sentuh, serta panel manajemen admin lengkap dengan ekspor laporan ke PDF.

---

## ✨ Fitur Utama

### 1. 🏠 Halaman Utama (Landing Page)
- **Desain Modern & Elegan**: Dilengkapi kanvas partikel animasi bintang interaktif dan pencahayaan dinamis (*ambient glow*).
- **Mode Terang / Gelap (Dark & Light Theme)**: Dapat beralih tema dengan transisi instan dan tersimpan di `localStorage`.
- **Call-to-Action Jelas**: Tombol responsif untuk langsung menuju pengisian buku tamu.

### 2. 📝 Formulir Kehadiran Tamu (Single-Page Seamless)
- **Input Identitas**: Kolom input nama pengunjung yang terintegrasi.
- **Pilihan Status Pengunjung**:
  - **Instansi**: Menampilkan kolom instansi/perusahaan terkait.
  - **Sekolah**: Menampilkan kolom nama asal sekolah.
- **Pengambilan Foto Tamu (Webcam)**: Mengambil foto wajah pengunjung secara langsung via kamera perangkat/webcam secara real-time.
- **Tanda Tangan Digital (Canvas Pad)**: Tamu dapat menandatangani langsung di layar HP, tablet, maupun menggunakan mouse di laptop.
- **Penilaian Pengalaman Pengunjung**:
  - 😊 **Senang**
  - 🤩 **Menarik**
  - 🤔 **Unik**
- **Validasi Cerdas Tanpa Reload**: Notifikasi interaktif dan perlindungan data agar pengisian form tidak terputus.

### 3. 📊 Panel Admin & Manajemen Data
- **Autentikasi Login Aman**: Akses khusus admin dengan proteksi session.
- **Statistik Kehadiran**: Ringkasan total pengunjung, kategori instansi, sekolah, dan grafik kepuasan.
- **Manajemen Data**: Pencarian cepat, filter status, modal edit data, dan hapus data pengunjung.
- **Ekspor Laporan ke PDF**: Mengunduh rekapitulasi data tamu yang rapi dalam format PDF siap cetak.

### 4. 📱 Arsitektur Responsif Multi-Device
Telah dioptimasi secara khusus tanpa *horizontal scrollbar*:
- **HP / Smartphone** (360px – 480px): Tata letak 1 kolom yang ramah jempol.
- **Tablet Standar** (iPad Mini 768px): Tampilan proporsional.
- **Tablet Pro / Portrait Besar** (iPad Pro 1032px, Surface Pro 960px): Elemen terisi penuh dan nyaman disentuh.
- **Laptop & Desktop PC** (1366px – 1920px): Ramping, elegan, dan pas 1 layar monitor.
- **Smart TV & Standing Kiosk** (≥ 1920px Full HD / 4K): Model Digital Signage dengan kartu kiosk di tengah layar.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: [Laravel 11](https://laravel.com/) (PHP 8.2+)
- **Frontend**: Blade Templating, Vanilla CSS (Design Tokens, Glassmorphism, Micro-animations), Vanilla JavaScript (No heavy frameworks required)
- **Database**: MySQL / MariaDB
- **Tools Tambahan**:
  - HTML5 Canvas API (Tanda Tangan Digital)
  - WebRTC MediaDevices API (Kamera & Foto Tamu)
  - DomPDF (Ekspor Laporan PDF)

---

## 🚀 Panduan Instalasi Lokal (Local Setup)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Clone Repository
```bash
git clone https://github.com/Akram6-dev/BUDI.git
cd BUDI
```

### 2. Install Dependensi Composer
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=budi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeder Database
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di: **http://127.0.0.1:8000**

---

## 🔐 Kredensial Login Default (Admin)

Untuk mengakses dashboard admin di **/login**:

| Keterangan | Nilai Default |
|---|---|
| **URL Login** | `/login` |
| **Username** | `admin` |
| **Password** | `admin123` |

---

## 🌐 Panduan Deploy ke Hosting (InfinityFree / cPanel)

1. **Import Database**:
   - Buka **phpMyAdmin** di hosting.
   - Buat database baru, lalu import file: `database/infinityfree_setup.sql`.
2. **Unggah File via FTP / FileZilla**:
   - Unggah seluruh direktori proyek ke hosting (pastikan `.env` telah disesuaikan dengan kredensial database hosting).
3. **Bersihkan Cache**:
   - Hapus file-file cache di dalam folder: `storage/framework/views/`.

---

## 📁 Struktur Direktori Penting

```plaintext
BUDI/
├── app/
│   └── Http/Controllers/
│       ├── AdminController.php   # Logika dashboard, login, dan ekspor PDF
│       └── TamuController.php    # Logika form tamu, foto, dan tanda tangan
├── database/
│   ├── infinityfree_setup.sql   # Skrip setup database untuk hosting
│   ├── migrations/              # Skema tabel database
│   └── seeders/                 # Data sampel awal
├── public/
│   ├── foto/                    # Folder penyimpanan foto tamu
│   ├── img/                     # Aset logo & ikon
│   └── ttd/                     # Folder penyimpanan tanda tangan
├── resources/views/
│   ├── admin/
│   │   ├── dashboard.blade.php  # Halaman Dashboard Admin
│   │   └── export-pdf.blade.php # Template PDF laporan tamu
│   ├── layouts/
│   │   └── footer.blade.php     # Komponen Footer
│   ├── tamu/
│   │   └── guest-form.blade.php # Halaman Formulir Tamu
│   └── index.blade.php          # Halaman Utama (Landing Page)
└── routes/
    └── web.php                  # Rute aplikasi
```

---

## 📄 Hak Cipta & Lisensi

© 2026 **SMKN 1 Subang** · **MRC (Mekatronika Robotics Club)**. Hak Cipta Dilindungi.
