@extends('layouts.admin')
@section('title', 'Kelola Ruangan')
@section('page-title', 'Kelola Ruangan')
@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Daftar Ruangan</h6>
                    <a href="{{ route('admin.ruangans.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Ruangan</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Ruangan</th>
                            <th>Gender</th>
                            <th>Jumlah Bed Aktif</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangans as $ruangan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                             <td><strong><a href="{{ route('admin.ruangans.show', $ruangan->id) }}" class="text-decoration-none text-success">{{ $ruangan->nama_ruangan }}</a></strong></td>
                            <td>
                                @if($ruangan->gender === 'laki-laki')
                                    <span class="badge bg-primary"><i class="bi bi-gender-male me-1"></i>Pria</span>
                                @elseif($ruangan->gender === 'perempuan')
                                    <span class="badge bg-danger" style="background-color: #e83e8c !important;"><i class="bi bi-gender-female me-1"></i>Wanita</span>
                                @else
                                    <span class="badge bg-secondary">Campur</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $ruangan->maximal }} Bed</span>
                            </td>
                            <td>
                                @if($ruangan->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.ruangans.show', $ruangan->id) }}" class="btn btn-sm btn-outline-info" title="Kelola Bed"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.ruangans.edit', $ruangan->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.ruangans.destroy', $ruangan->id) }}" class="d-inline" onsubmit="return confirm('Hapus ruangan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data ruangan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $ruangans->links() }}</div>
        </div>
    </div>
</div>
@endsection
