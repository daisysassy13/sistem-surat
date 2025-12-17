<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Tampilkan halaman form lupa password
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Proses kirim link reset ke email
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi: email harus diisi, format email, dan harus ada di tabel users
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar dalam sistem'
        ]);

        // Laravel otomatis kirim email dengan link reset
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Cek apakah berhasil atau gagal
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau spam.');
        } else {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }
}