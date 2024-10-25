-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 26, 2024 at 01:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pio_iskolar`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announce_id` int(11) NOT NULL,
  `batch_no` int(3) DEFAULT NULL,
  `st_date` date NOT NULL,
  `end_date` date NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announce_id`, `batch_no`, `st_date`, `end_date`, `img_name`, `title`, `content`, `status`) VALUES
(3, 0, '2024-10-25', '2024-11-02', 'pic2.jpg', 'Contract Signing', 'City Mayor REX Gatchalian graces the orientation and contract signing of 212 recipients of the Dr. Pio Valenzuela Scholarship program at the Pamantasan ng Lungsod ng Valenzuela (#PLV) Qualified Grantees are required to report at the Scholarship Office at PLV Maysan Campus, 2nd floor on December 10 to 16, 2023 (except Saturday and Sunday) 8:00 AM to 5:00 PM. Look for Ms. Miko Tongco regarding Contract Signing and Orientation. Thank you! \r\n', 'ACTIVE'),
(6, 0, '2024-10-25', '2024-11-24', 'pic3.jpg', 'Results for Batch 27', ' The results of the Dr. Pio Valenzuela Scholarship Program will be released on Dr. Pio\'s 154th Birth Anniversary on December 11, 2023. \r\n\r\nRightfully deserving of the grant, they are currently getting to know more about their future college journeys as Dr. Pio Valenzuela scholars. \r\n\r\nCongratulations and make us proud, dear students! ', 'ACTIVE'),
(16, 0, '2024-10-25', '2024-11-08', 'image.png', 'Test Announcement', ' This is a test announcement', 'ACTIVE'),
(17, 0, '2024-05-29', '2024-11-14', 'pio-museo.jpg', 'Test', ' Placeholder', 'ACTIVE'),
(37, 0, '2024-09-03', '2024-10-24', '449189555_773571168273027_1948298230391781972_n.jpg', 'wheee', ' oho', 'INACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `batch_year`
--

CREATE TABLE `batch_year` (
  `batch_no` int(11) NOT NULL,
  `acad_year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_year`
--

INSERT INTO `batch_year` (`batch_no`, `acad_year`) VALUES
(1, '1995-1996'),
(2, '1996-1997'),
(3, '1997-1998'),
(4, '1998-1999'),
(5, '1999-2000'),
(6, '2000-2001'),
(7, '2001-2002'),
(8, '2002-2003'),
(9, '2003-2004'),
(10, '2004-2005'),
(11, '2005-2006'),
(12, '2006-2007'),
(13, '2007-2008'),
(14, '2008-2009'),
(15, '2009-2010'),
(16, '2010-2011'),
(17, '2011-2012'),
(18, '2012-2013'),
(19, '2013-2014'),
(20, '2014-2015'),
(21, '2015-2016'),
(22, '2016-2017'),
(23, '2017-2018'),
(24, '2018-2019'),
(25, '2019-2020'),
(26, '2020-2021'),
(27, '2021-2022'),
(28, '2023-2024'),
(29, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `viewed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notif_id`, `user_id`, `date`, `title`, `content`, `viewed`) VALUES
(74, 1, '2024-09-04', '30001-test DOCUMENT SUBMISSION', 'Documents submitted: <br><br>test_123_456_Year0_Sem1_COR.pdf<br>test_123_456_Year0_Sem1_GRADES.pdf<br>test_123_456_Year0_Sem1_SOCIAL.pdf<br>test_123_456_Year0_Sem1_DIPLOMA.pdf', 0),
(75, 1, '2024-09-13', '31001-HAVENFIELD DOCUMENT SUBMISSION', 'Documents submitted: <br><br>HAVENFIELD_RAISSEILLE__Year1_Sem1_COR.pdf<br>HAVENFIELD_RAISSEILLE__Year1_Sem1_GRADES.pdf<br>HAVENFIELD_RAISSEILLE__Year1_Sem1_SOCIAL.pdf<br>HAVENFIELD_RAISSEILLE__Year1_Sem1_DIPLOMA.pdf', 0),
(76, 1, '2024-09-13', '32001-CASPAR DOCUMENT SUBMISSION', 'Documents submitted: <br><br>CASPAR_NAVIA__Year1_Sem1_COR.pdf<br>CASPAR_NAVIA__Year1_Sem1_GRADES.pdf<br>CASPAR_NAVIA__Year1_Sem1_SOCIAL.pdf<br>CASPAR_NAVIA__Year1_Sem1_DIPLOMA.pdf', 0),
(77, 1, '2024-09-13', '30005-CRUZ DOCUMENT SUBMISSION', 'Documents submitted: <br><br>CRUZ_MATTEO ANTONIO_Dela Cruz_Year1_Sem1_COR.pdf<br>CRUZ_MATTEO ANTONIO_Dela Cruz_Year1_Sem1_GRADES.pdf<br>CRUZ_MATTEO ANTONIO_Dela Cruz_Year1_Sem1_SOCIAL.pdf<br>CRUZ_MATTEO ANTONIO_Dela Cruz_Year1_Sem1_DIPLOMA.pdf', 0),
(78, 1, '2024-09-13', '29005-Garcia DOCUMENT SUBMISSION', 'Documents submitted: <br><br>Garcia_Mark_Dela Rosa_Year1_Sem1_COR.pdf<br>Garcia_Mark_Dela Rosa_Year1_Sem1_GRADES.pdf<br>Garcia_Mark_Dela Rosa_Year1_Sem1_SOCIAL.pdf<br>Garcia_Mark_Dela Rosa_Year1_Sem1_DIPLOMA.pdf', 0),
(80, 528, '2024-10-10', '157-Garcia DOCUMENT APPROVAL', 'Document has been approved.', 0),
(81, 1, '2024-10-18', '31001-HAVENFIELD DOCUMENT SUBMISSION', 'Documents submitted: <br><br>HAVENFIELD_RAISSEILLE__Year1_Sem1_SOCIAL.pdf', 0),
(84, 524, '2024-10-19', '162-Dela Cruz DOCUMENT APPROVAL', 'Document has been approved.', 0),
(85, 1, '2024-10-22', '29001-Dela Cruz DOCUMENT SUBMISSION', 'Documents submitted: <br><br>Dela Cruz_Juan_Santos_Year1_Sem1_SOCIAL.pdf', 0),
(86, 524, '2024-10-22', '170-Dela Cruz DOCUMENT APPROVAL', 'Document has been approved.', 0),
(87, 524, '2024-10-22', '169-Dela Cruz DOCUMENT APPROVAL', 'Document has been approved.', 0),
(88, 524, '2024-10-22', '166-Dela Cruz DOCUMENT APPROVAL', 'Document has been approved.', 0),
(89, 544, '2024-10-22', '172-DE GUZMAN DOCUMENT APPROVAL', 'Document has been approved.', 0),
(90, 544, '2024-10-22', '173-DE GUZMAN DOCUMENT APPROVAL', 'Document has been approved.', 0),
(91, 544, '2024-10-22', '174-DE GUZMAN DOCUMENT APPROVAL', 'Document has been approved.', 0),
(92, 525, '2024-10-22', '171-Reyes DOCUMENT APPROVAL', 'Document has been approved.', 0),
(93, 525, '2024-10-22', '175-Reyes DOCUMENT APPROVAL', 'Document has been approved.', 0),
(94, 525, '2024-10-22', '176-Reyes DOCUMENT APPROVAL', 'Document has been approved.', 0),
(95, 1, '2024-10-25', '31001-HAVENFIELD DOCUMENT SUBMISSION', 'Documents submitted: <br><br>HAVENFIELD_RAISSEILLE__Year1_Sem1_COR.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `batch_no` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `report_type` varchar(100) NOT NULL,
  `creation_date` date NOT NULL,
  `acad_year` int(11) NOT NULL,
  `sem` int(1) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `summary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `batch_no`, `title`, `report_type`, `creation_date`, `acad_year`, `sem`, `file_name`, `summary`) VALUES
