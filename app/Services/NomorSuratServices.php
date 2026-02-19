<?php

namespace App\Services;

use App\Models\Surat;
use Illuminate\Support\Facades\DB;

class NomorSuratService
{
    private function bulanRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III',
            4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX',
            10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $map[$bulan];
    }

    public function generate($kode = 'SPD', $instansi = 'BOJONGNANGKA')
    {
        return DB::transaction(function () use ($kode, $instansi) {

            $now = now();
            $bulan = $now->month;
            $tahun = $now->year;

            $count = Surat::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->lockForUpdate()
                ->count();

            $noUrut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

            return $noUrut . '/' . $kode . '/' . $instansi . '/' 
                . $this->bulanRomawi($bulan) . '/' . $tahun;
        });
    }
}