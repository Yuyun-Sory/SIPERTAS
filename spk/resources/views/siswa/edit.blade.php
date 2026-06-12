@extends('layouts.app')

@section('title', 'Edit Siswa – ' . $siswa->nama)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0d1526; --ink-2:#3a4761; --ink-3:#7a8aaa;
    --surface:#fff; --surface-2:#f5f7fc;
    --border:#e0e6f5; --border-2:#c5d0e8;
    --accent:#2563eb; --accent-dk:#1d4ed8;
    --accent-glow:rgba(37,99,235,.12); --accent-lt:#eff6ff;
    --amber:#d97706; --amber-bg:#fffbeb; --amber-bd:#fde68a;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(13,21,38,.05);
}
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:26px;flex-wrap:wrap;}
.ph-title{font-size:23px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:12px;margin-bottom:5px;}
.t-icon{width:40px;height:40px;flex-shrink:0;background:linear-gradient(135deg,#d97706,#b45309);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 6px 16px rgba(217,119,6,.28);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:52px;line-height:1.6;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 26px;}

/* INFO BANNER */
.info-banner{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--r-sm);background:var(--amber-bg);border:1.5px solid var(--amber-bd);font-size:13px;color:#92400e;line-height:1.6;margin-bottom:22px;}
.info-banner strong{font-weight:700;}

/* CARD */
.card-wrap{max-width:560px;margin:0 auto;}
.card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.card-head{padding:18px 22px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;gap:12px;background:var(--surface-2);}
.ch-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;flex-shrink:0;}
.ci-amber{background:linear-gradient(135deg,#d97706,#b45309);}
.ch-title{font-size:14px;font-weight:800;color:var(--ink);}
.ch-sub{font-size:11.5px;color:var(--ink-3);margin-top:2px;}
.card-body{padding:24px;}
.card-foot{padding:14px 22px;border-top:1.5px solid var(--border);background:var(--surface-2);display:flex;align-items:center;justify-content:flex-end;gap:8px;}

/* FIELDS */
.field-stack{display:flex;flex-direction:column;gap:18px;}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.field-row{grid-template-columns:1fr;}}
.field{display:flex;flex-direction:column;gap:6px;}
.fl{font-size:12px;font-weight:700;color:var(--ink);}
.fl .req{color:var(--red);margin-left:2px;}
.fi,.fs{padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:var(--sans);font-size:13px;color:var(--ink);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;}
.fi:focus,.fs:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-glow);}
.fi::placeholder{color:var(--ink-3);}
.fi.err,.fs.err{border-color:var(--red);}
.ferr{font-size:11.5px;color:var(--red);}

