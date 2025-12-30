<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        $gurus = $query->latest()->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nip' => 'required|string|unique:gurus,nip',
            'jabatan' => 'required|in:kepala_madrasah,guru_kelas,guru_mapel',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'guru',
                'is_active' => true,
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jabatan' => $validated['jabatan'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['user', 'rombelWaliKelas.kelas', 'soals', 'ujians']);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($guru->user_id)],
            'password' => 'nullable|string|min:6|confirmed',
            'nip' => ['required', 'string', Rule::unique('gurus', 'nip')->ignore($guru->id)],
            'jabatan' => 'required|in:kepala_madrasah,guru_kelas,guru_mapel',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $guru) {
            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'is_active' => $validated['is_active'] ?? true,
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $guru->user->update($userData);

            $guru->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jabatan' => $validated['jabatan'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            $guru->user->delete();
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
