<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Rombel;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    /**
     * Get pelajarans based on guru's jabatan.
     */
    private function getPelajaransForGuru($guru)
    {
        if ($guru->isGuruKelas()) {
            return Pelajaran::where('is_active', true)
                ->where('jenis', 'guru_kelas')
                ->orderBy('nama')
                ->get();
        } else {
            return $guru->pelajarans()
                ->where('is_active', true)
                ->orderBy('nama')
                ->distinct()
                ->get();
        }
    }
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $query = Ujian::with(['pelajaran', 'rombel.kelas'])
            ->where('guru_id', $guru->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $ujians = $query->latest()->paginate(10)->withQueryString();

        return view('guru.ujian.index', compact('ujians'));
    }

    public function create()
    {
        $guru = auth()->user()->guru;
        $pelajarans = $this->getPelajaransForGuru($guru);
        $rombels = Rombel::with('kelas')
            ->whereHas('pelajarans', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->orWhere('wali_kelas_id', $guru->id)
            ->get();

        return view('guru.ujian.create', compact('pelajarans', 'rombels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'jenis' => 'required|in:ulangan_harian,uts,uas,try_out',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date|after:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'acak_soal' => 'boolean',
            'acak_opsi' => 'boolean',
            'tampil_nilai' => 'boolean',
        ]);

        $validated['guru_id'] = auth()->user()->guru->id;
        $validated['status'] = 'draft';
        $validated['acak_soal'] = $validated['acak_soal'] ?? false;
        $validated['acak_opsi'] = $validated['acak_opsi'] ?? false;
        $validated['tampil_nilai'] = $validated['tampil_nilai'] ?? true;

        $ujian = Ujian::create($validated);

        return redirect()->route('guru.ujian.manage-soal', $ujian)
            ->with('success', 'Ujian berhasil dibuat. Silakan tambahkan soal.');
    }

    public function show(Ujian $ujian)
    {
        $this->authorize('view', $ujian);
        $ujian->load(['pelajaran', 'rombel.kelas', 'soals', 'hasilUjians.siswa']);
        return view('guru.ujian.show', compact('ujian'));
    }

    public function edit(Ujian $ujian)
    {
        $this->authorize('update', $ujian);
        
        if ($ujian->status !== 'draft') {
            return redirect()->route('guru.ujian.show', $ujian)
                ->with('error', 'Ujian yang sudah dipublikasikan tidak dapat diedit.');
        }

        $guru = auth()->user()->guru;
        $pelajarans = $this->getPelajaransForGuru($guru);
        $rombels = Rombel::with('kelas')
            ->whereHas('pelajarans', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->orWhere('wali_kelas_id', $guru->id)
            ->get();

        return view('guru.ujian.edit', compact('ujian', 'pelajarans', 'rombels'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $this->authorize('update', $ujian);

        if ($ujian->status !== 'draft') {
            return redirect()->route('guru.ujian.show', $ujian)
                ->with('error', 'Ujian yang sudah dipublikasikan tidak dapat diedit.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'rombel_id' => 'required|exists:rombels,id',
            'jenis' => 'required|in:ulangan_harian,uts,uas,try_out',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'acak_soal' => 'boolean',
            'acak_opsi' => 'boolean',
            'tampil_nilai' => 'boolean',
        ]);

        $validated['acak_soal'] = $validated['acak_soal'] ?? false;
        $validated['acak_opsi'] = $validated['acak_opsi'] ?? false;
        $validated['tampil_nilai'] = $validated['tampil_nilai'] ?? true;

        $ujian->update($validated);

        return redirect()->route('guru.ujian.show', $ujian)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        $this->authorize('delete', $ujian);

        if ($ujian->hasilUjians()->count() > 0) {
            return redirect()->route('guru.ujian.index')
                ->with('error', 'Ujian tidak dapat dihapus karena sudah ada siswa yang mengerjakan.');
        }

        $ujian->delete();

        return redirect()->route('guru.ujian.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    // Manage Soal in Ujian
    public function manageSoal(Ujian $ujian)
    {
        $this->authorize('update', $ujian);
        
        $guru = auth()->user()->guru;
        $ujian->load('soals');
        
        // Get available soals (same pelajaran and tingkat kelas)
        $tingkatKelas = $ujian->rombel->kelas->tingkat;
        $availableSoals = Soal::where('guru_id', $guru->id)
            ->where('pelajaran_id', $ujian->pelajaran_id)
            ->where('tingkat_kelas', $tingkatKelas)
            ->whereNotIn('id', $ujian->soals->pluck('id'))
            ->get();

        return view('guru.ujian.manage-soal', compact('ujian', 'availableSoals'));
    }

    public function addSoal(Request $request, Ujian $ujian)
    {
        $this->authorize('update', $ujian);

        $validated = $request->validate([
            'soal_ids' => 'required|array',
            'soal_ids.*' => 'exists:soals,id',
        ]);

        $lastUrutan = $ujian->soals()->max('urutan') ?? 0;

        foreach ($validated['soal_ids'] as $index => $soalId) {
            if (!$ujian->soals()->where('soal_id', $soalId)->exists()) {
                $ujian->soals()->attach($soalId, ['urutan' => $lastUrutan + $index + 1]);
            }
        }

        return redirect()->route('guru.ujian.manage-soal', $ujian)
            ->with('success', 'Soal berhasil ditambahkan ke ujian.');
    }

    public function removeSoal(Ujian $ujian, Soal $soal)
    {
        $this->authorize('update', $ujian);
        
        $ujian->soals()->detach($soal->id);

        return redirect()->route('guru.ujian.manage-soal', $ujian)
            ->with('success', 'Soal berhasil dihapus dari ujian.');
    }

    public function publish(Ujian $ujian)
    {
        $this->authorize('update', $ujian);

        if ($ujian->soals()->count() === 0) {
            return redirect()->route('guru.ujian.manage-soal', $ujian)
                ->with('error', 'Ujian harus memiliki minimal 1 soal untuk dipublikasikan.');
        }

        $ujian->update(['status' => 'published']);

        return redirect()->route('guru.ujian.show', $ujian)
            ->with('success', 'Ujian berhasil dipublikasikan.');
    }

    // View Results
    public function hasil(Ujian $ujian)
    {
        $this->authorize('view', $ujian);
        
        $ujian->load(['hasilUjians.siswa', 'hasilUjians.jawabanSiswas.soal', 'rombel.kelas']);
        
        // Check if there are ungraded essays
        $ungradedEssays = 0;
        foreach ($ujian->hasilUjians as $hasil) {
            foreach ($hasil->jawabanSiswas as $jawaban) {
                if ($jawaban->soal->isEssay() && is_null($jawaban->poin_didapat)) {
                    $ungradedEssays++;
                }
            }
        }
        
        return view('guru.ujian.hasil', compact('ujian', 'ungradedEssays'));
    }

    // Essay Grading Page
    public function grading(Ujian $ujian)
    {
        $this->authorize('view', $ujian);
        
        $ujian->load(['hasilUjians.siswa', 'hasilUjians.jawabanSiswas.soal', 'soals', 'rombel.kelas']);
        
        // Get all essay answers that need grading
        $essayAnswers = [];
        foreach ($ujian->hasilUjians as $hasil) {
            foreach ($hasil->jawabanSiswas as $jawaban) {
                if ($jawaban->soal->isEssay()) {
                    $essayAnswers[] = [
                        'jawaban' => $jawaban,
                        'siswa' => $hasil->siswa,
                        'soal' => $jawaban->soal,
                    ];
                }
            }
        }
        
        return view('guru.ujian.grading', compact('ujian', 'essayAnswers'));
    }

    // Grade Essay Answer
    public function gradeEssay(Request $request, Ujian $ujian, \App\Models\JawabanSiswa $jawabanSiswa)
    {
        $this->authorize('update', $ujian);
        
        $validated = $request->validate([
            'poin_didapat' => 'required|integer|min:0|max:' . $jawabanSiswa->soal->poin,
        ]);
        
        $jawabanSiswa->update([
            'poin_didapat' => $validated['poin_didapat'],
            'is_benar' => $validated['poin_didapat'] > 0,
        ]);
        
        // Update total nilai for hasil ujian
        $hasilUjian = $jawabanSiswa->hasilUjian;
        $hasilUjian->calculateNilai();
        
        return redirect()->route('guru.ujian.grading', $ujian)
            ->with('success', 'Nilai essay berhasil disimpan.');
    }

    // View Detailed Student Result
    public function hasilDetail(Ujian $ujian, \App\Models\HasilUjian $hasilUjian)
    {
        $this->authorize('view', $ujian);
        
        // Ensure hasilUjian belongs to this ujian
        if ($hasilUjian->ujian_id !== $ujian->id) {
            abort(404);
        }
        
        $hasilUjian->load(['siswa', 'jawabanSiswas.soal']);
        $ujian->load(['soals', 'pelajaran', 'rombel.kelas']);
        
        return view('guru.ujian.hasil-detail', compact('ujian', 'hasilUjian'));
    }
}
