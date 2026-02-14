-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Feb 2026 pada 14.41
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

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
-- Struktur dari tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_diminta` date DEFAULT NULL,
  `jam_diminta` time DEFAULT NULL,
  `keluhan` varchar(255) DEFAULT NULL,
  `tanggal_dikonfirmasi` date DEFAULT NULL,
  `jam_dikonfirmasi` time DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `tanggal_diminta`, `jam_diminta`, `keluhan`, `tanggal_dikonfirmasi`, `jam_dikonfirmasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, '2026-02-02', '09:00:00', 'Tambal gigi', '2026-02-02', '09:00:00', 'approved', '2026-02-01 17:04:22', '2026-02-02 09:02:15'),
(2, 13, '2026-02-02', '10:00:00', 'Cabut gigi depan', NULL, NULL, 'pending', '2026-02-01 17:04:22', '2026-02-01 17:04:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `keluhan` varchar(255) DEFAULT NULL,
  `alergi` varchar(255) DEFAULT NULL,
  `riwayat_penyakit` varchar(255) DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `resep_obat` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `medical_records`
--

INSERT INTO `medical_records` (`id`, `no_rm`, `patient_id`, `dokter_id`, `nama_pasien`, `alamat`, `tanggal_masuk`, `keluhan`, `alergi`, `riwayat_penyakit`, `diagnosa`, `tindakan`, `resep_obat`, `catatan`, `created_at`, `updated_at`) VALUES
(1, '01235', 1, NULL, 'Ahmad Ridho Hidayat', 'Jl. Almuslihun', '2025-05-11', 'Cabut gigi depan', NULL, 'Hipertensi', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '02446', 2, 2, 'Nurulia Octaviana', 'Jl. Pramuka', '2025-05-23', 'Tambal gigi', NULL, 'Hipertensi', 'karier gigi molar kanan', 'penamblan komposit', 'Amoxicillin 500mg 3x1', 'jika terasa nyeri silahkan datang lagi dan membuat janji temu', NULL, '2026-02-02 21:31:50'),
(3, '03478', 3, NULL, 'Sri Mulyani Adha', 'Jl. Wonosari', '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '09884', 4, NULL, 'Famela Oktavianda', 'Jl. Pramuka', '2025-05-16', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '05794', 5, NULL, 'Sandy Mulia Kesuma', 'Jl. Almuslihun', '2025-02-14', 'Cabut gigi graham', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '06432', 6, NULL, 'Ahmed Fadlu', 'Jl. Pramuka', '2025-05-11', 'Cabut gigi depan', NULL, 'Diabetes', NULL, NULL, NULL, NULL, NULL, NULL),
(7, '07894', 7, NULL, 'Arif Rahman', 'Jl. Air Putih', '2025-05-11', 'Scalling gigi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '08937', 8, NULL, 'Muhammad Yusri', 'Jl. Pramuka', '2025-05-16', 'Tambal gigi', 'Obat pennicilin', 'Hipertensi', NULL, NULL, NULL, NULL, NULL, NULL),
(9, '09937', 9, NULL, 'Kharis Ramadhani', 'Jl. Pertanian', '2025-02-14', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '01294', 10, NULL, 'Susi Salina', 'Jl. Pramuka', '2025-04-11', 'Scalling + tambal gigi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '01123', 11, NULL, 'Nuryanti', 'Jl. Pramuka', '2025-05-23', 'Cabut gigi depan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '01236', 15, NULL, 'Asridayati', 'Jl.pramuka', '2026-02-09', 'Tambal gigi', '-', 'hipertensi', NULL, NULL, NULL, NULL, '2026-02-08 20:04:57', '2026-02-08 20:04:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
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
(16, '2026_02_10_073022_add_keluhan_to_patients_table', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('terkirim','dibaca') DEFAULT 'terkirim',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `patient_id`, `jenis`, `judul`, `pesan`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 'jadwal', 'Jadwal disetujui', 'Agar datang sesuai dengan jadwal yang sudah dipilih', 'terkirim', '2026-02-01 11:31:30', '2026-02-01 11:31:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `patients`
--

INSERT INTO `patients` (`id`, `nama_lengkap`, `alamat`, `no_hp`, `email`, `username`, `password`, `keluhan`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, 'Ahmad Ridho Hidayat', 'Jl.Almuslihun', '081371261890', 'ahmadridhohidayat@gmail.com', 'ahmadridhohidayat', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(2, 'Nuraulia Octaviana', 'Jl.Pramuka', '082213457891', 'nurauliaoctaviana@gmail.com', 'nurauliaoctaviana', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(3, 'Sri Mulyani Adha', 'Jl.Wonosari', '082234689011', 'srimulyaniadha@gmail.com', 'srimulyaniadha', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(4, 'Famela Oktavianda', 'Jl.Pramuka', '082217904871', 'famelaoktavianda@gmail.com', 'famelaoktavianda', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(5, 'Sandy Mulia Kesuma', 'Jl.Almuslihun', '081394372012', 'sandymuliakesuma@gmail.com', 'sandymuliakesuma', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi graham', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(6, 'Ahmed Fadlu', 'Jl.Pramuka', '081298846021', 'ahmedfadlu@gmail.com', 'ahmedfadlu', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(7, 'Arif Rahman', 'Jl.Air Putih', '081246688012', 'arifrahman@gmail.com', 'arifrahman', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(8, 'Muhammad Yusri', 'Jl.Pramuka', '082344679031', 'muhammadyusri@gmail.com', 'muhammadyusri', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(9, 'Kharis Ramadhani', 'Jl.Pertanian', '081234689857', 'kharisramadhani@gmail.com', 'kharisramadhani', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(10, 'Susi Salina', 'Jl.Pramuka', '081322148907', 'susisalina@gmail.com', 'susisalina', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 15:49:07', '2026-02-01 15:49:07', NULL),
(11, 'Nuryanti', 'Jl.Pramuka', '082379540893', 'nuryanti@gmail.com', 'nuryanti', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-01 08:55:44', '2026-02-01 08:55:44', NULL),
(12, 'Edison Rizal', 'Jl.warung api', '082288374161', 'edisonrizal@gmail.com', 'edisonrizal', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 09:27:13', '2026-02-01 09:27:13', NULL),
(13, 'Fikri Setiawan', 'Jl.Pramuka', '0895385526705', 'fikrisetiawan@gmail.com', 'fikrisetiawan', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Tambal gigi', '2026-02-01 09:36:06', '2026-02-01 09:36:06', NULL),
(14, 'Defri Astarido', 'Jl.pangkalan batang', '082283880204', 'defriastarido@gmail.com', 'defriastarido', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Scalling + tambal gigi', '2026-02-01 09:44:29', '2026-02-01 09:44:29', NULL),
(15, 'Asridayati', 'Jl.pramuka', '081276539935', 'asridayati@gmail.com', 'asridayati', '$2y$12$9R6CwM0yHqY2Yc1f6nYx0O8yX0p0u9k8N0j9yH5sYk9C2lR8G6w3e', 'Cabut gigi depan', '2026-02-04 23:16:44', '2026-02-04 23:16:44', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `patient_auths`
--

CREATE TABLE `patient_auths` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `patient_controls`
--

CREATE TABLE `patient_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_record_id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kontrol` date NOT NULL,
  `jam_kontrol` time DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'terjadwal',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `patient_controls`
--

INSERT INTO `patient_controls` (`id`, `medical_record_id`, `dokter_id`, `tanggal_kontrol`, `jam_kontrol`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 11, 2, '2026-02-07', '16:30:00', 'terjadwal', NULL, '2026-02-07 07:27:09', '2026-02-07 07:27:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `patient_notifications`
--

CREATE TABLE `patient_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `patient_notifications`
--

INSERT INTO `patient_notifications` (`id`, `patient_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jadwal Janji Temu Disetujui', 'Janji temu Anda disetujui pada 2026-02-02 pukul 09:00.', 0, '2026-02-02 09:02:15', '2026-02-02 09:02:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_visits`
--

CREATE TABLE `report_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filters` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `report_visits`
--

INSERT INTO `report_visits` (`id`, `filters`, `file_path`, `created_at`, `updated_at`) VALUES
(1, '{\"from\":null,\"to\":null,\"nama\":null,\"keluhan\":null,\"riwayat\":null}', 'reports/laporan_kunjungan_20260207_144434.csv', '2026-02-07 07:44:35', '2026-02-07 07:44:35'),
(2, '{\"from\":null,\"to\":null,\"nama\":null,\"keluhan\":null,\"riwayat\":null}', 'reports/laporan_kunjungan_20260207_144444.csv', '2026-02-07 07:44:44', '2026-02-07 07:44:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `treatment_plans`
--

CREATE TABLE `treatment_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_record_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_rencana` date DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `rencana` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('draft','selesai') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `treatment_plans`
--

INSERT INTO `treatment_plans` (`id`, `medical_record_id`, `patient_id`, `dokter_id`, `tanggal_rencana`, `judul`, `rencana`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 11, 2, '2026-02-07', 'rencana tahapan tambal gigi tahap 1', 'melakukan tambalan gigi tahap 1', NULL, 'draft', '2026-02-07 07:26:32', '2026-02-07 07:26:32'),
(2, 11, 11, 2, '2026-02-07', 'rencana tahapan tambal gigi tahap 1', 'rencana tambal gigi tahap 1', NULL, 'selesai', '2026-02-07 07:41:51', '2026-02-07 07:41:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@klinik.com', NULL, '$2y$12$bJ5PveyHrlNrS8nrtBxxqu9wA/v09LsEJm8LniPTtj7klJ57jFg/W', 'admin', NULL, '2026-02-01 13:38:15', '2026-02-01 06:55:51'),
(2, 'Dokter', 'dokter@klinik.com', NULL, '$2y$12$BFpq4QKy6QwBOXf2CBKhvugpgDskGY6PakkiPgs.1LtPNOUcWOuFe', 'dokter', NULL, '2026-02-02 07:03:01', '2026-02-02 00:10:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visit_reports`
--

CREATE TABLE `visit_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `keluhan` varchar(255) DEFAULT NULL,
  `riwayat_penyakit` varchar(255) DEFAULT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visit_reports`
--

INSERT INTO `visit_reports` (`id`, `user_id`, `from_date`, `to_date`, `nama_pasien`, `keluhan`, `riwayat_penyakit`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 11, '2026-02-07 08:41:47', '2026-02-07 08:41:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visit_report_items`
--

CREATE TABLE `visit_report_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visit_report_id` bigint(20) UNSIGNED NOT NULL,
  `medical_record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_rm` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `keluhan` varchar(255) DEFAULT NULL,
  `alergi` varchar(255) DEFAULT NULL,
  `riwayat_penyakit` varchar(255) DEFAULT NULL,
  `rencana_perawatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visit_report_items`
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
(11, 1, 9, '09937', 'Kharis Ramadhani', 'Jl. Pertanian', '2025-02-14', 'Cabut gigi depan', NULL, NULL, NULL, '2026-02-07 08:41:47', '2026-02-07 08:41:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_records_no_rm_unique` (`no_rm`),
  ADD KEY `medical_records_patient_id_index` (`patient_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `patient_auths`
--
ALTER TABLE `patient_auths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_auths_no_hp_unique` (`no_hp`),
  ADD UNIQUE KEY `patient_auths_email_unique` (`email`),
  ADD UNIQUE KEY `patient_auths_username_unique` (`username`);

--
-- Indeks untuk tabel `patient_controls`
--
ALTER TABLE `patient_controls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_controls_medical_record_id_foreign` (`medical_record_id`),
  ADD KEY `patient_controls_dokter_id_foreign` (`dokter_id`);

--
-- Indeks untuk tabel `patient_notifications`
--
ALTER TABLE `patient_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indeks untuk tabel `report_visits`
--
ALTER TABLE `report_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_plans_medical_record_id_foreign` (`medical_record_id`),
  ADD KEY `treatment_plans_patient_id_foreign` (`patient_id`),
  ADD KEY `treatment_plans_dokter_id_foreign` (`dokter_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `visit_reports`
--
ALTER TABLE `visit_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `visit_report_items`
--
ALTER TABLE `visit_report_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `patient_auths`
--
ALTER TABLE `patient_auths`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `patient_controls`
--
ALTER TABLE `patient_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `patient_notifications`
--
ALTER TABLE `patient_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `report_visits`
--
ALTER TABLE `report_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `treatment_plans`
--
ALTER TABLE `treatment_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `visit_reports`
--
ALTER TABLE `visit_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `visit_report_items`
--
ALTER TABLE `visit_report_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `patient_controls`
--
ALTER TABLE `patient_controls`
  ADD CONSTRAINT `patient_controls_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_controls_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `treatment_plans`
--
ALTER TABLE `treatment_plans`
  ADD CONSTRAINT `treatment_plans_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_plans_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_plans_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
