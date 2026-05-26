@extends('layouts.admin')

@section('title', 'Detail Surat')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card mb-3">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <h6 class="fw-bold mb-0">Detail Surat</h6>
        <span class="badge {{ $surat->status === 'diterbitkan' ? 'bg-success' : 'bg-secondary' }}">
            {{ ucfirst($surat->status) }}
        </span>
    </div>

    <table class="table table-borderless small">
        <tr>
            <td class="text-muted" width="130">Nomor Surat</td>
            <td><strong>{{ $surat->nomor_surat }}</strong></td>
        </tr>
        <tr>
            <td class="text-muted">Jenis</td>
            <td>{{ \App\Models\PengajuanSurat::jenisSuratList()[$surat->jenis_surat] ?? $surat->jenis_surat }}</td>
        </tr>
        <tr>
            <td class="text-muted">Pemohon</td>
            <td>{{ $surat->penduduk->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">NIK</td>
            <td>{{ $surat->penduduk->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">Tanggal Terbit</td>
            <td>{{ $surat->tanggal_terbit->format('d M Y') }}</td>
        </tr>
        <tr>
            <td class="text-muted">Dibuat Oleh</td>
            <td>{{ $surat->creator->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">Kode Verifikasi</td>
            <td><code style="word-break:break-all;font-size:0.65rem;">{{ $surat->verification_code }}</code></td>
        </tr>
    </table>
</div>

<div class="stat-card mb-3">
    <h6 class="fw-bold mb-2">Isi Surat</h6>
    <div class="bg-light p-3 rounded small" style="white-space:pre-wrap;">{{ $surat->isi_surat }}</div>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('admin.surat.cetak', $surat) }}" class="btn btn-success rounded-pill flex-grow-1">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
    <a href="{{ route('admin.surat.edit', $surat) }}" class="btn btn-outline-warning rounded-pill">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="{{ route('admin.surat.destroy', $surat) }}" method="POST">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger rounded-pill btn-delete">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
@endsection
