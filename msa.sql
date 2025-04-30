-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 06:33 PM
-- Server version: 11.4.5-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msa`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_msa`
--

CREATE TABLE `about_msa` (
  `id` int(11) NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_msa`
--

INSERT INTO `about_msa` (`id`, `mission`, `vision`, `description`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(7, 'da', 'ad', 'asddsa', '2025-04-26 16:50:49', 1, 'asd', '2025-04-29 17:18:49'),
(8, 'asd', 'asdasd', 'asdasd', '2025-04-29 16:35:57', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `calendar_activities`
--

CREATE TABLE `calendar_activities` (
  `activity_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `activity_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_activities`
--

INSERT INTO `calendar_activities` (`activity_id`, `title`, `description`, `activity_date`, `created_by`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'sdfsd', 'fsfsfsz', '2025-04-19', NULL, '2025-04-04 09:37:20', 0, NULL, NULL),
(4, 'dfsd', 'sdfsas', '2025-04-19', NULL, '2025-04-05 05:33:40', 1, NULL, NULL),
(5, 'dfsd', 'sdfs', '2025-04-25', NULL, '2025-04-05 05:37:49', 0, NULL, NULL),
(6, 'ds', 'ds', '2025-04-25', NULL, '2025-04-05 05:37:59', 0, NULL, NULL),
(10, 'sx', 'asdasd', '2025-04-26', 1, '2025-04-06 03:01:04', 1, NULL, NULL),
(11, 'sheeshable', 'ass', '2025-04-25', 1, '2025-04-06 03:06:47', 0, NULL, NULL),
(12, 'asda', 'asdasdasdasdsdcsdcs', '2025-05-01', 1, '2025-04-29 05:53:47', 1, 'ASD', '2025-04-29 08:37:00'),
(13, 'asda', 'asdasdasd', '2025-04-08', 1, '2025-04-29 07:34:51', 0, NULL, NULL),
(14, 'ad', 'ad', '2025-04-30', 1, '2025-04-29 07:41:06', 0, NULL, NULL),
(15, 'asd', 'asdas', '2025-03-31', 1, '2025-04-29 07:52:15', 0, 'asd', '2025-04-29 07:52:20'),
(16, 'DSDSHET', 'DF', '2025-04-09', 1, '2025-04-29 08:09:44', 1, 'SD', '2025-04-29 08:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `college_id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`college_id`, `college_name`, `is_deleted`, `reason`, `deleted_at`) VALUES
(2, 'CCSSws', 0, NULL, NULL),
(3, 'CNss', 0, NULL, NULL),
(6, 'sd', 0, NULL, NULL),
(8, 'sads', 0, NULL, NULL),
(9, 'sadsa', 1, 'sad', '2025-04-28 16:56:56'),
(10, 'asddddddddddd', 0, NULL, NULL),
(11, 'd', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `downloadable_files`
--

CREATE TABLE `downloadable_files` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloadable_files`
--

INSERT INTO `downloadable_files` (`file_id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(4, 1, 'dsdasd', '1744977207_Automobile-metadata.docx', 'application/vnd.openxmlformats-officedocument.word', 17267, '2025-04-18 19:53:27', '2025-04-30 01:12:50', 0, NULL, NULL),
(5, 1, 'adas', '1744978038_00 Course Content Notes for CC105 - Application Development and Emerging Technologies.pdf', 'application/pdf', 360836, '2025-04-18 20:07:18', '2025-04-18 20:07:18', 0, NULL, NULL),
(6, 1, 'njakfs', '1745644019_The-Philippine-Drug-War-A-Failed-Experiment-in-Violence.pdf', 'application/pdf', 3633211, '2025-04-26 13:06:59', '2025-04-26 13:06:59', 0, NULL, NULL),
(7, 1, 'sdsa', '1745946303_Scenario 1.pdf', 'application/pdf', 25652, '2025-04-30 01:05:03', '2025-04-30 01:12:59', 0, 'asdasd', '2025-04-29 17:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `uploaded_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `image`, `description`, `created_at`, `uploaded_by`, `is_deleted`, `reason`, `deleted_at`) VALUES
(4, 'Screenshot 2024-08-28 183144.png', 'dddax', '2025-03-31 07:50:29', 1, 0, 'sd', '2025-04-28 20:02:40'),
(5, 'Hambre (1).png', 'ssssssssssssssssSS', '2025-04-16 12:07:26', 1, 0, NULL, NULL),
(6, 'Screenshot (4).png', 'efwef', '2025-04-28 18:32:52', 1, 0, NULL, NULL),
(7, 'Screenshot (4).png', 'sdfsdfsd', '2025-04-28 18:41:18', 1, 0, NULL, NULL),
(8, 'Screenshot (4).png', 'sad', '2025-04-28 18:43:15', 1, 0, NULL, NULL),
(9, 'Screenshot (4).png', 'sczs', '2025-04-28 19:07:31', 1, 0, NULL, NULL),
(10, 'Screenshot 2024-08-28 183144.png', 'S', '2025-04-29 04:31:10', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `executive_officers`
--

CREATE TABLE `executive_officers` (
  `officer_id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `position_id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `school_year_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `executive_officers`
--

INSERT INTO `executive_officers` (`officer_id`, `last_name`, `first_name`, `middle_name`, `position_id`, `program_id`, `image`, `school_year_id`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(5, 'asdaa', 'asd', 'asdasdas', 17, 3, '1744808236_458770354_489522533909122_3192676278561574321_n.jpg', 2, '2025-02-26 05:15:20', 0, 'df', '2025-04-30 08:36:34'),
(6, 'Kulong', 'Ron', '', 4, 3, '1744808526_459409453_1032098114905812_6755460979967927630_n.jpg', 2, '2025-02-26 11:07:34', 1, 'a', '2025-04-30 09:03:50'),
(13, 'ads', 'asdsd', 'asdasd', 14, NULL, '', 1, '2025-03-24 12:52:40', 0, NULL, NULL),
(14, 'sdfsddsss', 'sdfsd', 'dsfsdf', 15, 3, 'wap.png', 2, '2025-03-25 08:12:17', 0, NULL, NULL),
(18, 'asdasdniga', 'asd', 'asdas', 19, 3, 'Screenshot 2024-09-01 125053.png', 1, '2025-04-30 08:35:24', 0, NULL, NULL),
(19, 'fsdfsd', 'asdfasdf', 'adfsd', 19, 3, NULL, 1, '2025-04-30 08:36:25', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` enum('General Questions','Events and Activities','Donation and Support','Contact and Support') NOT NULL DEFAULT 'General Questions',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `question`, `answer`, `category`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(18, 'sad', 'asd', 'Events and Activities', '2025-03-26 16:52:34', 0, NULL, NULL),
(22, 'asasaased', 'asss', 'General Questions', '2025-03-26 17:19:20', 0, NULL, NULL),
(23, 'asd', 'sdad', 'General Questions', '2025-03-26 17:21:56', 0, NULL, NULL),
(24, 'as', 'asd', 'General Questions', '2025-03-26 17:27:29', 0, NULL, NULL),
(25, 's', 's', 'Events and Activities', '2025-03-26 17:29:18', 0, NULL, NULL),
(26, 'fvfv', 'fdfvdf', 'Donation and Support', '2025-03-27 03:25:41', 1, 'as', '2025-04-29 17:21:41'),
(27, 'asd', 'asdasd', 'General Questions', '2025-04-29 15:24:49', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friday_prayers`
--

CREATE TABLE `friday_prayers` (
  `prayer_id` int(11) NOT NULL,
  `khutbah_date` date NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friday_prayers`
--

INSERT INTO `friday_prayers` (`prayer_id`, `khutbah_date`, `speaker`, `topic`, `location`, `created_by`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, '2025-04-11', 'ron kulong', 'ewanssss', 'lab2', 17, '2025-04-06 03:27:48', 0, NULL, NULL),
(4, '2025-04-02', 'asds', 'dasdsss', 'asdadd', 1, '2025-04-29 07:20:13', 0, 'sdfd', '2025-04-29 07:20:38'),
(5, '2025-04-16', 'asdad', 'asdasdasdasd', 'asasdasdasdasdasd', 1, '2025-04-29 08:27:28', 0, 'trip lng', '2025-04-29 08:27:35'),
(6, '2025-04-18', 'ASDASD', 'SDADASD', 'ASDASDASDASDASD', 1, '2025-04-29 08:37:22', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `madrasa_enrollment`
--

CREATE TABLE `madrasa_enrollment` (
  `enrollment_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `classification` enum('On-site','Online') NOT NULL,
  `region` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `college_id` int(11) DEFAULT NULL,
  `ol_college` varchar(255) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `ol_program` varchar(255) DEFAULT NULL,
  `year_level` varchar(50) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `cor_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Enrolled','Rejected') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `madrasa_enrollment`
--

INSERT INTO `madrasa_enrollment` (`enrollment_id`, `first_name`, `middle_name`, `last_name`, `email`, `contact_number`, `classification`, `region`, `province`, `city`, `barangay`, `street`, `zip_code`, `college_id`, `ol_college`, `program_id`, `ol_program`, `year_level`, `school`, `cor_path`, `status`, `created_at`, `updated_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'Shane', 'Duran', 'Jimenez', '', '', 'Online', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 'wmsu', '1745130605_Hambre (1).png', 'Enrolled', '2025-04-20 14:30:05', '2025-04-20 14:30:05', 0, NULL, NULL),
(2, 'asf', 'Duran', 'Jimenez', '', '', 'Online', '', '', '', '', '', '', 2, NULL, 3, NULL, NULL, '', '1745130640_webcam-toy-photo9.jpg', 'Enrolled', '2025-04-20 14:30:40', '2025-04-21 23:39:57', 0, NULL, NULL),
(3, 'sfsd', 'sdfsf', 'sdfsfs', '', '', 'Online', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 'wmsu', '1745131022_459409453_1032098114905812_6755460979967927630_n.jpg', 'Enrolled', '2025-04-20 14:37:02', '2025-04-20 14:37:02', 0, NULL, NULL),
(6, 'Shane Hart', '', 'Jimenez', '', '', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, NULL, NULL, '1745238467_ron.png', 'Rejected', '2025-04-21 20:27:47', '2025-04-21 20:36:07', 0, NULL, NULL),
(13, 'FDF', 'SDF', 'SDFS', '', '', 'Online', '', '', '', '', '', '', 2, NULL, 3, NULL, NULL, 'SDF', NULL, 'Enrolled', '2025-04-23 22:34:46', '2025-04-23 22:34:46', 0, NULL, NULL),
(14, 'sdf', 'sdfsfs', 'sdfsdfsdfds', '', '', 'Online', '', '', '', '', '', '', NULL, 'sdf', NULL, 'sdfddddddddddd', NULL, 'sdf', NULL, 'Enrolled', '2025-04-23 22:42:41', '2025-04-30 15:59:55', 1, 'a', '2025-04-30 07:59:55'),
(16, 'sd', 'sd', 'sds', '', '', 'Online', '', '', '', '', '', '', NULL, 'sd', NULL, 'sdf', NULL, 'sds', NULL, 'Enrolled', '2025-04-23 23:15:15', '2025-04-23 23:15:15', 0, NULL, NULL),
(19, 'd', 'dsfdf', 'sdfsdf', '', '', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '1st year', NULL, '1745422167_Screenshot (3).png', 'Enrolled', '2025-04-23 23:29:27', '2025-04-30 15:15:13', 1, 'sdf', '2025-04-30 07:15:13'),
(20, 'rfe', 'efe', 'efef', '', '', 'Online', '', '', '', '', '', '', NULL, 'erf', NULL, 'eferf', NULL, 'efef', NULL, 'Enrolled', '2025-04-23 23:30:19', '2025-04-23 23:30:19', 0, NULL, NULL),
(21, 'AD', 'ADSD', 'ASD', '', '', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '1st year', NULL, '1745422388_Screenshot (4).png', 'Enrolled', '2025-04-23 23:33:08', '2025-04-23 23:33:08', 0, NULL, NULL),
(22, 'ASD', 'ADADAS', 'DASDASD', '', '', 'Online', '', '', '', '', '', '', NULL, 'ASDAS', NULL, 'ASDASDA', NULL, 'ASDAD', NULL, 'Enrolled', '2025-04-23 23:33:22', '2025-04-30 15:15:20', 1, 'sdas', '2025-04-30 07:15:20'),
(23, 'asddsdasdasdasda', 'sdfgfsrf', 'sdfsd', 'dfsdfsd@wmsu.edu.ph', '09066998483', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '2nd year', NULL, '1745994180_Screenshot (3).png', 'Enrolled', '2025-04-30 14:23:00', '2025-04-30 14:24:42', 0, NULL, NULL),
(24, 'asdasd', 'asdasdsanigga', 'asdasd', 'ertrt@wmsu.edu.ph', '0907678695', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '1st year', NULL, '1745994506_Screenshot (3).png', 'Enrolled', '2025-04-30 14:28:26', '2025-04-30 16:04:04', 1, 'as', '2025-04-30 08:04:04'),
(25, 'sgfdsdsfniga', 'dfgdfg', 'dfgdfg', 'HZ202300259@wmsu.edu.ph', '099875456', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '2nd year', NULL, '1745994884_Screenshot (2).png', 'Enrolled', '2025-04-30 14:34:44', '2025-04-30 16:24:09', 1, NULL, NULL),
(26, 'asda', 'asdasd', 'asdasd', 'HZ202300259@wmsu.edu.ph', '09876545323', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '2nd year', NULL, '1745995535_Screenshot (3).png', 'Enrolled', '2025-04-30 14:45:35', '2025-04-30 14:45:35', 0, NULL, NULL),
(27, 'QWESDFSDFSD', 'QWE', 'QWEQW', 'HZ202300259@wmsu.edu.ph', '23423423', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '1st year', NULL, '1745997110_Screenshot (4).png', 'Enrolled', '2025-04-30 15:11:50', '2025-04-30 15:49:42', 1, NULL, NULL),
(28, 'asdas', 'asdasd', 'asdasd', 'shanehart1001@wmsu.edu.ph', '09066998688', 'On-site', '', '', '', '', '', '', 2, NULL, 3, NULL, '1st year', NULL, '1745997922_output.png', 'Enrolled', '2025-04-30 15:25:22', '2025-04-30 16:17:36', 1, 'd', '2025-04-30 08:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `officer_positions`
--

CREATE TABLE `officer_positions` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officer_positions`
--

INSERT INTO `officer_positions` (`position_id`, `position_name`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'President', 0, NULL, NULL),
(2, 'Internal Vice President', 0, NULL, NULL),
(3, 'External Vice President', 0, NULL, NULL),
(4, 'Secretary', 0, NULL, NULL),
(5, 'Treasurer', 0, NULL, NULL),
(6, 'Auditor', 0, NULL, NULL),
(7, 'P.I.O.', 0, NULL, NULL),
(8, 'Project Manager', 0, NULL, NULL),
(9, 'Vice President', 0, NULL, NULL),
(10, 'P.I.O. Internal', 0, NULL, NULL),
(11, 'P.I.O. External', 0, NULL, NULL),
(12, 'Dahwa and Religious Instructions', 0, NULL, NULL),
(13, 'Documentation and Publication', 0, NULL, NULL),
(14, 'Logistics and Operations', 0, NULL, NULL),
(15, 'Budget and Finance', 0, NULL, NULL),
(16, 'Statistics and Evaluations', 0, NULL, NULL),
(17, 'Registration and Membership', 0, NULL, NULL),
(18, 'Tahara', 0, NULL, NULL),
(19, 'Publication', 0, NULL, NULL),
(20, 'Documentation', 0, NULL, NULL),
(21, 'Registration', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `college_id`, `is_deleted`, `reason`, `deleted_at`) VALUES
(3, 'shheshDDd', 2, 0, NULL, NULL),
(6, 'asdssasdasdads', 2, 1, 'sad', '2025-04-28 17:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`school_year_id`, `school_year`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, '2023-2024', 0, NULL, NULL),
(2, '2024-2025', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_updates`
--

CREATE TABLE `system_updates` (
  `update_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transparency_report`
--

CREATE TABLE `transparency_report` (
  `report_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `expense_detail` text NOT NULL,
  `expense_category` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('Cash In','Cash Out') NOT NULL,
  `semester` enum('1st','2nd') NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transparency_report`
--

INSERT INTO `transparency_report` (`report_id`, `report_date`, `expense_detail`, `expense_category`, `amount`, `transaction_type`, `semester`, `school_year_id`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, '2025-02-28', 'SHEESH', 'Administrative cost', 5000.00, 'Cash In', '1st', 2, 1, 'asdsd', '2025-04-29 13:43:13'),
(2, '2025-03-01', 'aefefSS', 'FULL TANK', 2000.00, 'Cash Out', '1st', 2, 0, NULL, NULL),
(5, '2025-04-09', 'SSS', '', 3000.00, 'Cash In', '1st', 2, 1, NULL, NULL),
(6, '2025-04-10', 'dasdsdsed', 'asdasdad', 2020.00, 'Cash Out', '1st', 2, 1, 'ytip kolng', '2025-04-29 15:29:46'),
(7, '2025-04-04', 'fsfs', '', 3234.00, 'Cash In', '2nd', 2, 1, 'asd', '2025-04-29 13:43:57'),
(10, '2025-04-26', 'ssss', 'asdasd', 1223.00, 'Cash In', '2nd', 2, 0, NULL, NULL),
(13, '2025-04-11', 'asd', 'asda', 121.00, 'Cash In', '1st', 2, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `update_images`
--

CREATE TABLE `update_images` (
  `image_id` int(11) NOT NULL,
  `update_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sub-admin') NOT NULL DEFAULT 'sub-admin',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `position_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `username`, `email`, `password`, `role`, `created_at`, `position_id`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin@wmsu.edu.ph', '$2y$10$cpAg005FgxgFGWv2uauF4egLs8ONXcMUSzOPlbaF0guCcdyOLmGZi', 'admin', '2025-02-23 03:11:49', NULL, 0, NULL, NULL),
(2, 'Shane', 'admin', 'Jimenez', 'ashxeynx', 'HZ202300259@wmsu.edu.ph', '$2y$10$Aow.SzRWGFBga4v5153m8Oe1IDlKWewGIZ5CPrNELpEJnzOVB4OTS', 'admin', '2025-02-23 04:03:09', NULL, 0, NULL, NULL),
(3, 'Rone', 'admin', 'Kulong', 'ron', 'admin@gmail.com', '$2y$10$agnEQCmt8ADyI/4a2dtvlOlGkDbbxvo/50I9Av11RQjuwluVKCrOe', 'admin', '2025-02-23 04:04:44', NULL, 0, NULL, NULL),
(7, 'sheesh', 'admin', 'bnb', 'rronn', 'ron@wmsu.edu.ph', '$2y$10$o4peCliKj4cIXPooJOYOfu8e.MIuwvkWiuTcdMANEH4QIef1QxFO6', 'admin', '2025-02-24 07:24:44', NULL, 0, NULL, NULL),
(9, 'sfvf', 'admin', 'dfvf', 'manager12', 'dvd@wmsu.edu.ph', '$2y$10$c4Igsr/pEcBpW742vdBvheznDxPHt0NlHkM3K1L8gzqKBBwtaAnIq', 'admin', '2025-02-24 07:32:26', NULL, 0, NULL, NULL),
(16, 'asdapakingshe', 'asdasfasss', 'adfaef', 'asdfefe', 'HZ2234300259@wmsu.edu.ph', '$2y$10$9r626N9kIa2AynwspQ2qJuFF.jGWTI9eYzBuH8w4inKomC0Uizw/O', 'sub-admin', '2025-04-30 11:02:51', 1, 0, 's', '0000-00-00 00:00:00'),
(17, 'sub', 'sub', 'sub', 'sub', 'sub@wmsu.edu.ph', '$2y$10$5CO4kvwyMDftD4aDxRR3Wu1VNPcQGPIftETFGlOYJDQOcRy8x0uYi', 'sub-admin', '2025-02-24 08:51:33', 2, 1, 'S', '2025-04-30 11:00:12'),
(22, 'dcasfafa', 'asdfasfSSS', 'asfaf', 'afsfuvkyou', 'HZsdsd300259@wmsu.edu.ph', '$2y$10$bRmm3Z9PBKrlazrhTN024epeRX.qGVgUbFZP4VnadXiyRRlLyggMW', 'sub-admin', '2025-03-18 12:30:28', 17, 1, 'w', '2025-04-30 16:19:28'),
(23, 'shane', '', 'shane', 'shane', 'shanehart1001@gmail.com', '$2y$10$YZnz75dPOm.bdtWhvWO4Guv0pUiZhSfmji9qbfONt7uIs1WJTgIdG', 'sub-admin', '2025-04-30 14:18:06', 10, 1, ';ll', '2025-04-30 14:23:35'),
(26, 'SDF', 'SDFSDF', 'DFSDF', 'ashxasdqwdqwynx', 'HZ2hhh300259@wmsu.edu.ph', '$2y$10$3TOiJtVpoP6q7F0r8Pf3j.elrgn.HPAufi5v7xw8DuXsiG8BvilFG', 'sub-admin', '2025-04-30 16:19:08', 17, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `section` varchar(10) NOT NULL,
  `program_id` int(11) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cor_file` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`volunteer_id`, `first_name`, `middle_name`, `last_name`, `year`, `section`, `program_id`, `contact`, `email`, `cor_file`, `status`, `user_id`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(6, 'adadasda', 'asdasdasnega', 'asdasd', 1, 'C', 3, '09926314071', 'HZ202300259@wmsu.edu.ph', '1742888757_webcam-toy-photo30.jpg', 'approved', 1, '2025-03-25 07:45:57', 0, NULL, NULL),
(9, 'sdfsdf', 'sdfsf', 'sdfsdf', 3, 'dfsdfs', 3, '09926314071', 'HZ20230ff59@wmsu.edu.ph', '', 'approved', 1, '2025-03-25 07:59:07', 0, NULL, NULL),
(12, 'NSDJJ', 'sdfsd', 'sdfs', 2, 'as', 3, '09926314074', 'sdfsfd@wmsu.edu.ph', '1745127797_456723636_314693881731223_8072479450925397794_n.jpg', 'pending', NULL, '2025-04-20 05:43:17', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_msa`
--
ALTER TABLE `about_msa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`college_id`),
  ADD UNIQUE KEY `college_name` (`college_name`);

--
-- Indexes for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `fk_user_files_user` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `executive_officers`
--
ALTER TABLE `executive_officers`
  ADD PRIMARY KEY (`officer_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `fk_program_id` (`program_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `friday_prayers`
--
ALTER TABLE `friday_prayers`
  ADD PRIMARY KEY (`prayer_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `fk_madrasa_enrollment_college` (`college_id`),
  ADD KEY `fk_madrasa_enrollment_program` (`program_id`);

--
-- Indexes for table `officer_positions`
--
ALTER TABLE `officer_positions`
  ADD PRIMARY KEY (`position_id`),
  ADD UNIQUE KEY `position_name` (`position_name`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`),
  ADD UNIQUE KEY `program_name` (`program_name`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`school_year_id`),
  ADD UNIQUE KEY `school_year` (`school_year`);

--
-- Indexes for table `system_updates`
--
ALTER TABLE `system_updates`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `transparency_report`
--
ALTER TABLE `transparency_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `school_year_id` (`school_year_id`);

--
-- Indexes for table `update_images`
--
ALTER TABLE `update_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `update_id` (`update_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_officer_positions` (`position_id`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `fk_adminusers` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_msa`
--
ALTER TABLE `about_msa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `executive_officers`
--
ALTER TABLE `executive_officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `friday_prayers`
--
ALTER TABLE `friday_prayers`
  MODIFY `prayer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `officer_positions`
--
ALTER TABLE `officer_positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_updates`
--
ALTER TABLE `system_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transparency_report`
--
ALTER TABLE `transparency_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `update_images`
--
ALTER TABLE `update_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  ADD CONSTRAINT `calendar_activities_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  ADD CONSTRAINT `fk_user_files_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `executive_officers`
--
ALTER TABLE `executive_officers`
  ADD CONSTRAINT `executive_officers_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `officer_positions` (`position_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `executive_officers_ibfk_2` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`school_year_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_program_id` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL;

--
-- Constraints for table `friday_prayers`
--
ALTER TABLE `friday_prayers`
  ADD CONSTRAINT `friday_prayers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  ADD CONSTRAINT `fk_madrasa_enrollment_college` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_madrasa_enrollment_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`) ON DELETE CASCADE;

--
-- Constraints for table `system_updates`
--
ALTER TABLE `system_updates`
  ADD CONSTRAINT `system_updates_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transparency_report`
--
ALTER TABLE `transparency_report`
  ADD CONSTRAINT `transparency_report_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`school_year_id`) ON DELETE CASCADE;

--
-- Constraints for table `update_images`
--
ALTER TABLE `update_images`
  ADD CONSTRAINT `update_images_ibfk_1` FOREIGN KEY (`update_id`) REFERENCES `system_updates` (`update_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_officer_positions` FOREIGN KEY (`position_id`) REFERENCES `officer_positions` (`position_id`) ON DELETE SET NULL;

--
-- Constraints for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `fk_adminusers` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `volunteers_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
