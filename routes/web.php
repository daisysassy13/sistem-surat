<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ActivityLogController;

// Route untuk halaman depan (redirect ke dashboard kalau sudah login)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Route Authentication (sudah dibuat otomatis oleh Laravel UI)
Auth::routes();

// Route yang butuh login
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class);
    
    // Surat Keluar
    Route::resource('surat-keluar', SuratKeluarController::class);
    
    // Arsip
    Route::get('/arsip', function () {
        $suratMasukArsip = \App\Models\SuratMasuk::onlyTrashed()->with('creator')->latest()->get();
        $suratKeluarArsip = \App\Models\SuratKeluar::onlyTrashed()->with('creator')->latest()->get();
        return view('arsip.index', compact('suratMasukArsip', 'suratKeluarArsip'));
    })->name('arsip.index');
    
    // Restore dari arsip (Semua user bisa)
    Route::post('/arsip/surat-masuk/{id}/restore', function ($id) {
        $surat = \App\Models\SuratMasuk::withTrashed()->findOrFail($id);
        $surat->restore();
        return redirect()->route('arsip.index')->with('success', 'Surat masuk berhasil di-restore!');
    })->name('arsip.surat-masuk.restore');
    
    Route::post('/arsip/surat-keluar/{id}/restore', function ($id) {
        $surat = \App\Models\SuratKeluar::withTrashed()->findOrFail($id);
        $surat->restore();
        return redirect()->route('arsip.index')->with('success', 'Surat keluar berhasil di-restore!');
    })->name('arsip.surat-keluar.restore');
    
    // Hapus permanen (ADMIN ONLY) ⚠️
    Route::delete('/arsip/surat-masuk/{id}/force-delete', function ($id) {
        $surat = \App\Models\SuratMasuk::withTrashed()->findOrFail($id);
        \Storage::disk('public')->delete($surat->file_surat);
        $surat->forceDelete();
        return redirect()->route('arsip.index')->with('success', 'Surat masuk berhasil dihapus permanen!');
    })->name('arsip.surat-masuk.force-delete')->middleware('role:admin');
    
    Route::delete('/arsip/surat-keluar/{id}/force-delete', function ($id) {
        $surat = \App\Models\SuratKeluar::withTrashed()->findOrFail($id);
        \Storage::disk('public')->delete($surat->file_surat);
        $surat->forceDelete();
        return redirect()->route('arsip.index')->with('success', 'Surat keluar berhasil dihapus permanen!');
    })->name('arsip.surat-keluar.force-delete')->middleware('role:admin');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/surat-masuk/excel', [LaporanController::class, 'exportSuratMasukExcel'])->name('laporan.surat-masuk.excel');
    Route::get('/laporan/surat-keluar/excel', [LaporanController::class, 'exportSuratKeluarExcel'])->name('laporan.surat-keluar.excel');
    Route::get('/laporan/surat-masuk/pdf', [LaporanController::class, 'exportSuratMasukPDF'])->name('laporan.surat-masuk.pdf');
    Route::get('/laporan/surat-keluar/pdf', [LaporanController::class, 'exportSuratKeluarPDF'])->name('laporan.surat-keluar.pdf');

    // Activity Log (Admin Only)
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity-logs.index')
    ->middleware('role:admin');

    Route::middleware('role:admin')->group(function () {
    Route::resource('users', UserController::class);
});

});

