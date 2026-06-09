@extends('layouts.customer')
@section('title', $service->name_service)
@section('content')

<div class="py-4">
    <a href="{{ route('customer.services.index') }}" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
        style="color:var(--text-muted);font-size:.875rem;font-weight:600;">
        <i class="bi bi-arrow-left"></i> Kembali ke Layanan
    </a>

    <div class="row g-4">
        <!-- Gambar Layanan -->
        <div class="col-lg-5">
            <div style="border-radius:16px;overflow:hidden;box-shadow:var(--shadow-md);">
                <img src="{{ asset($service->category_image) }}" alt="{{ $service->name_service }}"
                    style="width:100%;height:340px;object-fit:cover;">
            </div>
        </div>

        <!-- Detail -->
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="background:var(--green-light);color:var(--green-dark);font-size:.75rem;font-weight:700;padding:3px 12px;border-radius:50px;">
                            {{ $service->category_label }}
                        </span>
                        @if($service->is_active)
                            <span style="background:#e8f5ee;color:#1b6b3a;font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                                <i class="bi bi-circle-fill me-1" style="font-size:.45rem;"></i>Tersedia
                            </span>
                        @endif
                    </div>

                    <h3 class="fw-800 mb-2" style="font-weight:800;">{{ $service->name_service }}</h3>

                    <div class="mb-3" style="font-size:1.6rem;font-weight:800;color:var(--green-dark);">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </div>

                    @if($service->description)
                        <p style="color:var(--text-muted);line-height:1.7;font-size:.9rem;margin-bottom:20px;">
                            {{ $service->description }}
                        </p>
                    @endif

                    <div class="p-3 mb-4" style="background:var(--bg-page);border-radius:12px;border:1px solid var(--border-soft);">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-person-badge-fill" style="color:var(--green-mid);"></i>
                            <span style="font-size:.875rem;"><strong>Terapis:</strong> {{ $service->terapis->username }}</span>
                            @if($service->terapis->gender)
                                <span style="font-size:.75rem;background:{{ $service->terapis->gender=='laki-laki' ? '#e8f0fe' : '#fce4ec' }};color:{{ $service->terapis->gender=='laki-laki' ? '#1565c0' : '#880e4f' }};padding:2px 8px;border-radius:50px;">
                                    {{ $service->terapis->gender == 'laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                </span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-star-fill" style="color:var(--yellow-main);"></i>
                            <span style="font-size:.875rem;"><strong>Rating:</strong> {{ number_format($service->terapis->rating, 1) }} / 5.0</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill" style="color:var(--red-main);"></i>
                            <span style="font-size:.875rem;">Jl. Daud No.12, Rawa Belong, Jakarta Barat 11540</span>
                        </div>
                    </div>

                    @php $customer = auth()->user(); $genderMatch = !$customer->gender || !$service->terapis->gender || $customer->gender === $service->terapis->gender; @endphp

                    @if(!$genderMatch)
                        <div class="alert mb-3" style="background:var(--red-soft);border:1px solid #f5c6c2;color:var(--red-main);border-radius:10px;font-size:.875rem;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Layanan ini hanya untuk pelanggan <strong>{{ $service->terapis->gender }}</strong>. Data gender Anda tidak sesuai.
                        </div>
                    @endif

                    @if($service->is_active && $genderMatch)
                        <a href="{{ route('customer.bookings.create', ['service_id' => $service->id]) }}"
                            class="btn btn-primary w-100 py-3" style="border-radius:10px;font-weight:700;font-size:1rem;">
                            <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                        </a>
                    @else
                        <button class="btn w-100 py-3" disabled style="border-radius:10px;font-weight:700;background:#e0e0e0;color:#999;">
                            <i class="bi bi-x-circle me-2"></i>Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
