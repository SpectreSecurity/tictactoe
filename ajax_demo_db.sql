-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2013 at 12:39 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajax_demo`
--
CREATE DATABASE `ajax_demo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ajax_demo`;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playera` varchar(100) DEFAULT NULL,
  `playerb` varchar(100) DEFAULT NULL,
  `winner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `playera`, `playerb`, `winner`) VALUES
(1, 'Player1', 'Player2', 'Player2'),
(2, 'Player4', 'Player1', 'Player1'),
(3, 'Player6', 'Player4', 'Player6'),
(4, 'Player6', 'Player2', 'Player2'),
(5, 'Player1', 'Player3', 'Player3'),
(6, 'Player2', 'Player4', 'Player2'),
(7, 'Player6', 'Player2', 'Player2'),
(8, 'Player2', 'Player1', 'Player1'),
(9, 'Player5', 'Player1', 'Player1'),
(10, 'Player2', 'Player6', 'Player6'),
(11, 'Player1', 'Player2', 'Player2'),
(12, 'Player4', 'Player1', 'Player1'),
(13, 'Player6', 'Player4', 'Player6'),
(14, 'Player6', 'Player2', 'Player2'),
(15, 'Player1', 'Player3', 'Player3'),
(16, 'Player2', 'Player4', 'Player2'),
(17, 'Player6', 'Player2', 'Player6'),
(18, 'Player2', 'Player1', 'Player1'),
(19, 'Player5', 'Player1', 'Player1'),
(20, 'Player2', 'Player6', 'Player6'),
(27, 'Player4', 'Player2', 'Tie'),
(28, 'Player2', 'Player8', 'Player8'),
(29, 'Player8', 'Player10', 'Tie'),
(66, 'Player8', 'Player4', 'Player8'),
(67, 'test1', 'test2', 'test1'),
(68, 'test2', 'test1', 'test2'),
(69, 'test2', 'test1', 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
CREATE TABLE IF NOT EXISTS `invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(100) DEFAULT NULL,
  `receiver` varchar(100) DEFAULT NULL,
  `accepted` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `logged_in`
--

DROP TABLE IF EXISTS `logged_in`;
CREATE TABLE IF NOT EXISTS `logged_in` (
  `userid` varchar(100) NOT NULL,
  `last_seen` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logged_in`
--

INSERT INTO `logged_in` (`userid`, `last_seen`) VALUES
('test1', 1378946159),
('test2', 1378946154);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nickname` varchar(100) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `Nickname`, `Status`) VALUES
(1, 'Player1', 'playing'),
(2, 'Player2', 'available'),
(3, 'Player3', 'available'),
(4, 'Player4', 'available'),
(5, 'Player5', 'playing'),
(6, 'Player6', 'available'),
(7, 'Player7', 'playing'),
(8, 'Player8', 'available'),
(9, 'Player9', 'playing'),
(10, 'Player10', 'available'),
(11, 'test1', 'available'),
(12, 'test2', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tictactoe`
--

DROP TABLE IF EXISTS `tictactoe`;
CREATE TABLE IF NOT EXISTS `tictactoe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gameid` int(11) DEFAULT NULL,
  `opponentid` int(11) DEFAULT NULL,
  `pa1` varchar(3) DEFAULT NULL,
  `pb1` varchar(3) DEFAULT NULL,
  `pa2` varchar(3) DEFAULT NULL,
  `pb2` varchar(3) DEFAULT NULL,
  `pa3` varchar(3) DEFAULT NULL,
  `pb3` varchar(3) DEFAULT NULL,
  `pa4` varchar(3) DEFAULT NULL,
  `pb4` varchar(3) DEFAULT NULL,
  `pa5` varchar(3) DEFAULT NULL,
  `winner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tictactoe`
--

INSERT INTO `tictactoe` (`id`, `gameid`, `opponentid`, `pa1`, `pb1`, `pa2`, `pb2`, `pa3`, `pb3`, `pa4`, `pb4`, `pa5`, `winner`) VALUES
(7, 27, NULL, 'a1', 'b2', 'c3', 'b3', 'b1', 'c1', 'a3', 'a2', 'c2', 'Tie'),
(8, 28, NULL, 'a1', 'b2', 'b1', 'c1', 'a2', 'a3', NULL, NULL, NULL, 'Player8'),
(9, 29, NULL, 'a1', 'b2', 'a3', 'a2', 'c2', 'c3', 'c1', 'b1', 'b3', 'Tie'),
(46, 66, NULL, 'c1', 'b2', 'b1', 'c3', 'a1', NULL, NULL, NULL, NULL, 'Player8'),
(47, 67, NULL, 'a1', 'b2', 'c1', 'c2', 'b1', NULL, NULL, NULL, NULL, 'test1'),
(48, 68, NULL, 'c2', 'b1', 'b2', 'a1', 'a2', NULL, NULL, NULL, NULL, 'test2'),
(49, 69, NULL, 'a1', 'b2', 'b1', 'a2', 'c1', NULL, NULL, NULL, NULL, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(100) DEFAULT NULL,
  `Lastname` varchar(100) DEFAULT NULL,
  `Age` int(3) DEFAULT NULL,
  `Hometown` varchar(100) DEFAULT NULL,
  `Job` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Firstname`, `Lastname`, `Age`, `Hometown`, `Job`) VALUES
(1, 'Peter', 'Griffin', 41, 'Quahog', 'Brewery'),
(2, 'Lois', 'Griffin', 40, 'Newport', 'Piano Teacher'),
(3, 'Joseph', 'Swanson', 39, 'Quahog', 'Police Officer'),
(4, 'Glenn', 'Quagmire', 41, 'Quahog', 'Pilot');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nickname` varchar(100) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
