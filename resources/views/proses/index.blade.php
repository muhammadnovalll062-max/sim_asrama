@extends('layouts.app')
@section('title','Proses Perhitungan')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .info-box{background:#eff6ff;border-left:4px solid #2563eb;padding:.8rem 1rem;border-radius:4px;margin-bottom:1.2rem;font-size:.875rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden;margin-bottom:1.2rem}
    table{width:100%;border-collapse:collapse} thead{background:#1e3a5f;color:#fff}
    th,td{padding:.7rem 1rem;text-align:center;font-size:.85rem;border-bottom:1px solid #e5e7eb}
    td:first-child,td:nth-child(2){text-align:left}
    tbody tr:hover{background:#f9fafb}
    .btn{padding:.6rem 1.4rem;border-radius:4px;border:none;cursor:pointer;font-size:.9rem;text-decoration:none;display:inline-block}
    .btn-success{background:#16a34a;color:#fff}
    .btn-success:hover{background:#15803d}
    .alert{padding:.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-size:.875rem}
    .alert-success{background:#dcfce7;color:#16a34a}
</style>
@endpush

@section('content')
<div class="page-title">Proses Perhitungan Profile Matching</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="info-box">
    Tabel di bawah menampilkan nilai yang sudah diinput untuk setiap calon. Klik <strong>Proses Perhitungan</strong> untuk menghitung GAP, Core Factor, Secondary Factor, dan Nilai Akhir secara otomatis.
</div>

@if($calon->count() > 0)
<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Calon</th>
                @foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calon as $i => $c)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $c->nama }}</td>
                @foreach($kriteria as $k)
                @php $nilai = $c->penilaian->firstWhere('id_kriteria', $k->id_kriteria) @endphp
                <td>{{ $nilai ? $nilai->nilai : '-' }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form method="POST" action="{{ route('proses.hitung') }}">
    @csrf
    <button type="submit" class="btn btn-success" onclick="return confirm('Proses perhitungan Profile Matching sekarang?')">
        ⚙️ Proses Perhitungan
    </button>
</form>
@else
<div class="card" style="padding:2rem;text-align:center;color:#6b7280">
    Belum ada calon penghuni yang sudah dinilai. Silakan input penilaian terlebih dahulu.
</div>
@endif
@endsection