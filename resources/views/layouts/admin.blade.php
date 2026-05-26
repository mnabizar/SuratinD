<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SuratinD') - Sistem Pelayanan Surat Desa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4FC3F7;
            --primary-dark: #0288D1;
            --primary-light: #B3E5FC;
            --bg-light: #E8F5FE;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1050;
            transition: left 0.3s ease;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #eee;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Bottom Navigation */
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
            padding: 8px 0;
            z-index: 1000;
        }

        .bottom-nav a, .bottom-nav button {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #999;
            font-size: 0.65rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px 8px;
        }

        .bottom-nav a.active,
        .bottom-nav a:hover {
            color: var(--primary-dark);
        }

        .bottom-nav .logout-btn:hover {
            color: #dc3545;
        }

        .bottom-nav a i, .bottom-nav button i {
            font-size: 1.2rem;
            margin-bottom: 2px;
        }

        /* Stats Cards - FIXED HEIGHT */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-card .stat-number {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 0.7rem;
            color: #666;
            line-height: 1.2;
        }

        /* Content */
        .main-content {
            padding: 15px;
            padding-bottom: 75px;
        }

        /* Badge */
        .badge-pending { background: #FFF3CD; color: #856404; }
        .badge-diproses { background: #CCE5FF; color: #004085; }
        .badge-disetujui { background: #D4EDDA; color: #155724; }
        .badge-ditolak { background: #F8D7DA; color: #721C24; }
        .badge-selesai { background: #D1ECF1; color: #0C5460; }

        /* Responsive */
        @media (min-width: 768px) {
            .sidebar { left: 0; }
            .main-wrapper { margin-left: var(--sidebar-width); }
            .bottom-nav { display: none; }
            .sidebar-toggle { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="px-3 mb-3">
            <h5 class="fw-bold text-center mb-0">
                <i class="bi bi-envelope-paper text-primary"></i> SuratinD
            </h5>
            <p class="text-center text-muted mb-0" style="font-size:0.65rem;">Sistem Pelayanan Surat Desa</p>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.penduduk.index') }}" class="nav-link {{ request()->routeIs('admin.penduduk.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Penduduk
            </a>
            <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
                <i class="bi bi-check-circle"></i> Persetujuan
            </a>
            <a href="{{ route('admin.surat.index') }}" class="nav-link {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Kelola Surat
            </a>
            @endif
            @if(auth()->user()->isKepalaDesa())
            <a href="{{ route('admin.penduduk.list') }}" class="nav-link {{ request()->routeIs('admin.penduduk.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Penduduk
            </a>
            <a href="{{ route('admin.surat.list') }}" class="nav-link {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Data Surat
            </a>
            @endif
            <a href="{{ route('admin.history.index') }}" class="nav-link {{ request()->routeIs('admin.history.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> History
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
            @endif
            <a href="{{ route('admin.account.index') }}" class="nav-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Account
            </a>
        </nav>

        <!-- LOGOUT BUTTON DI SIDEBAR -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div>
                    <strong style="font-size:0.85rem;">SISTEM PELAYANAN</strong>
                    <small class="d-block text-muted" style="font-size:0.65rem;">SURAT DESA</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark small">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                <!-- LOGOUT BUTTON DI NAVBAR (DESKTOP) -->
                <form action="{{ route('logout') }}" method="POST" class="d-none d-md-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bottom Navigation dengan LOGOUT -->
    <nav class="bottom-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('admin.history.index') }}" class="{{ request()->routeIs('admin.history.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>History</span>
        </a>
        <a href="{{ route('admin.account.index') }}" class="{{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Account</span>
        </a>
        <!-- LOGOUT BUTTON DI BOTTOM NAV -->
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // SweetAlert for delete confirmations
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Toast notification
        @if(session('success'))
        Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false,
            timer: 3000, timerProgressBar: true,
        }).fire({ icon: 'success', title: '{{ session("success") }}' });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
