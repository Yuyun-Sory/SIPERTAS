@extends('layouts.app')

@section('title', 'Dashboard - SPK Siswa Terbaik')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan sistem dan informasi terkini')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --db-sans: 'Plus Jakarta Sans', sans-serif;
    --db-mono: 'JetBrains Mono', monospace;
}
* { font-family: var(--db-sans); box-sizing: border-box; }

.db-welcome {
    background: var(--primary, #2563eb);
    border-radius: 16px; padding: 22px 28px; margin-bottom: 22px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; color: #fff; position: relative; overflow: hidden; flex-wrap: wrap;
}
.db-welcome::before {
    content: ''; position: absolute; top: -40px; right: -40px;
    width: 200px; height: 200px; background: rgba(255,255,255,.06);
    border-radius: 50%; pointer-events: none;
}
.db-welcome::after {
    content: ''; position: absolute; bottom: -60px; right: 100px;
    width: 240px; height: 240px; background: rgba(255,255,255,.04);
    border-radius: 50%; pointer-events: none;
}
.db-welcome-left { position: relative; z-index: 1; }
.db-welcome-left h2 { font-size: 18px; font-weight: 800; margin: 0 0 4px; }
.db-welcome-left p  { font-size: 13px; opacity: .85; margin: 0; line-height: 1.5; }
.db-welcome-right { position: relative; z-index: 1; text-align: right; flex-shrink: 0; }
.db-welcome-right .wtime { font-size: 28px; font-weight: 800; line-height: 1; font-family: var(--db-mono); }
.db-welcome-right .wdate { font-size: 12px; opacity: .8; margin-top: 3px; }
.db-welcome-right .wperiode {
    margin-top: 8px; font-size: 11px;
    background: rgba(255,255,255,.18); border-radius: 20px;
    padding: 3px 12px; display: inline-block;
}

.db-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 20px; }
.db-stat {
    background: #fff; border: 1.5px solid #e5eaf4; border-radius: 14px;
    padding: 18px 16px; display: flex; align-items: center; gap: 14px;
    transition: box-shadow .2s, transform .2s; position: relative; overflow: hidden;
}
.db-stat::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; border-radius: 0 0 14px 14px; }
.db-stat:hover { box-shadow: 0 6px 24px rgba(0,0,0,.07); transform: translateY(-2px); }
.db-stat.s-blue::after   { background: linear-gradient(90deg,#2563eb,#6366f1); }
.db-stat.s-green::after  { background: linear-gradient(90deg,#059669,#10b981); }
.db-stat.s-orange::after { background: linear-gradient(90deg,#ea580c,#f97316); }
.db-stat.s-purple::after { background: linear-gradient(90deg,#7c3aed,#a855f7); }
.db-stat-icon { width: 48px; height: 48px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.db-stat.s-blue   .db-stat-icon { background: #eff6ff; }
.db-stat.s-green  .db-stat-icon { background: #ecfdf5; }
.db-stat.s-orange .db-stat-icon { background: #fff7ed; }
.db-stat.s-purple .db-stat-icon { background: #f5f3ff; }
.db-stat-val { font-size: 26px; font-weight: 800; color: #0f1623; line-height: 1; font-family: var(--db-mono); }
.db-stat-lbl { font-size: 11.5px; color: #7a8899; font-weight: 600; margin-top: 3px; }
.db-stat-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }

.db-row { display: grid; gap: 16px; margin-bottom: 16px; }
.db-row.cols-2   { grid-template-columns: 1fr 1fr; }
.db-row.cols-3-2 { grid-template-columns: 3fr 2fr; }
.db-row.cols-2-3 { grid-template-columns: 2fr 3fr; }
.db-row.cols-1   { grid-template-columns: 1fr; }

.db-card { background: #fff; border: 1.5px solid #e5eaf4; border-radius: 16px; overflow: hidden; }
.db-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1.5px solid #f0f4fb; gap: 10px; flex-wrap: wrap;
}
.db-card-head h3 { font-size: 13.5px; font-weight: 800; color: #0f1623; display: flex; align-items: center; gap: 8px; margin: 0; }
.db-card-head h3 .ch-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
.db-card-body { padding: 16px 18px; }
.db-card-body.tight { padding: 12px 18px; }

.badge { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
.badge-blue  { background: #eff6ff; color: #1d4ed8; }
.badge-green { background: #ecfdf5; color: #059669; }

.chart-wrap { position: relative; width: 100%; }

.status-list { display: flex; flex-direction: column; gap: 8px; }
.status-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border-radius: 10px; background: #f8fafc; gap: 8px; }
.status-left { display: flex; align-items: center; gap: 9px; }
.status-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.status-dot.ok    { background: #10b981; }
.status-dot.warn  { background: #f59e0b; }
.status-dot.empty { background: #cbd5e1; }
.status-lbl  { font-size: 12.5px; font-weight: 700; color: #0f1623; }
.status-desc { font-size: 11px; color: #94a3b8; }
.status-val  { font-size: 12px; font-weight: 700; white-space: nowrap; flex-shrink: 0; }
.status-val.ok    { color: #10b981; }
.status-val.warn  { color: #f59e0b; }
.status-val.empty { color: #94a3b8; }

.action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.action-btn { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; border: 1.5px solid #e5eaf4; background: #fff; text-decoration: none; transition: all .15s; }
.action-btn:hover { border-color: #2563eb; background: #eff6ff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,.1); }
.action-btn .ab-icon { width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
.ab-blue   { background: #eff6ff; } .ab-green  { background: #ecfdf5; }
.ab-yellow { background: #fffbeb; } .ab-purple { background: #f5f3ff; }
.action-btn span { font-size: 12px; font-weight: 700; color: #0f1623; line-height: 1.3; }

.flow-row { display: flex; align-items: flex-start; gap: 0; overflow-x: auto; padding-bottom: 6px; }
.flow-item { flex: 1; min-width: 100px; text-align: center; position: relative; padding: 0 4px; }
.flow-item:not(:last-child)::after { content: ''; position: absolute; top: 20px; right: -8px; width: 16px; height: 2px; background: #e2e8f0; }
.flow-circle { width: 40px; height: 40px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; margin-bottom: 8px; }
.fc-1 { background: #eff6ff; } .fc-2 { background: #fffbeb; }
.fc-3 { background: #f5f3ff; } .fc-4 { background: #ecfdf5; } .fc-5 { background: #fef2f2; }
.flow-item h5 { font-size: 11.5px; font-weight: 700; color: #0f1623; margin: 0 0 3px; }
.flow-item p  { font-size: 10px; color: #94a3b8; line-height: 1.5; margin: 0; }

.metode-box { border-radius: 12px; padding: 14px 16px; margin-bottom: 10px; }
.metode-box:last-child { margin-bottom: 0; }
.metode-box.ahp   { background: #eff6ff; border: 1.5px solid #bfdbfe; }
.metode-box.smart { background: #ecfdf5; border: 1.5px solid #a7f3d0; }
.metode-box h4 { font-size: 12.5px; font-weight: 800; margin: 0 0 5px; display: flex; align-items: center; gap: 7px; }
.metode-box.ahp   h4 { color: #1d4ed8; }
.metode-box.smart h4 { color: #065f46; }
.metode-box p { font-size: 11.5px; line-height: 1.6; color: #374151; margin: 0 0 8px; }
.metode-steps { display: flex; flex-wrap: wrap; gap: 5px; }
.ms-badge { font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.ms-ahp   { background: #bfdbfe; color: #1e40af; }
.ms-smart { background: #a7f3d0; color: #065f46; }

.rank-preview { display: flex; flex-direction: column; gap: 7px; }
.rank-row-item { display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 9px; background: #f8fafc; border: 1.5px solid #f0f4fb; transition: background .12s; }
.rank-row-item:hover { background: #f0f7ff; }
.rank-medal { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0; font-family: var(--db-mono); }
.medal-1 { background: #fef3c7; color: #d97706; }
.medal-2 { background: #f1f5f9; color: #64748b; }
.medal-3 { background: #fff7ed; color: #c2410c; }
.medal-n { background: #eff6ff; color: #2563eb; }
.rank-name  { flex: 1; font-size: 12.5px; font-weight: 700; color: #0f1623; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rank-kelas { font-size: 11px; color: #94a3b8; }
.rank-score { font-family: var(--db-mono); font-size: 12px; font-weight: 700; color: #2563eb; flex-shrink: 0; }
.rank-bar-outer { width: 70px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; flex-shrink: 0; }
.rank-bar-inner { height: 100%; border-radius: 3px; background: linear-gradient(90deg,#2563eb,#6366f1); }

/* Progress bar bobot */
.progress-item { margin-bottom: 12px; }
.progress-item:last-child { margin-bottom: 0; }
.progress-top { display: flex; justify-content: space-between; margin-bottom: 5px; }
.progress-lbl { font-size: 12px; font-weight: 700; color: #0f1623; }
.progress-pct { font-size: 12px; font-weight: 700; color: #2563eb; font-family: var(--db-mono); }
.progress-bar-outer { height: 8px; background: #f0f4fb; border-radius: 4px; overflow: hidden; }
.progress-bar-inner { height: 100%; border-radius: 4px; }

.chart-legend { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
.cl-item { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: #64748b; }
.cl-sq   { width: 10px; height: 10px; border-radius: 2px; flex-shrink: 0; }

.wk-banner { background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; font-size: 13px; color: #1d4ed8; }

@media (max-width: 1100px) {
    .db-stats { grid-template-columns: repeat(2,1fr); }
    .db-row.cols-3-2, .db-row.cols-2-3 { grid-template-columns: 1fr; }
}
@media (max-width: 768px) { .db-row.cols-2 { grid-template-columns: 1fr; } }
@media (max-width: 520px) {
    .db-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
    .db-welcome { flex-direction: column; }
    .action-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- WELCOME --}}
<div class="db-welcome">
    <div class="db-welcome-left">
        <h2>Selamat datang, {{ Auth::user()->name }}! 👋</h2>
        <p>
            @if(Auth::user()->role === 'admin')
                Login sebagai <strong>Administrator</strong> — semua fitur tersedia.
            @elseif(Auth::user()->role === 'wali_kelas')
                Login sebagai <strong>Wali Kelas</strong> — input nilai & lihat hasil SMART.
            @else
                Login sebagai <strong>Kepala Sekolah</strong> — lihat perankingan siswa.
            @endif
        </p>
    </div>
    <div class="db-welcome-right">
        <div class="wtime" id="dbJam">--:--</div>
        <div class="wdate" id="dbTgl">--</div>
        @if($periodeAktif)
            <div class="wperiode">{{ $periodeAktif->nama }}</div>
        @endif
    </div>
</div>

@if(Auth::user()->role === 'wali_kelas')
<div class="wk-banner">
    ℹ️ <div><strong>Panduan Wali Kelas:</strong> Input nilai di menu <em>Input Nilai</em>, lalu lihat ranking di menu <em>Perhitungan SMART</em>.</div>
</div>
@endif

{{-- ─── STAT CARDS ─── --}}
<div class="db-stats">
    <div class="db-stat s-blue">
        <div class="db-stat-icon">📋</div>
        <div>
            <div class="db-stat-val">{{ $jumlahKriteria }}</div>
            <div class="db-stat-lbl">Jumlah Kriteria</div>
            <div class="db-stat-sub">kriteria penilaian</div>
        </div>
    </div>
    <div class="db-stat s-green">
        <div class="db-stat-icon">👨‍🎓</div>
        <div>
            <div class="db-stat-val">{{ $jumlahSiswa }}</div>
            <div class="db-stat-lbl">Jumlah Siswa</div>
            <div class="db-stat-sub">siswa terdaftar</div>
        </div>
    </div>
    <div class="db-stat s-orange">
        <div class="db-stat-icon">📊</div>
        <div>
            <div class="db-stat-val" style="font-size:18px">
                {{ $konsistensiAHP === '-' ? '—' : 'CR '.$konsistensiAHP }}
            </div>
            <div class="db-stat-lbl">Konsistensi AHP</div>
            <div class="db-stat-sub">
                @if($konsistensiAHP === '-') belum dihitung
                @elseif((float)$konsistensiAHP < 0.1) konsisten ✓
                @else tidak konsisten ✗
                @endif
            </div>
        </div>
    </div>
    <div class="db-stat s-purple">
        <div class="db-stat-icon">🥇</div>
        <div>
            <div class="db-stat-val">{{ $jumlahTerbaik }}</div>
            <div class="db-stat-lbl">Kandidat SMART</div>
            <div class="db-stat-sub">hasil perankingan</div>
        </div>
    </div>
</div>

{{-- ─── BARIS 1: Bar Chart + Donut Chart ─── --}}
<div class="db-row cols-2">

    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#eff6ff">📊</span> Distribusi Siswa per Kelas</h3>
            <span class="badge badge-blue">Bar Chart</span>
        </div>
        <div class="db-card-body">
            <div class="chart-legend" id="legend-kelas"></div>
            <div class="chart-wrap" style="height:220px">
                <canvas id="chartKelas" role="img" aria-label="Jumlah siswa per kelas">Distribusi siswa per kelas.</canvas>
            </div>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#ecfdf5">✅</span> Status Input Nilai</h3>
            <span class="badge badge-green">Donut Chart</span>
        </div>
        <div class="db-card-body">
            <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap">
                <div class="chart-wrap" style="height:180px;width:180px;flex-shrink:0">
                    <canvas id="chartNilai" role="img" aria-label="Status input nilai siswa">Status input nilai siswa.</canvas>
                </div>
                <div style="flex:1;min-width:100px">
                    <div style="margin-bottom:14px">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;margin-bottom:4px">SUDAH DIINPUT</div>
                        <div style="font-size:26px;font-weight:800;color:#059669;font-family:var(--db-mono)">{{ $jumlahSudahInput }}</div>
                    </div>
                    <div style="margin-bottom:14px">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;margin-bottom:4px">BELUM DIINPUT</div>
                        <div style="font-size:26px;font-weight:800;color:#dc2626;font-family:var(--db-mono)">{{ $jumlahBelumInput }}</div>
                    </div>
                    @php
                        $total = $jumlahSudahInput + $jumlahBelumInput;
                        $pct   = $total > 0 ? round($jumlahSudahInput / $total * 100) : 0;
                    @endphp
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;margin-bottom:5px">PROGRES</div>
                    <div style="height:8px;background:#f0f4fb;border-radius:4px;overflow:hidden">
                        <div style="width:{{ $pct }}%;height:100%;background:linear-gradient(90deg,#059669,#10b981);border-radius:4px"></div>
                    </div>
                    <div style="font-size:11px;color:#059669;font-weight:700;margin-top:4px">{{ $pct }}% lengkap</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ─── BARIS 2: Ranking + Bobot AHP ─── --}}
<div class="db-row cols-3-2">

    {{-- Ranking Siswa --}}
    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#fef3c7">🏅</span> Peringkat Siswa Terbaik</h3>
            @if(count($topSiswa) > 0)
                <a href="{{ route('smart.index') }}" style="font-size:12px;color:#2563eb;font-weight:700;text-decoration:none">Lihat Semua →</a>
            @endif
        </div>
        <div class="db-card-body tight">
            @if(count($topSiswa) > 0)
                @php $maxScore = collect($topSiswa)->max('skor_akhir') ?: 1; @endphp
                <div class="rank-preview">
                    @foreach($topSiswa as $i => $siswa)
                    <div class="rank-row-item">
                        <div class="rank-medal {{ $i===0?'medal-1':($i===1?'medal-2':($i===2?'medal-3':'medal-n')) }}">
                            {{ $i + 1 }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <div class="rank-name">{{ $siswa['siswa_nama'] }}</div>
                            <div class="rank-kelas">Kelas {{ $siswa['kelas'] }}</div>
                        </div>
                        <div class="rank-bar-outer">
                            <div class="rank-bar-inner" style="width:{{ $maxScore > 0 ? round($siswa['skor_akhir'] / $maxScore * 100) : 0 }}%"></div>
                        </div>
                        <div class="rank-score">{{ number_format($siswa['skor_akhir'], 2) }}</div>
                    </div>
                    @endforeach
                </div>
            @else
            <div style="text-align:center;padding:32px 16px;color:#94a3b8">
                <div style="font-size:36px;margin-bottom:10px;opacity:.4">🏅</div>
                <div style="font-size:13px;font-weight:700;color:#64748b;margin-bottom:4px">Belum Ada Hasil Perankingan</div>
                <div style="font-size:12px">Hitung SMART terlebih dahulu</div>
                @if(Auth::user()->role !== 'kepala_sekolah')
                <a href="{{ route('smart.index') }}" style="display:inline-block;margin-top:12px;padding:7px 16px;background:#2563eb;color:#fff;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none">Hitung Sekarang →</a>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- Bobot Kriteria AHP --}}
    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#f5f3ff">⚖️</span> Bobot Kriteria AHP</h3>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('ahp.index') }}" style="font-size:12px;color:#2563eb;font-weight:700;text-decoration:none">Edit →</a>
            @endif
        </div>
        <div class="db-card-body">
            @php
                $barColors = ['#2563eb','#7c3aed','#059669','#ea580c','#dc2626','#0891b2','#d97706'];
            @endphp

            @if($bobotKriteria->count() > 0)
                {{-- $bobotKriteria adalah collection of plain object {kode, nama, bobot}
                     yang sudah di-map di DashboardController --}}
                @php $maxBobot = $bobotKriteria->max('bobot') ?: 1; @endphp
                @foreach($bobotKriteria as $ki => $kb)
                <div class="progress-item">
                    <div class="progress-top">
                        <span class="progress-lbl">
                            <span style="font-family:var(--db-mono);font-size:10.5px;color:#7c3aed;font-weight:700;margin-right:4px">
                                {{ $kb->kode }}
                            </span>
                            {{ Str::limit($kb->nama, 22) }}
                        </span>
                        <span class="progress-pct">{{ number_format($kb->bobot * 100, 1) }}%</span>
                    </div>
                    <div class="progress-bar-outer">
                        <div class="progress-bar-inner"
                             style="width:{{ $maxBobot > 0 ? round($kb->bobot / $maxBobot * 100) : 0 }}%;
                                    background:{{ $barColors[$ki % count($barColors)] }}">
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div style="text-align:center;padding:24px 16px;color:#94a3b8">
                <div style="font-size:32px;margin-bottom:8px;opacity:.4">⚖️</div>
                <div style="font-size:12.5px;font-weight:700;color:#64748b;margin-bottom:4px">Bobot Belum Dihitung</div>
                <div style="font-size:11.5px">Isi matriks AHP untuk mendapatkan bobot</div>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('ahp.index') }}" style="display:inline-block;margin-top:10px;padding:7px 16px;background:#7c3aed;color:#fff;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none">Hitung AHP →</a>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>

{{-- ─── BARIS 3: Alur Sistem ─── --}}
<div class="db-row cols-1">
    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#f0fdf4">🔄</span> Alur Penggunaan Sistem</h3>
        </div>
        <div class="db-card-body">
            <div class="flow-row">
                <div class="flow-item">
                    <div class="flow-circle fc-1">📅</div>
                    <h5>Buat Periode</h5>
                    <p>Tentukan periode penilaian</p>
                </div>
                <div class="flow-item">
                    <div class="flow-circle fc-2">📋</div>
                    <h5>Tambah Kriteria</h5>
                    <p>Definisikan kriteria & sub-kriteria</p>
                </div>
                <div class="flow-item">
                    <div class="flow-circle fc-3">👤</div>
                    <h5>Input Siswa</h5>
                    <p>Daftarkan siswa & nilai</p>
                </div>
                <div class="flow-item">
                    <div class="flow-circle fc-1">⚖️</div>
                    <h5>Hitung AHP</h5>
                    <p>Isi matriks & simpan bobot</p>
                </div>
                <div class="flow-item">
                    <div class="flow-circle fc-4">🏆</div>
                    <h5>Hitung SMART</h5>
                    <p>Hitung utilitas & ranking</p>
                </div>
                <div class="flow-item">
                    <div class="flow-circle fc-5">📄</div>
                    <h5>Lihat Hasil</h5>
                    <p>Ranking & riwayat tersimpan</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── BARIS 4: Status + Aksi + Metode ─── --}}
<div class="db-row cols-2-3">

    {{-- Status Sistem --}}
    <div class="db-card">
        <div class="db-card-head">
            <h3><span class="ch-icon" style="background:#f0fdf4">✅</span> Status Sistem</h3>
        </div>
        <div class="db-card-body tight">
            <div class="status-list">
                <div class="status-row">
                    <div class="status-left">
                        <div class="status-dot {{ $jumlahKriteria > 0 ? 'ok' : 'empty' }}"></div>
                        <div><div class="status-lbl">Data Kriteria</div><div class="status-desc">Kriteria penilaian</div></div>
                    </div>
                    <div class="status-val {{ $jumlahKriteria > 0 ? 'ok' : 'empty' }}">{{ $jumlahKriteria > 0 ? $jumlahKriteria.' kriteria' : 'Belum ada' }}</div>
                </div>
                <div class="status-row">
                    <div class="status-left">
                        <div class="status-dot {{ $jumlahSiswa > 0 ? 'ok' : 'empty' }}"></div>
                        <div><div class="status-lbl">Data Siswa</div><div class="status-desc">Total terdaftar</div></div>
                    </div>
                    <div class="status-val {{ $jumlahSiswa > 0 ? 'ok' : 'empty' }}">{{ $jumlahSiswa > 0 ? $jumlahSiswa.' siswa' : 'Belum ada' }}</div>
                </div>
                <div class="status-row">
                    <div class="status-left">
                        <div class="status-dot {{ $konsistensiAHP === '-' ? 'empty' : ((float)$konsistensiAHP < 0.1 ? 'ok' : 'warn') }}"></div>
                        <div><div class="status-lbl">Konsistensi AHP</div><div class="status-desc">CR harus &lt; 0.10</div></div>
                    </div>
                    <div class="status-val {{ $konsistensiAHP === '-' ? 'empty' : ((float)$konsistensiAHP < 0.1 ? 'ok' : 'warn') }}">
                        @if($konsistensiAHP === '-') Belum dihitung
                        @elseif((float)$konsistensiAHP < 0.1) Konsisten ✓
                        @else Tidak Konsisten ✗
                        @endif
                    </div>
                </div>
                <div class="status-row">
                    <div class="status-left">
                        <div class="status-dot {{ $jumlahTerbaik > 0 ? 'ok' : 'empty' }}"></div>
                        <div><div class="status-lbl">Hasil SMART</div><div class="status-desc">Perankingan siswa</div></div>
                    </div>
                    <div class="status-val {{ $jumlahTerbaik > 0 ? 'ok' : 'empty' }}">{{ $jumlahTerbaik > 0 ? $jumlahTerbaik.' data' : 'Belum ada' }}</div>
                </div>
                <div class="status-row">
                    <div class="status-left">
                        <div class="status-dot {{ $periodeAktif ? 'ok' : 'warn' }}"></div>
                        <div><div class="status-lbl">Periode Aktif</div><div class="status-desc">Periode berjalan</div></div>
                    </div>
                    <div class="status-val {{ $periodeAktif ? 'ok' : 'warn' }}">{{ $periodeAktif ? Str::limit($periodeAktif->nama, 18) : 'Belum diset' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px">

        {{-- Aksi Cepat --}}
        <div class="db-card">
            <div class="db-card-head">
                <h3><span class="ch-icon" style="background:#fff7ed">⚡</span> Aksi Cepat</h3>
            </div>
            <div class="db-card-body tight">
                <div class="action-grid">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('siswa.create') }}"   class="action-btn"><div class="ab-icon ab-green">➕</div><span>Tambah Siswa</span></a>
                        <a href="{{ route('kriteria.index') }}" class="action-btn"><div class="ab-icon ab-blue">📋</div><span>Kelola Kriteria</span></a>
                        <a href="{{ route('ahp.index') }}"      class="action-btn"><div class="ab-icon ab-purple">⚖️</div><span>Input Matriks AHP</span></a>
                        <a href="{{ route('smart.index') }}"    class="action-btn"><div class="ab-icon ab-yellow">🏆</div><span>Lihat Ranking</span></a>
                        <a href="{{ route('nilai.index') }}"    class="action-btn"><div class="ab-icon ab-green">✏️</div><span>Input Nilai</span></a>
                        <a href="{{ route('riwayat.index') }}"  class="action-btn"><div class="ab-icon ab-blue">🕓</div><span>Riwayat</span></a>
                    @elseif(Auth::user()->role === 'wali_kelas')
                        <a href="{{ route('nilai.index') }}"   class="action-btn"><div class="ab-icon ab-green">✏️</div><span>Input Nilai Siswa</span></a>
                        <a href="{{ route('smart.index') }}"   class="action-btn"><div class="ab-icon ab-purple">🏆</div><span>Perhitungan SMART</span></a>
                        <a href="{{ route('riwayat.index') }}" class="action-btn"><div class="ab-icon ab-yellow">🕓</div><span>Riwayat</span></a>
                    @else
                        <a href="{{ route('smart.index') }}"   class="action-btn"><div class="ab-icon ab-purple">🏆</div><span>Lihat Ranking</span></a>
                        <a href="{{ route('riwayat.index') }}" class="action-btn"><div class="ab-icon ab-yellow">🕓</div><span>Riwayat</span></a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tentang Metode --}}
        <div class="db-card">
            <div class="db-card-head">
                <h3><span class="ch-icon" style="background:#eff6ff">📖</span> Tentang Metode</h3>
            </div>
            <div class="db-card-body">
                <div class="metode-box ahp">
                    <h4>⚖️ Metode AHP</h4>
                    <p>Menentukan bobot kriteria lewat matriks perbandingan berpasangan skala Saaty (1–9). Valid jika CR &lt; 0,10.</p>
                    <div class="metode-steps">
                        <span class="ms-badge ms-ahp">Matriks</span>
                        <span class="ms-badge ms-ahp">Normalisasi</span>
                        <span class="ms-badge ms-ahp">Bobot</span>
                        <span class="ms-badge ms-ahp">Uji CR</span>
                    </div>
                </div>
                <div class="metode-box smart">
                    <h4>🏆 Metode SMART</h4>
                    <p>Mengubah nilai mentah menjadi utilitas (0–100), dikalikan bobot AHP, dijumlah sebagai skor akhir ranking.</p>
                    <div class="metode-steps">
                        <span class="ms-badge ms-smart">Min & Max</span>
                        <span class="ms-badge ms-smart">Utilitas</span>
                        <span class="ms-badge ms-smart">× Bobot</span>
                        <span class="ms-badge ms-smart">Ranking</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
/* ── JAM & TANGGAL ── */
(function tick() {
    const now  = new Date();
    const jam  = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const bln  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const e1   = document.getElementById('dbJam');
    const e2   = document.getElementById('dbTgl');
    if (e1) e1.textContent = jam;
    if (e2) e2.textContent = hari[now.getDay()] + ', ' + now.getDate() + ' ' + bln[now.getMonth()] + ' ' + now.getFullYear();
    setTimeout(tick, 1000);
})();

/* ── DATA DARI CONTROLLER ── */
const dataKelas  = @json($dataKelas ?? []);
const sudahInput = {{ (int)($jumlahSudahInput ?? 0) }};
const belumInput = {{ (int)($jumlahBelumInput ?? 0) }};

const COLORS = ['#2563eb','#7c3aed','#059669','#ea580c','#dc2626','#0891b2','#d97706','#0f766e','#be185d'];

document.addEventListener('DOMContentLoaded', function () {

    /* ── BAR CHART: SISWA PER KELAS ── */
    const cvKelas = document.getElementById('chartKelas');
    if (cvKelas) {
        const labels = Object.keys(dataKelas);
        const values = Object.values(dataKelas);

        if (labels.length === 0) {
            const ctx = cvKelas.getContext('2d');
            ctx.fillStyle = '#94a3b8';
            ctx.font = '13px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('Belum ada data siswa', cvKelas.parentElement.offsetWidth / 2, 110);
        } else {
            /* Legend */
            const legEl = document.getElementById('legend-kelas');
            if (legEl) {
                legEl.innerHTML = labels.map((l, i) =>
                    `<span class="cl-item"><span class="cl-sq" style="background:${COLORS[i % COLORS.length]}"></span>${l}: <strong>${values[i]}</strong></span>`
                ).join('');
            }
            new Chart(cvKelas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: values,
                        backgroundColor: labels.map((_, i) => COLORS[i % COLORS.length] + 'cc'),
                        borderColor:     labels.map((_, i) => COLORS[i % COLORS.length]),
                        borderWidth: 1.5,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => '  ' + ctx.parsed.y + ' siswa' } }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f0f4fb' } },
                        x: { ticks: { font: { size: 11 }, autoSkip: false, maxRotation: 30 }, grid: { display: false } }
                    }
                }
            });
        }
    }

    /* ── DONUT CHART: STATUS NILAI ── */
    const cvNilai = document.getElementById('chartNilai');
    if (cvNilai) {
        if (sudahInput + belumInput === 0) {
            const ctx = cvNilai.getContext('2d');
            ctx.fillStyle = '#f0f4fb';
            ctx.beginPath();
            ctx.arc(90, 90, 55, 0, Math.PI * 2);
            ctx.fill();
            ctx.fillStyle = '#94a3b8';
            ctx.font = '11px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('Belum ada data', 90, 90);
        } else {
            new Chart(cvNilai, {
                type: 'doughnut',
                data: {
                    labels: ['Sudah Diinput', 'Belum Diinput'],
                    datasets: [{
                        data: [sudahInput, belumInput],
                        backgroundColor: ['#059669cc', '#dc2626cc'],
                        borderColor:     ['#059669',   '#dc2626'],
                        borderWidth: 2,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => '  ' + ctx.parsed + ' siswa' } }
                    }
                }
            });
        }
    }

}); /* end DOMContentLoaded */
</script>
@endpush