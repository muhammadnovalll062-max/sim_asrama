@extends('layouts.app')
@section('title','Riwayat Seleksi')

@push('styles')
<style>
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f}
    .btn{padding:.5rem 1rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}
    .btn-secondary{background:#6b7280;color:#fff}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden}
    table{width:100%;border-collapse:collapse} thead{background:#1e3a5f;color:#fff}
    th,td{padding:.75rem 1rem;text-align:center;font-size:.875rem}
    td:nth-child(2){text-align:left}
    tbody tr:nth-child(even){background:#f9fafb}
    .badge{padding:.2rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .badge-diterima{background:#dcfce7;color:#16a34a}
    .badge-ditolak{background:#fee2e2;color:#dc2626}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Riwayat Seleksi Calon Penghuni</div>
    <a href="{{ route('calon.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<form method="GET" style="margin-bottom:1.2rem; display:flex; gap:.6rem;">
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari nama..." style="flex:1; max-width:320px; padding:.55rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(!empty($search))<a href="{{ route('calon.riwayat') }}" class="btn btn-secondary">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead><tr><th>No</th><th>Nama</th><th>Jenis Kelamin</th><th>Nilai Akhir</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($riwayat as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->jenis_kelamin }}</td>
                <td>{{ $r->hasilSeleksi ? number_format($r->hasilSeleksi->nilai_akhir, 4) : '-' }}</td>
                <td><span class="badge badge-{{ strtolower($r->status) }}">{{ $r->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#6b7280;padding:2rem">Belum ada riwayat seleksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection