<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CalonPenghuni extends Model
{
    protected $table      = 'calon_penghuni';
    protected $primaryKey = 'id_calon';
    public $timestamps    = false;
    protected $fillable   = ['nama','jenis_kelamin','alamat','no_hp','status'];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_calon', 'id_calon');
    }

    public function hasilSeleksi()
    {
        return $this->hasOne(HasilSeleksi::class, 'id_calon', 'id_calon');
    }
}