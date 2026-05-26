@extends('layouts.user')

@section('title', 'Pengajuan Surat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Pengajuan Surat Saya</h6>
    <a href="{{ route('user.pengajuan.create') }}" class="btn btn-sm btn-primary rounded-pill">
        <i class="bi bi-plus-lg"></i> Baru
    </a>
</div>

@forelse($pengajuan as $item)
<div class="card-stat mb-3">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <strong class="small">{{ \App\Models\PengajuanSurat::jenisSuratList()[$item->jenis_surat] ?? $item->jenis_surat }}</strong>
            <div class="text-muted" style="font-size:0.7rem;">
                {{ $item->created_at->format('d M Y, H:i') }}
            </div>
        </div>
        <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
    </div>

    <p class="small text-muted mb-2">{{ Str::limit($item->tujuan_surat, 60) }}</p>

    @if($item->catatan_admin)
        <div class="alert alert-light small py-1 px-2 mb-2">
            <i class="bi bi-chat-dots"></i> {{ $item->catatan_admin }}
        </div>
    @endif

    <div class="d-flex gap-2">
        <a href="{{ route('user.pengajuan.show', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-eye"></i> Detail
        </a>
        @if($item->status === 'selesai' && $item->surat)
        <a href="{{ route('user.pengajuan.download', $item) }}" class="btn btn-sm btn-success rounded-pill">
            <i class="bi bi-download"></i> Download
        </a>
        @endif
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="bi bi-file-earmark-plus display-4 text-muted"></i>
    <p class="text-muted mt-2">Belum ada pengajuan.</p>
    <a href="{{ route('user.pengajuan.create') }}" class="btn btn-primary rounded-pill">
        Ajukan Surat Pertama
    </a>
</div>
@endforelse

{{ $pengajuan->links() }}
@endsection
