@extends('layouts.admin')

@section('title', 'Edit Penduduk')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.penduduk.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card">
    <h6 class="fw-bold mb-3">Edit Data: {{ $penduduk->nama }}</h6>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.penduduk.update', $penduduk) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-bold">NIK *</label>
                <input type="text" name="nik" class="form-control" maxlength="16" value="{{ old('nik', $penduduk->nik) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">No. KK *</label>
                <input type="text" name="no_kk" class="form-control" maxlength="16" value="{{ old('no_kk', $penduduk->no_kk) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Nama Lengkap *</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $penduduk->nama) }}" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Tempat Lahir *</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Jenis Kelamin *</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Alamat *</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Pendidikan</label>
                <select name="pendidikan" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach(['Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan', $penduduk->pendidikan) == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Agama *</label>
                <select name="agama" class="form-select" required>
                    @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $a)
                        <option value="{{ $a }}" {{ old('agama', $penduduk->agama) == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Status Perkawinan *</label>
                <select name="status_perkawinan" class="form-select" required>
                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s)
                        <option value="{{ $s }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Golongan Darah</label>
                <select name="golongan_darah" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach(['A','B','AB','O','-'] as $g)
                        <option value="{{ $g }}" {{ old('golongan_darah', $penduduk->golongan_darah) == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 rounded-pill mt-4">
            <i class="bi bi-check-lg"></i> Simpan Perubahan
        </button>
    </form>
</div>
@endsection
