<?php
namespace App\Http\Controllers;

use App\Models\CalonPenghuni;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $calon = CalonPenghuni::with('penilaian')->where('status','Menunggu')->orderBy('nama')->get();
        return view('penilaian.index', compact('calon'));
    }

    public function create($id_calon = null)
    {
        $calonList = CalonPenghuni::where('status','Menunggu')->whereDoesntHave('penilaian')->orderBy('nama')->get();
        $kriteria  = Kriteria::orderBy('kode_kriteria')->get();
        $selected  = $id_calon ? CalonPenghuni::find($id_calon) : null;

        return view('penilaian.create', compact('calonList','kriteria','selected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_calon' => 'required|exists:calon_penghuni,id_calon',
            'nilai'    => 'required|array',
            'nilai.*'  => 'required|numeric|min:1|max:5',
        ]);

        foreach ($request->nilai as $id_kriteria => $nilai) {
            Penilaian::updateOrCreate(
                ['id_calon' => $request->id_calon, 'id_kriteria' => $id_kriteria],
                ['nilai' => $nilai]
            );
        }

        return redirect()->route('penilaian.index')->with('success','Penilaian berhasil disimpan.');
    }

    public function edit($id_calon)
    {
        $calon     = CalonPenghuni::findOrFail($id_calon);
        $kriteria  = Kriteria::orderBy('kode_kriteria')->get();
        $penilaian = Penilaian::where('id_calon',$id_calon)->pluck('nilai','id_kriteria');
        return view('penilaian.edit', compact('calon','kriteria','penilaian'));
    }

    public function update(Request $request, $id_calon)
    {
        $request->validate(['nilai' => 'required|array', 'nilai.*' => 'required|numeric|min:1|max:5']);

        foreach ($request->nilai as $id_kriteria => $nilai) {
            Penilaian::updateOrCreate(
                ['id_calon' => $id_calon, 'id_kriteria' => $id_kriteria],
                ['nilai' => $nilai]
            );
        }

        return redirect()->route('penilaian.index')->with('success','Penilaian berhasil diperbarui.');
    }
}