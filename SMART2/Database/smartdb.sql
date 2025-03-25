-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 11:13 AM
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
(1000, 5, 'fast and efficient', 'RandomPerson', 0, 'RM101', 'Aircon', 'broken', 'Resolved', '2025-03-05 03:20:17', '2025-03-05 03:20:31', 1),
(1001, 2, 'kinda slow', 'RandomPerson', 0, 'RM101', 'TV', 'need remote', 'Resolved', '2025-03-05 03:21:39', '2025-03-05 03:22:04', 1),
(1002, 4, 'fast', 'RandomPerson', 0, 'RM101', 'Aircon', 'broken', 'Resolved', '2025-03-05 03:21:50', '2025-03-05 03:22:06', 1),
(1003, 3, 'good                                                                                                                                                                                                                                                          ', 'RandomPerson', 0, 'RM103', 'Aircon', 'broken', 'Resolved', '2025-03-05 05:02:24', '2025-03-05 05:03:23', 1),
(1004, NULL, NULL, 'RandomPerson', 0, 'RM106', 'TV', 'no internet', 'Ongoing', '2025-03-05 05:33:54', NULL, 1),
(1005, NULL, NULL, 'RandomPerson', 0, 'RM103', 'Aircon', 'broken', 'Pending', '2025-03-12 15:14:10', NULL, 1),
(1007, NULL, NULL, 'Leiby Rose Masanegra', 33333333333, '123', '123', '123', 'Resolved', '2025-03-16 18:23:21', '2025-03-05 05:03:23', 1),
(1008, NULL, NULL, 'RandomPerson', 0, 'RM103', 'Aircon', 'broken', 'Pending', '2025-03-11 17:14:10', NULL, 1),
(1009, NULL, NULL, 'RandomPerson', 0, 'RM103', 'Aircon', 'broken', 'Pending', '2025-03-24 23:14:10', NULL, 0);

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
  `userstatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`position`, `full_name`, `school_id`, `hashword`, `bio`, `userstatus`) VALUES
('Maintenance Staff', 'Stephen Chase Nepomuceno', 2000365728, '$2y$10$W0maOsmLYziuUo29Cxg.1.g2opaIEXuTyHs0PBq9hjiP4RChg27fK', '', 'Approved'),
('Admin', 'Zanjoe Junel Soliveres', 11111111111, '$2y$10$Bo6aj7R8YzazHLB1k4ljE.LOCMXmV1PdzbRyB.Mx.0hlbijCEuKq.', '', 'Approved'),
('Maintenance Staff', 'Chris Jumong Soler', 22222222222, '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 'Approved'),
('Teacher', 'Leiby Rose Masanegra', 33333333333, '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 'Approved'),
('Student', 'Kenneth Del Mundo', 44444444444, '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 'Approved'),
('Maintenance Staff', 'Peter James Mistranza', 55555555555, '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 'Pending'),
('Student', 'Jhello Velasco', 66666666666, '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 'Pending'),
('Student', 'amoung uss', 122333444455, '$2y$10$hMN/BeYhf5qTPoMrHA.s5eKxIG1DxPu5ajp.c2ldMXBi3kiBYn65S', '', 'Approved'),
('Student', 'among uss', 123456789000, '$2y$10$lws7k9I1TW089pONlVFjiuDD1a4rGDLOsPX3zoCleqh/Z.68Id5Ua', '', 'Approved');

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
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
