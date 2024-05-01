-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 01 Bulan Mei 2024 pada 14.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dailyexpense`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenses`
--

CREATE TABLE `expenses` (
  `pengeluaran_id` int(20) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `pengeluaran` varchar(255) DEFAULT NULL,
  `tanggal` varchar(15) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `expenses`
--

INSERT INTO `expenses` (`pengeluaran_id`, `user_id`, `pengeluaran`, `tanggal`, `kategori`) VALUES
(91, '7', 'Rp 1,000,000', '2024-04-26', 'Kesehatan'),
(94, '7', 'Rp 2,000', '2024-05-01', 'Makanan'),
(97, '7', 'Rp 50,000', '2024-04-24', 'Lainnya'),
(98, '7', 'Rp 100,000', '2024-05-01', 'Kesehatan'),
(99, '7', 'Rp 60,000', '2024-04-30', 'Tagihan dan Isi Ulang'),
(100, '7', 'Rp 65,000', '2024-05-01', 'Transportasi'),
(101, '7', 'Rp 60,000', '2024-04-29', 'Tagihan dan Isi Ulang'),
(102, '7', 'Rp 900,000', '2024-04-25', 'Makanan'),
(103, '7', 'Rp 800,000', '2024-04-28', 'Tagihan dan Isi Ulang'),
(104, '7', 'Rp 1,000,000', '2024-04-02', 'Transportasi'),
(105, '7', 'Rp 500,000', '2024-04-11', 'Hiburan'),
(106, '7', 'Rp 100,000', '2024-05-01', 'Makanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_path` varchar(50) NOT NULL DEFAULT 'default_profile.png',
  `password` varchar(50) NOT NULL,
  `trn_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `profile_path`, `password`, `trn_date`) VALUES
(7, 'intan', 'rd', 'intanrd@gmail.com', 'user.png', '46a7357b0b816cb9dd56d70d2a385cfd', '2024-04-24 13:43:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`pengeluaran_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `expenses`
--
ALTER TABLE `expenses`
  MODIFY `pengeluaran_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
