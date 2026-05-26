@extends('layouts.admin')
@section('title','Tambah Service')
@section('page-title','Tambah Service')
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header bg-white border-0 pt-4"><h6 class="fw-bold mb-0">Form Tambah Service</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            <div class="mb-3"><label class="form-label fw-semibold">Nama Service <span class="text-danger">*</span></label>
                <input type="text" name="name_service" class="form-control" value="{{ old('name_service') }}" required></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="date_service" class="form-control" value="{{ old('date_service') }}" required></div>
                <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Waktu <span class="text-danger">*</span></label>
                    <input type="time" name="time_service" class="form-control" value="{{ old('time_service') }}" required></div>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Terapis <span class="text-danger">*</span></label>
                <select name="id_terapis" class="form-select" required>
                    <option value="">-- Pilih Terapis --</option>
                    @foreach($terapis as $t)<option value="{{ $t->id }}" {{ old('id_terapis')==$t->id?'selected':'' }}>{{ $t->username }}</option>@endforeach
                </select></div>
            <div class="mb-3"><label class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                <select name="id_location" class="form-select" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($locations as $l)<option value="{{ $l->id }}" {{ old('id_location')==$l->id?'selected':'' }}>{{ $l->name_location }}</option>@endforeach
                </select></div>
            <div class="mb-4"><label class="form-label fw-semibold">Status</label>
                <select name="status_payment" class="form-select">
                    <option value="active" {{ old('status_payment','active')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status_payment')=='inactive'?'selected':'' }}>Inactive</option>
                </select></div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
