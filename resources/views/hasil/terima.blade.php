@extends('layouts.app')
@section('title','Terima Calon Penghuni')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);padding:1.5rem;max-width:520px}
    .info-box{background:#dcfce7;border-left:4px solid #16a34a;padding:.8rem 1rem;border-radius:4px;margin-bottom:1.2rem;font-size:.875rem}
    .form-group{margin-bottom:1.2rem}
    label{display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:#374151}
    select,input{width:100%;padding:.6rem .8rem;border:1px solid #d1d5db;border-radius:4px;font-size:.9rem}
    .error-msg{color:#dc2626;font-size:.8rem;margin-top:.3rem}
    .btn{padding:.5rem 1.2rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-success{background:#16a34a;color:#fff}.btn-secondary{background:#6b7280;color:#fff;margin-left:.5rem}
</style>
@endpush

@section('content')
<div class="page-title">Terima Calon Penghuni</div>
<div class="card">
    <div class="info-box">
        Anda akan menerima <strong>{{ $calon->nama }}</strong> sebagai penghuni asrama. Pilih kamar dan tanggal masuk.
    </div>
    <form method="POST" action="{{ route('hasil.terima', $calon->id_calon) }}">
        @csrf
        <div class="form-group">
            <label>Pilih Kamar</label>
            <select name="id_kamar" required>
                <option value="">-- Pilih Kamar --</option>
                @foreach($kamar as $k)
                <option value="{{ $k->id_kamar }}">{{ $k->nomor_kamar }} ({{ $k->terisi }}/{{ $k->kapasitas }}) — {{ $k->status }}</option>
                @endforeach
            </select>
            @error('id_kamar')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required>
            @error('tanggal_masuk')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi penerimaan calon ini?')">✓ Konfirmasi Terima</button>
        <a href="{{ route('hasil.seleksi') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection