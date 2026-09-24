@extends('layouts.app')
@section('title', 'Data Penghuni')

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
    .alert { padding:.75rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:.875rem; }
    .alert-success { background:#dcfce7; color:#16a34a; }
    .alert-error   { background:#fee2e2; color:#dc2626; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Data Penghuni</div>
</div>

<div style="background:#eff6ff;border-left:4px solid #2563eb;padding:.7rem 1rem;border-radius:4px;font-size:.85rem;color:#1d4ed8;margin-bottom:1.5rem">
    Penghuni baru ditambahkan melalui proses Seleksi SPK.
    Lihat <a href="{{ route('hasil.seleksi') }}" style="font-weight:600">Hasil Seleksi</a>.
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="alert alert-error">{{ session('error') }}</div> @endif

<form method="GET" style="margin-bottom:1.2rem; display:flex; gap:.6rem;">
    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari..." style="flex:1; max-width:320px; padding:.55rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.875rem;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(!empty($search))<a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>@endif
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Jenis Kelamin</th>
                <th>No. HP</th><th>Kamar</th><th>Tgl Masuk</th><th>Alamat</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penghuni as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->no_hp ?? '-' }}</td>
                <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                <td>{{ $p->tanggal_masuk ? \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                <td>{{ $p->alamat ?? '-' }}</td>
                <td>
                    <a href="{{ route('penghuni.edit', $p->id_penghuni) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('penghuni.destroy', $p->id_penghuni) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus penghuni ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#6b7280;padding:2rem">Belum ada data penghuni.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection