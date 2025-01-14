-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 04:53 PM
-- Server version: 10.4.28-MariaDB-log
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `acara_dinas`
--

CREATE TABLE `acara_dinas` (
  `id_acara_dinas` int(11) NOT NULL,
  `nama_acara` varchar(255) NOT NULL,
  `jenis_dinas` enum('Luar','Dalam') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acara_dinas`
--

INSERT INTO `acara_dinas` (`id_acara_dinas`, `nama_acara`, `jenis_dinas`) VALUES
(14, 'HALIM', 'Luar'),
(15, 'PANGLIMA CHINA', 'Dalam'),
(16, 'HUT TNI', 'Luar'),
(17, 'HUT TNI', 'Luar'),
(18, 'HUT TNI', 'Luar'),
(19, 'PANGLIMA CHINA', 'Dalam'),
(20, 'KEMHAN', 'Luar'),
(21, 'HUT TNI', 'Luar'),
(22, 'HUT TNI', 'Luar'),
(23, 'HALIM', 'Luar'),
(24, 'KEMHAN', 'Luar'),
(25, 'MONAS', 'Luar'),
(26, 'HUT TNI', 'Luar'),
(27, 'HUT TNI', 'Luar'),
(28, 'KEMHAN', 'Luar'),
(29, 'HUT TNI', 'Luar'),
(30, 'KEMHAN', 'Luar'),
(31, 'HUT TNI', 'Luar'),
(32, 'HALIM', 'Luar'),
(33, 'HUT TNI', 'Luar');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'admin@idu.ac.id', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `loginmhsw`
--

CREATE TABLE `loginmhsw` (
  `idusermhsw` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginmhsw`
--

INSERT INTO `loginmhsw` (`idusermhsw`, `email`, `password`) VALUES
(1, 'iqbal.setyawan@tm.idu.ac.id', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `kodeqr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nim`, `nama`, `prodi`, `kodeqr`) VALUES
(6, '3203034543', 'Muhammad Iqbal Setyawan', 'Informatika', 'qrcodes/3203034543.png'),
(8, '3202204238', 'Muhammad Fadhil Diandra', 'Informatika', 'qrcodes/3202204238.png'),
(9, '320220101535', 'Jeremia Paskah Putra Sinaga', 'Informatika', 'qrcodes/320220101535.png'),
(10, '320220401041', 'Ida Bagus Aditya Nugraha', 'Kedokteran', 'qrcodes/320220401041.png'),
(11, '3203304014', 'Leander Berliano Farel Kristiyono', 'Teknik Mesin', 'qrcodes/3203304014.png'),
(12, '32329309241', 'Damar Adhiwidya Suyanto', 'Fisika', 'qrcodes/32329309241.png'),
(13, '32024204158', 'Achmad Sufa Ramdlani Al Kindi', 'Farmasi', 'qrcodes/32024204158.png'),
(14, '3232940219', 'Khaerul Imam Phatoni', 'Informatika', 'qrcodes/3232940219.png'),
(15, '32022010421', 'Aziz Al Qadri Setyawan', 'Kedokteran', 'qrcodes/32022010421.png'),
(16, '322320302', 'Rafi Ahmad Naufal', 'Teknik Sipil', 'qrcodes/322320302.png'),
(17, '320230403010', 'Jonathan Rico Petruska Ginting', 'Teknik Mesin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengambilan`
--

CREATE TABLE `pengambilan` (
  `id` int(11) NOT NULL,
  `idsenjata` int(11) NOT NULL,
  `tanggal_waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_mahasiswa` varchar(255) NOT NULL,
  `id_acara_dinas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengambilan`
--

INSERT INTO `pengambilan` (`id`, `idsenjata`, `tanggal_waktu`, `id_mahasiswa`, `id_acara_dinas`) VALUES
(60, 26, '2025-01-13 20:09:41', '15', 23),
(61, 27, '2025-01-13 20:09:51', '6', 23),
(62, 31, '2025-01-13 20:09:58', '8', 23),
(63, 33, '2025-01-13 20:10:12', '10', 24),
(64, 34, '2025-01-13 20:10:24', '13', 24),
(65, 35, '2025-01-13 20:10:35', '14', 24),
(66, 38, '2025-01-13 20:10:46', '16', 24),
(67, 39, '2025-01-13 20:10:55', '11', 24),
(68, 40, '2025-01-13 20:11:12', '12', 25),
(71, 26, '2025-01-14 09:32:09', '8', 33),
(72, 26, '2025-01-14 09:32:55', '6', 33),
(73, 26, '2025-01-14 09:39:05', '6', 33),
(74, 26, '2025-01-14 09:41:26', '6', 33),
(75, 26, '2025-01-14 09:43:02', '6', 33),
(76, 26, '2025-01-14 09:45:34', '6', 33),
(77, 26, '2025-01-14 09:47:04', '8', 33);

-- --------------------------------------------------------

--
-- Table structure for table `senjata`
--

CREATE TABLE `senjata` (
  `idsenjata` int(11) NOT NULL,
  `nosenjata` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kodeqr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `senjata`
--

INSERT INTO `senjata` (`idsenjata`, `nosenjata`, `keterangan`, `kodeqr`) VALUES
(26, '00003789', 'SS2-V5', 'qrcodes/00003789.png'),
(27, '00004354', 'SS2-V5', 'qrcodes/00004354.png'),
(31, '00008753', 'SS2-V5', 'qrcodes/00008753.png'),
(33, '00003791', 'SS2-V5', 'qrcodes/00003791.png'),
(34, '0002324', 'SS2-V5', 'qrcodes/0002324.png'),
(35, '00009878', 'SS2-V5', 'qrcodes/00009878.png'),
(38, '00003532', 'SS2-V5', 'qrcodes/00003532.png'),
(39, '00002424', 'SS2-V5', 'qrcodes/00002424.png'),
(40, '00007578', 'SS2-V5', 'qrcodes/00007578.png'),
(41, '00003342', 'SS2-V5', 'qrcodes/00003342.png'),
(42, '00005768', 'G6-Combat', 'qrcodes/00005768.png'),
(43, '00003243', 'G6-Combat', 'qrcodes/00003243.png'),
(44, '00003432', 'G6-Combat', 'qrcodes/00003432.png'),
(45, '00003543', 'G6-Combat', 'qrcodes/00003543.png'),
(46, '00004649', 'G6-Combat', 'qrcodes/00004649.png'),
(47, '00008695', 'G6-Combat', 'qrcodes/00008695.png'),
(48, '00003245', 'SS2-V5', 'qrcodes/00003245.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acara_dinas`
--
ALTER TABLE `acara_dinas`
  ADD PRIMARY KEY (`id_acara_dinas`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `loginmhsw`
--
ALTER TABLE `loginmhsw`
  ADD PRIMARY KEY (`idusermhsw`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `pengambilan`
--
ALTER TABLE `pengambilan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsenjata` (`idsenjata`),
  ADD KEY `id_acara_dinas` (`id_acara_dinas`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `senjata`
--
ALTER TABLE `senjata`
  ADD PRIMARY KEY (`idsenjata`),
  ADD UNIQUE KEY `nosenjata` (`nosenjata`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acara_dinas`
--
ALTER TABLE `acara_dinas`
  MODIFY `id_acara_dinas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loginmhsw`
--
ALTER TABLE `loginmhsw`
  MODIFY `idusermhsw` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pengambilan`
--
ALTER TABLE `pengambilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `senjata`
--
ALTER TABLE `senjata`
  MODIFY `idsenjata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengambilan`
--
ALTER TABLE `pengambilan`
  ADD CONSTRAINT `pengambilan_ibfk_1` FOREIGN KEY (`idsenjata`) REFERENCES `senjata` (`idsenjata`),
  ADD CONSTRAINT `pengambilan_ibfk_2` FOREIGN KEY (`id_acara_dinas`) REFERENCES `acara_dinas` (`id_acara_dinas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
