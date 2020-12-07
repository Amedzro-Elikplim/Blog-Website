-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2020 at 06:31 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(100) NOT NULL,
  `abio` varchar(1000) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'avatar.png',
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `addedby`) VALUES
(2, 'May-09-2020 16:25:15', 'Yung', '1234', 'Dennis Tetteh Abayateye', 'Blogger', 'I am good at blogging and web development', 'WP_20150221_00120150222163541.jpg', 'Dennis'),
(3, 'May-24-2020 13:03:31', 'dennis', 'dennis', '', '', '', '', 'Yung'),
(4, 'May-24-2020 13:49:29', 'Abaya', 'fuck', 'Abayateye', '', '', '', 'Yung'),
(5, 'May-24-2020 13:53:49', 'Thelma', '1234', '', '', '', '', 'Yung'),
(6, 'June-28-2020 15:57:30', 'ken', '1234', 'kenneth', '', '', 'avatar.png', 'Yung');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(2, 'News', 'Dennis', 'May-06-2020 23:20:10'),
(3, 'Sports', 'Dennis', 'May-06-2020 23:20:27'),
(4, 'Technology', 'Yung', 'May-17-2020 16:27:28'),
(5, 'Trending News', 'Yung', 'June-28-2020 09:41:34'),
(6, 'Politics', 'Yung', 'June-28-2020 09:41:50'),
(7, 'Entertainment & Lifestyle', 'Yung', 'June-28-2020 09:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(3, 'May-07-2020 23:05:30', 'Yung', 'test@gmail.com', 'God is good', 'Stephen', 'ON', 5),
(4, 'May-07-2020 23:08:06', 'Dennis', 'test20@gmail.com', 'I Thank you God', 'Stephen', 'ON', 5),
(5, 'May-07-2020 23:09:17', 'Dennis', 'test3@gmail.com', 'Testing2', 'Stephen', 'ON', 6),
(6, 'May-07-2020 23:12:13', 'Rapper', 'test2@gmail.com', 'Testing6', 'Stephen', 'ON', 6),
(7, 'May-07-2020 23:12:54', 'Rapper', 'test20@gmail.com', 'Give your life to christ', 'Stephen', 'ON', 6),
(9, 'May-16-2020 15:59:02', 'Seth', 'test2@gmail.com', 'Good Boy', 'Stephen', 'OFF', 3),
(10, 'May-16-2020 16:05:11', 'Rapper', 'test3@gmail.com', 'Hhahahahah', 'Stephen', 'OFF', 3),
(11, 'June-24-2020 21:23:04', 'Seth', 'test2@gmail.com', 'Please i need help', 'Stephen', 'OFF', 24);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(20000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(3, 'May-07-2020 01:22:32', 'DENYUNG is bad', 'Technology', 'Dennis', 'dd.jpg', '                                              I am tired                                      '),
(5, 'May-07-2020 01:23:13', 'This is the title of my page', 'Sports', 'Dennis', 'aa.jpg', 'Different authors have defined the term micro-credit in diverse ways. Rahman (1999, pp 67) defined micro- credit as â€œthe extension of a small amount of collateral free institutional loans to jointly liable poor group members for their self-employment and income generationâ€. In the view of Lott (2008), micro-credit involves providing small loans to poor people to increase their productive abilities. Anderson et al (2002), also defined micro-credit as the provision of a lesser amount of credit to help the poor in income generating activities in developing countries.\r\nFurther, NABARD (2010) states that â€œMicro-credit refers to the provision of small amounts of credit to the poorest of poor who were not served by the formal financial institutions for many reasons and remain unreachedâ€.'),
(6, 'May-07-2020 01:23:32', 'This is my second post', 'Technology', 'Dennis', 'agi-banner-ai1.jpg', 'Different authors have defined the term micro-credit in diverse ways. Rahman (1999, pp 67) defined micro- credit as â€œthe extension of a small amount of collateral free institutional loans to jointly liable poor group members for their self-employment and income generationâ€. In the view of Lott (2008), micro-credit involves providing small loans to poor people to increase their productive abilities. Anderson et al (2002), also defined micro-credit as the provision of a lesser amount of credit to help the poor in income generating activities in developing countries.\r\nFurther, NABARD (2010) states that â€œMicro-credit refers to the provision of small amounts of credit to the poorest of poor who were not served by the formal financial institutions for many reasons and remain unreachedâ€.'),
(8, 'May-16-2020 22:56:49', 'Post 5', 'Sports', 'Yung', 'Animation.jpg', ''),
(9, 'May-16-2020 22:57:28', 'Post 10', 'Sports', 'Yung', 'HTML5 CSS3.jpg', ''),
(10, 'May-16-2020 22:57:49', 'Post 45', 'News', 'Yung', 'htmlcourse.jpg', ''),
(11, 'May-16-2020 23:32:31', 'Post 8', 'Sports', 'Yung', 'sqlconcepts.jpg', ''),
(12, 'May-16-2020 23:32:57', 'Post 3', 'News', 'Yung', 'unnamed.jpg', ''),
(13, 'May-16-2020 23:33:14', 'Post 0', 'News', 'Yung', 'cacha.jpg', ''),
(14, 'May-16-2020 23:33:35', 'Post 6', 'Sports', 'Yung', 'aa.jpg', ''),
(15, 'May-16-2020 23:40:09', 'Post 1', 'News', 'Yung', 'cc.jpg', ''),
(16, 'May-16-2020 23:40:24', 'Post 2', 'News', 'Yung', 'children-running-t.jpg', ''),
(17, 'May-16-2020 23:40:39', 'Post 4', 'News', 'Yung', 'asasas.jpg', ''),
(18, 'May-16-2020 23:41:01', 'Post 5', 'News', 'Yung', '_102968357_diverse_politics.jpg', ''),
(19, 'May-16-2020 23:41:22', 'Post 21', 'News', 'Yung', 'fit.jpg', ''),
(20, 'May-17-2020 01:00:52', 'Ghana is here', 'News', 'Yung', '1948824_4d6c_4.jpg', ''),
(21, 'May-17-2020 01:01:11', 'Ghana 2', 'News', 'Yung', 'ddd.jpg', ''),
(22, 'May-17-2020 01:01:32', 'Ghana 3', 'Sports', 'Yung', 'download.jpg', ''),
(23, 'May-17-2020 01:01:53', 'Ghana 4', 'News', 'Yung', 'safe_image.jpg', ''),
(24, 'May-17-2020 01:02:22', 'Ghana 5', 'Sports', 'Yung', 'food.jpg', ''),
(25, 'June-29-2020 13:33:00', 'Ghana Experienced Earth Tremor', 'News', 'dennis', 'MyQRCode(1).jpg', 'it could be recoreded that Ghana experienced it first earthquake last year 2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
