@extends('layouts.app')

@section('title', 'Kelola User – SPK Siswa Terbaik')

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
    --purple:#7c3aed; --purple-bg:#f5f3ff; --purple-bd:#ddd6fe;
    --mono:'JetBrains Mono',monospace; --sans:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r:12px; --r-lg:16px; --r-xl:20px;
    --sh-xs:0 1px 2px rgba(15,22,35,.05);
    --sh-sm:0 2px 8px rgba(15,22,35,.07);
    --sh-xl:0 24px 64px rgba(15,22,35,.16);
}
*,*::before,*::after { box-sizing: border-box; margin:0; padding:0; }

.ph{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.ph-title{font-size:22px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:10px;margin-bottom:4px;}
.t-icon{width:36px;height:36px;background:linear-gradient(135deg,#7c3aed,#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.25);}
.ph-sub{font-size:13px;color:var(--ink-3);padding-left:46px;line-height:1.5;}
.divider{border:none;border-top:1.5px solid var(--border);margin:0 0 24px;}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-lg);padding:16px;display:flex;align-items:center;gap:12px;box-shadow:var(--sh-xs);}
.stat-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.stat-val{font-size:22px;font-weight:800;color:var(--ink);line-height:1;font-family:var(--mono);}
.stat-lbl{font-size:11px;color:var(--ink-3);font-weight:600;margin-top:2px;}

/* BTN */
.btn-add{display:inline-flex;align-items:center;gap:7px;background:var(--accent);color:#fff;border:none;border-radius:var(--r-sm);padding:9px 18px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;transition:all .15s;font-family:var(--sans);box-shadow:0 2px 8px rgba(37,99,235,.3);}
.btn-add:hover{background:var(--accent-dark);}

/* TABLE CARD */
.table-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--sh-xs);}
.table-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1.5px solid var(--border);gap:12px;flex-wrap:wrap;}
.table-title{font-size:14px;font-weight:800;color:var(--ink);display:flex;align-items:center;gap:8px;}
.count-badge{background:var(--accent-lt);color:var(--accent);font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;}
.tbl-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:13px;min-width:700px;}
thead tr{background:var(--surface-2);}
thead th{padding:10px 16px;font-size:10px;font-weight:700;color:var(--ink-3);text-transform:uppercase;letter-spacing:.5px;border-bottom:1.5px solid var(--border);text-align:left;white-space:nowrap;}
thead th.center{text-align:center;}
tbody tr{border-bottom:1px solid var(--surface-3);transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f8faff;}
tbody td{padding:12px 16px;color:var(--ink);vertical-align:middle;}
tbody td.center{text-align:center;}

