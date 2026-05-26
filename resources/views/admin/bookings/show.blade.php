@extends('layouts.admin')
@section('title','Detail Booking')
@section('page-title','Detail Booking')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Detail Booking #{{ $booking->id }}</h6>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Customer</div>
                            <div class="fw-semibold">{{ $booking->customer->username ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->customer->email ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->customer->no_telepon ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Terapis</div>
                            <div class="fw-semibold">{{ $booking->terapis->username ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->terapis->email ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Layanan</div>
                            <div class="fw-semibold">{{ $booking->service->name_service ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->service->location->name_location ?? '-' }}</div>
                            <div class="text-success fw-bold">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Jadwal Booking</div>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->date_booking)->format('d M Y') }}</div>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($booking->time_booking)->format('H:i') }} WIB</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <div class="text-muted small mb-2">Status Service</div>
                            @php $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger']; @endphp
                            <span class="badge bg-{{ $sc[$booking->status_service]??'secondary' }} fs-6">{{ ucfirst(str_replace('_',' ',$booking->status_service)) }}</span>
                            <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="mt-2">
                                @csrf @method('PUT')
                                <div class="input-group input-group-sm">
                                    <select name="status_service" class="form-select">
                                        @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                                            <option value="{{ $s }}" {{ $booking->status_service==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <div class="text-muted small mb-2">Status Pembayaran</div>
                            @php $pc=['unpaid'=>'secondary','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger']; @endphp
                            <span class="badge bg-{{ $pc[$booking->status_payment]??'secondary' }} fs-6">{{ ucfirst(str_replace('_',' ',$booking->status_payment)) }}</span>
                            @if($booking->status_payment === 'waiting_confirmation')
                                <div class="d-flex gap-2 mt-2">
                                    <form method="POST" action="{{ route('admin.bookings.confirm-payment', $booking->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Konfirmasi</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bookings.reject-payment', $booking->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($booking->payment_proof)
        <div class="card">
            <div class="card-header bg-white border-0 pt-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-image me-2"></i>Bukti Pembayaran</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/'.$booking->payment_proof) }}" class="img-fluid rounded" style="max-height:300px" alt="Bukti Pembayaran">
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-image fs-1 d-block mb-2"></i>
                Belum ada bukti pembayaran
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
