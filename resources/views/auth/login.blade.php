<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rumah Bekam Salam Insani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-dark:  #1b6b3a;
            --green-mid:   #2e9e58;
            --green-light: #e8f5ee;
            --red-main:    #c0392b;
            --red-soft:    #fdecea;
            --yellow-main: #e6a817;
            --border-soft: #d8e8de;
            --text-dark:   #1c2b22;
            --text-muted:  #6b7c72;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== LEFT PANEL ===== */
        .auth-left {
            flex: 0 0 52%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .auth-left img.bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .auth-left .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(27,107,58,.55) 0%,
                rgba(15,60,28,.82) 100%
            );
        }

        .auth-left .left-content {
            position: relative;
            z-index: 2;
            padding: 40px 48px;
        }

        .auth-left .brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: auto;
            position: absolute;
            top: 36px;
            left: 48px;
        }

        .auth-left .brand-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.18);
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: white;
        }

        .auth-left .brand-name {
            color: white;
            font-weight: 800;
            font-size: 1rem;
            line-height: 1.2;
        }

        .auth-left .brand-sub {
            color: rgba(255,255,255,.6);
            font-size: .72rem;
        }

        .auth-left .left-bottom {
            position: relative;
            z-index: 2;
            padding: 0 48px 48px;
        }

        .auth-left .tagline {
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            font-weight: 800;
            color: white;
            line-height: 1.25;
            margin-bottom: 14px;
        }

        .auth-left .tagline span { color: var(--yellow-main); }

        .auth-left .tagline-sub {
            color: rgba(255,255,255,.72);
            font-size: .92rem;
            line-height: 1.65;
            max-width: 380px;
            margin-bottom: 28px;
        }

        .auth-left .stats-row {
            display: flex;
            gap: 24px;
        }

        .auth-left .stat-item {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px;
            padding: 12px 18px;
            backdrop-filter: blur(6px);
        }

        .auth-left .stat-item .num {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--yellow-main);
            line-height: 1;
        }

        .auth-left .stat-item .lbl {
            font-size: .72rem;
            color: rgba(255,255,255,.7);
            margin-top: 2px;
        }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background: #f4f7f5;
            overflow-y: auto;
        }

        .auth-form-box {
            width: 100%;
            max-width: 400px;
        }

        .auth-form-box .form-heading {
            margin-bottom: 32px;
        }

        .auth-form-box .form-heading h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .auth-form-box .form-heading p {
            color: var(--text-muted);
            font-size: .875rem;
        }

        .form-label {
            font-weight: 600;
            font-size: .83rem;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .input-group-text {
            background: white;
            border: 1.5px solid var(--border-soft);
            border-right: none;
            color: var(--green-mid);
            border-radius: 10px 0 0 10px !important;
        }

        .form-control {
            border: 1.5px solid var(--border-soft);
            border-left: none;
            border-radius: 0 10px 10px 0 !important;
            font-size: .875rem;
            padding: 10px 14px;
            background: white;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(46,158,88,.1);
            border-left: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--green-mid);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: .95rem;
            padding: 12px;
            color: white;
            width: 100%;
            transition: opacity .2s, transform .2s;
            margin-top: 4px;
        }

        .btn-submit:hover {
            opacity: .92;
            transform: translateY(-1px);
            color: white;
        }

        .alert-danger {
            background: var(--red-soft);
            border: 1px solid #f5c6c2;
            color: var(--red-main);
            border-radius: 10px;
            font-size: .84rem;
            padding: 10px 14px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: .78rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-soft);
        }

        .link-green {
            color: var(--green-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .link-green:hover {
            color: var(--green-mid);
            text-decoration: underline;
        }

        .back-to-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color .2s;
        }

        .back-to-home:hover { color: var(--green-dark); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { padding: 40px 24px; background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); }
            .auth-form-box { background: white; border-radius: 20px; padding: 36px 28px; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
            .back-to-home { color: rgba(255,255,255,.75); }
            .back-to-home:hover { color: white; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <!-- LEFT: Image Panel -->
    <div class="auth-left">
        <img class="bg-img" src="{{ asset('image/Bekam Foto.jpeg') }}" alt="Bekam Profesional">
        <div class="overlay"></div>

        <!-- Brand top-left -->
        <div class="brand-row">
            <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
            <div>
                <div class="brand-name">Rumah Bekam</div>
                <div class="brand-sub">Salam Insani</div>
            </div>
        </div>

        <!-- Bottom content -->
        <div class="left-bottom">
            <h2 class="tagline">
                Sehat Bersama<br><span>Bekam Profesional</span>
            </h2>
            <p class="tagline-sub">
                Layanan bekam terpercaya dengan terapis bersertifikat, peralatan steril, dan suasana klinik yang nyaman untuk kesehatan Anda.
            </p>
            <div class="stats-row">
                <div class="stat-item">
                    <div class="num">1000+</div>
                    <div class="lbl">Pasien Puas</div>
                </div>
                <div class="stat-item">
                    <div class="num">10+</div>
                    <div class="lbl">Terapis Ahli</div>
                </div>
                <div class="stat-item">
                    <div class="num">5+</div>
                    <div class="lbl">Tahun Berdiri</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Form Panel -->
    <div class="auth-right">
        <div class="auth-form-box">

            <a href="{{ route('landing') }}" class="back-to-home">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="form-heading">
                <h2>Selamat Datang 👋</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-3" style="background:var(--green-light);border:1px solid #b8dfc8;color:var(--green-dark);border-radius:10px;font-size:.84rem;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="email@example.com"
                            required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="loginPwd" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required>
                        <button type="button" class="btn" id="togglePwd"
                            style="border:1.5px solid var(--border-soft);border-left:none;border-radius:0 10px 10px 0;background:white;color:var(--text-muted);padding:0 12px;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="form-check mb-0">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                            style="border-color:var(--border-soft);border-radius:4px;">
                        <label class="form-check-label" for="remember"
                            style="font-size:.82rem;color:var(--text-muted);">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="divider">atau</div>

            <p class="text-center mb-0" style="font-size:.875rem;color:var(--text-muted);">
                Belum punya akun?
                <a href="{{ route('register') }}" class="link-green ms-1">Daftar sekarang</a>
            </p>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('togglePwd').addEventListener('click', function() {
        const pwd  = document.getElementById('loginPwd');
        const icon = document.getElementById('eyeIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            pwd.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });
</script>
</body>
</html>