(38, 30, 'Scholar Status Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'status', '2024-09-05', 2024, 1, 'Scholar-Status-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>30</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-09-05</strong>, there are a total of <strong>3</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>1</strong> <br>\r\n                Total Dropped Scholars: <strong>1</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>1</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(40, 30, 'Scholar Status Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'status', '2024-09-12', 2024, 1, 'Scholar-Status-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>30</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-09-12</strong>, there are a total of <strong>3</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>1</strong> <br>\r\n                Total Dropped Scholars: <strong>1</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>1</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(42, 30, 'Scholar Profile and Requirements Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'requirement', '2024-09-13', 2024, 1, 'Profile-Requirement-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n\r\n                Batch Number: <strong> 30 </strong>\r\n\r\n                <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for Semester <strong> 1 </strong> of S.Y. <strong> 2024-2025 </strong>. As of <strong>2024-09-13</strong>, there are a total of <strong>11</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. The full report presents the profile of scholars and the current status of their requirements, along with the total number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program\'s criteria and obligation. </p>\r\n                <br>\r\n                    \r\n                Total Number of Scholars: <strong>11</strong> <br>\r\n                Total Number of Scholars with Complete Requirements: <strong>0</strong> <br>\r\n                Total Number of Scholars with Missing Requirements: <strong>1</strong> <br> <br>\r\n            '),
(43, 30, 'Scholar Profile and Requirements Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'requirement', '2024-09-13', 2024, 1, 'Profile-Requirement-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n\r\n                Batch Number: <strong> 30 </strong>\r\n\r\n                <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for Semester <strong> 1 </strong> of S.Y. <strong> 2024-2025 </strong>. As of <strong>2024-09-13</strong>, there are a total of <strong>11</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. The full report presents the profile of scholars and the current status of their requirements, along with the total number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program\'s criteria and obligation. </p>\r\n                <br>\r\n                    \r\n                Total Number of Scholars: <strong>11</strong> <br>\r\n                Total Number of Scholars with Complete Requirements: <strong>0</strong> <br>\r\n                Total Number of Scholars with Missing Requirements: <strong>1</strong> <br> <br>\r\n            '),
(44, 29, 'Scholar Status Report for Batch 29 - A.Y. 2024-2025 - Semester 1', 'status', '2024-09-13', 2024, 1, 'Scholar-Status-Report_Batch-29_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>29</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-09-13</strong>, there are a total of <strong>10</strong> scholars enrolled in the program for Batch Number <strong>29</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>6</strong> <br>\r\n                Total Dropped Scholars: <strong>1</strong> <br>\r\n                Total Dropped Scholars: <strong>2</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>1</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(45, 30, 'Scholar Status Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'status', '2024-10-01', 2024, 1, 'Scholar-Status-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>30</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-10-01</strong>, there are a total of <strong>11</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>11</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>0</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(46, 30, 'Scholar Status Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'status', '2024-10-05', 2024, 1, 'Scholar-Status-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>30</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-10-05</strong>, there are a total of <strong>11</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>11</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>0</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(47, 30, 'Scholar Status Report for Batch 30 - A.Y. 2024-2025 - Semester 1', 'status', '2024-10-08', 2024, 1, 'Scholar-Status-Report_Batch-30_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>30</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-10-08</strong>, there are a total of <strong>11</strong> scholars enrolled in the program for Batch Number <strong>30</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>11</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Dropped Scholars: <strong>0</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>0</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            '),
(48, 29, 'Scholar Status Report for Batch 29 - A.Y. 2024-2025 - Semester 1', 'status', '2024-10-08', 2024, 1, 'Scholar-Status-Report_Batch-29_Year-2024-2025_Sem-1.pdf', '\r\n                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>\r\n                SCHOLAR STATUS REPORT<br>\r\n                A.Y. 2024-2025 Semester 1 </h3><br>\r\n                    \r\n                Batch Number: <strong>29</strong>\r\n\r\n                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>2024-2025</strong>. As of <strong>2024-10-08</strong>, there are a total of <strong>10</strong> scholars enrolled in the program for Batch Number <strong>29</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>\r\n                <br>\r\n                Total Active Scholars: <strong>4</strong> <br>\r\n                Total Dropped Scholars: <strong>2</strong> <br>\r\n                Total Dropped Scholars: <strong>2</strong> <br>\r\n                Total Scholars on Leave of Absence: <strong>2</strong> <br>\r\n                Total Graduated Scholars: <strong>0</strong> <br>\r\n            ');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `description`) VALUES
(1, 'admin', 'Scholarship Coordinator'),
(2, 'scholar', 'Dr Pio Valenzuela Scholarship Program Grantee'),
(3, 'evaluator', '');

-- --------------------------------------------------------

--
-- Table structure for table `scholar`
--

CREATE TABLE `scholar` (
  `scholar_id` int(11) NOT NULL COMMENT 'B#SID',
  `batch_no` int(11) NOT NULL COMMENT 'B#',
  `user_id` int(11) NOT NULL COMMENT 'user table',
  `status` varchar(20) NOT NULL COMMENT 'status name',
  `last_name` varchar(30) NOT NULL COMMENT 'CAPS LOCK',
  `first_name` varchar(100) NOT NULL COMMENT 'CAPS LOCK',
  `middle_name` varchar(20) DEFAULT NULL COMMENT 'CAPS LOCK',
  `school` varchar(150) NOT NULL COMMENT 'CAPS LOCK',
  `course` varchar(150) NOT NULL COMMENT 'CAPS LOCK',
  `_address` text NOT NULL COMMENT 'CAPS LOCK',
  `contact` varchar(20) NOT NULL COMMENT 'phone number',
  `email` varchar(320) NOT NULL COMMENT 'example@provider.com',
  `remarks` text DEFAULT NULL,
  `graduating` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholar`
--

INSERT INTO `scholar` (`scholar_id`, `batch_no`, `user_id`, `status`, `last_name`, `first_name`, `middle_name`, `school`, `course`, `_address`, `contact`, `email`, `remarks`, `graduating`) VALUES
(29001, 29, 524, 'PROBATION', 'Dela Cruz', 'Juan', 'Santos', 'PAMANTASAN NG LUNGSOD NG VALENZUELA', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '7322 ELPIDIO QUIRINO AVENUE, BARANGAY TALON, LAS PI?AS CITY, METRO MANILA', '+63968078392', 'email@email.com', NULL, 0),
(29002, 29, 525, 'LOA', 'Reyes', 'Maria', 'Gonzales', 'Ateneo de Manila University', 'Bachelor of Arts in Economics', '218 Mariano Marcos Street, Barangay Sumilang, Pasig City, Metro Manila', '+639982153874', 'abcde@gmail.com', NULL, 0),
(29003, 29, 526, 'ACTIVE', 'Santos', 'Carlos', 'Ramirez', 'De La Salle University', 'Bachelor of Science in Chemical Engineering', '5839 Gregorio Araneta Avenue, Barangay Tandang Sora, Quezon City, Metro Manila', '+639324689127', 'abcde@gmail.com', NULL, 0),
(29004, 29, 527, 'ACTIVE', 'Cruz', 'Ana', 'Reyes', 'University of Santo Tomas', 'Bachelor of Science in Pharmacy', '1342 Juan Luna Street, Barangay Tondo, Manila City, Metro Manila', '+639567438291', 'abcde@gmail.com', NULL, 0),
(29005, 29, 528, 'LOA', 'Garcia', 'Mark', 'Dela Rosa', 'POLYTECHNIC UNIVERSITY OF THE PHILIPPINES', 'BACHELOR OF SCIENCE IN ARCHITECTURE', '4175 E. RODRIGUEZ SR. AVENUE, BARANGAY MARILAG, QUEZON CITY, METRO MANILA', '+6309083746257', 'garcia@gmail.com', NULL, 0),
(29006, 29, 529, 'ACTIVE', 'Bautista', 'Jose', 'Mendoza', 'Far Eastern University', 'Bachelor of Science in Accountancy', '9219 A. Mabini Street, Barangay San Isidro, Para?aque City, Metro Manila', '+639196512437', 'abcde@gmail.com', NULL, 0),
(29007, 29, 530, 'DROPPED', 'Mendoza', 'Clara', 'Bautista', 'Polytechnic University of the Philippines', 'Bachelor of Science in Architecture', '3546 J.P. Rizal Avenue, Barangay Olympia, Makati City, Metro Manila', '+639458391752', 'abcde@gmail.com', NULL, 0),
(29008, 29, 531, 'PROBATION', 'Ramos', 'Vicente', 'Pascual', 'Adamson University', 'Bachelor of Science in Nursing', '5671 P. Burgos Street, Barangay San Miguel, Mandaluyong City, Metro Manila', '+639275716483', 'abcde@gmail.com', NULL, 0),
(29009, 29, 532, 'DROPPED', 'Perez', 'Elisa', 'Mercado', 'National University', 'Bachelor of Science in Business Administration', '2468 R. Magsaysay Boulevard, Barangay Sta. Mesa, Manila City, Metro Manila', '+639632159846', 'abcde@gmail.com', NULL, 0),
(29010, 29, 533, 'ACTIVE', 'Morales', 'Leo', 'Fernandez', 'University of the East', 'Bachelor of Laws', '9087 J. Fajardo Street, Barangay Sampaloc, Manila City, Metro Manila', '+639164387925', 'abcde@gmail.com', NULL, 0),
(30001, 30, 534, 'ACTIVE', 'JACINTO', 'ALEXIS ROVIC JOHN', '', 'PAMANTASAN NG LUNGSOD NG VALENZUELA', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '1070 A VINCHY ST GEN T DE LEON VALENZUELA CITY', '+6309578078392', 'alexis.jacinto.320401@gmail.com', NULL, 0),
(30002, 30, 535, 'ACTIVE', 'REYES', 'ALTHEA MARIE', 'Aquino', 'University of the Philippines Diliman', 'Bachelor of Science in Computer Science', '27 Sampaguita Street, Barangay San Antonio, Quezon City', '+6309175552468', 'alexis.jacinto.320401+test1@gmail.com', NULL, 0),
(30003, 30, 536, 'ACTIVE', 'SANTOS', 'JOAQUIN MIGUEL', 'Mendoza', 'Ateneo de Manila University', 'Bachelor of Arts in Economics', 'Unit 15B Makati Skyline Tower, Ayala Avenue, Makati City', '+6309051237890', 'alexis.jacinto.320401+test2@gmail.com', NULL, 0),
(30004, 30, 537, 'ACTIVE', 'MERCADO', 'ZIA ISABEL', 'Lim', 'De La Salle University', 'Bachelor of Science in Chemical Engineering', '134 Mango Road, Poblacion, Davao City', '+6309289876543', 'alexis.jacinto.320401+test3@gmail.com', NULL, 0),
(30005, 30, 538, 'ACTIVE', 'CRUZ', 'MATTEO ANTONIO', 'Dela Cruz', 'University of Santo Tomas', 'Bachelor of Science in Pharmacy', '78 Rizal Boulevard, Bacolod City, Negros Occidental', '+6309392468135', 'alexis.jacinto.320401+test4@gmail.com', NULL, 0),
(30006, 30, 539, 'ACTIVE', 'BAUTISTA', 'ARIA GRACE', 'Tan', 'Map?a University', 'Bachelor of Science in Electronics Engineering', 'Block 3 Lot 7, Green Meadows Subdivision, Cainta, Rizal', '+6309987654321', 'alexis.jacinto.320401+test5@gmail.com', NULL, 0),
(30007, 30, 540, 'ACTIVE', 'DOMINGO', 'KAI RAFAEL', 'Reyes', 'Far Eastern University', 'Bachelor of Science in Accountancy', '56 Mayon Avenue, Legazpi City, Albay', '+6309451357902', 'alexis.jacinto.320401+test6@gmail.com', NULL, 0),
(30008, 30, 541, 'ACTIVE', 'VILLEGAS', 'LUNA SOFIA', 'Gonzales', 'Polytechnic University of the Philippines', 'Bachelor of Science in Architecture', 'Unit 203 Cebu Business Park, Cebu City', '+6309568024680', 'alexis.jacinto.320401+test7@gmail.com', NULL, 0),
(30009, 30, 542, 'ACTIVE', 'FERNANDEZ', 'ENZO GABRIEL', 'Pascual', 'Adamson University', 'Bachelor of Science in Nursing', '19 Kalayaan Street, Baguio City, Benguet', '+6309773691470', 'alexis.jacinto.320401+test8@gmail.com', NULL, 0),
(30011, 30, 544, 'ACTIVE', 'DE GUZMAN', 'NICO ALEJANDRO', 'Dizon', 'University of the East', 'Bachelor of Laws', '88 General Luna Road, Intramuros, Manila', '+6309261597532', 'alexis.jacinto.320401+test0@gmail.com', NULL, 0),
(31001, 31, 606, 'ACTIVE', 'a', 'a', 'a', 'a', 'a', 'a', '+63a', 'a', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `scholar_id` int(11) NOT NULL,
  `_status` int(11) NOT NULL,
  `acad_year` varchar(10) NOT NULL,
  `sem` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `submit_id` int(11) NOT NULL,
  `scholar_id` int(11) NOT NULL,
  `sub_date` date NOT NULL,
  `doc_name` varchar(150) NOT NULL,
  `doc_type` varchar(50) NOT NULL,
  `school` varchar(150) NOT NULL,
  `acad_year` varchar(10) NOT NULL,
  `sem` int(1) NOT NULL,
  `doc_status` varchar(10) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`submit_id`, `scholar_id`, `sub_date`, `doc_name`, `doc_type`, `school`, `acad_year`, `sem`, `doc_status`, `reason`) VALUES
(157, 29005, '2024-09-13', 'Garcia_Mark_Dela Rosa_Year1_Sem1_COR.pdf', 'COR', 'POLYTECHNIC UNIVERSITY OF THE PHILIPPINES', '2024-2025', 1, 'APPROVED', ''),
(159, 29005, '2024-09-13', 'Garcia_Mark_Dela Rosa_Year1_Sem1_SOCIAL.pdf', 'SOCIAL', 'POLYTECHNIC UNIVERSITY OF THE PHILIPPINES', '2024-2025', 1, 'PENDING', ''),
(160, 29005, '2024-09-13', 'Garcia_Mark_Dela Rosa_Year1_Sem1_DIPLOMA.pdf', 'DIPLOMA', 'POLYTECHNIC UNIVERSITY OF THE PHILIPPINES', '2024-2025', 1, 'PENDING', ''),
(166, 29001, '2024-10-22', 'Dela Cruz_Juan_Santos_Year1_Sem1_SOCIAL.pdf', 'SOCIAL', 'PAMANTASAN NG LUNGSOD NG VALENZUELA', '2024-2025', 1, 'APPROVED', ''),
(169, 29001, '2024-10-22', 'Dela Cruz_Juan_Santos_Year4_Sem1_GRADES.pdf', 'GRADES', 'PAMANTASAN NG LUNGSOD NG VALENZUELA', '2024-2025', 1, 'APPROVED', ''),
(170, 29001, '2024-10-22', 'Dela Cruz_Juan_Santos_Year4_Sem1_COR.pdf', 'COR', 'PAMANTASAN NG LUNGSOD NG VALENZUELA', '2024-2025', 1, 'APPROVED', ''),
(171, 29002, '2024-10-22', 'Reyes_Maria_Gonzales_Year4_Sem1_COR.pdf', 'COR', 'Ateneo de Manila University', '2024-2025', 1, 'APPROVED', ''),
(172, 30011, '2024-10-22', 'DE GUZMAN_NICO ALEJANDRO_Dizon_Year3_Sem1_COR.pdf', 'COR', 'University of the East', '2024-2025', 1, 'APPROVED', ''),
(173, 30011, '2024-10-22', 'DE GUZMAN_NICO ALEJANDRO_Dizon_Year3_Sem1_GRADES.pdf', 'GRADES', 'University of the East', '2024-2025', 1, 'APPROVED', ''),
(174, 30011, '2024-10-22', 'DE GUZMAN_NICO ALEJANDRO_Dizon_Year3_Sem1_SOCIAL.pdf', 'SOCIAL', 'University of the East', '2024-2025', 1, 'APPROVED', ''),
(175, 29002, '2024-10-22', 'Reyes_Maria_Gonzales_Year4_Sem1_GRADES.pdf', 'GRADES', 'Ateneo de Manila University', '2024-2025', 1, 'APPROVED', ''),
(176, 29002, '2024-10-22', 'Reyes_Maria_Gonzales_Year4_Sem1_SOCIAL.pdf', 'SOCIAL', 'Ateneo de Manila University', '2024-2025', 1, 'APPROVED', '');

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(150) NOT NULL,
  `address` varchar(250) NOT NULL,
  `acad_year` varchar(10) NOT NULL,
  `sem_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`school_id`, `school_name`, `address`, `acad_year`, `sem_count`) VALUES
(1, 'PAMANTASAN NG LUNGSOD NG VALENZUELA', 'MXV9+GJF, Maysan Rd, Valenzuela, Metro Manila', '2024-2025', 2),
(3, 'aa', 'bb', '2024-2025', 2),
(4, 'bb', 'zz', '2024-2025', 3),
(5, 'zz', 'aa', '2024-2025', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `passhash` varchar(255) NOT NULL,
  `reset_code` varchar(8) NOT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role_id`, `username`, `email`, `passhash`, `reset_code`, `reset_expiry`) VALUES
(1, 1, 'admin', 'pio.iskolar.team@gmail.com', 'test', '', NULL),
(2, 3, 'evaluator', 'pio.iskolar.team+eval@gmail.com', 'eval', '', NULL),
(3, 2, 'test', '', 'testing', '', NULL),
(524, 2, '29-001', '', 'Dela Cruz', '', NULL),
(525, 2, '29-002', '', 'Reyes', '', NULL),
(526, 2, '29-003', '', 'Santos', '', NULL),
(527, 2, '29-004', '', 'Cruz', '', NULL),
(528, 2, '29-005', '', 'Garcia', '', NULL),
(529, 2, '29-006', '', 'Bautista', '', NULL),
(530, 2, '29-007', '', 'Mendoza', '', NULL),
(531, 2, '29-008', '', 'Ramos', '', NULL),
(532, 2, '29-009', '', 'Perez', '', NULL),
(533, 2, '29-010', '', 'Morales', '', NULL),
(534, 2, '30-001', 'alexis.jacinto.320401@gmail.com', 'test', '', NULL),
(535, 2, '30-002', '', 'REYES', '', NULL),
(536, 2, '30-003', '', 'SANTOS', '', NULL),
(537, 2, '30-004', '', 'MERCADO', '', NULL),
(538, 2, '30-005', '', 'CRUZ', '', NULL),
(539, 2, '30-006', '', 'BAUTISTA', '', NULL),
(540, 2, '30-007', '', 'DOMINGO', '', NULL),
(541, 2, '30-008', '', 'VILLEGAS', '', NULL),
(542, 2, '30-009', '', 'FERNANDEZ', '', NULL),
(544, 2, '30-011', '', 'DE GUZMAN', '', NULL),
(547, 2, '31-001', '', 'HAVENFIELD', '', NULL),
(551, 2, '28-002', '', 'A', '', NULL),
(558, 2, '27-003', '', 'B', '', NULL),
(561, 2, '23-001', '', 'B', '', NULL),
(562, 2, '23-002', '', 'B', '', NULL),
(563, 2, '31-001', '', 'TESTING', '', NULL),
(564, 2, '31-001', '', 'A', '', NULL),
(565, 2, '31-001', '', 'A', '', NULL),
(566, 2, '31-001', '', 'A', '', NULL),
(567, 2, '31-001', '', 'A', '', NULL),
(568, 2, '31-001', '', 'A', '', NULL),
(569, 2, '31-001', '', 'A', '', NULL),
(570, 2, '31-001', '', 'A', '', NULL),
(571, 2, '31-001', '', 'A', '', NULL),
(572, 2, '31-001', '', 'A', '', NULL),
(573, 2, '31-001', '', 'A', '', NULL),
(574, 2, '31-001', '', 'A', '', NULL),
(575, 2, '31-002', '', 'A', '', NULL),
(576, 2, '31-003', '', 'A', '', NULL),
(577, 2, '31-004', '', 'A', '', NULL),
(578, 2, '31-005', '', 'A', '', NULL),
(579, 2, '31-005', '', 'A', '', NULL),
(580, 2, '31-004', '', 'A', '', NULL),
(581, 2, '31-003', '', 'B', '', NULL),
(582, 2, '31-006', '', 'B', '', NULL),
(583, 2, '31-007', '', 'C', '', NULL),
(584, 2, '31-008', '', 'C', '', NULL),
(585, 2, '30-012', '', 'B', '', NULL),
(586, 2, '32-001', '', 'D', '', NULL),
(587, 2, '33-001', '', 'E', '', NULL),
(588, 2, '33-002', '', 'E', '', NULL),
(589, 2, '33-003', '', 'E', '', NULL),
(590, 2, '33-004', '', 'E', '', NULL),
(591, 2, '33-005', '', 'E', '', NULL),
(592, 2, '32-001', '', 'A', '', NULL),
(593, 2, '32-002', '', 'A', '', NULL),
(594, 2, '32-003', '', 'A', '', NULL),
(595, 2, '32-004', '', 'A', '', NULL),
(596, 2, '32-005', '', 'A', '', NULL),
(597, 2, '32-006', '', 'A', '', NULL),
(603, 2, '30-001', 'a', 'a', '', NULL),
(604, 2, '30-001', 'a', 'a', '', NULL),
(605, 2, '30-001', 'a', 'a', '', NULL),
(606, 2, '31-001', 'a', 'a', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announce_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `batch_year`
--
ALTER TABLE `batch_year`
  ADD UNIQUE KEY `batch_no` (`batch_no`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `notif-user` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `scholar`
--
ALTER TABLE `scholar`
  ADD PRIMARY KEY (`scholar_id`),
  ADD KEY `scholar_id` (`scholar_id`,`batch_no`,`last_name`),
  ADD KEY `scholar-user` (`user_id`),
  ADD KEY `scholar-status` (`status`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`scholar_id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`submit_id`),
  ADD KEY `submission-scholar` (`scholar_id`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user-role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `submit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=607;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notif-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scholar`
--
ALTER TABLE `scholar`
  ADD CONSTRAINT `scholar-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `submission-scholar` FOREIGN KEY (`scholar_id`) REFERENCES `scholar` (`scholar_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user-role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
