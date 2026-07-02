<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 11px; color: #1f2937; }
    .header { text-align:center; margin-bottom:16px; border-bottom:2px solid #dc2626; padding-bottom:8px; }
    .header h2 { font-size:14px; margin:0; color:#dc2626; }
    .header p  { margin:2px 0; font-size:10px; color:#6b7280; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th { background:#dc2626; color:#fff; padding:6px 8px; text-align:left; font-size:10px; }
    td { padding:5px 8px; border-bottom:1px solid #e5e7eb; }
    tr:nth-child(even) td { background:#fff5f5; }
    .footer { margin-top:20px; text-align:right; font-size:9px; color:#9ca3af; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN TUNGGAKAN PEMBAYARAN</h2>
    <p>Asrama Mahasiswa Tapin</p>
    <p>Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
</div>
<table>
    <thead>
        <tr>
            <th>No</th><th>Penghuni</th><th>Kamar</th>
            <th>Bulan</th><th>Jumlah Tagihan</th><th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $p)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $p->penghuni->nama ?? '-' }}</td>
            <td>{{ $p->penghuni->kamar->nomor_kamar ?? '-' }}</td>
            <td>{{ $p->bulan_bayar }}</td>
            <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
            <td>{{ $p->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="footer">
    Total Tunggakan: {{ $data->count() }} |
    Total Nominal: Rp {{ number_format($data->sum('jumlah'),0,',','.') }}
</div>
</body>
</html>