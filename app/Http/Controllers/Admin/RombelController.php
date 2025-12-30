<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RombelController extends Controller
{
    public function index(Request $request)
    {
        $query = Rombel::with(['kelas', 'waliKelas'])
            ->withCount(['siswas', 'pelajarans']);

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $rombels = $query->latest()->paginate(10)->withQueryString();
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        $tahunAjarans = Rombel::distinct()->pluck('tahun_ajaran');

        return view('admin.rombel.index', compact('rombels', 'kelass', 'tahunAjarans'));
    }

    public function create()
    {
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        $guruKelas = Guru::where('jabatan', 'guru_kelas')->orderBy('nama')->get();
        
        return view('admin.rombel.create', compact('kelass', 'guruKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'required|exists:gurus,id',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:ganjil,genap',
        ]);

        // Check if rombel already exists
        $exists = Rombel::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran', $validated['tahun_ajaran'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Rombel untuk kelas, tahun ajaran, dan semester ini sudah ada.');
        }

        Rombel::create($validated);

        return redirect()->route('admin.rombel.index')
            ->with('success', 'Rombel berhasil ditambahkan.');
    }

    public function show(Rombel $rombel)
    {
        $rombel->load(['kelas', 'waliKelas', 'siswas', 'pelajarans', 'gurus']);
        return view('admin.rombel.show', compact('rombel'));
    }

    public function edit(Rombel $rombel)
    {
        $kelass = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        $guruKelas = Guru::where('jabatan', 'guru_kelas')->orderBy('nama')->get();
        
        return view('admin.rombel.edit', compact('rombel', 'kelass', 'guruKelas'));
    }

    public function update(Request $request, Rombel $rombel)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'required|exists:gurus,id',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:ganjil,genap',
        ]);

        // Check if rombel already exists (excluding current)
        $exists = Rombel::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran', $validated['tahun_ajaran'])
            ->where('semester', $validated['semester'])
            ->where('id', '!=', $rombel->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Rombel untuk kelas, tahun ajaran, dan semester ini sudah ada.');
        }

        $rombel->update($validated);

        return redirect()->route('admin.rombel.index')
            ->with('success', 'Rombel berhasil diperbarui.');
    }

    public function destroy(Rombel $rombel)
    {
        if ($rombel->ujians()->count() > 0) {
            return redirect()->route('admin.rombel.index')
                ->with('error', 'Rombel tidak dapat dihapus karena masih memiliki ujian.');
        }

        $rombel->delete();

        return redirect()->route('admin.rombel.index')
            ->with('success', 'Rombel berhasil dihapus.');
    }

    // Manage Siswa in Rombel
    public function manageSiswa(Rombel $rombel)
    {
        $rombel->load(['siswas', 'kelas']);
        
        // Filter siswa berdasarkan kelas yang sama dengan rombel
        $allSiswas = Siswa::where('kelas_id', $rombel->kelas_id)
            ->orderBy('nama')
            ->get();
        
        $assignedIds = $rombel->siswas->pluck('id')->toArray();

        return view('admin.rombel.manage-siswa', compact('rombel', 'allSiswas', 'assignedIds'));
    }

    public function updateSiswa(Request $request, Rombel $rombel)
    {
        $validated = $request->validate([
            'siswa_ids' => 'array',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        $rombel->siswas()->sync($validated['siswa_ids'] ?? []);

        return redirect()->route('admin.rombel.show', $rombel)
            ->with('success', 'Data siswa rombel berhasil diperbarui.');
    }

    // Manage Pelajaran in Rombel
    public function managePelajaran(Rombel $rombel)
    {
        $rombel->load(['pelajarans', 'gurus', 'waliKelas']);
        $allPelajarans = Pelajaran::where('is_active', true)->orderBy('nama')->get();
        $allGurus = Guru::orderBy('nama')->get();
        
        // Pass wali kelas id for auto-assignment of guru_kelas subjects
        $waliKelasId = $rombel->wali_kelas_id;

        return view('admin.rombel.manage-pelajaran', compact('rombel', 'allPelajarans', 'allGurus', 'waliKelasId'));
    }

    public function updatePelajaran(Request $request, Rombel $rombel)
    {
        $validated = $request->validate([
            'pelajarans' => 'array',
            'pelajarans.*.pelajaran_id' => 'required|exists:pelajarans,id',
            'pelajarans.*.guru_id' => 'required|exists:gurus,id',
        ]);

        // Clear existing and add new
        $rombel->pelajarans()->detach();
        
        foreach ($validated['pelajarans'] ?? [] as $item) {
            $rombel->pelajarans()->attach($item['pelajaran_id'], [
                'guru_id' => $item['guru_id'],
            ]);
        }

        return redirect()->route('admin.rombel.show', $rombel)
            ->with('success', 'Data pelajaran rombel berhasil diperbarui.');
    }
}
