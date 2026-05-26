@extends('layouts.terapis')
@section('title','Dashboard Terapis')
@section('page-title','Dashboard')
@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->username }}! 👋</h5>
    <p class="text-muted">Kelola jadwal dan booking Anda di sini.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="card text-white" style="background:linear-gradient(135deg,#1a5276,#2980b9)">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Booking Hari Ini</div>
                    <div class="fs-2 fw-bold">{{ $todayBookings }}</div>
                </div>
                <i class="bi bi-calendar-day fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-white" style="background:linear-gradient(135deg,#7d3c98,#9b59b6)">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Booking Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $monthBookings }}</div>
                </div>
                <i class="bi bi-calendar-month fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-white" style="background:linear-gradient(135deg,#b7950b,#f39c12)">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Rating Rata-rata</div>
                    <div class="fs-2 fw-bold">{{ number_format($avgRating, 1) }}</div>
                </div>
                <i class="bi bi-star-fill fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Booking Terbaru</h6>
        <a href="{{ route('terapis.bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Customer</th><th>Layanan</th><th>Tanggal</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                    @php $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger']; @endphp
                    <tr>
                        <td>{{ $b->customer->username ?? '-' }}</td>
                        <td>{{ $b->service->name_service ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->date_booking)->format('d M Y') }}</td>
                        <td><span class="badge bg-{{ $sc[$b->status_service]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_service)) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
