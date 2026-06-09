@extends('layouts.customer')
@section('title','Booking Layanan')
@section('content')

<div class="py-4">
    <a href="{{ route('customer.services.show', $service->id) }}" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
        style="color:var(--text-muted);font-size:.875rem;font-weight:600;">
        <i class="bi bi-arrow-left"></i> Kembali ke Detail Layanan
    </a>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-check" style="color:var(--green-mid);"></i>
                    Pilih Jadwal &amp; Pembayaran
                </div>
                <div class="card-body p-4">

                    @if(session('error'))
                        <div class="alert mb-4" style="background:var(--red-soft);border:1px solid #f5c6c2;color:var(--red-main);border-radius:10px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <!-- Service summary -->
                    <div class="p-3 mb-4" style="background:var(--green-light);border-radius:12px;border:1px solid #b8dfc8;">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset($service->category_image) }}" alt="{{ $service->name_service }}"
                                style="width:64px;height:64px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                            <div>
                                <div class="fw-bold" style="color:var(--green-dark);">{{ $service->name_service }}</div>
                                <div style="font-size:.8rem;color:var(--text-muted);">{{ $service->category_label }}</div>
                                <div class="fw-bold mt-1" style="color:var(--green-dark);">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="ms-auto text-end">
                                <div style="font-size:.78rem;color:var(--text-muted);">Terapis</div>
                                <div class="fw-bold" style="font-size:.875rem;">{{ $service->terapis->username }}</div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('customer.bookings.store') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="id_service" value="{{ $service->id }}">

                        <!-- Step 1: Pilih Tanggal -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Tanggal <span style="color:var(--red-main)">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:white;border:1.5px solid var(--border-soft);border-right:none;color:var(--green-mid);border-radius:10px 0 0 10px;">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <input type="date" id="dateInput" name="date_booking"
                                    class="form-control"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('date_booking') }}"
                                    style="border-left:none;border-radius:0 10px 10px 0;" required>
                            </div>
                        </div>

                        <!-- Step 2: Pilih Jam -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Jam <span style="color:var(--red-main)">*</span></label>
                            <p style="font-size:.78rem;color:var(--text-muted);margin-bottom:10px;">
                                <i class="bi bi-info-circle me-1"></i>Slot merah sudah dipesan. Pilih tanggal dulu untuk melihat slot tersedia.
                            </p>
                            <div id="timeSlots" class="d-flex flex-wrap gap-2">
                                <span style="font-size:.82rem;color:var(--text-muted);">Pilih tanggal terlebih dahulu</span>
                            </div>
                            <input type="hidden" name="time_booking" id="timeInput" value="{{ old('time_booking') }}" required>
                        </div>

                        <!-- Step 3: Metode Pembayaran -->
                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran <span style="color:var(--red-main)">*</span></label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" name="payment_method" id="pm_online" value="online"
                                        class="d-none" {{ old('payment_method')=='online'?'checked':'' }}>
                                    <label for="pm_online" class="pay-opt w-100">
                                        <i class="bi bi-credit-card-fill"></i>
                                        <div class="mt-1 fw-bold">Transfer Online</div>
                                        <div style="font-size:.72rem;opacity:.7;">Bayar via Midtrans</div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="payment_method" id="pm_cash" value="cash"
                                        class="d-none" {{ old('payment_method','cash')=='cash'?'checked':'' }}>
                                    <label for="pm_cash" class="pay-opt w-100">
                                        <i class="bi bi-cash-stack"></i>
                                        <div class="mt-1 fw-bold">Bayar Cash</div>
                                        <div style="font-size:.72rem;opacity:.7;">Bayar di tempat / upload bukti</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius:10px;font-weight:700;font-size:1rem;">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pay-opt {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 16px 12px; border: 2px solid var(--border-soft); border-radius: 12px;
        background: white; cursor: pointer; text-align: center; transition: all .2s;
        font-size: .875rem; color: var(--text-muted);
    }
    .pay-opt i { font-size: 1.6rem; }
    input[type=radio]:checked + .pay-opt {
        border-color: var(--green-mid); background: var(--green-light); color: var(--green-dark);
    }
    .pay-opt:hover { border-color: var(--green-mid); }

    .time-slot {
        padding: 8px 16px; border: 1.5px solid var(--border-soft); border-radius: 8px;
        font-size: .82rem; font-weight: 600; cursor: pointer; transition: all .2s;
        background: white; color: var(--text-dark); user-select: none;
    }
    .time-slot.booked  { background: #fee2e2; border-color: #fca5a5; color: #9b1c1c; cursor: not-allowed; }
    .time-slot.selected { background: var(--green-dark); border-color: var(--green-dark); color: white; }
    .time-slot:not(.booked):hover { border-color: var(--green-mid); background: var(--green-light); }
</style>
@endpush

@push('scripts')
<script>
    const serviceId  = {{ $service->id }};
    const slotsUrl   = '{{ route("customer.bookings.slots") }}';
    const allSlots   = ['08:00','09:00','10:00','11:00','13:00','14:00','15:00','16:00','17:00'];
    let bookedSlots  = [];
    let selectedTime = document.getElementById('timeInput').value || '';

    document.getElementById('dateInput').addEventListener('change', function() {
        const date = this.value;
        if (!date) return;

        fetch(slotsUrl + '?service_id=' + serviceId + '&date=' + date, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            bookedSlots = data.booked_slots || [];
            renderSlots();
        });
    });

    function renderSlots() {
        const container = document.getElementById('timeSlots');
        container.innerHTML = '';
        allSlots.forEach(t => {
            const isBooked   = bookedSlots.includes(t + ':00') || bookedSlots.includes(t);
            const isSelected = selectedTime === t || selectedTime === t + ':00';
            const div = document.createElement('div');
            div.className = 'time-slot' + (isBooked ? ' booked' : '') + (isSelected && !isBooked ? ' selected' : '');
            div.textContent = t;
            if (!isBooked) {
                div.addEventListener('click', function() {
                    selectedTime = t;
                    document.getElementById('timeInput').value = t + ':00';
                    renderSlots();
                });
            } else {
                div.title = 'Slot ini sudah dipesan';
            }
            container.appendChild(div);
        });
    }

    // Validate before submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!document.getElementById('timeInput').value) {
            e.preventDefault();
            alert('Pilih jam terlebih dahulu.');
        }
        const pm = document.querySelector('input[name=payment_method]:checked');
        if (!pm) {
            e.preventDefault();
            alert('Pilih metode pembayaran terlebih dahulu.');
        }
    });
</script>
@endpush

@endsection
