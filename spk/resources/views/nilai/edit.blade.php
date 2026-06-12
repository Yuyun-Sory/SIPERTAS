@extends('layouts.app')

@section('title', 'Edit Nilai – ' . $siswa->nama)

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
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(15,22,35,.05);
    --lv4-bg:#ecfdf5; --lv4-bd:#6ee7b7; --lv4-tx:#059669;
    --lv3-bg:#eff6ff; --lv3-bd:#93c5fd; --lv3-tx:#2563eb;
    --lv2-bg:#fff7ed; --lv2-bd:#fed7aa; --lv2-tx:#ea580c;
    --lv1-bg:#fef2f2; --lv1-bd:#fca5a5; --lv1-tx:#dc2626;
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.ph-title{font-size:22px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:10px;margin-bottom:4px;}
.t-icon{width:36px;height:36px;background:linear-gradient(135deg,#059669,#10b981);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;box-shadow:0 4px 12px rgba(5,150,105,.25);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:46px;line-height:1.5;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 24px;}

.form-layout{display:grid;grid-template-columns:260px 1fr;gap:22px;align-items:start;}
@media(max-width:860px){.form-layout{grid-template-columns:1fr;}}

/* SISWA CARD */
.siswa-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);position:sticky;top:80px;}
.siswa-banner{height:80px;background:linear-gradient(135deg,#059669,#7c3aed);position:relative;}
.siswa-avatar-wrap{position:absolute;bottom:-30px;left:50%;transform:translateX(-50%);}
.siswa-avatar{width:60px;height:60px;border-radius:50%;border:3px solid var(--surface);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff;object-fit:cover;box-shadow:0 4px 12px rgba(0,0,0,.15);}
.avatar-male{background:linear-gradient(135deg,#3b82f6,#1d4ed8);}
.avatar-female{background:linear-gradient(135deg,#ec4899,#be185d);}
.siswa-body{padding:40px 18px 18px;text-align:center;}
.siswa-name{font-size:15px;font-weight:800;color:var(--ink);margin-bottom:3px;}
.siswa-nis{font-size:11px;color:var(--ink-3);font-family:var(--mono);margin-bottom:12px;}
.siswa-meta{display:flex;flex-direction:column;gap:8px;border-top:1.5px solid var(--border);padding-top:12px;text-align:left;}
.meta-row{display:flex;justify-content:space-between;align-items:center;font-size:12.5px;}
.meta-key{color:var(--ink-3);font-weight:500;}
.kelas-badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:700;background:var(--accent-lt);color:var(--accent);}
.periode-badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:700;background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd);}

/* EDIT BADGE */
.edit-notice{display:flex;align-items:center;gap:8px;padding:10px 14px;
    background:#fff7ed;border:1.5px solid #fed7aa;border-radius:var(--r-sm);
    font-size:12px;color:#92400e;margin-top:14px;}

/* FORM CARD */
.form-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.form-head{padding:16px 22px;border-bottom:1.5px solid var(--border);}
.form-head-title{font-size:14px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:8px;margin-bottom:4px;}
.form-head-sub{font-size:12px;color:var(--ink-3);}
.form-body{padding:22px;display:flex;flex-direction:column;gap:22px;}

/* KRITERIA BLOCK */
.kriteria-block{border:1.5px solid var(--border);border-radius:var(--r-lg);overflow:hidden;}
.kriteria-header{display:flex;align-items:center;gap:10px;padding:14px 16px;background:var(--surface-2);border-bottom:1.5px solid var(--border);}
.k-kode{background:var(--accent);color:#fff;font-size:10px;font-weight:800;padding:3px 8px;border-radius:5px;font-family:var(--mono);}
.k-nama{font-size:13.5px;font-weight:700;color:var(--ink);flex:1;}
.k-tipe{font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;border:1.5px solid;}
.k-tipe.benefit{background:var(--lv4-bg);color:var(--lv4-tx);border-color:var(--lv4-bd);}
.k-tipe.cost{background:var(--lv1-bg);color:var(--lv1-tx);border-color:var(--lv1-bd);}

.level-options{display:grid;grid-template-columns:repeat(4,1fr);gap:0;}
.level-opt{position:relative;}
.level-opt input[type="radio"]{position:absolute;opacity:0;width:0;height:0;}
.level-label{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 8px;
    cursor:pointer;border-right:1px solid var(--border);transition:all .15s;text-align:center;}
.level-opt:last-child .level-label{border-right:none;}
.level-num{font-size:20px;font-weight:800;font-family:var(--mono);line-height:1;}
.level-text{font-size:10.5px;font-weight:700;line-height:1.3;}
.level-desc{font-size:10px;color:var(--ink-3);line-height:1.3;margin-top:2px;}

.lv-opt-4 .level-label:hover,.lv-opt-4 input:checked ~ .level-label{background:var(--lv4-bg);color:var(--lv4-tx);}
.lv-opt-3 .level-label:hover,.lv-opt-3 input:checked ~ .level-label{background:var(--lv3-bg);color:var(--lv3-tx);}
.lv-opt-2 .level-label:hover,.lv-opt-2 input:checked ~ .level-label{background:var(--lv2-bg);color:var(--lv2-tx);}
.lv-opt-1 .level-label:hover,.lv-opt-1 input:checked ~ .level-label{background:var(--lv1-bg);color:var(--lv1-tx);}

.form-actions{display:flex;gap:10px;padding:18px 22px;border-top:1.5px solid var(--border);background:var(--surface-2);}
.btn-submit{flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
    padding:11px;border:none;border-radius:var(--r-sm);background:var(--green);
    font-family:var(--sans);font-size:14px;font-weight:700;color:#fff;cursor:pointer;transition:background .15s;}
.btn-submit:hover{background:#047857;}
.btn-back{display:flex;align-items:center;justify-content:center;gap:7px;padding:11px 20px;
    border:1.5px solid var(--border);border-radius:var(--r-sm);background:var(--surface);
    font-family:var(--sans);font-size:13px;font-weight:600;color:var(--ink-3);
    text-decoration:none;transition:all .15s;}
.btn-back:hover{border-color:var(--ink-3);color:var(--ink);}

.progress-wrap{padding:14px 22px;background:var(--surface-2);border-bottom:1.5px solid var(--border);}
.progress-info{display:flex;justify-content:space-between;font-size:12px;font-weight:600;color:var(--ink-3);margin-bottom:6px;}
.progress-bar{height:6px;background:var(--surface-3);border-radius:3px;overflow:hidden;}
.progress-fill{height:100%;background:linear-gradient(90deg,var(--green),#10b981);border-radius:3px;transition:width .3s;}

.kriteria-block.invalid{border-color:var(--red-bd);}
.kriteria-block.invalid .kriteria-header{background:var(--red-bg);}
.valid-indicator{font-size:14px;margin-left:auto;}
</style>
@endpush

@section('content')

<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">✏️</span>
            Edit Nilai Siswa
        </h1>
        <p class="ph-sub">Memperbarui nilai untuk: <strong>{{ $siswa->nama }}</strong></p>
    </div>
</div>
<hr class="divider">

<form method="POST" action="{{ route('nilai.update', $siswa) }}" id="nilaiForm">
@csrf @method('PUT')
<input type="hidden" name="periode_id" value="{{ $periodeId }}">

<div class="form-layout">

    {{-- KOLOM KIRI --}}
    <div>
        <div class="siswa-card">
            <div class="siswa-banner">
                <div class="siswa-avatar-wrap">
                    @if($siswa->foto)
                        <img src="{{ Storage::url($siswa->foto) }}"
                             class="siswa-avatar" alt="{{ $siswa->nama }}">
                    @else
                        <div class="siswa-avatar {{ $siswa->jenis_kelamin === 'L' ? 'avatar-male' : 'avatar-female' }}">
                            {{ $siswa->initials }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="siswa-body">
                <div class="siswa-name">{{ $siswa->nama }}</div>
                <div class="siswa-nis">NIS: {{ $siswa->nis }}</div>
                <div class="siswa-meta">
                    <div class="meta-row">
                        <span class="meta-key">Kelas</span>
                        <span class="kelas-badge">{{ $siswa->kelas }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Periode</span>
                        <span class="periode-badge">
                            {{ optional($periodes->firstWhere('id', $periodeId))->nama_periode ?? 'Aktif' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Total Kriteria</span>
                        <span style="font-weight:700;color:var(--ink);">{{ $kriterias->count() }}</span>
                    </div>
                </div>
                <div class="edit-notice">
                    ⚠️ Nilai lama akan <strong>diganti</strong> dengan nilai baru.
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM --}}
    <div>
        <div class="form-card">
            <div class="form-head">
                <div class="form-head-title">✏️ Edit Penilaian</div>
                <div class="form-head-sub">Nilai yang sudah ada ditampilkan terseleksi. Ubah sesuai kebutuhan.</div>
            </div>

            {{-- PROGRESS --}}
            <div class="progress-wrap">
                <div class="progress-info">
                    <span id="progressLabel">Menghitung...</span>
                    <span id="progressPct"></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill" style="width:0%"></div>
                </div>
            </div>

            <div class="form-body">

                @foreach($kriterias as $kriteria)
                @php
                    $nilaiSaatIni = $nilaiSiswa[$kriteria->id] ?? null;
                @endphp
                <div class="kriteria-block" id="block-{{ $kriteria->id }}" data-kriteria="{{ $kriteria->id }}">
                    <div class="kriteria-header">
                        <span class="k-kode">{{ $kriteria->kode }}</span>
                        <span class="k-nama">{{ $kriteria->nama }}</span>
                        <span class="k-tipe {{ $kriteria->tipe }}">
                            {{ $kriteria->tipe === 'benefit' ? '↑ Benefit' : '↓ Cost' }}
                        </span>
                        <span class="valid-indicator" id="vi-{{ $kriteria->id }}">
                            {{ $nilaiSaatIni ? '✅' : '⬜' }}
                        </span>
                    </div>
                    <div class="level-options">
                        @foreach([4,3,2,1] as $level)
                        @php
                            $labels = [4=>'Sangat Baik',3=>'Baik',2=>'Cukup',1=>'Kurang'];
                            $sub    = $kriteria->subKriterias->firstWhere('level', $level);
                        @endphp
                        <div class="level-opt lv-opt-{{ $level }}">
                            <input type="radio"
                                   name="nilai[{{ $kriteria->id }}]"
                                   id="k{{ $kriteria->id }}_l{{ $level }}"
                                   value="{{ $level }}"
                                   {{ $nilaiSaatIni == $level ? 'checked' : '' }}
                                   onchange="updateProgress()">
                            <label class="level-label" for="k{{ $kriteria->id }}_l{{ $level }}">
                                <span class="level-num" style="color:var(--lv{{ $level }}-tx)">{{ $level }}</span>
                                <span class="level-text">{{ $labels[$level] }}</span>
                                @if($sub)
                                <span class="level-desc">{{ $sub->nama }}</span>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

            </div>

            <div class="form-actions">
                <a href="{{ route('nilai.index') }}" class="btn-back">← Kembali</a>
                <button type="submit" class="btn-submit">
                    💾 Perbarui Nilai
                </button>
            </div>
        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
const totalKriteria = {{ $kriterias->count() }};

function updateProgress() {
    const blocks = document.querySelectorAll('.kriteria-block');
    let filled = 0;

    blocks.forEach(block => {
        const kriteriaId = block.dataset.kriteria;
        const checked = block.querySelector(`input[name="nilai[${kriteriaId}]"]:checked`);
        const indicator = document.getElementById('vi-' + kriteriaId);

        if (checked) {
            filled++;
            block.classList.remove('invalid');
            indicator.textContent = '✅';
        } else {
            indicator.textContent = '⬜';
        }
    });

    const pct = Math.round((filled / totalKriteria) * 100);
    document.getElementById('progressLabel').textContent = filled + ' / ' + totalKriteria + ' kriteria diisi';
    document.getElementById('progressPct').textContent   = pct + '%';
    document.getElementById('progressFill').style.width  = pct + '%';
}

// Jalankan saat halaman dimuat untuk hitung nilai yang sudah ada
document.addEventListener('DOMContentLoaded', updateProgress);

document.getElementById('nilaiForm').addEventListener('submit', function(e) {
    const blocks = document.querySelectorAll('.kriteria-block');
    let allFilled = true;

    blocks.forEach(block => {
        const kriteriaId = block.dataset.kriteria;
        const checked = block.querySelector(`input[name="nilai[${kriteriaId}]"]:checked`);
        if (!checked) {
            block.classList.add('invalid');
            allFilled = false;
        }
    });

    if (!allFilled) {
        e.preventDefault();
        document.querySelector('.invalid')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        alert('Harap isi semua kriteria sebelum menyimpan.');
    }
});
</script>
@endpush