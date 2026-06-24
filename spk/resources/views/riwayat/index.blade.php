@extends('layouts.app')

@section('title', 'Riwayat – SPK Siswa Terbaik')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0a0f1e; --ink-2:#2d3748; --ink-3:#64748b;
    --surface:#fff; --surface-2:#f8fafc; --surface-3:#f1f5f9;
    --border:#e2e8f0; --border-2:#cbd5e1;
    --accent:#2563eb; --accent-dark:#1d4ed8; --accent-lt:#eff6ff;
    --gold:#f59e0b; --gold-bg:#fffbeb; --gold-bd:#fde68a;
    --green:#059669; --green-bg:#ecfdf5; --green-bd:#6ee7b7;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --purple:#7c3aed; --purple-bg:#f5f3ff; --purple-bd:#ddd6fe;
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 3px rgba(10,15,30,.06);
    --sh-sm:0 4px 16px rgba(10,15,30,.08);
    --sh-xl:0 24px 64px rgba(10,15,30,.14);
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

/* ── PAGE HEADER ─────────────────────────────── */
.ph { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.ph-title { font-size:23px; font-weight:900; color:var(--ink); display:flex; align-items:center; gap:12px; margin-bottom:5px; }
.t-icon { width:40px; height:40px; background:linear-gradient(135deg,#7c3aed,#2563eb); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; box-shadow:0 6px 20px rgba(124,58,237,.3); }
.ph-sub { font-size:13px; color:var(--ink-3); padding-left:52px; line-height:1.6; }
.divider { border:none; border-top:1.5px solid var(--border); margin:0 0 24px; }

/* ── STATS ───────────────────────────────────── */
.stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:14px; margin-bottom:24px; }
.stat-card { background:var(--surface); border:1.5px solid var(--border); border-radius:var(--r-lg); padding:18px 16px; display:flex; align-items:center; gap:12px; box-shadow:var(--sh-xs); position:relative; overflow:hidden; transition:transform .2s,box-shadow .2s; }
.stat-card:hover { transform:translateY(-2px); box-shadow:var(--sh-sm); }
.stat-card::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; border-radius:0 0 var(--r-lg) var(--r-lg); }
.sc-all::after    { background:linear-gradient(90deg,#7c3aed,#2563eb); }
.sc-smart::after  { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
.sc-ahp::after    { background:linear-gradient(90deg,#2563eb,#6366f1); }
.sc-nilai::after  { background:linear-gradient(90deg,#059669,#10b981); }
.stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
.stat-val { font-size:26px; font-weight:900; color:var(--ink); line-height:1; font-family:var(--mono); }
.stat-lbl { font-size:11.5px; color:var(--ink-3); font-weight:600; margin-top:3px; }

/* ── FILTER BAR ──────────────────────────────── */
.filter-bar { display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
.filter-select { padding:9px 12px; border:1.5px solid var(--border); border-radius:var(--r-sm); font-family:var(--sans); font-size:13px; color:var(--ink); background:var(--surface); outline:none; cursor:pointer; transition:border-color .15s; }
.filter-select:focus { border-color:var(--accent); }

/* ── DATE PICKER DENGAN DOT ──────────────────── */
.date-picker-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}
.filter-input-date {
    padding: 9px 12px 9px 34px;
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    font-family: var(--sans);
    font-size: 13px;
    color: var(--ink);
    background: var(--surface);
    outline: none;
    cursor: pointer;
    transition: border-color .15s;
    min-width: 160px;
}
.filter-input-date:focus { border-color: var(--accent); }
.date-calendar-icon {
    position: absolute;
    left: 10px;
    font-size: 14px;
    pointer-events: none;
    z-index: 1;
}
/* Tanggal yang punya aktivitas tampil khusus di popover kalender */
/* Catatan: native date picker tidak mendukung kustomisasi per-tanggal.
   Kita tampilkan petunjuk teks di bawah input */
.date-hint {
    font-size: 11px;
    color: var(--ink-3);
    margin-left: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
    max-width: 320px;
}
.date-dot {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}
.dd-smart  { background: #f59e0b; }
.dd-ahp    { background: #2563eb; }
.dd-nilai  { background: #059669; }
.dd-mix    { background: linear-gradient(135deg,#f59e0b 33%,#2563eb 33% 66%,#059669 66%); }

.btn-filter { display:inline-flex; align-items:center; gap:6px; padding:9px 16px; background:var(--accent); color:#fff; border:none; border-radius:var(--r-sm); font-family:var(--sans); font-size:13px; font-weight:700; cursor:pointer; transition:background .15s; }
.btn-filter:hover { background:var(--accent-dark); }
.btn-reset { display:inline-flex; align-items:center; gap:6px; padding:9px 14px; border:1.5px solid var(--border); border-radius:var(--r-sm); font-family:var(--sans); font-size:13px; font-weight:600; color:var(--ink-3); background:var(--surface); text-decoration:none; transition:all .15s; }
.btn-reset:hover { border-color:var(--accent); color:var(--accent); }

/* ── TANGGAL AKTIF LEGEND ────────────────────── */
.tanggal-legend {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-bottom: 16px;
    padding: 10px 14px;
    background: var(--surface-2);
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--ink-3);
}
.tanggal-legend-title { font-weight:700; color:var(--ink-2); margin-right:4px; }
.tanggal-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    border: 1.5px solid transparent;
    cursor: default;
    white-space: nowrap;
}
.tc-smart { background: var(--gold-bg); color:#92400e; border-color: var(--gold-bd); }
.tc-ahp   { background: var(--accent-lt); color: var(--accent); border-color: #bfdbfe; }
.tc-nilai { background: var(--green-bg); color: var(--green); border-color: var(--green-bd); }
.tc-mix   { background: var(--purple-bg); color: var(--purple); border-color: var(--purple-bd); }

/* ── RIWAYAT LIST ────────────────────────────── */
.riwayat-list { display:flex; flex-direction:column; gap:10px; }

.riwayat-card { background:var(--surface); border:1.5px solid var(--border); border-radius:var(--r-xl); overflow:hidden; box-shadow:var(--sh-xs); transition:transform .2s,box-shadow .2s; }
.riwayat-card:hover { transform:translateY(-2px); box-shadow:var(--sh-sm); }

.rc-inner { display:flex; align-items:stretch; }

.rc-strip { width:5px; flex-shrink:0; }
.strip-smart { background:linear-gradient(180deg,#f59e0b,#fbbf24); }
.strip-ahp   { background:linear-gradient(180deg,#2563eb,#6366f1); }
.strip-nilai { background:linear-gradient(180deg,#059669,#10b981); }

.rc-body { flex:1; padding:16px 20px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; }

.rc-icon { width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:21px; flex-shrink:0; }
.icon-smart { background:var(--gold-bg); }
.icon-ahp   { background:var(--accent-lt); }
.icon-nilai { background:var(--green-bg); }

.rc-info { flex:1; min-width:0; }
.rc-judul { font-size:14px; font-weight:800; color:var(--ink); margin-bottom:5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.rc-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.rc-meta-item { display:flex; align-items:center; gap:4px; font-size:12px; color:var(--ink-3); }

.jenis-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.jb-smart { background:var(--gold-bg); color:#92400e; border:1.5px solid var(--gold-bd); }
.jb-ahp   { background:var(--accent-lt); color:var(--accent); border:1.5px solid #bfdbfe; }
.jb-nilai { background:var(--green-bg); color:var(--green); border:1.5px solid var(--green-bd); }

.rc-highlight { display:flex; flex-direction:column; align-items:flex-end; gap:5px; flex-shrink:0; padding-right:4px; }
.rc-skor { font-family:var(--mono); font-size:13px; font-weight:700; color:var(--ink-2); }
.rc-winner { font-size:12px; font-weight:700; color:var(--gold); }

.rc-actions { display:flex; align-items:center; gap:6px; padding:0 14px 0 0; flex-shrink:0; }
.btn-act { width:34px; height:34px; border-radius:var(--r-sm); display:inline-flex; align-items:center; justify-content:center; font-size:14px; border:1.5px solid transparent; cursor:pointer; transition:all .15s; text-decoration:none; background:transparent; font-family:var(--sans); }
.btn-act.view { background:var(--accent-lt); color:var(--accent); border-color:#bfdbfe; }
.btn-act.view:hover { background:var(--accent); color:#fff; }
.btn-act.del  { background:var(--red-bg); color:var(--red); border-color:var(--red-bd); }
.btn-act.del:hover  { background:var(--red); color:#fff; }

/* ── NOMOR URUT ──────────────────────────────── */
.rc-nomor {
    font-family: var(--mono);
    font-size: 11px;
    font-weight: 700;
    color: var(--ink-3);
    background: var(--surface-3);
    border-radius: 6px;
    padding: 2px 7px;
    flex-shrink: 0;
    align-self: center;
    margin-right: 2px;
}

/* ── DATE GROUP ──────────────────────────────── */
.date-group { margin-bottom:18px; }
.date-label-wrap { display:flex; align-items:center; gap:8px; margin-bottom:10px; flex-wrap:wrap; }
.date-label { display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:var(--ink-3); padding:4px 12px; background:var(--surface-3); border-radius:20px; }
.date-count { font-size:11px; font-weight:600; color:var(--ink-3); background:var(--border); border-radius:10px; padding:1px 7px; margin-left:4px; }

/* Dot indikator aktivitas per tanggal */
.date-activity-dots { display:inline-flex; align-items:center; gap:4px; }
.activity-dot {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}
.ad-smart { background:var(--gold-bg); color:#92400e; border:1px solid var(--gold-bd); }
.ad-ahp   { background:var(--accent-lt); color:var(--accent); border:1px solid #bfdbfe; }
.ad-nilai { background:var(--green-bg); color:var(--green); border:1px solid var(--green-bd); }

/* ── EMPTY STATE ─────────────────────────────── */
.empty-box { text-align:center; padding:72px 20px; }
.empty-icon { font-size:52px; margin-bottom:14px; opacity:.3; }
.empty-title { font-size:16px; font-weight:800; color:var(--ink); margin-bottom:6px; }
.empty-sub { font-size:13px; color:var(--ink-3); line-height:1.7; }

/* ── PAGINATION ──────────────────────────────── */
.pagination-wrap { margin-top:24px; display:flex; justify-content:center; }
.pagination-wrap nav { display:flex; align-items:center; gap:4px; }

/* Override default Laravel pagination agar tombol panah kecil */
.pagination-wrap .pagination {
    display:flex;
    gap:4px;
    list-style:none;
    align-items:center;
    margin:0;
    padding:0;
}
.pagination-wrap .page-item .page-link {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:30px;
    height:30px;
    padding:0 8px;
    border:1.5px solid var(--border);
    border-radius:var(--r-sm);
    font-family:var(--sans);
    font-size:12px;
    font-weight:600;
    color:var(--ink-3);
    text-decoration:none;
    background:var(--surface);
    transition:all .15s;
    line-height:1;
}
/* Tombol prev/next (svg di dalamnya) — kecilkan */
.pagination-wrap .page-item:first-child .page-link,
.pagination-wrap .page-item:last-child .page-link {
    min-width:28px;
    height:28px;
    padding:0 7px;
}
.pagination-wrap .page-item:first-child .page-link svg,
.pagination-wrap .page-item:last-child .page-link svg {
    width:12px !important;
    height:12px !important;
}
.pagination-wrap .page-item.active .page-link {
    background:var(--accent);
    border-color:var(--accent);
    color:#fff;
}
.pagination-wrap .page-item .page-link:hover {
    border-color:var(--accent);
    color:var(--accent);
}
.pagination-wrap .page-item.active .page-link:hover {
    color:#fff;
}
.pagination-wrap .page-item.disabled .page-link {
    opacity:.4;
    cursor:not-allowed;
    pointer-events:none;
}

/* ── MODAL HAPUS ─────────────────────────────── */
.modal-overlay { position:fixed; inset:0; background:rgba(10,15,30,.5); backdrop-filter:blur(4px); z-index:1000; display:flex; align-items:center; justify-content:center; padding:16px; opacity:0; pointer-events:none; transition:opacity .2s; }
.modal-overlay.open { opacity:1; pointer-events:all; }
.modal-box { background:var(--surface); border-radius:var(--r-xl); padding:28px; max-width:400px; width:100%; box-shadow:var(--sh-xl); border:1.5px solid var(--border); transform:translateY(12px) scale(.97); transition:transform .2s cubic-bezier(.34,1.56,.64,1); position:relative; text-align:center; }
.modal-overlay.open .modal-box { transform:none; }
.modal-box::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--red),#f87171); border-radius:var(--r-xl) var(--r-xl) 0 0; }
.modal-actions { display:flex; gap:10px; margin-top:20px; }
.btn-cancel { flex:1; padding:10px; border:1.5px solid var(--border-2); border-radius:var(--r-sm); background:var(--surface); font-family:var(--sans); font-size:13px; font-weight:600; color:var(--ink-3); cursor:pointer; transition:all .15s; }
.btn-cancel:hover { border-color:var(--ink-3); color:var(--ink); }
.btn-confirm { flex:1; padding:10px; border:none; border-radius:var(--r-sm); background:var(--red); font-family:var(--sans); font-size:13px; font-weight:700; color:#fff; cursor:pointer; transition:background .15s; }
.btn-confirm:hover { background:#b91c1c; }

/* ── FLASH MESSAGE ───────────────────────────── */
.flash { padding:12px 16px; border-radius:var(--r-sm); font-size:13px; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.flash-success { background:var(--green-bg); color:var(--green); border:1.5px solid var(--green-bd); }
.flash-error   { background:var(--red-bg);   color:var(--red);   border:1.5px solid var(--red-bd); }

@media(max-width:768px) {
    .stats-row { grid-template-columns:repeat(2,1fr); }
    .rc-highlight { display:none; }
    .rc-nomor { display:none; }
}
</style>
@endpush

@section('content')

{{-- ════════════════ PAGE HEADER ════════════════ --}}
<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">🕐</span>
            Riwayat Aktivitas
        </h1>
        <p class="ph-sub">Rekam jejak semua perhitungan dan aktivitas sistem secara otomatis.</p>
    </div>
</div>
<hr class="divider">

{{-- ════════════════ FLASH MESSAGES ════════════════ --}}

@if(session('error'))
    <div class="flash flash-error">❌ {{ session('error') }}</div>
@endif

{{-- ════════════════ STATS — total global, tidak terpengaruh filter ════════════════ --}}
<div class="stats-row">
    <div class="stat-card sc-all">
        <div class="stat-icon" style="background:var(--purple-bg);">📋</div>
        <div>
            <div class="stat-val">{{ $totalSmart + $totalAhp + $totalNilai }}</div>
            <div class="stat-lbl">Total Riwayat</div>
        </div>
    </div>
    <div class="stat-card sc-smart">
        <div class="stat-icon" style="background:var(--gold-bg);">🏆</div>
        <div>
            <div class="stat-val">{{ $totalSmart }}</div>
            <div class="stat-lbl">Perhitungan SMART</div>
        </div>
    </div>
    <div class="stat-card sc-ahp">
        <div class="stat-icon" style="background:var(--accent-lt);">⚖️</div>
        <div>
            <div class="stat-val">{{ $totalAhp }}</div>
            <div class="stat-lbl">Perhitungan AHP</div>
        </div>
    </div>
</div>

{{-- ════════════════ FILTER BAR ════════════════ --}}
@php
    /*
     * Kumpulkan semua tanggal yang punya aktivitas beserta jenis-jenisnya,
     * untuk menampilkan indikator di bawah date picker.
     * Diambil tanpa filter agar selalu lengkap.
     */
    $tanggalAktif = \App\Models\Riwayat::selectRaw("DATE(created_at) as tgl, GROUP_CONCAT(DISTINCT jenis) as jenis_list")
        ->groupBy('tgl')
        ->orderByDesc('tgl')
        ->get()
        ->keyBy('tgl');
@endphp

<form method="GET" action="{{ route('riwayat.index') }}">
<div class="filter-bar">
    {{-- Filter jenis — mencakup semua: smart, ahp, nilai --}}
    <select name="jenis" class="filter-select">
        <option value="">Semua Jenis</option>
        <option value="smart" {{ request('jenis')==='smart' ? 'selected' : '' }}>🏆 Perhitungan SMART</option>
        <option value="ahp"   {{ request('jenis')==='ahp'   ? 'selected' : '' }}>⚖️ Perhitungan AHP</option>
    </select>

    <select name="periode_id" class="filter-select">
        <option value="">Semua Periode</option>
        @foreach($periodes as $p)
        <option value="{{ $p->id }}" {{ request('periode_id')==$p->id ? 'selected' : '' }}>
            {{ $p->nama_periode }}
        </option>
        @endforeach
    </select>

    <button type="submit" class="btn-filter">🔍 Filter</button>

    @if(request()->hasAny(['jenis','periode_id','tanggal']))
    <a href="{{ route('riwayat.index') }}" class="btn-reset">✕ Reset</a>
    @endif

    <div style="margin-left:auto;font-size:12px;color:var(--ink-3);">
        <strong style="color:var(--ink);">{{ $riwayats->total() }}</strong> riwayat ditemukan
    </div>
</div>
</form>

{{-- ════════════════ LEGENDA TANGGAL AKTIF ════════════════ --}}
{{--
    Menampilkan 10 tanggal terakhir yang ada aktivitas beserta kode aktivitasnya.
    Ini menjawab permintaan nomor 3: "dikasih tanda pada tanggal berapa terdapat riwayat".
--}}

{{-- ════════════════ RIWAYAT LIST ════════════════ --}}
@if($riwayats->isEmpty())
<div class="empty-box">
    <div class="empty-icon">🕐</div>
    <div class="empty-title">Belum Ada Riwayat</div>
    <div class="empty-sub">
        Riwayat akan muncul secara otomatis setelah ada aktivitas di sistem.<br>
        Mulai dengan menjalankan perhitungan <strong>AHP</strong> atau <strong>SMART</strong>.
    </div>
</div>
@else

@php
    $grouped = $riwayats->getCollection()->groupBy(
        fn($r) => $r->created_at->format('Y-m-d')
    );
    $nomorUrut = ($riwayats->currentPage() - 1) * $riwayats->perPage() + 1;
@endphp

@foreach($grouped as $tanggal => $items)
@php
    $dt    = \Carbon\Carbon::parse($tanggal);
    $hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$dt->dayOfWeek];
    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni',
              'Juli','Agustus','September','Oktober','November','Desember'][$dt->month];

    // Hitung berapa item per jenis di tanggal ini
    $countSmart = $items->where('jenis','smart')->count();
    $countAhp   = $items->where('jenis','ahp')->count();
    $countNilai = $items->where('jenis','nilai')->count();
@endphp
<div class="date-group">

    {{-- Label tanggal + indikator aktivitas --}}
    <div class="date-label-wrap">
        <div class="date-label">
            📅 {{ $hari }}, {{ $dt->day }} {{ $bulan }} {{ $dt->year }}
            @if($dt->isToday())
                <span style="color:var(--accent);font-weight:800;">— Hari ini</span>
            @elseif($dt->isYesterday())
                <span style="color:var(--ink-3);">— Kemarin</span>
            @endif
            <span class="date-count">{{ $items->count() }} item</span>
        </div>

        {{-- Dot indikator jenis aktivitas --}}
        <div class="date-activity-dots">
            @if($countSmart > 0)
            <span class="activity-dot ad-smart">🏆 SMART ×{{ $countSmart }}</span>
            @endif
            @if($countAhp > 0)
            <span class="activity-dot ad-ahp">⚖️ AHP ×{{ $countAhp }}</span>
            @endif
            @if($countNilai > 0)
            <span class="activity-dot ad-nilai">📝 Nilai ×{{ $countNilai }}</span>
            @endif
        </div>
    </div>

    {{-- Kartu-kartu riwayat --}}
    <div class="riwayat-list">
        @foreach($items as $riwayat)
        @php
            $jenis    = $riwayat->jenis;
            $data     = is_array($riwayat->data_json) ? $riwayat->data_json : [];
            $stripCls = 'strip-' . $jenis;
            $iconCls  = 'icon-' . $jenis;
            $jbCls    = 'jb-' . $jenis;
            $icons    = ['smart'=>'🏆','ahp'=>'⚖️','nilai'=>'📝'];
            $labels   = ['smart'=>'Perhitungan SMART','ahp'=>'Perhitungan AHP','nilai'];
        @endphp
        <div class="riwayat-card">
            <div class="rc-inner">
                <div class="rc-strip {{ $stripCls }}"></div>

                <div class="rc-body">
                    <div class="rc-nomor">#{{ $nomorUrut++ }}</div>

                    <div class="rc-icon {{ $iconCls }}">{{ $icons[$jenis] ?? '📋' }}</div>

                    <div class="rc-info">
                        <div class="rc-judul" title="{{ $riwayat->judul }}">
                            {{ $riwayat->judul }}
                        </div>
                        <div class="rc-meta">
                            <span class="jenis-badge {{ $jbCls }}">
                                {{ $icons[$jenis] ?? '📋' }} {{ $labels[$jenis] ?? ucfirst($jenis) }}
                            </span>
                            @if($riwayat->periode)
                            <span class="rc-meta-item">📅 {{ $riwayat->periode->nama_periode }}</span>
                            @endif
                            @if($riwayat->user)
                            <span class="rc-meta-item">👤 {{ $riwayat->user->name }}</span>
                            @endif
                            <span class="rc-meta-item" style="font-family:var(--mono);">
                                🕐 {{ $riwayat->created_at->format('H:i:s') }}
                            </span>
                            @if($riwayat->keterangan)
                            <span class="rc-meta-item">💬 {{ Str::limit($riwayat->keterangan, 60) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Highlight per jenis --}}
                    @if($jenis === 'smart' && isset($data['siswa_terbaik']))
                    <div class="rc-highlight">
                        <div class="rc-winner">🥇 {{ $data['siswa_terbaik'] }}</div>
                        <div class="rc-skor">Skor: {{ number_format($data['skor_tertinggi'] ?? 0, 4) }}</div>
                        <div style="font-size:11px;color:var(--ink-3);">{{ $data['jumlah_siswa'] ?? 0 }} siswa</div>
                    </div>
                    @elseif($jenis === 'ahp' && isset($data['cr']))
                    <div class="rc-highlight">
                        <div class="rc-skor">CR: {{ number_format($data['cr'], 4) }}</div>
                        <div style="font-size:11px;color:{{ $data['cr'] <= 0.1 ? 'var(--green)' : 'var(--red)' }};">
                            {{ $data['cr'] <= 0.1 ? '✓ Konsisten' : '✗ Tidak Konsisten' }}
                        </div>
                    </div>
                    @elseif($jenis === 'nilai' && isset($data['siswa_nama']))
                    <div class="rc-highlight">
                        <div class="rc-skor" style="font-size:12px;">{{ $data['siswa_nama'] }}</div>
                        <div style="font-size:11px;color:var(--ink-3);">{{ $data['kelas'] ?? '' }}</div>
                    </div>
                    @endif
                </div>

                <div class="rc-actions">
                    <a href="{{ route('riwayat.show', $riwayat) }}"
                       class="btn-act view" title="Lihat Detail">👁</a>
                    @if(Auth::user()->role === 'admin')
                    <button type="button" class="btn-act del" title="Hapus"
                        onclick="openDelModal({{ $riwayat->id }}, '{{ addslashes($riwayat->judul) }}')">
                        🗑
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endforeach

{{-- PAGINATION --}}
@if($riwayats->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:24px;padding-top:16px;border-top:1.5px solid var(--border);">
    
    <div style="font-size:12px;color:var(--ink-3);">
        Menampilkan <strong style="color:var(--ink);">{{ $riwayats->firstItem() }}–{{ $riwayats->lastItem() }}</strong>
        dari <strong style="color:var(--ink);">{{ $riwayats->total() }}</strong> riwayat
    </div>

    <div style="display:flex;align-items:center;gap:4px;">
        {{-- First --}}
        @if($riwayats->onFirstPage())
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);opacity:.4;cursor:not-allowed;">«</span>
        @else
            <a href="{{ $riwayats->url(1) }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-3)'">«</a>
        @endif

        {{-- Prev --}}
        @if($riwayats->onFirstPage())
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);opacity:.4;cursor:not-allowed;">‹</span>
        @else
            <a href="{{ $riwayats->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-3)'">‹</a>
        @endif

        {{-- Nomor halaman --}}
        @foreach($riwayats->getUrlRange(1, $riwayats->lastPage()) as $page => $url)
            @if($page == $riwayats->currentPage())
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--accent);border-radius:var(--r-sm);font-size:12px;font-weight:700;color:#fff;background:var(--accent);">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-3)'">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($riwayats->hasMorePages())
            <a href="{{ $riwayats->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-3)'">›</a>
        @else
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);opacity:.4;cursor:not-allowed;">›</span>
        @endif

        {{-- Last --}}
        @if($riwayats->hasMorePages())
            <a href="{{ $riwayats->url($riwayats->lastPage()) }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink-3)'">»</a>
        @else
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--ink-3);opacity:.4;cursor:not-allowed;">»</span>
        @endif
    </div>
</div>
@endif

@endif

{{-- ════════════════ MODAL HAPUS ════════════════ --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box">
        <div style="font-size:44px;margin-bottom:14px;">🗑️</div>
        <div style="font-size:17px;font-weight:800;color:var(--ink);margin-bottom:8px;">Hapus Riwayat?</div>
        <div style="font-size:13px;color:var(--ink-3);line-height:1.6;margin-bottom:4px;">
            Anda akan menghapus riwayat:<br>
            <strong id="delJudul" style="color:var(--ink);"></strong>
        </div>
        <div style="font-size:12px;color:var(--red);margin-top:6px;">Tindakan ini tidak dapat dibatalkan.</div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDelModal()">Batal</button>
            <form id="delForm" method="POST" style="flex:1;display:flex;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%;">🗑️ Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openDelModal(id, judul) {
    document.getElementById('delJudul').textContent = judul;
    document.getElementById('delForm').action = '/riwayat/' + id;
    document.getElementById('delModal').classList.add('open');
}
function closeDelModal() {
    document.getElementById('delModal').classList.remove('open');
}
document.getElementById('delModal').addEventListener('click', function(e) {
    if (e.target === this) closeDelModal();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDelModal();
});
</script>
@endpush