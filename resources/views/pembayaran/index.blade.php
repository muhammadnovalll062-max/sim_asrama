@extends('layouts.app')
@section('title', 'Data Pembayaran')

@push('styles')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .page-title { font-size:1.2rem; font-weight:bold; color:#1e3a5f; }
    .btn { padding:.5rem 1rem; border-radius:4px; border:none; cursor:pointer; font-size:.875rem; text-decoration:none; display:inline-block; }
    .btn-primary { background:#2563eb; color:#fff; }
    .btn-warning { background:#d97706; color:#fff; }
    .btn-danger  { background:#dc2626; color:#fff; }
    .btn-secondary{background:#6b7280;color:#fff}
    .card { background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.08); overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    thead { background:#1e3a5f; color:#fff; }
    th, td { padding:.75rem 1rem; text-align:left; font-size:.875rem; }
    tbody tr:nth-child(even) { background:#f9fafb; }
    tbody tr:hover { background:#f0f2f5; }
    .badge { padding:.2rem .6rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-lunas   { background:#dcfce7; color:#16a34a; }
    .badge-belum   { background:#fee2e2; color:#dc2626; }
    .alert { padding:.75rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:.875rem; }
    .alert-success { background:#dcfce7; color:#16a34a; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Data Pembayaran</div>
    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">+ Catat Pembayaran</a>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<form method="GET" style="margin-bottom:1.2rem; display:flex; gap:.6rem;">
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari..." style="flex:1; max-width:320px; padding:.55rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(!empty($search))<a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th><th>Penghuni</th><th>Bulan</th>
                <th>Jumlah</th><th>Tgl Bayar</th><th>Status</th>
                <th>Keterangan</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->penghuni->nama ?? '-' }}</td>
                <td>{{ $p->bulan_bayar }}</td>
                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td>{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                <td>
                    <span class="badge {{ $p->status == 'Lunas' ? 'badge-lunas' : 'badge-belum' }}">
                        {{ $p->status }}
                    </span>
                </td>
                <td>{{ $p->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('pembayaran.edit', $p->id_pembayaran) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('pembayaran.destroy', $p->id_pembayaran) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#6b7280;padding:2rem">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection