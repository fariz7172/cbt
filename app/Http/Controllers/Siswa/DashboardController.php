<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\HasilUjian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $currentRombel = $siswa->currentRombel();

        // Get available ujians
        $availableUjians = collect();
        $completedUjians = collect();

        if ($currentRombel) {
            $availableUjians = Ujian::with(['pelajaran', 'guru'])
                ->where('rombel_id', $currentRombel->id)
                ->where('status', 'published')
                ->where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->whereDoesntHave('hasilUjians', function ($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id)
                        ->where('status', 'selesai');
                })
                ->get();

            $completedUjians = HasilUjian::with(['ujian.pelajaran'])
                ->where('siswa_id', $siswa->id)
                ->where('status', 'selesai')
                ->latest()
                ->take(5)
                ->get();
        }

        $stats = [
            'total_ujian' => HasilUjian::where('siswa_id', $siswa->id)->count(),
            'ujian_selesai' => HasilUjian::where('siswa_id', $siswa->id)->where('status', 'selesai')->count(),
            'rata_rata_nilai' => HasilUjian::where('siswa_id', $siswa->id)
                ->where('status', 'selesai')
                ->avg('nilai') ?? 0,
        ];

        return view('siswa.dashboard', compact('siswa', 'currentRombel', 'availableUjians', 'completedUjians', 'stats'));
    }
}
