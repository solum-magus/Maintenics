-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 11:53 AM
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
-- Database: `smartdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `reportdetails`
--

CREATE TABLE `reportdetails` (
  `report_id` bigint(15) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `rname` varchar(128) NOT NULL,
  `rid` bigint(20) NOT NULL,
  `plocation` varchar(30) NOT NULL,
  `problem` varchar(50) NOT NULL,
  `pdescription` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_resolved` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reportdetails`
--

INSERT INTO `reportdetails` (`report_id`, `rating`, `feedback`, `rname`, `rid`, `plocation`, `problem`, `pdescription`, `status`, `date_reported`, `date_resolved`, `is_read`) VALUES
(1072, NULL, NULL, '', 0, 'Ampi', 'TV', 'sd', 'Pending', '2025-03-27 06:22:40', NULL, 0),
(1073, NULL, NULL, '', 0, 'Ampi', 'Broken Chair', 'sd', 'Pending', '2025-03-27 06:29:54', NULL, 0),
(1074, NULL, NULL, '', 0, 'Room 101', 'Broken Chair', 'sd', 'Pending', '2025-03-27 06:32:40', NULL, 0),
(1075, NULL, NULL, '', 0, 'Ampi', 'Broken Chair', 'sd', 'Pending', '2025-03-27 06:33:34', NULL, 0),
(1076, NULL, NULL, '', 0, 'Room 101', 'TV', 'sadasdadasdasdasdfsdfafasfsd', 'Pending', '2025-03-27 06:34:31', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `position` varchar(20) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `school_id` bigint(20) NOT NULL,
  `hashword` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `userstatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`position`, `full_name`, `school_id`, `hashword`, `bio`, `dark_mode`, `userstatus`) VALUES
('Maintenance Staff', 'Stephen Chase Nepomuceno', 2000365728, '$2y$10$W0maOsmLYziuUo29Cxg.1.g2opaIEXuTyHs0PBq9hjiP4RChg27fK', '', 0, 'Approved'),
('Admin', 'Zanjoe Junel Soliveres', 11111111111, '$2y$10$Bo6aj7R8YzazHLB1k4ljE.LOCMXmV1PdzbRyB.Mx.0hlbijCEuKq.', '', 0, 'Approved'),
('Maintenance Staff', 'Chris Jumong Soler', 22222222222, '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved'),
('Teacher', 'Leiby Rose Masanegra', 33333333333, '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 0, 'Approved'),
('Student', 'Kenneth Del Mundo', 44444444444, '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 0, 'Approved'),
('Maintenance Staff', 'Peter James Mistranza', 55555555555, '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Pending'),
('Student', 'Jhello Velasco', 66666666666, '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending'),
('Student', 'amoung uss', 122333444455, '$2y$10$hMN/BeYhf5qTPoMrHA.s5eKxIG1DxPu5ajp.c2ldMXBi3kiBYn65S', '', 0, 'Approved'),
('Student', 'among uss', 123456789000, '$2y$10$lws7k9I1TW089pONlVFjiuDD1a4rGDLOsPX3zoCleqh/Z.68Id5Ua', '', 0, 'Approved'),
('Student', 'Zanjoe Ladesma Soliveres', 231232132121, '$2y$10$YSRhJLpPvwYMzuKFX9o.H.Qs2fDP.WUbaBnziJo3YZUYC/8MPTwMS', '', 1, 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reportdetails`
--
ALTER TABLE `reportdetails`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reportdetails`
--
ALTER TABLE `reportdetails`
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1077;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
