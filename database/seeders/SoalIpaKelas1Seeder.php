<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalIpaKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran IPA
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Ilmu Pengetahuan Alam'],
            ['kode' => 'IPA', 'jenis' => 'guru_kelas'] 
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
        // Topik: Anggota Tubuh, Hewan, Tumbuhan, Benda Langit, Lingkungan Sehat
        
        $pgQuestions = [
            ['q' => 'Mata digunakan untuk ...', 'a' => 'A', 'opsi' => ['A' => 'Melihat', 'B' => 'Mendengar', 'C' => 'Berjalan']],
            ['q' => 'Hidung berguna untuk mencium ...', 'a' => 'B', 'opsi' => ['A' => 'Suara', 'B' => 'Bau', 'C' => 'Rasa']],
            ['q' => 'Kita berjalan menggunakan ...', 'a' => 'C', 'opsi' => ['A' => 'Tangan', 'B' => 'Kepala', 'C' => 'Kaki']],
            ['q' => 'Gigi digunakan untuk ... makanan.', 'a' => 'A', 'opsi' => ['A' => 'Mengunyah', 'B' => 'Menelan', 'C' => 'Membaui']],
            ['q' => 'Telinga ada di ... kepala.', 'a' => 'B', 'opsi' => ['A' => 'Atas', 'B' => 'Samping', 'C' => 'Belakang']],
            ['q' => 'Hewan yang berkokok di pagi hari adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Ayam jantan', 'B' => 'Kucing', 'C' => 'Sapi']],
            ['q' => 'Ikan berenang menggunakan ...', 'a' => 'C', 'opsi' => ['A' => 'Kaki', 'B' => 'Sayap', 'C' => 'Sirip']],
            ['q' => 'Kucing suka makan ...', 'a' => 'B', 'opsi' => ['A' => 'Rumput', 'B' => 'Ikan', 'C' => 'Biji-bijian']],
            ['q' => 'Burung terbang menggunakan ...', 'a' => 'B', 'opsi' => ['A' => 'Ekor', 'B' => 'Sayap', 'C' => 'Paruh']],
            ['q' => 'Sapi menghasilkan ...', 'a' => 'A', 'opsi' => ['A' => 'Susu', 'B' => 'Telur', 'C' => 'Madu']],
            ['q' => 'Bagian tumbuhan yang ada di dalam tanah adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Daun', 'B' => 'Batang', 'C' => 'Akar']],
            ['q' => 'Warna daun kebanyakan adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Merah', 'B' => 'Hijau', 'C' => 'Biru']],
            ['q' => 'Lidah berguna untuk mengecap ...', 'a' => 'A', 'opsi' => ['A' => 'Rasa', 'B' => 'Bau', 'C' => 'Bunyi']],
            ['q' => 'Matahari terbit dari arah ...', 'a' => 'B', 'opsi' => ['A' => 'Barat', 'B' => 'Timur', 'C' => 'Utara']],
            ['q' => 'Di malam hari langit terlihat ...', 'a' => 'C', 'opsi' => ['A' => 'Terang', 'B' => 'Putih', 'C' => 'Gelap']],
            ['q' => 'Benda langit yang terlihat di malam hari adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Bulan dan Bintang', 'B' => 'Matahari', 'C' => 'Awan']],
            ['q' => 'Mandi sebaiknya dilakuan ... kali sehari.', 'a' => 'B', 'opsi' => ['A' => '1', 'B' => '2', 'C' => '5']],
            ['q' => 'Supaya gigi bersih kita harus ...', 'a' => 'A', 'opsi' => ['A' => 'Menggosok gigi', 'B' => 'Makan permen', 'C' => 'Tidur']],
            ['q' => 'Kuku yang panjang harus di...', 'a' => 'B', 'opsi' => ['A' => 'Warnai', 'B' => 'Potong', 'C' => 'Biarkan']],
            ['q' => 'Sebelum makan kita harus mencuci ...', 'a' => 'C', 'opsi' => ['A' => 'Kaki', 'B' => 'Rambut', 'C' => 'Tangan']],
            ['q' => 'Sampah harus dibuang di ...', 'a' => 'A', 'opsi' => ['A' => 'Tempat sampah', 'B' => 'Sungai', 'C' => 'Jalan']],
            ['q' => 'Rumah yang bersih menjauhkan kita dari ...', 'a' => 'B', 'opsi' => ['A' => 'Kenyamanan', 'B' => 'Penyakit', 'C' => 'Teman']],
            ['q' => 'Air yang kotor dapat menyebabkan ...', 'a' => 'C', 'opsi' => ['A' => 'Sehat', 'B' => 'Kuat', 'C' => 'Gatal-gatal']],
            ['q' => 'Nyamuk menyebabkan penyakit ...', 'a' => 'A', 'opsi' => ['A' => 'Demam berdarah', 'B' => 'Sakit gigi', 'C' => 'Batuk']],
            ['q' => 'Pakaian kotor harus segera di...', 'a' => 'B', 'opsi' => ['A' => 'Pakai', 'B' => 'Cuci', 'C' => 'Jual']],
            ['q' => 'Jika kulit terkena api akan terasa ...', 'a' => 'C', 'opsi' => ['A' => 'Dingin', 'B' => 'Gatal', 'C' => 'Panas']],
            ['q' => 'Es batu rasanya ...', 'a' => 'A', 'opsi' => ['A' => 'Dingin', 'B' => 'Panas', 'C' => 'Pedas']],
            ['q' => 'Suara petir terdengar sangat ...', 'a' => 'B', 'opsi' => ['A' => 'Pelan', 'B' => 'Keras', 'C' => 'Merdu']],
            ['q' => 'Gajah memiliki tubuh yang ...', 'a' => 'C', 'opsi' => ['A' => 'Kecil', 'B' => 'Tipis', 'C' => 'Besar']],
            ['q' => 'Semut memiliki tubuh yang ...', 'a' => 'A', 'opsi' => ['A' => 'Kecil', 'B' => 'Besar', 'C' => 'Panjang']],
            ['q' => 'Buah jeruk rasanya ...', 'a' => 'B', 'opsi' => ['A' => 'Pahit', 'B' => 'Manis atau asam', 'C' => 'Asin']],
            ['q' => 'Cabai rasanya ...', 'a' => 'C', 'opsi' => ['A' => 'Manis', 'B' => 'Asam', 'C' => 'Pedas']],
            ['q' => 'Kambing makan ...', 'a' => 'A', 'opsi' => ['A' => 'Rumput', 'B' => 'Daging', 'C' => 'Nasi']],
            ['q' => 'Harimau makan ...', 'a' => 'B', 'opsi' => ['A' => 'Buah', 'B' => 'Daging', 'C' => 'Sayur']],
            ['q' => 'Kelinci bergerak dengan cara ...', 'a' => 'C', 'opsi' => ['A' => 'Terbang', 'B' => 'Berenang', 'C' => 'Melompat']],
            ['q' => 'Ular bergerak dengan cara ...', 'a' => 'A', 'opsi' => ['A' => 'Melata', 'B' => 'Berjalan', 'C' => 'Terbang']],
            ['q' => 'Hewan yang lehernya panjang adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Gajah', 'B' => 'Jerapah', 'C' => 'Kuda']],
            ['q' => 'Bunga mawar batangnya ber...', 'a' => 'C', 'opsi' => ['A' => 'Buah', 'B' => 'Bulu', 'C' => 'Duri']],
            ['q' => 'Pohon kelapa tumbuh tinggi menjulang ke ...', 'a' => 'A', 'opsi' => ['A' => 'Atas', 'B' => 'Bawah', 'C' => 'Samping']],
            ['q' => 'Benda padat contohnya adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Air', 'B' => 'Batu', 'C' => 'Angin']],
            ['q' => 'Benda cair contohnya adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Air', 'B' => 'Kayu', 'C' => 'Asap']],
            ['q' => 'Agar tanaman subur harus di...', 'a' => 'C', 'opsi' => ['A' => 'Tebang', 'B' => 'Injak', 'C' => 'Siram']],
            ['q' => 'Matahari memberikan energi ...', 'a' => 'B', 'opsi' => ['A' => 'Bunyi', 'B' => 'Panas dan Cahaya', 'C' => 'Gerak']],
            ['q' => 'Lantai yang kotor harus di...', 'a' => 'A', 'opsi' => ['A' => 'Sapu', 'B' => 'Kotori', 'C' => 'Lihat']],
            ['q' => 'Tidur yang cukup membuat badan menjadi ...', 'a' => 'C', 'opsi' => ['A' => 'Lemas', 'B' => 'Sakit', 'C' => 'Sehat']],
            ['q' => 'Saat bersin sebaiknya menutup ...', 'a' => 'B', 'opsi' => ['A' => 'Mata', 'B' => 'Mulut dan hidung', 'C' => 'Telinga']],
            ['q' => 'Rambut berguna untuk melindungi ...', 'a' => 'A', 'opsi' => ['A' => 'Kepala', 'B' => 'Kaki', 'C' => 'Tangan']],
            ['q' => 'Alis mata ada di atas ...', 'a' => 'B', 'opsi' => ['A' => 'Hidung', 'B' => 'Mata', 'C' => 'Mulut']],
            ['q' => 'Jumlah kaki ayam ada ...', 'a' => 'A', 'opsi' => ['A' => '2', 'B' => '4', 'C' => '6']],
            ['q' => 'Jumlah kaki sapi ada ...', 'a' => 'B', 'opsi' => ['A' => '2', 'B' => '4', 'C' => '8']],
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
        // Topik: Pengetahuan umum IPA dasar
        
        $essayQuestions = [
            ['q' => 'Sebutkan 2 pancaindra yang kamu ketahui!', 'a' => 'Mata, Hidung, Telinga, Lidah, Kulit (pilih 2)'],
            ['q' => 'Apa kegunaan kaki?', 'a' => 'Untuk berjalan / berdiri'],
            ['q' => 'Hewan apa yang menghasilkan madu?', 'a' => 'Lebah'],
            ['q' => 'Apa makanan kelinci?', 'a' => 'Wortel / Sayuran'],
            ['q' => 'Sebutkan benda cair!', 'a' => 'Air, Susu, Minyak, Teh'],
            ['q' => 'Kapan matahari terbit?', 'a' => 'Pagi hari'],
            ['q' => 'Apa warna langit saat cerah?', 'a' => 'Biru'],
            ['q' => 'Jika kita tidak mandi, badan akan terasa ...', 'a' => 'Gatal / Bau'],
            ['q' => 'Sebutkan hewan yang hidup di air!', 'a' => 'Ikan, Udang, Paus'],
            ['q' => 'Apa kegunaan air bagi manusia?', 'a' => 'Minum, Mandi, Mencuci'],
            ['q' => 'Bagian tumbuhan yang indah dan berwarna-warni disebut ...', 'a' => 'Bunga'],
            ['q' => 'Sebutkan hewan berkaki dua!', 'a' => 'Ayam, Bebek, Burung'],
            ['q' => 'Apa rasa air laut?', 'a' => 'Asin'],
            ['q' => 'Agar udara segar, kita harus menanam ...', 'a' => 'Pohon / Tumbuhan'],
            ['q' => 'Apa yang kamu pakai untuk melindungi kaki?', 'a' => 'Sepatu / Sendal'],
            ['q' => 'Sebutkan guna hidung!', 'a' => 'Bernapas / Mencium bau'],
            ['q' => 'Hewan apa yang lehernya sangat panjang?', 'a' => 'Jerapah'],
            ['q' => 'Apa makanan sapi?', 'a' => 'Rumput'],
            ['q' => 'Jika haus kita harus ...', 'a' => 'Minum'],
            ['q' => 'Sampah plastik harus dibuang di ...', 'a' => 'Tempat sampah'],
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
