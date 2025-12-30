<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $currentRombel = $siswa->currentRombel();

        $ujians = collect();
        if ($currentRombel) {
            $ujians = Ujian::with(['pelajaran', 'guru'])
                ->withCount('soals')
                ->where('rombel_id', $currentRombel->id)
                ->where('status', 'published')
                ->orderBy('waktu_mulai', 'desc')
                ->get()
                ->map(function ($ujian) use ($siswa) {
                    $hasil = HasilUjian::where('ujian_id', $ujian->id)
                        ->where('siswa_id', $siswa->id)
                        ->first();
                    $ujian->hasil = $hasil;
                    $ujian->is_available = $ujian->isActive() && (!$hasil || $hasil->status !== 'selesai');
                    return $ujian;
                });
        }

        return view('siswa.ujian.index', compact('ujians'));
    }

    public function show(Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        // Check if siswa is in the rombel
        $currentRombel = $siswa->currentRombel();
        if (!$currentRombel || $ujian->rombel_id !== $currentRombel->id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }

        $hasil = HasilUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $ujian->load(['pelajaran', 'guru']);

        return view('siswa.ujian.show', compact('ujian', 'hasil'));
    }

    public function start(Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        // Validate access
        $currentRombel = $siswa->currentRombel();
        if (!$currentRombel || $ujian->rombel_id !== $currentRombel->id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }

        if (!$ujian->isActive()) {
            return redirect()->route('siswa.ujian.show', $ujian)
                ->with('error', 'Ujian tidak tersedia saat ini.');
        }

        // Check if already completed
        $hasil = HasilUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($hasil && $hasil->status === 'selesai') {
            return redirect()->route('siswa.ujian.hasil', $ujian)
                ->with('error', 'Anda sudah menyelesaikan ujian ini.');
        }

        // Create or get hasil ujian
        if (!$hasil) {
            $hasil = HasilUjian::create([
                'ujian_id' => $ujian->id,
                'siswa_id' => $siswa->id,
                'waktu_mulai' => now(),
                'status' => 'sedang_mengerjakan',
            ]);
        }

        return redirect()->route('siswa.ujian.kerjakan', $ujian);
    }

    public function kerjakan(Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        $hasil = HasilUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sedang_mengerjakan')
            ->first();

        if (!$hasil) {
            return redirect()->route('siswa.ujian.show', $ujian)
                ->with('error', 'Silakan mulai ujian terlebih dahulu.');
        }

        // Get soals
        $soals = $ujian->soals;
        if ($ujian->acak_soal) {
            $soals = $soals->shuffle();
        }

        // Get existing answers
        $jawabanMap = JawabanSiswa::where('hasil_ujian_id', $hasil->id)
            ->pluck('jawaban', 'soal_id')
            ->toArray();

        // Calculate remaining time
        $elapsedMinutes = $hasil->waktu_mulai->diffInMinutes(now());
        $remainingMinutes = max(0, $ujian->durasi - $elapsedMinutes);

        return view('siswa.ujian.kerjakan', compact('ujian', 'soals', 'hasil', 'jawabanMap', 'remainingMinutes'));
    }

    public function saveJawaban(Request $request, Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        $hasil = HasilUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sedang_mengerjakan')
            ->first();

        if (!$hasil) {
            return response()->json(['error' => 'Ujian tidak valid'], 400);
        }

        $validated = $request->validate([
            'soal_id' => 'required|exists:soals,id',
            'jawaban' => 'nullable|string',
        ]);

        JawabanSiswa::updateOrCreate(
            [
                'hasil_ujian_id' => $hasil->id,
                'soal_id' => $validated['soal_id'],
            ],
            [
                'jawaban' => $validated['jawaban'],
            ]
        );

        return response()->json(['success' => true]);
    }

    public function submit(Request $request, Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        $hasil = HasilUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sedang_mengerjakan')
            ->first();

        if (!$hasil) {
            return redirect()->route('siswa.ujian.index')
                ->with('error', 'Ujian tidak valid.');
        }

        DB::transaction(function () use ($hasil, $ujian) {
            // Grade all answers
            $jawabans = JawabanSiswa::where('hasil_ujian_id', $hasil->id)->get();
            foreach ($jawabans as $jawaban) {
                $jawaban->grade();
            }

            // Update hasil
            $hasil->waktu_selesai = now();
            $hasil->status = 'selesai';
            $hasil->save();

            // Calculate final score
            $hasil->calculateNilai();
        });

        return redirect()->route('siswa.ujian.hasil', $ujian)
            ->with('success', 'Ujian berhasil diselesaikan!');
    }

    public function hasil(Ujian $ujian)
    {
        $siswa = auth()->user()->siswa;
        
        $hasil = HasilUjian::with(['jawabanSiswas.soal'])
            ->where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->first();

        if (!$hasil) {
            return redirect()->route('siswa.ujian.show', $ujian)
                ->with('error', 'Hasil ujian tidak ditemukan.');
        }

        $ujian->load(['pelajaran', 'guru']);

        return view('siswa.ujian.hasil', compact('ujian', 'hasil'));
    }
}