/* FOTO */
.foto-area{border:2px dashed var(--border-2);border-radius:var(--r-lg);padding:18px 16px;text-align:center;cursor:pointer;position:relative;transition:border-color .15s,background .15s;}
.foto-area:hover{border-color:var(--accent);background:var(--accent-lt);}
.foto-area input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;}
.current-foto{text-align:center;margin-bottom:12px;}
.current-foto img{width:68px;height:68px;object-fit:cover;border-radius:50%;border:3px solid var(--accent-lt);display:block;margin:0 auto 6px;}
.current-foto span{font-size:11px;color:var(--ink-3);}
.fp{display:none;justify-content:center;margin-bottom:10px;}
.fp img{width:68px;height:68px;object-fit:cover;border-radius:50%;border:3px solid var(--accent-lt);}
.fat{font-size:13px;color:var(--ink-3);}
.fat strong{color:var(--accent);}
.fah{font-size:11px;color:var(--ink-3);margin-top:4px;}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 22px;border-radius:var(--r-sm);font-family:var(--sans);font-size:13px;font-weight:700;border:1.5px solid transparent;cursor:pointer;text-decoration:none;transition:all .15s;white-space:nowrap;}
.btn svg{width:14px;height:14px;stroke:currentColor;flex-shrink:0;}
.btn-primary{background:var(--accent);color:#fff;border-color:var(--accent);box-shadow:0 3px 12px rgba(37,99,235,.32);}
.btn-primary:hover{background:var(--accent-dk);transform:translateY(-1px);}
.btn-primary:disabled{background:var(--ink-3);cursor:not-allowed;transform:none;box-shadow:none;}
.btn-ghost{background:var(--surface);color:var(--ink-3);border-color:var(--border-2);}
.btn-ghost:hover{border-color:var(--ink-3);color:var(--ink);}

.alert{padding:13px 18px;border-radius:var(--r-sm);margin-bottom:20px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:10px;border:1.5px solid;}
.alert-error{background:var(--red-bg);color:var(--red);border-color:var(--red-bd);}
</style>
@endpush

@section('content')

<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">✏️</span>
            Edit Data Siswa
        </h1>
        <p class="ph-sub">Memperbarui identitas siswa: <strong>{{ $siswa->nama }}</strong></p>
    </div>
</div>
<hr class="divider">

{{-- Info banner --}}
<div class="info-banner">
    ℹ️ Halaman ini hanya untuk mengedit <strong>identitas siswa</strong>.
    Untuk mengubah nilai, gunakan menu <strong>Input Nilai</strong> sebagai <strong>Wali Kelas</strong>.
</div>

@if($errors->any())
<div class="alert alert-error">
    ⚠ Terdapat {{ $errors->count() }} kesalahan. Periksa isian di bawah.
</div>
@endif

<div class="card-wrap">
    <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data" id="formSiswa">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-head">
            <div class="ch-icon ci-amber">✏️</div>
            <div>
                <div class="ch-title">Identitas Siswa</div>
                <div class="ch-sub">Perbarui data dasar siswa</div>
            </div>
        </div>

        <div class="card-body">
            <div class="field-stack">

                {{-- Foto --}}
                <div class="field">
                    <span class="fl">Foto Profil</span>
                    @if($siswa->foto)
                    <div class="current-foto">
                        <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}">
                        <span>Foto saat ini · Upload baru untuk mengganti</span>
                    </div>
                    @endif
                    <div class="foto-area">
                        <input type="file" name="foto" accept="image/*" id="fotoInput" onchange="previewFoto(this)">
                        <div class="fp" id="fotoPreview">
                            <img id="fotoImg" src="#" alt="Preview">
                        </div>
                        <div class="fat"><strong>Klik untuk ganti foto</strong></div>
                        <div class="fah">JPG, PNG, WebP · Maks 2 MB</div>
                    </div>
                    @error('foto')
                        <span class="ferr">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- NIS + Jenis Kelamin --}}
                <div class="field-row">
                    <div class="field">
                        <label class="fl">NIS <span class="req">*</span></label>
                        <input type="text" name="nis"
                               value="{{ old('nis', $siswa->nis) }}"
                               class="fi {{ $errors->has('nis') ? 'err' : '' }}">
                        @error('nis')
                            <span class="ferr">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="fl">Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" class="fs {{ $errors->has('jenis_kelamin') ? 'err' : '' }}">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>♂ Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>♀ Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="ferr">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Nama --}}
                <div class="field">
                    <label class="fl">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $siswa->nama) }}"
                           placeholder="cth. Ahmad Fauzi"
                           class="fi {{ $errors->has('nama') ? 'err' : '' }}">
                    @error('nama')
                        <span class="ferr">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="field">
                    <label class="fl">Kelas <span class="req">*</span></label>
                    <select name="kelas" class="fs {{ $errors->has('kelas') ? 'err' : '' }}">
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ old('kelas', $siswa->kelas) == $k ? 'selected' : '' }}>
                                {{ $k }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <span class="ferr">⚠ {{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card-foot">
            <a href="{{ route('siswa.index') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Batal
            </a>
            <button type="submit" class="btn btn-primary" id="btnSubmit">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Perbarui Data
            </button>
        </div>
    </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('fotoImg').src = e.target.result;
            document.getElementById('fotoPreview').style.display = 'flex';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
document.getElementById('formSiswa').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '⏳ Menyimpan...';
});
</script>
@endpush