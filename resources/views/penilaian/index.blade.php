@extends('layouts.app')
@section('title','Penilaian')

@push('styles')
<style>
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f}
    .btn{padding:.5rem 1rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}.btn-warning{background:#d97706;color:#fff}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden}
    table{width:100%;border-collapse:collapse} thead{background:#1e3a5f;color:#fff}
    th,td{padding:.75rem 1rem;text-align:left;font-size:.875rem}
    tbody tr:nth-child(even){background:#f9fafb}
    .badge{padding:.2rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .badge-sudah{background:#dcfce7;color:#16a34a}.badge-belum{background:#fee2e2;color:#dc2626}
    .alert{padding:.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-size:.875rem}
    .alert-success{background:#dcfce7;color:#16a34a}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Penilaian Calon Penghuni</div>
    <a href="{{ route('penilaian.create') }}" class="btn btn-primary">+ Input Penilaian</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
    <table>
        <thead><tr><th>No</th><th>Nama Calon</th><th>Jenis Kelamin</th><th>Status Penilaian</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($calon as $i => $c)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $c->nama }}</td><td>{{ $c->jenis_kelamin }}</td>
                <td>
                    @if($c->penilaian->count() > 0)
                        <span class="badge badge-sudah">Sudah Dinilai ({{ $c->penilaian->count() }} kriteria)</span>
                    @else
                        <span class="badge badge-belum">Belum Dinilai</span>
                    @endif
                </td>
                <td>
                    @if($c->penilaian->count() > 0)
                        <a href="{{ route('penilaian.edit', $c->id_calon) }}" class="btn btn-warning">Edit Nilai</a>
                    @else
                        <a href="{{ route('penilaian.create', $c->id_calon) }}" class="btn btn-primary">Input Nilai</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#6b7280;padding:2rem">Belum ada calon yang perlu dinilai.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection