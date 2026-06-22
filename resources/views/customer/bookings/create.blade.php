@extends('layouts.customer')
@section('title','Booking Layanan')
@section('content')

<div class="py-4">
    <a href="{{ route('customer.services.show', $service->id) }}"
        class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
        style="color:var(--text-muted);font-size:.875rem;font-weight:600;">
        <i class="bi bi-arrow-left"></i> Kembali ke Detail Layanan
    </a>

    {{-- Service summary strip --}}
    <div class="p-3 mb-4" style="background:var(--green-light);border-radius:12px;border:1px solid #b8dfc8;">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset($service->display_image) }}" alt="{{ $service->name }}"
                style="width:56px;height:56px;border-radius:10px;object-fit:cover;flex-shrink:0;">
            <div>
                <div class="fw-bold" style="color:var(--green-dark);">{{ $service->header_content ?: $service->name }}</div>
                <div style="font-size:.8rem;color:var(--text-muted);">{{ $service->name }}</div>
                <div class="fw-bold mt-1" style="color:var(--green-dark);">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
            </div>
            <div class="ms-auto text-end d-none d-sm-block">
                <span style="background:var(--green-light);border:1px solid #b8dfc8;color:var(--green-dark);font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:50px;">
                    <i class="bi bi-patch-check-fill me-1"></i>Terapis ditentukan admin
                </span>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert mb-4" style="background:var(--red-soft);border:1px solid #f5c6c2;color:var(--red-main);border-radius:10px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('customer.bookings.store') }}" id="bookingForm">
        @csrf
        <input type="hidden" name="id_service" value="{{ $service->id }}">
        <input type="hidden" name="id_waktu_boking" id="inputWaktuBoking">
        <input type="hidden" name="id_ruangan" id="inputRuangan">

        <div class="row g-4">

            {{-- ===== KOLOM KIRI: Langkah 1, 2, 3 ===== --}}
            <div class="col-lg-8">

                {{-- STEP 1: Untuk Siapa --}}
                <div class="booking-step" id="step1">
                    <div class="step-header">
                        <span class="step-num">1</span>
                        <span class="step-title">Booking untuk siapa?</span>
                    </div>
                    <div class="step-body">
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" name="booking_for" id="bf_self" value="self"
                                    class="d-none" {{ old('booking_for','self')==='self'?'checked':'' }}>
                                <label for="bf_self" class="pay-opt w-100">
                                    <i class="bi bi-person-fill"></i>
                                    <div class="mt-1 fw-bold">Untuk Saya</div>
                                    <div style="font-size:.72rem;opacity:.7;">Gunakan data profil saya</div>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="booking_for" id="bf_other" value="other"
                                    class="d-none" {{ old('booking_for')==='other'?'checked':'' }}>
                                <label for="bf_other" class="pay-opt w-100">
                                    <i class="bi bi-people-fill"></i>
                                    <div class="mt-1 fw-bold">Titipan</div>
                                    <div style="font-size:.72rem;opacity:.7;">Saudara / teman</div>
                                </label>
                            </div>
                        </div>

                        {{-- Info profil sendiri --}}
                        <div id="selfInfo" class="mt-3 p-3" style="background:#f0fdf4;border:1px solid #b8dfc8;border-radius:10px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle" style="font-size:1.4rem;color:var(--green-mid);"></i>
                                <div>
                                    <div class="fw-bold" style="font-size:.9rem;color:var(--green-dark);">{{ auth()->user()->username }}</div>
                                    <div style="font-size:.78rem;color:var(--text-muted);">
                                        {{ auth()->user()->email }}
                                        @if(auth()->user()->gender) &bull; {{ ucfirst(auth()->user()->gender) }} @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form titipan --}}
                        <div id="otherInfo" class="mt-3" style="display:none;">
                            <div class="p-3" style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;">
                                <p style="font-size:.8rem;color:#92400e;margin-bottom:12px;">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jenis kelamin digunakan untuk menentukan ruangan yang sesuai.
                                </p>
                                <div class="mb-3">
                                    <label class="form-label" style="font-size:.85rem;font-weight:600;">Nama Penerima <span style="color:var(--red-main)">*</span></label>
                                    <input type="text" name="second_username" id="secondUsername"
                                        class="form-control @error('second_username') is-invalid @enderror"
                                        placeholder="Nama lengkap" value="{{ old('second_username') }}" style="border-radius:8px;">
                                    @error('second_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="form-label" style="font-size:.85rem;font-weight:600;">Jenis Kelamin <span style="color:var(--red-main)">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender_second" id="gs_laki" value="laki-laki" {{ old('gender_second')==='laki-laki'?'checked':'' }}>
                                            <label class="form-check-label" for="gs_laki" style="font-size:.85rem;">
                                                <i class="bi bi-gender-male me-1" style="color:#3b82f6;"></i>Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender_second" id="gs_perempuan" value="perempuan" {{ old('gender_second')==='perempuan'?'checked':'' }}>
                                            <label class="form-check-label" for="gs_perempuan" style="font-size:.85rem;">
                                                <i class="bi bi-gender-female me-1" style="color:#ec4899;"></i>Perempuan
                                            </label>
                                        </div>
                                    </div>
                                    @error('gender_second')<div class="text-danger" style="font-size:.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Pilih Tanggal --}}
                <div class="booking-step" id="step2">
                    <div class="step-header">
                        <span class="step-num">2</span>
                        <span class="step-title">Pilih Tanggal</span>
                    </div>
                    <div class="step-body">
                        @if(count($availableDates) === 0)
                            <div class="text-center py-3" style="color:var(--text-muted);font-size:.875rem;">
                                <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                                Belum ada jadwal tersedia. Hubungi admin untuk informasi jadwal.
                            </div>
                        @else
                        <div class="d-flex flex-wrap gap-2" id="dateList">
                            @foreach($availableDates as $d)
                                @php
                                    $carbon = \Carbon\Carbon::parse($d);
                                    $isSelected = old('date_booking') === $d;
                                @endphp
                                <button type="button" class="date-btn {{ $isSelected ? 'selected' : '' }}"
                                    data-date="{{ $d }}">
                                    <div style="font-size:.75rem;font-weight:600;opacity:.8;">{{ $carbon->isoFormat('ddd') }}</div>
                                    <div style="font-size:1.2rem;font-weight:800;line-height:1;">{{ $carbon->format('d') }}</div>
                                    <div style="font-size:.7rem;">{{ $carbon->isoFormat('MMM') }}</div>
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="date_booking" id="inputDate" value="{{ old('date_booking') }}">
                        @endif
                    </div>
                </div>

                {{-- STEP 3: Pilih Slot Waktu (UI Bioskop) --}}
                <div class="booking-step" id="step3">
                    <div class="step-header">
                        <span class="step-num">3</span>
                        <span class="step-title">Pilih Slot Waktu</span>
                    </div>
                    <div class="step-body">
                        <div id="slotLoading" style="display:none;" class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-success me-2"></div>
                            Memuat slot...
                        </div>
                        <div id="slotContainer">
                            <p style="font-size:.82rem;color:var(--text-muted);">Pilih tanggal terlebih dahulu.</p>
                        </div>
                        <input type="hidden" name="time_booking" id="inputTime">

                        {{-- Legenda --}}
                        <div class="d-flex gap-3 mt-3 flex-wrap" style="font-size:.75rem;">
                            <div class="d-flex align-items-center gap-1"><div class="legend-box available"></div>Tersedia</div>
                            <div class="d-flex align-items-center gap-1"><div class="legend-box selected-leg"></div>Dipilih</div>
                            <div class="d-flex align-items-center gap-1"><div class="legend-box full"></div>Penuh</div>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: Pilih Ruangan --}}
                <div class="booking-step" id="step4">
                    <div class="step-header">
                        <span class="step-num">4</span>
                        <span class="step-title">Pilih Ruangan</span>
                    </div>
                    <div class="step-body">
                        <div id="ruanganLoading" style="display:none;" class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-success me-2"></div>
                            Memuat ruangan...
                        </div>
                        <div id="ruanganContainer">
                            <p style="font-size:.82rem;color:var(--text-muted);">Pilih slot waktu terlebih dahulu.</p>
                        </div>
                    </div>
                </div>

                {{-- STEP 5: Metode Pembayaran --}}
                <div class="booking-step" id="step5">
                    <div class="step-header">
                        <span class="step-num">5</span>
                        <span class="step-title">Metode Pembayaran</span>
                    </div>
                    <div class="step-body">
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" name="payment_method" id="pm_online" value="online" class="d-none" {{ old('payment_method')==='online'?'checked':'' }}>
                                <label for="pm_online" class="pay-opt w-100">
                                    <i class="bi bi-credit-card-fill"></i>
                                    <div class="mt-1 fw-bold">Transfer Online</div>
                                    <div style="font-size:.72rem;opacity:.7;">Bayar via Midtrans</div>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="payment_method" id="pm_cash" value="cash" class="d-none" {{ old('payment_method','cash')==='cash'?'checked':'' }}>
                                <label for="pm_cash" class="pay-opt w-100">
                                    <i class="bi bi-cash-stack"></i>
                                    <div class="mt-1 fw-bold">Bayar Cash</div>
                                    <div style="font-size:.72rem;opacity:.7;">Bayar di tempat</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== KOLOM KANAN: Ringkasan ===== --}}
            <div class="col-lg-4">
                <div class="card sticky-top" style="top:80px;">
                    <div class="card-header" style="background:var(--green-dark);color:white;border-radius:12px 12px 0 0;">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Ringkasan Booking</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="summary-item">
                            <span class="summary-label">Layanan</span>
                            <span class="summary-value fw-bold">{{ $service->header_content ?: $service->name }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Pasien</span>
                            <span class="summary-value" id="summaryPasien">{{ auth()->user()->username }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Tanggal</span>
                            <span class="summary-value" id="summaryTanggal">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Jam</span>
                            <span class="summary-value" id="summaryJam">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Ruangan</span>
                            <span class="summary-value" id="summaryRuangan">-</span>
                        </div>
                        <hr>
                        <div class="summary-item">
                            <span class="summary-label fw-bold">Total</span>
                            <span class="summary-value fw-bold" style="color:var(--green-dark);font-size:1.1rem;">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit" id="submitBtn" class="btn w-100 py-3 mt-3" disabled
                            style="background:linear-gradient(135deg,var(--green-dark),var(--green-mid));color:white;border:none;border-radius:10px;font-weight:700;font-size:.95rem;opacity:.5;">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Booking
                        </button>
                        <p id="submitHint" style="font-size:.75rem;color:var(--text-muted);text-align:center;margin-top:8px;">
                            Lengkapi semua pilihan untuk melanjutkan
                        </p>
                    </div>
                </div>
            </div>

        </div>{{-- end row --}}
    </form>
</div>

@push('styles')
<style>
/* ===== STEP WRAPPER ===== */
.booking-step { background:white; border:1px solid var(--border-soft); border-radius:14px; margin-bottom:16px; overflow:hidden; }
.step-header { display:flex; align-items:center; gap:12px; padding:14px 18px; background:var(--bg-page); border-bottom:1px solid var(--border-soft); }
.step-num { width:28px; height:28px; border-radius:50%; background:var(--green-dark); color:white; font-weight:800; font-size:.8rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.step-title { font-weight:700; font-size:.92rem; color:var(--text-dark); }
.step-body { padding:16px 18px; }

/* ===== TANGGAL ===== */
.date-btn {
    border:2px solid var(--border-soft); border-radius:10px; background:white;
    padding:10px 14px; text-align:center; cursor:pointer; transition:all .2s;
    color:var(--text-dark); min-width:56px;
}
.date-btn:hover { border-color:var(--green-mid); background:var(--green-light); }
.date-btn.selected { border-color:var(--green-dark); background:var(--green-dark); color:white; }

/* ===== SLOT (BIOSKOP) ===== */
.slot-grid { display:flex; flex-wrap:wrap; gap:10px; }
.slot-card {
    border:2px solid var(--border-soft); border-radius:10px; padding:10px 14px;
    text-align:center; cursor:pointer; transition:all .2s; background:white;
    min-width:90px; position:relative;
}
.slot-card:hover:not(.full) { border-color:var(--green-mid); background:var(--green-light); }
.slot-card.selected { border-color:var(--green-dark); background:var(--green-dark); color:white; }
.slot-card.full { background:#f3f4f6; border-color:#e5e7eb; color:#9ca3af; cursor:not-allowed; }
.slot-card .slot-time { font-weight:800; font-size:1rem; }
.slot-card .slot-sisa { font-size:.68rem; margin-top:2px; }
.slot-card.selected .slot-sisa { color:rgba(255,255,255,.75); }
.slot-card.full .slot-sisa { color:#9ca3af; }
.slot-card .slot-sisa:not(.full) { color:var(--green-mid); }

/* ===== RUANGAN (BIOSKOP) ===== */
.ruangan-grid { display:flex; flex-direction:column; gap:10px; }
.ruangan-card {
    border:2px solid var(--border-soft); border-radius:12px; padding:14px 16px;
    cursor:pointer; transition:all .2s; background:white; display:flex; align-items:center; gap:14px;
}
.ruangan-card:hover:not(.full) { border-color:var(--green-mid); background:var(--green-light); }
.ruangan-card.selected { border-color:var(--green-dark); background:var(--green-dark); color:white; }
.ruangan-card.full { background:#f3f4f6; border-color:#e5e7eb; cursor:not-allowed; }
.ruangan-icon { width:44px; height:44px; border-radius:10px; background:var(--green-light); display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
.ruangan-card.selected .ruangan-icon { background:rgba(255,255,255,.2); }
.ruangan-card.full .ruangan-icon { background:#e5e7eb; }
.kursi-row { display:flex; gap:4px; flex-wrap:wrap; margin-top:6px; }
.kursi-dot { width:16px; height:16px; border-radius:4px; border:1.5px solid var(--border-soft); background:white; font-size:.6rem; display:flex; align-items:center; justify-content:center; }
.kursi-dot.booked { background:#fee2e2; border-color:#fca5a5; }
.kursi-dot.available { background:#d1fae5; border-color:#6ee7b7; }

/* ===== LEGENDA ===== */
.legend-box { width:16px; height:16px; border-radius:4px; }
.legend-box.available { background:#d1fae5; border:1.5px solid #6ee7b7; }
.legend-box.selected-leg { background:var(--green-dark); }
.legend-box.full { background:#f3f4f6; border:1.5px solid #e5e7eb; }

/* ===== PAYMENT ===== */
.pay-opt {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    padding:14px 12px; border:2px solid var(--border-soft); border-radius:12px;
    background:white; cursor:pointer; text-align:center; transition:all .2s;
    font-size:.875rem; color:var(--text-muted);
}
.pay-opt i { font-size:1.5rem; }
input[type=radio]:checked + .pay-opt { border-color:var(--green-mid); background:var(--green-light); color:var(--green-dark); }

/* ===== SUMMARY ===== */
.summary-item { display:flex; justify-content:space-between; align-items:flex-start; gap:8px; margin-bottom:10px; font-size:.85rem; }
.summary-label { color:var(--text-muted); flex-shrink:0; }
.summary-value { text-align:right; }
</style>
@endpush

@push('scripts')
<script>
const serviceId   = {{ $service->id }};
const slotsUrl    = '{{ route("customer.bookings.slots") }}';
const ruanganUrl  = '{{ route("customer.bookings.ruangan") }}';
const selfGender  = '{{ auth()->user()->gender ?? "" }}';

let selectedDate    = document.getElementById('inputDate').value || '';
let selectedJam     = document.getElementById('inputTime').value || '';
let selectedSlotId  = document.getElementById('inputWaktuBoking').value || '';
let selectedRoomId  = document.getElementById('inputRuangan').value || '';
let selectedRoomName = '';

// ======== UNTUK SIAPA ========
document.querySelectorAll('input[name="booking_for"]').forEach(r => {
    r.addEventListener('change', function() {
        document.getElementById('selfInfo').style.display   = this.value === 'self'  ? 'block' : 'none';
        document.getElementById('otherInfo').style.display  = this.value === 'other' ? 'block' : 'none';
        document.getElementById('secondUsername').required  = this.value === 'other';
        document.querySelectorAll('input[name="gender_second"]').forEach(g => g.required = this.value === 'other');

        updateSummaryPasien();
        // Reset slot & ruangan jika gender berubah
        resetSlotAndRoom();
        if (selectedDate) loadSlots(selectedDate);
    });
});

function getGenderPasien() {
    const isOther = document.getElementById('bf_other').checked;
    if (!isOther) return selfGender;
    const g = document.querySelector('input[name="gender_second"]:checked');
    return g ? g.value : '';
}

document.querySelectorAll('input[name="gender_second"]').forEach(r => {
    r.addEventListener('change', function() {
        resetSlotAndRoom();
        if (selectedDate) loadSlots(selectedDate);
    });
});

function updateSummaryPasien() {
    const isOther = document.getElementById('bf_other').checked;
    const name = isOther
        ? (document.getElementById('secondUsername').value || '-')
        : '{{ auth()->user()->username }}';
    document.getElementById('summaryPasien').textContent = name;
}
document.getElementById('secondUsername')?.addEventListener('input', updateSummaryPasien);

// ======== TANGGAL ========
document.querySelectorAll('.date-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        selectedDate = this.dataset.date;
        document.getElementById('inputDate').value = selectedDate;

        // Update summary
        const d = new Date(selectedDate + 'T00:00:00');
        const opts = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
        document.getElementById('summaryTanggal').textContent = d.toLocaleDateString('id-ID', opts);

        resetSlotAndRoom();
        loadSlots(selectedDate);
    });
});

// ======== LOAD SLOTS (AJAX) ========
function resetSlotAndRoom() {
    selectedJam    = '';
    selectedSlotId = '';
    selectedRoomId = '';
    selectedRoomName = '';
    document.getElementById('inputTime').value       = '';
    document.getElementById('inputWaktuBoking').value = '';
    document.getElementById('inputRuangan').value    = '';
    document.getElementById('summaryJam').textContent     = '-';
    document.getElementById('summaryRuangan').textContent = '-';
    document.getElementById('ruanganContainer').innerHTML = '<p style="font-size:.82rem;color:var(--text-muted);">Pilih slot waktu terlebih dahulu.</p>';
    checkSubmit();
}

function loadSlots(date) {
    const gender = getGenderPasien();
    document.getElementById('slotLoading').style.display    = 'block';
    document.getElementById('slotContainer').style.display  = 'none';

    const params = new URLSearchParams({ service_id: serviceId, date, gender });

    fetch(slotsUrl + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            document.getElementById('slotLoading').style.display   = 'none';
            document.getElementById('slotContainer').style.display = 'block';

            if (!data.slots || data.slots.length === 0) {
                document.getElementById('slotContainer').innerHTML =
                    '<p style="font-size:.82rem;color:var(--text-muted);"><i class="bi bi-calendar-x me-1"></i>' +
                    (data.message || 'Tidak ada slot tersedia.') + '</p>';
                return;
            }

            let html = '<div class="slot-grid">';
            data.slots.forEach(s => {
                const isFull  = s.is_full;
                const cls     = isFull ? 'full' : (selectedJam === s.jam ? 'selected' : '');
                const sisaTxt = isFull ? 'Penuh' : `${s.sisa} kursi`;
                html += `<div class="slot-card ${cls}" data-jam="${s.jam}" data-sisa="${s.sisa}" ${isFull ? '' : 'onclick="selectSlot(this)"'}>
                    <div class="slot-time">${s.jam}</div>
                    <div class="slot-sisa ${isFull ? 'full' : ''}">${sisaTxt}</div>
                </div>`;
            });
            html += '</div>';
            document.getElementById('slotContainer').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('slotLoading').style.display   = 'none';
            document.getElementById('slotContainer').style.display = 'block';
            document.getElementById('slotContainer').innerHTML = '<p class="text-danger small">Gagal memuat slot. Coba lagi.</p>';
        });
}

function selectSlot(el) {
    document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedJam = el.dataset.jam;
    document.getElementById('inputTime').value = selectedJam;
    document.getElementById('summaryJam').textContent = selectedJam + ' WIB';

    selectedSlotId = '';
    selectedRoomId = '';
    document.getElementById('inputWaktuBoking').value = '';
    document.getElementById('inputRuangan').value     = '';
    document.getElementById('summaryRuangan').textContent = '-';
    checkSubmit();

    loadRuangan(selectedDate, selectedJam);
}

// ======== LOAD RUANGAN (AJAX) ========
function loadRuangan(date, jam) {
    const gender = getGenderPasien();
    document.getElementById('ruanganLoading').style.display    = 'block';
    document.getElementById('ruanganContainer').style.display  = 'none';

    const params = new URLSearchParams({ date, jam, gender });

    fetch(ruanganUrl + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            document.getElementById('ruanganLoading').style.display   = 'none';
            document.getElementById('ruanganContainer').style.display = 'block';

            if (!data.ruangan || data.ruangan.length === 0) {
                document.getElementById('ruanganContainer').innerHTML =
                    '<p style="font-size:.82rem;color:var(--text-muted);"><i class="bi bi-door-closed me-1"></i>Tidak ada ruangan tersedia untuk slot ini.</p>';
                return;
            }

            let html = '<div class="ruangan-grid">';
            data.ruangan.forEach(r => {
                const isFull = r.is_full;
                const cls    = isFull ? 'full' : '';
                const icon   = r.gender === 'laki-laki' ? '♂' : (r.gender === 'perempuan' ? '♀' : '⚥');

                // Visualisasi kursi
                let kursiHtml = '<div class="kursi-row">';
                for (let i = 0; i < r.maximal; i++) {
                    const isBooked = i < r.booked;
                    kursiHtml += `<div class="kursi-dot ${isBooked ? 'booked' : 'available'}" title="${isBooked ? 'Terisi' : 'Tersedia'}">
                        ${isBooked ? '●' : '○'}
                    </div>`;
                }
                kursiHtml += '</div>';

                html += `<div class="ruangan-card ${cls}" data-slot-id="${r.id_waktu_boking}" data-room-id="${r.id_ruangan}" data-room-name="${r.nama_ruangan}" ${isFull ? '' : 'onclick="selectRuangan(this)"'}>
                    <div class="ruangan-icon">${icon}</div>
                    <div style="flex:1;">
                        <div class="fw-bold" style="font-size:.92rem;">${r.nama_ruangan}</div>
                        <div style="font-size:.75rem;opacity:.75;">${r.gender_label} &bull; Kapasitas ${r.maximal}</div>
                        ${kursiHtml}
                    </div>
                    <div class="text-end" style="flex-shrink:0;">
                        ${isFull
                            ? '<span style="font-size:.72rem;background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:50px;font-weight:600;">Penuh</span>'
                            : `<span style="font-size:.72rem;background:#d1fae5;color:#065f46;padding:3px 8px;border-radius:50px;font-weight:600;">${r.sisa} tersisa</span>`
                        }
                    </div>
                </div>`;
            });
            html += '</div>';
            document.getElementById('ruanganContainer').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('ruanganLoading').style.display   = 'none';
            document.getElementById('ruanganContainer').style.display = 'block';
            document.getElementById('ruanganContainer').innerHTML = '<p class="text-danger small">Gagal memuat ruangan.</p>';
        });
}

function selectRuangan(el) {
    document.querySelectorAll('.ruangan-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedSlotId   = el.dataset.slotId;
    selectedRoomId   = el.dataset.roomId;
    selectedRoomName = el.dataset.roomName;

    document.getElementById('inputWaktuBoking').value = selectedSlotId;
    document.getElementById('inputRuangan').value     = selectedRoomId;
    document.getElementById('summaryRuangan').textContent = selectedRoomName;
    checkSubmit();
}

// ======== VALIDASI & SUBMIT ========
function checkSubmit() {
    const btn   = document.getElementById('submitBtn');
    const hint  = document.getElementById('submitHint');
    const isOther = document.getElementById('bf_other').checked;
    const pmOk  = document.querySelector('input[name="payment_method"]:checked');

    const ready = selectedDate && selectedJam && selectedSlotId && selectedRoomId && pmOk
        && (!isOther || (document.getElementById('secondUsername').value.trim()
            && document.querySelector('input[name="gender_second"]:checked')));

    btn.disabled = !ready;
    btn.style.opacity = ready ? '1' : '.5';
    hint.style.display = ready ? 'none' : 'block';
}

document.querySelectorAll('input[name="payment_method"]').forEach(r => r.addEventListener('change', checkSubmit));

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    if (!selectedSlotId || !selectedRoomId) {
        e.preventDefault();
        alert('Pilih slot waktu dan ruangan terlebih dahulu.');
        return;
    }
    const isOther = document.getElementById('bf_other').checked;
    if (isOther) {
        if (!document.getElementById('secondUsername').value.trim()) {
            e.preventDefault(); alert('Isi nama penerima layanan.'); return;
        }
        if (!document.querySelector('input[name="gender_second"]:checked')) {
            e.preventDefault(); alert('Pilih jenis kelamin penerima.'); return;
        }
    }
});

// Init jika ada old value
if (selectedDate) loadSlots(selectedDate);
</script>
@endpush

@endsection
