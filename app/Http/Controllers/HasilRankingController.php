<?php
namespace App\Http\Controllers;

use App\Models\HasilSeleksi;

class HasilRankingController extends Controller
{
    public function index()
    {
        $hasil = HasilSeleksi::with('calon')
                    ->whereHas('calon', fn($q) => $q->where('status','Menunggu'))
                    ->orderBy('ranking')->get();
        return view('ranking.index', compact('hasil'));
    }
}