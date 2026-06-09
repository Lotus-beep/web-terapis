<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Rumah Bekam Salam Insani</title>
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
            --sidebar-w:    260px;
            --shadow-sm:    0 2px 12px rgba(27,107,58,.08);
            --shadow-md:    0 6px 24px rgba(27,107,58,.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            color: var(--text-dark);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: linear-gradient(180deg, var(--green-dark) 0%, #1e7a42 60%, var(--green-mid) 100%);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform .3s;
            box-shadow: 4px 0 20px rgba(27,107,58,.18);
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.2); border-radius: 4px; }

        .sidebar .brand {
            padding: 20px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .brand-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,.18);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: white; flex-shrink: 0;
        }

        .sidebar .brand-text .title {
            color: white; font-weight: 800; font-size: .95rem; line-height: 1.2;
        }

        .sidebar .brand-text .sub {
            color: rgba(255,255,255,.55); font-size: .72rem;
        }

        .sidebar .nav-section {
            padding: 16px 20px 6px;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: rgba(255,255,255,.4);
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.78);
            padding: 9px 14px;
            border-radius: 10px;
            margin: 2px 10px;
            font-size: .875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background .2s, color .2s;
            text-decoration: none;
        }

        .sidebar .nav-link i { font-size: 1rem; width: 18px; flex-shrink: 0; }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,.15);
            color: white;
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,.22);
            color: white;
            font-weight: 700;
            box-shadow: inset 3px 0 0 var(--yellow-main);
        }

        /* ===== MAIN ===== */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: white;
            padding: 14px 28px;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-soft);
        }

        .topbar .page-title {
            font-weight: 700;
            font-size: .95rem;
            color: var(--text-dark);
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .topbar .user-avatar {
            width: 34px; height: 34px;
            background: var(--green-light);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--green-dark);
            font-size: 1rem;
        }

        .btn-logout {
            background: var(--red-soft);
            color: var(--red-main);
            border: 1px solid #f5c6c2;
            border-radius: 8px;
            padding: 5px 14px;
            font-size: .82rem;
            font-weight: 600;
            transition: background .2s;
        }

        .btn-logout:hover {
            background: #fbd5d2;
            color: var(--red-main);
        }

        /* ===== CONTENT ===== */
        .content-area { padding: 28px; }

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
        .stat-card {
            border-radius: 14px;
            padding: 22px;
            color: white;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 80px; height: 80px;
            background: rgba(255,255,255,.1);
            border-radius: 50%;
        }

        .stat-green  { background: linear-gradient(135deg, var(--green-dark), var(--green-mid)); }
        .stat-red    { background: linear-gradient(135deg, #a93226, var(--red-main)); }
        .stat-yellow { background: linear-gradient(135deg, #c98a10, var(--yellow-main)); }
        .stat-teal   { background: linear-gradient(135deg, #0e6b7a, #1a9aad); }

        /* ===== TABLES ===== */
        .table { font-size: .875rem; }
        .table thead th {
            background: var(--green-light);
            color: var(--green-dark);
            font-weight: 700;
            border: none;
            padding: 12px 16px;
        }
        .table tbody td { padding: 12px 16px; vertical-align: middle; border-color: var(--border-soft); }
        .table tbody tr:hover { background: #f9fcfa; }

        /* ===== BADGES ===== */
        .badge-green  { background: var(--green-light);  color: var(--green-dark);  font-weight: 600; }
        .badge-red    { background: var(--red-soft);     color: var(--red-main);    font-weight: 600; }
        .badge-yellow { background: var(--yellow-soft);  color: #9a6e0a;            font-weight: 600; }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
        }
        .btn-primary:hover { opacity: .9; color: white; }

        .btn-warning {
            background: var(--yellow-soft);
            border: 1px solid #f0d080;
            color: #9a6e0a;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-warning:hover { background: #fdefc0; color: #9a6e0a; }

        .btn-danger {
            background: var(--red-soft);
            border: 1px solid #f5c6c2;
            color: var(--red-main);
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-danger:hover { background: #fbd5d2; color: var(--red-main); }

        /* ===== ALERTS ===== */
        .alert-success {
            background: var(--green-light);
            border: 1px solid #b8dfc8;
            color: var(--green-dark);
            border-radius: 10px;
        }
        .alert-danger {
            background: var(--red-soft);
            border: 1px solid #f5c6c2;
            color: var(--red-main);
            border-radius: 10px;
        }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border: 1.5px solid var(--border-soft);
            border-radius: 8px;
            font-size: .875rem;
            padding: 9px 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(46,158,88,.12);
        }
        .form-label { font-weight: 600; font-size: .85rem; color: var(--text-dark); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
            <div class="brand-text">
                <div class="title">Rumah Bekam</div>
                <div class="sub">Panel Admin</div>
            </div>
        </div>
        <nav class="mt-2 pb-4">
            <div class="nav-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <div class="nav-section">Manajemen</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('admin.terapis.index') }}" class="nav-link {{ request()->routeIs('admin.terapis.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Terapis
            </a>
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-pulse"></i> Services
            </a>
            <a href="{{ route('admin.service-categories.index') }}" class="nav-link {{ request()->routeIs('admin.service-categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori Layanan
            </a>
            <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Locations
            </a>
            <div class="nav-section">Transaksi</div>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Bookings
            </a>
            <a href="{{ route('admin.comments.index') }}" class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Comments
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm d-md-none" style="background:var(--green-light);color:var(--green-dark);border:none;border-radius:8px;" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <span class="page-title">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="user-info">
                <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
                <span>{{ auth()->user()->username }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
