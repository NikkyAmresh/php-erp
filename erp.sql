-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2021 at 10:02 PM
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
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `timeTableID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `studentID`, `date`, `status`, `timeTableID`) VALUES
(1, 1, '2021-12-08 05:59:43', 1, 415);

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
(9, 1, 1, 'a', 4, 10),
(10, 1, 1, 'b', 6, 9);

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
(1, 'Computer Science', 14),
(2, 'Electrical', 9),
(24, 'CIVIL', 11);

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` int(11) NOT NULL,
  `fromTime` varchar(10) NOT NULL,
  `toTime` varchar(10) NOT NULL,
  `isExtra` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `fromTime`, `toTime`, `isExtra`) VALUES
(4, '09:20', '10:10', NULL),
(5, '10:10', '11:00', NULL),
(6, '11:20', '12:10', NULL),
(7, '12:10', '13:00', NULL),
(8, '14:00', '14:50', NULL),
(9, '14:50', '15:40', NULL),
(10, '15:40', '16:30', NULL);

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
(1, 1, 4, 3, 9, '190240101065'),
(2, 3, 5, 3, 9, '190240101016'),
(3, 4, 4, 3, 10, '1902ECE');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `subjectCode` varchar(10) NOT NULL,
  `departmentID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subjectCode`, `departmentID`) VALUES
(4, 'Operating System', 'BCST-501', 1),
(5, 'Computer Network', 'BCST-502', 1),
(6, 'DAA', 'BCST-503', 1),
(7, 'Java Programming', 'BCSt-504 D', 1),
(8, 'PPL', 'BOCS-505 A', 1),
(9, 'DAA Lab', 'BCSP-503', 1),
(10, 'JAVA Lab', 'BCST-506', 1),
(11, 'CN LAB', 'BCSP-501', 1),
(12, 'OS LAB', 'BCSP-502', 1);

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
(9, 22, 1),
(10, 23, 1),
(11, 24, 1),
(12, 25, 1),
(13, 26, 1),
(14, 27, 1),
(15, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` int(20) NOT NULL,
  `periodID` int(11) NOT NULL,
  `day` varchar(10) NOT NULL,
  `classID` int(10) NOT NULL,
  `subjectID` int(10) NOT NULL,
  `teacherID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `periodID`, `day`, `classID`, `subjectID`, `teacherID`) VALUES
