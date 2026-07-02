<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HasilSeleksi extends Model
{
    protected $table      = 'hasil_seleksi';
    protected $primaryKey = 'id_hasil';
    public $timestamps    = false;
    protected $fillable   = ['id_calon','nilai_cf','nilai_sf','nilai_akhir','ranking'];

    public function calon()
    {
        return $this->belongsTo(CalonPenghuni::class, 'id_calon', 'id_calon');
    }
}