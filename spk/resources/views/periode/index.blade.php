@extends('layouts.app')

@section('title', 'Periode - SPK Siswa Terbaik')
@section('page-title', 'Periode')
@section('page-subtitle', 'Manajemen periode penilaian siswa terbaik')

@push('styles')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-header h2 {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
    }

    .page-header p {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* ===== BUTTON ===== */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(29,78,216,0.25);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(29,78,216,0.35);
        color: white;
    }

    .btn-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.15s;
        text-decoration: none;
    }

    .btn-edit {
        background: #eff6ff;
        color: var(--primary);
        border: 1px solid #bfdbfe;
    }

    .btn-edit:hover {
        background: #dbeafe;
        color: var(--primary-dark);
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #fee2e2;
    }

    /* ===== CARD ===== */
    .card {
        background: var(--white);
        border-radius: 14px;
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
    }

    .card-header h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-header h3 i { color: var(--primary); }

    /* ===== TABLE ===== */
    .table-wrapper { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        padding: 12px 20px;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f8fafc;
        border-bottom: 1px solid var(--border);
        text-align: left;
        white-space: nowrap;
    }

    thead th.text-center { text-align: center; }

    tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #f8fafc; }

    /* Row nonaktif sedikit redup */
    tbody tr.row-nonaktif {
        opacity: 0.65;
    }

    tbody td {
        padding: 14px 20px;
        font-size: 13.5px;
        color: var(--text);
        vertical-align: middle;
    }

    tbody td.text-center { text-align: center; }
    tbody td.text-muted  { color: var(--text-muted); }

    /* ===== BADGE STATUS ===== */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-aktif {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-nonaktif {
        background: #f1f5f9;
        color: #94a3b8;
    }

    /* ===== BADGE READONLY ===== */
    .badge-readonly {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px dashed #cbd5e1;
        cursor: default;
    }

    /* ===== NO DATA ===== */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.3;
        display: block;
    }

    .no-data p {
        font-size: 14px;
        font-weight: 500;
    }

    .no-data span {
        font-size: 12px;
        display: block;
        margin-top: 4px;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
    }

    .modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modal {
        background: var(--white);
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        margin: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        transform: translateY(10px) scale(0.98);
        transition: all 0.2s;
        overflow: hidden;
    }

    .modal-overlay.show .modal {
        transform: translateY(0) scale(1);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }

    .modal-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-header h4 i { color: var(--primary); }

    .modal-close {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: var(--bg);
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.15s;
    }

    .modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .modal-body { padding: 24px; }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: #f8fafc;
    }

    /* ===== FORM ===== */
    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 7px;
    }

    .form-group label .required {
        color: #dc2626;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-family: inherit;
        font-size: 13.5px;
        color: var(--text);
        background: #f8fafc;
        transition: all 0.2s;
        outline: none;
    }

    .form-control:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
    }

    .form-control.is-invalid { border-color: #dc2626; }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #dc2626;
        margin-top: 5px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 9px;
        border: 1.5px solid var(--border);
        background: white;
        color: var(--text-muted);
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-cancel:hover {
        border-color: #94a3b8;
        color: var(--text);
    }

    /* ===== KONFIRMASI HAPUS ===== */
    .confirm-icon {
        width: 56px;
        height: 56px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        color: #dc2626;
    }

    .confirm-text {
        text-align: center;
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .confirm-text strong {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 9px;
        border: none;
        background: #dc2626;
        color: white;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-danger:hover { background: #b91c1c; }

    /* ===== INFO AKTIF ===== */
    .info-aktif {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
        color: var(--primary-dark);
    }

    .info-aktif i { font-size: 15px; flex-shrink: 0; }

    /* ===== INFO LOCK ===== */
    .info-lock {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #9a3412;
    }

    .info-lock i { font-size: 15px; flex-shrink: 0; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h2>Daftar Periode</h2>
        <p>Periode baru otomatis aktif — periode lama terkunci dan hanya bisa dilihat</p>
    </div>
    <button class="btn-primary" onclick="openModal('modalTambah')">
        <i class="fas fa-plus"></i> Tambah Periode
    </button>
</div>

{{-- Info Periode Aktif --}}
@php $periodeAktif = $periodes->where('status', 'aktif')->first(); @endphp
@if($periodeAktif)
<div class="info-aktif">
    <i class="fas fa-circle-check"></i>
    <span>Periode aktif saat ini: <strong>{{ $periodeAktif->nama_periode }}</strong>
    ({{ $periodeAktif->tanggal_mulai->format('d M Y') }} – {{ $periodeAktif->tanggal_selesai->format('d M Y') }})</span>
</div>
@endif

{{-- Info Lock --}}
@if($periodes->where('status', 'nonaktif')->count() > 0)
<div class="info-lock">
    <i class="fas fa-lock"></i>
    <span>Periode <strong>nonaktif</strong> bersifat terkunci — tidak dapat diedit maupun dihapus, hanya bisa dilihat.</span>
</div>
@endif

{{-- Tabel Periode --}}
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-calendar-days"></i> Data Periode</h3>
        <span style="font-size:12px;color:var(--text-muted);">
            Total: {{ $periodes->count() }} periode
        </span>
    </div>
    <div class="table-wrapper">
        @if($periodes->isEmpty())
            <div class="no-data">
                <i class="fas fa-calendar-xmark"></i>
                <p>Belum ada data periode</p>
                <span>Klik tombol "Tambah Periode" untuk menambahkan</span>
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th style="width:50px;" class="text-center">No</th>
                    <th>Nama Periode</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($periodes as $i => $periode)
                <tr class="{{ $periode->status === 'nonaktif' ? 'row-nonaktif' : '' }}">
                    <td class="text-center text-muted">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $periode->nama_periode }}</div>
                    </td>
                    <td>{{ $periode->tanggal_mulai->format('d M Y') }}</td>
                    <td>{{ $periode->tanggal_selesai->format('d M Y') }}</td>
                    <td class="text-muted">{{ $periode->keterangan ?? '-' }}</td>
                    <td class="text-center">
                        @if($periode->status === 'aktif')
                            <span class="badge badge-aktif">
                                <i class="fas fa-circle" style="font-size:7px;"></i> Aktif
                            </span>
                        @else
                            <span class="badge badge-nonaktif">
                                <i class="fas fa-circle" style="font-size:7px;"></i> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($periode->status === 'aktif')
                            {{-- Hanya periode aktif yang bisa diedit --}}
                            <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                                <button class="btn-sm btn-edit"
                                        onclick="openEdit(
                                            {{ $periode->id }},
                                            '{{ addslashes($periode->nama_periode) }}',
                                            '{{ $periode->tanggal_mulai->format('Y-m-d') }}',
                                            '{{ $periode->tanggal_selesai->format('Y-m-d') }}',
                                            '{{ addslashes($periode->keterangan ?? '') }}'
                                        )">
                                    <i class="fas fa-pen"></i> Edit
                                </button>
                            </div>
                        @else
                            {{-- Periode nonaktif: hanya bisa dilihat, terkunci --}}
                            <span class="badge-readonly">
                                <i class="fas fa-lock"></i> Terkunci
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- ===================== MODAL TAMBAH ===================== --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h4><i class="fas fa-plus-circle"></i> Tambah Periode</h4>
            <button class="modal-close" onclick="closeModal('modalTambah')">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
        {{-- Tampilkan error validasi --}}
@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:9px;padding:12px 14px;margin-bottom:16px;">
    <div style="font-size:12.5px;font-weight:700;color:#dc2626;margin-bottom:6px;">
        ⚠️ Periksa isian berikut:
    </div>
    <ul style="margin:0;padding-left:18px;font-size:12px;color:#dc2626;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
        <form action="{{ route('periode.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                {{-- Peringatan --}}
                <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;margin-bottom:18px;font-size:12.5px;color:#9a3412;line-height:1.5;">
                    <i class="fas fa-triangle-exclamation" style="margin-top:2px;flex-shrink:0;"></i>
                    <span>Menambahkan periode baru akan otomatis <strong>menonaktifkan periode yang sedang aktif</strong> dan periode lama tidak dapat diedit kembali.</span>
                </div>
                <div class="form-group">
                    <label>Nama Periode <span class="required">*</span></label>
                    <input type="text" name="nama_periode" class="form-control"
                           placeholder="cth: Tahun Ajaran Ganjil 2026"
                           value="{{ old('nama_periode') }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Mulai <span class="required">*</span></label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                               value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai <span class="required">*</span></label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                               value="{{ old('tanggal_selesai') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control"
                           placeholder="Opsional" value="{{ old('keterangan') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalTambah')">
                    <i class="fas fa-xmark"></i> Batal
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan & Aktifkan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== MODAL EDIT ===================== --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h4><i class="fas fa-pen"></i> Edit Periode</h4>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
        <form id="formEdit" action="" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Periode <span class="required">*</span></label>
                    <input type="text" name="nama_periode" id="editNama" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Mulai <span class="required">*</span></label>
                        <input type="date" name="tanggal_mulai" id="editMulai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai <span class="required">*</span></label>
                        <input type="date" name="tanggal_selesai" id="editSelesai" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" id="editKeterangan" class="form-control" placeholder="Opsional">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalEdit')">
                    <i class="fas fa-xmark"></i> Batal
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    function openEdit(id, nama, mulai, selesai, keterangan) {
        document.getElementById('formEdit').action = `/periode/${id}`;
        document.getElementById('editNama').value       = nama;
        document.getElementById('editMulai').value      = mulai;
        document.getElementById('editSelesai').value    = selesai;
        document.getElementById('editKeterangan').value = keterangan;
        openModal('modalEdit');
    }

    @if($errors->any())
        openModal('modalTambah');
    @endif
</script>
@endpush