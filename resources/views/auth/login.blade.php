@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-header">
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-subtitle">Sign in to your account</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
               placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" 
               name="password" required autocomplete="current-password"
               placeholder="Enter your password">
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" 
               {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
            Remember me
        </label>
    </div>

    <button type="submit" class="btn btn-primary">
        Sign In
    </button>
</form>

<div class="text-center mt-3">
    @if (Route::has('register') && !App\Models\User::where('role', 'admin')->exists())
        <a class="text-link" href="{{ route('register') }}">
            Create Admin Account
        </a>
    @endif
</div>
@endsection