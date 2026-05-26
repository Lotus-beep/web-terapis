<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="text-center">
        <i class="bi bi-search text-muted" style="font-size:80px"></i>
        <h1 class="display-4 fw-bold text-muted mt-3">404</h1>
        <h4 class="fw-bold mb-3">Halaman Tidak Ditemukan</h4>
        <p class="text-muted mb-4">Halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <a href="{{ url('/') }}" class="btn btn-primary"><i class="bi bi-house me-2"></i>Kembali ke Beranda</a>
    </div>
</body>
</html>
