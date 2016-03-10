-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2016 at 02:51 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

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

CREATE TABLE `block_list` (
  `id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `block_list`
--

INSERT INTO `block_list` (`id`, `block_id`, `user_id`) VALUES
(3, 4, 8),
(4, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friend_since` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sent_to_id` int(11) NOT NULL,
  `sent_from_id` int(11) NOT NULL,
  `sent_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sent_to_id`, `sent_from_id`, `sent_time`) VALUES
(5, 5, 7, 1457208914),
(8, 6, 4, 1457209469);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(2048) NOT NULL,
  `posted_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `status`, `posted_at`) VALUES
(37, 4, 'I am Sandeep Acharya. This is my first Post.', 1457208461),
(38, 7, 'Hi I am Mallika. New Here.', 1457208827),
(39, 4, 'I am Sandeep', 1457209083),
(40, 8, 'I am Santu. Now I will cahnge my status and info and profile picture.', 1457209260),
(41, 4, 'Wow....', 1457209459),
(42, 4, 'This is a new post.', 1457616789);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `joining_time_stamp`, `sex`, `profile_status`, `profile_picture_path`, `mobile_no`, `hometown`, `school_name`, `college_name`, `language_1st`, `language_2nd`, `language_3rd`, `relationship`) VALUES
(4, 'Sandeep', '', 'Acharya', 'i.am.sandeep.acharya@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1457206082, 'male', '', 'http://localhost/sandeep/uploads/4/12742376_196654257362217_6337975465053401984_n.jpg', '', '', '', '', '', '', '', ''),
(5, 'Keshab', '', 'Sahoo', 'keshab@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1457206820, 'male', '', '', '', '', '', '', '', '', '', ''),
(6, 'PRANAY', 'KUMAR', 'NANDI', 'pranay.nandi99@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1457207362, 'male', '', '', '', '', '', '', '', '', '', ''),
(7, 'Mallika', '', 'Das', 'mallika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1457208787, 'female', 'I am new here', 'http://localhost/sandeep/uploads/7/billions.jpg', '8979878978', 'Kolkata', '', '', '', '', '', ''),
(8, 'Santu', '', 'Das', 'sandeep.acharya@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1457209212, 'male', 'I am santu.', 'http://localhost/sandeep/uploads/8/question.jpg', '789798789', '', '', '', '', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
