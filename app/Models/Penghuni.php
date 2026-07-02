<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table      = 'penghuni';
    protected $primaryKey = 'id_penghuni';
    public $timestamps    = false;

    protected $fillable = ['nama', 'jenis_kelamin', 'alamat', 'no_hp', 'tanggal_masuk', 'id_kamar'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_penghuni', 'id_penghuni');
    }
}