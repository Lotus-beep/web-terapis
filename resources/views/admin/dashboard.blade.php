@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1a5276,#2980b9)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Customer</div>
                    <div class="fs-2 fw-bold">{{ $totalCustomer }}</div>
                </div>
                <i class="bi bi-people fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#148f77,#1abc9c)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Terapis</div>
                    <div class="fs-2 fw-bold">{{ $totalTerapis }}</div>
                </div>
                <i class="bi bi-person-badge fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#7d3c98,#9b59b6)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Booking</div>
                    <div class="fs-2 fw-bold">{{ $totalBooking }}</div>
                </div>
                <i class="bi bi-calendar-check fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#b7950b,#f39c12)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Pendapatan</div>
                    <div class="fs-4 fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-cash-stack fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Booking Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr><th>Customer</th><th>Layanan</th><th>Tanggal</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $b)
                            <tr>
                                <td>{{ $b->customer->username ?? '-' }}</td>
                                <td>{{ $b->service->name_service ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->date_booking)->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $colors = ['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
                                        $c = $colors[$b->status_service] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $c }}">{{ ucfirst($b->status_service) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada booking</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-credit-card me-2 text-warning"></i>Menunggu Konfirmasi Pembayaran</h6>
            </div>
            <div class="card-body">
                @forelse($pendingPayments as $p)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <div class="fw-semibold small">{{ $p->customer->username ?? '-' }}</div>
                        <div class="text-muted" style="font-size:12px">{{ $p->service->name_service ?? '-' }}</div>
                    </div>
                    <a href="{{ route('admin.bookings.show', $p->id) }}" class="btn btn-sm btn-warning">Review</a>
                </div>
                @empty
                <p class="text-muted text-center py-3">Tidak ada pembayaran pending</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
