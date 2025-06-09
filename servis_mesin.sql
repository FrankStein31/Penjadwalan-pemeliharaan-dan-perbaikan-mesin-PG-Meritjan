-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2025 pada 12.53
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
-- Database: `servis_mesin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `damage_reports`
--

CREATE TABLE `damage_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `repair_id` bigint(20) UNSIGNED NOT NULL,
  `technician_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pemeliharaan`
--

CREATE TABLE `jadwal_pemeliharaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('rutin','incidental') NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('Terjadwal','Selesai','Dibatalkan') NOT NULL DEFAULT 'Terjadwal',
  `pertanyaan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_pemeliharaan`
--

INSERT INTO `jadwal_pemeliharaan` (`id`, `mesin_id`, `user_id`, `jenis`, `tanggal`, `deskripsi`, `status`, `pertanyaan`, `created_at`, `updated_at`) VALUES
(8, 3, 9, 'incidental', '2025-03-19', 'Rusak Gear', 'Selesai', '', '2025-03-18 11:38:21', '2025-03-19 15:09:55'),
(9, 10, 12, 'rutin', '2025-03-20', 'Rusak Total', 'Selesai', '', '2025-03-19 15:01:37', '2025-03-19 15:15:24'),
(10, 10, 12, 'incidental', '2025-03-20', 'Rusak Gear', 'Selesai', '', '2025-03-19 15:19:29', '2025-03-19 15:46:42'),
(11, 10, 12, 'rutin', '2025-03-20', 'Rusak Sebagian', 'Selesai', '', '2025-03-19 15:19:59', '2025-03-19 15:36:05'),
(12, 10, 12, 'rutin', '2025-03-20', 'Rusak', 'Selesai', '', '2025-03-19 15:50:17', '2025-03-19 15:50:33'),
(13, 10, 12, 'rutin', '2025-03-20', 'Rusak', 'Selesai', '', '2025-03-19 22:56:37', '2025-03-19 22:56:48'),
(23, 3, 9, 'rutin', '2025-04-30', 'Perbaikan rutin', 'Selesai', '', '2025-04-24 12:29:33', '2025-04-24 13:02:19'),
(38, 3, 9, 'rutin', '2025-05-25', 'Rusak Gearr', 'Selesai', '', '2025-05-22 14:00:21', '2025-06-07 12:10:56'),
(39, 3, 9, 'rutin', '2025-05-25', 'Rusak', 'Terjadwal', '', '2025-05-22 14:08:12', '2025-05-22 14:08:12'),
(41, 3, 12, 'incidental', '2025-06-07', 'Perbaikan incidental', 'Selesai', 'Apakah ada getaran berlebih?', '2025-06-07 12:20:15', '2025-06-07 12:28:56'),
(43, 10, 9, 'incidental', '2025-06-07', 'Perbaikan', 'Selesai', 'Apakah ada getaran berlebih?', '2025-06-07 12:23:31', '2025-06-07 12:28:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporanincidental`
--

CREATE TABLE `laporanincidental` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `station_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `requires_spare_part` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(50) DEFAULT 'Dalam Peninjauan',
  `spare_part_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `laporanincidental`
--

