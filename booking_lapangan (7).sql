-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 13, 2025 at 01:58 AM
-- Server version: 11.3.2-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_lapangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

DROP TABLE IF EXISTS `fasilitas`;
CREATE TABLE IF NOT EXISTS `fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `harga` double(11,2) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `type` enum('number','checkbox') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `harga`, `satuan`, `type`) VALUES
(1, '💧 Air Mineral', 5000.00, 'botol', 'number'),
(2, '🎽 Rompi Tim', 10000.00, 'paket', 'checkbox'),
(3, '⚽ Bola Tambahan', 5000.00, 'buah', 'checkbox');

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

DROP TABLE IF EXISTS `lapangan`;
CREATE TABLE IF NOT EXISTS `lapangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga_per_jam` decimal(10,2) NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia') DEFAULT 'Tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id`, `nama`, `deskripsi`, `foto`, `harga_per_jam`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Lapangan Barat', 'Lapangan Futsal GET FUTSAL', '1753166060_6842b0cf00eab08977ed.jpg', 100000.00, 'Tersedia', '2025-06-15 22:25:58', '2025-07-21 23:54:17'),
(7, 'Lapangan Timur', 'Lapangan GET Futsal', '1752073876_5be94e498e02d7e939d6.jpg', 105000.00, 'Tersedia', '2025-07-09 08:11:16', '2025-08-12 22:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

DROP TABLE IF EXISTS `pemesanan`;
CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(150) DEFAULT NULL,
  `kode_booking` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `lapangan_id` int(11) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_bayar` int(11) DEFAULT 0,
  `status` varchar(100) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `snaptoken` varchar(200) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tambahan_fasilitas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pemesanan_to_user` (`user_id`),
  KEY `pemesanan_to_lapangan` (`lapangan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `order_id`, `kode_booking`, `user_id`, `nama_pemesan`, `lapangan_id`, `tanggal_pesan`, `jam_mulai`, `jam_selesai`, `total_bayar`, `status`, `payment_type`, `catatan`, `snaptoken`, `deleted_at`, `created_at`, `updated_at`, `tambahan_fasilitas`) VALUES
(102, '68936bd267886', NULL, 8, 'qqqq', 5, '2025-08-08', '11:00:00', '12:00:00', 115000, 'settlement', 'qris', '', '59cc71e1-0523-4795-85ad-50f9ee06f6f9', NULL, '2025-08-06 14:50:58', '2025-08-06 14:51:55', 'Rompi Tim, Bola Tambahan'),
(103, '68936c4eea375', NULL, 8, 'qqqq', 5, '2025-08-08', '12:00:00', '13:00:00', 105000, 'settlement', 'qris', 'mas aku ngeleh', '7c27af62-b8dd-4a1f-a4dc-87574d066e44', NULL, '2025-08-06 14:53:02', '2025-08-06 14:53:26', ''),
(104, '68937035ad3ee', 'KBK-20250806-F5A745', 8, 'qqqq', 5, '2025-08-08', '13:00:00', '14:00:00', 100000, 'settlement', 'qris', '', 'd2209498-9a2c-44dd-a123-69fd03c8e901', NULL, '2025-08-06 15:09:41', '2025-08-06 15:10:10', ''),
(107, '689bdb185d139', 'KBK-20250813-D1163F', 8, 'qqqq', 5, '2025-08-13', '10:00:00', '11:00:00', 125000, 'settlement', 'cash', '', NULL, NULL, '2025-08-13 00:23:52', '2025-08-13 00:23:52', NULL),
(108, '689bf0fb2c61c', NULL, 8, 'qqqq', 5, '2025-08-13', '11:00:00', '12:00:00', 125000, 'pending', NULL, '', NULL, NULL, '2025-08-13 01:57:15', '2025-08-13 01:57:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_fasilitas`
--

DROP TABLE IF EXISTS `pemesanan_fasilitas`;
CREATE TABLE IF NOT EXISTS `pemesanan_fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pemesanan_id` int(11) NOT NULL,
  `fasilitas_id` int(11) NOT NULL,
  `qty` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pemesananfasilitas_to_pemesanan` (`pemesanan_id`),
  KEY `pemesananfasilitas_to_fasilitas` (`fasilitas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan_fasilitas`
--

INSERT INTO `pemesanan_fasilitas` (`id`, `pemesanan_id`, `fasilitas_id`, `qty`) VALUES
(1, 107, 1, 2),
(2, 107, 2, 1),
(3, 107, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `durasi_minimal` int(11) NOT NULL,
  `kontak_admin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hari_tutup` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `jam_buka`, `jam_tutup`, `durasi_minimal`, `kontak_admin`, `created_at`, `updated_at`, `hari_tutup`) VALUES
(1, '10:00:00', '22:00:00', 1, '085601106039', '2025-04-15 06:36:20', '2025-07-25 03:57:58', 'Kamis');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `alamat`, `password`, `created_at`, `updated_at`, `role`) VALUES
(4, 'Administrator', 'admin@gmail.com', 'admin', 'admin', '$2y$10$BpEBflOT4CMtRXPUiXqZ1uYo6UxCKGdIk.cxDRjPa4pPlmC22iXo6', '2025-04-26 01:10:18', '2025-07-09 22:06:37', 'admin'),
(8, 'qqqq', 'qqqq@gmail.com', '089383737343', 'qqqqqq', '$2y$10$ATYyi3gVBLKG1LEeRn5EMe7KuFT4euhOBVZTte9curgnPQGHA0lz6', '2025-07-09 22:07:20', '2025-08-13 08:17:27', 'pelanggan'),
(9, 'qwerty', 'qwerty@gmail.com', '089373762544', 'qwerty', '$2y$10$7hVdgOMl0QT4FLP0PhWiYOhCQyxf5iS0y8XV66fFGIkYiGs.7pbfG', '2025-07-09 22:08:20', '2025-08-13 07:08:11', 'pelanggan');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pemesanan_fasilitas`
--
ALTER TABLE `pemesanan_fasilitas`
  ADD CONSTRAINT `pemesananfasilitas_to_fasilitas` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesananfasilitas_to_pemesanan` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
