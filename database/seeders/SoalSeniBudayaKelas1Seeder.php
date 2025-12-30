<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalSeniBudayaKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran SBK
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Seni Budaya dan Keterampilan'],
            ['kode' => 'SBK', 'jenis' => 'guru_kelas'] 
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
        // Topik: Seni Rupa (Warna, Garis), Seni Musik (Bunyi), Seni Tari (Gerak)
        
        $pgQuestions = [
            ['q' => 'Warna pelangi ada ...', 'a' => 'C', 'opsi' => ['A' => '5', 'B' => '6', 'C' => '7']],
            ['q' => 'Bunyi tepuk tangan adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Prok prok prok', 'B' => 'Tik tik tik', 'C' => 'Dor dor dor']],
            ['q' => 'Alat untuk menggambar adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Sendok', 'B' => 'Pensil warna', 'C' => 'Gunting']],
            ['q' => 'Daun berwarna ...', 'a' => 'C', 'opsi' => ['A' => 'Merah', 'B' => 'Biru', 'C' => 'Hijau']],
            ['q' => 'Menari menggerakkan ...', 'a' => 'A', 'opsi' => ['A' => 'Tubuh', 'B' => 'Langit', 'C' => 'Meja']],
            ['q' => 'Suara bebek adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Mbek mbek', 'B' => 'Kwek kwek', 'C' => 'Meong meong']],
            ['q' => 'Benda yang berbunyi "Kring kring" adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Sepeda', 'B' => 'Kereta', 'C' => 'Pesawat']],
            ['q' => 'Lagu "Balonku" ada ...', 'a' => 'C', 'opsi' => ['A' => '3', 'B' => '4', 'C' => '5']],
            ['q' => 'Warna buah pisang matang adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Hijau', 'B' => 'Kuning', 'C' => 'Merah']],
            ['q' => 'Bahan alam untuk membuat kerajinan adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Tanah liat', 'B' => 'Plastik', 'C' => 'Kaca']],
            ['q' => 'Bunyi alam contohnya ...', 'a' => 'C', 'opsi' => ['A' => 'Klakson', 'B' => 'Gitar', 'C' => 'Angin']],
            ['q' => 'Lagu "Bintang Kecil" bercerita tentang ...', 'a' => 'B', 'opsi' => ['A' => 'Bumi', 'B' => 'Langit', 'C' => 'Laut']],
            ['q' => 'Jika menyanyi harus sesuai ...', 'a' => 'A', 'opsi' => ['A' => 'Irama', 'B' => 'Teriakan', 'C' => 'Tangisan']],
            ['q' => 'Gerakan tumbuhan tertiup angin adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Diam', 'B' => 'Bergoyang', 'C' => 'Lari']],
            ['q' => 'Garis lurus bentuknya seperti ...', 'a' => 'C', 'opsi' => ['A' => 'Ular', 'B' => 'Bola', 'C' => 'Lidi']],
            ['q' => 'Menggambar sebaiknya di ...', 'a' => 'A', 'opsi' => ['A' => 'Buku gambar', 'B' => 'Tembok', 'C' => 'Baju']],
            ['q' => 'Warna susu adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Hitam', 'B' => 'Putih', 'C' => 'Merah']],
            ['q' => 'Bunyi buatan contohnya ...', 'a' => 'C', 'opsi' => ['A' => 'Ombak', 'B' => 'Petir', 'C' => 'Bel sekolah']],
            ['q' => 'Kita mendengar musik dengan ...', 'a' => 'A', 'opsi' => ['A' => 'Telinga', 'B' => 'Mata', 'C' => 'Hidung']],
            ['q' => 'Seni rupa 2 dimensi memiliki panjang dan ...', 'a' => 'B', 'opsi' => ['A' => 'Tinggi', 'B' => 'Lebar', 'C' => 'Berat']],
            ['q' => 'Lukisan dipajang di ...', 'a' => 'C', 'opsi' => ['A' => 'Lantai', 'B' => 'Atap', 'C' => 'Dinding']],
            ['q' => 'Warna awan cerah adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Hitam', 'B' => 'Putih/Biru', 'C' => 'Merah']],
            ['q' => 'Burung berkicau termasuk bunyi ...', 'a' => 'A', 'opsi' => ['A' => 'Alam', 'B' => 'Buatan', 'C' => 'Mesin']],
            ['q' => 'Menari harus dengan hati ...', 'a' => 'C', 'opsi' => ['A' => 'Sedih', 'B' => 'Marah', 'C' => 'Gembira']],
            ['q' => 'Tepuk tangan menghasilkan ...', 'a' => 'B', 'opsi' => ['A' => 'Cahaya', 'B' => 'Bunyi', 'C' => 'Bau']],
            ['q' => 'Alat musik seruling dimainkan dengan cara ...', 'a' => 'A', 'opsi' => ['A' => 'Ditiup', 'B' => 'Dipukul', 'C' => 'Dipetik']],
            ['q' => 'Gendang dimainkan dengan cara ...', 'a' => 'B', 'opsi' => ['A' => 'Ditiup', 'B' => 'Dipukul', 'C' => 'Digesek']],
            ['q' => 'Warna merah dicampur kuning menjadi ...', 'a' => 'C', 'opsi' => ['A' => 'Hijau', 'B' => 'Ungu', 'C' => 'Jingga/Oranye']],
            ['q' => 'Warna biru dicampur kuning menjadi ...', 'a' => 'A', 'opsi' => ['A' => 'Hijau', 'B' => 'Merah', 'C' => 'Coklat']],
            ['q' => 'Gerakan kelinci adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Terbang', 'B' => 'Melompat', 'C' => 'Merayap']],
            ['q' => 'Bahan lunak untuk membuat patung adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Plastisin', 'B' => 'Batu', 'C' => 'Kayu']],
            ['q' => 'Topi digunakan di ...', 'a' => 'C', 'opsi' => ['A' => 'Kaki', 'B' => 'Tangan', 'C' => 'Kepala']],
            ['q' => 'Baju seragam harus ...', 'a' => 'B', 'opsi' => ['A' => 'Kotor', 'B' => 'Rapi', 'C' => 'Robek']],
            ['q' => 'Suara "Mbek mbek" adalah suara hewan ...', 'a' => 'A', 'opsi' => ['A' => 'Kambing', 'B' => 'Sapi', 'C' => 'Ayam']],
            ['q' => 'Piano adalah alat musik ...', 'a' => 'C', 'opsi' => ['A' => 'Tiup', 'B' => 'Pukul', 'C' => 'Tekan']],
            ['q' => 'Menari dilakukan dengan menggerakkan ...', 'a' => 'B', 'opsi' => ['A' => 'Patahan', 'B' => 'Anggota tubuh', 'C' => 'Alat tulis']],
            ['q' => 'Contoh benda seni rupa 3 dimensi adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Patung', 'B' => 'Foto', 'C' => 'Lukisan']],
            ['q' => 'Boneka biasanya terbuat dari ...', 'a' => 'C', 'opsi' => ['A' => 'Besi', 'B' => 'Kertas', 'C' => 'Kain']],
            ['q' => 'Origami adalah seni melipat ...', 'a' => 'B', 'opsi' => ['A' => 'Kain', 'B' => 'Kertas', 'C' => 'Plastik']],
            ['q' => 'Daun kering berwarna ...', 'a' => 'A', 'opsi' => ['A' => 'Coklat', 'B' => 'Hijau', 'C' => 'Biru']],
            ['q' => 'Kolase dibuat dengan cara ...', 'a' => 'B', 'opsi' => ['A' => 'Melukis', 'B' => 'Menempel', 'C' => 'Memahat']],
            ['q' => 'Lem berguna untuk ...', 'a' => 'A', 'opsi' => ['A' => 'Merekatkan', 'B' => 'Memotong', 'C' => 'Mewarnai']],
            ['q' => 'Gunting digunakan untuk ...', 'a' => 'C', 'opsi' => ['A' => 'Menulis', 'B' => 'Menempel', 'C' => 'Memotong']],
            ['q' => 'Gambar matahari bentuknya ...', 'a' => 'B', 'opsi' => ['A' => 'Kotak', 'B' => 'Bulat', 'C' => 'Segitiga']],
            ['q' => 'Lagu "Indonesia Raya" dinyanyikan saat ...', 'a' => 'B', 'opsi' => ['A' => 'Tidur', 'B' => 'Upacara', 'C' => 'Makan']],
            ['q' => 'Gerakan kupu-kupu terbang menggunakan ...', 'a' => 'A', 'opsi' => ['A' => 'Sayap', 'B' => 'Kaki', 'C' => 'Ekor']],
            ['q' => 'Suara orang menyanyi disebut ...', 'a' => 'C', 'opsi' => ['A' => 'Musik', 'B' => 'Nada', 'C' => 'Vokal']],
            ['q' => 'Lagu "Kasih Ibu" diciptakan untuk ...', 'a' => 'B', 'opsi' => ['A' => 'Ayah', 'B' => 'Ibu', 'C' => 'Kakak']],
            ['q' => 'Senam irama diiringi dengan ...', 'a' => 'A', 'opsi' => ['A' => 'Musik', 'B' => 'Tangisan', 'C' => 'Marah']],
            ['q' => 'Gambar imajinasi dibuat berdasarkan ...', 'a' => 'C', 'opsi' => ['A' => 'Contoh', 'B' => 'Jiplakan', 'C' => 'Khayalan']],
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
        // Topik: Dasar kesenian
        
        $essayQuestions = [
            ['q' => 'Sebutkan 3 warna pelangi!', 'a' => 'Merah, Kuning, Hijau (Mejikuhibiniu)'],
            ['q' => 'Apa alat untuk memotong kertas?', 'a' => 'Gunting'],
            ['q' => 'Tirukan bunyi kucing!', 'a' => 'Meong'],
            ['q' => 'Lengkapilan lirik ini: Balonku ada ...', 'a' => 'Lima'],
            ['q' => 'Sebutkan bahan alam untuk kerajinan!', 'a' => 'Daun, Biji-bijian, Tanah Liat, Batu'],
            ['q' => 'Apa gunanya pensil warna?', 'a' => 'Mewarnai gambar'],
            ['q' => 'Patung adalah karya seni ... dimensi.', 'a' => '3 / Tiga'],
            ['q' => 'Lukisan adalah karya seni ... dimensi.', 'a' => '2 / Dua'],
            ['q' => 'Bagaimana bunyi tepuk tangan?', 'a' => 'Prok prok prok'],
            ['q' => 'Apa warna buah apel?', 'a' => 'Merah / Hijau'],
            ['q' => 'Menari menggerakkan ...', 'a' => 'Badan / Tubuh'],
            ['q' => 'Sebutkan satu judul lagu anak-anak!', 'a' => 'Balonku / Bintang Kecil / Pelangi / dll'],
            ['q' => 'Angklung berasal dari daerah ...', 'a' => 'Jawa Barat / Sunda'],
            ['q' => 'Bahan untuk membuat perahu mainan kertas adalah ...', 'a' => 'Kertas'],
            ['q' => 'Apa yang digunakan untuk menempel kertas?', 'a' => 'Lem'],
            ['q' => 'Sebutkan warna bendera kita!', 'a' => 'Merah dan Putih'],
            ['q' => 'Gitar dimainkan dengan cara ...', 'a' => 'Dipetik'],
            ['q' => 'Apa warna langit saat malam?', 'a' => 'Hitam / Gelap'],
            ['q' => 'Sebutkan benda berbentuk bulat!', 'a' => 'Bola / Kelereng / Buah Jeruk'],
            ['q' => 'Bunyi petir termasuk bunyi ... (alam/buatan)', 'a' => 'Alam'],
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