INSERT INTO `laporanincidental` (`id`, `mesin_id`, `station_id`, `description`, `photo_path`, `requires_spare_part`, `status`, `spare_part_id`, `created_at`, `updated_at`) VALUES
(7, 11, 2, 'Rusak Gear', 'laporan-insidental/5rvXsRQqYCNe4sVV5wZ9ZAv3aLB4AEVtPgt0bmE5.jpg', 1, 'Selesai', NULL, '2025-05-15 17:35:32', '2025-06-02 16:33:13'),
(8, 3, 1, 'Rusak Berat', 'laporan-insidental/1r4eDDiqB9UjxG23Wr1ZPL5N2XfuRW9cKJLvO0sC.png', 0, 'Dalam Peninjauan', NULL, '2025-06-02 16:13:15', '2025-06-09 10:43:01'),
(12, 10, 2, 'Rusak  Total', 'laporan-insidental/HDBPI0PMbmbhg2GVFnHxreCbwddcBQcnPwTYIXFe.jpg', 1, 'Selesai', 3, '2025-06-09 09:45:20', '2025-06-09 10:34:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintenance_schedules`
--

CREATE TABLE `maintenance_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` bigint(20) UNSIGNED NOT NULL,
  `technician_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_date` date NOT NULL,
  `status` enum('scheduled','completed','pending') DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesins`
--

CREATE TABLE `mesins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `station_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mesins`
--

INSERT INTO `mesins` (`id`, `nama`, `jenis`, `tahun`, `deskripsi`, `created_at`, `updated_at`, `station_id`) VALUES
(3, 'Cane Crusher', 'Mesin Penggiling Tebu', 2018, 'Menghancurkan tebu untuk mengekstrak nira (cairan tebu).', '2025-03-06 09:38:17', '2025-03-21 03:34:13', 1),
(10, 'Milling Tandem', 'Mesin Pemeras Tebu', 2013, 'Memeras tebu lebih lanjut untuk mendapatkan hasil maksimal.', '2025-03-17 06:48:17', '2025-03-21 03:53:11', 2),
(11, 'Juice Heater', 'Mesin Pemeras Nira', 2011, 'Meningkatkan suhu nira untuk proses pemurnian.', '2025-03-17 06:49:42', '2025-03-21 04:25:04', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin_spare_part`
--

CREATE TABLE `mesin_spare_part` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `spare_part_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mesin_spare_part`
--

INSERT INTO `mesin_spare_part` (`id`, `mesin_id`, `spare_part_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(2, 10, 3, 10, '2025-03-18 09:07:33', '2025-03-18 09:07:33');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_03_06_132826_create_mesins_table', 2),
(3, '2025_03_13_195304_create_repair_assignments_table', 3),
(4, '2025_03_13_201112_create_tugas_perbaikans_table', 4),
(5, '2025_03_18_134928_create_spare_parts_table', 5),
(6, '2025_03_18_134930_create_mesin_spare_part_table', 6),
(7, '2025_03_18_201834_create_screenings_table', 7),
(8, '2025_03_20_165644_create_stations_table', 8),
(9, '2025_03_20_172842_add_station_id_to_mesins_table', 8),
(10, '2025_03_20_174818_add_station_id_to_users_table', 8),
(16, '2025_05_16_023403_create_table_pasca_giling', 9),
(17, '2025_05_23_004430_add_jadwal_id_to_screenings_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasca_gilings`
--

CREATE TABLE `pasca_gilings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `station_id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('Terjadwal','Selesai','Dibatalkan') NOT NULL DEFAULT 'Terjadwal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasca_gilings`
--

INSERT INTO `pasca_gilings` (`id`, `station_id`, `mesin_id`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 3, '2025-05-16', '2025-05-30', 'Giling', 'Terjadwal', '2025-05-15 21:08:52', '2025-05-15 21:08:52'),
(3, 1, NULL, '2025-06-03', NULL, 'Baru', 'Terjadwal', '2025-06-03 14:32:52', '2025-06-03 14:32:52'),
(4, 1, NULL, '2025-06-03', '2025-06-13', 'Penjadwalan', 'Terjadwal', '2025-06-03 14:34:49', '2025-06-03 14:34:49'),
(5, 2, NULL, '2025-06-03', NULL, 'Baru', 'Terjadwal', '2025-06-03 14:35:23', '2025-06-03 14:35:23'),
(6, 2, NULL, '2025-06-03', NULL, 'Baru', 'Terjadwal', '2025-06-03 14:36:51', '2025-06-03 14:36:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_pemeliharaan_id` bigint(20) UNSIGNED NOT NULL,
  `getaran` varchar(255) NOT NULL,
  `suara` varchar(255) NOT NULL,
  `pelumasan` varchar(255) NOT NULL,
  `bocor` varchar(255) NOT NULL,
  `kerusakan` varchar(255) NOT NULL,
  `tindakan` varchar(255) NOT NULL,
  `komponen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id`, `jadwal_pemeliharaan_id`, `getaran`, `suara`, `pelumasan`, `bocor`, `kerusakan`, `tindakan`, `komponen`, `created_at`, `updated_at`) VALUES
(8, 39, 'Ya', 'Ya', 'Ya', 'Ya', 'Ya', 'Pergantian Komponen', 'Roll gilingan (001)', '2025-06-08 17:44:49', '2025-06-08 17:44:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `repairs`
--

CREATE TABLE `repairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` bigint(20) UNSIGNED NOT NULL,
  `technician_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `repair_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `repair_assignments`
--

CREATE TABLE `repair_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` datetime NOT NULL,
  `status` enum('dijadwalkan','sedang dikerjakan','selesai') NOT NULL DEFAULT 'dijadwalkan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_parts`
--

CREATE TABLE `request_parts` (
  `id` bigint(20) NOT NULL,
  `teknisi_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `mesin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `spare_part_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `request_parts`
--

INSERT INTO `request_parts` (`id`, `teknisi_id`, `jumlah`, `keterangan`, `status`, `created_at`, `updated_at`, `mesin_id`, `spare_part_id`) VALUES
(9, 9, 5, 'Baru', 'Ditolak', '2025-06-02 22:40:49', '2025-06-02 22:41:37', 3, 3),
(10, 9, 6, 'Lama', 'Disetujui', '2025-06-02 22:41:30', '2025-06-02 22:41:44', 11, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `screenings`
--

CREATE TABLE `screenings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `teknisi_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `status_operasional` enum('Normal','Tidak Normal') NOT NULL,
  `kode_error` varchar(255) DEFAULT NULL,
  `suara_anomali` tinyint(1) NOT NULL DEFAULT 0,
  `getaran_berlebih` tinyint(1) NOT NULL DEFAULT 0,
  `kebocoran` tinyint(1) NOT NULL DEFAULT 0,
  `terakhir_perawatan` date DEFAULT NULL,
  `tindakan_rekomendasi` enum('Lanjut Operasi','Perbaikan','Penggantian Komponen') NOT NULL,
  `catatan` text DEFAULT NULL,
  `jawaban` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `screenings`
--

INSERT INTO `screenings` (`id`, `jadwal_id`, `mesin_id`, `teknisi_id`, `admin_id`, `tanggal_pemeriksaan`, `status_operasional`, `kode_error`, `suara_anomali`, `getaran_berlebih`, `kebocoran`, `terakhir_perawatan`, `tindakan_rekomendasi`, `catatan`, `jawaban`, `created_at`, `updated_at`) VALUES
(1, NULL, 10, 9, 1, '2025-03-19', 'Tidak Normal', '205', 0, 0, 0, '2025-03-17', 'Penggantian Komponen', 'Apakah kerusakannya parah?', '', '2025-03-18 14:08:00', '2025-03-18 14:24:21'),
(2, NULL, 10, 9, 1, '2025-03-21', 'Tidak Normal', '45', 1, 1, 1, '2025-03-04', 'Perbaikan', 'Apa?', 'pp', '2025-03-20 22:13:02', '2025-03-20 23:04:28'),
(3, NULL, 10, 12, 1, '2025-03-21', 'Normal', '21', 0, 1, 1, '2025-03-20', 'Lanjut Operasi', 'Apakah ada kerusakan lebih?', 'Sudah diperbaiki', '2025-03-20 23:25:28', '2025-03-20 23:53:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spare_parts`
--

CREATE TABLE `spare_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_part` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `spare_parts`
--

INSERT INTO `spare_parts` (`id`, `kode_part`, `nama`, `jenis`, `stok`, `deskripsi`, `created_at`, `updated_at`) VALUES
(3, '001', 'Roll gilingan', 'mekanik', 6, 'Komponen utama yang menghancurkan tebu.', '2025-03-18 09:06:52', '2025-06-08 17:44:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stations`
--

CREATE TABLE `stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_station` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stations`
--

INSERT INTO `stations` (`id`, `nama_station`, `created_at`, `updated_at`) VALUES
(1, 'Station Penggilingan Awal', '2025-03-21 03:33:46', '2025-04-24 12:47:38'),
(2, 'Station Pemanasan Nira', '2025-03-21 03:33:57', '2025-04-24 12:48:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teknisi_mesin`
--

CREATE TABLE `teknisi_mesin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `teknisi_mesin`
--

INSERT INTO `teknisi_mesin` (`id`, `user_id`, `mesin_id`, `created_at`, `updated_at`) VALUES
(6, 9, 10, '2025-06-04 06:51:34', '2025-06-04 06:51:34'),
(7, 12, 3, '2025-06-04 06:51:46', '2025-06-04 06:51:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_perbaikan`
--

CREATE TABLE `tugas_perbaikan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mesin_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_penugasan` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Diterima',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `station_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `user_id`, `nama`, `password`, `level`, `alamat`, `telp`, `status`, `created_at`, `updated_at`, `station_id`) VALUES
(1, 'adm1', 'Endra', '$2y$10$UYrVzq.P/bgKfAY5aon4suc5AyZm5lQVZav3siAcAZAMMy.iWSmx2', 'Administrator', 'Kediri', '082335022640', 1, NULL, '2025-03-10 12:13:18', NULL),
(9, 'teknisi1', 'Frengki', '$2y$10$cxgNE8rd5HKi7iRRupJYHeYfWcq9xzoIfNwMW2WH6CdBE75O8/37m', 'Teknisi', 'Pare', '628883866931', 1, '2025-02-19 04:35:41', '2025-06-03 14:19:53', 2),
(12, 'teknisi2', 'Hafidz', '$2y$10$nEiaR7bCMxEZeaNu6Jx18O350KIT3HanRxJrEdExFywhIT6Kr2SH2', 'Teknisi', 'Kebomas, Gresik', '62881036554563', 1, '2025-03-17 07:02:22', '2025-06-04 06:51:13', 1),
(13, 'manajer1', 'manajer', '$2y$10$pxxV7VDE3dcrAtV/fRsLX.fW9ToJ62JHi9BqpC/LIlw8yvIC0bhXC', 'Manajer Teknisi', 'Kebomas', '089612684096', 1, '2025-03-18 06:29:46', '2025-03-18 06:29:46', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `damage_reports`
--
ALTER TABLE `damage_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_id` (`repair_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indeks untuk tabel `jadwal_pemeliharaan`
--
ALTER TABLE `jadwal_pemeliharaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporanincidental`
--
ALTER TABLE `laporanincidental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporanincidental_mesin_id_foreign` (`mesin_id`),
  ADD KEY `laporanincidental_station_id_foreign` (`station_id`),
  ADD KEY `laporanincidental_spare_part_id_foreign` (`spare_part_id`);

--
-- Indeks untuk tabel `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indeks untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indeks untuk tabel `mesins`
--
ALTER TABLE `mesins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesins_station_id_foreign` (`station_id`);

--
-- Indeks untuk tabel `mesin_spare_part`
--
ALTER TABLE `mesin_spare_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesin_spare_part_mesin_id_foreign` (`mesin_id`),
  ADD KEY `mesin_spare_part_spare_part_id_foreign` (`spare_part_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pasca_gilings`
--
ALTER TABLE `pasca_gilings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasca_gilings_station_id_foreign` (`station_id`),
  ADD KEY `pasca_gilings_mesin_id_foreign` (`mesin_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indeks untuk tabel `repair_assignments`
--
ALTER TABLE `repair_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_assignments_machine_id_foreign` (`machine_id`),
  ADD KEY `repair_assignments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `request_parts`
--
ALTER TABLE `request_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_request_parts_mesin_id` (`mesin_id`),
  ADD KEY `fk_request_parts_spare_part_id` (`spare_part_id`);

--
-- Indeks untuk tabel `screenings`
--
ALTER TABLE `screenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `screenings_mesin_id_foreign` (`mesin_id`),
  ADD KEY `screenings_teknisi_id_foreign` (`teknisi_id`),
  ADD KEY `screenings_admin_id_foreign` (`admin_id`),
  ADD KEY `screenings_jadwal_id_foreign` (`jadwal_id`);

--
-- Indeks untuk tabel `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spare_parts_kode_part_unique` (`kode_part`);

--
-- Indeks untuk tabel `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `teknisi_mesin`
--
ALTER TABLE `teknisi_mesin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teknisi_mesin_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tugas_perbaikan`
--
ALTER TABLE `tugas_perbaikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_perbaikan_mesin_id_foreign` (`mesin_id`),
  ADD KEY `tugas_perbaikan_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_station_id_foreign` (`station_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `damage_reports`
--
ALTER TABLE `damage_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_pemeliharaan`
--
ALTER TABLE `jadwal_pemeliharaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `laporanincidental`
--
ALTER TABLE `laporanincidental`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mesins`
--
ALTER TABLE `mesins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `mesin_spare_part`
--
ALTER TABLE `mesin_spare_part`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pasca_gilings`
--
ALTER TABLE `pasca_gilings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `repair_assignments`
--
ALTER TABLE `repair_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `request_parts`
--
ALTER TABLE `request_parts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `screenings`
--
ALTER TABLE `screenings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `spare_parts`
--
ALTER TABLE `spare_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stations`
--
ALTER TABLE `stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `teknisi_mesin`
--
ALTER TABLE `teknisi_mesin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tugas_perbaikan`
--
ALTER TABLE `tugas_perbaikan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `damage_reports`
--
ALTER TABLE `damage_reports`
  ADD CONSTRAINT `damage_reports_ibfk_1` FOREIGN KEY (`repair_id`) REFERENCES `repairs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `damage_reports_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporanincidental`
--
ALTER TABLE `laporanincidental`
  ADD CONSTRAINT `laporanincidental_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporanincidental_spare_part_id_foreign` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `laporanincidental_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD CONSTRAINT `maintenance_schedules_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_schedules_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mesins`
--
ALTER TABLE `mesins`
  ADD CONSTRAINT `mesins_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `mesin_spare_part`
--
ALTER TABLE `mesin_spare_part`
  ADD CONSTRAINT `mesin_spare_part_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mesin_spare_part_spare_part_id_foreign` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasca_gilings`
--
ALTER TABLE `pasca_gilings`
  ADD CONSTRAINT `pasca_gilings_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `repairs`
--
ALTER TABLE `repairs`
  ADD CONSTRAINT `repairs_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `repairs_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `repair_assignments`
--
ALTER TABLE `repair_assignments`
  ADD CONSTRAINT `repair_assignments_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `repair_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `request_parts`
--
ALTER TABLE `request_parts`
  ADD CONSTRAINT `fk_request_parts_mesin_id` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_request_parts_spare_part_id` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `screenings`
--
ALTER TABLE `screenings`
  ADD CONSTRAINT `screenings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `screenings_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_pemeliharaan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `screenings_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `screenings_teknisi_id_foreign` FOREIGN KEY (`teknisi_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `teknisi_mesin`
--
ALTER TABLE `teknisi_mesin`
  ADD CONSTRAINT `teknisi_mesin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas_perbaikan`
--
ALTER TABLE `tugas_perbaikan`
  ADD CONSTRAINT `tugas_perbaikan_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_perbaikan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
