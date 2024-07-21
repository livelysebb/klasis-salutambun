<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidi extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_jemaat_id',
        'tanggal_sidi',
        'tempat_sidi',
        'pendeta_sidi',
        'bacaan_sidi',
        'nomor_surat',
        'foto',
        'dokumen_sidi',
    ];

    public function anggotaJemaat()
{
    return $this->belongsTo(AnggotaJemaat::class);
}
}
