-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Mar 2025 pada 00.56
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
-- Database: `servis_mobil`
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_pemeliharaan`
--

INSERT INTO `jadwal_pemeliharaan` (`id`, `mesin_id`, `user_id`, `jenis`, `tanggal`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(8, 3, 9, 'incidental', '2025-03-19', 'Rusak Gear', 'Selesai', '2025-03-18 11:38:21', '2025-03-19 15:09:55'),
(9, 10, 12, 'rutin', '2025-03-20', 'Rusak Total', 'Selesai', '2025-03-19 15:01:37', '2025-03-19 15:15:24'),
(10, 10, 12, 'incidental', '2025-03-20', 'Rusak Gear', 'Selesai', '2025-03-19 15:19:29', '2025-03-19 15:46:42'),
(11, 10, 12, 'rutin', '2025-03-20', 'Rusak Sebagian', 'Selesai', '2025-03-19 15:19:59', '2025-03-19 15:36:05'),
(12, 10, 12, 'rutin', '2025-03-20', 'Rusak', 'Selesai', '2025-03-19 15:50:17', '2025-03-19 15:50:33'),
(13, 10, 12, 'rutin', '2025-03-20', 'Rusak', 'Selesai', '2025-03-19 22:56:37', '2025-03-19 22:56:48'),
(14, 10, 12, 'rutin', '2025-03-20', 'Rusak', 'Terjadwal', '2025-03-19 22:57:51', '2025-03-19 22:57:51');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mesins`
--

INSERT INTO `mesins` (`id`, `nama`, `jenis`, `tahun`, `deskripsi`, `created_at`, `updated_at`) VALUES
(3, 'Cane Crusher', 'Mesin Penggiling Tebu', 2018, 'Menghancurkan tebu untuk mengekstrak nira (cairan tebu).', '2025-03-06 09:38:17', '2025-03-17 06:47:31'),
(10, 'Milling Tandem', 'Mesin Pemeras Tebu', 2013, 'Memeras tebu lebih lanjut untuk mendapatkan hasil maksimal.', '2025-03-17 06:48:17', '2025-03-17 06:48:17'),
(11, 'Juice Heater', 'Mesin Pemeras Nira', 2011, 'Meningkatkan suhu nira untuk proses pemurnian.', '2025-03-17 06:49:42', '2025-03-18 09:56:13');

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
(7, '2025_03_18_201834_create_screenings_table', 7);

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
-- Struktur dari tabel `screenings`
--

CREATE TABLE `screenings` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `screenings` (`id`, `mesin_id`, `teknisi_id`, `admin_id`, `tanggal_pemeriksaan`, `status_operasional`, `kode_error`, `suara_anomali`, `getaran_berlebih`, `kebocoran`, `terakhir_perawatan`, `tindakan_rekomendasi`, `catatan`, `jawaban`, `created_at`, `updated_at`) VALUES
(1, 10, 9, 1, '2025-03-19', 'Tidak Normal', '205', 0, 0, 0, '2025-03-17', 'Penggantian Komponen', 'Apakah kerusakannya parah?', '', '2025-03-18 14:08:00', '2025-03-18 14:24:21'),
(2, 10, 9, 1, '2025-03-21', 'Tidak Normal', '45', 1, 1, 1, '2025-03-04', 'Perbaikan', 'Apa?', 'pp', '2025-03-20 22:13:02', '2025-03-20 23:04:28'),
(3, 10, 12, 1, '2025-03-21', 'Normal', '21', 0, 1, 1, '2025-03-20', 'Lanjut Operasi', 'Apakah ada kerusakan lebih?', 'Sudah diperbaiki', '2025-03-20 23:25:28', '2025-03-20 23:53:32');

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
(3, '001', 'Roll gilingan', 'mekanik', 10, 'Komponen utama yang menghancurkan tebu.', '2025-03-18 09:06:52', '2025-03-18 09:06:52');

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
(2, 9, 3, '2025-03-17 07:02:37', '2025-03-17 07:02:37'),
(3, 12, 10, '2025-03-17 07:02:47', '2025-03-17 07:02:47');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `user_id`, `nama`, `password`, `level`, `alamat`, `telp`, `status`, `created_at`, `updated_at`) VALUES
(1, 'adm1', 'Endra', '$2y$10$UYrVzq.P/bgKfAY5aon4suc5AyZm5lQVZav3siAcAZAMMy.iWSmx2', 'Administrator', 'Kediri', '082335022640', 1, NULL, '2025-03-10 12:13:18'),
(9, 'teknisi1', 'Stenlie', '$2y$10$cxgNE8rd5HKi7iRRupJYHeYfWcq9xzoIfNwMW2WH6CdBE75O8/37m', 'Teknisi', 'Malang', '052314758596', 1, '2025-02-19 04:35:41', '2025-03-10 12:14:30'),
(12, 'teknisi2', 'Nana', '$2y$10$nEiaR7bCMxEZeaNu6Jx18O350KIT3HanRxJrEdExFywhIT6Kr2SH2', 'Teknisi', 'Gurah', '085645214125', 1, '2025-03-17 07:02:22', '2025-03-18 06:31:36'),
(13, 'manajer1', 'Hafidz', '$2y$10$pxxV7VDE3dcrAtV/fRsLX.fW9ToJ62JHi9BqpC/LIlw8yvIC0bhXC', 'Manajer Teknisi', 'Kebomas', '089612684096', 1, '2025-03-18 06:29:46', '2025-03-18 06:29:46');

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
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indeks untuk tabel `screenings`
--
ALTER TABLE `screenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `screenings_mesin_id_foreign` (`mesin_id`),
  ADD KEY `screenings_teknisi_id_foreign` (`teknisi_id`),
  ADD KEY `screenings_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spare_parts_kode_part_unique` (`kode_part`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT untuk tabel `teknisi_mesin`
--
ALTER TABLE `teknisi_mesin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tugas_perbaikan`
--
ALTER TABLE `tugas_perbaikan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Ketidakleluasaan untuk tabel `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD CONSTRAINT `maintenance_schedules_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_schedules_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Ketidakleluasaan untuk tabel `screenings`
--
ALTER TABLE `screenings`
  ADD CONSTRAINT `screenings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
