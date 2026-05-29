-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 07:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekrutmen`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_saw`
--

CREATE TABLE `hasil_saw` (
  `id_hasil` int(11) NOT NULL,
  `id_pelamar` int(11) DEFAULT NULL,
  `nilai_preferensi` float DEFAULT NULL,
  `ranking` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `atribut` enum('benefit','cost') DEFAULT NULL,
  `id_lowongan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `atribut`, `id_lowongan`) VALUES
(1, 'umur', 0.05, 'benefit', NULL),
(2, 'pendidikan', 0.3, 'benefit', NULL),
(3, 'pengalaman', 0, 'benefit', NULL),
(4, 'skil bahasa', 0, 'benefit', NULL),
(5, 'usia', 0.5, 'benefit', NULL),
(6, 'usia', 0.5, 'benefit', NULL),
(7, 'usia', 0.5, 'benefit', NULL),
(9, 'gaji', 0.5, 'cost', 2),
(10, 'pengalaman', 0.3, 'benefit', 2),
(11, 'Kesesuaian Pendidikan', 2, 'benefit', 3),
(12, 'usia', 1, 'cost', 3),
(18, 'umur', 0.5, 'cost', 6),
(19, 'pengalaman', 0.5, 'benefit', 6),
(20, 'pengalaman', 0.3, 'benefit', 4),
(21, 'Kemampuan Mengemudi mobil', 0.4, 'benefit', 4),
(22, 'usia', 0.3, 'cost', 4),
(23, 'umur', 0.5, 'cost', 7),
(24, 'pengalaman', 0.05, 'benefit', 7),
(37, 'umur', 50, 'cost', 8),
(38, 'pengalaman', 50, 'benefit', 8),
(39, 'umur', 100, 'cost', 9);

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_pelamar` int(11) DEFAULT NULL,
  `id_lowongan` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) DEFAULT 'pending',
  `status_lamaran` varchar(100) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lamaran`
--

INSERT INTO `lamaran` (`id_lamaran`, `id_pelamar`, `id_lowongan`, `tanggal`, `status`) VALUES
(1, 7, 3, '2026-04-06 16:00:00', 'pending'),
(2, 7, 2, '2026-04-06 16:00:00', 'pending'),
(3, 8, 3, '2026-04-06 16:00:00', 'pending'),
(4, 8, 2, '2026-04-06 16:00:00', 'pending'),
(5, 9, 2, '2026-04-06 16:00:00', 'pending'),
(6, 8, 3, '2026-04-07 16:00:00', 'pending'),
(7, 7, 2, '2026-04-07 16:00:00', 'pending'),
(8, 7, 2, '2026-04-07 16:00:00', 'pending'),
(9, 8, 4, '2026-04-12 16:00:00', 'pending'),
(10, 10, 4, '2026-04-12 16:00:00', 'pending'),
(11, 12, 4, '2026-04-12 16:00:00', 'pending'),
(12, 7, 7, '2026-04-26 16:00:00', 'pending'),
(13, 12, 7, '2026-04-26 16:00:00', 'pending'),
(14, 13, 7, '2026-05-10 16:00:00', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id` int(11) NOT NULL,
  `nama_pekerjaan` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lowongan`
--

INSERT INTO `lowongan` (`id`, `nama_pekerjaan`, `deskripsi`, `created_at`) VALUES
(8, 'try again', 'IT', '2026-05-12 06:16:37'),
(9, 'GA', 'General Admin', '2026-05-18 03:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_pelamar`
--

