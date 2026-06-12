<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK Siswa Terbaik')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

@media print {

    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .main-content,
    .content,
    .container,
    .container-fluid,
    .page-content,
    .wrapper,
    .content-wrapper {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .sidebar,
    .navbar,
    .topbar,
    .footer {
        display: none !important;
    }
}

        :root {
            --primary: #1d4ed8;
            --primary-dark: #1e40af;
            --primary-light: #dbeafe;
            --primary-xlight: #eff6ff;
            --accent: #f59e0b;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #d97706;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f1f5f9;
            --white: #ffffff;
            --sidebar-w: 240px;
            --navbar-h: 60px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sidebar-brand .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon i { color: white; font-size: 17px; }

        .sidebar-brand .logo-text { line-height: 1.2; }

        .sidebar-brand .logo-text strong {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.3px;
        }

        .sidebar-brand .logo-text span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ── Role badge di sidebar ── */
        .sidebar-role {
            margin: 10px 12px 0;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sidebar-role.admin          { background: #fef3c7; color: #92400e; }
        .sidebar-role.wali_kelas     { background: #dbeafe; color: #1e40af; }
        .sidebar-role.kepala_sekolah { background: #d1fae5; color: #065f46; }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .nav-section { margin-bottom: 20px; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 8px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-item:hover { background: var(--primary-xlight); color: var(--primary); }

        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nav-item .badge {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid var(--border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: var(--bg);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .user-detail strong {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .user-detail span {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        /* ===================== NAVBAR ===================== */
        .navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--navbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 99;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-title   { font-size: 16px; font-weight: 700; color: var(--text); }
        .navbar-subtitle { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--text-muted);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-logout:hover {
            border-color: var(--danger);
            color: var(--danger);
            background: #fef2f2;
        }

        /* ===================== MAIN ===================== */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--navbar-h);
            padding: 28px;
            min-height: calc(100vh - var(--navbar-h));
        }

        /* ===================== ALERTS ===================== */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-success { background: #f0fdf4; color: var(--success); border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: var(--danger);  border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: var(--warning); border: 1px solid #fde68a; }

        /* ===================== ROLE BADGE (navbar) ===================== */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .role-badge.admin          { background: #fef3c7; color: #92400e; }
        .role-badge.wali_kelas     { background: #dbeafe; color: #1e40af; }
        .role-badge.kepala_sekolah { background: #d1fae5; color: #065f46; }

    </style>

    @stack('styles')
    @yield('head')
</head>
<body>

{{-- ===================== SIDEBAR ===================== --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="logo-text">
                <strong>SPK Siswa Terbaik</strong>
                <span>AHP & SMART</span>
            </div>
        </a>
    </div>

    {{-- Role indicator --}}
    @php $role = Auth::user()->role; @endphp
    <div class="sidebar-role {{ $role }}">
        <i class="fas fa-{{ $role === 'admin' ? 'shield-halved' : ($role === 'wali_kelas' ? 'chalkboard-user' : 'user-tie') }}"></i>
        {{ $role === 'admin' ? 'Administrator' : ($role === 'wali_kelas' ? 'Wali Kelas' : 'Kepala Sekolah') }}
    </div>

    <nav class="sidebar-nav">

        {{-- ── MENU UTAMA (semua role) ── --}}
        <div class="nav-section">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                Dashboard
            </a>
        </div>

        {{-- ══════════════════════════════════════
             ADMIN — tampilkan semua
        ══════════════════════════════════════ --}}
        @if($role === 'admin')

            <div class="nav-section">
                <div class="nav-section-label">Data</div>
                <a href="{{ route('periode.index') }}"
                   class="nav-item {{ request()->routeIs('periode.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-days"></i> Periode
                </a>
                <a href="{{ route('kriteria.index') }}"
                   class="nav-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                    <i class="fas fa-list-check"></i> Kriteria & Parameter
                </a>
                <a href="{{ route('siswa.index') }}"
                   class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Siswa
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Metode</div>
                <a href="{{ route('ahp.index') }}"
                   class="nav-item {{ request()->routeIs('ahp.*') ? 'active' : '' }}">
                    <i class="fas fa-scale-balanced"></i> AHP
                </a>
                <a href="{{ route('smart.index') }}"
                   class="nav-item {{ request()->routeIs('smart.*') ? 'active' : '' }}">
                    <i class="fas fa-ranking-star"></i> SMART
                </a>
                <a href="{{ route('riwayat.index') }}"
                   class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fas fa-clock-rotate-left"></i> Riwayat
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Administrasi</div>
                <a href="{{ route('admin.users') }}"
                   class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fas fa-users-gear"></i> Kelola User
                </a>
            </div>

        {{-- ══════════════════════════════════════
             WALI KELAS — dashboard, nilai, smart, riwayat
             TIDAK tampil: Periode, Kriteria, AHP
        ══════════════════════════════════════ --}}
        @elseif($role === 'wali_kelas')

            <div class="nav-section">
                <div class="nav-section-label">Penilaian</div>
                <a href="{{ route('nilai.index') }}"
                   class="nav-item {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                    <i class="fas fa-pen-to-square"></i> Input Nilai Siswa
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Hasil</div>
                <a href="{{ route('smart.index') }}"
                   class="nav-item {{ request()->routeIs('smart.*') ? 'active' : '' }}">
                    <i class="fas fa-ranking-star"></i> Perhitungan SMART
                </a>
                <a href="{{ route('riwayat.index') }}"
                   class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fas fa-clock-rotate-left"></i> Riwayat
                </a>
            </div>

        {{-- ══════════════════════════════════════
             KEPALA SEKOLAH — view only
        ══════════════════════════════════════ --}}
        @elseif($role === 'kepala_sekolah')

            <div class="nav-section">
                <div class="nav-section-label">Laporan</div>
                <a href="{{ route('smart.index') }}"
                   class="nav-item {{ request()->routeIs('smart.*') ? 'active' : '' }}">
                    <i class="fas fa-ranking-star"></i> Hasil Ranking SMART
                </a>
                <a href="{{ route('riwayat.index') }}"
                   class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fas fa-clock-rotate-left"></i> Riwayat
                </a>
            </div>

        @endif

    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-detail">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ str_replace('_', ' ', Auth::user()->role) }}</span>
            </div>
        </div>
    </div>
</aside>

{{-- ===================== NAVBAR ===================== --}}
<header class="navbar">
    <div class="navbar-left">
        <div>
            <div class="navbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="navbar-subtitle">@yield('page-subtitle', 'Sistem Pendukung Keputusan Pemilihan Siswa Terbaik')</div>
        </div>
        @yield('page-actions')
    </div>
    <div class="navbar-right">
        <span class="role-badge {{ Auth::user()->role }}">
            <i class="fas fa-circle-user"></i>
            {{ Auth::user()->name }}
        </span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-right-from-bracket"></i>
                Logout
            </button>
        </form>
    </div>
</header>

{{-- ===================== MAIN ===================== --}}
<main class="main-content">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            <i class="fas fa-triangle-exclamation"></i>
            {{ session('warning') }}
        </div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>