@extends('layouts.admin')
@section('title','Edit Layanan')
@section('page-title','Edit Layanan')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2" style="color:var(--yellow-main);"></i>Edit Layanan: <strong>{{ $serviceCategory->name }}</strong>
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

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $serviceCategory->name) }}" required>
                <div class="form-text">Slug saat ini: <code>{{ $serviceCategory->slug }}</code></div>
            </div>

            {{-- Kategori --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="bekam"     {{ old('category', $serviceCategory->category) == 'bekam'     ? 'selected' : '' }}>🩸 Bekam</option>
                    <option value="non-bekam" {{ old('category', $serviceCategory->category) == 'non-bekam' ? 'selected' : '' }}>💆 Non Bekam</option>
                </select>
            </div>

            {{-- Judul Display --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Tampilan <small class="text-muted fw-normal">(opsional)</small></label>
                <input type="text" name="header_content" class="form-control"
                    value="{{ old('header_content', $serviceCategory->header_content) }}"
                    placeholder="contoh: Bekam Basah Premium, Fashdu Punggung">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $serviceCategory->description) }}</textarea>
            </div>

            {{-- Harga + Urutan + Status --}}
            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $serviceCategory->price) }}" min="0" step="1000" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Urutan Tampil</label>
                    <input type="number" name="sort_order" class="form-control"
                        value="{{ old('sort_order', $serviceCategory->sort_order) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $serviceCategory->is_active ? '1':'0') == '1' ? 'selected':'' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $serviceCategory->is_active ? '1':'0') == '0' ? 'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- ===== GALERI FOTO SAAT INI ===== --}}
            @if($serviceCategory->images->count())
            <div class="mb-4">
                <label class="form-label fw-semibold">Foto Saat Ini</label>
                <div class="existing-grid">
                    @foreach($serviceCategory->images as $img)
                    <div class="existing-item" id="img-{{ $img->id }}">
                        <img src="{{ asset('storage/' . $img->path) }}" alt="Foto layanan">
                        @if($loop->first)
                            <span class="badge-primary-lbl">Utama</span>
                        @endif
                        <button type="button"
                            class="del-existing-btn"
                            data-id="{{ $img->id }}"
                            data-url="{{ route('admin.service-images.destroy', $img->id) }}"
                            title="Hapus foto ini">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="form-text">Klik <i class="bi bi-trash-fill text-danger"></i> untuk menghapus foto. Perubahan langsung tersimpan.</div>
            </div>
            @else
            <div class="mb-3">
                <p class="text-muted" style="font-size:.85rem;"><i class="bi bi-image me-1"></i>Belum ada foto untuk layanan ini.</p>
            </div>
            @endif

            {{-- ===== UPLOAD FOTO BARU ===== --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Tambah Foto Baru
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

@push('styles')
<style>
.upload-dropzone {
    border: 2px dashed var(--border-soft);
    border-radius: 12px;
    padding: 28px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.upload-dropzone:hover, .upload-dropzone.dragover {
    border-color: var(--green-mid);
    background: var(--green-light);
}
/* Grid foto yang sudah ada */
.existing-grid, .preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 10px;
}
.existing-item, .preview-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 2px solid var(--border-soft);
    background: #f0f0f0;
}
.existing-item img, .preview-item img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.del-existing-btn, .remove-btn {
    position: absolute; top: 4px; right: 4px;
    background: rgba(192,57,43,.9);
    border: none; border-radius: 50%;
    color: white; width: 26px; height: 26px;
    font-size: .75rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: transform .15s;
}
.del-existing-btn:hover, .remove-btn:hover { transform: scale(1.15); }
.badge-primary-lbl {
    position: absolute; bottom: 4px; left: 4px;
    background: rgba(27,107,58,.85);
    color: white; font-size: .6rem; padding: 2px 6px; border-radius: 50px;
    font-weight: 700;
}
/* Dimmed saat dihapus */
.existing-item.deleting { opacity: .4; pointer-events: none; }
</style>
@endpush

@push('scripts')
<script>
/* ====== Hapus foto yang sudah ada (AJAX) ====== */
document.querySelectorAll('.del-existing-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id  = this.dataset.id;
        const url = this.dataset.url;
        const item = document.getElementById('img-' + id);
        if (!confirm('Hapus foto ini?')) return;
        item.classList.add('deleting');

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                item.remove();
            } else {
                item.classList.remove('deleting');
                alert('Gagal menghapus foto.');
            }
        })
        .catch(() => {
            item.classList.remove('deleting');
            alert('Terjadi kesalahan koneksi.');
        });
    });
});

/* ====== Upload foto baru dengan preview ====== */
const input    = document.getElementById('imgInput');
const grid     = document.getElementById('previewGrid');
const dropzone = document.getElementById('dropzone');
let files = [];

input.addEventListener('change', () => addFiles(input.files));
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
