-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 04:29 AM
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
(20, 'RM103');

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
(12, 'Air Conditioner');

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
(1072, NULL, NULL, '', 0, 'Ampi', 'TV', 'sd', '', 0, 'Rejected', '2025-03-27 06:22:40', '2025-03-29 09:01:34', 1),
(1073, NULL, NULL, '', 0, 'Ampi', 'Broken Chair', 'sd', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-03-27 06:29:54', NULL, 1),
(1074, NULL, NULL, '', 0, 'Room 101', 'Broken Chair', 'sd', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-03-27 06:32:40', NULL, 1),
(1075, NULL, NULL, '', 0, 'Ampi', 'Broken Chair', 'sd', '', 0, 'Resolved', '2025-03-27 06:33:34', NULL, 1),
(1076, NULL, NULL, '', 0, 'Room 101', 'TV', 'sadasdadasdasdasdfsdfafasfsd', '', 0, 'Resolved', '2025-03-27 06:34:31', NULL, 1),
(1077, 3, '  vawfawf', 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', '', 0, 'Resolved', '2025-03-31 09:38:17', NULL, 1),
(1078, 5, 'amongus in real life@!!!!!', 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', '', 0, 'Resolved', '2025-04-01 09:38:23', NULL, 1),
(1079, 4, ' okokok', 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:22:08', NULL, 1),
(1080, 4, ' okokok', 'Leiby Rose Masanegra', 33333333333, 'Library', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:23:05', NULL, 1),
(1081, 1, 'okokokokok', 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', 's', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:31:11', NULL, 1),
(1082, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:40:54', NULL, 1),
(1083, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:47:31', NULL, 1),
(1084, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:50:03', NULL, 1),
(1085, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:50:18', NULL, 1),
(1086, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:52:06', NULL, 1),
(1087, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:55:55', NULL, 1),
(1088, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Rejected', '2025-04-02 09:58:09', NULL, 1),
(1089, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Rejected', '2025-04-02 09:58:56', NULL, 1),
(1090, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Library', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 09:59:25', NULL, 1),
(1091, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 10:08:44', NULL, 1),
(1092, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 10:12:27', NULL, 1),
(1093, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 10:17:05', NULL, 1),
(1094, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 10:18:58', NULL, 1),
(1095, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'No Wi-Fi', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 10:19:24', NULL, 1),
(1096, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Ongoing', '2025-04-02 10:24:05', NULL, 1),
(1097, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 10:33:25', NULL, 1),
(1098, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 10:37:10', NULL, 1),
(1099, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 11:04:27', NULL, 1),
(1100, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 11:24:19', NULL, 1),
(1101, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 11:32:13', NULL, 1),
(1102, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Library', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 11:48:27', NULL, 1),
(1103, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 11:50:12', NULL, 1),
(1104, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Rejected', '2025-04-02 11:50:26', NULL, 1),
(1105, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 11:51:40', NULL, 1),
(1106, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Rejected', '2025-04-02 12:00:57', NULL, 1),
(1107, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Rejected', '2025-04-02 12:03:26', NULL, 1),
(1108, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Rejected', '2025-04-02 12:03:46', NULL, 1),
(1109, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 12:06:14', NULL, 1),
(1110, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'No Wi-Fi', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 12:07:40', NULL, 1),
(1111, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-02 12:07:55', NULL, 1),
(1112, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Chris Jumong Soler', 22222222222, 'Ongoing', '2025-04-02 12:09:14', NULL, 1),
(1113, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:10:39', NULL, 1),
(1114, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:12:41', NULL, 1),
(1115, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:13:56', NULL, 1),
(1116, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:16:34', NULL, 1),
(1117, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', '', 0, 'Pending', '2025-04-02 12:18:28', NULL, 1),
(1118, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:21:51', NULL, 1),
(1119, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 12:22:48', NULL, 1),
(1120, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 12:23:32', NULL, 1),
(1121, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 12:25:30', NULL, 1),
(1122, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Room 101', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 12:26:53', NULL, 1),
(1123, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 12:30:16', NULL, 1),
(1124, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 12:35:14', NULL, 1),
(1125, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', 'Stephen Chase Nepomuceno', 100000000000, 'Resolved', '2025-04-02 13:23:10', NULL, 1),
(1126, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'TV', '', '', 0, 'Pending', '2025-04-02 15:22:06', NULL, 1),
(1127, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'RM101', 'Broken Chair', '', '', 0, 'Pending', '2025-04-05 11:04:09', NULL, 1),
(1128, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'RM101', 'TV', '', '', 0, 'Pending', '2025-04-05 11:04:58', NULL, 1),
(1129, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'RM101', 'TV', 'hel[p', '', 0, 'Pending', '2025-04-05 11:06:09', NULL, 1),
(1130, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'Broken Chair', '', '', 0, 'Pending', '2025-04-06 08:21:30', NULL, 1),
(1131, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Ampi', 'No Wi-Fi', '', '', 0, 'Pending', '2025-04-06 08:21:45', NULL, 1),
(1132, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Library', 'No Wi-Fi', '', '', 0, 'Pending', '2025-04-06 08:22:42', NULL, 1),
(1133, NULL, NULL, 'Stephen Chase Nepomuceno', 100000000000, 'RM101', 'Broken Chair', 'ok', '', 0, 'Pending', '2025-04-06 08:59:39', NULL, 1),
(1134, NULL, NULL, 'Stephen Chase Nepomuceno', 100000000000, 'RM101', 'TV', '', '', 0, 'Pending', '2025-04-06 09:04:38', NULL, 1),
(1135, NULL, NULL, 'Stephen Chase Nepomuceno', 100000000000, '', 'TV', 'kl', '', 0, 'Pending', '2025-04-06 09:11:32', NULL, 1),
(1136, NULL, NULL, 'Stephen Chase Nepomuceno', 100000000000, 'Other', 'TV', '', '', 0, 'Pending', '2025-04-06 09:12:07', NULL, 1),
(1137, NULL, NULL, 'Stephen Chase Nepomuceno', 100000000000, 'RM101', 'Other', '', '', 0, 'Pending', '2025-04-06 09:12:22', NULL, 1),
(1138, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'RM101', 'No Wifi', 'hey\r\nbich\r\n', '', 0, 'Pending', '2025-04-06 12:27:57', NULL, 1),
(1139, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, 'Other', 'Other', '', '', 0, 'Pending', '2025-04-06 14:27:48', NULL, 1);

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
('Admin', 'Zanjoe Junel Soliveres', 11111111111, '$2y$10$PgkTyai.VmldO/cSdUqhEuuDyYWMoS7Ut/D4yLTWMHD6obYr13pxa', '', 1, 'Approved'),
('Maintenance Staff', 'Chris Jumong Soler', 22222222222, '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved'),
('Teacher', 'Leiby Rose Masanegra', 33333333333, '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 1, 'Approved'),
('Student', 'Kenneth Del Mundo', 44444444444, '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 0, 'Approved'),
('Student', 'Peter James Mistranza', 55555555555, '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Approved'),
('Student', 'Jhello Velasco', 66666666666, '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending'),
('Maintenance Staff', 'Stephen Chase Nepomuceno', 100000000000, '$2y$10$6RI8kpmwl5TbBX3EVTtYAurDRi0hHkXLW1hzHnrQP37UfqCXL2Qh6', '', 0, 'Approved'),
('Student', 'amoung uss', 122333444455, '$2y$10$hMN/BeYhf5qTPoMrHA.s5eKxIG1DxPu5ajp.c2ldMXBi3kiBYn65S', '', 0, 'Approved'),
('Student', 'hello e', 123333333333, '$2y$10$pnGoqcUNskDdQm/7f6.99uNyR2aaz2dKYI7y68n0H.Y9FuFBRACxy', '', 0, 'Approved'),
('Student', 'hello erdffswf', 123444443444, '$2y$10$8goUALe7G9H1MJ4msut1Xu9u9ikiMjz3.Otn8qJw5EdPbLdqZKzna', '', 0, 'Approved'),
('Student', 'hello erdffsw', 123444444221, '$2y$10$c/Cq39/pyY1jZwlOZ6ds4eGUhAldVIufspH5zuxA/VWRGCSiiMwhy', '', 0, 'Approved'),
('Student', 'hello erdffs', 123444444222, '$2y$10$ZD4pbCiDjCoFxhc2bHtlFOMHX466s/u33pKJtZmAFQusNydJr5Uf6', '', 0, 'Approved'),
('Student', 'hello erdff', 123444444235, '$2y$10$B0Y5sK5Kqnv6N0.LF4ymxeDwzuxuNUpkPc.mV695Ew4TqzyTZUITK', '', 0, 'Approved'),
('Student', 'Zanjoe Ladesma Soliveres', 231232132121, '$2y$10$YSRhJLpPvwYMzuKFX9o.H.Qs2fDP.WUbaBnziJo3YZUYC/8MPTwMS', '', 1, 'Approved');

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
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `problemtypes`
--
ALTER TABLE `problemtypes`
  MODIFY `iddd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reportdetails`
--
ALTER TABLE `reportdetails`
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1140;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
