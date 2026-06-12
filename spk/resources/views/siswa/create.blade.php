@extends('layouts.app')

@section('title', 'Tambah Siswa — SPK Siswa Terbaik')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
:root {
    --ink:#0d1526; --ink-2:#3a4761; --ink-3:#7a8aaa;
    --surface:#fff; --surface-2:#f5f7fc; --surface-3:#edf0f9;
    --border:#e0e6f5; --border-2:#c5d0e8;
    --accent:#2563eb; --accent-dk:#1d4ed8;
    --accent-glow:rgba(37,99,235,.12); --accent-lt:#eff6ff;
    --green:#059669; --green-bg:#ecfdf5;
    --red:#dc2626; --red-bg:#fef2f2; --red-bd:#fca5a5;
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(13,21,38,.05);
    --sh-sm:0 2px 8px rgba(13,21,38,.07);
}
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:26px;flex-wrap:wrap;}
.ph-title{font-size:23px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:12px;margin-bottom:5px;}
.t-icon{width:40px;height:40px;flex-shrink:0;background:linear-gradient(135deg,#2563eb,#6366f1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 6px 16px rgba(37,99,235,.30);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:52px;line-height:1.6;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 26px;}

/* INFO BANNER */
.info-banner{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--r-sm);background:#eff6ff;border:1.5px solid #bfdbfe;font-size:13px;color:#1e40af;line-height:1.6;margin-bottom:22px;}
.info-banner strong{font-weight:700;}

/* CARD — satu kolom tengah */
.card-wrap{max-width:560px;margin:0 auto;}
.card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.card-head{padding:18px 22px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;gap:12px;background:var(--surface-2);}
.ch-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;flex-shrink:0;}
.ci-blue{background:linear-gradient(135deg,#2563eb,#1d4ed8);}
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
.fi,.fs{
    padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r-sm);
    font-family:var(--sans);font-size:13px;color:var(--ink);
    background:var(--surface);outline:none;
    transition:border-color .15s,box-shadow .15s;
}
.fi:focus,.fs:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-glow);}
.fi::placeholder{color:var(--ink-3);}
.fi.err,.fs.err{border-color:var(--red);}
.ferr{font-size:11.5px;color:var(--red);}
.fhint{font-size:11px;color:var(--ink-3);}

/* FOTO */
.foto-area{
    border:2px dashed var(--border-2);border-radius:var(--r-lg);
    padding:22px 16px;text-align:center;cursor:pointer;position:relative;
    transition:border-color .15s,background .15s;
}
.foto-area:hover{border-color:var(--accent);background:var(--accent-lt);}
.foto-area input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;}
.fp{display:none;justify-content:center;margin-bottom:12px;}
.fp img{width:76px;height:76px;object-fit:cover;border-radius:50%;border:3px solid var(--accent-lt);}
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
            <span class="t-icon">➕</span>
            Tambah Data Siswa
        </h1>
        <p class="ph-sub">Input identitas siswa. Nilai akan diinput oleh <strong>Wali Kelas</strong> melalui menu <strong>Input Nilai</strong>.</p>
    </div>
</div>
<hr class="divider">

{{-- Info banner --}}
<div class="info-banner">
    ℹ️ Halaman ini hanya untuk data <strong>identitas siswa</strong>.
    Setelah siswa ditambahkan, minta <strong>Wali Kelas</strong> untuk menginput nilai melalui menu
    <strong>Input Nilai → Pilih siswa → Input</strong>.
</div>

@if($errors->any())
<div class="alert alert-error">
    ⚠ Terdapat {{ $errors->count() }} kesalahan. Periksa isian di bawah.
</div>
@endif

<div class="card-wrap">
    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data" id="formSiswa">
    @csrf

    <div class="card">
        <div class="card-head">
            <div class="ch-icon ci-blue">👤</div>
            <div>
                <div class="ch-title">Identitas Siswa</div>
                <div class="ch-sub">Isi data dasar siswa dengan lengkap dan benar</div>
            </div>
        </div>

        <div class="card-body">
            <div class="field-stack">

                {{-- Foto --}}
                <div class="field">
                    <span class="fl">Foto Profil <span style="color:var(--ink-3);font-weight:500">(opsional)</span></span>
                    <div class="foto-area" id="fotoArea">
                        <input type="file" name="foto" accept="image/*" id="fotoInput" onchange="previewFoto(this)">
                        <div class="fp" id="fotoPreview">
                            <img id="fotoImg" src="#" alt="Preview">
                        </div>
                        <div id="fotoIcon" style="font-size:30px;margin-bottom:7px;opacity:.35">🖼️</div>
                        <div class="fat"><strong>Klik untuk upload</strong> atau seret ke sini</div>
                        <div class="fah">JPG, PNG, WebP · Maks. 2 MB</div>
                    </div>
                    @error('foto')
                        <span class="ferr">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- NIS + Jenis Kelamin --}}
                <div class="field-row">
                    <div class="field">
                        <label class="fl" for="nis">NIS <span class="req">*</span></label>
                        <input type="text" id="nis" name="nis"
                               value="{{ old('nis') }}"
                               placeholder="cth. 2212108"
                               class="fi {{ $errors->has('nis') ? 'err' : '' }}">
                        @error('nis')
                            <span class="ferr">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="fl" for="jk">Jenis Kelamin <span class="req">*</span></label>
                        <select id="jk" name="jenis_kelamin"
                                class="fs {{ $errors->has('jenis_kelamin') ? 'err' : '' }}">
                            <option value="L" {{ old('jenis_kelamin','L') === 'L' ? 'selected' : '' }}>♂ Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>♀ Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="ferr">⚠ {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Nama --}}
                <div class="field">
                    <label class="fl" for="nama">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="nama" name="nama"
                           value="{{ old('nama') }}"
                           placeholder="cth. Ahmad Fauzi"
                           class="fi {{ $errors->has('nama') ? 'err' : '' }}">
                    @error('nama')
                        <span class="ferr">⚠ {{ $message }}</span>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="field">
                    <label class="fl" for="kelas">Kelas <span class="req">*</span></label>
                    <select id="kelas" name="kelas"
                            class="fs {{ $errors->has('kelas') ? 'err' : '' }}">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }}>
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
                Simpan Siswa
            </button>
        </div>
    </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('fotoImg').src = e.target.result;
        document.getElementById('fotoPreview').style.display = 'flex';
        document.getElementById('fotoIcon').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
document.getElementById('formSiswa').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '⏳ Menyimpan...';
});
</script>
@endpush