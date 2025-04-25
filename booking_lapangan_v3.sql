-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Apr 2025 pada 20.31
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
(1, 'Lapangan 1', 'Lapngan josss', '1744697898_c056b09b7799d1955e4b.jpg', 80000.00, 'Tersedia', '2025-04-14 23:18:18', '2025-04-15 07:16:42'),
(2, 'Lapangan II', 'DSFSFSFSFWFSFSFF', '1745307848_1ed7be258fb75b077a43.jpeg', 100.00, 'Tersedia', '2025-04-22 00:44:08', '2025-04-25 16:59:14');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `order_id`, `user_id`, `nama_pemesan`, `lapangan_id`, `tanggal_pesan`, `jam_mulai`, `jam_selesai`, `total_bayar`, `status`, `payment_type`, `catatan`, `snaptoken`, `created_at`, `updated_at`) VALUES
(44, '680bd1b59a9b4', 4, 'User Dummy', 2, '2025-04-25', '07:00:00', '08:00:00', 25100, 'settlement', 'qris', '', 'fd174ae7-4b63-4e96-882d-5e7d10810474', '2025-04-25 18:17:25', '2025-04-25 18:25:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `durasi_minimal` int(11) NOT NULL,
  `foto_default` varchar(255) DEFAULT NULL,
  `kontak_admin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `jam_buka`, `jam_tutup`, `durasi_minimal`, `foto_default`, `kontak_admin`, `created_at`, `updated_at`) VALUES
(1, '09:00:00', '22:00:00', 1, NULL, '5646466464', '2025-04-15 06:36:20', '2025-04-15 06:39:02');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `alamat`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Aan Futsal4', 'aanfutsal@mail.com', '08123456789', 'Jalan Mawar No. 10 gg', 'dummyhashedpassword', '2025-04-22 13:15:00', '2025-04-22 13:25:45'),
(2, 'andi', 'andi@gmail.com', '08123456789', 'adsasdaaas', '$2y$10$X7RMS3rIKOF5uXfir7hgDONfV9fxiiU7yCFiJDAEAoXWDlM3aCPNe', '2025-04-22 14:41:53', '2025-04-22 14:41:53'),
(4, 'Administrator', 'admin@gmail.com', '0867263625211', 'desa', '$2y$10$BpEBflOT4CMtRXPUiXqZ1uYo6UxCKGdIk.cxDRjPa4pPlmC22iXo6', '2025-04-26 01:10:18', '2025-04-26 01:10:18');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
