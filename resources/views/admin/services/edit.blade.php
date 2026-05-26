@extends('layouts.admin')
@section('title','Edit Service')
@section('page-title','Edit Service')
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header bg-white border-0 pt-4"><h6 class="fw-bold mb-0">Edit Service: {{ $service->name_service }}</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('admin.services.update', $service->id) }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label fw-semibold">Nama Service</label>
                <input type="text" name="name_service" class="form-control" value="{{ old('name_service', $service->name_service) }}" required></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="date_service" class="form-control" value="{{ old('date_service', $service->date_service->format('Y-m-d')) }}" required></div>
                <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Waktu</label>
                    <input type="time" name="time_service" class="form-control" value="{{ old('time_service', $service->time_service) }}" required></div>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}" min="0" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Terapis</label>
                <select name="id_terapis" class="form-select" required>
                    @foreach($terapis as $t)<option value="{{ $t->id }}" {{ $service->id_terapis==$t->id?'selected':'' }}>{{ $t->username }}</option>@endforeach
                </select></div>
            <div class="mb-3"><label class="form-label fw-semibold">Lokasi</label>
                <select name="id_location" class="form-select" required>
                    @foreach($locations as $l)<option value="{{ $l->id }}" {{ $service->id_location==$l->id?'selected':'' }}>{{ $l->name_location }}</option>@endforeach
                </select></div>
            <div class="mb-4"><label class="form-label fw-semibold">Status</label>
                <select name="status_payment" class="form-select">
                    <option value="active" {{ $service->status_payment=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ $service->status_payment=='inactive'?'selected':'' }}>Inactive</option>
                </select></div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
