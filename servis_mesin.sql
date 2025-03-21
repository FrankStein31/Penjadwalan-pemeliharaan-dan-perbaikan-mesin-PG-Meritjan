/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - servis_mesin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`servis_mesin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `servis_mesin`;

/*Table structure for table `damage_reports` */

DROP TABLE IF EXISTS `damage_reports`;

CREATE TABLE `damage_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `repair_id` bigint unsigned NOT NULL,
  `technician_id` bigint unsigned NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repair_id` (`repair_id`),
  KEY `technician_id` (`technician_id`),
  CONSTRAINT `damage_reports_ibfk_1` FOREIGN KEY (`repair_id`) REFERENCES `repairs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `damage_reports_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `damage_reports` */

/*Table structure for table `jadwal_pemeliharaan` */

DROP TABLE IF EXISTS `jadwal_pemeliharaan`;

CREATE TABLE `jadwal_pemeliharaan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mesin_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `jenis` enum('rutin','incidental') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Terjadwal','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terjadwal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jadwal_pemeliharaan` */

insert  into `jadwal_pemeliharaan`(`id`,`mesin_id`,`user_id`,`jenis`,`tanggal`,`deskripsi`,`status`,`created_at`,`updated_at`) values 
(8,3,9,'incidental','2025-03-19','Rusak Gear','Selesai','2025-03-18 18:38:21','2025-03-19 22:09:55'),
(9,10,12,'rutin','2025-03-20','Rusak Total','Selesai','2025-03-19 22:01:37','2025-03-19 22:15:24'),
(10,10,12,'incidental','2025-03-20','Rusak Gear','Selesai','2025-03-19 22:19:29','2025-03-19 22:46:42'),
(11,10,12,'rutin','2025-03-20','Rusak Sebagian','Selesai','2025-03-19 22:19:59','2025-03-19 22:36:05'),
(12,10,12,'rutin','2025-03-20','Rusak','Selesai','2025-03-19 22:50:17','2025-03-19 22:50:33'),
(13,10,12,'rutin','2025-03-20','Rusak','Selesai','2025-03-20 05:56:37','2025-03-20 05:56:48'),
(14,10,12,'rutin','2025-03-20','Rusak','Terjadwal','2025-03-20 05:57:51','2025-03-20 05:57:51'),
(15,11,14,'rutin','2025-03-21','asdas','Terjadwal','2025-03-21 11:26:24','2025-03-21 11:26:24');

/*Table structure for table `machines` */

DROP TABLE IF EXISTS `machines`;

CREATE TABLE `machines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial_number` (`serial_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `machines` */

/*Table structure for table `maintenance_schedules` */

DROP TABLE IF EXISTS `maintenance_schedules`;

CREATE TABLE `maintenance_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` bigint unsigned NOT NULL,
  `technician_id` bigint unsigned NOT NULL,
  `schedule_date` date NOT NULL,
  `status` enum('scheduled','completed','pending') COLLATE utf8mb4_general_ci DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `machine_id` (`machine_id`),
  KEY `technician_id` (`technician_id`),
  CONSTRAINT `maintenance_schedules_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_schedules_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `maintenance_schedules` */

/*Table structure for table `mesin_spare_part` */

DROP TABLE IF EXISTS `mesin_spare_part`;

CREATE TABLE `mesin_spare_part` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mesin_id` bigint unsigned NOT NULL,
  `spare_part_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mesin_spare_part_mesin_id_foreign` (`mesin_id`),
  KEY `mesin_spare_part_spare_part_id_foreign` (`spare_part_id`),
  CONSTRAINT `mesin_spare_part_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mesin_spare_part_spare_part_id_foreign` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mesin_spare_part` */

insert  into `mesin_spare_part`(`id`,`mesin_id`,`spare_part_id`,`jumlah`,`created_at`,`updated_at`) values 
(2,10,3,10,'2025-03-18 16:07:33','2025-03-18 16:07:33');

/*Table structure for table `mesins` */

DROP TABLE IF EXISTS `mesins`;

CREATE TABLE `mesins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `station_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mesins_station_id_foreign` (`station_id`),
  CONSTRAINT `mesins_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mesins` */

