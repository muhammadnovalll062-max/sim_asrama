<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table      = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    public $timestamps    = false;
    protected $fillable   = ['kode_kriteria','nama_kriteria','nilai_ideal','jenis'];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_kriteria', 'id_kriteria');
    }
}   