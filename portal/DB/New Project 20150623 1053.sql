-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.16


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema eduschools
--

CREATE DATABASE IF NOT EXISTS eduschools;
USE eduschools;
CREATE TABLE `userdetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmpCode` int(10) unsigned NOT NULL,
  `EmpName` varchar(45) NOT NULL,
  `School` varchar(45) NOT NULL,
  `ContactNo` varchar(45) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `UserType` varchar(15) NOT NULL,
  `UserStatus` int(10) unsigned NOT NULL,
  `Password` varchar(45) NOT NULL,
  `LoginID` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `userdetails` DISABLE KEYS */;
INSERT INTO `userdetails` (`id`,`EmpCode`,`EmpName`,`School`,`ContactNo`,`Email`,`UserType`,`UserStatus`,`Password`,`LoginID`) VALUES 
 (1,0,'Administrator','ESIML','+919717705010','pallab.db@educomp.com','Admin',1,'password','admin'),
 (2,20171,'Pallab DB','ESIML','+919717705010','pallabdb@gmail.com','User',1,'pallab','PALLABDB'),
 (3,1,'Anoop Bharti','ESIML','+919112345678','anoop.bharti@educompschools.com','Support',1,'password','ANOOP.BHARTI'),
 (4,2,'CS Prabhakar','ESL','+911234567890','prabhakar.cs@educomp.com','Supervisor',1,'password','PRABHAKAR.CS');
/*!40000 ALTER TABLE `userdetails` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
