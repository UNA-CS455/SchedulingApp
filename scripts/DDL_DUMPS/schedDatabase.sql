-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5289
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for cs455
CREATE DATABASE IF NOT EXISTS `cs455` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cs455`;

-- Dumping structure for table cs455.blacklist
CREATE TABLE IF NOT EXISTS `blacklist` (
  `group_id` int(11) NOT NULL,
  `numeric_room_id` int(11) NOT NULL,
  `blacklist_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`blacklist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.blacklist: ~7 rows (approximately)
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
INSERT INTO `blacklist` (`group_id`, `numeric_room_id`, `blacklist_id`) VALUES
	(2, 3, 1),
	(1, 3, 2),
	(1, 2, 3),
	(1, 1, 4),
	(2, 8, 11),
	(2, 2, 12),
	(2, 1, 13);
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;



-- Dumping structure for table cs455.favorites
CREATE TABLE IF NOT EXISTS `favorites` (
  `email` varchar(100) NOT NULL,
  `roomid` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.favorites: ~10 rows (approximately)
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` (`email`, `roomid`, `id`) VALUES
	('dbrown4@una.edu', 'Keller 122', 74),
	('dbrown4@una.edu', 'Keller 133', 81),
	('dbrown4@una.edu', 'Keller 220', 91),
	('dbrown4@una.edu', 'Keller 320', 93),
	('dbrown4@una.edu', 'Keller 222', 96),
	('super', 'Keller 220', 195),
	('super', 'Keller 222', 196),
	('super', 'Keller 233', 197),
	('admin@una.edu', 'Keller 122', 198),
	('admin@una.edu', 'Keller 233', 199),
	('admin@una.edu', 'Keller 221', 200),
	('user@una.edu', 'Raburn 305', 201),
	('user@una.edu', 'Raburn 210', 202),
	('user@una.edu', 'Raburn 207', 203);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;

-- Dumping structure for table cs455.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.groups: ~2 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`) VALUES
	(1, 'A'),
	(2, 'U');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table cs455.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `roomnumber` varchar(100) NOT NULL,
  `owneremail` varchar(100) NOT NULL,
  `allowshare` tinyint(1) NOT NULL,
  `headcount` int(11) DEFAULT NULL,
  `termstart` date DEFAULT NULL,
  `termend` date DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `occur` varchar(11) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_email` varchar(50) DEFAULT NULL,
  `unique_identifier` varchar(33) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`unique_identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=13378 DEFAULT CHARSET=latin1;


-- Dumping structure for table cs455.roomdat
CREATE TABLE IF NOT EXISTS `roomdat` (
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



-- Dumping structure for table cs455.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `roomid` varchar(100) NOT NULL COMMENT 'The room number, or identification string.',
  `type` varchar(100) NOT NULL COMMENT 'computer lab, conference room, classroom',
  `floor` tinyint(3) NOT NULL,
  `seats` int(11) NOT NULL COMMENT 'The number of open seats',
  `hascomputers` int(11) unsigned DEFAULT NULL,
  `numcomputers` int(11) DEFAULT NULL COMMENT 'number of open computers given that hascomputers is true.',
  `limitusers` int(11) unsigned DEFAULT NULL COMMENT 'indicates if an Admin can limit reservations on a room',
  `numeric_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`numeric_id`),
  UNIQUE KEY `roomid` (`roomid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.rooms: ~22 rows (approximately)
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `numeric_id`) VALUES
	('Keller 122', 'Classroom', 1, 40, 0, NULL, 1),
	('Keller 133', 'Classroom', 1, 64, 0, NULL, 2),
	('Keller 220', 'Classroom', 2, 36, 0, NULL, 3),
	('Keller 222', 'Classroom', 2, 40, 0, NULL, 4),
	('Keller 227', 'Classroom', 2, 32, 0, NULL, 5),
	('Keller 320', 'Classroom', 3, 36, 0, NULL, 6),
	('Keller 322', 'Classroom', 3, 40, 0, NULL, 7),
	('Keller 327', 'Classroom', 3, 32, 0, NULL, 8),
	('Keller 333', 'Classroom', 3, 48, 0, NULL, 9),
	('Keller 221', 'Conference Room', 3, 10, 0, NULL, 10),
	('Keller 233', 'Computer Lab', 3, 58, 1, 58, 11),
	('Keller 234', 'Conference Room', 3, 24, 0, NULL, 12),
	('Keller 334', 'Computer Lab', 3, 24, 1, 24, 14),
	('Raburn 104', 'Classroom', 1, 50, 0, NULL, 15),
	('Raburn 109', 'Classroom', 1, 50, 0, NULL, 16),
	('Raburn 110', 'Classroom', 1, 50, 0, NULL, 17),
	('Raburn 206', 'Computer Lab', 2, 30, 1, 30, 18),
	('Raburn 207', 'Computer Lab', 2, 12, 1, 12, 19),
	('Raburn 210', 'Computer Lab', 2, 24, 1, 24, 20),
	('Raburn 211', 'Computer Lab', 2, 30, 1, 30, 21),
	('Raburn 305', 'Conference Room', 3, 25, 0, NULL, 22),
	('Keller 240', 'Conference Room', 2, 8, 0, NULL, 23);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Dumping structure for table cs455.users
CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `classification` varchar(200) NOT NULL,
  `groupID` int(2) DEFAULT '2',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`email`, `firstname`, `lastname`, `password`, `classification`, `groupID`) VALUES
	('admin@una.edu', 'admin', 'admin', '771fd8b75bddc7a94885ec0331bf0f3c298dc2ae', 'ADMIN', 2),
	('super@una.edu', 'super', 'super', 'e97ce80acab2f20ca045fe17ba1d3f5a8087e963', 'ADMIN', 2),
	('user@una.edu', 'user', 'user', 'f9b047f39effbd6912cc851ff989115f9b4f9ada', 'USER', 2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


CREATE TABLE IF NOT EXISTS `whitelist` (
  `email` varchar(100) NOT NULL,
  `roomid` varchar(100) NOT NULL,
  FOREIGN KEY (`email`) REFERENCES users(`email`),
  FOREIGN KEY (`roomid`) REFERENCES rooms(`roomid`),
  PRIMARY KEY (`email`, `roomid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
-- `email` is the primary key of the `users` table
-- `numeric_id` is the primary key of the `rooms` table
-- `roomid` is a unique key of the `rooms` table
