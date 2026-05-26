@extends('layouts.user')

@section('title', 'Profil')

@section('content')
<h6 class="fw-bold mb-3">Profil Saya</h6>

<div class="card-stat mb-3 text-center">
    @if($user->photo)
        <img src="{{ Storage::url($user->photo) }}" class="rounded-circle mb-2" style="width:70px;height:70px;object-fit:cover;">
    @else
        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-2" style="width:70px;height:70px;">
            <i class="bi bi-person display-6 text-muted"></i>
        </div>
    @endif
    <p class="fw-bold mb-0">{{ $user->name }}</p>
    <small class="text-muted">{{ $user->email }}</small>
</div>

<div class="card-stat mb-3">
    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-bold">Foto Profil</label>
            <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan</button>
    </form>
</div>

<div class="card-stat">
    <h6 class="fw-bold mb-3 small">Ganti Password</h6>
    <form action="{{ route('user.profile.password') }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-2">
            <input type="password" name="current_password" class="form-control form-control-sm" placeholder="Password lama" required>
        </div>
        <div class="mb-2">
            <input type="password" name="password" class="form-control form-control-sm" placeholder="Password baru" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Konfirmasi password" required>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100 rounded-pill btn-sm">Ubah Password</button>
    </form>
</div>
@endsection