insert  into `mesins`(`id`,`nama`,`jenis`,`tahun`,`deskripsi`,`created_at`,`updated_at`,`station_id`) values 
(3,'Cane Crusher','Mesin Penggiling Tebu',2018,'Menghancurkan tebu untuk mengekstrak nira (cairan tebu).','2025-03-06 16:38:17','2025-03-21 10:34:13',1),
(10,'Milling Tandem','Mesin Pemeras Tebu',2013,'Memeras tebu lebih lanjut untuk mendapatkan hasil maksimal.','2025-03-17 13:48:17','2025-03-21 10:53:11',2),
(11,'Juice Heater','Mesin Pemeras Nira',2011,'Meningkatkan suhu nira untuk proses pemurnian.','2025-03-17 13:49:42','2025-03-21 11:25:04',2);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2019_12_14_000001_create_personal_access_tokens_table',1),
(2,'2025_03_06_132826_create_mesins_table',2),
(3,'2025_03_13_195304_create_repair_assignments_table',3),
(4,'2025_03_13_201112_create_tugas_perbaikans_table',4),
(5,'2025_03_18_134928_create_spare_parts_table',5),
(6,'2025_03_18_134930_create_mesin_spare_part_table',6),
(7,'2025_03_18_201834_create_screenings_table',7),
(8,'2025_03_20_165644_create_stations_table',8),
(9,'2025_03_20_172842_add_station_id_to_mesins_table',8),
(10,'2025_03_20_174818_add_station_id_to_users_table',8);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notifications` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `repair_assignments` */

DROP TABLE IF EXISTS `repair_assignments`;

CREATE TABLE `repair_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `assigned_at` datetime NOT NULL,
  `status` enum('dijadwalkan','sedang dikerjakan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dijadwalkan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repair_assignments_machine_id_foreign` (`machine_id`),
  KEY `repair_assignments_user_id_foreign` (`user_id`),
  CONSTRAINT `repair_assignments_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `repair_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `repair_assignments` */

/*Table structure for table `repairs` */

DROP TABLE IF EXISTS `repairs`;

CREATE TABLE `repairs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` bigint unsigned NOT NULL,
  `technician_id` bigint unsigned NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `repair_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `machine_id` (`machine_id`),
  KEY `technician_id` (`technician_id`),
  CONSTRAINT `repairs_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `repairs_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `repairs` */

/*Table structure for table `screenings` */

DROP TABLE IF EXISTS `screenings`;

CREATE TABLE `screenings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mesin_id` bigint unsigned NOT NULL,
  `teknisi_id` bigint unsigned NOT NULL,
  `admin_id` bigint unsigned NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `status_operasional` enum('Normal','Tidak Normal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suara_anomali` tinyint(1) NOT NULL DEFAULT '0',
  `getaran_berlebih` tinyint(1) NOT NULL DEFAULT '0',
  `kebocoran` tinyint(1) NOT NULL DEFAULT '0',
  `terakhir_perawatan` date DEFAULT NULL,
  `tindakan_rekomendasi` enum('Lanjut Operasi','Perbaikan','Penggantian Komponen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `jawaban` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `screenings_mesin_id_foreign` (`mesin_id`),
  KEY `screenings_teknisi_id_foreign` (`teknisi_id`),
  KEY `screenings_admin_id_foreign` (`admin_id`),
  CONSTRAINT `screenings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `screenings_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `screenings_teknisi_id_foreign` FOREIGN KEY (`teknisi_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `screenings` */

insert  into `screenings`(`id`,`mesin_id`,`teknisi_id`,`admin_id`,`tanggal_pemeriksaan`,`status_operasional`,`kode_error`,`suara_anomali`,`getaran_berlebih`,`kebocoran`,`terakhir_perawatan`,`tindakan_rekomendasi`,`catatan`,`jawaban`,`created_at`,`updated_at`) values 
(1,10,9,1,'2025-03-19','Tidak Normal','205',0,0,0,'2025-03-17','Penggantian Komponen','Apakah kerusakannya parah?','','2025-03-18 21:08:00','2025-03-18 21:24:21'),
(2,10,9,1,'2025-03-21','Tidak Normal','45',1,1,1,'2025-03-04','Perbaikan','Apa?','pp','2025-03-21 05:13:02','2025-03-21 06:04:28'),
(3,10,12,1,'2025-03-21','Normal','21',0,1,1,'2025-03-20','Lanjut Operasi','Apakah ada kerusakan lebih?','Sudah diperbaiki','2025-03-21 06:25:28','2025-03-21 06:53:32');

/*Table structure for table `spare_parts` */

DROP TABLE IF EXISTS `spare_parts`;

CREATE TABLE `spare_parts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_part` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spare_parts_kode_part_unique` (`kode_part`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `spare_parts` */

insert  into `spare_parts`(`id`,`kode_part`,`nama`,`jenis`,`stok`,`deskripsi`,`created_at`,`updated_at`) values 
(3,'001','Roll gilingan','mekanik',10,'Komponen utama yang menghancurkan tebu.','2025-03-18 16:06:52','2025-03-18 16:06:52');

/*Table structure for table `stations` */

DROP TABLE IF EXISTS `stations`;

CREATE TABLE `stations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_station` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `stations` */

insert  into `stations`(`id`,`nama_station`,`created_at`,`updated_at`) values 
(1,'qqqq','2025-03-21 10:33:46','2025-03-21 11:16:42'),
(2,'bbbb','2025-03-21 10:33:57','2025-03-21 10:33:57');

/*Table structure for table `teknisi_mesin` */

DROP TABLE IF EXISTS `teknisi_mesin`;

CREATE TABLE `teknisi_mesin` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `mesin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teknisi_mesin_user_id_foreign` (`user_id`),
  CONSTRAINT `teknisi_mesin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `teknisi_mesin` */

insert  into `teknisi_mesin`(`id`,`user_id`,`mesin_id`,`created_at`,`updated_at`) values 
(2,9,3,'2025-03-17 14:02:37','2025-03-17 14:02:37'),
(3,12,10,'2025-03-17 14:02:47','2025-03-17 14:02:47'),
(4,14,11,'2025-03-21 11:24:51','2025-03-21 11:24:51'),
(5,15,11,'2025-03-21 11:25:16','2025-03-21 11:25:16');

/*Table structure for table `tugas_perbaikan` */

DROP TABLE IF EXISTS `tugas_perbaikan`;

CREATE TABLE `tugas_perbaikan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mesin_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tanggal_penugasan` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diterima',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tugas_perbaikan_mesin_id_foreign` (`mesin_id`),
  KEY `tugas_perbaikan_user_id_foreign` (`user_id`),
  CONSTRAINT `tugas_perbaikan_mesin_id_foreign` FOREIGN KEY (`mesin_id`) REFERENCES `mesins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tugas_perbaikan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tugas_perbaikan` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `station_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_station_id_foreign` (`station_id`),
  CONSTRAINT `users_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`user_id`,`nama`,`password`,`level`,`alamat`,`telp`,`status`,`created_at`,`updated_at`,`station_id`) values 
(1,'adm1','Endra','$2y$10$UYrVzq.P/bgKfAY5aon4suc5AyZm5lQVZav3siAcAZAMMy.iWSmx2','Administrator','Kediri','082335022640',1,NULL,'2025-03-10 19:13:18',NULL),
(9,'teknisi1','teknisi1','$2y$10$cxgNE8rd5HKi7iRRupJYHeYfWcq9xzoIfNwMW2WH6CdBE75O8/37m','Teknisi','Malang','052314758596',1,'2025-02-19 11:35:41','2025-03-10 19:14:30',NULL),
(12,'teknisi2','teknisi2','$2y$10$nEiaR7bCMxEZeaNu6Jx18O350KIT3HanRxJrEdExFywhIT6Kr2SH2','Teknisi','Gurah','085645214125',1,'2025-03-17 14:02:22','2025-03-18 13:31:36',NULL),
(13,'manajer1','manajer','$2y$10$pxxV7VDE3dcrAtV/fRsLX.fW9ToJ62JHi9BqpC/LIlw8yvIC0bhXC','Manajer Teknisi','Kebomas','089612684096',1,'2025-03-18 13:29:46','2025-03-18 13:29:46',NULL),
(14,'teknisi3','teknisi3','$2y$10$O7Zf7xMKWwsNY4mM1xSaju/TS6SpQwylc7bLU66TmwMTJcpDcA5oi','Teknisi','Medan','123',1,'2025-03-21 11:24:06','2025-03-21 11:24:06',NULL),
(15,'teknisi4','teknisi4','$2y$10$q5jYfnQVVh2Qzz5ux.yqv.TLwLf.fZxaDM38x9zCAwm.6Utqo81g6','Teknisi','Medan','123',1,'2025-03-21 11:24:39','2025-03-21 11:24:39',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
