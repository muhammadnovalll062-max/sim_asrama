@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 1.2rem 1.4rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 22px; height: 22px; stroke-width: 2; }
    .stat-icon.blue   { background: #e0e7ff; } .stat-icon.blue svg   { stroke: #3b5bdb; }
    .stat-icon.green  { background: #dcfce7; } .stat-icon.green svg  { stroke: #16a34a; }
    .stat-icon.amber  { background: #fef3c7; } .stat-icon.amber svg  { stroke: #d97706; }
    .stat-icon.red    { background: #fee2e2; } .stat-icon.red svg    { stroke: #dc2626; }
    .stat-text .label { font-size: .78rem; color: #6b7280; }
    .stat-text .value { font-size: 1.5rem; font-weight: 700; color: #1f2937; }

    .grid-2 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.2rem;
    }
    .panel {
        background: #fff;
        border-radius: 10px;
        padding: 1.3rem 1.4rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .panel h3 { font-size: .95rem; margin-bottom: 1rem; color: #1f2937; }
    .activity-item {
        display: flex; align-items: center; gap: .7rem;
        padding: .6rem 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: .85rem;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item .avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: #3b5bdb; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; font-weight: 600; flex-shrink: 0;
    }
    .activity-item .meta { flex: 1; }
    .activity-item .meta strong { display: block; }
    .activity-item .meta span { font-size: .75rem; color: #9ca3af; }
</style>
@endpush

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a5 5 0 015-5h4a5 5 0 015 5v2"/></svg>
            </div>
            <div class="stat-text">
                <div class="label">Total Penghuni</div>
                <div class="value">{{ $totalPenghuni }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" fill="none"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21V12h6v9"/></svg>
            </div>
            <div class="stat-text">
                <div class="label">Kamar Kosong</div>
                <div class="value">{{ $kamarKosong }} <span style="font-size:.85rem;color:#9ca3af">/ {{ $totalKamar }}</span></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M2 10h20"/></svg>
            </div>
            <div class="stat-text">
                <div class="label">Pemasukan Bulan Ini</div>
                <div class="value" style="font-size:1.25rem">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            </div>
            <div class="stat-text">
                <div class="label">Belum Lunas</div>
                <div class="value">{{ $totalBelum }}</div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <h3>Pemasukan Pembayaran Per Bulan</h3>
            <canvas id="chartPemasukan" height="110"></canvas>
        </div>
        <div class="panel">
            <h3>Status Hunian Kamar</h3>
            <canvas id="chartKamar" height="160"></canvas>
        </div>
    </div>

    <div class="panel" style="margin-top:1.2rem">
        <h3>Penghuni Terbaru</h3>
        @forelse($aktivitas as $p)
            <div class="activity-item">
                <div class="avatar">{{ strtoupper(substr($p->nama, 0, 2)) }}</div>
                <div class="meta">
                    <strong>{{ $p->nama }}</strong>
                    <span>Check-in kamar {{ $p->kamar->nomor_kamar ?? '-' }}</span>
                </div>
                <span style="color:#9ca3af;font-size:.78rem">{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') }}</span>
            </div>
        @empty
            <p style="color:#9ca3af;font-size:.85rem">Belum ada data penghuni.</p>
        @endforelse
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('chartPemasukan'), {
        type: 'bar',
        data: {
            labels: @json($grafikLabel),
            datasets: [{
                label: 'Pemasukan',
                data: @json($grafikData),
                backgroundColor: '#3b5bdb',
                borderRadius: 4,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartKamar'), {
        type: 'doughnut',
        data: {
            labels: ['Kosong', 'Terisi', 'Penuh'],
            datasets: [{
                data: [{{ $kamarKosong }}, {{ $kamarTerisi }}, {{ $kamarPenuh }}],
                backgroundColor: ['#16a34a', '#d97706', '#dc2626'],
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush