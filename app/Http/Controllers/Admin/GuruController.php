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

        // Filter by sekolah for Super Admin
        if ($request->filled('sekolah_id')) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

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
        
        // Get all sekolahs for filter (only for Super Admin)
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();

        return view('admin.guru.index', compact('gurus', 'sekolahs'));
    }

    public function create()
    {
        // Get all sekolahs for Super Admin
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();
            
        return view('admin.guru.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sekolah_id' => auth()->user()->isSuperAdmin() ? 'required|exists:sekolahs,id' : 'nullable',
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
                'sekolah_id' => auth()->user()->isSuperAdmin() 
                    ? $validated['sekolah_id'] 
                    : auth()->user()->sekolah_id,
                'is_active' => true,
            ]);

            Guru::create([
                'user_id' => $user->id,
                'sekolah_id' => auth()->user()->isSuperAdmin() 
                    ? $validated['sekolah_id'] 
                    : auth()->user()->sekolah_id,
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
        // Get all sekolahs for Super Admin
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();
            
        return view('admin.guru.edit', compact('guru', 'sekolahs'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'sekolah_id' => auth()->user()->isSuperAdmin() ? 'required|exists:sekolahs,id' : 'nullable',
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
            
            // Update sekolah_id for Super Admin
            if (auth()->user()->isSuperAdmin() && isset($validated['sekolah_id'])) {
                $userData['sekolah_id'] = $validated['sekolah_id'];
            }

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $guru->user->update($userData);

            $guruData = [
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jabatan' => $validated['jabatan'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ];
            
            // Update sekolah_id for Super Admin
            if (auth()->user()->isSuperAdmin() && isset($validated['sekolah_id'])) {
                $guruData['sekolah_id'] = $validated['sekolah_id'];
            }
            
            $guru->update($guruData);
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
