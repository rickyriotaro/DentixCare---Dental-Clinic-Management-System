-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2026 at 06:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_dokter_gigi`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `tanggal_diminta` date DEFAULT NULL,
  `jam_diminta` time DEFAULT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_dikonfirmasi` date DEFAULT NULL,
  `jam_dikonfirmasi` time DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `tanggal_diminta`, `jam_diminta`, `keluhan`, `tanggal_dikonfirmasi`, `jam_dikonfirmasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, '2026-02-02', '09:00:00', 'Tambal gigi', '2026-02-02', '09:00:00', 'approved', '2026-02-01 17:04:22', '2026-02-02 09:02:15'),
(2, 13, '2026-02-02', '10:00:00', 'Cabut gigi depan', '2026-02-13', '02:01:00', 'approved', '2026-02-01 17:04:22', '2026-02-11 12:01:54'),
(3, 29, '2026-02-12', '04:22:00', 'sakit pinggang', '2026-02-12', '04:22:00', 'approved', '2026-02-11 14:22:51', '2026-02-11 14:48:54'),
(4, 29, '2026-02-12', '05:10:00', 'gigi berlubang', NULL, NULL, 'rejected', '2026-02-11 15:11:16', '2026-02-11 15:11:47'),
(5, 29, '2026-02-12', '05:00:00', 'ppp', '2026-02-13', '10:01:00', 'approved', '2026-02-11 15:12:29', '2026-02-11 15:12:56'),
(6, 29, '2026-02-18', '07:18:00', 'tolong kaki saya sakit', NULL, NULL, 'pending', '2026-02-11 17:18:32', '2026-02-11 17:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint UNSIGNED NOT NULL,
  `no_rm` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `dokter_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alergi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa` text COLLATE utf8mb4_unicode_ci,
  `tindakan` text COLLATE utf8mb4_unicode_ci,
  `resep_obat` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `no_rm`, `patient_id`, `dokter_id`, `tanggal_masuk`, `keluhan`, `alergi`, `riwayat_penyakit`, `diagnosa`, `tindakan`, `resep_obat`, `catatan`, `created_at`, `updated_at`) VALUES
(1, '01235', 1, NULL, '2025-05-11', 'Cabut gigi depan', NULL, 'Hipertensi', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '02446', 2, 2, '2025-05-23', 'Tambal gigi', NULL, 'Hipertensi', 'karier gigi molar kanan', 'penamblan komposit', 'Amoxicillin 500mg 3x1', 'jika terasa nyeri silahkan datang lagi dan membuat janji temu', NULL, '2026-02-02 21:31:50'),
(3, '03478', 3, NULL, '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '09884', 4, NULL, '2025-05-16', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '06432', 6, NULL, '2025-05-11', 'Cabut gigi depan', NULL, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(7, '07894', 7, NULL, '2025-05-11', 'Scalling gigi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '08937', 8, NULL, '2025-05-16', 'Tambal gigi', 'Obat pennicilin', 'Hipertensi', NULL, NULL, NULL, NULL, NULL, NULL),
(9, '09937', 9, NULL, '2025-02-14', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '01123', 11, NULL, '2025-05-23', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '555', 29, 2, '2026-02-13', 'saa', 'aa', 'aa', 'kakakak', 'papapa', 'lalalal', 'kekeke', '2026-02-11 12:59:31', '2026-02-11 16:07:17'),
(15, '444343', 29, NULL, '2026-02-14', 'Cabut gigi depan', 'alergi drama', 'jadi selingkuhancdgn tidak disengaja', NULL, NULL, NULL, NULL, '2026-02-11 15:58:20', '2026-02-11 15:58:20'),
(16, '97108', 29, NULL, '2026-02-11', 'uuuuuuuu', 'yyyyyyyyyy', 'iiiiiiiiiii', NULL, NULL, NULL, NULL, '2026-02-11 16:21:48', '2026-02-11 16:21:48'),
(17, '58599', 28, 2, '2026-02-12', 'meriang', 'ikan cucut', 'sawan', 'demam menggigil', 'tembak', 'racun tikus', 'sampai mampos', '2026-02-11 18:45:41', '2026-02-11 18:47:51'),
(18, '79541', 5, NULL, '2026-02-14', 'ginjal', 'oaoaoa', 'oaoaoao', NULL, NULL, NULL, NULL, '2026-02-14 10:22:02', '2026-02-14 10:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_01_151437_create_patients_table', 1),
(5, '2026_02_01_190037_create_patients_tablecreate_report_visits_table', 2),
(6, '2026_02_02_184631_create_medical_records_table', 3),
(7, '2026_02_03_050406_create_treatment_plans_table', 4),
(8, '2026_02_03_064855_create_patient_controls_table', 5),
(9, '2026_02_07_151513_create_visit_reports_table', 6),
(10, '2026_02_07_151534_create_visit_report_items_table', 6),
(11, '2026_02_09_074826_create_patient_auths_table', 7),
(14, '2026_02_09_140707_create_patient_auths_table', 8),
(15, '2026_02_10_070802_alter_patients_table_for_auth', 8),
(16, '2026_02_10_073022_add_keluhan_to_patients_table', 8),
(17, '2026_02_10_135200_create_personal_access_tokens_table', 9),
(18, '2026_02_11_195620_remove_duplicate_fields_from_medical_records', 10),
(19, '2026_02_11_200340_add_no_hp_to_notifications_table', 11),
(20, '2026_02_12_044900_fix_notifications_status_column', 12),
(21, '2026_02_11_234920_add_jam_rencana_to_treatment_plans_table', 13),
(22, '2026_02_12_002934_add_related_id_to_notifications_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `related_id` bigint UNSIGNED DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `patient_id`, `related_id`, `no_hp`, `jenis`, `judul`, `pesan`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, NULL, 'jadwal', 'Jadwal disetujui', 'Agar datang sesuai dengan jadwal yang sudah dipilih', 'terkirim', '2026-02-01 11:31:30', '2026-02-01 11:31:30'),
(2, 14, NULL, '082283880204', 'perubahan', 'aa', 'aaa', 'terkirim', '2026-02-11 13:05:31', '2026-02-11 13:05:31'),
(4, 29, NULL, '44444', 'appointment', 'Jadwal Janji Temu Disetujui', 'Janji temu Anda disetujui pada 2026-02-13 pukul 10:01.', 'read', '2026-02-11 15:12:56', '2026-02-11 15:27:11'),
(5, 29, NULL, NULL, 'rencana_perawatan', 'Rencana Perawatan Baru', 'Dokter telah membuat rencana perawatan untuk Anda: ututut', 'read', '2026-02-11 16:39:08', '2026-02-11 16:42:12'),
(6, 29, NULL, NULL, 'rencana_perawatan', 'Rencana Perawatan Baru', 'Dokter telah membuat rencana perawatan untuk Anda: tes aja', 'read', '2026-02-11 16:40:22', '2026-02-11 17:32:04'),
(7, 29, NULL, NULL, 'rencana_perawatan', 'Rencana Perawatan Baru', 'Dokter telah membuat rencana perawatan untuk Anda: saa', 'read', '2026-02-11 16:41:57', '2026-02-11 17:32:07'),
(8, 29, NULL, NULL, 'rencana_perawatan', 'Rencana Perawatan Baru', 'Dokter telah membuat rencana perawatan untuk Anda: datang woyy', 'unread', '2026-02-11 16:53:33', '2026-02-11 16:53:33'),
(9, 29, NULL, NULL, 'rencana_perawatan', 'Rencana Perawatan Selesai', 'Rencana perawatan \"datang woyy\" telah selesai dilaksanakan.', 'unread', '2026-02-11 17:26:09', '2026-02-11 17:26:09'),
(10, 29, 9, NULL, 'rencana_perawatan', 'Rencana Perawatan Baru', 'Dokter telah membuat rencana perawatan untuk Anda: wowowoow', 'read', '2026-02-11 17:33:25', '2026-02-11 17:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `nama_lengkap`, `alamat`, `no_hp`, `email`, `username`, `password`, `keluhan`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, 'Ahmad Ridho Hidayat', 'Jl.Almuslihun', '081371261890', 'ahmadridhohidayat@gmail.com', 'ahmadridhohidayat', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(2, 'Nuraulia Octaviana', 'Jl.Pramuka', '082213457891', 'nurauliaoctaviana@gmail.com', 'nurauliaoctaviana', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(3, 'Sri Mulyani Adha', 'Jl.Wonosari', '082234689011', 'srimulyaniadha@gmail.com', 'srimulyaniadha', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(4, 'Famela Oktavianda', 'Jl.Pramuka', '082217904871', 'famelaoktavianda@gmail.com', 'famelaoktavianda', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(5, 'Sandy Mulia Kesuma', 'Jl.Almuslihun', '081394372012', 'sandymuliakesuma@gmail.com', 'sandymuliakesuma', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'ginjal', '2026-02-01 15:49:07', '2026-02-14 10:22:02', NULL),
(6, 'Ahmed Fadlu', 'Jl.Pramuka', '081298846021', 'ahmedfadlu@gmail.com', 'ahmedfadlu', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(7, 'Arif Rahman', 'Jl.Air Putih', '081246688012', 'arifrahman@gmail.com', 'arifrahman', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(8, 'Muhammad Yusri', 'Jl.Pramuka', '082344679031', 'muhammadyusri@gmail.com', 'muhammadyusri', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(10, 'Susi Salina', 'Jl.Pramuka', '081322148907', 'susisalina@gmail.com', 'susisalina', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(11, 'Nuryanti', 'Jl.Pramuka', '082379540893', 'nuryanti@gmail.com', 'nuryanti', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 08:55:44', '2026-02-01 08:55:44', NULL),
(12, 'Edison Rizal', 'Jl.warung api', '082288374161', 'edisonrizal@gmail.com', 'edisonrizal', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 09:27:13', '2026-02-01 09:27:13', NULL),
(13, 'Fikri Setiawan', 'Jl.Pramuka', '0895385526705', 'fikrisetiawan@gmail.com', 'fikrisetiawan', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 09:36:06', '2026-02-01 09:36:06', NULL),
(14, 'Defri Astarido', 'Jl.pangkalan batang', '082283880204', 'defriastarido@gmail.com', 'defriastarido', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 09:44:29', '2026-02-01 09:44:29', NULL),
(15, 'Asridayati', 'Jl.pramuka', '081276539935', 'asridayati@gmail.com', 'asridayati', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-04 23:16:44', '2026-02-04 23:16:44', NULL),
(28, 'fulanaaa', '235 West 57th Street', '01614207300', 'tesa@gmail.com', 'tes', '$2y$12$xXanjZN4ED8ejz5GXWKA0eR0FBCYee8Owy5qISkwQflZarl8duYHW', 'aaaaaa', '2026-02-11 12:22:54', '2026-02-11 12:33:47', NULL),
(29, 'kakakaka', 'tttt', '44444', 'tes1@gmail.com', 'tes1', '$2y$12$tFy5.lsWNZ6wvJB6wNbSauFkuaT1lIz/I5xTAUFhPVl056kbE1LlK', NULL, '2026-02-11 12:46:26', '2026-02-11 18:24:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_auths`
--

