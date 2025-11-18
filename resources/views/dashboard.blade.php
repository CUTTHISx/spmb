@extends('layouts.app')

@section('content')
<script>
    // Redirect to appropriate dashboard based on user role
    @auth
        @if(auth()->user()->role === 'admin')
            window.location.href = '{{ url('/dashboard/admin') }}';
        @elseif(auth()->user()->role === 'kepsek')
            window.location.href = '{{ url('/dashboard/kepsek') }}';
        @elseif(auth()->user()->role === 'keuangan')
            window.location.href = '{{ url('/dashboard/keuangan') }}';
        @elseif(auth()->user()->role === 'verifikator')
            window.location.href = '{{ url('/dashboard/verifikator') }}';
        @else
            window.location.href = '{{ url('/dashboard/pendaftar') }}';
        @endif
    @else
        window.location.href = '{{ route('login') }}';
    @endauth
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Mengarahkan ke dashboard...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection