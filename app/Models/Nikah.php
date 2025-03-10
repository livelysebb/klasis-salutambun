<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nikah extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_jemaat_id',
        'pasangan_id',
        'tanggal_nikah',
        'tempat_nikah',
        'pendeta_nikah',
        'catatan_nikah',
        'foto_nikah',
        'dokumen_nikah',
        //'status_pernikahan'
    ];
    protected $casts = [
        'tanggal_nikah' => 'date', // Atau 'datetime' jika Anda menyimpan waktu juga
    ];

    public function anggotaJemaat()
    {
        return $this->belongsTo(AnggotaJemaat::class, 'anggota_jemaat_id');
    }

    public function pasangan()
    {
        return $this->belongsTo(AnggotaJemaat::class, 'pasangan_id');
    }
}
