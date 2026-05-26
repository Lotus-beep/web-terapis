@extends('layouts.customer')
@section('title','Daftar Layanan')
@section('content')
<div class="py-4">
    <h4 class="fw-bold mb-1">Daftar Layanan Bekam</h4>
    <p class="text-muted mb-4">Pilih layanan yang sesuai dengan kebutuhan Anda</p>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Filter Lokasi</label>
                    <select name="id_location" class="form-select">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ request('id_location')==$loc->id?'selected':'' }}>{{ $loc->name_location }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Filter Terapis</label>
                    <select name="id_terapis" class="form-select">
                        <option value="">Semua Terapis</option>
                        @foreach($terapis as $t)
                            <option value="{{ $t->id }}" {{ request('id_terapis')==$t->id?'selected':'' }}>{{ $t->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-2"></i>Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($services as $s)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm" style="border-radius:12px;transition:transform .2s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-bold mb-0">{{ $s->name_service }}</h6>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <ul class="list-unstyled text-muted small mb-3">
                        <li class="mb-1"><i class="bi bi-person-badge me-2 text-primary"></i>{{ $s->terapis->username ?? '-' }}
                            <span class="text-warning ms-1">
                                @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=round($s->terapis->rating??0)?'-fill':'' }}"></i>@endfor
                            </span>
                        </li>
                        <li class="mb-1"><i class="bi bi-geo-alt me-2 text-primary"></i>{{ $s->location->name_location ?? '-' }}</li>
                        <li class="mb-1"><i class="bi bi-calendar3 me-2 text-primary"></i>{{ \Carbon\Carbon::parse($s->date_service)->format('d M Y') }}</li>
                        <li><i class="bi bi-clock me-2 text-primary"></i>{{ \Carbon\Carbon::parse($s->time_service)->format('H:i') }} WIB</li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-success fw-bold fs-5">Rp {{ number_format($s->price, 0, ',', '.') }}</span>
                        <a href="{{ route('customer.bookings.create', ['service_id' => $s->id]) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-calendar-check me-1"></i>Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-clipboard2-x fs-1 d-block mb-3"></i>
                <h5>Tidak ada layanan tersedia</h5>
                <p>Coba ubah filter pencarian Anda</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $services->withQueryString()->links() }}</div>
</div>
@endsection
