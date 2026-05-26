@extends('layouts.user')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="mb-3">
    <a href="{{ route('user.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-stat mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Pengajuan</h6>
        <span class="badge badge-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
    </div>

    <table class="table table-borderless small mb-0">
        <tr>
            <td class="text-muted" width="120">Jenis Surat</td>
            <td>{{ \App\Models\PengajuanSurat::jenisSuratList()[$pengajuan->jenis_surat] ?? $pengajuan->jenis_surat }}</td>
        </tr>
        <tr>
            <td class="text-muted">Tujuan</td>
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
            <td class="text-danger">{{ $pengajuan->catatan_admin }}</td>
        </tr>
        @endif
    </table>
</div>

<!-- Timeline Status -->
<div class="card-stat mb-3">
    <h6 class="fw-bold mb-3 small">Timeline Status</h6>
    <div class="d-flex flex-column gap-2">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                <i class="bi bi-check text-white" style="font-size:0.7rem;"></i>
            </div>
            <small>Pengajuan dikirim - {{ $pengajuan->created_at->format('d M Y') }}</small>
        </div>
        @if(in_array($pengajuan->status, ['diproses','disetujui','selesai']))
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                <i class="bi bi-arrow-repeat text-white" style="font-size:0.7rem;"></i>
            </div>
            <small>Sedang diproses</small>
        </div>
        @endif
        @if(in_array($pengajuan->status, ['disetujui','selesai']))
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                <i class="bi bi-check-all text-white" style="font-size:0.7rem;"></i>
            </div>
            <small>Disetujui</small>
        </div>
        @endif
        @if($pengajuan->status === 'ditolak')
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                <i class="bi bi-x text-white" style="font-size:0.7rem;"></i>
            </div>
            <small class="text-danger">Ditolak</small>
        </div>
        @endif
    </div>
</div>

<!-- Download -->
@if($pengajuan->surat && $pengajuan->status === 'selesai')
<a href="{{ route('user.pengajuan.download', $pengajuan) }}" class="btn btn-success w-100 rounded-pill">
    <i class="bi bi-download"></i> Download Surat PDF
</a>

<div class="card-stat mt-3 text-center">
    <small class="text-muted">Kode Verifikasi:</small>
    <div class="bg-light p-2 rounded mt-1">
        <code style="font-size:0.6rem;word-break:break-all;">{{ $pengajuan->surat->verification_code }}</code>
    </div>
</div>
@endif
@endsection
