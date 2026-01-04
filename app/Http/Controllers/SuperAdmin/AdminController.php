<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('sekolah')
            ->where('role', 'admin');

        if ($request->has('sekolah_id') && $request->sekolah_id) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10);
        $sekolahs = Sekolah::where('is_active', true)->orderBy('nama')->get();

        return view('super-admin.admin.index', compact('admins', 'sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::where('is_active', true)->orderBy('nama')->get();
        return view('super-admin.admin.create', compact('sekolahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'admin';

        User::create($validated);

        return redirect()->route('super-admin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $admin->load('sekolah');
        return view('super-admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $sekolahs = Sekolah::where('is_active', true)->orderBy('nama')->get();
        return view('super-admin.admin.edit', compact('admin', 'sekolahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('super-admin.admin.index')
            ->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $admin->delete();

        return redirect()->route('super-admin.admin.index')
            ->with('success', 'Admin berhasil dihapus!');
    }
}
