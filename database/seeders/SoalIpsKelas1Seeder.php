<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\Guru;

class SoalIpsKelas1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil atau Buat Pelajaran IPS
        $pelajaran = Pelajaran::firstOrCreate(
            ['nama' => 'Ilmu Pengetahuan Sosial'],
            ['kode' => 'IPS', 'jenis' => 'guru_kelas'] 
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
        // Topik: Identitas Diri, Keluarga, Lingkungan Rumah, Peristiwa Penting
        
        $pgQuestions = [
            ['q' => 'Nama panggilan adalah nama yang ...', 'a' => 'B', 'opsi' => ['A' => 'Panjang', 'B' => 'Pendek', 'C' => 'Sulit']],
            ['q' => 'Ayah dan Ibu disebut ...', 'a' => 'C', 'opsi' => ['A' => 'Saudara', 'B' => 'Kakek Nenek', 'C' => 'Orang Tua']],
            ['q' => 'Adik laki-laki dari ayah dipanggil ...', 'a' => 'A', 'opsi' => ['A' => 'Paman', 'B' => 'Bibi', 'C' => 'Kakek']],
            ['q' => 'Ibu dari ibu kita dipanggil ...', 'a' => 'B', 'opsi' => ['A' => 'Ibu', 'B' => 'Nenek', 'C' => 'Kakak']],
            ['q' => 'Rumah adalah tempat untuk ...', 'a' => 'A', 'opsi' => ['A' => 'Berlindung', 'B' => 'Jajan', 'C' => 'Sekolah']],
            ['q' => 'Alamat rumah harus diingat agar tidak ...', 'a' => 'C', 'opsi' => ['A' => 'Lapar', 'B' => 'Sakit', 'C' => 'Tersesat']],
            ['q' => 'Keluarga inti terdiri dari Ayah, Ibu, dan ...', 'a' => 'B', 'opsi' => ['A' => 'Paman', 'B' => 'Anak', 'C' => 'Tetangga']],
            ['q' => 'Tugas seorang anak di rumah adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Menghormati orang tua', 'B' => 'Bekerja mencari uang', 'C' => 'Memarah adik']],
            ['q' => 'Jika adik menangis, kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Memukul', 'B' => 'Menghibur', 'C' => 'Tertawa']],
            ['q' => 'Sikap yang baik kepada orang tua adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Sopan', 'B' => 'Kasar', 'C' => 'Membangkang']],
            ['q' => 'Tetangga adalah orang yang tinggal di ... rumah kita.', 'a' => 'C', 'opsi' => ['A' => 'Dalam', 'B' => 'Atas', 'C' => 'Dekat']],
            ['q' => 'Jika bertemu tetangga di jalan kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Lari', 'B' => 'Menyapa', 'C' => 'Diam']],
            ['q' => 'Gotong royong artinya bekerja ...', 'a' => 'A', 'opsi' => ['A' => 'Bersama-sama', 'B' => 'Sendiri', 'C' => 'Malas-malasan']],
            ['q' => 'Tempat untuk memasak di rumah adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Kamar Tidur', 'B' => 'Ruang Tamu', 'C' => 'Dapur']],
            ['q' => 'Tamu yang datang dipersilakan masuk ke ...', 'a' => 'B', 'opsi' => ['A' => 'Kamar Mandi', 'B' => 'Ruang Tamu', 'C' => 'Dapur']],
            ['q' => 'Jendela rumah berguna untuk keluar masuk ...', 'a' => 'A', 'opsi' => ['A' => 'Udara dan cahaya', 'B' => 'Orang', 'C' => 'Mobil']],
            ['q' => 'Sampah di halaman harus di...', 'a' => 'C', 'opsi' => ['A' => 'Biarkan', 'B' => 'Timbun', 'C' => 'Sapu']],
            ['q' => 'Kerja bakti membuat pekerjaan menjadi lebih ...', 'a' => 'B', 'opsi' => ['A' => 'Berat', 'B' => 'Ringan', 'C' => 'Lama']],
            ['q' => 'Kepala keluarga di rumah adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Ayah', 'B' => 'Ibu', 'C' => 'Anak']],
            ['q' => 'Kasih sayang ibu sepanjang ...', 'a' => 'C', 'opsi' => ['A' => 'Jalan', 'B' => 'Galah', 'C' => 'Masa']],
            ['q' => 'Peristiwa yang menyenangkan contohnya ...', 'a' => 'A', 'opsi' => ['A' => 'Ulang tahun', 'B' => 'Sakit', 'C' => 'Jatuh dari sepeda']],
            ['q' => 'Peristiwa yang menyedihkan contohnya ...', 'a' => 'B', 'opsi' => ['A' => 'Dapat hadiah', 'B' => 'Kehilangan mainan', 'C' => 'Juara kelas']],
            ['q' => 'Jika teman sedang sedih, kita harus ...', 'a' => 'A', 'opsi' => ['A' => 'Menghibur', 'B' => 'Mengejek', 'C' => 'Memarah']],
            ['q' => 'Manusia tidak bisa hidup ...', 'a' => 'C', 'opsi' => ['A' => 'Bersama', 'B' => 'Berkelompok', 'C' => 'Sendiri']],
            ['q' => 'Rumah yang sehat harus memiliki ...', 'a' => 'B', 'opsi' => ['A' => 'TV besar', 'B' => 'Ventilasi udara', 'C' => 'Mainan banyak']],
            ['q' => 'Setiap orang memiliki identitas diri. Identitas diri contohnya ...', 'a' => 'A', 'opsi' => ['A' => 'Nama', 'B' => 'Baju', 'C' => 'Sepatu']],
            ['q' => 'Anak pertama disebut anak ...', 'a' => 'C', 'opsi' => ['A' => 'Bungsu', 'B' => 'Tengah', 'C' => 'Sulung']],
            ['q' => 'Anak terakhir disebut anak ...', 'a' => 'A', 'opsi' => ['A' => 'Bungsu', 'B' => 'Sulung', 'C' => 'Kembar']],
            ['q' => 'Jika ingin keluar rumah kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Lari', 'B' => 'Pamit', 'C' => 'Diam-diam']],
            ['q' => 'Rumah yang kotor menjadi sarang ...', 'a' => 'A', 'opsi' => ['A' => 'Penyakit', 'B' => 'Kesehatan', 'C' => 'Kenyamanan']],
            ['q' => 'Kita harus ... kepada Tuhan Yang Maha Esa.', 'a' => 'C', 'opsi' => ['A' => 'Lupa', 'B' => 'Marah', 'C' => 'Bersyukur']],
            ['q' => 'Suku bangsa di Indonesia ada ...', 'a' => 'B', 'opsi' => ['A' => 'Satu', 'B' => 'Banyak', 'C' => 'Sedikit']],
            ['q' => 'Bhinneka Tunggal Ika artinya berbeda-beda tetapi tetap ...', 'a' => 'A', 'opsi' => ['A' => 'Satu', 'B' => 'Dua', 'C' => 'Tiga']],
            ['q' => 'Warna merah pada bendera artinya ...', 'a' => 'B', 'opsi' => ['A' => 'Suci', 'B' => 'Berani', 'C' => 'Takut']],
            ['q' => 'Warna putih pada bendera artinya ...', 'a' => 'A', 'opsi' => ['A' => 'Suci', 'B' => 'Berani', 'C' => 'Kuat']],
            ['q' => 'Lagu kebangsaan kita adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Balonku', 'B' => 'Pelangi', 'C' => 'Indonesia Raya']],
            ['q' => 'Presiden Indonesia saat ini adalah ...', 'a' => 'C', 'opsi' => ['A' => 'Soekarno', 'B' => 'Soeharto', 'C' => 'Jokowi / Prabowo (sesuaikan)']],
            ['q' => 'Tempat untuk menyimpan foto kenangan adalah ...', 'a' => 'B', 'opsi' => ['A' => 'Buku tulis', 'B' => 'Album foto', 'C' => 'Koran']],
            ['q' => 'Hari kemerdekaan Indonesia tanggal ...', 'a' => 'A', 'opsi' => ['A' => '17 Agustus', 'B' => '21 April', 'C' => '10 November']],
            ['q' => 'Ibu Kartini adalah pahlawan ...', 'a' => 'B', 'opsi' => ['A' => 'Laki-laki', 'B' => 'Wanita', 'C' => 'Anak-anak']],
            ['q' => 'Garuda Pancasila adalah ... negara Indonesia.', 'a' => 'C', 'opsi' => ['A' => 'Lagu', 'B' => 'Bendera', 'C' => 'Lambang']],
            ['q' => 'Sila pertama Pancasila dilambangkan dengan ...', 'a' => 'A', 'opsi' => ['A' => 'Bintang', 'B' => 'Rantai', 'C' => 'Pohon Beringin']],
            ['q' => 'Sila kedua Pancasila berbunyi kemanusiaan yang adil dan ...', 'a' => 'B', 'opsi' => ['A' => 'Makmur', 'B' => 'Beradab', 'C' => 'Sentosa']],
            ['q' => 'Musyawarah dilakukan untuk mencapai ...', 'a' => 'C', 'opsi' => ['A' => 'Masalah', 'B' => 'Keributan', 'C' => 'Mufakat']],
            ['q' => 'Di sekolah kita dipimpin oleh ...', 'a' => 'A', 'opsi' => ['A' => 'Kepala Sekolah', 'B' => 'Satpam', 'C' => 'Ketua Kelas']],
            ['q' => 'Seragam SD berwarna putih dan ...', 'a' => 'B', 'opsi' => ['A' => 'Biru', 'B' => 'Merah', 'C' => 'Abu-abu']],
            ['q' => 'Upacara bendera dilakukan dengan ...', 'a' => 'C', 'opsi' => ['A' => 'Ramai', 'B' => 'Bercanda', 'C' => 'Khidmat']],
            ['q' => 'Tempat meminjam buku di sekolah adalah ...', 'a' => 'A', 'opsi' => ['A' => 'Perpustakaan', 'B' => 'Kantin', 'C' => 'UKS']],
            ['q' => 'Jika guru sedang menjelaskan kita harus ...', 'a' => 'B', 'opsi' => ['A' => 'Tidur', 'B' => 'Mendengarkan', 'C' => 'Ngobrol']],
            ['q' => 'PR singkatan dari ...', 'a' => 'A', 'opsi' => ['A' => 'Pekerjaan Rumah', 'B' => 'Pekerjaan Ribet', 'C' => 'Pekerjaan Rusak']],
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
        // Topik: Pengetahuan sosial dasar
        
        $essayQuestions = [
            ['q' => 'Siapa nama lengkapmu?', 'a' => 'Jawaban nama siswa'],
            ['q' => 'Di mana kamu tinggal? (Sebutkan desa/kota)', 'a' => 'Jawaban alamat siswa'],
            ['q' => 'Siapa kepala keluarga di rumahmu?', 'a' => 'Ayah'],
            ['q' => 'Sebutkan 2 tugas ibu di rumah!', 'a' => 'Memasak, Mengurus rumah, Merawat anak'],
            ['q' => 'Apa yang kamu lakukan sebelum berangkat sekolah?', 'a' => 'Mandi, Sarapan, Pamit orang tua'],
            ['q' => 'Sebutkan nama teman sebangkumu!', 'a' => 'Jawaban nama teman'],
            ['q' => 'Apa lambang negara Indonesia?', 'a' => 'Garuda Pancasila'],
            ['q' => 'Sebutkan warna bendera kita!', 'a' => 'Merah Putih'],
            ['q' => 'Kapan kita merayakan hari kemerdekaan?', 'a' => '17 Agustus'],
            ['q' => 'Apa nama agamamu?', 'a' => 'Islam (atau sesuai siswa)'],
            ['q' => 'Sebutkan satu contoh hidup rukun!', 'a' => 'Bermain bersama, Tidak bertengkar'],
            ['q' => 'Apa yang kamu ucapkan jika melakukan kesalahan?', 'a' => 'Maaf'],
            ['q' => 'Tempat untuk berobat orang sakit adalah ...', 'a' => 'Rumah Sakit / Puskesmas'],
            ['q' => 'Sebutkan alat transportasi beroda dua!', 'a' => 'Sepeda, Sepeda Motor'],
            ['q' => 'Apa guna lampu lalu lintas?', 'a' => 'Mengatur lalu lintas'],
            ['q' => 'Siapa yang mengajar di kelas?', 'a' => 'Guru'],
            ['q' => 'Sebutkan perlengkapan sekolah!', 'a' => 'Tas, Buku, Pensil, Sepatu'],
            ['q' => 'Jika ada tamu mengetuk pintu, kita harus ...', 'a' => 'Membuka pintu / Menjawab salam'],
            ['q' => 'Sebutkan anggota keluarga intimu!', 'a' => 'Ayah, Ibu, Kakak, Adik'],
            ['q' => 'Apa yang kita lakukan di kantin sekolah?', 'a' => 'Makan / Jajan'],
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
