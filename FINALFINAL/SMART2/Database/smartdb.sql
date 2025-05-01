-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 08:15 PM
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
-- Table structure for table `problemlocations`
--

CREATE TABLE `problemlocations` (
  `idd` int(11) NOT NULL,
  `problemloc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problemlocations`
--

INSERT INTO `problemlocations` (`idd`, `problemloc`) VALUES
(15, 'RM101'),
(16, 'RM102'),
(20, 'RM103'),
(22, 'RM105'),
(23, 'RM106'),
(24, 'RM104');

-- --------------------------------------------------------

--
-- Table structure for table `problemtypes`
--

CREATE TABLE `problemtypes` (
  `iddd` int(11) NOT NULL,
  `probtype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problemtypes`
--

INSERT INTO `problemtypes` (`iddd`, `probtype`) VALUES
(9, 'TV'),
(10, 'Wifi'),
(12, 'Air Conditioner'),
(13, 'Lights');

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
  `sname` varchar(255) NOT NULL,
  `sid` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_resolved` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reportdetails`
--

INSERT INTO `reportdetails` (`report_id`, `rating`, `feedback`, `rname`, `rid`, `plocation`, `problem`, `pdescription`, `sname`, `sid`, `status`, `date_reported`, `date_resolved`, `is_read`) VALUES
(1140, 4, 'good', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', 'broken', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-07 17:46:57', '2025-04-07 17:54:10', 1),
(1141, 1, 'major distraction', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-07 17:47:02', '2025-04-07 17:54:17', 1),
(1142, 2, 'a bit slow', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Air Conditioner', '', 'Leiby Rose Masanegra', 33333333333, 'Resolved', '2025-04-07 17:47:10', '2025-04-07 17:55:05', 1),
(1143, 3, 'ok', 'Kenneth Del Mundo', 44444444444, 'Other', 'Air Conditioner', 'in pe hall', 'Leiby Rose Masanegra', 33333333333, 'Resolved', '2025-04-07 17:47:23', '2025-04-07 17:55:07', 1),
(1144, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM104', 'Wifi', '', 'Chris Jumong Soler', 22222222222, 'Ongoing', '2025-04-07 17:47:28', NULL, 1),
(1145, 5, 'good', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Wifi', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-07 17:47:33', '2025-04-07 17:55:37', 1),
(1146, 5, 'great', 'Peter James Mistranza', 55555555555, 'RM102', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-07 17:51:46', '2025-04-07 17:54:13', 1),
(1147, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Ongoing', '2025-04-07 17:51:52', NULL, 1),
(1148, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Other', 'keyboard', 'Leiby Rose Masanegra', 33333333333, 'Ongoing', '2025-04-07 17:52:06', NULL, 1),
(1149, 3, 'ok', 'Peter James Mistranza', 55555555555, 'RM103', 'Wifi', '', 'Leiby Rose Masanegra', 33333333333, 'Resolved', '2025-04-07 17:52:11', '2025-04-07 17:55:09', 1),
(1150, 2, 'a little distracting', 'Peter James Mistranza', 55555555555, 'RM106', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-07 17:52:21', '2025-04-07 17:55:41', 1),
(1151, 1, 'horrible', 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-07 17:52:25', '2025-04-07 17:55:39', 1);

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
('Admin', 'Zanjoe Ladesma Soliveres', 11111111111, '$2y$10$PgkTyai.VmldO/cSdUqhEuuDyYWMoS7Ut/D4yLTWMHD6obYr13pxa', '', 0, 'Approved'),
('Maintenance Staff', 'Chris Jumong Soler', 22222222222, '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved'),
('Maintenance Staff', 'Leiby Rose Masanegra', 33333333333, '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 0, 'Approved'),
('Teacher', 'Kenneth Del Mundo', 44444444444, '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 1, 'Approved'),
('Student', 'Peter James Mistranza', 55555555555, '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Approved'),
('Student', 'Jhello Velasco', 66666666666, '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending'),
('Maintenance Staff', 'Stephen Chase Nepomuceno', 77777777777, '$2y$10$6RI8kpmwl5TbBX3EVTtYAurDRi0hHkXLW1hzHnrQP37UfqCXL2Qh6', '', 0, 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `problemlocations`
--
ALTER TABLE `problemlocations`
  ADD UNIQUE KEY `idd` (`idd`);

--
-- Indexes for table `problemtypes`
--
ALTER TABLE `problemtypes`
  ADD UNIQUE KEY `iddd` (`iddd`);

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
-- AUTO_INCREMENT for table `problemlocations`
--
ALTER TABLE `problemlocations`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `problemtypes`
--
ALTER TABLE `problemtypes`
  MODIFY `iddd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reportdetails`
--
ALTER TABLE `reportdetails`
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1152;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
