@extends('layouts.admin')
@section('title','Komentar Customer')
@section('page-title','Komentar Customer')
@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Daftar Komentar & Rating</h6>
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
                    <tr><th>#</th><th>Customer</th><th>Terapis</th><th>Rating</th><th>Komentar</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $c->customer->username ?? '-' }}</td>
                        <td>{{ $c->terapis->username ?? '-' }}</td>
                        <td>
                            <span class="text-warning">
                                @for($i=1;$i<=5;$i++)
                                    <i class="bi bi-star{{ $i<=$c->rating?'-fill':'' }}"></i>
                                @endfor
                            </span>
                            <span class="ms-1 small fw-bold">{{ $c->rating }}/5</span>
                        </td>
                        <td style="max-width:300px">{{ $c->comment }}</td>
                        <td>{{ $c->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada komentar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $comments->withQueryString()->links() }}</div>
</div>
@endsection
