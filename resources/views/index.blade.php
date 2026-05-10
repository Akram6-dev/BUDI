<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pameran TKI - SMKN 1 Subang</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

    <!-- Success Alert -->
    @if(session('success'))
    <div id="successAlert" style="
        position: fixed;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.75);
        color: #FFB800;
        padding: 14px 32px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        z-index: 999;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,184,0,0.4);
    ">✓ {{ session('success') }}</div>
    <script>
        setTimeout(() => {
            document.getElementById('successAlert').style.display = 'none';
        }, 4000);
    </script>
    @endif

    <!-- Background -->
    <div class="slider-wrapper">
        <div class="slide"></div>
    </div>
    <div class="slider-overlay"></div>

    <!-- Navbar -->
    <nav>
        <div class="nav-left">
            <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo Nesasa" class="nav-logo">
            <span class="nav-title">PAMERAN TKI</span>
        </div>
        <a href="/login" class="btn-login">Login Admin</a>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="welcome-text">
            <span class="line1">Selamat Datang di</span>
            <span class="line2">Pameran TKI</span>
        </h1>

        <div class="logo-section">
            <img src="{{ asset('img/LOGO RPL.png') }}" alt="Logo RPL" class="logo-school">
            <span class="x-separator">✕</span>
            <img src="{{ asset('img/LogoTKJ.png') }}" alt="Logo TKJ" class="logo-school">
        </div>

        <a href="/guest-form" class="btn-isi-data">Isi Data Tamu</a>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 PAMERAN TKI - SMKN 1 SUBANG
    </footer>

</body>
</html>
