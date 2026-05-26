@extends('layouts.admin')
@section('title','Edit Terapis')
@section('page-title','Edit Terapis')
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header bg-white border-0 pt-4"><h6 class="fw-bold mb-0">Edit Terapis: {{ $terapi->username }}</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('admin.terapis.update', $terapi->id) }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label fw-semibold">Nama</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $terapi->username) }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $terapi->email) }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $terapi->no_telepon) }}"></div>
            <div class="mb-3"><label class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $terapi->alamat) }}</textarea></div>
            <div class="mb-3"><label class="form-label fw-semibold">Password Baru <span class="text-muted small">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="form-control"></div>
            <div class="mb-4"><label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control"></div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="{{ route('admin.terapis.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
