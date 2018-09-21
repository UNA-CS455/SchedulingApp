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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.blacklist: ~0 rows (approximately)
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;

-- Dumping structure for table cs455.favorites
CREATE TABLE IF NOT EXISTS `favorites` (
  `email` varchar(100) NOT NULL,
  `roomid` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.favorites: ~16 rows (approximately)
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` (`email`, `roomid`, `id`) VALUES
	('super@una.edu', 'Keller 122', 182),
	('super@una.edu', 'Keller 133', 183),
	('super@una.edu', 'Keller 220', 184),
	('fglover@una.edu', 'Keller 122', 185),
	('fglover@una.edu', 'Keller 220', 186),
	('fglover@una.edu', 'Keller 240', 187),
	('fglover@una.edu', 'Keller 227', 188),
	('test@una.edu', 'Keller 122', 189),
	('test@una.edu', 'Keller 133', 190),
	('test@una.edu', 'Keller 220', 191),
	('admin@una.edu', 'Keller 122', 199),
	('admin@una.edu', 'Keller 222', 200),
	('admin@una.edu', 'Keller 227', 201),
	('admin@una.edu', 'Keller 320', 202),
	('admin@una.edu', 'Raburn 210', 203),
	('admin@una.edu', 'Keller 240', 204);
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
  `headcount` varchar(20) DEFAULT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `occur` varchar(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.reservations: ~52 rows (approximately)
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` (`roomnumber`, `owneremail`, `allowshare`, `headcount`, `startdate`, `enddate`, `starttime`, `endtime`, `occur`, `comment`, `id`, `res_email`) VALUES
	('Keller 322', 'dbrown4@una.edu', 1, '10', '2018-04-03', '2018-04-03', '08:00:00', '10:00:00', 'Once', 'This is a test', 75, 'dbrown4@una.edu'),
	('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-04', '2018-04-04', '07:00:00', '20:00:00', 'Once', 'comment', 76, 'dbrown4@una.edu'),
	('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-05', '2018-04-05', '07:00:00', '20:00:00', 'Once', '', 77, 'dbrown4@una.edu'),
	('Keller 3304', 'dbrown4@una.edu', 1, '40', '2018-04-07', '2018-04-07', '07:00:00', '20:00:00', 'Once', '', 79, 'dbrown4@una.edu'),
	('Keller 3304', 'dbrown4@una.edu', 1, '20', '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'Hi', 81, 'dbrown4@una.edu'),
	('Keller 327', 'dbrown4@una.edu', 0, '0', '2018-04-03', '2018-04-03', '13:00:00', '14:00:00', 'Once', '', 82, 'dbrown4@una.edu'),
	('Keller 3304', 'dbrown4@una.edu', 1, '15', '2018-04-03', '2018-04-03', '14:00:00', '15:00:00', 'Once', 'This is a comment', 83, 'dbrown4@una.edu'),
	('Keller 222', 'dbrown4@una.edu', 1, '16', '2018-04-03', '2018-04-03', '13:00:00', '16:00:00', 'Once', 'This', 84, 'dbrown4@una.edu'),
	('Keller 327', 'dbrown4@una.edu', 1, '10', '2018-04-03', '2018-04-03', '17:00:00', '20:15:00', 'Weekly', 'test', 85, 'dbrown4@una.edu'),
	('Keller 220', 'dbrown4@una.edu', 0, '0', '2018-04-04', '2018-04-04', '13:00:00', '14:00:00', 'Once', 'Test', 87, 'dbrown4@una.edu'),
	('Keller 220', 'dbrown4@una.edu', 0, '0', '2018-04-06', '2018-04-06', '14:00:00', '15:00:00', 'Once', 'test', 89, 'dbrown4@una.edu'),
	('Keller 133', 'dbrown4@una.edu', 1, '42', '2018-04-06', '2018-04-06', '13:00:00', '14:00:00', 'Once', 'test', 90, 'dbrown4@una.edu'),
	('Keller 133', 'dbrown4@una.edu', 1, '54', '2018-04-07', '2018-04-07', '13:00:00', '14:15:00', 'Once', '', 91, 'dbrown4@una.edu'),
	('Keller 133', 'dbrown4@una.edu', 1, '45', '2018-04-06', '2018-04-06', '17:00:00', '19:00:00', 'Once', '', 92, 'dbrown4@una.edu'),
	('Keller 220', 'admin@una.edu', 0, '0', '2018-04-10', '2018-04-10', '13:00:00', '14:00:00', 'Once', 'bfnfghn', 93, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '15', '2018-04-09', '2018-04-09', '07:00:00', '16:00:00', 'Weekly', 'Terstsfaljsdlkfjsdalkjfasdlkjfasdlkjfasdlkjfasdlkjfaskldjflasd', 95, 'admin@una.edu'),
	('Keller 3304', 'admin@una.edu', 0, '0', '2018-04-10', '2018-04-10', '17:15:00', '18:00:00', 'Once', '', 96, 'admin@una.edu'),
	('', 'derekb', 0, '0', '2018-04-19', '2018-04-19', '15:15:00', '17:00:00', 'null', 'asfd', 106, 'admin@una.edu'),
	('', 'afasdf', 0, '0', '2018-04-17', '2018-04-17', '17:00:00', '18:00:00', 'null', 'tste', 107, 'admin@una.edu'),
	('Keller 327', 'admin@una.edu', 1, '20', '2018-04-13', '2018-04-13', '13:15:00', '16:30:00', 'Once', '', 108, 'admin@una.edu'),
	('', 'test@una.edu', 1, '15', '2018-04-16', '2018-04-16', '13:00:00', '14:00:00', 'Once', 'test', 109, 'admin@una.edu'),
	('Keller 220', 'test@una.edu', 0, '0', '2018-04-16', '2018-04-16', '15:15:00', '18:00:00', 'Once', '', 110, 'admin@una.edu'),
	('Keller 222', 'admin@una.edu', 1, '12', '2018-04-19', '2018-04-19', '08:00:00', '14:00:00', 'Once', '', 111, 'admin@una.edu'),
	('Keller 133', 'admin@una.edu', 1, '3', '2018-04-19', '2018-04-19', '16:00:00', '17:00:00', 'Once', '', 112, 'admin@una.edu'),
	('Keller 3304', 'test@una.edu', 1, '3', '2018-04-19', '2018-04-19', '14:00:00', '15:30:00', 'Once', '', 113, 'admin@una.edu'),
	('', '', 0, '0', '2018-04-09', '2018-04-09', '17:00:00', '19:00:00', 'null', '', 114, 'admin@una.edu'),
	('', '', 0, '0', '2018-04-11', '2018-04-11', '13:00:00', '16:15:00', 'null', '', 115, 'admin@una.edu'),
	('', '', 0, '0', '2018-04-24', '2018-04-24', '14:00:00', '16:00:00', 'null', '', 116, 'admin@una.edu'),
	('Keller 222', 'admin@una.edu', 1, '15', '2018-04-21', '2018-04-21', '14:00:00', '15:00:00', 'Once', 'test', 117, 'admin@una.edu'),
	('', '', 0, '0', '2018-04-09', '2018-04-09', '10:00:00', '11:30:00', 'null', '', 119, 'admin@una.edu'),
	('', '', 0, '0', '2018-04-09', '2018-04-09', '19:45:00', '20:30:00', 'null', '', 120, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '10', '2018-04-09', '2018-04-09', '14:15:00', '16:15:00', 'Once', '', 121, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '13', '2018-04-09', '2018-04-09', '14:00:00', '16:00:00', 'Once', '', 122, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '5', '2018-04-09', '2018-04-09', '12:00:00', '13:30:00', 'Once', '', 123, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '2', '2018-04-09', '2018-04-09', '14:30:00', '16:30:00', 'Once', '', 124, 'admin@una.edu'),
	('', 'admin1@una.edu', 0, '0', '2018-04-16', '2018-04-16', '16:00:00', '17:30:00', 'null', 'test', 125, 'admin@una.edu'),
	('', 'admin@una.edu', 1, '30', '2018-04-24', '2018-04-24', '16:15:00', '16:15:00', 'Once', '', 126, 'admin@una.edu'),
	('Keller 133', 'admin@una.edu', 1, '5', '2018-04-24', '2018-04-24', '17:15:00', '18:15:00', 'Once', '', 127, 'admin@una.edu'),
	('', 'super@una.edu', 1, '20', '2018-05-01', '2018-05-01', '14:00:00', '15:00:00', 'Once', '', 128, 'super@una.edu'),
	('', 'super@una.edu', 0, '0', '2018-05-11', '2018-05-11', '14:30:00', '16:15:00', 'Once', '', 129, 'super@una.edu'),
	('', 'super@una.edu', 1, '14', '2018-05-11', '2018-05-11', '16:15:00', '17:00:00', 'Once', '', 130, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-05-17', '2018-05-17', '12:00:00', '13:00:00', 'Once', '', 131, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-05-24', '2018-05-24', '15:00:00', '16:00:00', 'Once', '', 132, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-06-04', '2018-06-04', '12:00:00', '13:00:00', 'Once', '', 133, 'super@una.edu'),
	('Keller 333', 'super@una.edu', 0, '', '2018-06-07', '2018-06-07', '13:00:00', '14:00:00', 'Once', '', 134, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-06-08', '2018-06-08', '14:00:00', '15:00:00', 'Once', '', 135, 'super@una.edu'),
	('Keller 220', 'super@una.edu', 0, '', '2018-06-14', '2018-06-14', '08:00:00', '08:45:00', 'Once', '', 136, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-07-28', '2018-07-28', '08:00:00', '21:00:00', 'Once', '', 137, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-07-28', '2018-07-28', '21:30:00', '23:00:00', 'Once', '', 138, 'super@una.edu'),
	('', 'super@una.edu', 0, '', '2018-07-31', '2018-07-31', '12:00:00', '14:00:00', 'Once', '', 140, 'super@una.edu'),
	('Keller 220', 'super@una.edu', 0, '', '2018-08-01', '2018-08-01', '08:00:00', '13:00:00', 'Once', '', 141, 'super@una.edu'),
	('', 'super', 0, '', '2018-08-16', '2018-08-16', '08:00:00', '09:00:00', 'null', 'super', 142, 'super@una.edu');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;

-- Dumping structure for table cs455.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `roomid` varchar(100) NOT NULL COMMENT 'The room number, or identification string.',
  `type` varchar(100) NOT NULL COMMENT 'computer lab, conference room, classroom',
  `floor` tinyint(3) NOT NULL,
  `seats` int(11) NOT NULL COMMENT 'The number of open seats',
  `hascomputers` int(11) unsigned DEFAULT NULL,
  `numcomputers` int(11) DEFAULT NULL COMMENT 'number of open computers given that hascomputers is true.',
  `numeric_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`numeric_id`),
  UNIQUE KEY `roomid` (`roomid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table cs455.rooms: ~24 rows (approximately)
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `numeric_id`) VALUES
	('Keller 122', 'Classroom', 1, 40, 0, 0, 1),
	('Keller 133', 'Computer Lab', 1, 64, 0, NULL, 2),
	('Keller 220', 'Computer Lab', 2, 36, 0, 0, 3),
	('Keller 222', 'Computer Lab', 2, 40, 0, NULL, 4),
	('Keller 227', 'Computer Lab', 2, 32, 0, NULL, 5),
	('Keller 320', 'Computer Lab', 3, 36, 0, NULL, 6),
	('Keller 322', 'Computer Lab', 3, 40, 0, NULL, 7),
	('Keller 327', 'Computer Lab', 3, 32, 0, NULL, 8),
	('Keller 333', 'Computer Lab', 3, 48, 0, 0, 9),
	('Keller 221', 'Computer Lab', 3, 10, 0, NULL, 10),
	('Keller 233', 'Computer Lab', 3, 58, 1, 58, 11),
	('Keller 234', 'Computer Lab', 3, 24, 0, NULL, 12),
	('Keller 334', 'Computer Lab', 3, 24, 1, 24, 14),
	('Raburn 104', 'Computer Lab', 1, 50, 0, NULL, 15),
	('Raburn 109', 'Computer Lab', 1, 50, 0, NULL, 16),
	('Raburn 110', 'Computer Lab', 1, 50, 0, NULL, 17),
	('Raburn 206', 'Computer Lab', 2, 30, 1, 30, 18),
	('Raburn 207', 'Computer Lab', 2, 12, 1, 12, 19),
	('Raburn 210', 'Computer Lab', 2, 24, 1, 24, 20),
	('Raburn 211', 'Computer Lab', 2, 30, 1, 30, 21),
	('Raburn 305', 'Computer Lab', 3, 25, 0, NULL, 22),
	('Keller 240', 'Computer Lab', 2, 8, 0, NULL, 23),
	('test', 'Classroom', 2, 34, 0, 0, 36),
	('asdf ', 'Conference Room', 1, 12, 0, NULL, 37);
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

-- Dumping data for table cs455.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`email`, `firstname`, `lastname`, `password`, `classification`, `groupID`) VALUES
	('admin@una.edu', 'admin', 'admin', '771fd8b75bddc7a94885ec0331bf0f3c298dc2ae', 'ADMIN', 2),
	('fglover@una.edu', 'Franklin1', 'Glover', 'cdc4242074a4d84790e1b6d2fe254b2c562d187d', 'ADMIN', 2),
	('mbanks@una.edu', 'Shane', 'Banks', '55ddf90e5c02e7700f19cc5d9fc87741f2867f08', 'ADMIN', 2),
	('super@una.edu', 'Super', 'Super', 'e97ce80acab2f20ca045fe17ba1d3f5a8087e963', 'ADMIN', 2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
