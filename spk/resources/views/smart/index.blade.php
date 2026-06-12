@extends('layouts.app')

@section('title', 'Perhitungan SMART – SPK Siswa Terbaik')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0a0f1e; --ink-2:#2d3748; --ink-3:#64748b;
    --surface:#fff; --surface-2:#f8fafc; --surface-3:#f1f5f9;
    --border:#e2e8f0; --border-2:#cbd5e1;
    --accent:#2563eb; --accent-dark:#1d4ed8; --accent-lt:#eff6ff;
    --gold:#f59e0b; --gold-bg:#fffbeb; --gold-bd:#fde68a;
    --silver:#94a3b8; --silver-bg:#f8fafc; --silver-bd:#e2e8f0;
    --bronze:#b45309; --bronze-bg:#fff7ed; --bronze-bd:#fed7aa;
    --green:#059669; --green-bg:#ecfdf5; --green-bd:#6ee7b7;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --purple:#7c3aed; --purple-bg:#f5f3ff; --purple-bd:#ddd6fe;
    --mono:'JetBrains Mono',monospace;
    --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px; --r-2xl:24px;
    --sh-xs:0 1px 3px rgba(10,15,30,.06);
    --sh-sm:0 4px 16px rgba(10,15,30,.08);
    --sh-md:0 8px 32px rgba(10,15,30,.10);
    --sh-xl:0 24px 64px rgba(10,15,30,.14);
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

