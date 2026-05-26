@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<h5 class="fw-bold mb-3">
    <i class="bi bi-gear"></i> Pengaturan
</h5>

<!-- Informasi Desa -->
<div class="stat-card mb-3">
    <h6 class="fw-bold mb-3">Informasi Desa</h6>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-bold">Desa</label>
            <input type="text" name="nama_desa" class="form-control" value="{{ $setting->nama_desa }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" value="{{ $setting->kecamatan }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Kabupaten</label>
            <input type="text" name="kabupaten" class="form-control" value="{{ $setting->kabupaten }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Provinsi</label>
            <input type="text" name="provinsi" class="form-control" value="{{ $setting->provinsi }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Logo Desa</label>
            @if($setting->logo)
                <img src="{{ Storage::url($setting->logo) }}" class="d-block mb-2" style="width:60px;">
            @endif
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Secret Key Verifikasi</label>
            <input type="text" name="secret_key" class="form-control" value="{{ $setting->secret_key }}" required>
            <small class="text-muted">Minimal 10 karakter. Digunakan untuk generate kode verifikasi.</small>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Simpan Perubahan
        </button>
    </form>
</div>

<!-- Backup Database -->
<div class="stat-card">
    <h6 class="fw-bold mb-3"><i class="bi bi-database"></i> Backup Data</h6>
    <p class="small text-muted">Backup otomatis setiap hari pukul 02:00.<br>Backup terakhir: {{ $setting->updated_at ? $setting->updated_at->format('d M Y, H:i') : '-' }}</p>
    <form action="{{ route('admin.settings.backup') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-primary rounded-pill btn-sm">
            <i class="bi bi-download"></i> Backup Manual Sekarang
        </button>
    </form>
</div>
@endsection
