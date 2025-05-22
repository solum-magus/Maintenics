-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 08:10 PM
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
  `problemloc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problemlocations`
--

INSERT INTO `problemlocations` (`idd`, `problemloc`) VALUES
(1, 'RM101'),
(2, 'RM102'),
(3, 'RM103'),
(4, 'RM104'),
(5, 'RM105'),
(6, 'RM106'),
(7, 'RM107'),
(8, 'Networking Laboratory'),
(9, 'Physics Laboratory'),
(10, 'Chemical Laboratory'),
(11, 'Hotel Room'),
(12, 'Ampitheater'),
(13, 'Computer Laboratory A'),
(14, 'Computer Laboratory B'),
(15, 'Lobby'),
(16, 'Faculty Lounge'),
(17, 'PE Hall'),
(18, 'Bathroom');

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
(1, 'TV'),
(2, 'Wifi'),
(3, 'Air Conditioner'),
(4, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `reportdetails`
--

CREATE TABLE `reportdetails` (
  `report_id` bigint(15) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `rname` varchar(128) NOT NULL,
  `rid` varchar(128) NOT NULL,
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
(1015, 5, 'fast', 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', 'Physics Laboratory', 'Furniture', 'broken glass cabinet', 'Stephen Chase Nepomuceno', 'nepomuceno.365728@meycauayan.sti.edu.ph', 'Resolved', '2025-05-22 17:18:10', '2025-05-22 17:27:06', 1),
(1022, 2, 'slow', 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', 'Computer Laboratory B', 'Other', 'computer doesnt open', 'Leiby Rose Masanegra', 'masanegra.358230@meycauayan.sti.edu.ph', 'Resolved', '2025-05-22 18:05:16', '2025-05-22 18:07:56', 1),
(1023, 1, 'huh?', 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', 'Physics Laboratory', 'Air Conditioner', 'aircon doesnt work', 'Leiby Rose Masanegra', 'masanegra.358230@meycauayan.sti.edu.ph', 'Rejected', '2025-05-22 18:05:38', NULL, 1),
(1024, NULL, NULL, 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', 'Lobby', 'Other', 'hazard on floor', '', '', 'Pending', '2025-05-22 18:06:10', NULL, 1),
(1025, 5, 'great', 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', 'Bathroom', 'Furniture', 'clogged sink', 'Leiby Rose Masanegra', 'masanegra.358230@meycauayan.sti.edu.ph', 'Resolved', '2025-05-22 18:06:35', '2025-05-22 18:08:10', 1);

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
('Student', 'Kenneth Edward Del Mundo', 'delmundo.349605@meycauayan.sti.edu.ph', '$2y$10$Ac25G3JGZiDp/iBoneBap.j.QdjkVAfPSdLjajhcDiRko7JB0M2Hy', '', 1, 'Approved', NULL, 0),
('Student', 'John Christian Lomotan', 'lomotan.339274@meycauayan.sti.edu.ph', '$2y$10$BNa8EYtLU54s2b/J5a6Ja.ZWHbZXmtAJU1HJKZTjupJojfHbRbSmi', '', 1, 'Pending', NULL, 0),
('Maintenance Staff', 'Leiby Rose Masanegra', 'masanegra.358230@meycauayan.sti.edu.ph', '$2y$10$8irU3..Q6cDMJsHFGsX.0.U8vz9wV0ReY6VOvQ.ovxkPoLMgTcl4K', '', 1, 'Approved', NULL, 0),
('Student', 'Peter James Mistranza', 'mistranza.373112@meycauayan.sti.edu.ph', '$2y$10$r58QbyWDNlcwGwPh63yzUO5rvV1cPtVy6pxFj5KV85wx.dX13ZXlm', '', 1, 'Approved', NULL, 0),
('Student', 'Aug John Lei Mosende', 'mosende.376431@meycauayan.sti.edu.ph', '$2y$10$.5M852pbHqNs6tjZpWQqaeUuluGPUSOVZNYljtBCh67zm/G.0QzT2', '', 1, 'Pending', NULL, 0),
('Admin', 'Stephen Chase Nepomuceno', 'nepomuceno.365728@meycauayan.sti.edu.ph', '$2y$10$cP88bVn/ZEJKJBnvCu4xquKt3M6YAvAqgHLhWlJ5Fnw2JZZRgQuWW', '', 1, 'Approved', NULL, 0),
('Maintenance Staff', 'Chris Jumong Soler', 'soler.328374@meycauayan.sti.edu.ph', '$2y$10$iojXIJ6XV0BdSQdPC2rjLOFzyD3C9/r9PXmWMRsidsMMuzpxMfMn6', '', 1, 'Approved', NULL, 0),
('Admin', 'Zanjoe Junel Soliveres', 'soliveres.348991@meycauayan.sti.edu.ph', '$2y$10$UVUoTzsWBXEaVYDSufuYgeznjI6xqWZCp9MOWlBs163QbPEB6OcA.', '', 1, 'Approved', NULL, 0),
('Student', 'Jhello Velasco', 'velasco.368103@meycauayan.sti.edu.ph', '$2y$10$CdosHS9/HFbRmJzCmmqSmOBXJVbySOtePmVuvIp6xiOW802T.s/VW', '', 1, 'Approved', NULL, 0);

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
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `problemtypes`
--
ALTER TABLE `problemtypes`
  MODIFY `iddd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reportdetails`
--
ALTER TABLE `reportdetails`
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1026;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
