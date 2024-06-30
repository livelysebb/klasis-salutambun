<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email'
    ];

    // Relasi one-to-many dengan AnggotaJemaat
    public function anggotaJemaat()
    {
        return $this->hasMany(AnggotaJemaat::class);
    }
}
