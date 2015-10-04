-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2015 at 10:01 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sandeep`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_list`
--

CREATE TABLE IF NOT EXISTS `block_list` (
  `id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `block_list`
--

INSERT INTO `block_list` (`id`, `block_id`, `user_id`) VALUES
(1, 3, 1),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friend_since` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `friend_since`) VALUES
(8, 3, 2, 1442179329),
(9, 2, 3, 1442179329),
(18, 2, 1, 1443987779),
(19, 1, 2, 1443987779);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL,
  `sent_to_id` int(11) NOT NULL,
  `sent_from_id` int(11) NOT NULL,
  `sent_time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(2048) NOT NULL,
  `posted_at` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `status`, `posted_at`) VALUES
(20, 1, 'ami post korlam Sandeep', 1443984669),
(21, 2, 'ami keshab post korlam', 1443984684),
(22, 2, 'I am new here', 1443987758);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `middle_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `joining_time_stamp` bigint(20) NOT NULL,
  `sex` text NOT NULL,
  `profile_status` varchar(256) NOT NULL,
  `profile_picture_path` varchar(256) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `hometown` varchar(256) NOT NULL,
  `school_name` varchar(256) NOT NULL,
  `college_name` varchar(256) NOT NULL,
  `language_1st` varchar(256) NOT NULL,
  `language_2nd` varchar(256) NOT NULL,
  `language_3rd` varchar(256) NOT NULL,
  `relationship` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `joining_time_stamp`, `sex`, `profile_status`, `profile_picture_path`, `mobile_no`, `hometown`, `school_name`, `college_name`, `language_1st`, `language_2nd`, `language_3rd`, `relationship`) VALUES
(1, 'Sandeep', '', 'Acharya', 'i.am.sandeep.acharya@gmail.com', 'a63344033a193f3da3af76f4010c2a0754e033d9', 1442158102, 'male', 'I am the boss', 'http://localhost/sandeep/uploads/1/WP_20130805_00820130807094058201401020140104011616.jpg', '9679343518', 'Taherpur', '', 'Heritage Institute Of Technology', '', '', '', 'I Am Always With You'),
(2, 'Keshab', '', 'Sahoo', 'keshab@gmail.com', 'cf5f756d88f00d403dda7c93e36f4c52dd1e2aa9', 1442162292, 'male', 'I am keshab', 'http://localhost/sandeep/uploads/2/main-thumb-74652087-200-ulemrvyguidqagxcxolawdygjbbqthgj.jpeg', '9879798798', '', '', '', 'Bengali', '', '', ''),
(3, 'Mallika', '', 'Some', 'mallika@gmail.com', '3fbffddf8fd3ab21ceeaa8a0b26edf04e57079ca', 1442175019, 'female', '', '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_list`
--
ALTER TABLE `block_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block_list`
--
ALTER TABLE `block_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
