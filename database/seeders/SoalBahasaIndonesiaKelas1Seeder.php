<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalBahasaIndonesiaKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran Bahasa Indonesia
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Bahasa Indonesia'],
            ['kode' => 'BIN', 'jenis' => 'guru_kelas'] 
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
        // Topik: Huruf, Suku Kata, Benda Sekitar, Kalimat Sederhana
        
        $pgQuestions = [
            ['q' => 'Huruf pertama dari kata "AYAM" adalah ...', 'a' => 'A', 'opsi' => ['A' => 'A', 'B' => 'B', 'C' => 'C']],
            ['q' => 'Benda yang digunakan untuk menulis adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Sendok', 'B' => 'Gelas', 'C' => 'Pensil']],
            ['q' => 'Suara kucing berbunyi ...', 'a' => 'B', 'opsi' => ['A' => 'Guk guk', 'B' => 'Meong', 'C' => 'Mbek']],
            ['q' => 'Ibu sedang ... nasi di dapur.', 'a' => 'A', 'opsi' => ['A' => 'Memasak', 'B' => 'Membaca', 'C' => 'Bermain']],
            ['q' => 'Sebelum makan kita harus ...', 'a' => 'C', 'opsi' => ['A' => 'Tidur', 'B' => 'Bermain', 'C' => 'Berdoa']],
            ['q' => 'Anggota tubuh untuk melihat adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Mata', 'B' => 'Hidung', 'C' => 'Telinga']],
            ['q' => 'Budi bermain bola di ...', 'a' => 'B', 'opsi' => ['A' => 'Kamar', 'B' => 'Lapangan', 'C' => 'Dapur']],
            ['q' => 'Huruf vokal terdiri dari a, i, u, e, dan ...', 'a' => 'C', 'opsi' => ['A' => 'b', 'B' => 'c', 'C' => 'o']],
            ['q' => 'Ayah pergi bekerja naik ... motor.', 'a' => 'A', 'opsi' => ['A' => 'Sepeda', 'B' => 'Rumah', 'C' => 'Meja']],
            ['q' => 'Lawan kata "BESAR" adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Tinggi', 'B' => 'Kecil', 'C' => 'Panjang']],
            ['q' => 'Matahari terbit pada ... hari.', 'a' => 'A', 'opsi' => ['A' => 'Pagi', 'B' => 'Siang', 'C' => 'Malam']],
            ['q' => 'Sapi makan ...', 'a' => 'C', 'opsi' => ['A' => 'Daging', 'B' => 'Nasi', 'C' => 'Rumput']],
            ['q' => 'Warna bendera Indonesia adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Merah Biru', 'B' => 'Merah Putih', 'C' => 'Putih Merah']],
            ['q' => 'Tempat untuk mandi adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Dapur', 'B' => 'Teras', 'C' => 'Kamar Mandi']],
            ['q' => 'Jika bertemu guru di jalan kita harus ...', 'a' => 'A', 'opsi' => ['A' => 'Menyapa', 'B' => 'Lari', 'C' => 'Diam']],
            ['q' => 'Huruf "B" adalah huruf ...', 'a' => 'B', 'opsi' => ['A' => 'Vokal', 'B' => 'Konsonan', 'C' => 'Angka']],
            ['q' => 'Buah yang warnanya kuning dan bentuknya melengkung adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Pisang', 'B' => 'Apel', 'C' => 'Anggur']],
            ['q' => 'Adik minum susu menggunakan ...', 'a' => 'B', 'opsi' => ['A' => 'Piring', 'B' => 'Gelas', 'C' => 'Ember']],
            ['q' => 'Buku digunakan untuk ...', 'a' => 'C', 'opsi' => ['A' => 'Dimakan', 'B' => 'Dibuang', 'C' => 'Dibaca']],
            ['q' => 'Kaki meja ada ...', 'a' => 'B', 'opsi' => ['A' => 'Dua', 'B' => 'Empat', 'C' => 'Lima']],
            ['q' => '"Sapu" huruf depannya adalah ...', 'a' => 'C', 'opsi' => ['A' => 'M', 'B' => 'B', 'C' => 'S']],
            ['q' => 'Kita mendengar menggunakan ...', 'a' => 'A', 'opsi' => ['A' => 'Telinga', 'B' => 'Mata', 'C' => 'Hidung']],
            ['q' => 'Rasa gula adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Asin', 'B' => 'Manis', 'C' => 'Pahit']],
            ['q' => 'Jika berbuat salah kita harus minta ...', 'a' => 'A', 'opsi' => ['A' => 'Maaf', 'B' => 'Uang', 'C' => 'Makan']],
            ['q' => 'Binatang yang bisa terbang adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Kucing', 'B' => 'Ikan', 'C' => 'Burung']],
            ['q' => 'Jumlah jari tangan kanan ada ...', 'a' => 'B', 'opsi' => ['A' => 'Empat', 'B' => 'Lima', 'C' => 'Enam']],
            ['q' => 'Ayah dari ayah kita panggil ...', 'a' => 'A', 'opsi' => ['A' => 'Kakek', 'B' => 'Paman', 'C' => 'Kakak']],
            ['q' => 'Sekolah tempat kita untuk ...', 'a' => 'B', 'opsi' => ['A' => 'Tidur', 'B' => 'Belajar', 'C' => 'Jajan']],
            ['q' => 'Alat untuk membersihkan gigi adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Sikat gigi', 'B' => 'Sapu', 'C' => 'Sendok']],
            ['q' => 'Lampu lalu lintas warna merah artinya ...', 'a' => 'C', 'opsi' => ['A' => 'Jalan', 'B' => 'Hati-hati', 'C' => 'Berhenti']],
            ['q' => 'Benda untuk duduk adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Meja', 'B' => 'Kursi', 'C' => 'Lemari']],
            ['q' => 'Kata "MAKAN" terdiri dari ... huruf.', 'a' => 'B', 'opsi' => ['A' => '4', 'B' => '5', 'C' => '6']],
            ['q' => 'Teman Budi sedang sakit. Budi ... teman.', 'a' => 'A', 'opsi' => ['A' => 'Menjenguk', 'B' => 'Memukul', 'C' => 'Mengejek']],
            ['q' => 'Pagi hari ayam jantan akan ...', 'a' => 'B', 'opsi' => ['A' => 'Mengaum', 'B' => 'Berkokok', 'C' => 'Mengeong']],
            ['q' => 'Bunga melati warnanya ...', 'a' => 'C', 'opsi' => ['A' => 'Merah', 'B' => 'Biru', 'C' => 'Putih']],
            ['q' => 'Buani sedang ... baju.', 'a' => 'A', 'opsi' => ['A' => 'Mencuci', 'B' => 'Memasak', 'C' => 'Menulis']],
            ['q' => 'Tempat berkumpulnya siswa di sekolah adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Pasar', 'B' => 'Kelas', 'C' => 'Rumah sakit']],
            ['q' => 'Kita berjalan menggunakan ...', 'a' => 'C', 'opsi' => ['A' => 'Tangan', 'B' => 'Kepala', 'C' => 'Kaki']],
            ['q' => 'Setelah mandi kita memakai ...', 'a' => 'A', 'opsi' => ['A' => 'Handuk', 'B' => 'Selimut', 'C' => 'Topi']],
            ['q' => 'Binatang yang hidup di air adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Ayam', 'B' => 'Ikan', 'C' => 'Kambing']],
             ['q' => 'Matahari terbenam di sebelah ...', 'a' => 'C', 'opsi' => ['A' => 'Timur', 'B' => 'Atas', 'C' => 'Barat']],
            ['q' => 'Jika diberi hadiah kita mengucapkan ...', 'a' => 'A', 'opsi' => ['A' => 'Terima kasih', 'B' => 'Maaf', 'C' => 'Tolong']],
            ['q' => 'Benda di langit yang bersinar malam hari adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Matahari', 'B' => 'Bulan', 'C' => 'Awan']],
            ['q' => 'Adik menangis karena ...', 'a' => 'A', 'opsi' => ['A' => 'Jatuh', 'B' => 'Senang', 'C' => 'Tidur']],
            ['q' => 'Alat tulis untuk menghapus adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Penggaris', 'B' => 'Bolpoin', 'C' => 'Penghapus']],
            ['q' => 'Rambut diletakkan di ...', 'a' => 'A', 'opsi' => ['A' => 'Kepala', 'B' => 'Kaki', 'C' => 'Perut']],
            ['q' => 'Anak yang rajin belajar akan menjadi ...', 'a' => 'B', 'opsi' => ['A' => 'Bodoh', 'B' => 'Pintar', 'C' => 'Nakal']],
            ['q' => 'Rumah tempat kita ...', 'a' => 'C', 'opsi' => ['A' => 'Sekolah', 'B' => 'Belanja', 'C' => 'Tinggal']],
            ['q' => 'Ekor gajah itu ...', 'a' => 'B', 'opsi' => ['A' => 'Panjang', 'B' => 'Pendek', 'C' => 'Besar']],
            ['q' => 'Kita mencium bau dengan ...', 'a' => 'A', 'opsi' => ['A' => 'Hidung', 'B' => 'Mulut', 'C' => 'Telinga']],
        ];

        foreach ($pgQuestions as $q) {
            Soal::create(array_merge($commonData, [
                'tipe' => 'pilihan_ganda',
                'pertanyaan' => $q['q'],
                'opsi' => $q['opsi'],
                'kunci_jawaban' => $q['a'], // Kunci jawaban PG: A, B, C...
                'poin' => 2, // Total 50 soal x 2 = 100 poin (jika semua PG)
            ]));
        }

        // --- 20 SOAL ESSAY ---
        // Topik: Melengkapi kalimat, Menebak benda, Pengetahuan umum anak
        
        $essayQuestions = [
            ['q' => 'Siapakah nama presiden Indonesia yang pertama?', 'a' => 'Soekarno'],
            ['q' => 'Sebutkan 2 hewan berkaki empat!', 'a' => 'Sapi, Kambing, Kuda, Kucing, Anjing (jawaban fleksibel binatang kaki 4)'],
            ['q' => 'Lengkapi kalimat ini: Ibu pergi ke ... untuk membeli sayur.', 'a' => 'Pasar'],
            ['q' => 'Apa warna daun pada umumnya?', 'a' => 'Hijau'],
            ['q' => 'Tuliskan nama lengkapmu!', 'a' => 'Jawaban menyesuaikan nama siswa'],
            ['q' => 'Berapa jumlah roda sepeda motor?', 'a' => 'Dua / 2'],
            ['q' => 'Apa nama ibukota negara Indonesia?', 'a' => 'Jakarta'],
            ['q' => 'Sebutkan guna tangan!', 'a' => 'Memegang, Menulis, Makan'],
            ['q' => 'Lengkapi: Satu, dua, tiga, empat, ...', 'a' => 'Lima'],
            ['q' => 'Apa rasa garam?', 'a' => 'Asin'],
            ['q' => 'Sebutkan benda di dalam tas sekolahmu!', 'a' => 'Buku, Pensil, Penghapus, Penggaris'],
            ['q' => 'Kapan kita melakukan upacara bendera?', 'a' => 'Hari Senin'],
            ['q' => 'Di mana ikan hidup?', 'a' => 'Di air / Laut / Sungai'],
            ['q' => 'Lengkapi kata ini: S_KOL_H', 'a' => 'SEKOLAH'],
            ['q' => 'Apa bahasa Inggris dari "Satu"?', 'a' => 'One'],
            ['q' => 'Siapa yang melahirkan kita?', 'a' => 'Ibu'],
            ['q' => 'Gigi digunakan untuk apa?', 'a' => 'Mengunyah makanan'],
            ['q' => 'Sebutkan nama hari setelah Minggu!', 'a' => 'Senin'],
            ['q' => 'Apa yang kamu lakukan sebelum tidur?', 'a' => 'Gosok gigi / Berdoa'],
            ['q' => 'Jika hujan turun kita memakai apa agar tidak basah?', 'a' => 'Payung / Jas Hujan'],
        ];

        foreach ($essayQuestions as $q) {
            Soal::create(array_merge($commonData, [
                'tipe' => 'essay',
                'pertanyaan' => $q['q'],
                'kunci_jawaban' => $q['a'], // Kunci jawaban Essay (referensi guru)
                'poin' => 5, // Standar poin essay
            ]));
        }
    }
}
