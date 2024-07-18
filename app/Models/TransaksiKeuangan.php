<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jemaat_id',
        'jenis_transaksi',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
    ];
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class);
    }
}
