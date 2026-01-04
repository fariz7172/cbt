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

        // Filter by sekolah for Super Admin
        if ($request->filled('sekolah_id')) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $kelass = $query->orderBy('tingkat')->orderBy('nama')->paginate(12)->withQueryString();
        
        // Get all sekolahs for filter (only for Super Admin)
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();

        return view('admin.kelas.index', compact('kelass', 'sekolahs'));
    }

    public function create()
    {
        // Get all sekolahs for Super Admin
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();
            
        return view('admin.kelas.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $sekolahId = auth()->user()->isSuperAdmin() 
            ? $request->sekolah_id 
            : auth()->user()->sekolah_id;
            
        $validated = $request->validate([
            'sekolah_id' => auth()->user()->isSuperAdmin() ? 'required|exists:sekolahs,id' : 'nullable',
            'tingkat' => 'required|integer|min:1|max:12',
            'nama' => [
                'required',
                'string',
                'max:10',
                Rule::unique('kelas', 'nama')->where(function ($query) use ($sekolahId) {
                    return $query->where('sekolah_id', $sekolahId);
                })
            ],
        ]);

        $validated['sekolah_id'] = $sekolahId;
        
        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        // Get all sekolahs for Super Admin
        $sekolahs = auth()->user()->isSuperAdmin() 
            ? \App\Models\Sekolah::orderBy('nama')->get() 
            : collect();
            
        return view('admin.kelas.edit', ['kelas' => $kela, 'sekolahs' => $sekolahs]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $sekolahId = auth()->user()->isSuperAdmin() && $request->filled('sekolah_id')
            ? $request->sekolah_id 
            : $kela->sekolah_id;
            
        $validated = $request->validate([
            'sekolah_id' => auth()->user()->isSuperAdmin() ? 'required|exists:sekolahs,id' : 'nullable',
            'tingkat' => 'required|integer|min:1|max:12',
            'nama' => [
                'required',
                'string',
                'max:10',
                Rule::unique('kelas', 'nama')
                    ->ignore($kela->id)
                    ->where(function ($query) use ($sekolahId) {
                        return $query->where('sekolah_id', $sekolahId);
                    })
            ],
        ]);

        $kelasData = [
            'tingkat' => $validated['tingkat'],
            'nama' => $validated['nama'],
        ];
        
        // Update sekolah_id for Super Admin
        if (auth()->user()->isSuperAdmin() && isset($validated['sekolah_id'])) {
            $kelasData['sekolah_id'] = $validated['sekolah_id'];
        }

        $kela->update($kelasData);

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
