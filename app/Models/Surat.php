<?php

namespace App\Models;

use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    //
    protected $table = 'surat';
    
    protected $fillable = [
        'jenis_surat_id',
        'nomor_surat',
        'tanggal_surat',
        'isi_surat',
    ];

    public function jenis() {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}