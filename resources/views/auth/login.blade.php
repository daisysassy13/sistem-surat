@extends('layouts.auth')

@section('title', 'Login - Sistem Surat')

@section('content')
    <div class="auth-header">
        <h2>Login</h2>
        <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            ❌ {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control"
                value="{{ old('email') }}" 
                placeholder="contoh@email.com" 
                required 
                autofocus
            >
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control"
                placeholder="Masukkan password" 
                required
            >
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-check">
            <input 
                type="checkbox" 
                id="remember" 
                name="remember" 
                {{ old('remember') ? 'checked' : '' }}
            >
            <label for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <a href="{{ route('password.request') }}" class="auth-link">Forgot Your Password?</a>
@endsection