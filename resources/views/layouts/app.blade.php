<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Asrama Tapin — @yield('title')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f8;
            display: flex;
            height: 100vh;
            color: #1f2937;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 252px;
            background: #1e2a52;
            color: #fff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: 1.3rem 1.4rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .logo-box {
            width: 36px; height: 36px;
            background: #3b5bdb;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand .logo-box svg { width: 18px; height: 18px; stroke: #fff; }
        .sidebar-brand .brand-text { line-height: 1.3; }
        .sidebar-brand .brand-text strong { display: block; font-size: .92rem; }
        .sidebar-brand .brand-text span { font-size: .7rem; opacity: .6; }

        .sidebar nav { padding: .8rem 0; flex: 1; overflow-y: auto; }
        .nav-section {
            padding: .9rem 1.4rem .3rem;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .45;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .6rem 1.4rem;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: .87rem;
            transition: background .15s;
            border-left: 3px solid transparent;
        }
        .sidebar nav a svg { width: 17px; height: 17px; stroke: currentColor; flex-shrink: 0; }
        .sidebar nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar nav a.active {
            background: rgba(59,91,219,0.25);
            color: #fff;
            border-left-color: #5b7cfa;
        }

        .sidebar-footer {
            padding: .9rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .sidebar-footer .avatar {
            width: 34px; height: 34px;
            background: #3b5bdb;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 600;
            flex-shrink: 0;
        }
        .sidebar-footer .who { flex: 1; line-height: 1.25; overflow: hidden; }
        .sidebar-footer .who strong { display: block; font-size: .82rem; }
        .sidebar-footer .who span { font-size: .68rem; opacity: .55; }
        .sidebar-footer form button {
            background: none;
            border: none;
            color: rgba(255,255,255,0.55);
            cursor: pointer;
            padding: .3rem;
        }
        .sidebar-footer form button svg { width: 17px; height: 17px; stroke: currentColor; }
        .sidebar-footer form button:hover { color: #fff; }

        /* ===== Main ===== */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar {
            background: #fff;
            padding: .9rem 1.8rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .breadcrumb { font-size: .8rem; color: #9ca3af; }
        .topbar .breadcrumb strong { color: #1f2937; font-size: 1rem; display: block; margin-top: .1rem; }
        .topbar .right { display: flex; align-items: center; gap: 1.1rem; font-size: .8rem; color: #6b7280; }
        .topbar .right svg { width: 18px; height: 18px; stroke: #6b7280; }

        .content { flex: 1; overflow-y: auto; padding: 1.8rem; }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-box">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
            </div>
            <div class="brand-text">
                <strong>SIM-Asrama Tapin</strong>
                <span>Manajemen Asrama</span>
            </div>
        </div>

        <nav>
        @if(Auth::user()->isAdmin())
            <div class="nav-section">Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Dashboard
            </a>
            <a href="{{ route('penghuni.index') }}" class="{{ request()->routeIs('penghuni.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a5 5 0 015-5h4a5 5 0 015 5v2"/></svg>
                Data Penghuni
            </a>
            <a href="{{ route('kamar.index') }}" class="{{ request()->routeIs('kamar.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21V12h6v9"/></svg>
                Data Kamar
            </a>

            <div class="nav-section">Transaksi</div>
            <a href="{{ route('pembayaran.index') }}" class="{{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M2 10h20"/></svg>
                Pembayaran
            </a>

            <div class="nav-section">Monitoring</div>
            <a href="{{ route('monitoring.kamar') }}" class="{{ request()->routeIs('monitoring.kamar') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21V12h6v9"/></svg>
                Status Kamar
            </a>
            <a href="{{ route('monitoring.pembayaran') }}" class="{{ request()->routeIs('monitoring.pembayaran') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
                Status Pembayaran
            </a>

            <div class="nav-section">SPK</div>
            <a href="{{ route('hasil.seleksi') }}" class="{{ request()->routeIs('hasil.seleksi') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Hasil Seleksi
            </a>

            <div class="nav-section">Laporan</div>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/></svg>
                Laporan Administrasi
            </a>

        @elseif(Auth::user()->isPenilai())
            <div class="nav-section">Utama</div>
            <a href="{{ route('penilai.dashboard') }}" class="{{ request()->routeIs('penilai.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Dashboard
            </a>

            <div class="nav-section">Seleksi</div>
            <a href="{{ route('calon.index') }}" class="{{ request()->routeIs('calon.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a5 5 0 015-5h4a5 5 0 015 5v2"/></svg>
                Calon Penghuni
            </a>
            <a href="{{ route('kriteria.index') }}" class="{{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Kriteria
            </a>
            <a href="{{ route('penilaian.index') }}" class="{{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Penilaian
            </a>
            <a href="{{ route('proses.index') }}" class="{{ request()->routeIs('proses.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
                Proses Perhitungan
            </a>
            <a href="{{ route('ranking.index') }}" class="{{ request()->routeIs('ranking.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/></svg>
                Hasil Ranking
            </a>
        @endif
    </nav>

        <div class="sidebar-footer">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="who">
                <strong>{{ Auth::user()->name }}</strong>
                <span>Pengelola Asrama Tapin</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="breadcrumb">
                Beranda / @yield('title')
                <strong>@yield('title')</strong>
            </div>
            <div class="right">
                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>