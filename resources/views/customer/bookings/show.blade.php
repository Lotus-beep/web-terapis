@extends('layouts.customer')
@section('title','Detail Booking')
@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Detail Booking #{{ $booking->id }}</h4>
        <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>

    @php
        $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
        $pc=['unpaid'=>'secondary','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger'];
    @endphp

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Booking</h6>
                    <div class="row g-3">
                        <div class="col-6"><div class="text-muted small">Layanan</div><div class="fw-semibold">{{ $booking->service->name_service ?? '-' }}</div></div>
                        <div class="col-6"><div class="text-muted small">Terapis</div><div class="fw-semibold">{{ $booking->terapis->username ?? '-' }}</div></div>
                        <div class="col-6"><div class="text-muted small">Lokasi</div><div class="fw-semibold">{{ $booking->service->location->name_location ?? '-' }}</div></div>
                        <div class="col-6"><div class="text-muted small">Harga</div><div class="fw-bold text-success">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</div></div>
                        <div class="col-6"><div class="text-muted small">Tanggal</div><div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->date_booking)->format('d M Y') }}</div></div>
                        <div class="col-6"><div class="text-muted small">Waktu</div><div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->time_booking)->format('H:i') }} WIB</div></div>
                        <div class="col-6">
                            <div class="text-muted small">Status Service</div>
                            <span class="badge bg-{{ $sc[$booking->status_service]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$booking->status_service)) }}</span>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Status Pembayaran</div>
                            <span class="badge bg-{{ $pc[$booking->status_payment]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$booking->status_payment)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload Pembayaran --}}
            @if(in_array($booking->status_service, ['confirmed','in_progress']) && $booking->status_payment === 'unpaid')
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning bg-opacity-10 border-warning">
                    <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-credit-card me-2"></i>Upload Bukti Pembayaran</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.bookings.payment', $booking->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                            <div class="form-text">Format: JPG, JPEG, PNG. Maks: 2MB</div>
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran</button>
                    </form>
                </div>
            </div>
            @endif

            @if($booking->payment_proof)
            <div class="card mb-4">
                <div class="card-header bg-white border-0 pt-3"><h6 class="fw-bold mb-0">Bukti Pembayaran</h6></div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/'.$booking->payment_proof) }}" class="img-fluid rounded" style="max-height:250px" alt="Bukti Pembayaran">
                </div>
            </div>
            @endif

            {{-- Form Komentar --}}
            @if($booking->status_service === 'completed' && !$hasComment)
            <div class="card border-success">
                <div class="card-header bg-success bg-opacity-10 border-success">
                    <h6 class="fw-bold mb-0 text-success"><i class="bi bi-star me-2"></i>Berikan Rating & Komentar</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.bookings.comment', $booking->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                @for($i=1;$i<=5;$i++)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="{{ $i }}" id="r{{ $i }}" {{ old('rating')==$i?'checked':'' }} required>
                                    <label class="form-check-label" for="r{{ $i }}">{{ $i }} <i class="bi bi-star-fill text-warning"></i></label>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar <span class="text-danger">*</span></label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Bagikan pengalaman Anda..." required maxlength="500">{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-send me-2"></i>Kirim Komentar</button>
                    </form>
                </div>
            </div>
            @elseif($booking->status_service === 'completed' && $hasComment)
            <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>Anda sudah memberikan rating untuk terapis ini.</div>
            @endif
        </div>

        <div class="col-lg-5">
            @if($booking->status_service === 'pending')
            <div class="card border-danger">
                <div class="card-body text-center p-4">
                    <i class="bi bi-x-circle text-danger fs-1 mb-3 d-block"></i>
                    <h6 class="fw-bold">Batalkan Booking</h6>
                    <p class="text-muted small">Booking masih bisa dibatalkan karena berstatus Pending</p>
                    <form method="POST" action="{{ route('customer.bookings.cancel', $booking->id) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger w-100"><i class="bi bi-x-circle me-2"></i>Batalkan Booking</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
