<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 11px; color: #1f2937; }
    .header { text-align:center; margin-bottom:16px; border-bottom:2px solid #1e3a5f; padding-bottom:8px; }
    .header h2 { font-size:14px; margin:0; color:#1e3a5f; }
    .header p  { margin:2px 0; font-size:10px; color:#6b7280; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th { background:#1e3a5f; color:#fff; padding:6px 8px; text-align:left; font-size:10px; }
    td { padding:5px 8px; border-bottom:1px solid #e5e7eb; }
    tr:nth-child(even) td { background:#f9fafb; }
    .footer { margin-top:20px; text-align:right; font-size:9px; color:#9ca3af; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN DATA KAMAR</h2>
    <p>Asrama Mahasiswa Tapin</p>
    <p>Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
</div>
<table>
    <thead>
        <tr>
            <th>No</th><th>Nomor Kamar</th><th>Kapasitas</th>
            <th>Terisi</th><th>Status</th><th>Penghuni</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $k)
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
<div class="footer">Total: {{ $data->count() }} kamar</div>
</body>
</html>