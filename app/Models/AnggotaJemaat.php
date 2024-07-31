<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class AnggotaJemaat extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jemaat_id', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nama_ayah', 'nama_ibu', 'foto'];

    // Relasi belongsTo dengan Jemaat
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class);
    }

    public function baptisan()
    {
        return $this->hasOne(Baptisan::class);
    }

    public function sidi()
    {
        return $this->hasOne(Sidi::class);
    }

    // Relasi ke Nikah (sebagai pasangan pertama)
    public function pernikahans()
    {
        return $this->hasMany(Nikah::class, 'anggota_jemaat_id');
    }

    // Relasi ke Nikah (sebagai pasangan kedua)
    public function pernikahanSebagaiPasangan()
    {
        return $this->hasMany(Nikah::class, 'pasangan_id');
    }

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'anggota_jemaat_id');
    }
}
