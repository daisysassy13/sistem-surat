<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    // Export Surat Masuk ke CSV
    public function exportSuratMasukExcel(Request $request)
    {
        $query = SuratMasuk::with('creator');

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        $data = $query->get();
        $filename = 'Laporan-Surat-Masuk-' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        
        // BOM for Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['No', 'Nomor Agenda', 'Nomor Surat', 'Tanggal Surat', 'Tanggal Diterima', 'Asal Surat', 'Perihal', 'Keterangan', 'Dibuat Oleh']);
        
        // Data
        $no = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $no++,
                $row->nomor_agenda,
                $row->nomor_surat ?? '-',
                $row->tanggal_surat->format('d/m/Y'),
                $row->tanggal_diterima->format('d/m/Y'),
                $row->asal_surat,
                $row->perihal,
                $row->keterangan ?? '-',
                $row->creator->name,
            ]);
        }
        
        fclose($output);
        exit;
    }

    // Export Surat Keluar ke CSV
    public function exportSuratKeluarExcel(Request $request)
    {
        $query = SuratKeluar::with('creator');

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        $data = $query->get();
        $filename = 'Laporan-Surat-Keluar-' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Nomor Surat', 'Tanggal Surat', 'Tujuan Surat', 'Perihal', 'Keterangan', 'Dibuat Oleh']);
        
        $no = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $no++,
                $row->nomor_surat,
                $row->tanggal_surat->format('d/m/Y'),
                $row->tujuan_surat,
                $row->perihal,
                $row->keterangan ?? '-',
                $row->creator->name,
            ]);
        }
        
        fclose($output);
        exit;
    }

    // Export Surat Masuk ke PDF
    public function exportSuratMasukPDF(Request $request)
    {
        $query = SuratMasuk::with('creator');

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        $data = $query->get();
        $pdf = Pdf::loadView('laporan.surat-masuk-pdf', compact('data'));
        
        return $pdf->download('Laporan-Surat-Masuk-' . date('Y-m-d') . '.pdf');
    }

    // Export Surat Keluar ke PDF
    public function exportSuratKeluarPDF(Request $request)
    {
        $query = SuratKeluar::with('creator');

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        $data = $query->get();
        $pdf = Pdf::loadView('laporan.surat-keluar-pdf', compact('data'));
        
        return $pdf->download('Laporan-Surat-Keluar-' . date('Y-m-d') . '.pdf');
    }
}