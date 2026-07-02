<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table      = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps    = false;

    protected $fillable = ['id_penghuni', 'tanggal_bayar', 'bulan_bayar', 'jumlah', 'status', 'keterangan'];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id_penghuni');
    }
}