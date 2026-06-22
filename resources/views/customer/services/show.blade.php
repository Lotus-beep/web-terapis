@extends('layouts.customer')
@section('title', $service->header_content ?: $service->name)
@section('content')

<div class="py-4">
    <a href="{{ route('customer.services.index') }}"
        class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
        style="color:var(--text-muted);font-size:.875rem;font-weight:600;">
        <i class="bi bi-arrow-left"></i> Kembali ke Layanan
    </a>

    <div class="row g-4">
        {{-- Gambar Layanan --}}
        <div class="col-lg-5">
            <div style="border-radius:16px;overflow:hidden;box-shadow:var(--shadow-md);">
                <img src="{{ asset($service->display_image) }}" alt="{{ $service->name }}"
                    style="width:100%;height:340px;object-fit:cover;">
            </div>
        </div>

        {{-- Detail --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-body p-4 d-flex flex-column">

                    {{-- Badge kategori + status --}}
                    <div class="d-flex align-items-center gap-2 mb-2">
                        @if($service->icon)
                        <span style="background:var(--green-light);color:var(--green-dark);font-size:.75rem;font-weight:700;padding:3px 12px;border-radius:50px;">
                            <i class="bi {{ $service->icon }} me-1"></i>{{ $service->name }}
                        </span>
                        @endif
                        @if($service->is_active)
                            <span style="background:#e8f5ee;color:#1b6b3a;font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                                <i class="bi bi-circle-fill me-1" style="font-size:.45rem;"></i>Tersedia
                            </span>
                        @else
                            <span style="background:#fee2e2;color:#991b1b;font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                                <i class="bi bi-circle-fill me-1" style="font-size:.45rem;"></i>Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h3 class="fw-bold mb-2" style="font-size:1.4rem;">
                        {{ $service->header_content ?: $service->name }}
                    </h3>

                    {{-- Harga --}}
                    <div class="mb-3" style="font-size:1.6rem;font-weight:800;color:var(--green-dark);">
                        @if($service->price)
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        @else
                            <span style="font-size:1rem;color:var(--text-muted);">Hubungi kami</span>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    @if($service->description)
                        <p style="color:var(--text-muted);line-height:1.7;font-size:.9rem;margin-bottom:20px;">
                            {{ $service->description }}
                        </p>
                    @endif

                    {{-- Info Lokasi --}}
                    <div class="p-3 mb-4"
                        style="background:var(--bg-page);border-radius:12px;border:1px solid var(--border-soft);">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt-fill" style="color:var(--red-main);"></i>
                                <span style="font-size:.875rem;">Lokasi ditentukan oleh admin saat konfirmasi booking</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-patch-check-fill" style="color:var(--green-mid);"></i>
                                <span style="font-size:.875rem;">Terapis bersertifikat — ditentukan admin</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock" style="color:var(--green-mid);"></i>
                                <span style="font-size:.875rem;">Buka 08.00 – 17.00 WIB</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Booking --}}
                    <div class="mt-auto">
                        @if($service->is_active)
                            <a href="{{ route('customer.bookings.create', ['service_id' => $service->id]) }}"
                                class="btn w-100 py-3"
                                style="background:linear-gradient(135deg,var(--green-dark),var(--green-mid));color:white;border:none;border-radius:12px;font-weight:700;font-size:1rem;">
                                <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                            </a>
                        @else
                            <button class="btn w-100 py-3" disabled
                                style="background:#e5e7eb;color:#9ca3af;border:none;border-radius:12px;font-weight:700;font-size:1rem;">
                                <i class="bi bi-x-circle me-2"></i>Layanan Tidak Tersedia
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
