@extends('layouts.app')

@section('title', 'Data Siswa - SPK Siswa Terbaik')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:          #0f1623;
    --ink-2:        #3d4a5c;
    --ink-3:        #7a8899;
    --surface:      #ffffff;
    --surface-2:    #f6f8fc;
    --surface-3:    #eef1f8;
    --border:       #e2e8f4;
    --border-2:     #c8d3e8;
    --accent:       #2563eb;
    --accent-dark:  #1d4ed8;
    --accent-glow:  rgba(37,99,235,0.10);
    --accent-light: #eff6ff;
    --green:        #059669;
    --green-bg:     #ecfdf5;
    --red:          #dc2626;
    --red-bg:       #fef2f2;
    --red-bd:       #fca5a5;
    --orange:       #ea580c;
    --orange-bg:    #fff7ed;
    --orange-bd:    #fed7aa;
    --purple:       #7c3aed;
    --purple-bg:    #f5f3ff;
    --mono:         'JetBrains Mono', monospace;
    --sans:         'Plus Jakarta Sans', sans-serif;
    --r-sm:         8px;
    --r:            12px;
    --r-lg:         16px;
    --r-xl:         20px;
    --sh-sm:        0 1px 3px rgba(15,22,35,.06);
    --sh:           0 4px 16px rgba(15,22,35,.08);
    --sh-xl:        0 24px 64px rgba(15,22,35,.16);
}
* { font-family: var(--sans); box-sizing: border-box; margin: 0; padding: 0; }

/* ─── PAGE HEADER ─── */
.page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 16px;
    margin-bottom: 24px; flex-wrap: wrap;
}
.page-header-title {
    font-size: 22px; font-weight: 800; color: var(--ink);
    display: flex; align-items: center; gap: 10px;
    line-height: 1.2; margin-bottom: 4px;
}
.page-header-title .title-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #2563eb, #6366f1);
    border-radius: 10px; display: flex; align-items: center;
    justify-content: center; font-size: 17px; flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(37,99,235,.25);
}
.page-header-subtitle {
    font-size: 13px; color: var(--ink-3);
    padding-left: 46px; line-height: 1.5;
}
.page-header-actions { display: flex; align-items: center; gap: 8px; padding-top: 4px; }
.page-divider { border: none; border-top: 1.5px solid var(--border); margin: 0 0 24px; }

/* ─── BUTTONS ─── */
.btn-add {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--accent); color: #fff;
    border: none; border-radius: var(--r-sm);
    padding: 10px 20px; font-size: 13.5px; font-weight: 700;
    cursor: pointer; text-decoration: none;
    transition: all .18s; white-space: nowrap; font-family: var(--sans);
    box-shadow: 0 2px 10px rgba(37,99,235,.35);
}
.btn-add:hover { background: var(--accent-dark); transform: translateY(-1px); }
.btn-add svg { width: 15px; height: 15px; stroke: #fff; flex-shrink: 0; }
.btn-reset {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 14px; border: 1.5px solid var(--border); border-radius: var(--r-sm);
    background: var(--surface); font-family: var(--sans); font-size: 13px;
    font-weight: 600; color: var(--ink-3); cursor: pointer; text-decoration: none;
    transition: all .15s;
}
.btn-reset:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }

