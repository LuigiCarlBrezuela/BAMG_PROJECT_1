-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 02:47 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipt2_midterm_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` bigint(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_year` int(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `ratings` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `release_year`, `genre`, `descriptions`, `ratings`) VALUES
(23, 'The Lord of the rings', 2001, 'Adventure fiction, Fantasy fiction', '', '6.9'),
(24, 'The Hobbit ', 2014, 'Fantasy ', '', '5.5'),
(25, 'Kill Bill', 2004, 'Comedy', '', '7.5'),
(26, 'John Wick', 2014, 'Action', '', '8.9'),
(27, 'Barbie', 2023, 'Fantasy', '', '7.9'),
(28, 'Ready Or Not', 2019, 'HORROR, ACTION, TRILLER, COMEDY, MYSTERY', '', '7.6'),
(29, 'a song', 2002, 'fantasy', '', '2.6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
