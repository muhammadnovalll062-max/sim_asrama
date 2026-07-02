<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table      = 'kamar';
    protected $primaryKey = 'id_kamar';
    public $timestamps    = false;

    protected $fillable = ['nomor_kamar', 'kapasitas', 'terisi', 'status'];

    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'id_kamar', 'id_kamar');
    }
}