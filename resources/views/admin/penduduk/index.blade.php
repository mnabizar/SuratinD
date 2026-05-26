@extends('layouts.admin')

@section('title', 'Data Penduduk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">
        <i class="bi bi-people text-primary"></i> Data Penduduk
    </h6>
    <span class="badge bg-primary">{{ $penduduk->total() }} data</span>
</div>

<!-- Tambah Penduduk Button (Admin Only) -->
@if(auth()->user()->isAdmin())
<a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary w-100 rounded-pill mb-3">
    <i class="bi bi-plus-lg"></i> Tambah Penduduk
</a>
@endif

<!-- Search & Filter -->
<div class="bg-white rounded-3 shadow-sm p-3 mb-3">
    <form action="{{ route('admin.penduduk.index') }}" method="GET">
        <div class="input-group mb-2">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill"
                   placeholder="🔍 Cari nama atau NIK..." value="{{ request('search') }}">
            <button class="btn btn-sm btn-primary rounded-pill ms-2" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
        <div class="d-flex gap-2">
            <select name="jenis_kelamin" class="form-select form-select-sm rounded-pill" style="max-width:130px;" onchange="this.form.submit()">
                <option value="">Semua JK</option>
                <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <select name="agama" class="form-select form-select-sm rounded-pill" style="max-width:120px;" onchange="this.form.submit()">
                <option value="">Semua Agama</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $agm)
                    <option value="{{ $agm }}" {{ request('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                @endforeach
            </select>
            @if(request()->hasAny(['search', 'jenis_kelamin', 'agama']))
                <a href="{{ route('admin.penduduk.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Export Button (Admin only) -->
@if(auth()->user()->isAdmin())
<div class="mb-3">
    <a href="{{ route('admin.penduduk.export') }}" class="btn btn-sm btn-outline-success rounded-pill">
        <i class="bi bi-file-pdf"></i> Export PDF
    </a>
</div>
@endif

<!-- Penduduk List -->
@forelse($penduduk as $p)
<div class="bg-white rounded-3 shadow-sm p-3 mb-2">
    <div class="d-flex justify-content-between align-items-start">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:32px;height:32px;background:{{ $p->jenis_kelamin == 'Laki-laki' ? '#CCE5FF' : '#F8D7DA' }}">
                    <i class="bi {{ $p->jenis_kelamin == 'Laki-laki' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' }}" style="font-size:0.8rem;"></i>
                </div>
                <div>
                    <strong style="font-size:0.82rem;">{{ $p->nama }}</strong>
                    <div class="text-muted" style="font-size:0.65rem;">NIK: {{ $p->nik }}</div>
                </div>
            </div>
            <div class="ps-5" style="font-size:0.68rem; color:#666;">
                <i class="bi bi-geo-alt"></i> {{ Str::limit($p->alamat, 40) }}<br>
                <i class="bi bi-briefcase"></i> {{ $p->pekerjaan ?? '-' }} •
                <i class="bi bi-calendar"></i> {{ $p->tanggal_lahir->format('d/m/Y') }}
            </div>
        </div>

        <!-- Action Buttons (Admin Only) -->
        @if(auth()->user()->isAdmin())
        <div class="d-flex flex-column gap-1 flex-shrink-0">
            <a href="{{ route('admin.penduduk.show', $p) }}" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size:0.65rem;">
                <i class="bi bi-eye"></i>
            </a>
            <a href="{{ route('admin.penduduk.edit', $p) }}" class="btn btn-sm btn-outline-warning py-0 px-2" style="font-size:0.65rem;">
                <i class="bi bi-pencil"></i>
            </a>
            <form action="{{ route('admin.penduduk.destroy', $p) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-delete" style="font-size:0.65rem;">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
        @else
        <a href="{{ route('admin.penduduk.show', $p) }}" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size:0.65rem;">
            <i class="bi bi-eye"></i>
        </a>
        @endif
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="bi bi-inbox display-4 text-muted"></i>
    <p class="text-muted mt-2 small">Belum ada data penduduk.</p>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary rounded-pill btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah Pertama
    </a>
    @endif
</div>
@endforelse

<!-- Pagination -->
@if($penduduk->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $penduduk->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
@endif
@endsection
