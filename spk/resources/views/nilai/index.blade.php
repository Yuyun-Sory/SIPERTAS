@extends('layouts.app')

@section('title', 'Input Nilai – SPK Siswa Terbaik')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0f1623; --ink-2:#3d4a5c; --ink-3:#7a8899;
    --surface:#fff; --surface-2:#f6f8fc; --surface-3:#eef1f8;
    --border:#e2e8f4; --border-2:#c8d3e8;
    --accent:#2563eb; --accent-dark:#1d4ed8; --accent-lt:#eff6ff;
    --green:#059669; --green-bg:#ecfdf5; --green-bd:#6ee7b7;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --orange:#ea580c; --orange-bg:#fff7ed; --orange-bd:#fed7aa;
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(15,22,35,.05);
    --sh-sm:0 2px 8px rgba(15,22,35,.07);
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.ph-title{font-size:22px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:10px;margin-bottom:4px;}
.t-icon{width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;box-shadow:0 4px 12px rgba(37,99,235,.25);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:46px;line-height:1.5;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 24px;}

/* PERIODE BANNER */
.periode-banner{display:flex;align-items:center;justify-content:space-between;gap:12px;
    padding:14px 18px;border-radius:var(--r-lg);margin-bottom:20px;flex-wrap:wrap;}
.pb-aktif{background:var(--green-bg);border:1.5px solid var(--green-bd);}
.pb-none{background:var(--orange-bg);border:1.5px solid var(--orange-bd);}
.pb-info{display:flex;align-items:center;gap:10px;}
.pb-icon{font-size:22px;}
.pb-label{font-size:12px;font-weight:600;color:var(--ink-3);}
.pb-nama{font-size:14px;font-weight:800;color:var(--ink);}
.pb-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;}
.pb-badge.aktif{background:var(--green);color:#fff;}
.pb-badge.none{background:var(--orange);color:#fff;}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px;}
.stat-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:16px;display:flex;align-items:center;gap:12px;box-shadow:var(--sh-xs);}
.stat-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.stat-val{font-size:22px;font-weight:800;color:var(--ink);line-height:1;font-family:var(--mono);}
.stat-lbl{font-size:11px;color:var(--ink-3);font-weight:600;margin-top:2px;}

/* INFO WALI KELAS */
.info-wali{display:flex;align-items:center;gap:10px;padding:12px 16px;
    border-radius:var(--r-sm);background:var(--accent-lt);border:1.5px solid #bfdbfe;
    font-size:12.5px;color:#1e40af;margin-bottom:20px;}

/* TABLE */
.table-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.table-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1.5px solid var(--border);gap:12px;flex-wrap:wrap;}
.table-title{font-size:14px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:8px;}
.count-badge{background:var(--accent-lt);color:var(--accent);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;}
.tbl-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:13px;min-width:600px;}
thead tr{background:var(--surface-2);}
thead th{padding:10px 16px;font-size:10px;font-weight:700;color:var(--ink-3);text-transform:uppercase;letter-spacing:.5px;border-bottom:1.5px solid var(--border);text-align:left;white-space:nowrap;}
thead th.center{text-align:center;}
tbody tr{border-bottom:1px solid var(--surface-3);transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f8faff;}
tbody td{padding:12px 16px;color:var(--ink);vertical-align:middle;}
tbody td.center{text-align:center;}

