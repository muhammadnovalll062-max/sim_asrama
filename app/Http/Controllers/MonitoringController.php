<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function kamar(Request $request)
    {
        $search = $request->get('q');

        $kamar = Kamar::with('penghuni')
            ->when($search, fn($q) => $q->where('nomor_kamar', 'like', "%{$search}%"))
            ->orderBy('nomor_kamar')->get();

        return view('monitoring.kamar', compact('kamar', 'search'));
    }

    public function pembayaran(Request $request)
    {
        $search      = $request->get('q');
        $bulanFilter = $request->get('bulan');

        $data = Penghuni::with(['kamar', 'pembayaran' => fn($q) => $q->orderByDesc('bulan_bayar')])
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')->get();

        $bulanList = Pembayaran::selectRaw("DISTINCT bulan_bayar")->orderByDesc('bulan_bayar')->pluck('bulan_bayar');

        return view('monitoring.pembayaran', compact('data', 'bulanList', 'search', 'bulanFilter'));
    }
}