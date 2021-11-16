-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2021 at 04:40 AM
-- Server version: 5.7.27
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `fromYear` varchar(5) NOT NULL,
  `toYear` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `code`, `fromYear`, `toYear`) VALUES
(1, '2017-2021', '2017', '2021'),
(2, '2018-2022', '2018', '2022'),
(3, '2019-2023', '2019', '2023'),
(4, '2020-2024', '2020', '2024'),
(5, '2021-2025', '2021', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `departmentID`, `name`, `code`) VALUES
(1, 1, 'Computer Science Engineering', 'CSE'),
(2, 2, 'Electronics and Communications Engineering', 'ECE'),
(4, 24, 'Nikky Amresh', '2132');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `branchID` int(11) NOT NULL,
  `section` varchar(1) NOT NULL,
  `semesterID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `departmentID`, `branchID`, `section`, `semesterID`, `teacherID`) VALUES
(1, 1, 1, 'a', 1, 1),
(2, 1, 1, 'b', 1, 1),
(3, 1, 1, 'a', 3, 1),
(4, 2, 2, 'a', 3, 2),
(5, 1, 1, 'a', 6, 1),
(7, 1, 4, 'c', 3, 7),
(8, 2, 2, 'd', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `duration`) VALUES
(2, 'BSc', 3),
(4, 'btech', 4),
(5, 'VISA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `hodID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `hodID`) VALUES
(1, 'Computer Science', 1),
(2, 'Electrical', 1),
(24, 'CIVIL', 7);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `name`) VALUES
(1, '1st'),
(2, '2nd'),
(3, '3rd'),
(4, '4th'),
(6, '5th');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `batchID` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `rollNum` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `userID`, `courseID`, `batchID`, `classID`, `rollNum`) VALUES
(1, 1, 4, 3, 3, '190240101065'),
(2, 3, 5, 3, 3, '190240101016'),
(3, 4, 4, 3, 8, '1902ECE');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `userID`, `departmentID`) VALUES
(1, 5, 2),
(2, 6, 2),
(3, 17, 1),
(4, 18, 25),
(6, 20, 25),
(7, 21, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `lastLogin`) VALUES
(1, 'Nikky Amresh', 'nikkyamresh8@gmail.com', '8800900692', '098f6bcd4621d373cade4e832627b4f6', '2021-11-13 13:12:18'),
(2, 'Test User', 'test@gmail.com', '812981982', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 13:04:59'),
(3, 'Aman', 'aman@gmail.com', '2111111111', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 10:14:19'),
(4, 'Abhi', 'abhi@gmail.com', '989238928', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 10:15:03'),
(5, 'Deepak Arya', 'deepak@gmail.com', '8888888888', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 11:38:40'),
(6, 'Ankit', 'ankit@gmail.com', '8765656765', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 11:39:19'),
(17, 'Amit', 'amit@gmail.com', '23223232', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 15:48:12'),
(18, 'Anuk', 'nik.ky.amresh.8@gmail.com', '89237', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 16:31:17'),
(19, 'Nikky Amresh', 'kjhdrtykj@dfghjkk.fdgh', '+91880900692', '045cbbfb5d0ea613f5f487aa25e5495c', '2021-11-14 16:41:40'),
(20, 'Anushree', 'asjjh@jh.asdf', '3874982374', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 18:27:50');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
