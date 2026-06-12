<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Siswa Terbaik</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #1d4ed8;
            --primary-dark: #1e40af;
            --primary-panel: #1a3a6e;
            --accent: #fbbf24;
            --danger: #dc2626;
            --success: #16a34a;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f1f5f9;
            --white: #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ── WRAPPER ── */
        .login-wrapper {
            width: 100%;
            max-width: 860px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(10,15,40,0.18);
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            flex: 1;
            background: var(--primary-panel);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 36px;
            position: relative;
            overflow: hidden;
        }

        /* decorative circles */
        .panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .logo-ring {
            width: 80px; height: 80px;
            border-radius: 22px;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
            z-index: 1;
        }
        .logo-ring i { font-size: 34px; color: var(--accent); }

        .panel-left h2 {
            font-size: 20px; font-weight: 800;
            color: #fff; text-align: center;
            margin-bottom: 12px; line-height: 1.4;
            z-index: 1;
        }

        .accent-line {
            width: 36px; height: 3px;
            background: var(--accent);
            border-radius: 2px;
            margin: 0 auto 16px;
        }

        .panel-left p {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            text-align: center;
            line-height: 1.7;
            max-width: 210px;
            z-index: 1;
        }

        .badge-row {
            display: flex; gap: 8px; margin-top: 28px;
            flex-wrap: wrap; justify-content: center;
            z-index: 1;
        }
        .badge {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px; font-weight: 700;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .badge.accent {
            background: rgba(251,191,36,0.15);
            color: var(--accent);
            border-color: rgba(251,191,36,0.3);
        }

        /* ── RIGHT PANEL (FORM) ── */
        .panel-right {
            flex: 1.1;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .form-header { margin-bottom: 30px; }
        .form-header h3 {
            font-size: 22px; font-weight: 800;
            color: var(--text); margin-bottom: 4px;
            letter-spacing: -.3px;
        }
        .form-header p { font-size: 13px; color: var(--text-muted); }

        /* Alert */
        .alert {
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 9px;
        }
        .alert-danger {
            background: #fef2f2; color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #f0fdf4; color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Form Fields */
        .form-group { margin-bottom: 20px; }

        label.field-label {
            display: block;
            font-size: 11px; font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 7px;
            text-transform: uppercase; letter-spacing: .5px;
        }

        .input-wrap { position: relative; }
        .input-wrap i.ico-l {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px; color: var(--text-muted);
            pointer-events: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 11px 13px 11px 40px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: inherit; font-size: 14px;
            color: var(--text);
            background: #f8fafc;
            outline: none;
            transition: border-color .15s, background .15s, box-shadow .15s;
        }
        input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }
        input.is-invalid {
            border-color: var(--danger);
            background: #fff5f5;
        }
        .toggle-pw {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 15px; padding: 0;
            transition: color .15s;
        }
        .toggle-pw:hover { color: var(--primary); }

        .invalid-feedback {
            display: block; font-size: 12px;
            color: var(--danger); margin-top: 6px;
        }

        /* Options row */
        .form-options {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 26px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            cursor: pointer; font-size: 13px; color: var(--text-muted);
        }
        .remember-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--primary); cursor: pointer;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--primary);
            color: white; border: none;
            border-radius: 10px;
            font-family: inherit; font-size: 15px; font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .15s, transform .1s, box-shadow .15s;
            letter-spacing: .2px;
        }
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(29,78,216,0.3);
        }
        .btn-login:active { transform: translateY(0); box-shadow: none; }
        .btn-login.loading { opacity: .7; pointer-events: none; }

        /* Footer */
        .card-footer {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: var(--text-muted);
        }
        .card-footer i { color: var(--primary); font-size: 14px; }

        /* Responsive */
        @media (max-width: 640px) {
            .panel-left { display: none; }
            .panel-right { padding: 36px 28px; border-radius: 20px; }
            .login-wrapper { max-width: 420px; border-radius: 20px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- ── LEFT PANEL ── --}}
    <div class="panel-left">
        <div class="logo-ring">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <h2>SPK Siswa Terbaik</h2>
        <div class="accent-line"></div>
        <p>Sistem pendukung keputusan pemilihan siswa terbaik secara objektif &amp; terukur</p>
        <div class="badge-row">
            <span class="badge accent">AHP</span>
            <span class="badge accent">SMART</span>
        </div>
    </div>

    {{-- ── RIGHT PANEL (FORM) ── --}}
    <div class="panel-right">

        <div class="form-header">
            <h3>Selamat datang</h3>
            <p>Masuk menggunakan akun yang telah terdaftar</p>
        </div>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        {{-- Alert Success (setelah logout) --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf

            {{-- Username --}}
            <div class="form-group">
                <label class="field-label" for="username">Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user ico-l"></i>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        class="{{ $errors->has('username') ? 'is-invalid' : '' }}"
                        autofocus autocomplete="username"
                    >
                </div>
                @error('username')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="field-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock ico-l"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="btnLogin">
                <i class="fas fa-right-to-bracket"></i>
                Masuk ke Sistem
            </button>
        </form>

        <div class="card-footer">
            <i class="fas fa-shield-halved"></i>
            <span>&copy; {{ date('Y') }} SPK Siswa Terbaik &mdash; AHP + SMART</span>
        </div>

    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnLogin');
        btn.classList.add('loading');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>

</body>
</html>