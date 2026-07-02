@extends('layouts.app')
@section('title', 'Laporan Administrasi')

@push('styles')
<style>
    .page-title { font-size:1.2rem; font-weight:bold; color:#1e3a5f; margin-bottom:1.5rem; }
    .laporan-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:1rem; }
    .laporan-card {
        background:#fff; border-radius:10px;
        box-shadow:0 1px 4px rgba(0,0,0,0.08);
        padding:1.4rem; display:flex; flex-direction:column; gap:.8rem;
        border-top:4px solid #2563eb;
    }
    .laporan-card h3 { font-size:.95rem; color:#1e3a5f; }
    .laporan-card p  { font-size:.82rem; color:#6b7280; flex:1; }
    .btn-pdf {
        display:inline-block; padding:.5rem 1rem;
        background:#dc2626; color:#fff;
        border-radius:4px; text-decoration:none;
        font-size:.85rem; text-align:center;
    }
    .btn-pdf:hover { background:#b91c1c; }
</style>
@endpush

@section('content')
<div class="page-title">Laporan Administrasi</div>
<div class="laporan-grid">
    <div class="laporan-card">
        <h3>📋 Laporan Data Penghuni</h3>
        <p>Rekap seluruh data penghuni beserta informasi kamar yang ditempati.</p>
        <a href="{{ route('laporan.penghuni') }}" class="btn-pdf" target="_blank">Cetak PDF</a>
    </div>
    <div class="laporan-card">
        <h3>🚪 Laporan Data Kamar</h3>
        <p>Rekap data kamar beserta status hunian dan daftar penghuni per kamar.</p>
        <a href="{{ route('laporan.kamar') }}" class="btn-pdf" target="_blank">Cetak PDF</a>
    </div>
    <div class="laporan-card">
        <h3>💰 Laporan Pembayaran</h3>
        <p>Rekap seluruh transaksi pembayaran sewa kamar penghuni.</p>
        <a href="{{ route('laporan.pembayaran') }}" class="btn-pdf" target="_blank">Cetak PDF</a>
    </div>
    <div class="laporan-card">
        <h3>⚠️ Laporan Tunggakan</h3>
        <p>Daftar penghuni yang belum melunasi pembayaran sewa kamar.</p>
        <a href="{{ route('laporan.tunggakan') }}" class="btn-pdf" target="_blank">Cetak PDF</a>
    </div>
    <div class="laporan-card">
        <h3>📊 Laporan Monitoring Asrama</h3>
        <p>Ringkasan kondisi asrama meliputi status kamar dan hunian penghuni.</p>
        <a href="{{ route('laporan.monitoring') }}" class="btn-pdf" target="_blank">Cetak PDF</a>
    </div>
</div>
@endsection