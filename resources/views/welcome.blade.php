<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuratinD - Sistem Pelayanan Surat Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #E8F5FE; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .splash-card { text-align: center; padding: 40px; max-width: 380px; }
        .splash-card .logo-icon { width: 100px; height: 100px; border-radius: 25px; background: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .splash-card .logo-icon i { font-size: 3rem; color: #4FC3F7; }
        .btn-action { border-radius: 25px; padding: 12px 30px; font-weight: 600; width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="splash-card">
        <div class="logo-icon">
            <i class="bi bi-envelope-paper"></i>
        </div>
        <h3 class="fw-bold">SuratinD</h3>
        <p class="text-muted mb-4">Sistem Pelayanan Surat Desa<br>dengan Verifikasi Dokumen Digital</p>

        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'kepala_desa')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-action">
                    <i class="bi bi-grid"></i> Dashboard Admin
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-action">
                    <i class="bi bi-grid"></i> Dashboard Saya
                </a>
            @endif

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-action">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-action">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-action">
                <i class="bi bi-person-plus"></i> Daftar
            </a>
        @endauth

        <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-success btn-action mt-3">
            <i class="bi bi-shield-check"></i> Verifikasi Surat
        </a>
    </div>
</body>
</html>
