<?php

namespace App\Models;

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
}