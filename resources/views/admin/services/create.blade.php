@extends('layouts.admin')
@section('title','Tambah Layanan')
@section('page-title','Tambah Layanan')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card">
    <div class="card-header"><i class="bi bi-plus-circle me-2" style="color:var(--green-mid);"></i>Form Tambah Layanan</div>
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger mb-4"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                    <input type="text" name="name_service" class="form-control" value="{{ old('name_service') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis / Kategori</label>
                    <select name="id_category" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('id_category')==$cat->id?'selected':'' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Terapis <span class="text-danger">*</span></label>
                    <select name="id_terapis" class="form-select" required>
                        <option value="">-- Pilih Terapis --</option>
                        @foreach($terapis as $t)
                            <option value="{{ $t->id }}" {{ old('id_terapis')==$t->id?'selected':'' }}>
                                {{ $t->username }} {{ $t->gender ? '('.ucfirst($t->gender).')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <select name="id_location" class="form-select" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($locations as $l)
                            <option value="{{ $l->id }}" {{ old('id_location')==$l->id?'selected':'' }}>{{ $l->name_location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi Layanan</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Jelaskan layanan ini secara singkat...">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Foto Layanan <small class="text-muted">(Opsional — jika tidak diisi, foto default kategori akan dipakai)</small></label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="imgInput">
                    <div id="imgPreviewWrap" class="mt-2 d-none">
                        <img id="imgPreview" src="" alt="Preview" style="height:140px;border-radius:10px;object-fit:cover;">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Layanan</button>
                <a href="{{ route('admin.services.index') }}" class="btn" style="background:var(--border-soft);color:var(--text-muted);border-radius:8px;">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>

@push('scripts')
<script>
    document.getElementById('imgInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const wrap = document.getElementById('imgPreviewWrap');
            const img  = document.getElementById('imgPreview');
            img.src = URL.createObjectURL(file);
            wrap.classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
