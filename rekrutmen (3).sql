-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jun 24, 2026 at 03:14 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.31

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
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int NOT NULL,
  `nama_kriteria` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `atribut` enum('benefit','cost') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_lowongan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `atribut`, `id_lowongan`) VALUES
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
(42, 'umur', 100, 'cost', 9),
(45, 'umur', 50, 'cost', 8),
(46, 'pengalaman', 50, 'benefit', 8),
(53, 'Umur', 30, 'cost', 10),
(54, 'pengalaman', 40, 'benefit', 10),
(55, 'Kemampuan Mengemudi', 30, 'benefit', 10),
(57, 'pengalaman', 100, 'benefit', 11),
(58, 'umur', 100, 'cost', 12),
(59, 'umur', 100, 'cost', 13),
(64, 'Kemampuan Mengemudi', 30, 'benefit', 14),
(65, 'Usia', 30, 'cost', 14),
(66, 'pengalaman Kerja', 40, 'benefit', 14),
(73, 'Pengalaman Kerja', 40, 'benefit', 16),
(74, 'Umur', 30, 'cost', 16),
(75, 'Kemampuan Mengemudi ', 30, 'benefit', 16);

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int NOT NULL,
  `id_pelamar` int DEFAULT NULL,
  `id_lowongan` int DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `status_lamaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `cv_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cv_path` text COLLATE utf8mb4_general_ci,
  `cv_uploaded_at` datetime DEFAULT NULL,
  `surat_lamaran_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surat_lamaran_path` text COLLATE utf8mb4_general_ci,
  `surat_lamaran_uploaded_at` datetime DEFAULT NULL,
  `ijazah_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ijazah_path` text COLLATE utf8mb4_general_ci,
  `ijazah_uploaded_at` datetime DEFAULT NULL,
  `dokumen_pendukung_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dokumen_pendukung_path` text COLLATE utf8mb4_general_ci,
  `dokumen_pendukung_uploaded_at` datetime DEFAULT NULL,
  `admin_validated_at` datetime DEFAULT NULL,
  `admin_validated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id` int NOT NULL,
  `nama_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `start_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` date DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelamar`
--

CREATE TABLE `pelamar` (
  `id_pelamar` int NOT NULL,
  `nama_pelamar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pendidikan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lamar` date DEFAULT NULL,
  `status` enum('pending','lolos_saw','tidak_lolos') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `id_user` int DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelamar`
--

INSERT INTO `pelamar` (`id_pelamar`, `nama_pelamar`, `email`, `pendidikan`, `tanggal_lamar`, `status`, `id_user`, `nama_lengkap`, `no_hp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`) VALUES
(29, 'Asatu', 'A1@gmail.com', 's1', '2026-06-17', '', 26, 'satu', '098909878899', 'bjm', '2000-06-01', 'Laki-laki'),
(30, 'asatu', 'A1new@gmail.com', 'd3', '2026-06-17', '', 27, 'bbbbbbbbbbbbb', '098909878899', 'bjm', '2005-06-01', 'Laki-laki'),
(31, 'a dua', 'A2@gmail.com', 's1', '2026-06-17', '', 28, 'bbbbbbbbbbbbb', '098909878899', 'bjm', '2005-06-27', 'Laki-laki'),
(32, 'a tiga', 'A3@gmail.com', 's1', '2026-06-17', '', 29, 'bbbbbbbbbbbbb', '098909878899', 'bjm', '2005-06-17', 'Laki-laki');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int NOT NULL,
  `id_lamaran` int DEFAULT NULL,
  `id_kriteria` int DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub` int NOT NULL,
  `id_kriteria` int DEFAULT NULL,
  `nama_sub` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub`, `id_kriteria`, `nama_sub`, `nilai`) VALUES
