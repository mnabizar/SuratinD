@extends('layouts.admin')

@section('title', 'Persetujuan')

@section('content')
<h5 class="fw-bold mb-3">
    <i class="bi bi-check-circle"></i> Persetujuan
</h5>

<!-- Filter -->
<div class="mb-3">
    <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
        <select name="status" class="form-select form-select-sm rounded-pill" style="max-width:140px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>
</div>

<!-- Pengajuan List -->
@forelse($pengajuan as $item)
<div class="stat-card mb-3">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <strong class="d-block">{{ \App\Models\PengajuanSurat::jenisSuratList()[$item->jenis_surat] ?? $item->jenis_surat }}</strong>
            <small class="text-muted">{{ $item->user->name }} • NIK: {{ $item->user->nik ?? '-' }}</small>
        </div>
        <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
    </div>
    <p class="small text-muted mb-2">
        Keperluan: {{ Str::limit($item->tujuan_surat, 80) }}<br>
        Diajukan: {{ $item->created_at->format('d M Y') }}
    </p>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.pengajuan.show', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-eye"></i> detail
        </a>
        @if($item->status === 'pending' && auth()->user()->isAdmin())
        <form action="{{ route('admin.pengajuan.reject', $item) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="catatan_admin" value="Ditolak oleh admin">
            <button class="btn btn-sm btn-outline-danger rounded-pill btn-delete">
                <i class="bi bi-x-lg"></i> tolak
            </button>
        </form>
        <form action="{{ route('admin.pengajuan.approve', $item) }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-success rounded-pill">
                <i class="bi bi-check-lg"></i> setujui
            </button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="bi bi-inbox display-4 text-muted"></i>
    <p class="text-muted mt-2">Belum ada pengajuan masuk.</p>
</div>
@endforelse

{{ $pengajuan->appends(request()->query())->links() }}
@endsection
