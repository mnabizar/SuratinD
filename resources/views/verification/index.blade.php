@extends('layouts.app')

@section('content')

<div class="card rounded-4 shadow-sm border-0 p-4">

    <h3 class="mb-4">Verifikasi Surat</h3>

    <form method="POST" action="/verifikasi">
        @csrf

        <input type="text"
            name="kode"
            class="form-control mb-3"
            placeholder="Masukkan kode verifikasi">

        <button class="btn btn-primary w-100">
            Cek Verifikasi
        </button>

    </form>

</div>

@endsection