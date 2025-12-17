@extends('layouts.auth')

@section('title', 'Reset Password - Sistem Surat')

@section('content')
    <div class="auth-header">
        <h2>🔑 Buat Password Baru</h2>
        <p class="subtitle">Masukkan password baru Anda di bawah ini.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control"
                value="{{ $email ?? old('email') }}" 
                readonly 
                required
            >
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password Baru</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control"
                placeholder="Minimal 8 karakter" 
                required 
                autofocus
            >
            <span class="form-hint">💡 Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik</span>
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form-control"
                placeholder="Ketik ulang password" 
                required
            >
        </div>

        <button type="submit" class="btn btn-success">✅ Reset Password</button>
    </form>
@endsection