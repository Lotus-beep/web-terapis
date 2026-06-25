@extends('layouts.admin')
@section('title', 'Kelola Sesi Layanan')
@section('page-title', 'Kelola Sesi Layanan')
@section('content')
<div class="row">
    <div class="col-lg-12">
        
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs border-bottom-0 mb-4" id="sessionTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold text-success border-success" id="master-tab" data-bs-toggle="tab" data-bs-target="#master-pane" type="button" role="tab" style="border-radius: 10px 10px 0 0;">
                    <i class="bi bi-clock-history me-1"></i> Master Sesi Waktu
                </button>
            </li>
            <li class="nav-item ms-2">
                <button class="nav-link fw-bold text-success" id="holiday-tab" data-bs-toggle="tab" data-bs-target="#holiday-pane" type="button" role="tab" style="border-radius: 10px 10px 0 0;">
                    <i class="bi bi-calendar-x me-1"></i> Hari Libur / Tutup Klinik
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="sessionTabsContent">
            
            <!-- TAB 1: MASTER SESI WAKTU -->
            <div class="tab-pane fade show active" id="master-pane" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-white border-0 pt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Daftar Template Sesi Waktu (Berlaku Setiap Hari)</h6>
                            <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Tambah Master Sesi
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                             <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Sesi</th>
                                    <th>Waktu Operasional Sesi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                <tr>
                                    <td>{{ $loop->iteration + ($sessions->firstItem() - 1) }}</td>
                                    <td>
                                        <strong><span class="text-success">{{ $session->nama_sesi ?: 'Sesi ' . $loop->iteration }}</span></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary fs-6">{{ $session->jam_mulai }} - {{ $session->jam_selesai }} WIB</span>
                                    </td>
                                    <td>
                                        @if($session->active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.sessions.edit', $session->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.sessions.destroy', $session->id) }}" class="d-inline" onsubmit="return confirm('Hapus master sesi jam ini? Pemesanan aktif di masa mendatang pada jam ini akan terpengaruh.')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada master sesi jam layanan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $sessions->appends(request()->except('sessions_page'))->links() }}
                    </div>
                </div>
            </div>

            <!-- TAB 2: HARI LIBUR / TUTUP KLINIK -->
            <div class="tab-pane fade" id="holiday-pane" role="tabpanel">
                <div class="row">
                    <!-- Form Tambah Hari Libur -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-white border-0 pt-4">
                                <h6 class="fw-bold mb-0">Atur Tanggal Libur/Tutup</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.sessions.store-holiday') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Libur <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required min="{{ date('Y-m-d') }}">
                                        <div class="form-text">Pada tanggal ini, klinik akan ditandai libur dan customer tidak bisa melakukan booking.</div>
                                    </div>
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-calendar-minus me-1"></i>Simpan Tanggal Libur
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Hari Libur -->
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-white border-0 pt-4">
                                <h6 class="fw-bold mb-0">Tanggal Klinik Tutup / Libur</h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Hari & Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($holidays as $holiday)
                                        <tr>
                                            <td>{{ $loop->iteration + ($holidays->firstItem() - 1) }}</td>
                                            <td>
                                                <strong class="text-danger">
                                                    {{ $holiday->tanggal->isoFormat('dddd, D MMMM Y') }}
                                                </strong>
                                            </td>
                                            <td><span class="badge bg-danger">Tutup Operasional</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.sessions.destroy-holiday', $holiday->id) }}" class="d-inline" onsubmit="return confirm('Buka kembali klinik pada tanggal ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-unlock-fill me-1"></i>Buka Kembali
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada jadwal hari libur terdaftar. Klinik buka setiap hari.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-white">
                                {{ $holidays->appends(request()->except('holidays_page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    // Keep active tab state on reload
    document.addEventListener("DOMContentLoaded", function() {
        var activeTab = localStorage.getItem('activeSessionTab');
        if (activeTab) {
            var tabEl = document.querySelector('#sessionTabs button[data-bs-target="' + activeTab + '"]');
            if (tabEl) {
                var tab = new bootstrap.Tab(tabEl);
                tab.show();
            }
        }
        
        var tabButtons = document.querySelectorAll('#sessionTabs button');
        tabButtons.forEach(function(button) {
            button.addEventListener('shown.bs.tab', function(event) {
                localStorage.setItem('activeSessionTab', event.target.getAttribute('data-bs-target'));
                // Highlight borders
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-success');
                    btn.style.borderBottom = 'none';
                });
                event.target.classList.add('border-success');
            });
        });
    });
</script>
@endpush
@endsection
