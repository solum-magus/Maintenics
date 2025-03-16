-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 11:50 AM
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

INSERT INTO `reportdetails` (`report_id`, `rating`, `feedback`, `rname`, `plocation`, `problem`, `pdescription`, `status`, `date_reported`, `date_resolved`) VALUES
(66, 4, '                                                                                    asd', 'Zanjoe Ladesma Soliveres', 'In School', 'To many stuffs', 'IDK', 'Resolved', '2025-03-05 03:20:17', '2025-03-05 03:20:31'),
(67, 4, '                            asdsad', 'Zanjoe Ladesma Soliveres', 'In MY HOUSE', 'ASDJSAJDKSADJKAJSK', 'IDK', 'Resolved', '2025-03-05 03:21:39', '2025-03-05 03:22:04'),
(68, 4, '                                                        what is this', 'Zanjoe Ladesma Soliveres', 'IN MY BASEMENT', 'HAHAHAHA', 'CRAZY STUFF', 'Resolved', '2025-03-05 03:21:50', '2025-03-05 03:22:06'),
(69, 3, '                                                                                                                                                                        This is trash super duper YEYEYEYEE', 'Zanjoe Ladesma Soliveres', 'Shitty life', 'TRASH LIFE', 'aksdjaskd', 'Resolved', '2025-03-05 05:02:24', '2025-03-05 05:03:23'),
(70, NULL, NULL, 'Zanjoe Ladesma Soliveres', 'In School', 'TO MY CLASSMATE', 'I HAVE MAN', 'Ongoing', '2025-03-05 05:33:54', NULL);

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
('Student', 'Chris Jumong M. Soler', 1, '$2y$10$2a5Kds4HzZ75BwhgzS6rBuXdv4sYdR/2K7rdSVQBrOwGOzhg.QOHa', '', 'Pending'),
('Maintenance Staff', 'amongus', 2, '$2y$10$3BpuC7N8C/sW7PgIg8K4y.4RnIje5SmaENuiPlf6KXmpcngCwN2.6', '', 'Approved'),
('Student', '3', 3, '$2y$10$qWUYHvwQgv7ShcIk6RXiweCt2z4uC7g0snR4bVi4WEpXFqs98.B7G', '', 'Pending'),
('Maintenance Staff', '4', 4, '$2y$10$d2/5dzM1AiXuC61M086GH.f0F2t44llup/y2T5xxqijfHbGI5a.Gi', '', 'Pending'),
('Student', '5', 5, '$2y$10$butskWjfT2BME0khI01/AO8AP048sdFRuev7nIknEQLZNWbPj0HNK', '', 'Pending'),
('Student', 'Stephen Chase N. Nepomuceno', 2000365728, '$2y$10$79.ab/jdPlrKco.yjvtj5.2frBQBhGNMUfOFlkI8XgWlWyTLnenDm', '', 'Pending'),
('Maintenance Staff', 'Ako ay isang Maintenance', 9564159261, '$2y$10$ms67oIi.vBoy74171nmPG.o04XDzuxVgj8YMcDtniFmizDp6vJOXm', '', 'Approved'),
('Admin', 'Ako ay isang Admin', 9564159264, '$2y$10$qwehwD06v2feEyYzAY4GpO74POZ2QrDqmdwW2kGfZ6XKlo3JZwFl6', '', 'Approved'),
('Student', 'Zanjoe Ladesma Soliveres', 9564159265, '$2y$10$bq1gqlNswY7H5WVVYhk9yuWzD1RpNkdw1l9uLmq.GOqN4Qso/G0i.', '', 'Approved'),
('Student', 'Random stuff ig', 9564159268, '$2y$10$15GhtT87XKbaykj/kJpZFe3Qd8rTnoPVQpDm4IGzJEhv4r1WK2RPK', '', 'Pending'),
('Student', 'Zanjoe L. Soliveres', 11111111111, '$2y$10$7ZX0LI0TUUgLW5Kx5pOUXeeCH6Xadcf1DkKoR85fPIdudIrtfj0sq', '', 'Pending'),
('Maintenance Staff', 'Mr. Swabe', 22222222222, '$2y$10$d.wt7oBsY4GiO/aDYCqfwOkiB5zv4GQa7WX0mIMlkfXmKC2Bu1Kxe', '', 'Approved'),
('Student', 'ssss', 111111111111, '$2y$10$A5SgAl8kB/YVzklp0W4ECuB45rRiyDYyywk.Hdzr9LXITn8iSk1j2', '', 'Pending');

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
  MODIFY `report_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
