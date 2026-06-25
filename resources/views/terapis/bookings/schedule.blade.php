@extends('layouts.terapis')
@section('title','Jadwal Service')
@section('page-title','Jadwal Service')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Jadwal Service Mendatang</h6>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" placeholder="Filter tanggal">
            </div>
            <div class="col-auto">
                <button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('terapis.schedule') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        @if($bookings->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                <h5>Tidak ada jadwal</h5>
                <p>Belum ada booking yang dikonfirmasi</p>
            </div>
        @else
            @php $grouped = $bookings->groupBy(fn($b) => \Carbon\Carbon::parse($b->date_booking)->format('Y-m-d')); @endphp
            @foreach($grouped as $date => $dayBookings)
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-calendar3 me-2"></i>
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                    <span class="badge bg-primary ms-2">{{ $dayBookings->count() }} booking</span>
                </h6>
                <div class="row g-3">
                    @foreach($dayBookings as $b)
                    @php $sc=['confirmed'=>'info','in_progress'=>'primary']; @endphp
                    <div class="col-md-6">
                        <div class="card border-start border-4 border-{{ $sc[$b->status_service]??'secondary' }}">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold">{{ $b->customer->username ?? '-' }}</div>
                                        <div class="text-muted small">{{ $b->service->name_service ?? '-' }}</div>
                                        <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $b->location->name_location ?? '-' }}</div>
                                        <div class="text-muted small">
                                            <i class="bi bi-door-open me-1"></i>{{ $b->ruangan->nama_ruangan ?? '-' }}
                                            &bull;
                                            <i class="bi bi-hospital me-1"></i>{{ $b->bed->nama_bed ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-primary small">{{ $b->formatted_time }}</div>
                                        <span class="badge bg-{{ $sc[$b->status_service]??'secondary' }} small">{{ ucfirst(str_replace('_',' ',$b->status_service)) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
