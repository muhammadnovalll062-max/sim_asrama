<?php
namespace App\Http\Controllers;

use App\Models\HasilSeleksi;
use App\Models\CalonPenghuni;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class HasilSeleksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $hasil = HasilSeleksi::with('calon')
            ->whereHas('calon', fn($q) => $q->where('status', 'Menunggu'))
            ->when($search, fn($q) => $q->whereHas('calon', fn($qq) => $qq->where('nama', 'like', "%{$search}%")))
            ->orderBy('ranking')->get();

        return view('hasil.index', compact('hasil', 'search'));
    }

    public function riwayat(Request $request)
    {
        $search = $request->get('q');

        $hasil = HasilSeleksi::with('calon')
            ->whereHas('calon', fn($q) => $q->where('status', '!=', 'Menunggu'))
            ->when($search, fn($q) => $q->whereHas('calon', fn($qq) => $qq->where('nama', 'like', "%{$search}%")))
            ->orderByDesc('id_hasil')->get();

        return view('hasil.riwayat', compact('hasil', 'search'));
    }

    public function terimaForm($id_calon)
    {
        $calon = CalonPenghuni::findOrFail($id_calon);
        $kamar = Kamar::where('status','!=','Penuh')->orderBy('nomor_kamar')->get();
        return view('hasil.terima', compact('calon','kamar'));
    }

    public function terima(Request $request, $id_calon)
    {
        $request->validate([
            'id_kamar'      => 'required|exists:kamar,id_kamar',
            'tanggal_masuk' => 'required|date',
        ]);

        $calon = CalonPenghuni::findOrFail($id_calon);

        Penghuni::create([
            'nama'          => $calon->nama,
            'jenis_kelamin' => $calon->jenis_kelamin,
            'alamat'        => $calon->alamat,
            'no_hp'         => $calon->no_hp,
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_kamar'      => $request->id_kamar,
        ]);

        $kamar  = Kamar::find($request->id_kamar);
        $terisi = Penghuni::where('id_kamar', $request->id_kamar)->count();
        $status = $terisi == 0 ? 'Kosong' : ($terisi >= $kamar->kapasitas ? 'Penuh' : 'Terisi');
        $kamar->update(['terisi' => $terisi, 'status' => $status]);

        $calon->update(['status' => 'Diterima']);

        return redirect()->route('hasil.seleksi')->with('success', $calon->nama.' berhasil diterima sebagai penghuni.');
    }

    public function tolak($id_calon)
    {
        $calon = CalonPenghuni::findOrFail($id_calon);
        $calon->update(['status' => 'Ditolak']);
        return redirect()->route('hasil.seleksi')->with('success', $calon->nama.' telah ditolak.');
    }
}