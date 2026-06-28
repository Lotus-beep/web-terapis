@extends('layouts.admin')
@section('title','Kelola Transaksi')
@section('page-title','Kelola Transaksi')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Daftar Booking</h6>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-3">
                <select name="status_service" class="form-select form-select-sm">
                    <option value="">Semua Status Service</option>
                    @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status_service')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status_payment" class="form-select form-select-sm">
                    <option value="">Semua Status Bayar</option>
                    @foreach(['unpaid','waiting_confirmation','paid','rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status_payment')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-filter"></i> Filter</button></div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Kode transaksi</th><th>Customer</th><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status Service</th><th>Total Harga</th><th>Status Bayar</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $b)
                    @php
                        $sc=['pending'=>'warning','confirmed'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
                        $pc=['unpaid'=>'secondary','waiting_confirmation'=>'warning','paid'=>'success','rejected'=>'danger'];
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $b->kode_booking }}</span></td>
                        <td>{{ $b->customer->username ?? '-' }}</td>
                        <td>{{ $b->service->name_service ?? '-' }}</td>
                        <td>{{ $b->terapis->username ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->date_booking)->format('d M Y') }}</td>
                        <td><span class="badge bg-{{ $sc[$b->status_service]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_service)) }}</span></td>
                        <td>{{ 'Rp'.$b->service->name_service ?? '-' }}</td>
                        <td><span class="badge bg-{{ $pc[$b->status_payment]??'secondary' }}">{{ ucfirst(str_replace('_',' ',$b->status_payment)) }}</span></td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $b->id) }}" class="d-inline" onsubmit="return confirm('Hapus booking ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            <a href="{{ route('admin.transaksi.export', request()->query()) }}"
                            class="btn btn-success">
                                <i class="bi bi-file-earmark-excel"></i>
                                Export Excel
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $transaksi->withQueryString()->links() }}</div>
</div>
@endsection
