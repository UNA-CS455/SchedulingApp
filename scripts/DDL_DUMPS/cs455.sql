-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2018 at 06:16 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1
CREATE DATABASE cs455;
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
('Keller 122', 'super@una.edu', 1, 14, '2018-05-11', '2018-05-11', '16:15:00', '17:00:00', 'Once', '', 130, 'super@una.edu'),
('Keller 327', 'Jbond', 0, 0, '2018-06-12', '2018-06-12', '13:00:00', '15:15:00', 'null', '', 132, 'super@una.edu'),
('Keller 322', 'super@una.edu', 0, 0, '2018-06-18', '2018-06-18', '18:30:00', '19:30:00', 'Once', '', 136, 'super@una.edu');

-- --------------------------------------------------------

--
-- Table structure for table `roomdat`
--

CREATE TABLE `roomdat` (
  `Term Code` varchar(9) DEFAULT NULL,
  `Term Description` varchar(16) DEFAULT NULL,
  `Full/Part Term Description` varchar(26) DEFAULT NULL,
  `Course CRN` int(10) DEFAULT NULL,
  `Course Subject` varchar(14) DEFAULT NULL,
  `Course Number` int(13) DEFAULT NULL,
  `Course Sequence Number` int(22) DEFAULT NULL,
  `Building Name` varchar(13) DEFAULT NULL,
  `Room Number` int(11) DEFAULT NULL,
  `Course Start Time` int(17) DEFAULT NULL,
  `Course End Time` int(15) DEFAULT NULL,
  `Course Start Date` date DEFAULT NULL,
  `Course End Date` date DEFAULT NULL,
  `Sunday Indicator` varchar(16) DEFAULT NULL,
  `Monday Indicator` varchar(16) DEFAULT NULL,
  `Tuesday Indicator` varchar(17) DEFAULT NULL,
  `Wednesday Indicator` varchar(19) DEFAULT NULL,
  `Thursday Indicator` varchar(18) DEFAULT NULL,
  `Friday Indicator` varchar(16) DEFAULT NULL,
  `Saturday Indicator` varchar(18) DEFAULT NULL,
  `Course Maximum Enrollment` int(25) DEFAULT NULL,
  `Course Enrollment` int(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomdat`
--

INSERT INTO `roomdat` (`Term Code`, `Term Description`, `Full/Part Term Description`, `Course CRN`, `Course Subject`, `Course Number`, `Course Sequence Number`, `Building Name`, `Room Number`, `Course Start Time`, `Course End Time`, `Course Start Date`, `Course End Date`, `Sunday Indicator`, `Monday Indicator`, `Tuesday Indicator`, `Wednesday Indicator`, `Thursday Indicator`, `Friday Indicator`, `Saturday Indicator`, `Course Maximum Enrollment`, `Course Enrollment`) VALUES
('201820', 'Spring 2018', 'Full Term', 20113, 'MG', 331, 1, 'KELLER', 133, 930, 1045, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 40, 24),
('201820', 'Spring 2018', 'Full Term', 20119, 'MG', 362, 1, 'KELLER', 133, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 45, 28),
('201820', 'Spring 2018', 'Full Term', 20122, 'MG', 391, 1, 'KELLER', 333, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 48, 47),
('201820', 'Spring 2018', 'Full Term', 20140, 'MG', 382, 1, 'KELLER', 133, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 50, 39),
('201820', 'Spring 2018', 'Full Term', 20141, 'MG', 382, 2, 'KELLER', 133, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 50, 33),
('201820', 'Spring 2018', 'Full Term', 20146, 'MG', 491, 1, 'RABURN', 109, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 45, 38),
('201820', 'Spring 2018', 'Full Term', 20147, 'MG', 494, 0, 'KELLER', 120, 1700, 1900, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 10, 5),
('201820', 'Spring 2018', 'Full Term', 20180, 'MK', 363, 1, 'KELLER', 322, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 42, 42),
('201820', 'Spring 2018', 'Full Term', 20183, 'MK', 461, 1, 'KELLER', 220, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 36, 35),
('201820', 'Spring 2018', 'Full Term', 20219, 'CS', 155, 1, 'RABURN', 206, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 28),
('201820', 'Spring 2018', 'Full Term', 20221, 'CS', 255, 1, 'RABURN', 110, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 25),
('201820', 'Spring 2018', 'Full Term', 20226, 'CS', 455, 1, 'RABURN', 210, 1500, 1745, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 24, 15),
('201820', 'Spring 2018', 'Full Term', 20227, 'CS', 470, 1, 'RABURN', 206, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 21),
('201820', 'Spring 2018', 'Full Term', 20738, 'EC', 251, 1, 'RABURN', 104, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 60, 50),
('201820', 'Spring 2018', 'Full Term', 20739, 'EC', 251, 2, 'KELLER', 333, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 48, 36),
('201820', 'Spring 2018', 'Full Term', 20740, 'EC', 251, 3, 'RABURN', 110, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 39),
('201820', 'Spring 2018', 'Full Term', 20743, 'EC', 252, 2, 'KELLER', 133, 1100, 1150, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 64, 61),
('201820', 'Spring 2018', 'Full Term', 20744, 'EC', 252, 3, 'KELLER', 133, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 64, 36),
('201820', 'Spring 2018', 'Full Term', 20746, 'EC', 341, 1, 'KELLER', 227, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 32, 9),
('201820', 'Spring 2018', 'Full Term', 20753, 'FI', 393, 1, 'KELLER', 222, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 40, 21),
('201820', 'Spring 2018', 'Full Term', 20754, 'FI', 393, 2, 'KELLER', 222, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 40, 40),
('201820', 'Spring 2018', 'Full Term', 20756, 'FI', 423, 1, 'KELLER', 227, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 32, 20),
('201820', 'Spring 2018', 'Full Term', 20757, 'FI', 470, 1, 'KELLER', 221, 1800, 2045, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 10, 10),
('201820', 'Spring 2018', 'Full Term', 20759, 'FI', 495, 1, 'KELLER', 222, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 19),
('201820', 'Spring 2018', 'Full Term', 20759, 'FI', 495, 1, 'RABURN', 211, 1200, 1315, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 30, 19),
('201820', 'Spring 2018', 'Full Term', 20760, 'FI', 498, 1, 'RABURN', 110, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 31),
('201820', 'Spring 2018', 'Full Term', 20763, 'QM', 291, 1, 'KELLER', 227, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 32, 32),
('201820', 'Spring 2018', 'Full Term', 20764, 'QM', 291, 2, 'RABURN', 104, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 42, 41),
('201820', 'Spring 2018', 'Full Term', 20766, 'QM', 292, 1, 'RABURN', 104, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 60, 34),
('201820', 'Spring 2018', 'Full Term', 20767, 'QM', 292, 2, 'RABURN', 104, 1800, 2045, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 45, 14),
('201820', 'Spring 2018', 'Full Term', 20769, 'QM', 292, 3, 'RABURN', 104, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 65, 65),
('201820', 'Spring 2018', 'Full Term', 20774, 'EC', 391, 1, 'RABURN', 104, 1100, 1150, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 50, 37),
('201820', 'Spring 2018', 'Full Term', 20776, 'EC', 453, 1, 'KELLER', 227, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 32, 6),
('201820', 'Spring 2018', 'Full Term', 20924, 'CIS', 125, 1, 'RABURN', 211, 800, 850, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 30, 11),
('201820', 'Spring 2018', 'Full Term', 20925, 'CIS', 125, 2, 'RABURN', 211, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 20926, 'CIS', 125, 3, 'RABURN', 211, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 20927, 'CIS', 125, 4, 'RABURN', 211, 1630, 1745, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 17),
('201820', 'Spring 2018', 'Full Term', 20928, 'CIS', 125, 5, 'RABURN', 211, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 20929, 'CIS', 125, 6, 'RABURN', 211, 930, 1045, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 30, 17),
('201820', 'Spring 2018', 'Full Term', 20930, 'CIS', 125, 7, 'RABURN', 211, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 30, 26),
('201820', 'Spring 2018', 'Full Term', 20931, 'CIS', 125, 8, 'RABURN', 211, 1230, 1345, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 30, 15),
('201820', 'Spring 2018', 'Full Term', 20932, 'CIS', 125, 9, 'RABURN', 211, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 30, 17),
('201820', 'Spring 2018', 'Full Term', 20933, 'CIS', 125, 10, 'RABURN', 211, 1400, 1515, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 30, 11),
('201820', 'Spring 2018', 'Full Term', 20937, 'CIS', 225, 1, 'RABURN', 210, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 24, 23),
('201820', 'Spring 2018', 'Full Term', 20938, 'CIS', 225, 2, 'RABURN', 210, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 24, 16),
('201820', 'Spring 2018', 'Full Term', 20939, 'CIS', 236, 1, 'RABURN', 210, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 24, 25),
('201820', 'Spring 2018', 'Full Term', 20942, 'CIS', 330, 1, 'KELLER', 222, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 16),
('201820', 'Spring 2018', 'Full Term', 20946, 'CIS', 366, 1, 'RABURN', 211, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 24, 17),
('201820', 'Spring 2018', 'Full Term', 20947, 'CIS', 376, 1, 'RABURN', 206, 1500, 1615, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 23),
('201820', 'Spring 2018', 'Full Term', 20949, 'CIS', 445, 1, 'RABURN', 210, 930, 1045, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 24, 6),
('201820', 'Spring 2018', 'Full Term', 20954, 'CIS', 486, 1, 'RABURN', 211, 1530, 1645, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 15),
('201820', 'Spring 2018', 'Full Term', 20998, 'AC', 391, 1, 'RABURN', 104, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 45, 39),
('201820', 'Spring 2018', 'Full Term', 21458, 'FI', 635, 1, 'RABURN', 110, 1800, 2045, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 35, 17),
('201820', 'Spring 2018', 'Full Term', 21617, 'EC', 251, 0, 'KELLER', 220, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 10, 4),
('201820', 'Spring 2018', 'Full Term', 21980, 'MG', 498, 1, 'KELLER', 133, 1330, 1445, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 64, 41),
('201820', 'Spring 2018', 'Full Term', 22234, 'CIS', 236, 2, 'RABURN', 211, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 29),
('201820', 'Spring 2018', 'Full Term', 22304, 'CIS', 236, 3, 'RABURN', 211, 1500, 1615, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 15),
('201820', 'Spring 2018', 'Full Term', 22313, 'FI', 393, 3, 'RABURN', 110, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 35),
('201820', 'Spring 2018', 'Full Term', 22739, 'MG', 462, 1, 'KELLER', 122, 1800, 2045, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 30, 9),
('201820', 'Spring 2018', 'Full Term', 22744, 'CIS', 236, 4, 'RABURN', 210, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 24, 22),
('201820', 'Spring 2018', 'Full Term', 22757, 'MG', 350, 1, 'RABURN', 109, 1100, 1150, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 30, 22),
('201820', 'Spring 2018', 'Full Term', 23208, 'BL', 240, 1, 'KELLER', 333, 1100, 1150, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 45, 44),
('201820', 'Spring 2018', 'Full Term', 23210, 'BL', 240, 2, 'KELLER', 333, 1200, 1250, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 45, 39),
('201820', 'Spring 2018', 'Full Term', 23214, 'MK', 462, 1, 'RABURN', 110, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 21),
('201820', 'Spring 2018', 'Full Term', 23635, 'CS', 310, 1, 'RABURN', 110, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 21),
('201820', 'Spring 2018', 'Full Term', 23638, 'BL', 240, 4, 'KELLER', 122, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 42, 34),
('201820', 'Spring 2018', 'Full Term', 23653, 'AC', 291, 2, 'KELLER', 333, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 45, 44),
('201820', 'Spring 2018', 'Full Term', 23655, 'AC', 291, 3, 'KELLER', 122, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 35),
('201820', 'Spring 2018', 'Full Term', 23656, 'AC', 291, 4, 'KELLER', 320, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 35, 21),
('201820', 'Spring 2018', 'Full Term', 23657, 'AC', 292, 4, 'KELLER', 322, 1800, 2045, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 40, 10),
('201820', 'Spring 2018', 'Full Term', 23658, 'AC', 292, 1, 'RABURN', 104, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 67, 67),
('201820', 'Spring 2018', 'Full Term', 23659, 'AC', 292, 2, 'KELLER', 122, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 37),
('201820', 'Spring 2018', 'Full Term', 23660, 'AC', 292, 3, 'KELLER', 122, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 39),
('201820', 'Spring 2018', 'Full Term', 23661, 'AC', 390, 1, 'KELLER', 320, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 23664, 'AC', 392, 1, 'KELLER', 322, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 39),
('201820', 'Spring 2018', 'Full Term', 23665, 'AC', 395, 1, 'KELLER', 327, 1800, 2045, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 21),
('201820', 'Spring 2018', 'Full Term', 23665, 'AC', 395, 1, 'RABURN', 211, 1930, 2045, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 21),
('201820', 'Spring 2018', 'Full Term', 23666, 'AC', 471, 1, 'KELLER', 320, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 36, 32),
('201820', 'Spring 2018', 'Full Term', 23667, 'AC', 472, 1, 'KELLER', 322, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 28),
('201820', 'Spring 2018', 'Full Term', 23668, 'AC', 473, 1, 'KELLER', 220, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 21),
('201820', 'Spring 2018', 'Full Term', 23670, 'AC', 481, 1, 'RABURN', 104, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 28),
('201820', 'Spring 2018', 'Full Term', 23891, 'CS', 135, 3, 'RABURN', 206, 800, 915, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 12),
('201820', 'Spring 2018', 'Full Term', 23892, 'CS', 135, 4, 'RABURN', 206, 1400, 1515, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 23894, 'CS', 135, 1, 'RABURN', 206, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 23987, 'MG', 395, 1, 'RABURN', 104, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 55, 41),
('201820', 'Spring 2018', 'Full Term', 24033, 'CIS', 289, 1, 'KELLER', 234, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 24, 24),
('201820', 'Spring 2018', 'Full Term', 24092, 'CS', 155, 2, 'RABURN', 206, 1230, 1345, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 30),
('201820', 'Spring 2018', 'Full Term', 24202, 'AC', 291, 1, 'KELLER', 333, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 40, 40),
('201820', 'Spring 2018', 'Full Term', 24299, 'MK', 465, 1, 'RABURN', 109, 1100, 1150, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 15),
('201820', 'Spring 2018', 'Full Term', 24312, 'MG', 234, 1, 'KELLER', 120, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 17, 8),
('201820', 'Spring 2018', 'Full Term', 24326, 'EC', 252, 1, 'RABURN', 104, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 60, 31),
('201820', 'Spring 2018', 'Full Term', 24328, 'QM', 291, 3, 'RABURN', 109, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 29),
('201820', 'Spring 2018', 'Full Term', 24514, 'CS', 430, 1, 'RABURN', 206, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 30, 10),
('201820', 'Spring 2018', 'Full Term', 24515, 'CS', 249, 1, 'RABURN', 110, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 15, 14),
('201820', 'Spring 2018', 'Full Term', 24517, 'CIS', 476, 1, 'RABURN', 210, 1500, 1745, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 24, 15),
('201820', 'Spring 2018', 'Full Term', 24518, 'CIS', 344, 1, 'RABURN', 210, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 24, 23),
('201820', 'Spring 2018', 'Full Term', 24519, 'CIS', 249, 1, 'RABURN', 110, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 15, 10),
('201820', 'Spring 2018', 'Full Term', 24567, 'MG', 474, 1, 'KELLER', 120, 1500, 1615, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 15, 8),
('201820', 'Spring 2018', 'Full Term', 24568, 'MG', 640, 1, 'KELLER', 122, 1500, 1700, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 22, 22),
('201820', 'Spring 2018', 'Full Term', 24657, 'FI', 493, 1, 'RABURN', 110, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 20, 10),
('201820', 'Spring 2018', 'Full Term', 24659, 'FI', 593, 1, 'RABURN', 110, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 20, 1),
('201820', 'Spring 2018', 'Full Term', 24661, 'PHL', 250, 1, 'RABURN', 110, 900, 950, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 40, 39),
('201820', 'Spring 2018', 'Full Term', 24814, 'QM', 292, 4, 'RABURN', 104, 1530, 1645, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 60, 32),
('201820', 'Spring 2018', 'Full Term', 24824, 'CS', 135, 2, 'RABURN', 206, 1330, 1445, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 30, 18),
('201820', 'Spring 2018', 'Full Term', 24844, 'HI', 201, 4, 'KELLER', 222, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 40),
('201820', 'Spring 2018', 'Full Term', 24847, 'HI', 201, 6, 'KELLER', 222, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 38),
('201820', 'Spring 2018', 'Full Term', 24857, 'HI', 390, 1, 'RABURN', 109, 1000, 1050, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 25, 25),
('201820', 'Spring 2018', 'Full Term', 24867, 'PHL', 250, 2, 'RABURN', 110, 1100, 1150, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', 'F', '', 40, 40),
('201820', 'Spring 2018', 'Full Term', 24868, 'PHL', 250, 3, 'RABURN', 109, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 40, 39),
('201820', 'Spring 2018', 'Full Term', 25111, 'AC', 697, 1, 'KELLER', 320, 1800, 2045, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 25, 3),
('201820', 'Spring 2018', 'Full Term', 25115, 'CS', 355, 1, 'RABURN', 206, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 30, 9),
('201820', 'Spring 2018', 'Full Term', 25116, 'CIS', 430, 1, 'RABURN', 210, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 21, 17),
('201820', 'Spring 2018', 'Full Term', 25120, 'CIS', 651, 1, 'RABURN', 210, 930, 1045, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 3, 1),
('201820', 'Spring 2018', 'Full Term', 25121, 'AC', 694, 1, 'KELLER', 320, 1800, 2045, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 25, 1),
('201820', 'Spring 2018', 'Second Half Term', 25217, 'EMB', 612, 1, 'KELLER', 122, 1000, 1200, '0000-00-00', '0000-00-00', '', '', '', 'W', '', '', '', 30, 26),
('201820', 'Spring 2018', 'Full Term', 25242, 'AC', 650, 1, 'KELLER', 320, 1800, 2045, '0000-00-00', '0000-00-00', '', '', '', '', 'R', '', '', 25, 2),
('201820', 'Spring 2018', 'First Half Term', 25248, 'AC', 642, 1, 'KELLER', 320, 1300, 1500, '0000-00-00', '0000-00-00', '', '', 'T', '', '', '', '', 30, 19),
('201820', 'Spring 2018', 'First Half Term', 25249, 'FI', 632, 1, 'KELLER', 327, 1200, 1400, '0000-00-00', '0000-00-00', '', 'M', '', '', '', '', '', 30, 23),
('201820', 'Spring 2018', 'Full Term', 25333, 'MG', 274, 1, 'KELLER', 120, 1200, 1315, '0000-00-00', '0000-00-00', '', 'M', '', 'W', '', '', '', 10, 3),
('201820', 'Spring 2018', 'Full Term', 25337, 'CIS', 366, 2, 'RABURN', 211, 1100, 1215, '0000-00-00', '0000-00-00', '', '', 'T', '', 'R', '', '', 17, 18);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `numeric_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
