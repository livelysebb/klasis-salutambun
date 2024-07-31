<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Pengurus extends Model
{
    use HasFactory;
    protected $fillable = [
        'anggota_jemaat_id',
        'jabatan',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date', // Atau 'datetime' jika Anda menyimpan waktu juga
    ];

    // Relasi dengan AnggotaJemaat
    public function anggotaJemaat()
    {
        return $this->belongsTo(AnggotaJemaat::class, 'anggota_jemaat_id');
    }

    // Relasi dengan Jemaat (melalui AnggotaJemaat)
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'jemaat_id');
    }
}
