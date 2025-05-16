-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 06:20 PM
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

--
-- Dumping data for table `about_msa`
--

INSERT INTO `about_msa` (`id`, `mission`, `vision`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'To seek the pleasure of Allah (SWT) by empowering Muslim students with resources aimed at fostering character and leadership development (tarbiyyah), campus activism and da’wah, and connecting for a unified vision. niga', 'A unifying movement, rooted in deen, of all Muslim Student Associations, cultivating safe and transformative spaces for all Muslims on campus and continuing to serve the Ummah beyond graduation. niga', '2025-05-01 09:51:01', 0, NULL, NULL),
(2, 'try', 'try', '2025-05-01 15:15:51', 1, 'try', '2025-05-01 20:32:31'),
(3, 'asd', 'asd', '2025-05-05 07:34:47', 1, 'asdasdasd', '2025-05-05 07:40:25'),
(4, 'asd', 'asdada', '2025-05-05 07:41:03', 1, 'asds', '2025-05-06 12:06:33'),
(5, 'asd', 'asdasda', '2025-05-05 07:41:47', 1, 'asd', '2025-05-06 12:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_activities`
--

CREATE TABLE `calendar_activities` (
  `activity_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `activity_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_activities`
--

INSERT INTO `calendar_activities` (`activity_id`, `title`, `description`, `venue`, `activity_date`, `end_date`, `time`, `created_by`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'Quran Recitation Workshop', 'Learn proper Quran recitation techniques. Open to all levels. Bring your mushaf.', NULL, '2025-05-02', '2025-05-02', NULL, 3, '2025-05-01 08:47:30', 0, NULL, NULL),
(2, 'Islamic Finance Seminarss', 'Practical workshop on Islamic banking principles and halal career paths.', NULL, '2025-05-14', '2025-05-14', NULL, 3, '2025-05-01 08:48:02', 1, 'c xcxcx', '2025-05-02 04:58:06'),
(3, 'Cultural Fair', 'Celebrate Eid with traditional foods, henna art, and cultural performances from Muslim student groups.', 'TBA', '2025-05-01', '2025-05-01', '11:17:00', 3, '2025-05-01 08:50:22', 0, NULL, NULL),
(4, 'Ramadan Iftar Program', 'Community iftars with short tafsir sessions after Maghrib prayers.', NULL, '2025-03-15', '2025-03-15', NULL, 3, '2025-05-01 08:53:06', 1, 'try', '2025-05-01 15:12:06'),
(5, 'Muslim Activity for Madrasa', 'Madrasa activity workshop.', 'asdas', '2025-04-02', NULL, '00:08:00', 3, '2025-05-01 09:26:23', 0, NULL, NULL),
(6, 'fv', 'v cv c', NULL, '2025-05-03', '2025-05-03', NULL, 3, '2025-05-02 04:56:34', 0, NULL, NULL),
(7, 'asd', 'asdasd', 'TBA', '2025-05-01', '2025-05-01', '23:17:00', 6, '2025-05-05 07:19:15', 0, NULL, NULL),
(8, 'asdasda', 'dasd', 'TBA', '2025-06-04', '2025-06-10', '11:14:00', 6, '2025-05-05 14:46:42', 0, NULL, NULL),
(9, 'asdasd', 'asdasd', NULL, '2025-05-07', '2025-05-10', NULL, 6, '2025-05-06 02:54:05', 0, NULL, NULL),
(10, 'asd', 'asdas', NULL, '2025-05-06', '0000-00-00', NULL, 6, '2025-05-06 02:55:48', 1, 'asdasdada', '2025-05-06 03:04:51'),
(11, 'asdasd', 'asdasdasdasdasd', NULL, '2025-05-06', '0000-00-00', NULL, 6, '2025-05-06 02:56:08', 1, 'wsdasdasdasda', '2025-05-06 03:04:35'),
(12, 'asdasda', 'nigga', NULL, '2025-05-06', '2025-05-09', NULL, 6, '2025-05-06 03:05:27', 0, NULL, NULL),
(13, 'asdasd', 'adasdas', NULL, '2025-05-06', '2025-05-09', NULL, 6, '2025-05-06 03:06:00', 0, NULL, NULL),
(14, 'nigga', 'nigga', NULL, '2025-05-21', NULL, NULL, 6, '2025-05-06 03:06:50', 0, NULL, NULL),
(15, 'asd', 'asdada', NULL, '2025-05-08', NULL, NULL, 6, '2025-05-06 04:02:23', 0, NULL, NULL),
(16, 'ng', 'ngdd', NULL, '2025-05-07', '2025-05-08', NULL, 6, '2025-05-06 04:02:38', 0, NULL, NULL),
(17, 'asdasdasdasda', 'nigga', NULL, '2025-05-07', NULL, NULL, 6, '2025-05-06 06:12:51', 1, 'v', '2025-05-16 15:58:47'),
(18, 'a', 'a', 'TBA', '2025-05-07', NULL, '23:05:00', 6, '2025-05-11 15:03:56', 1, 'a', '2025-05-16 15:58:52');

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
(19, 'SAMPLEs', 1, 'SAMPLE', '2025-05-05 06:59:36'),
(20, 'College of Asian Islamic Studies', 0, NULL, NULL);

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
(1, 3, 'Total Students Paid (SY. 2023-2024)', '1746093280_Introduction to Machine Learning.pdf', 'application/pdf', 270063, '2025-05-01 17:54:40', '2025-05-14 13:02:52', 0, NULL, NULL),
(2, 3, 'Rules and Bylaws', '1746093300_Study Mats.pdf.docx', 'application/vnd.openxmlformats-officedocument.word', 22363, '2025-05-01 17:55:00', '2025-05-01 23:12:43', 1, 'try', '2025-05-01 15:12:43'),
(3, 3, 'Bylaws', '1746131595_Study Mats.pdf.docx', 'application/vnd.openxmlformats-officedocument.word', 22363, '2025-05-02 04:33:15', '2025-05-02 04:33:15', 0, NULL, NULL),
(4, 3, 'Sir Rhame', '1746162335_NumPy-Cheat-Sheet.pdf', 'application/pdf', 137888, '2025-05-02 13:05:35', '2025-05-13 10:49:18', 0, NULL, NULL),
(5, 6, 'asd', '1746430434_1746162335_NumPy-Cheat-Sheet.pdf', 'application/pdf', 137888, '2025-05-05 15:33:54', '2025-05-05 15:33:54', 0, NULL, NULL),
(6, 6, 'asda', '1746440802___🐍 Django Project Setup Guide__.pdf', 'application/pdf', 312893, '2025-05-05 18:26:42', '2025-05-05 18:26:42', 0, NULL, NULL),
(7, 4, 'ss', '1747034043_Project Overview.pdf', 'application/pdf', 306978, '2025-05-12 15:14:03', '2025-05-12 15:14:03', 0, NULL, NULL);

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
  `office` enum('wac','male','ils') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `executive_officers`
--

INSERT INTO `executive_officers` (`officer_id`, `last_name`, `first_name`, `middle_name`, `position_id`, `program_id`, `image`, `school_year_id`, `office`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'MOHAMMAD', 'AL GHANI', '', 23, NULL, NULL, 1, '', '2025-05-16 10:26:05', 0, NULL, NULL),
(2, 'Ahang', 'Nadzmia', '', 1, 15, NULL, 1, 'wac', '2025-05-16 10:45:00', 0, NULL, NULL),
(3, 'Najar', 'Ahmad Jainal', '', 1, 11, NULL, 1, 'male', '2025-05-16 10:45:59', 0, NULL, NULL),
(4, 'Arjan', 'Ahmed Yousref', '', 2, 10, NULL, 1, 'male', '2025-05-16 13:22:11', 0, NULL, NULL);

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
(1, 'What is the purpose of this oqrganization?', 'Our organization aims to support underprivileged students through educational programs, scholarships, and community initiatives.', 'General Questions', '2023-01-15 00:00:00', 0, NULL, NULL),
(2, 'How can I become a member?', 'You can become a member by filling out the membership form on our website and paying the annual membership fee.', 'General Questions', '2023-02-20 01:30:00', 0, NULL, NULL),
(3, 'What are your operating hours?', 'Our office is open Monday to Friday from 9:00 AM to 5:00 PM. We are closed on weekends and public holidays.', 'General Questions', '2023-03-10 02:15:00', 0, NULL, NULL),
(4, 'Do you offer volunteer opportunities?', 'Yes, we have various volunteer programs. Please visit our Volunteers page for current opportunities.', 'General Questions', '2023-04-05 03:45:00', 1, 'Outdated information', '2023-06-01 06:20:00'),
(5, 'How can I update my contact information?', 'You can update your details by logging into your account on our website or by contacting our support team.', 'General Questions', '2023-05-12 05:10:00', 0, NULL, NULL),
(6, 'What types of events do you organize?', 'We organize educational workshops, fundraising galas, community service projects, and awareness campaigns.', 'Events and Activities', '2023-01-25 00:30:00', 0, NULL, NULL),
(7, 'How can I register for an upcoming event?', 'Event registration is available on our website under the Events section. Some events may require pre-registration.', 'Events and Activities', '2023-02-15 02:45:00', 0, NULL, NULL),
(8, 'Are your events free to attend?', 'Some events are free while others may have a registration fee. Check the event details for specific information.', 'Events and Activities', '2023-03-22 03:20:00', 0, NULL, NULL),
(9, 'Can I suggest an event idea?', 'Absolutely! We welcome suggestions. Please use the Contact Us form and select \"Event Suggestion\" as the subject.', 'Events and Activities', '2023-04-18 06:00:00', 1, 'Duplicate question', '2023-05-30 08:45:00'),
(10, 'Do you offer virtual events?', 'Yes, we host both in-person and virtual events. The format is indicated in each event description.', 'Events and Activities', '2023-05-08 07:30:00', 0, NULL, NULL),
(11, 'How can I make a donation?', 'Donations can be made online through our secure payment portal, by bank transfer, or in person at our office.', 'Donation and Support', '2023-01-10 01:00:00', 0, NULL, NULL),
(12, 'Is my donation tax-deductible?', 'Yes, we are a registered non-profit organization and all donations are tax-deductible. You will receive a receipt.', 'Donation and Support', '2023-02-05 02:15:00', 0, NULL, NULL),
(13, 'Can I specify how my donation should be used?', 'Yes, during the donation process you can select specific programs or indicate \"Where most needed\".', 'Donation and Support', '2023-03-15 03:45:00', 0, NULL, NULL),
(14, 'Do you accept in-kind donations?', 'We accept certain in-kind donations. Please contact our office to discuss what items we currently need.', 'Donation and Support', '2023-04-20 05:30:00', 1, 'Policy changed', '2023-06-10 01:15:00'),
(15, 'What percentage of donations goes to programs?', '85% of all donations directly support our programs, with 15% allocated to administrative and fundraising costs.', 'Donation and Support', '2023-05-25 06:45:00', 0, NULL, NULL),
(16, 'How can I contact your support team?', 'You can reach us by phone at (555) 123-4567, by email at support@organization.org, or through our contact form.', 'Contact and Support', '2023-01-05 00:15:00', 0, NULL, NULL),
(17, 'What is your response time for inquiries?', 'We aim to respond to all inquiries within 2 business days. Urgent matters may be addressed sooner.', 'Contact and Support', '2023-02-12 01:30:00', 0, NULL, NULL),
(18, 'Do you have regional offices?', 'Our main office is in New York, but we have representatives in 5 other states. See our Contact page for details.', 'Contact and Support', '2023-03-18 02:45:00', 0, NULL, NULL),
(19, 'Can I schedule a meeting with a staff member?', 'Yes, please contact our office to schedule an appointment with the appropriate staff member.', 'Contact and Support', '2023-04-22 04:00:00', 0, NULL, NULL),
(20, 'Where can I find your annual reports?', 'Our annual reports are available in the About Us section of our website under \"Financials\".', 'Contact and Support', '2023-05-30 05:15:00', 0, NULL, NULL);

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
(1, 'Mohammad', 'Ali', 'Abdullah', 'mabdullah@wmsu.edu.ph', '09171234567', 'On-site', 'Zamboanga Peninsula', 'Zamboanga del Norte', 'Dipolog City', 'Barra', '123 Mosque Street', '7100', 1, NULL, 1, NULL, '2nd year', NULL, '1746094081_Screenshot 2024-12-27 122010.png', 'Pending', '2023-01-10 08:30:00', '2025-05-12 15:00:51', 0, NULL, NULL),
(2, 'Aisha', 'Fatima', 'Hassan', 'ahassan@wmsu.edu.ph', '09221234567', 'On-site', 'Zamboanga Peninsula', 'Isabela City', 'Isabela City', 'Balatanay', 'Perez St.', '7000', 2, NULL, 4, NULL, '2nd year', NULL, '1746101095_Screenshot 2025-04-10 214344.png', 'Pending', '2023-01-15 09:45:00', '2025-05-12 15:01:02', 0, NULL, NULL),
(3, 'Ibrahim', NULL, 'Santos', 'isantos@wmsu.edu.ph', '09331234567', 'On-site', 'Zamboanga Peninsula', 'Zamboanga del Sur', 'Pagadian City', 'Balangasan', '789 Quran Road', '7016', 3, NULL, 2, NULL, '3rd Year', 'Western Mindanao State University - Pagadian', NULL, 'Rejected', '2023-02-05 10:20:00', '2025-05-12 14:58:50', 0, NULL, NULL),
(4, 'Fatima', 'Rahma', 'Dimalutang', 'fatima.d@email.com', '09441234567', 'Online', 'Zamboanga Peninsula', 'Zamboanga Sibugay', 'Ipil', 'Bacalan', '321 Sunnah Blvd', '7001', NULL, 'Islamic Online University', NULL, 'Islamic Studies', '4th Year', NULL, NULL, 'Enrolled', '2023-02-10 14:15:00', '2025-05-12 14:49:30', 0, NULL, NULL),
(5, 'Yusuf', 'Bin', 'Omar', 'yusuf.omar@email.com', '09551234567', 'Online', 'Zamboanga Peninsula', 'Zamboanga del Norte', 'Dapitan City', 'Baylimango', '555 Hadith Street', '7101', NULL, 'Madrasa Online', NULL, 'Quran Memorization', '2nd Year', NULL, NULL, 'Enrolled', '2023-02-15 11:30:00', '2025-05-12 14:33:14', 0, NULL, NULL),
(6, 'Mariam', 'Sofia', 'Ibrahim', 'mibrahim@wmsu.edu.ph', '09661234567', 'On-site', 'Zamboanga Peninsula', 'Isabela City', 'Isabela City', 'Aguada', '777 Tawhid Road', '7300', 1, NULL, 1, NULL, '1st Year', 'Western Mindanao State University - Isabela', NULL, 'Rejected', '2023-03-01 13:45:00', '2023-03-03 15:20:00', 0, 'Incomplete requirements', NULL),
(7, 'Abdul', 'Rahman', 'Garcia', 'abdul.g@email.com', '09771234567', 'Online', 'Zamboanga Peninsula', 'Zamboanga del Sur', 'Pagadian City', 'Balintawak', '888 Fi Sabilillah Ave', '7016', NULL, 'Online Islamic Academy', NULL, 'Arabic Language', '3rd Year', NULL, NULL, 'Enrolled', '2023-03-05 16:00:00', '2025-05-02 10:50:08', 1, 'Duplicate submission', '2023-03-07 01:30:00'),
(8, 'Amina', '', 'Fernandez', 'afernandez@wmsu.edu.ph', '09881234567', 'On-site', 'Zamboanga Peninsula', 'Zamboanga del Norte', 'Dapitan City', 'Baylimango', 'Blk 3', '7200', 2, NULL, 4, NULL, '3rd year', NULL, '1746101038_Screenshot (6).png', 'Enrolled', '2023-03-10 10:45:00', '2025-05-01 20:03:58', 0, NULL, NULL),
(9, 'Omar', 'Farouk', 'Lim', 'omar.lim@email.com', '09991234567', 'Online', 'Zamboanga Peninsula', 'Zamboanga Sibugay', 'Ipil', 'Sanito', '111 Iman Road', '7001', NULL, 'Virtual Islamic School', NULL, 'Fiqh Studies', '1st Year', NULL, NULL, 'Enrolled', '2023-03-15 14:00:00', '2025-05-02 04:33:42', 0, NULL, NULL),
(10, 'Khadija', 'Amina', 'Tan', 'ktan@wmsu.edu.ph', '09101234567', 'On-site', 'Zamboanga Peninsula', 'Zamboanga del Norte', 'Dipolog City', 'Estaka', '222 Sunnah Avenue', '7100', 3, NULL, 2, NULL, '2nd Year', 'Western Mindanao State University - Dipolog', NULL, 'Rejected', '2023-03-20 15:30:00', '2023-03-22 17:15:00', 0, 'Ineligible for program', NULL),
(11, 'Shane', 'Duran', 'Jimenez', 'shanehart1001@wmsu.edu.ph', '09066998688', 'On-site', 'Zamboanga Peninsula', 'Zamboanga City', 'Zamboanga City', 'Putik', 'Sapphire', '7000', 3, NULL, 7, NULL, '2nd year', NULL, '1746094541_Screenshot (6).png', 'Enrolled', '2025-05-01 18:15:41', '2025-05-01 20:36:25', 1, 'a', '2025-05-01 12:36:25'),
(12, 'Shane', '', 'Jimenez', 'shane@wmsu.edu.ph', '09876545323', 'On-site', 'Zamboanga Peninsula', 'Zamboanga del Norte', 'Dipolog City', 'Biasong', 'Sapphire', '7900', 3, NULL, 7, NULL, '3rd year', NULL, '1746123154_Screenshot 2025-02-21 203438.png', 'Enrolled', '2025-05-02 02:12:34', '2025-05-02 02:12:34', 0, NULL, NULL),
(13, 'sdfsdfsdf', 'sdfsdfsd', 'fsdfsdfsdfs', 'HZ202300259@wmsu.edu.ph', '09171234567', 'On-site', 'Zamboanga Peninsula', 'Zamboanga City', 'Zamboanga City', 'Arena Blanco', '123 Mosque Street', '7100', 3, NULL, 7, NULL, '2nd year', NULL, '1746420168_output.png', 'Enrolled', '2025-05-05 12:42:48', '2025-05-05 12:42:48', 0, NULL, NULL),
(14, 'ASD', '', 'ADASD', 'sdfsfd@wmsu.edu.ph', '09066998483', 'On-site', 'Zamboanga Peninsula', 'Zamboanga City', 'Zamboanga City', 'San Jose Gusu', '123 Mosque Street', '7100', 16, NULL, 43, NULL, '2nd year', NULL, '1746431113_login.jpg', 'Enrolled', '2025-05-05 15:45:13', '2025-05-05 15:45:13', 0, NULL, NULL);

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

--
-- Dumping data for table `org_updates`
--

INSERT INTO `org_updates` (`update_id`, `title`, `content`, `created_by`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'Eid Fiest Celebration', 'The Muslim Student Association (MSA Connect) is pleased to announce its annual Eid al-Fitr Celebration, marking the conclusion of Ramadan 1446H. This community event aims to foster unity, gratitude, and Islamic brotherhood among students, faculty, and staff.\r\n\r\nTheme: &quot;Blessings of Unity: Sharing Joy, Strengthening Faith&quot;\r\n\r\nDate:March 2025\r\n\r\nTime: 7:00 AM - 3:00 PM\r\n\r\nVenue: WMSU, Campus A', 3, '2025-05-01 08:42:00', 1, 'try', '2025-05-01 15:10:50'),
(2, 'Muslim Activity', 'Engage with your faith and community! Our Muslim Activities section highlights a diverse range of events, programs, and initiatives designed to foster spiritual growth, build connections, and serve our community. Explore opportunities to learn, connect, and contribute.', 3, '2025-05-01 15:10:36', 0, NULL, NULL),
(3, 'Ramadhan Fiest', 'As the holy month of Ramadan graces us once again, let us come together in the spirit of unity, reflection, and joy! Our Ramadan Fiestas are a vibrant celebration of our shared faith and community. Join us for heartwarming Iftars filled with delicious food and fellowship, engaging Taraweeh prayers that uplift the soul, and enriching programs designed to deepen our connection with Allah (SWT).<br />\r\n<br />\r\nThis Ramadan, let us strengthen our bonds, share our blessings, and experience the beauty of our community coming together. Check our schedule for dates, times, and locations of our various Ramadan Fiesta events – everyone is welcome!x', 6, '2025-05-05 05:02:39', 0, NULL, NULL),
(4, 'SAMPLE', 'SAMPLE', 6, '2025-05-05 07:00:13', 1, 'SAMPLE', '2025-05-05 07:00:17'),
(5, 'f', 'sd', 6, '2025-05-05 07:35:08', 1, 'as', '2025-05-05 07:37:53'),
(6, 'Sample News', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 6, '2025-05-05 12:05:26', 0, NULL, NULL),
(7, 'Sample News', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 6, '2025-05-06 16:19:36', 0, NULL, NULL),
(8, 'ljhblh', 'iuhpu', 6, '2025-05-14 15:07:44', 1, 'X', '2025-05-16 06:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `prayer_schedule`
--

CREATE TABLE `prayer_schedule` (
  `prayer_id` int(11) NOT NULL,
  `prayer_type` enum('khutba','fajr','asr','maghrib','isha','jumu''ah','dhuhr') NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `iqamah` time NOT NULL,
  `speaker` varchar(255) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prayer_schedule`
--

INSERT INTO `prayer_schedule` (`prayer_id`, `prayer_type`, `date`, `time`, `iqamah`, `speaker`, `topic`, `location`, `created_by`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'khutba', '2025-03-28', '00:00:00', '00:00:00', 'Ahmad Eldani', 'Virtue of Reading Quran', 'MSA Center', 3, '2025-05-01 08:57:38', 1, 'try', '2025-05-01 15:15:31'),
(2, 'khutba', '2025-05-23', '04:00:00', '04:15:00', 'Khalid Mohammad Ali', 'Special Prayers', 'COE, 2nd Floor', 3, '2025-05-01 08:59:03', 0, NULL, NULL),
(3, 'khutba', '2025-05-30', '00:03:00', '00:03:15', 'Rhamirl Jaafar', 'Balancing Deen and Studies: Islamic Time Management', 'CCS, Lab 2', 3, '2025-05-01 09:21:25', 0, NULL, NULL),
(4, 'asr', '2025-05-16', '11:06:00', '00:01:00', 'TBA', 'Special Prayerss', 'ASDASDASDASDASD', 6, '2025-05-05 15:08:24', 0, NULL, NULL),
(5, 'khutba', '2025-05-09', '00:00:00', '00:00:00', 'asdasdasssssssssssss', 'Special Prayers', 'asdasdda', 6, '2025-05-05 15:29:35', 1, 'a', '2025-05-05 15:29:54'),
(6, 'khutba', '2025-05-16', '14:00:00', '00:00:00', 'Rone Paullan Kulong', 'Importance of Prayings', 'CCS, Lab 1', 6, '2025-05-05 15:32:15', 0, NULL, NULL),
(7, 'fajr', '2025-05-16', '22:24:00', '22:30:00', 'TBA', 'Special Prayersaa', 'MSA Center', 6, '2025-05-13 14:23:53', 0, NULL, NULL),
(8, 'dhuhr', '2025-05-16', '00:00:00', '00:00:00', 'TBA', 'sssddd', 'asdadd', 6, '2025-05-13 14:48:11', 1, 'q', '2025-05-16 07:56:38'),
(9, 'khutba', '2025-05-23', '18:52:00', '00:00:00', 'asda', 'wdq', 'asdasda', 6, '2025-05-14 10:50:12', 0, NULL, NULL),
(10, 'dhuhr', '2025-05-16', '15:00:00', '15:01:00', NULL, NULL, 'qds', 6, '2025-05-16 07:58:30', 0, NULL, NULL),
(11, 'khutba', '2025-05-09', '16:06:00', '00:00:00', 's', 'S', 'A', 6, '2025-05-16 08:04:30', 0, NULL, NULL);

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
(1, 'BS Agriculture', 1, 0, NULL, NULL),
(2, 'BS Agricultural Economics', 1, 0, NULL, NULL),
(3, 'BS Agribusiness', 1, 0, NULL, NULL),
(4, 'BS Architecture', 2, 0, NULL, NULL),
(5, 'BS Interior Design', 2, 1, 'No program like this in WMSU.', '2025-05-01 15:02:36'),
(6, 'BS Information Technology', 3, 0, NULL, NULL),
(7, 'BS Computer Science', 3, 0, NULL, NULL),
(8, 'Associate in Computer Technology', 3, 0, NULL, NULL),
(9, 'BS Information Systems', 3, 0, NULL, NULL),
(10, 'BS Criminology', 4, 0, NULL, NULL),
(11, 'BS Elementary Education', 5, 0, NULL, NULL),
(12, 'BS Secondary Education', 5, 0, NULL, NULL),
(13, 'BS Early Childhood Education', 5, 0, NULL, NULL),
(14, 'BS Special Education', 5, 0, NULL, NULL),
(15, 'BS Civil Engineering', 6, 0, NULL, NULL),
(16, 'BS Electrical Engineering', 6, 0, NULL, NULL),
(17, 'BS Mechanical Engineering', 6, 0, NULL, NULL),
(18, 'BS Electronics Engineering', 6, 0, NULL, NULL),
(19, 'BS Industrial Engineering', 6, 0, NULL, NULL),
(20, 'BS Forestry', 7, 0, NULL, NULL),
(21, 'BS Environmental Science', 7, 0, NULL, NULL),
(22, 'BS Home Economics', 8, 0, NULL, NULL),
(23, 'BS Nutrition and Dietetics', 8, 0, NULL, NULL),
(24, 'BS Hospitality Management', 8, 0, NULL, NULL),
(25, 'Juris Doctor', 9, 0, NULL, NULL),
(26, 'AB English', 10, 0, NULL, NULL),
(27, 'AB History', 10, 0, NULL, NULL),
(28, 'AB Political Science', 10, 0, NULL, NULL),
(29, 'AB Sociology', 10, 0, NULL, NULL),
(30, 'AB Philosophy', 10, 0, NULL, NULL),
(31, 'Doctor of Medicine', 11, 0, NULL, NULL),
(32, 'BS Nursing', 12, 0, NULL, NULL),
(33, 'BS Biology', 13, 0, NULL, NULL),
(34, 'BS Chemistry', 13, 0, NULL, NULL),
(35, 'BS Mathematics', 13, 0, NULL, NULL),
(36, 'BS Physics', 13, 0, NULL, NULL),
(37, 'BS Statistics', 13, 0, NULL, NULL),
(38, 'BS Social Work', 14, 0, NULL, NULL),
(39, 'BS Community Development', 14, 0, NULL, NULL),
(40, 'BS Sports Science', 15, 0, NULL, NULL),
(41, 'BS Physical Education', 15, 0, NULL, NULL),
(42, 'BS Industrial Technology', 16, 0, NULL, NULL),
(43, 'BS Automotive Technology', 16, 0, NULL, NULL),
(44, 'BS Electrical Technology', 16, 0, NULL, NULL),
(48, 'BA Islamic Studies', 20, 0, NULL, NULL);

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
  `page_type` enum('registration','about','volunteer','calendar','faqs','transparency','home','logo','carousel','footer','background') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `contact_no` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fb_link` varchar(255) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `org_name` varchar(255) DEFAULT NULL,
  `web_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_pages`
--

INSERT INTO `site_pages` (`page_id`, `page_type`, `title`, `description`, `image_path`, `contact_no`, `email`, `fb_link`, `school_name`, `org_name`, `web_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Assalamu Alaykum!', 'We strive to foster a vibrant and inclusive community rooted in Islamic values. Whether you are a practicing Muslim, exploring Islam, or simply curious about our faith and culture, you will find a welcoming space to connect, learn, and grow with fellow students. Join us as we build bridges, serve our community, and strengthen our understanding of Islam together.', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-16 09:19:01'),
(2, 'about', 'About MSA', 'Established in January 1963, the Muslim Students Association of the U.S. Canada — also known as MSA National — continues to serve Muslim students during their college and university careers by facilitating their efforts to establish, maintain, and develop local MSA chapters.', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-16 09:26:00'),
(3, 'volunteer', 'Be With Us!', 'Register with the Muslim Students Association to connect with fellow students, grow in faith, and serve the community. Enjoy access to prayers, events, halaqas, and lifelong friendships. Sign up now—your journey of knowledge, brotherhood/sisterhood, and dawah starts here!', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-16 09:25:29'),
(4, 'calendar', 'Calendards', 'Stay up-to-date with MSA events and activities by checking our calendar regularly. From community service projects to social gatherings, something for everyone to enjoy and participate in.', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-16 08:29:15'),
(5, 'faqs', 'FAQs', 'Find answers to common questions about our organization, activities, and how you can get involved.', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-14 06:58:31'),
(6, 'transparency', 'Transparency Report', 'We are committed to maintaining transparency in all our transactions. Belsow is a detailed breakdown of our financial activities.', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-01 19:53:07', '2025-05-14 07:01:00'),
(7, 'registration', 'Registrations', 'Registration for madrasa classes is now open for the upcoming term. Parents and guardians are encouraged to enroll their children early to secure a spot, as spaces are limited. The registration process is simple and can be completed online or in person at the madrasa office. Classes will cover Quranic studies, Islamic teachings, and basic Arabic, tailored to different age groups. Don’t miss the opportunity to give your child a strong foundation in faith and knowledge.', NULL, '', '', '', NULL, NULL, NULL, 0, '2025-05-01 19:53:07', '2025-05-12 02:18:25'),
(9, 'logo', 'tit', '', 'assets/site/682039a8d0d45.jpg', '', '', '', NULL, NULL, NULL, 0, '2025-05-11 05:46:16', '2025-05-11 07:06:11'),
(10, 'footer', 'adasqdqSSsssss', '', NULL, '09926314072', 'wmsu@wmsu.edu.ph', 'https://www.facebook.com/msawmsuofficial/', 'Western Mindanao State Universityk', 'Muslim Students Association', 'MSA Connect', 1, '2025-05-11 05:47:15', '2025-05-16 08:26:19'),
(13, 'carousel', 'Sample photo 1', '', 'assets/site/carousel_6821875fb655a6.48257244.png', '', '', '', NULL, NULL, NULL, 0, '2025-05-11 06:24:49', '2025-05-12 05:52:35'),
(21, 'logo', 'adasds', '', 'assets/site/68215f4c9f680.jpg', '', '', '', NULL, NULL, NULL, 0, '2025-05-11 06:33:54', '2025-05-12 12:38:10'),
(22, 'carousel', 'sdad', '', 'assets/site/carousel_682189a2c5bc36.10040176.jpg', '', '', '', NULL, NULL, NULL, 0, '2025-05-11 06:34:24', '2025-05-12 05:52:42'),
(23, 'carousel', '4th', '', 'assets/site/carousel_6826dd5d0346b9.75852035.jpg', '', '', '', NULL, NULL, NULL, 1, '2025-05-11 06:34:38', '2025-05-16 06:38:21'),
(24, 'carousel', '3rd', '', 'assets/site/carousel_6826dd5cf37358.17814414.jpg', '', '', '', NULL, NULL, NULL, 1, '2025-05-11 06:34:47', '2025-05-16 06:38:20'),
(25, 'carousel', 'Front', '', 'assets/site/carousel_6826dd5ce446b4.94762859.jpg', '', '', '', NULL, NULL, NULL, 1, '2025-05-11 06:34:58', '2025-05-16 06:38:20'),
(28, 'registration', 'q', 'qdjj', NULL, '', '', '', NULL, NULL, NULL, 0, '2025-05-12 02:18:25', '2025-05-12 12:54:14'),
(29, 'carousel', '2nd', '', 'assets/site/carousel_6826dd5cec1092.35204039.jpg', '', '', '', NULL, NULL, NULL, 1, '2025-05-12 05:44:32', '2025-05-16 06:38:20'),
(30, 'logo', 'ww', '', 'assets/site/6821ebb26713d.png', '', '', '', NULL, NULL, NULL, 0, '2025-05-12 12:38:10', '2025-05-12 12:54:34'),
(31, 'background', 'qqqq', '', 'assets/site/682701d0cae73.jpg', '', '', '', NULL, NULL, NULL, 1, '2025-05-12 12:41:36', '2025-05-16 09:13:52'),
(33, 'registration', 'Registration Page', 'i am the worst i am the worst i am the worst i am the worst i am the worst i am the worst i am the worstS', NULL, '', '', '', NULL, NULL, NULL, 1, '2025-05-12 12:54:14', '2025-05-16 09:19:50'),
(34, 'logo', 'qqqee', '', 'assets/site/msa_logo.png', '', '', '', NULL, NULL, NULL, 1, '2025-05-12 12:54:34', '2025-05-13 17:45:13');

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

--
-- Dumping data for table `transparency_report`
--

INSERT INTO `transparency_report` (`report_id`, `report_date`, `end_date`, `expense_detail`, `expense_category`, `amount`, `transaction_type`, `semester`, `school_year_id`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, '2024-06-15', '2024-06-17', 'Membership fees collection', 'Membership', 5000.00, 'Cash In', '1st', 2, 0, NULL, NULL),
(2, '2024-06-20', NULL, 'Eid al-Fitr celebration expenses', 'Events', 3200.50, 'Cash Out', '1st', 2, 0, NULL, NULL),
(3, '2024-07-05', NULL, 'Donation from alumni', 'Donationss', 2000.00, 'Cash In', '1st', 2, 0, NULL, NULL),
(4, '2024-07-15', NULL, 'Purchase of Quran copies', 'Islamic Materials', 1500.75, 'Cash Out', '1st', 2, 0, NULL, NULL),
(5, '2024-08-01', NULL, 'Campus iftar program', 'Charity', 2800.00, 'Cash Out', '1st', 2, 1, 'd', '2025-05-06 06:21:26'),
(6, '2024-11-10', NULL, 'Islamic lecture series honorarium', 'Events', 1200.00, 'Cash Out', '2nd', 2, 1, 'd', '2025-05-06 18:05:04'),
(7, '2024-11-25', NULL, 'Fundraising dinner proceed', 'Fundraising', 10500.00, 'Cash In', '2nd', 2, 0, NULL, NULL),
(8, '2024-12-05', NULL, 'Winter charity drive for orphans', 'Charity', 4000.00, 'Cash Out', '2nd', 2, 1, 'mmjg', '2025-05-02 04:46:03'),
(9, '2023-06-10', NULL, 'Initial semester budget from university', 'University Funds', 10000.00, 'Cash In', '1st', 1, 1, 'as', '2025-05-06 06:07:57'),
(10, '2023-07-20', NULL, 'Ramadan preparation materials', 'Islamic Materials', 2200.00, 'Cash Out', '1st', 1, 1, 'try', '2025-05-01 15:11:13'),
(11, '2023-08-15', NULL, 'New student orientation eventSHH', 'Events', 1800.50, 'Cash Out', '1st', 1, 0, NULL, NULL),
(12, '2023-11-05', NULL, 'Islamic book fair proceed', 'Fundraising', 3200.00, 'Cash In', '2nd', 1, 0, NULL, NULL),
(13, '2023-11-20', NULL, 'Guest speaker transportation', 'Events', 800.00, 'Cash Out', '2nd', 1, 0, NULL, NULL),
(14, '2023-12-10', NULL, 'Year-end charity distribution', 'Charity', 3500.00, 'Cash Out', '2nd', 1, 0, NULL, NULL),
(22, '2025-05-06', '2025-05-10', 'ssss', 'Donationss', 2342.00, 'Cash In', '1st', 2, 0, NULL, NULL),
(23, '2025-05-15', '2025-05-22', 'wqe', 'qwenigg', 23456.00, 'Cash Out', '2nd', 2, 1, 'asd', '2025-05-06 06:21:12'),
(24, '2025-05-08', NULL, 'neega', 'Membership', 2000.00, 'Cash In', '1st', 2, 1, 's', '2025-05-06 17:36:04'),
(25, '2025-05-23', '2025-05-31', 'nigggggaa', 'Events', 200.00, 'Cash Out', '1st', 2, 1, 'd', '2025-05-06 17:55:16');

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

--
-- Dumping data for table `update_images`
--

INSERT INTO `update_images` (`image_id`, `update_id`, `file_path`, `upload_order`) VALUES
(1, 1, '681333d810dee_eid.jpg', 0),
(4, 2, '68138eec3ca0d_eid.jpg', 2),
(6, 4, '681861fdf162a_Screenshot (1).png', 0),
(7, 5, '68186a2c71c77_a6a0a64d-de4e-4f3f-bea0-fb500c5701a9.jpg', 0),
(10, 3, '6823869aac36a_494329516_550593951457782_5439799207768938403_n.jpg', 0),
(11, 6, '682386ecaf2bb_background.jpg', 0),
(12, 7, '6823870dc91a6_f627e81a-deab-42b9-9df3-e12e1eae5664.jpg', 0),
(13, 8, '6824b1c0ebd3c_Screenshot (2).png', 0),
(14, 2, '6826d56e523e8_487126878_1066796692135436_2620514646350456280_n.jpg', 0),
(15, 2, '6826d5878e787_489730274_709393674760663_250886768100815877_n.jpg', 0);

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
(4, 'sub', 'sub', 'subs', 'sub', 'sub@wmsu.edu.ph', '$2y$10$TkNyqLP29O8syY9h/0Yl1ukM5jQ9WNPVrbWjmAhNsY0q1J7n1A/kq', 'sub-admin', '2025-05-01 12:51:55', 3, 0, NULL, NULL),
(5, 'Shane', '', 'Jimenez', 'ashxeynx', 'ashxeynx@wmsu.edu.ph', '$2y$10$UIDkASXpuBfVsXVUJ2B58.yIATNoUkScXWpEL5DY0n2kAdZsuQn.e', 'sub-admin', '2025-05-01 15:13:29', 19, 1, 'try', '2025-05-01 15:13:34'),
(6, 'admin', 'adminn', 'adminn', 'admin', 'adminn@gmail.com', '$2y$10$YHqUoGsuBsKMcDYyYwt87O/zbyqKsjQhMYjF4JlsdqHNFidU0rKQC', 'admin', '2025-05-02 05:50:10', NULL, 0, NULL, NULL),
(7, 'sfs', 'dfsdfs', 'sdfs', 'sdfs', 'asdas@wmsu.edu.ph', '$2y$10$TcQRKug94GAOg1ZSnKd2x.AYcyKJgKfx68wpD/wgkn9A8ffMDGhu6', 'sub-admin', '2025-05-05 04:43:52', 21, 0, NULL, NULL),
(8, 'asdx', 'asda', 'asdasd', 'asdad', 'asdasda@gmail.com', '$2y$10$UHcuruockF5Xjhw2vJI8WOH4mz.L39nzVMVBtyWdCjYCibu0qhJAy', 'sub-admin', '2025-05-05 09:16:13', 12, 0, NULL, NULL);

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

INSERT INTO `volunteers` (`volunteer_id`, `first_name`, `middle_name`, `last_name`, `year`, `program_id`, `contact`, `email`, `cor_file`, `status`, `user_id`, `created_at`, `is_deleted`, `reason`, `deleted_at`) VALUES
(1, 'Marlo', '', 'Manonog', 2, 7, '09926314071', 'sdfsfd@wmsu.edu.ph', '1746107236_Screenshot 2024-09-10 100740.png', 'pending', 3, '2025-05-01 13:47:16', 1, 'try', '2025-05-01 15:25:43'),
(2, 'Brixell LlOyd', '', 'Mesa', 2, 27, '09926314073', 'shanehart1001@gmil.com', '1746107335_Screenshot 2025-01-26 143128.png', 'approved', 6, '2025-05-01 13:48:55', 0, NULL, NULL),
(3, 'Ronie polan', '', 'Kulonggies', 4, 27, '09926314073', 'shhesh@gmail.com', '1746112696_Screenshot 2024-12-26 172643.png', 'approved', 6, '2025-05-01 15:18:16', 0, NULL, NULL),
(4, 'Chrysjann Theo', 'Duran', 'Bongo', 1, 10, '09066998754', 'theo@wmsu.edu.ph', '1746144813_Screenshot 2024-12-28 163143.png', 'approved', 6, '2025-05-02 00:13:33', 0, NULL, NULL),
(5, 'Rone Paullan', 'Gellecania', 'Kulong', 3, 8, '09088776543', 'rone@wmsu.edu.ph', '1746144874_Screenshot 2025-03-06 195555.png', 'approved', 3, '2025-05-02 00:14:34', 0, NULL, NULL),
(6, 'Sitti Kashma', '', 'Akbar', 1, 32, '09876543234', 'kashma@wmsu.edu.ph', '1746144930_Screenshot 2024-12-28 163213.png', 'rejected', 6, '2025-04-16 00:15:30', 0, NULL, NULL),
(7, 'fsaf', 'asdad', 'asdad', 2, 27, '09926314074', 'sdfsfd@wmsu.edu.ph', '1747031357_a6a0a64d-de4e-4f3f-bea0-fb500c5701a9.jpg', 'approved', 6, '2025-05-12 06:29:17', 0, NULL, NULL),
(8, 'asdasda', 'adsadadad', 'adasdasdasd', 0, 29, '09926314071', 'sdfsfd@wmsu.edu.ph', '1747032114_login.jpg', 'approved', 6, '2025-05-12 06:41:54', 0, NULL, NULL),
(9, 'Shane', '', 'Jimenez', 2, 34, '09926314071', 'shanehart1001@gmail.com', '1747140401_f627e81a-deab-42b9-9df3-e12e1eae5664.jpg', 'pending', NULL, '2025-05-13 12:46:41', 0, NULL, NULL);

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
  ADD PRIMARY KEY (`page_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `downloadable_files`
--
ALTER TABLE `downloadable_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `executive_officers`
--
ALTER TABLE `executive_officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `madrasa_enrollment`
--
ALTER TABLE `madrasa_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `officer_positions`
--
ALTER TABLE `officer_positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `org_updates`
--
ALTER TABLE `org_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prayer_schedule`
--
ALTER TABLE `prayer_schedule`
  MODIFY `prayer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_pages`
--
ALTER TABLE `site_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transparency_report`
--
ALTER TABLE `transparency_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `update_images`
--
ALTER TABLE `update_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