/* SISWA CELL */
.siswa-cell{display:flex;align-items:center;gap:10px;}
.siswa-avatar{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;flex-shrink:0;object-fit:cover;}
.avatar-male{background:linear-gradient(135deg,#3b82f6,#1d4ed8);}
.avatar-female{background:linear-gradient(135deg,#ec4899,#be185d);}
.siswa-name{font-weight:700;color:var(--ink);font-size:13px;}
.siswa-nis{font-size:11px;color:var(--ink-3);font-family:var(--mono);margin-top:1px;}
.kelas-badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:700;background:var(--accent-lt);color:var(--accent);}

/* STATUS */
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;}
.sb-lengkap{background:var(--green-bg);color:var(--green);border:1.5px solid var(--green-bd);}
.sb-belum{background:var(--red-bg);color:var(--red);border:1.5px solid var(--red-bd);}

/* ACTION */
.btn-input{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:var(--r-sm);font-size:12px;font-weight:700;text-decoration:none;transition:all .15s;border:1.5px solid;cursor:pointer;font-family:var(--sans);}
.btn-input.input{background:var(--accent-lt);color:var(--accent);border-color:#bfdbfe;}
.btn-input.input:hover{background:var(--accent);color:#fff;}
.btn-input.edit{background:var(--green-bg);color:var(--green);border-color:var(--green-bd);}
.btn-input.edit:hover{background:var(--green);color:#fff;}
.btn-input.disabled{background:var(--surface-2);color:var(--ink-3);border-color:var(--border);cursor:not-allowed;opacity:.6;}

/* EMPTY */
.empty-state{text-align:center;padding:56px 20px;color:var(--ink-3);}
.empty-icon{font-size:44px;margin-bottom:12px;opacity:.4;}
.empty-title{font-size:15px;font-weight:800;color:var(--ink);margin-bottom:6px;}
.empty-sub{font-size:13px;}
</style>
@endpush

@section('content')
@php
    $periodeAktif = $periodeAktif ?? null;
@endphp

{{-- PAGE HEADER --}}
<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">📊</span>
            Input Nilai Siswa
        </h1>
        <p class="ph-sub">
            @if(Auth::user()->role === 'wali_kelas')
                Input nilai siswa kelas <strong>{{ Auth::user()->kelas }}</strong>
            @else
                Kelola nilai seluruh siswa
            @endif
        </p>
    </div>
</div>
<hr class="divider">

{{-- PERIODE BANNER --}}
@if($periodeAktif)
<div class="periode-banner pb-aktif">
    <div class="pb-info">
        <span class="pb-icon">📅</span>
        <div>
            <div class="pb-label">Periode Aktif</div>
            <div class="pb-nama">{{ $periodeAktif->nama_periode }}</div>
        </div>
    </div>
    <span class="pb-badge aktif">✓ Aktif</span>
</div>
@else
<div class="periode-banner pb-none">
    <div class="pb-info">
        <span class="pb-icon">⚠️</span>
        <div>
            <div class="pb-label">Tidak ada periode aktif</div>
            <div class="pb-nama">Hubungi Admin untuk mengaktifkan periode</div>
        </div>
    </div>
    <span class="pb-badge none">Tidak Aktif</span>
</div>
@endif

{{-- INFO WALI KELAS --}}
@if(Auth::user()->role === 'wali_kelas')
<div class="info-wali">
    ℹ️ Anda hanya dapat menginput nilai siswa kelas <strong>{{ Auth::user()->kelas }}</strong>.
</div>
@endif

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--accent-lt);">👥</div>
        <div>
            <div class="stat-val">{{ $siswas->count() }}</div>
            <div class="stat-lbl">Total Siswa</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--green-bg);">✅</div>
        <div>
            <div class="stat-val">{{ $jumlahSudah }}</div>
            <div class="stat-lbl">Sudah Diinput</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--red-bg);">❌</div>
        <div>
            <div class="stat-val">{{ $jumlahBelum }}</div>
            <div class="stat-lbl">Belum Diinput</div>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-head">
        <div class="table-title">
            📋 Daftar Siswa
            <span class="count-badge">{{ $siswas->count() }} siswa</span>
        </div>
    </div>
    <div class="tbl-wrap">
        @if($siswas->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div class="empty-title">Tidak Ada Siswa</div>
            <div class="empty-sub">
                @if(Auth::user()->role === 'wali_kelas')
                    Tidak ada siswa di kelas {{ Auth::user()->kelas }}.
                @else
                    Belum ada data siswa.
                @endif
            </div>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th style="width:44px" class="center">NO</th>
                    <th>NAMA SISWA</th>
                    <th class="center">KELAS</th>
                    <th class="center">STATUS NILAI</th>
                    <th class="center" style="width:140px">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $i => $siswa)
                @php
                    $sudahInput = $sudahDiinput->contains($siswa->id);
                @endphp
                <tr>
                    <td class="center" style="font-size:12px;color:var(--ink-3);font-weight:600;">{{ $i+1 }}</td>
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
                    <td class="center">
                        <span class="kelas-badge">{{ $siswa->kelas }}</span>
                    </td>
                    <td class="center">
                        @if($sudahInput)
                            <span class="status-badge sb-lengkap">✓ Sudah Diinput</span>
                        @else
                            <span class="status-badge sb-belum">✗ Belum Diinput</span>
                        @endif
                    </td>
                    <td class="center">
                        @if(!$periodeAktif)
                            <span class="btn-input disabled">Tidak Ada Periode</span>
                        @elseif($sudahInput)
                            <a href="{{ route('nilai.edit', [$siswa, 'periode_id' => $periodeAktif->id]) }}"
                               class="btn-input edit">✏️ Edit Nilai</a>
                        @else
                            <a href="{{ route('nilai.create', [$siswa, 'periode_id' => $periodeAktif->id]) }}"
                               class="btn-input input">📝 Input Nilai</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div style="padding:12px 20px;border-top:1.5px solid var(--border);background:var(--surface-2);
                font-size:12px;color:var(--ink-3);display:flex;gap:14px;flex-wrap:wrap;">
        <span>✅ Sudah diinput: <strong style="color:var(--green)">{{ $jumlahSudah }}</strong></span>
        <span>❌ Belum: <strong style="color:var(--red)">{{ $jumlahBelum }}</strong></span>
        @if($periodeAktif)
        <span style="margin-left:auto;">📅 Periode: <strong>{{ $periodeAktif->nama_periode }}</strong></span>
        @endif
    </div>
</div>

@endsection