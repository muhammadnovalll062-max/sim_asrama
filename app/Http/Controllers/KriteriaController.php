<?php
namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $kriteria = Kriteria::when($search, function($query) use ($search) {
                $query->where('nama_kriteria', 'like', "%{$search}%")->orWhere('kode_kriteria', 'like', "%{$search}%");
            })
            ->orderBy('kode_kriteria')->get();

        return view('kriteria.index', compact('kriteria', 'search'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriteria,kode_kriteria',
            'nama_kriteria' => 'required|string|max:100',
            'nilai_ideal'   => 'required|numeric|min:1|max:5',
            'jenis'         => 'required|in:Core,Secondary',
        ]);

        Kriteria::create($request->only(['kode_kriteria','nama_kriteria','nilai_ideal','jenis']));
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriterion)
    {
        return view('kriteria.edit', ['kriteria' => $kriterion]);
    }

    public function update(Request $request, Kriteria $kriterion)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriteria,kode_kriteria,'.$kriterion->id_kriteria.',id_kriteria',
            'nama_kriteria' => 'required|string|max:100',
            'nilai_ideal'   => 'required|numeric|min:1|max:5',
            'jenis'         => 'required|in:Core,Secondary',
        ]);

        $kriterion->update($request->only(['kode_kriteria','nama_kriteria','nilai_ideal','jenis']));
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriterion)
    {
        $kriterion->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}