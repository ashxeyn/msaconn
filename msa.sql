-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 10:27 AM
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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calendar_activities`
--

CREATE TABLE `calendar_activities` (
  `activity_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `activity_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'College of Agriculture', 0, NULL, NULL),
(2, 'College of Architecture', 0, NULL, NULL),
(3, 'College of Computing Studies', 0, NULL, NULL),
(4, 'College of Criminal Justice Education', 0, NULL, NULL),
(5, 'College of Education', 0, NULL, NULL),
(6, 'College of Engineering', 0, NULL, NULL),
(7, 'College of Forestry and Environmental Studies', 0, NULL, NULL),
(8, 'College of Home Economics', 0, NULL, NULL),
(9, 'College of Law', 1, 'Try', '2025-05-01 15:02:17'),
(10, 'College of Liberal Arts', 0, NULL, NULL),
(11, 'College of Medicine', 0, NULL, NULL),
(12, 'College of Nursing', 0, NULL, NULL),
(13, 'College of Science and Mathematics', 0, NULL, NULL),
(14, 'College of Social Work and Community Development', 0, NULL, NULL),
(15, 'College of Sports Science and Physical Education', 0, NULL, NULL),
(16, 'College of Technical Education', 0, NULL, NULL),
(17, 'College of Hospitality Management', 0, NULL, NULL),
(18, 'sS', 1, 'S', '2025-05-05 04:41:24'),
(19, 'SAMPLEs', 1, 'SAMPLE', '2025-05-05 06:59:36');

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
(1, 'Kulong', 'Rone', '', 1, 7, 'Screenshot 2025-02-18 222613.png', 2, '2025-05-01 13:28:30', 1, 'try', '2025-05-01 15:16:08'),
(2, 'Jimenez', 'Shane', 'Duran', 2, 7, 'webcam-toy-photo14.jpg', 2, '2025-05-01 13:30:56', 0, NULL, NULL),
(3, 'Jaafar', 'Rhamirl', '', 20, 8, 'Screenshot 2025-01-03 151758.png', 2, '2025-05-01 13:32:01', 0, NULL, NULL),
(4, 'sdfsd', 'fsdfssd', 'fdfsdfsd', 17, 27, 'Screenshot (5).png', 1, '2025-05-05 04:43:29', 0, NULL, NULL),
(5, 'asda', 'sdasda', '', 3, 13, 'Screenshot (1).png', 1, '2025-05-05 09:16:35', 0, NULL, NULL);

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
(21, 'Registration', 0, NULL, NULL),
(23, 'Adviser', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `org_updates`
--

CREATE TABLE `org_updates` (
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
-- Table structure for table `prayer_schedule`
--

CREATE TABLE `prayer_schedule` (
  `prayer_id` int(11) NOT NULL,
  `prayer_type` enum('khutba','fajr','asr','maghrib','isha','jumu''ah') NOT NULL,
  `date` date NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, '2024-2025', 0, NULL, NULL),
(3, '2026-2027', 0, NULL, NULL),
(4, '2028-2029', 1, 'trip', '2025-05-01 15:09:06'),
(5, '2029-2030', 1, 'trip', '2025-05-01 15:07:31'),
(6, '2031-2032', 1, 'asdad', '2025-05-05 12:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `site_pages`
--

CREATE TABLE `site_pages` (
  `page_id` int(11) NOT NULL,
  `page_type` enum('registration','about','volunteer','calendar','faqs','transparency','home','logo','carousel','footer') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `contact_no` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transparency_report`
--

CREATE TABLE `transparency_report` (
  `report_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
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
(3, 'adminatics', '', 'admin', 'adminss', 'admin@wmsu.edu.ph', 'admin123', 'admin', '2025-05-01 08:20:18', NULL, 0, NULL, NULL),
(4, 'sub', 'sub', 'sub', 'sub', 'sub@wmsu.edu.ph', '$2y$10$TkNyqLP29O8syY9h/0Yl1ukM5jQ9WNPVrbWjmAhNsY0q1J7n1A/kq', 'sub-admin', '2025-05-01 12:51:55', 3, 0, NULL, NULL),
(5, 'Shane', '', 'Jimenez', 'ashxeynx', 'ashxeynx@wmsu.edu.ph', '$2y$10$UIDkASXpuBfVsXVUJ2B58.yIATNoUkScXWpEL5DY0n2kAdZsuQn.e', 'sub-admin', '2025-05-01 15:13:29', 19, 1, 'try', '2025-05-01 15:13:34'),
(6, 'adminn', 'adminn', 'adminn', 'adminn', 'adminn@gmail.com', '$2y$10$YHqUoGsuBsKMcDYyYwt87O/zbyqKsjQhMYjF4JlsdqHNFidU0rKQC', 'admin', '2025-05-02 05:50:10', NULL, 0, NULL, NULL),
(7, 'sfs', 'dfsdfs', 'sdfs', 'sdfs', 'asdas@wmsu.edu.ph', '$2y$10$TcQRKug94GAOg1ZSnKd2x.AYcyKJgKfx68wpD/wgkn9A8ffMDGhu6', 'sub-admin', '2025-05-05 04:43:52', 21, 0, NULL, NULL),
(8, 'asd', 'asda', 'asdasd', 'asdad', 'asdasda@gmail.com', '$2y$10$UHcuruockF5Xjhw2vJI8WOH4mz.L39nzVMVBtyWdCjYCibu0qhJAy', 'sub-admin', '2025-05-05 09:16:13', 12, 0, NULL, NULL);

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
-- Indexes for table `org_updates`
--
ALTER TABLE `org_updates`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `prayer_schedule`
--
ALTER TABLE `prayer_schedule`
  ADD PRIMARY KEY (`prayer_id`),
  ADD KEY `created_by` (`created_by`);

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
-- Indexes for table `site_pages`
--
ALTER TABLE `site_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page_type` (`page_type`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `executive_officers`
--
ALTER TABLE `executive_officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officer_positions`
--
ALTER TABLE `officer_positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `org_updates`
--
ALTER TABLE `org_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prayer_schedule`
--
ALTER TABLE `prayer_schedule`
  MODIFY `prayer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_pages`
--
ALTER TABLE `site_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transparency_report`
--
ALTER TABLE `transparency_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_images`
--
ALTER TABLE `update_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `executive_officers`
--
ALTER TABLE `executive_officers`
  ADD CONSTRAINT `executive_officers_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `officer_positions` (`position_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `executive_officers_ibfk_2` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`school_year_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_program_id` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL;

--
-- Constraints for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  ADD CONSTRAINT `fk_madrasa_enrollment_college` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_madrasa_enrollment_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `org_updates`
--
ALTER TABLE `org_updates`
  ADD CONSTRAINT `org_updates_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `prayer_schedule`
--
ALTER TABLE `prayer_schedule`
  ADD CONSTRAINT `prayer_schedule_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`) ON DELETE CASCADE;

--
-- Constraints for table `transparency_report`
--
ALTER TABLE `transparency_report`
  ADD CONSTRAINT `transparency_report_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`school_year_id`) ON DELETE CASCADE;

--
-- Constraints for table `update_images`
--
ALTER TABLE `update_images`
  ADD CONSTRAINT `update_images_ibfk_1` FOREIGN KEY (`update_id`) REFERENCES `org_updates` (`update_id`) ON DELETE CASCADE;

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
