<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table      = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    public $timestamps    = false;
    protected $fillable   = ['id_calon','id_kriteria','nilai'];

    public function calon()
    {
        return $this->belongsTo(CalonPenghuni::class, 'id_calon', 'id_calon');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}