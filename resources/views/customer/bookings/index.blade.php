@extends('layouts.customer')
@section('title','Riwayat Booking')
@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Booking</h4>
            <p class="text-muted mb-0">Semua booking layanan bekam Anda</p>
        </div>
        <a href="{{ route('customer.services.index') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Booking Baru</a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" class="d-flex gap-3 align-items-center flex-wrap">
                <label class="small fw-semibold mb-0">Filter Status:</label>
                @foreach([''=>'Semua','pending'=>'Pending','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$label)
                    <a href="{{ route('customer.bookings.index', ['status_service'=>$val]) }}"
                       class="btn btn-sm {{ request('status_service')===$val ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Layanan</th><th>Terapis</th><th>Lokasi</th><th>Tanggal</th><th>Status</th><th>Pembayaran</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        @php
                            $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
                            $pc=['unpaid'=>'secondary','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger'];
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->service->name_service ?? '-' }}</td>
                            <td>{{ $b->terapis->username ?? '-' }}</td>
                            <td>{{ $b->service->location->name_location ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->date_booking)->format('d M Y') }}</td>
                            <td><span class="badge bg-{{ $sc[$b->status_service]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_service)) }}</span></td>
                            <td><span class="badge bg-{{ $pc[$b->status_payment]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_payment)) }}</span></td>
                            <td>
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                @if($b->status_service === 'pending')
                                    <form method="POST" action="{{ route('customer.bookings.cancel', $b->id) }}" class="d-inline" onsubmit="return confirm('Batalkan booking ini?')">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada booking</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $bookings->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
