<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $pembayaran = Pembayaran::with('penghuni')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('bulan_bayar', 'like', "%{$search}%")
                    ->orWhereHas('penghuni', fn($qq) => $qq->where('nama', 'like', "%{$search}%"));
                });
            })
            ->orderByDesc('tanggal_bayar')->get();

        return view('pembayaran.index', compact('pembayaran', 'search'));
    }

    public function create()
    {
        $penghuni = Penghuni::orderBy('nama')->get();
        return view('pembayaran.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penghuni'  => 'required|exists:penghuni,id_penghuni',
            'tanggal_bayar'=> 'nullable|date',
            'bulan_bayar'  => 'required|string|max:20',
            'jumlah'       => 'required|numeric|min:0',
            'status'       => 'required|in:Lunas,Belum Lunas',
            'keterangan'   => 'nullable|string|max:100',
        ]);

        Pembayaran::create($request->only([
            'id_penghuni','tanggal_bayar','bulan_bayar','jumlah','status','keterangan'
        ]));

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penghuni = Penghuni::orderBy('nama')->get();
        return view('pembayaran.edit', compact('pembayaran', 'penghuni'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'id_penghuni'  => 'required|exists:penghuni,id_penghuni',
            'tanggal_bayar'=> 'nullable|date',
            'bulan_bayar'  => 'required|string|max:20',
            'jumlah'       => 'required|numeric|min:0',
            'status'       => 'required|in:Lunas,Belum Lunas',
            'keterangan'   => 'nullable|string|max:100',
        ]);

        $pembayaran->update($request->only([
            'id_penghuni','tanggal_bayar','bulan_bayar','jumlah','status','keterangan'
        ]));

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}