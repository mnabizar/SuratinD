@extends('layouts.user')

@section('title', 'Ajukan Surat')

@section('content')
<div class="mb-3">
    <a href="{{ route('user.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card-stat">
    <h6 class="fw-bold mb-3">Formulir Pengajuan Surat</h6>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-bold">Jenis Surat *</label>
            <select name="jenis_surat" class="form-select" required>
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach($jenisSurat as $key => $label)
                    <option value="{{ $key }}" {{ old('jenis_surat') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Tujuan/Keperluan *</label>
            <textarea name="tujuan_surat" class="form-control" rows="3"
                      placeholder="Jelaskan tujuan pembuatan surat..." required>{{ old('tujuan_surat') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Keterangan Tambahan</label>
            <textarea name="keterangan" class="form-control" rows="2"
                      placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
        </div>

        <hr>
        <h6 class="fw-bold mb-3 small">Upload Dokumen Pendukung</h6>

        <div class="mb-3">
            <label class="form-label small fw-bold">Foto KTP *</label>
            <input type="file" name="file_ktp" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
            <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB</small>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Foto KK *</label>
            <input type="file" name="file_kk" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
            <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB</small>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Dokumen Tambahan</label>
            <input type="file" name="file_tambahan" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB (Opsional)</small>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill mt-3">
            <i class="bi bi-send"></i> Kirim Pengajuan
        </button>
    </form>
</div>
@endsection
