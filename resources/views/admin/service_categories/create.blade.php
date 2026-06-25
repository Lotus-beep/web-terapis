@extends('layouts.admin')
@section('title','Tambah Layanan')
@section('page-title','Tambah Layanan')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2" style="color:var(--green-mid);"></i>Form Tambah Layanan
    </div>
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.service-categories.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name') }}"
                    placeholder="contoh: Bekam Umum, Akupuntur..." required>
                <div class="form-text">Slug akan dibuat otomatis dari nama.</div>
            </div>

            {{-- Kategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="bekam"     {{ old('category') == 'bekam'     ? 'selected' : '' }}>🩸 Bekam</option>
                    <option value="non-bekam" {{ old('category') == 'non-bekam' ? 'selected' : '' }}>💆 Non Bekam</option>
                </select>
            </div>

            {{-- Judul Display --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Tampilan <small class="text-muted fw-normal">(opsional)</small></label>
                <input type="text" name="header_content" class="form-control"
                    value="{{ old('header_content') }}"
                    placeholder="contoh: Bekam Basah Premium, Fashdu Punggung">
                <div class="form-text">Jika diisi, judul ini yang tampil di halaman layanan.</div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Jelaskan layanan ini...">{{ old('description') }}</textarea>
            </div>

            {{-- Harga + Urutan + Status --}}
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', 0) }}" min="0" step="1000"
                            placeholder="150000" required>
                    </div>
                    <div class="form-text">Isi 0 jika harga "Hubungi kami".</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Urutan Tampil</label>
                    <input type="number" name="sort_order" class="form-control"
                        value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- Upload Gambar (Multiple) --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Foto Layanan
                    <small class="text-muted fw-normal">(opsional, bisa pilih beberapa sekaligus)</small>
                </label>
                <div id="dropzone" class="upload-dropzone" onclick="document.getElementById('imgInput').click()">
                    <i class="bi bi-cloud-arrow-up-fill" style="font-size:2rem;color:var(--border-soft);"></i>
                    <p class="mb-0 mt-2 text-muted" style="font-size:.85rem;">Klik atau drag foto ke sini</p>
                    <p class="mb-0 text-muted" style="font-size:.75rem;">JPG, PNG, WEBP — maks 3 MB per foto</p>
                </div>
                <input type="file" name="images[]" id="imgInput" multiple accept="image/*" class="d-none">
                <div id="previewGrid" class="preview-grid mt-3"></div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Layanan
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

@push('styles')
<style>
.upload-dropzone {
    border: 2px dashed var(--border-soft);
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.upload-dropzone:hover, .upload-dropzone.dragover {
    border-color: var(--green-mid);
    background: var(--green-light);
}
.preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 10px;
}
.preview-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 2px solid var(--border-soft);
}
.preview-item img {
    width: 100%; height: 100%;
    object-fit: cover;
}
.preview-item .remove-btn {
    position: absolute; top: 4px; right: 4px;
    background: rgba(192,57,43,.85);
    border: none; border-radius: 50%;
    color: white; width: 22px; height: 22px;
    font-size: .7rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    line-height: 1;
}
.preview-item .badge-primary {
    position: absolute; bottom: 4px; left: 4px;
    background: rgba(27,107,58,.85);
    color: white; font-size: .6rem; padding: 2px 6px; border-radius: 50px;
}
</style>
@endpush

@push('scripts')
<script>
const input   = document.getElementById('imgInput');
const grid    = document.getElementById('previewGrid');
const dropzone = document.getElementById('dropzone');

let files = []; // Array file yang dipilih

input.addEventListener('change', () => addFiles(input.files));

// Drag & drop
dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('dragover'); });
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    addFiles(e.dataTransfer.files);
});

function addFiles(newFiles) {
    for (const f of newFiles) {
        if (!f.type.startsWith('image/')) continue;
        files.push(f);
    }
    syncInput();
    renderPreviews();
}

function removeFile(idx) {
    files.splice(idx, 1);
    syncInput();
    renderPreviews();
}

function syncInput() {
    // Rebuild DataTransfer untuk sync ke input[file]
    const dt = new DataTransfer();
    files.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function renderPreviews() {
    grid.innerHTML = '';
    files.forEach((f, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="">
                ${i === 0 ? '<span class="badge-primary">Utama</span>' : ''}
                <button type="button" class="remove-btn" onclick="removeFile(${i})">
                    <i class="bi bi-x"></i>
                </button>`;
            grid.appendChild(div);
        };
        reader.readAsDataURL(f);
    });
}
</script>
@endpush

@endsection
