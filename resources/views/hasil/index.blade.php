@extends('layouts.app')
@section('title','Hasil Seleksi')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden}
    table{width:100%;border-collapse:collapse} thead{background:#1e3a5f;color:#fff}
    th,td{padding:.75rem 1rem;text-align:center;font-size:.875rem}
    td:nth-child(2){text-align:left}
    tbody tr:nth-child(even){background:#f9fafb}
    .badge{padding:.2rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .badge-menunggu{background:#fef9c3;color:#ca8a04}
    .badge-diterima{background:#dcfce7;color:#16a34a}
    .badge-ditolak{background:#fee2e2;color:#dc2626}
    .btn{padding:.4rem .8rem;border-radius:4px;border:none;cursor:pointer;font-size:.8rem;text-decoration:none;display:inline-block}
    .btn-success{background:#16a34a;color:#fff}
    .btn-danger{background:#dc2626;color:#fff}
    .btn-secondary{background:#6b7280;color:#fff}
    .alert{padding:.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-size:.875rem}
    .alert-success{background:#dcfce7;color:#16a34a}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Hasil Seleksi Calon Penghuni</div>
    <a href="{{ route('hasil.riwayat') }}" class="btn btn-secondary">Riwayat Seleksi</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

@if($hasil->count() > 0)

<form method="GET" style="margin-bottom:1.2rem; display:flex; gap:.6rem;">
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari..." style="flex:1; max-width:320px; padding:.55rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(!empty($search))<a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead>
            <tr><th>Ranking</th><th>Nama Calon</th><th>Nilai CF</th><th>Nilai SF</th><th>Nilai Akhir</th><th>Rekomendasi</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($hasil as $h)
            <tr>
                <td><strong>#{{ $h->ranking }}</strong></td>
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
                <td><span class="badge badge-{{ strtolower($h->calon->status) }}">{{ $h->calon->status }}</span></td>
                <td>
                    @if($h->calon->status == 'Menunggu')
                    <a href="{{ route('hasil.terima.form', $h->calon->id_calon) }}" class="btn btn-success">✓ Terima</a>
                    <form method="POST" action="{{ route('hasil.tolak', $h->calon->id_calon) }}" style="display:inline">
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Tolak calon ini?')">✗ Tolak</button>
                    </form>
                    @else
                    <span style="color:#9ca3af;font-size:.8rem">{{ $h->calon->status }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card" style="padding:2rem;text-align:center;color:#6b7280">Belum ada hasil seleksi. Penilai perlu memproses perhitungan terlebih dahulu.</div>
@endif
@endsection