<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelajaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $pelajarans = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('admin.pelajaran.index', compact('pelajarans'));
    }

    public function create()
    {
        return view('admin.pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:pelajarans,kode',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:guru_kelas,guru_mapel',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        Pelajaran::create($validated);

        return redirect()->route('admin.pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Pelajaran $pelajaran)
    {
        return view('admin.pelajaran.edit', compact('pelajaran'));
    }

    public function update(Request $request, Pelajaran $pelajaran)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', Rule::unique('pelajarans', 'kode')->ignore($pelajaran->id)],
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:guru_kelas,guru_mapel',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        $pelajaran->update($validated);

        return redirect()->route('admin.pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Pelajaran $pelajaran)
    {
        if ($pelajaran->soals()->count() > 0) {
            return redirect()->route('admin.pelajaran.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki soal.');
        }

        $pelajaran->delete();

        return redirect()->route('admin.pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
