@extends('layouts.admin')

@section('title', 'Edit Surat')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card">
    <h6 class="fw-bold mb-3">Edit Surat: {{ $surat->nomor_surat }}</h6>

    <form action="{{ route('admin.surat.update', $surat) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-bold">Status</label>
            <select name="status" class="form-select">
                <option value="draft" {{ $surat->status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="diterbitkan" {{ $surat->status === 'diterbitkan' ? 'selected' : '' }}>Diterbitkan</option>
                <option value="dibatalkan" {{ $surat->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Isi Surat</label>
            <textarea name="isi_surat" class="form-control" rows="10" required>{{ $surat->isi_surat }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Simpan Perubahan
        </button>
    </form>
</div>
@endsection
