@extends('layouts.admin')
@section('title', 'Tambah Ruangan')
@section('page-title', 'Tambah Ruangan')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0">Form Tambah Ruangan</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.ruangans.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ruangan" class="form-control" value="{{ old('nama_ruangan') }}" required placeholder="Contoh: Ruang 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="laki-laki" {{ old('gender') === 'laki-laki' ? 'selected' : '' }}>Pria</option>
                            <option value="perempuan" {{ old('gender') === 'perempuan' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Daftar Bed Awal <span class="text-muted">(Satu nama bed per baris - Opsional)</span></label>
                        <textarea name="beds_list" class="form-control" rows="4" placeholder="Contoh:&#10;Bed 1&#10;Bed 2&#10;Bed 3">{{ old('beds_list') }}</textarea>
                        <div class="form-text text-muted">Masukkan nama-nama bed yang ingin langsung dibuat pada ruangan ini, dipisahkan per baris baru.</div>
                    </div>
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" checked>
                        <label class="form-check-label" for="active">Ruangan Aktif</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('admin.ruangans.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
