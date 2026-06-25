@extends('layouts.admin')
@section('title', 'Detail Ruangan & Bed')
@section('page-title', 'Detail Ruangan & Bed')
@section('content')
<div class="row">
    <!-- Room details card -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0">Informasi Ruangan</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small d-block">Nama Ruangan</label>
                    <span class="fw-bold fs-5 text-success">{{ $ruangan->nama_ruangan }}</span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Gender</label>
                    @if($ruangan->gender === 'laki-laki')
                        <span class="badge bg-primary fs-6"><i class="bi bi-gender-male me-1"></i>Pria</span>
                    @elseif($ruangan->gender === 'perempuan')
                        <span class="badge bg-danger fs-6" style="background-color: #e83e8c !important;"><i class="bi bi-gender-female me-1"></i>Wanita</span>
                    @else
                        <span class="badge bg-secondary fs-6">Campur</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Jumlah Bed Aktif</label>
                    <span class="badge bg-success fs-6">{{ $ruangan->maximal }} Bed</span>
                </div>
                <div class="mb-4">
                    <label class="text-muted small d-block">Status Ruangan</label>
                    @if($ruangan->active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Nonaktif</span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.ruangans.edit', $ruangan->id) }}" class="btn btn-warning btn-sm w-100"><i class="bi bi-pencil me-1"></i>Edit Ruangan</a>
                    <a href="{{ route('admin.ruangans.index') }}" class="btn btn-secondary btn-sm w-100">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bed management list and add form -->
    <div class="col-lg-8 mb-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Kelola Bed di {{ $ruangan->nama_ruangan }}</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#addBedFormBlock">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Bed
                </button>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Collapsible form to add bed -->
            <div class="collapse p-3 border-bottom bg-light" id="addBedFormBlock">
                <form method="POST" action="{{ route('admin.beds.store') }}">
                    @csrf
                    <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama / Nomor Bed <span class="text-danger">*</span></label>
                            <input type="text" name="nama_bed" class="form-control form-control-sm" required placeholder="Contoh: Bed {{ $ruangan->nama_ruangan }}-{{ $ruangan->beds->count() + 1 }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="active" id="new_bed_active" value="1" checked>
                                <label class="form-check-label small" for="new_bed_active">Bed Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-save me-1"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Bed</th>
                            <th>Status Bed</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangan->beds as $bed)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <!-- Form to rename bed inline -->
                                <form method="POST" action="{{ route('admin.beds.update', $bed->id) }}" id="edit-form-{{ $bed->id }}" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                                    <input type="text" name="nama_bed" class="form-control form-control-sm border-0 bg-transparent fw-semibold" value="{{ $bed->nama_bed }}" style="max-width: 200px;" onchange="document.getElementById('edit-form-{{ $bed->id }}').submit()">
                                    @if($bed->active)
                                        <input type="hidden" name="active" value="1">
                                    @endif
                                </form>
                            </td>
                            <td>
                                <!-- Toggle switch for bed active status -->
                                <form method="POST" action="{{ route('admin.beds.update', $bed->id) }}" id="toggle-form-{{ $bed->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                                    <input type="hidden" name="nama_bed" value="{{ $bed->nama_bed }}">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" {{ $bed->active ? 'checked' : '' }} onchange="document.getElementById('toggle-form-{{ $bed->id }}').submit()">
                                        <label class="form-check-label small">{{ $bed->active ? 'Aktif' : 'Nonaktif' }}</label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.beds.destroy', $bed->id) }}" class="d-inline" onsubmit="return confirm('Hapus bed ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada bed di ruangan ini. Silakan tambah bed di atas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
