-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2026 pada 14.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `padel_booking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `kode_booking` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `nama_pemesan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id`, `kode_booking`, `user_id`, `slot_id`, `tanggal`, `status`, `nama_pemesan`, `no_hp`, `created_at`) VALUES
(5, 'BK-20260628-0002', 4, 25, '2026-06-28', 'pending', 'reza', '0812345678', '2026-06-28 12:42:59'),
(14, 'BK-20260629-0001', 4, 31, '2026-06-29', 'pending', 'reza', '0812345678', '2026-06-29 03:00:16'),
(15, 'BK-20260629-0002', 4, 32, '2026-06-29', 'confirmed', 'reza', '088217912731', '2026-06-29 06:14:11'),
(16, 'BK-20260629-0003', 4, 35, '2026-06-29', 'pending', 'abcd', '0812345678', '2026-06-29 06:54:26'),
(17, 'BK-20260629-0004', 4, 33, '2026-07-03', 'pending', 'fathan', '08192372940', '2026-06-29 07:13:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_lapangan`
--

CREATE TABLE `foto_lapangan` (
  `id` int(11) NOT NULL,
  `lapangan_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `foto_lapangan`
--

INSERT INTO `foto_lapangan` (`id`, `lapangan_id`, `foto`) VALUES
(1, 2, 'La Familia_2.jpeg'),
(2, 2, 'La Familia_3.jpeg'),
(3, 5, 'Padelwood_2.jpeg'),
(4, 5, 'Padelwood_3.jpeg'),
(5, 4, 'Gauri_2.jpeg'),
(6, 4, 'Gauri_3.jpeg'),
(7, 3, 'Americano_2.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lapangan`
--

CREATE TABLE `lapangan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lapangan`
--

INSERT INTO `lapangan` (`id`, `nama`, `lokasi`, `foto`, `status`) VALUES
(2, 'La Familia Padel Bandung', 'Jl. Dr. Djunjunan, Sukawarna, Kec. Sukajadi, Kota Bandung, Jawa Barat', '1782627113_La Familia_1.jpeg', 'aktif'),
(3, 'Americano Padel', 'Jl. Cipedes Atas No.89, Sukarasa, Kec. Sukasari, Kota Bandung, Jawa Barat', '1782627199_Americano_1.jpeg', 'aktif'),
(4, 'Gauri Padel Court', 'Jl. Sukamaju No.1, Pasteur, Kec. Sukajadi, Kota Bandung, Jawa Barat', '1782627240_Gauri_1.jpeg', 'aktif'),
(5, 'Padelwood Bandung', 'Jl. Setramurni Raya No.33, Sukarasa, Kec. Sukasari, Kota Bandung, Jawa Barat', '1782627385_Padelwood_2.jpeg', 'aktif'),
(6, 'Padela', 'Jl. Prof. drg. Soeria Soemantri No.112, Sukagalih, Kec. Sukajadi, Kota Bandung, Jawa Barat', '1782713877_1782627050_Padela_2.jpeg', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `slot_waktu`
--

CREATE TABLE `slot_waktu` (
  `id` int(11) NOT NULL,
  `lapangan_id` int(11) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `slot_waktu`
--

INSERT INTO `slot_waktu` (`id`, `lapangan_id`, `jam_mulai`, `jam_selesai`, `harga`) VALUES
(18, 2, '13:00:00', '14:00:00', 400000),
(19, 2, '14:00:00', '15:00:00', 400000),
(20, 2, '15:00:00', '16:00:00', 400000),
(21, 2, '16:00:00', '17:00:00', 400000),
(22, 2, '17:00:00', '18:00:00', 400000),
(23, 2, '18:00:00', '19:00:00', 400000),
(24, 2, '19:00:00', '20:00:00', 400000),
(25, 3, '09:00:00', '10:00:00', 250000),
(26, 3, '10:00:00', '11:00:00', 250000),
(27, 3, '11:00:00', '12:00:00', 250000),
(28, 3, '12:00:00', '13:00:00', 250000),
(29, 3, '13:00:00', '14:00:00', 250000),
(30, 3, '14:00:00', '15:00:00', 250000),
(31, 4, '18:00:00', '19:00:00', 800000),
(32, 4, '19:00:00', '20:00:00', 800000),
(33, 4, '20:00:00', '21:00:00', 800000),
(34, 4, '21:00:00', '22:00:00', 800000),
(35, 4, '22:00:00', '23:00:00', 800000),
(36, 5, '08:00:00', '09:00:00', 300000),
(37, 5, '09:00:00', '10:00:00', 300000),
(38, 5, '10:00:00', '11:00:00', 300000),
(39, 5, '11:00:00', '12:00:00', 300000),
(40, 6, '06:00:00', '07:00:00', 300000),
(41, 6, '07:00:00', '08:00:00', 300000),
(42, 6, '08:00:00', '09:00:00', 300000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'admin', 'admin@padel.com', '$2y$10$VXnnGEH2oVBRTYd2vj7IvuebPKrTzaYv5Ux2MsChMayddEfIAq4MG', 'admin', '2026-06-27 11:05:46'),
(4, 'reza', 'rahadian20reza@gmail.com', '$2y$10$6/LPBT5JDLxci.6VLctNWuqW4bUMMnz1Va4iVBGMU1b.pBbAVpAfq', 'user', '2026-06-28 11:59:00'),
(5, 'Padela', 'padela@padel.com', '$2y$10$ULVvdg2850Jey6vutCFtC.td66gHKEvj8GwLW.WNFUJm31D3vPhHu', 'user', '2026-06-28 12:49:26'),
(6, 'abcd', 'abcd@padel.com', '$2y$10$Sc9cfCN9LNbBNb1JPgx1fuhboxFUcJB5epSodiKA0w3ZiVG.6RSka', 'user', '2026-06-29 06:15:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_booking` (`kode_booking`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indeks untuk tabel `foto_lapangan`
--
ALTER TABLE `foto_lapangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lapangan_id` (`lapangan_id`);

--
-- Indeks untuk tabel `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `slot_waktu`
--
ALTER TABLE `slot_waktu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lapangan_id` (`lapangan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `foto_lapangan`
--
ALTER TABLE `foto_lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `slot_waktu`
--
ALTER TABLE `slot_waktu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `slot_waktu` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `foto_lapangan`
--
ALTER TABLE `foto_lapangan`
  ADD CONSTRAINT `foto_lapangan_ibfk_1` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `slot_waktu`
--
ALTER TABLE `slot_waktu`
  ADD CONSTRAINT `slot_waktu_ibfk_1` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
