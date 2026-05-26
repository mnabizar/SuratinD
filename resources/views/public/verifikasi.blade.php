<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - SuratinD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #E8F5FE; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .verify-card { background: white; border-radius: 20px; padding: 40px 30px; max-width: 420px; width: 100%; box-shadow: 0 10px 40px rgba(0,0,0,0.08); text-align: center; }
        .form-control { border-radius: 25px; padding: 12px 20px; }
        .btn-verify { border-radius: 25px; padding: 12px; background: #4FC3F7; border: none; color: white; width: 100%; font-weight: 600; }
        .btn-verify:hover { background: #0288D1; color: white; }
        .result-valid { background: #D4EDDA; border: 2px solid #28A745; border-radius: 15px; padding: 20px; }
        .result-invalid { background: #F8D7DA; border: 2px solid #DC3545; border-radius: 15px; padding: 20px; }
    </style>
</head>
<body>
    <div class="verify-card">
        <i class="bi bi-shield-check display-4 text-primary"></i>
        <h4 class="fw-bold mt-3 mb-2">Verifikasi Surat</h4>
        <p class="text-muted small mb-4">Masukkan kode verifikasi untuk mengecek keaslian surat.</p>

        <form action="{{ route('verifikasi.check') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="kode" class="form-control" placeholder="Masukkan kode verifikasi..."
                       value="{{ old('kode') }}" required>
            </div>
            <button type="submit" class="btn btn-verify">
                <i class="bi bi-search"></i> Cek Verifikasi
            </button>
        </form>

        @if(isset($result) && $result === 'valid')
        <div class="result-valid mt-4 text-start">
            <div class="text-center mb-3">
                <i class="bi bi-check-circle-fill text-success display-5"></i>
                <h5 class="fw-bold text-success mt-2">VALID</h5>
            </div>
            <table class="table table-borderless table-sm small mb-0">
                <tr>
                    <td class="text-muted">Nama Pemohon</td>
                    <td><strong>{{ $surat->penduduk->nama }}</strong></td>
                </tr>
                <tr>
                    <td class="text-muted">Jenis Surat</td>
                    <td>{{ \App\Models\PengajuanSurat::jenisSuratList()[$surat->jenis_surat] ?? $surat->jenis_surat }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Nomor Surat</td>
                    <td>{{ $surat->nomor_surat }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Tanggal Terbit</td>
                    <td>{{ $surat->tanggal_terbit->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
        @elseif(isset($result) && $result === 'tidak_valid')
        <div class="result-invalid mt-4">
            <i class="bi bi-x-circle-fill text-danger display-5"></i>
            <h5 class="fw-bold text-danger mt-2">TIDAK VALID</h5>
            <p class="small text-muted mb-0">Kode verifikasi tidak ditemukan atau surat tidak valid.</p>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('home') }}" class="small text-decoration-none text-muted">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
