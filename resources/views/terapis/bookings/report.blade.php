@extends('layouts.terapis')
@section('title','Isi Laporan Terapi')
@section('page-title','Isi Laporan Terapi')
@section('content')

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laporan Terapi Booking #{{ $booking->id }}</h6>
        <a href="{{ route('terapis.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('terapis.bookings.store-report', $booking->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Keluhan Pasien Sebelum Terapi</label>
                <textarea name="keluhan_sebelum" class="form-control" rows="3">{{ old('keluhan_sebelum', $booking->therapyReport->keluhan_sebelum ?? $booking->keluhan ?? '') }}</textarea>
            </div>

            <h6 class="fw-bold mt-4 mb-3">Hasil Pemeriksaan Awal</h6>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Tekanan Darah (contoh: 120/80 mmHg)</label>
                    <input type="text" name="tekanan_darah" class="form-control" value="{{ old('tekanan_darah', $booking->therapyReport->tekanan_darah ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Suhu Tubuh (contoh: 36.5 °C)</label>
                    <input type="text" name="suhu_tubuh" class="form-control" value="{{ old('suhu_tubuh', $booking->therapyReport->suhu_tubuh ?? '') }}" required autofocus>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi Umum (contoh: Stabil, Lemah)</label>
                    <input type="text" name="kondisi_umum" class="form-control" value="{{ old('kondisi_umum', $booking->therapyReport->kondisi_umum ?? '') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Area Keluhan (contoh: Bahu dan Punggung)</label>
                    <input type="text" name="area_keluhan" class="form-control" value="{{ old('area_keluhan', $booking->therapyReport->area_keluhan ?? '') }}">
                </div>
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label fw-bold">Tindakan Terapi</label>
                <div class="form-text mb-2">Tuliskan area terapi dan keterangan. Contoh: Al-Kahil (Dilakukan), Punggung (Dilakukan). Gunakan baris baru untuk setiap tindakan.</div>
                @php
                    $tindakan = '';
                    if (isset($booking->therapyReport) && $booking->therapyReport->tindakan_terapi) {
                        $tindakan = json_decode($booking->therapyReport->tindakan_terapi);
                    }
                @endphp
                <textarea name="tindakan_terapi" class="form-control" rows="4">{{ old('tindakan_terapi', $tindakan) }}</textarea>
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label fw-bold">Hasil Setelah Terapi</label>
                <div class="form-text mb-2">Tuliskan parameter, sebelum, sesudah, dan keterangan. Contoh: Tingkat Nyeri (Sebelum: 8/10, Sesudah: 4/10, Keterangan: Membaik). Gunakan baris baru untuk setiap parameter.</div>
                @php
                    $hasil = '';
                    if (isset($booking->therapyReport) && $booking->therapyReport->hasil_setelah_terapi) {
                        $hasil = json_decode($booking->therapyReport->hasil_setelah_terapi);
                    }
                @endphp
                <textarea name="hasil_setelah_terapi" class="form-control" rows="4">{{ old('hasil_setelah_terapi', $hasil) }}</textarea>
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label fw-bold">Catatan Terapis</label>
                <textarea name="catatan_terapis" class="form-control" rows="3">{{ old('catatan_terapis', $booking->therapyReport->catatan_terapis ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Saran Terapis</label>
                <textarea name="saran_terapis" class="form-control" rows="3">{{ old('saran_terapis', $booking->therapyReport->saran_terapis ?? '') }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
