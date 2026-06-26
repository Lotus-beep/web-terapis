@extends('layouts.terapis')
@section('title','Ulasan Pelanggan')
@section('page-title','Ulasan Pelanggan')
@section('content')

<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Semua Ulasan Customer</h6>
    </div>
    <div class="card-body">
        @forelse($comments as $c)
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-semibold mb-1">
                        {{ $c->customer->username ?? '-' }}
                        @if($c->booking)
                        <span class="badge bg-secondary ms-2 fw-normal" style="font-size:.7rem;">{{ $c->booking->kode_booking }}</span>
                        @endif
                    </div>
                    <p class="text-muted mb-0">{{ $c->comment }}</p>
                </div>
                <div class="text-muted small text-end">{{ $c->created_at->format('d M Y') }}</div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-chat-dots fs-1 d-block mb-3"></i>
            <h5>Belum ada ulasan</h5>
        </div>
        @endforelse
    </div>
    <div class="card-footer bg-white">{{ $comments->links() }}</div>
</div>
@endsection
