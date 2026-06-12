@extends('layouts.app')

@section('title', 'Detail Siswa – ' . $siswa->nama)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0d1526; --ink-2:#3a4761; --ink-3:#7a8aaa;
    --surface:#fff; --surface-2:#f5f7fc; --surface-3:#edf0f9;
    --border:#e0e6f5; --border-2:#c5d0e8;
    --accent:#2563eb; --accent-dk:#1d4ed8; --accent-lt:#eff6ff;
    --green:#059669; --green-bg:#ecfdf5; --green-bd:#6ee7b7;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(13,21,38,.05);
    --sh-sm:0 2px 8px rgba(13,21,38,.07);
    --lv4-bg:#ecfdf5; --lv4-bd:#6ee7b7; --lv4-tx:#059669;
    --lv3-bg:#eff6ff; --lv3-bd:#93c5fd; --lv3-tx:#2563eb;
    --lv2-bg:#fff7ed; --lv2-bd:#fed7aa; --lv2-tx:#ea580c;
    --lv1-bg:#fef2f2; --lv1-bd:#fca5a5; --lv1-tx:#dc2626;
}
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:26px;flex-wrap:wrap;}
.ph-title{font-size:23px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:12px;margin-bottom:5px;}
.t-icon{width:40px;height:40px;flex-shrink:0;background:linear-gradient(135deg,#2563eb,#6366f1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 6px 16px rgba(37,99,235,.28);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:52px;line-height:1.6;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 26px;}

/* LAYOUT */
.detail-grid{display:grid;grid-template-columns:280px 1fr;gap:22px;align-items:start;}
@media(max-width:900px){.detail-grid{grid-template-columns:1fr;}}

/* PROFILE CARD */
.profile-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.profile-banner{height:90px;background:linear-gradient(135deg,#2563eb,#7c3aed);position:relative;}
.profile-avatar-wrap{position:absolute;bottom:-34px;left:50%;transform:translateX(-50%);}
.profile-avatar{width:68px;height:68px;border-radius:50%;border:4px solid var(--surface);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;object-fit:cover;box-shadow:0 4px 12px rgba(0,0,0,.15);}
.avatar-male{background:linear-gradient(135deg,#3b82f6,#1d4ed8);}
.avatar-female{background:linear-gradient(135deg,#ec4899,#be185d);}
.profile-body{padding:46px 22px 22px;text-align:center;}
.profile-name{font-size:17px;font-weight:800;color:var(--ink);margin-bottom:4px;}
.profile-nis{font-size:12px;color:var(--ink-3);margin-bottom:16px;font-family:var(--mono);}
.profile-meta{display:flex;flex-direction:column;gap:10px;text-align:left;border-top:1.5px solid var(--border);padding-top:16px;}
.meta-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;}
.meta-key{color:var(--ink-3);font-weight:500;}
.meta-val{font-weight:700;color:var(--ink);}
.kelas-badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:11.5px;font-weight:700;background:var(--accent-lt);color:var(--accent);}
.gender-l{background:#dbeafe;color:#1d4ed8;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:6px;}
.gender-p{background:#fce7f3;color:#be185d;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:6px;}

.profile-actions{display:flex;flex-direction:column;gap:8px;padding:16px 22px;border-top:1.5px solid var(--border);}
.btn-edit{display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border-radius:9px;border:1.5px solid var(--accent);background:var(--accent-lt);color:var(--accent);font-family:var(--sans);font-size:13px;font-weight:700;text-decoration:none;transition:all .15s;}
.btn-edit:hover{background:var(--accent);color:#fff;}
.btn-back{display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border-radius:9px;border:1.5px solid var(--border);background:var(--surface);color:var(--ink-3);font-family:var(--sans);font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;}
.btn-back:hover{border-color:var(--ink-3);color:var(--ink);}

/* CONTENT CARD */
.content-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.content-head{padding:16px 22px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
.content-title{font-size:14px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:8px;}
.content-body{padding:22px;}

/* TABS */
.tab-pills{display:flex;gap:6px;flex-wrap:wrap;}
.tab-pill{padding:6px 14px;border-radius:20px;font-size:12.5px;font-weight:600;border:1.5px solid var(--border);background:var(--surface);color:var(--ink-3);cursor:pointer;transition:all .15s;text-decoration:none;}
.tab-pill.active,.tab-pill:hover{border-color:var(--accent);background:var(--accent-lt);color:var(--accent);}

.periode-panel{display:none;}
.periode-panel.active{display:block;}

/* NILAI per kriteria */
.kriteria-section{margin-bottom:20px;}
.kriteria-section:last-child{margin-bottom:0;}
.kriteria-head{display:flex;align-items:center;gap:8px;margin-bottom:10px;}
.k-badge{background:var(--accent);color:#fff;font-size:11px;font-weight:800;padding:3px 9px;border-radius:6px;}
.k-title{font-size:13px;font-weight:700;color:var(--ink);}
.k-tipe{font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;border:1.5px solid;}
.k-tipe.benefit{background:var(--lv4-bg);color:var(--lv4-tx);border-color:var(--lv4-bd);}
.k-tipe.cost{background:var(--lv1-bg);color:var(--lv1-tx);border-color:var(--lv1-bd);}

/* Level card */
.level-result{display:inline-flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--r-lg);border:1.5px solid;}
.lv-4{background:var(--lv4-bg);border-color:var(--lv4-bd);color:var(--lv4-tx);}
.lv-3{background:var(--lv3-bg);border-color:var(--lv3-bd);color:var(--lv3-tx);}
.lv-2{background:var(--lv2-bg);border-color:var(--lv2-bd);color:var(--lv2-tx);}
.lv-1{background:var(--lv1-bg);border-color:var(--lv1-bd);color:var(--lv1-tx);}
.lv-num{font-size:22px;font-weight:800;font-family:var(--mono);}
.lv-label{font-size:13px;font-weight:700;}
.lv-sub{font-size:11px;opacity:.8;margin-top:2px;}

/* EMPTY */
.no-nilai{text-align:center;padding:48px 20px;color:var(--ink-3);}
.no-nilai-icon{font-size:40px;margin-bottom:12px;opacity:.35;}
.no-nilai-title{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:6px;}
.no-nilai-sub{font-size:13px;}
</style>
@endpush

@section('content')

{{-- Pastikan variabel selalu tersedia meski controller lupa kirim --}}
@php
    $nilaiByPeriode = $nilaiByPeriode ?? collect();
    $periodes       = $periodes       ?? collect();
    $kriterias      = $kriterias      ?? collect();
@endphp

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">👤</span>
            Detail Siswa
        </h1>
        <p class="ph-sub">Profil dan riwayat nilai: <strong>{{ $siswa->nama }}</strong></p>
    </div>
</div>
<hr class="divider">

<div class="detail-grid">

    {{-- ═══════════ KOLOM KIRI: PROFIL ═══════════ --}}
    <div>
        <div class="profile-card">

            {{-- Banner + Avatar --}}
            <div class="profile-banner">
                <div class="profile-avatar-wrap">
                    @if($siswa->foto)
                        <img src="{{ Storage::url($siswa->foto) }}"
                             class="profile-avatar" alt="{{ $siswa->nama }}">
                    @else
                        <div class="profile-avatar {{ $siswa->jenis_kelamin === 'L' ? 'avatar-male' : 'avatar-female' }}">
                            {{ $siswa->initials }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Utama --}}
            <div class="profile-body">
                <div class="profile-name">{{ $siswa->nama }}</div>
                <div class="profile-nis">NIS: {{ $siswa->nis }}</div>

                <div class="profile-meta">
                    <div class="meta-row">
                        <span class="meta-key">Kelas</span>
                        <span class="kelas-badge">{{ $siswa->kelas }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Jenis Kelamin</span>
                        @if($siswa->jenis_kelamin === 'L')
                            <span class="gender-l">♂ Laki-laki</span>
                        @else
                            <span class="gender-p">♀ Perempuan</span>
                        @endif
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Periode Tercatat</span>
                        <span class="meta-val">{{ $nilaiByPeriode->count() }} periode</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Ditambahkan</span>
                        <span class="meta-val">{{ $siswa->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="profile-actions">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn-edit">
                        ✏️ Edit Identitas Siswa
                    </a>
                @endif

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'wali_kelas')
                    <a href="{{ route('nilai.edit', $siswa) }}"
                       class="btn-edit"
                       style="background:var(--green-bg);border-color:var(--green-bd);color:var(--green);">
                        📊 Edit Nilai Siswa
                    </a>
                @endif

                <a href="{{ route('siswa.index') }}" class="btn-back">
                    ← Kembali ke Daftar
                </a>
            </div>

        </div>
    </div>
    {{-- akhir kolom kiri --}}

    {{-- ═══════════ KOLOM KANAN: NILAI PER PERIODE ═══════════ --}}
    <div>
        <div class="content-card">

            {{-- Header + Tab Pills --}}
            <div class="content-head">
                <div class="content-title">📊 Nilai Per Periode</div>

                @if($nilaiByPeriode->isNotEmpty())
                    <div class="tab-pills">
                        @php $firstTab = true; @endphp
                        @foreach($periodes as $periode)
                            @if($nilaiByPeriode->has($periode->id))
                                <a href="#"
                                   class="tab-pill {{ $firstTab ? 'active' : '' }}"
                                   onclick="switchTab(event, 'panel-{{ $periode->id }}')">
                                    {{ $periode->nama }}
                                    @if($periode->status === 'aktif')
                                        <span style="font-size:9px;margin-left:3px;">✓</span>
                                    @endif
                                </a>
                                @php $firstTab = false; @endphp
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- akhir content-head --}}

            {{-- Body: panel nilai per periode --}}
            <div class="content-body">

                @if($nilaiByPeriode->isEmpty())
                    {{-- Belum ada nilai sama sekali --}}
                    <div class="no-nilai">
                        <div class="no-nilai-icon">📋</div>
                        <div class="no-nilai-title">Belum Ada Nilai</div>
                        <div class="no-nilai-sub">
                            Nilai belum diinput oleh Wali Kelas.
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'wali_kelas')
                                <br>
                                <a href="{{ route('nilai.create', $siswa) }}"
                                   style="color:var(--accent);font-weight:700;">
                                    → Input nilai sekarang
                                </a>
                            @endif
                        </div>
                    </div>

                @else
                    {{-- Loop setiap periode yang punya data --}}
                    @php $firstPanel = true; @endphp

                    @foreach($periodes as $periode)
                        @if($nilaiByPeriode->has($periode->id))

                            <div class="periode-panel {{ $firstPanel ? 'active' : '' }}"
                                 id="panel-{{ $periode->id }}">

                                @php
                                    $nilaiRows = $nilaiByPeriode[$periode->id];

                                    // Map: kriteria_id => baris NilaiSiswa
                                    $nilaiByKriteria = $nilaiRows->keyBy(
                                        fn($n) => optional(optional($n->subKriteria)->kriteria)->id
                                    );

                                    $labels = [
                                        1 => 'Kurang',
                                        2 => 'Cukup',
                                        3 => 'Baik',
                                        4 => 'Sangat Baik',
                                    ];
                                @endphp

                                @foreach($kriterias as $kriteria)
                                    @php
                                        $nilaiRow = $nilaiByKriteria[$kriteria->id] ?? null;
                                        $lv       = $nilaiRow ? $nilaiRow->nilai : null;
                                    @endphp

                                    <div class="kriteria-section">
                                        <div class="kriteria-head">
                                            <span class="k-badge">{{ $kriteria->kode }}</span>
                                            <span class="k-title">{{ $kriteria->nama }}</span>
                                            <span class="k-tipe {{ $kriteria->tipe }}">
                                                {{ $kriteria->tipe === 'benefit' ? '↑ Benefit' : '↓ Cost' }}
                                            </span>
                                        </div>

                                        @if($lv)
                                            <div class="level-result lv-{{ $lv }}">
                                                <div class="lv-num">{{ $lv }}</div>
                                                <div class="lv-info">
                                                    <div class="lv-label">{{ $labels[$lv] ?? '-' }}</div>
                                                    @if($nilaiRow->subKriteria)
                                                        <div class="lv-sub">{{ $nilaiRow->subKriteria->nama }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span style="font-size:13px;color:var(--ink-3);font-style:italic;">
                                                — Belum diisi
                                            </span>
                                        @endif
                                    </div>
                                    {{-- akhir kriteria-section --}}

                                @endforeach
                                {{-- akhir foreach kriterias --}}

                            </div>
                            {{-- akhir periode-panel --}}

                            @php $firstPanel = false; @endphp

                        @endif
                    @endforeach
                    {{-- akhir foreach periodes --}}

                @endif
                {{-- akhir if/else nilaiByPeriode --}}

            </div>
            {{-- akhir content-body --}}

        </div>
        {{-- akhir content-card --}}
    </div>
    {{-- akhir kolom kanan --}}

</div>
{{-- akhir detail-grid --}}

@endsection

@push('scripts')
<script>
function switchTab(e, panelId) {
    e.preventDefault();
    document.querySelectorAll('.periode-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-pill').forEach(t => t.classList.remove('active'));
    document.getElementById(panelId).classList.add('active');
    e.currentTarget.classList.add('active');
}
</script>
@endpush