-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2018 at 05:24 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs455`
--
CREATE DATABASE IF NOT EXISTS `cs455` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cs455`;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `email` varchar(100) NOT NULL,
  `roomid` varchar(100) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`email`, `roomid`, `id`) VALUES
('dbrown4@una.edu', 'Keller 122', 74),
('dbrown4@una.edu', 'Keller 133', 81),
('dbrown4@una.edu', 'Keller 220', 91),
('dbrown4@una.edu', 'Keller 320', 93),
('dbrown4@una.edu', 'Keller 222', 96),
('admin@una.edu', 'Keller 133', 98),
('admin@una.edu', 'Keller 3304', 131),
('admin@una.edu', 'Keller 122', 132),
('admin@una.edu', 'Keller 327', 138);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `roomnumber` varchar(100) NOT NULL,
  `owneremail` varchar(100) NOT NULL,
  `allowshare` tinyint(1) NOT NULL,
  `headcount` text,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `occur` varchar(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `res_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`roomnumber`, `owneremail`, `allowshare`, `headcount`, `startdate`, `enddate`, `starttime`, `endtime`, `occur`, `comment`, `id`, `res_email`) VALUES
('Keller 322', 'dbrown4@una.edu', 1, '10', '2018-04-03', '2018-04-03', '08:00:00', '10:00:00', 'Once', 'This is a test', 75, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-04', '2018-04-04', '07:00:00', '20:00:00', 'Once', 'comment', 76, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-05', '2018-04-05', '07:00:00', '20:00:00', 'Once', '', 77, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-07', '2018-04-07', '07:00:00', '20:00:00', 'Once', '', 79, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, '20', '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'Hi', 81, 'dbrown4@una.edu'),
('Keller 327', 'dbrown4@una.edu', 0, '', '2018-04-03', '2018-04-03', '13:00:00', '14:00:00', 'Once', '', 82, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, '15', '2018-04-03', '2018-04-03', '14:00:00', '15:00:00', 'Once', 'This is a comment', 83, 'dbrown4@una.edu'),
('Keller 222', 'dbrown4@una.edu', 1, '16', '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'This', 84, 'dbrown4@una.edu'),
('Keller 327', 'dbrown4@una.edu', 1, '10', '2018-04-03', '2018-04-03', '17:00:00', '20:15:00', 'Weekly', 'test', 85, 'dbrown4@una.edu'),
('Keller 220', 'dbrown4@una.edu', 0, '', '2018-04-04', '2018-04-04', '13:00:00', '14:00:00', 'Once', 'Test', 87, 'dbrown4@una.edu'),
('Keller 220', 'dbrown4@una.edu', 0, '', '2018-04-06', '2018-04-06', '14:00:00', '15:00:00', 'Once', 'test', 89, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, '42', '2018-04-06', '2018-04-06', '13:00:00', '14:00:00', 'Once', 'test', 90, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, '54', '2018-04-07', '2018-04-07', '13:00:00', '14:15:00', 'Once', '', 91, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, '45', '2018-04-06', '2018-04-06', '17:00:00', '19:00:00', 'Once', '', 92, 'dbrown4@una.edu'),
('Keller 220', 'admin@una.edu', 0, '', '2018-04-10', '2018-04-10', '13:00:00', '14:00:00', 'Once', 'bfnfghn', 93, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '15', '2018-04-09', '2018-04-09', '07:00:00', '16:00:00', 'Weekly', 'Terstsfaljsdlkfjsdalkjfasdlkjfasdlkjfasdlkjfasdlkjfaskldjflasd', 95, 'admin@una.edu'),
('Keller 3304', 'admin@una.edu', 0, '', '2018-04-10', '2018-04-10', '17:15:00', '18:00:00', 'Once', '', 96, 'admin@una.edu'),
('Keller 122', 'derekb', 0, '', '2018-04-19', '2018-04-19', '15:15:00', '17:00:00', 'null', 'asfd', 106, 'admin@una.edu'),
('Keller 122', 'afasdf', 0, '', '2018-04-17', '2018-04-17', '17:00:00', '18:00:00', 'null', 'tste', 107, 'admin@una.edu'),
('Keller 327', 'admin@una.edu', 1, '20', '2018-04-13', '2018-04-13', '13:15:00', '16:30:00', 'Once', '', 108, 'admin@una.edu'),
('Keller 122', 'test@una.edu', 1, '15', '2018-04-16', '2018-04-16', '13:00:00', '14:00:00', 'Once', 'test', 109, 'admin@una.edu'),
('Keller 220', 'test@una.edu', 0, '', '2018-04-16', '2018-04-16', '15:15:00', '18:00:00', 'Once', '', 110, 'admin@una.edu'),
('Keller 222', 'admin@una.edu', 1, '12', '2018-04-19', '2018-04-19', '08:00:00', '14:00:00', 'Once', '', 111, 'admin@una.edu'),
('Keller 133', 'admin@una.edu', 1, '3', '2018-04-19', '2018-04-19', '16:00:00', '17:00:00', 'Once', '', 112, 'admin@una.edu'),
('Keller 3304', 'test@una.edu', 1, '3', '2018-04-19', '2018-04-19', '14:00:00', '15:30:00', 'Once', '', 113, 'admin@una.edu'),
('Keller 122', '', 0, '', '2018-04-09', '2018-04-09', '17:00:00', '19:00:00', 'null', '', 114, 'admin@una.edu'),
('Keller 122', '', 0, '', '2018-04-11', '2018-04-11', '13:00:00', '16:15:00', 'null', '', 115, 'admin@una.edu'),
('Keller 122', '', 0, '', '2018-04-24', '2018-04-24', '14:00:00', '16:00:00', 'null', '', 116, 'admin@una.edu'),
('Keller 222', 'admin@una.edu', 1, '15', '2018-04-21', '2018-04-21', '14:00:00', '15:00:00', 'Once', 'test', 117, 'admin@una.edu'),
('Keller 122', '', 0, '', '2018-04-09', '2018-04-09', '10:00:00', '11:30:00', 'null', '', 119, 'admin@una.edu'),
('Keller 122', '', 0, '', '2018-04-09', '2018-04-09', '19:45:00', '20:30:00', 'null', '', 120, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '10', '2018-04-09', '2018-04-09', '14:15:00', '16:15:00', 'Once', '', 121, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '13', '2018-04-09', '2018-04-09', '14:00:00', '16:00:00', 'Once', '', 122, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '5', '2018-04-09', '2018-04-09', '12:00:00', '13:30:00', 'Once', '', 123, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '2', '2018-04-09', '2018-04-09', '14:30:00', '16:30:00', 'Once', '', 124, 'admin@una.edu'),
('Keller 122', 'admin1@una.edu', 0, '', '2018-04-16', '2018-04-16', '16:00:00', '17:30:00', 'null', 'test', 125, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, '30', '2018-04-24', '2018-04-24', '16:15:00', '16:15:00', 'Once', '', 126, 'admin@una.edu'),
('Keller 133', 'admin@una.edu', 1, '5', '2018-04-24', '2018-04-24', '17:15:00', '18:15:00', 'Once', '', 127, 'admin@una.edu');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomid` varchar(100) NOT NULL COMMENT 'The room number, or identification string.',
  `type` varchar(100) NOT NULL COMMENT 'computer lab, conference room, classroom',
  `floor` tinyint(3) NOT NULL,
  `seats` int(11) NOT NULL COMMENT 'The number of open seats',
  `hascomputers` tinyint(4) NOT NULL,
  `numcomputers` int(11) DEFAULT NULL COMMENT 'number of open computers given that hascomputers is true.',
  `blacklist` varchar(100) DEFAULT NULL COMMENT 'Comma-delimited string of group names that are blacklisted from booking this room'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `blacklist`) VALUES
('Keller 122', 'Classroom', 1, 40, 0, NULL, NULL),
('Keller 133', 'Classroom', 1, 64, 0, NULL, NULL),
('Keller 220', 'Classroom', 2, 36, 0, NULL, NULL),
('Keller 222', 'Classroom', 2, 40, 0, NULL, NULL),
('Keller 227', 'Classroom', 2, 32, 0, NULL, NULL),
('Keller 320', 'Classroom', 3, 36, 0, NULL, NULL),
('Keller 322', 'Classroom', 3, 40, 0, NULL, NULL),
('Keller 327', 'Classroom', 3, 32, 0, NULL, NULL),
('Keller 3304', 'Computer Lab', 3, 48, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `classification` varchar(200) NOT NULL,
  `permissions` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `firstname`, `lastname`, `classification`, `permissions`) VALUES
('admin@una.edu', 'Admin', 'account', 'ADMIN', 'U');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