/* USER CELL */
.user-cell{display:flex;align-items:center;gap:10px;}
.user-avatar{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;flex-shrink:0;}
.av-admin{background:linear-gradient(135deg,#f59e0b,#d97706);}
.av-wali{background:linear-gradient(135deg,#2563eb,#1d4ed8);}
.av-kepala{background:linear-gradient(135deg,#059669,#047857);}
.user-name{font-weight:700;color:var(--ink);font-size:13px;}
.user-username{font-size:11px;color:var(--ink-3);font-family:var(--mono);margin-top:1px;}

/* ROLE BADGE */
.role-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;}
.rb-admin{background:#fef3c7;color:#92400e;border:1.5px solid #fde68a;}
.rb-wali{background:var(--accent-lt);color:var(--accent);border:1.5px solid #bfdbfe;}
.rb-kepala{background:var(--green-bg);color:var(--green);border:1.5px solid var(--green-bd);}

/* STATUS */
.status-dot{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;}
.dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.dot-on{background:var(--green);}
.dot-off{background:var(--ink-3);}

/* ACTION */
.action-btns{display:flex;align-items:center;gap:5px;justify-content:center;}
.btn-act{width:30px;height:30px;border-radius:var(--r-sm);display:inline-flex;align-items:center;justify-content:center;font-size:13px;border:1.5px solid transparent;cursor:pointer;transition:all .15s;text-decoration:none;background:transparent;font-family:var(--sans);}
.btn-act.edit{background:var(--accent-lt);color:var(--accent);border-color:#bfdbfe;}
.btn-act.edit:hover{background:var(--accent);color:#fff;}
.btn-act.del{background:var(--red-bg);color:var(--red);border-color:var(--red-bd);}
.btn-act.del:hover{background:var(--red);color:#fff;}
.btn-act.tog{background:var(--green-bg);color:var(--green);border-color:var(--green-bd);}
.btn-act.tog:hover{background:var(--green);color:#fff;}
.btn-act.tog.off{background:var(--surface-2);color:var(--ink-3);border-color:var(--border);}
.btn-act.tog.off:hover{background:var(--ink-3);color:#fff;}

/* MODAL */
.modal-overlay{position:fixed;inset:0;background:rgba(10,14,26,.5);backdrop-filter:blur(4px);z-index:1000;display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;pointer-events:none;transition:opacity .2s;}
.modal-overlay.open{opacity:1;pointer-events:all;}
.modal-box{background:var(--surface);border-radius:var(--r-xl);padding:28px;max-width:480px;width:100%;box-shadow:var(--sh-xl);border:1.5px solid var(--border);transform:translateY(12px) scale(.97);transition:transform .2s cubic-bezier(.34,1.56,.64,1);}
.modal-overlay.open .modal-box{transform:none;}
.modal-title{font-size:17px;font-weight:800;color:var(--ink);margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-grid.full{grid-template-columns:1fr;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-group.span2{grid-column:span 2;}
.form-label{font-size:12px;font-weight:700;color:var(--ink-2);}
.form-input,.form-select{padding:9px 12px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:var(--sans);font-size:13px;color:var(--ink);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;}
.form-input:focus,.form-select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.form-hint{font-size:11px;color:var(--ink-3);margin-top:2px;}
.modal-actions{display:flex;gap:10px;margin-top:20px;}
.btn-cancel{flex:1;padding:9px;border:1.5px solid var(--border-2);border-radius:var(--r-sm);background:var(--surface);font-family:var(--sans);font-size:13px;font-weight:600;color:var(--ink-3);cursor:pointer;transition:all .15s;}
.btn-cancel:hover{border-color:var(--ink-3);color:var(--ink);}
.btn-submit{flex:1;padding:9px;border:none;border-radius:var(--r-sm);background:var(--accent);font-family:var(--sans);font-size:13px;font-weight:700;color:#fff;cursor:pointer;transition:background .15s;}
.btn-submit:hover{background:var(--accent-dark);}

/* DELETE MODAL */
.del-modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--red),#f87171);border-radius:var(--r-xl) var(--r-xl) 0 0;}
.del-modal-box{position:relative;}

/* KELAS FIELD - kondisional */
.kelas-field{display:none;}
.kelas-field.show{display:flex;}

@media(max-width:600px){
    .stats-row{grid-template-columns:repeat(2,1fr);}
    .form-grid{grid-template-columns:1fr;}
    .form-group.span2{grid-column:span 1;}
}
</style>
@endpush

@section('content')

<div class="ph">
    <div>
        <h1 class="ph-title">
            <span class="t-icon">👥</span>
            Kelola User
        </h1>
        <p class="ph-sub">Manajemen akun pengguna sistem SPK Siswa Terbaik</p>
    </div>
    <button class="btn-add" onclick="openModal('addModal')">
        ➕ Tambah User
    </button>
</div>
<hr class="divider">

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;">👑</div>
        <div>
            <div class="stat-val">{{ $users->where('role','admin')->count() }}</div>
            <div class="stat-lbl">Admin</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--accent-lt);">🏫</div>
        <div>
            <div class="stat-val">{{ $users->where('role','wali_kelas')->count() }}</div>
            <div class="stat-lbl">Wali Kelas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--green-bg);">🎓</div>
        <div>
            <div class="stat-val">{{ $users->where('role','kepala_sekolah')->count() }}</div>
            <div class="stat-lbl">Kepala Sekolah</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--surface-2);">✅</div>
        <div>
            <div class="stat-val">{{ $users->where('is_active',true)->count() }}</div>
            <div class="stat-lbl">User Aktif</div>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-head">
        <div class="table-title">
            👥 Daftar User
            <span class="count-badge">{{ $users->count() }} user</span>
        </div>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:44px" class="center">NO</th>
                    <th>NAMA USER</th>
                    <th class="center">ROLE</th>
                    <th class="center">KELAS</th>
                    <th class="center">STATUS</th>
                    <th class="center" style="width:110px">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td class="center" style="font-size:12px;color:var(--ink-3);font-weight:600;">{{ $i+1 }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar
                                {{ $user->role === 'admin' ? 'av-admin' : ($user->role === 'wali_kelas' ? 'av-wali' : 'av-kepala') }}">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-username">{{ $user->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="center">
                        <span class="role-badge
                            {{ $user->role === 'admin' ? 'rb-admin' : ($user->role === 'wali_kelas' ? 'rb-wali' : 'rb-kepala') }}">
                            @if($user->role === 'admin') 👑 Admin
                            @elseif($user->role === 'wali_kelas') 🏫 Wali Kelas
                            @else 🎓 Kepala Sekolah
                            @endif
                        </span>
                    </td>
                    <td class="center" style="font-size:12.5px;font-weight:600;color:var(--ink-2);">
                        {{ $user->kelas ?? '—' }}
                    </td>
                    <td class="center">
                        <span class="status-dot">
                            <span class="dot {{ $user->is_active ? 'dot-on' : 'dot-off' }}"></span>
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="center">
                        <div class="action-btns">
                            {{-- Edit --}}
                            <button class="btn-act edit" title="Edit"
                                onclick="openEditModal(
                                    {{ $user->id }},
                                    '{{ addslashes($user->name) }}',
                                    '{{ addslashes($user->username) }}',
                                    '{{ addslashes($user->email) }}',
                                    '{{ $user->role }}',
                                    '{{ $user->kelas ?? '' }}',
                                    {{ $user->is_active ? 'true' : 'false' }}
                                )">✏️</button>

                            {{-- Toggle aktif --}}
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display:contents;">
                                @csrf @method('PATCH')
                                <button type="submit" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    class="btn-act tog {{ $user->is_active ? '' : 'off' }}">
                                    {{ $user->is_active ? '🔒' : '🔓' }}
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <button class="btn-act del" title="Hapus"
                                onclick="openDelModal({{ $user->id }}, '{{ addslashes($user->name) }}')">🗑</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:48px;color:var(--ink-3);">
                        Belum ada user terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ═══ MODAL TAMBAH ═══ --}}
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-title">➕ Tambah User Baru</div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group span2">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-input" placeholder="Nama lengkap" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-input" placeholder="username" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" placeholder="email@sekolah.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select" required onchange="toggleKelasField(this,'add')">
                        <option value="">Pilih Role</option>
                        <option value="admin">👑 Admin</option>
                        <option value="wali_kelas">🏫 Wali Kelas</option>
                        <option value="kepala_sekolah">🎓 Kepala Sekolah</option>
                    </select>
                </div>
                <div class="form-group kelas-field" id="add-kelas-field">
                    <label class="form-label">Kelas *</label>
                    <select name="kelas" class="form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}">{{ $kelas }}</option>
                        @endforeach
                    </select>
                    <span class="form-hint">Wali kelas hanya bisa input nilai kelasnya</span>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-submit">✅ Simpan User</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL EDIT ═══ --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-title">✏️ Edit User</div>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group span2">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" id="edit-name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" id="edit-username" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" id="edit-email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" placeholder="Kosongkan jika tidak diubah">
                </div>
                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" id="edit-role" class="form-select" required onchange="toggleKelasField(this,'edit')">
                        <option value="admin">👑 Admin</option>
                        <option value="wali_kelas">🏫 Wali Kelas</option>
                        <option value="kepala_sekolah">🎓 Kepala Sekolah</option>
                    </select>
                </div>
                <div class="form-group kelas-field" id="edit-kelas-field">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" id="edit-kelas" class="form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}">{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group span2" style="flex-direction:row;align-items:center;gap:10px;">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" style="width:16px;height:16px;cursor:pointer;">
                    <label for="edit-active" class="form-label" style="cursor:pointer;margin:0;">User Aktif</label>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-submit">💾 Perbarui</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL HAPUS ═══ --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box del-modal-box" style="max-width:400px;text-align:center;">
        <div style="font-size:44px;margin-bottom:14px;">🗑️</div>
        <div style="font-size:17px;font-weight:800;color:var(--ink);margin-bottom:8px;">Hapus User?</div>
        <div style="font-size:13px;color:var(--ink-3);line-height:1.6;margin-bottom:22px;">
            Anda akan menghapus akun <strong id="delNama"></strong>.<br>
            Tindakan ini <strong>tidak dapat dibatalkan</strong>.
        </div>
        <form method="POST" id="delForm" style="display:flex;gap:10px;">
            @csrf @method('DELETE')
            <button type="button" class="btn-cancel" onclick="closeModal('delModal')">Batal</button>
            <button type="submit" class="btn-submit" style="background:var(--red);">🗑️ Ya, Hapus</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

// Tutup modal klik backdrop
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(el => el.classList.remove('open'));
});

// Tampilkan/sembunyikan field kelas
function toggleKelasField(sel, prefix) {
    const field = document.getElementById(prefix + '-kelas-field');
    if (sel.value === 'wali_kelas') {
        field.classList.add('show');
    } else {
        field.classList.remove('show');
    }
}

// Buka modal edit dengan data user
function openEditModal(id, name, username, email, role, kelas, isActive) {
    document.getElementById('edit-name').value     = name;
    document.getElementById('edit-username').value = username;
    document.getElementById('edit-email').value    = email;
    document.getElementById('edit-role').value     = role;
    document.getElementById('edit-active').checked = isActive;

    const kelasField = document.getElementById('edit-kelas-field');
    const kelasSelect = document.getElementById('edit-kelas');
    if (role === 'wali_kelas') {
        kelasField.classList.add('show');
        kelasSelect.value = kelas;
    } else {
        kelasField.classList.remove('show');
    }

    document.getElementById('editForm').action = '/admin/users/' + id;
    openModal('editModal');
}

// Buka modal hapus
function openDelModal(id, nama) {
    document.getElementById('delNama').textContent = nama;
    document.getElementById('delForm').action = '/admin/users/' + id;
    openModal('delModal');
}
</script>
@endpush