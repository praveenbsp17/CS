-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2014 at 07:17 AM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cinesodhi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `admin_type` varchar(150) NOT NULL,
  `createddate` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `admin_type`, `createddate`, `status`) VALUES
(1, 'admin', 'võA', 'support@c3docs.com', 'Admin', '2012-08-17', 1),
(2, 'test', '&P\\‡', 'test@in.com', 'Content Writer', '2014-12-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_url` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` longtext NOT NULL,
  `article_title` varchar(250) NOT NULL,
  `article_content` longtext NOT NULL,
  `category` int(11) unsigned NOT NULL,
  `article_img` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `modified_by` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) NOT NULL,
  `option1` varchar(150) NOT NULL,
  `option2` varchar(150) NOT NULL,
  `option3` varchar(150) NOT NULL,
  `option4` varchar(150) NOT NULL,
  `createddate` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `createddate`, `status`) VALUES
(1, 'Best Movie of the Year 2014?', '1 - Nenokkadine', 'Race Gurram', 'Manam', 'Run Raja Run', '2015-01-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE IF NOT EXISTS `poll_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `vote` tinyint(4) unsigned NOT NULL,
  `user_ip` varchar(50) NOT NULL,
  `voted_datetime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `poll_votes`
--

INSERT INTO `poll_votes` (`id`, `poll_id`, `vote`, `user_ip`, `voted_datetime`, `status`) VALUES
(1, 1, 1, '192.168.100.10', '2015-01-07 14:14:00', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD CONSTRAINT `poll_votes_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
