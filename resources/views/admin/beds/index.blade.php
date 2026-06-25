@extends('layouts.admin')
@section('title', 'Kelola Bed')
@section('page-title', 'Kelola Bed')
@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Daftar Bed</h6>
                    <a href="{{ route('admin.beds.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Bed</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama / Nomor Bed</th>
                            <th>Ruangan</th>
                            <th>Gender Ruangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beds as $bed)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $bed->nama_bed }}</strong></td>
                            <td>{{ $bed->ruangan->nama_ruangan ?? '-' }}</td>
                            <td>
                                @if($bed->ruangan)
                                    @if($bed->ruangan->gender === 'laki-laki')
                                        <span class="badge bg-primary"><i class="bi bi-gender-male me-1"></i>Pria</span>
                                    @elseif($bed->ruangan->gender === 'perempuan')
                                        <span class="badge bg-danger" style="background-color: #e83e8c !important;"><i class="bi bi-gender-female me-1"></i>Wanita</span>
                                    @else
                                        <span class="badge bg-secondary">Campur</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($bed->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.beds.edit', $bed->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.beds.destroy', $bed->id) }}" class="d-inline" onsubmit="return confirm('Hapus bed ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data bed</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $beds->links() }}</div>
        </div>
    </div>
</div>
@endsection
