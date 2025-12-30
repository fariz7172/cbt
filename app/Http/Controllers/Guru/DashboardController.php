<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Rombel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;
        
        $stats = [
            'total_soal' => Soal::where('guru_id', $guru->id)->count(),
            'total_ujian' => Ujian::where('guru_id', $guru->id)->count(),
            'ujian_aktif' => Ujian::where('guru_id', $guru->id)
                ->where('status', 'published')
                ->where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->count(),
            'rombel_mengajar' => $guru->rombels()->count(),
        ];

        $recentUjians = Ujian::with(['pelajaran', 'rombel.kelas'])
            ->where('guru_id', $guru->id)
            ->latest()
            ->take(5)
            ->get();

        $rombelWaliKelas = $guru->rombelWaliKelas()->with('kelas', 'siswas')->first();

        return view('guru.dashboard', compact('stats', 'recentUjians', 'rombelWaliKelas', 'guru'));
    }
}
