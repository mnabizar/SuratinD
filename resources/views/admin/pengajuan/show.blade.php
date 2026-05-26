@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card mb-3">
    <h6 class="fw-bold mb-3">Detail Pengajuan #{{ $pengajuan->id }}</h6>

    <div class="mb-3">
        <span class="badge badge-{{ $pengajuan->status }} fs-6">{{ ucfirst($pengajuan->status) }}</span>
    </div>

    <table class="table table-borderless small">
        <tr>
            <td class="text-muted" width="140">Pemohon</td>
            <td><strong>{{ $pengajuan->user->name }}</strong></td>
        </tr>
        <tr>
            <td class="text-muted">NIK</td>
            <td>{{ $pengajuan->user->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">Jenis Surat</td>
            <td>{{ \App\Models\PengajuanSurat::jenisSuratList()[$pengajuan->jenis_surat] ?? $pengajuan->jenis_surat }}</td>
        </tr>
        <tr>
            <td class="text-muted">Tujuan/Keperluan</td>
            <td>{{ $pengajuan->tujuan_surat }}</td>
        </tr>
        <tr>
            <td class="text-muted">Keterangan</td>
            <td>{{ $pengajuan->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">Tanggal Ajukan</td>
            <td>{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
        </tr>
        @if($pengajuan->catatan_admin)
        <tr>
            <td class="text-muted">Catatan Admin</td>
            <td>{{ $pengajuan->catatan_admin }}</td>
        </tr>
        @endif
    </table>
</div>

<!-- File Pendukung -->
<div class="stat-card mb-3">
    <h6 class="fw-bold mb-3">Dokumen Pendukung</h6>
    @if($pengajuan->file_pendukung)
        @foreach($pengajuan->file_pendukung as $key => $file)
        <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded">
            <i class="bi bi-file-earmark text-primary"></i>
            <span class="small flex-grow-1">{{ strtoupper($key) }}</span>
            <a href="{{ Storage::url($file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye"></i>
            </a>
        </div>
        @endforeach
    @else
        <p class="text-muted small">Tidak ada dokumen pendukung.</p>
    @endif
</div>

<!-- Actions -->
@if($pengajuan->status === 'pending' && auth()->user()->isAdmin())
<div class="stat-card">
    <h6 class="fw-bold mb-3">Tindakan</h6>

    <!-- Process -->
    <form action="{{ route('admin.pengajuan.process', $pengajuan) }}" method="POST" class="mb-3">
        @csrf
        <button class="btn btn-info w-100 rounded-pill text-white">
            <i class="bi bi-arrow-repeat"></i> Tandai Diproses
        </button>
    </form>

    <!-- Approve -->
    <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST" class="mb-3">
        @csrf
        <div class="mb-2">
            <textarea name="catatan_admin" class="form-control form-control-sm" rows="2"
                      placeholder="Catatan (opsional)"></textarea>
        </div>
        <button class="btn btn-success w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Setujui & Terbitkan Surat
        </button>
    </form>

    <!-- Reject -->
    <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" method="POST">
        @csrf
        <div class="mb-2">
            <textarea name="catatan_admin" class="form-control form-control-sm" rows="2"
                      placeholder="Alasan penolakan (wajib)" required></textarea>
        </div>
        <button class="btn btn-danger w-100 rounded-pill">
            <i class="bi bi-x-lg"></i> Tolak Pengajuan
        </button>
    </form>
</div>
@endif

@if($pengajuan->status === 'diproses' && auth()->user()->isAdmin())
<div class="stat-card">
    <h6 class="fw-bold mb-3">Tindakan</h6>
    <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST" class="mb-3">
        @csrf
        <div class="mb-2">
            <textarea name="catatan_admin" class="form-control form-control-sm" rows="2"
                      placeholder="Catatan (opsional)"></textarea>
        </div>
        <button class="btn btn-success w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Setujui & Terbitkan Surat
        </button>
    </form>
    <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" method="POST">
        @csrf
        <div class="mb-2">
            <textarea name="catatan_admin" class="form-control form-control-sm" rows="2"
                      placeholder="Alasan penolakan (wajib)" required></textarea>
        </div>
        <button class="btn btn-danger w-100 rounded-pill">
            <i class="bi bi-x-lg"></i> Tolak Pengajuan
        </button>
    </form>
</div>
@endif

<!-- Surat yang diterbitkan -->
@if($pengajuan->surat)
<div class="stat-card mt-3">
    <h6 class="fw-bold mb-3">Surat Diterbitkan</h6>
    <table class="table table-borderless small">
        <tr>
            <td class="text-muted">Nomor Surat</td>
            <td><strong>{{ $pengajuan->surat->nomor_surat }}</strong></td>
        </tr>
        <tr>
            <td class="text-muted">Tanggal Terbit</td>
            <td>{{ $pengajuan->surat->tanggal_terbit->format('d M Y') }}</td>
        </tr>
        <tr>
            <td class="text-muted">Kode Verifikasi</td>
            <td><code class="small">{{ Str::limit($pengajuan->surat->verification_code, 20) }}...</code></td>
        </tr>
    </table>
    <a href="{{ route('admin.surat.cetak', $pengajuan->surat) }}" class="btn btn-primary rounded-pill btn-sm">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
</div>
@endif
@endsection
