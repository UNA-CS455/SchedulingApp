-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2018 at 10:54 PM
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
('Keller 333', 'dbrown4@una.edu', 1, '', '2018-02-12', '2018-02-12', '15:00:00', '17:30:00', 'Once', 'hi', 48, 'jcrabtree@una.edu');

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
  `comment` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `comment`) VALUES
('Keller 122', 'Classroom', 1, 40, 0, NULL, NULL),
('Keller 133', 'Classroom', 1, 64, 0, NULL, NULL),
('Keller 220', 'Classroom', 2, 36, 0, NULL, NULL),
('Keller 222', 'Classroom', 2, 40, 0, NULL, NULL),
('Keller 227', 'Classroom', 2, 32, 0, NULL, NULL),
('Keller 320', 'Classroom', 3, 36, 0, NULL, NULL),
('Keller 322', 'Classroom', 3, 40, 0, NULL, NULL),
('Keller 327', 'Classroom', 3, 32, 0, NULL, NULL),
('Keller 333', 'Classroom', 3, 48, 0, NULL, NULL);

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
('dbrown4@una.edu', 'Derek', 'Brown', 'ADMIN', 'AA');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
