<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 10px; color: #1f2937; }
    .header { text-align:center; margin-bottom:16px; border-bottom:2px solid #1e3a5f; padding-bottom:8px; }
    .header h2 { font-size:14px; margin:0; color:#1e3a5f; }
    .header p  { margin:2px 0; font-size:10px; color:#6b7280; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th { background:#1e3a5f; color:#fff; padding:6px 8px; text-align:left; font-size:10px; }
    td { padding:5px 8px; border-bottom:1px solid #e5e7eb; }
    tr:nth-child(even) td { background:#f9fafb; }
    .footer { margin-top:20px; font-size:9px; color:#9ca3af; display:flex; justify-content:space-between; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN DATA PEMBAYARAN</h2>
    <p>Asrama Mahasiswa Tapin</p>
    <p>Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
</div>
<table>
    <thead>
        <tr>
            <th>No</th><th>Penghuni</th><th>Bulan</th>
            <th>Jumlah</th><th>Tgl Bayar</th><th>Status</th><th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($data as $i => $p)
        @php $total += $p->jumlah; @endphp
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $p->penghuni->nama ?? '-' }}</td>
            <td>{{ $p->bulan_bayar }}</td>
            <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
            <td>{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
            <td>{{ $p->status }}</td>
            <td>{{ $p->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="footer">
    <span>Total: {{ $data->count() }} transaksi</span>
    <span>Total Pemasukan Lunas: Rp {{ number_format($data->where('status','Lunas')->sum('jumlah'),0,',','.') }}</span>
</div>
</body>
</html>