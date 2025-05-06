-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 05:42 PM
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
(1147, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-07 17:51:52', '2025-04-27 12:00:15', 1),
(1148, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Other', 'keyboard', 'Leiby Rose Masanegra', 33333333333, 'Ongoing', '2025-04-07 17:52:06', NULL, 1),
(1149, 3, 'ok', 'Peter James Mistranza', 55555555555, 'RM103', 'Wifi', '', 'Leiby Rose Masanegra', 33333333333, 'Resolved', '2025-04-07 17:52:11', '2025-04-07 17:55:09', 1),
(1150, 2, 'a little distracting', 'Peter James Mistranza', 55555555555, 'RM106', 'TV', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-07 17:52:21', '2025-04-07 17:55:41', 1),
(1151, 1, 'horrible', 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Chris Jumong Soler', 22222222222, 'Resolved', '2025-04-07 17:52:25', '2025-04-07 17:55:39', 1),
(1152, 3, 'h', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-09 13:10:10', '2025-04-27 12:30:07', 1),
(1153, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', 'HELL', 'Stephen Chase Nepomuceno', 77777777777, 'Rejected', '2025-04-09 15:02:22', NULL, 1),
(1154, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Rejected', '2025-04-25 13:49:44', NULL, 1),
(1155, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Ongoing', '2025-04-25 13:55:11', NULL, 1),
(1156, 4, 'bitch', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 11:13:05', '2025-04-27 12:00:34', 1),
(1157, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', '', 0, 'Pending', '2025-04-27 11:23:15', NULL, 1),
(1158, 1, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Other', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 12:05:05', '2025-04-27 12:05:22', 1),
(1159, 1, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 12:40:30', '2025-04-27 12:40:43', 1),
(1160, 4, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 12:49:21', '2025-04-27 12:49:28', 1),
(1161, 4, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 12:51:10', '2025-04-27 12:51:19', 1),
(1162, 2, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Wifi', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-04-27 12:52:27', '2025-04-27 12:52:35', 1),
(1163, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 12:33:37', NULL, 1),
(1164, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM101', 'TV', '', '', 0, 'Pending', '2025-05-01 13:04:31', NULL, 1),
(1165, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM102', 'Wifi', '', '', 0, 'Pending', '2025-05-01 13:05:53', NULL, 1),
(1166, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM102', 'TV', '', '', 0, 'Pending', '2025-05-01 13:07:29', NULL, 1),
(1167, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 13:27:24', NULL, 1),
(1168, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 13:34:05', NULL, 1),
(1169, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'TV', '', '', 0, 'Pending', '2025-05-01 13:37:51', NULL, 1),
(1170, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 13:40:29', NULL, 1),
(1171, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'TV', '', '', 0, 'Pending', '2025-05-01 13:48:31', NULL, 1),
(1172, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-01 13:48:42', NULL, 1),
(1173, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-01 13:50:00', NULL, 1),
(1174, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'TV', '', '', 0, 'Pending', '2025-05-01 13:50:19', NULL, 1),
(1175, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 13:50:36', NULL, 1),
(1176, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 13:50:53', NULL, 1),
(1177, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 13:51:06', NULL, 1),
(1178, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-01 14:32:21', NULL, 1),
(1179, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', '', 0, 'Pending', '2025-05-01 14:32:37', NULL, 1),
(1180, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 14:34:59', NULL, 1),
(1181, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'TV', '', '', 0, 'Pending', '2025-05-01 14:35:12', NULL, 1),
(1182, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 14:41:59', NULL, 1),
(1183, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 14:43:39', NULL, 1),
(1184, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-01 14:44:00', NULL, 1),
(1185, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 14:48:21', NULL, 1),
(1186, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 14:49:59', NULL, 1),
(1187, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'Wifi', '', '', 0, 'Pending', '2025-05-01 14:55:05', NULL, 1),
(1188, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', '', 0, 'Pending', '2025-05-01 15:09:59', NULL, 1),
(1189, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM102', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 15:21:23', NULL, 1),
(1190, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 15:26:20', NULL, 1),
(1191, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM102', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-01 15:26:36', NULL, 1),
(1192, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 07:47:49', NULL, 1),
(1193, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'TV', '', '', 0, 'Pending', '2025-05-03 07:58:11', NULL, 1),
(1194, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', '', 0, 'Pending', '2025-05-03 08:10:05', NULL, 1),
(1195, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:10:26', NULL, 1),
(1196, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'TV', '', '', 0, 'Pending', '2025-05-03 08:16:25', NULL, 1),
(1197, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:21:31', NULL, 1),
(1198, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:23:08', NULL, 1),
(1199, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:24:48', NULL, 1),
(1200, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'TV', '', '', 0, 'Pending', '2025-05-03 08:25:05', NULL, 1),
(1201, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-03 08:26:38', NULL, 1),
(1202, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', 0, 'Pending', '2025-05-03 08:29:23', NULL, 1),
(1203, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Wifi', '', '', 0, 'Pending', '2025-05-03 08:29:40', NULL, 1),
(1204, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:30:02', NULL, 1),
(1205, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:30:22', NULL, 1),
(1206, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', 0, 'Pending', '2025-05-03 08:30:33', NULL, 1),
(1207, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Rejected', '2025-05-03 08:54:30', NULL, 1),
(1208, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', 'Stephen Chase Nepomuceno', 77777777777, 'Resolved', '2025-05-03 09:04:30', '2025-05-03 11:00:31', 1),
(1209, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '', 0, 'Pending', '2025-05-03 12:04:47', NULL, 1),
(1210, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', 77777777777, 'Rejected', '2025-05-03 15:08:21', NULL, 1),
(1211, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'TV', '', 'Stephen Chase Nepomuceno', 77777777777, 'Ongoing', '2025-05-03 15:10:02', NULL, 1);

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
('Maintenance Staff', 'Chris Jumong Soler', 22222222222, '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved'),
('Maintenance Staff', 'Leiby Rose Masanegra', 33333333333, '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 0, 'Approved'),
('Teacher', 'Kenneth Del Mundo', 44444444444, '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 1, 'Approved'),
('Student', 'Peter James Mistranza', 55555555555, '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Approved'),
('Student', 'Jhello Velasco', 66666666666, '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending'),
('Maintenance Staff', 'Stephen Chase Nepomuceno', 77777777777, '$2y$10$6RI8kpmwl5TbBX3EVTtYAurDRi0hHkXLW1hzHnrQP37UfqCXL2Qh6', '', 1, 'Approved'),
('Admin', 'Zanjoe Ladesma Soliveres', 111111111111, '$2y$10$PgkTyai.VmldO/cSdUqhEuuDyYWMoS7Ut/D4yLTWMHD6obYr13pxa', '', 0, 'Approved'),
('Student', 'hello e', 122332444444, '$2y$10$86fWInav6ivxI6Kji22kf.ak2FBs6lU7aLY5krYBYXaj0r8v.5vgO', '', 0, 'Approved');

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
  ADD PRIMARY KEY (`school_id`),
  ADD UNIQUE KEY `full_name` (`full_name`),
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
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1212;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
