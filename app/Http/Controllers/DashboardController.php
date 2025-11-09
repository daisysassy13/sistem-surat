<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $suratMasukBulanIni = SuratMasuk::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $suratKeluarBulanIni = SuratKeluar::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $totalArsip = SuratMasuk::onlyTrashed()->count() + SuratKeluar::onlyTrashed()->count();

        $suratMasukTerbaru = SuratMasuk::with('creator')
            ->latest()
            ->take(5)
            ->get();

        $suratKeluarTerbaru = SuratKeluar::with('creator')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'suratMasukBulanIni',
            'suratKeluarBulanIni',
            'totalArsip',
            'suratMasukTerbaru',
            'suratKeluarTerbaru'
        ));
    }
}