@extends('layouts.app')
@section('title','Edit Penilaian')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);padding:1.5rem;max-width:600px}
    .form-group{margin-bottom:1.2rem}
    label{display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:#374151}
    .kriteria-table{width:100%;border-collapse:collapse}
    .kriteria-table th,.kriteria-table td{padding:.6rem .8rem;border:1px solid #e5e7eb;font-size:.875rem}
    .kriteria-table th{background:#f9fafb}
    .kriteria-table input{width:80px;text-align:center;padding:.4rem;border:1px solid #d1d5db;border-radius:4px}
    .btn{padding:.5rem 1.2rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}.btn-secondary{background:#6b7280;color:#fff;margin-left:.5rem}
    .info-box{background:#eff6ff;border-left:4px solid #2563eb;padding:.7rem 1rem;border-radius:4px;margin-bottom:1rem;font-size:.875rem}
</style>
@endpush

@section('content')
<div class="page-title">Edit Penilaian</div>
<div class="card">
    <div class="info-box">Calon: <strong>{{ $calon->nama }}</strong></div>
    <form method="POST" action="{{ route('penilaian.update', $calon->id_calon) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <table class="kriteria-table">
                <thead><tr><th>Kode</th><th>Nama Kriteria</th><th>Jenis</th><th>Nilai Ideal</th><th>Nilai</th></tr></thead>
                <tbody>
                    @foreach($kriteria as $k)
                    <tr>
                        <td><strong>{{ $k->kode_kriteria }}</strong></td>
                        <td>{{ $k->nama_kriteria }}</td>
                        <td>{{ $k->jenis }}</td>
                        <td style="text-align:center">{{ $k->nilai_ideal }}</td>
                        <td><input type="number" name="nilai[{{ $k->id_kriteria }}]" value="{{ old('nilai.'.$k->id_kriteria, $penilaian[$k->id_kriteria] ?? '') }}" min="1" max="5" step="1" required></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Update Penilaian</button>
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection