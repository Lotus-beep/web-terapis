@extends('layouts.customer')
@section('title','Layanan')
@section('content')

<div class="py-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Jenis Layanan</h4>
        <p class="text-muted mb-0" style="font-size:.875rem;">Pilih layanan yang sesuai kebutuhan Anda</p>
    </div>

    {{-- Filter Kategori --}}
    <div class="filter-bar mb-4">
        <a href="{{ route('customer.services.index') }}"
           class="filter-btn {{ is_null($filter) ? 'active' : '' }}">
            <i class="bi bi-grid-fill me-1"></i> Semua
        </a>
        <a href="{{ route('customer.services.index', ['kategori' => 'bekam']) }}"
           class="filter-btn bekam {{ $filter === 'bekam' ? 'active' : '' }}">
            <i class="bi bi-droplet-fill me-1"></i> Bekam
        </a>
        <a href="{{ route('customer.services.index', ['kategori' => 'non-bekam']) }}"
           class="filter-btn non-bekam {{ $filter === 'non-bekam' ? 'active' : '' }}">
            <i class="bi bi-activity me-1"></i> Non Bekam
        </a>

        @if(!is_null($filter))
        <span class="filter-count ms-auto">
            {{ $services->count() }} layanan ditemukan
        </span>
        @endif
    </div>

    {{-- Grid Layanan --}}
    @if($services->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-clipboard-x" style="font-size:3rem;color:var(--border-soft);"></i>
            <p class="text-muted mt-3">Tidak ada layanan dalam kategori ini</p>
            <a href="{{ route('customer.services.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                Lihat Semua Layanan
            </a>
        </div>
    @else
        <div class="row g-4" id="servicesGrid">
            @foreach($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="service-card-new">

                    {{-- Badge Kategori --}}
                    @php
                        $isBeam = $service->category === 'bekam';
                        $badgeBg    = $isBeam ? '#1b6b3a' : '#2563eb';
                        $badgeIcon  = $isBeam ? 'bi-droplet-fill' : 'bi-activity';
                        $badgeLabel = $isBeam ? 'Bekam' : 'Non Bekam';
                    @endphp
                    <span class="cat-badge" style="background:{{ $badgeBg }};">
                        <i class="bi {{ $badgeIcon }} me-1" style="font-size:.6rem;"></i>{{ $badgeLabel }}
                    </span>

                    {{-- Gambar --}}
                    <div class="svc-img-wrap">
                        <img src="{{ $service->display_image }}"
                             alt="{{ $service->header_content ?? $service->name }}">
                        <div class="svc-img-overlay">
                            <i class="bi {{ $service->icon }}"></i>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="svc-body">
                        <h5 class="svc-title">{{ $service->header_content ?: $service->name }}</h5>

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
                                @if($service->price > 0)
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
            @endforeach
        </div>
    @endif

</div>

@push('styles')
<style>
    /* ===== Filter Bar ===== */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--border-soft);
        background: white;
        color: var(--text-muted);
        transition: all .2s;
    }
    .filter-btn:hover {
        border-color: var(--green-mid);
        color: var(--green-dark);
        background: var(--green-light);
    }
    /* Semua - active */
    .filter-btn.active {
        background: var(--green-dark);
        border-color: var(--green-dark);
        color: white;
        box-shadow: 0 4px 12px rgba(27,107,58,.25);
    }
    /* Bekam - active */
    .filter-btn.bekam.active {
        background: #1b6b3a;
        border-color: #1b6b3a;
        color: white;
        box-shadow: 0 4px 12px rgba(27,107,58,.3);
    }
    /* Non Bekam - active */
    .filter-btn.non-bekam.active {
        background: #2563eb;
        border-color: #2563eb;
        color: white;
        box-shadow: 0 4px 12px rgba(37,99,235,.3);
    }

    .filter-count {
        font-size: .78rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* ===== Service Cards ===== */
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
    .service-card-new:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .cat-badge {
        position: absolute;
        top: 12px; left: 12px;
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