CREATE TABLE `nilai_pelamar` (
  `id` int(11) NOT NULL,
  `id_pelamar` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelamar`
--

CREATE TABLE `pelamar` (
  `id_pelamar` int(11) NOT NULL,
  `nama_pelamar` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `pengalaman` int(11) DEFAULT 0,
  `tanggal_lamar` date DEFAULT NULL,
  `status` enum('pending','lolos_saw','tidak_lolos') DEFAULT 'pending',
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelamar`
--

INSERT INTO `pelamar` (`id_pelamar`, `nama_pelamar`, `email`, `pendidikan`, `tanggal_lamar`, `status`, `id_user`) VALUES
(2, 'nanda ', 'nanda@gmail.com', '', '2026-03-25', 'pending', NULL),
(3, 'Nanda Aulia Rizkiah', 'try@gmail.com', 's1', '2026-03-25', 'pending', NULL),
(4, 'nana', 'try@gmail.com', '', '2026-04-07', 'pending', NULL),
(5, 'nana', 'nanda@gmail.com', '', '2026-04-07', '', 3),
(6, 'coba', 'coba1@gmail.com', '', '2026-04-07', '', 4),
(7, 'nanda', 'nanda2@gmail.com', '', '2026-04-07', '', 5),
(8, 'nanda3', 'nanda3@gmail.com', '', '2026-04-07', '', 6),
(9, 'aulia', 'aulia@gmail.com', '', '2026-04-07', '', 7),
(10, 'nanda4', 'nanda4@gmail.com', '', '2026-04-13', '', 8),
(11, 'try', 'try@gmail.com', '', '2026-04-13', '', 9),
(12, 'rizki', 'rizki@gmail.com', '', '2026-04-13', '', 10),
(13, 'nanda aulia', 'aulia5@gmail.com', '', '2026-05-09', '', 11),
(14, NULL, NULL, '', NULL, 'pending', NULL),
(15, NULL, NULL, 's1', NULL, 'pending', NULL),
(16, 'atdvin nur', 'atdvin@gmail.com', '', '2026-05-11', '', 12);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `id_lamaran` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `id_lamaran`, `id_kriteria`, `nilai`) VALUES
(1, 1, 11, 0.3),
(2, 1, 12, 0.4),
(3, 2, 9, 0.3),
(4, 2, 10, 2),
(5, 3, 11, 0.5),
(6, 3, 12, 0.5),
(7, 4, 9, 0.2),
(8, 4, 10, 4),
(9, 5, 9, 0.3),
(10, 5, 10, 4),
(11, 6, 11, 0.5),
(12, 6, 12, 0.5),
(13, 7, 9, 0.3),
(14, 7, 10, 4),
(15, 8, 9, 0.3),
(16, 8, 10, 4),
(17, 9, 14, 2),
(18, 9, 16, 0),
(19, 9, 17, 2),
(20, 10, 14, 4),
(21, 10, 16, 5),
(22, 10, 17, 4),
(23, 11, 14, 4),
(24, 11, 16, 0),
(25, 11, 17, 4),
(26, 12, 23, 5),
(27, 12, 24, 5),
(28, 13, 23, 3),
(29, 13, 24, 3),
(30, 14, 23, 5),
(31, 14, 24, 3);

-- --------------------------------------------------------

--
-- Table structure for table `seleksi_lanjutan`
--

CREATE TABLE `seleksi_lanjutan` (
  `id` int(11) NOT NULL,
  `id_pelamar` int(11) DEFAULT NULL,
  `rekomendasi` enum('ya','tidak') DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nama_sub` varchar(100) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub`, `id_kriteria`, `nama_sub`, `nilai`) VALUES
