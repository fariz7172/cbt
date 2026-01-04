-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2026 at 08:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt_madrasah`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` enum('kepala_madrasah','guru_kelas','guru_mapel') NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `user_id`, `sekolah_id`, `nip`, `nama`, `jabatan`, `no_hp`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '1980010120050011001', 'H. Ahmad Syafii, S.Pd.I', 'kepala_madrasah', '081234567890', NULL, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(2, 5, 1, '1985010120100011001', 'Siti Fatimah, S.Pd', 'guru_kelas', '08190974916', NULL, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(3, 6, 1, '1986010120100011002', 'Ahmad Rizki, S.Pd', 'guru_kelas', '08243541967', NULL, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(4, 7, 1, '1987010120100011003', 'Nurul Hidayah, S.Pd', 'guru_kelas', '08594765750', NULL, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(5, 8, 1, '1988010120100011004', 'Muhammad Iqbal, S.Pd', 'guru_kelas', '08672302204', NULL, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(6, 9, 1, '1989010120100011005', 'Dewi Rahmawati, S.Pd', 'guru_kelas', '08876439397', NULL, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(7, 10, 1, '1990010120100011006', 'Hasan Abdullah, S.Pd', 'guru_kelas', '08135539295', NULL, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(8, 11, 1, '1982010120080011001', 'Ustadz Mahmud, S.Ag', 'guru_mapel', '08867439930', NULL, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(9, 12, 1, '1983010120080011002', 'Ibu Kartini, S.Pd', 'guru_mapel', '08201964739', NULL, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(10, 13, 1, '1984010120080011003', 'Pak Budi Santoso, S.Pd', 'guru_mapel', '08841578021', NULL, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(11, 25, 2, '080812121', 'ujang', 'guru_kelas', '1141', 'Jakarta', NULL, '2026-01-03 04:43:45', '2026-01-03 04:43:45'),
(12, 28, 3, '0', 'Fidiawati', 'guru_kelas', '1141', 'Jakarta', NULL, '2026-01-03 05:39:59', '2026-01-03 05:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujians`
--

CREATE TABLE `hasil_ujians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `benar` int(11) NOT NULL DEFAULT 0,
  `salah` int(11) NOT NULL DEFAULT 0,
  `status` enum('belum_mulai','sedang_mengerjakan','selesai') NOT NULL DEFAULT 'belum_mulai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_siswas`
--

CREATE TABLE `jawaban_siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hasil_ujian_id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` text DEFAULT NULL,
  `is_benar` tinyint(1) DEFAULT NULL,
  `poin_didapat` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tingkat` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `tingkat`, `nama`, `sekolah_id`, `created_at`, `updated_at`) VALUES
(1, 1, '1A', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(2, 1, '1B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(3, 2, '2A', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(4, 2, '2B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(5, 3, '3A', 3, '2026-01-03 04:29:44', '2026-01-03 05:53:17'),
(6, 3, '3B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(7, 4, '4A', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(8, 4, '4B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(9, 5, '5A', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(10, 5, '5B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(11, 6, '6A', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(12, 6, '6B', 1, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(14, 9, 'A', 2, '2026-01-03 04:42:29', '2026-01-03 04:42:29'),
(15, 2, '1V', NULL, '2026-01-03 05:50:58', '2026-01-03 05:50:58'),
(16, 3, '3A', 2, '2026-01-03 05:52:41', '2026-01-03 05:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_24_010001_create_kelas_table', 1),
(6, '2024_12_24_010002_create_gurus_table', 1),
(7, '2024_12_24_010003_create_siswas_table', 1),
(8, '2024_12_24_010004_create_pelajarans_table', 1),
(9, '2024_12_24_010005_create_rombels_table', 1),
(10, '2024_12_24_010006_create_soals_table', 1),
(11, '2024_12_24_010007_create_ujians_table', 1),
(12, '2024_12_24_010008_create_hasil_ujians_table', 1),
(13, '2024_12_24_102400_add_kelas_id_to_siswas_table', 1),
(14, '2025_12_24_040231_add_gambar_to_soals_table', 1),
(15, '2026_01_03_112459_create_sekolahs_table', 1),
(16, '2026_01_03_112501_add_sekolah_id_to_tables', 1),
(17, '2026_01_03_114547_add_sekolah_id_to_rombels_table', 2),
(18, '2026_01_03_131940_remove_unique_constraint_from_pelajarans_kode', 3),
(19, '2026_01_03_131950_remove_unique_constraint_from_pelajarans_kode', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelajarans`
--

CREATE TABLE `pelajarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` enum('guru_kelas','guru_mapel') NOT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelajarans`
--

INSERT INTO `pelajarans` (`id`, `kode`, `nama`, `jenis`, `sekolah_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MTK', 'Matematika', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(2, 'BIN', 'Bahasa Indonesia', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(3, 'IPA', 'Ilmu Pengetahuan Alam', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(4, 'IPS', 'Ilmu Pengetahuan Sosial', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(5, 'PKN', 'Pendidikan Kewarganegaraan', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(6, 'SBK', 'Seni Budaya dan Keterampilan', 'guru_kelas', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(7, 'AGI', 'Pendidikan Agama Islam', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(8, 'BAR', 'Bahasa Arab', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(9, 'QHD', 'Quran Hadits', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(10, 'AQI', 'Aqidah Akhlak', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(11, 'FIQ', 'Fiqih', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(12, 'SKI', 'Sejarah Kebudayaan Islam', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(13, 'PJK', 'Pendidikan Jasmani dan Kesehatan', 'guru_mapel', 1, 1, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(15, 'IPA', 'ILMU PENGETAHUAN ALAM', 'guru_kelas', 3, 1, '2026-01-03 06:21:07', '2026-01-03 06:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rombels`
--

CREATE TABLE `rombels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rombels`
--

INSERT INTO `rombels` (`id`, `sekolah_id`, `kelas_id`, `wali_kelas_id`, `tahun_ajaran`, `semester`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2024/2025', 'ganjil', '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(2, 3, 5, 12, '2026/2027', 'ganjil', '2026-01-03 06:03:07', '2026-01-03 06:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `rombel_pelajaran`
--

CREATE TABLE `rombel_pelajaran` (
  `rombel_id` bigint(20) UNSIGNED NOT NULL,
  `pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rombel_pelajaran`
--

INSERT INTO `rombel_pelajaran` (`rombel_id`, `pelajaran_id`, `guru_id`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2),
(2, 15, 12);

-- --------------------------------------------------------

--
-- Table structure for table `rombel_siswa`
--

CREATE TABLE `rombel_siswa` (
  `rombel_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rombel_siswa`
--

INSERT INTO `rombel_siswa` (`rombel_id`, `siswa_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sekolahs`
--

CREATE TABLE `sekolahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nsm` varchar(255) NOT NULL COMMENT 'Nomor Statistik Madrasah',
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sekolahs`
--

INSERT INTO `sekolahs` (`id`, `nama`, `nsm`, `alamat`, `telepon`, `email`, `logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MI Nurul Huda', '111233040001', 'Jl. Pendidikan No. 123, Jakarta', '021-12345678', 'info@minurulhuda.sch.id', NULL, 1, '2026-01-03 04:29:43', '2026-01-03 04:29:43'),
(2, 'MI Al-Ikhlas', '111233040002', 'Jl. Raya Pendidikan No. 456, Bogor', '0251-87654321', 'info@mialikhlas.sch.id', NULL, 1, '2026-01-03 04:29:43', '2026-01-03 04:29:43'),
(3, 'MIS NURHIDAYAH', '1112317200013', 'Jakarta', '081280965725', 'Misnurhidayah@gmail.com', NULL, 1, '2026-01-03 04:52:08', '2026-01-03 04:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nisn` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp_ortu` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `user_id`, `sekolah_id`, `kelas_id`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `no_hp_ortu`, `foto`, `created_at`, `updated_at`) VALUES
(1, 14, 1, NULL, '0101234001', 'Ahmad Fauzi', 'L', '2013-12-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(2, 15, 1, NULL, '0101234002', 'Siti Aisyah', 'P', '2016-07-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(3, 16, 1, NULL, '0101234003', 'Muhammad Rizky', 'L', '2013-05-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(4, 17, 1, NULL, '0101234004', 'Fatimah Azzahra', 'P', '2016-01-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(5, 18, 1, NULL, '0101234005', 'Abdul Rahman', 'L', '2014-04-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(6, 19, 1, NULL, '0101234006', 'Khadijah Putri', 'P', '2019-02-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(7, 20, 1, NULL, '0101234007', 'Umar Faruq', 'L', '2015-02-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(8, 21, 1, NULL, '0101234008', 'Zainab Maulida', 'P', '2018-07-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(9, 22, 1, NULL, '0101234009', 'Ali Imran', 'L', '2017-05-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(10, 23, 1, 1, '0101234010', 'Maryam Sholihah', 'P', '2019-08-03', NULL, NULL, NULL, NULL, '2026-01-03 04:29:49', '2026-01-03 05:27:30'),
(11, 24, 2, 14, '3170151252', 'Tatang', 'L', '2026-01-03', '31', 'Jakarta', '314412', NULL, '2026-01-03 04:43:14', '2026-01-03 04:43:14'),
(12, 29, 3, 5, '3170151251', 'Mikael Ellia', 'L', '2025-12-29', 'Jakarta', 'Jakarta', '314412', NULL, '2026-01-03 05:56:50', '2026-01-03 05:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `soals`
--

CREATE TABLE `soals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `tingkat_kelas` int(11) NOT NULL,
  `tipe` enum('pilihan_ganda','essay','benar_salah') NOT NULL,
  `pertanyaan` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `opsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opsi`)),
  `kunci_jawaban` text NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soals`
--

INSERT INTO `soals` (`id`, `pelajaran_id`, `guru_id`, `tingkat_kelas`, `tipe`, `pertanyaan`, `gambar`, `opsi`, `kunci_jawaban`, `poin`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 1, 'pilihan_ganda', 'Huruf pertama dari kata \"AYAM\" adalah ...', NULL, '{\"A\":\"A\",\"B\":\"B\",\"C\":\"C\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(2, 2, 2, 1, 'pilihan_ganda', 'Benda yang digunakan untuk menulis adalah ...', NULL, '{\"A\":\"Sendok\",\"B\":\"Gelas\",\"C\":\"Pensil\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(3, 2, 2, 1, 'pilihan_ganda', 'Suara kucing berbunyi ...', NULL, '{\"A\":\"Guk guk\",\"B\":\"Meong\",\"C\":\"Mbek\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(4, 2, 2, 1, 'pilihan_ganda', 'Ibu sedang ... nasi di dapur.', NULL, '{\"A\":\"Memasak\",\"B\":\"Membaca\",\"C\":\"Bermain\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(5, 2, 2, 1, 'pilihan_ganda', 'Sebelum makan kita harus ...', NULL, '{\"A\":\"Tidur\",\"B\":\"Bermain\",\"C\":\"Berdoa\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(6, 2, 2, 1, 'pilihan_ganda', 'Anggota tubuh untuk melihat adalah ...', NULL, '{\"A\":\"Mata\",\"B\":\"Hidung\",\"C\":\"Telinga\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(7, 2, 2, 1, 'pilihan_ganda', 'Budi bermain bola di ...', NULL, '{\"A\":\"Kamar\",\"B\":\"Lapangan\",\"C\":\"Dapur\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(8, 2, 2, 1, 'pilihan_ganda', 'Huruf vokal terdiri dari a, i, u, e, dan ...', NULL, '{\"A\":\"b\",\"B\":\"c\",\"C\":\"o\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(9, 2, 2, 1, 'pilihan_ganda', 'Ayah pergi bekerja naik ... motor.', NULL, '{\"A\":\"Sepeda\",\"B\":\"Rumah\",\"C\":\"Meja\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(10, 2, 2, 1, 'pilihan_ganda', 'Lawan kata \"BESAR\" adalah ...', NULL, '{\"A\":\"Tinggi\",\"B\":\"Kecil\",\"C\":\"Panjang\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(11, 2, 2, 1, 'pilihan_ganda', 'Matahari terbit pada ... hari.', NULL, '{\"A\":\"Pagi\",\"B\":\"Siang\",\"C\":\"Malam\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(12, 2, 2, 1, 'pilihan_ganda', 'Sapi makan ...', NULL, '{\"A\":\"Daging\",\"B\":\"Nasi\",\"C\":\"Rumput\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(13, 2, 2, 1, 'pilihan_ganda', 'Warna bendera Indonesia adalah ...', NULL, '{\"A\":\"Merah Biru\",\"B\":\"Merah Putih\",\"C\":\"Putih Merah\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(14, 2, 2, 1, 'pilihan_ganda', 'Tempat untuk mandi adalah ...', NULL, '{\"A\":\"Dapur\",\"B\":\"Teras\",\"C\":\"Kamar Mandi\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(15, 2, 2, 1, 'pilihan_ganda', 'Jika bertemu guru di jalan kita harus ...', NULL, '{\"A\":\"Menyapa\",\"B\":\"Lari\",\"C\":\"Diam\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(16, 2, 2, 1, 'pilihan_ganda', 'Huruf \"B\" adalah huruf ...', NULL, '{\"A\":\"Vokal\",\"B\":\"Konsonan\",\"C\":\"Angka\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(17, 2, 2, 1, 'pilihan_ganda', 'Buah yang warnanya kuning dan bentuknya melengkung adalah ...', NULL, '{\"A\":\"Pisang\",\"B\":\"Apel\",\"C\":\"Anggur\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(18, 2, 2, 1, 'pilihan_ganda', 'Adik minum susu menggunakan ...', NULL, '{\"A\":\"Piring\",\"B\":\"Gelas\",\"C\":\"Ember\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(19, 2, 2, 1, 'pilihan_ganda', 'Buku digunakan untuk ...', NULL, '{\"A\":\"Dimakan\",\"B\":\"Dibuang\",\"C\":\"Dibaca\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(20, 2, 2, 1, 'pilihan_ganda', 'Kaki meja ada ...', NULL, '{\"A\":\"Dua\",\"B\":\"Empat\",\"C\":\"Lima\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(21, 2, 2, 1, 'pilihan_ganda', '\"Sapu\" huruf depannya adalah ...', NULL, '{\"A\":\"M\",\"B\":\"B\",\"C\":\"S\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(22, 2, 2, 1, 'pilihan_ganda', 'Kita mendengar menggunakan ...', NULL, '{\"A\":\"Telinga\",\"B\":\"Mata\",\"C\":\"Hidung\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(23, 2, 2, 1, 'pilihan_ganda', 'Rasa gula adalah ...', NULL, '{\"A\":\"Asin\",\"B\":\"Manis\",\"C\":\"Pahit\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(24, 2, 2, 1, 'pilihan_ganda', 'Jika berbuat salah kita harus minta ...', NULL, '{\"A\":\"Maaf\",\"B\":\"Uang\",\"C\":\"Makan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(25, 2, 2, 1, 'pilihan_ganda', 'Binatang yang bisa terbang adalah ...', NULL, '{\"A\":\"Kucing\",\"B\":\"Ikan\",\"C\":\"Burung\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(26, 2, 2, 1, 'pilihan_ganda', 'Jumlah jari tangan kanan ada ...', NULL, '{\"A\":\"Empat\",\"B\":\"Lima\",\"C\":\"Enam\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(27, 2, 2, 1, 'pilihan_ganda', 'Ayah dari ayah kita panggil ...', NULL, '{\"A\":\"Kakek\",\"B\":\"Paman\",\"C\":\"Kakak\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(28, 2, 2, 1, 'pilihan_ganda', 'Sekolah tempat kita untuk ...', NULL, '{\"A\":\"Tidur\",\"B\":\"Belajar\",\"C\":\"Jajan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(29, 2, 2, 1, 'pilihan_ganda', 'Alat untuk membersihkan gigi adalah ...', NULL, '{\"A\":\"Sikat gigi\",\"B\":\"Sapu\",\"C\":\"Sendok\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(30, 2, 2, 1, 'pilihan_ganda', 'Lampu lalu lintas warna merah artinya ...', NULL, '{\"A\":\"Jalan\",\"B\":\"Hati-hati\",\"C\":\"Berhenti\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(31, 2, 2, 1, 'pilihan_ganda', 'Benda untuk duduk adalah ...', NULL, '{\"A\":\"Meja\",\"B\":\"Kursi\",\"C\":\"Lemari\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(32, 2, 2, 1, 'pilihan_ganda', 'Kata \"MAKAN\" terdiri dari ... huruf.', NULL, '{\"A\":\"4\",\"B\":\"5\",\"C\":\"6\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(33, 2, 2, 1, 'pilihan_ganda', 'Teman Budi sedang sakit. Budi ... teman.', NULL, '{\"A\":\"Menjenguk\",\"B\":\"Memukul\",\"C\":\"Mengejek\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(34, 2, 2, 1, 'pilihan_ganda', 'Pagi hari ayam jantan akan ...', NULL, '{\"A\":\"Mengaum\",\"B\":\"Berkokok\",\"C\":\"Mengeong\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(35, 2, 2, 1, 'pilihan_ganda', 'Bunga melati warnanya ...', NULL, '{\"A\":\"Merah\",\"B\":\"Biru\",\"C\":\"Putih\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(36, 2, 2, 1, 'pilihan_ganda', 'Buani sedang ... baju.', NULL, '{\"A\":\"Mencuci\",\"B\":\"Memasak\",\"C\":\"Menulis\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(37, 2, 2, 1, 'pilihan_ganda', 'Tempat berkumpulnya siswa di sekolah adalah ...', NULL, '{\"A\":\"Pasar\",\"B\":\"Kelas\",\"C\":\"Rumah sakit\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(38, 2, 2, 1, 'pilihan_ganda', 'Kita berjalan menggunakan ...', NULL, '{\"A\":\"Tangan\",\"B\":\"Kepala\",\"C\":\"Kaki\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(39, 2, 2, 1, 'pilihan_ganda', 'Setelah mandi kita memakai ...', NULL, '{\"A\":\"Handuk\",\"B\":\"Selimut\",\"C\":\"Topi\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(40, 2, 2, 1, 'pilihan_ganda', 'Binatang yang hidup di air adalah ...', NULL, '{\"A\":\"Ayam\",\"B\":\"Ikan\",\"C\":\"Kambing\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(41, 2, 2, 1, 'pilihan_ganda', 'Matahari terbenam di sebelah ...', NULL, '{\"A\":\"Timur\",\"B\":\"Atas\",\"C\":\"Barat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(42, 2, 2, 1, 'pilihan_ganda', 'Jika diberi hadiah kita mengucapkan ...', NULL, '{\"A\":\"Terima kasih\",\"B\":\"Maaf\",\"C\":\"Tolong\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(43, 2, 2, 1, 'pilihan_ganda', 'Benda di langit yang bersinar malam hari adalah ...', NULL, '{\"A\":\"Matahari\",\"B\":\"Bulan\",\"C\":\"Awan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(44, 2, 2, 1, 'pilihan_ganda', 'Adik menangis karena ...', NULL, '{\"A\":\"Jatuh\",\"B\":\"Senang\",\"C\":\"Tidur\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(45, 2, 2, 1, 'pilihan_ganda', 'Alat tulis untuk menghapus adalah ...', NULL, '{\"A\":\"Penggaris\",\"B\":\"Bolpoin\",\"C\":\"Penghapus\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(46, 2, 2, 1, 'pilihan_ganda', 'Rambut diletakkan di ...', NULL, '{\"A\":\"Kepala\",\"B\":\"Kaki\",\"C\":\"Perut\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(47, 2, 2, 1, 'pilihan_ganda', 'Anak yang rajin belajar akan menjadi ...', NULL, '{\"A\":\"Bodoh\",\"B\":\"Pintar\",\"C\":\"Nakal\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(48, 2, 2, 1, 'pilihan_ganda', 'Rumah tempat kita ...', NULL, '{\"A\":\"Sekolah\",\"B\":\"Belanja\",\"C\":\"Tinggal\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(49, 2, 2, 1, 'pilihan_ganda', 'Ekor gajah itu ...', NULL, '{\"A\":\"Panjang\",\"B\":\"Pendek\",\"C\":\"Besar\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(50, 2, 2, 1, 'pilihan_ganda', 'Kita mencium bau dengan ...', NULL, '{\"A\":\"Hidung\",\"B\":\"Mulut\",\"C\":\"Telinga\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(51, 2, 2, 1, 'essay', 'Siapakah nama presiden Indonesia yang pertama?', NULL, NULL, 'Soekarno', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(52, 2, 2, 1, 'essay', 'Sebutkan 2 hewan berkaki empat!', NULL, NULL, 'Sapi, Kambing, Kuda, Kucing, Anjing (jawaban fleksibel binatang kaki 4)', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(53, 2, 2, 1, 'essay', 'Lengkapi kalimat ini: Ibu pergi ke ... untuk membeli sayur.', NULL, NULL, 'Pasar', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(54, 2, 2, 1, 'essay', 'Apa warna daun pada umumnya?', NULL, NULL, 'Hijau', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(55, 2, 2, 1, 'essay', 'Tuliskan nama lengkapmu!', NULL, NULL, 'Jawaban menyesuaikan nama siswa', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(56, 2, 2, 1, 'essay', 'Berapa jumlah roda sepeda motor?', NULL, NULL, 'Dua / 2', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(57, 2, 2, 1, 'essay', 'Apa nama ibukota negara Indonesia?', NULL, NULL, 'Jakarta', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(58, 2, 2, 1, 'essay', 'Sebutkan guna tangan!', NULL, NULL, 'Memegang, Menulis, Makan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(59, 2, 2, 1, 'essay', 'Lengkapi: Satu, dua, tiga, empat, ...', NULL, NULL, 'Lima', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(60, 2, 2, 1, 'essay', 'Apa rasa garam?', NULL, NULL, 'Asin', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(61, 2, 2, 1, 'essay', 'Sebutkan benda di dalam tas sekolahmu!', NULL, NULL, 'Buku, Pensil, Penghapus, Penggaris', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(62, 2, 2, 1, 'essay', 'Kapan kita melakukan upacara bendera?', NULL, NULL, 'Hari Senin', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(63, 2, 2, 1, 'essay', 'Di mana ikan hidup?', NULL, NULL, 'Di air / Laut / Sungai', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(64, 2, 2, 1, 'essay', 'Lengkapi kata ini: S_KOL_H', NULL, NULL, 'SEKOLAH', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(65, 2, 2, 1, 'essay', 'Apa bahasa Inggris dari \"Satu\"?', NULL, NULL, 'One', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(66, 2, 2, 1, 'essay', 'Siapa yang melahirkan kita?', NULL, NULL, 'Ibu', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(67, 2, 2, 1, 'essay', 'Gigi digunakan untuk apa?', NULL, NULL, 'Mengunyah makanan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(68, 2, 2, 1, 'essay', 'Sebutkan nama hari setelah Minggu!', NULL, NULL, 'Senin', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(69, 2, 2, 1, 'essay', 'Apa yang kamu lakukan sebelum tidur?', NULL, NULL, 'Gosok gigi / Berdoa', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(70, 2, 2, 1, 'essay', 'Jika hujan turun kita memakai apa agar tidak basah?', NULL, NULL, 'Payung / Jas Hujan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(71, 3, 2, 1, 'pilihan_ganda', 'Mata digunakan untuk ...', NULL, '{\"A\":\"Melihat\",\"B\":\"Mendengar\",\"C\":\"Berjalan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(72, 3, 2, 1, 'pilihan_ganda', 'Hidung berguna untuk mencium ...', NULL, '{\"A\":\"Suara\",\"B\":\"Bau\",\"C\":\"Rasa\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(73, 3, 2, 1, 'pilihan_ganda', 'Kita berjalan menggunakan ...', NULL, '{\"A\":\"Tangan\",\"B\":\"Kepala\",\"C\":\"Kaki\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(74, 3, 2, 1, 'pilihan_ganda', 'Gigi digunakan untuk ... makanan.', NULL, '{\"A\":\"Mengunyah\",\"B\":\"Menelan\",\"C\":\"Membaui\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(75, 3, 2, 1, 'pilihan_ganda', 'Telinga ada di ... kepala.', NULL, '{\"A\":\"Atas\",\"B\":\"Samping\",\"C\":\"Belakang\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(76, 3, 2, 1, 'pilihan_ganda', 'Hewan yang berkokok di pagi hari adalah ...', NULL, '{\"A\":\"Ayam jantan\",\"B\":\"Kucing\",\"C\":\"Sapi\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(77, 3, 2, 1, 'pilihan_ganda', 'Ikan berenang menggunakan ...', NULL, '{\"A\":\"Kaki\",\"B\":\"Sayap\",\"C\":\"Sirip\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(78, 3, 2, 1, 'pilihan_ganda', 'Kucing suka makan ...', NULL, '{\"A\":\"Rumput\",\"B\":\"Ikan\",\"C\":\"Biji-bijian\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(79, 3, 2, 1, 'pilihan_ganda', 'Burung terbang menggunakan ...', NULL, '{\"A\":\"Ekor\",\"B\":\"Sayap\",\"C\":\"Paruh\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(80, 3, 2, 1, 'pilihan_ganda', 'Sapi menghasilkan ...', NULL, '{\"A\":\"Susu\",\"B\":\"Telur\",\"C\":\"Madu\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(81, 3, 2, 1, 'pilihan_ganda', 'Bagian tumbuhan yang ada di dalam tanah adalah ...', NULL, '{\"A\":\"Daun\",\"B\":\"Batang\",\"C\":\"Akar\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(82, 3, 2, 1, 'pilihan_ganda', 'Warna daun kebanyakan adalah ...', NULL, '{\"A\":\"Merah\",\"B\":\"Hijau\",\"C\":\"Biru\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(83, 3, 2, 1, 'pilihan_ganda', 'Lidah berguna untuk mengecap ...', NULL, '{\"A\":\"Rasa\",\"B\":\"Bau\",\"C\":\"Bunyi\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(84, 3, 2, 1, 'pilihan_ganda', 'Matahari terbit dari arah ...', NULL, '{\"A\":\"Barat\",\"B\":\"Timur\",\"C\":\"Utara\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(85, 3, 2, 1, 'pilihan_ganda', 'Di malam hari langit terlihat ...', NULL, '{\"A\":\"Terang\",\"B\":\"Putih\",\"C\":\"Gelap\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(86, 3, 2, 1, 'pilihan_ganda', 'Benda langit yang terlihat di malam hari adalah ...', NULL, '{\"A\":\"Bulan dan Bintang\",\"B\":\"Matahari\",\"C\":\"Awan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(87, 3, 2, 1, 'pilihan_ganda', 'Mandi sebaiknya dilakuan ... kali sehari.', NULL, '{\"A\":\"1\",\"B\":\"2\",\"C\":\"5\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(88, 3, 2, 1, 'pilihan_ganda', 'Supaya gigi bersih kita harus ...', NULL, '{\"A\":\"Menggosok gigi\",\"B\":\"Makan permen\",\"C\":\"Tidur\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(89, 3, 2, 1, 'pilihan_ganda', 'Kuku yang panjang harus di...', NULL, '{\"A\":\"Warnai\",\"B\":\"Potong\",\"C\":\"Biarkan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(90, 3, 2, 1, 'pilihan_ganda', 'Sebelum makan kita harus mencuci ...', NULL, '{\"A\":\"Kaki\",\"B\":\"Rambut\",\"C\":\"Tangan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(91, 3, 2, 1, 'pilihan_ganda', 'Sampah harus dibuang di ...', NULL, '{\"A\":\"Tempat sampah\",\"B\":\"Sungai\",\"C\":\"Jalan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(92, 3, 2, 1, 'pilihan_ganda', 'Rumah yang bersih menjauhkan kita dari ...', NULL, '{\"A\":\"Kenyamanan\",\"B\":\"Penyakit\",\"C\":\"Teman\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(93, 3, 2, 1, 'pilihan_ganda', 'Air yang kotor dapat menyebabkan ...', NULL, '{\"A\":\"Sehat\",\"B\":\"Kuat\",\"C\":\"Gatal-gatal\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(94, 3, 2, 1, 'pilihan_ganda', 'Nyamuk menyebabkan penyakit ...', NULL, '{\"A\":\"Demam berdarah\",\"B\":\"Sakit gigi\",\"C\":\"Batuk\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(95, 3, 2, 1, 'pilihan_ganda', 'Pakaian kotor harus segera di...', NULL, '{\"A\":\"Pakai\",\"B\":\"Cuci\",\"C\":\"Jual\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(96, 3, 2, 1, 'pilihan_ganda', 'Jika kulit terkena api akan terasa ...', NULL, '{\"A\":\"Dingin\",\"B\":\"Gatal\",\"C\":\"Panas\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(97, 3, 2, 1, 'pilihan_ganda', 'Es batu rasanya ...', NULL, '{\"A\":\"Dingin\",\"B\":\"Panas\",\"C\":\"Pedas\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(98, 3, 2, 1, 'pilihan_ganda', 'Suara petir terdengar sangat ...', NULL, '{\"A\":\"Pelan\",\"B\":\"Keras\",\"C\":\"Merdu\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(99, 3, 2, 1, 'pilihan_ganda', 'Gajah memiliki tubuh yang ...', NULL, '{\"A\":\"Kecil\",\"B\":\"Tipis\",\"C\":\"Besar\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(100, 3, 2, 1, 'pilihan_ganda', 'Semut memiliki tubuh yang ...', NULL, '{\"A\":\"Kecil\",\"B\":\"Besar\",\"C\":\"Panjang\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(101, 3, 2, 1, 'pilihan_ganda', 'Buah jeruk rasanya ...', NULL, '{\"A\":\"Pahit\",\"B\":\"Manis atau asam\",\"C\":\"Asin\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(102, 3, 2, 1, 'pilihan_ganda', 'Cabai rasanya ...', NULL, '{\"A\":\"Manis\",\"B\":\"Asam\",\"C\":\"Pedas\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(103, 3, 2, 1, 'pilihan_ganda', 'Kambing makan ...', NULL, '{\"A\":\"Rumput\",\"B\":\"Daging\",\"C\":\"Nasi\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(104, 3, 2, 1, 'pilihan_ganda', 'Harimau makan ...', NULL, '{\"A\":\"Buah\",\"B\":\"Daging\",\"C\":\"Sayur\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(105, 3, 2, 1, 'pilihan_ganda', 'Kelinci bergerak dengan cara ...', NULL, '{\"A\":\"Terbang\",\"B\":\"Berenang\",\"C\":\"Melompat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(106, 3, 2, 1, 'pilihan_ganda', 'Ular bergerak dengan cara ...', NULL, '{\"A\":\"Melata\",\"B\":\"Berjalan\",\"C\":\"Terbang\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(107, 3, 2, 1, 'pilihan_ganda', 'Hewan yang lehernya panjang adalah ...', NULL, '{\"A\":\"Gajah\",\"B\":\"Jerapah\",\"C\":\"Kuda\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(108, 3, 2, 1, 'pilihan_ganda', 'Bunga mawar batangnya ber...', NULL, '{\"A\":\"Buah\",\"B\":\"Bulu\",\"C\":\"Duri\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(109, 3, 2, 1, 'pilihan_ganda', 'Pohon kelapa tumbuh tinggi menjulang ke ...', NULL, '{\"A\":\"Atas\",\"B\":\"Bawah\",\"C\":\"Samping\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(110, 3, 2, 1, 'pilihan_ganda', 'Benda padat contohnya adalah ...', NULL, '{\"A\":\"Air\",\"B\":\"Batu\",\"C\":\"Angin\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(111, 3, 2, 1, 'pilihan_ganda', 'Benda cair contohnya adalah ...', NULL, '{\"A\":\"Air\",\"B\":\"Kayu\",\"C\":\"Asap\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(112, 3, 2, 1, 'pilihan_ganda', 'Agar tanaman subur harus di...', NULL, '{\"A\":\"Tebang\",\"B\":\"Injak\",\"C\":\"Siram\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(113, 3, 2, 1, 'pilihan_ganda', 'Matahari memberikan energi ...', NULL, '{\"A\":\"Bunyi\",\"B\":\"Panas dan Cahaya\",\"C\":\"Gerak\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(114, 3, 2, 1, 'pilihan_ganda', 'Lantai yang kotor harus di...', NULL, '{\"A\":\"Sapu\",\"B\":\"Kotori\",\"C\":\"Lihat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(115, 3, 2, 1, 'pilihan_ganda', 'Tidur yang cukup membuat badan menjadi ...', NULL, '{\"A\":\"Lemas\",\"B\":\"Sakit\",\"C\":\"Sehat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(116, 3, 2, 1, 'pilihan_ganda', 'Saat bersin sebaiknya menutup ...', NULL, '{\"A\":\"Mata\",\"B\":\"Mulut dan hidung\",\"C\":\"Telinga\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(117, 3, 2, 1, 'pilihan_ganda', 'Rambut berguna untuk melindungi ...', NULL, '{\"A\":\"Kepala\",\"B\":\"Kaki\",\"C\":\"Tangan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(118, 3, 2, 1, 'pilihan_ganda', 'Alis mata ada di atas ...', NULL, '{\"A\":\"Hidung\",\"B\":\"Mata\",\"C\":\"Mulut\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(119, 3, 2, 1, 'pilihan_ganda', 'Jumlah kaki ayam ada ...', NULL, '{\"A\":\"2\",\"B\":\"4\",\"C\":\"6\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(120, 3, 2, 1, 'pilihan_ganda', 'Jumlah kaki sapi ada ...', NULL, '{\"A\":\"2\",\"B\":\"4\",\"C\":\"8\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(121, 3, 2, 1, 'essay', 'Sebutkan 2 pancaindra yang kamu ketahui!', NULL, NULL, 'Mata, Hidung, Telinga, Lidah, Kulit (pilih 2)', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(122, 3, 2, 1, 'essay', 'Apa kegunaan kaki?', NULL, NULL, 'Untuk berjalan / berdiri', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(123, 3, 2, 1, 'essay', 'Hewan apa yang menghasilkan madu?', NULL, NULL, 'Lebah', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(124, 3, 2, 1, 'essay', 'Apa makanan kelinci?', NULL, NULL, 'Wortel / Sayuran', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(125, 3, 2, 1, 'essay', 'Sebutkan benda cair!', NULL, NULL, 'Air, Susu, Minyak, Teh', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(126, 3, 2, 1, 'essay', 'Kapan matahari terbit?', NULL, NULL, 'Pagi hari', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(127, 3, 2, 1, 'essay', 'Apa warna langit saat cerah?', NULL, NULL, 'Biru', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(128, 3, 2, 1, 'essay', 'Jika kita tidak mandi, badan akan terasa ...', NULL, NULL, 'Gatal / Bau', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(129, 3, 2, 1, 'essay', 'Sebutkan hewan yang hidup di air!', NULL, NULL, 'Ikan, Udang, Paus', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(130, 3, 2, 1, 'essay', 'Apa kegunaan air bagi manusia?', NULL, NULL, 'Minum, Mandi, Mencuci', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(131, 3, 2, 1, 'essay', 'Bagian tumbuhan yang indah dan berwarna-warni disebut ...', NULL, NULL, 'Bunga', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(132, 3, 2, 1, 'essay', 'Sebutkan hewan berkaki dua!', NULL, NULL, 'Ayam, Bebek, Burung', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(133, 3, 2, 1, 'essay', 'Apa rasa air laut?', NULL, NULL, 'Asin', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(134, 3, 2, 1, 'essay', 'Agar udara segar, kita harus menanam ...', NULL, NULL, 'Pohon / Tumbuhan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(135, 3, 2, 1, 'essay', 'Apa yang kamu pakai untuk melindungi kaki?', NULL, NULL, 'Sepatu / Sendal', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(136, 3, 2, 1, 'essay', 'Sebutkan guna hidung!', NULL, NULL, 'Bernapas / Mencium bau', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(137, 3, 2, 1, 'essay', 'Hewan apa yang lehernya sangat panjang?', NULL, NULL, 'Jerapah', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(138, 3, 2, 1, 'essay', 'Apa makanan sapi?', NULL, NULL, 'Rumput', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(139, 3, 2, 1, 'essay', 'Jika haus kita harus ...', NULL, NULL, 'Minum', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(140, 3, 2, 1, 'essay', 'Sampah plastik harus dibuang di ...', NULL, NULL, 'Tempat sampah', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(141, 4, 2, 1, 'pilihan_ganda', 'Nama panggilan adalah nama yang ...', NULL, '{\"A\":\"Panjang\",\"B\":\"Pendek\",\"C\":\"Sulit\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(142, 4, 2, 1, 'pilihan_ganda', 'Ayah dan Ibu disebut ...', NULL, '{\"A\":\"Saudara\",\"B\":\"Kakek Nenek\",\"C\":\"Orang Tua\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(143, 4, 2, 1, 'pilihan_ganda', 'Adik laki-laki dari ayah dipanggil ...', NULL, '{\"A\":\"Paman\",\"B\":\"Bibi\",\"C\":\"Kakek\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(144, 4, 2, 1, 'pilihan_ganda', 'Ibu dari ibu kita dipanggil ...', NULL, '{\"A\":\"Ibu\",\"B\":\"Nenek\",\"C\":\"Kakak\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(145, 4, 2, 1, 'pilihan_ganda', 'Rumah adalah tempat untuk ...', NULL, '{\"A\":\"Berlindung\",\"B\":\"Jajan\",\"C\":\"Sekolah\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(146, 4, 2, 1, 'pilihan_ganda', 'Alamat rumah harus diingat agar tidak ...', NULL, '{\"A\":\"Lapar\",\"B\":\"Sakit\",\"C\":\"Tersesat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(147, 4, 2, 1, 'pilihan_ganda', 'Keluarga inti terdiri dari Ayah, Ibu, dan ...', NULL, '{\"A\":\"Paman\",\"B\":\"Anak\",\"C\":\"Tetangga\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(148, 4, 2, 1, 'pilihan_ganda', 'Tugas seorang anak di rumah adalah ...', NULL, '{\"A\":\"Menghormati orang tua\",\"B\":\"Bekerja mencari uang\",\"C\":\"Memarah adik\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(149, 4, 2, 1, 'pilihan_ganda', 'Jika adik menangis, kita harus ...', NULL, '{\"A\":\"Memukul\",\"B\":\"Menghibur\",\"C\":\"Tertawa\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(150, 4, 2, 1, 'pilihan_ganda', 'Sikap yang baik kepada orang tua adalah ...', NULL, '{\"A\":\"Sopan\",\"B\":\"Kasar\",\"C\":\"Membangkang\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(151, 4, 2, 1, 'pilihan_ganda', 'Tetangga adalah orang yang tinggal di ... rumah kita.', NULL, '{\"A\":\"Dalam\",\"B\":\"Atas\",\"C\":\"Dekat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(152, 4, 2, 1, 'pilihan_ganda', 'Jika bertemu tetangga di jalan kita harus ...', NULL, '{\"A\":\"Lari\",\"B\":\"Menyapa\",\"C\":\"Diam\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(153, 4, 2, 1, 'pilihan_ganda', 'Gotong royong artinya bekerja ...', NULL, '{\"A\":\"Bersama-sama\",\"B\":\"Sendiri\",\"C\":\"Malas-malasan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(154, 4, 2, 1, 'pilihan_ganda', 'Tempat untuk memasak di rumah adalah ...', NULL, '{\"A\":\"Kamar Tidur\",\"B\":\"Ruang Tamu\",\"C\":\"Dapur\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(155, 4, 2, 1, 'pilihan_ganda', 'Tamu yang datang dipersilakan masuk ke ...', NULL, '{\"A\":\"Kamar Mandi\",\"B\":\"Ruang Tamu\",\"C\":\"Dapur\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(156, 4, 2, 1, 'pilihan_ganda', 'Jendela rumah berguna untuk keluar masuk ...', NULL, '{\"A\":\"Udara dan cahaya\",\"B\":\"Orang\",\"C\":\"Mobil\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(157, 4, 2, 1, 'pilihan_ganda', 'Sampah di halaman harus di...', NULL, '{\"A\":\"Biarkan\",\"B\":\"Timbun\",\"C\":\"Sapu\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(158, 4, 2, 1, 'pilihan_ganda', 'Kerja bakti membuat pekerjaan menjadi lebih ...', NULL, '{\"A\":\"Berat\",\"B\":\"Ringan\",\"C\":\"Lama\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(159, 4, 2, 1, 'pilihan_ganda', 'Kepala keluarga di rumah adalah ...', NULL, '{\"A\":\"Ayah\",\"B\":\"Ibu\",\"C\":\"Anak\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(160, 4, 2, 1, 'pilihan_ganda', 'Kasih sayang ibu sepanjang ...', NULL, '{\"A\":\"Jalan\",\"B\":\"Galah\",\"C\":\"Masa\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(161, 4, 2, 1, 'pilihan_ganda', 'Peristiwa yang menyenangkan contohnya ...', NULL, '{\"A\":\"Ulang tahun\",\"B\":\"Sakit\",\"C\":\"Jatuh dari sepeda\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(162, 4, 2, 1, 'pilihan_ganda', 'Peristiwa yang menyedihkan contohnya ...', NULL, '{\"A\":\"Dapat hadiah\",\"B\":\"Kehilangan mainan\",\"C\":\"Juara kelas\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(163, 4, 2, 1, 'pilihan_ganda', 'Jika teman sedang sedih, kita harus ...', NULL, '{\"A\":\"Menghibur\",\"B\":\"Mengejek\",\"C\":\"Memarah\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(164, 4, 2, 1, 'pilihan_ganda', 'Manusia tidak bisa hidup ...', NULL, '{\"A\":\"Bersama\",\"B\":\"Berkelompok\",\"C\":\"Sendiri\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(165, 4, 2, 1, 'pilihan_ganda', 'Rumah yang sehat harus memiliki ...', NULL, '{\"A\":\"TV besar\",\"B\":\"Ventilasi udara\",\"C\":\"Mainan banyak\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(166, 4, 2, 1, 'pilihan_ganda', 'Setiap orang memiliki identitas diri. Identitas diri contohnya ...', NULL, '{\"A\":\"Nama\",\"B\":\"Baju\",\"C\":\"Sepatu\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(167, 4, 2, 1, 'pilihan_ganda', 'Anak pertama disebut anak ...', NULL, '{\"A\":\"Bungsu\",\"B\":\"Tengah\",\"C\":\"Sulung\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(168, 4, 2, 1, 'pilihan_ganda', 'Anak terakhir disebut anak ...', NULL, '{\"A\":\"Bungsu\",\"B\":\"Sulung\",\"C\":\"Kembar\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(169, 4, 2, 1, 'pilihan_ganda', 'Jika ingin keluar rumah kita harus ...', NULL, '{\"A\":\"Lari\",\"B\":\"Pamit\",\"C\":\"Diam-diam\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(170, 4, 2, 1, 'pilihan_ganda', 'Rumah yang kotor menjadi sarang ...', NULL, '{\"A\":\"Penyakit\",\"B\":\"Kesehatan\",\"C\":\"Kenyamanan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(171, 4, 2, 1, 'pilihan_ganda', 'Kita harus ... kepada Tuhan Yang Maha Esa.', NULL, '{\"A\":\"Lupa\",\"B\":\"Marah\",\"C\":\"Bersyukur\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(172, 4, 2, 1, 'pilihan_ganda', 'Suku bangsa di Indonesia ada ...', NULL, '{\"A\":\"Satu\",\"B\":\"Banyak\",\"C\":\"Sedikit\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(173, 4, 2, 1, 'pilihan_ganda', 'Bhinneka Tunggal Ika artinya berbeda-beda tetapi tetap ...', NULL, '{\"A\":\"Satu\",\"B\":\"Dua\",\"C\":\"Tiga\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(174, 4, 2, 1, 'pilihan_ganda', 'Warna merah pada bendera artinya ...', NULL, '{\"A\":\"Suci\",\"B\":\"Berani\",\"C\":\"Takut\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(175, 4, 2, 1, 'pilihan_ganda', 'Warna putih pada bendera artinya ...', NULL, '{\"A\":\"Suci\",\"B\":\"Berani\",\"C\":\"Kuat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(176, 4, 2, 1, 'pilihan_ganda', 'Lagu kebangsaan kita adalah ...', NULL, '{\"A\":\"Balonku\",\"B\":\"Pelangi\",\"C\":\"Indonesia Raya\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(177, 4, 2, 1, 'pilihan_ganda', 'Presiden Indonesia saat ini adalah ...', NULL, '{\"A\":\"Soekarno\",\"B\":\"Soeharto\",\"C\":\"Jokowi \\/ Prabowo (sesuaikan)\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(178, 4, 2, 1, 'pilihan_ganda', 'Tempat untuk menyimpan foto kenangan adalah ...', NULL, '{\"A\":\"Buku tulis\",\"B\":\"Album foto\",\"C\":\"Koran\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(179, 4, 2, 1, 'pilihan_ganda', 'Hari kemerdekaan Indonesia tanggal ...', NULL, '{\"A\":\"17 Agustus\",\"B\":\"21 April\",\"C\":\"10 November\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(180, 4, 2, 1, 'pilihan_ganda', 'Ibu Kartini adalah pahlawan ...', NULL, '{\"A\":\"Laki-laki\",\"B\":\"Wanita\",\"C\":\"Anak-anak\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(181, 4, 2, 1, 'pilihan_ganda', 'Garuda Pancasila adalah ... negara Indonesia.', NULL, '{\"A\":\"Lagu\",\"B\":\"Bendera\",\"C\":\"Lambang\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(182, 4, 2, 1, 'pilihan_ganda', 'Sila pertama Pancasila dilambangkan dengan ...', NULL, '{\"A\":\"Bintang\",\"B\":\"Rantai\",\"C\":\"Pohon Beringin\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(183, 4, 2, 1, 'pilihan_ganda', 'Sila kedua Pancasila berbunyi kemanusiaan yang adil dan ...', NULL, '{\"A\":\"Makmur\",\"B\":\"Beradab\",\"C\":\"Sentosa\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(184, 4, 2, 1, 'pilihan_ganda', 'Musyawarah dilakukan untuk mencapai ...', NULL, '{\"A\":\"Masalah\",\"B\":\"Keributan\",\"C\":\"Mufakat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(185, 4, 2, 1, 'pilihan_ganda', 'Di sekolah kita dipimpin oleh ...', NULL, '{\"A\":\"Kepala Sekolah\",\"B\":\"Satpam\",\"C\":\"Ketua Kelas\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(186, 4, 2, 1, 'pilihan_ganda', 'Seragam SD berwarna putih dan ...', NULL, '{\"A\":\"Biru\",\"B\":\"Merah\",\"C\":\"Abu-abu\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(187, 4, 2, 1, 'pilihan_ganda', 'Upacara bendera dilakukan dengan ...', NULL, '{\"A\":\"Ramai\",\"B\":\"Bercanda\",\"C\":\"Khidmat\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(188, 4, 2, 1, 'pilihan_ganda', 'Tempat meminjam buku di sekolah adalah ...', NULL, '{\"A\":\"Perpustakaan\",\"B\":\"Kantin\",\"C\":\"UKS\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(189, 4, 2, 1, 'pilihan_ganda', 'Jika guru sedang menjelaskan kita harus ...', NULL, '{\"A\":\"Tidur\",\"B\":\"Mendengarkan\",\"C\":\"Ngobrol\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(190, 4, 2, 1, 'pilihan_ganda', 'PR singkatan dari ...', NULL, '{\"A\":\"Pekerjaan Rumah\",\"B\":\"Pekerjaan Ribet\",\"C\":\"Pekerjaan Rusak\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(191, 4, 2, 1, 'essay', 'Siapa nama lengkapmu?', NULL, NULL, 'Jawaban nama siswa', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(192, 4, 2, 1, 'essay', 'Di mana kamu tinggal? (Sebutkan desa/kota)', NULL, NULL, 'Jawaban alamat siswa', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(193, 4, 2, 1, 'essay', 'Siapa kepala keluarga di rumahmu?', NULL, NULL, 'Ayah', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(194, 4, 2, 1, 'essay', 'Sebutkan 2 tugas ibu di rumah!', NULL, NULL, 'Memasak, Mengurus rumah, Merawat anak', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(195, 4, 2, 1, 'essay', 'Apa yang kamu lakukan sebelum berangkat sekolah?', NULL, NULL, 'Mandi, Sarapan, Pamit orang tua', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(196, 4, 2, 1, 'essay', 'Sebutkan nama teman sebangkumu!', NULL, NULL, 'Jawaban nama teman', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(197, 4, 2, 1, 'essay', 'Apa lambang negara Indonesia?', NULL, NULL, 'Garuda Pancasila', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(198, 4, 2, 1, 'essay', 'Sebutkan warna bendera kita!', NULL, NULL, 'Merah Putih', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(199, 4, 2, 1, 'essay', 'Kapan kita merayakan hari kemerdekaan?', NULL, NULL, '17 Agustus', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(200, 4, 2, 1, 'essay', 'Apa nama agamamu?', NULL, NULL, 'Islam (atau sesuai siswa)', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(201, 4, 2, 1, 'essay', 'Sebutkan satu contoh hidup rukun!', NULL, NULL, 'Bermain bersama, Tidak bertengkar', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(202, 4, 2, 1, 'essay', 'Apa yang kamu ucapkan jika melakukan kesalahan?', NULL, NULL, 'Maaf', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(203, 4, 2, 1, 'essay', 'Tempat untuk berobat orang sakit adalah ...', NULL, NULL, 'Rumah Sakit / Puskesmas', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(204, 4, 2, 1, 'essay', 'Sebutkan alat transportasi beroda dua!', NULL, NULL, 'Sepeda, Sepeda Motor', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(205, 4, 2, 1, 'essay', 'Apa guna lampu lalu lintas?', NULL, NULL, 'Mengatur lalu lintas', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(206, 4, 2, 1, 'essay', 'Siapa yang mengajar di kelas?', NULL, NULL, 'Guru', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(207, 4, 2, 1, 'essay', 'Sebutkan perlengkapan sekolah!', NULL, NULL, 'Tas, Buku, Pensil, Sepatu', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(208, 4, 2, 1, 'essay', 'Jika ada tamu mengetuk pintu, kita harus ...', NULL, NULL, 'Membuka pintu / Menjawab salam', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(209, 4, 2, 1, 'essay', 'Sebutkan anggota keluarga intimu!', NULL, NULL, 'Ayah, Ibu, Kakak, Adik', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(210, 4, 2, 1, 'essay', 'Apa yang kita lakukan di kantin sekolah?', NULL, NULL, 'Makan / Jajan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(211, 1, 2, 1, 'pilihan_ganda', '1 + 1 = ...', NULL, '{\"A\":\"2\",\"B\":\"3\",\"C\":\"4\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(212, 1, 2, 1, 'pilihan_ganda', '2 + 3 = ...', NULL, '{\"A\":\"4\",\"B\":\"5\",\"C\":\"6\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(213, 1, 2, 1, 'pilihan_ganda', 'Ayah membeli 3 apel, lalu membeli lagi 2 apel. Jumlah apel ayah adalah ...', NULL, '{\"A\":\"4\",\"B\":\"6\",\"C\":\"5\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(214, 1, 2, 1, 'pilihan_ganda', 'Angka setelah 7 adalah ...', NULL, '{\"A\":\"6\",\"B\":\"8\",\"C\":\"9\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(215, 1, 2, 1, 'pilihan_ganda', 'Angka sebelum 10 adalah ...', NULL, '{\"A\":\"9\",\"B\":\"11\",\"C\":\"8\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(216, 1, 2, 1, 'pilihan_ganda', '5 - 2 = ...', NULL, '{\"A\":\"4\",\"B\":\"1\",\"C\":\"3\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(217, 1, 2, 1, 'pilihan_ganda', 'Benda yang berbentuk bulat adalah ...', NULL, '{\"A\":\"Buku\",\"B\":\"Bola\",\"C\":\"Meja\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(218, 1, 2, 1, 'pilihan_ganda', 'Benda yang berbentuk kotak adalah ...', NULL, '{\"A\":\"Kardus\",\"B\":\"Kelereng\",\"C\":\"Gelas\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(219, 1, 2, 1, 'pilihan_ganda', '8 ... 5 (Lebih besar/kecil)', NULL, '{\"A\":\"Lebih besar dari\",\"B\":\"Lebih kecil dari\",\"C\":\"Sama dengan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(220, 1, 2, 1, 'pilihan_ganda', '3 ... 9 (Lebih besar/kecil)', NULL, '{\"A\":\"Lebih besar dari\",\"B\":\"Lebih kecil dari\",\"C\":\"Sama dengan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(221, 1, 2, 1, 'pilihan_ganda', 'Jumlah jari tangan kanan dan kiri adalah ...', NULL, '{\"A\":\"5\",\"B\":\"8\",\"C\":\"10\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(222, 1, 2, 1, 'pilihan_ganda', 'Lambang bilangan \"Dua Belas\" adalah ...', NULL, '{\"A\":\"12\",\"B\":\"21\",\"C\":\"2\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(223, 1, 2, 1, 'pilihan_ganda', 'Nama bilangan dari 15 adalah ...', NULL, '{\"A\":\"Satu Lima\",\"B\":\"Lima Belas\",\"C\":\"Lima Puluh\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(224, 1, 2, 1, 'pilihan_ganda', '4 + 4 = ...', NULL, '{\"A\":\"6\",\"B\":\"7\",\"C\":\"8\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(225, 1, 2, 1, 'pilihan_ganda', '9 - 4 = ...', NULL, '{\"A\":\"4\",\"B\":\"5\",\"C\":\"6\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(226, 1, 2, 1, 'pilihan_ganda', 'Bangun datar yang memiliki 3 sisi disebut ...', NULL, '{\"A\":\"Segitiga\",\"B\":\"Segiempat\",\"C\":\"Lingkaran\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(227, 1, 2, 1, 'pilihan_ganda', 'Uang koin berbentuk ...', NULL, '{\"A\":\"Kotak\",\"B\":\"Segitiga\",\"C\":\"Lingkaran\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(228, 1, 2, 1, 'pilihan_ganda', 'Urutan angka dari terkecil: 3, 1, 5 adalah ...', NULL, '{\"A\":\"1, 3, 5\",\"B\":\"5, 3, 1\",\"C\":\"1, 5, 3\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(229, 1, 2, 1, 'pilihan_ganda', 'Urutan angka dari terbesar: 6, 8, 2 adalah ...', NULL, '{\"A\":\"2, 6, 8\",\"B\":\"8, 6, 2\",\"C\":\"6, 2, 8\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(230, 1, 2, 1, 'pilihan_ganda', 'Siti punya 5 permen, dikasih Adik 2 permen. Sisa permen Siti ...', NULL, '{\"A\":\"7\",\"B\":\"5\",\"C\":\"3\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(231, 1, 2, 1, 'pilihan_ganda', 'Hari ini hari Senin, besok hari ...', NULL, '{\"A\":\"Minggu\",\"B\":\"Selasa\",\"C\":\"Rabu\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(232, 1, 2, 1, 'pilihan_ganda', 'Jarum panjang jam menunjuk angka 12, jarum pendek angka 6. Maka pukul ...', NULL, '{\"A\":\"06.00\",\"B\":\"12.00\",\"C\":\"09.00\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(233, 1, 2, 1, 'pilihan_ganda', '1 minggu ada ... hari.', NULL, '{\"A\":\"5\",\"B\":\"6\",\"C\":\"7\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(234, 1, 2, 1, 'pilihan_ganda', 'Gajah lebih ... daripada semut.', NULL, '{\"A\":\"Kecil\",\"B\":\"Besar\",\"C\":\"Ringan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(235, 1, 2, 1, 'pilihan_ganda', 'Kapas lebih ... daripada batu.', NULL, '{\"A\":\"Ringan\",\"B\":\"Berat\",\"C\":\"Keras\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(236, 1, 2, 1, 'pilihan_ganda', '10 + 10 = ...', NULL, '{\"A\":\"10\",\"B\":\"20\",\"C\":\"30\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(237, 1, 2, 1, 'pilihan_ganda', '15 - 5 = ...', NULL, '{\"A\":\"5\",\"B\":\"15\",\"C\":\"10\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(238, 1, 2, 1, 'pilihan_ganda', 'Banyak kaki seekor kambing ada ...', NULL, '{\"A\":\"4\",\"B\":\"2\",\"C\":\"3\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(239, 1, 2, 1, 'pilihan_ganda', 'Roda sepeda bentuknya ...', NULL, '{\"A\":\"Persegi\",\"B\":\"Lingkaran\",\"C\":\"Segitiga\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(240, 1, 2, 1, 'pilihan_ganda', 'Buku tulis bentuknya ...', NULL, '{\"A\":\"Bulat\",\"B\":\"Segitiga\",\"C\":\"Persegi Panjang\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(241, 1, 2, 1, 'pilihan_ganda', '6 + 2 ... 10 - 2. Tanda yang tepat adalah ...', NULL, '{\"A\":\">\",\"B\":\"<\",\"C\":\"=\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(242, 1, 2, 1, 'pilihan_ganda', 'Tujuh belas ditulis angka ...', NULL, '{\"A\":\"17\",\"B\":\"71\",\"C\":\"7\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(243, 1, 2, 1, 'pilihan_ganda', 'Bilangan loncat 2: 2, 4, 6, ...', NULL, '{\"A\":\"7\",\"B\":\"8\",\"C\":\"9\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(244, 1, 2, 1, 'pilihan_ganda', 'Penggaris panjangnya 30 ...', NULL, '{\"A\":\"kg\",\"B\":\"cm\",\"C\":\"jam\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(245, 1, 2, 1, 'pilihan_ganda', 'Berat badan diukur dengan ...', NULL, '{\"A\":\"Timbangan\",\"B\":\"Penggaris\",\"C\":\"Jam\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(246, 1, 2, 1, 'pilihan_ganda', '3 + 3 + 3 = ...', NULL, '{\"A\":\"6\",\"B\":\"333\",\"C\":\"9\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(247, 1, 2, 1, 'pilihan_ganda', 'Dua puluh lima ditulis ...', NULL, '{\"A\":\"205\",\"B\":\"25\",\"C\":\"52\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(248, 1, 2, 1, 'pilihan_ganda', 'Sekarang jam 7 pagi. 1 jam lagi jam ...', NULL, '{\"A\":\"6\",\"B\":\"8\",\"C\":\"9\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(249, 1, 2, 1, 'pilihan_ganda', 'Bangun yang sisinya sama panjang adalah ...', NULL, '{\"A\":\"Persegi\",\"B\":\"Persegi Panjang\",\"C\":\"Segitiga\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(250, 1, 2, 1, 'pilihan_ganda', '8 - 0 = ...', NULL, '{\"A\":\"0\",\"B\":\"8\",\"C\":\"80\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(251, 1, 2, 1, 'pilihan_ganda', '1 puluhan + 3 satuan = ...', NULL, '{\"A\":\"13\",\"B\":\"31\",\"C\":\"4\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(252, 1, 2, 1, 'pilihan_ganda', 'Jumlah sisi segitiga ada ...', NULL, '{\"A\":\"4\",\"B\":\"5\",\"C\":\"3\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(253, 1, 2, 1, 'pilihan_ganda', '12, 13, 14, ..., 16', NULL, '{\"A\":\"11\",\"B\":\"15\",\"C\":\"17\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(254, 1, 2, 1, 'pilihan_ganda', 'Tali A panjang, Tali B pendek. Tali A ... Tali B', NULL, '{\"A\":\"Lebih panjang dari\",\"B\":\"Lebih pendek dari\",\"C\":\"Sama panjang dengan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(255, 1, 2, 1, 'pilihan_ganda', '20, 19, 18, 17, ...', NULL, '{\"A\":\"15\",\"B\":\"19\",\"C\":\"16\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(256, 1, 2, 1, 'pilihan_ganda', 'Ibu punya 10 telur, pecah 3. Sisa telur ibu ...', NULL, '{\"A\":\"6\",\"B\":\"7\",\"C\":\"8\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(257, 1, 2, 1, 'pilihan_ganda', 'Kakek punya 2 ekor ayam. Paman memberi 3 ekor ayam. Ayam kakek sekarang ...', NULL, '{\"A\":\"5\",\"B\":\"6\",\"C\":\"4\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(258, 1, 2, 1, 'pilihan_ganda', '7 + ... = 10', NULL, '{\"A\":\"1\",\"B\":\"2\",\"C\":\"3\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(259, 1, 2, 1, 'pilihan_ganda', 'Angka 5, 8, 4. Yang paling besar adalah ...', NULL, '{\"A\":\"8\",\"B\":\"5\",\"C\":\"4\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(260, 1, 2, 1, 'pilihan_ganda', 'Satu hari ada ... jam.', NULL, '{\"A\":\"12\",\"B\":\"24\",\"C\":\"48\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(261, 1, 2, 1, 'essay', '4 + 5 = ...', NULL, NULL, '9', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(262, 1, 2, 1, 'essay', '10 - 3 = ...', NULL, NULL, '7', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(263, 1, 2, 1, 'essay', 'Tulislah lambang bilangan \"delapan belas\"!', NULL, NULL, '18', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(264, 1, 2, 1, 'essay', 'Bangun datar yang memiliki 4 sisi sama panjang disebut ...', NULL, NULL, 'Persegi', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(265, 1, 2, 1, 'essay', '1, 2, 3, 4, ... (lanjutkan)', NULL, NULL, '5', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(266, 1, 2, 1, 'essay', 'Jumlah jari di kedua kakimu adalah ...', NULL, NULL, '10', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(267, 1, 2, 1, 'essay', 'Budi punya 5 kelereng, hilang 1. Sisa kelereng Budi adalah ...', NULL, NULL, '4', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(268, 1, 2, 1, 'essay', '6 + 6 = ...', NULL, NULL, '12', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(269, 1, 2, 1, 'essay', 'Angka sebelum 20 adalah ...', NULL, NULL, '19', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(270, 1, 2, 1, 'essay', 'Bola berbentuk ...', NULL, NULL, 'Bulat / Lingkaran / Bola', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(271, 1, 2, 1, 'essay', '2 puluhan + 4 satuan = ...', NULL, NULL, '24', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(272, 1, 2, 1, 'essay', '8 - 4 = ...', NULL, NULL, '4', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(273, 1, 2, 1, 'essay', 'Alat untuk mengukur panjang adalah ...', NULL, NULL, 'Penggaris', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(274, 1, 2, 1, 'essay', 'Batu itu berat, kapas itu ...', NULL, NULL, 'Ringan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(275, 1, 2, 1, 'essay', 'Mana yang lebih banyak: 5 permen atau 10 permen?', NULL, NULL, '10 permen', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(276, 1, 2, 1, 'essay', 'Segitiga memiliki ... sisi.', NULL, NULL, '3', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(277, 1, 2, 1, 'essay', '5 + 5 + 5 = ...', NULL, NULL, '15', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(278, 1, 2, 1, 'essay', 'Tuliskan angka \"Tiga Puluh\"!', NULL, NULL, '30', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(279, 1, 2, 1, 'essay', 'Ibu membeli 2 roti. Ayah membeli 2 roti. Jumlah roti ada ...', NULL, NULL, '4', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(280, 1, 2, 1, 'essay', 'Jarum jam menunjuk angka 12 siang. Itu tandanya waktu ...', NULL, NULL, 'Siang / Istirahat / Solat', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(281, 5, 2, 1, 'pilihan_ganda', 'Lambang negara Indonesia adalah ...', NULL, '{\"A\":\"Garuda Pancasila\",\"B\":\"Harimau\",\"C\":\"Gajah\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(282, 5, 2, 1, 'pilihan_ganda', 'Dasar negara kita adalah ...', NULL, '{\"A\":\"UUD 1945\",\"B\":\"Pancasila\",\"C\":\"Burung Garuda\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(283, 5, 2, 1, 'pilihan_ganda', 'Sila pertama berbunyi Ketuhanan Yang Maha ...', NULL, '{\"A\":\"Esa\",\"B\":\"Dua\",\"C\":\"Kuasa\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(284, 5, 2, 1, 'pilihan_ganda', 'Lambang sila pertama adalah ...', NULL, '{\"A\":\"Rantai\",\"B\":\"Bintang\",\"C\":\"Pohon Beringin\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(285, 5, 2, 1, 'pilihan_ganda', 'Lambang sila kedua adalah ...', NULL, '{\"A\":\"Rantai\",\"B\":\"Bintang\",\"C\":\"Kepala Banteng\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(286, 5, 2, 1, 'pilihan_ganda', 'Pohon beringin adalah lambang sila ke...', NULL, '{\"A\":\"1\",\"B\":\"2\",\"C\":\"3\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(287, 5, 2, 1, 'pilihan_ganda', 'Kepala banteng adalah lambang sila ke...', NULL, '{\"A\":\"4\",\"B\":\"3\",\"C\":\"5\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(288, 5, 2, 1, 'pilihan_ganda', 'Padi dan kapas adalah lambang sila ke...', NULL, '{\"A\":\"3\",\"B\":\"4\",\"C\":\"5\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(289, 5, 2, 1, 'pilihan_ganda', 'Warna bendera Indonesia adalah ...', NULL, '{\"A\":\"Merah Putih\",\"B\":\"Putih Merah\",\"C\":\"Merah Biru\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(290, 5, 2, 1, 'pilihan_ganda', 'Sebelum belajar kita harus ...', NULL, '{\"A\":\"Makan\",\"B\":\"Berdoa\",\"C\":\"Tidur\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(291, 5, 2, 1, 'pilihan_ganda', 'Anak yang rajin berdoa disayang ...', NULL, '{\"A\":\"Tuhan\",\"B\":\"Setan\",\"C\":\"Teman\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49');
INSERT INTO `soals` (`id`, `pelajaran_id`, `guru_id`, `tingkat_kelas`, `tipe`, `pertanyaan`, `gambar`, `opsi`, `kunci_jawaban`, `poin`, `created_at`, `updated_at`) VALUES
(292, 5, 2, 1, 'pilihan_ganda', 'Teman beragama Kristen beribadah di ...', NULL, '{\"A\":\"Masjid\",\"B\":\"Pura\",\"C\":\"Gereja\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(293, 5, 2, 1, 'pilihan_ganda', 'Umat Islam beribadah di ...', NULL, '{\"A\":\"Masjid\",\"B\":\"Gereja\",\"C\":\"Wihara\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(294, 5, 2, 1, 'pilihan_ganda', 'Jika ada teman yang berdoa, kita tidak boleh ...', NULL, '{\"A\":\"Ikut\",\"B\":\"Mengganggu\",\"C\":\"Diam\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(295, 5, 2, 1, 'pilihan_ganda', 'Hidup rukun membuat hati menjadi ...', NULL, '{\"A\":\"Senang\",\"B\":\"Sedih\",\"C\":\"Marah\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(296, 5, 2, 1, 'pilihan_ganda', 'Bermain dengan teman tidak boleh ...', NULL, '{\"A\":\"Bersama\",\"B\":\"Gantian\",\"C\":\"Curang\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(297, 5, 2, 1, 'pilihan_ganda', 'Jika teman jatuh dari sepeda, kita harus ...', NULL, '{\"A\":\"Menertawakan\",\"B\":\"Menolong\",\"C\":\"Meninggalkan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(298, 5, 2, 1, 'pilihan_ganda', 'Anak yang jujur akan punya ... teman.', NULL, '{\"A\":\"Banyak\",\"B\":\"Sedikit\",\"C\":\"Musuh\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(299, 5, 2, 1, 'pilihan_ganda', 'Jika meminjam mainan teman harus ...', NULL, '{\"A\":\"Dibuang\",\"B\":\"Dirusak\",\"C\":\"Dikembalikan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(300, 5, 2, 1, 'pilihan_ganda', 'Aturan di rumah harus di...', NULL, '{\"A\":\"Langgar\",\"B\":\"Taati\",\"C\":\"Abaikan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(301, 5, 2, 1, 'pilihan_ganda', 'Bangun tidur sebaiknya ... tempat tidur.', NULL, '{\"A\":\"Merapikan\",\"B\":\"Mengotori\",\"C\":\"Melihat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(302, 5, 2, 1, 'pilihan_ganda', 'Sebelum berangkat sekolah harus ... kepada orang tua.', NULL, '{\"A\":\"Minta uang\",\"B\":\"Menangis\",\"C\":\"Berpamitan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(303, 5, 2, 1, 'pilihan_ganda', 'Sampah harus dibuang di ...', NULL, '{\"A\":\"Sungai\",\"B\":\"Tempat sampah\",\"C\":\"Jalan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(304, 5, 2, 1, 'pilihan_ganda', 'Upacara bendera dilaksanakan setiap hari ...', NULL, '{\"A\":\"Senin\",\"B\":\"Selasa\",\"C\":\"Minggu\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(305, 5, 2, 1, 'pilihan_ganda', 'Saat upacara kita harus berdiri dengan ...', NULL, '{\"A\":\"Santai\",\"B\":\"Miring\",\"C\":\"Tegap\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(306, 5, 2, 1, 'pilihan_ganda', 'Seragam sekolah harus dipakai dengan ...', NULL, '{\"A\":\"Kotor\",\"B\":\"Rapi\",\"C\":\"Sembarangan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(307, 5, 2, 1, 'pilihan_ganda', 'Terlambat datang ke sekolah adalah perbuatan ...', NULL, '{\"A\":\"Buruk\",\"B\":\"Baik\",\"C\":\"Hebat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(308, 5, 2, 1, 'pilihan_ganda', 'Anak yang tertib akan ... pelajaran.', NULL, '{\"A\":\"Ketinggalan\",\"B\":\"Membenci\",\"C\":\"Mengerti\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(309, 5, 2, 1, 'pilihan_ganda', 'Piket kelas dilakukan secara ...', NULL, '{\"A\":\"Sendiri\",\"B\":\"Bersama-sama\",\"C\":\"Gantian\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(310, 5, 2, 1, 'pilihan_ganda', 'Hak adalah sesuatu yang harus kita ...', NULL, '{\"A\":\"Terima\",\"B\":\"Beri\",\"C\":\"Buang\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(311, 5, 2, 1, 'pilihan_ganda', 'Kewajiban adalah sesuatu yang harus kita ...', NULL, '{\"A\":\"Hindari\",\"B\":\"Kerjakan\",\"C\":\"Lupakan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(312, 5, 2, 1, 'pilihan_ganda', 'Mendapat kasih sayang orang tua adalah ... anak.', NULL, '{\"A\":\"Hak\",\"B\":\"Kewajiban\",\"C\":\"Tugas\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(313, 5, 2, 1, 'pilihan_ganda', 'Belajar adalah ... seorang siswa.', NULL, '{\"A\":\"Hak\",\"B\":\"Kewajiban\",\"C\":\"Larangan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(314, 5, 2, 1, 'pilihan_ganda', 'Laki-laki dan perempuan berbeda jenis ...', NULL, '{\"A\":\"Rambut\",\"B\":\"Baju\",\"C\":\"Kelamin\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(315, 5, 2, 1, 'pilihan_ganda', 'Kita harus menghormati orang yang lebih ...', NULL, '{\"A\":\"Tua\",\"B\":\"Muda\",\"C\":\"Kaya\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(316, 5, 2, 1, 'pilihan_ganda', 'Adik harus kita ...', NULL, '{\"A\":\"Pukul\",\"B\":\"Sayangi\",\"C\":\"Biarkan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(317, 5, 2, 1, 'pilihan_ganda', 'Kakak dan adik tidak boleh ...', NULL, '{\"A\":\"Bermain\",\"B\":\"Belajar\",\"C\":\"Bertengkar\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(318, 5, 2, 1, 'pilihan_ganda', 'Makan harus menggunakan tangan ...', NULL, '{\"A\":\"Kanan\",\"B\":\"Kiri\",\"C\":\"Dua-duanya\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(319, 5, 2, 1, 'pilihan_ganda', 'Berbicara kasar itu ...', NULL, '{\"A\":\"Boleh\",\"B\":\"Tidak boleh\",\"C\":\"Hebat\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(320, 5, 2, 1, 'pilihan_ganda', 'Jika guru menerangkan pelajaran, kita harus ...', NULL, '{\"A\":\"Tidur\",\"B\":\"Main\",\"C\":\"Mendengarkan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(321, 5, 2, 1, 'pilihan_ganda', 'Presiden Indonesia pertama adalah ...', NULL, '{\"A\":\"Soekarno\",\"B\":\"Soeharto\",\"C\":\"Habibie\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(322, 5, 2, 1, 'pilihan_ganda', 'Wakil Presiden Indonesia pertama adalah ...', NULL, '{\"A\":\"Soekarno\",\"B\":\"Moh. Hatta\",\"C\":\"Sudirman\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(323, 5, 2, 1, 'pilihan_ganda', 'Bhineka Tunggal Ika artinya berbeda-beda tetap ... jua.', NULL, '{\"A\":\"Satu\",\"B\":\"Dua\",\"C\":\"Tiga\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(324, 5, 2, 1, 'pilihan_ganda', 'Gotong royong adalah budaya bangsa ...', NULL, '{\"A\":\"Jepang\",\"B\":\"Belanda\",\"C\":\"Indonesia\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(325, 5, 2, 1, 'pilihan_ganda', 'Di sekolah kita tidak boleh membedakan ...', NULL, '{\"A\":\"Buku\",\"B\":\"Teman\",\"C\":\"Sepatu\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(326, 5, 2, 1, 'pilihan_ganda', 'Kebersihan adalah pangkal ...', NULL, '{\"A\":\"Kesehatan\",\"B\":\"Kekayaan\",\"C\":\"Kepandaian\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(327, 5, 2, 1, 'pilihan_ganda', 'Buanglah sampah pada ...', NULL, '{\"A\":\"Tempat tidur\",\"B\":\"Lantai\",\"C\":\"Tempatnya\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(328, 5, 2, 1, 'pilihan_ganda', 'Menjaga kebersihan lingkungan adalah tugas ...', NULL, '{\"A\":\"Pemerintah\",\"B\":\"Kita semua\",\"C\":\"Orang tua\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(329, 5, 2, 1, 'pilihan_ganda', 'Lingkungan yang kotor menyebabkan ...', NULL, '{\"A\":\"Penyakit\",\"B\":\"Sehat\",\"C\":\"Senang\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(330, 5, 2, 1, 'pilihan_ganda', 'Kita wajib bangga menjadi anak ...', NULL, '{\"A\":\"Malaysia\",\"B\":\"Singapura\",\"C\":\"Indonesia\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(331, 5, 2, 1, 'essay', 'Apa dasar negara Indonesia?', NULL, NULL, 'Pancasila', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(332, 5, 2, 1, 'essay', 'Sila pertama dilambangkan dengan gambar ...', NULL, NULL, 'Bintang', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(333, 5, 2, 1, 'essay', 'Bunyi sila ketiga adalah ...', NULL, NULL, 'Persatuan Indonesia', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(334, 5, 2, 1, 'essay', 'Apa warna bendera Indonesia?', NULL, NULL, 'Merah Putih', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(335, 5, 2, 1, 'essay', 'Sebutkan agamamu!', NULL, NULL, 'Islam (atau menyesuaikan)', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(336, 5, 2, 1, 'essay', 'Tempat ibadah umat Islam adalah ...', NULL, NULL, 'Masjid', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(337, 5, 2, 1, 'essay', 'Tempat ibadah umat Kristen adalah ...', NULL, NULL, 'Gereja', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(338, 5, 2, 1, 'essay', 'Kita harus ... kepada orang tua dan guru.', NULL, NULL, 'Hormat / Patuh', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(339, 5, 2, 1, 'essay', 'Jika berbuat salah, kita harus meminta ...', NULL, NULL, 'Maaf', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(340, 5, 2, 1, 'essay', 'Sebutkan satu aturan di rumah!', NULL, NULL, 'Tidur tepat waktu / Merapikan mainan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(341, 5, 2, 1, 'essay', 'Sebutkan satu aturan di sekolah!', NULL, NULL, 'Datang tepat waktu / Pakai seragam', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(342, 5, 2, 1, 'essay', 'Apa yang kamu lakukan jika melihat teman jatuh?', NULL, NULL, 'Menolongnya', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(343, 5, 2, 1, 'essay', 'Bersatu kita teguh, bercerai kita ...', NULL, NULL, 'Runtuh', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(344, 5, 2, 1, 'essay', 'Sebutkan kewajibanmu sebagai siswa!', NULL, NULL, 'Belajar', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(345, 5, 2, 1, 'essay', 'Apa hakmu di rumah?', NULL, NULL, 'Disayang orang tua / Dapat makan', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(346, 5, 2, 1, 'essay', 'Siapa pemimpin di sekolah?', NULL, NULL, 'Kepala Sekolah', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(347, 5, 2, 1, 'essay', 'Siapa pemimpin di negara kita?', NULL, NULL, 'Presiden', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(348, 5, 2, 1, 'essay', 'Lagu kebangsaan Indonesia adalah ...', NULL, NULL, 'Indonesia Raya', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(349, 5, 2, 1, 'essay', 'Sebutkan suku bangsa yang kamu tahu!', NULL, NULL, 'Jawa / Sunda / Batak / dll', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(350, 5, 2, 1, 'essay', 'Aku bangga menjadi anak ...', NULL, NULL, 'Indonesia', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(351, 6, 2, 1, 'pilihan_ganda', 'Warna pelangi ada ...', NULL, '{\"A\":\"5\",\"B\":\"6\",\"C\":\"7\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(352, 6, 2, 1, 'pilihan_ganda', 'Bunyi tepuk tangan adalah ...', NULL, '{\"A\":\"Prok prok prok\",\"B\":\"Tik tik tik\",\"C\":\"Dor dor dor\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(353, 6, 2, 1, 'pilihan_ganda', 'Alat untuk menggambar adalah ...', NULL, '{\"A\":\"Sendok\",\"B\":\"Pensil warna\",\"C\":\"Gunting\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(354, 6, 2, 1, 'pilihan_ganda', 'Daun berwarna ...', NULL, '{\"A\":\"Merah\",\"B\":\"Biru\",\"C\":\"Hijau\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(355, 6, 2, 1, 'pilihan_ganda', 'Menari menggerakkan ...', NULL, '{\"A\":\"Tubuh\",\"B\":\"Langit\",\"C\":\"Meja\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(356, 6, 2, 1, 'pilihan_ganda', 'Suara bebek adalah ...', NULL, '{\"A\":\"Mbek mbek\",\"B\":\"Kwek kwek\",\"C\":\"Meong meong\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(357, 6, 2, 1, 'pilihan_ganda', 'Benda yang berbunyi \"Kring kring\" adalah ...', NULL, '{\"A\":\"Sepeda\",\"B\":\"Kereta\",\"C\":\"Pesawat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(358, 6, 2, 1, 'pilihan_ganda', 'Lagu \"Balonku\" ada ...', NULL, '{\"A\":\"3\",\"B\":\"4\",\"C\":\"5\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(359, 6, 2, 1, 'pilihan_ganda', 'Warna buah pisang matang adalah ...', NULL, '{\"A\":\"Hijau\",\"B\":\"Kuning\",\"C\":\"Merah\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(360, 6, 2, 1, 'pilihan_ganda', 'Bahan alam untuk membuat kerajinan adalah ...', NULL, '{\"A\":\"Tanah liat\",\"B\":\"Plastik\",\"C\":\"Kaca\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(361, 6, 2, 1, 'pilihan_ganda', 'Bunyi alam contohnya ...', NULL, '{\"A\":\"Klakson\",\"B\":\"Gitar\",\"C\":\"Angin\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(362, 6, 2, 1, 'pilihan_ganda', 'Lagu \"Bintang Kecil\" bercerita tentang ...', NULL, '{\"A\":\"Bumi\",\"B\":\"Langit\",\"C\":\"Laut\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(363, 6, 2, 1, 'pilihan_ganda', 'Jika menyanyi harus sesuai ...', NULL, '{\"A\":\"Irama\",\"B\":\"Teriakan\",\"C\":\"Tangisan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(364, 6, 2, 1, 'pilihan_ganda', 'Gerakan tumbuhan tertiup angin adalah ...', NULL, '{\"A\":\"Diam\",\"B\":\"Bergoyang\",\"C\":\"Lari\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(365, 6, 2, 1, 'pilihan_ganda', 'Garis lurus bentuknya seperti ...', NULL, '{\"A\":\"Ular\",\"B\":\"Bola\",\"C\":\"Lidi\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(366, 6, 2, 1, 'pilihan_ganda', 'Menggambar sebaiknya di ...', NULL, '{\"A\":\"Buku gambar\",\"B\":\"Tembok\",\"C\":\"Baju\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(367, 6, 2, 1, 'pilihan_ganda', 'Warna susu adalah ...', NULL, '{\"A\":\"Hitam\",\"B\":\"Putih\",\"C\":\"Merah\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(368, 6, 2, 1, 'pilihan_ganda', 'Bunyi buatan contohnya ...', NULL, '{\"A\":\"Ombak\",\"B\":\"Petir\",\"C\":\"Bel sekolah\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(369, 6, 2, 1, 'pilihan_ganda', 'Kita mendengar musik dengan ...', NULL, '{\"A\":\"Telinga\",\"B\":\"Mata\",\"C\":\"Hidung\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(370, 6, 2, 1, 'pilihan_ganda', 'Seni rupa 2 dimensi memiliki panjang dan ...', NULL, '{\"A\":\"Tinggi\",\"B\":\"Lebar\",\"C\":\"Berat\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(371, 6, 2, 1, 'pilihan_ganda', 'Lukisan dipajang di ...', NULL, '{\"A\":\"Lantai\",\"B\":\"Atap\",\"C\":\"Dinding\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(372, 6, 2, 1, 'pilihan_ganda', 'Warna awan cerah adalah ...', NULL, '{\"A\":\"Hitam\",\"B\":\"Putih\\/Biru\",\"C\":\"Merah\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(373, 6, 2, 1, 'pilihan_ganda', 'Burung berkicau termasuk bunyi ...', NULL, '{\"A\":\"Alam\",\"B\":\"Buatan\",\"C\":\"Mesin\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(374, 6, 2, 1, 'pilihan_ganda', 'Menari harus dengan hati ...', NULL, '{\"A\":\"Sedih\",\"B\":\"Marah\",\"C\":\"Gembira\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(375, 6, 2, 1, 'pilihan_ganda', 'Tepuk tangan menghasilkan ...', NULL, '{\"A\":\"Cahaya\",\"B\":\"Bunyi\",\"C\":\"Bau\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(376, 6, 2, 1, 'pilihan_ganda', 'Alat musik seruling dimainkan dengan cara ...', NULL, '{\"A\":\"Ditiup\",\"B\":\"Dipukul\",\"C\":\"Dipetik\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(377, 6, 2, 1, 'pilihan_ganda', 'Gendang dimainkan dengan cara ...', NULL, '{\"A\":\"Ditiup\",\"B\":\"Dipukul\",\"C\":\"Digesek\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(378, 6, 2, 1, 'pilihan_ganda', 'Warna merah dicampur kuning menjadi ...', NULL, '{\"A\":\"Hijau\",\"B\":\"Ungu\",\"C\":\"Jingga\\/Oranye\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(379, 6, 2, 1, 'pilihan_ganda', 'Warna biru dicampur kuning menjadi ...', NULL, '{\"A\":\"Hijau\",\"B\":\"Merah\",\"C\":\"Coklat\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(380, 6, 2, 1, 'pilihan_ganda', 'Gerakan kelinci adalah ...', NULL, '{\"A\":\"Terbang\",\"B\":\"Melompat\",\"C\":\"Merayap\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(381, 6, 2, 1, 'pilihan_ganda', 'Bahan lunak untuk membuat patung adalah ...', NULL, '{\"A\":\"Plastisin\",\"B\":\"Batu\",\"C\":\"Kayu\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(382, 6, 2, 1, 'pilihan_ganda', 'Topi digunakan di ...', NULL, '{\"A\":\"Kaki\",\"B\":\"Tangan\",\"C\":\"Kepala\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(383, 6, 2, 1, 'pilihan_ganda', 'Baju seragam harus ...', NULL, '{\"A\":\"Kotor\",\"B\":\"Rapi\",\"C\":\"Robek\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(384, 6, 2, 1, 'pilihan_ganda', 'Suara \"Mbek mbek\" adalah suara hewan ...', NULL, '{\"A\":\"Kambing\",\"B\":\"Sapi\",\"C\":\"Ayam\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(385, 6, 2, 1, 'pilihan_ganda', 'Piano adalah alat musik ...', NULL, '{\"A\":\"Tiup\",\"B\":\"Pukul\",\"C\":\"Tekan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(386, 6, 2, 1, 'pilihan_ganda', 'Menari dilakukan dengan menggerakkan ...', NULL, '{\"A\":\"Patahan\",\"B\":\"Anggota tubuh\",\"C\":\"Alat tulis\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(387, 6, 2, 1, 'pilihan_ganda', 'Contoh benda seni rupa 3 dimensi adalah ...', NULL, '{\"A\":\"Patung\",\"B\":\"Foto\",\"C\":\"Lukisan\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(388, 6, 2, 1, 'pilihan_ganda', 'Boneka biasanya terbuat dari ...', NULL, '{\"A\":\"Besi\",\"B\":\"Kertas\",\"C\":\"Kain\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(389, 6, 2, 1, 'pilihan_ganda', 'Origami adalah seni melipat ...', NULL, '{\"A\":\"Kain\",\"B\":\"Kertas\",\"C\":\"Plastik\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(390, 6, 2, 1, 'pilihan_ganda', 'Daun kering berwarna ...', NULL, '{\"A\":\"Coklat\",\"B\":\"Hijau\",\"C\":\"Biru\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(391, 6, 2, 1, 'pilihan_ganda', 'Kolase dibuat dengan cara ...', NULL, '{\"A\":\"Melukis\",\"B\":\"Menempel\",\"C\":\"Memahat\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(392, 6, 2, 1, 'pilihan_ganda', 'Lem berguna untuk ...', NULL, '{\"A\":\"Merekatkan\",\"B\":\"Memotong\",\"C\":\"Mewarnai\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(393, 6, 2, 1, 'pilihan_ganda', 'Gunting digunakan untuk ...', NULL, '{\"A\":\"Menulis\",\"B\":\"Menempel\",\"C\":\"Memotong\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(394, 6, 2, 1, 'pilihan_ganda', 'Gambar matahari bentuknya ...', NULL, '{\"A\":\"Kotak\",\"B\":\"Bulat\",\"C\":\"Segitiga\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(395, 6, 2, 1, 'pilihan_ganda', 'Lagu \"Indonesia Raya\" dinyanyikan saat ...', NULL, '{\"A\":\"Tidur\",\"B\":\"Upacara\",\"C\":\"Makan\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(396, 6, 2, 1, 'pilihan_ganda', 'Gerakan kupu-kupu terbang menggunakan ...', NULL, '{\"A\":\"Sayap\",\"B\":\"Kaki\",\"C\":\"Ekor\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(397, 6, 2, 1, 'pilihan_ganda', 'Suara orang menyanyi disebut ...', NULL, '{\"A\":\"Musik\",\"B\":\"Nada\",\"C\":\"Vokal\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(398, 6, 2, 1, 'pilihan_ganda', 'Lagu \"Kasih Ibu\" diciptakan untuk ...', NULL, '{\"A\":\"Ayah\",\"B\":\"Ibu\",\"C\":\"Kakak\"}', 'B', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(399, 6, 2, 1, 'pilihan_ganda', 'Senam irama diiringi dengan ...', NULL, '{\"A\":\"Musik\",\"B\":\"Tangisan\",\"C\":\"Marah\"}', 'A', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(400, 6, 2, 1, 'pilihan_ganda', 'Gambar imajinasi dibuat berdasarkan ...', NULL, '{\"A\":\"Contoh\",\"B\":\"Jiplakan\",\"C\":\"Khayalan\"}', 'C', 2, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(401, 6, 2, 1, 'essay', 'Sebutkan 3 warna pelangi!', NULL, NULL, 'Merah, Kuning, Hijau (Mejikuhibiniu)', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(402, 6, 2, 1, 'essay', 'Apa alat untuk memotong kertas?', NULL, NULL, 'Gunting', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(403, 6, 2, 1, 'essay', 'Tirukan bunyi kucing!', NULL, NULL, 'Meong', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(404, 6, 2, 1, 'essay', 'Lengkapilan lirik ini: Balonku ada ...', NULL, NULL, 'Lima', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(405, 6, 2, 1, 'essay', 'Sebutkan bahan alam untuk kerajinan!', NULL, NULL, 'Daun, Biji-bijian, Tanah Liat, Batu', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(406, 6, 2, 1, 'essay', 'Apa gunanya pensil warna?', NULL, NULL, 'Mewarnai gambar', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(407, 6, 2, 1, 'essay', 'Patung adalah karya seni ... dimensi.', NULL, NULL, '3 / Tiga', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(408, 6, 2, 1, 'essay', 'Lukisan adalah karya seni ... dimensi.', NULL, NULL, '2 / Dua', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(409, 6, 2, 1, 'essay', 'Bagaimana bunyi tepuk tangan?', NULL, NULL, 'Prok prok prok', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(410, 6, 2, 1, 'essay', 'Apa warna buah apel?', NULL, NULL, 'Merah / Hijau', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(411, 6, 2, 1, 'essay', 'Menari menggerakkan ...', NULL, NULL, 'Badan / Tubuh', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(412, 6, 2, 1, 'essay', 'Sebutkan satu judul lagu anak-anak!', NULL, NULL, 'Balonku / Bintang Kecil / Pelangi / dll', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(413, 6, 2, 1, 'essay', 'Angklung berasal dari daerah ...', NULL, NULL, 'Jawa Barat / Sunda', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(414, 6, 2, 1, 'essay', 'Bahan untuk membuat perahu mainan kertas adalah ...', NULL, NULL, 'Kertas', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(415, 6, 2, 1, 'essay', 'Apa yang digunakan untuk menempel kertas?', NULL, NULL, 'Lem', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(416, 6, 2, 1, 'essay', 'Sebutkan warna bendera kita!', NULL, NULL, 'Merah dan Putih', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(417, 6, 2, 1, 'essay', 'Gitar dimainkan dengan cara ...', NULL, NULL, 'Dipetik', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(418, 6, 2, 1, 'essay', 'Apa warna langit saat malam?', NULL, NULL, 'Hitam / Gelap', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(419, 6, 2, 1, 'essay', 'Sebutkan benda berbentuk bulat!', NULL, NULL, 'Bola / Kelereng / Buah Jeruk', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(420, 6, 2, 1, 'essay', 'Bunyi petir termasuk bunyi ... (alam/buatan)', NULL, NULL, 'Alam', 5, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(421, 15, 12, 3, 'pilihan_ganda', 'Siapa saya', NULL, '{\"A\":\"Fariz\",\"B\":\"Tatang\",\"C\":\"Muzaid\",\"D\":\"Warno\",\"E\":\"Karno\"}', 'A', 1, '2026-01-03 06:40:19', '2026-01-03 06:40:19');

-- --------------------------------------------------------

--
-- Table structure for table `ujians`
--

CREATE TABLE `ujians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `rombel_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis` enum('ulangan_harian','uts','uas','try_out') NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `durasi` int(11) NOT NULL,
  `acak_soal` tinyint(1) NOT NULL DEFAULT 0,
  `acak_opsi` tinyint(1) NOT NULL DEFAULT 0,
  `tampil_nilai` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('draft','published','ongoing','finished') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujians`
--

INSERT INTO `ujians` (`id`, `guru_id`, `pelajaran_id`, `rombel_id`, `judul`, `deskripsi`, `jenis`, `waktu_mulai`, `waktu_selesai`, `durasi`, `acak_soal`, `acak_opsi`, `tampil_nilai`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 15, 2, 'IPA', 'UTS', 'uts', '2026-01-03 14:30:00', '2026-01-04 13:30:00', 60, 1, 0, 1, 'published', '2026-01-03 06:30:57', '2026-01-03 06:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_soal`
--

CREATE TABLE `ujian_soal` (
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ujian_soal`
--

INSERT INTO `ujian_soal` (`ujian_id`, `soal_id`, `urutan`) VALUES
(1, 421, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `sekolah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `sekolah_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'superadmin@cbt.com', NULL, '$2y$12$.dL6gr6PPeCddMquZ6wV2usLRtB4/nntgm2xumEtB1I0/GHi2X63K', 'super_admin', NULL, 1, NULL, '2026-01-03 04:29:43', '2026-01-03 04:29:43'),
(2, 'Admin MI Nurul Huda', 'admin@minurulhuda.com', NULL, '$2y$12$2e/qRYeUlxmYUqcrit7/a.8O3JX0xF1XAgRAP4za.S4uRpQ9FM/YC', 'admin', 1, 1, NULL, '2026-01-03 04:29:43', '2026-01-03 04:29:43'),
(3, 'Admin MI Al-Ikhlas', 'admin@mialikhlas.com', NULL, '$2y$12$bQ4iT3xAhTRlgbVUu5kfAefdUEI3HtKJDwJZzebx2LEvT8MwiYTQe', 'admin', 2, 1, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(4, 'H. Ahmad Syafii, S.Pd.I', 'kamad@madrasah.com', NULL, '$2y$12$P7mN.aLrkAPCD4Pm.e2.xO60cRmDdW8eg/V4jMQgqba9vt.grkvJy', 'guru', 1, 1, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(5, 'Siti Fatimah, S.Pd', 'guru.kelas1@madrasah.com', NULL, '$2y$12$hZuxgPsxrTlMup65orofmO7pUglK9yIsx52nx6OAF7wX5g94P8GzK', 'guru', 1, 1, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(6, 'Ahmad Rizki, S.Pd', 'guru.kelas2@madrasah.com', NULL, '$2y$12$nJFVluKmMwTmEu77sibqb.tcBSzqOgHqd8ypBtYWnnOLmq78G1M1q', 'guru', 1, 1, NULL, '2026-01-03 04:29:44', '2026-01-03 04:29:44'),
(7, 'Nurul Hidayah, S.Pd', 'guru.kelas3@madrasah.com', NULL, '$2y$12$gg6ENIzQOJteNatSDKvOh.PG9onnEt0jXSDma0g.cGKWBTyQIgfTO', 'guru', 1, 1, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(8, 'Muhammad Iqbal, S.Pd', 'guru.kelas4@madrasah.com', NULL, '$2y$12$pgx63C5qtY4ylTXAD0pUkur8DEy2KaTg04MWS.aUWI7y37XM3W6f2', 'guru', 1, 1, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(9, 'Dewi Rahmawati, S.Pd', 'guru.kelas5@madrasah.com', NULL, '$2y$12$ka71qGQP0Cv9pQ2wd/JIJe8Q2.VBcvIEkZp1EgLb44TXLmGl56iYG', 'guru', 1, 1, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(10, 'Hasan Abdullah, S.Pd', 'guru.kelas6@madrasah.com', NULL, '$2y$12$pXUNwg0jTD9uELjgkN6rVuoUxC6wQ7GzO.awMUtj/9pt8jg2oQWqO', 'guru', 1, 1, NULL, '2026-01-03 04:29:45', '2026-01-03 04:29:45'),
(11, 'Ustadz Mahmud, S.Ag', 'guru.agama@madrasah.com', NULL, '$2y$12$SU.cZn.0dDjHAsvTqrAjGuzgja8sTe1Q2hTZsAzNERxblxgo6daKm', 'guru', 1, 1, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(12, 'Ibu Kartini, S.Pd', 'guru.bahasa@madrasah.com', NULL, '$2y$12$vTX2PfLRplbJRSzcgC34o.C6OmDUnI4ZdtKcDbwCNcF1I2dOrS.1G', 'guru', 1, 1, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(13, 'Pak Budi Santoso, S.Pd', 'guru.olahraga@madrasah.com', NULL, '$2y$12$vhBlKTGMAhrFH5lJ0UdrqOx2xaTNy.Z6WKlRjWgOrPkfMvwxlT/se', 'guru', 1, 1, NULL, '2026-01-03 04:29:46', '2026-01-03 04:29:46'),
(14, 'Ahmad Fauzi', 'siswa1@madrasah.com', NULL, '$2y$12$lISUgbnoxpOFQWhrrpQEVePXyqM/qMS9EvDo8J3lKBVEhNSnvFvuO', 'siswa', 1, 1, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(15, 'Siti Aisyah', 'siswa2@madrasah.com', NULL, '$2y$12$MoyyonOmNrmbEv2SiRz1SuWpLzjgKUZCLfHx9w3dxlUp20soIQ8Mq', 'siswa', 1, 1, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(16, 'Muhammad Rizky', 'siswa3@madrasah.com', NULL, '$2y$12$.e6/YZszJbTnun84btCw...a61P0JICAlFEs6Lm9pq850xaV58LGW', 'siswa', 1, 1, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(17, 'Fatimah Azzahra', 'siswa4@madrasah.com', NULL, '$2y$12$SiSXrjqALcG8T9wAotFNsuxcUL3cvHB0jLHXeoM35ulg4eEcPVjEq', 'siswa', 1, 1, NULL, '2026-01-03 04:29:47', '2026-01-03 04:29:47'),
(18, 'Abdul Rahman', 'siswa5@madrasah.com', NULL, '$2y$12$qUOGqkMONnNG2OBZ5bZpI.DpRCatjcnWv0r89vR5XnaGTjsJ/JQyK', 'siswa', 1, 1, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(19, 'Khadijah Putri', 'siswa6@madrasah.com', NULL, '$2y$12$hpDL9fdMJpYdshI.jI67iuQwmN9sldo/CFDPtyTeGsRzB7any4/lC', 'siswa', 1, 1, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(20, 'Umar Faruq', 'siswa7@madrasah.com', NULL, '$2y$12$dzbQ8Hn.I2.c.0ZlDU6DDOVdJWA.eBgWG3ursW/Ee8XeDmSW/fQZO', 'siswa', 1, 1, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(21, 'Zainab Maulida', 'siswa8@madrasah.com', NULL, '$2y$12$GQNViwG4i3i74lfx3P5V6OmQh0j8KDeDgVrobZuU22qhWI5T/cCXe', 'siswa', 1, 1, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(22, 'Ali Imran', 'siswa9@madrasah.com', NULL, '$2y$12$qxrTUrIK36HxWK4VC/4BKuA62CSHKXCKxVmAf2mOvaS9aA.vVBiLm', 'siswa', 1, 1, NULL, '2026-01-03 04:29:48', '2026-01-03 04:29:48'),
(23, 'Maryam Sholihah', 'siswa10@madrasah.com', NULL, '$2y$12$nYYbM4ERqKu9y7.dsspebedpR1e/GE0Y9pYlPlMoP1XZgzEzKeNim', 'siswa', 1, 1, NULL, '2026-01-03 04:29:49', '2026-01-03 04:29:49'),
(24, 'Tatang', 'tatang@gmail.com', NULL, '$2y$12$cDWorWWmSbv/HiRXizaCrezyMNDJbWjnbZae/QMqYg5.0Z8/VsZuK', 'siswa', 2, 1, NULL, '2026-01-03 04:43:14', '2026-01-03 04:43:14'),
(25, 'ujang', 'ujang@gmail.com', NULL, '$2y$12$gY5JT00pzqKNbc8s08LQs.U0aQpNUeC8hb.haZtRjaZNZjoMRfbVS', 'guru', 2, 1, NULL, '2026-01-03 04:43:45', '2026-01-03 04:43:45'),
(26, 'jhon doe', 'jhon@gmail.com', NULL, '$2y$12$82hBz6B3H8BjBYsxa/MZSOdkZsC6zz3.eWDnImFFdAZXBkyfAw9qK', 'siswa', NULL, 1, NULL, '2026-01-03 04:56:35', '2026-01-03 04:56:35'),
(27, 'Widiwati S.Pd', 'widiawati@gmail.com', NULL, '$2y$12$Xvlp2Zr62NzbEHObDkXDqugl5jd.xVW8SayCr.fmqtVWSj8VH6raW', 'admin', 3, 1, NULL, '2026-01-03 05:39:01', '2026-01-03 05:39:01'),
(28, 'Fidiawati', 'fidiawati@gmail.com', NULL, '$2y$12$x2cia.KLYfQgEHs8uvdjhOxwFRS9KjqkQtnUzNfvmUhwWkgfUmd.a', 'guru', 3, 1, NULL, '2026-01-03 05:39:59', '2026-01-03 05:46:19'),
(29, 'Mikael Ellia', 'nataliefariz69@gmail.com', NULL, '$2y$12$rewoSB2qOav7QhpNhOkjVOvtY66OuU9AdgS9/FeRShC3dke02Wwae', 'siswa', 3, 1, NULL, '2026-01-03 05:56:50', '2026-01-03 05:56:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_nip_unique` (`nip`),
  ADD KEY `gurus_user_id_foreign` (`user_id`),
  ADD KEY `gurus_sekolah_id_foreign` (`sekolah_id`);

--
-- Indexes for table `hasil_ujians`
--
ALTER TABLE `hasil_ujians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_ujians_ujian_id_foreign` (`ujian_id`),
  ADD KEY `hasil_ujians_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `jawaban_siswas`
--
ALTER TABLE `jawaban_siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_siswas_hasil_ujian_id_foreign` (`hasil_ujian_id`),
  ADD KEY `jawaban_siswas_soal_id_foreign` (`soal_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_sekolah_id_foreign` (`sekolah_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelajarans`
--
ALTER TABLE `pelajarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelajarans_sekolah_id_foreign` (`sekolah_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rombels`
--
ALTER TABLE `rombels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rombels_kelas_id_foreign` (`kelas_id`),
  ADD KEY `rombels_wali_kelas_id_foreign` (`wali_kelas_id`),
  ADD KEY `rombels_sekolah_id_foreign` (`sekolah_id`);

--
-- Indexes for table `rombel_pelajaran`
--
ALTER TABLE `rombel_pelajaran`
  ADD PRIMARY KEY (`rombel_id`,`pelajaran_id`),
  ADD KEY `rombel_pelajaran_pelajaran_id_foreign` (`pelajaran_id`),
  ADD KEY `rombel_pelajaran_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `rombel_siswa`
--
ALTER TABLE `rombel_siswa`
  ADD PRIMARY KEY (`rombel_id`,`siswa_id`),
  ADD KEY `rombel_siswa_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `sekolahs`
--
ALTER TABLE `sekolahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sekolahs_nsm_unique` (`nsm`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_nisn_unique` (`nisn`),
  ADD KEY `siswas_user_id_foreign` (`user_id`),
  ADD KEY `siswas_kelas_id_foreign` (`kelas_id`),
  ADD KEY `siswas_sekolah_id_foreign` (`sekolah_id`);

--
-- Indexes for table `soals`
--
ALTER TABLE `soals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soals_pelajaran_id_foreign` (`pelajaran_id`),
  ADD KEY `soals_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `ujians`
--
ALTER TABLE `ujians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujians_guru_id_foreign` (`guru_id`),
  ADD KEY `ujians_pelajaran_id_foreign` (`pelajaran_id`),
  ADD KEY `ujians_rombel_id_foreign` (`rombel_id`);

--
-- Indexes for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD PRIMARY KEY (`ujian_id`,`soal_id`),
  ADD KEY `ujian_soal_soal_id_foreign` (`soal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_sekolah_id_foreign` (`sekolah_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hasil_ujians`
--
ALTER TABLE `hasil_ujians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jawaban_siswas`
--
ALTER TABLE `jawaban_siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pelajarans`
--
ALTER TABLE `pelajarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rombels`
--
ALTER TABLE `rombels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sekolahs`
--
ALTER TABLE `sekolahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `soals`
--
ALTER TABLE `soals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `ujians`
--
ALTER TABLE `ujians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_ujians`
--
ALTER TABLE `hasil_ujians`
  ADD CONSTRAINT `hasil_ujians_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_ujians_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jawaban_siswas`
--
ALTER TABLE `jawaban_siswas`
  ADD CONSTRAINT `jawaban_siswas_hasil_ujian_id_foreign` FOREIGN KEY (`hasil_ujian_id`) REFERENCES `hasil_ujians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_siswas_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelajarans`
--
ALTER TABLE `pelajarans`
  ADD CONSTRAINT `pelajarans_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rombels`
--
ALTER TABLE `rombels`
  ADD CONSTRAINT `rombels_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombels_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombels_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `gurus` (`id`);

--
-- Constraints for table `rombel_pelajaran`
--
ALTER TABLE `rombel_pelajaran`
  ADD CONSTRAINT `rombel_pelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombel_pelajaran_pelajaran_id_foreign` FOREIGN KEY (`pelajaran_id`) REFERENCES `pelajarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombel_pelajaran_rombel_id_foreign` FOREIGN KEY (`rombel_id`) REFERENCES `rombels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rombel_siswa`
--
ALTER TABLE `rombel_siswa`
  ADD CONSTRAINT `rombel_siswa_rombel_id_foreign` FOREIGN KEY (`rombel_id`) REFERENCES `rombels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rombel_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswas_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `soals`
--
ALTER TABLE `soals`
  ADD CONSTRAINT `soals_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `soals_pelajaran_id_foreign` FOREIGN KEY (`pelajaran_id`) REFERENCES `pelajarans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujians`
--
ALTER TABLE `ujians`
  ADD CONSTRAINT `ujians_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujians_pelajaran_id_foreign` FOREIGN KEY (`pelajaran_id`) REFERENCES `pelajarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujians_rombel_id_foreign` FOREIGN KEY (`rombel_id`) REFERENCES `rombels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `ujian_soal_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_soal_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolahs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
