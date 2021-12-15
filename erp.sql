-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 11, 2021 at 02:25 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `achivementdetails`
--

CREATE TABLE `achivementdetails` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `achivementdetails`
--

INSERT INTO `achivementdetails` (`id`, `userID`, `title`, `date`, `description`) VALUES
(1, 1, 'MTA security fundamentals', '2018-12-07', 'achievement from microsoft'),
(2, 3, 'coursera web developemnt', '2021-12-04', 'received from coursera');

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
  `date` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `timeTableID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `studentID`, `date`, `status`, `timeTableID`) VALUES
(1, 1, '2021-12-08', 1, 415),
(2, 1, '2021-12-09', 1, 416);

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
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `org` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `userID`, `title`, `org`, `description`, `date`, `link`) VALUES
(1, 1, 'MTAP security fundamentals', 'Microsoft', 'received certificate from microsoft', '2018-12-08', 'https://www.jotform.com/pdf-editor/213441654500042?template=1'),
(2, 3, 'udemy web developemnt', 'coursera', 'received certificate from udemy', '2021-12-01', 'https://www.udemy.com/course/photoshop-pro-100/');

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
-- Table structure for table `educationdetails`
--

CREATE TABLE `educationdetails` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `school` varchar(50) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `field` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `educationdetails`
--

INSERT INTO `educationdetails` (`id`, `userID`, `school`, `degree`, `fromDate`, `toDate`, `field`, `grade`, `description`) VALUES
(1, 1, 'Jawahar navodaya vidyalaya ', 'under graduation', '2021-11-03', '2018-12-04', 'science', '9.0', 'xyz desc of education details'),
(2, 3, 'kendriya vidyalaya', 'under graduation', '2020-12-03', '2021-12-04', 'science', '9.0', 'xyz desc of education details');

-- --------------------------------------------------------

--
-- Table structure for table `experiencedetails`
--

CREATE TABLE `experiencedetails` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `employmentType` varchar(20) NOT NULL,
  `companyName` varchar(20) NOT NULL,
  `location` varchar(20) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `experiencedetails`
--

INSERT INTO `experiencedetails` (`id`, `userID`, `title`, `employmentType`, `companyName`, `location`, `fromDate`, `toDate`, `description`) VALUES
(1, 1, 'devops', 'full time', 'fotonicia', 'delhi', '2020-12-02', '2021-12-03', 'xyz desc of experience details'),
(2, 3, 'web developer', 'intern', 'infotech', 'delhi', '2020-12-02', '2020-12-05', 'xyz desc of experience');

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `userID`, `title`, `description`, `fromDate`, `toDate`, `link`) VALUES
(1, 1, 'pexels py', 'xyz desc of projects', '2021-12-02', '2021-12-03', 'https://www.pexels.com/'),
(2, 3, 'dictionary', 'desc about dictionary', '2020-12-05', '2021-12-06', 'https://www.dictionary.com/');

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
-- Table structure for table `studentpersonaldetails`
--

CREATE TABLE `studentpersonaldetails` (
  `id` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `fatherName` varchar(50) NOT NULL,
  `fatherMobile` varchar(15) NOT NULL,
  `fatherEmail` varchar(50) NOT NULL,
  `motherName` varchar(50) NOT NULL,
  `motherEmail` varchar(50) NOT NULL,
  `motherMobile` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studentpersonaldetails`
--

