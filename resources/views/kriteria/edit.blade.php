@extends('layouts.app')
@section('title', 'Edit Kriteria')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);padding:1.5rem;max-width:500px}
    .form-group{margin-bottom:1.2rem}
    label{display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:#374151}
    input,select{width:100%;padding:.6rem .8rem;border:1px solid #d1d5db;border-radius:4px;font-size:.9rem}
    .error-msg{color:#dc2626;font-size:.8rem;margin-top:.3rem}
    .btn{padding:.5rem 1.2rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}
    .btn-secondary{background:#6b7280;color:#fff;margin-left:.5rem}
</style>
@endpush

@section('content')
<div class="page-title">Edit Kriteria</div>
<div class="card">
    <form method="POST" action="{{ route('kriteria.update', $kriteria->id_kriteria) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Kode Kriteria</label>
            <input type="text" name="kode_kriteria" value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}">
            @error('kode_kriteria')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}">
        </div>
        <div class="form-group">
            <label>Nilai Ideal (1-5)</label>
            <input type="number" name="nilai_ideal" value="{{ old('nilai_ideal', $kriteria->nilai_ideal) }}" min="1" max="5" step="0.5">
        </div>
        <div class="form-group">
            <label>Jenis</label>
            <select name="jenis">
                <option value="Core"      {{ old('jenis',$kriteria->jenis)=='Core'      ?'selected':'' }}>Core Factor</option>
                <option value="Secondary" {{ old('jenis',$kriteria->jenis)=='Secondary' ?'selected':'' }}>Secondary Factor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection