@extends('layouts.terapis')
@section('title','Booking Masuk')
@section('page-title','Booking Masuk')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Daftar Booking</h6>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-3">
                <select name="status_service" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                        <option value="{{ $v }}" {{ request('status_service')===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <div class="col-auto"><button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-filter"></i></button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Kode Booking</th><th>Customer</th><th>Layanan</th><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Bayar</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    @php
                        $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
                        $pc=['unpaid'=>'secondary','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger'];
                        $today=today()->toDateString();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $b->kode_booking }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $b->customer->username ?? '-' }}</div>
                            <div class="text-muted small">{{ $b->customer->no_telepon ?? '' }}</div>
                        </td>
                        <td>{{ $b->service->name_service ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->date_booking)->format('d M Y') }}</td>
                        <td>{{ $b->formatted_time }}</td>
                        <td><span class="badge bg-{{ $sc[$b->status_service]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_service)) }}</span></td>
                        <td><span class="badge bg-{{ $pc[$b->status_payment]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_payment)) }}</span></td>
                        <td>
                           @if($b->date_booking->isToday())
                            @if($b->status_service === 'pending')
                                <form method="POST" action="{{ route('terapis.bookings.confirm', $b->id) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Konfirmasi"><i class="bi bi-check-lg"></i></button>
                                </form>
                            @elseif($b->status_service === 'confirmed')
                                <form method="POST" action="{{ route('terapis.bookings.update-status', $b->id) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status_service" value="in_progress">
                                    <button class="btn btn-sm btn-primary" title="Mulai"><i class="bi bi-play-fill"></i></button>
                                </form>
                            @elseif($b->status_service === 'in_progress')
                                <form method="POST" action="{{ route('terapis.bookings.update-status', $b->id) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status_service" value="completed">
                                    <button class="btn btn-sm btn-info" title="Selesai"><i class="bi bi-check-circle"></i></button>
                                </form>
                            @endif
                           @endif

                            @if(in_array($b->status_service, ['in_progress', 'completed']))
                                <a href="{{ route('terapis.bookings.report', $b->id) }}" class="btn btn-sm btn-secondary" title="Isi Laporan">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </a>
                                @if($b->therapyReport)
                                <a href="{{ route('terapis.bookings.export-word', $b->id) }}" class="btn btn-sm btn-outline-primary" title="Download Word">
                                    <i class="bi bi-file-word"></i>
                                </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $bookings->withQueryString()->links() }}</div>
</div>
@endsection
