<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalMatematikaKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran Matematika
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Matematika'],
            ['kode' => 'MTK', 'jenis' => 'guru_kelas'] 
        );

        // 2. Ambil User Guru Kelas 1 (Siti Fatimah)
        $userGuru = User::where('email', 'guru.kelas1@madrasah.com')->first();
        
        if ($userGuru && $userGuru->guru) {
            $guru = $userGuru->guru;
        } else {
            // Fallback ke guru pertama jika user spesifik tidak ada
            $guru = Guru::first();
            echo "Warning: User guru.kelas1 tidak ditemukan, menggunakan guru id: {$guru->id}\n";
        }

        $commonData = [
            'guru_id' => $guru->id,
            'pelajaran_id' => $pelajaran->id,
            'tingkat_kelas' => 1,
        ];

        // --- 50 SOAL PILIHAN GANDA ---
        // Topik: Penjumlahan, Pengurangan, Bangun Datar, Urutan Angka, Waktu, Panjang/Berat
        
        $pgQuestions = [
            ['q' => '1 + 1 = ...', 'a' => 'A', 'opsi' => ['A' => '2', 'B' => '3', 'C' => '4']],
            ['q' => '2 + 3 = ...', 'a' => 'B', 'opsi' => ['A' => '4', 'B' => '5', 'C' => '6']],
            ['q' => 'Ayah membeli 3 apel, lalu membeli lagi 2 apel. Jumlah apel ayah adalah ...', 'a' => 'C', 'opsi' => ['A' => '4', 'B' => '6', 'C' => '5']],
            ['q' => 'Angka setelah 7 adalah ...', 'a' => 'B', 'opsi' => ['A' => '6', 'B' => '8', 'C' => '9']],
            ['q' => 'Angka sebelum 10 adalah ...', 'a' => 'A', 'opsi' => ['A' => '9', 'B' => '11', 'C' => '8']],
            ['q' => '5 - 2 = ...', 'a' => 'C', 'opsi' => ['A' => '4', 'B' => '1', 'C' => '3']],
            ['q' => 'Benda yang berbentuk bulat adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Buku', 'B' => 'Bola', 'C' => 'Meja']],
            ['q' => 'Benda yang berbentuk kotak adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Kardus', 'B' => 'Kelereng', 'C' => 'Gelas']],
            ['q' => '8 ... 5 (Lebih besar/kecil)', 'a' => 'A', 'opsi' => ['A' => 'Lebih besar dari', 'B' => 'Lebih kecil dari', 'C' => 'Sama dengan']],
            ['q' => '3 ... 9 (Lebih besar/kecil)', 'a' => 'B', 'opsi' => ['A' => 'Lebih besar dari', 'B' => 'Lebih kecil dari', 'C' => 'Sama dengan']],
            ['q' => 'Jumlah jari tangan kanan dan kiri adalah ...', 'a' => 'C', 'opsi' => ['A' => '5', 'B' => '8', 'C' => '10']],
            ['q' => 'Lambang bilangan "Dua Belas" adalah ...', 'a' => 'A', 'opsi' => ['A' => '12', 'B' => '21', 'C' => '2']],
            ['q' => 'Nama bilangan dari 15 adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Satu Lima', 'B' => 'Lima Belas', 'C' => 'Lima Puluh']],
            ['q' => '4 + 4 = ...', 'a' => 'C', 'opsi' => ['A' => '6', 'B' => '7', 'C' => '8']],
            ['q' => '9 - 4 = ...', 'a' => 'B', 'opsi' => ['A' => '4', 'B' => '5', 'C' => '6']],
            ['q' => 'Bangun datar yang memiliki 3 sisi disebut ...', 'a' => 'A', 'opsi' => ['A' => 'Segitiga', 'B' => 'Segiempat', 'C' => 'Lingkaran']],
            ['q' => 'Uang koin berbentuk ...', 'a' => 'C', 'opsi' => ['A' => 'Kotak', 'B' => 'Segitiga', 'C' => 'Lingkaran']],
            ['q' => 'Urutan angka dari terkecil: 3, 1, 5 adalah ...', 'a' => 'A', 'opsi' => ['A' => '1, 3, 5', 'B' => '5, 3, 1', 'C' => '1, 5, 3']],
            ['q' => 'Urutan angka dari terbesar: 6, 8, 2 adalah ...', 'a' => 'B', 'opsi' => ['A' => '2, 6, 8', 'B' => '8, 6, 2', 'C' => '6, 2, 8']],
            ['q' => 'Siti punya 5 permen, dikasih Adik 2 permen. Sisa permen Siti ...', 'a' => 'C', 'opsi' => ['A' => '7', 'B' => '5', 'C' => '3']],
            ['q' => 'Hari ini hari Senin, besok hari ...', 'a' => 'B', 'opsi' => ['A' => 'Minggu', 'B' => 'Selasa', 'C' => 'Rabu']],
            ['q' => 'Jarum panjang jam menunjuk angka 12, jarum pendek angka 6. Maka pukul ...', 'a' => 'A', 'opsi' => ['A' => '06.00', 'B' => '12.00', 'C' => '09.00']],
            ['q' => '1 minggu ada ... hari.', 'a' => 'C', 'opsi' => ['A' => '5', 'B' => '6', 'C' => '7']],
            ['q' => 'Gajah lebih ... daripada semut.', 'a' => 'B', 'opsi' => ['A' => 'Kecil', 'B' => 'Besar', 'C' => 'Ringan']],
            ['q' => 'Kapas lebih ... daripada batu.', 'a' => 'A', 'opsi' => ['A' => 'Ringan', 'B' => 'Berat', 'C' => 'Keras']],
            ['q' => '10 + 10 = ...', 'a' => 'B', 'opsi' => ['A' => '10', 'B' => '20', 'C' => '30']],
            ['q' => '15 - 5 = ...', 'a' => 'C', 'opsi' => ['A' => '5', 'B' => '15', 'C' => '10']],
            ['q' => 'Banyak kaki seekor kambing ada ...', 'a' => 'A', 'opsi' => ['A' => '4', 'B' => '2', 'C' => '3']],
            ['q' => 'Roda sepeda bentuknya ...', 'a' => 'B', 'opsi' => ['A' => 'Persegi', 'B' => 'Lingkaran', 'C' => 'Segitiga']],
            ['q' => 'Buku tulis bentuknya ...', 'a' => 'C', 'opsi' => ['A' => 'Bulat', 'B' => 'Segitiga', 'C' => 'Persegi Panjang']],
            ['q' => '6 + 2 ... 10 - 2. Tanda yang tepat adalah ...', 'a' => 'C', 'opsi' => ['A' => '>', 'B' => '<', 'C' => '=']],
            ['q' => 'Tujuh belas ditulis angka ...', 'a' => 'A', 'opsi' => ['A' => '17', 'B' => '71', 'C' => '7']],
            ['q' => 'Bilangan loncat 2: 2, 4, 6, ...', 'a' => 'B', 'opsi' => ['A' => '7', 'B' => '8', 'C' => '9']],
            ['q' => 'Penggaris panjangnya 30 ...', 'a' => 'B', 'opsi' => ['A' => 'kg', 'B' => 'cm', 'C' => 'jam']],
            ['q' => 'Berat badan diukur dengan ...', 'a' => 'A', 'opsi' => ['A' => 'Timbangan', 'B' => 'Penggaris', 'C' => 'Jam']],
            ['q' => '3 + 3 + 3 = ...', 'a' => 'C', 'opsi' => ['A' => '6', 'B' => '333', 'C' => '9']],
            ['q' => 'Dua puluh lima ditulis ...', 'a' => 'B', 'opsi' => ['A' => '205', 'B' => '25', 'C' => '52']],
            ['q' => 'Sekarang jam 7 pagi. 1 jam lagi jam ...', 'a' => 'B', 'opsi' => ['A' => '6', 'B' => '8', 'C' => '9']],
            ['q' => 'Bangun yang sisinya sama panjang adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Persegi', 'B' => 'Persegi Panjang', 'C' => 'Segitiga']],
            ['q' => '8 - 0 = ...', 'a' => 'B', 'opsi' => ['A' => '0', 'B' => '8', 'C' => '80']],
            ['q' => '1 puluhan + 3 satuan = ...', 'a' => 'A', 'opsi' => ['A' => '13', 'B' => '31', 'C' => '4']],
            ['q' => 'Jumlah sisi segitiga ada ...', 'a' => 'C', 'opsi' => ['A' => '4', 'B' => '5', 'C' => '3']],
            ['q' => '12, 13, 14, ..., 16', 'a' => 'B', 'opsi' => ['A' => '11', 'B' => '15', 'C' => '17']],
            ['q' => 'Tali A panjang, Tali B pendek. Tali A ... Tali B', 'a' => 'A', 'opsi' => ['A' => 'Lebih panjang dari', 'B' => 'Lebih pendek dari', 'C' => 'Sama panjang dengan']],
            ['q' => '20, 19, 18, 17, ...', 'a' => 'C', 'opsi' => ['A' => '15', 'B' => '19', 'C' => '16']],
            ['q' => 'Ibu punya 10 telur, pecah 3. Sisa telur ibu ...', 'a' => 'B', 'opsi' => ['A' => '6', 'B' => '7', 'C' => '8']],
            ['q' => 'Kakek punya 2 ekor ayam. Paman memberi 3 ekor ayam. Ayam kakek sekarang ...', 'a' => 'A', 'opsi' => ['A' => '5', 'B' => '6', 'C' => '4']],
            ['q' => '7 + ... = 10', 'a' => 'C', 'opsi' => ['A' => '1', 'B' => '2', 'C' => '3']],
            ['q' => 'Angka 5, 8, 4. Yang paling besar adalah ...', 'a' => 'A', 'opsi' => ['A' => '8', 'B' => '5', 'C' => '4']],
            ['q' => 'Satu hari ada ... jam.', 'a' => 'B', 'opsi' => ['A' => '12', 'B' => '24', 'C' => '48']],
        ];

        foreach ($pgQuestions as $q) {
            Soal::create(array_merge($commonData, [
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => $q['q'],
                'opsi' => $q['opsi'],
                'kunci_jawaban' => $q['a'],
                'poin' => 2,
            ]));
        }

        // --- 20 SOAL ESSAY ---
        // Topik: Operasi hitung dasar, teka-teki logika sederhana
        
        $essayQuestions = [
            ['q' => '4 + 5 = ...', 'a' => '9'],
            ['q' => '10 - 3 = ...', 'a' => '7'],
            ['q' => 'Tulislah lambang bilangan "delapan belas"!', 'a' => '18'],
            ['q' => 'Bangun datar yang memiliki 4 sisi sama panjang disebut ...', 'a' => 'Persegi'],
            ['q' => '1, 2, 3, 4, ... (lanjutkan)', 'a' => '5'],
            ['q' => 'Jumlah jari di kedua kakimu adalah ...', 'a' => '10'],
            ['q' => 'Budi punya 5 kelereng, hilang 1. Sisa kelereng Budi adalah ...', 'a' => '4'],
            ['q' => '6 + 6 = ...', 'a' => '12'],
            ['q' => 'Angka sebelum 20 adalah ...', 'a' => '19'],
            ['q' => 'Bola berbentuk ...', 'a' => 'Bulat / Lingkaran / Bola'],
            ['q' => '2 puluhan + 4 satuan = ...', 'a' => '24'],
            ['q' => '8 - 4 = ...', 'a' => '4'],
            ['q' => 'Alat untuk mengukur panjang adalah ...', 'a' => 'Penggaris'],
            ['q' => 'Batu itu berat, kapas itu ...', 'a' => 'Ringan'],
            ['q' => 'Mana yang lebih banyak: 5 permen atau 10 permen?', 'a' => '10 permen'],
            ['q' => 'Segitiga memiliki ... sisi.', 'a' => '3'],
            ['q' => '5 + 5 + 5 = ...', 'a' => '15'],
            ['q' => 'Tuliskan angka "Tiga Puluh"!', 'a' => '30'],
            ['q' => 'Ibu membeli 2 roti. Ayah membeli 2 roti. Jumlah roti ada ...', 'a' => '4'],
            ['q' => 'Jarum jam menunjuk angka 12 siang. Itu tandanya waktu ...', 'a' => 'Siang / Istirahat / Solat'],
        ];

        foreach ($essayQuestions as $q) {
            Soal::create(array_merge($commonData, [
                'tipe' => 'essay',
                'pertanyaan' => $q['q'],
                'kunci_jawaban' => $q['a'],
                'poin' => 5,
            ]));
        }
    }
}
