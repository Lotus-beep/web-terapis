@extends('layouts.admin')
@section('title','Kelola Lokasi')
@section('page-title','Kelola Lokasi')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Daftar Lokasi</h6>
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Lokasi</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Nama Lokasi</th><th>Jumlah Service</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $loc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loc->name_location }}</td>
                            <td><span class="badge bg-info">{{ $loc->services_count }}</span></td>
                            <td>
                                <a href="{{ route('admin.locations.edit', $loc->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.locations.destroy', $loc->id) }}" class="d-inline" onsubmit="return confirm('Hapus lokasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada data lokasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $locations->links() }}</div>
        </div>
    </div>
</div>
@endsection
