@extends('layouts.app')

@section('title', 'Dashboard Penilai')

@section('content')
    <div style="background:#fff;border-radius:10px;padding:2rem;box-shadow:0 1px 4px rgba(0,0,0,0.06)">
        <h2 style="color:#1e2a52;margin-bottom:.5rem">Selamat Datang, {{ Auth::user()->name }}</h2>
        <p style="color:#6b7280;font-size:.9rem">Panel Penilai — Sistem Pendukung Keputusan Seleksi Calon Penghuni</p>
    </div>
@endsection