@extends('layouts.auth')

@section('title', 'Lupa Password - Sistem Surat')

@section('content')
    <div class="auth-header">
        <h2>🔐 Lupa Password?</h2>
        <p class="subtitle">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
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

        <button type="submit" class="btn btn-primary">📧 Kirim Link Reset Password</button>
    </form>

    <a href="{{ route('login') }}" class="auth-link">← Kembali ke Halaman Login</a>
@endsection