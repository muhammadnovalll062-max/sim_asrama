@extends('layouts.app')
@section('title', 'Monitoring Status Pembayaran')

@push('styles')
<style>
    .page-title { font-size:1.2rem; font-weight:bold; color:#1e3a5f; margin-bottom:1.5rem; }
    .filter-bar { background:#fff; border-radius:8px; padding:1rem 1.2rem; box-shadow:0 1px 4px rgba(0,0,0,0.07); margin-bottom:1.2rem; display:flex; align-items:center; gap:1rem; }
    .filter-bar label { font-size:.875rem; font-weight:600; color:#374151; }
    .filter-bar select { padding:.4rem .7rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem; }
    .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem; }
    .stat-card { background:#fff; border-radius:8px; padding:1rem 1.2rem; box-shadow:0 1px 4px rgba(0,0,0,0.07); border-left:4px solid #2563eb; }
    .stat-card.green { border-color:#16a34a; }
    .stat-card.red { border-color:#dc2626; }
    .stat-card .label { font-size:.78rem; color:#6b7280; }
    .stat-card .value { font-size:1.6rem; font-weight:700; color:#1f2937; }
    .card { background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.08); overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    thead { background:#1e3a5f; color:#fff; }
    th, td { padding:.75rem 1rem; text-align:left; font-size:.875rem; }
    tbody tr:nth-child(even) { background:#f9fafb; }
    tbody tr:hover { background:#f0f2f5; }
    .badge { padding:.2rem .6rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-lunas { background:#dcfce7; color:#16a34a; }
    .badge-belum { background:#fee2e2; color:#dc2626; }
    .badge-none  { background:#f3f4f6; color:#6b7280; }
    .btn, .btn-primary
</style>
@endpush

@section('content')
<div class="page-title">Monitoring Status Pembayaran</div>

<form method="GET" class="filter-bar" style="flex-wrap:wrap;">
    <label>Cari Nama:</label>
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Nama penghuni..." style="padding:.4rem .7rem;border:1px solid #d1d5db;border-radius:4px;font-size:.875rem;">
    <label>Filter Bulan:</label>
    <select name="bulan" onchange="this.form.submit()">
        <option value="">-- Semua Bulan --</option>
        @foreach($bulanList as $b)
            <option value="{{ $b }}" {{ $bulanFilter==$b ? 'selected':'' }}>{{ $b }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary" style="padding:.4rem 1rem;">Terapkan</button>
</form>

@php
    $lunas = 0; $belum = 0;
    foreach($data as $p) {
        $bayar = $bulanFilter ? $p->pembayaran->firstWhere('bulan_bayar', $bulanFilter) : $p->pembayaran->first();
        if ($bayar && $bayar->status == 'Lunas') $lunas++; else $belum++;
    }
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Penghuni</div>
        <div class="value">{{ $data->count() }}</div>
    </div>
    <div class="stat-card green">
        <div class="label">Sudah Lunas</div>
        <div class="value">{{ $lunas }}</div>
    </div>
    <div class="stat-card red">
        <div class="label">Belum Lunas</div>
        <div class="value">{{ $belum }}</div>
    </div>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th><th>Nama Penghuni</th><th>Kamar</th>
                <th>Bulan</th><th>Jumlah</th><th>Tgl Bayar</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $p)
            @php
                $bayar = $bulanFilter
                    ? $p->pembayaran->firstWhere('bulan_bayar', $bulanFilter)
                    : $p->pembayaran->first();
            @endphp
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                <td>{{ $bayar->bulan_bayar ?? '-' }}</td>
                <td>{{ $bayar ? 'Rp '.number_format($bayar->jumlah,0,',','.') : '-' }}</td>
                <td>{{ $bayar && $bayar->tanggal_bayar ? \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($bayar)
                        <span class="badge {{ $bayar->status=='Lunas' ? 'badge-lunas':'badge-belum' }}">
                            {{ $bayar->status }}
                        </span>
                    @else
                        <span class="badge badge-none">Belum Ada Data</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection