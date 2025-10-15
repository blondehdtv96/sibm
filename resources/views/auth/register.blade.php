@extends('layouts.auth')

@section('title', 'Create Admin Account')

@section('content')
<div class="auth-header">
    <h1 class="auth-title">Setup Admin</h1>
    <p class="auth-subtitle">Create the first administrator account</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label for="name" class="form-label">Full Name</label>
        <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" 
               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
               placeholder="Enter your full name">
    </div>

    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" required autocomplete="email"
               placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">Phone Number (Optional)</label>
        <input id="phone" type="text" class="form-input @error('phone') is-invalid @enderror" 
               name="phone" value="{{ old('phone') }}" autocomplete="tel"
               placeholder="Enter your phone number">
    </div>

    <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" 
               name="password" required autocomplete="new-password"
               placeholder="Enter your password">
    </div>

    <div class="form-group">
        <label for="password-confirm" class="form-label">Confirm Password</label>
        <input id="password-confirm" type="password" class="form-input" 
               name="password_confirmation" required autocomplete="new-password"
               placeholder="Confirm your password">
    </div>

    <button type="submit" class="btn btn-primary">
        Create Admin Account
    </button>
</form>

<div class="text-center mt-3">
    <a class="text-link" href="{{ route('login') }}">
        Already have an account? Sign in
    </a>
</div>
@endsection