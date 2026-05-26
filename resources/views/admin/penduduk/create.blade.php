@extends('layouts.admin')

@section('title', 'Tambah Penduduk')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.penduduk.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card">
    <h6 class="fw-bold mb-3">Tambah Data Penduduk</h6>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.penduduk.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-bold">NIK *</label>
                <input type="text" name="nik" class="form-control" maxlength="16" value="{{ old('nik') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">No. KK *</label>
                <input type="text" name="no_kk" class="form-control" maxlength="16" value="{{ old('no_kk') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Nama Lengkap *</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Tempat Lahir *</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Jenis Kelamin *</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Alamat *</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Pendidikan</label>
                <select name="pendidikan" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach(['Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Agama *</label>
                <select name="agama" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $a)
                        <option value="{{ $a }}" {{ old('agama') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Status Perkawinan *</label>
                <select name="status_perkawinan" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s)
                        <option value="{{ $s }}" {{ old('status_perkawinan') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">Golongan Darah</label>
                <select name="golongan_darah" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach(['A','B','AB','O','-'] as $g)
                        <option value="{{ $g }}" {{ old('golongan_darah') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill mt-4">
            <i class="bi bi-check-lg"></i> Simpan Data
        </button>
    </form>
</div>
@endsection
