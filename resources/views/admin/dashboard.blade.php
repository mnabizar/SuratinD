@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section - Compact -->
<div class="d-flex align-items-center gap-3 mb-3 p-3 bg-white rounded-3 shadow-sm">
    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:42px;height:42px;min-width:42px;">
        <i class="bi bi-person text-primary fs-5"></i>
    </div>
    <div>
        <strong class="d-block" style="font-size:0.85rem;">{{ auth()->user()->name }}</strong>
        <small class="text-muted" style="font-size:0.7rem;">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }} • {{ auth()->user()->nik ?? '-' }}</small>
    </div>
</div>

<!-- Dashboard Stats - COMPACT GRID -->
<div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-2">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-number">{{ number_format($totalPenduduk) }}</div>
            <div class="stat-label">Penduduk</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-2">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="stat-number">{{ number_format($totalSurat) }}</div>
            <div class="stat-label">Total Surat</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="stat-icon bg-info bg-opacity-10 text-info mx-auto mb-2">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-number">{{ number_format($suratBulanIni) }}</div>
            <div class="stat-label">Bulan Ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center py-3">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-2">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-number">{{ $pengajuanMenunggu }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
</div>

<!-- Chart - COMPACT -->
<div class="bg-white rounded-3 shadow-sm p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold mb-0" style="font-size:0.8rem;">📊 Statistik Surat Bulanan</h6>
        <span class="badge bg-light text-muted" style="font-size:0.6rem;">12 Bulan Terakhir</span>
    </div>
    <div style="height: 180px;">
        <canvas id="chartSurat"></canvas>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row g-2 mb-3">
    <div class="col-6">
        <div class="bg-white rounded-3 shadow-sm p-3 text-center">
            <i class="bi bi-shield-check text-success fs-4"></i>
            <div class="fw-bold mt-1">{{ number_format($totalVerifikasi) }}</div>
            <small class="text-muted" style="font-size:0.65rem;">Surat Terverifikasi</small>
        </div>
    </div>
    <div class="col-6">
        <div class="bg-white rounded-3 shadow-sm p-3 text-center">
            <i class="bi bi-envelope-check text-primary fs-4"></i>
            <div class="fw-bold mt-1">{{ number_format($totalSurat > 0 ? $totalSurat : 0) }}</div>
            <small class="text-muted" style="font-size:0.65rem;">Surat Diterbitkan</small>
        </div>
    </div>
</div>

<!-- Recent Activity - COMPACT LIST -->
<div class="bg-white rounded-3 shadow-sm p-3 mb-3">
    <h6 class="fw-bold mb-2" style="font-size:0.8rem;">🕐 Aktivitas Terbaru</h6>
    @forelse($aktivitasTerbaru->take(5) as $log)
        <div class="d-flex align-items-center gap-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:28px;height:28px;background:{{ match(true) {
                     str_contains($log->aktivitas, 'Login') => '#D4EDDA',
                     str_contains($log->aktivitas, 'Tambah') => '#CCE5FF',
                     str_contains($log->aktivitas, 'Hapus') => '#F8D7DA',
                     default => '#E2E3E5',
                 } }}">
                <i class="bi {{ match(true) {
                    str_contains($log->aktivitas, 'Login') => 'bi-box-arrow-in-right',
                    str_contains($log->aktivitas, 'Tambah') => 'bi-plus-circle',
                    str_contains($log->aktivitas, 'Hapus') => 'bi-trash',
                    str_contains($log->aktivitas, 'Cetak') => 'bi-printer',
                    default => 'bi-activity',
                } }}" style="font-size:0.65rem;"></i>
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <div class="fw-semibold text-truncate" style="font-size:0.72rem;">{{ $log->aktivitas }}</div>
                <div class="text-muted text-truncate" style="font-size:0.6rem;">{{ $log->user->name ?? 'System' }} • {{ $log->created_at->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <p class="text-muted small mb-0 text-center py-2">Belum ada aktivitas.</p>
    @endforelse
</div>

<!-- Verification Logs - COMPACT -->
@if($verifikasiTerbaru->count() > 0)
<div class="bg-white rounded-3 shadow-sm p-3">
    <h6 class="fw-bold mb-2" style="font-size:0.8rem;">🔒 Log Verifikasi Terakhir</h6>
    @foreach($verifikasiTerbaru->take(3) as $v)
        <div class="d-flex align-items-center gap-2 py-1 {{ !$loop->last ? 'border-bottom' : '' }}">
            <span class="badge {{ $v->status === 'valid' ? 'bg-success' : 'bg-danger' }}" style="font-size:0.55rem;">
                {{ strtoupper($v->status) }}
            </span>
            <code class="text-truncate flex-grow-1" style="font-size:0.6rem;">{{ Str::limit($v->kode, 20) }}</code>
            <small class="text-muted flex-shrink-0" style="font-size:0.55rem;">{{ $v->created_at->diffForHumans() }}</small>
        </div>
    @endforeach
</div>
@endif
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('chartSurat').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($chartData)->pluck('bulan')) !!},
            datasets: [{
                label: 'Surat',
                data: {!! json_encode(collect($chartData)->pluck('jumlah')) !!},
                backgroundColor: 'rgba(79, 195, 247, 0.6)',
                borderColor: '#0288D1',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 9 } }
                },
                x: {
                    ticks: { font: { size: 9 } }
                }
            }
        }
    });
</script>
@endpush
