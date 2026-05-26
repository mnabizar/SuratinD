@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="mb-3">
    <h6 class="fw-bold">Halo, {{ auth()->user()->name }}! 👋</h6>
    <small class="text-muted">Selamat datang di Portal Masyarakat SuratinD</small>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-6">
        <div class="card-stat">
            <div class="number text-primary">{{ $totalPengajuan }}</div>
            <div class="label">Total Pengajuan</div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-stat">
            <div class="number text-info">{{ $diproses }}</div>
            <div class="label">Diproses</div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-stat">
            <div class="number text-success">{{ $disetujui }}</div>
            <div class="label">Disetujui</div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-stat">
            <div class="number text-danger">{{ $ditolak }}</div>
            <div class="label">Ditolak</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<a href="{{ route('user.pengajuan.create') }}" class="btn btn-primary w-100 rounded-pill mb-4">
    <i class="bi bi-plus-lg"></i> Ajukan Surat Baru
</a>

<!-- Pengajuan Terbaru -->
<h6 class="fw-bold mb-3">Pengajuan Terbaru</h6>
@forelse($pengajuanTerbaru as $item)
<div class="card-stat mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong class="small">{{ \App\Models\PengajuanSurat::jenisSuratList()[$item->jenis_surat] ?? $item->jenis_surat }}</strong>
            <div class="text-muted" style="font-size:0.7rem;">{{ $item->created_at->format('d M Y') }}</div>
        </div>
        <span class="badge badge-{{ $item->status }} small">{{ ucfirst($item->status) }}</span>
    </div>
</div>
@empty
<div class="text-center py-4">
    <i class="bi bi-file-earmark display-4 text-muted"></i>
    <p class="text-muted small mt-2">Belum ada pengajuan surat.</p>
</div>
@endforelse

<!-- Verifikasi Link -->
<div class="card-stat mt-4 text-center">
    <i class="bi bi-shield-check text-success fs-3"></i>
    <p class="small mb-2 fw-bold">Verifikasi Surat</p>
    <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-success btn-sm rounded-pill">
        Cek Keaslian Surat
    </a>
</div>
@endsection
