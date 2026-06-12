@extends('layouts.app')

@section('title', 'Kriteria & Parameter - SPK Siswa Terbaik')
@section('page-title', 'Kriteria & Parameter')
@section('page-subtitle', 'Kelola kriteria penilaian dan level Parameter untuk metode AHP & SMART')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --ink:         #0f1623;
    --ink-2:       #3d4a5c;
    --ink-3:       #7a8899;
    --surface:     #ffffff;
    --surface-2:   #f6f8fc;
    --surface-3:   #eef1f8;
    --border:      #e2e8f4;
    --border-2:    #c8d3e8;
    --accent:      #2563eb;
    --accent-2:    #1d4ed8;
    --accent-glow: rgba(37,99,235,0.12);
    --green:       #059669;
    --green-bg:    #ecfdf5;
    --green-bd:    #a7f3d0;
    --red:         #dc2626;
    --red-bg:      #fef2f2;
    --red-bd:      #fca5a5;
    --yellow:      #d97706;
    --yellow-bg:   #fffbeb;
    --yellow-bd:   #fde68a;
    --purple:      #7c3aed;
    --purple-bg:   #f5f3ff;
    --purple-bd:   #ddd6fe;
    --mono:        'JetBrains Mono', monospace;
    --sans:        'Plus Jakarta Sans', sans-serif;
    --radius-sm:   8px;
    --radius:      14px;
    --radius-lg:   20px;
    --shadow-sm:   0 1px 3px rgba(15,22,35,0.06), 0 1px 2px rgba(15,22,35,0.04);
    --shadow:      0 4px 12px rgba(15,22,35,0.07), 0 1px 3px rgba(15,22,35,0.05);
    --shadow-lg:   0 12px 32px rgba(15,22,35,0.10), 0 4px 8px rgba(15,22,35,0.06);
    --shadow-xl:   0 24px 64px rgba(15,22,35,0.14), 0 8px 16px rgba(15,22,35,0.08);
  }

  * { font-family: var(--sans); box-sizing: border-box; }

  .kriteria-page-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
  }

  /* ══════════════════════════════════════════
     PAGE HEADER — terintegrasi, profesional
  ══════════════════════════════════════════ */
  .page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }
  .page-header-left {}
  .page-header-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.2;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .page-header-title .title-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #2563eb, #6366f1);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(37,99,235,.25);
  }
  .page-header-subtitle {
    font-size: 13px;
    color: var(--ink-3);
    margin: 0;
    padding-left: 46px;
    line-height: 1.5;
  }
  .page-header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    padding-top: 4px;
  }
  .btn-add-main {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .18s;
    box-shadow: 0 2px 10px rgba(37,99,235,.35);
    white-space: nowrap;
    font-family: var(--sans);
    letter-spacing: .1px;
  }
  .btn-add-main:hover {
    background: var(--accent-2);
    box-shadow: 0 6px 20px rgba(37,99,235,.45);
    transform: translateY(-1px);
  }
  .btn-add-main svg {
    width: 16px; height: 16px;
    stroke: #fff;
    flex-shrink: 0;
  }
  .page-divider {
    border: none;
    border-top: 1.5px solid var(--border);
    margin: 0 0 24px;
  }

  /* ══════════════════════════════════════════
     INFO BANNER
  ══════════════════════════════════════════ */
  .info-banner {
    background: linear-gradient(135deg, #eff6ff 0%, #f0f4ff 100%);
    border: 1.5px solid #bfdbfe;
    border-radius: var(--radius);
    padding: 14px 18px;
    margin-bottom: 24px;
    display: flex; align-items: flex-start; gap: 12px;
    font-size: 13px; color: #1e40af; line-height: 1.65;
    position: relative; overflow: hidden;
    width: 100%;
  }
  .info-banner::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, #2563eb, #6366f1, #0891b2);
  }
  .info-banner .info-icon { font-size: 16px; margin-top: 2px; flex-shrink: 0; }

  /* ══════════════════════════════════════════
     STATS ROW
  ══════════════════════════════════════════ */
  .stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 28px;
    width: 100%;
  }
  .stat-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 16px;
    box-shadow: var(--shadow-sm);
    display: flex; align-items: center; gap: 12px;
    position: relative; overflow: hidden;
    transition: box-shadow .2s, transform .2s;
    min-width: 0;
  }
  .stat-card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
  .stat-card::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    border-radius: 0 0 var(--radius) var(--radius);
  }
  .stat-card.s-blue::after   { background: linear-gradient(90deg, #2563eb, #6366f1); }
  .stat-card.s-green::after  { background: linear-gradient(90deg, #059669, #10b981); }
  .stat-card.s-yellow::after { background: linear-gradient(90deg, #d97706, #f59e0b); }
  .stat-card.s-purple::after { background: linear-gradient(90deg, #7c3aed, #a855f7); }

  .stat-icon-wrap {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
  }
  .s-blue   .stat-icon-wrap { background: #eff6ff; }
  .s-green  .stat-icon-wrap { background: #ecfdf5; }
  .s-yellow .stat-icon-wrap { background: #fffbeb; }
  .s-purple .stat-icon-wrap { background: #f5f3ff; }

  .stat-info { min-width: 0; flex: 1; }
  .stat-val { font-size: 26px; font-weight: 800; color: var(--ink); line-height: 1; font-family: var(--mono); }
  .stat-lbl { font-size: 11px; color: var(--ink-3); margin-top: 3px; font-weight: 600; letter-spacing: .3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  /* ══════════════════════════════════════════
     SECTION HEADER
  ══════════════════════════════════════════ */
  .section-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px; flex-wrap: wrap; gap: 8px;
  }
  .section-title {
    font-size: 14px; font-weight: 800; color: var(--ink);
    display: flex; align-items: center; gap: 8px;
  }
  .section-title::before {
    content: '';
    width: 4px; height: 18px; background: var(--accent);
    border-radius: 2px; display: inline-block; flex-shrink: 0;
  }
  .section-count {
    font-size: 11px; font-weight: 700; color: var(--ink-3);
    background: var(--surface-3); border: 1px solid var(--border);
    padding: 3px 10px; border-radius: 20px; white-space: nowrap;
  }

  /* ══════════════════════════════════════════
     CRITERIA GRID
  ══════════════════════════════════════════ */
  .criteria-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    width: 100%;
  }
  @media (min-width: 1100px) {
    .criteria-grid { grid-template-columns: repeat(2, 1fr); }
  }

  /* ══════════════════════════════════════════
     CRITERIA CARD
  ══════════════════════════════════════════ */
  .criteria-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s, border-color .2s;
    display: flex; flex-direction: column;
    width: 100%; min-width: 0;
  }
  .criteria-card:hover { box-shadow: var(--shadow-lg); border-color: var(--border-2); transform: translateY(-3px); }

  .card-strip { height: 4px; background: linear-gradient(90deg, var(--strip-a), var(--strip-b)); flex-shrink: 0; }

  .card-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    padding: 16px 18px 14px; border-bottom: 1.5px solid var(--border);
    gap: 10px; flex-wrap: nowrap; min-width: 0;
  }
  .card-header-left {
    display: flex; align-items: flex-start; gap: 10px;
    flex: 1; min-width: 0;
  }
  .c-badge {
    width: 38px; height: 38px; border-radius: 10px;
    color: #fff; font-size: 12px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-family: var(--mono);
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
  }
  .c-meta { flex: 1; min-width: 0; }
  .c-name {
    font-size: 14px; font-weight: 800; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3;
  }
  .c-desc-preview {
    font-size: 11.5px; color: var(--ink-3); margin-top: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4;
  }
  .card-header-right {
    display: flex; align-items: center; gap: 5px; flex-shrink: 0;
  }
  .tag-type {
    font-size: 10px; font-weight: 700; padding: 3px 8px;
    border-radius: 20px; border: 1.5px solid; letter-spacing: .3px;
    text-transform: uppercase; white-space: nowrap;
  }
  .tag-benefit { background: var(--green-bg); color: var(--green); border-color: var(--green-bd); }
  .tag-cost    { background: var(--red-bg);   color: var(--red);   border-color: var(--red-bd);   }

  .action-btn {
    background: var(--surface-2); border: 1.5px solid var(--border);
    cursor: pointer; width: 32px; height: 32px; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; transition: all .15s; color: var(--ink-3); flex-shrink: 0;
  }
  .action-btn:hover        { background: var(--surface-3); color: var(--ink); border-color: var(--border-2); }
  .action-btn.danger:hover { background: var(--red-bg); color: var(--red); border-color: var(--red-bd); }
  .action-btn.edit:hover   { background: var(--accent-glow); color: var(--accent); border-color: #bfdbfe; }

  .card-body {
    padding: 14px 16px; display: flex; flex-direction: column;
    gap: 8px; flex: 1;
  }
  .card-body-label {
    font-size: 10.5px; font-weight: 700; color: var(--ink-3);
    letter-spacing: .6px; text-transform: uppercase; margin-bottom: 2px;
  }

  .sub-item {
    display: flex; align-items: center; gap: 12px;
    border-radius: 10px; padding: 10px 14px;
    border: 1.5px solid transparent; transition: transform .12s; min-width: 0;
  }
  .sub-item:hover { transform: translateX(3px); }
  .sub-item.l4 { background: #f0fdf4; border-color: #a7f3d0; }
  .sub-item.l3 { background: #eff6ff; border-color: #bfdbfe; }
  .sub-item.l2 { background: #fffbeb; border-color: #fde68a; }
  .sub-item.l1 { background: #fef2f2; border-color: #fca5a5; }

  .level-pill {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0; font-family: var(--mono);
  }
  .l4 .level-pill { background: rgba(5,150,105,.12); }
  .l3 .level-pill { background: rgba(37,99,235,.10); }
  .l2 .level-pill { background: rgba(217,119,6,.10); }
  .l1 .level-pill { background: rgba(220,38,38,.10); }
  .level-pill .lp-tag { font-size: 8.5px; font-weight: 700; letter-spacing: .5px; line-height: 1; }
  .level-pill .lp-num { font-size: 18px; font-weight: 800; line-height: 1.1; }
  .l4 .lp-tag, .l4 .lp-num { color: #059669; }
  .l3 .lp-tag, .l3 .lp-num { color: #2563eb; }
  .l2 .lp-tag, .l2 .lp-num { color: #d97706; }
  .l1 .lp-tag, .l1 .lp-num { color: #dc2626; }

  .sub-text { flex: 1; min-width: 0; }
  .sub-text .sub-title {
    font-size: 12.5px; font-weight: 700; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .sub-text .sub-desc {
    font-size: 11px; color: var(--ink-3); margin-top: 2px; line-height: 1.4;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .sub-empty {
    text-align: center; padding: 20px; color: var(--ink-3); font-size: 12.5px;
    background: var(--surface-2); border-radius: 10px; border: 1.5px dashed var(--border-2);
  }

  .card-footer {
    padding: 10px 16px; border-top: 1.5px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    background: var(--surface-2); flex-wrap: wrap; gap: 8px; flex-shrink: 0;
  }
  .card-sub-count {
    font-size: 11px; color: var(--ink-3); font-weight: 600;
    display: flex; align-items: center; gap: 5px; white-space: nowrap;
  }
  .add-sub-btn {
    background: none; border: 1.5px solid var(--border); cursor: pointer;
    font-family: var(--sans); font-size: 12px; font-weight: 700; color: var(--accent);
    display: flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: var(--radius-sm); transition: all .15s; white-space: nowrap;
  }
  .add-sub-btn:hover { background: var(--accent-glow); border-color: #bfdbfe; }

  /* ══════════════════════════════════════════
     EMPTY STATE
  ══════════════════════════════════════════ */
  .empty-state {
    grid-column: 1 / -1; text-align: center; padding: 80px 20px;
    background: var(--surface); border: 1.5px dashed var(--border-2);
    border-radius: var(--radius-lg);
  }
  .empty-icon  { font-size: 52px; margin-bottom: 14px; }
  .empty-title { font-weight: 800; font-size: 16px; color: var(--ink); margin-bottom: 6px; }
  .empty-sub   { font-size: 13px; color: var(--ink-3); }

  /* ══════════════════════════════════════════
     MODAL
  ══════════════════════════════════════════ */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(10,14,26,0.5); backdrop-filter: blur(6px);
    z-index: 1000; align-items: center; justify-content: center; padding: 16px;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--surface); border-radius: var(--radius-lg);
    padding: 28px 30px; width: 580px; max-width: 100%;
    box-shadow: var(--shadow-xl);
    animation: modalIn .22s cubic-bezier(.34,1.56,.64,1);
    max-height: 92vh; overflow-y: auto;
    border: 1.5px solid var(--border); position: relative;
  }
  .modal::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
    background: linear-gradient(90deg, var(--accent), #6366f1);
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
  }
  @keyframes modalIn {
    from { transform: translateY(-20px) scale(.96); opacity: 0; }
    to   { transform: none; opacity: 1; }
  }
  .modal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 22px; margin-top: 4px;
  }
  .modal-title  { font-size: 17px; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 8px; }
  .modal-close  {
    background: var(--surface-2); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); width: 32px; height: 32px;
    font-size: 14px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; color: var(--ink-3); flex-shrink: 0;
  }
  .modal-close:hover { background: var(--red-bg); color: var(--red); border-color: var(--red-bd); }
  .modal-footer {
    display: flex; justify-content: flex-end; gap: 8px;
    margin-top: 22px; padding-top: 18px; border-top: 1.5px solid var(--border);
  }

  /* ══════════════════════════════════════════
     FORM ELEMENTS
  ══════════════════════════════════════════ */
  .form-group  { margin-bottom: 16px; }
  .form-row    { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .form-label  { font-size: 12px; font-weight: 700; color: var(--ink); margin-bottom: 6px; display: block; letter-spacing: .2px; }
  .form-label span { color: var(--red); margin-left: 2px; }
  .form-input, .form-select, .form-textarea {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-family: var(--sans); font-size: 13px; color: var(--ink);
    background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow);
  }
  .form-textarea { resize: vertical; min-height: 72px; line-height: 1.6; }
  .form-hint     { font-size: 11px; color: var(--ink-3); margin-top: 5px; }

  .sub-section-label {
    font-size: 12px; font-weight: 800; color: var(--ink);
    display: flex; align-items: center; gap: 8px; margin-bottom: 12px;
  }
  .sub-section-label::after { content: ''; flex: 1; height: 1.5px; background: var(--border); border-radius: 2px; }

  .sub-levels-wrapper { display: flex; flex-direction: column; gap: 10px; }
  .sub-level-row { display: grid; grid-template-columns: 44px 1fr 1fr; gap: 8px; align-items: start; }
  .sub-level-badge {
    display: flex; align-items: center; justify-content: center;
    height: 42px; border-radius: var(--radius-sm);
    font-weight: 800; font-family: var(--mono); font-size: 13px; border: 1.5px solid transparent;
  }
  .slb-4 { background: #f0fdf4; color: #059669; border-color: #a7f3d0; }
  .slb-3 { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
  .slb-2 { background: #fffbeb; color: #d97706; border-color: #fde68a; }
  .slb-1 { background: #fef2f2; color: #dc2626; border-color: #fca5a5; }

  .section-divider { border: none; border-top: 1.5px solid var(--border); margin: 18px 0 16px; }

  .btn           { padding: 9px 20px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 700; border: 1.5px solid transparent; cursor: pointer; transition: all .15s; font-family: var(--sans); }
  .btn-primary   { background: var(--accent); color: #fff; border-color: var(--accent); box-shadow: 0 2px 8px rgba(37,99,235,.3); }
  .btn-primary:hover { background: var(--accent-2); box-shadow: 0 4px 12px rgba(37,99,235,.4); transform: translateY(-1px); }
  .btn-secondary { background: var(--surface); color: var(--ink); border-color: var(--border-2); }
  .btn-secondary:hover { background: var(--surface-3); }
  .btn-danger    { background: #dc2626; color: #fff; border-color: #dc2626; }
  .btn-danger:hover { background: #b91c1c; }

  /* ══════════════════════════════════════════
     CONFIRM MODAL
  ══════════════════════════════════════════ */
  .confirm-modal { width: 400px; }
  .confirm-body  { text-align: center; padding: 10px 0 6px; }
  .confirm-icon-wrap {
    width: 70px; height: 70px; border-radius: 50%;
    background: var(--red-bg); border: 2px solid var(--red-bd);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; margin: 0 auto 16px;
  }
  .confirm-title { font-size: 19px; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
  .confirm-desc  { font-size: 13px; color: var(--ink-3); line-height: 1.65; }

  /* ══════════════════════════════════════════
     BADGE & STRIP COLORS
  ══════════════════════════════════════════ */
  .bc1{background:#2563eb}.bc2{background:#6366f1}.bc3{background:#0891b2}
  .bc4{background:#059669}.bc5{background:#d97706}.bc6{background:#dc2626}
  .bc7{background:#7c3aed}.bc8{background:#0284c7}.bc9{background:#db2777}
  .bc-def{background:#475569}

  .cs1 {--strip-a:#2563eb;--strip-b:#6366f1}.cs2 {--strip-a:#6366f1;--strip-b:#8b5cf6}
  .cs3 {--strip-a:#0891b2;--strip-b:#06b6d4}.cs4 {--strip-a:#059669;--strip-b:#10b981}
  .cs5 {--strip-a:#d97706;--strip-b:#f59e0b}.cs6 {--strip-a:#dc2626;--strip-b:#f87171}
  .cs7 {--strip-a:#7c3aed;--strip-b:#a855f7}.cs8 {--strip-a:#0284c7;--strip-b:#38bdf8}
  .cs9 {--strip-a:#db2777;--strip-b:#f472b6}.cs-def{--strip-a:#475569;--strip-b:#94a3b8}

  /* ══════════════════════════════════════════
     RESPONSIVE
  ══════════════════════════════════════════ */
  @media (max-width: 1099px) {
    .criteria-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    .stats-row    { grid-template-columns: 1fr 1fr; }
    .form-row     { grid-template-columns: 1fr; }
    .sub-level-row{ grid-template-columns: 44px 1fr; }
    .sub-level-row input:last-child { grid-column: 2; }
    .page-header  { flex-direction: column; align-items: flex-start; }
    .page-header-actions { width: 100%; }
    .btn-add-main { width: 100%; justify-content: center; }
  }
  @media (max-width: 480px) {
    .stats-row    { grid-template-columns: 1fr 1fr; gap: 10px; }
    .stat-val     { font-size: 22px; }
    .card-header  { flex-wrap: wrap; }
    .card-header-right { flex-wrap: wrap; }
  }
</style>
@endpush

@section('content')
<div class="kriteria-page-wrap">

  {{-- ─── PAGE HEADER ─── --}}
  <div class="page-header">
    <div class="page-header-left">
      <h1 class="page-header-title">
        <span class="title-icon">📋</span>
        Kriteria &amp; Parameter
      </h1>
      <p class="page-header-subtitle">
        Kelola kriteria penilaian dan level Parameter untuk metode AHP &amp; SMART
      </p>
    </div>
    <div class="page-header-actions">
      <button class="btn-add-main" onclick="openAddCriteriaModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Kriteria
      </button>
    </div>
  </div>
  <hr class="page-divider">

  {{-- ─── INFO BANNER ─── --}}
  <div class="info-banner">
    <span class="info-icon">ℹ️</span>
    <div>
      Terdapat <strong>{{ $stats['total'] }}</strong> kriteria penilaian. Setiap kriteria memiliki tepat
      <strong>4 Parameter (level 1–4)</strong> agar perhitungan SMART konsisten dan dapat dibandingkan
      secara adil. Level 4 = Sangat Baik · Level 3 = Baik · Level 2 = Cukup · Level 1 = Kurang.
    </div>
  </div>

  {{-- ─── STATS ROW ─── --}}
  <div class="stats-row">
    <div class="stat-card s-blue">
      <div class="stat-icon-wrap">📋</div>
      <div class="stat-info">
        <div class="stat-val">{{ $stats['total'] }}</div>
        <div class="stat-lbl">Total Kriteria</div>
      </div>
    </div>
    <div class="stat-card s-green">
      <div class="stat-icon-wrap">✅</div>
      <div class="stat-info">
        <div class="stat-val">{{ $stats['benefit'] }}</div>
        <div class="stat-lbl">Kriteria Benefit</div>
      </div>
    </div>
    <div class="stat-card s-yellow">
      <div class="stat-icon-wrap">📉</div>
      <div class="stat-info">
        <div class="stat-val">{{ $stats['cost'] }}</div>
        <div class="stat-lbl">Kriteria Cost</div>
      </div>
    </div>
    <div class="stat-card s-purple">
      <div class="stat-icon-wrap">🔢</div>
      <div class="stat-info">
        <div class="stat-val">{{ $stats['sub'] }}</div>
        <div class="stat-lbl">Total Parameter</div>
      </div>
    </div>
  </div>

  {{-- ─── SECTION HEADER ─── --}}
  <div class="section-header">
    <div class="section-title">Daftar Kriteria Penilaian</div>
    <div class="section-count">{{ $kriterias->count() }} kriteria</div>
  </div>

  {{-- ─── CRITERIA GRID ─── --}}
  <div class="criteria-grid">
    @forelse($kriterias as $i => $k)
      @php
        $idx = $i + 1;
        $bc  = $idx <= 9 ? "bc{$idx}"  : 'bc-def';
        $cs  = $idx <= 9 ? "cs{$idx}"  : 'cs-def';

        $s4 = $k->subKriterias->where('level',4)->first();
        $s3 = $k->subKriterias->where('level',3)->first();
        $s2 = $k->subKriterias->where('level',2)->first();
        $s1 = $k->subKriterias->where('level',1)->first();

        $editArgs = implode(',', [
          $k->id,
          "'" . addslashes($k->nama)            . "'",
          "'" . $k->tipe                        . "'",
          "'" . addslashes($k->deskripsi ?? '') . "'",
          $s4?->id ?? 'null', "'" . addslashes($s4?->nama ?? '') . "'", "'" . addslashes($s4?->deskripsi ?? '') . "'",
          $s3?->id ?? 'null', "'" . addslashes($s3?->nama ?? '') . "'", "'" . addslashes($s3?->deskripsi ?? '') . "'",
          $s2?->id ?? 'null', "'" . addslashes($s2?->nama ?? '') . "'", "'" . addslashes($s2?->deskripsi ?? '') . "'",
          $s1?->id ?? 'null', "'" . addslashes($s1?->nama ?? '') . "'", "'" . addslashes($s1?->deskripsi ?? '') . "'",
        ]);
      @endphp

      <div class="criteria-card {{ $cs }}">
        <div class="card-strip"></div>

        <div class="card-header">
          <div class="card-header-left">
            <div class="c-badge {{ $bc }}">{{ $k->kode }}</div>
            <div class="c-meta">
              <div class="c-name">{{ $k->nama }}</div>
              @if($k->deskripsi)
                <div class="c-desc-preview">{{ $k->deskripsi }}</div>
              @endif
            </div>
          </div>
          <div class="card-header-right">
            <span class="{{ $k->tipe === 'benefit' ? 'tag-benefit' : 'tag-cost' }} tag-type">
              {{ $k->tipe === 'benefit' ? 'Benefit ↑' : 'Cost ↓' }}
            </span>
            <button class="action-btn edit" title="Edit Kriteria"
              onclick="openEditModal({{ $editArgs }})">✏️</button>
            <button class="action-btn danger" title="Hapus Kriteria"
              onclick="openDeleteModal({{ $k->id }}, '{{ addslashes($k->nama) }}')">🗑️</button>
          </div>
        </div>

        <div class="card-body">
          <div class="card-body-label">Parameter</div>
          @forelse($k->subKriterias->sortByDesc('level') as $sub)
            <div class="sub-item l{{ $sub->level }}">
              <div class="level-pill">
                <span class="lp-tag">LVL</span>
                <span class="lp-num">{{ $sub->level }}</span>
              </div>
              <div class="sub-text">
                <div class="sub-title">{{ $sub->nama }}</div>
                @if($sub->deskripsi)
                  <div class="sub-desc">{{ $sub->deskripsi }}</div>
                @endif
              </div>
            </div>
          @empty
            <div class="sub-empty">Belum ada Parameter ditambahkan</div>
          @endforelse
        </div>

        <div class="card-footer">
          <div class="card-sub-count">
            📊 {{ $k->subKriterias->count() }} / 4 Parameter
          </div>
          <button class="add-sub-btn" onclick="openEditModal({{ $editArgs }})">
            ✏️ Edit Parameter
          </button>
        </div>
      </div>

    @empty
      <div class="empty-state">
        <div class="empty-icon">📭</div>
        <div class="empty-title">Belum Ada Kriteria</div>
        <div class="empty-sub">Klik tombol <strong>Tambah Kriteria</strong> di atas untuk memulai</div>
      </div>
    @endforelse
  </div>

</div>{{-- end .kriteria-page-wrap --}}


{{-- ══════════════════════════════════════════════
     MODAL: TAMBAH KRITERIA
══════════════════════════════════════════════ --}}
<div class="modal-overlay" id="modal-add">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">➕ Tambah Kriteria Baru</div>
      <button class="modal-close" onclick="closeModal('modal-add')">✕</button>
    </div>

    <form method="POST" action="{{ route('kriteria.store') }}">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nama Kriteria <span>*</span></label>
          <input type="text" name="nama" class="form-input"
            placeholder="cth. Sikap dan Perilaku" required />
        </div>
        <div class="form-group">
          <label class="form-label">Tipe Kriteria <span>*</span></label>
          <select name="tipe" class="form-select">
            <option value="benefit">↑ Benefit (semakin tinggi = baik)</option>
            <option value="cost">↓ Cost (semakin rendah = baik)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Singkat</label>
        <textarea name="deskripsi" class="form-textarea"
          placeholder="Jelaskan kriteria ini secara singkat..."></textarea>
      </div>

      <hr class="section-divider">
      <div class="sub-section-label">📝 Parameter (Level 1–4)</div>
      <p class="form-hint" style="margin-bottom:14px;margin-top:-6px">
        Level 4 = Sangat Baik &nbsp;·&nbsp; Level 3 = Baik &nbsp;·&nbsp;
        Level 2 = Cukup &nbsp;·&nbsp; Level 1 = Kurang
      </p>

      <div class="sub-levels-wrapper">
        @foreach([4 => 'slb-4', 3 => 'slb-3', 2 => 'slb-2', 1 => 'slb-1'] as $lv => $cls)
          <input type="hidden" name="subs[{{ $loop->index }}][level]" value="{{ $lv }}">
          <div class="sub-level-row">
            <div class="sub-level-badge {{ $cls }}">L{{ $lv }}</div>
            <input type="text" name="subs[{{ $loop->index }}][nama]"
              class="form-input" placeholder="Nama level {{ $lv }}" required />
            <input type="text" name="subs[{{ $loop->index }}][deskripsi]"
              class="form-input" placeholder="Deskripsi level {{ $lv }}" />
          </div>
        @endforeach
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-add')">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Simpan Kriteria</button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     MODAL: EDIT KRITERIA
══════════════════════════════════════════════ --}}
<div class="modal-overlay" id="modal-edit">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">✏️ Edit Kriteria</div>
      <button class="modal-close" onclick="closeModal('modal-edit')">✕</button>
    </div>

    <form method="POST" id="form-edit" action="">
      @csrf
      @method('PUT')

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nama Kriteria <span>*</span></label>
          <input type="text" name="nama" id="edit-nama" class="form-input" required />
        </div>
        <div class="form-group">
          <label class="form-label">Tipe Kriteria <span>*</span></label>
          <select name="tipe" id="edit-tipe" class="form-select">
            <option value="benefit">↑ Benefit (semakin tinggi = baik)</option>
            <option value="cost">↓ Cost (semakin rendah = baik)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Singkat</label>
        <textarea name="deskripsi" id="edit-deskripsi" class="form-textarea"></textarea>
      </div>

      <hr class="section-divider">
      <div class="sub-section-label">📝 Parameter (Level 1–4)</div>

      <div class="sub-levels-wrapper">
        @foreach([4 => 'slb-4', 3 => 'slb-3', 2 => 'slb-2', 1 => 'slb-1'] as $lv => $cls)
          <input type="hidden" name="subs[{{ $loop->index }}][level]" value="{{ $lv }}">
          <div class="sub-level-row">
            <div class="sub-level-badge {{ $cls }}">L{{ $lv }}</div>
            <input type="text" name="subs[{{ $loop->index }}][nama]"
              id="edit-s{{ $lv }}-nama" class="form-input" required />
            <input type="text" name="subs[{{ $loop->index }}][deskripsi]"
              id="edit-s{{ $lv }}-desc" class="form-input" />
          </div>
        @endforeach
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Perbarui</button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     MODAL: KONFIRMASI HAPUS
══════════════════════════════════════════════ --}}
<div class="modal-overlay" id="modal-delete">
  <div class="modal confirm-modal">
    <div class="confirm-body">
      <div class="confirm-icon-wrap">🗑️</div>
      <div class="confirm-title">Hapus Kriteria?</div>
      <div class="confirm-desc" id="delete-desc">
        Yakin ingin menghapus kriteria ini? Semua Parameter akan ikut terhapus
        dan bobot AHP perlu dihitung ulang.
      </div>
    </div>
    <form method="POST" id="form-delete" action="">
      @csrf
      @method('DELETE')
      <div class="modal-footer" style="justify-content:center">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-delete')">Batal</button>
        <button type="submit" class="btn btn-danger">🗑️ Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }

  document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('open'); });
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape')
      document.querySelectorAll('.modal-overlay.open').forEach(el => el.classList.remove('open'));
  });

  function openAddCriteriaModal() { openModal('modal-add'); }

  function openEditModal(
    id, nama, tipe, desc,
    s4id, s4nama, s4desc,
    s3id, s3nama, s3desc,
    s2id, s2nama, s2desc,
    s1id, s1nama, s1desc
  ) {
    document.getElementById('form-edit').action     = '/kriteria/' + id;
    document.getElementById('edit-nama').value      = nama;
    document.getElementById('edit-tipe').value      = tipe;
    document.getElementById('edit-deskripsi').value = desc;
    document.getElementById('edit-s4-nama').value   = s4nama;
    document.getElementById('edit-s4-desc').value   = s4desc;
    document.getElementById('edit-s3-nama').value   = s3nama;
    document.getElementById('edit-s3-desc').value   = s3desc;
    document.getElementById('edit-s2-nama').value   = s2nama;
    document.getElementById('edit-s2-desc').value   = s2desc;
    document.getElementById('edit-s1-nama').value   = s1nama;
    document.getElementById('edit-s1-desc').value   = s1desc;
    openModal('modal-edit');
  }

  function openDeleteModal(id, nama) {
    document.getElementById('form-delete').action = '/kriteria/' + id;
    document.getElementById('delete-desc').innerHTML =
      'Yakin ingin menghapus kriteria <strong>' + nama + '</strong>? ' +
      'Semua Parameter akan ikut terhapus dan bobot AHP perlu dihitung ulang.';
    openModal('modal-delete');
  }

  @if($errors->any())
    openModal('modal-add');
  @endif
</script>
@endpush