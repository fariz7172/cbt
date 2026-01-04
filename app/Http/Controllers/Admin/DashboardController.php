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
        $sekolahId = auth()->user()->sekolah_id;

        $stats = [
            'total_guru' => Guru::where('sekolah_id', $sekolahId)->count(),
            'total_siswa' => Siswa::where('sekolah_id', $sekolahId)->count(),
            'total_kelas' => Kelas::where('sekolah_id', $sekolahId)->count(),
            'total_rombel' => Rombel::where('sekolah_id', $sekolahId)->count(),
            'total_pelajaran' => Pelajaran::where('sekolah_id', $sekolahId)->count(),
            // Ujian linked to Guru -> Sekolah
            'total_ujian' => Ujian::whereHas('guru', function($q) use ($sekolahId) {
                $q->where('sekolah_id', $sekolahId);
            })->count(),
            
            'guru_by_jabatan' => Guru::where('sekolah_id', $sekolahId)
                ->selectRaw('jabatan, count(*) as total')
                ->groupBy('jabatan')
                ->pluck('total', 'jabatan'),
            
            'recent_ujians' => Ujian::with(['guru', 'pelajaran', 'rombel.kelas'])
                ->whereHas('guru', function($q) use ($sekolahId) {
                    $q->where('sekolah_id', $sekolahId);
                })
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
