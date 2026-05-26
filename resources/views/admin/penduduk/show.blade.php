@extends('layouts.admin')

@section('title', 'Detail Penduduk')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.penduduk.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card">
    <h6 class="fw-bold mb-3">{{ $penduduk->nama }}</h6>

    <table class="table table-borderless small">
        <tr><td class="text-muted" width="150">NIK</td><td><strong>{{ $penduduk->nik }}</strong></td></tr>
        <tr><td class="text-muted">No. KK</td><td>{{ $penduduk->no_kk }}</td></tr>
        <tr><td class="text-muted">Tempat/Tgl Lahir</td><td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d M Y') }}</td></tr>
        <tr><td class="text-muted">Jenis Kelamin</td><td>{{ $penduduk->jenis_kelamin }}</td></tr>
        <tr><td class="text-muted">Alamat</td><td>{{ $penduduk->alamat }}</td></tr>
        <tr><td class="text-muted">Pekerjaan</td><td>{{ $penduduk->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="text-muted">Pendidikan</td><td>{{ $penduduk->pendidikan ?? '-' }}</td></tr>
        <tr><td class="text-muted">Agama</td><td>{{ $penduduk->agama }}</td></tr>
        <tr><td class="text-muted">Status Perkawinan</td><td>{{ $penduduk->status_perkawinan }}</td></tr>
        <tr><td class="text-muted">Golongan Darah</td><td>{{ $penduduk->golongan_darah ?? '-' }}</td></tr>
    </table>

    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('admin.penduduk.edit', $penduduk) }}" class="btn btn-warning rounded-pill flex-grow-1">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('admin.penduduk.destroy', $penduduk) }}" method="POST" class="flex-grow-1">
            @csrf @method('DELETE')
            <button class="btn btn-danger rounded-pill w-100 btn-delete">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection
