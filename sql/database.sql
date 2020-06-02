-- --------------------------------------------------------
-- Host:                         ivgz2rnl5rh7sphb.chr7pe7iynqr.eu-west-1.rds.amazonaws.com
-- Server version:               5.7.23-log - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for kees56750ub6vj34
CREATE DATABASE IF NOT EXISTS `kees56750ub6vj34` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `kees56750ub6vj34`;

-- Dumping structure for table kees56750ub6vj34.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `grade` int(3) NOT NULL,
  `orgCode` int(32) NOT NULL,
  `baseSalary` double NOT NULL,
  `perHour` double NOT NULL,
  `extraPay` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table kees56750ub6vj34.employee: ~0 rows (approximately)
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`ID`, `name`, `grade`, `orgCode`, `baseSalary`, `perHour`, `extraPay`) VALUES
	(1, 'hamad k. alotaibi', 45, 0, 15000, 83.33333333333333, 125);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

-- Dumping structure for table kees56750ub6vj34.overtime
CREATE TABLE IF NOT EXISTS `overtime` (
  `ID` int(32) NOT NULL AUTO_INCREMENT,
  `empID` int(32) NOT NULL,
  `empname` text NOT NULL,
  `orgcode` int(32) NOT NULL,
  `ccp` varchar(100) NOT NULL,
  `wbsCode` varchar(32) NOT NULL,
  `actType` text NOT NULL,
  `attType` text NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time(6) NOT NULL,
  `endTime` time(6) NOT NULL,
  `hours` double NOT NULL,
  `otCost` double NOT NULL,
  `baseSalary` double NOT NULL,
  `Username` varchar(23) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `wbsCode` (`wbsCode`),
  KEY `empID` (`empID`),
  CONSTRAINT `overtime_ibfk_1` FOREIGN KEY (`wbsCode`) REFERENCES `wbs` (`code`),
  CONSTRAINT `overtime_ibfk_2` FOREIGN KEY (`empID`) REFERENCES `employee` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table kees56750ub6vj34.overtime: ~0 rows (approximately)
/*!40000 ALTER TABLE `overtime` DISABLE KEYS */;
/*!40000 ALTER TABLE `overtime` ENABLE KEYS */;

-- Dumping structure for table kees56750ub6vj34.users
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table kees56750ub6vj34.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`ID`, `username`, `password`, `admin`) VALUES
	(3, 'admin1', '81dc9bdb52d04dc20036dbd8313ed055', 1),
	(4, 'hamad', '81dc9bdb52d04dc20036dbd8313ed055', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table kees56750ub6vj34.wbs
CREATE TABLE IF NOT EXISTS `wbs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `code` varchar(32) NOT NULL,
  `budget` double NOT NULL,
  `withdrew` double NOT NULL,
  `remainder` double NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table kees56750ub6vj34.wbs: ~0 rows (approximately)
/*!40000 ALTER TABLE `wbs` DISABLE KEYS */;
INSERT INTO `wbs` (`ID`, `name`, `code`, `budget`, `withdrew`, `remainder`) VALUES
	(1, 'new wbs for devils', '666', 666, 0, 666);
/*!40000 ALTER TABLE `wbs` ENABLE KEYS */;

-- Dumping structure for table kees56750ub6vj34.work_assign
CREATE TABLE IF NOT EXISTS `work_assign` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `empID` int(11) NOT NULL,
  `empName` text NOT NULL,
  `orgCode` int(11) NOT NULL,
  `ccp` int(11) NOT NULL,
  `wbsCode` varchar(32) NOT NULL,
  `actType` text NOT NULL,
  `waType` text NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `days` int(11) NOT NULL,
  `ticket` double NOT NULL,
  `waCost` float NOT NULL,
  `baseSalary` double NOT NULL,
  `Username` varchar(23) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `wbsCode` (`wbsCode`),
  KEY `empID` (`empID`),
  CONSTRAINT `work_assign_ibfk_1` FOREIGN KEY (`wbsCode`) REFERENCES `wbs` (`code`),
  CONSTRAINT `work_assign_ibfk_2` FOREIGN KEY (`empID`) REFERENCES `employee` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table kees56750ub6vj34.work_assign: ~0 rows (approximately)
/*!40000 ALTER TABLE `work_assign` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_assign` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
