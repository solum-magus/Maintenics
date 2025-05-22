-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 03:49 PM
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
(24, 'RM104'),
(25, 'RM107'),
(27, 'jvhkeghwkjg');

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
(17, 'egaawhgwj');

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
  `sid` varchar(128) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_resolved` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reportdetails`
--

INSERT INTO `reportdetails` (`report_id`, `rating`, `feedback`, `rname`, `rid`, `plocation`, `problem`, `pdescription`, `sname`, `sid`, `status`, `date_reported`, `date_resolved`, `is_read`) VALUES
(1140, 4, 'good', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', 'broken', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-07 17:46:57', '2025-04-07 17:54:10', 1),
(1141, 1, 'major distraction', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-07 17:47:02', '2025-04-07 17:54:17', 1),
(1142, 2, 'a bit slow', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Air Conditioner', '', 'Leiby Rose Masanegra', '33333333333', 'Resolved', '2025-04-07 17:47:10', '2025-04-07 17:55:05', 1),
(1143, 3, 'ok', 'Kenneth Del Mundo', 44444444444, 'Other', 'Air Conditioner', 'in pe hall', 'Leiby Rose Masanegra', '33333333333', 'Resolved', '2025-04-07 17:47:23', '2025-04-07 17:55:07', 1),
(1144, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM104', 'Wifi', '', 'Chris Jumong Soler', '22222222222', 'Ongoing', '2025-04-07 17:47:28', NULL, 1),
(1145, 5, 'good', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Wifi', '', 'Chris Jumong Soler', '22222222222', 'Resolved', '2025-04-07 17:47:33', '2025-04-07 17:55:37', 1),
(1146, 5, 'great', 'Peter James Mistranza', 55555555555, 'RM102', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-07 17:51:46', '2025-04-07 17:54:13', 1),
(1147, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-07 17:51:52', '2025-04-27 12:00:15', 1),
(1148, NULL, NULL, 'Peter James Mistranza', 55555555555, 'RM104', 'Other', 'keyboard', 'Leiby Rose Masanegra', '33333333333', 'Ongoing', '2025-04-07 17:52:06', NULL, 1),
(1149, 3, 'ok', 'Peter James Mistranza', 55555555555, 'RM103', 'Wifi', '', 'Leiby Rose Masanegra', '33333333333', 'Resolved', '2025-04-07 17:52:11', '2025-04-07 17:55:09', 1),
(1150, 2, 'a little distracting', 'Peter James Mistranza', 55555555555, 'RM106', 'TV', '', 'Chris Jumong Soler', '22222222222', 'Resolved', '2025-04-07 17:52:21', '2025-04-07 17:55:41', 1),
(1151, 1, 'horrible', 'Peter James Mistranza', 55555555555, 'RM104', 'Lights', '', 'Chris Jumong Soler', '22222222222', 'Resolved', '2025-04-07 17:52:25', '2025-04-07 17:55:39', 1),
(1152, 3, 'h', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-09 13:10:10', '2025-04-27 12:30:07', 1),
(1153, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', 'HELL', 'Stephen Chase Nepomuceno', '77777777777', 'Rejected', '2025-04-09 15:02:22', NULL, 1),
(1154, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Rejected', '2025-04-25 13:49:44', NULL, 1),
(1155, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Ongoing', '2025-04-25 13:55:11', NULL, 1),
(1156, 4, 'bitch', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-27 11:13:05', '2025-04-27 12:00:34', 1),
(1157, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Resolved', '2025-04-27 11:23:15', '2025-05-20 11:10:46', 1),
(1158, 1, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM102', 'Other', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-27 12:05:05', '2025-04-27 12:05:22', 1),
(1159, 1, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-27 12:40:30', '2025-04-27 12:40:43', 1),
(1160, 4, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM103', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-27 12:49:21', '2025-04-27 12:49:28', 1),
(1161, 4, 'No feedback given.', 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-04-27 12:51:10', '2025-04-27 12:51:19', 1),
(1196, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM103', 'TV', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Resolved', '2025-05-03 08:16:25', '2025-05-20 11:10:59', 1),
(1197, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Rejected', '2025-05-03 08:21:31', NULL, 1),
(1198, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Ongoing', '2025-05-03 08:23:08', NULL, 1),
(1199, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', '0', 'Pending', '2025-05-03 08:24:48', NULL, 1),
(1200, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'TV', '', '', '0', 'Pending', '2025-05-03 08:25:05', NULL, 1),
(1201, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', '0', 'Pending', '2025-05-03 08:26:38', NULL, 1),
(1202, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', '', '0', 'Pending', '2025-05-03 08:29:23', NULL, 1),
(1203, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Wifi', '', '', '0', 'Pending', '2025-05-03 08:29:40', NULL, 1),
(1204, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', '', '0', 'Pending', '2025-05-03 08:30:02', NULL, 1),
(1205, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM102', 'Air Conditioner', '', '', '0', 'Pending', '2025-05-03 08:30:22', NULL, 1),
(1206, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', '', '0', 'Pending', '2025-05-03 08:30:33', NULL, 1),
(1207, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Rejected', '2025-05-03 08:54:30', NULL, 1),
(1208, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', '', 'Stephen Chase Nepomuceno', '77777777777', 'Resolved', '2025-05-03 09:04:30', '2025-05-03 11:00:31', 1),
(1209, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Lights', 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '', '0', 'Pending', '2025-05-03 12:04:47', NULL, 1),
(1210, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'Air Conditioner', '', 'Stephen Chase Nepomuceno', '77777777777', 'Rejected', '2025-05-03 15:08:21', NULL, 1),
(1211, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'RM101', 'TV', '', '', '', 'Rejected', '2025-05-03 15:10:02', NULL, 1),
(1212, NULL, NULL, 'among us', 141564734421, 'RM101', 'Lights', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Rejected', '2025-05-13 06:24:49', NULL, 1),
(1213, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'PE Hall', 'Air Conditioner', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Resolved', '2025-05-13 14:50:17', '2025-05-22 13:33:42', 1),
(1214, NULL, NULL, 'Kenneth Del Mundo', 44444444444, 'PE Hall', 'Lights', '', 'Zanjoe Ladesma Soliveres', '111111111111', 'Ongoing', '2025-05-13 14:50:22', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `position` varchar(20) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `school_id` varchar(128) NOT NULL,
  `hashword` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `userstatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `otp` varchar(6) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`position`, `full_name`, `school_id`, `hashword`, `bio`, `dark_mode`, `userstatus`, `otp`, `is_verified`) VALUES
('Admin', 'Zanjoe Ladesma Soliveres', '111111111111', '$2y$10$PgkTyai.VmldO/cSdUqhEuuDyYWMoS7Ut/D4yLTWMHD6obYr13pxa', '', 1, 'Approved', NULL, 0),
('Student', 'hello ewwra', '123444441324', '$2y$10$KQYSVvTs/tSKLbKTjNbE..9dFsH6amHS7DfLFmHYzVEeieE.B8gIa', '', 0, 'Approved', NULL, 0),
('Student', 'hello ew', '123444444214', '$2y$10$83gDU4VWxLKwwssf/oOOa.57Ac3JHt51I.NQVduxr9.8DZzhB2Z9.', '', 0, 'Rejected', NULL, 0),
('Student', 'hello err', '123444454244', '$2y$10$WH632ZxGNMRwhoU4js4A8uWhd0iH23Exk0k/qfQFLh.bYNkSzbA8a', '', 0, 'Approved', NULL, 0),
('Student', 'among us', '141564734421', '$2y$10$/XcuKDRP1NNba/9ynSclWepC6Rtm3rpTJP1oqEWslL./EsV/kUJ8m', '', 0, 'Approved', NULL, 0),
('Student', 'hello ewrrq', '213124241231', '$2y$10$mH6SlhGezGdeRIqhe/Ge.e2GMCm26uGvcAkERScCus3ARRznMcVzi', '', 0, 'Approved', NULL, 0),
('Maintenance Staff', 'Chris Jumong Soler', '22222222222', '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved', NULL, 0),
('Maintenance Staff', 'Leiby Rose Masanegra', '33333333333', '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 0, 'Approved', NULL, 0),
('Teacher', 'Kenneth Del Mundo', '44444444444', '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 0, 'Approved', NULL, 0),
('Student', 'Peter James Mistranza', '55555555555', '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Approved', NULL, 0),
('Student', 'Jhello Velasco', '66666666666', '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending', NULL, 0),
('Maintenance Staff', 'Stephen Chase Nepomuceno', '77777777777', '$2y$10$6RI8kpmwl5TbBX3EVTtYAurDRi0hHkXLW1hzHnrQP37UfqCXL2Qh6', '', 0, 'Approved', NULL, 0),
('Student', 'bitch ass', 'bihv.212121@meycauayan.sti.edu.ph', '$2y$10$HUoSDalyEuFxAVgkUV947erXBRsT4nSbA8yx.TOMGU/LbH9rYfk9e', '', 0, 'Approved', NULL, 0),
('Student', 'bitch ass', 'jkhgj.123456@meycauayan.sti.edu.ph', '$2y$10$zyBnEN2k8B11Db8/nytbFO5K4PJnAxNESbRiE.J67F2KM0CXYAr9u', '', 0, 'Approved', NULL, 0),
('Student', 'bitch ass', 'nepomuceno.365728@meycauayan.sti.edu.ph', '$2y$10$rYJ3uqE1riThTauMyCklaer9Ja0Oe0vqBkAYAPeDP58XMhJznwaS2', '', 0, 'Approved', '574615', 0),
('Student', 'bitch ass', 'stephenchase2728@gmail.com', '$2y$10$Xw3bWp9omwekREacwBjJouCYEYfaLgv3Pu7uN5Tjprj5aalIkbnny', '', 0, 'Approved', '268419', 0),
('Student', 'bitch ass', 'stephenchase7228@gmail.com', '$2y$10$muxdSRXV1SYfHorYS9WvQecPiiKhaMguKrNzU8ThKe1hWzlmMzn2K', '', 0, 'Approved', '725173', 0),
('Student', 'bitch ass', 'stephenchase728@gmail.com', '$2y$10$ROIkyDKDCxYXhQcw89F.BerHraX98n2TDeWQRvecC3iFIz89M5L.q', '', 0, 'Approved', '721914', 0),
('Student', 'bitch assre', 'test.121@meycauayan.sti.edu.ph', '$2y$10$Pf/MZZWi1FNzLmre20VtV.v0USofsh.0i0WKPyqNsvpcxsqmFw9gG', '', 0, 'Approved', NULL, 0),
('Maintenance Staff', 'hoe hoe', 'test.2121@meycauayan.sti.edu.ph', '$2y$10$ZLGHx6PMCpyyYPWlUAg61e/eyg2.MC9ztTlhOnWWzgsriCEeuH4Be', '', 0, 'Approved', '896953', 0);

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
  ADD UNIQUE KEY `school_id` (`school_id`),
  ADD UNIQUE KEY `school_id_2` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `problemlocations`
--
ALTER TABLE `problemlocations`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `problemtypes`
--
ALTER TABLE `problemtypes`
  MODIFY `iddd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reportdetails`
--
ALTER TABLE `reportdetails`
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1215;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
