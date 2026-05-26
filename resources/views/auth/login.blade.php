<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SuratinD</title>
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
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
        }
        .login-card .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .login-card .avatar i {
            font-size: 2.5rem;
            color: #666;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
        }
        .btn-login {
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            background: #4FC3F7;
            border: none;
            color: white;
            width: 100%;
        }
        .btn-login:hover {
            background: #0288D1;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="avatar">
            <i class="bi bi-person"></i>
        </div>
        <h4 class="fw-bold mb-4">Login</h4>

        @if(session('warning'))
            <div class="alert alert-warning small">{{ session('warning') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email/Number"
                       value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa password?</a>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <p class="mt-3 mb-0 small">
            Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar</a>
        </p>
    </div>
</body>
</html>
