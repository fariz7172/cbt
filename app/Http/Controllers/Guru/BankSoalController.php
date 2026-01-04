<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankSoalController extends Controller
{
    /**
     * Get pelajarans based on guru's jabatan.
     * - Guru Kelas: only pelajarans with jenis = 'guru_kelas'
     * - Guru Mapel: only pelajarans assigned through rombel_pelajaran
     */
    private function getPelajaransForGuru($guru)
    {
        if ($guru->isGuruKelas()) {
            // Guru Kelas hanya bisa membuat soal untuk pelajaran guru_kelas
            return Pelajaran::where('is_active', true)
                ->where('jenis', 'guru_kelas')
                ->orderBy('nama')
                ->get();
        } else {
            // Guru Mapel hanya bisa membuat soal untuk pelajaran yang di-assign
            return $guru->pelajarans()
                ->where('is_active', true)
                ->orderBy('nama')
                ->distinct()
                ->get();
        }
    }

    /**
     * Get tingkat kelas based on guru's assigned rombels.
     * - Guru Kelas: only tingkat from rombels where they are wali kelas
     * - Guru Mapel: tingkat from all rombels where they teach
     */
    private function getTingkatKelasForGuru($guru)
    {
        if ($guru->isGuruKelas()) {
            // Guru Kelas only sees tingkat from rombels where they are wali kelas
            return Rombel::with('kelas')
                ->where('wali_kelas_id', $guru->id)
                ->get()
                ->pluck('kelas.tingkat')
                ->unique()
                ->sort()
                ->values();
        } else {
            // Guru Mapel sees tingkat from all rombels where they teach
            return $guru->rombels()
                ->with('kelas')
                ->get()
                ->pluck('kelas.tingkat')
                ->unique()
                ->sort()
                ->values();
        }
    }

    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        
        // Guru only sees soals they created themselves
        $query = Soal::with('pelajaran', 'guru')->where('guru_id', $guru->id);

        if ($request->filled('pelajaran_id')) {
            $query->where('pelajaran_id', $request->pelajaran_id);
        }

        if ($request->filled('tingkat_kelas')) {
            $query->where('tingkat_kelas', $request->tingkat_kelas);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        $soals = $query->latest()->paginate(10)->withQueryString();
        $pelajarans = $this->getPelajaransForGuru($guru);

        return view('guru.bank-soal.index', compact('soals', 'pelajarans'));
    }

    public function create()
    {
        $guru = auth()->user()->guru;
        $pelajarans = $this->getPelajaransForGuru($guru);
        $tingkatKelas = $this->getTingkatKelasForGuru($guru);
        return view('guru.bank-soal.create', compact('pelajarans', 'tingkatKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'tingkat_kelas' => 'required|integer|min:1|max:6',
            'tipe' => 'required|in:pilihan_ganda,essay,benar_salah',
            'pertanyaan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi' => 'nullable|array',
            'opsi.*' => 'nullable|string',
            'kunci_jawaban' => 'required|string',
            'poin' => 'required|integer|min:1',
        ]);

        $validated['guru_id'] = auth()->user()->guru->id;
        
        // Handle image upload
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('soal-images', 'public_uploads');
        }
        
        // Filter empty options and re-key to A, B, C...
        if (isset($validated['opsi'])) {
            $validated['opsi'] = array_values(array_filter($validated['opsi'], fn($v) => !empty($v)));
            $keys = range('A', 'Z');
            $newOpsi = [];
            foreach ($validated['opsi'] as $index => $value) {
                if (isset($keys[$index])) {
                    $newOpsi[$keys[$index]] = $value;
                }
            }
            $validated['opsi'] = $newOpsi;
        }

        Soal::create($validated);

        return redirect()->route('guru.bank-soal.index')
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function show(Soal $bankSoal)
    {
        $this->authorize('view', $bankSoal);
        return view('guru.bank-soal.show', ['soal' => $bankSoal]);
    }

    public function edit(Soal $bankSoal)
    {
        $this->authorize('update', $bankSoal);
        $guru = auth()->user()->guru;
        $pelajarans = $this->getPelajaransForGuru($guru);
        $tingkatKelas = $this->getTingkatKelasForGuru($guru);
        return view('guru.bank-soal.edit', ['soal' => $bankSoal, 'pelajarans' => $pelajarans, 'tingkatKelas' => $tingkatKelas]);
    }

    public function update(Request $request, Soal $bankSoal)
    {
        $this->authorize('update', $bankSoal);

        $validated = $request->validate([
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'tingkat_kelas' => 'required|integer|min:1|max:6',
            'tipe' => 'required|in:pilihan_ganda,essay,benar_salah',
            'pertanyaan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi' => 'nullable|array',
            'opsi.*' => 'nullable|string',
            'kunci_jawaban' => 'required|string',
            'poin' => 'required|integer|min:1',
        ]);

        // Handle image upload
        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($bankSoal->gambar) {
                Storage::disk('public_uploads')->delete($bankSoal->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('soal-images', 'public_uploads');
        }
        
        // Handle image removal
        if ($request->has('hapus_gambar') && $request->hapus_gambar) {
            if ($bankSoal->gambar) {
                Storage::disk('public_uploads')->delete($bankSoal->gambar);
            }
            $validated['gambar'] = null;
        }

        // Filter empty options and re-key to A, B, C...
        if (isset($validated['opsi'])) {
            $validated['opsi'] = array_values(array_filter($validated['opsi'], fn($v) => !empty($v)));
            $keys = range('A', 'Z');
            $newOpsi = [];
            foreach ($validated['opsi'] as $index => $value) {
                if (isset($keys[$index])) {
                    $newOpsi[$keys[$index]] = $value;
                }
            }
            $validated['opsi'] = $newOpsi;
        }

        $bankSoal->update($validated);

        return redirect()->route('guru.bank-soal.index')
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $bankSoal)
    {
        $this->authorize('delete', $bankSoal);

        if ($bankSoal->ujians()->count() > 0) {
            return redirect()->route('guru.bank-soal.index')
                ->with('error', 'Soal tidak dapat dihapus karena sudah digunakan dalam ujian.');
        }

        $bankSoal->delete();

        return redirect()->route('guru.bank-soal.index')
            ->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * Show form for batch creating multiple questions.
     */
    public function createBatch()
    {
        $guru = auth()->user()->guru;
        $pelajarans = $this->getPelajaransForGuru($guru);
        $tingkatKelas = $this->getTingkatKelasForGuru($guru);
        return view('guru.bank-soal.create-batch', compact('pelajarans', 'tingkatKelas'));
    }

    /**
     * Store multiple questions at once (supports mixed types).
     */
    public function storeBatch(Request $request)
    {
        $request->validate([
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'tingkat_kelas' => 'required|integer|min:1|max:6',
            'soals' => 'required|array|min:1',
            'soals.*.tipe' => 'required|in:pilihan_ganda,essay,benar_salah',
            'soals.*.pertanyaan' => 'required|string',
            'soals.*.opsi' => 'nullable|array',
            'soals.*.kunci_jawaban' => 'required|string',
            'soals.*.poin' => 'required|integer|min:1',
        ]);

        $guru = auth()->user()->guru;
        $count = 0;

        foreach ($request->soals as $soalData) {
            // Skip empty questions
            if (empty(trim($soalData['pertanyaan']))) {
                continue;
            }

            $tipe = $soalData['tipe'];
            $opsi = null;
            
            // Only process opsi for pilihan_ganda type
            if ($tipe === 'pilihan_ganda' && isset($soalData['opsi'])) {
                $opsiValues = array_values(array_filter($soalData['opsi'], fn($v) => !empty($v)));
                $keys = range('A', 'Z');
                $opsi = [];
                foreach ($opsiValues as $index => $value) {
                    if (isset($keys[$index])) {
                        $opsi[$keys[$index]] = $value;
                    }
                }
            }

            Soal::create([
                'guru_id' => $guru->id,
                'pelajaran_id' => $request->pelajaran_id,
                'tingkat_kelas' => $request->tingkat_kelas,
                'tipe' => $tipe,
                'pertanyaan' => $soalData['pertanyaan'],
                'opsi' => $opsi,
                'kunci_jawaban' => $soalData['kunci_jawaban'],
                'poin' => $soalData['poin'],
            ]);
            $count++;
        }

        return redirect()->route('guru.bank-soal.index')
            ->with('success', "{$count} soal berhasil ditambahkan.");
    }

    /**
     * Download template Excel for import.
     */
    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TemplateSoalExport, 'template_soal.xlsx');
    }

    /**
     * Show import form.
     */
    public function showImportForm()
    {
        return view('guru.bank-soal.import');
    }

    /**
     * Process Excel import.
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $guru = auth()->user()->guru;
        $import = new \App\Imports\SoalImport($guru);
        
        try {
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));
            
            $errors = $import->getErrors();
            $count = $import->getImportedCount();
            
            $message = "{$count} soal berhasil diimport.";
            if (count($errors) > 0) {
                $message .= " " . count($errors) . " baris gagal.";
            }

            return redirect()->route('guru.bank-soal.index')
                ->with('success', $message)
                ->with('import_errors', $errors);
                
        } catch (\Throwable $e) {
            // Check for ZipArchive error
            if (str_contains($e->getMessage(), 'ZipArchive') || str_contains($e->getMessage(), 'zip')) {
                return back()->with('error', 'Gagal: Ekstensi PHP Zip belum aktif di server. Pastikan extension=zip diaktifkan di php.ini dan restart server.')->withInput();
            }
            
            return back()->with('error', 'Gagal import file: ' . $e->getMessage())->withInput();
        }
    }
}
