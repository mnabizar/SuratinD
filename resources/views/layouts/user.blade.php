<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SuratinD') - Portal Masyarakat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4FC3F7;
            --primary-dark: #0288D1;
            --primary-light: #B3E5FC;
            --bg-light: #E8F5FE;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .top-bar {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .content-area {
            padding: 20px;
        }

        .card-stat {
            background: white;
            border-radius: 15px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: center;
        }

        .card-stat .number {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .card-stat .label {
            font-size: 0.75rem;
            color: #666;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            z-index: 1000;
        }

        .bottom-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #999;
            font-size: 0.7rem;
        }

        .bottom-nav a.active { color: var(--primary-dark); }
        .bottom-nav a i { font-size: 1.3rem; margin-bottom: 3px; }

        .badge-pending { background: #FFF3CD; color: #856404; }
        .badge-diproses { background: #CCE5FF; color: #004085; }
        .badge-disetujui, .badge-selesai { background: #D4EDDA; color: #155724; }
        .badge-ditolak { background: #F8D7DA; color: #721C24; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div>
            <strong>SuratinD</strong>
            <small class="d-block text-muted" style="font-size:0.7rem;">Portal Masyarakat</small>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('user.profile.index') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house"></i><span>Home</span>
        </a>
        <a href="{{ route('user.pengajuan.index') }}" class="{{ request()->routeIs('user.pengajuan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i><span>Pengajuan</span>
        </a>
        <a href="{{ route('user.profile.index') }}" class="{{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i><span>Profil</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
