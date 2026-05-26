<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Rumah Bekam Salam Insani</title>
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

        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; }

        .auth-wrapper { display: flex; min-height: 100vh; }

        /* ===== LEFT PANEL ===== */
        .auth-left {
            flex: 0 0 44%;
            position: relative;
            overflow: hidden;
        }

        .auth-left img.bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
        }

        .auth-left .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(27,107,58,.5) 0%,
                rgba(15,60,28,.88) 100%
            );
        }

        .auth-left .brand-row {
            position: absolute;
            top: 36px;
            left: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }

        .auth-left .brand-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.18);
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: white;
        }

        .auth-left .brand-name  { color: white; font-weight: 800; font-size: 1rem; line-height: 1.2; }
        .auth-left .brand-sub   { color: rgba(255,255,255,.6); font-size: .72rem; }

        .auth-left .left-bottom {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 2;
            padding: 0 40px 44px;
        }

        .auth-left .tagline {
            font-size: clamp(1.4rem, 2.2vw, 2rem);
            font-weight: 800;
            color: white;
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .auth-left .tagline span { color: var(--yellow-main); }

        .auth-left .tagline-sub {
            color: rgba(255,255,255,.7);
            font-size: .875rem;
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .feature-list { list-style: none; padding: 0; margin: 0; }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.82);
            font-size: .84rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .feature-list li .fi {
            width: 28px; height: 28px;
            background: rgba(255,255,255,.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .fi-yellow { color: var(--yellow-main) !important; }
        .fi-green  { color: #6ee89a !important; }
        .fi-red    { color: #f4a0a0 !important; }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 40px;
            background: #f4f7f5;
            overflow-y: auto;
        }

        .auth-form-box {
            width: 100%;
            max-width: 440px;
        }

        .form-heading { margin-bottom: 28px; }
        .form-heading h2 { font-size: 1.6rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px; }
        .form-heading p  { color: var(--text-muted); font-size: .875rem; }

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

        .form-control, textarea.form-control {
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

        .input-group:focus-within .input-group-text { border-color: var(--green-mid); }

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

        .btn-submit:hover { opacity: .92; transform: translateY(-1px); color: white; }

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
            margin: 18px 0;
            color: var(--text-muted);
            font-size: .78rem;
        }

        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border-soft); }

        .link-green { color: var(--green-dark); font-weight: 700; text-decoration: none; }
        .link-green:hover { color: var(--green-mid); text-decoration: underline; }

        .back-to-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .2s;
        }

        .back-to-home:hover { color: var(--green-dark); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right {
                padding: 40px 24px;
                background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            }
            .auth-form-box {
                background: white;
                border-radius: 20px;
                padding: 36px 28px;
                box-shadow: 0 20px 60px rgba(0,0,0,.2);
            }
            .back-to-home { color: rgba(255,255,255,.75); }
            .back-to-home:hover { color: white; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <!-- LEFT: Image Panel -->
    <div class="auth-left">
        <img class="bg-img" src="{{ asset('image/Rumah Bekam 3.jpeg') }}" alt="Rumah Bekam Salam Insani">
        <div class="overlay"></div>

        <div class="brand-row">
            <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
            <div>
                <div class="brand-name">Rumah Bekam</div>
                <div class="brand-sub">Salam Insani</div>
            </div>
        </div>

        <div class="left-bottom">
            <h2 class="tagline">
                Bergabung &amp;<br>Mulai <span>Hidup Sehat</span>
            </h2>
            <p class="tagline-sub">
                Daftar sekarang dan nikmati kemudahan booking layanan bekam profesional kapan saja, di mana saja.
            </p>
            <ul class="feature-list">
                <li>
                    <span class="fi fi-green"><i class="bi bi-patch-check-fill"></i></span>
                    Terapis bersertifikat &amp; berpengalaman
                </li>
                <li>
                    <span class="fi fi-yellow"><i class="bi bi-calendar2-check-fill"></i></span>
                    Booking online mudah &amp; cepat
                </li>
                <li>
                    <span class="fi fi-red"><i class="bi bi-shield-fill-check"></i></span>
                    Peralatan steril standar medis
                </li>
                <li>
                    <span class="fi fi-green"><i class="bi bi-geo-alt-fill"></i></span>
                    Tersedia di berbagai lokasi
                </li>
            </ul>
        </div>
    </div>

    <!-- RIGHT: Form Panel -->
    <div class="auth-right">
        <div class="auth-form-box">

            <a href="{{ route('landing') }}" class="back-to-home">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="form-heading">
                <h2>Buat Akun Baru ✨</h2>
                <p>Isi data di bawah untuk mendaftar</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0 ps-3 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label">Nama Lengkap <span style="color:var(--red-main)">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}"
                                placeholder="Nama lengkap Anda" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Email <span style="color:var(--red-main)">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="email@example.com" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">No. Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" name="no_telepon"
                                class="form-control @error('no_telepon') is-invalid @enderror"
                                value="{{ old('no_telepon') }}"
                                placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text" style="align-items:flex-start;padding-top:10px;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <textarea name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror"
                                rows="2"
                                placeholder="Alamat lengkap Anda">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label">Password <span style="color:var(--red-main)">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Min. 8 karakter" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label">Konfirmasi <span style="color:var(--red-main)">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="divider">atau</div>

            <p class="text-center mb-0" style="font-size:.875rem;color:var(--text-muted);">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="link-green ms-1">Masuk di sini</a>
            </p>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
