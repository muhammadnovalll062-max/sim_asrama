<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $kamar = Kamar::when($search, fn($q) => $q->where('nomor_kamar', 'like', "%{$search}%"))
            ->orderBy('nomor_kamar')->get();

        return view('kamar.index', compact('kamar', 'search'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar',
            'kapasitas'   => 'required|integer|min:1',
        ]);

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'kapasitas'   => $request->kapasitas,
            'terisi'      => 0,
            'status'      => 'Kosong',
        ]);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kamar $kamar)
    {
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar,' . $kamar->id_kamar . ',id_kamar',
            'kapasitas'   => 'required|integer|min:' . $kamar->terisi,
        ]);

        // Hitung ulang status
        $terisi = $kamar->terisi;
        $kapasitas = $request->kapasitas;

        if ($terisi == 0) {
            $status = 'Kosong';
        } elseif ($terisi >= $kapasitas) {
            $status = 'Penuh';
        } else {
            $status = 'Terisi';
        }

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'kapasitas'   => $kapasitas,
            'status'      => $status,
        ]);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Kamar $kamar)
    {
        if ($kamar->terisi > 0) {
            return redirect()->route('kamar.index')->with('error', 'Kamar tidak bisa dihapus karena masih ada penghuni.');
        }

        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}