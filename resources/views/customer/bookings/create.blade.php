@extends('layouts.customer')
@section('title','Booking Layanan')
@section('content')
<div class="py-4">
    <h4 class="fw-bold mb-1">Booking Layanan</h4>
    <p class="text-muted mb-4">Isi form berikut untuk melakukan booking</p>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif
                    <form method="POST" action="{{ route('customer.bookings.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Layanan <span class="text-danger">*</span></label>
                            <select name="id_service" class="form-select" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" {{ (isset($service) && $service->id==$s->id) || old('id_service')==$s->id ? 'selected' : '' }}>
                                        {{ $s->name_service }} - {{ $s->terapis->username ?? '' }} - Rp {{ number_format($s->price,0,',','.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(isset($service))
                        <div class="alert alert-info mb-3">
                            <div class="fw-semibold">{{ $service->name_service }}</div>
                            <div class="small">Terapis: {{ $service->terapis->username ?? '-' }} | Lokasi: {{ $service->location->name_location ?? '-' }}</div>
                            <div class="small">Jadwal: {{ \Carbon\Carbon::parse($service->date_service)->format('d M Y') }} {{ \Carbon\Carbon::parse($service->time_service)->format('H:i') }}</div>
                            <div class="fw-bold text-success">Rp {{ number_format($service->price,0,',','.') }}</div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Booking <span class="text-danger">*</span></label>
                                <input type="date" name="date_booking" class="form-control" value="{{ old('date_booking', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Waktu Booking <span class="text-danger">*</span></label>
                                <input type="time" name="time_booking" class="form-control" value="{{ old('time_booking', '09:00') }}" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-calendar-check me-2"></i>Konfirmasi Booking</button>
                            <a href="{{ route('customer.services.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Booking</h6>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Booking akan berstatus <strong>Pending</strong> setelah dibuat</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Lakukan pembayaran setelah booking dikonfirmasi terapis</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Upload bukti pembayaran untuk konfirmasi</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Booking bisa dibatalkan selama masih berstatus Pending</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
