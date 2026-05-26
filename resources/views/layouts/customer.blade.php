<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer') - Rumah Bekam Salam Insani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-dark:   #1b6b3a;
            --green-mid:    #2e9e58;
            --green-light:  #e8f5ee;
            --red-main:     #c0392b;
            --red-soft:     #fdecea;
            --yellow-main:  #e6a817;
            --yellow-soft:  #fef9ec;
            --bg-page:      #f4f7f5;
            --text-dark:    #1c2b22;
            --text-muted:   #6b7c72;
            --border-soft:  #d8e8de;
            --shadow-sm:    0 2px 12px rgba(27,107,58,.08);
            --shadow-md:    0 6px 24px rgba(27,107,58,.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            color: var(--text-dark);
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: linear-gradient(135deg, var(--green-dark) 0%, #1e7a42 60%, var(--green-mid) 100%) !important;
            box-shadow: 0 4px 20px rgba(27,107,58,.25);
            padding: 12px 0;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 800;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand .brand-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,.18);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: white;
        }

        .navbar .nav-link {
            color: rgba(255,255,255,.82) !important;
            font-weight: 600;
            font-size: .875rem;
            padding: 7px 14px !important;
            border-radius: 8px;
            transition: background .2s, color .2s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            background: rgba(255,255,255,.18) !important;
            color: white !important;
        }

        .navbar .nav-link.fw-bold { color: white !important; }

        .navbar .dropdown-menu {
            border: 1px solid var(--border-soft);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            padding: 8px;
        }

        .navbar .dropdown-item {
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 500;
            padding: 8px 14px;
            color: var(--text-dark);
        }

        .navbar .dropdown-item:hover { background: var(--green-light); color: var(--green-dark); }
        .navbar .dropdown-item.text-danger:hover { background: var(--red-soft); color: var(--red-main); }

        .navbar-toggler { border: none; color: white; }
        .navbar-toggler:focus { box-shadow: none; }

        /* ===== CONTENT ===== */
        .content-area {
            padding: 28px 0;
            min-height: calc(100vh - 130px);
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid var(--border-soft);
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-soft);
            border-radius: 14px 14px 0 0 !important;
            padding: 16px 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* ===== STAT CARDS ===== */
        .stat-card { border-radius: 14px; padding: 22px; color: white; border: none; position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,.1); border-radius: 50%; }
        .stat-green  { background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); }
        .stat-red    { background: linear-gradient(135deg, #a93226, var(--red-main)); }
        .stat-yellow { background: linear-gradient(135deg, #c98a10, var(--yellow-main)); }
        .stat-teal   { background: linear-gradient(135deg, #0e6b7a, #1a9aad); }

        /* ===== TABLES ===== */
        .table { font-size: .875rem; }
        .table thead th { background: var(--green-light); color: var(--green-dark); font-weight: 700; border: none; padding: 12px 16px; }
        .table tbody td { padding: 12px 16px; vertical-align: middle; border-color: var(--border-soft); }
        .table tbody tr:hover { background: #f9fcfa; }

        /* ===== BUTTONS ===== */
        .btn-primary { background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); border: none; border-radius: 8px; font-weight: 600; color: white; }
        .btn-primary:hover { opacity: .9; color: white; }
        .btn-warning { background: var(--yellow-soft); border: 1px solid #f0d080; color: #9a6e0a; border-radius: 8px; font-weight: 600; }
        .btn-warning:hover { background: #fdefc0; color: #9a6e0a; }
        .btn-danger  { background: var(--red-soft); border: 1px solid #f5c6c2; color: var(--red-main); border-radius: 8px; font-weight: 600; }
        .btn-danger:hover  { background: #fbd5d2; color: var(--red-main); }
        .btn-success { background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); border: none; border-radius: 8px; font-weight: 600; color: white; }
        .btn-success:hover { opacity: .9; color: white; }

        /* ===== ALERTS ===== */
        .alert-success { background: var(--green-light); border: 1px solid #b8dfc8; color: var(--green-dark); border-radius: 10px; }
        .alert-danger  { background: var(--red-soft);   border: 1px solid #f5c6c2; color: var(--red-main);   border-radius: 10px; }

        /* ===== FORMS ===== */
        .form-control, .form-select { border: 1.5px solid var(--border-soft); border-radius: 8px; font-size: .875rem; padding: 9px 14px; transition: border-color .2s, box-shadow .2s; }
        .form-control:focus, .form-select:focus { border-color: var(--green-mid); box-shadow: 0 0 0 3px rgba(46,158,88,.12); }
        .form-label { font-weight: 600; font-size: .85rem; color: var(--text-dark); }

        /* ===== BADGES ===== */
        .badge-green  { background: var(--green-light); color: var(--green-dark); font-weight: 600; }
        .badge-red    { background: var(--red-soft);    color: var(--red-main);   font-weight: 600; }
        .badge-yellow { background: var(--yellow-soft); color: #9a6e0a;           font-weight: 600; }

        /* ===== RATING ===== */
        .rating-stars { color: var(--yellow-main); }

        /* ===== FOOTER ===== */
        footer {
            background: linear-gradient(160deg, #0f2318 0%, #1b3a28 100%);
            color: white;
            padding: 20px 0;
        }

        footer p { color: rgba(255,255,255,.45); font-size: .82rem; margin: 0; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                Rumah Bekam
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('customer.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.services.*') ? 'active fw-bold' : '' }}" href="{{ route('customer.services.index') }}">
                            <i class="bi bi-clipboard2-pulse me-1"></i>Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.bookings.*') ? 'active fw-bold' : '' }}" href="{{ route('customer.bookings.index') }}">
                            <i class="bi bi-calendar-check me-1"></i>Booking Saya
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <span style="width:30px;height:30px;background:rgba(255,255,255,.18);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}"><i class="bi bi-pencil me-2"></i>Edit Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-area">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p>&copy; 2025 Rumah Bekam Salam Insani. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
