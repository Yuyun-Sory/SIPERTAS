@extends('layouts.app')

@section('title', 'Detail Riwayat – ' . $riwayat->judul)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════
   CSS VARIABLES & RESET
═══════════════════════════════════════════ */
:root {
    --ink:       #0a0f1e;
    --ink-2:     #2d3748;
    --ink-3:     #64748b;
    --surface:   #ffffff;
    --surface-2: #f8fafc;
    --surface-3: #f1f5f9;
    --border:    #e2e8f0;
    --accent:    #2563eb;
    --accent-dk: #1d4ed8;
    --accent-lt: #eff6ff;
    --gold:      #f59e0b;
    --gold-bg:   #fffbeb;
    --gold-bd:   #fde68a;
    --green:     #059669;
    --green-bg:  #ecfdf5;
    --green-bd:  #6ee7b7;
    --red:       #dc2626;
    --red-bg:    #fef2f2;
    --red-bd:    #fca5a5;
    --orange-bg: #fff7ed;
    --orange-bd: #fed7aa;
    --sans:      'Plus Jakarta Sans', sans-serif;
    --mono:      'JetBrains Mono', monospace;
    --r-xs:      6px;
    --r-sm:      8px;
    --r:         12px;
    --r-lg:      16px;
    --r-xl:      20px;
    --sh-xs:     0 1px 3px rgba(10,15,30,.06);
    --sh-sm:     0 4px 16px rgba(10,15,30,.08);
    --sh-md:     0 8px 32px rgba(10,15,30,.10);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--sans); background: var(--surface-2); color: var(--ink); }

/* ═══════════════════════════════════════════
   SCREEN: PAGE HEADER
═══════════════════════════════════════════ */
.ph {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.ph-title {
    font-size: 22px;
    font-weight: 900;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 5px;
}
.t-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
}
.ph-sub {
    font-size: 13px;
    color: var(--ink-3);
    padding-left: 52px;
    line-height: 1.6;
}
.divider {
    border: none;
    border-top: 1.5px solid var(--border);
    margin: 0 0 24px;
}

/* ═══════════════════════════════════════════
   SCREEN: BUTTONS
═══════════════════════════════════════════ */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    font-family: var(--sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-3);
    text-decoration: none;
    transition: all .15s;
    background: var(--surface);
}
.btn-back:hover { border-color: var(--accent); color: var(--accent); }

.btn-print {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    background: var(--ink-2);
    color: #fff;
    border: none;
    border-radius: var(--r-sm);
    font-family: var(--sans);
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s;
}
.btn-print:hover { background: var(--ink); }

/* ═══════════════════════════════════════════
   SCREEN: META CARD
═══════════════════════════════════════════ */
.meta-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-xs);
    margin-bottom: 22px;
}
.meta-head {
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1.5px solid var(--border);
    background: var(--surface-2);
}
.meta-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}
.meta-title { font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
.meta-sub   { font-size: 12px; color: var(--ink-3); }

.meta-body {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
.meta-item {
    padding: 16px 20px;
    border-right: 1px solid var(--border);
}
.meta-item:last-child { border-right: none; }
.meta-item-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--ink-3);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 5px;
}
.meta-item-val {
    font-size: 14px;
    font-weight: 800;
    color: var(--ink);
    font-family: var(--mono);
}

@media(max-width:700px) {
    .meta-body { grid-template-columns: repeat(2,1fr); }
    .meta-item { border-bottom: 1px solid var(--border); }
}

/* ═══════════════════════════════════════════
   SCREEN: SECTION CARD
═══════════════════════════════════════════ */
.section-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-xs);
    margin-bottom: 22px;
}
.section-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 22px;
    border-bottom: 1.5px solid var(--border);
    background: var(--surface-2);
}
.section-title {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 8px;
}
.step-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--accent);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
}
.section-body { overflow-x: auto; }

