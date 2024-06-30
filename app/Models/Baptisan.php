<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Baptisan extends Model
{
    use HasFactory;
       // app/Models/Baptisan.php

    protected $fillable = [
        'anggota_jemaat_id', 'tanggal_baptis', 'tempat_baptis', 'pendeta_baptis', 'daftar_saksi'
    ];
    // protected $casts = [
    //     'tanggal_baptis' => 'datetime', // Casting manual untuk kolom tanggal_baptis
    // ];


    public function anggotaJemaat()
        {
            return $this->belongsTo(AnggotaJemaat::class);
        }
}
