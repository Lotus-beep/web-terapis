<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Bekam Salam Insani - Layanan Bekam Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --green-dark:   #1b6b3a;
            --green-mid:    #2e9e58;
            --green-light:  #e8f5ee;
            --red-main:     #c0392b;
            --red-soft:     #fdecea;
            --yellow-main:  #e6a817;
            --yellow-soft:  #fef9ec;
            --white:        #ffffff;
            --bg-page:      #f4f7f5;
            --text-dark:    #1c2b22;
            --text-muted:   #6b7c72;
            --border-soft:  #d8e8de;
            --shadow-sm:    0 2px 12px rgba(27,107,58,.08);
            --shadow-md:    0 8px 28px rgba(27,107,58,.13);
            --shadow-lg:    0 16px 48px rgba(27,107,58,.18);
            --radius-card:  16px;
            --radius-pill:  50px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-dark);
        }

        /* ===== SUBTLE CLINIC BACKGROUND PATTERN ===== */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(46,158,88,.04) 0%, transparent 50%),
                radial-gradient(circle at 85% 75%, rgba(192,57,43,.03) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(230,168,23,.03) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255,255,255,.97) !important;
            backdrop-filter: blur(14px);
            box-shadow: 0 2px 16px rgba(27,107,58,.10);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--green-dark) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .nav-link {
            font-weight: 600;
            font-size: .9rem;
            color: var(--text-dark) !important;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: background .2s, color .2s;
        }

        .nav-link:hover {
            background: var(--green-light);
            color: var(--green-dark) !important;
        }

        .btn-nav-login {
            border: 1.5px solid var(--green-mid);
            color: var(--green-dark) !important;
            border-radius: var(--radius-pill) !important;
            padding: 6px 20px !important;
        }

        .btn-nav-login:hover {
            background: var(--green-light) !important;
        }

        .btn-nav-register {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid)) !important;
            color: white !important;
            border-radius: var(--radius-pill) !important;
            padding: 6px 20px !important;
            border: none !important;
        }

        .btn-nav-register:hover {
            opacity: .9;
            color: white !important;
        }

        /* ===== HERO ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--green-dark) 0%, #27855a 55%, var(--green-mid) 100%);
            color: white;
            padding: 130px 0 90px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 80% 20%, rgba(230,168,23,.18) 0%, transparent 55%),
                radial-gradient(ellipse at 10% 80%, rgba(192,57,43,.12) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 80px;
            background: var(--bg-page);
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.3);
            color: white;
            font-size: .8rem;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: var(--radius-pill);
            margin-bottom: 20px;
            backdrop-filter: blur(6px);
        }

        .hero-badge .dot {
            width: 7px;
            height: 7px;
            background: var(--yellow-main);
            border-radius: 50%;
            animation: pulse-dot 1.6s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(1.4); }
        }

        .hero-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--yellow-main);
        }

        .hero-stats {
            display: flex;
            gap: 28px;
            margin-top: 36px;
        }

        .hero-stat-item {
            text-align: center;
        }

        .hero-stat-item .num {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--yellow-main);
            line-height: 1;
        }

        .hero-stat-item .lbl {
            font-size: .75rem;
            opacity: .8;
            margin-top: 2px;
        }

        .hero-stat-divider {
            width: 1px;
            background: rgba(255,255,255,.25);
            align-self: stretch;
        }

        .hero-img-wrap {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-img-circle {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid rgba(255,255,255,.25);
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            position: relative;
            z-index: 1;
        }

        .hero-img-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-float-card {
            position: absolute;
            background: white;
            border-radius: 14px;
            padding: 10px 16px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-dark);
            z-index: 2;
        }

        .hero-float-card .icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .hero-float-card.card-1 { bottom: 30px; left: -20px; }
        .hero-float-card.card-2 { top: 30px; right: -20px; }

        /* ===== SECTION COMMON ===== */
        .section-label {
            display: inline-block;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--green-mid);
            background: var(--green-light);
            padding: 4px 14px;
            border-radius: var(--radius-pill);
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(1.5rem, 3vw, 2.1rem);
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .section-title span { color: var(--green-dark); }

        .section-divider {
            width: 56px;
            height: 4px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--green-dark), var(--yellow-main));
            margin: 0 auto 16px;
        }

        /* ===== FEATURES STRIP ===== */
        .features-strip {
            background: white;
            border-bottom: 1px solid var(--border-soft);
            padding: 36px 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .feature-item .fi-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .fi-green  { background: var(--green-light);  color: var(--green-dark); }
        .fi-red    { background: var(--red-soft);     color: var(--red-main); }
        .fi-yellow { background: var(--yellow-soft);  color: var(--yellow-main); }

        .feature-item h6 {
            font-weight: 700;
            margin-bottom: 4px;
            font-size: .95rem;
        }

        .feature-item p {
            font-size: .82rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* ===== SERVICE CARDS ===== */
        .services-section { background: var(--bg-page); }

        .service-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-card);
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .service-card-top {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            padding: 20px 20px 14px;
            color: white;
        }

        .service-card-top .price-badge {
            display: inline-block;
            background: var(--yellow-main);
            color: var(--text-dark);
            font-weight: 700;
            font-size: .78rem;
            padding: 3px 12px;
            border-radius: var(--radius-pill);
        }

        .service-card-body { padding: 18px 20px; }

        .service-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .82rem;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .service-meta-item i { color: var(--green-mid); font-size: .9rem; }

        .btn-booking {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            padding: 8px 22px;
            font-size: .85rem;
            font-weight: 600;
            transition: opacity .2s, transform .2s;
        }

        .btn-booking:hover {
            opacity: .9;
            transform: translateY(-1px);
            color: white;
        }

        /* ===== KENALI LAYANAN ===== */
        .kenali-section { background: white; }

        .layanan-photo-card {
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-card);
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
            position: relative;
            background: white;
        }

        .layanan-photo-card:hover {
            transform: translateY(-7px);
            box-shadow: var(--shadow-lg);
        }

        .layanan-photo-card .img-wrap {
            overflow: hidden;
            height: 210px;
        }

        .layanan-photo-card .img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .45s;
        }

        .layanan-photo-card:hover .img-wrap img {
            transform: scale(1.08);
        }

        .layanan-photo-card .card-body {
            padding: 16px 18px 18px;
        }

        .layanan-photo-card .card-body h5 {
            font-size: .97rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-dark);
        }

        .layanan-photo-card .card-body p {
            font-size: .8rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.55;
        }

        .layanan-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: .7rem;
            font-weight: 700;
            padding: 3px 11px;
            border-radius: var(--radius-pill);
            z-index: 2;
            letter-spacing: .03em;
        }

        .badge-unggulan { background: var(--green-dark);  color: white; }
        .badge-populer  { background: var(--red-main);    color: white; }
        .badge-spesial  { background: var(--yellow-main); color: var(--text-dark); }

        /* ===== GALLERY ===== */
        .gallery-section { background: var(--bg-page); }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto auto;
            gap: 12px;
        }

        .gallery-grid .g-item-large {
            grid-column: span 2;
            grid-row: span 2;
        }

        .gallery-item {
            overflow: hidden;
            border-radius: 14px;
            cursor: pointer;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .45s;
            min-height: 160px;
        }

        .g-item-large img { min-height: 332px; }

        .gallery-item:hover img { transform: scale(1.07); }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(27,107,58,.6), rgba(192,57,43,.4));
            opacity: 0;
            transition: opacity .3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 14px;
        }

        .gallery-item:hover .gallery-overlay { opacity: 1; }

        .gallery-overlay i { font-size: 2rem; color: white; }

        .gallery-overlay span {
            font-size: .78rem;
            font-weight: 600;
            color: rgba(255,255,255,.9);
        }

        /* ===== LIGHTBOX ===== */
        .lightbox-modal .modal-dialog { max-width: 860px; }
        .lightbox-modal .modal-content { background: transparent; border: none; }
        .lightbox-modal img {
            width: 100%;
            border-radius: 16px;
            max-height: 82vh;
            object-fit: contain;
            box-shadow: 0 24px 64px rgba(0,0,0,.5);
        }
        .lightbox-modal .btn-close-lb {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 36px;
            height: 36px;
            background: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            z-index: 10;
            box-shadow: var(--shadow-md);
            color: var(--text-dark);
        }

        /* ===== TERAPIS ===== */
        .terapis-section { background: white; }

        .terapis-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-card);
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
        }

        .terapis-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .terapis-card-header {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            padding: 28px 20px 20px;
            text-align: center;
            position: relative;
        }

        .terapis-avatar {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,.2);
            border: 3px solid rgba(255,255,255,.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 2rem;
            color: white;
        }

        .terapis-card-header h5 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: .97rem;
        }

        .terapis-card-body { padding: 16px 20px; }

        .rating-stars { color: var(--yellow-main); font-size: .9rem; }

        /* ===== ABOUT ===== */
        .about-section { background: var(--bg-page); }

        .about-stat-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-card);
            padding: 24px 16px;
            text-align: center;
            transition: transform .3s, box-shadow .3s;
        }

        .about-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .about-stat-card .stat-num {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .about-stat-card .stat-lbl {
            font-size: .8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .stat-green  .stat-num { color: var(--green-dark); }
        .stat-red    .stat-num { color: var(--red-main); }
        .stat-yellow .stat-num { color: var(--yellow-main); }
        .stat-teal   .stat-num { color: #0e7490; }

        .check-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            font-size: .92rem;
        }

        .check-list li i {
            color: var(--green-mid);
            font-size: 1.1rem;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, var(--green-dark) 0%, #27855a 60%, var(--green-mid) 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 90% 10%, rgba(230,168,23,.2) 0%, transparent 50%),
                radial-gradient(ellipse at 5% 90%, rgba(192,57,43,.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .btn-cta-white {
            background: white;
            color: var(--green-dark);
            font-weight: 700;
            border-radius: var(--radius-pill);
            padding: 14px 40px;
            font-size: 1rem;
            border: none;
            transition: transform .2s, box-shadow .2s;
        }

        .btn-cta-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0,0,0,.2);
            color: var(--green-dark);
        }

        .btn-cta-outline {
            background: transparent;
            color: white;
            font-weight: 600;
            border-radius: var(--radius-pill);
            padding: 13px 36px;
            font-size: 1rem;
            border: 2px solid rgba(255,255,255,.5);
            transition: background .2s, border-color .2s;
        }

        .btn-cta-outline:hover {
            background: rgba(255,255,255,.12);
            border-color: white;
            color: white;
        }

        /* ===== FOOTER ===== */
        footer {
            background: linear-gradient(160deg, #0f2318 0%, #1b3a28 100%);
            color: white;
        }

        footer .footer-brand {
            font-size: 1.1rem;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        footer .footer-brand .brand-icon {
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
        }

        footer a {
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: .88rem;
            transition: color .2s;
        }

        footer a:hover { color: var(--yellow-main); }

        footer .footer-contact li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .88rem;
            color: rgba(255,255,255,.55);
            margin-bottom: 10px;
        }

        footer .footer-contact li i { color: var(--green-mid); }

        footer hr { border-color: rgba(255,255,255,.1); }

        /* ===== SCROLL ANIMATION ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .55s ease, transform .55s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 767px) {
            .hero-section { padding: 100px 0 70px; }
            .hero-img-circle { width: 220px; height: 220px; }
            .hero-float-card { display: none; }
            .hero-stats { gap: 16px; }
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .gallery-grid .g-item-large {
                grid-column: span 2;
                grid-row: span 1;
            }
            .g-item-large img { min-height: 200px; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                Rumah Bekam Salam Insani
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kenali-layanan">Kenali Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#terapis">Terapis</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    @auth
                        <li class="nav-item ms-2">
                            <a class="nav-link btn-nav-register px-3" href="{{ route(auth()->user()->role_users . '.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-1">
                            <a class="nav-link btn-nav-login" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-1">
                            <a class="nav-link btn-nav-register" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <span class="dot"></span>
                        Terapis Bersertifikat Resmi
                    </div>
                    <h1 class="hero-title">
                        Layanan Bekam <span>Profesional</span><br>& Terpercaya
                    </h1>
                    <p class="mb-4" style="opacity:.88; font-size:1.05rem; line-height:1.7;">
                        Rumah Bekam Salam Insani hadir dengan terapis berpengalaman, peralatan steril, dan suasana klinik yang nyaman. Kesehatan Anda adalah prioritas kami.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-cta-white btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                        </a>
                        <a href="#kenali-layanan" class="btn btn-cta-outline btn-lg">
                            <i class="bi bi-play-circle me-2"></i>Kenali Layanan
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="num">1000+</div>
                            <div class="lbl">Pasien Puas</div>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div class="hero-stat-item">
                            <div class="num">10+</div>
                            <div class="lbl">Terapis Ahli</div>
                        </div>
                        <div class="hero-stat-divider"></div>
                        <div class="hero-stat-item">
                            <div class="num">5+</div>
                            <div class="lbl">Tahun Berdiri</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center">
                    <div class="hero-img-wrap">
                        <div class="hero-img-circle">
                            <img src="{{ asset('image/Bekam Foto.jpeg') }}" alt="Bekam Profesional">
                        </div>
                        <div class="hero-float-card card-1">
                            <div class="icon-wrap fi-green"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <div style="font-size:.7rem;color:var(--text-muted);">Standar</div>
                                Peralatan Steril
                            </div>
                        </div>
                        <div class="hero-float-card card-2">
                            <div class="icon-wrap fi-yellow"><i class="bi bi-star-fill"></i></div>
                            <div>
                                <div style="font-size:.7rem;color:var(--text-muted);">Rating</div>
                                4.9 / 5.0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES STRIP ===== -->
    <section class="features-strip">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 fade-up">
                    <div class="feature-item">
                        <div class="fi-icon fi-green"><i class="bi bi-patch-check-fill"></i></div>
                        <div>
                            <h6>Terapis Bersertifikat</h6>
                            <p>Semua terapis memiliki sertifikat resmi dan pengalaman bertahun-tahun di bidangnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-up" style="transition-delay:.1s">
                    <div class="feature-item">
                        <div class="fi-icon fi-yellow"><i class="bi bi-calendar2-check-fill"></i></div>
                        <div>
                            <h6>Booking Online Mudah</h6>
                            <p>Sistem reservasi digital yang cepat dan praktis, bisa dilakukan kapan saja.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 fade-up" style="transition-delay:.2s">
                    <div class="feature-item">
                        <div class="fi-icon fi-red"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <h6>Lokasi Strategis</h6>
                            <p>Tersedia di beberapa lokasi yang mudah dijangkau dari berbagai penjuru kota.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section id="layanan" class="services-section py-5">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <span class="section-label">Jadwal Tersedia</span>
                <h2 class="section-title">Layanan <span>Kami</span></h2>
                <div class="section-divider"></div>
                <p class="text-muted" style="max-width:520px;margin:0 auto;">Pilih layanan bekam sesuai kebutuhan Anda. Semua sesi ditangani oleh terapis bersertifikat.</p>
            </div>

            <div class="row g-4">
                @forelse($services as $service)
                <div class="col-md-6 col-lg-4 fade-up">
                    <div class="service-card h-100">
                        {{-- Foto Layanan --}}
                        <div style="overflow:hidden;height:180px;position:relative;">
                            <img src="{{ asset($service->display_image) }}"
                                alt="{{ $service->name }}"
                                style="width:100%;height:100%;object-fit:cover;transition:transform .45s;">
                            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(27,107,58,.55),transparent 55%);"></div>

                            <span style="position:absolute;bottom:10px;left:12px;color:white;font-weight:800;font-size:.95rem;text-shadow:0 1px 4px rgba(0,0,0,.4);">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="service-card-body">
                            <h5 class="fw-bold mb-2" style="font-size:.97rem;color:var(--text-dark);">{{ $service->header_content ?: $service->name }}</h5>
                            @if($service->description)
                                <p style="font-size:.8rem;color:var(--text-muted);margin-bottom:12px;line-height:1.55;">
                                    {{ Str::limit($service->description, 80) }}
                                </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:1px solid var(--border-soft);">
                                <span class="fw-bold" style="color:var(--green-dark);font-size:.95rem;">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                <a href="{{ route('login') }}" class="btn-booking btn btn-sm">
                                    <i class="bi bi-calendar-check me-1"></i>Booking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size:3rem;color:var(--border-soft);"></i>
                    <p class="text-muted mt-3">Belum ada jadwal layanan tersedia</p>
                </div>
                @endforelse
            </div>

            @if($services->count() > 0)
            <div class="text-center mt-5 fade-up">
                <a href="{{ route('login') }}" class="btn btn-booking btn-lg px-5">
                    <i class="bi bi-arrow-right-circle me-2"></i>Lihat Semua Layanan
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- ===== KENALI LAYANAN ===== -->
    <section id="kenali-layanan" class="kenali-section py-5">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <span class="section-label">Jenis Terapi</span>
                <h2 class="section-title">Kenali <span>Layanan Kami</span></h2>
                <div class="section-divider"></div>
                <p class="text-muted" style="max-width:520px;margin:0 auto;">Temukan berbagai layanan bekam profesional yang kami sediakan untuk mendukung kesehatan Anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 fade-up">
                    <div class="layanan-photo-card h-100">
                        <span class="layanan-badge badge-unggulan">Unggulan</span>
                        <div class="img-wrap">
                            <img src="{{ asset('image/Bekam Foto.jpeg') }}" alt="Bekam Basah">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-droplet-fill me-2" style="color:var(--red-main);"></i>Bekam Basah</h5>
                            <p>Terapi wet cupping untuk mengeluarkan darah kotor dan racun dari tubuh. Efektif untuk berbagai keluhan kesehatan kronis maupun akut.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 fade-up" style="transition-delay:.08s">
                    <div class="layanan-photo-card h-100">
                        <span class="layanan-badge badge-populer">Populer</span>
                        <div class="img-wrap">
                            <img src="{{ asset('image/jenis Layanan.png') }}" alt="Jenis Layanan Bekam">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-grid-fill me-2" style="color:var(--green-mid);"></i>Berbagai Jenis Bekam</h5>
                            <p>Kami menyediakan berbagai jenis layanan bekam yang dapat disesuaikan dengan kebutuhan dan kondisi kesehatan Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 fade-up" style="transition-delay:.16s">
                    <div class="layanan-photo-card h-100">
                        <span class="layanan-badge badge-spesial">Spesial</span>
                        <div class="img-wrap">
                            <img src="{{ asset('image/Layanan Pijat Bayi & Anak.jpeg') }}" alt="Pijat Bayi dan Anak">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-emoji-smile-fill me-2" style="color:var(--yellow-main);"></i>Pijat Bayi &amp; Anak</h5>
                            <p>Layanan pijat khusus bayi dan anak dengan teknik lembut dan aman, membantu tumbuh kembang si kecil secara optimal.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 fade-up" style="transition-delay:.24s">
                    <div class="layanan-photo-card h-100">
                        <div class="img-wrap">
                            <img src="{{ asset('image/tempat Bekam.jpeg') }}" alt="Tempat Bekam">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-house-heart-fill me-2" style="color:var(--green-dark);"></i>Ruang Bekam Nyaman</h5>
                            <p>Fasilitas ruang bekam yang bersih, nyaman, dan higienis untuk memberikan pengalaman terapi terbaik bagi Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 fade-up" style="transition-delay:.32s">
                    <div class="layanan-photo-card h-100">
                        <div class="img-wrap">
                            <img src="{{ asset('image/Tempat Bekam 2.jpeg') }}" alt="Fasilitas Bekam">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-clipboard2-pulse-fill me-2" style="color:var(--red-main);"></i>Fasilitas Lengkap</h5>
                            <p>Dilengkapi peralatan medis standar dan steril untuk memastikan keamanan dan kenyamanan setiap sesi terapi.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 fade-up" style="transition-delay:.4s">
                    <div class="layanan-photo-card h-100">
                        <div class="img-wrap">
                            <img src="{{ asset('image/Rumah Bekam 3.jpeg') }}" alt="Rumah Bekam Salam Insani">
                        </div>
                        <div class="card-body">
                            <h5><i class="bi bi-building-fill-check me-2" style="color:var(--green-mid);"></i>Rumah Bekam Salam Insani</h5>
                            <p>Pusat layanan bekam profesional yang telah dipercaya ribuan pasien. Hadir untuk melayani kesehatan Anda sepenuh hati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== GALLERY ===== -->
    <section id="galeri" class="gallery-section py-5">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <span class="section-label">Dokumentasi</span>
                <h2 class="section-title">Galeri <span>Kami</span></h2>
                <div class="section-divider"></div>
                <p class="text-muted" style="max-width:480px;margin:0 auto;">Sekilas suasana dan kegiatan di Rumah Bekam Salam Insani.</p>
            </div>

            <div class="gallery-grid fade-up">
                <!-- Large item -->
                <div class="gallery-item g-item-large"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Bekam Foto.jpeg') }}" data-caption="Bekam Basah">
                    <img src="{{ asset('image/Bekam Foto.jpeg') }}" alt="Bekam Basah">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Bekam Basah</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Poster Promosi Bekam.jpeg') }}" data-caption="Poster Promosi Bekam">
                    <img src="{{ asset('image/Poster Promosi Bekam.jpeg') }}" alt="Poster Promosi">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Promosi Bekam</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Poster Salam Insani.png') }}" data-caption="Poster Salam Insani">
                    <img src="{{ asset('image/Poster Salam Insani.png') }}" alt="Poster Salam Insani">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Salam Insani</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Layanan Pijat Bayi & Anak.jpeg') }}" data-caption="Pijat Bayi & Anak">
                    <img src="{{ asset('image/Layanan Pijat Bayi & Anak.jpeg') }}" alt="Pijat Bayi">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Pijat Bayi &amp; Anak</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/tempat Bekam.jpeg') }}" data-caption="Tempat Bekam">
                    <img src="{{ asset('image/tempat Bekam.jpeg') }}" alt="Tempat Bekam">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Ruang Bekam</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Tempat Bekam 2.jpeg') }}" data-caption="Fasilitas Bekam">
                    <img src="{{ asset('image/Tempat Bekam 2.jpeg') }}" alt="Fasilitas">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Fasilitas</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/Rumah Bekam 3.jpeg') }}" data-caption="Rumah Bekam Salam Insani">
                    <img src="{{ asset('image/Rumah Bekam 3.jpeg') }}" alt="Rumah Bekam">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Rumah Bekam</span>
                    </div>
                </div>

                <div class="gallery-item"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('image/jenis Layanan.png') }}" data-caption="Jenis Layanan Bekam">
                    <img src="{{ asset('image/jenis Layanan.png') }}" alt="Jenis Layanan">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in"></i>
                        <span>Jenis Layanan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="modal fade lightbox-modal" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">
                <button type="button" class="btn-close-lb" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                <img id="lightboxImg" src="" alt="">
                <p id="lightboxCaption" class="text-center text-white mt-3 mb-0 fw-semibold fs-6"></p>
            </div>
        </div>
    </div>

    <!-- ===== TERAPIS ===== -->
    <section id="terapis" class="terapis-section py-5">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <span class="section-label">Tim Profesional</span>
                <h2 class="section-title">Terapis <span>Kami</span></h2>
                <div class="section-divider"></div>
                <p class="text-muted" style="max-width:480px;margin:0 auto;">Ditangani langsung oleh terapis bersertifikat yang berpengalaman dan ramah.</p>
            </div>

            <div class="row g-4">
                @forelse($terapis as $t)
                <div class="col-md-6 col-lg-4 fade-up">
                    <div class="terapis-card">
                        <div class="terapis-card-header">
                            <div class="terapis-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h5>{{ $t->username }}</h5>
                            <small style="opacity:.75;font-size:.78rem;">Terapis Bersertifikat</small>
                        </div>
                        <div class="terapis-card-body">
                            <div class="d-flex align-items-center gap-2 mb-2" style="font-size:.83rem;color:var(--text-muted);">
                                <i class="bi bi-telephone-fill" style="color:var(--green-mid);"></i>
                                {{ $t->no_telepon }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-people" style="font-size:3rem;color:var(--border-soft);"></i>
                    <p class="text-muted mt-3">Belum ada data terapis</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section id="tentang" class="about-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-up">
                    <span class="section-label">Tentang Kami</span>
                    <h2 class="section-title mt-2">Rumah Bekam <span>Salam Insani</span></h2>
                    <div class="section-divider" style="margin:0 0 20px;"></div>
                    <p style="color:var(--text-muted);line-height:1.8;margin-bottom:24px;">
                        Rumah Bekam Salam Insani adalah pusat layanan bekam profesional yang telah berpengalaman melayani ribuan pasien. Kami berkomitmen memberikan pelayanan terbaik dengan standar kesehatan yang tinggi, suasana klinik yang nyaman, dan harga yang terjangkau.
                    </p>
                    <ul class="check-list list-unstyled">
                        <li><i class="bi bi-check-circle-fill"></i>Terapis bersertifikat dan berpengalaman</li>
                        <li><i class="bi bi-check-circle-fill"></i>Peralatan steril dan higienis sesuai standar medis</li>
                        <li><i class="bi bi-check-circle-fill"></i>Harga terjangkau dan transparan tanpa biaya tersembunyi</li>
                        <li><i class="bi bi-check-circle-fill"></i>Lokasi strategis dan mudah dijangkau</li>
                        <li><i class="bi bi-check-circle-fill"></i>Sistem booking online yang praktis</li>
                    </ul>
                </div>
                <div class="col-lg-6 fade-up" style="transition-delay:.15s">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="about-stat-card stat-green">
                                <div class="stat-num">1000+</div>
                                <div class="stat-lbl">Pasien Puas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card stat-red">
                                <div class="stat-num">10+</div>
                                <div class="stat-lbl">Terapis Ahli</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card stat-yellow">
                                <div class="stat-num">5+</div>
                                <div class="stat-lbl">Tahun Pengalaman</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card stat-teal">
                                <div class="stat-num">3</div>
                                <div class="stat-lbl">Lokasi Cabang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section py-5">
        <div class="container position-relative text-center py-3">
            <span class="section-label" style="background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);">Mulai Sekarang</span>
            <h2 class="fw-800 mt-3 mb-3 text-white" style="font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;">
                Siap Memulai Perjalanan<br>Kesehatan Anda?
            </h2>
            <p class="text-white mb-4" style="opacity:.85;font-size:1.05rem;max-width:480px;margin:0 auto 28px;">
                Daftar sekarang dan rasakan manfaat bekam profesional dari terapis terpercaya kami.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-cta-white btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-cta-outline btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                        Rumah Bekam Salam Insani
                    </div>
                    <p style="color:rgba(255,255,255,.5);font-size:.88rem;line-height:1.7;">
                        Layanan bekam profesional dengan terapis bersertifikat. Kesehatan Anda adalah prioritas kami.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.08);border-radius:8px;color:rgba(255,255,255,.6);font-size:1rem;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.08);border-radius:8px;color:rgba(255,255,255,.6);font-size:1rem;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:rgba(255,255,255,.08);border-radius:8px;color:rgba(255,255,255,.6);font-size:1rem;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-700 mb-3 text-white" style="font-weight:700;">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#layanan">Layanan</a></li>
                        <li class="mb-2"><a href="#kenali-layanan">Kenali Layanan</a></li>
                        <li class="mb-2"><a href="#galeri">Galeri</a></li>
                        <li class="mb-2"><a href="#terapis">Terapis</a></li>
                        <li class="mb-2"><a href="#tentang">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-700 mb-3 text-white" style="font-weight:700;">Kontak</h6>
                    <ul class="footer-contact list-unstyled">
                        <li><i class="bi bi-telephone-fill"></i>+62 812-3456-7890</li>
                        <li><i class="bi bi-envelope-fill"></i>info@rumahbekam.com</li>
                        <li><i class="bi bi-geo-alt-fill"></i>Jakarta, Indonesia</li>
                        <li><i class="bi bi-clock-fill"></i>Senin – Sabtu, 08.00 – 20.00</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center" style="color:rgba(255,255,255,.35);font-size:.82rem;">
                &copy; 2025 Rumah Bekam Salam Insani. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lightbox
        document.querySelectorAll('.gallery-item').forEach(function(item) {
            item.addEventListener('click', function() {
                document.getElementById('lightboxImg').src = this.getAttribute('data-img');
                document.getElementById('lightboxCaption').textContent = this.getAttribute('data-caption');
            });
        });

        // Scroll fade-up animation
        const fadeEls = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        fadeEls.forEach(function(el) { observer.observe(el); });

        // Navbar active link highlight on scroll
        const sections = document.querySelectorAll('section[id]');
        window.addEventList=ener('scroll', function() {
            let scrollY = window.pageYOffset;
            sections.forEach(function(sec) {
                const top = sec.offsetTop - 80;
                const height = sec.offsetHeight;
                const id = sec.getAttribute('id');
                const link = document.querySelector('.navbar a[href="#' + id + '"]');
                if (link) {
                    if (scrollY >= top && scrollY < top + height) {
                        link.style.color = 'var(--green-dark)';
                        link.style.background = 'var(--green-light)';
                    } else {
                        link.style.color = '';
                        link.style.background = '';
                    }
                }
            });
        });
    </script>
</body>
</html>
