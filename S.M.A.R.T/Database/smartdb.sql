-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 10:34 AM
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
  `rname` varchar(128) NOT NULL,
  `plocation` varchar(30) NOT NULL,
  `problem` varchar(50) NOT NULL,
  `pdescription` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_resolved` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reportdetails`
--

INSERT INTO `reportdetails` (`report_id`, `rname`, `plocation`, `problem`, `pdescription`, `status`, `date_reported`, `date_resolved`) VALUES
(24, 'MAWD 12 A', 'Amphitheater', 'Aircon', 'Not working, also leaks some waters', 'Resolved', '2024-11-23 17:36:21', '2024-11-23 17:52:52'),
(25, 'Chris Jumong M. Soler', 'RM101', 'Broken Chair', 'its broken', 'Resolved', '2024-11-24 14:47:13', '2024-11-24 14:48:47'),
(26, 'Jumong', 'RM101', 'amongus', 'iuimpostor', 'Resolved', '2024-11-24 18:59:50', '2024-11-24 19:00:17'),
(27, 'a', 'a', 'a', 'a', 'Resolved', '2025-02-13 13:03:19', '2025-02-24 15:25:09'),
(28, 'admin', 'r', 't', 'a', 'Resolved', '2025-02-19 13:47:27', '2025-02-24 16:02:43'),
(29, '5', '2', '3', '4', 'Resolved', '2025-02-24 16:09:29', '2025-02-24 16:09:39'),
(30, '5', 'among', 'us', 'impostor', 'Resolved', '2025-02-24 16:11:11', '2025-02-24 16:11:20'),
(31, '5', 't', 'e', 's', 'Resolved', '2025-02-24 16:13:04', '2025-02-24 16:13:13'),
(32, '5', '2', '2', '2', 'Resolved', '2025-02-24 16:14:30', '2025-02-24 16:15:35'),
(33, '5', '3', '3', '3', 'Resolved', '2025-02-24 16:15:58', '2025-02-24 16:17:13'),
(34, '5', '1', '1', '1', 'Resolved', '2025-02-24 16:18:56', '2025-02-24 16:19:02'),
(35, '5', '0', '0', '0', 'Resolved', '2025-02-24 16:26:20', '2025-02-24 16:26:26'),
(36, '5', '1', '2', '3', 'False Report', '2025-02-24 16:59:26', NULL),
(37, '5', '2', '2', '1', 'False Report', '2025-02-24 17:01:50', NULL),
(38, '5', '2', '2', '2', 'Pending', '2025-02-24 17:04:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sentfeedback`
--

CREATE TABLE `sentfeedback` (
  `id_report` bigint(15) NOT NULL,
  `user_feedback` varchar(255) NOT NULL,
  `rating` varchar(15) NOT NULL,
  `Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sentfeedback`
--

INSERT INTO `sentfeedback` (`id_report`, `user_feedback`, `rating`, `Id`) VALUES
(24, 'Good and Fast !!!', 'Excellent', 6);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `position` varchar(20) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `school_id` bigint(20) NOT NULL,
  `hashword` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`position`, `full_name`, `school_id`, `hashword`, `bio`) VALUES
('Admin', 'admin', 0, '$2y$10$l5q06kZ818ovEo8DnRHhcOO1Utoy9P6Kmryrlo3OqfQxrMrMsWh9O', ''),
('Student', 'Chris Jumong M. Soler', 1, '$2y$10$2a5Kds4HzZ75BwhgzS6rBuXdv4sYdR/2K7rdSVQBrOwGOzhg.QOHa', ''),
('Maintenance Staff', 'amongus', 2, '$2y$10$3BpuC7N8C/sW7PgIg8K4y.4RnIje5SmaENuiPlf6KXmpcngCwN2.6', ''),
('Student', '3', 3, '$2y$10$qWUYHvwQgv7ShcIk6RXiweCt2z4uC7g0snR4bVi4WEpXFqs98.B7G', ''),
('Maintenance Staff', '4', 4, '$2y$10$d2/5dzM1AiXuC61M086GH.f0F2t44llup/y2T5xxqijfHbGI5a.Gi', ''),
('Student', '5', 5, '$2y$10$butskWjfT2BME0khI01/AO8AP048sdFRuev7nIknEQLZNWbPj0HNK', ''),
('Student', 'Stephen Chase N. Nepomuceno', 2000365728, '$2y$10$79.ab/jdPlrKco.yjvtj5.2frBQBhGNMUfOFlkI8XgWlWyTLnenDm', ''),
('Student', 'Zanjoe L. Soliveres', 11111111111, '$2y$10$7ZX0LI0TUUgLW5Kx5pOUXeeCH6Xadcf1DkKoR85fPIdudIrtfj0sq', ''),
('Maintenance Staff', 'Mr. Swabe', 22222222222, '$2y$10$d.wt7oBsY4GiO/aDYCqfwOkiB5zv4GQa7WX0mIMlkfXmKC2Bu1Kxe', ''),
('Student', 'ssss', 111111111111, '$2y$10$A5SgAl8kB/YVzklp0W4ECuB45rRiyDYyywk.Hdzr9LXITn8iSk1j2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reportdetails`
--
ALTER TABLE `reportdetails`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `sentfeedback`
--
ALTER TABLE `sentfeedback`
  ADD PRIMARY KEY (`Id`);

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
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `sentfeedback`
--
ALTER TABLE `sentfeedback`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
