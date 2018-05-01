-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2018 at 11:19 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

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
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `group_id` int(11) NOT NULL,
  `numeric_room_id` int(11) NOT NULL,
  `blacklist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blacklist`
--

INSERT INTO `blacklist` (`group_id`, `numeric_room_id`, `blacklist_id`) VALUES
(2, 3, 1),
(1, 3, 2),
(1, 2, 3),
(1, 1, 4),
(1, 7, 5),
(1, 4, 8),
(1, 5, 9),
(1, 6, 10),
(2, 8, 11),
(2, 2, 12),
(2, 1, 13);

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
('admin@una.edu', 'Keller 3304', 131),
('admin@una.edu', 'Keller 122', 132),
('admin@una.edu', 'Keller 222', 142),
('admin@una.edu', 'Keller 133', 143),
('super@una.edu', 'Keller 322', 145),
('super@una.edu', 'Keller 220', 146),
('super@una.edu', 'Keller 133', 147);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'A'),
(2, 'U');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `roomnumber` varchar(100) NOT NULL,
  `owneremail` varchar(100) NOT NULL,
  `allowshare` tinyint(1) NOT NULL,
  `headcount` int(11) DEFAULT NULL,
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
('Keller 322', 'dbrown4@una.edu', 1, 10, '2018-04-03', '2018-04-03', '08:00:00', '10:00:00', 'Once', 'This is a test', 75, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, 40, '2018-04-04', '2018-04-04', '07:00:00', '20:00:00', 'Once', 'comment', 76, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, 40, '2018-04-05', '2018-04-05', '07:00:00', '20:00:00', 'Once', '', 77, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, 40, '2018-04-07', '2018-04-07', '07:00:00', '20:00:00', 'Once', '', 79, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, 20, '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'Hi', 81, 'dbrown4@una.edu'),
('Keller 327', 'dbrown4@una.edu', 0, 0, '2018-04-03', '2018-04-03', '13:00:00', '14:00:00', 'Once', '', 82, 'dbrown4@una.edu'),
('Keller 3304', 'dbrown4@una.edu', 1, 15, '2018-04-03', '2018-04-03', '14:00:00', '15:00:00', 'Once', 'This is a comment', 83, 'dbrown4@una.edu'),
('Keller 222', 'dbrown4@una.edu', 1, 16, '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'This', 84, 'dbrown4@una.edu'),
('Keller 327', 'dbrown4@una.edu', 1, 10, '2018-04-03', '2018-04-03', '17:00:00', '20:15:00', 'Weekly', 'test', 85, 'dbrown4@una.edu'),
('Keller 220', 'dbrown4@una.edu', 0, 0, '2018-04-04', '2018-04-04', '13:00:00', '14:00:00', 'Once', 'Test', 87, 'dbrown4@una.edu'),
('Keller 220', 'dbrown4@una.edu', 0, 0, '2018-04-06', '2018-04-06', '14:00:00', '15:00:00', 'Once', 'test', 89, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, 42, '2018-04-06', '2018-04-06', '13:00:00', '14:00:00', 'Once', 'test', 90, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, 54, '2018-04-07', '2018-04-07', '13:00:00', '14:15:00', 'Once', '', 91, 'dbrown4@una.edu'),
('Keller 133', 'dbrown4@una.edu', 1, 45, '2018-04-06', '2018-04-06', '17:00:00', '19:00:00', 'Once', '', 92, 'dbrown4@una.edu'),
('Keller 220', 'admin@una.edu', 0, 0, '2018-04-10', '2018-04-10', '13:00:00', '14:00:00', 'Once', 'bfnfghn', 93, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 15, '2018-04-09', '2018-04-09', '07:00:00', '16:00:00', 'Weekly', 'Terstsfaljsdlkfjsdalkjfasdlkjfasdlkjfasdlkjfasdlkjfaskldjflasd', 95, 'admin@una.edu'),
('Keller 3304', 'admin@una.edu', 0, 0, '2018-04-10', '2018-04-10', '17:15:00', '18:00:00', 'Once', '', 96, 'admin@una.edu'),
('Keller 122', 'derekb', 0, 0, '2018-04-19', '2018-04-19', '15:15:00', '17:00:00', 'null', 'asfd', 106, 'admin@una.edu'),
('Keller 122', 'afasdf', 0, 0, '2018-04-17', '2018-04-17', '17:00:00', '18:00:00', 'null', 'tste', 107, 'admin@una.edu'),
('Keller 327', 'admin@una.edu', 1, 20, '2018-04-13', '2018-04-13', '13:15:00', '16:30:00', 'Once', '', 108, 'admin@una.edu'),
('Keller 122', 'test@una.edu', 1, 15, '2018-04-16', '2018-04-16', '13:00:00', '14:00:00', 'Once', 'test', 109, 'admin@una.edu'),
('Keller 220', 'test@una.edu', 0, 0, '2018-04-16', '2018-04-16', '15:15:00', '18:00:00', 'Once', '', 110, 'admin@una.edu'),
('Keller 222', 'admin@una.edu', 1, 12, '2018-04-19', '2018-04-19', '08:00:00', '14:00:00', 'Once', '', 111, 'admin@una.edu'),
('Keller 133', 'admin@una.edu', 1, 3, '2018-04-19', '2018-04-19', '16:00:00', '17:00:00', 'Once', '', 112, 'admin@una.edu'),
('Keller 3304', 'test@una.edu', 1, 3, '2018-04-19', '2018-04-19', '14:00:00', '15:30:00', 'Once', '', 113, 'admin@una.edu'),
('Keller 122', '', 0, 0, '2018-04-09', '2018-04-09', '17:00:00', '19:00:00', 'null', '', 114, 'admin@una.edu'),
('Keller 122', '', 0, 0, '2018-04-11', '2018-04-11', '13:00:00', '16:15:00', 'null', '', 115, 'admin@una.edu'),
('Keller 122', '', 0, 0, '2018-04-24', '2018-04-24', '14:00:00', '16:00:00', 'null', '', 116, 'admin@una.edu'),
('Keller 222', 'admin@una.edu', 1, 15, '2018-04-21', '2018-04-21', '14:00:00', '15:00:00', 'Once', 'test', 117, 'admin@una.edu'),
('Keller 122', '', 0, 0, '2018-04-09', '2018-04-09', '10:00:00', '11:30:00', 'null', '', 119, 'admin@una.edu'),
('Keller 122', '', 0, 0, '2018-04-09', '2018-04-09', '19:45:00', '20:30:00', 'null', '', 120, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 10, '2018-04-09', '2018-04-09', '14:15:00', '16:15:00', 'Once', '', 121, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 13, '2018-04-09', '2018-04-09', '14:00:00', '16:00:00', 'Once', '', 122, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 5, '2018-04-09', '2018-04-09', '12:00:00', '13:30:00', 'Once', '', 123, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 2, '2018-04-09', '2018-04-09', '14:30:00', '16:30:00', 'Once', '', 124, 'admin@una.edu'),
('Keller 122', 'admin1@una.edu', 0, 0, '2018-04-16', '2018-04-16', '16:00:00', '17:30:00', 'null', 'test', 125, 'admin@una.edu'),
('Keller 122', 'admin@una.edu', 1, 30, '2018-04-24', '2018-04-24', '16:15:00', '16:15:00', 'Once', '', 126, 'admin@una.edu'),
('Keller 133', 'admin@una.edu', 1, 5, '2018-04-24', '2018-04-24', '17:15:00', '18:15:00', 'Once', '', 127, 'admin@una.edu'),
('Keller 122', 'super@una.edu', 1, 20, '2018-05-01', '2018-05-01', '14:00:00', '15:00:00', 'Once', '', 128, 'super@una.edu'),
('Keller 122', 'super@una.edu', 0, 0, '2018-05-11', '2018-05-11', '14:30:00', '16:15:00', 'Once', '', 129, 'super@una.edu'),
('Keller 122', 'super@una.edu', 1, 14, '2018-05-11', '2018-05-11', '16:15:00', '17:00:00', 'Once', '', 130, 'super@una.edu');

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
  `numeric_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `numeric_id`) VALUES
('Keller 122', 'Classroom', 1, 40, 0, NULL, 1),
('Keller 133', 'Classroom', 1, 64, 0, NULL, 2),
('Keller 220', 'Classroom', 2, 36, 0, NULL, 3),
('Keller 222', 'Classroom', 2, 40, 0, NULL, 4),
('Keller 227', 'Classroom', 2, 32, 0, NULL, 5),
('Keller 320', 'Classroom', 3, 36, 0, NULL, 6),
('Keller 322', 'Classroom', 3, 40, 0, NULL, 7),
('Keller 327', 'Classroom', 3, 32, 0, NULL, 8),
('Keller 333', 'Computer Lab', 3, 48, 0, 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `classification` varchar(200) NOT NULL,
  `groupID` int(2) DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `firstname`, `lastname`, `classification`, `groupID`) VALUES
('admin@una.edu', 'Admin', 'account', 'ADMIN', 1),
('dbrown@una.edu', 'derek', 'brown', 'student', 2),
('super@una.edu', 'Admin', 'account', 'ADMIN', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`blacklist_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`numeric_id`),
  ADD UNIQUE KEY `roomid` (`roomid`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `blacklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `numeric_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
