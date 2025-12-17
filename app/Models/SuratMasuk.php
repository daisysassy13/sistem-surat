<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'nomor_agenda',
        'tanggal_surat',
        'tanggal_diterima',
        'asal_surat',
        'perihal',
        'file_surat',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    // Relasi ke User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Generate nomor agenda otomatis
   public static function generateNomorAgenda()
{
    $year = date('Y');
    $month = self::getRomanMonth(date('n'));
    
    // Ambil nomor terbesar dari tahun & bulan ini (termasuk yang diarsip)
    $lastNomor = self::withTrashed()
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', date('n'))
        ->where('nomor_agenda', 'like', '%/SM/' . $month . '/' . $year)
        ->max('nomor_agenda');
    
    if ($lastNomor) {
        // Extract angka dari format: 013/SM/XI/2025
        preg_match('/^(\d+)\//', $lastNomor, $matches);
        $urutan = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
    } else {
        $urutan = 1;
    }
    
    return sprintf('%03d/SM/%s/%s', $urutan, $month, $year);
}

    // Konversi bulan ke romawi
    private static function getRomanMonth($month)
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romans[$month - 1];
    }
}