(35, 20, '> 2 Tahun', 4),
(36, 21, 'Tidak bisa', 0),
(37, 21, 'Bisa', 5),
(38, 22, '>35', 2),
(39, 22, '<35', 4),
(40, 23, '>35 tahun', 3),
(41, 23, '<35 tahun', 5),
(42, 24, '>5 tahun', 5),
(43, 24, '<5 tahun', 3),
(77, 42, '>5 tahun', 5),
(82, 45, '>5 tahun', 2),
(83, 45, '<5 tahun', -1),
(84, 46, '>5 tahun', 2),
(85, 46, '<5 tahun', 1),
(98, 53, '>35 tahun', 1),
(99, 53, '<35 tahun', 2),
(100, 54, '<5 tahun', 1),
(101, 54, '>5 tahun', 2),
(102, 55, 'Memiliki SIM A', 2),
(103, 55, 'Tidak Memiliki SIM A', 1),
(105, 57, '>5 tahun', 10),
(106, 57, '<5 tahun', 5),
(107, 58, '>35 tahun', 5),
(108, 58, '<35 tahun', 10),
(109, 59, '>35 tahun', 5),
(118, 64, 'Bisa mengemudi kendaraan besar (truk) dan memiliki SIM B', 100),
(119, 64, 'Bisa mengemudi (mobil/motor) dan memiliki SIM A/C', 80),
(120, 64, 'Bisa mengemudi tapi tidak memiliki SIM', 60),
(121, 64, 'Tidak bisa mengemudi ', 40),
(122, 65, '20–25 Tahun', 100),
(123, 65, '26–30 Tahun', 80),
(124, 65, '31–35 Tahun', 60),
(125, 65, '> 35 Tahun', 40),
(126, 66, '> 5 Tahun', 100),
(127, 66, '3–5 Tahun ', 80),
(128, 66, '1–2 Tahun', 60),
(129, 66, '< 1 Tahun', 40),
(154, 73, '> 5 Tahun', 10),
(155, 73, '3–5 Tahun', 8),
(156, 73, '1–2 Tahun', 6),
(157, 73, '< 1 Tahun', 4),
(158, 74, '20–25 Tahun', 4),
(159, 74, '26–30 Tahun', 6),
(160, 74, '31–35 Tahun', 8),
(161, 74, '> 35 Tahun', 10),
(162, 75, 'Bisa mengemudi kendaraan besar (truk) dan memiliki SIM B', 10),
(163, 75, 'Bisa mengemudi (mobil/motor) dan memiliki SIM A/C', 8),
(164, 75, 'Bisa mengemudi tapi tidak memiliki SIM', 6),
(165, 75, 'Tidak bisa mengemudi ', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tahapan_rekrutmen`
--

CREATE TABLE `tahapan_rekrutmen` (
  `id_tahapan` int NOT NULL,
  `id_lamaran` int DEFAULT NULL,
  `tahap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahapan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('proses','lulus','gagal') COLLATE utf8mb4_general_ci DEFAULT 'proses',
  `catatan` text COLLATE utf8mb4_general_ci,
  `dokumen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','pelamar') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `foto`, `no_hp`, `alamat`) VALUES
(1, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1779773259_dcf01476cd5fd983a880.png', NULL, NULL),
(2, 'nana', 'try@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(3, 'nana', 'nanda@gmail.com', 'c33367701511b4f6020ec61ded352059', 'pelamar', NULL, NULL, NULL),
(4, 'coba', 'coba1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(5, 'nanda', 'nanda2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(6, 'nanda3', 'nanda3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(7, 'aulia', 'aulia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(8, 'nanda4', 'nanda4@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(9, 'try', 'try@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(10, 'rizki', 'rizki@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(11, 'nanda aulia', 'aulia5@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(12, 'atdvin nur', 'atdvin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(13, 'Nanda Aulia R', 'nanda@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', '1779978153_9ac7c743f2eef38c8f0a.jpg', NULL, NULL),
(15, 'amelia', 'amel@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(16, 'amelia', 'amelia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(17, 'Nanda', 'nandaa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(18, 'norma', 'norma@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(19, 'azizah', 'azizah@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(20, 'aziz', 'aziz@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(21, 'andi', 'andi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(22, 'Dika', 'Dika@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(23, 'sisi', 'sisi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(24, 'ilham', 'ilham@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(25, 'ddd', 'd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(26, 'Asatu', 'A1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(27, 'asatu', 'A1new@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(28, 'a dua', 'A2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL),
(29, 'a tiga', 'A3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`),
  ADD KEY `fk_lamaran_pelamar` (`id_pelamar`),
  ADD KEY `fk_lamaran_lowongan` (`id_lowongan`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id_pelamar`),
  ADD KEY `fk_pelamar_user` (`id_user`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_penilaian_lamaran` (`id_lamaran`),
  ADD KEY `fk_penilaian_kriteria` (`id_kriteria`);

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
  ADD PRIMARY KEY (`id_tahapan`),
  ADD KEY `fk_tahapan_lamaran` (`id_lamaran`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id_pelamar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tahapan_rekrutmen`
--
ALTER TABLE `tahapan_rekrutmen`
  MODIFY `id_tahapan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `fk_lamaran_lowongan` FOREIGN KEY (`id_lowongan`) REFERENCES `lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lamaran_pelamar` FOREIGN KEY (`id_pelamar`) REFERENCES `pelamar` (`id_pelamar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelamar`
--
ALTER TABLE `pelamar`
  ADD CONSTRAINT `fk_pelamar_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penilaian_lamaran` FOREIGN KEY (`id_lamaran`) REFERENCES `lamaran` (`id_lamaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);

--
-- Constraints for table `tahapan_rekrutmen`
--
ALTER TABLE `tahapan_rekrutmen`
  ADD CONSTRAINT `fk_tahapan_lamaran` FOREIGN KEY (`id_lamaran`) REFERENCES `lamaran` (`id_lamaran`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
