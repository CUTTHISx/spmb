@extends('layouts.guest')

@section('content')
<h4 class="text-center mb-4">Login</h4>

@if (session('status'))
    <div class="alert alert-success mb-3">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label class="form-check-label" for="remember_me">Ingat saya</label>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            @if (Route::has('password.request'))
                <a class="text-decoration-none small" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
            <br>
            <a class="text-decoration-none small" href="{{ route('register') }}">
                Belum punya akun?
            </a>
        </div>

        <button type="submit" class="btn btn-primary">
            Login
        </button>
    </div>
</form>
@endsection
