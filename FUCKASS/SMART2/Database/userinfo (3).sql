-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 01:20 PM
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
('Student', 'fwaf wfafwff', '0', '$2y$10$HUoSDalyEuFxAVgkUV947erXBRsT4nSbA8yx.TOMGU/LbH9rYfk9e', '', 0, 'Approved', NULL, 0),
('Admin', 'Zanjoe Ladesma Soliveres', '111111111111', '$2y$10$PgkTyai.VmldO/cSdUqhEuuDyYWMoS7Ut/D4yLTWMHD6obYr13pxa', '', 1, 'Approved', NULL, 0),
('Teacher', 'wrarafwaf fwafaw', '122436333333', '$2y$10$vGi/aA.eNmJKmZVsoEsz6u54lzMDHvR1Y/m1DL1s2eNxx89TPCPjG', '', 0, 'Approved', NULL, 0),
('Teacher', 'wrarafwaf fwafagegew', '122436333343', '$2y$10$g2szn2oWI/bwuEWwtYugx.ZCL287eZfvL8l7Rk4MmUdXtkOE44Xcm', '', 0, 'Approved', NULL, 0),
('Teacher', 'hello erdffrwr', '123333323333', '$2y$10$qW1MEDlDY0/qHceCBJeEOOSTB.9xAxCYylBJ4m7qCcDaMg7ecgxvS', '', 0, 'Approved', NULL, 0),
('Student', 'hello ewwra', '123444441324', '$2y$10$KQYSVvTs/tSKLbKTjNbE..9dFsH6amHS7DfLFmHYzVEeieE.B8gIa', '', 0, 'Approved', NULL, 0),
('Student', 'hello ew', '123444444214', '$2y$10$83gDU4VWxLKwwssf/oOOa.57Ac3JHt51I.NQVduxr9.8DZzhB2Z9.', '', 0, 'Rejected', NULL, 0),
('Student', 'hello err', '123444454244', '$2y$10$WH632ZxGNMRwhoU4js4A8uWhd0iH23Exk0k/qfQFLh.bYNkSzbA8a', '', 0, 'Approved', NULL, 0),
('Student', 'among us', '141564734421', '$2y$10$/XcuKDRP1NNba/9ynSclWepC6Rtm3rpTJP1oqEWslL./EsV/kUJ8m', '', 0, 'Approved', NULL, 0),
('Student', 'hello ewrrq', '213124241231', '$2y$10$mH6SlhGezGdeRIqhe/Ge.e2GMCm26uGvcAkERScCus3ARRznMcVzi', '', 0, 'Approved', NULL, 0),
('Student', 'ewr qr', '213241512515', '$2y$10$E14JTQEMNpU3YItenIT3Re5psb0VPln17XIhpEnTF3476w0ObcJh.', '', 0, 'Approved', NULL, 0),
('Maintenance Staff', 'Chris Jumong Soler', '22222222222', '$2y$10$tzo0eE7EgTgXCRmuPTSffeowQJR5.OyTOnJsbRCNLfof6YwOGtmfa', '', 0, 'Approved', NULL, 0),
('Maintenance Staff', 'Leiby Rose Masanegra', '33333333333', '$2y$10$ajg4.tN.lwG/QsaMqdZMzeJJ0iG7RJ5jE1DHsg/mENunBaMvB2BkK', '', 0, 'Approved', NULL, 0),
('Teacher', 'Kenneth Del Mundo', '44444444444', '$2y$10$F0v2vBYbRbWeIzy8GGHJJO4/qJwj5k/sQz0ZsrXIx9JHm24daVuNe', '', 0, 'Approved', NULL, 0),
('Student', 'Peter James Mistranza', '55555555555', '$2y$10$GstnnmCq5.P5UZmP53LvieADCWz3sx25W0UktD.v3cU4i0rKey0Le', '', 0, 'Approved', NULL, 0),
('Student', 'Jhello Velasco', '66666666666', '$2y$10$Bkm7Bk0jom3/4uJhCO529e14ctUrp2fkh3XK5Wa4lMfD4YkIZjTli', '', 0, 'Pending', NULL, 0),
('Maintenance Staff', 'Stephen Chase Nepomuceno', '77777777777', '$2y$10$6RI8kpmwl5TbBX3EVTtYAurDRi0hHkXLW1hzHnrQP37UfqCXL2Qh6', '', 0, 'Approved', NULL, 0),
('Teacher', 'fa fw fwfafa', 'amoung.123456@meycauayan.sti.edu.ph', '$2y$10$Pf/MZZWi1FNzLmre20VtV.v0USofsh.0i0WKPyqNsvpcxsqmFw9gG', '', 0, 'Approved', NULL, 0),
('Teacher', 'hello eddd', 'jkhgj.123456@meycauayan.sti.edu.ph', '$2y$10$zyBnEN2k8B11Db8/nytbFO5K4PJnAxNESbRiE.J67F2KM0CXYAr9u', '', 0, 'Approved', NULL, 0),
('Student', 'hello ecv', 'nepomuceno.365728@meycauayan.sti.edu.ph', '$2y$10$rYJ3uqE1riThTauMyCklaer9Ja0Oe0vqBkAYAPeDP58XMhJznwaS2', '', 0, 'Approved', '574615', 0),
('Student', 'hello ecvdwfe', 'stephenchase728@gmail.com', '$2y$10$muxdSRXV1SYfHorYS9WvQecPiiKhaMguKrNzU8ThKe1hWzlmMzn2K', '', 0, 'Approved', '725173', 0),
('Student', 'hello ecvdw', 'stephenchase78@gmail.com', '$2y$10$ZLGHx6PMCpyyYPWlUAg61e/eyg2.MC9ztTlhOnWWzgsriCEeuH4Be', '', 0, 'Approved', '896953', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`school_id`),
  ADD UNIQUE KEY `full_name` (`full_name`),
  ADD UNIQUE KEY `school_id` (`school_id`),
  ADD UNIQUE KEY `school_id_2` (`school_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
