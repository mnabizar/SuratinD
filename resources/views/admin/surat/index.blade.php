@extends('layouts.admin')

@section('title', 'Kelola Surat')

@section('content')
<h5 class="fw-bold mb-3">
    <i class="bi bi-file-earmark-text"></i> Kelola Surat
</h5>

<a href="{{ route('admin.surat.create') }}" class="btn btn-success w-100 rounded-pill mb-3">
    <i class="bi bi-plus-lg"></i> Tambah Surat
</a>

<!-- Search -->
<form action="{{ route('admin.surat.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control rounded-pill" placeholder="Cari nomor surat, nama..."
               value="{{ request('search') }}">
        <button class="btn btn-outline-primary rounded-pill ms-2" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

<!-- Surat List -->
@forelse($surat as $item)
<div class="stat-card mb-3">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <strong class="small">{{ \App\Models\PengajuanSurat::jenisSuratList()[$item->jenis_surat] ?? $item->jenis_surat }}</strong>
            <span class="badge {{ $item->status === 'diterbitkan' ? 'bg-success' : ($item->status === 'draft' ? 'bg-secondary' : 'bg-danger') }} ms-1">{{ $item->status }}</span>
        </div>
    </div>
    <div class="small text-muted">
        {{ $item->nomor_surat }}<br>
        {{ $item->penduduk->nama ?? '-' }} • {{ $item->penduduk->nik ?? '-' }}<br>
        Kode: {{ Str::limit($item->verification_code, 15) }}...<br>
        {{ $item->tanggal_terbit->format('d M Y') }}
    </div>
    <div class="d-flex gap-2 mt-2">
        <a href="{{ route('admin.surat.show', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-eye"></i> detail
        </a>
        <a href="{{ route('admin.surat.cetak', $item) }}" class="btn btn-sm btn-outline-success rounded-pill">
            <i class="bi bi-printer"></i> cetak
        </a>
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="bi bi-inbox display-4 text-muted"></i>
    <p class="text-muted mt-2">Belum ada surat yang diterbitkan.</p>
</div>
@endforelse

{{ $surat->appends(request()->query())->links() }}
@endsection
