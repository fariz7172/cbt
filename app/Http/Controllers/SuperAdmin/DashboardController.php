<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSekolahs = \App\Models\Sekolah::count();
        $totalAdmins = \App\Models\User::where('role', 'admin')->count();
        $totalGurus = \App\Models\Guru::count();
        $totalSiswas = \App\Models\Siswa::count();
        
        $sekolahs = \App\Models\Sekolah::withCount(['users', 'gurus', 'siswas', 'kelas', 'pelajarans'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.dashboard', compact(
            'totalSekolahs',
            'totalAdmins',
            'totalGurus',
            'totalSiswas',
            'sekolahs'
        ));
    }
}