/* ─── STATS ─── */
.stats-row {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 24px;
}
.stat-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--r-lg); padding: 18px 16px;
    display: flex; align-items: center; gap: 12px;
    box-shadow: var(--sh-sm); transition: box-shadow .2s, transform .2s;
    position: relative; overflow: hidden; min-width: 0;
}
.stat-card:hover { box-shadow: var(--sh); transform: translateY(-2px); }
.stat-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    border-radius: 0 0 var(--r-lg) var(--r-lg);
}
.stat-card.s-blue::after   { background: linear-gradient(90deg,#2563eb,#6366f1); }
.stat-card.s-green::after  { background: linear-gradient(90deg,#059669,#10b981); }
.stat-card.s-orange::after { background: linear-gradient(90deg,#ea580c,#f97316); }
.stat-card.s-purple::after { background: linear-gradient(90deg,#7c3aed,#a855f7); }
.stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px; flex-shrink: 0;
}
.s-blue   .stat-icon { background: #eff6ff; }
.s-green  .stat-icon { background: #ecfdf5; }
.s-orange .stat-icon { background: #fff7ed; }
.s-purple .stat-icon { background: #f5f3ff; }
.stat-val { font-size: 24px; font-weight: 800; color: var(--ink); line-height: 1; font-family: var(--mono); }
.stat-lbl { font-size: 11.5px; color: var(--ink-3); font-weight: 600; margin-top: 3px; }

/* ─── INFO BANNER ─── */
.info-banner {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: var(--r-sm);
    background: #eff6ff; border: 1.5px solid #bfdbfe;
    font-size: 12.5px; color: #1e40af; line-height: 1.6;
    margin-bottom: 20px;
}

/* ─── TOOLBAR ─── */
.toolbar {
    display: flex; align-items: center;
    gap: 10px; margin-bottom: 20px; flex-wrap: wrap;
}
.toolbar-left  { display: flex; align-items: center; gap: 10px; flex: 1; flex-wrap: wrap; min-width: 0; }
.search-wrap   { position: relative; min-width: 220px; }
.search-icon   { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--ink-3); font-size: 13px; pointer-events: none; }
.search-input  { width: 100%; padding: 9px 12px 9px 36px; border: 1.5px solid var(--border); border-radius: var(--r-sm); font-family: var(--sans); font-size: 13px; color: var(--ink); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; }
.search-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
.filter-select { padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--r-sm); font-family: var(--sans); font-size: 13px; color: var(--ink); background: var(--surface); outline: none; cursor: pointer; transition: border-color .15s; min-width: 140px; }
.filter-select:focus { border-color: var(--accent); }

/* ─── BULK ACTION BAR ─── */
.bulk-action-bar {
    display: none;
    align-items: center; gap: 10px; flex-wrap: wrap;
    padding: 10px 16px;
    background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
    border-radius: var(--r-sm);
    margin-bottom: 14px;
    box-shadow: 0 4px 16px rgba(220,38,38,.25);
    animation: slideDown .22s ease;
}
.bulk-action-bar.visible { display: flex; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.bulk-info {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 700; color: #fff; flex: 1;
}
.bulk-count-badge {
    background: rgba(255,255,255,.2);
    border: 1.5px solid rgba(255,255,255,.3);
    color: #fff;
    font-size: 12px; font-weight: 800;
    padding: 2px 10px; border-radius: 20px;
    font-family: var(--mono);
}
.bulk-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--r-sm);
    font-family: var(--sans); font-size: 13px; font-weight: 700;
    cursor: pointer; border: none; transition: all .15s; white-space: nowrap;
    text-decoration: none;
}
.bulk-btn.delete-bulk {
    background: #fff;
    color: var(--red);
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.bulk-btn.delete-bulk:hover { background: #fef2f2; transform: translateY(-1px); }
.bulk-btn.cancel-bulk {
    background: transparent; color: rgba(255,255,255,.8);
    border: 1.5px solid rgba(255,255,255,.3);
}
.bulk-btn.cancel-bulk:hover { color: #fff; border-color: #fff; }

/* ─── CHECKBOX ─── */
.cb-wrap { display: flex; align-items: center; justify-content: center; }
.cb-custom {
    width: 18px; height: 18px; border-radius: 5px;
    border: 2px solid var(--border-2);
    background: var(--surface); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; flex-shrink: 0; position: relative;
    appearance: none; -webkit-appearance: none;
}
.cb-custom:hover { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
.cb-custom:checked { background: var(--accent); border-color: var(--accent); }
.cb-custom:checked::after {
    content: '';
    position: absolute;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg) translate(-1px,-1px);
}
.cb-custom:indeterminate { background: var(--accent); border-color: var(--accent); }
.cb-custom:indeterminate::after {
    content: '';
    position: absolute;
    width: 8px; height: 2px;
    background: #fff; border-radius: 2px;
}

/* ─── TABLE ─── */
.table-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--sh-sm); }
.table-card-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1.5px solid var(--border); gap: 12px; flex-wrap: wrap; }
.table-card-title { font-size: 14px; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 8px; }
.count-badge { background: var(--accent-light); color: var(--accent); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
table { width: 100%; border-collapse: collapse; font-size: 13.5px; min-width: 600px; }
thead tr { background: var(--surface-2); }
thead th { padding: 11px 16px; font-size: 10.5px; font-weight: 700; color: var(--ink-3); text-transform: uppercase; letter-spacing: .5px; border-bottom: 1.5px solid var(--border); white-space: nowrap; text-align: left; }
thead th.center { text-align: center; }
tbody tr { border-bottom: 1px solid var(--surface-3); transition: background .12s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #f8faff; }
tbody tr.row-selected { background: #eff6ff !important; }
tbody tr.row-selected:hover { background: #dbeafe !important; }
tbody td { padding: 13px 16px; color: var(--ink); vertical-align: middle; }
tbody td.center { text-align: center; }

/* ─── SISWA CELL ─── */
.siswa-cell { display: flex; align-items: center; gap: 11px; }
.siswa-avatar { width: 40px; height: 40px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; color: #fff; flex-shrink: 0; object-fit: cover; }
.avatar-male   { background: linear-gradient(135deg,#3b82f6,#1d4ed8); }
.avatar-female { background: linear-gradient(135deg,#ec4899,#be185d); }
.siswa-name { font-weight: 700; color: var(--ink); font-size: 13.5px; line-height: 1.2; }
.siswa-nis  { font-size: 11.5px; color: var(--ink-3); margin-top: 2px; font-family: var(--mono); }
.kelas-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; background: var(--accent-light); color: var(--accent); white-space: nowrap; }

/* ─── STATUS BADGE ─── */
.status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
.status-lengkap { background: #ecfdf5; color: #059669; border: 1.5px solid #6ee7b7; }
.status-belum   { background: #fef2f2; color: #dc2626; border: 1.5px solid #fca5a5; }

/* ─── ACTION BUTTONS ─── */
.action-btns { display: flex; align-items: center; gap: 5px; justify-content: center; }
.btn-action { width: 32px; height: 32px; border-radius: var(--r-sm); display: inline-flex; align-items: center; justify-content: center; font-size: 13px; border: 1.5px solid transparent; cursor: pointer; transition: all .15s; text-decoration: none; background: transparent; }
.btn-action.show  { background: var(--green-bg); color: var(--green); border-color: #a7f3d0; }
.btn-action.show:hover  { background: var(--green); color: #fff; }
.btn-action.edit  { background: var(--accent-light); color: var(--accent); border-color: #bfdbfe; }
.btn-action.edit:hover  { background: var(--accent); color: #fff; }
.btn-action.nilai { background: var(--orange-bg); color: var(--orange); border-color: var(--orange-bd); }
.btn-action.nilai:hover { background: var(--orange); color: #fff; }

/* ─── EMPTY STATE ─── */
.empty-state { text-align: center; padding: 72px 20px; color: var(--ink-3); }
.empty-icon  { font-size: 48px; margin-bottom: 14px; opacity: .4; }
.empty-title { font-size: 16px; font-weight: 800; color: var(--ink); margin-bottom: 6px; }
.empty-sub   { font-size: 13px; margin-bottom: 18px; }

/* ─── MODAL ─── */
.modal-overlay { position: fixed; inset: 0; background: rgba(10,14,26,.55); backdrop-filter: blur(5px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 16px; opacity: 0; pointer-events: none; transition: opacity .2s; }
.modal-overlay.open { opacity: 1; pointer-events: all; }
.modal-box { background: var(--surface); border-radius: var(--r-xl); padding: 30px; max-width: 440px; width: 100%; box-shadow: var(--sh-xl); border: 1.5px solid var(--border); transform: translateY(14px) scale(.97); transition: transform .22s cubic-bezier(.34,1.56,.64,1); position: relative; }
.modal-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; border-radius: var(--r-xl) var(--r-xl) 0 0; background: linear-gradient(90deg, var(--red), #f87171); }
.modal-overlay.open .modal-box { transform: none; }
.modal-icon-wrap { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 18px; background: var(--red-bg); border: 2px solid var(--red-bd); }
.modal-title { text-align: center; font-size: 18px; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
.modal-desc  { text-align: center; font-size: 13px; color: var(--ink-3); line-height: 1.65; margin-bottom: 24px; }
.modal-desc strong { color: var(--ink); }
.modal-actions { display: flex; gap: 10px; }
.btn-cancel  { flex: 1; padding: 10px; border: 1.5px solid var(--border-2); border-radius: var(--r-sm); background: var(--surface); font-family: var(--sans); font-size: 13.5px; font-weight: 600; color: var(--ink-3); cursor: pointer; transition: all .15s; }
.btn-cancel:hover { border-color: var(--ink-3); color: var(--ink); }
.btn-confirm-red { flex: 1; padding: 10px; border: none; border-radius: var(--r-sm); background: var(--red); font-family: var(--sans); font-size: 13.5px; font-weight: 700; color: #fff; cursor: pointer; transition: background .15s; }
.btn-confirm-red:hover { background: #b91c1c; }

/* ─── TOAST ─── */
.toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: var(--r-sm); background: var(--ink); color: #fff; font-size: 13px; font-weight: 600; box-shadow: var(--sh-xl); animation: toastIn .25s ease forwards; max-width: 320px; }
.toast.warning { background: #b45309; }
.toast.success { background: var(--green); }
.toast.error   { background: var(--red); }
@keyframes toastIn {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes toastOut {
    from { opacity: 1; }
    to   { opacity: 0; transform: translateX(20px); }
}

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .page-header { flex-direction: column; align-items: flex-start; }
    .btn-add { width: 100%; justify-content: center; }
}
@media (max-width: 480px) {
    .stats-row { grid-template-columns: 1fr 1fr; gap: 10px; }
    .stat-val  { font-size: 20px; }
    .toolbar   { flex-direction: column; align-items: stretch; }
    .search-wrap { min-width: 100%; }
}
</style>
@endpush

@section('content')

<div class="toast-container" id="toastContainer"></div>

{{-- ─── PAGE HEADER ─── --}}
<div class="page-header">
    <div>
        <h1 class="page-header-title">
            <span class="title-icon">👤</span>
            Data Siswa
        </h1>
        <p class="page-header-subtitle">
            Kelola data identitas dan nilai siswa.
        </p>
    </div>
    @if(Auth::user()->role === 'admin')
    <div class="page-header-actions">
        <a href="{{ route('siswa.create') }}" class="btn-add">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Siswa
        </a>
    </div>
    @endif
</div>
<hr class="page-divider">

{{-- ─── INFO BANNER WALI KELAS ─── --}}
@if(Auth::user()->role === 'wali_kelas')
<div class="info-banner">
    ℹ️ Anda login sebagai <strong>Wali Kelas</strong>.
    Untuk menginput nilai, gunakan menu <strong>Input Nilai</strong>.
</div>
@endif

{{-- ─── STATS ─── --}}
<div class="stats-row">
    <div class="stat-card s-blue">
        <div class="stat-icon">👥</div>
        <div>
            <div class="stat-val">{{ $siswas->count() }}</div>
            <div class="stat-lbl">Total Siswa</div>
        </div>
    </div>
    <div class="stat-card s-green">
        <div class="stat-icon">🏫</div>
        <div>
            <div class="stat-val">{{ $kelasList->count() }}</div>
            <div class="stat-lbl">Jumlah Kelas</div>
        </div>
    </div>
    <div class="stat-card s-orange">
        <div class="stat-icon">👦</div>
        <div>
            <div class="stat-val">{{ $siswas->where('jenis_kelamin', 'L')->count() }}</div>
            <div class="stat-lbl">Laki-laki</div>
        </div>
    </div>
    <div class="stat-card s-purple">
        <div class="stat-icon">👧</div>
        <div>
            <div class="stat-val">{{ $siswas->where('jenis_kelamin', 'P')->count() }}</div>
            <div class="stat-lbl">Perempuan</div>
        </div>
    </div>
</div>

{{-- ─── TOOLBAR / FILTER ─── --}}
<form method="GET" action="{{ route('siswa.index') }}" id="filterForm">
<div class="toolbar">
    <div class="toolbar-left">
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" class="search-input"
                   placeholder="Cari nama atau NIS…"
                   value="{{ request('search') }}"
                   oninput="this.form.submit()">
        </div>
        <select name="kelas" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                    {{ $kelas }}
                </option>
            @endforeach
        </select>
        @if(request('search') || request('kelas'))
            <a href="{{ route('siswa.index') }}" class="btn-reset">✕ Reset</a>
        @endif
    </div>
</div>
</form>

{{-- ─── BULK ACTION BAR ─── --}}
@if(Auth::user()->role === 'admin')
<div class="bulk-action-bar" id="bulkActionBar">
    <div class="bulk-info">
        🗑️ Hapus:
        <span class="bulk-count-badge" id="bulkCount">0</span>
        siswa dipilih
    </div>
    <button type="button" class="bulk-btn delete-bulk" onclick="confirmBulkDelete()">
        🗑️ Hapus yang Dipilih
    </button>
    <button type="button" class="bulk-btn cancel-bulk" onclick="clearSelection()">
        ✕ Batal
    </button>
</div>
@endif

{{-- ─── TABLE CARD ─── --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            📋 Daftar Siswa
            <span class="count-badge" id="displayCount">{{ $siswas->count() }} siswa</span>
        </div>
        @if(!$siswas->isEmpty() && Auth::user()->role === 'admin')
        <button type="button" id="btnSelectAll" onclick="toggleSelectAll()" style="
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 13px; border: 1.5px solid var(--border);
            border-radius: var(--r-sm); background: var(--surface);
            font-family: var(--sans); font-size: 12px; font-weight: 600;
            color: var(--ink-3); cursor: pointer; transition: all .15s;
        ">
            <input type="checkbox" id="cbSelectAll" class="cb-custom" style="pointer-events:none;">
            <span id="selectAllText">Pilih Semua</span>
        </button>
        @endif
    </div>

    <div class="tbl-wrap">
        @if($siswas->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div class="empty-title">Belum Ada Data Siswa</div>
            <div class="empty-sub">Tambahkan siswa baru untuk mulai mengelola data.</div>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('siswa.create') }}" class="btn-add" style="display:inline-flex;margin-top:8px;">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Siswa Pertama
            </a>
            @endif
        </div>
        @else
        <table>
            <thead>
                <tr>
                    @if(Auth::user()->role === 'admin')
                    <th style="width:44px" class="center">
                        <div class="cb-wrap">
                            <input type="checkbox" id="cbHeaderAll" class="cb-custom"
                                   onchange="syncHeaderCheck(this)">
                        </div>
                    </th>
                    @endif
                    <th style="width:44px" class="center">NO</th>
                    <th>NAMA SISWA</th>
                    <th class="center">KELAS</th>
                    <th class="center">JENIS KELAMIN</th>
                    <th class="center">STATUS NILAI</th>
                    <th class="center" style="width:110px">AKSI</th>
                </tr>
            </thead>
            <tbody id="siswaTableBody">
                @foreach($siswas as $i => $siswa)
                @php $jumlahNilai = $siswa->nilaiSiswas->count(); @endphp
                <tr id="row-{{ $siswa->id }}" data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}">

                    {{-- CHECKBOX — admin only --}}
                    @if(Auth::user()->role === 'admin')
                    <td class="center">
                        <div class="cb-wrap">
                            <input type="checkbox"
                                   class="cb-custom row-cb"
                                   value="{{ $siswa->id }}"
                                   data-nama="{{ $siswa->nama }}"
                                   onchange="onRowCheck(this)">
                        </div>
                    </td>
                    @endif

                    {{-- NO --}}
                    <td class="center" style="font-size:12px;font-weight:600;color:var(--ink-3)">
                        {{ $i + 1 }}
                    </td>

                    {{-- NAMA --}}
                    <td>
                        <div class="siswa-cell">
                            @if($siswa->foto)
                                <img src="{{ Storage::url($siswa->foto) }}"
                                     class="siswa-avatar" alt="{{ $siswa->nama }}">
                            @else
                                <div class="siswa-avatar {{ $siswa->jenis_kelamin === 'L' ? 'avatar-male' : 'avatar-female' }}">
                                    {{ $siswa->initials }}
                                </div>
                            @endif
                            <div>
                                <div class="siswa-name">{{ $siswa->nama }}</div>
                                <div class="siswa-nis">{{ $siswa->nis }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- KELAS --}}
                    <td class="center">
                        <span class="kelas-badge">{{ $siswa->kelas }}</span>
                    </td>

                    {{-- JENIS KELAMIN --}}
                    <td class="center" style="font-size:13px;color:var(--ink-2)">
                        {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>

                    {{-- STATUS NILAI --}}
                    <td class="center">
                        @if($jumlahNilai === 0)
                            <span class="status-badge status-belum">✗ Belum Diinput</span>
                        @else
                            <span class="status-badge status-lengkap">✓ Sudah Diinput</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="center">
                        <div class="action-btns">
                            <a href="{{ route('siswa.show', $siswa->id) }}"
                               class="btn-action show" title="Lihat Detail">👁</a>

                            @if(Auth::user()->role === 'wali_kelas' || Auth::user()->role === 'admin')
                            <a href="{{ route('nilai.create', ['siswa' => $siswa->id]) }}"
                               class="btn-action nilai" title="Input Nilai">📝</a>
                            @endif

                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('siswa.edit', $siswa) }}"
                               class="btn-action edit" title="Edit Data Siswa">✏️</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Footer tabel --}}
    <div style="padding:12px 20px; border-top:1.5px solid var(--border); background:var(--surface-2);
                display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <div style="font-size:12px; color:var(--ink-3);">
            @if(Auth::user()->role === 'admin')
            💡 Centang siswa lalu klik <strong>🗑️ Hapus yang Dipilih</strong> untuk menghapus sekaligus.
            @endif
        </div>
        <div style="font-size:12px; color:var(--ink-3); display:flex; gap:12px;">
            <span>✓ Sudah diinput: <strong style="color:#059669">{{ $jumlahSudahInput }}</strong></span>
            <span>✗ Belum: <strong style="color:#dc2626">{{ $jumlahBelumInput }}</strong></span>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     MODAL HAPUS BULK
     FIX: action diubah ke route('siswa.destroyBulk')
          bukan route('siswa.index') seperti sebelumnya
     ════════════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="deleteBulkModal">
    <div class="modal-box">
        <div class="modal-icon-wrap">🗑️</div>
        <div class="modal-title">Hapus Beberapa Siswa?</div>
        <div class="modal-desc">
            Anda akan menghapus <strong id="bulkDeleteCount">0</strong> siswa sekaligus.<br>
            Semua nilai mereka juga akan terhapus permanen.<br>
            Tindakan ini <strong>tidak dapat dibatalkan</strong>.
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('deleteBulkModal')">Batalkan</button>

            {{-- ✅ FIX #1: action sekarang mengarah ke route siswa.destroyBulk
                             yaitu DELETE /siswa/hapus-bulk
                 ✅ FIX #2: @method('DELETE') wajib ada agar Laravel
                             menerima request sebagai HTTP DELETE --}}
            <form id="deleteBulkForm"
                  method="POST"
                  action="{{ route('siswa.destroyBulk') }}"
                  style="flex:1; display:flex;">
                @csrf
                @method('DELETE')
                {{-- siswa_ids diisi oleh JS saat modal dibuka --}}
                <input type="hidden" name="siswa_ids" id="bulkDeleteIds">
                <button type="submit" class="btn-confirm-red" style="width:100%;">
                    🗑️ Ya, Hapus Semua
                </button>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ─── STATE ───────────────────────────────────────────────
let selectedIds   = new Set();
let selectedNames = {};

// ─── ROW CHECK ──────────────────────────────────────────
function onRowCheck(cb) {
    const id   = parseInt(cb.value);
    const nama = cb.dataset.nama;
    const row  = document.getElementById('row-' + id);

    if (cb.checked) {
        selectedIds.add(id);
        selectedNames[id] = nama;
        row.classList.add('row-selected');
    } else {
        selectedIds.delete(id);
        delete selectedNames[id];
        row.classList.remove('row-selected');
    }
    updateBulkBar();
    syncHeaderCbState();
}

// ─── SELECT ALL ──────────────────────────────────────────
function toggleSelectAll() {
    const cbs       = document.querySelectorAll('.row-cb');
    const headerCb  = document.getElementById('cbHeaderAll');
    const allChecked = [...cbs].every(cb => cb.checked);

    cbs.forEach(cb => {
        cb.checked = !allChecked;
        onRowCheck(cb);
    });
    if (headerCb) { headerCb.checked = !allChecked; headerCb.indeterminate = false; }
}

function syncHeaderCheck(headerCb) {
    document.querySelectorAll('.row-cb').forEach(cb => {
        cb.checked = headerCb.checked;
        onRowCheck(cb);
    });
}

function syncHeaderCbState() {
    const cbs      = document.querySelectorAll('.row-cb');
    const headerCb = document.getElementById('cbHeaderAll');
    if (!headerCb) return;

    const checked = [...cbs].filter(c => c.checked).length;
    if (checked === 0) {
        headerCb.checked = false; headerCb.indeterminate = false;
        document.getElementById('selectAllText').textContent = 'Pilih Semua';
    } else if (checked === cbs.length) {
        headerCb.checked = true; headerCb.indeterminate = false;
        document.getElementById('selectAllText').textContent = 'Batal Semua';
    } else {
        headerCb.checked = false; headerCb.indeterminate = true;
        document.getElementById('selectAllText').textContent = `${checked} Dipilih`;
    }
}

// ─── CLEAR ───────────────────────────────────────────────
function clearSelection() {
    selectedIds.clear();
    selectedNames = {};
    document.querySelectorAll('.row-cb').forEach(cb => {
        cb.checked = false;
        const row = document.getElementById('row-' + cb.value);
        if (row) row.classList.remove('row-selected');
    });
    const hdr = document.getElementById('cbHeaderAll');
    if (hdr) { hdr.checked = false; hdr.indeterminate = false; }
    const txt = document.getElementById('selectAllText');
    if (txt) txt.textContent = 'Pilih Semua';
    updateBulkBar();
}

// ─── BULK BAR ────────────────────────────────────────────
function updateBulkBar() {
    const bar   = document.getElementById('bulkActionBar');
    const count = document.getElementById('bulkCount');
    if (!bar) return;
    if (selectedIds.size > 0) {
        bar.classList.add('visible');
        count.textContent = selectedIds.size;
    } else {
        bar.classList.remove('visible');
    }
}

// ─── BULK DELETE ─────────────────────────────────────────
function confirmBulkDelete() {
    if (selectedIds.size === 0) {
        showToast('⚠️ Pilih minimal 1 siswa untuk dihapus.', 'warning');
        return;
    }
    // Isi jumlah di modal
    document.getElementById('bulkDeleteCount').textContent = selectedIds.size;
    // Isi hidden input: "1,2,3"
    document.getElementById('bulkDeleteIds').value = [...selectedIds].join(',');
    // Buka modal
    document.getElementById('deleteBulkModal').classList.add('open');
}

// ─── MODAL ───────────────────────────────────────────────
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape')
        document.querySelectorAll('.modal-overlay.open').forEach(m => closeModal(m.id));
});

// ─── TOAST ───────────────────────────────────────────────
function showToast(msg, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = msg;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'toastOut .25s ease forwards';
        setTimeout(() => toast.remove(), 280);
    }, 3500);
}

// ─── FLASH SESSION ───────────────────────────────────────
@if(session('success'))
    showToast('✅ {!! addslashes(session('success')) !!}', 'success');
@endif
@if(session('error'))
    showToast('❌ {!! addslashes(session('error')) !!}', 'error');
@endif
</script>
@endpush