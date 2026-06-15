@extends('layouts.admin')
@section('title','Edit Kategori')
@section('page-title','Edit Kategori Layanan')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2" style="color:var(--yellow-main);"></i>Edit Kategori: <strong>{{ $serviceCategory->name }}</strong>
    </div>
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.service-categories.update', $serviceCategory->id) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $serviceCategory->name) }}" required>
                <div style="font-size:.75rem;color:var(--text-muted);margin-top:4px;">
                    Slug saat ini: <code>{{ $serviceCategory->slug }}</code>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Kategori <span class="text-danger">*</span></label>
                <input type="text" name="header_content" class="form-control"
                    value="{{ old('name', $serviceCategory->header_content) }}" required>
                <div style="font-size:.75rem;color:var(--text-muted);margin-top:4px;">
                    Slug saat ini: <code>{{ $serviceCategory->slug }}</code>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $serviceCategory->description) }}</textarea>
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
                            <i class="bi {{ old('icon', $serviceCategory->icon) }}" style="font-size:1.1rem;color:var(--green-mid);"></i>
                        </span>
                        <input type="text" name="icon" id="iconInput" class="form-control"
                            value="{{ old('icon', $serviceCategory->icon) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" class="form-control"
                        value="{{ old('sort_order', $serviceCategory->sort_order) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $serviceCategory->is_active ? '1':'0') == '1' ? 'selected':'' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $serviceCategory->is_active ? '1':'0') == '0' ? 'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Foto Kategori
                    <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small>
                </label>
                <div class="mb-2">
                    <img src="{{ asset($serviceCategory->display_image) }}" alt="{{ $serviceCategory->name }}"
                        id="currentImg"
                        style="height:110px;border-radius:10px;object-fit:cover;">
                    <small class="d-block text-muted mt-1">Foto saat ini</small>
                </div>
                <input type="file" name="image" id="imgInput" class="form-control" accept="image/*">
                <div id="imgPreviewWrap" class="mt-2 d-none">
                    <img id="imgPreview" src="" alt="Preview"
                        style="height:110px;border-radius:10px;object-fit:cover;">
                    <small class="d-block text-muted mt-1">Preview foto baru</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
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
    document.getElementById('iconInput').addEventListener('input', function() {
        document.getElementById('iconPreview').innerHTML =
            '<i class="bi ' + this.value + '" style="font-size:1.1rem;color:var(--green-mid);"></i>';
    });

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
