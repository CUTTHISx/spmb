@extends('layouts.guest')

@section('content')
<h4 class="text-center mb-4">Daftar Akun Baru</h4>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a class="text-decoration-none small" href="{{ route('login') }}">
            Sudah punya akun?
        </a>

        <button type="submit" class="btn btn-primary">
            Daftar
        </button>
    </div>
</form>
@endsection
