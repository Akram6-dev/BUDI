<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/guest-form.css') }}">
</head>
<body class="guest-form-body">

    @include('layouts.ai-bg')

    <nav class="navbar-form">
        <div class="nav-left">
            <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo SMKN 1 Subang" class="nav-logo">
            <span class="nav-title">PAMERAN TKI</span>
        </div>
    </nav>

    <div class="main-content-form">
        <div class="form-card admin-login-card">
            <h1 class="form-card-title">Login admin</h1>

            @if(session('success'))
                <div class="form-message">{{ session('success') }}</div>
            @endif

            <form action="/login" method="post" class="admin-login-form">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" name="username" class="form-input" value="{{ old('username') }}" placeholder="Masukkan username" required>
                    @error('username')
                        <div class="form-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    @error('password')
                        <div class="form-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-continue btn-admin-login">Login To Admin Panel</button>
                </div>
            </form>

            <hr class="admin-divider">
            <a href="/" class="back-to-dashboard">Kembali ke dashboard</a>
        </div>
    </div>

    @include('layouts.footer')

</body>
</html>
