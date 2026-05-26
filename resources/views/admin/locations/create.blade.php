@extends('layouts.admin')
@section('title','Tambah Lokasi')
@section('page-title','Tambah Lokasi')
@section('content')
<div class="row justify-content-center"><div class="col-lg-5">
<div class="card">
    <div class="card-header bg-white border-0 pt-4"><h6 class="fw-bold mb-0">Form Tambah Lokasi</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('admin.locations.store') }}">
            @csrf
            <div class="mb-4"><label class="form-label fw-semibold">Nama Lokasi <span class="text-danger">*</span></label>
                <input type="text" name="name_location" class="form-control" value="{{ old('name_location') }}" required placeholder="Contoh: Cabang Utama - Jakarta Pusat"></div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
