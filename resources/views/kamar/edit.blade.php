@extends('layouts.app')

@section('title', 'Edit Kamar')

@push('styles')
<style>
    .page-title { font-size: 1.2rem; font-weight: bold; color: #1e3a5f; margin-bottom: 1.5rem; }
    .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 1.5rem; max-width: 500px; }
    .form-group { margin-bottom: 1.2rem; }
    label { display: block; margin-bottom: .4rem; font-size: .875rem; font-weight: 600; color: #374151; }
    input {
        width: 100%; padding: .6rem .8rem;
        border: 1px solid #d1d5db; border-radius: 4px;
        font-size: .9rem;
    }
    input:focus { outline: none; border-color: #2563eb; }
    .error-msg { color: #dc2626; font-size: .8rem; margin-top: .3rem; }
    .hint { font-size: .78rem; color: #6b7280; margin-top: .3rem; }
    .btn { padding: .5rem 1.2rem; border-radius: 4px; border: none; cursor: pointer; font-size: .875rem; text-decoration: none; display: inline-block; }
    .btn-primary { background: #2563eb; color: #fff; }
    .btn-secondary { background: #6b7280; color: #fff; margin-left: .5rem; }
</style>
@endpush

@section('content')
    <div class="page-title">Edit Kamar</div>

    <div class="card">
        <form method="POST" action="{{ route('kamar.update', $kamar->id_kamar) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nomor Kamar</label>
                <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}">
                @error('nomor_kamar') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas', $kamar->kapasitas) }}" min="{{ $kamar->terisi }}">
                <div class="hint">Saat ini terisi: {{ $kamar->terisi }} orang. Kapasitas tidak boleh kurang dari jumlah penghuni aktif.</div>
                @error('kapasitas') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection