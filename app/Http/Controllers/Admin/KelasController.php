<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::withCount('rombels');

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $kelass = $query->orderBy('tingkat')->orderBy('nama')->paginate(12)->withQueryString();

        return view('admin.kelas.index', compact('kelass'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|integer|min:1|max:6',
            'nama' => 'required|string|max:10|unique:kelas,nama',
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        return view('admin.kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'tingkat' => 'required|integer|min:1|max:6',
            'nama' => ['required', 'string', 'max:10', Rule::unique('kelas', 'nama')->ignore($kela->id)],
        ]);

        $kela->update($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->rombels()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki rombel.');
        }

        $kela->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
