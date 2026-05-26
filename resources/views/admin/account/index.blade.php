@extends('layouts.admin')

@section('title', 'Account')

@section('content')
<h5 class="fw-bold mb-3">ACCOUNT</h5>

<!-- Profile Photo -->
<div class="stat-card mb-3 text-center">
    <div class="mb-3">
        @if($user->photo)
            <img src="{{ Storage::url($user->photo) }}" class="rounded-circle" style="width:80px;height:80px;object-fit:cover;">
        @else
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                <i class="bi bi-person display-6 text-muted"></i>
            </div>
        @endif
    </div>
    <a href="#" class="text-primary small text-decoration-none" onclick="document.getElementById('photoInput').click()">edit profil</a>
</div>

<!-- Edit Profile Form -->
<div class="stat-card mb-3">
    <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <input type="file" id="photoInput" name="photo" class="d-none" accept="image/*" onchange="this.form.submit()">

        <div class="mb-3">
            <label class="form-label small fw-bold">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ $user->nik }}" maxlength="16">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Nomor Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Simpan Perubahan
        </button>
    </form>
</div>

<!-- Change Password -->
<div class="stat-card">
    <h6 class="fw-bold mb-3">Ganti Password</h6>
    <form action="{{ route('admin.account.password') }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-bold">Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
            <i class="bi bi-lock"></i> Ubah Password
        </button>
    </form>
</div>

<!-- Logout -->
<form action="{{ route('logout') }}" method="POST" class="mt-3">
    @csrf
    <button class="btn btn-outline-danger w-100 rounded-pill">
        <i class="bi bi-box-arrow-right"></i> Logout
    </button>
</form>
@endsection
