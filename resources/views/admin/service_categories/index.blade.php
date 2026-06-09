@extends('layouts.admin')
@section('title','Kategori Layanan')
@section('page-title','Kategori Layanan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0" style="font-size:.875rem;">Kelola jenis-jenis layanan yang tersedia</p>
    </div>
    <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="row g-3">
    @forelse($categories as $cat)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100" style="border-radius:14px;overflow:hidden;transition:transform .2s,box-shadow .2s;"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-md)'"
             onmouseout="this.style.transform='';this.style.boxShadow=''">

            {{-- Gambar kategori --}}
            <div style="height:140px;overflow:hidden;position:relative;">
                <img src="{{ asset($cat->display_image) }}" alt="{{ $cat->name }}"
                    style="width:100%;height:100%;object-fit:cover;">
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(27,107,58,.6),transparent 50%);"></div>
                <div style="position:absolute;bottom:10px;left:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:32px;height:32px;background:rgba(255,255,255,.18);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi {{ $cat->icon }}" style="color:white;font-size:1rem;"></i>
                    </span>
                    <span style="color:white;font-weight:700;font-size:.9rem;">{{ $cat->name }}</span>
                </div>
                @if(!$cat->is_active)
                    <span style="position:absolute;top:10px;right:10px;background:rgba(192,57,43,.85);color:white;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:50px;">
                        Nonaktif
                    </span>
                @endif
            </div>

            <div class="card-body p-3">
                @if($cat->description)
                    <p class="text-muted mb-2" style="font-size:.8rem;line-height:1.5;">
                        {{ Str::limit($cat->description, 80) }}
                    </p>
                @endif

                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:.75rem;color:var(--text-muted);">
                        <i class="bi bi-clipboard2-pulse me-1" style="color:var(--green-mid);"></i>
                        {{ $cat->services()->count() }} layanan
                        &nbsp;|&nbsp;
                        <span style="color:var(--text-muted);">Urutan: {{ $cat->sort_order }}</span>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.service-categories.edit', $cat->id) }}"
                            class="btn btn-sm btn-warning" style="border-radius:6px;padding:4px 10px;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.service-categories.destroy', $cat->id) }}"
                            onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius:6px;padding:4px 10px;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-tags" style="font-size:3rem;color:var(--border-soft);"></i>
        <p class="text-muted mt-3">Belum ada kategori layanan</p>
        <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary mt-2">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori Pertama
        </a>
    </div>
    @endforelse
</div>

@endsection
