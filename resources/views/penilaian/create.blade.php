@extends('layouts.app')
@section('title','Input Penilaian')

@push('styles')
<style>
    .page-title{font-size:1.2rem;font-weight:bold;color:#1e3a5f;margin-bottom:1.5rem}
    .card{background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);padding:1.5rem;max-width:600px}
    .form-group{margin-bottom:1.2rem}
    label{display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:#374151}
    select,input{width:100%;padding:.6rem .8rem;border:1px solid #d1d5db;border-radius:4px;font-size:.9rem}
    .kriteria-table{width:100%;border-collapse:collapse;margin-top:.5rem}
    .kriteria-table th,.kriteria-table td{padding:.6rem .8rem;border:1px solid #e5e7eb;font-size:.875rem}
    .kriteria-table th{background:#f9fafb;color:#374151}
    .kriteria-table input{width:80px;text-align:center}
    .hint{font-size:.75rem;color:#9ca3af;margin-top:.3rem}
    .error-msg{color:#dc2626;font-size:.8rem;margin-top:.3rem}
    .btn{padding:.5rem 1.2rem;border-radius:4px;border:none;cursor:pointer;font-size:.875rem;text-decoration:none;display:inline-block}
    .btn-primary{background:#2563eb;color:#fff}.btn-secondary{background:#6b7280;color:#fff;margin-left:.5rem}
</style>
@endpush

@section('content')
<div class="page-title">Input Penilaian</div>
<div class="card">
    <form method="POST" action="{{ route('penilaian.store') }}">
        @csrf
        <div class="form-group">
            <label>Calon Penghuni</label>
            @if($selected)
                <input type="text" value="{{ $selected->nama }}" disabled style="background:#f3f4f6">
                <input type="hidden" name="id_calon" value="{{ $selected->id_calon }}">
            @else
                <select name="id_calon" required>
                    <option value="">-- Pilih Calon --</option>
                    @foreach($calonList as $c)
                    <option value="{{ $c->id_calon }}" {{ old('id_calon')==$c->id_calon?'selected':'' }}>{{ $c->nama }}</option>
                    @endforeach
                </select>
            @endif
            @error('id_calon')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Nilai Per Kriteria <span style="font-weight:400;color:#6b7280">(Skala 1–5)</span></label>
            <table class="kriteria-table">
                <thead><tr><th>Kode</th><th>Nama Kriteria</th><th>Jenis</th><th>Nilai Ideal</th><th>Nilai</th></tr></thead>
                <tbody>
                    @foreach($kriteria as $k)
                    <tr>
                        <td><strong>{{ $k->kode_kriteria }}</strong></td>
                        <td>{{ $k->nama_kriteria }}</td>
                        <td>{{ $k->jenis }}</td>
                        <td style="text-align:center">{{ $k->nilai_ideal }}</td>
                        <td><input type="number" name="nilai[{{ $k->id_kriteria }}]" value="{{ old('nilai.'.$k->id_kriteria) }}" min="1" max="5" step="1" required></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="hint">Isi nilai 1–5 untuk setiap kriteria sesuai kondisi calon penghuni.</div>
            @error('nilai')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection