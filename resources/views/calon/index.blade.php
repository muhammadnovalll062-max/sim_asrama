@extends('layouts.app')
@section('title', 'Data Calon Penghuni')

@push('styles')
<style>
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f}
    .btn{padding:.5rem 1rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}
    .btn-warning{background:#d97706;color:#fff}
    .btn-danger{background:#dc2626;color:#fff}
    .btn-secondary{background:#6b7280;color:#fff}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden}
    table{width:100%;border-collapse:collapse}
    thead{background:#1e3a5f;color:#fff}
    th,td{padding:.75rem 1rem;text-align:left;font-size:.875rem}
    tbody tr:nth-child(even){background:#f9fafb}
    tbody tr:hover{background:#f0f2f5}
    .badge{padding:.2rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .badge-menunggu{background:#fef9c3;color:#ca8a04}
    .badge-diterima{background:#dcfce7;color:#16a34a}
    .badge-ditolak{background:#fee2e2;color:#dc2626}
    .alert{padding:.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-size:.875rem}
    .alert-success{background:#dcfce7;color:#16a34a}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Data Calon Penghuni (Menunggu)</div>
    <div>
        <a href="{{ route('calon.riwayat') }}" class="btn btn-secondary">Riwayat Seleksi</a>
        <a href="{{ route('calon.create') }}" class="btn btn-primary">+ Tambah Calon</a>
    </div>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card">
    <table>
        <thead>
            <tr><th>No</th><th>Nama</th><th>Jenis Kelamin</th><th>No. HP</th><th>Alamat</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($calon as $i => $c)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $c->nama }}</td>
                <td>{{ $c->jenis_kelamin }}</td>
                <td>{{ $c->no_hp ?? '-' }}</td>
                <td>{{ $c->alamat ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($c->status) }}">{{ $c->status }}</span>
                </td>
                <td>
                    @if($c->status == 'Menunggu')
                    <a href="{{ route('calon.edit', $c->id_calon) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('calon.destroy', $c->id_calon) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus calon ini?')">Hapus</button>
                    </form>
                    @else
                    <span style="color:#9ca3af;font-size:.8rem">{{ $c->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:2rem">Belum ada data calon penghuni.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection