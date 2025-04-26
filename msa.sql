-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 09:23 PM
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
  `reason` varchar(255) DEFAULT NULL
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
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `college_id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`college_id`, `college_name`, `is_deleted`, `reason`) VALUES
(2, 'CCSSws', 0, NULL),
(3, 'CN', 0, NULL),
(6, 'sd', 0, NULL);

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
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloadable_files`
--

INSERT INTO `downloadable_files` (`file_id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`, `is_deleted`, `reason`) VALUES
(4, 1, 'dsd', '1744977207_Automobile-metadata.docx', 'application/vnd.openxmlformats-officedocument.word', 17267, '2025-04-18 19:53:27', '2025-04-18 19:53:27', 0, NULL),
(5, 1, 'adas', '1744978038_00 Course Content Notes for CC105 - Application Development and Emerging Technologies.pdf', 'application/pdf', 360836, '2025-04-18 20:07:18', '2025-04-18 20:07:18', 0, NULL),
(6, 1, 'njakfs', '1745644019_The-Philippine-Drug-War-A-Failed-Experiment-in-Violence.pdf', 'application/pdf', 3633211, '2025-04-26 13:06:59', '2025-04-26 13:06:59', 0, NULL);

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
  `reason` varchar(255) DEFAULT NULL
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
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `reason` varchar(255) DEFAULT NULL
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
  `classification` enum('On-site','Online') NOT NULL,
  `address` varchar(255) DEFAULT NULL,
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
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `officer_positions`
--

CREATE TABLE `officer_positions` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officer_positions`
--

INSERT INTO `officer_positions` (`position_id`, `position_name`, `is_deleted`, `reason`) VALUES
(1, 'President', 0, NULL),
(2, 'Internal Vice President', 0, NULL),
(3, 'External Vice President', 0, NULL),
(4, 'Secretary', 0, NULL),
(5, 'Treasurer', 0, NULL),
(6, 'Auditor', 0, NULL),
(7, 'P.I.O.', 0, NULL),
(8, 'Project Manager', 0, NULL),
(9, 'Vice President', 0, NULL),
(10, 'P.I.O. Internal', 0, NULL),
(11, 'P.I.O. External', 0, NULL),
(12, 'Dahwa and Religious Instructions', 0, NULL),
(13, 'Documentation and Publication', 0, NULL),
(14, 'Logistics and Operations', 0, NULL),
(15, 'Budget and Finance', 0, NULL),
(16, 'Statistics and Evaluations', 0, NULL),
(17, 'Registration and Membership', 0, NULL),
(18, 'Tahara', 0, NULL),
(19, 'Publication', 0, NULL),
(20, 'Documentation', 0, NULL),
(21, 'Registration', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `college_id`, `is_deleted`, `reason`) VALUES
(3, 'shheshDDd', 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`school_year_id`, `school_year`, `is_deleted`, `reason`) VALUES
(1, '2023-2024', 0, NULL),
(2, '2024-2025', 0, NULL);

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
  `reason` varchar(255) DEFAULT NULL
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
  `reason` varchar(255) DEFAULT NULL
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
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `username`, `email`, `password`, `role`, `created_at`, `position_id`, `is_deleted`, `reason`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin@wmsu.edu.ph', '$2y$10$cpAg005FgxgFGWv2uauF4egLs8ONXcMUSzOPlbaF0guCcdyOLmGZi', 'admin', '2025-02-23 03:11:49', NULL, 0, NULL),
(2, 'Shane', 'admin', 'Jimenez', 'ashxeynx', 'HZ202300259@wmsu.edu.ph', '$2y$10$Aow.SzRWGFBga4v5153m8Oe1IDlKWewGIZ5CPrNELpEJnzOVB4OTS', 'admin', '2025-02-23 04:03:09', NULL, 0, NULL),
(3, 'Rone', 'admin', 'Kulong', 'ron', 'admin@gmail.com', '$2y$10$agnEQCmt8ADyI/4a2dtvlOlGkDbbxvo/50I9Av11RQjuwluVKCrOe', 'admin', '2025-02-23 04:04:44', NULL, 0, NULL),
(7, 'sheesh', 'admin', 'bnb', 'rronn', 'ron@wmsu.edu.ph', '$2y$10$o4peCliKj4cIXPooJOYOfu8e.MIuwvkWiuTcdMANEH4QIef1QxFO6', 'admin', '2025-02-24 07:24:44', NULL, 0, NULL),
(9, 'sfvf', 'admin', 'dfvf', 'manager12', 'dvd@wmsu.edu.ph', '$2y$10$c4Igsr/pEcBpW742vdBvheznDxPHt0NlHkM3K1L8gzqKBBwtaAnIq', 'admin', '2025-02-24 07:32:26', NULL, 0, NULL),
(16, 'asdapakingshe', 'asdasfasss', 'adfaef', 'asdfefe', 'HZ2234300259@wmsu.edu.ph', '$2y$10$9r626N9kIa2AynwspQ2qJuFF.jGWTI9eYzBuH8w4inKomC0Uizw/O', 'sub-admin', '2025-02-24 08:37:21', 1, 0, NULL),
(17, 'sub', 'sub', 'sub', 'sub', 'sub@wmsu.edu.ph', '$2y$10$5CO4kvwyMDftD4aDxRR3Wu1VNPcQGPIftETFGlOYJDQOcRy8x0uYi', 'sub-admin', '2025-02-24 08:51:33', 2, 0, NULL),
(22, 'dcasfafa', 'asdfasfSSS', 'asfaf', 'afsf', 'HZsdsd300259@wmsu.edu.ph', '$2y$10$bRmm3Z9PBKrlazrhTN024epeRX.qGVgUbFZP4VnadXiyRRlLyggMW', 'sub-admin', '2025-03-18 12:30:28', 17, 0, NULL);

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
  `reason` varchar(255) DEFAULT NULL
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
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `executive_officers`
--
ALTER TABLE `executive_officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friday_prayers`
--
ALTER TABLE `friday_prayers`
  MODIFY `prayer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officer_positions`
--
ALTER TABLE `officer_positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
