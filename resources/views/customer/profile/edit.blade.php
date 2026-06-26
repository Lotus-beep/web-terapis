@extends('layouts.customer')
@section('title','Edit Profil')
@section('content')
<div class="py-4">
    <h4 class="fw-bold mb-4">Edit Profil</h4>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif
                    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        
                        <div class="text-center mb-4">
                            <div class="d-inline-block position-relative">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle object-fit-cover" width="100" height="100" alt="Foto Profil">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light text-secondary" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <label for="photo" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-camera me-1"></i> Ganti Foto
                                </label>
                                <input type="file" name="photo" id="photo" class="d-none" accept="image/*" onchange="this.form.submit()">
                            </div>
                            <div class="small text-muted mt-1">Format: JPG, PNG, GIF (Max 2MB)</div>
                        </div>

                        <h6 class="fw-bold mb-3 text-muted">Informasi Akun</h6>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <h6 class="fw-bold mb-3 text-muted border-top pt-3">Ganti Password <span class="text-muted fw-normal small">(opsional)</span></h6>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