INSERT INTO `studentpersonaldetails` (`id`, `studentID`, `fatherName`, `fatherMobile`, `fatherEmail`, `motherName`, `motherEmail`, `motherMobile`, `address`) VALUES
(1, 1, 'Ramesh Kumar', '9876543219', 'ramesh@gmail.com', 'Asha Kumari', 'asha@gmail.com', '987654392', 'Dumraon, Bihar'),
(2, 3, 'Mamesh Kumar', '9876543219', 'mamesh@gmail.com', 'Misha Kumari', 'misha@gmail.com', '987654392', 'delhi,India');

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
(3, 4, 4, 3, 10, '1902ECE'),
(4, 30, 4, 3, 10, '9391'),
(5, 31, 4, 3, 10, '11459'),
(6, 32, 4, 3, 10, '16798'),
(7, 33, 4, 3, 10, '19745'),
(8, 34, 4, 3, 10, '19780'),
(9, 35, 4, 3, 10, '19786'),
(10, 36, 4, 3, 10, '19840'),
(11, 37, 4, 3, 10, '19857'),
(12, 38, 4, 3, 10, '23668'),
(13, 39, 4, 3, 10, '25197'),
(14, 40, 4, 3, 10, '28831'),
(15, 41, 4, 3, 10, '29042'),
(16, 42, 4, 3, 10, '29921'),
(17, 43, 4, 3, 10, '30040'),
(18, 44, 4, 3, 10, '30045'),
(19, 45, 4, 3, 10, '30046'),
(20, 46, 4, 3, 10, '30048'),
(21, 47, 4, 3, 10, '30056'),
(22, 48, 4, 3, 10, '30066'),
(23, 49, 4, 3, 10, '30067'),
(24, 50, 4, 3, 10, '30070'),
(25, 51, 4, 3, 10, '30075'),
(26, 52, 4, 3, 10, '30076'),
(27, 53, 4, 3, 10, '30077'),
(28, 54, 4, 3, 10, '30079'),
(29, 55, 4, 3, 10, '30081'),
(30, 56, 4, 3, 10, '30083'),
(31, 57, 4, 3, 10, '30085'),
(32, 58, 4, 3, 10, '30093'),
(33, 59, 4, 3, 10, '30096'),
(34, 60, 4, 3, 10, '30098'),
(35, 61, 4, 3, 10, '30099'),
(36, 62, 4, 3, 10, '30105'),
(37, 63, 4, 3, 10, '30108'),
(38, 64, 4, 3, 10, '30110'),
(39, 65, 4, 3, 10, '30115'),
(40, 66, 4, 3, 10, '30121'),
(41, 67, 4, 3, 10, '30126'),
(42, 68, 4, 3, 10, '30128'),
(43, 69, 4, 3, 10, '30137'),
(44, 70, 4, 3, 10, '30146'),
(45, 71, 4, 3, 10, '30154'),
(46, 72, 4, 3, 10, '30158'),
(47, 73, 4, 3, 10, '30165'),
(48, 74, 4, 3, 10, '30167'),
(49, 75, 4, 3, 10, '30172'),
(50, 76, 4, 3, 10, '30173'),
(51, 77, 4, 3, 10, '30180'),
(52, 78, 4, 3, 10, '30182'),
(53, 79, 4, 3, 10, '30184');

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
(444, 8, 'wednesday', 9, 8, 14),
(445, 5, 'monday', 9, 5, 10),
(446, 6, 'monday', 9, 6, 11),
(447, 7, 'monday', 9, 7, 12),
(448, 8, 'monday', 9, 8, 13),
(449, 10, 'monday', 9, 9, 11),
(450, 5, 'tuesday', 9, 10, 12),
(451, 6, 'tuesday', 9, 6, 11),
(452, 7, 'tuesday', 9, 7, 12),
(453, 8, 'tuesday', 9, 8, 13),
(454, 9, 'tuesday', 9, 7, 11),
(455, 4, 'wednesday', 9, 4, 9),
(456, 5, 'thursday', 9, 5, 10),
(457, 4, 'friday', 9, 4, 9),
(458, 5, 'saturday', 9, 5, 10),
(459, 4, 'thursday', 9, 4, 9),
(460, 5, 'friday', 9, 5, 10),
(461, 4, 'saturday', 9, 4, 9),
(462, 5, 'wednesday', 9, 5, 10),
(463, 7, 'wednesday', 9, 7, 12),
(464, 6, 'thursday', 9, 12, 9),
(470, 5, 'monday', 9, 5, 10),
(471, 6, 'monday', 9, 6, 11),
(472, 7, 'monday', 9, 7, 12),
(473, 8, 'monday', 9, 8, 13),
(474, 10, 'monday', 9, 9, 11),
(475, 5, 'tuesday', 9, 10, 12),
(476, 6, 'tuesday', 9, 6, 11),
(477, 7, 'tuesday', 9, 7, 12),
(478, 8, 'tuesday', 9, 8, 13),
(479, 9, 'tuesday', 9, 7, 11),
(480, 4, 'wednesday', 9, 4, 9),
(481, 5, 'thursday', 9, 5, 10),
(482, 4, 'friday', 9, 4, 9),
(483, 5, 'saturday', 9, 5, 10),
(484, 4, 'thursday', 9, 4, 9),
(485, 5, 'friday', 9, 5, 10),
(486, 4, 'saturday', 9, 4, 9),
(487, 5, 'wednesday', 9, 5, 10),
(488, 7, 'wednesday', 9, 7, 12),
(489, 6, 'thursday', 9, 12, 9),
(495, 9, 'friday', 9, 10, 12),
(496, 5, 'monday', 9, 5, 10),
(497, 6, 'monday', 9, 6, 11),
(498, 7, 'monday', 9, 7, 12),
(499, 8, 'monday', 9, 8, 13),
(500, 10, 'monday', 9, 9, 11),
(501, 5, 'tuesday', 9, 10, 12),
(502, 6, 'tuesday', 9, 6, 11),
(503, 7, 'tuesday', 9, 7, 12),
(504, 8, 'tuesday', 9, 8, 13),
(505, 9, 'tuesday', 9, 7, 11),
(506, 4, 'wednesday', 9, 4, 9),
(507, 5, 'thursday', 9, 5, 10),
(508, 4, 'friday', 9, 4, 9),
(509, 5, 'saturday', 9, 5, 10),
(510, 4, 'thursday', 9, 4, 9),
(511, 5, 'friday', 9, 5, 10),
(512, 4, 'saturday', 9, 4, 9),
(513, 5, 'wednesday', 9, 5, 10),
(514, 7, 'wednesday', 9, 7, 12),
(515, 6, 'thursday', 9, 12, 9),
(522, 5, 'monday', 9, 5, 10),
(523, 6, 'monday', 9, 6, 11),
(524, 7, 'monday', 9, 7, 12),
(525, 8, 'monday', 9, 8, 13),
(526, 10, 'monday', 9, 9, 11),
(527, 5, 'tuesday', 9, 10, 12),
(528, 6, 'tuesday', 9, 6, 11),
(529, 7, 'tuesday', 9, 7, 12),
(530, 8, 'tuesday', 9, 8, 13),
(531, 9, 'tuesday', 9, 7, 11),
(532, 4, 'wednesday', 9, 4, 9),
(533, 5, 'thursday', 10, 10, 12),
(534, 4, 'friday', 9, 4, 9),
(535, 5, 'saturday', 9, 5, 10),
(536, 4, 'thursday', 9, 4, 9),
(537, 5, 'friday', 9, 5, 10),
(538, 4, 'saturday', 9, 4, 9),
(539, 5, 'wednesday', 9, 5, 10),
(540, 7, 'wednesday', 9, 7, 12),
(541, 6, 'thursday', 9, 12, 9),
(542, 4, 'monday', 10, 9, 11),
(543, 9, 'monday', 10, 7, 12),
(544, 4, 'tuesday', 10, 6, 11),
(545, 6, 'wednesday', 10, 6, 10),
(546, 8, 'wednesday', 10, 8, 10),
(547, 9, 'thursday', 10, 7, 14);

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
  `lastLogin` timestamp NOT NULL DEFAULT current_timestamp()
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
(28, 'Nikky Amresh', 'nikkyamresh8@gmail.com', '+91880900692', '927a0354df56b565ff387e339d4ddf80', '2021-11-20 06:28:02'),
(29, 'New Teacher', 'root@test.com', '98394829', 'bed763da5d83dbe09200aa709c4803c7', '2021-12-09 15:37:10'),
(30, 'devansh dashora', 'sachindashora130@gmail.com', '9636372849', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:24'),
(31, 'Aman Dubey', 'dubey01aman@gmail.com', '7879694537', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:24'),
(32, 'karthick h', 'karthick311418104025@gmail.com', '9940385021', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:24'),
(33, 'Singireddy Bharath', 'singireddybharath99@gmail.com', '917382380428', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:24'),
(34, 'KAVYA SREE GORRE', 'kavyasreeg999@gmail.com', '9121016104', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:24'),
(35, 'Pranathi BHONAGIRI', 'pranathisree124@gmail.com', '7013452467', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(36, 'Saiharika Enagala', 'saiharikaenagala2001@gmail.com', '9381594481', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(37, 'Akhila Arvapalli', 'akhilaarvapalli2@gmail.com', '916303531292', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(38, 'Venkata Karthik Golla', 'gollakarthik001@gmail.com', '8688377353', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(39, 'Mohd Asad', 'mohdasadnaseem.man786@gmail.com', '9027623846', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(40, 'chaitanya raju g.l.v', 'chaitanyachaitu325@gmail.com', '9885095988', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(41, 'Gokul H', 'echoserria28@gmail.com', '8610482182', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(42, 'Astha Anni', 'asthaanni7301@gmail.com', '7033102905', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(43, 'Kinshuk Bansal', 'kinshukbansal.cse24@jecrc.ac.in', '8387026256', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(44, 'Yash Bansal', 'yashbansal.cse23@jecrc.ac.in', '8290545090', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(45, 'Deeksha Gupta', 'deekshagupta.it23@jecrc.ac.in', '8955780012', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(46, 'Ankit Goyal', 'ankitgoyal.2cse23@jecrc.ac.in', '9413371104', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(47, 'UTKARSH Dubey', 'utkarshdubey.cse23@jecrc.ac.in', '8303083523', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(48, 'Pushpendra Singh Gurjar', 'pushpendrasinghgurjar.cse22@jecrc.ac.in', '9672407021', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(49, 'Bhunesh Dadheech', 'Bhuneshdadheech362@gmail.com', '9982794604', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(50, 'Khushi Goyal', 'khushigoyal.cse24@jecrc.ac.in', '6377341988', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(51, 'Khushi Garg', 'khushigarg.ai24@jecrc.ac.in', '9785226238', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(52, 'Bhawna Golchha', 'bhawnagolchha03@gmail.com', '9999999999', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(53, 'Anjali Anjali', 'anjali.ece24@jecrc.ac.in', '7764877222', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(54, 'Mohit Gupta', 'mohitgupta.cse24@jecrc.ac.in', '8209649240', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(55, 'Ashish Gupta', 'ashishgupta.ece24@jecrc.ac.in', '9782558727', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(56, 'Sneha Agarwal', 'snehaagarwal.ai24@jecrc.ac.in', '9999999999', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(57, 'Anuj Bhalothia', 'anujbhalothia.cse24@jecrc.ac.in', '9414345812', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(58, 'Nikhil Gautam', 'nikhilgautam.cse23@jecrc.ac.in', '9828413720', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(59, 'SAMARTH AMERA', 'samarthamera2707@gmail.com', '9166334222', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(60, 'Chintan Grover', 'chintangrover.ai24@jecrc.ac.in', '7340322282', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(61, 'Hemant kumar garg', 'hemantkumargarg.cse24@jecrc.ac.in', '7410896906', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(62, 'Arin Goyal', 'aringoyal.cse24@jecrc.ac.in', '9166627203', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(63, 'Harsh Gupta', 'harshgupta.ece24@jecrc.ac.in', '9462830136', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(64, 'Mohan Chandak', 'mohanchandak.cse23@jecrc.ac.in', '8824820074', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(65, 'Chirag Garg', 'chiraggarg.it24@jecrc.ac.in', '8302998044', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(66, 'Mihir Dadhich', 'mihirdadhich.ece23@jecrc.ac.in', '9636040882', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(67, 'Lalit Dhakad', 'Lalitdhakad.ce24@jecrc.ac.in', '7726048421', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(68, 'Manu Garg', 'manugarg.ai24@jecrc.ac.in', '9929813200', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(69, 'Lavkush Bansal', 'lavkushbansal.cse23@jecrc.ac.in', '8740950931', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(70, 'Abhijeet Dadheech', 'abhijeetdadheech.ece24@jecrc.ac.in', '8112284175', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(71, 'Ayushi George', 'ayushigeorge31@gmail.com', '8058184584', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(72, 'Rounak Garg', 'rounakgarg68@gmail.com', '9468584541', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(73, 'Abhay Agrawal', 'abhayagrawal.it24@jecrc.ac.in', '7878053154', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(74, 'Chandra prakash Gupta', 'chandraprakashgupta.ece24@jecrc.ac.in', '7877010702', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(75, 'Rashmi Gaur', 'rashmigaur.cse23@jecrc.ac.in', '7726958662', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:25'),
(76, 'Vikalp Chaturvedi', 'vikalpchaturvedi.cse23@jecrc.ac.in', '9772551557', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:26'),
(77, 'Priyanshu Garg', 'Priyanshugarg.it24@jecrc.ac.in', '7597374717', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:26'),
(78, 'palash gupta', 'palashgupta.cse23@jecrc.ac.in', '7742623453', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:26'),
(79, 'Harshit Agarwal', 'harshitagarwal.it23@jecrc.ac.in', '9571132601', '098f6bcd4621d373cade4e832627b4f6', '2021-12-10 18:51:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achivementdetails`
--
ALTER TABLE `achivementdetails`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `educationdetails`
--
ALTER TABLE `educationdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiencedetails`
--
ALTER TABLE `experiencedetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentpersonaldetails`
--
ALTER TABLE `studentpersonaldetails`
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
-- AUTO_INCREMENT for table `achivementdetails`
--
ALTER TABLE `achivementdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `educationdetails`
--
ALTER TABLE `educationdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `experiencedetails`
--
ALTER TABLE `experiencedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `studentpersonaldetails`
--
ALTER TABLE `studentpersonaldetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=548;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

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
