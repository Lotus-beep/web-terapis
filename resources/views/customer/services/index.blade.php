@extends('layouts.customer')
@section('title','Layanan')
@section('content')

<div class="py-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Jenis Layanan</h4>
        <p class="text-muted mb-0" style="font-size:.875rem;">Pilih layanan yang sesuai kebutuhan Anda</p>
    </div>

    {{-- Filter Category --}}
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('customer.services.index') }}"
            class="filter-tag {{ !request('category') ? 'active' : '' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('customer.services.index', ['category' => $cat->id]) }}"
                class="filter-tag {{ request('category') == $cat->id ? 'active' : '' }}">
                <i class="bi {{ $cat->icon }} me-1"></i>{{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="row g-4">
        @forelse($services as $service)
        <div class="col-md-6 col-lg-4">
            <div class="service-card-new">
                {{-- Category badge --}}
                <div class="cat-badge">
                    <i class="bi {{ $service->icon }} me-1"></i>{{ $service->name }}
                </div>

                {{-- Image --}}
                <div class="svc-img-wrap">
                    <img src="{{ asset($service->display_image) }}" alt="{{ $service->header_content ?? $service->name }}">
                    <div class="svc-img-overlay">
                        <i class="bi {{ $service->icon }}"></i>
                    </div>
                </div>

                {{-- Body --}}
                <div class="svc-body">
                    {{-- Judul dari header_content --}}
                    <h5 class="svc-title">
                        {{ $service->header_content ?: $service->name }}
                    </h5>

                    {{-- Deskripsi dari description --}}
                    @if($service->description)
                        <p class="svc-desc">{{ Str::limit($service->description, 100) }}</p>
                    @endif

                    <div class="svc-meta">
                        <div>
                            <i class="bi bi-patch-check-fill" style="color:var(--green-mid);"></i>
                            Terapis Bersertifikat
                        </div>
                        <div>
                            <i class="bi bi-geo-alt-fill" style="color:var(--red-main);"></i>
                            Rawa Belong, Jakbar
                        </div>
                    </div>

                    <div class="svc-footer">
                        <div class="svc-price">
                            @if($service->price)
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            @else
                                <span style="font-size:.8rem;color:var(--text-muted);">Hubungi kami</span>
                            @endif
                        </div>
                        <a href="{{ route('customer.services.show', $service->id) }}" class="btn-book-svc">
                            Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-clipboard-x" style="font-size:3rem;color:var(--border-soft);"></i>
            <p class="text-muted mt-3">Belum ada layanan tersedia</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $services->withQueryString()->links() }}</div>
</div>

@push('styles')
<style>
    .filter-tag {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 600;
        background: white;
        border: 1.5px solid var(--border-soft);
        color: var(--text-muted);
        text-decoration: none;
        transition: all .2s;
    }
    .filter-tag:hover, .filter-tag.active {
        background: var(--green-light);
        border-color: var(--green-mid);
        color: var(--green-dark);
    }

    .service-card-new {
        background: white;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        overflow: hidden;
        transition: transform .3s, box-shadow .3s;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .service-card-new:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }

    .cat-badge {
        position: absolute;
        top: 12px; left: 12px;
        background: var(--green-dark);
        color: white;
        font-size: .68rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 50px;
        z-index: 2;
    }

    .svc-img-wrap { position: relative; height: 200px; overflow: hidden; }
    .svc-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s; }
    .service-card-new:hover .svc-img-wrap img { transform: scale(1.07); }

    .svc-img-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(27,107,58,.5) 0%, transparent 60%);
        display: flex; align-items: flex-end; justify-content: flex-end; padding: 12px;
    }
    .svc-img-overlay i { font-size: 1.8rem; color: rgba(255,255,255,.8); }

    .svc-body { padding: 16px 18px 18px; display: flex; flex-direction: column; flex: 1; }
    .svc-title { font-size: .97rem; font-weight: 700; margin-bottom: 6px; color: var(--text-dark); }
    .svc-desc { font-size: .8rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 10px; flex: 1; }

    .svc-meta {
        display: flex; gap: 14px; font-size: .78rem; color: var(--text-muted);
        margin-bottom: 14px; padding-top: 10px; border-top: 1px solid var(--border-soft);
    }
    .svc-footer { display: flex; align-items: center; justify-content: space-between; }
    .svc-price { font-size: 1.05rem; font-weight: 800; color: var(--green-dark); }

    .btn-book-svc {
        display: inline-flex; align-items: center;
        background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
        color: white; border: none; border-radius: 50px;
        padding: 7px 18px; font-size: .8rem; font-weight: 700;
        text-decoration: none; transition: opacity .2s;
    }
    .btn-book-svc:hover { opacity: .9; color: white; }
</style>
@endpush

@endsection
