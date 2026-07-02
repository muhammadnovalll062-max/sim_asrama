<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar    = Kamar::count();
        $kamarKosong   = Kamar::where('status', 'Kosong')->count();
        $kamarTerisi   = Kamar::where('status', 'Terisi')->count();
        $kamarPenuh    = Kamar::where('status', 'Penuh')->count();
        $totalPenghuni = Penghuni::count();
        $totalLunas    = Pembayaran::where('status', 'Lunas')->count();
        $totalBelum    = Pembayaran::where('status', 'Belum Lunas')->count();

        $pemasukanBulanIni = Pembayaran::where('status', 'Lunas')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah');

        // Grafik pemasukan 6 bulan terakhir
        $raw = Pembayaran::where('status', 'Lunas')
            ->whereNotNull('tanggal_bayar')
            ->where('tanggal_bayar', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(tanggal_bayar, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->get();

        $grafikLabel = [];
        $grafikData  = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $match = $raw->firstWhere('bulan', $key);
            $grafikLabel[] = Carbon::createFromFormat('Y-m', $key)->locale('id')->isoFormat('MMM');
            $grafikData[]  = $match ? (float) $match->total : 0;
        }

        $aktivitas = Penghuni::orderByDesc('tanggal_masuk')->take(5)->get();

        return view('dashboard', compact(
            'totalKamar', 'kamarKosong', 'kamarTerisi', 'kamarPenuh',
            'totalPenghuni', 'totalLunas', 'totalBelum', 'pemasukanBulanIni',
            'grafikLabel', 'grafikData', 'aktivitas'
        ));
    }
}