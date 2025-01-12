-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2025 at 09:38 AM
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
(9, 'HUT TNI', 'Luar'),
(10, 'HUT TNI', 'Luar'),
(11, 'MONAS', 'Luar');

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
(1, '320220401005', 'Ilham', 'informatika', 'qrcodes/320220401005.png'),
(2, '320220401016', 'Fadhil', 'Informatika', 'qrcodes/320220401016.png'),
(3, '320220401015', 'Zammy', 'Biologi', 'qrcodes/320220401015.png'),
(4, '320220401002', 'jere', 'Matematika', 'qrcodes/320220401002.png'),
(5, '3202202040223', 'Rizal', 'Teknik Elektro', 'qrcodes/3202202040223.png');

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
(33, 19, '2025-01-12 02:34:23', '3', 10),
(34, 17, '2025-01-12 02:36:13', '4', 11);

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
(17, '00003789', 'Senapan', 'qrcodes/00003789.png'),
(18, '00003790', 'Senapan', 'qrcodes/00003790.png'),
(19, '00003791', 'Senapan', 'qrcodes/00003791.png'),
(20, '00003792', 'Senapan', 'qrcodes/00003792.png'),
(22, '00008682', 'Senapan', 'qrcodes/00008682.png');

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
  MODIFY `id_acara_dinas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengambilan`
--
ALTER TABLE `pengambilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `senjata`
--
ALTER TABLE `senjata`
  MODIFY `idsenjata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
