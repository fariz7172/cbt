<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalPknKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran PKN
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Pendidikan Kewarganegaraan'],
            ['kode' => 'PKN', 'jenis' => 'guru_kelas'] 
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
        // Topik: Pancasila, Aturan di Rumah/Sekolah, Hak & Kewajiban, Hidup Rukun
        
        $pgQuestions = [
            ['q' => 'Lambang negara Indonesia adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Garuda Pancasila', 'B' => 'Harimau', 'C' => 'Gajah']],
            ['q' => 'Dasar negara kita adalah ...', 'a' => 'B', 'opsi' => ['A' => 'UUD 1945', 'B' => 'Pancasila', 'C' => 'Burung Garuda']],
            ['q' => 'Sila pertama berbunyi Ketuhanan Yang Maha ...', 'a' => 'A', 'opsi' => ['A' => 'Esa', 'B' => 'Dua', 'C' => 'Kuasa']],
            ['q' => 'Lambang sila pertama adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Rantai', 'B' => 'Bintang', 'C' => 'Pohon Beringin']],
            ['q' => 'Lambang sila kedua adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Rantai', 'B' => 'Bintang', 'C' => 'Kepala Banteng']],
            ['q' => 'Pohon beringin adalah lambang sila ke...', 'a' => 'C', 'opsi' => ['A' => '1', 'B' => '2', 'C' => '3']],
            ['q' => 'Kepala banteng adalah lambang sila ke...', 'a' => 'A', 'opsi' => ['A' => '4', 'B' => '3', 'C' => '5']],
            ['q' => 'Padi dan kapas adalah lambang sila ke...', 'a' => 'C', 'opsi' => ['A' => '3', 'B' => '4', 'C' => '5']],
            ['q' => 'Warna bendera Indonesia adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Merah Putih', 'B' => 'Putih Merah', 'C' => 'Merah Biru']],
            ['q' => 'Sebelum belajar kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Makan', 'B' => 'Berdoa', 'C' => 'Tidur']],
            ['q' => 'Anak yang rajin berdoa disayang ...', 'a' => 'A', 'opsi' => ['A' => 'Tuhan', 'B' => 'Setan', 'C' => 'Teman']],
            ['q' => 'Teman beragama Kristen beribadah di ...', 'a' => 'C', 'opsi' => ['A' => 'Masjid', 'B' => 'Pura', 'C' => 'Gereja']],
            ['q' => 'Umat Islam beribadah di ...', 'a' => 'A', 'opsi' => ['A' => 'Masjid', 'B' => 'Gereja', 'C' => 'Wihara']],
            ['q' => 'Jika ada teman yang berdoa, kita tidak boleh ...', 'a' => 'B', 'opsi' => ['A' => 'Ikut', 'B' => 'Mengganggu', 'C' => 'Diam']],
            ['q' => 'Hidup rukun membuat hati menjadi ...', 'a' => 'A', 'opsi' => ['A' => 'Senang', 'B' => 'Sedih', 'C' => 'Marah']],
            ['q' => 'Bermain dengan teman tidak boleh ...', 'a' => 'C', 'opsi' => ['A' => 'Bersama', 'B' => 'Gantian', 'C' => 'Curang']],
            ['q' => 'Jika teman jatuh dari sepeda, kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Menertawakan', 'B' => 'Menolong', 'C' => 'Meninggalkan']],
            ['q' => 'Anak yang jujur akan punya ... teman.', 'a' => 'A', 'opsi' => ['A' => 'Banyak', 'B' => 'Sedikit', 'C' => 'Musuh']],
            ['q' => 'Jika meminjam mainan teman harus ...', 'a' => 'C', 'opsi' => ['A' => 'Dibuang', 'B' => 'Dirusak', 'C' => 'Dikembalikan']],
            ['q' => 'Aturan di rumah harus di...', 'a' => 'B', 'opsi' => ['A' => 'Langgar', 'B' => 'Taati', 'C' => 'Abaikan']],
            ['q' => 'Bangun tidur sebaiknya ... tempat tidur.', 'a' => 'A', 'opsi' => ['A' => 'Merapikan', 'B' => 'Mengotori', 'C' => 'Melihat']],
            ['q' => 'Sebelum berangkat sekolah harus ... kepada orang tua.', 'a' => 'C', 'opsi' => ['A' => 'Minta uang', 'B' => 'Menangis', 'C' => 'Berpamitan']],
            ['q' => 'Sampah harus dibuang di ...', 'a' => 'B', 'opsi' => ['A' => 'Sungai', 'B' => 'Tempat sampah', 'C' => 'Jalan']],
            ['q' => 'Upacara bendera dilaksanakan setiap hari ...', 'a' => 'A', 'opsi' => ['A' => 'Senin', 'B' => 'Selasa', 'C' => 'Minggu']],
            ['q' => 'Saat upacara kita harus berdiri dengan ...', 'a' => 'C', 'opsi' => ['A' => 'Santai', 'B' => 'Miring', 'C' => 'Tegap']],
            ['q' => 'Seragam sekolah harus dipakai dengan ...', 'a' => 'B', 'opsi' => ['A' => 'Kotor', 'B' => 'Rapi', 'C' => 'Sembarangan']],
            ['q' => 'Terlambat datang ke sekolah adalah perbuatan ...', 'a' => 'A', 'opsi' => ['A' => 'Buruk', 'B' => 'Baik', 'C' => 'Hebat']],
            ['q' => 'Anak yang tertib akan ... pelajaran.', 'a' => 'C', 'opsi' => ['A' => 'Ketinggalan', 'B' => 'Membenci', 'C' => 'Mengerti']],
            ['q' => 'Piket kelas dilakukan secara ...', 'a' => 'B', 'opsi' => ['A' => 'Sendiri', 'B' => 'Bersama-sama', 'C' => 'Gantian']],
            ['q' => 'Hak adalah sesuatu yang harus kita ...', 'a' => 'A', 'opsi' => ['A' => 'Terima', 'B' => 'Beri', 'C' => 'Buang']],
            ['q' => 'Kewajiban adalah sesuatu yang harus kita ...', 'a' => 'B', 'opsi' => ['A' => 'Hindari', 'B' => 'Kerjakan', 'C' => 'Lupakan']],
            ['q' => 'Mendapat kasih sayang orang tua adalah ... anak.', 'a' => 'A', 'opsi' => ['A' => 'Hak', 'B' => 'Kewajiban', 'C' => 'Tugas']],
            ['q' => 'Belajar adalah ... seorang siswa.', 'a' => 'B', 'opsi' => ['A' => 'Hak', 'B' => 'Kewajiban', 'C' => 'Larangan']],
            ['q' => 'Laki-laki dan perempuan berbeda jenis ...', 'a' => 'C', 'opsi' => ['A' => 'Rambut', 'B' => 'Baju', 'C' => 'Kelamin']],
            ['q' => 'Kita harus menghormati orang yang lebih ...', 'a' => 'A', 'opsi' => ['A' => 'Tua', 'B' => 'Muda', 'C' => 'Kaya']],
            ['q' => 'Adik harus kita ...', 'a' => 'B', 'opsi' => ['A' => 'Pukul', 'B' => 'Sayangi', 'C' => 'Biarkan']],
            ['q' => 'Kakak dan adik tidak boleh ...', 'a' => 'C', 'opsi' => ['A' => 'Bermain', 'B' => 'Belajar', 'C' => 'Bertengkar']],
            ['q' => 'Makan harus menggunakan tangan ...', 'a' => 'A', 'opsi' => ['A' => 'Kanan', 'B' => 'Kiri', 'C' => 'Dua-duanya']],
            ['q' => 'Berbicara kasar itu ...', 'a' => 'B', 'opsi' => ['A' => 'Boleh', 'B' => 'Tidak boleh', 'C' => 'Hebat']],
            ['q' => 'Jika guru menerangkan pelajaran, kita harus ...', 'a' => 'C', 'opsi' => ['A' => 'Tidur', 'B' => 'Main', 'C' => 'Mendengarkan']],
            ['q' => 'Presiden Indonesia pertama adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Soekarno', 'B' => 'Soeharto', 'C' => 'Habibie']],
            ['q' => 'Wakil Presiden Indonesia pertama adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Soekarno', 'B' => 'Moh. Hatta', 'C' => 'Sudirman']],
            ['q' => 'Bhineka Tunggal Ika artinya berbeda-beda tetap ... jua.', 'a' => 'A', 'opsi' => ['A' => 'Satu', 'B' => 'Dua', 'C' => 'Tiga']],
            ['q' => 'Gotong royong adalah budaya bangsa ...', 'a' => 'C', 'opsi' => ['A' => 'Jepang', 'B' => 'Belanda', 'C' => 'Indonesia']],
            ['q' => 'Di sekolah kita tidak boleh membedakan ...', 'a' => 'B', 'opsi' => ['A' => 'Buku', 'B' => 'Teman', 'C' => 'Sepatu']],
            ['q' => 'Kebersihan adalah pangkal ...', 'a' => 'A', 'opsi' => ['A' => 'Kesehatan', 'B' => 'Kekayaan', 'C' => 'Kepandaian']],
            ['q' => 'Buanglah sampah pada ...', 'a' => 'C', 'opsi' => ['A' => 'Tempat tidur', 'B' => 'Lantai', 'C' => 'Tempatnya']],
            ['q' => 'Menjaga kebersihan lingkungan adalah tugas ...', 'a' => 'B', 'opsi' => ['A' => 'Pemerintah', 'B' => 'Kita semua', 'C' => 'Orang tua']],
            ['q' => 'Lingkungan yang kotor menyebabkan ...', 'a' => 'A', 'opsi' => ['A' => 'Penyakit', 'B' => 'Sehat', 'C' => 'Senang']],
            ['q' => 'Kita wajib bangga menjadi anak ...', 'a' => 'C', 'opsi' => ['A' => 'Malaysia', 'B' => 'Singapura', 'C' => 'Indonesia']],
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
        // Topik: Penerapan nilai Pancasila dan Kewarganegaraan
        
        $essayQuestions = [
            ['q' => 'Apa dasar negara Indonesia?', 'a' => 'Pancasila'],
            ['q' => 'Sila pertama dilambangkan dengan gambar ...', 'a' => 'Bintang'],
            ['q' => 'Bunyi sila ketiga adalah ...', 'a' => 'Persatuan Indonesia'],
            ['q' => 'Apa warna bendera Indonesia?', 'a' => 'Merah Putih'],
            ['q' => 'Sebutkan agamamu!', 'a' => 'Islam (atau menyesuaikan)'],
            ['q' => 'Tempat ibadah umat Islam adalah ...', 'a' => 'Masjid'],
            ['q' => 'Tempat ibadah umat Kristen adalah ...', 'a' => 'Gereja'],
            ['q' => 'Kita harus ... kepada orang tua dan guru.', 'a' => 'Hormat / Patuh'],
            ['q' => 'Jika berbuat salah, kita harus meminta ...', 'a' => 'Maaf'],
            ['q' => 'Sebutkan satu aturan di rumah!', 'a' => 'Tidur tepat waktu / Merapikan mainan'],
            ['q' => 'Sebutkan satu aturan di sekolah!', 'a' => 'Datang tepat waktu / Pakai seragam'],
            ['q' => 'Apa yang kamu lakukan jika melihat teman jatuh?', 'a' => 'Menolongnya'],
            ['q' => 'Bersatu kita teguh, bercerai kita ...', 'a' => 'Runtuh'],
            ['q' => 'Sebutkan kewajibanmu sebagai siswa!', 'a' => 'Belajar'],
            ['q' => 'Apa hakmu di rumah?', 'a' => 'Disayang orang tua / Dapat makan'],
            ['q' => 'Siapa pemimpin di sekolah?', 'a' => 'Kepala Sekolah'],
            ['q' => 'Siapa pemimpin di negara kita?', 'a' => 'Presiden'],
            ['q' => 'Lagu kebangsaan Indonesia adalah ...', 'a' => 'Indonesia Raya'],
            ['q' => 'Sebutkan suku bangsa yang kamu tahu!', 'a' => 'Jawa / Sunda / Batak / dll'],
            ['q' => 'Aku bangga menjadi anak ...', 'a' => 'Indonesia'],
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
