@extends('layouts.admin')
@section('title','Kelola Services')
@section('page-title','Kelola Services')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Daftar Services</h6>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Service</a>
        </div>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama service..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama Service</th><th>Terapis</th><th>Lokasi</th><th>Tanggal</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($services as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->name_service }}</td>
                        <td>{{ $s->terapis->username ?? '-' }}</td>
                        <td>{{ $s->location->name_location ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($s->date_service)->format('d M Y') }} {{ \Carbon\Carbon::parse($s->time_service)->format('H:i') }}</td>
                        <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $s->status_payment=='active'?'success':'secondary' }}">{{ ucfirst($s->status_payment) }}</span></td>
                        <td>
                            <a href="{{ route('admin.services.edit', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.services.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Hapus service ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data service</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $services->withQueryString()->links() }}</div>
</div>
@endsection
