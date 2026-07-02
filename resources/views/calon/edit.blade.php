@extends('layouts.app')
@section('title', 'Edit Calon Penghuni')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);padding:1.5rem;max-width:560px}
    .form-group{margin-bottom:1.2rem}
    label{display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:#374151}
    input,select,textarea{width:100%;padding:.6rem .8rem;border:1px solid #d1d5db;border-radius:4px;font-size:.9rem}
    .error-msg{color:#dc2626;font-size:.8rem;margin-top:.3rem}
    .btn{padding:.5rem 1.2rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}
    .btn-secondary{background:#6b7280;color:#fff;margin-left:.5rem}
</style>
@endpush

@section('content')
<div class="page-title">Edit Calon Penghuni</div>
<div class="card">
    <form method="POST" action="{{ route('calon.update', $calon->id_calon) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $calon->nama) }}">
            @error('nama')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="Laki-laki" {{ old('jenis_kelamin',$calon->jenis_kelamin)=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin',$calon->jenis_kelamin)=='Perempuan'?'selected':'' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $calon->no_hp) }}">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="2">{{ old('alamat', $calon->alamat) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('calon.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection