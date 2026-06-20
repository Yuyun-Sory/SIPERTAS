<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function getKelasList(): array
    {
        return [
            'VII A', 'VII B',
            'VIII A', 'VIII B',
            'IX A', 'IX B',
        ];
    }

    public function index()
{
    $kelasList = $this->getKelasList();

    $users = User::orderBy('role')->orderBy('name')->get();

    // Urutkan ulang: wali_kelas dikelompokkan sesuai urutan kelasList,
    // role lain (admin, kepala_sekolah) tetap di awal sesuai orderBy('role')
    $kelasOrder = array_flip($kelasList);

    $users = $users->sortBy(function ($user) use ($kelasOrder) {
        if ($user->role === 'wali_kelas') {
            // urutan: 100+ index kelas, supaya admin/kepsek (tanpa kelas) tetap di atas
            return 100 + ($kelasOrder[$user->kelas] ?? 999);
        }
        // non wali_kelas urut berdasarkan role dulu (admin di atas)
        return $user->role === 'admin' ? 0 : 50;
    })->values();

    return view('admin.users', compact('users', 'kelasList'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:admin,wali_kelas,kepala_sekolah'],
            'kelas'    => ['nullable', 'string', Rule::requiredIf($request->role === 'wali_kelas')],
        ]);

        User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'kelas'     => $validated['role'] === 'wali_kelas' ? $validated['kelas'] : null,
            'is_active' => true,
        ]);

        return back()->with('success', "User <strong>{$validated['name']}</strong> berhasil ditambahkan.");
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role'     => ['required', 'in:admin,wali_kelas,kepala_sekolah'],
            'kelas'    => ['nullable', 'string'],
            'is_active'=> ['boolean'],
        ]);

        $data = [
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],
            'kelas'     => $validated['role'] === 'wali_kelas' ? $validated['kelas'] : null,
            'is_active' => $request->boolean('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', "User <strong>{$user->name}</strong> berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('success', "User <strong>{$nama}</strong> berhasil dihapus.");
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "User <strong>{$user->name}</strong> berhasil {$status}.");
    }
}