(1, 2, 'SMA', 0.3),
(2, 2, 'SMA', 0.3),
(3, 2, 'SMA', 0.3),
(4, 2, 'SMA', 0.3),
(5, 2, 'SMA', 0.3),
(6, 2, 'SMA', 0.3),
(7, 2, 'SMA', 0.3),
(8, 2, 'SMA', 0.3),
(9, 3, '>30', 0.3),
(10, 3, '>30', 0.3),
(11, 3, '>30', 0.3),
(12, 3, '>30', 0.5),
(15, 9, 'umr', 0.3),
(16, 9, '>umr', 0.2),
(17, 10, '> 5 tahun', 4),
(18, 10, '<5', 2),
(19, 11, 'manajemen', 0.5),
(20, 11, 'ekonomi', 0.3),
(21, 12, '< 30 Tahun', 0.5),
(22, 12, '> 30 Tahun', 0.4),
(30, 18, '>35 tahun', 5),
(31, 18, '<35 tahun', 9),
(32, 19, '>5 tahun', 5),
(33, 19, '<5 tahun', 9),
(34, 20, '< 2 Tahun', 2),
(35, 20, '> 2 Tahun', 4),
(36, 21, 'Tidak bisa', 0),
(37, 21, 'Bisa', 5),
(38, 22, '>35', 2),
(39, 22, '<35', 4),
(40, 23, '>35 tahun', 3),
(41, 23, '<35 tahun', 5),
(42, 24, '>5 tahun', 5),
(43, 24, '<5 tahun', 3),
(68, 37, '>5 tahun', 2),
(69, 37, '<5 tahun', 0),
(70, 38, '>5 tahun', 2),
(71, 38, '<5 tahun', 1),
(72, 39, '>5 tahun', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tahapan_rekrutmen`
--

CREATE TABLE `tahapan_rekrutmen` (
  `id_tahapan` int(11) NOT NULL,
  `id_lamaran` int(11) DEFAULT NULL,
  `tahap` varchar(100) DEFAULT NULL,
  `tahapan` varchar(100) DEFAULT NULL,
  `status` enum('proses','lulus','gagal') DEFAULT 'proses',
  `catatan` text DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','pelamar') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
(2, 'nana', 'try@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(3, 'nana', 'nanda@gmail.com', 'c33367701511b4f6020ec61ded352059', 'pelamar'),
(4, 'coba', 'coba1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(5, 'nanda', 'nanda2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(6, 'nanda3', 'nanda3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(7, 'aulia', 'aulia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(8, 'nanda4', 'nanda4@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(9, 'try', 'try@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(10, 'rizki', 'rizki@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(11, 'nanda aulia', 'aulia5@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(12, 'atdvin nur', 'atdvin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_saw`
--
ALTER TABLE `hasil_saw`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_pelamar` (`id_pelamar`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_pelamar`
--
ALTER TABLE `nilai_pelamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_sub` (`id_sub`);

--
-- Indexes for table `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id_pelamar`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seleksi_lanjutan`
--
ALTER TABLE `seleksi_lanjutan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `tahapan_rekrutmen`
--
ALTER TABLE `tahapan_rekrutmen`
  ADD PRIMARY KEY (`id_tahapan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_saw`
--
ALTER TABLE `hasil_saw`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nilai_pelamar`
--
ALTER TABLE `nilai_pelamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id_pelamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `seleksi_lanjutan`
--
ALTER TABLE `seleksi_lanjutan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tahapan_rekrutmen`
--
ALTER TABLE `tahapan_rekrutmen`
  MODIFY `id_tahapan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

COMMIT;

-- sinkron status_lamaran dari status yang ada
UPDATE `lamaran` SET `status_lamaran` = `status` WHERE `status_lamaran` = 'pending';
UPDATE `tahapan_rekrutmen` SET `tahapan` = `tahap` WHERE `tahap` IS NOT NULL;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_saw`
--
ALTER TABLE `hasil_saw`
  ADD CONSTRAINT `hasil_saw_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `pelamar` (`id_pelamar`);

--
-- Constraints for table `nilai_pelamar`
--
ALTER TABLE `nilai_pelamar`
  ADD CONSTRAINT `nilai_pelamar_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `pelamar` (`id_pelamar`),
  ADD CONSTRAINT `nilai_pelamar_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`),
  ADD CONSTRAINT `nilai_pelamar_ibfk_3` FOREIGN KEY (`id_sub`) REFERENCES `sub_kriteria` (`id_sub`);

--
-- Constraints for table `seleksi_lanjutan`
--
ALTER TABLE `seleksi_lanjutan`
  ADD CONSTRAINT `seleksi_lanjutan_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `pelamar` (`id_pelamar`);

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
