<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $penghuni = Penghuni::with('kamar')
            ->when($search, function($query) use ($search) {
                $query->where(fn($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('no_hp', 'like', "%{$search}%"));
            })
            ->orderBy('nama')->get();

        return view('penghuni.index', compact('penghuni', 'search'));
    }

    public function create()
    {
        $kamar = Kamar::where('status', '!=', 'Penuh')->orderBy('nomor_kamar')->get();
        return view('penghuni.create', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:15',
            'tanggal_masuk' => 'required|date',
            'id_kamar'      => 'required|exists:kamar,id_kamar',
        ]);

        Penghuni::create($request->only(['nama','jenis_kelamin','alamat','no_hp','tanggal_masuk','id_kamar']));

        $this->updateStatusKamar($request->id_kamar);

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil ditambahkan.');
    }

    public function edit(Penghuni $penghuni)
    {
        $kamar = Kamar::orderBy('nomor_kamar')->get();
        return view('penghuni.edit', compact('penghuni', 'kamar'));
    }

    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:15',
            'tanggal_masuk' => 'required|date',
            'id_kamar'      => 'required|exists:kamar,id_kamar',
        ]);

        $kamarLama = $penghuni->id_kamar;
        $penghuni->update($request->only(['nama','jenis_kelamin','alamat','no_hp','tanggal_masuk','id_kamar']));

        $this->updateStatusKamar($kamarLama);
        if ($kamarLama != $request->id_kamar) {
            $this->updateStatusKamar($request->id_kamar);
        }

        return redirect()->route('penghuni.index')->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function destroy(Penghuni $penghuni)
    {
        if ($penghuni->pembayaran()->exists()) {
            return redirect()->route('penghuni.index')->with('error', 'Penghuni tidak bisa dihapus karena masih memiliki riwayat pembayaran. Hapus riwayat pembayaran terlebih dahulu jika diperlukan.');
        }

        $idKamar = $penghuni->id_kamar;
        $penghuni->delete();
        $this->updateStatusKamar($idKamar);

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus.');
    }

    private function updateStatusKamar($idKamar)
    {
        $kamar = Kamar::find($idKamar);
        if (!$kamar) return;

        $terisi = Penghuni::where('id_kamar', $idKamar)->count();

        if ($terisi == 0) $status = 'Kosong';
        elseif ($terisi >= $kamar->kapasitas) $status = 'Penuh';
        else $status = 'Terisi';

        $kamar->update(['terisi' => $terisi, 'status' => $status]);
    }
}