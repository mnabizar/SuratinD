<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SuratinD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #E8F5FE;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
        }
        .register-card .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
        }
        .btn-register {
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            background: #4FC3F7;
            border: none;
            color: white;
            width: 100%;
        }
        .btn-register:hover { background: #0288D1; color: white; }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="avatar">
            <i class="bi bi-person-plus" style="font-size:2rem;color:#666;"></i>
        </div>
        <h4 class="fw-bold mb-3">Registrasi</h4>

        @if($errors->any())
            <div class="alert alert-danger small text-start">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap"
                       value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email"
                       value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <input type="text" name="nik" class="form-control" placeholder="NIK (16 digit)"
                       value="{{ old('nik') }}" maxlength="16" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Nomor HP"
                       value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-register">Daftar</button>
        </form>

        <p class="mt-3 mb-0 small">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Login</a>
        </p>
    </div>
</body>
</html>