CREATE TABLE `patient_auths` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_auths`
--

INSERT INTO `patient_auths` (`id`, `nama_lengkap`, `alamat`, `no_hp`, `email`, `username`, `password`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'lala', 'lalal', '002020202', 'tes@gmail.com', 'tes', '$2y$12$QhhI4tHgXn8K4Zd6MeE9GOeEqa5ljhTeIQKg5dUvqslIjzqxCNyjC', NULL, '2026-02-11 11:31:37', '2026-02-11 11:31:37');

-- --------------------------------------------------------

--
-- Table structure for table `patient_controls`
--

CREATE TABLE `patient_controls` (
  `id` bigint UNSIGNED NOT NULL,
  `medical_record_id` bigint UNSIGNED NOT NULL,
  `dokter_id` bigint UNSIGNED NOT NULL,
  `tanggal_kontrol` date NOT NULL,
  `jam_kontrol` time DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'terjadwal',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_controls`
--

INSERT INTO `patient_controls` (`id`, `medical_record_id`, `dokter_id`, `tanggal_kontrol`, `jam_kontrol`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 11, 2, '2026-02-07', '16:30:00', 'terjadwal', NULL, '2026-02-07 07:27:09', '2026-02-07 07:27:09'),
(3, 15, 2, '2026-02-13', '10:00:00', 'terjadwal', 'sasasas', '2026-02-11 16:55:54', '2026-02-11 16:55:54'),
(4, 13, 2, '2026-02-14', '11:04:00', 'terjadwal', 'aaaaaaaaaaaaaaaaa', '2026-02-11 17:02:57', '2026-02-11 17:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `patient_notifications`
--

CREATE TABLE `patient_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_notifications`
--

INSERT INTO `patient_notifications` (`id`, `patient_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jadwal Janji Temu Disetujui', 'Janji temu Anda disetujui pada 2026-02-02 pukul 09:00.', 0, '2026-02-02 09:02:15', '2026-02-02 09:02:15'),
(2, 13, 'Jadwal Janji Temu Disetujui', 'Janji temu Anda disetujui pada 2026-02-13 pukul 02:01.', 0, '2026-02-11 12:01:54', '2026-02-11 12:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\PatientAuth', 1, 'patient-mobile', '188d77093591f291ec12a7bc4de074a07f5099f8db6f1c03192ce9030c1daac1', '[\"*\"]', NULL, NULL, '2026-02-11 11:42:43', '2026-02-11 11:42:43'),
(2, 'App\\Models\\Patient', 29, 'patient-mobile', '4528a29f2e475c222f0831dcc800b93d01cdf95845170663e9604dff6db36949', '[\"*\"]', NULL, NULL, '2026-02-11 12:46:54', '2026-02-11 12:46:54'),
(6, 'App\\Models\\Patient', 28, 'patient-mobile', '79af7293ff3d23e47866e70d5f60347b1716f6b5324733fe957575e9467b2ee2', '[\"*\"]', '2026-02-11 19:53:33', NULL, '2026-02-11 18:46:11', '2026-02-11 19:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `report_visits`
--

CREATE TABLE `report_visits` (
  `id` bigint UNSIGNED NOT NULL,
  `filters` longtext COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_visits`
--

INSERT INTO `report_visits` (`id`, `filters`, `file_path`, `created_at`, `updated_at`) VALUES
(1, '{\"from\":null,\"to\":null,\"nama\":null,\"keluhan\":null,\"riwayat\":null}', 'reports/laporan_kunjungan_20260207_144434.csv', '2026-02-07 07:44:35', '2026-02-07 07:44:35'),
(2, '{\"from\":null,\"to\":null,\"nama\":null,\"keluhan\":null,\"riwayat\":null}', 'reports/laporan_kunjungan_20260207_144444.csv', '2026-02-07 07:44:44', '2026-02-07 07:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_plans`
--

CREATE TABLE `treatment_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `medical_record_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `dokter_id` bigint UNSIGNED NOT NULL,
  `tanggal_rencana` date DEFAULT NULL,
  `jam_rencana` time DEFAULT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rencana` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatment_plans`
--

INSERT INTO `treatment_plans` (`id`, `medical_record_id`, `patient_id`, `dokter_id`, `tanggal_rencana`, `jam_rencana`, `judul`, `rencana`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 11, 2, '2026-02-07', NULL, 'rencana tahapan tambal gigi tahap 1', 'melakukan tambalan gigi tahap 1', NULL, 'draft', '2026-02-07 07:26:32', '2026-02-07 07:26:32'),
(2, 11, 11, 2, '2026-02-07', NULL, 'rencana tahapan tambal gigi tahap 1', 'rencana tambal gigi tahap 1', NULL, 'selesai', '2026-02-07 07:41:51', '2026-02-07 07:41:51'),
(4, 15, 29, 2, '2026-02-13', NULL, 'ututut', 'ptptptptptpt', 'dfddddddddddddddddd', 'draft', '2026-02-11 16:36:21', '2026-02-11 16:36:21'),
(5, 15, 29, 2, '2026-02-13', NULL, 'ututut', 'ptptptptptpt', 'dfddddddddddddddddd', 'draft', '2026-02-11 16:39:08', '2026-02-11 16:39:08'),
(6, 13, 29, 2, '2026-02-21', NULL, 'tes aja', 'kapan-kapan', 'aws tak datang', 'draft', '2026-02-11 16:40:22', '2026-02-11 16:40:22'),
(7, 13, 29, 2, '2026-02-15', NULL, 'saa', 'dddddddd', 'rrrrrrrr', 'draft', '2026-02-11 16:41:57', '2026-02-11 16:41:57'),
(8, 15, 29, 2, '2026-02-17', '10:59:00', 'datang woyy', 'awas kau tk datang', 'papapapa', 'selesai', '2026-02-11 16:53:33', '2026-02-11 17:26:09'),
(9, 13, 29, 2, '2026-02-17', '11:33:00', 'wowowoow', 'lalalalal', 'kakaka', 'draft', '2026-02-11 17:33:25', '2026-02-11 17:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@klinik.com', NULL, '$2y$12$bJ5PveyHrlNrS8nrtBxxqu9wA/v09LsEJm8LniPTtj7klJ57jFg/W', 'admin', NULL, '2026-02-01 13:38:15', '2026-02-01 06:55:51'),
(2, 'Dokter', 'dokter@klinik.com', NULL, '$2y$12$BFpq4QKy6QwBOXf2CBKhvugpgDskGY6PakkiPgs.1LtPNOUcWOuFe', 'dokter', NULL, '2026-02-02 07:03:01', '2026-02-02 00:10:58'),
(4, 'diktir', 'diktir@gmail.com', NULL, '$2y$12$/AgzT.k5q9lIZYpmHy50t.MxhHPckZmMoIzf0vkXpblcOd9PoBNGW', 'dokter', NULL, '2026-02-11 13:23:50', '2026-02-11 13:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `visit_reports`
--

CREATE TABLE `visit_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visit_reports`
--

INSERT INTO `visit_reports` (`id`, `user_id`, `from_date`, `to_date`, `nama_pasien`, `keluhan`, `riwayat_penyakit`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 11, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(2, 1, NULL, NULL, NULL, NULL, NULL, 10, '2026-02-11 12:11:14', '2026-02-11 12:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `visit_report_items`
--

CREATE TABLE `visit_report_items` (
  `id` bigint UNSIGNED NOT NULL,
  `visit_report_id` bigint UNSIGNED NOT NULL,
  `medical_record_id` bigint UNSIGNED DEFAULT NULL,
  `no_rm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pasien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alergi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rencana_perawatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visit_report_items`
--

INSERT INTO `visit_report_items` (`id`, `visit_report_id`, `medical_record_id`, `no_rm`, `nama_pasien`, `alamat`, `tanggal_masuk`, `keluhan`, `alergi`, `riwayat_penyakit`, `rencana_perawatan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '02446', 'Nurulia Octaviana', 'Jl. Pramuka', '2025-05-23', 'Tambal gigi', NULL, 'Hipertensi', 'penamblan komposit', '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(2, 1, 11, '01123', 'Nuryanti', 'Jl. Pramuka', '2025-05-23', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(3, 1, 4, '09884', 'Famela Oktavianda', 'Jl. Pramuka', '2025-05-16', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(4, 1, 8, '08937', 'Muhammad Yusri', 'Jl. Pramuka', '2025-05-16', 'Tambal gigi', 'Obat pennicilin', 'Hipertensi', NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(5, 1, 1, '01235', 'Ahmad Ridho Hidayat', 'Jl. Almuslihun', '2025-05-11', 'Cabut gigi depan', NULL, 'Hipertensi', NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(6, 1, 6, '06432', 'Ahmed Fadlu', 'Jl. Pramuka', '2025-05-11', 'Cabut gigi depan', NULL, 'Diabetes', NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(7, 1, 7, '07894', 'Arif Rahman', 'Jl. Air Putih', '2025-05-11', 'Scalling gigi', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(8, 1, 3, '03478', 'Sri Mulyani Adha', 'Jl. Wonosari', '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(9, 1, 10, '01294', 'Susi Salina', 'Jl. Pramuka', '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(10, 1, 5, '05794', 'Sandy Mulia Kesuma', 'Jl. Almuslihun', '2025-02-14', 'Cabut gigi graham', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(11, 1, 9, '09937', 'Kharis Ramadhani', 'Jl. Pertanian', '2025-02-14', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47'),
(12, 2, 12, '01236', 'Asridayati', 'Jl.pramuka', '2026-02-09', 'Tambal gigi', '-', 'hipertensi', NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(13, 2, 2, '02446', 'Nurulia Octaviana', 'Jl. Pramuka', '2025-05-23', 'Tambal gigi', NULL, 'Hipertensi', 'penamblan komposit', '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(14, 2, 11, '01123', 'Nuryanti', 'Jl. Pramuka', '2025-05-23', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(15, 2, 4, '09884', 'Famela Oktavianda', 'Jl. Pramuka', '2025-05-16', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(16, 2, 8, '08937', 'Muhammad Yusri', 'Jl. Pramuka', '2025-05-16', 'Tambal gigi', 'Obat pennicilin', 'Hipertensi', NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(17, 2, 1, '01235', 'Ahmad Ridho Hidayat', 'Jl. Almuslihun', '2025-05-11', 'Cabut gigi depan', NULL, 'Hipertensi', NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(18, 2, 6, '06432', 'Ahmed Fadlu', 'Jl. Pramuka', '2025-05-11', 'Cabut gigi depan', NULL, 'Diabetes', NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(19, 2, 7, '07894', 'Arif Rahman', 'Jl. Air Putih', '2025-05-11', 'Scalling gigi', NULL, NULL, NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(20, 2, 3, '03478', 'Sri Mulyani Adha', 'Jl. Wonosari', '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14'),
(21, 2, 9, '09937', 'Kharis Ramadhani', 'Jl. Pertanian', '2025-02-14', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-11 12:11:14', '2026-02-11 12:11:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_records_no_rm_unique` (`no_rm`),
  ADD KEY `medical_records_patient_id_index` (`patient_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_auths`
--
ALTER TABLE `patient_auths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_auths_no_hp_unique` (`no_hp`),
  ADD UNIQUE KEY `patient_auths_email_unique` (`email`),
  ADD UNIQUE KEY `patient_auths_username_unique` (`username`);

--
-- Indexes for table `patient_controls`
--
ALTER TABLE `patient_controls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_controls_medical_record_id_foreign` (`medical_record_id`),
  ADD KEY `patient_controls_dokter_id_foreign` (`dokter_id`);

--
-- Indexes for table `patient_notifications`
--
ALTER TABLE `patient_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `report_visits`
--
ALTER TABLE `report_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_plans_medical_record_id_foreign` (`medical_record_id`),
  ADD KEY `treatment_plans_patient_id_foreign` (`patient_id`),
  ADD KEY `treatment_plans_dokter_id_foreign` (`dokter_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visit_reports`
--
ALTER TABLE `visit_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visit_report_items`
--
ALTER TABLE `visit_report_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `patient_auths`
--
ALTER TABLE `patient_auths`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_controls`
--
ALTER TABLE `patient_controls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient_notifications`
--
ALTER TABLE `patient_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `report_visits`
--
ALTER TABLE `report_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visit_reports`
--
ALTER TABLE `visit_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visit_report_items`
--
ALTER TABLE `visit_report_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_controls`
--
ALTER TABLE `patient_controls`
  ADD CONSTRAINT `patient_controls_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_controls_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD CONSTRAINT `treatment_plans_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_plans_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_plans_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
