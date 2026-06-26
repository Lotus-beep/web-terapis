@extends('layouts.admin')
@section('title', 'Pengaturan Klinik')
@section('page-title', 'Pengaturan Klinik')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-gear-fill" style="color:var(--green-mid);"></i>
                Informasi & Lokasi Klinik
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.clinic-settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Klinik <span class="text-danger">*</span></label>
                        <input type="text" name="clinic_name" class="form-control" value="{{ old('clinic_name', $settings['clinic_name'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="clinic_phone" class="form-control" value="{{ old('clinic_phone', $settings['clinic_phone'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="clinic_hours" class="form-control" value="{{ old('clinic_hours', $settings['clinic_hours'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="clinic_address" class="form-control" rows="3" required>{{ old('clinic_address', $settings['clinic_address'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Google Maps (Link Maps)</label>
                        <input type="url" name="maps_link" class="form-control" value="{{ old('maps_link', $settings['maps_link'] ?? '') }}" placeholder="https://maps.google.com/?q=...">
                        <div class="form-text">Tautan yang akan terbuka saat user klik 'Buka di Maps'.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Google Maps Embed URL (iframe src)</label>
                        <textarea name="maps_embed_url" class="form-control" rows="3" placeholder="https://www.google.com/maps/embed?...">{{ old('maps_embed_url', $settings['maps_embed_url'] ?? '') }}</textarea>
                        <div class="form-text">Ambil URL dari fitur 'Embed a map' di Google Maps (hanya bagian src="..." nya saja).</div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Panduan Embed Maps
            </div>
            <div class="card-body" style="font-size: .85rem; color: var(--text-muted);">
                <ol class="ps-3 mb-0">
                    <li class="mb-2">Buka lokasi klinik Anda di <strong>Google Maps</strong>.</li>
                    <li class="mb-2">Klik tombol <strong>Bagikan (Share)</strong>.</li>
                    <li class="mb-2">Pilih tab <strong>Sematkan Peta (Embed a map)</strong>.</li>
                    <li class="mb-2">Klik <strong>Salin HTML</strong>.</li>
                    <li class="mb-2">Paste di notepad, dan ambil URL di dalam atribut <code>src="..."</code> saja.</li>
                    <li>Masukkan URL tersebut ke form "Google Maps Embed URL" di samping.</li>
                </ol>
            </div>
        </div>

        @if(!empty($settings['maps_embed_url']))
        <div class="card">
            <div class="card-header">
                <i class="bi bi-geo-alt me-2"></i>Preview Maps
            </div>
            <div class="card-body p-0">
                <iframe src="{{ $settings['maps_embed_url'] }}" width="100%" height="250" style="border:0; border-radius: 0 0 14px 14px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
