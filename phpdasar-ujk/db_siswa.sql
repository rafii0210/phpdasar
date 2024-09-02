-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 04:30 AM
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
-- Database: `db_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `name`) VALUES
(1, 'Junior Web Programming'),
(2, 'Bahasa Inggris'),
(3, 'Content Creator');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`) VALUES
(1, '---'),
(2, 'admin'),
(3, 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `nik` int(16) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_status` tinyint(3) DEFAULT NULL,
  `files` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nik`, `email`, `id_jurusan`, `gambar`, `password`, `is_status`, `files`, `created_at`, `updated_at`) VALUES
(5, 'Reza Ibrahim', 214748362, 'dani@gmail.com', 1, '666bc33a1a254.png', '$2y$10$S4ocK/Y5wjlknwhU8ZLPd.AWeVCW9lBe9mvwp3jmGEKCjSxlpP/.2', 0, '666bc316bdf06.pdf', '2024-06-14', '2024-06-14'),
(10, 'Rahmat', 987654321, 'dani@gmail.com', 1, '666bee6f48542.png', '$2y$10$UR5LufZhhO5xA4ARU9XLseLGgLSlLAl7Gi5xP92sSR.r517W8Zb2G', 0, '', '2024-06-14', '2024-06-14'),
(12, 'Reza Ibrahim', 987654321, 'dani@gmail.com', 1, '666bef27b8d06.png', '$2y$10$UruR9dPwNP0jvdDlI498Oub42JXO30NF3kFmG.FT.9J88kvSyURZi', 0, '666bef27c5fb2.pdf', '2024-06-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `username`, `email`, `password`) VALUES
(2, 2, 'Susi Susanti', 'susi@gmail.com', '$2y$10$TLOl03qG7L5T6FrJi3rUIuUxGoIvwAQ1VPmxahOuWezeVAnpvvJRK'),
(3, 3, 'Santoso Leonardo', 'santoso@gmail.com', '$2y$10$TLOl03qG7L5T6FrJi3rUIuUxGoIvwAQ1VPmxahOuWezeVAnpvvJRK');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_siswa`
-- (See below for the actual view)
--
CREATE TABLE `view_siswa` (
`id` int(11)
,`nama` varchar(45)
,`nik` int(16)
,`email` varchar(45)
,`name` varchar(45)
,`gambar` varchar(100)
,`files` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `view_siswa`
--
DROP TABLE IF EXISTS `view_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_siswa`  AS SELECT `siswa`.`id` AS `id`, `siswa`.`nama` AS `nama`, `siswa`.`nik` AS `nik`, `siswa`.`email` AS `email`, `jurusan`.`name` AS `name`, `siswa`.`gambar` AS `gambar`, `siswa`.`files` AS `files` FROM (`siswa` join `jurusan` on(`siswa`.`id_jurusan` = `jurusan`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_siswa` (`id_jurusan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_level` (`id_level`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
