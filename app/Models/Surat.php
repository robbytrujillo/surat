<?php

namespace App\Models;

use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Surat extends Model
{
    protected $table = 'surat';
    
    protected $fillable = [
        'jenis_surat_id',
        'nomor_surat',
        'tanggal_surat',
        'isi_surat',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public static function generateNomorSurat($kode = 'SPD', $kodeBagian = 'BOJONGNANGKA')
    {
        return DB::transaction(function () use ($kode, $kodeBagian) {

            $romawi = [
                1 => 'I', 2 => 'II', 3 => 'III',
                4 => 'IV', 5 => 'V', 6 => 'VI',
                7 => 'VII', 8 => 'VIII', 9 => 'IX',
                10 => 'X', 11 => 'XI', 12 => 'XII',
            ];

            $tahun = date('Y');
            $bulan = date('n');
            $romawiBulan = $romawi[$bulan];

            $last = self::whereYear('tanggal_surat', $tahun)
                ->whereMonth('tanggal_surat', $bulan)
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if ($last) {
                $lastNumber = (int) explode('/', $last->nomor_surat)[0];
                $urut = $lastNumber + 1;
            } else {
                $urut = 1;
            }

            return str_pad($urut, 3, '0', STR_PAD_LEFT)
                . "/$kode/$kodeBagian/$romawiBulan/$tahun";
        });
    }
}