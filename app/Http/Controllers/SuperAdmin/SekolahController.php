<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolahs = Sekolah::withCount(['users', 'gurus', 'siswas', 'kelas', 'pelajarans'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('super-admin.sekolah.index', compact('sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super-admin.sekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nsm' => 'required|string|unique:sekolahs,nsm|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Sekolah::create($validated);

        return redirect()->route('super-admin.sekolah.index')
            ->with('success', 'Sekolah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        $sekolah->loadCount(['users', 'gurus', 'siswas', 'kelas', 'pelajarans']);
        
        return view('super-admin.sekolah.show', compact('sekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        return view('super-admin.sekolah.edit', compact('sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nsm' => 'required|string|max:255|unique:sekolahs,nsm,' . $sekolah->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($sekolah->logo && \Storage::disk('public')->exists($sekolah->logo)) {
                \Storage::disk('public')->delete($sekolah->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $sekolah->update($validated);

        return redirect()->route('super-admin.sekolah.index')
            ->with('success', 'Sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        // Check if sekolah has related data
        if ($sekolah->users()->count() > 0 || $sekolah->gurus()->count() > 0 || $sekolah->siswas()->count() > 0) {
            return redirect()->route('super-admin.sekolah.index')
                ->with('error', 'Tidak dapat menghapus sekolah yang masih memiliki data terkait!');
        }

        // Delete logo if exists
        if ($sekolah->logo && \Storage::disk('public')->exists($sekolah->logo)) {
            \Storage::disk('public')->delete($sekolah->logo);
        }

        $sekolah->delete();

        return redirect()->route('super-admin.sekolah.index')
            ->with('success', 'Sekolah berhasil dihapus!');
    }
}
