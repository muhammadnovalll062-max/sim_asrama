<?php
namespace App\Http\Controllers;

use App\Models\CalonPenghuni;
use App\Models\Kriteria;
use App\Models\HasilSeleksi;

class ProsesPerhitunganController extends Controller
{
    private $bobotTable = [
        0=>5, 1=>4.5, -1=>4, 2=>3.5, -2=>3,
        3=>2.5, -3=>2, 4=>1.5, -4=>1
    ];

    public function index()
    {
        $calon    = CalonPenghuni::with(['penilaian.kriteria','hasilSeleksi'])
                        ->where('status','Menunggu')->whereHas('penilaian')->orderBy('nama')->get();
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('proses.index', compact('calon','kriteria'));
    }

    public function hitung()
    {
        $calonList = CalonPenghuni::with(['penilaian.kriteria'])
                        ->where('status','Menunggu')->whereHas('penilaian')->get();

        foreach ($calonList as $calon) {
            $cf = []; $sf = [];
            foreach ($calon->penilaian as $p) {
                $gap   = max(-4, min(4, intval($p->nilai) - intval($p->kriteria->nilai_ideal)));
                $bobot = $this->bobotTable[$gap] ?? 1;
                $p->kriteria->jenis == 'Core' ? $cf[] = $bobot : $sf[] = $bobot;
            }
            $nilaiCF    = count($cf) > 0 ? array_sum($cf)/count($cf) : 0;
            $nilaiSF    = count($sf) > 0 ? array_sum($sf)/count($sf) : 0;
            $nilaiAkhir = (0.6 * $nilaiCF) + (0.4 * $nilaiSF);

            HasilSeleksi::updateOrCreate(
                ['id_calon' => $calon->id_calon],
                ['nilai_cf' => $nilaiCF, 'nilai_sf' => $nilaiSF, 'nilai_akhir' => $nilaiAkhir, 'ranking' => 0]
            );
        }

        // Update ranking
        $semua = HasilSeleksi::with('calon')
                    ->whereHas('calon', fn($q) => $q->where('status','Menunggu'))
                    ->orderByDesc('nilai_akhir')->get();
        foreach ($semua as $i => $h) $h->update(['ranking' => $i + 1]);

        return redirect()->route('ranking.index')->with('success','Perhitungan Profile Matching berhasil diproses.');
    }
}