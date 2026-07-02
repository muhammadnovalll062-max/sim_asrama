@extends('layouts.app')
@section('title','Hasil Ranking')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden}
    table{width:100%;border-collapse:collapse} thead{background:#1e3a5f;color:#fff}
    th,td{padding:.75rem 1rem;text-align:center;font-size:.875rem}
    td:nth-child(2){text-align:left}
    tbody tr:nth-child(even){background:#f9fafb}
    .rank-1{background:#fef9c3!important;font-weight:bold}
    .badge-rank{width:30px;height:30px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem}
    .rank-gold{background:#fbbf24;color:#fff}
    .rank-silver{background:#9ca3af;color:#fff}
    .rank-bronze{background:#d97706;color:#fff}
    .rank-other{background:#e5e7eb;color:#374151}
    .alert{padding:.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-size:.875rem}
    .alert-success{background:#dcfce7;color:#16a34a}
    .info-box{background:#eff6ff;border-left:4px solid #2563eb;padding:.8rem 1rem;border-radius:4px;margin-bottom:1.2rem;font-size:.875rem}
</style>
@endpush

@section('content')
<div class="page-title">Hasil Ranking Profile Matching</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

@if($hasil->count() > 0)
<div class="info-box">Menampilkan {{ $hasil->count() }} calon. Ranking berdasarkan Nilai Akhir tertinggi = (60% × Core Factor) + (40% × Secondary Factor).</div>
<div class="card">
    <table>
        <thead>
            <tr><th>Ranking</th><th>Nama Calon</th><th>Nilai CF</th><th>Nilai SF</th><th>Nilai Akhir</th><th>Rekomendasi</th></tr>
        </thead>
        <tbody>
            @foreach($hasil as $h)
            <tr class="{{ $h->ranking == 1 ? 'rank-1' : '' }}">
                <td>
                    @php $cls = $h->ranking==1?'rank-gold':($h->ranking==2?'rank-silver':($h->ranking==3?'rank-bronze':'rank-other')) @endphp
                    <span class="badge-rank {{ $cls }}">{{ $h->ranking }}</span>
                </td>
                <td>{{ $h->calon->nama }}</td>
                <td>{{ number_format($h->nilai_cf, 4) }}</td>
                <td>{{ number_format($h->nilai_sf, 4) }}</td>
                <td><strong>{{ number_format($h->nilai_akhir, 4) }}</strong></td>
                <td>
                    @if($h->nilai_akhir >= 3.5)
                        <span class="badge" style="background:#dcfce7;color:#16a34a">✓ Direkomendasikan</span>
                    @else
                        <span class="badge" style="background:#fef9c3;color:#ca8a04">⚠ Perlu Pertimbangan</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card" style="padding:2rem;text-align:center;color:#6b7280">Belum ada hasil perhitungan. Silakan proses perhitungan terlebih dahulu.</div>
@endif
@endsection