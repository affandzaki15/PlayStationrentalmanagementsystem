-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Des 2024 pada 16.53
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
-- Database: `rentalps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ps_id` int(11) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor_tempat` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending',
  `payment_screenshot` varchar(255) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `ps_id`, `hari`, `tanggal`, `nomor_tempat`, `start_time`, `end_time`, `payment_status`, `payment_screenshot`, `amount_paid`) VALUES
(12, 17, 2, NULL, '2024-12-26', 1, '2024-12-26 17:00:00', '2024-12-26 18:00:00', 'Paid', 'Neon Effects PNG Image, Neon Effect Of Snowflakes, Blue Snowflakes, Symmetrical Snowflakes, Neon Light Effect Of Snowflakes PNG Image For Free Download.jpeg', 10000.00),
(13, 19, 6, NULL, '2024-12-27', 5, '2024-12-27 10:00:00', '2024-12-27 12:00:00', 'Paid', 'download (3).jpeg', 20000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comments` text DEFAULT NULL,
  `feedback_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `booking_id`, `user_id`, `rating`, `comments`, `feedback_date`) VALUES
(2, NULL, 18, 4, 'wow', '2024-12-26 17:34:23'),
(3, NULL, 19, 4, 'menarik', '2024-12-26 22:33:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `playstation`
--

CREATE TABLE `playstation` (
  `ps_id` int(11) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `nomor_tempat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `playstation`
--

INSERT INTO `playstation` (`ps_id`, `model`, `nomor_tempat`) VALUES
(2, 'PS3', 1),
(3, 'PS3', 2),
(4, 'PS3', 3),
(5, 'PS3', 4),
(6, 'PS4', 5),
(7, 'PS4', 6),
(8, 'PS4', 7),
(9, 'PS5', 8),
(10, 'PS5', 9),
(11, 'PS5', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`) VALUES
(17, 'affan', 'affandzaki1@gmail.com', '$2y$10$I7CrsmWFfIYsPWpmPcfOWeEOBW/qiBCCChEgmDPhlzfdwRYwrHG3u'),
(18, 'Affandz', 'affandzaki69@gmail.com', '$2y$10$62oMba4MHrI1tvA..yErYuKn9rwG4N9dpu1lTGpd/ujruTae3.kQ.'),
(19, 'Abrar', 'affandzaki15@gmail.com', '$2y$10$E6DuJlPImYJiwyWdWSllnOmk7YHy3Tr5QgSTctrk62C.HMO3Yfpxy');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ps_id` (`ps_id`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `playstation`
--
ALTER TABLE `playstation`
  ADD PRIMARY KEY (`ps_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `playstation`
--
ALTER TABLE `playstation`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`ps_id`) REFERENCES `playstation` (`ps_id`);

--
-- Ketidakleluasaan untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
