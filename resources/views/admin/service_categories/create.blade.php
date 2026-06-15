@extends('layouts.admin')
@section('title','Tambah Kategori')
@section('page-title','Tambah Kategori Layanan')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2" style="color:var(--green-mid);"></i>Form Tambah Kategori
    </div>
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.service-categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name') }}"
                    placeholder="contoh: Bekam Umum, Akupuntur..." required>
                <div style="font-size:.75rem;color:var(--text-muted);margin-top:4px;">
                    Slug akan dibuat otomatis dari nama.
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Judul Layanan <small class="text-muted">(header_content)</small>
                </label>
                <input type="text" name="header_content" class="form-control"
                    value="{{ old('header_content') }}"
                    placeholder="contoh: Bekam Basah, Fashdu Punggung, Akupuntur Relaksasi">
                <div style="font-size:.75rem;color:var(--text-muted);margin-top:4px;">
                    Judul spesifik yang tampil di halaman layanan, misal: "Bekam Basah Premium".
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Jelaskan kategori layanan ini...">{{ old('description') }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        Icon Bootstrap
                        <a href="https://icons.getbootstrap.com/" target="_blank"
                            style="font-size:.75rem;color:var(--green-mid);margin-left:6px;">
                            Lihat daftar icon <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" id="iconPreview" style="min-width:42px;justify-content:center;">
                            <i class="bi bi-heart-pulse-fill" style="font-size:1.1rem;color:var(--green-mid);"></i>
                        </span>
                        <input type="text" name="icon" id="iconInput" class="form-control"
                            value="{{ old('icon', 'bi-heart-pulse-fill') }}"
                            placeholder="bi-heart-pulse-fill">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" class="form-control"
                        value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Foto Kategori
                    <small class="text-muted">(Opsional — jika kosong, foto default dipakai)</small>
                </label>
                <input type="file" name="image" id="imgInput" class="form-control" accept="image/*">
                <div id="imgPreviewWrap" class="mt-2 d-none">
                    <img id="imgPreview" src="" alt="Preview"
                        style="height:120px;border-radius:10px;object-fit:cover;">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Kategori
                </button>
                <a href="{{ route('admin.service-categories.index') }}"
                    class="btn" style="background:var(--border-soft);color:var(--text-muted);border-radius:8px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

@push('scripts')
<script>
    // Preview icon
    document.getElementById('iconInput').addEventListener('input', function() {
        const preview = document.getElementById('iconPreview');
        preview.innerHTML = '<i class="bi ' + this.value + '" style="font-size:1.1rem;color:var(--green-mid);"></i>';
    });

    // Preview image
    document.getElementById('imgInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            document.getElementById('imgPreview').src = URL.createObjectURL(file);
            document.getElementById('imgPreviewWrap').classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
