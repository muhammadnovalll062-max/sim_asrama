<?php
namespace App\Http\Controllers;

use App\Models\CalonPenghuni;
use Illuminate\Http\Request;

class CalonPenghuniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $calon = CalonPenghuni::where('status','Menunggu')
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')->get();

        return view('calon.index', compact('calon', 'search'));
    }

    public function riwayat(Request $request)
    {
        $search = $request->get('q');

        $riwayat = CalonPenghuni::with('hasilSeleksi')
            ->where('status', '!=', 'Menunggu')
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderByDesc('id_calon')->get();

        return view('calon.riwayat', compact('riwayat', 'search'));
    }

    public function create()
    {
        return view('calon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:15',
        ]);

        CalonPenghuni::create(array_merge(
            $request->only(['nama','jenis_kelamin','alamat','no_hp']),
            ['status' => 'Menunggu']
        ));

        return redirect()->route('calon.index')->with('success', 'Calon penghuni berhasil ditambahkan.');
    }

    public function edit(CalonPenghuni $calon)
    {
        return view('calon.edit', compact('calon'));
    }

    public function update(Request $request, CalonPenghuni $calon)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:15',
        ]);

        $calon->update($request->only(['nama','jenis_kelamin','alamat','no_hp']));
        return redirect()->route('calon.index')->with('success', 'Data calon berhasil diperbarui.');
    }

    public function destroy(CalonPenghuni $calon)
    {
        $calon->delete();
        return redirect()->route('calon.index')->with('success', 'Calon penghuni berhasil dihapus.');
    }
}