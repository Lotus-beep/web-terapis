@extends('layouts.terapis')
@section('title','Rating & Komentar')
@section('page-title','Rating & Komentar')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-center p-4" style="background:linear-gradient(135deg,#b7950b,#f39c12);color:white">
            <div class="fs-1 fw-bold">{{ number_format($avgRating, 1) }}</div>
            <div class="mb-2">
                @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i<=round($avgRating)?'-fill':'' }} fs-5"></i>
                @endfor
            </div>
            <div class="small opacity-75">Rating Rata-rata dari {{ $comments->total() }} ulasan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-4">
        <h6 class="fw-bold mb-0">Semua Komentar Customer</h6>
    </div>
    <div class="card-body">
        @forelse($comments as $c)
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-semibold">{{ $c->customer->username ?? '-' }}</div>
                    <div class="text-warning mb-1">
                        @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i<=$c->rating?'-fill':'' }}"></i>
                        @endfor
                        <span class="text-muted ms-1 small">{{ $c->rating }}/5</span>
                    </div>
                    <p class="text-muted mb-0">{{ $c->comment }}</p>
                </div>
                <div class="text-muted small text-end">{{ $c->created_at->format('d M Y') }}</div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-chat-dots fs-1 d-block mb-3"></i>
            <h5>Belum ada komentar</h5>
        </div>
        @endforelse
    </div>
    <div class="card-footer bg-white">{{ $comments->links() }}</div>
</div>
@endsection
