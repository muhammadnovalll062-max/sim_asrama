<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 11px; color: #1f2937; }
    .header { text-align:center; margin-bottom:16px; border-bottom:2px solid #1e3a5f; padding-bottom:8px; }
    .header h2 { font-size:14px; margin:0; color:#1e3a5f; }
    .header p  { margin:2px 0; font-size:10px; color:#6b7280; }
    .section-title { font-size:12px; font-weight:bold; margin:16px 0 6px; color:#1e3a5f; border-left:3px solid #2563eb; padding-left:6px; }
    table { width:100%; border-collapse:collapse; }
    th { background:#1e3a5f; color:#fff; padding:6px 8px; text-align:left; font-size:10px; }
    td { padding:5px 8px; border-bottom:1px solid #e5e7eb; }
    tr:nth-child(even) td { background:#f9fafb; }
    .summary { display:flex; gap:16px; margin-bottom:12px; }
    .sum-box { flex:1; border:1px solid #e5e7eb; border-radius:4px; padding:8px 10px; }
    .sum-box .lbl { font-size:9px; color:#6b7280; }
    .sum-box .val { font-size:16px; font-weight:700; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN MONITORING ASRAMA</h2>
    <p>Asrama Mahasiswa Tapin</p>
    <p>Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
</div>

<div class="summary">
    <div class="sum-box"><div class="lbl">Total Kamar</div><div class="val">{{ $kamar->count() }}</div></div>
    <div class="sum-box"><div class="lbl">Kamar Kosong</div><div class="val">{{ $kamar->where('status','Kosong')->count() }}</div></div>
    <div class="sum-box"><div class="lbl">Kamar Terisi</div><div class="val">{{ $kamar->where('status','Terisi')->count() }}</div></div>
    <div class="sum-box"><div class="lbl">Kamar Penuh</div><div class="val">{{ $kamar->where('status','Penuh')->count() }}</div></div>
    <div class="sum-box"><div class="lbl">Total Penghuni</div><div class="val">{{ $penghuni->count() }}</div></div>
</div>

<div class="section-title">Status Kamar</div>
<table>
    <thead>
        <tr><th>No</th><th>Nomor Kamar</th><th>Kapasitas</th><th>Terisi</th><th>Status</th><th>Penghuni</th></tr>
    </thead>
    <tbody>
        @foreach($kamar as $i => $k)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $k->nomor_kamar }}</td>
            <td>{{ $k->kapasitas }}</td>
            <td>{{ $k->terisi }}</td>
            <td>{{ $k->status }}</td>
            <td>{{ $k->penghuni->pluck('nama')->join(', ') ?: '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="section-title">Daftar Penghuni Aktif</div>
<table>
    <thead>
        <tr><th>No</th><th>Nama</th><th>Kamar</th><th>Tgl Masuk</th></tr>
    </thead>
    <tbody>
        @foreach($penghuni as $i => $p)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
            <td>{{ $p->tanggal_masuk ? \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>