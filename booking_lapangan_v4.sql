-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jul 2025 pada 11.07
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
-- Database: `booking_lapangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `lapangan`
--

CREATE TABLE `lapangan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga_per_jam` decimal(10,2) NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia') DEFAULT 'Tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lapangan`
--

INSERT INTO `lapangan` (`id`, `nama`, `deskripsi`, `foto`, `harga_per_jam`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Lapangan Atas', 'Lapangan Futsal GET FUTSAL adalah tempat yang ideal untuk Anda yang ingin bermain futsal bersama teman, komunitas, maupun tim latihan. Terletak di lokasi yang strategis dan mudah diakses, lapangan kami menawarkan kenyamanan, fasilitas lengkap, dan harga sewa yang terjangkau.\r\n\r\n🏟 Spesifikasi Lapangan:\r\nUkuran standar nasional (25 x 15 meter)\r\n\r\nLantai berbahan rumput sintetis berkualitas tinggi\r\n\r\nPenerangan lampu LED terang, cocok untuk bermain malam hari\r\n\r\nArea tertutup dan beratap, aman dari hujan dan panas\r\n\r\n', '1750051558_377003bef4858ce5e654.jpeg', 70000.00, 'Tersedia', '2025-06-15 22:25:58', '2025-06-15 22:30:16'),
(6, 'Lapangan Bawah', 'Lapangan Futsal [Nama Lapangan] adalah tempat yang ideal untuk Anda yang ingin bermain futsal bersama teman, komunitas, maupun tim latihan. Terletak di lokasi yang strategis dan mudah diakses, lapangan kami menawarkan kenyamanan, fasilitas lengkap, dan harga sewa yang terjangkau.\r\n\r\n🏟 Spesifikasi Lapangan:\r\nUkuran standar nasional (25 x 15 meter)\r\n\r\nLantai berbahan rumput sintetis berkualitas tinggi\r\n\r\nPenerangan lampu LED terang, cocok untuk bermain malam hari\r\n\r\nArea tertutup dan beratap, aman dari hujan dan panas\r\n\r\n🧼 Fasilitas Penunjang:\r\nRuang tunggu dan tribun penonton\r\n\r\nKamar ganti & toilet bersih\r\n\r\nKantin / mini café\r\n\r\nArea parkir luas\r\n\r\nMushola', '1750051732_cf285e68cf0c4cbf5f0f.png', 90000.00, 'Tersedia', '2025-06-15 22:28:52', '2025-06-15 22:29:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `order_id` varchar(150) DEFAULT NULL,
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `order_id`, `user_id`, `nama_pemesan`, `lapangan_id`, `tanggal_pesan`, `jam_mulai`, `jam_selesai`, `total_bayar`, `status`, `payment_type`, `catatan`, `snaptoken`, `deleted_at`, `created_at`, `updated_at`) VALUES
(44, '680bd1b59a9b4', 4, 'User Dummy', 2, '2025-04-25', '08:00:00', '10:00:00', 25100, 'settlement', 'qris', '', 'fd174ae7-4b63-4e96-882d-5e7d10810474', NULL, '2025-04-25 18:17:25', '2025-05-28 01:31:25'),
(45, '680effaf6863a', NULL, 'User Dummy', 2, '2025-04-28', '09:00:00', '10:00:00', 15100, 'settlement', 'qris', '', '4edb9a4f-61d8-4d2d-9354-6a3efc8eb042', NULL, '2025-04-28 04:10:23', '2025-04-28 04:11:32'),
(46, '6820d5e428bd9', 2, 'User Dummy', 1, '2025-05-11', '14:00:00', '15:00:00', 105000, 'settlement', 'qris', '', '5ee2c6a3-4dee-48da-bfc5-f2e45dee3ef5', NULL, '2025-05-11 16:52:52', '2025-05-11 16:53:41'),
(47, '6824ce9a7beff', 6, 'diki', 2, '2025-05-14', '07:00:00', '08:00:00', 100, 'pending', NULL, '', '1ae3304f-52e1-42c9-af22-21a2fca4f40e', NULL, '2025-05-14 17:10:50', '2025-05-18 22:15:01'),
(49, '68360ce9f09d3', 2, 'andi', 2, '2025-05-27', '08:00:00', '09:00:00', 100, 'pending', NULL, '', 'eb1ed489-03bb-4bbc-9d12-6d65c5c0be95', NULL, '2025-05-27 19:05:13', '2025-05-27 19:05:15'),
(50, '684fa8ffb2fcb', 5, 'dikiiii', 1, '2025-06-16', '07:00:00', '08:00:00', 80000, 'pending', NULL, '', 'a62b2e1d-06ed-4e67-add4-89d6778a598d', NULL, '2025-06-16 05:17:51', '2025-06-16 05:17:53'),
(61, '686424db35db7', 6, 'diki', 5, '2025-07-01', '07:00:00', '08:00:00', 70000, 'settlement', 'bank_transfer', '', 'aade0876-a1e8-4653-af7c-d9f8caff6d67', NULL, '2025-07-02 01:11:39', '2025-07-02 01:15:22'),
(63, '6868dda98ec5d', 2, 'andi', 5, '2025-07-05', '11:00:00', '12:00:00', 70000, 'settlement', 'qris', '', 'c0a25bf4-a5a2-4c1f-83da-7ca5f6dc0b5f', NULL, '2025-07-05 15:09:13', '2025-07-05 15:09:41'),
(64, '686e3134592b3', 5, 'dikiiii', 5, '2025-07-09', '10:00:00', '11:00:00', 70000, 'pending', NULL, '', 'abbae13f-9031-40d8-8d3b-f1499293bba8', NULL, '2025-07-09 16:07:00', '2025-07-09 16:07:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `durasi_minimal` int(11) NOT NULL,
  `kontak_admin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hari_tutup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `jam_buka`, `jam_tutup`, `durasi_minimal`, `kontak_admin`, `created_at`, `updated_at`, `hari_tutup`) VALUES
(1, '10:00:00', '22:00:00', 1, '085601106039', '2025-04-15 06:36:20', '2025-07-09 08:47:23', 'Jumat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','pelanggan') NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `alamat`, `password`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Aan Futsal44512', 'aanfutsal@mail.com', '08123456765', 'Jalan Mawar No. 10 gg 3', 'dummyhashedpassword', '2025-04-22 13:15:00', '2025-07-02 01:22:33', 'pelanggan'),
(2, 'andi', 'andi@gmail.com', '08123456789', 'adsasdaaas', '$2y$10$1CESNJZX8MkKfv8CWVYG4eJLaRg1FQjnj3CkYSJvPjSfrDLXMbXRa', '2025-04-22 14:41:53', '2025-05-05 21:32:28', 'pelanggan'),
(4, 'Administrator', 'admin@gmail.com', '0867263625211', 'desa', '$2y$10$BpEBflOT4CMtRXPUiXqZ1uYo6UxCKGdIk.cxDRjPa4pPlmC22iXo6', '2025-04-26 01:10:18', '2025-05-02 22:57:26', 'admin'),
(5, 'dikiiii', 'ok@admin.com', '08123456789', 'ffsdsf', '$2y$10$PMW1eH6ebtZcF0.0owUEfeu7SHtIauFEK4bEHO8agMDWRg4yyzEIm', '2025-05-03 00:27:23', '2025-05-05 21:52:28', 'pelanggan'),
(6, 'diki', 'diki@gmail.com', '08123456787', 'dsfsdfsdffsf', '$2y$10$ELR6Ak/MezNCMIO2kDgOz.oPDuFwcbeOWy23fkTaaZJGhzJAeMoW6', '2025-05-15 00:10:32', '2025-07-02 01:18:49', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_to_user` (`user_id`),
  ADD KEY `pemesanan_to_lapangan` (`lapangan_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
