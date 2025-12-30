<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Rombel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Kelas 1-6 (each with A and B)
        $kelasData = [];
        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B'] as $suffix) {
                $kelasData[] = Kelas::create([
                    'tingkat' => $tingkat,
                    'nama' => $tingkat . $suffix,
                ]);
            }
        }

        // Create Kepala Madrasah
        $kepalaMadrasahUser = User::create([
            'name' => 'H. Ahmad Syafii, S.Pd.I',
            'email' => 'kamad@madrasah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'is_active' => true,
        ]);
        Guru::create([
            'user_id' => $kepalaMadrasahUser->id,
            'nip' => '1980010120050011001',
            'nama' => 'H. Ahmad Syafii, S.Pd.I',
            'jabatan' => 'kepala_madrasah',
            'no_hp' => '081234567890',
        ]);

        // Create Guru Kelas (6 guru for 6 kelas)
        $guruKelasData = [
            ['nama' => 'Siti Fatimah, S.Pd', 'email' => 'guru.kelas1@madrasah.com', 'nip' => '1985010120100011001'],
            ['nama' => 'Ahmad Rizki, S.Pd', 'email' => 'guru.kelas2@madrasah.com', 'nip' => '1986010120100011002'],
            ['nama' => 'Nurul Hidayah, S.Pd', 'email' => 'guru.kelas3@madrasah.com', 'nip' => '1987010120100011003'],
            ['nama' => 'Muhammad Iqbal, S.Pd', 'email' => 'guru.kelas4@madrasah.com', 'nip' => '1988010120100011004'],
            ['nama' => 'Dewi Rahmawati, S.Pd', 'email' => 'guru.kelas5@madrasah.com', 'nip' => '1989010120100011005'],
            ['nama' => 'Hasan Abdullah, S.Pd', 'email' => 'guru.kelas6@madrasah.com', 'nip' => '1990010120100011006'],
        ];

        $guruKelas = [];
        foreach ($guruKelasData as $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_active' => true,
            ]);
            $guruKelas[] = Guru::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jabatan' => 'guru_kelas',
                'no_hp' => '08' . rand(100000000, 999999999),
            ]);
        }

        // Create Guru Mapel (3 guru mapel)
        $guruMapelData = [
            ['nama' => 'Ustadz Mahmud, S.Ag', 'email' => 'guru.agama@madrasah.com', 'nip' => '1982010120080011001'],
            ['nama' => 'Ibu Kartini, S.Pd', 'email' => 'guru.bahasa@madrasah.com', 'nip' => '1983010120080011002'],
            ['nama' => 'Pak Budi Santoso, S.Pd', 'email' => 'guru.olahraga@madrasah.com', 'nip' => '1984010120080011003'],
        ];

        foreach ($guruMapelData as $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_active' => true,
            ]);
            Guru::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jabatan' => 'guru_mapel',
                'no_hp' => '08' . rand(100000000, 999999999),
            ]);
        }

        // Create Pelajaran - Guru Kelas
        $pelajaranGuruKelas = [
            ['kode' => 'MTK', 'nama' => 'Matematika'],
            ['kode' => 'BIN', 'nama' => 'Bahasa Indonesia'],
            ['kode' => 'IPA', 'nama' => 'Ilmu Pengetahuan Alam'],
            ['kode' => 'IPS', 'nama' => 'Ilmu Pengetahuan Sosial'],
            ['kode' => 'PKN', 'nama' => 'Pendidikan Kewarganegaraan'],
            ['kode' => 'SBK', 'nama' => 'Seni Budaya dan Keterampilan'],
        ];

        foreach ($pelajaranGuruKelas as $data) {
            Pelajaran::create([
                'kode' => $data['kode'],
                'nama' => $data['nama'],
                'jenis' => 'guru_kelas',
                'is_active' => true,
            ]);
        }

        // Create Pelajaran - Guru Mapel
        $pelajaranGuruMapel = [
            ['kode' => 'AGI', 'nama' => 'Pendidikan Agama Islam'],
            ['kode' => 'BAR', 'nama' => 'Bahasa Arab'],
            ['kode' => 'QHD', 'nama' => 'Quran Hadits'],
            ['kode' => 'AQI', 'nama' => 'Aqidah Akhlak'],
            ['kode' => 'FIQ', 'nama' => 'Fiqih'],
            ['kode' => 'SKI', 'nama' => 'Sejarah Kebudayaan Islam'],
            ['kode' => 'PJK', 'nama' => 'Pendidikan Jasmani dan Kesehatan'],
        ];

        foreach ($pelajaranGuruMapel as $data) {
            Pelajaran::create([
                'kode' => $data['kode'],
                'nama' => $data['nama'],
                'jenis' => 'guru_mapel',
                'is_active' => true,
            ]);
        }

        // Create Sample Siswa (10 siswa)
        $siswaData = [
            ['nama' => 'Ahmad Fauzi', 'nisn' => '0101234001', 'jk' => 'L'],
            ['nama' => 'Siti Aisyah', 'nisn' => '0101234002', 'jk' => 'P'],
            ['nama' => 'Muhammad Rizky', 'nisn' => '0101234003', 'jk' => 'L'],
            ['nama' => 'Fatimah Azzahra', 'nisn' => '0101234004', 'jk' => 'P'],
            ['nama' => 'Abdul Rahman', 'nisn' => '0101234005', 'jk' => 'L'],
            ['nama' => 'Khadijah Putri', 'nisn' => '0101234006', 'jk' => 'P'],
            ['nama' => 'Umar Faruq', 'nisn' => '0101234007', 'jk' => 'L'],
            ['nama' => 'Zainab Maulida', 'nisn' => '0101234008', 'jk' => 'P'],
            ['nama' => 'Ali Imran', 'nisn' => '0101234009', 'jk' => 'L'],
            ['nama' => 'Maryam Sholihah', 'nisn' => '0101234010', 'jk' => 'P'],
        ];

        $siswas = [];
        foreach ($siswaData as $index => $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => 'siswa' . ($index + 1) . '@madrasah.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'is_active' => true,
            ]);
            $siswas[] = Siswa::create([
                'user_id' => $user->id,
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jk'],
                'tanggal_lahir' => now()->subYears(rand(6, 12))->subMonths(rand(1, 12)),
            ]);
        }

        // Create Rombel for Kelas 1A with first guru kelas as wali kelas
        $rombel = Rombel::create([
            'kelas_id' => $kelasData[0]->id, // Kelas 1A
            'wali_kelas_id' => $guruKelas[0]->id, // First guru kelas
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);

        // Assign 5 siswa to rombel
        foreach (array_slice($siswas, 0, 5) as $siswa) {
            $rombel->siswas()->attach($siswa->id);
        }

        // Assign pelajaran to rombel
        $pelajarans = Pelajaran::all();
        foreach ($pelajarans->take(5) as $pelajaran) {
            $rombel->pelajarans()->attach($pelajaran->id, [
                'guru_id' => $guruKelas[0]->id,
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@madrasah.com / password');
        $this->command->info('Kepala: kepala@madrasah.com / password');
        $this->command->info('Guru: guru.kelas1@madrasah.com / password');
        $this->command->info('Siswa: siswa1@madrasah.com / password');
    }
}
