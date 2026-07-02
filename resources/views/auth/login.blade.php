<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIM Asrama Tapin</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #1e2a52;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper {
            display: flex;
            width: 880px;
            max-width: 92vw;
            background: transparent;
        }
        .left {
            flex: 1;
            background: linear-gradient(160deg, #2b3a6b, #1e2a52);
            color: #fff;
            padding: 3rem 2.5rem;
            border-radius: 14px 0 0 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .left .logo-box {
            width: 46px; height: 46px;
            background: #3b5bdb;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.4rem;
        }
        .left .logo-box svg { width: 24px; height: 24px; stroke: #fff; }
        .left h1 { font-size: 1.3rem; margin-bottom: .6rem; }
        .left p { font-size: .85rem; opacity: .7; line-height: 1.5; margin-bottom: 1.3rem; }
        .left ul { list-style: none; font-size: .8rem; opacity: .8; line-height: 2; }
        .left ul li::before { content: "• "; color: #5b7cfa; }

        .right {
            flex: 1;
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 0 14px 14px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right h2 { font-size: 1.25rem; margin-bottom: .3rem; color: #1f2937; }
        .right p.sub { font-size: .82rem; color: #9ca3af; margin-bottom: 1.6rem; }
        label { display: block; font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
        input {
            width: 100%;
            padding: .65rem .9rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: .9rem;
            margin-bottom: 1.1rem;
        }
        input:focus { outline: none; border-color: #3b5bdb; }
        button {
            width: 100%;
            padding: .75rem;
            background: #3b5bdb;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background: #2f49b8; }
        .error { color: #dc2626; font-size: .82rem; margin-bottom: 1rem; }
        .footnote { font-size: .72rem; color: #9ca3af; text-align: center; margin-top: 1.3rem; }

        @media (max-width: 720px) {
            .wrapper { flex-direction: column; }
            .left, .right { border-radius: 14px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="left">
            <div class="logo-box">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
            </div>
            <h1>SIM-Asrama Tapin</h1>
            <p>Sistem Informasi Manajemen Asrama berbasis web untuk pengelolaan data penghuni, kamar, pembayaran, dan laporan secara terintegrasi.</p>
            <ul>
                <li>Data penghuni & kamar terpusat</li>
                <li>Monitoring status kamar real-time</li>
                <li>Laporan administrasi otomatis</li>
            </ul>
        </div>

        <div class="right">
            <h2>Selamat Datang 👋</h2>
            <p class="sub">Masuk untuk mengelola administrasi Asrama Tapin</p>

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <label>Username Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email/username..." required autofocus>

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password..." required>

                <button type="submit">Masuk ke Sistem</button>
            </form>

            <div class="footnote">© 2026 SIM-Asrama Tapin · Akses khusus Admin Pengelola Asrama Tapin</div>
        </div>
    </div>
</body>
</html>