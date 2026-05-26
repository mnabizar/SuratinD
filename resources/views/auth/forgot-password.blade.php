<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SuratinD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #E8F5FE; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .card-form { background: white; border-radius: 20px; padding: 40px 30px; max-width: 380px; width: 100%; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .form-control { border-radius: 25px; padding: 12px 20px; }
        .btn-submit { border-radius: 25px; padding: 12px; background: #4FC3F7; border: none; color: white; width: 100%; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card-form text-center">
        <h5 class="fw-bold mb-3">Lupa Password</h5>
        <p class="text-muted small mb-4">Masukkan email Anda untuk menerima link reset password.</p>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <button type="submit" class="btn btn-submit">Kirim Link Reset</button>
        </form>

        <p class="mt-3 small">
            <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke Login</a>
        </p>
    </div>
</body>
</html>
