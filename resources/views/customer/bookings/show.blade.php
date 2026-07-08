@extends('layouts.customer')
@section('title','Detail Booking')
@section('content')

@php
    $clinicName = \App\Models\ClinicSetting::getValue('clinic_name', 'Klinik Bekam');
    $clinicPhone = \App\Models\ClinicSetting::getValue('clinic_phone', '-');
    $clinicHours = \App\Models\ClinicSetting::getValue('clinic_hours', '-');
@endphp

<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Detail Booking #{{ $booking->id }}</h4>
        <div>
            <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm"
                style="background:var(--green-light);color:var(--green-dark);border:none;border-radius:8px;font-weight:600;">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert mb-4" style="background:var(--green-light);border:1px solid #b8dfc8;color:var(--green-dark);border-radius:10px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert mb-4" style="background:var(--red-soft);border:1px solid #f5c6c2;color:var(--red-main);border-radius:10px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <!-- Info Booking -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill" style="color:var(--green-mid);"></i>
                    Informasi Booking
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0" style="font-size:.875rem;">
                        <tbody>
                            <tr><td class="fw-600 text-muted ps-4" style="width:40%;font-weight:600;">Kode Booking</td><td class="fw-bold text-primary">{{ $booking->kode_booking }}</td></tr>
                            <tr><td class="fw-600 text-muted ps-4" style="width:40%;font-weight:600;">Layanan</td><td class="fw-bold">{{ $booking->service->name ?? '-' }}</td></tr>
                            <tr>
                                <td class="fw-600 text-muted ps-4" style="font-weight:600;">Pasien</td>
                                <td>
                                    @if($booking->booking_for === 'other' && $booking->second_username)
                                        <span class="fw-bold">{{ $booking->second_username }}</span>
                                        <span style="font-size:.75rem;background:#fffbeb;border:1px solid #fde68a;color:#92400e;padding:2px 8px;border-radius:50px;margin-left:6px;">
                                            <i class="bi bi-people-fill me-1"></i>Titipan
                                        </span>
                                        @if($booking->gender_second)
                                            <div style="font-size:.78rem;color:var(--text-muted);margin-top:2px;">
                                                {{ $booking->gender_second === 'laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="fw-bold">{{ $booking->customer->username ?? '-' }}</span>
                                        <span style="font-size:.75rem;background:var(--green-light);border:1px solid #b8dfc8;color:var(--green-dark);padding:2px 8px;border-radius:50px;margin-left:6px;">
                                            <i class="bi bi-person-fill me-1"></i>Untuk Saya
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Terapis</td>
                                <td>
                                    @if($booking->terapis)
                                        <span style="background:var(--green-light);color:var(--green-dark);font-size:.78rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                                            <i class="bi bi-patch-check-fill me-1"></i>{{ $booking->terapis->username }}
                                        </span>
                                    @else
                                        <span style="background:#f3f4f6;color:#6b7280;font-size:.78rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                                            <i class="bi bi-clock me-1"></i>Menunggu penugasan admin
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Lokasi</td>
                                <td>
                                    @if($booking->location)
                                        <i class="bi bi-geo-alt-fill me-1" style="color:var(--red-main);"></i>
                                        {{ $booking->location->name_location }}
                                    @else
                                        <span style="font-size:.8rem;color:var(--text-muted);">
                                            <i class="bi bi-clock me-1"></i>Menunggu konfirmasi admin
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Tanggal</td><td class="fw-bold">{{ \Carbon\Carbon::parse($booking->date_booking)->isoFormat('dddd, D MMMM Y') }}</td></tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Jam</td><td class="fw-bold">{{ $booking->formatted_time }}</td></tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Ruangan</td>
                                <td>
                                    @if($booking->ruangan)
                                        <i class="bi bi-door-open me-1" style="color:var(--green-mid);"></i>
                                        {{ $booking->ruangan->nama_ruangan }}
                                        <span style="font-size:.75rem;color:var(--text-muted);"> ({{ $booking->ruangan->gender_label }})</span>
                                    @else
                                        <span style="font-size:.8rem;color:var(--text-muted);">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Bed</td>
                                <td>
                                    @if($booking->bed)
                                        <i class="bi bi-hospital me-1" style="color:var(--green-mid);"></i>
                                        {{ $booking->bed->nama_bed }}
                                    @else
                                        <span style="font-size:.8rem;color:var(--text-muted);">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Metode Bayar</td>
                                <td>
                                    @if($booking->payment_method === 'online')
                                        <span style="background:#e8f0fe;color:#1565c0;padding:3px 10px;border-radius:50px;font-size:.75rem;font-weight:700;">
                                            <i class="bi bi-credit-card-fill me-1"></i>Transfer Online
                                        </span>
                                    @else
                                        <span style="background:var(--green-light);color:var(--green-dark);padding:3px 10px;border-radius:50px;font-size:.75rem;font-weight:700;">
                                            <i class="bi bi-cash-stack me-1"></i>Cash
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Harga</td>
                                <td class="fw-bold" style="color:var(--green-dark);font-size:1rem;">
                                    Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Keluhan</td>
                                <td>
                                    <span class="fw-bold">{{ $booking->keluhan ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Status Booking</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_service_badge }}">
                                        {{ $booking->status_service_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr><td class="fw-600 text-muted ps-4" style="font-weight:600;">Status Pembayaran</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_payment_badge }}">
                                        {{ $booking->status_payment_label }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Midtrans Online Payment --}}
            @if($booking->payment_method === 'online' && in_array($booking->status_payment, ['unpaid','pending_snap']))
                <div class="card mb-4" style="border:2px solid #3b82f6;">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-credit-card-fill" style="font-size:2.5rem;color:#3b82f6;"></i>
                        <h6 class="fw-bold mt-3 mb-2">Selesaikan Pembayaran Online</h6>
                        <p style="font-size:.85rem;color:var(--text-muted);">Klik tombol di bawah untuk membuka halaman pembayaran Midtrans.</p>
                        @if($booking->status_payment === 'pending_snap')
                            <div class="mb-2" style="font-size:.78rem;color:#3b82f6;">
                                <i class="bi bi-arrow-repeat me-1"></i>Halaman diperbarui otomatis setiap 10 detik...
                            </div>
                        @endif
                        <button id="payBtn" class="btn w-100 py-2" style="background:#3b82f6;color:white;border-radius:10px;font-weight:700;">
                            <i class="bi bi-lock-fill me-2"></i>Bayar Sekarang — Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}
                        </button>
                    </div>
                </div>
            @elseif($booking->payment_method === 'online' && $booking->status_payment === 'paid')
                <div class="card mb-4" style="border:2px solid var(--green-mid);">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-check-circle-fill" style="font-size:2.5rem;color:var(--green-mid);"></i>
                        <h6 class="fw-bold mt-3 mb-1" style="color:var(--green-dark);">Pembayaran Berhasil!</h6>
                        <p style="font-size:.85rem;color:var(--text-muted);">
                            Pembayaran online Anda telah dikonfirmasi. Booking otomatis dikonfirmasi.
                        </p>
                    </div>
                </div>
            @elseif($booking->payment_method === 'online' && $booking->status_payment === 'expired')
                <div class="card mb-4" style="border:2px solid #6b7280;">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-clock-history" style="font-size:2.5rem;color:#6b7280;"></i>
                        <h6 class="fw-bold mt-3 mb-1">Pembayaran Kadaluarsa</h6>
                        <p style="font-size:.85rem;color:var(--text-muted);">Sesi pembayaran telah habis. Booking dibatalkan otomatis.</p>
                    </div>
                </div>
            @elseif($booking->payment_method === 'online' && $booking->status_payment === 'rejected')
                <div class="card mb-4" style="border:2px solid var(--red-main);">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-x-circle-fill" style="font-size:2.5rem;color:var(--red-main);"></i>
                        <h6 class="fw-bold mt-3 mb-1">Pembayaran Ditolak</h6>
                        <p style="font-size:.85rem;color:var(--text-muted);">Pembayaran gagal atau ditolak. Silakan buat booking baru.</p>
                    </div>
                </div>
            @endif

            {{-- Cash: Info bayar langsung ke admin --}}
            @if($booking->payment_method === 'cash' && $booking->status_payment === 'unpaid' && $booking->status_service !== 'cancelled')
            <div class="card mb-4" style="border:2px solid var(--yellow-main);">
                <div class="card-header d-flex align-items-center gap-2" style="background:var(--yellow-soft);border-color:var(--yellow-main);">
                    <i class="bi bi-cash-coin" style="color:#7a5700;font-size:1.1rem;"></i>
                    <h6 class="fw-bold mb-0" style="color:#7a5700;">Pembayaran Cash</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-cash-stack" style="font-size:1.4rem;color:#d97706;"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-1" style="color:#7a5700;">Bayar Langsung ke Admin</p>
                            <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:8px;">
                                Serahkan pembayaran sebesar
                                <strong style="color:var(--green-dark);">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</strong>
                                langsung ke admin/kasir klinik saat datang.
                            </p>
                            <div style="font-size:.8rem;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:8px 12px;color:#78350f;">
                                <i class="bi bi-info-circle me-1"></i>
                                Admin akan mengkonfirmasi pembayaran Anda di sistem setelah menerima uang.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Bukti yang sudah diupload --}}
            @if($booking->payment_proof)
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-image me-2" style="color:var(--green-mid);"></i>Bukti Pembayaran</div>
                <div class="card-body text-center p-3">
                    <img src="{{ asset('storage/'.$booking->payment_proof) }}"
                        class="img-fluid rounded" style="max-height:220px;border-radius:10px;" alt="Bukti Pembayaran">
                </div>
            </div>
            @endif

            {{-- Ulasan --}}
            @if($booking->status_service === 'completed' && !$hasComment)
            <div class="card" style="border:2px solid var(--green-mid);">
                <div class="card-header" style="background:var(--green-light);border-color:var(--green-mid);">
                    <h6 class="fw-bold mb-0" style="color:var(--green-dark);"><i class="bi bi-chat-text-fill me-2" style="color:var(--green-mid);"></i>Berikan Ulasan</h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('customer.bookings.comment', $booking->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Ulasan <span style="color:var(--red-main)">*</span></label>
                            <textarea name="comment" class="form-control" rows="3"
                                placeholder="Bagikan pengalaman Anda..." required maxlength="500">{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
            @elseif($booking->status_service === 'completed' && $hasComment)
            <div class="alert alert-success d-flex align-items-center mb-0">
                <i class="bi bi-check-circle-fill me-2"></i>Terimakasih atas ulasan anda.
            </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-5">
            @if($booking->status_service === 'pending')
            <div class="card mb-4" style="border:2px solid var(--green-main);">
                <div class="card-body text-center p-4">
                    <i class="bi bi-whatsapp" style="font-size:2.5rem;color:#25D366;"></i>

                    <h6 class="fw-bold mt-3 mb-1">Hubungi Admin</h6>

                    <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:16px;">
                        Jika Anda ingin membatalkan atau memiliki pertanyaan mengenai booking,
                        silakan hubungi admin melalui WhatsApp.
                    </p>

                    <a href="https://wa.me/{{ $clinicHours }}?text=Halo%20Admin,%20saya%20ingin%20bertanya%20mengenai%20booking%20dengan%20ID%20{{ $booking->id }}"
                        target="_blank"
                        class="btn btn-success w-100"
                        style="border-radius:8px;font-weight:700;">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Admin
                    </a>
                </div>
            </div>
            @endif

            @if(isset($booking->therapyReport))
            <div class="card mb-4" style="border:2px solid #3b82f6;">
                <div class="card-body text-center p-4">
                    <i class="bi bi-file-earmark-word" style="font-size:2.5rem;color:#3b82f6;"></i>
                    <h6 class="fw-bold mt-3 mb-1">Unduh Laporan Terapi</h6>
                    <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:16px;">
                        Laporan terapi Anda telah selesai dibuat dan siap untuk diunduh (format Word).
                    </p>
                    <a href="{{ route('customer.bookings.export-word', $booking->id) }}" class="btn btn-primary w-100" style="border-radius:8px;font-weight:700;background-color:#3b82f6;border-color:#3b82f6;">
                        <i class="bi bi-download me-2"></i>Download Laporan
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
</style>
@endpush

@push('scripts')
@if($snapToken)
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('payBtn') && document.getElementById('payBtn').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                // Midtrans Dashboard akan redirect ke /payment/finish
                // Tapi sebagai fallback, refresh halaman
                window.location.reload();
            },
            onPending: function(result) {
                window.location.reload();
            },
            onError: function(result) {
                // Midtrans Dashboard akan redirect ke /payment/error
                window.location.reload();
            },
            onClose: function() {
                // user tutup popup tanpa bayar
            }
        });
    });
</script>
@elseif($booking->payment_method === 'online' && $booking->snap_token && in_array($booking->status_payment, ['unpaid','pending_snap']))
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('payBtn') && document.getElementById('payBtn').addEventListener('click', function() {
        snap.pay('{{ $booking->snap_token }}', {
            onSuccess: function() { window.location.reload(); },
            onPending: function() { window.location.reload(); },
            onError:   function() { window.location.reload(); }
        });
    });
</script>
@endif

{{-- Auto-refresh jika masih pending_snap --}}
@if($booking->status_payment === 'pending_snap')
<script>
    setTimeout(function() { window.location.reload(); }, 10000);
</script>
@endif
@endpush

@endsection