(254, 4, 'monday', 10, 9, 11),
(259, 9, 'monday', 10, 7, 12),
(261, 4, 'tuesday', 10, 6, 11),
(275, 6, 'wednesday', 10, 6, 10),
(285, 4, 'monday', 10, 9, 11),
(290, 9, 'monday', 10, 7, 12),
(292, 4, 'tuesday', 10, 6, 11),
(306, 6, 'wednesday', 10, 6, 10),
(346, 4, 'monday', 10, 9, 11),
(351, 9, 'monday', 10, 7, 12),
(353, 4, 'tuesday', 10, 6, 11),
(367, 6, 'wednesday', 10, 6, 10),
(378, 4, 'monday', 10, 9, 11),
(379, 9, 'monday', 10, 7, 12),
(380, 4, 'tuesday', 10, 6, 11),
(381, 6, 'wednesday', 10, 6, 10),
(411, 4, 'monday', 10, 9, 11),
(412, 9, 'monday', 10, 7, 12),
(413, 4, 'tuesday', 10, 6, 11),
(414, 6, 'wednesday', 10, 6, 10),
(415, 5, 'monday', 9, 5, 10),
(416, 6, 'monday', 9, 6, 11),
(417, 7, 'monday', 9, 7, 12),
(418, 8, 'monday', 9, 8, 13),
(419, 10, 'monday', 9, 9, 11),
(420, 5, 'tuesday', 9, 10, 12),
(421, 6, 'tuesday', 9, 6, 11),
(422, 7, 'tuesday', 9, 7, 12),
(423, 8, 'tuesday', 9, 8, 13),
(424, 9, 'tuesday', 9, 7, 11),
(425, 4, 'wednesday', 9, 4, 9),
(426, 5, 'thursday', 9, 5, 10),
(427, 4, 'friday', 9, 4, 9),
(428, 5, 'saturday', 9, 5, 10),
(429, 4, 'thursday', 9, 4, 9),
(430, 5, 'friday', 9, 5, 10),
(431, 4, 'saturday', 9, 4, 9),
(432, 5, 'wednesday', 9, 5, 10),
(433, 7, 'wednesday', 9, 7, 12),
(434, 6, 'thursday', 9, 12, 9),
(435, 7, 'thursday', 9, 11, 10),
(436, 6, 'friday', 9, 6, 11),
(437, 7, 'friday', 9, 6, 11),
(438, 6, 'saturday', 9, 6, 11),
(439, 7, 'saturday', 9, 6, 11),
(440, 9, 'friday', 9, 9, 13),
(441, 10, 'wednesday', 9, 7, 14),
(442, 9, 'thursday', 9, 8, 14),
(443, 8, 'thursday', 9, 7, 15),
(444, 8, 'wednesday', 9, 8, 14);

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
(20, 'Anushree', 'asjjh@jh.asdf', '3874982374', '098f6bcd4621d373cade4e832627b4f6', '2021-11-14 18:27:50'),
(21, 'Nikky Amresh', '8800900692@fd.hg', '91880900692', '927a0354df56b565ff387e339d4ddf80', '2021-11-18 11:55:07'),
(22, 'Mrs Taruna Chhabra', 'MrsTarunaChhabra@gmail.com', '7868768767', '2adf7c12befeb2de8bd153bb0c3413f6', '2021-11-18 18:06:28'),
(23, 'Mrs Bhanu Priya', 'bhanup@gmail.com', '8739587982345', '098f6bcd4621d373cade4e832627b4f6', '2021-11-18 18:06:58'),
(24, 'Mr Gaurav Gupta', 'ashdkfjha@gmail.com', '817498782', '098f6bcd4621d373cade4e832627b4f6', '2021-11-18 18:07:26'),
(25, 'Mr Durga Prasad Roy', '8374982374@hgs.sdf', '376287465', '927a0354df56b565ff387e339d4ddf80', '2021-11-18 18:07:55'),
(26, 'Mr Ravindra Kumar', 'kjasdhfj@jkhksdjf.sjdhf', '8743958752', '927a0354df56b565ff387e339d4ddf80', '2021-11-18 18:08:22'),
(27, 'Mr Deepak Arya', '918800900692@gmail.com', '84757864375', '927a0354df56b565ff387e339d4ddf80', '2021-11-19 05:38:15'),
(28, 'Nikky Amresh', 'nikkyamresh8@gmail.com', '+91880900692', '927a0354df56b565ff387e339d4ddf80', '2021-11-20 06:28:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AdminUser` (`userID`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timeTable_Attendance` (`timeTableID`),
  ADD KEY `student_Attendace` (`studentID`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departMentBranch` (`departmentID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classDepartment` (`departmentID`),
  ADD KEY `ClassBranch` (`branchID`),
  ADD KEY `classSemester` (`semesterID`),
  ADD KEY `classTeacher` (`teacherID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hod` (`hodID`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentUser` (`userID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
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
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `AdminUser` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `student_Attendace` FOREIGN KEY (`studentID`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `timeTable_Attendance` FOREIGN KEY (`timeTableID`) REFERENCES `timetables` (`id`);

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `departMentBranch` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `ClassBranch` FOREIGN KEY (`branchID`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `classDepartment` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `classSemester` FOREIGN KEY (`semesterID`) REFERENCES `semesters` (`id`),
  ADD CONSTRAINT `classTeacher` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `hod` FOREIGN KEY (`hodID`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `studentUser` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
