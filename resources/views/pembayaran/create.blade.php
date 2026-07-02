@extends('layouts.app')
@section('title', 'Catat Pembayaran')

@push('styles')
<style>
    .page-title { font-size:1.2rem; font-weight:bold; color:#1e3a5f; margin-bottom:1.5rem; }
    .card { background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.08); padding:1.5rem; max-width:560px; }
    .form-group { margin-bottom:1.2rem; }
    label { display:block; margin-bottom:.4rem; font-size:.875rem; font-weight:600; color:#374151; }
    input, select, textarea { width:100%; padding:.6rem .8rem; border:1px solid #d1d5db; border-radius:4px; font-size:.9rem; }
    input:focus, select:focus { outline:none; border-color:#2563eb; }
    .error-msg { color:#dc2626; font-size:.8rem; margin-top:.3rem; }
    .btn { padding:.5rem 1.2rem; border-radius:4px; border:none; cursor:pointer; font-size:.875rem; text-decoration:none; display:inline-block; }
    .btn-primary { background:#2563eb; color:#fff; }
    .btn-secondary { background:#6b7280; color:#fff; margin-left:.5rem; }
</style>
@endpush

@section('content')
<div class="page-title">Catat Pembayaran</div>
<div class="card">
    <form method="POST" action="{{ route('pembayaran.store') }}">
        @csrf
        <div class="form-group">
            <label>Penghuni</label>
            <select name="id_penghuni">
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                <option value="{{ $p->id_penghuni }}" {{ old('id_penghuni')==$p->id_penghuni ? 'selected':'' }}>
                    {{ $p->nama }} — Kamar {{ $p->kamar->nomor_kamar ?? '-' }}
                </option>
                @endforeach
            </select>
            @error('id_penghuni') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Bulan Bayar</label>
            <input type="text" name="bulan_bayar" value="{{ old('bulan_bayar') }}" placeholder="Contoh: Juni 2026">
            @error('bulan_bayar') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="0">
            @error('jumlah') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="Belum Lunas" {{ old('status')=='Belum Lunas' ? 'selected':'' }}>Belum Lunas</option>
                <option value="Lunas"       {{ old('status')=='Lunas'       ? 'selected':'' }}>Lunas</option>
            </select>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Opsional">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection