<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tujuan_surat',
        'perihal',
        'file_surat',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    // Relasi ke User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Generate nomor surat otomatis
    public static function generateNomorSurat()
{
    $year = date('Y');
    $month = self::getRomanMonth(date('n'));
    
    // Ambil nomor terbesar dari tahun & bulan ini (termasuk yang diarsip)
    $lastNomor = self::withTrashed()
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', date('n'))
        ->where('nomor_surat', 'like', '%/SK/' . $month . '/' . $year)
        ->max('nomor_surat');
    
    if ($lastNomor) {
        preg_match('/^(\d+)\//', $lastNomor, $matches);
        $urutan = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
    } else {
        $urutan = 1;
    }
    
    return sprintf('%03d/SK/%s/%s', $urutan, $month, $year);
}
    // Konversi bulan ke romawi
    private static function getRomanMonth($month)
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romans[$month - 1];
    }
}