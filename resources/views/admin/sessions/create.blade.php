@extends('layouts.admin')
@section('title', 'Tambah Master Sesi')
@section('page-title', 'Tambah Master Sesi')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0">Form Tambah Master Sesi Waktu</h6>
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
                <form method="POST" action="{{ route('admin.sessions.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Sesi (Opsional)</label>
                        <input type="text" name="nama_sesi" class="form-control @error('nama_sesi') is-invalid @enderror" value="{{ old('nama_sesi') }}" placeholder="Contoh: Sesi 1 atau Sesi Sore">
                        <div class="form-text">Dapat dikosongkan. Sistem akan melabeli secara urut jika kosong.</div>
                        @error('nama_sesi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="text" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}" required placeholder="Contoh: 08:00" maxlength="5">
                            @error('jam_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="text" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}" required placeholder="Contoh: 09:30" maxlength="5">
                            @error('jam_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" checked>
                        <label class="form-check-label" for="active">Sesi Aktif (Berlaku bagi pendaftaran customer)</label>
                    </div>

                    <div class="alert bg-light border p-3 mb-4 text-muted small">
                        <i class="bi bi-info-circle-fill text-success me-1"></i>
                        Sesi baru ini akan otomatis muncul pada date picker boking customer untuk seluruh ruangan aktif setiap harinya (kecuali hari libur).
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