/* ── PAGE HEADER ── */
.ph { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.ph-title { font-size:24px; font-weight:900; color:var(--ink); display:flex; align-items:center; gap:12px; margin-bottom:5px; letter-spacing:-.5px; }
.t-icon { width:42px; height:42px; background:linear-gradient(135deg,#2563eb,#7c3aed); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; box-shadow:0 6px 20px rgba(37,99,235,.3); }
.ph-sub { font-size:13px; color:var(--ink-3); padding-left:54px; line-height:1.6; max-width:580px; }
.divider { border:none; border-top:1.5px solid var(--border); margin:0 0 24px; }

/* ── PERIODE SELECTOR ── */
.periode-bar { display:flex; align-items:center; gap:12px; padding:14px 18px; background:var(--surface); border:1.5px solid var(--border); border-radius:var(--r-lg); margin-bottom:24px; flex-wrap:wrap; box-shadow:var(--sh-xs); }
.periode-label { font-size:12px; font-weight:700; color:var(--ink-3); white-space:nowrap; }
.periode-select { padding:8px 14px; border:1.5px solid var(--border); border-radius:var(--r-sm); font-family:var(--sans); font-size:13px; font-weight:600; color:var(--ink); background:var(--surface-2); outline:none; cursor:pointer; transition:border-color .15s; }
.periode-select:focus { border-color:var(--accent); }
.btn-hitung { display:inline-flex; align-items:center; gap:7px; padding:8px 18px; background:var(--accent); color:#fff; border:none; border-radius:var(--r-sm); font-family:var(--sans); font-size:13px; font-weight:700; cursor:pointer; transition:background .15s; text-decoration:none; }
.btn-hitung:hover { background:var(--accent-dark); }
.btn-hitung:disabled { opacity:.45; cursor:not-allowed; }
.periode-aktif-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; background:var(--green-bg); color:var(--green); border:1.5px solid var(--green-bd); border-radius:20px; font-size:11px; font-weight:700; }

/* ── WINNER PODIUM ── */
.podium-section { margin-bottom:28px; }
.podium-grid { display:grid; grid-template-columns:1fr 1.1fr 1fr; gap:14px; }
@media(max-width:700px) { .podium-grid { grid-template-columns:1fr; } }
.podium-card { border-radius:var(--r-xl); padding:24px 20px; text-align:center; border:2px solid; position:relative; overflow:hidden; transition:transform .2s, box-shadow .2s; }
.podium-card:hover { transform:translateY(-3px); box-shadow:var(--sh-md); }
.podium-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; }
.podium-1 { background:linear-gradient(135deg,#fffbeb,#fef3c7); border-color:var(--gold-bd); }
.podium-1::before { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
.podium-2 { background:linear-gradient(135deg,#f8fafc,#f1f5f9); border-color:var(--silver-bd); }
.podium-2::before { background:linear-gradient(90deg,#94a3b8,#cbd5e1); }
.podium-3 { background:linear-gradient(135deg,#fff7ed,#fed7aa30); border-color:var(--bronze-bd); }
.podium-3::before { background:linear-gradient(90deg,#b45309,#d97706); }
.rank-medal { font-size:36px; margin-bottom:10px; display:block; }
.rank-num-abs { position:absolute; top:14px; right:14px; font-size:11px; font-weight:800; font-family:var(--mono); opacity:.5; }
.podium-avatar { width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:800; color:#fff; margin:0 auto 12px; object-fit:cover; border:3px solid rgba(255,255,255,.8); box-shadow:0 4px 12px rgba(0,0,0,.15); }
.av-m { background:linear-gradient(135deg,#3b82f6,#1d4ed8); }
.av-f { background:linear-gradient(135deg,#ec4899,#be185d); }
.podium-name { font-size:15px; font-weight:800; color:var(--ink); margin-bottom:3px; }
.podium-nis { font-size:11px; color:var(--ink-3); font-family:var(--mono); margin-bottom:8px; }
.podium-kelas { display:inline-flex; align-items:center; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:700; background:rgba(255,255,255,.7); color:var(--ink-2); margin-bottom:12px; }
.podium-skor { font-size:28px; font-weight:900; font-family:var(--mono); letter-spacing:-1px; }
.podium-1 .podium-skor { color:#b45309; }
.podium-2 .podium-skor { color:#475569; }
.podium-3 .podium-skor { color:#92400e; }
.podium-skor-label { font-size:10px; font-weight:600; color:var(--ink-3); margin-top:2px; }

/* ── SECTION CARD ── */
.section-card { background:var(--surface); border:1.5px solid var(--border); border-radius:var(--r-xl); overflow:hidden; box-shadow:var(--sh-xs); margin-bottom:22px; }
.section-head { display:flex; align-items:center; justify-content:space-between; padding:16px 22px; border-bottom:1.5px solid var(--border); background:var(--surface-2); flex-wrap:wrap; gap:10px; }
.section-title { font-size:14px; font-weight:800; color:var(--ink); display:flex; align-items:center; gap:8px; }
.section-sub { font-size:12px; color:var(--ink-3); margin-top:2px; }
.section-body { padding:0; overflow-x:auto; }

/* ── TABLES ── */
table { width:100%; border-collapse:collapse; font-size:12.5px; }
thead tr { background:var(--surface-2); }
thead th { padding:10px 14px; font-size:10px; font-weight:700; color:var(--ink-3); text-transform:uppercase; letter-spacing:.6px; border-bottom:1.5px solid var(--border); white-space:nowrap; text-align:center; }
thead th.left { text-align:left; }
tbody tr { border-bottom:1px solid var(--surface-3); transition:background .1s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:#f8faff; }
tbody td { padding:11px 14px; color:var(--ink); vertical-align:middle; text-align:center; white-space:nowrap; }
tbody td.left { text-align:left; }

/* CHECKBOX COL */
.chk-col { width:44px; }
/* ROW SELECTED */
tbody tr.row-selected { background:#eff6ff !important; }

/* RANK CELL */
.rank-cell { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; font-size:12px; font-weight:800; font-family:var(--mono); }
.rank-1 { background:var(--gold-bg); color:#92400e; border:2px solid var(--gold-bd); }
.rank-2 { background:var(--silver-bg); color:#475569; border:2px solid var(--silver-bd); }
.rank-3 { background:var(--bronze-bg); color:var(--bronze); border:2px solid var(--bronze-bd); }
.rank-n { background:var(--surface-3); color:var(--ink-3); border:1.5px solid var(--border); }

/* SISWA CELL */
.siswa-cell { display:flex; align-items:center; gap:9px; }
.s-avatar { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:#fff; flex-shrink:0; object-fit:cover; }

/* VALUE CELLS — disesuaikan untuk skala 0–100 */
.val-mono { font-family:var(--mono); font-size:12px; font-weight:600; }
.val-high { color:var(--green); font-weight:700; }
.val-mid  { color:var(--accent); }
.val-low  { color:var(--ink-3); }

/* SKOR TOTAL */
.skor-total { font-family:var(--mono); font-size:14px; font-weight:800; padding:4px 10px; border-radius:6px; }
.skor-1 { background:var(--gold-bg); color:#92400e; }
.skor-2 { background:var(--silver-bg); color:#475569; }
.skor-3 { background:var(--bronze-bg); color:var(--bronze); }
.skor-n { background:var(--accent-lt); color:var(--accent); }

/* BOBOT BADGE */
.bobot-val { display:inline-block; font-family:var(--mono); font-size:12px; font-weight:700; padding:3px 10px; border-radius:6px; background:var(--accent-lt); color:var(--accent); }

/* PROGRESS BAR SKOR */
.skor-bar-wrap { display:flex; align-items:center; gap:10px; }
.skor-bar { flex:1; height:6px; background:var(--surface-3); border-radius:3px; overflow:hidden; min-width:60px; }
.skor-bar-fill { height:100%; border-radius:3px; transition:width .6s cubic-bezier(.4,0,.2,1); }
.skor-bar-val { font-family:var(--mono); font-size:12px; font-weight:700; min-width:54px; text-align:right; }

/* BADGE DIPILIH */
.badge-dipilih { background:var(--accent-lt); color:var(--accent); padding:5px 13px; border-radius:20px; font-size:12px; font-weight:700; border:1.5px solid #bfdbfe; }

/* EMPTY / ALERT */
.empty-box { text-align:center; padding:60px 20px; }
.empty-icon { font-size:52px; margin-bottom:14px; opacity:.35; }
.empty-title { font-size:16px; font-weight:800; color:var(--ink); margin-bottom:6px; }
.empty-sub { font-size:13px; color:var(--ink-3); line-height:1.6; }
.alert-box { display:flex; align-items:flex-start; gap:12px; padding:14px 18px; border-radius:var(--r-lg); margin-bottom:22px; }
.alert-warn { background:var(--gold-bg); border:1.5px solid var(--gold-bd); color:#92400e; }
.alert-info { background:var(--accent-lt); border:1.5px solid #bfdbfe; color:#1e40af; }
.alert-success { background:var(--green-bg); border:1.5px solid var(--green-bd); color:#065f46; }

/* STEP BADGE */
.step-badge { display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:50%; background:var(--accent); color:#fff; font-size:10px; font-weight:800; flex-shrink:0; }

/* TIPE BADGE */
.tipe-benefit { background:var(--green-bg); color:var(--green); border:1px solid var(--green-bd); font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px; }
.tipe-cost    { background:var(--red-bg); color:var(--red); border:1px solid var(--red-bd); font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px; }

/* PRINT */
@media print {
    .ph, .periode-bar, .no-print,
    .podium-section, .alert-box, .step-badge, .t-icon,
    .s-avatar, .skor-bar, .periode-aktif-badge,
    #formSeleksi { display:none !important; }
    *, *::before, *::after { box-sizing:border-box !important; }
    body { background:#fff !important; font-family:'Times New Roman',serif !important; color:#000 !important; font-size:11pt !important; }
    @page { size:A4 landscape; margin:1.5cm 1.5cm 2cm; }
    body::before {
        content:'HASIL PERHITUNGAN SMART\A Sistem Pendukung Keputusan Pemilihan Siswa Terbaik\A SMPN 2 Keo Tengah Satap';
        white-space:pre; display:block; text-align:center;
        font-family:'Times New Roman',serif; font-size:13pt; font-weight:bold;
        border-bottom:2px solid #000; padding-bottom:10px; margin-bottom:18px; line-height:1.8;
    }
    .section-card { box-shadow:none !important; border:1px solid #333 !important; border-radius:0 !important; margin-bottom:20px !important; page-break-inside:avoid; }
    .section-head { background:#e8e8e8 !important; border-bottom:1px solid #333 !important; padding:7px 12px !important; border-radius:0 !important; }
    .section-title { font-size:11pt !important; font-weight:bold !important; color:#000 !important; }
    .section-sub { font-size:9pt !important; color:#333 !important; }
    table { width:100% !important; border-collapse:collapse !important; font-size:9.5pt !important; font-family:'Times New Roman',serif !important; }
    thead th { background:#d4d4d4 !important; color:#000 !important; font-weight:bold !important; border:1px solid #555 !important; padding:5px 8px !important; font-size:9pt !important; }
    tbody td { border:1px solid #888 !important; padding:5px 8px !important; color:#000 !important; font-size:9.5pt !important; background:#fff !important; }
    .val-mono,.val-high,.val-mid,.val-low,.skor-total,.bobot-val,.tipe-benefit,.tipe-cost { color:#000 !important; background:none !important; border:none !important; font-family:'Courier New',monospace !important; font-weight:bold !important; padding:0 !important; }
    .rank-cell { background:none !important; border:1px solid #555 !important; color:#000 !important; font-weight:bold !important; font-size:9.5pt !important; width:auto !important; height:auto !important; padding:2px 5px !important; border-radius:0 !important; }
    .skor-bar-wrap { display:block !important; }
    .skor-bar { display:none !important; }
    .skor-bar-val { display:block !important; font-size:10pt !important; }
    .divider { display:none !important; }
}

@media(max-width:768px) {
    .ph { flex-direction:column; }
    .podium-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════
     PAGE HEADER
════════════════════════════════════ --}}
<div class="ph">
    <div class="ph-left">
        <h1 class="ph-title">
            <span class="t-icon">🏆</span>
            Perhitungan SMART
        </h1>
        <p class="ph-sub">
            SMART menormalisasi nilai utility tiap siswa per kriteria, lalu mengalikannya dengan bobot AHP.
            Skor akhir = Σ (bobot × utility). Siswa dengan skor tertinggi adalah yang terbaik.
        </p>
    </div>

    {{-- Tombol Cetak — hanya muncul jika sudah dihitung --}}
    @if(($sudahDihitung ?? false) && ($tabelSkor ?? collect())->isNotEmpty())
        <button class="btn-hitung no-print" onclick="window.print()" style="background:var(--ink-2);">
            🖨️ Cetak Hasil
        </button>
    @endif
</div>
<hr class="divider">

{{-- ════════════════════════════════════
     PERIODE SELECTOR (GET)
════════════════════════════════════ --}}
<form method="GET" action="{{ route('smart.index') }}" class="no-print">
    <div class="periode-bar">
        <span class="periode-label">📅 Periode:</span>
        <select name="periode_id" class="periode-select" onchange="this.form.submit()">
            @foreach($periodes as $p)
                <option value="{{ $p->id }}" {{ $periodeId == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}
                    {{ $p->status === 'aktif' ? '(Aktif)' : '' }}
                </option>
            @endforeach
        </select>
        @if($periodeAktif && $periodeId == $periodeAktif->id)
            <span class="periode-aktif-badge">✓ Periode Aktif</span>
        @endif
        <div style="margin-left:auto;font-size:12px;color:var(--ink-3);">
            @if(($jumlahSiswa ?? 0) > 0)
                <strong style="color:var(--ink);">{{ $jumlahSiswa }}</strong> siswa dihitung
            @endif
        </div>
    </div>
</form>

{{-- ════════════════════════════════════
     STATE: Bobot AHP belum ada
════════════════════════════════════ --}}
@if($bobotBelumAda ?? false)

    <div class="alert-box alert-warn">
        <span style="font-size:22px">⚠️</span>
        <div>
            <div style="font-weight:800;margin-bottom:3px;">Bobot Kriteria Belum Dihitung</div>
            <div style="font-size:13px;">
                Silakan hitung bobot AHP terlebih dahulu melalui menu <strong>AHP</strong>
                sebelum menjalankan SMART.
            </div>
        </div>
    </div>

{{-- ════════════════════════════════════
     STATE: Nilai siswa belum ada
════════════════════════════════════ --}}
@elseif($nilaiBelumAda ?? false)

    <div class="alert-box alert-info">
        <span style="font-size:22px">ℹ️</span>
        <div>
            <div style="font-weight:800;margin-bottom:3px;">Belum Ada Data Nilai Siswa</div>
            <div style="font-size:13px;">
                Wali Kelas belum menginput nilai untuk periode
                <strong>{{ optional($periodeSeleksi)->nama_periode ?? 'ini' }}</strong>.
                Silakan input nilai terlebih dahulu.
            </div>
        </div>
    </div>

{{-- ════════════════════════════════════
     STATE: Data lengkap → tampilkan form seleksi + hasil
════════════════════════════════════ --}}
@else

    {{-- Notifikasi sukses setelah hitung --}}
    @if($sudahDihitung ?? false)
        <div class="alert-box alert-success no-print">
            <span style="font-size:22px">✅</span>
            <div>
                <div style="font-weight:800;margin-bottom:3px;">
                    Perhitungan Berhasil & Tersimpan ke Riwayat
                </div>
                <div style="font-size:13px;">
                    {{ $jumlahSiswa }} siswa telah dihitung.
                    Siswa terbaik: <strong>{{ ($tabelSkor ?? collect())->first()['nama'] ?? '-' }}</strong>
                    dengan skor <strong>{{ number_format(($tabelSkor ?? collect())->first()['total_skor'] ?? 0, 4) }}</strong>.
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════
         FORM SELEKSI SISWA (POST → hitung)
    ══════════════════════════════════════════════ --}}
    <form method="POST"
          action="{{ route('smart.hitung') }}"
          id="formSeleksi"
          class="no-print">
        @csrf
        <input type="hidden" name="periode_id" value="{{ $periodeId }}">

        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">
                        👨‍🎓 Pilih Siswa yang Akan Dihitung
                    </div>
                    <div class="section-sub">
                        Centang siswa yang ingin diproses — minimal 4 siswa
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <span class="badge-dipilih" id="badge">0 dipilih</span>
                    <button type="button"
                            onclick="pilihSemua()"
                            class="btn-hitung"
                            style="background:var(--ink-3);">
                        ✓ Pilih Semua
                    </button>
                    <button type="submit"
                            id="btnHitung"
                            class="btn-hitung"
                            disabled>
                        🧮 Hitung SMART
                    </button>
                </div>
            </div>

            {{-- Error validasi --}}
            @error('siswa_ids')
                <div style="padding:10px 22px;background:var(--red-bg);color:var(--red);font-size:13px;font-weight:600;border-bottom:1px solid var(--red-bd);">
                    ⚠️ {{ $message }}
                </div>
            @enderror

            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th class="chk-col">
                                <input type="checkbox" id="chkAll">
                            </th>
                            <th class="left" style="min-width:180px;">Nama Siswa</th>
                            <th style="min-width:80px;">Kelas</th>
                            @foreach($kriterias as $k)
                                <th title="{{ $k->nama }}">
                                    {{ $k->kode }}
                                    <div style="font-size:9px;font-weight:500;opacity:.7;text-transform:none;">
                                        {{ Str::limit($k->nama, 10) }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        {{--
                            $daftarSiswa adalah Collection of array dari controller.
                            Setiap item: ['siswa_id', 'nama', 'nis', 'kelas', 'foto',
                                          'initials', 'jenis_kelamin', 'nilai' => [kriteria_id => avg]]
                        --}}
                        @forelse($daftarSiswa as $siswa)
                            @php
                                $dipilihSebelumnya = in_array(
                                    $siswa['siswa_id'],
                                    $siswaIdsDipilih ?? []
                                );
                            @endphp
                            <tr class="{{ $dipilihSebelumnya ? 'row-selected' : '' }}"
                                id="tr-{{ $siswa['siswa_id'] }}">

                                <td class="chk-col">
                                    <input type="checkbox"
                                           name="siswa_ids[]"
                                           value="{{ $siswa['siswa_id'] }}"
                                           class="chk-siswa"
                                           {{ $dipilihSebelumnya ? 'checked' : '' }}
                                           onchange="onCheckChange(this)">
                                </td>

                                <td class="left">
                                    <div class="siswa-cell">
                                        @if(!empty($siswa['foto']))
                                            <img src="{{ Storage::url($siswa['foto']) }}"
                                                 class="s-avatar"
                                                 alt="{{ $siswa['nama'] }}">
                                        @else
                                            <div class="s-avatar {{ $siswa['jenis_kelamin'] === 'L' ? 'av-m' : 'av-f' }}">
                                                {{ $siswa['initials'] }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700;font-size:13px;">{{ $siswa['nama'] }}</div>
                                            <div style="font-size:10px;color:var(--ink-3);font-family:var(--mono);">{{ $siswa['nis'] }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span style="font-size:11px;font-weight:600;padding:2px 8px;background:var(--surface-3);border-radius:20px;color:var(--ink-2);">
                                        {{ $siswa['kelas'] }}
                                    </span>
                                </td>

                                @foreach($kriterias as $k)
                                    @php
                                        $v = round($siswa['nilai'][$k->id] ?? 0, 2);
                                        $colors = [4=>'#059669',3=>'#2563eb',2=>'#ea580c',1=>'#dc2626'];
                                        $labels = [4=>'SB',3=>'B',2=>'C',1=>'K'];
                                        // floor() untuk mapping label (nilai bisa berupa avg desimal)
                                        $vInt   = (int) floor($v);
                                    @endphp
                                    <td>
                                        @if($v > 0)
                                            <span style="font-family:var(--mono);font-size:14px;font-weight:800;color:{{ $colors[$vInt] ?? '#64748b' }};">
                                                {{ $v }}
                                            </span>
                                            <div style="font-size:9px;color:{{ $colors[$vInt] ?? '#64748b' }};font-weight:600;">
                                                {{ $labels[$vInt] ?? '' }}
                                            </div>
                                        @else
                                            <span style="color:var(--ink-3);">—</span>
                                        @endif
                                    </td>
                                @endforeach

                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + $kriterias->count() }}" style="padding:40px;text-align:center;color:var(--ink-3);">
                                    Tidak ada siswa yang memiliki data nilai untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- ══════════════════════════════════════════════
         HASIL PERHITUNGAN — hanya tampil setelah POST
    ══════════════════════════════════════════════ --}}
    @if($sudahDihitung ?? false)

        {{-- PODIUM TOP 3 --}}
        @if(($tabelSkor ?? collect())->count() >= 1)
            <div class="podium-section">
                <div style="font-size:13px;font-weight:700;color:var(--ink-3);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                    <span>🏅 Hasil Perankingan</span>
                    <span style="font-weight:400;">— {{ optional($periodeSeleksi)->nama_periode }}</span>
                </div>
                <div class="podium-grid">
                    @foreach([0,1,2] as $pos)
                        @if($tabelSkor->has($pos))
                            @php
                                $s = $tabelSkor[$pos];
                                $medals      = [0=>'🥇', 1=>'🥈', 2=>'🥉'];
                                $podiumClass = ['podium-1','podium-2','podium-3'];
                            @endphp
                            <div class="podium-card {{ $podiumClass[$pos] }}">
                                <span class="rank-num-abs">#{{ $pos + 1 }}</span>
                                <span class="rank-medal">{{ $medals[$pos] }}</span>
                                @if(!empty($s['foto']))
                                    <img src="{{ Storage::url($s['foto']) }}"
                                         class="podium-avatar"
                                         alt="{{ $s['nama'] }}">
                                @else
                                    <div class="podium-avatar {{ $s['jenis_kelamin'] === 'L' ? 'av-m' : 'av-f' }}">
                                        {{ $s['initials'] }}
                                    </div>
                                @endif
                                <div class="podium-name">{{ $s['nama'] }}</div>
                                <div class="podium-nis">{{ $s['nis'] }}</div>
                                <div class="podium-kelas">{{ $s['kelas'] }}</div>
                                <div class="podium-skor">{{ number_format($s['total_skor'], 4) }}</div>
                                <div class="podium-skor-label">Skor Akhir SMART</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- STEP 1: BOBOT KRITERIA --}}
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">
                        <span class="step-badge">1</span>
                        Bobot Kriteria dari AHP
                    </div>
                    <div class="section-sub">
                        Bobot dihitung menggunakan Analytical Hierarchy Process (AHP)
                    </div>
                </div>
                <div style="font-size:12px;color:var(--ink-3);">
                    Total:
                    <strong style="font-family:var(--mono);color:var(--ink);">
                        {{ number_format($bobotMap->sum(), 4) }}
                    </strong>
                </div>
            </div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            @foreach($kriterias as $k)
                                <th>
                                    <div style="font-size:11px;">{{ $k->kode }}</div>
                                    <div style="font-size:9px;font-weight:500;opacity:.7;text-transform:none;">
                                        {{ Str::limit($k->nama, 12) }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($kriterias as $k)
                                <td>
                                    <div class="bobot-val">
                                        {{ number_format($bobotMap[$k->id] ?? 0, 4) }}
                                    </div>
                                    <div style="margin-top:4px;">
                                        <span class="tipe-{{ $k->tipe }}">
                                            {{ $k->tipe === 'benefit' ? '↑ Benefit' : '↓ Cost' }}
                                        </span>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- STEP 2: NILAI AWAL --}}
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">
                        <span class="step-badge">2</span>
                        Tabel Nilai Awal Siswa
                    </div>
                    <div class="section-sub">Rata-rata nilai per kriteria (skala 1–4)</div>
                </div>
                <div style="font-size:12px;color:var(--ink-3);">
                    <strong style="color:#059669;">4</strong>=SB &nbsp;
                    <strong style="color:#2563eb;">3</strong>=B &nbsp;
                    <strong style="color:#ea580c;">2</strong>=C &nbsp;
                    <strong style="color:#dc2626;">1</strong>=K
                </div>
            </div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th class="left" style="width:200px;">Siswa</th>
                            @foreach($kriterias as $k)
                                <th>{{ $k->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabelNilai as $row)
                            <tr>
                                <td class="left">
                                    <div class="siswa-cell">
                                        @if(!empty($row['foto']))
                                            <img src="{{ Storage::url($row['foto']) }}"
                                                 class="s-avatar"
                                                 alt="{{ $row['nama'] }}">
                                        @else
                                            <div class="s-avatar {{ $row['jenis_kelamin'] === 'L' ? 'av-m' : 'av-f' }}">
                                                {{ $row['initials'] }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700;font-size:13px;">{{ $row['nama'] }}</div>
                                            <div style="font-size:10px;color:var(--ink-3);font-family:var(--mono);">{{ $row['nis'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                @foreach($kriterias as $k)
                                    @php
                                        $v    = $row['nilai'][$k->id] ?? 0;
                                        $vInt = (int) floor($v);
                                        $colors = [4=>'#059669',3=>'#2563eb',2=>'#ea580c',1=>'#dc2626'];
                                        $labels = [4=>'SB',3=>'B',2=>'C',1=>'K'];
                                    @endphp
                                    <td>
                                        <span style="font-family:var(--mono);font-size:15px;font-weight:800;color:{{ $colors[$vInt] ?? '#64748b' }};">
                                            {{ $v ?: '—' }}
                                        </span>
                                        @if($v)
                                            <div style="font-size:9px;color:{{ $colors[$vInt] ?? '#64748b' }};font-weight:600;">
                                                {{ $labels[$vInt] ?? '' }}
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- STEP 3: NORMALISASI UTILITY (skala 0–100) --}}
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">
                        <span class="step-badge">3</span>
                        Normalisasi Utility
                    </div>
                    <div class="section-sub">
                        Benefit: u = (v − min) / (max − min) × 100 &nbsp;|&nbsp;
                        Cost: u = (max − v) / (max − min) × 100 &nbsp;|&nbsp;
                        Hasil: 0.00 – 100.00
                    </div>
                </div>
                {{-- min-max per kriteria --}}
                <div style="font-size:11px;color:var(--ink-3);display:flex;gap:10px;flex-wrap:wrap;">
                    @foreach($kriterias as $k)
                        <span>
                            {{ $k->kode }}:
                            <span style="font-family:var(--mono);">
                                {{ $minMax[$k->id]['min'] ?? 0 }}–{{ $minMax[$k->id]['max'] ?? 0 }}
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th class="left" style="width:200px;">Siswa</th>
                            @foreach($kriterias as $k)
                                <th>{{ $k->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabelNormalisasi as $row)
                            <tr>
                                <td class="left">
                                    <span style="font-weight:700;font-size:13px;">{{ $row['nama'] }}</span>
                                </td>
                                @foreach($kriterias as $k)
                                    @php
                                        // Skala 0–100 (dari controller)
                                        $u = $row['utility'][$k->id] ?? 0;
                                    @endphp
                                    <td>
                                        <span class="val-mono {{ $u >= 80 ? 'val-high' : ($u >= 40 ? 'val-mid' : 'val-low') }}">
                                            {{ number_format($u, 4) }}
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- STEP 4: NILAI TERBOBOT & SKOR AKHIR --}}
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">
                        <span class="step-badge">4</span>
                        Nilai Terbobot & Skor Akhir
                    </div>
                    <div class="section-sub">
                        Skor per kriteria = bobot × utility. Skor akhir = Σ skor. Diurutkan dari tertinggi.
                    </div>
                </div>
            </div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th style="width:44px;">RANK</th>
                            <th class="left" style="width:200px;">Siswa</th>
                            @foreach($kriterias as $k)
                                <th>{{ $k->kode }}</th>
                            @endforeach
                            <th style="min-width:160px;">SKOR AKHIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxSkor = $tabelSkor->first()['total_skor'] ?? 1; @endphp
                        @foreach($tabelSkor as $rank => $row)
                            @php
                                $rankClass = match($rank) { 0=>'rank-1', 1=>'rank-2', 2=>'rank-3', default=>'rank-n' };
                                $skorClass = match($rank) { 0=>'skor-1', 1=>'skor-2', 2=>'skor-3', default=>'skor-n' };
                                $barColor  = match($rank) {
                                    0 => 'linear-gradient(90deg,#f59e0b,#fbbf24)',
                                    1 => 'linear-gradient(90deg,#94a3b8,#cbd5e1)',
                                    2 => 'linear-gradient(90deg,#b45309,#d97706)',
                                    default => 'linear-gradient(90deg,#2563eb,#6366f1)'
                                };
                                $pct = $maxSkor > 0
                                    ? ($row['total_skor'] / $maxSkor) * 100
                                    : 0;
                            @endphp
                            <tr style="{{ $rank === 0 ? 'background:linear-gradient(90deg,#fffbeb,transparent);' : '' }}">
                                <td>
                                    <span class="rank-cell {{ $rankClass }}">
                                        @if($rank === 0) 🥇
                                        @elseif($rank === 1) 🥈
                                        @elseif($rank === 2) 🥉
                                        @else {{ $rank + 1 }}
                                        @endif
                                    </span>
                                </td>
                                <td class="left">
                                    <div class="siswa-cell">
                                        @if(!empty($row['foto']))
                                            <img src="{{ Storage::url($row['foto']) }}"
                                                 class="s-avatar"
                                                 alt="{{ $row['nama'] }}">
                                        @else
                                            <div class="s-avatar {{ $row['jenis_kelamin'] === 'L' ? 'av-m' : 'av-f' }}">
                                                {{ $row['initials'] }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700;font-size:13px;">{{ $row['nama'] }}</div>
                                            <div style="font-size:10px;color:var(--ink-3);font-family:var(--mono);">{{ $row['kelas'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                @foreach($kriterias as $k)
                                    @php $sv = $row['skor_per_kriteria'][$k->id] ?? 0; @endphp
                                    <td>
                                        <span class="val-mono" style="color:var(--ink-2);">
                                            {{ number_format($sv, 4) }}
                                        </span>
                                    </td>
                                @endforeach
                                <td>
                                    <div class="skor-bar-wrap">
                                        <div class="skor-bar">
                                            <div class="skor-bar-fill"
                                                 style="width:{{ number_format($pct, 2) }}%;background:{{ $barColor }};"></div>
                                        </div>
                                        <span class="skor-bar-val">
                                            <span class="skor-total {{ $skorClass }}">
                                                {{ number_format($row['total_skor'], 4) }}
                                            </span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer ringkasan --}}
            <div style="padding:14px 22px;border-top:1.5px solid var(--border);background:var(--surface-2);
                        display:flex;align-items:center;gap:16px;flex-wrap:wrap;font-size:12px;color:var(--ink-3);">
                <span>🏆 Siswa Terbaik:
                    <strong style="color:var(--ink);">{{ $tabelSkor->first()['nama'] ?? '-' }}</strong>
                </span>
                <span>📊 Skor Tertinggi:
                    <strong style="font-family:var(--mono);color:var(--green);">
                        {{ number_format($tabelSkor->first()['total_skor'] ?? 0, 4) }}
                    </strong>
                </span>
                <span>👥 Total Dihitung:
                    <strong style="color:var(--ink);">{{ $tabelSkor->count() }} siswa</strong>
                </span>
                <span style="margin-left:auto;">📅 {{ optional($periodeSeleksi)->nama_periode }}</span>
            </div>
        </div>

    @endif
    {{-- akhir @if($sudahDihitung) --}}

@endif
{{-- akhir kondisi data lengkap --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Checkbox "Pilih Semua" (header) ──
    const chkAll = document.getElementById('chkAll');
    if (chkAll) {
        chkAll.addEventListener('change', function () {
            document.querySelectorAll('.chk-siswa')
                    .forEach(x => {
                        x.checked = this.checked;
                        highlightRow(x);
                    });
            updateBadge();
        });
    }

    // ── Tiap checkbox siswa ──
    document.querySelectorAll('.chk-siswa').forEach(x => {
        x.addEventListener('change', function () {
            highlightRow(this);
            syncChkAll();
            updateBadge();
        });
    });

    // Jalankan sekali untuk restore state setelah POST (siswa yang sudah dipilih)
    updateBadge();
    document.querySelectorAll('.chk-siswa').forEach(x => highlightRow(x));
});

// Tombol "Pilih Semua" toggle
function pilihSemua() {
    const items    = document.querySelectorAll('.chk-siswa');
    const allChk   = [...items].every(x => x.checked);
    items.forEach(x => {
        x.checked = !allChk;
        highlightRow(x);
    });
    const chkAll = document.getElementById('chkAll');
    if (chkAll) chkAll.checked = !allChk;
    updateBadge();
}

// Dipanggil dari onchange inline (fallback)
function onCheckChange(el) {
    highlightRow(el);
    syncChkAll();
    updateBadge();
}

// Update badge jumlah & disabled tombol
function updateBadge() {
    const n = document.querySelectorAll('.chk-siswa:checked').length;
    document.getElementById('badge').innerText = n + ' dipilih';
    document.getElementById('btnHitung').disabled = n < 4;
}

// Highlight baris yang diceklis
function highlightRow(el) {
    const tr = el.closest('tr');
    if (!tr) return;
    if (el.checked) {
        tr.classList.add('row-selected');
    } else {
        tr.classList.remove('row-selected');
    }
}

// Sinkronkan state chkAll
function syncChkAll() {
    const all     = document.querySelectorAll('.chk-siswa');
    const checked = document.querySelectorAll('.chk-siswa:checked');
    const chkAll  = document.getElementById('chkAll');
    if (!chkAll) return;
    chkAll.checked       = all.length > 0 && checked.length === all.length;
    chkAll.indeterminate = checked.length > 0 && checked.length < all.length;
}

// Animasi progress bar
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.skor-bar-fill').forEach((el, i) => {
        const target = el.style.width;
        el.style.width = '0%';
        setTimeout(() => { el.style.width = target; }, 200 + i * 100);
    });
});
</script>
@endpush