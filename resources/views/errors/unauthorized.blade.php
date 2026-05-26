<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="text-center">
        <i class="bi bi-shield-x text-danger" style="font-size:80px"></i>
        <h1 class="display-4 fw-bold text-danger mt-3">403</h1>
        <h4 class="fw-bold mb-3">Akses Ditolak</h4>
        <p class="text-muted mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="btn btn-primary me-2"><i class="bi bi-house me-2"></i>Beranda</a>
        <a href="{{ route('login') }}" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
    </div>
</body>
</html>