/* ═══════════════════════════════════════════
   SCREEN: TABLE
═══════════════════════════════════════════ */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
}
thead tr { background: var(--surface-2); }
thead th {
    padding: 10px 14px;
    font-size: 10px;
    font-weight: 700;
    color: var(--ink-3);
    text-transform: uppercase;
    letter-spacing: .5px;
    border-bottom: 1.5px solid var(--border);
    text-align: center;
    white-space: nowrap;
}
thead th.left  { text-align: left; }
tbody tr { border-bottom: 1px solid var(--surface-3); transition: background .1s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #f8faff; }
tbody td {
    padding: 11px 14px;
    color: var(--ink);
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}
tbody td.left { text-align: left; }

/* ═══════════════════════════════════════════
   SCREEN: BADGES & VALUES
═══════════════════════════════════════════ */
.rank-cell {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 12px;
    font-weight: 800;
}
.rank-1 { background: var(--gold-bg);   color: #92400e; border: 2px solid var(--gold-bd);   }
.rank-2 { background: var(--surface-3); color: #475569; border: 2px solid var(--border);     }
.rank-3 { background: var(--orange-bg); color: #92400e; border: 2px solid var(--orange-bd);  }
.rank-n { background: var(--surface-3); color: var(--ink-3); border: 1.5px solid var(--border); }

.val-mono { font-family: var(--mono); font-size: 12px; font-weight: 600; }
.val-high { color: var(--green);  font-weight: 700; }
.val-mid  { color: var(--accent); }
.val-low  { color: var(--ink-3);  }

.skor-badge {
    font-family: var(--mono);
    font-size: 13px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-block;
}
.skor-1 { background: var(--gold-bg);   color: #92400e; }
.skor-2 { background: var(--surface-3); color: #475569; }
.skor-3 { background: var(--orange-bg); color: #92400e; }
.skor-n { background: var(--accent-lt); color: var(--accent); }

.bobot-val {
    font-family: var(--mono);
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 6px;
    background: var(--accent-lt);
    color: var(--accent);
    display: inline-block;
}
.tipe-benefit {
    background: var(--green-bg);
    color: var(--green);
    border: 1px solid var(--green-bd);
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    display: inline-block;
}
.tipe-cost {
    background: var(--red-bg);
    color: var(--red);
    border: 1px solid var(--red-bd);
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    display: inline-block;
}

/* ═══════════════════════════════════════════
   SCREEN: PODIUM MINI
═══════════════════════════════════════════ */
.podium-mini {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    padding: 20px 22px;
}
.podium-mini-card {
    border-radius: var(--r-lg);
    padding: 18px 14px;
    text-align: center;
    border: 1.5px solid;
}
.pm-1 { background: linear-gradient(135deg, #fffbeb, #fef3c7); border-color: var(--gold-bd); }
.pm-2 { background: var(--surface-2); border-color: var(--border); }
.pm-3 { background: var(--orange-bg); border-color: var(--orange-bd); }
.pm-medal { font-size: 26px; margin-bottom: 8px; display: block; }
.pm-name  { font-size: 13px; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
.pm-kelas { font-size: 11px; color: var(--ink-3); margin-bottom: 8px; }
.pm-skor  { font-size: 18px; font-weight: 900; font-family: var(--mono); }
.pm-1 .pm-skor { color: #b45309; }
.pm-2 .pm-skor { color: #475569; }
.pm-3 .pm-skor { color: #92400e; }

/* ═══════════════════════════════════════════
   SCREEN: SUMMARY BAR
═══════════════════════════════════════════ */
.summary-bar {
    padding: 12px 20px;
    border-top: 1.5px solid var(--border);
    background: var(--surface-2);
    font-size: 12px;
    color: var(--ink-3);
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    align-items: center;
}
.summary-bar strong { color: var(--ink); }

/* ═══════════════════════════════════════════
   PRINT HEADER — hanya tampil saat @media print
═══════════════════════════════════════════ */
.print-header { display: none; }

/* ═══════════════════════════════════════════
   ██████████████  PRINT STYLES  ██████████████
   Prinsip:
   1. Sembunyikan semua elemen navigasi/UI
   2. Tampilkan HANYA konten bertanda .print-show
   3. Gunakan @page + page-break untuk layout A4
   4. Force warna agar tinta tercetak
═══════════════════════════════════════════ */
@media print {
    /* ---------- PAGE SETUP ---------- */
    @page {
        size: A4 portrait;
        margin: 1.5cm 1.8cm 2cm 1.8cm;
    }
    @page :first {
        margin-top: 1cm;
    }

    /* ---------- BASE RESET ---------- */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    html, body {
        background: #ffffff !important;
        color: #000000 !important;
        font-family: 'Plus Jakarta Sans', Arial, sans-serif !important;
        font-size: 10pt !important;
        line-height: 1.5;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ---------- SEMBUNYIKAN ELEMEN UI ---------- */
    .no-print,
    .btn-back,
    .btn-print,
    nav, header, aside, footer,
    .ph,
    .divider,
    .section-card:not(.print-show),
    .meta-card.no-print {
        display: none !important;
    }

    /* ---------- TAMPILKAN KOP SURAT ---------- */
    .print-header {
        display: block !important;
        margin-bottom: 0;
    }

    /* ---------- META CARD CETAK ---------- */
    .meta-card {
        box-shadow: none !important;
        border: 1pt solid #cbd5e1 !important;
        border-radius: 0 !important;
        margin-bottom: 10pt !important;
        page-break-inside: avoid;
    }
    .meta-head {
        background: #f1f5f9 !important;
        padding: 10px 14px !important;
    }
    .meta-icon { display: none !important; }
    .meta-title { font-size: 13pt !important; }
    .meta-sub   { font-size: 9pt !important; }
    .meta-body  { grid-template-columns: repeat(4, 1fr) !important; }
    .meta-item  { padding: 8px 12px !important; }
    .meta-item-label { font-size: 8pt !important; }
    .meta-item-val   { font-size: 10pt !important; }

    /* ---------- SECTION CARD CETAK ---------- */
    .section-card.print-show {
        display: block !important;
        box-shadow: none !important;
        border: 1pt solid #cbd5e1 !important;
        border-radius: 0 !important;
        margin-bottom: 14pt !important;
        page-break-inside: avoid;
    }
    .section-head {
        background: #f1f5f9 !important;
        padding: 8px 14px !important;
        border-bottom: 1pt solid #cbd5e1 !important;
    }
    .section-title { font-size: 11pt !important; }
    .step-badge {
        background: #1e40af !important;
        color: #ffffff !important;
        width: 18px !important;
        height: 18px !important;
        font-size: 8pt !important;
    }

    /* ---------- TABLE CETAK ---------- */
    table { width: 100% !important; border-collapse: collapse !important; font-size: 9pt !important; }
    thead tr { background: #f1f5f9 !important; }
    thead th {
        padding: 7px 10px !important;
        font-size: 8pt !important;
        font-weight: 700 !important;
        color: #475569 !important;
        border-bottom: 1.5pt solid #94a3b8 !important;
        border-right: 0.5pt solid #e2e8f0 !important;
        text-align: center !important;
        white-space: normal !important;
        word-break: break-word !important;
    }
    thead th.left { text-align: left !important; }
    tbody tr { border-bottom: 0.5pt solid #e2e8f0 !important; }
    tbody tr:last-child { border-bottom: none !important; }
    tbody tr:nth-child(even) { background: #f8fafc !important; }
    tbody tr.row-top1 { background: #fffbeb !important; }
    tbody td {
        padding: 7px 10px !important;
        font-size: 9pt !important;
        text-align: center !important;
        vertical-align: middle !important;
        border-right: 0.5pt solid #e2e8f0 !important;
        white-space: normal !important;
        word-break: break-word !important;
    }
    tbody td.left { text-align: left !important; }

    /* ---------- BADGES CETAK ---------- */
    .rank-cell {
        display: inline-flex !important;
        width: 22px !important;
        height: 22px !important;
        font-size: 9pt !important;
        border-radius: 50% !important;
    }
    .rank-1 { background: #fef3c7 !important; color: #92400e !important; border: 1.5pt solid #fcd34d !important; }
    .rank-2 { background: #f1f5f9 !important; color: #475569 !important; border: 1.5pt solid #cbd5e1 !important; }
    .rank-3 { background: #fff7ed !important; color: #9a3412 !important; border: 1.5pt solid #fdba74 !important; }
    .rank-n { background: #f8fafc !important; color: #64748b !important; border: 1pt solid #e2e8f0 !important; }

    .skor-badge {
        font-size: 10pt !important;
        font-weight: 900 !important;
        padding: 3px 8px !important;
        border-radius: 4px !important;
    }
    .skor-1 { background: #fef3c7 !important; color: #92400e !important; }
    .skor-2 { background: #f1f5f9 !important; color: #475569 !important; }
    .skor-3 { background: #fff7ed !important; color: #9a3412 !important; }
    .skor-n { background: #eff6ff !important; color: #1d4ed8 !important; }

    .bobot-val {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        font-size: 9pt !important;
        padding: 2px 8px !important;
    }
    .tipe-benefit { background: #d1fae5 !important; color: #065f46 !important; font-size: 8pt !important; }
    .tipe-cost    { background: #fee2e2 !important; color: #991b1b !important; font-size: 8pt !important; }

    /* ---------- PODIUM CETAK ---------- */
    .podium-mini {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 10pt !important;
        padding: 12pt 14pt !important;
    }
    .podium-mini-card {
        border-radius: 6pt !important;
        padding: 12pt 10pt !important;
        page-break-inside: avoid;
    }
    .pm-1 { background: #fffbeb !important; border-color: #fcd34d !important; }
    .pm-2 { background: #f8fafc !important; border-color: #cbd5e1 !important; }
    .pm-3 { background: #fff7ed !important; border-color: #fdba74 !important; }
    .pm-medal { font-size: 20pt !important; }
    .pm-name  { font-size: 10pt !important; }
    .pm-kelas { font-size: 8pt !important; }
    .pm-skor  { font-size: 14pt !important; }

    /* ---------- SUMMARY BAR CETAK ---------- */
    .summary-bar {
        background: #f8fafc !important;
        border-top: 1pt solid #cbd5e1 !important;
        padding: 8px 12px !important;
        font-size: 9pt !important;
        gap: 14pt !important;
    }

    /* ---------- AHP CR BOX ---------- */
    .cr-box {
        background: #f8fafc !important;
        border-top: 1pt solid #cbd5e1 !important;
    }

    /* ---------- ANTI POTONG ---------- */
    .print-show { page-break-inside: avoid; }
    .podium-mini-card { page-break-inside: avoid; }
    tr { page-break-inside: avoid !important; }

    /* Tabel panjang boleh multi-halaman, tapi header diulang */
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    /* Pastikan tidak ada overflow horizontal */
    .section-body { overflow: visible !important; }
}
</style>
@endpush

@section('content')
@php
    $data    = $riwayat->data_json ?? [];
    $jenis   = $riwayat->jenis;
    $icons   = ['smart' => '🏆', 'ahp' => '⚖️', 'nilai' => '📝'];
    $iconBg  = ['smart' => 'var(--gold-bg)', 'ahp' => 'var(--accent-lt)', 'nilai' => 'var(--green-bg)'];
    $iconClr = ['smart' => '#92400e', 'ahp' => 'var(--accent)', 'nilai' => 'var(--green)'];

    /* Untuk SMART */
    $kriterias  = collect($data['kriterias']  ?? []);
    $bobotMap   = $data['bobot_map'] ?? [];
    $tabelNilai = collect($data['tabel_nilai']         ?? []);
    $tabelNorm  = collect($data['tabel_normalisasi']   ?? []);
    $tabelSkor  = collect($data['tabel_skor']          ?? [])->sortByDesc('total_skor')->values();
@endphp

{{-- ═══════════════════════════════════════════════════════════
     KOP SURAT CETAK — hanya muncul saat @media print
═══════════════════════════════════════════════════════════ --}}
<div class="print-header">

    {{-- Garis atas --}}
    <table style="width:100%;border-collapse:collapse;border-bottom:2.5pt solid #0a0f1e;padding-bottom:10pt;margin-bottom:10pt;">
        <tr>
            <td style="vertical-align:top;padding:0 0 8pt 0;">
                <div style="font-size:15pt;font-weight:900;color:#0a0f1e;letter-spacing:-.3px;">
                    LAPORAN HASIL SISTEM PENDUKUNG KEPUTUSAN
                </div>
                <div style="font-size:10pt;font-weight:700;color:#0a0f1e;margin-top:1pt;">
                    Pemilihan Siswa Terbaik — Metode AHP &amp; SMART
                </div>
                <div style="font-size:8.5pt;color:#64748b;margin-top:2pt;">
                    Simple Multi Attribute Rating Technique (SMART) dikombinasikan dengan Analytical Hierarchy Process (AHP)
                </div>
            </td>
            <td style="text-align:right;vertical-align:top;padding:0;white-space:nowrap;">
                <div style="font-size:8.5pt;color:#475569;line-height:1.7;">
                    <div>Periode&nbsp;: <strong style="color:#0a0f1e;">{{ optional($riwayat->periode)->nama_periode ?? '—' }}</strong></div>
                    <div>Tanggal&nbsp;: <strong style="color:#0a0f1e;">{{ $riwayat->created_at->isoFormat('D MMMM YYYY') }}</strong></div>
                    <div>Waktu&nbsp;&nbsp;&nbsp;: <strong style="color:#0a0f1e;">{{ $riwayat->created_at->format('H:i:s') }} WIB</strong></div>
                    <div>Dibuat oleh: <strong style="color:#0a0f1e;">{{ optional($riwayat->user)->name ?? '—' }}</strong></div>
                    <div>Dicetak&nbsp;: <strong style="color:#0a0f1e;" id="tgl-cetak">—</strong></div>
                </div>
            </td>
        </tr>
    </table>

    {{-- Judul dokumen --}}
    <div style="background:#0a0f1e;color:#fff;padding:8pt 12pt;border-radius:4pt;margin-bottom:10pt;font-size:11pt;font-weight:800;">
        {{ $riwayat->judul }}
        @if($riwayat->keterangan)
        <span style="font-weight:400;font-size:9pt;opacity:.75;margin-left:8pt;">— {{ $riwayat->keterangan }}</span>
        @endif
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     SCREEN HEADER
═══════════════════════════════════════════════════════════ --}}
<div class="ph no-print">
    <div>
        <h1 class="ph-title">
            <span class="t-icon" style="background:{{ $iconBg[$jenis] ?? 'var(--surface-2)' }};">
                {{ $icons[$jenis] ?? '📋' }}
            </span>
            Detail Riwayat
        </h1>
        <p class="ph-sub">{{ $riwayat->judul }}</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Laporan</button>
        <a href="{{ route('riwayat.index') }}" class="btn-back">← Kembali</a>
    </div>
</div>
<hr class="divider no-print">

{{-- ═══════════════════════════════════════════════════════════
     META CARD — tampil di layar & cetak
═══════════════════════════════════════════════════════════ --}}
<div class="meta-card">
    <div class="meta-head">
        <div class="meta-icon no-print" style="background:{{ $iconBg[$jenis] ?? 'var(--surface-2)' }};">
            {{ $icons[$jenis] ?? '📋' }}
        </div>
        <div>
            <div class="meta-title">{{ $riwayat->judul }}</div>
            @if($riwayat->keterangan)
            <div class="meta-sub">{{ $riwayat->keterangan }}</div>
            @endif
        </div>
    </div>
    <div class="meta-body">
        <div class="meta-item">
            <div class="meta-item-label">Tanggal</div>
            <div class="meta-item-val" style="font-size:13px;">{{ $riwayat->created_at->isoFormat('D MMM YYYY') }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-item-label">Waktu</div>
            <div class="meta-item-val">{{ $riwayat->created_at->format('H:i:s') }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-item-label">Periode</div>
            <div class="meta-item-val" style="font-size:12px;">{{ optional($riwayat->periode)->nama_periode ?? '—' }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-item-label">Dibuat Oleh</div>
            <div class="meta-item-val" style="font-size:12px;">{{ optional($riwayat->user)->name ?? '—' }}</div>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     ████████   KONTEN SMART   ████████
═══════════════════════════════════════════════════════════ --}}
@if($jenis === 'smart')

    {{-- ── PODIUM ── (cetak + layar) --}}
    @if($tabelSkor->count() >= 1)
    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title">🏅 Hasil Perankingan Siswa Terbaik</div>
        </div>
        <div class="podium-mini">
            @foreach([0,1,2] as $pos)
                @if($tabelSkor->has($pos))
                @php
                    $s      = $tabelSkor[$pos];
                    $medals = [0=>'🥇', 1=>'🥈', 2=>'🥉'];
                    $cls    = [0=>'pm-1', 1=>'pm-2', 2=>'pm-3'];
                @endphp
                <div class="podium-mini-card {{ $cls[$pos] }}">
                    <span class="pm-medal">{{ $medals[$pos] }}</span>
                    <div class="pm-name">{{ $s['nama'] }}</div>
                    <div class="pm-kelas">{{ $s['kelas'] ?? '' }}</div>
                    <div class="pm-skor">{{ number_format($s['total_skor'], 4) }}</div>
                </div>
                @endif
            @endforeach
            @if($tabelSkor->count() < 3)
                @for($i = $tabelSkor->count(); $i < 3; $i++)
                <div class="podium-mini-card {{ ['pm-1','pm-2','pm-3'][$i] }}" style="opacity:.3;">
                    <span class="pm-medal">{{ ['🥇','🥈','🥉'][$i] }}</span>
                    <div class="pm-name">—</div>
                    <div class="pm-skor">—</div>
                </div>
                @endfor
            @endif
        </div>
    </div>
    @endif

    {{-- ── STEP 1: BOBOT KRITERIA (AHP) ── (layar saja) --}}
    @if($kriterias->isNotEmpty())
    <div class="section-card no-print">
        <div class="section-head">
            <div class="section-title"><span class="step-badge">1</span> Bobot Kriteria (dari AHP)</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th class="left" style="width:40px;">No</th>
                        <th class="left">Kode</th>
                        <th class="left">Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot (AHP)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriterias as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="left"><strong style="font-family:var(--mono);">{{ $k['kode'] }}</strong></td>
                        <td class="left">{{ $k['nama'] }}</td>
                        <td><span class="tipe-{{ $k['tipe'] }}">{{ $k['tipe'] === 'benefit' ? '↑ Benefit' : '↓ Cost' }}</span></td>
                        <td><span class="bobot-val">{{ number_format($bobotMap[$k['id']] ?? 0, 4) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── STEP 2: NILAI AWAL SISWA ── (layar saja) --}}
    @if($tabelNilai->isNotEmpty())
    <div class="section-card no-print">
        <div class="section-head">
            <div class="section-title"><span class="step-badge">2</span> Nilai Awal Siswa per Kriteria</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th class="left">Siswa / NIS</th>
                        @foreach($kriterias as $k)
                        <th title="{{ $k['nama'] }}">{{ $k['kode'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($tabelNilai as $row)
                    <tr>
                        <td class="left">
                            <div style="font-weight:700;">{{ $row['nama'] }}</div>
                            <div style="font-size:10px;color:var(--ink-3);font-family:var(--mono);">{{ $row['nis'] ?? '' }}</div>
                        </td>
                        @foreach($kriterias as $k)
                        @php
                            $v = $row['nilai'][$k['id']] ?? 0;
                            $clrs = [4=>'#059669', 3=>'#2563eb', 2=>'#ea580c', 1=>'#dc2626'];
                            $lbls = [4=>'Sangat Baik', 3=>'Baik', 2=>'Cukup', 1=>'Kurang'];
                        @endphp
                        <td>
                            <span style="font-family:var(--mono);font-size:15px;font-weight:800;color:{{ $clrs[$v] ?? '#64748b' }};">
                                {{ $v ?: '—' }}
                            </span>
                            @if($v)
                            <div style="font-size:9px;color:{{ $clrs[$v] }};font-weight:600;">{{ $lbls[$v] ?? '' }}</div>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── STEP 3: NORMALISASI UTILITY ── (layar saja) --}}
    @if($tabelNorm->isNotEmpty())
    <div class="section-card no-print">
        <div class="section-head">
            <div class="section-title"><span class="step-badge">3</span> Normalisasi Utility [0 – 1]</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th class="left">Siswa</th>
                        @foreach($kriterias as $k)
                        <th title="{{ $k['nama'] }}">{{ $k['kode'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($tabelNorm as $row)
                    <tr>
                        <td class="left" style="font-weight:700;">{{ $row['nama'] }}</td>
                        @foreach($kriterias as $k)
                        @php $u = $row['utility'][$k['id']] ?? 0; @endphp
                        <td>
                            <span class="val-mono {{ $u >= 0.75 ? 'val-high' : ($u >= 0.4 ? 'val-mid' : 'val-low') }}">
                                {{ number_format($u, 4) }}
                            </span>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="summary-bar no-print" style="font-size:11px;">
            <span>🟢 ≥ 0.75 = Tinggi</span>
            <span>🔵 ≥ 0.40 = Sedang</span>
            <span>⚪ &lt; 0.40 = Rendah</span>
        </div>
    </div>
    @endif

    {{-- ── STEP 4: SKOR AKHIR SMART ── (cetak + layar) --}}
    @if($tabelSkor->isNotEmpty())
    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title"><span class="step-badge">4</span> Nilai Terbobot &amp; Skor Akhir SMART</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th style="width:46px;">RANK</th>
                        <th class="left">Nama Siswa</th>
                        <th class="left">Kelas</th>
                        @foreach($kriterias as $k)
                        <th title="{{ $k['nama'] }}">{{ $k['kode'] }}<br><span style="font-weight:500;font-size:8px;opacity:.65;">w={{ number_format($bobotMap[$k['id']] ?? 0, 3) }}</span></th>
                        @endforeach
                        <th style="min-width:90px;">SKOR AKHIR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tabelSkor as $rank => $row)
                    @php
                        $rc = match(true) { $rank===0=>'rank-1', $rank===1=>'rank-2', $rank===2=>'rank-3', default=>'rank-n' };
                        $sc = match(true) { $rank===0=>'skor-1', $rank===1=>'skor-2', $rank===2=>'skor-3', default=>'skor-n' };
                        $isTop = $rank === 0;
                    @endphp
                    <tr class="{{ $isTop ? 'row-top1' : '' }}" style="{{ $isTop ? 'background:linear-gradient(90deg,#fffbeb,transparent);' : '' }}">
                        <td>
                            <span class="rank-cell {{ $rc }}">
                                @if($rank===0)🥇@elseif($rank===1)🥈@elseif($rank===2)🥉@else{{ $rank+1 }}@endif
                            </span>
                        </td>
                        <td class="left">
                            <div style="font-weight:700;{{ $isTop ? 'color:#92400e;' : '' }}">{{ $row['nama'] }}</div>
                            @if(isset($row['nis']))<div style="font-size:10px;color:var(--ink-3);font-family:var(--mono);">{{ $row['nis'] }}</div>@endif
                        </td>
                        <td class="left" style="color:var(--ink-3);font-size:11px;">{{ $row['kelas'] ?? '—' }}</td>
                        @foreach($kriterias as $k)
                        <td>
                            <span class="val-mono">{{ number_format($row['skor_per_kriteria'][$k['id']] ?? 0, 4) }}</span>
                        </td>
                        @endforeach
                        <td>
                            <span class="skor-badge {{ $sc }}">{{ number_format($row['total_skor'], 4) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="summary-bar">
            <span>🏆 Siswa Terbaik: <strong>{{ $data['siswa_terbaik'] ?? '—' }}</strong></span>
            <span>📊 Skor Tertinggi: <strong style="font-family:var(--mono);color:var(--green);">{{ number_format($data['skor_tertinggi'] ?? 0, 4) }}</strong></span>
            <span>📉 Skor Terendah: <strong style="font-family:var(--mono);color:var(--red);">{{ number_format($data['skor_terendah'] ?? $tabelSkor->last()['total_skor'] ?? 0, 4) }}</strong></span>
            <span>👥 Total Siswa: <strong>{{ $data['jumlah_siswa'] ?? $tabelSkor->count() }}</strong></span>
        </div>
    </div>
    @endif

    {{-- ── DETAIL BOBOT KRITERIA (untuk cetak) ── --}}
    @if($kriterias->isNotEmpty())
    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title">📋 Rincian Kriteria &amp; Bobot</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th class="left">Kode</th>
                        <th class="left">Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot (AHP)</th>
                        <th>Bobot (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalBobot = array_sum($bobotMap); @endphp
                    @foreach($kriterias as $i => $k)
                    @php $b = $bobotMap[$k['id']] ?? 0; @endphp
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="left"><strong style="font-family:var(--mono);">{{ $k['kode'] }}</strong></td>
                        <td class="left">{{ $k['nama'] }}</td>
                        <td><span class="tipe-{{ $k['tipe'] }}">{{ $k['tipe'] === 'benefit' ? '↑ Benefit' : '↓ Cost' }}</span></td>
                        <td><span class="bobot-val">{{ number_format($b, 4) }}</span></td>
                        <td><span style="font-family:var(--mono);font-size:12px;font-weight:700;">{{ $totalBobot > 0 ? number_format(($b/$totalBobot)*100, 1).'%' : '—' }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:var(--surface-3);font-weight:800;">
                        <td colspan="4" class="left" style="padding:8px 14px;font-size:11px;"><strong>TOTAL</strong></td>
                        <td><span class="bobot-val">{{ number_format($totalBobot, 4) }}</span></td>
                        <td><span style="font-family:var(--mono);font-size:12px;font-weight:800;color:var(--green);">100.0%</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    {{-- ── CATATAN / FOOTER CETAK ── --}}
    <div class="section-card print-show" style="margin-bottom:0;">
        <div class="section-head">
            <div class="section-title">📌 Catatan &amp; Validasi</div>
        </div>
        <div style="padding:14px 20px;font-size:12px;color:var(--ink-2);line-height:1.8;">
            <p>1. Laporan ini dihasilkan secara otomatis oleh Sistem Pendukung Keputusan Pemilihan Siswa Terbaik.</p>
            <p>2. Metode yang digunakan: <strong>Analytical Hierarchy Process (AHP)</strong> untuk pembobotan kriteria dan <strong>Simple Multi Attribute Rating Technique (SMART)</strong> untuk perankingan alternatif.</p>
            <p>3. Skor SMART dihitung menggunakan rumus: <em>V(Ai) = Σ [wj × ui(ai)]</em> dimana <em>wj</em> adalah bobot kriteria ke-j dan <em>ui(ai)</em> adalah nilai utility alternatif ke-i pada kriteria ke-j.</p>
            <p>4. Nilai utility dinormalisasi ke dalam rentang [0,1] menggunakan fungsi nilai linear.</p>
            @if(isset($data['cr']))
            <p>5. Consistency Ratio (CR) AHP: <strong style="font-family:var(--mono);">{{ number_format($data['cr'] ?? 0, 4) }}</strong>
            — {{ ($data['cr'] ?? 1) <= 0.1 ? '✓ Konsisten (CR ≤ 0.10, bobot dapat diterima)' : '⚠ Tidak Konsisten (CR > 0.10, perlu ditinjau ulang)' }}</p>
            @endif
        </div>
        <div style="padding:12px 20px;border-top:1.5px solid var(--border);display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--ink-3);">
            <span>Sistem Pendukung Keputusan · {{ optional($riwayat->periode)->nama_periode ?? '' }}</span>
            <span id="ttd-tanggal">Dicetak: —</span>
        </div>
    </div>


{{-- ═══════════════════════════════════════════════════════════
     ████████   KONTEN AHP   ████████
═══════════════════════════════════════════════════════════ --}}
@elseif($jenis === 'ahp')

    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title">⚖️ Hasil Pembobotan AHP (Analytical Hierarchy Process)</div>
        </div>
        <div class="section-body">
            @if(!empty($data['bobot_list']))
            <table>
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th class="left">Kode</th>
                        <th class="left">Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot</th>
                        <th>Bobot (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalB = array_sum(array_column($data['bobot_list'], 'bobot')); @endphp
                    @foreach($data['bobot_list'] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="left"><strong style="font-family:var(--mono);">{{ $item['kode'] }}</strong></td>
                        <td class="left">{{ $item['nama'] }}</td>
                        <td><span class="tipe-{{ $item['tipe'] }}">{{ $item['tipe'] === 'benefit' ? '↑ Benefit' : '↓ Cost' }}</span></td>
                        <td><span class="bobot-val">{{ number_format($item['bobot'], 4) }}</span></td>
                        <td><span style="font-family:var(--mono);font-weight:700;">{{ $totalB > 0 ? number_format(($item['bobot']/$totalB)*100, 1).'%' : '—' }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:var(--surface-3);">
                        <td colspan="4" class="left" style="padding:8px 14px;font-weight:800;">TOTAL</td>
                        <td><span class="bobot-val">{{ number_format($totalB, 4) }}</span></td>
                        <td><span style="font-family:var(--mono);font-weight:800;color:var(--green);">100.0%</span></td>
                    </tr>
                </tfoot>
            </table>
            @else
            <div style="padding:30px;text-align:center;color:var(--ink-3);">Data detail AHP tidak tersedia.</div>
            @endif
        </div>

        @if(isset($data['cr']))
        <div class="summary-bar cr-box">
            @php $crOk = ($data['cr'] <= 0.1); @endphp
            <span>Consistency Ratio (CR):
                <strong style="font-family:var(--mono);color:{{ $crOk ? 'var(--green)' : 'var(--red)' }};">
                    {{ number_format($data['cr'], 4) }}
                </strong>
            </span>
            <span>Status:
                <strong style="color:{{ $crOk ? 'var(--green)' : 'var(--red)' }};">
                    {{ $crOk ? '✓ Konsisten (CR ≤ 0.10)' : '✗ Tidak Konsisten (CR > 0.10)' }}
                </strong>
            </span>
            @if(isset($data['lambda_max']))
            <span>λ<sub>max</sub>: <strong style="font-family:var(--mono);">{{ number_format($data['lambda_max'], 4) }}</strong></span>
            @endif
            @if(isset($data['ci']))
            <span>CI: <strong style="font-family:var(--mono);">{{ number_format($data['ci'], 4) }}</strong></span>
            @endif
        </div>
        @endif
    </div>

    {{-- Matriks Perbandingan AHP (jika tersedia) --}}
    @if(!empty($data['matriks']))
    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title">📊 Matriks Perbandingan Berpasangan (Pairwise Comparison)</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th class="left">Kriteria</th>
                        @foreach($data['bobot_list'] ?? [] as $item)
                        <th>{{ $item['kode'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['matriks'] as $rowKey => $rowVals)
                    <tr>
                        <td class="left"><strong style="font-family:var(--mono);">{{ $rowKey }}</strong></td>
                        @foreach($rowVals as $val)
                        <td><span class="val-mono">{{ is_float($val) ? number_format($val, 3) : $val }}</span></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif


{{-- ═══════════════════════════════════════════════════════════
     ████████   KONTEN NILAI (INPUT NILAI)   ████████
═══════════════════════════════════════════════════════════ --}}
@elseif($jenis === 'nilai')

    <div class="section-card print-show">
        <div class="section-head">
            <div class="section-title">📝 Detail Input Penilaian Siswa</div>
        </div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th class="left">Nama Siswa</th>
                        <th class="left">Kriteria</th>
                        <th>Nilai</th>
                        <th class="left">Keterangan Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['detail'] ?? [] as $idx => $item)
                    @php
                        $v = $item['nilai'] ?? 0;
                        $clrs = [4=>'#059669', 3=>'#2563eb', 2=>'#ea580c', 1=>'#dc2626'];
                        $lbls = [4=>'Sangat Baik (4)', 3=>'Baik (3)', 2=>'Cukup (2)', 1=>'Kurang (1)'];
                    @endphp
                    <tr>
                        <td>{{ $idx+1 }}</td>
                        <td class="left"><strong>{{ $item['siswa'] ?? '—' }}</strong></td>
                        <td class="left">{{ $item['kriteria'] ?? '—' }}</td>
                        <td>
                            <span style="font-family:var(--mono);font-weight:800;font-size:15px;color:{{ $clrs[$v] ?? '#64748b' }};">
                                {{ $v ?: '—' }}
                            </span>
                        </td>
                        <td class="left" style="color:var(--ink-3);">{{ $lbls[$v] ?? ($item['sub_nama'] ?? '—') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:var(--ink-3);">
                            Data penilaian tidak tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="summary-bar">
            <span>Total Data: <strong>{{ count($data['detail'] ?? []) }}</strong> record</span>
        </div>
    </div>

@endif
{{-- END JENIS --}}

@endsection

@push('scripts')
<script>
/* Isi tanggal cetak secara dinamis */
document.addEventListener('DOMContentLoaded', function () {
    const now    = new Date();
    const opts   = { day:'2-digit', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit' };
    const tgl    = now.toLocaleDateString('id-ID', opts);
    const elKop  = document.getElementById('tgl-cetak');
    const elTtd  = document.getElementById('ttd-tanggal');
    if (elKop) elKop.textContent = tgl;
    if (elTtd) elTtd.textContent = 'Dicetak: ' + tgl;
});
</script>
@endpush