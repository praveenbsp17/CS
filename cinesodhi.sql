-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2015 at 10:53 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pratice`
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
  `category` varchar(150) DEFAULT NULL,
  `article_img` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `modified_by` int(11) unsigned DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `page_url`, `meta_keywords`, `meta_description`, `article_title`, `article_content`, `category`, `article_img`, `status`, `created_by`, `modified_by`, `created_date`, `modified_date`) VALUES
(5, 'allu-arjun-back-from-holiday.html', 'Allu Arjun back from holiday', 'Allu Arjun back from holiday', 'Allu Arjun back from holiday', '<p>Allu Arjun returned to the city on Sunday morning from South Africa after celebrating New Year&rsquo;s Eve there. His untitled film with director Trivikram Srinivas started its final schedule on Tuesday.</p>\r\n\r\n<p>&ldquo;This was a much-needed break and the actor enjoyed some quality time with his family, especially his son. Now, he wants to concentrate on the film,&rdquo; says a source.</p>\r\n\r\n<p>The shooting will take place around Hyderabad and the director is planning to can some important scenes. Allu Arjun plays a wedding planner in the film, which also stars Samantha, Adah Sharma and Nithya Menon.</p>\r\n\r\n<p>Samantha plays the main female lead. K. Radhakrishna is producing this film, while Kannada actor Upendra and Rajendra Prasad both have important roles in the film.</p>\r\n', 'Movies', 'aa_1420792687_1420801693.jpg', 1, 1, 2, '2015-01-09 09:38:07', '2015-01-09 12:08:13'),
(6, 'HC-stays-release-of-film-I-till-january-30th.html', 'HC stays release of film ''I'' till January 30th', 'HC stays release of film ''I'' till January 30th', 'HC stays release of film ''I'' till January 30th', '<p><strong>Chennai:</strong>&nbsp; Madras(Tamil Nadu) High Court today stayed the release of multi-crore Tamil film by Director Shankar and starring Vikram and Emy Jackson, slated for January 15, till January 30 on a petition alleging violation of agreements by the producers. Justice R Mahadevan granted the interim injunction on a petition by city-based Picturehouse Media Limited alleging violation of financial and commercial agreements between it and producers Aascar Films (Private) Ltd.</p>\r\n\r\n<p>The judge restrained Aascar Films Private Limited, its Directors V Ravichandran and D Ramesh Babu, besides Reliance Mediaworks Limited, from releasing the film till January 30 in any format and asked the litigating parties to settle the issues by arbitration in the meanwhile. He issued notices to the producers and directed them to file their response by then. The producers, distributors, film laboratories and digital projection services &quot;are hereby restrained by an order of interim injunction till January 30, 2015 from releasing the movie in theatres all over the country, and outside India,&quot; the Judge said in his order.</p>\r\n\r\n<p>The applicant had claimed violation of commercial and financial agreements between it and Aascar Films and wanted the matter to be settled by arbitration.</p>\r\n', 'Movies', 'i_1420787613_1420794972.jpg', 1, 1, 1, '2015-01-09 09:40:13', '2015-01-09 10:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_url` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` longtext NOT NULL,
  `gallery_title` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `modified_by` int(11) unsigned DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `page_url`, `meta_keywords`, `meta_description`, `gallery_title`, `status`, `created_by`, `modified_by`, `created_date`, `modified_date`) VALUES
(1, 'i-movie-gallery.html', 'I Movie Gallery', 'I Movie Gallery', 'I Movie Gallery', 1, 1, 1, '2015-01-13 10:19:37', '2015-01-13 10:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) unsigned NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
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
(1, 1, 1, '192.168.100.10', '2015-01-07 14:14:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_url` varchar(250) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` longtext NOT NULL,
  `video_title` varchar(250) NOT NULL,
  `video_type` varchar(250) DEFAULT NULL,
  `video_url` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `modified_by` int(11) unsigned DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `page_url`, `meta_keywords`, `meta_description`, `video_title`, `video_type`, `video_url`, `status`, `created_by`, `modified_by`, `created_date`, `modified_date`) VALUES
(1, 'test.html', 'test', 'test', 'test', 'Trailer', 'http://youtube.com/v/123456677', 1, 1, 1, '2015-01-13 12:33:58', '2015-01-13 12:37:33');

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
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gallery_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD CONSTRAINT `poll_votes_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
