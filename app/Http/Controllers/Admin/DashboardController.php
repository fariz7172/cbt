<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Pelajaran;
use App\Models\Ujian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_kelas' => Kelas::count(),
            'total_rombel' => Rombel::count(),
            'total_pelajaran' => Pelajaran::count(),
            'total_ujian' => Ujian::count(),
            'guru_by_jabatan' => Guru::selectRaw('jabatan, count(*) as total')
                ->groupBy('jabatan')
                ->pluck('total', 'jabatan'),
            'recent_ujians' => Ujian::with(['guru', 'pelajaran', 'rombel.kelas'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
