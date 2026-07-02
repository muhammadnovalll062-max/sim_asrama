<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function penghuni()
    {
        $data = Penghuni::with('kamar')->orderBy('nama')->get();
        $pdf  = Pdf::loadView('laporan.penghuni', compact('data'))->setPaper('a4','portrait');
        return $pdf->stream('laporan-penghuni.pdf');
    }

    public function kamar()
    {
        $data = Kamar::with('penghuni')->orderBy('nomor_kamar')->get();
        $pdf  = Pdf::loadView('laporan.kamar', compact('data'))->setPaper('a4','portrait');
        return $pdf->stream('laporan-kamar.pdf');
    }

    public function pembayaran()
    {
        $data = Pembayaran::with('penghuni')->orderByDesc('tanggal_bayar')->get();
        $pdf  = Pdf::loadView('laporan.pembayaran', compact('data'))->setPaper('a4','landscape');
        return $pdf->stream('laporan-pembayaran.pdf');
    }

    public function tunggakan()
    {
        $data = Pembayaran::with('penghuni.kamar')
            ->where('status', 'Belum Lunas')
            ->orderBy('bulan_bayar')
            ->get();
        $pdf  = Pdf::loadView('laporan.tunggakan', compact('data'))->setPaper('a4','portrait');
        return $pdf->stream('laporan-tunggakan.pdf');
    }

    public function monitoring()
    {
        $kamar    = Kamar::with('penghuni')->orderBy('nomor_kamar')->get();
        $penghuni = Penghuni::with('kamar')->orderBy('nama')->get();
        $pdf      = Pdf::loadView('laporan.monitoring', compact('kamar','penghuni'))->setPaper('a4','portrait');
        return $pdf->stream('laporan-monitoring.pdf');
    }
}