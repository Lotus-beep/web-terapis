@extends('layouts.admin')
@section('title','Komentar Customer')
@section('page-title','Komentar Customer')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Daftar Ulasan Customer</h6>
        <form class="row g-2 mt-2" method="GET">
            <div class="col-md-4">
                <select name="id_terapis" class="form-select form-select-sm">
                    <option value="">Semua Terapis</option>
                    @foreach($terapis as $t)
                        <option value="{{ $t->id }}" {{ request('id_terapis')==$t->id?'selected':'' }}>{{ $t->username }}</option>
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
                    <tr><th>#</th><th>Customer</th><th>Kode Booking</th><th>Terapis</th><th>Ulasan</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $c->customer->username ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $c->booking->kode_booking ?? '-' }}</span></td>
                        <td>{{ $c->terapis->username ?? '-' }}</td>
                        <td style="max-width:300px">{{ $c->comment }}</td>
                        <td>{{ $c->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada ulasan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $comments->withQueryString()->links() }}</div>
</div>
@endsection
