@extends('layouts.admin')
@section('title','Kelola Terapis')
@section('page-title','Kelola Terapis')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Daftar Terapis</h6>
            <a href="{{ route('admin.terapis.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Terapis</a>
        </div>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama/email..." value="{{ request('search') }}">
            </div>
            <div class="col-auto"><button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama</th><th>Email</th><th>No. Telepon</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($terapis as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->username }}</td>
                        <td>{{ $t->email }}</td>
                        <td>{{ $t->no_telepon ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.terapis.edit', $t->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.terapis.destroy', $t->id) }}" class="d-inline" onsubmit="return confirm('Hapus terapis ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data terapis</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $terapis->withQueryString()->links() }}</div>
</div>
@endsection
