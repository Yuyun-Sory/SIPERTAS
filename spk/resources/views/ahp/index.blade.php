@extends('layouts.app')

@section('title', 'Perhitungan AHP - SPK Siswa Terbaik')
@section('page-title', 'Perhitungan AHP')
@section('page-subtitle', 'Tentukan bobot prioritas tiap kriteria menggunakan metode Analytic Hierarchy Process (AHP) dengan skala perbandingan Saaty 1–9.')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --font:    'Plus Jakarta Sans', sans-serif;
    --mono:    'JetBrains Mono', monospace;
    --ink:     #0d1526;
    --ink-2:   #3a4a60;
    --ink-3:   #7a8899;
    --surface: #ffffff;
    --surf-2:  #f7f9fd;
    --surf-3:  #eef2f9;
    --border:  #e1e8f4;
    --border-2:#c8d4ea;
    --accent:  #2254e8;
    --accent-d:#1a42cc;
    --accent-g:rgba(34,84,232,.10);
    --green:   #059669;
    --green-bg:#ecfdf5;
    --green-bd:#a7f3d0;
    --red:     #dc2626;
    --red-bg:  #fef2f2;
    --red-bd:  #fca5a5;
    --yellow:  #d97706;
    --yel-bg:  #fffbeb;
    --yel-bd:  #fde68a;
    --purple:  #6d28d9;
    --pur-bg:  #f5f3ff;
    --pur-bd:  #ddd6fe;
    --radius-sm: 8px;
    --radius:    14px;
    --radius-lg: 20px;
    --shadow-sm: 0 1px 3px rgba(13,21,38,.06),0 1px 2px rgba(13,21,38,.04);
    --shadow:    0 4px 14px rgba(13,21,38,.07),0 1px 4px rgba(13,21,38,.05);
    --shadow-lg: 0 12px 36px rgba(13,21,38,.10),0 4px 8px rgba(13,21,38,.06);
  }
  * { font-family: var(--font); box-sizing: border-box; }
  .ahp-wrap { width:100%; max-width:100%; }

  /* ── STEP BAR ── */
  .step-bar {
    display:flex; align-items:center; gap:0;
    background:var(--surface); border:1.5px solid var(--border);
    border-radius:var(--radius); padding:14px 20px;
    margin-bottom:24px; box-shadow:var(--shadow-sm); overflow-x:auto;
  }
  .step-item { display:flex; align-items:center; gap:10px; flex-shrink:0; }
  .step-num {
    width:30px; height:30px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:800; font-family:var(--mono); flex-shrink:0;
  }
  .step-item.active   .step-num { background:var(--accent); color:#fff; box-shadow:0 2px 8px rgba(34,84,232,.35); }
  .step-item.done     .step-num { background:var(--green);  color:#fff; }
  .step-item.inactive .step-num { background:var(--surf-3); color:var(--ink-3); }
  .step-label { font-size:12px; font-weight:700; }
  .step-item.active   .step-label { color:var(--accent); }
  .step-item.done     .step-label { color:var(--green); }
  .step-item.inactive .step-label { color:var(--ink-3); }
  .step-arrow { margin:0 14px; color:var(--border-2); font-size:14px; flex-shrink:0; }

  /* ── CARD ── */
  .ahp-card {
    background:var(--surface); border:1.5px solid var(--border);
    border-radius:var(--radius-lg); box-shadow:var(--shadow-sm);
    margin-bottom:20px; overflow:hidden; transition:box-shadow .2s;
  }
  .ahp-card:hover { box-shadow:var(--shadow); }
  .card-head {
    padding:18px 22px 16px; border-bottom:1.5px solid var(--border);
    display:flex; align-items:center; gap:14px;
    background:linear-gradient(135deg,var(--surf-2) 0%,#fff 100%);
  }
  .card-head-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
  .card-head-text { flex:1; min-width:0; }
  .card-head-title { font-size:15px; font-weight:800; color:var(--ink); line-height:1.2; }
  .card-head-sub   { font-size:12px; color:var(--ink-3); margin-top:3px; line-height:1.5; }
  .card-head-badge { font-size:10px; font-weight:700; padding:4px 10px; border-radius:20px; white-space:nowrap; flex-shrink:0; }
  .card-body       { padding:20px 22px; overflow-x:auto; }
  .card-stripe     { height:3px; }
  .stripe-blue   { background:linear-gradient(90deg,#2254e8,#6366f1); }
  .stripe-green  { background:linear-gradient(90deg,#059669,#10b981); }
  .stripe-yellow { background:linear-gradient(90deg,#d97706,#f59e0b); }
  .stripe-purple { background:linear-gradient(90deg,#6d28d9,#8b5cf6); }
  .stripe-orange { background:linear-gradient(90deg,#ea580c,#f97316); }
  .stripe-teal   { background:linear-gradient(90deg,#0d9488,#14b8a6); }

  /* ── SKALA GRID ── */
  .skala-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:8px; }
  .skala-chip { display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; border:1.5px solid; transition:transform .12s; }
  .skala-chip:hover { transform:translateY(-1px); }
  .skala-chip .sc-num { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-family:var(--mono); font-size:14px; font-weight:800; flex-shrink:0; }
  .skala-chip .sc-info { flex:1; min-width:0; }
  .skala-chip .sc-name { font-size:12px; font-weight:700; color:var(--ink); }
  .skala-chip .sc-desc { font-size:10.5px; color:var(--ink-3); margin-top:1px; line-height:1.4; }
  .sk-1{background:#f0fdf4;border-color:#a7f3d0;} .sk-1 .sc-num{background:#a7f3d0;color:#065f46;}
  .sk-2{background:#f0fdf4;border-color:#bbf7d0;} .sk-2 .sc-num{background:#bbf7d0;color:#065f46;}
  .sk-3{background:#eff6ff;border-color:#bfdbfe;} .sk-3 .sc-num{background:#bfdbfe;color:#1e40af;}
  .sk-4{background:#eff6ff;border-color:#93c5fd;} .sk-4 .sc-num{background:#93c5fd;color:#1e40af;}
  .sk-5{background:#fffbeb;border-color:#fde68a;} .sk-5 .sc-num{background:#fde68a;color:#92400e;}
  .sk-6{background:#fffbeb;border-color:#fcd34d;} .sk-6 .sc-num{background:#fcd34d;color:#92400e;}
  .sk-7{background:#fef3c7;border-color:#fbbf24;} .sk-7 .sc-num{background:#fbbf24;color:#78350f;}
  .sk-8{background:#fff7ed;border-color:#fdba74;} .sk-8 .sc-num{background:#fdba74;color:#7c2d12;}
  .sk-9{background:#fef2f2;border-color:#fca5a5;} .sk-9 .sc-num{background:#fca5a5;color:#7f1d1d;}

  /* ── MATRIKS TABEL ── */
  .matrix-table { width:100%; border-collapse:separate; border-spacing:0; min-width:520px; }
  .matrix-table th {
    padding:10px 12px; text-align:center; background:var(--surf-2);
    font-size:11.5px; font-weight:700; color:var(--ink-2); border:1px solid var(--border);
    position:sticky; top:0; z-index:2;
  }
  .matrix-table th.th-row-label { text-align:left; min-width:150px; position:sticky; left:0; z-index:3; background:var(--surf-2); }
  .matrix-table td {
    padding:8px 10px; text-align:center;
    border:1px solid var(--border); font-size:12.5px; background:var(--surface);
  }
  .matrix-table td.td-row-label {
    text-align:left; font-weight:600; color:var(--ink); background:var(--surf-2);
    position:sticky; left:0; z-index:1; white-space:nowrap; min-width:150px;
    border-right:2px solid var(--border-2);
  }
  .td-row-label .k-code { font-family:var(--mono); color:var(--accent); font-size:11px; margin-right:5px; font-weight:700; }
  .td-row-label .k-name { font-size:12px; }
  .cell-diag  { background:linear-gradient(135deg,#eff6ff,#e0e7ff); font-family:var(--mono); font-weight:800; color:var(--accent); font-size:14px; }
  .cell-recip { background:var(--surf-3); color:var(--ink-3); font-family:var(--mono); font-size:11.5px; font-style:italic; }
  .cell-input { padding:5px 7px; }
  .cell-input select {
    border:1.5px solid var(--border-2); border-radius:var(--radius-sm);
    padding:6px 28px 6px 10px; font-family:var(--font); font-size:12px; font-weight:600;
    color:var(--ink); background:var(--surface); cursor:pointer; outline:none; min-width:95px;
    transition:border-color .15s,box-shadow .15s; appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%232254e8'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 9px center; background-size:10px 6px;
  }
  .cell-input select:hover { border-color:var(--accent); }
  .cell-input select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(34,84,232,.12); }
  .row-colsum td {
    background:linear-gradient(135deg,#eff6ff,#e0e7ff); font-family:var(--mono);
    font-weight:700; color:var(--accent); font-size:12px; border-top:2px solid var(--accent);
  }
  .row-colsum td.td-sum-label { text-align:left; font-family:var(--font); font-weight:700; color:var(--ink); }

  /* ── TABEL EXCEL-STYLE ── */
  .excel-table { width:100%; border-collapse:separate; border-spacing:0; min-width:520px; font-size:12px; }
  .excel-table th, .excel-table td { padding:9px 11px; border:1px solid var(--border); }
  .excel-table th { background:var(--surf-2); font-weight:700; color:var(--ink-2); font-size:11.5px; text-align:center; }
  .excel-table th.th-label { text-align:left; min-width:160px; position:sticky; left:0; z-index:2; }
  .excel-table td { font-family:var(--mono); font-size:11.5px; color:var(--ink-2); text-align:center; background:var(--surface); }
  .excel-table td.td-label { text-align:left; background:var(--surf-2); font-weight:600; color:var(--ink); font-family:var(--font); position:sticky; left:0; border-right:2px solid var(--border-2); white-space:nowrap; }
  .excel-table td.td-label .k-code { font-family:var(--mono); color:var(--accent); font-size:11px; margin-right:5px; font-weight:700; }
  .excel-table td.td-result { background:linear-gradient(135deg,#eff6ff,#e0e7ff); font-weight:800; color:var(--accent); border-left:2px solid var(--accent); }
  .excel-table td.td-pct    { background:var(--green-bg); font-weight:700; color:var(--green); }
  .excel-table th.th-result { background:#eff6ff; color:var(--accent); border-left:2px solid var(--accent); }
  .excel-table th.th-pct    { background:var(--green-bg); color:var(--green); }
  .excel-table tr.tr-total td { background:linear-gradient(135deg,#f0fdf4,#dcfce7); font-weight:800; color:var(--green); border-top:2px solid var(--green); }
  .excel-table tr.tr-total td.td-label { background:linear-gradient(135deg,#f0fdf4,#dcfce7); font-family:var(--font); font-weight:800; color:var(--green); }

  /* ── STATS ── */
  .stats-4 { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
  .stat-box { border-radius:var(--radius); padding:16px; border:1.5px solid; text-align:center; transition:transform .15s,box-shadow .15s; }
  .stat-box:hover { transform:translateY(-2px); box-shadow:var(--shadow); }
  .stat-box .sb-label { font-size:10.5px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; margin-bottom:6px; }
  .stat-box .sb-val   { font-size:22px; font-weight:800; font-family:var(--mono); line-height:1; }
  .stat-box .sb-desc  { font-size:10px; margin-top:5px; opacity:.75; }
  .sb-blue  { background:#eff6ff;border-color:#bfdbfe; } .sb-blue   .sb-label,.sb-blue   .sb-val { color:var(--accent); }
  .sb-yellow{ background:var(--yel-bg);border-color:var(--yel-bd); } .sb-yellow .sb-label,.sb-yellow .sb-val { color:var(--yellow); }
  .sb-green { background:var(--green-bg);border-color:var(--green-bd); } .sb-green  .sb-label,.sb-green  .sb-val { color:var(--green); }
  .sb-purple{ background:var(--pur-bg);border-color:var(--pur-bd); } .sb-purple .sb-label,.sb-purple .sb-val { color:var(--purple); }

  /* ── CR BANNER ── */
  .cr-banner { border-radius:var(--radius); padding:16px 20px; display:flex; align-items:center; gap:14px; border:1.5px solid; margin-bottom:16px; transition:all .3s; }
  .cr-banner.state-wait { background:var(--surf-2);border-color:var(--border-2); }
  .cr-banner.state-ok   { background:#f0fdf4;border-color:#86efac; }
  .cr-banner.state-fail { background:#fff1f2;border-color:#fca5a5; }
  .cr-banner .cb-icon   { font-size:28px; flex-shrink:0; }
  .cr-banner .cb-body   { flex:1; }
  .cr-banner .cb-title  { font-size:14px; font-weight:800; margin-bottom:3px; }
  .cr-banner .cb-sub    { font-size:12.5px; line-height:1.5; }
  .state-wait .cb-title { color:var(--ink-3); } .state-wait .cb-sub { color:var(--ink-3); }
  .state-ok   .cb-title { color:#15803d; }      .state-ok   .cb-sub { color:#166534; }
  .state-fail .cb-title { color:#be123c; }      .state-fail .cb-sub { color:#9f1239; }
  .cr-val { font-family:var(--mono); font-size:28px; font-weight:800; flex-shrink:0; padding:10px 16px; border-radius:var(--radius-sm); border:1.5px solid; }
  .state-wait .cr-val { background:var(--surf-3);border-color:var(--border-2);color:var(--ink-3); }
  .state-ok   .cr-val { background:#dcfce7;border-color:#86efac;color:#15803d; }
  .state-fail .cr-val { background:#fee2e2;border-color:#fca5a5;color:#be123c; }
  .formula-strip {
    background:var(--surf-2); border:1px solid var(--border); border-radius:var(--radius-sm);
    padding:12px 16px; font-size:12px; color:var(--ink-3); line-height:1.8;
    display:flex; flex-wrap:wrap; gap:6px 20px; align-items:center;
  }
  .formula-strip .f-item { display:flex; align-items:center; gap:6px; }
  .formula-strip .f-eq   { font-family:var(--mono); font-size:12px; color:var(--ink-2); font-weight:600; }
  .formula-strip .f-ok   { color:var(--green); font-weight:700; }
  .formula-strip .f-fail { color:var(--red);   font-weight:700; }

  /* ── RANK ── */
  .rank-list { display:flex; flex-direction:column; gap:10px; }
  .rank-row {
    display:flex; align-items:center; gap:12px; padding:10px 14px;
    background:var(--surf-2); border:1.5px solid var(--border); border-radius:var(--radius-sm);
    transition:transform .12s,box-shadow .12s;
  }
  .rank-row:hover { transform:translateX(3px); box-shadow:var(--shadow-sm); }
  .rank-num { width:28px;height:28px;border-radius:50%;background:var(--accent);color:#fff;font-size:11px;font-weight:800;font-family:var(--mono);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
  .rank-row:nth-child(1) .rank-num { background:#f59e0b; }
  .rank-row:nth-child(2) .rank-num { background:#94a3b8; }
  .rank-row:nth-child(3) .rank-num { background:#b45309; }
  .rank-kode  { font-family:var(--mono);font-size:11px;font-weight:700;color:var(--accent);width:36px;flex-shrink:0; }
  .rank-name  { flex:1;font-size:12.5px;font-weight:600;color:var(--ink);min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
  .rank-bar-wrap { width:180px;height:18px;background:var(--surf-3);border-radius:20px;overflow:hidden;flex-shrink:0; }
  .rank-bar   { height:100%;border-radius:20px;background:linear-gradient(90deg,var(--accent),#6366f1);display:flex;align-items:center;justify-content:flex-end;padding-right:8px;min-width:30px;transition:width .7s cubic-bezier(.34,1.2,.64,1); }
  .rank-bar span { font-size:9.5px;font-weight:700;color:#fff;font-family:var(--mono); }
  .rank-pct   { width:52px;text-align:right;font-family:var(--mono);font-size:12px;font-weight:700;color:var(--accent);flex-shrink:0; }

  /* ── SAVE SECTION ── */
  .save-section {
    border-radius:var(--radius-lg); padding:24px 28px; margin-top:8px;
    display:flex; align-items:center; justify-content:space-between;
    gap:20px; flex-wrap:wrap; box-shadow:var(--shadow); position:relative; overflow:hidden;
    border:1.5px solid;
  }
  .save-section.state-saved   { background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-color:#86efac; }
  .save-section.state-unsaved { background:linear-gradient(135deg,#f8faff,#eff4ff); border-color:#c0cff8; }
  .save-section::before {
    content:'';position:absolute;top:0;left:0;right:0;height:3px;
  }
  .save-section.state-saved::before   { background:linear-gradient(90deg,var(--green),#10b981,#34d399); }
  .save-section.state-unsaved::before { background:linear-gradient(90deg,var(--accent),#6366f1,#8b5cf6); }
  .save-info { flex:1; min-width:240px; }
  .save-info .si-title { font-size:15px; font-weight:800; color:var(--ink); margin-bottom:4px; }
  .save-info .si-sub   { font-size:12.5px; color:var(--ink-3); line-height:1.5; }
  .save-actions { display:flex; gap:10px; flex-shrink:0; flex-wrap:wrap; }

  /* ── SAVED STATE BOX ── */
  .saved-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:var(--green-bg); border:1.5px solid var(--green-bd); color:var(--green);
    border-radius:20px; padding:5px 14px; font-size:12px; font-weight:700;
    margin-bottom:8px;
  }

  /* ── BUTTONS ── */
  .btn {
    display:inline-flex; align-items:center; gap:7px; padding:11px 22px;
    border-radius:var(--radius-sm); font-family:var(--font); font-size:13px; font-weight:700;
    border:1.5px solid transparent; cursor:pointer; transition:all .15s;
    text-decoration:none; white-space:nowrap;
  }
  .btn-primary   { background:var(--accent);color:#fff;border-color:var(--accent);box-shadow:0 2px 10px rgba(34,84,232,.35); }
  .btn-primary:hover:not(:disabled) { background:var(--accent-d);box-shadow:0 4px 18px rgba(34,84,232,.45);transform:translateY(-1px); }
  .btn-primary:disabled { opacity:0.45; cursor:not-allowed; }
  .btn-secondary { background:var(--surface);color:var(--ink);border-color:var(--border-2);box-shadow:var(--shadow-sm); }
  .btn-secondary:hover { background:var(--surf-3);transform:translateY(-1px); }
  .btn-success   { background:var(--green);color:#fff;border-color:var(--green);box-shadow:0 2px 10px rgba(5,150,105,.30); }
  .btn-success:hover:not(:disabled) { background:#047857;box-shadow:0 4px 18px rgba(5,150,105,.40);transform:translateY(-1px); }

  /* ── EMPTY / FLASH ── */
  .empty-wrap { text-align:center;padding:60px 24px;background:var(--surface);border:2px dashed var(--border-2);border-radius:var(--radius-lg); }
  .empty-wrap .ei { font-size:52px;margin-bottom:14px; }
  .empty-wrap .et { font-size:17px;font-weight:800;color:var(--ink);margin-bottom:8px; }
  .empty-wrap .es { font-size:13px;color:var(--ink-3);line-height:1.6; }
  .flash { display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:var(--radius-sm);margin-bottom:18px;font-size:13px;font-weight:600;border:1.5px solid; }
  .flash.success { background:var(--green-bg);border-color:var(--green-bd);color:#065f46; }
  .flash.error   { background:var(--red-bg);border-color:var(--red-bd);color:#7f1d1d; }

  /* ── REKAP BOX ── */
  .rekap-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:12px; margin-bottom:16px; }
  .rekap-item {
    display:flex; align-items:center; gap:12px; padding:14px 16px;
    border-radius:var(--radius-sm); border:1.5px solid; background:var(--surf-2);
  }
  .rekap-item .ri-icon { font-size:22px; flex-shrink:0; }
  .rekap-item .ri-body { flex:1; min-width:0; }
  .rekap-item .ri-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--ink-3); margin-bottom:3px; }
  .rekap-item .ri-val   { font-size:18px; font-weight:800; font-family:var(--mono); color:var(--ink); }
  .rekap-item .ri-sub   { font-size:10.5px; color:var(--ink-3); margin-top:2px; }

  .table-scroll { overflow-x:auto;-webkit-overflow-scrolling:touch; }
  .table-scroll::-webkit-scrollbar { height:5px; }
  .table-scroll::-webkit-scrollbar-thumb { background:var(--border-2);border-radius:10px; }

  .section-divider {
    display:flex; align-items:center; gap:12px; margin:6px 0 14px;
    font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:var(--ink-3);
  }
  .section-divider::before,.section-divider::after { content:''; flex:1; height:1px; background:var(--border); }

  @media (max-width:900px) { .stats-4 { grid-template-columns:1fr 1fr; } .rank-bar-wrap { width:120px; } }
  @media (max-width:600px) { .stats-4 { grid-template-columns:1fr 1fr;gap:10px; } .save-section { flex-direction:column; } }
</style>
@endpush

@section('content')
<div class="ahp-wrap">

{{-- ── FLASH ── --}}
@if(session('success'))
  <div class="flash success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="flash error">❌ {{ session('error') }}</div>
@endif

@if($kriterias->isEmpty())
<div class="empty-wrap">
  <div class="ei">⚠️</div>
  <div class="et">Belum Ada Data Kriteria</div>
  <div class="es">Tambahkan kriteria penilaian terlebih dahulu sebelum melakukan perhitungan AHP.</div>
  <a href="{{ route('kriteria.index') }}" class="btn btn-primary" style="margin-top:20px">📋 Tambah Kriteria</a>
</div>

@else

{{-- ══════════════════════════════════════
     STEP BAR
     FIX: step-state ditentukan dari $bobotTersimpan (PHP),
     bukan session() — sehingga tetap 'done' setelah refresh
════════════════════════════════════════ --}}
@php
  $allDone = $bobotTersimpan;
  $hasilAda = !empty($hasil);
@endphp
<div class="step-bar">
  <div class="step-item {{ $allDone ? 'done' : 'active' }}">
    <div class="step-num">{{ $allDone ? '✓' : '1' }}</div>
    <div class="step-label">Isi Matriks Perbandingan</div>
  </div>
  <div class="step-arrow">›</div>
  <div class="step-item {{ $allDone ? 'done' : ($hasilAda ? 'active' : 'inactive') }}">
    <div class="step-num">{{ $allDone ? '✓' : '2' }}</div>
    <div class="step-label">Normalisasi & Bobot</div>
  </div>
  <div class="step-arrow">›</div>
  <div class="step-item {{ $allDone ? 'done' : ($hasilAda ? 'active' : 'inactive') }}">
    <div class="step-num">{{ $allDone ? '✓' : '3' }}</div>
    <div class="step-label">Uji Konsistensi (CR)</div>
  </div>
  <div class="step-arrow">›</div>
  <div class="step-item {{ $allDone ? 'done' : 'inactive' }}">
    <div class="step-num">{{ $allDone ? '✓' : '4' }}</div>
    <div class="step-label">Simpan Bobot</div>
  </div>
</div>

{{-- ══════════════════════════════════════
     PANDUAN SKALA SAATY
════════════════════════════════════════ --}}
<div class="ahp-card">
  <div class="card-stripe stripe-blue"></div>
  <div class="card-head">
    <div class="card-head-icon" style="background:#eff6ff">📖</div>
    <div class="card-head-text">
      <div class="card-head-title">Panduan Skala Perbandingan Saaty</div>
      <div class="card-head-sub">Gunakan acuan berikut saat mengisi nilai perbandingan antar kriteria — nilai 1/x diisi otomatis oleh sistem</div>
    </div>
    <div class="card-head-badge" style="background:#eff6ff;color:var(--accent);border:1.5px solid #bfdbfe">Referensi</div>
  </div>
  <div class="card-body">
    <div class="skala-grid">
      <div class="skala-chip sk-1"><div class="sc-num">1</div><div class="sc-info"><div class="sc-name">Sama Penting</div><div class="sc-desc">Kedua kriteria memiliki kepentingan yang setara</div></div></div>
      <div class="skala-chip sk-2"><div class="sc-num">2</div><div class="sc-info"><div class="sc-name">Antara 1 dan 3</div><div class="sc-desc">Nilai tengah antara sama dan sedikit lebih penting</div></div></div>
      <div class="skala-chip sk-3"><div class="sc-num">3</div><div class="sc-info"><div class="sc-name">Sedikit Lebih Penting</div><div class="sc-desc">Satu kriteria sedikit lebih penting dari yang lain</div></div></div>
      <div class="skala-chip sk-4"><div class="sc-num">4</div><div class="sc-info"><div class="sc-name">Antara 3 dan 5</div><div class="sc-desc">Nilai tengah antara sedikit dan cukup penting</div></div></div>
      <div class="skala-chip sk-5"><div class="sc-num">5</div><div class="sc-info"><div class="sc-name">Cukup Lebih Penting</div><div class="sc-desc">Satu kriteria cukup lebih penting dibanding yang lain</div></div></div>
      <div class="skala-chip sk-6"><div class="sc-num">6</div><div class="sc-info"><div class="sc-name">Antara 5 dan 7</div><div class="sc-desc">Nilai tengah antara cukup dan sangat penting</div></div></div>
      <div class="skala-chip sk-7"><div class="sc-num">7</div><div class="sc-info"><div class="sc-name">Sangat Lebih Penting</div><div class="sc-desc">Satu kriteria sangat lebih penting dari yang lain</div></div></div>
      <div class="skala-chip sk-8"><div class="sc-num">8</div><div class="sc-info"><div class="sc-name">Antara 7 dan 9</div><div class="sc-desc">Nilai tengah antara sangat dan mutlak penting</div></div></div>
      <div class="skala-chip sk-9"><div class="sc-num">9</div><div class="sc-info"><div class="sc-name">Mutlak Sangat Penting</div><div class="sc-desc">Satu kriteria mutlak jauh lebih penting dari yang lain</div></div></div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     FORM — dibuka di sini, ditutup setelah save section
════════════════════════════════════════ --}}
<form method="POST" action="{{ route('ahp.hitung') }}" id="form-ahp">
@csrf

{{-- ══════════════════════════════════════
     LANGKAH 1 — MATRIKS PERBANDINGAN BERPASANGAN
════════════════════════════════════════ --}}
<div class="ahp-card">
  <div class="card-stripe stripe-blue"></div>
  <div class="card-head">
    <div class="card-head-icon" style="background:#eff6ff">📊</div>
    <div class="card-head-text">
      <div class="card-head-title">Langkah 1 — Matriks Perbandingan Berpasangan</div>
      <div class="card-head-sub">Isi sel di <strong>atas diagonal</strong>. Diagonal = 1 (konstan). Bawah diagonal = kebalikan otomatis.</div>
    </div>
    <div class="card-head-badge" style="background:#eff6ff;color:var(--accent);border:1.5px solid #bfdbfe">
      {{ $n }}×{{ $n }} Matriks
    </div>
  </div>
  <div class="card-body">
    <div class="table-scroll">
      <table class="matrix-table" id="matrix-table">
        <thead>
          <tr>
            <th class="th-row-label">Nama Kriteria</th>
            @foreach($kriterias as $k)
              <th>
                <span style="font-family:var(--mono);color:var(--accent);font-size:11px">{{ $k->kode }}</span><br>
                <span style="font-weight:500;font-size:10px;color:var(--ink-3)">{{ Str::limit($k->nama,12) }}</span>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($kriterias as $i => $ki)
          <tr>
            <td class="td-row-label">
              <span class="k-code">{{ $ki->kode }}</span>
              <span class="k-name">{{ Str::limit($ki->nama, 16) }}</span>
            </td>
            @foreach($kriterias as $j => $kj)
              @if($i === $j)
                <td class="cell-diag">1</td>
              @elseif($i < $j)
                @php
                  $savedVal = 1;
                  if (!empty($matrix[$i][$j])) {
                    $v = (float) $matrix[$i][$j];
                    // Cari nilai integer terdekat yang cocok (1–9)
                    $savedVal = ($v >= 1) ? (int) round($v) : $v;
                  }
                @endphp
                <td class="cell-input">
                  <select name="matrix[{{ $i }}][{{ $j }}]"
                          id="sel_{{ $i }}_{{ $j }}"
                          onchange="updateReciprocal({{ $i }},{{ $j }},this.value); recalculate()">
                    <option value="1" {{ $savedVal==1?'selected':'' }}>1 — Sama Penting</option>
                    <option value="2" {{ $savedVal==2?'selected':'' }}>2 — Antara 1 & 3</option>
                    <option value="3" {{ $savedVal==3?'selected':'' }}>3 — Sedikit lebih penting</option>
                    <option value="4" {{ $savedVal==4?'selected':'' }}>4 — Antara 3 & 5</option>
                    <option value="5" {{ $savedVal==5?'selected':'' }}>5 — Cukup lebih penting</option>
                    <option value="6" {{ $savedVal==6?'selected':'' }}>6 — Antara 5 & 7</option>
                    <option value="7" {{ $savedVal==7?'selected':'' }}>7 — Sangat lebih penting</option>
                    <option value="8" {{ $savedVal==8?'selected':'' }}>8 — Antara 7 & 9</option>
                    <option value="9" {{ $savedVal==9?'selected':'' }}>9 — Mutlak lebih penting</option>
                  </select>
                </td>
              @else
                <td class="cell-recip" id="rec_{{ $i }}_{{ $j }}">—</td>
              @endif
            @endforeach
          </tr>
          @endforeach

          {{-- Baris Σ Kolom --}}
          <tr class="row-colsum">
            <td class="td-sum-label">Σ Kolom (Total)</td>
            @foreach($kriterias as $j => $kj)
              <td id="colsum_{{ $j }}">—</td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     LANGKAH 2 — NORMALISASI & PRIORITAS
     (Sesuai struktur Excel Sheet AHP)
════════════════════════════════════════ --}}
<div class="ahp-card">
  <div class="card-stripe stripe-purple"></div>
  <div class="card-head">
    <div class="card-head-icon" style="background:var(--pur-bg)">🔢</div>
    <div class="card-head-text">
      <div class="card-head-title">Langkah 2 — Proses Sintesis</div>
      <div class="card-head-sub">2.2 Normalisasi matriks (tiap sel / Σ kolom) → 2.3 Nilai prioritas = rata-rata baris normalisasi</div>
    </div>
  </div>
  <div class="card-body">

    <div class="section-divider">2.2 Normalisasi Matriks</div>
    <div class="table-scroll" style="margin-bottom:20px">
      <table class="excel-table" id="norm-table">
        <thead>
          <tr>
            <th class="th-label">Nama Kriteria</th>
            @foreach($kriterias as $k)
              <th>{{ $k->kode }}</th>
            @endforeach
            <th style="background:#eff6ff;color:var(--accent)">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kriterias as $i => $ki)
          <tr>
            <td class="td-label">
              <span class="k-code">{{ $ki->kode }}</span>{{ Str::limit($ki->nama,16) }}
            </td>
            @foreach($kriterias as $j => $kj)
              <td id="norm_{{ $i }}_{{ $j }}">—</td>
            @endforeach
            <td id="norm_row_{{ $i }}" style="background:linear-gradient(135deg,#eff6ff,#e0e7ff);font-weight:700;color:var(--accent);">—</td>
          </tr>
          @endforeach
          <tr class="tr-total">
            <td class="td-label">Total</td>
            @foreach($kriterias as $j => $kj)
              <td id="norm_col_total_{{ $j }}">—</td>
            @endforeach
            <td>—</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="section-divider">2.3 Nilai Prioritas (Bobot)</div>
    <div class="table-scroll">
      <table class="excel-table" id="priority-table">
        <thead>
          <tr>
            <th class="th-label">Nama Kriteria</th>
            <th class="th-result">Jumlah Baris</th>
            <th class="th-result">Prioritas (Bobot)</th>
            <th class="th-pct">Persentase (%)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kriterias as $i => $ki)
          <tr>
            <td class="td-label">
              <span class="k-code">{{ $ki->kode }}</span>{{ Str::limit($ki->nama,16) }}
            </td>
            <td class="td-result" id="bobot_jumlah_{{ $i }}">—</td>
            <td class="td-result" id="bobot_{{ $i }}">—</td>
            <td class="td-pct"   id="persen_{{ $i }}">—</td>
          </tr>
          @endforeach
          <tr class="tr-total">
            <td class="td-label">Total</td>
            <td class="td-result" id="total_bobot_jumlah">—</td>
            <td class="td-result" id="total_bobot">—</td>
            <td class="td-pct">100%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     LANGKAH 3 — UJI KONSISTENSI
     (Sesuai struktur Excel: 3.1 + 3.2 + Rekap)
════════════════════════════════════════ --}}
<div class="ahp-card">
  <div class="card-stripe stripe-green"></div>
  <div class="card-head">
    <div class="card-head-icon" style="background:var(--green-bg)">📈</div>
    <div class="card-head-text">
      <div class="card-head-title">Langkah 3 — Ukur Konsistensi</div>
      <div class="card-head-sub">3.1 Kalikan matriks × prioritas → 3.2 Hitung λmax, CI, CR — syarat: CR ≤ 0,10</div>
    </div>
    <div class="card-head-badge" style="background:var(--green-bg);color:var(--green);border:1.5px solid var(--green-bd)">
      CR ≤ 0,10 → OK
    </div>
  </div>
  <div class="card-body">

    {{-- 3.1 Matriks × Prioritas --}}
    <div class="section-divider">3.1 Kalikan Matriks Perbandingan dengan Prioritas (A × W)</div>
    <div class="table-scroll" style="margin-bottom:20px">
      <table class="excel-table" id="aw-table">
        <thead>
          <tr>
            <th class="th-label">Nama Kriteria</th>
            @foreach($kriterias as $k)
              <th>{{ $k->kode }}</th>
            @endforeach
            <th class="th-result">Jumlah (A×W)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kriterias as $i => $ki)
          <tr>
            <td class="td-label">
              <span class="k-code">{{ $ki->kode }}</span>{{ Str::limit($ki->nama,16) }}
            </td>
            @foreach($kriterias as $j => $kj)
              <td id="aw_{{ $i }}_{{ $j }}">—</td>
            @endforeach
            <td class="td-result" id="aw_row_{{ $i }}">—</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- 3.2 Hasil (Jumlah/Prioritas) --}}
    <div class="section-divider">3.2 Hasil = (A×W) / Prioritas</div>
    <div class="table-scroll" style="margin-bottom:20px">
      <table class="excel-table" id="lambda-table">
        <thead>
          <tr>
            <th class="th-label">Nama Kriteria</th>
            <th class="th-result">Jumlah (A×W)</th>
            <th class="th-result">Prioritas</th>
            <th class="th-result" style="background:#fffbeb;color:var(--yellow);">Hasil (λ)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kriterias as $i => $ki)
          <tr>
            <td class="td-label">
              <span class="k-code">{{ $ki->kode }}</span>{{ Str::limit($ki->nama,16) }}
            </td>
            <td class="td-result" id="lambda_aw_{{ $i }}">—</td>
            <td class="td-result" id="lambda_w_{{ $i }}">—</td>
            <td id="lambda_val_{{ $i }}" style="background:#fffbeb;font-weight:700;color:var(--yellow);">—</td>
          </tr>
          @endforeach
          <tr class="tr-total">
            <td class="td-label">Total</td>
            <td class="td-result" id="lambda_aw_total">—</td>
            <td class="td-result">—</td>
            <td style="background:#fffbeb;font-weight:800;color:var(--yellow);" id="lambda_total">—</td>
          </tr>
        </tbody>
      </table>
    </div>

    {{-- Rekap λmax, CI, CR --}}
    <div class="section-divider">Rekap Hasil Uji Konsistensi</div>
    <div class="stats-4">
      <div class="stat-box sb-blue">
        <div class="sb-label">Jumlah Kriteria (n)</div>
        <div class="sb-val">{{ $n }}</div>
        <div class="sb-desc">Ordo matriks perbandingan</div>
      </div>
      <div class="stat-box sb-yellow">
        <div class="sb-label">λ max</div>
        <div class="sb-val" id="stat-lambda">—</div>
        <div class="sb-desc">Rata-rata nilai eigen</div>
      </div>
      <div class="stat-box sb-blue">
        <div class="sb-label">CI</div>
        <div class="sb-val" id="stat-ci">—</div>
        <div class="sb-desc">(λmax − n) / (n − 1)</div>
      </div>
      <div class="stat-box sb-purple">
        <div class="sb-label">RI (n={{ $n }})</div>
        <div class="sb-val">{{ number_format($ri[$n] ?? 1.24, 2) }}</div>
        <div class="sb-desc">Nilai Indeks Random</div>
      </div>
    </div>

    <div class="cr-banner state-wait" id="cr-banner">
      <span class="cr-icon" id="cr-icon">⏳</span>
      <div class="cb-body">
        <div class="cb-title" id="cr-title">Menunggu Input Matriks</div>
        <div class="cb-sub"  id="cr-text">Isi nilai perbandingan pada matriks di atas untuk melihat hasil uji konsistensi secara real-time.</div>
      </div>
      <div class="cr-val" id="cr-val">—</div>
    </div>

    <div class="formula-strip">
      <div class="f-item"><span>λmax</span><span class="f-eq">= Σ Hasil / n</span></div>
      <div class="f-item"><span>CI</span><span class="f-eq">= (λmax − n) / (n − 1)</span></div>
      <div class="f-item"><span>CR</span><span class="f-eq">= CI / RI</span></div>
      <div class="f-item"><span class="f-ok">CR ≤ 0,10 ✔ Konsisten</span></div>
      <div class="f-item"><span class="f-fail">CR > 0,10 ✖ Tidak Konsisten</span></div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     PERINGKAT BOBOT
════════════════════════════════════════ --}}
<div class="ahp-card">
  <div class="card-stripe stripe-yellow"></div>
  <div class="card-head">
    <div class="card-head-icon" style="background:var(--yel-bg)">🏆</div>
    <div class="card-head-text">
      <div class="card-head-title">Peringkat Bobot Prioritas Kriteria</div>
      <div class="card-head-sub">Kriteria diurutkan dari bobot tertinggi ke terendah</div>
    </div>
  </div>
  <div class="card-body" id="rank-body">
    <div style="text-align:center;color:var(--ink-3);padding:24px 0;font-size:13px">
      ⏳ Isi matriks perbandingan untuk melihat peringkat bobot kriteria
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════
     SAVE SECTION
     FIX UTAMA: warna & teks berubah dari PHP
     berdasarkan $bobotTersimpan (bukan session)
     → tetap hijau setelah refresh
════════════════════════════════════════ --}}
<div class="save-section {{ $bobotTersimpan ? 'state-saved' : 'state-unsaved' }}" id="save-section">
  <div class="save-info">
    @if($bobotTersimpan)
      <div class="saved-badge">✅ Bobot Tersimpan</div>
    @endif
    <div class="si-title">
      {{ $bobotTersimpan ? '✅ Bobot AHP Sudah Tersimpan' : '💾 Simpan Bobot Prioritas' }}
    </div>
    <div class="si-sub">
      @if($bobotTersimpan)
        Bobot sudah tersimpan dan siap digunakan pada perhitungan SMART.
        Anda dapat mengubah matriks dan menyimpan ulang kapan saja.
      @else
        Pastikan CR ≤ 0,10 sebelum menyimpan. Bobot yang tersimpan akan digunakan
        pada tahap perhitungan SMART untuk perankingan siswa terbaik.
      @endif
    </div>
  </div>
  <div class="save-actions">
    <button type="button" class="btn btn-secondary" onclick="resetMatrix()">
      ↺ Reset Matriks
    </button>
    {{-- FIX: id="btn-save" digunakan JS untuk enable/disable berdasarkan CR --}}
    <button type="button"
            class="btn {{ $bobotTersimpan ? 'btn-success' : 'btn-primary' }}"
            onclick="submitForm()"
            id="btn-save"
            @if(!$bobotTersimpan) disabled @endif>
      {{ $bobotTersimpan ? '🔄 Perbarui Bobot AHP' : '💾 Simpan Bobot AHP' }}
    </button>
  </div>
</div>

{{-- </form> ditutup di sini — SETELAH save section --}}
</form>

@endif
</div>{{-- end .ahp-wrap --}}

@if(!$kriterias->isEmpty())
<script>
  // ─── Konstanta dari PHP ───
  const N         = {{ $n }};
  const RI_TABLE  = {!! json_encode($ri) !!};
  const RI        = RI_TABLE[N] ?? 1.49;
  const KRITERIAS = {!! json_encode($kriterias->map(fn($k)=>['id'=>$k->id,'kode'=>$k->kode,'nama'=>$k->nama])->values()->toArray()) !!};

  // ─── Matriks state (diisi dari DB lewat PHP) ───
  // FIX UTAMA: matrix diinisialisasi dari nilai $matrix (tersimpan di DB)
  // sehingga saat refresh, select menampilkan nilai yang benar
  let matrix = Array.from({length:N}, (_,i) =>
    Array.from({length:N}, (_,j) => {
      @if(!empty($matrix))
        const saved = {!! json_encode($matrix) !!};
        if (saved[i] && saved[i][j] !== undefined) return parseFloat(saved[i][j]);
      @endif
      return 1.0;
    })
  );

  // ─── INIT ───
  function initMatrix() {
    for (let i = 0; i < N; i++) {
      for (let j = i+1; j < N; j++) {
        const sel = document.getElementById(`sel_${i}_${j}`);
        if (sel) {
          const v = parseFloat(sel.value);
          matrix[i][j] = v;
          matrix[j][i] = 1 / v;
          updateReciprocal(i, j, v);
        }
      }
    }
    recalculate();
  }

  // ─── UPDATE RECIPROCAL ───
  function updateReciprocal(i, j, val) {
    const v      = parseFloat(val) || 1;
    matrix[i][j] = v;
    matrix[j][i] = v === 0 ? 1 : 1 / v;
    const cell   = document.getElementById(`rec_${j}_${i}`);
    if (cell) {
      if (v === 1) {
        cell.textContent = '1';
      } else if (v > 1) {
        cell.textContent = '1/' + Math.round(v);
      } else {
        cell.textContent = (1/v).toFixed(0);
      }
    }
  }

  // ─── RECALCULATE (sesuai alur Excel) ───
  function recalculate() {
    // Sync matrix dari select
    for (let i=0; i<N; i++) for (let j=i+1; j<N; j++) {
      const sel = document.getElementById(`sel_${i}_${j}`);
      if (sel) {
        const v = parseFloat(sel.value) || 1;
        matrix[i][j] = v;
        matrix[j][i] = 1 / v;
        updateReciprocal(i, j, v);
      }
    }

    // ── Langkah 2.1: Σ Kolom ──
    const colSum = Array(N).fill(0);
    for (let j=0; j<N; j++) {
      for (let i=0; i<N; i++) colSum[j] += matrix[i][j];
      const el = document.getElementById(`colsum_${j}`);
      if (el) el.textContent = colSum[j].toFixed(4);
    }

    // ── Langkah 2.2: Normalisasi ──
    const norm = Array.from({length:N}, () => Array(N).fill(0));
    for (let i=0; i<N; i++) {
      for (let j=0; j<N; j++) {
        norm[i][j] = colSum[j] > 0 ? matrix[i][j] / colSum[j] : 0;
        const el = document.getElementById(`norm_${i}_${j}`);
        if (el) el.textContent = norm[i][j].toFixed(4);
      }
      // Jumlah kolom per baris normalisasi
      const rowEl = document.getElementById(`norm_row_${i}`);
      if (rowEl) rowEl.textContent = norm[i].reduce((a,b)=>a+b,0).toFixed(4);
    }

    // Total kolom normalisasi (seharusnya ≈1 tiap kolom)
    for (let j=0; j<N; j++) {
      let colTot = 0;
      for (let i=0; i<N; i++) colTot += norm[i][j];
      const el = document.getElementById(`norm_col_total_${j}`);
      if (el) el.textContent = colTot.toFixed(4);
    }

    // ── Langkah 2.3: Bobot (rata-rata baris normalisasi) ──
    const bobot    = Array(N).fill(0);
    const rowNorm  = Array(N).fill(0);
    for (let i=0; i<N; i++) {
      rowNorm[i] = norm[i].reduce((a,b)=>a+b, 0);
      bobot[i]   = rowNorm[i] / N;

      const elJ = document.getElementById(`bobot_jumlah_${i}`);
      const elB = document.getElementById(`bobot_${i}`);
      const elP = document.getElementById(`persen_${i}`);
      if (elJ) elJ.textContent = rowNorm[i].toFixed(6);
      if (elB) elB.textContent = bobot[i].toFixed(6);
      if (elP) elP.textContent = (bobot[i]*100).toFixed(2) + '%';
    }

    // Total bobot (harus = 1)
    const totalBobot = bobot.reduce((a,b)=>a+b,0);
    const elTB  = document.getElementById('total_bobot');
    const elTBJ = document.getElementById('total_bobot_jumlah');
    if (elTB)  elTB.textContent  = totalBobot.toFixed(6);
    if (elTBJ) elTBJ.textContent = rowNorm.reduce((a,b)=>a+b,0).toFixed(6);

    // ── Langkah 3.1: A × W ──
    const matTimesW = Array(N).fill(0);
    for (let i=0; i<N; i++) {
      for (let j=0; j<N; j++) {
        const awVal = matrix[i][j] * bobot[j];
        const el    = document.getElementById(`aw_${i}_${j}`);
        if (el) el.textContent = awVal.toFixed(6);
        matTimesW[i] += awVal;
      }
      const elRow = document.getElementById(`aw_row_${i}`);
      if (elRow) elRow.textContent = matTimesW[i].toFixed(6);
    }

    // ── Langkah 3.2: Hasil = (A×W) / W ──
    const lambdaVals = Array(N).fill(0);
    for (let i=0; i<N; i++) {
      lambdaVals[i] = bobot[i] > 0 ? matTimesW[i] / bobot[i] : 0;

      const elAW = document.getElementById(`lambda_aw_${i}`);
      const elW  = document.getElementById(`lambda_w_${i}`);
      const elL  = document.getElementById(`lambda_val_${i}`);
      if (elAW) elAW.textContent = matTimesW[i].toFixed(6);
      if (elW)  elW.textContent  = bobot[i].toFixed(6);
      if (elL)  elL.textContent  = lambdaVals[i].toFixed(6);
    }

    const totalLambda = lambdaVals.reduce((a,b)=>a+b, 0);
    const totalAW     = matTimesW.reduce((a,b)=>a+b, 0);
    const elLT  = document.getElementById('lambda_total');
    const elLAT = document.getElementById('lambda_aw_total');
    if (elLT)  elLT.textContent  = totalLambda.toFixed(6);
    if (elLAT) elLAT.textContent = totalAW.toFixed(6);

    // ── λmax, CI, CR ──
    const lambdaMax = totalLambda / N;
    const ci        = N > 1 ? (lambdaMax - N) / (N - 1) : 0;
    const cr        = RI > 0 ? ci / RI : 0;

    const elLambda = document.getElementById('stat-lambda');
    const elCI     = document.getElementById('stat-ci');
    if (elLambda) elLambda.textContent = lambdaMax.toFixed(4);
    if (elCI)     elCI.textContent     = ci.toFixed(4);

    // CR Banner
    const banner  = document.getElementById('cr-banner');
    const crIcon  = document.getElementById('cr-icon');
    const crTitle = document.getElementById('cr-title');
    const crText  = document.getElementById('cr-text');
    const crVal   = document.getElementById('cr-val');
    if (crVal) crVal.textContent = cr.toFixed(4);

    const btnSave   = document.getElementById('btn-save');
    const saveSec   = document.getElementById('save-section');

    if (cr <= 0.10) {
      if (banner) banner.className = 'cr-banner state-ok';
      if (crIcon)  crIcon.textContent  = '✅';
      if (crTitle) crTitle.textContent = 'Penilaian KONSISTEN';
      if (crText)  crText.innerHTML    = `CR = <strong>${cr.toFixed(4)}</strong> ≤ 0,10 — Bobot valid, siap disimpan.`;
      if (btnSave) {
        btnSave.disabled     = false;
        btnSave.style.opacity = '1';
      }
    } else {
      if (banner) banner.className = 'cr-banner state-fail';
      if (crIcon)  crIcon.textContent  = '❌';
      if (crTitle) crTitle.textContent = 'Penilaian TIDAK KONSISTEN';
      if (crText)  crText.innerHTML    = `CR = <strong>${cr.toFixed(4)}</strong> > 0,10 — Revisi nilai perbandingan.`;
      if (btnSave) {
        btnSave.disabled      = true;
        btnSave.style.opacity = '0.45';
      }
    }

    // ── Ranking ──
    const ranked = KRITERIAS
      .map((k,i) => ({...k, bobot: bobot[i], pct: bobot[i] * 100}))
      .sort((a,b) => b.bobot - a.bobot);
    const maxB = ranked[0]?.bobot || 1;
    const rankBody = document.getElementById('rank-body');
    if (rankBody) {
      rankBody.innerHTML =
        `<div class="rank-list">` +
        ranked.map((item, idx) => `
          <div class="rank-row">
            <div class="rank-num">${idx+1}</div>
            <div class="rank-kode">${item.kode}</div>
            <div class="rank-name">${item.nama}</div>
            <div class="rank-bar-wrap">
              <div class="rank-bar" style="width:${(item.bobot/maxB*100).toFixed(1)}%">
                <span>${item.pct.toFixed(1)}%</span>
              </div>
            </div>
            <div class="rank-pct">${item.pct.toFixed(2)}%</div>
          </div>`).join('') +
        `</div>`;
    }
  }

  // ─── RESET ───
  function resetMatrix() {
    if (!confirm('Reset semua nilai matriks ke 1 (Sama Penting)?')) return;
    matrix = Array.from({length:N}, () => Array(N).fill(1));
    document.querySelectorAll('[id^="sel_"]').forEach(sel => sel.value = '1');
    for (let i=0; i<N; i++) for (let j=i+1; j<N; j++) updateReciprocal(i, j, 1);
    recalculate();
  }

  // ─── SUBMIT ───
  function submitForm() {
    const crText = document.getElementById('cr-val')?.textContent ?? '';
    const cr     = parseFloat(crText);
    if (isNaN(cr)) {
      alert('Silakan tunggu perhitungan selesai.');
      return;
    }
    if (cr > 0.10) {
      alert('Matriks belum konsisten.\n\nCR = ' + cr.toFixed(4) + '\n\nCR harus ≤ 0,10.\nSilakan revisi nilai perbandingan antar kriteria.');
      return;
    }
    document.getElementById('form-ahp').submit();
  }

  // ─── INIT saat DOM siap ───
  document.addEventListener('DOMContentLoaded', initMatrix);
</script>
@endif
@endsection