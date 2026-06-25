@extends('layouts.admin')
@section('title', 'Edit Ruangan & Bed')
@section('page-title', 'Edit Ruangan & Bed')
@section('content')
<div class="row">
    <!-- Room edit card (Left Column) -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0">Form Edit Ruangan</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.ruangans.update', $ruangan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ruangan" class="form-control" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="laki-laki" {{ old('gender', $ruangan->gender) === 'laki-laki' ? 'selected' : '' }}>Pria</option>
                            <option value="perempuan" {{ old('gender', $ruangan->gender) === 'perempuan' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $ruangan->active ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Ruangan Aktif</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('admin.ruangans.index') }}" class="btn btn-secondary btn-sm w-100">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bed management list and add form (Right Column) -->
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
