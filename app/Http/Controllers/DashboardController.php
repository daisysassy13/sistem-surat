<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik Bulan Ini
            $suratMasukBulanIni = SuratMasuk::whereMonth('tanggal_surat', Carbon::now()->month)
                ->whereYear('tanggal_surat', Carbon::now()->year)
                ->count();

            $suratKeluarBulanIni = SuratKeluar::whereMonth('tanggal_surat', Carbon::now()->month)
                ->whereYear('tanggal_surat', Carbon::now()->year)
                ->count();

            // Bulan Lalu
            $suratMasukBulanLalu = SuratMasuk::whereMonth('tanggal_surat', Carbon::now()->subMonth()->month)
                ->whereYear('tanggal_surat', Carbon::now()->subMonth()->year)
                ->count();

            // Hitung Growth Percentage
            if ($suratMasukBulanLalu > 0) {
                $growthPercentage = round((($suratMasukBulanIni - $suratMasukBulanLalu) / $suratMasukBulanLalu) * 100, 1);
            } else {
                $growthPercentage = $suratMasukBulanIni > 0 ? 100 : 0;
            }

            // Total Arsip
            $totalArsip = SuratMasuk::count() + SuratKeluar::count();

            // Total User
            $totalUser = User::count();

            // Trend Data 6 Bulan Terakhir
            $trendData = $this->getTrendData();

            // Distribusi Asal Surat
            $distribusiAsalSurat = SuratMasuk::select('asal_surat', DB::raw('count(*) as total'))
                ->whereNotNull('asal_surat')
                ->groupBy('asal_surat')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

            // Jika tidak ada data, buat dummy
            if ($distribusiAsalSurat->isEmpty()) {
                $distribusiAsalSurat = collect([
                    (object)['asal_surat' => 'Belum ada data', 'total' => 0]
                ]);
            }

            // Perbandingan Bulanan
            $perbandinganBulanan = [
                'masuk' => $suratMasukBulanIni,
                'keluar' => $suratKeluarBulanIni
            ];

            // Recent Activity
            $recentActivity = $this->getRecentActivity();

            return view('dashboard', compact(
                'suratMasukBulanIni',
                'suratKeluarBulanIni',
                'totalArsip',
                'totalUser',
                'growthPercentage',
                'trendData',
                'distribusiAsalSurat',
                'perbandinganBulanan',
                'recentActivity'
            ));
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return view('dashboard')->with([
                'suratMasukBulanIni' => 0,
                'suratKeluarBulanIni' => 0,
                'totalArsip' => 0,
                'totalUser' => User::count(),
                'growthPercentage' => 0,
                'trendData' => [
                    'labels' => [],
                    'suratMasuk' => [],
                    'suratKeluar' => []
                ],
                'distribusiAsalSurat' => collect([]),
                'perbandinganBulanan' => ['masuk' => 0, 'keluar' => 0],
                'recentActivity' => []
            ]);
        }
    }

    private function getTrendData()
    {
        $labels = [];
        $suratMasuk = [];
        $suratKeluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y'); // Format Indonesia

            $suratMasuk[] = SuratMasuk::whereMonth('tanggal_surat', $date->month)
                ->whereYear('tanggal_surat', $date->year)
                ->count();

            $suratKeluar[] = SuratKeluar::whereMonth('tanggal_surat', $date->month)
                ->whereYear('tanggal_surat', $date->year)
                ->count();
        }

        return [
            'labels' => $labels,
            'suratMasuk' => $suratMasuk,
            'suratKeluar' => $suratKeluar
        ];
    }

   private function getRecentActivity()
{
    $activities = [];

    try {

        // Ambil 5 surat keluar terakhir
        $suratKeluarTerbaru = SuratKeluar::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($suratKeluarTerbaru as $surat) {
            $activities[] = [
                'type'   => 'keluar',
                'user'   => $surat->user->name ?? 'System',
                'action' => 'menambahkan surat keluar',
                'detail' => $surat->nomor_surat ?? '-',
                'time'   => $surat->created_at,
            ];
        }

        // 🔑 SORT BERDASARKAN WAKTU (INI WAJIB)
        usort($activities, function ($a, $b) {
            return $b['time']->timestamp <=> $a['time']->timestamp;
        });

        return array_slice($activities, 0, 10);

    } catch (\Exception $e) {
        return [];
    }
}

}