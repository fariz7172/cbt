<?php

namespace App\Imports;

use App\Models\Soal;
use App\Models\Pelajaran;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class SoalImport implements ToCollection, WithHeadingRow
{
    private $guru;
    private $errors = [];
    private $importedCount = 0;

    public function __construct($guru)
    {
        $this->guru = $guru;
    }

    public function collection(Collection $rows)
    {
        $lineNumber = 2; // Row 1 is header

        foreach ($rows as $row) {
            // Skip empty rows
            if ($row->filter()->isEmpty()) {
                $lineNumber++;
                continue;
            }

            try {
                // Map columns (adjust keys based on your Excel header slug)
                $pelajaranNama = trim($row['mata_pelajaran'] ?? '');
                $tingkatKelas = trim($row['tingkat_kelas'] ?? '');
                $tipe = trim($row['tipe'] ?? '');
                $pertanyaan = trim($row['pertanyaan'] ?? '');
                $kunciJawaban = trim($row['kunci_jawaban'] ?? '');
                $poin = trim($row['poin'] ?? '');

                // Validation
                if (empty($pelajaranNama) || empty($tingkatKelas) || empty($tipe) || empty($pertanyaan) || empty($kunciJawaban) || empty($poin)) {
                    $this->errors[] = "Baris {$lineNumber}: Data tidak lengkap";
                    $lineNumber++;
                    continue;
                }

                // Find pelajaran
                $pelajaran = Pelajaran::where('nama', 'LIKE', "%{$pelajaranNama}%")
                    ->where('sekolah_id', $this->guru->sekolah_id)
                    ->first();

                if (!$pelajaran) {
                    $this->errors[] = "Baris {$lineNumber}: Mata pelajaran '{$pelajaranNama}' tidak ditemukan";
                    $lineNumber++;
                    continue;
                }

                // Validate tipe
                if (!in_array($tipe, ['pilihan_ganda', 'essay', 'benar_salah'])) {
                    $this->errors[] = "Baris {$lineNumber}: Tipe soal tidak valid. Gunakan: pilihan_ganda, essay, atau benar_salah";
                    $lineNumber++;
                    continue;
                }

                // Validate tingkat kelas
                if (!is_numeric($tingkatKelas) || $tingkatKelas < 1 || $tingkatKelas > 12) {
                    $this->errors[] = "Baris {$lineNumber}: Tingkat kelas harus antara 1-12";
                    $lineNumber++;
                    continue;
                }

                // Prepare opsi for pilihan_ganda
                $opsi = null;
                if ($tipe === 'pilihan_ganda') {
                    $opsiArray = [];
                    if (!empty($row['opsi_a'])) $opsiArray['A'] = (string)$row['opsi_a'];
                    if (!empty($row['opsi_b'])) $opsiArray['B'] = (string)$row['opsi_b'];
                    if (!empty($row['opsi_c'])) $opsiArray['C'] = (string)$row['opsi_c'];
                    if (!empty($row['opsi_d'])) $opsiArray['D'] = (string)$row['opsi_d'];
                    if (!empty($row['opsi_e'])) $opsiArray['E'] = (string)$row['opsi_e'];

                    if (count($opsiArray) < 2) {
                        $this->errors[] = "Baris {$lineNumber}: Pilihan ganda harus memiliki minimal 2 opsi";
                        $lineNumber++;
                        continue;
                    }

                    // Validate kunci jawaban
                    if (!isset($opsiArray[$kunciJawaban])) {
                        $this->errors[] = "Baris {$lineNumber}: Kunci jawaban '{$kunciJawaban}' tidak ada dalam opsi";
                        $lineNumber++;
                        continue;
                    }

                    $opsi = $opsiArray;
                } elseif ($tipe === 'benar_salah') {
                    if (!in_array(strtolower($kunciJawaban), ['benar', 'salah'])) {
                        $this->errors[] = "Baris {$lineNumber}: Kunci jawaban benar/salah harus 'benar' atau 'salah'";
                        $lineNumber++;
                        continue;
                    }
                }

                // Create soal
                Soal::create([
                    'guru_id' => $this->guru->id,
                    'pelajaran_id' => $pelajaran->id,
                    'tingkat_kelas' => (int)$tingkatKelas,
                    'tipe' => $tipe,
                    'pertanyaan' => $pertanyaan,
                    'opsi' => $opsi,
                    'kunci_jawaban' => $kunciJawaban,
                    'poin' => (int)$poin,
                ]);

                $this->importedCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Baris {$lineNumber}: " . $e->getMessage();
            }

            $lineNumber++;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }
}
