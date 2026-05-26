<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SuratinD</title>
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
        <h5 class="fw-bold mb-4">Reset Password</h5>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', request('email')) }}" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
