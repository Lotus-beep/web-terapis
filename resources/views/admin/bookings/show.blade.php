@extends('layouts.admin')
@section('title','Detail Booking')
@section('page-title','Detail Booking')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Detail Booking #{{ $booking->id }}</h6>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- Customer --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Pemesan (Customer)</div>
                            <div class="fw-semibold">{{ $booking->customer->username ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->customer->email ?? '-' }}</div>
                            <div class="text-muted small">{{ $booking->customer->no_telepon ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Pasien --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:#fffbeb;border:1px solid #fde68a;">
                            <div class="text-muted small mb-1">Pasien yang Diterapi</div>
                            @if($booking->booking_for === 'other' && $booking->second_username)
                                <div class="fw-semibold">{{ $booking->second_username }}</div>
                                <div class="text-muted small">
                                    {{ $booking->gender_second === 'laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                </div>
                                <span style="font-size:.72rem;background:#fde68a;color:#92400e;padding:2px 8px;border-radius:50px;font-weight:600;">
                                    <i class="bi bi-people-fill me-1"></i>Titipan
                                </span>
                            @else
                                <div class="fw-semibold">{{ $booking->customer->username ?? '-' }}</div>
                                <div class="text-muted small">
                                    {{ $booking->customer->gender ? ucfirst($booking->customer->gender) : '-' }}
                                </div>
                                <span style="font-size:.72rem;background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:50px;font-weight:600;">
                                    <i class="bi bi-person-fill me-1"></i>Untuk Diri Sendiri
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Layanan --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Layanan</div>
                            <div class="fw-semibold">{{ $booking->service->name ?? '-' }}</div>
                            <div class="text-success fw-bold">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    {{-- Jadwal --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Jadwal Booking</div>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->date_booking)->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $booking->formatted_time }}</div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Lokasi</div>
                            @if($booking->location)
                                <div class="fw-semibold">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                    {{ $booking->location->name_location }}
                                </div>
                            @else
                                <div class="text-warning small">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Belum ditentukan
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Ruangan & Bed --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <div class="text-muted small mb-1">Ruangan & Bed</div>
                            <div class="fw-semibold">
                                <i class="bi bi-door-open-fill me-1 text-success"></i>
                                {{ $booking->ruangan->nama_ruangan ?? '-' }}
                                @if($booking->ruangan)
                                    <span style="font-size:.75rem;color:var(--text-muted);"> ({{ $booking->ruangan->gender_label }})</span>
                                @endif
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-hospital me-1"></i>
                                {{ $booking->bed->nama_bed ?? '-' }}
                            </div>
                        </div>
                    </div>

                {{-- Terapis & Status --}}
                <div class="row g-3 mt-1">

                    {{-- Assign Terapis --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <div class="text-muted small mb-2">Terapis</div>
                            @if($booking->terapis)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success">
                                        <i class="bi bi-patch-check-fill me-1"></i>{{ $booking->terapis->username }}
                                    </span>
                                    @if($booking->terapis->gender)
                                        <span class="badge bg-secondary" style="font-size:.7rem;">{{ ucfirst($booking->terapis->gender) }}</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-warning small mb-2">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Belum ada terapis yang ditugaskan
                                </div>
                            @endif

                            @if($booking->status_service !== 'completed' && $booking->status_service !== 'cancelled')
                                <form method="POST" action="{{ route('admin.bookings.assign-terapis', $booking->id) }}">
                                    @csrf @method('PATCH')
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size:.8rem;font-weight:600;color:var(--text-muted);">Pilih Terapis</label>
                                        <select name="id_terapis" class="form-select form-select-sm" required>
                                            <option value="">-- Pilih Terapis --</option>
                                            @foreach($terapisList as $t)
                                                <option value="{{ $t->id }}"
                                                    {{ $booking->id_terapis == $t->id ? 'selected' : '' }}>
                                                    {{ $t->username }}
                                                    @if($t->gender) ({{ ucfirst($t->gender) }}) @endif
                                                    @if($t->rating) ★{{ number_format($t->rating, 1) }} @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size:.8rem;font-weight:600;color:var(--text-muted);">Pilih Lokasi</label>
                                        <select name="id_location" class="form-select form-select-sm">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach($locationList as $loc)
                                                <option value="{{ $loc->id }}"
                                                    {{ $booking->id_location == $loc->id ? 'selected' : '' }}>
                                                    {{ $loc->name_location }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-success btn-sm w-100" type="submit">
                                        <i class="bi bi-person-check me-1"></i>Tugaskan &amp; Konfirmasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Status Service --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <div class="text-muted small mb-2">Status Layanan</div>
                            @php $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger']; @endphp
                            <span class="badge bg-{{ $sc[$booking->status_service]??'secondary' }} fs-6 mb-2">
                                {{ ucfirst(str_replace('_',' ',$booking->status_service)) }}
                            </span>
                            <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="mt-1">
                                @csrf @method('PUT')
                                <div class="input-group input-group-sm">
                                    <select name="status_service" class="form-select">
                                        @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                                            <option value="{{ $s }}" {{ $booking->status_service==$s?'selected':'' }}>
                                                {{ ucfirst(str_replace('_',' ',$s)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Status Pembayaran --}}
                    <div class="col-12">
                        <div class="p-3 border rounded">
                            <div class="text-muted small mb-2">Status Pembayaran</div>
                            @php $pc=['unpaid'=>'secondary','pending_snap'=>'info','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger','expired'=>'dark']; @endphp
                            <span class="badge bg-{{ $pc[$booking->status_payment]??'secondary' }} fs-6 mb-2">
                                {{ $booking->status_payment_label }}
                            </span>
                            @if($booking->status_payment === 'waiting_confirmation')
                                <div class="d-flex gap-2 mt-2">
                                    <form method="POST" action="{{ route('admin.bookings.confirm-payment', $booking->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-check-lg me-1"></i>Konfirmasi Pembayaran
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bookings.reject-payment', $booking->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-lg me-1"></i>Tolak
                                        </button>
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
                <img src="{{ asset('storage/'.$booking->payment_proof) }}"
                    class="img-fluid rounded" style="max-height:300px" alt="Bukti Pembayaran">
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

        {{-- Info cepat --}}
        <div class="card mt-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0 small">Metode Pembayaran</h6>
            </div>
            <div class="card-body pt-1">
                @if($booking->payment_method === 'online')
                    <span class="badge bg-primary"><i class="bi bi-credit-card me-1"></i>Transfer Online</span>
                @else
                    <span class="badge bg-secondary"><i class="bi bi-cash-stack me-1"></i>Cash</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
