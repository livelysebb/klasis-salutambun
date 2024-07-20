<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'jenis_surat',
        'pengirim_tujuan',
        'penerima',
        'file_surat',
        'jemaat_id',
    ];
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class);
    }
}
