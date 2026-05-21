<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Pameran TKI</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #f5f5f0;
            display: flex;
            flex-direction: column;
        }

        .login-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 80px;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 48px 44px;
            width: min(420px, 90vw);
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
        }

        .card h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1C1B1B;
            margin-bottom: 6px;
        }

        .card .subtitle {
            font-size: 0.88rem;
            color: #888;
            margin-bottom: 32px;
        }

        .card label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .card input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e5e5e5;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1C1B1B;
            background: #fafafa;
            outline: none;
            transition: border-color 0.2s;
            margin-bottom: 20px;
        }

        .card input:focus { border-color: #7C5800; background: #fff; }

        .card button {
            width: 100%;
            padding: 13px;
            background: #1C1B1B;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 4px;
        }

        .card button:hover { background: #333; }

        .card .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 24px 0 16px;
        }

        .card .back-link {
            display: block;
            text-align: center;
            color: #888;
            font-size: 0.88rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .card .back-link:hover { color: #1C1B1B; }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 20px;
        }

        /* Override navbar & footer untuk halaman ini */
        nav {
            background-color: #ffffff !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.08);
        }

        nav .nav-title { color: #1C1B1B !important; }

        footer {
            background: #1C1B1B !important;
            color: rgba(255,255,255,0.7) !important;
        }
    </style>
</head>
<body>

    <!-- Navbar tanpa tombol login -->
    <nav>
        <div class="nav-left">
            <img src="{{ asset('img/Gambar_SMKN_1SUBANG.png') }}" alt="Logo" class="nav-logo">
            <span class="nav-title">PAMERAN TKI</span>
        </div>
    </nav>

    <!-- Card -->
    <div class="login-wrap">
        <div class="card">
            <h1>Selamat Datang</h1>
            <p class="subtitle">Masuk ke panel admin</p>

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="/login" method="POST">
                @csrf

                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>

                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Masukkan password" required>

                <button type="submit">Masuk</button>
            </form>

            <hr class="divider">
            <a href="/" class="back-link">← Kembali ke halaman utama</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 PAMERAN TKI - SMKN 1 SUBANG
    </footer>

</body>
</html>
