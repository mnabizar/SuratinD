@extends('layouts.admin')

@section('title', 'History')

@section('content')
<h5 class="fw-bold mb-3">
    <i class="bi bi-clock-history"></i> HISTORY
</h5>

<!-- Search -->
<form action="{{ route('admin.history.index') }}" method="GET" class="mb-3">
    <input type="text" name="search" class="form-control rounded-pill" placeholder="Cari aktivitas..."
           value="{{ request('search') }}">
</form>

<!-- Timeline Log -->
@forelse($logs as $log)
<div class="stat-card mb-2">
    <div class="d-flex align-items-start gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:36px;height:36px;min-width:36px;background:{{ match(true) {
                 str_contains($log->aktivitas, 'Login') => '#D4EDDA',
                 str_contains($log->aktivitas, 'Logout') => '#F8D7DA',
                 str_contains($log->aktivitas, 'Tambah') => '#CCE5FF',
                 str_contains($log->aktivitas, 'Edit') => '#FFF3CD',
                 str_contains($log->aktivitas, 'Hapus') => '#F8D7DA',
                 str_contains($log->aktivitas, 'Persetujuan') => '#D4EDDA',
                 str_contains($log->aktivitas, 'Cetak') => '#D1ECF1',
                 default => '#E2E3E5',
             } }}">
            <i class="bi {{ match(true) {
                str_contains($log->aktivitas, 'Login') => 'bi-box-arrow-in-right',
                str_contains($log->aktivitas, 'Logout') => 'bi-box-arrow-right',
                str_contains($log->aktivitas, 'Tambah') => 'bi-plus-circle',
                str_contains($log->aktivitas, 'Edit') => 'bi-pencil',
                str_contains($log->aktivitas, 'Hapus') => 'bi-trash',
                str_contains($log->aktivitas, 'Cetak') => 'bi-printer',
                default => 'bi-activity',
            } }} small"></i>
        </div>
        <div class="flex-grow-1">
            <strong class="small">{{ $log->aktivitas }}</strong>
            @if($log->deskripsi)
                <p class="mb-0 text-muted" style="font-size:0.72rem;">{{ $log->deskripsi }}</p>
            @endif
            <div class="d-flex justify-content-between">
                <small class="text-muted">{{ $log->user->name ?? 'System' }}</small>
                <small class="text-muted">
                    <i class="bi bi-clock"></i> {{ $log->created_at->format('d M Y, H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="bi bi-clock display-4 text-muted"></i>
    <p class="text-muted mt-2">Belum ada riwayat aktivitas.</p>
</div>
@endforelse

{{ $logs->appends(request()->query())->links() }}
@endsection
