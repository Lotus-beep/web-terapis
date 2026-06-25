@extends('layouts.admin')
@section('title', 'Edit Bed')
@section('page-title', 'Edit Bed')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0">Form Edit Bed</h6>
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
                <form method="POST" action="{{ route('admin.beds.update', $bed->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama / Nomor Bed <span class="text-danger">*</span></label>
                        <input type="text" name="nama_bed" class="form-control" value="{{ old('nama_bed', $bed->nama_bed) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select name="id_ruangan" class="form-select" required>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ old('id_ruangan', $bed->id_ruangan) == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }} ({{ $ruangan->gender === 'laki-laki' ? 'Pria' : 'Wanita' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $bed->active ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Bed Aktif</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
                        <a href="{{ route('admin.beds.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
