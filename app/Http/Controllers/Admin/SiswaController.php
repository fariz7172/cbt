<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();

        return view('admin.siswa.index', compact('siswas', 'kelass'));
    }

    public function create()
    {
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        return view('admin.siswa.create', compact('kelass'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nisn' => 'required|string|unique:siswas,nisn',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'siswa',
                'is_active' => true,
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $validated['kelas_id'] ?? null,
                'nisn' => $validated['nisn'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas', 'rombels.kelas', 'rombels.waliKelas', 'hasilUjians.ujian']);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelass'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($siswa->user_id)],
            'password' => 'nullable|string|min:6|confirmed',
            'nisn' => ['required', 'string', Rule::unique('siswas', 'nisn')->ignore($siswa->id)],
            'kelas_id' => 'nullable|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $siswa) {
            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'is_active' => $validated['is_active'] ?? true,
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $siswa->user->update($userData);

            $siswa->update([
                'kelas_id' => $validated['kelas_id'] ?? null,
                'nisn' => $validated['nisn'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $siswa->user->delete();
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
