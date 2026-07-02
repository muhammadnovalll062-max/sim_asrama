@extends('layouts.app')
@section('title', 'Monitoring Status Kamar')

@push('styles')
<style>
    .page-title { font-size:1.2rem; font-weight:bold; color:#1e3a5f; margin-bottom:1.5rem; }
    .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem; }
    .stat-card { background:#fff; border-radius:8px; padding:1rem 1.2rem; box-shadow:0 1px 4px rgba(0,0,0,0.07); border-left:4px solid #2563eb; }
    .stat-card.green { border-color:#16a34a; }
    .stat-card.yellow { border-color:#d97706; }
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
    .badge-kosong { background:#dcfce7; color:#16a34a; }
    .badge-terisi { background:#fef9c3; color:#ca8a04; }
    .badge-penuh  { background:#fee2e2; color:#dc2626; }
    .progress { background:#e5e7eb; border-radius:99px; height:8px; }
    .progress-bar { background:#2563eb; border-radius:99px; height:8px; }
    .btn-secondary{background:#6b7280;color:#fff}
</style>
@endpush

@section('content')
<div class="page-title">Monitoring Status Kamar</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Kamar</div>
        <div class="value">{{ $kamar->count() }}</div>
    </div>
    <div class="stat-card green">
        <div class="label">Kosong</div>
        <div class="value">{{ $kamar->where('status','Kosong')->count() }}</div>
    </div>
    <div class="stat-card yellow">
        <div class="label">Terisi</div>
        <div class="value">{{ $kamar->where('status','Terisi')->count() }}</div>
    </div>
    <div class="stat-card red">
        <div class="label">Penuh</div>
        <div class="value">{{ $kamar->where('status','Penuh')->count() }}</div>
    </div>
</div>

<form method="GET" style="margin-bottom:1.2rem; display:flex; gap:.6rem;">
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari..." style="flex:1; max-width:320px; padding:.55rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(!empty($search))<a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th><th>Nomor Kamar</th><th>Kapasitas</th>
                <th>Terisi</th><th>Hunian</th><th>Status</th><th>Penghuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kamar as $i => $k)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $k->nomor_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }} / {{ $k->kapasitas }}</td>
                <td style="width:120px">
                    @php $pct = $k->kapasitas > 0 ? round(($k->terisi/$k->kapasitas)*100) : 0; @endphp
                    <div class="progress"><div class="progress-bar" style="width:{{ $pct }}%"></div></div>
                    <small style="color:#6b7280">{{ $pct }}%</small>
                </td>
                <td>
                    <span class="badge badge-{{ strtolower($k->status) }}">{{ $k->status }}</span>
                </td>
                <td style="font-size:.8rem; color:#374151">
                    {{ $k->penghuni->pluck('nama')->join(', ') ?: '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection