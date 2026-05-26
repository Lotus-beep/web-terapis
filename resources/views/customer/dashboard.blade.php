@extends('layouts.customer')
@section('title','Dashboard')
@section('content')
<div class="py-4">
    <h4 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->username }}! 👋</h4>
    <p class="text-muted mb-4">Kelola booking layanan bekam Anda di sini.</p>

    <div class="row g-4 mb-4">
        <div class="col-sm-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#1a5276,#2980b9)">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Total Booking</div>
                        <div class="fs-2 fw-bold">{{ $totalBooking }}</div>
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#b7950b,#f39c12)">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Booking Aktif</div>
                        <div class="fs-2 fw-bold">{{ $activeBooking }}</div>
                    </div>
                    <i class="bi bi-clock-history fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#148f77,#1abc9c)">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Selesai</div>
                        <div class="fs-2 fw-bold">{{ $completedBooking }}</div>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Booking Terbaru</h6>
                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $b)
                                @php $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger']; @endphp
                                <tr>
                                    <td>{{ $b->service->name_service ?? '-' }}</td>
                                    <td>{{ $b->terapis->username ?? '-' }}</td>
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
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center p-4">
                    <i class="bi bi-calendar-plus text-primary fs-1 mb-3 d-block"></i>
                    <h6 class="fw-bold">Booking Layanan Baru</h6>
                    <p class="text-muted small">Temukan layanan bekam terbaik untuk kesehatan Anda</p>
                    <a href="{{ route('customer.services.index') }}" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Lihat Layanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
