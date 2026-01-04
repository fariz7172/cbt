<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin first
        User::firstOrCreate(
            ['email' => 'superadmin@cbt.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'sekolah_id' => null,
                'is_active' => true,
            ]
        );

        // Data Sekolah from NSM list
        $sekolahData = [
            ['nsm' => '111131720002', 'nama' => 'MIN 20 JAKARTA'],
            ['nsm' => '111131720003', 'nama' => 'MIN 22 JAKARTA'],
            ['nsm' => '111231720001', 'nama' => 'MI AL-HUSNA'],
            ['nsm' => '111231720002', 'nama' => 'MI MIFTAHUL HIKMAH'],
            ['nsm' => '111231720003', 'nama' => 'MIS ASH-SHIDDIQIN'],
            ['nsm' => '111231720005', 'nama' => 'MIS AL WATHONIYAH 43'],
            ['nsm' => '111231720007', 'nama' => 'MI AL-MUBASYIRIN '],
            ['nsm' => '111231720009', 'nama' => 'MIS AL WATHONIYAH 1'],
            ['nsm' => '111231720010', 'nama' => 'MIS AL HIKMAH'],
            ['nsm' => '111231720011', 'nama' => 'MIS IMADUN NAJAH'],
            ['nsm' => '111231720012', 'nama' => 'MIS AL MAARIF'],
            ['nsm' => '111231720013', 'nama' => 'MIS NURHIDAYAH'],
            ['nsm' => '111231720015', 'nama' => 'MIS AT TAUFIQ'],
            ['nsm' => '111231720018', 'nama' => 'MIS AL BARKAH'],
            ['nsm' => '111231720021', 'nama' => 'MIS AL MUZAYYANAH'],
            ['nsm' => '111231720022', 'nama' => 'MIS EL NUR EL KASYSYAF IV'],
            ['nsm' => '111231720023', 'nama' => 'MIS AL WATHONIYAH 14'],
            ['nsm' => '111231720024', 'nama' => 'MIS NURUL ISLAM I'],
            ['nsm' => '111231720025', 'nama' => 'MIS RAUDLATUL ISLAMIYAH'],
            ['nsm' => '111231720029', 'nama' => 'MIS NURUL IKHLAS'],
            ['nsm' => '111231720030', 'nama' => 'MIS NURUL BAHRI'],
            ['nsm' => '111231720031', 'nama' => 'MIS AL KHAIRIYAH'],
            ['nsm' => '111231720032', 'nama' => 'MIS AL-FALAH'],
            ['nsm' => '111231720034', 'nama' => 'MIS JAMIATUL KHAIR'],
            ['nsm' => '111231720035', 'nama' => 'MIS NURUL ISLAM II'],
            ['nsm' => '111231720037', 'nama' => 'MIS RAUDLATUL MUBTADIIN'],
            ['nsm' => '111231720039', 'nama' => 'MIS RIYADLUS SHIBYAN'],
            ['nsm' => '111231720040', 'nama' => 'MIS AL MUTTAQIN'],
            ['nsm' => '111231720041', 'nama' => 'MIS AL ISLAMIYAH'],
            ['nsm' => '111231720042', 'nama' => 'MIS AL ALIMIYAH'],
            ['nsm' => '111231720045', 'nama' => 'MIS AL AMIN'],
            ['nsm' => '111231720047', 'nama' => 'MIS MIFTAHUL HUDA'],
            ['nsm' => '111231720051', 'nama' => 'MIS AL JIHAD'],
            ['nsm' => '111231720053', 'nama' => 'MIS AL HIDAYAH'],
            ['nsm' => '111231720055', 'nama' => 'MIS AR RASYIDIYYAH'],
            ['nsm' => '111231720056', 'nama' => 'MIS ASH SHIDDIQQIYAH'],
            ['nsm' => '111231720061', 'nama' => 'MIS RAUDHATUL JANNATINAIM'],
            ['nsm' => '111231720062', 'nama' => 'MIS BUDI MULIA'],
            ['nsm' => '111231720063', 'nama' => 'MIS NUR-ATTAQWA'],
            ['nsm' => '111231720064', 'nama' => 'MIS TAHFIZH BAITUL HUDA'],
            ['nsm' => '111231720067', 'nama' => 'MIS AL-FATIMIYAH AN-NUR'],
            ['nsm' => '111231720069', 'nama' => 'MIS AL ANWARIYAH'],
            ['nsm' => '121131720002', 'nama' => 'MTSN 15 JAKARTA'],
            ['nsm' => '121131720003', 'nama' => 'MTSN 38 JAKARTA'],
            ['nsm' => '121231720005', 'nama' => 'MTSS ASH SHIDIQIYAH'],
            ['nsm' => '121231720007', 'nama' => 'MTSS AL HIKMAH'],
            ['nsm' => '121231720008', 'nama' => 'MTSS AL MIFFTAHIYYAH'],
            ['nsm' => '121231720009', 'nama' => 'MTSS AL MUBASYIRIN'],
            ['nsm' => '121231720010', 'nama' => 'MTSS AL WATHONIYAH 14'],
            ['nsm' => '121231720013', 'nama' => 'MTSS AL FALAH'],
            ['nsm' => '121231720014', 'nama' => 'MTSS DARUL BINA'],
            ['nsm' => '121231720016', 'nama' => 'MTSS YAPIS'],
            ['nsm' => '121231720018', 'nama' => 'MTSS AL MUHAJIRIN TG'],
            ['nsm' => '121231720019', 'nama' => 'MTSS PERSIS 12'],
            ['nsm' => '121231720021', 'nama' => 'MTSS AL WATHONIYAH 43'],
            ['nsm' => '121231720023', 'nama' => 'MTSS NUR ATTAQWA'],
            ['nsm' => '121231720024', 'nama' => 'MTSS NURUL BAHRI'],
            ['nsm' => '121231720025', 'nama' => 'MTSS MANDIRI'],
            ['nsm' => '121231720026', 'nama' => 'MTSS AL-AQSHA'],
            ['nsm' => '121231720028', 'nama' => 'MTSS EL-NUR EL-KASYSYAF'],
            ['nsm' => '121231720031', 'nama' => 'MTSS Al-Anwariyah'],
            ['nsm' => '131131720001', 'nama' => 'MAN 5 JAKARTA'],
            ['nsm' => '131131720002', 'nama' => 'MAN 21 JAKARTA'],
            ['nsm' => '131231720001', 'nama' => 'MAS AL MUHAJIRIN'],
            ['nsm' => '131231720003', 'nama' => 'MAS AL JIHAD'],
            ['nsm' => '131231720005', 'nama' => 'MAS AL KHAIRIYAH'],
            ['nsm' => '131231720006', 'nama' => 'MAS AR RASYIDIYAH'],
            ['nsm' => '131231720009', 'nama' => 'MAS AL WATHONIYAH 14'],
            ['nsm' => '131231720012', 'nama' => 'MAS KHAIRUL UMMAH'],
            ['nsm' => '131231720013', 'nama' => 'MAS Nurul Bahri'],
            ['nsm' => '111131720001', 'nama' => 'MIN 5 JAKARTA'],
            ['nsm' => '111231720004', 'nama' => 'MIS AR RIDHA'],
            ['nsm' => '111231720006', 'nama' => 'MIS MIFTAHUL JANNAH'],
            ['nsm' => '111231720008', 'nama' => 'MIS AL ARAF'],
            ['nsm' => '111231720014', 'nama' => 'MIS AL ITTIHADIYAH'],
            ['nsm' => '111235320071', 'nama' => 'MIS ALKHAIRIYAH'],
            ['nsm' => '111231720016', 'nama' => 'MIS TARBIYATUL ISLAMIYAH'],
            ['nsm' => '111231720017', 'nama' => 'MIS AL JIHAD'],
            ['nsm' => '111231720019', 'nama' => 'MIS ARRRUHANIYAH'],
            ['nsm' => '111231720020', 'nama' => 'MIS NURUL AKHYAR'],
            ['nsm' => '111231720026', 'nama' => 'MIS DAARUL GHUFRON'],
            ['nsm' => '111235720016', 'nama' => 'MIN 16 JAKARTA'],
            ['nsm' => '111231720027', 'nama' => 'MIS AL IFADAH'],
            ['nsm' => '111231720028', 'nama' => 'MIS AL MUHAJIRIN'],
            ['nsm' => '111231720033', 'nama' => 'MIS TARBIYATUL FALAH'],
            ['nsm' => '111231720036', 'nama' => 'MIS NURUL HUDA'],
            ['nsm' => '111231720038', 'nama' => 'MIS NURUL FALAH'],
            ['nsm' => '111231720043', 'nama' => 'MIS NURUL IKHWAN'],
            ['nsm' => '111231720044', 'nama' => 'MIS AL MUTTAQIIEN'],
            ['nsm' => '111231720046', 'nama' => 'MIS AL MUAWANAH'],
            ['nsm' => '111231720048', 'nama' => 'MIS ILHAM II'],
            ['nsm' => '111231720049', 'nama' => 'MIS AL IHSAN'],
            ['nsm' => '111231720050', 'nama' => 'MIS NURUL HUDA'],


              ['nsm' => '111231720052', 'nama' => 'MIS AL IHSANIYAH'],
            ['nsm' => '111231720054', 'nama' => 'MIS AL IKHWAN'],
            ['nsm' => '111231720057', 'nama' => 'MIS AL KHAIRIYAH PAGI'],
            ['nsm' => '111231720058', 'nama' => 'MIS RAUDLATUL MUTTAQIEN'],
            ['nsm' => '111231720059', 'nama' => 'MIS ILHAM 1'],
            ['nsm' => '111231720060', 'nama' => 'MIS AR RAUDHAH'],
            ['nsm' => '111231720065', 'nama' => 'MIS BACHRUL ILMI AL-AMIN'],
            ['nsm' => '111231720066', 'nama' => 'MIS AL GIVARI'],
            ['nsm' => '111231720068', 'nama' => 'MIS TAHFIDZ AL MARJAN'],
            ['nsm' => '121131720001', 'nama' => 'MTSN 5 JAKARTA'],
            ['nsm' => '121131720004', 'nama' => 'MTSN 39 JAKARTA'],
            ['nsm' => '121231720001', 'nama' => 'MTSS AL KHAIRIYAH KOJA'],
            ['nsm' => '121231720002', 'nama' => 'MTSS AL HIDAYAH UKA'],
            ['nsm' => '121231720003', 'nama' => 'MTSS AL MUHAJIRIN KJ'],
            ['nsm' => '121231720004', 'nama' => 'MTSS AR RASYIDIYYAH'],
            ['nsm' => '121231720006', 'nama' => 'MTSS RAUDHATUL MUTTAQIN'],
            ['nsm' => '121231720011', 'nama' => 'MTSS IMADUN NAJAH'],
            ['nsm' => '121231720012', 'nama' => 'MTSS AL KHAIRIYAH KP BAHARI'],
            ['nsm' => '121231720015', 'nama' => 'MTSS AL-JIHAD'],
            ['nsm' => '121231720017', 'nama' => 'MTSS AL HIDAYAH RBU'],
            ['nsm' => '121231720022', 'nama' => 'MTSS RAUDHATUL JANNATINNA IM'],
            ['nsm' => '121231720027', 'nama' => 'MTSS KHAIRUL UMMAH'],
            ['nsm' => '121231720029', 'nama' => 'MTs NURUL JALAL'],
            ['nsm' => '121231720030', 'nama' => 'MTSS Tahfizh Baitul Huda'],
            ['nsm' => '131231720002', 'nama' => 'MAS RD JANNATINNAIM'],
            ['nsm' => '131231720004', 'nama' => 'MAS YAPIS'],
            ['nsm' => '131231720007', 'nama' => 'MAS PERSIS 12'],
            ['nsm' => '131231720008', 'nama' => 'MAS AL WATHONIYAH 43'],
            ['nsm' => '131231720011', 'nama' => 'MAS NURUL JALAL'],
            ['nsm' => '131231720014', 'nama' => 'MA AL MARJAN '],

        ];

        foreach ($sekolahData as $index => $data) {
            // Create sekolah
            $sekolah = Sekolah::firstOrCreate(
                ['nsm' => $data['nsm']],
                [
                    'nama' => $data['nama'],
                    'alamat' => 'Jakarta',
                    'telepon' => '-',
                    'email' => 'info' . $data['nsm'] . '@sch.id',
                    'is_active' => true,
                ]
            );

            // Create admin for this sekolah using NSM for short email
            User::firstOrCreate(
                ['email' => "admin{$data['nsm']}@cbt.com"],
                [
                    'name' => Str::limit("Admin " . $data['nama'], 50, ''),
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'sekolah_id' => $sekolah->id,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Sekolah and Admin seeding completed!');
        $this->command->info('Total sekolah: ' . count($sekolahData));
        $this->command->info('Admin login format: admin{NSM}@cbt.com / password');
        $this->command->info('Example: admin111131720002@cbt.com');
    }
}
