-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2024 at 02:33 AM
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
-- Database: `ofrs_db`
--
CREATE DATABASE IF NOT EXISTS `ofrs_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ofrs_db`;

-- --------------------------------------------------------

--
-- Table structure for table `events_list`
--

CREATE TABLE `events_list` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `sitio` varchar(255) NOT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_list`
--

INSERT INTO `events_list` (`id`, `event_name`, `event_description`, `event_date`, `event_time`, `municipality`, `barangay`, `sitio`, `event_image`, `created_at`, `updated_at`, `delete_flag`) VALUES
(75, 'Hazardous Materials Drill', 'kakakakkka', '2024-11-03', '08:00:00', 'Bantayan', 'Oboob', 'Tabagak Elem School', '', '2024-11-01 00:42:55', '2024-11-04 13:23:22', 1),
(76, 'Flood Drill', 'fadkielqi', '2024-11-20', NULL, 'Bantayan', 'Lipayran', 'Pulang Bato ', '1730426626_santafe_logo.jpg', '2024-11-01 02:03:46', '2024-11-04 13:23:12', 1),
(82, 'Tornado Drill', 'there\'s a hurricane milton', '2024-11-20', '10:40:00', 'Bantayan', 'Binaobao', 'Binaobao Elementary School', '1730724264_one.jpg', '2024-11-04 12:39:42', '2024-11-04 13:22:58', 1),
(83, 'Earthquake Drill', 'hello folks', '2024-11-14', '09:00:00', 'Bantayan', 'Baigad', 'Baigad Elementary School', '1730725647_logo.jpg', '2024-11-04 13:07:27', '2024-11-04 13:21:46', 1),
(84, 'Hazardous Materials Drill', 'hahahahaa', '2024-11-25', '10:00:00', 'Bantayan', 'Hilotongan', 'Hilotongan Elementary School', '1730726676_download (4).jpg', '2024-11-04 13:24:16', '2024-11-06 01:12:01', 1),
(85, 'Fire Drill', '.....kdkdk', '2024-11-30', '10:00:00', 'Bantayan', 'Doong', 'Doong Elementary School', '1730856713_Screenshot 2024-11-02 090958.png', '2024-11-06 01:31:53', '2024-11-06 01:32:11', 1),
(86, 'Fire Drill', 'amlala', '2024-11-08', '08:00:00', 'Santa Fe', 'Langub', 'lskwk', '1730876290_Screenshot 2024-11-05 142916.png', '2024-11-06 06:58:10', '2024-11-06 06:58:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `history_list`
--

CREATE TABLE `history_list` (
  `id` int(30) NOT NULL,
  `request_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_list`
--

INSERT INTO `history_list` (`id`, `request_id`, `status`, `remarks`, `date_created`) VALUES
(117, 77, 1, 'Request has been assign to a fire control team.', '2024-09-19 15:44:03'),
(118, 78, 1, 'Request has been assign to a fire control team.', '2024-10-04 20:39:06'),
(119, 89, 1, 'Request has been assign to a fire control team.', '2024-10-15 19:46:53'),
(120, 96, 1, 'Request has been assign to a fire control team.', '2024-10-31 22:35:17'),
(121, 96, 2, '', '2024-10-31 22:35:28'),
(122, 96, 3, '', '2024-10-31 22:54:03'),
(123, 96, 4, '', '2024-10-31 22:54:16'),
(124, 94, 1, 'Request has been assign to a fire control team.', '2024-10-31 23:18:17'),
(125, 94, 2, '', '2024-10-31 23:18:34'),
(126, 94, 3, '', '2024-10-31 23:18:59'),
(127, 94, 4, '', '2024-10-31 23:19:07'),
(128, 97, 1, 'Request has been assign to a fire control team.', '2024-11-02 15:51:34'),
(129, 102, 1, 'Request has been assign to a fire control team.', '2024-11-04 17:26:23'),
(130, 102, 2, '', '2024-11-04 17:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_list`
--

CREATE TABLE `inquiry_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `contact` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `municipalities`
--

CREATE TABLE `municipalities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `municipalities`
--

INSERT INTO `municipalities` (`id`, `name`, `logo`) VALUES
(1, 'Bantayan', ''),
(2, 'Santa Fe', ''),
(3, 'Madridejos', '');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `district` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_list`
--

CREATE TABLE `request_list` (
  `id` int(30) NOT NULL,
  `team_id` int(30) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `contact` text NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `sitio_street` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending,\r\n1 = Assigned to Team,\r\n2 = Team on their Way\r\n3 = Relief on progress\r\n4 = Completed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_reports` text DEFAULT NULL,
  `deleted_from` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_list`
--

INSERT INTO `request_list` (`id`, `team_id`, `code`, `lastname`, `firstname`, `middlename`, `contact`, `subject`, `message`, `image`, `municipality`, `barangay`, `sitio_street`, `status`, `date_created`, `date_updated`, `deleted_reports`, `deleted_from`) VALUES
(73, NULL, '20240913-0001', 'Oflas', 'Mary', 'Ann', '09325247257', 'Flood', 'hello lord', '../uploads/ec380e786054aa3cdd247f583471fe85.jpg', 'Madridejos', 'Pili', 'Purok lubi 2, cahutay srt.', 5, '2024-09-13 16:58:40', '2024-11-02 13:42:45', NULL, NULL),
(75, NULL, '20240917-0001', 'Durant', 'Kevin', 'James', '09325247257', 'Flood', 'jafhsakdfjksa', '../uploads/4b4cd4a350ebe4090bcf4fdf9bcc40f3.jpeg', 'Bantayan', 'Tamiao', 'Purok Mangga 2', 5, '2024-09-17 10:28:12', '2024-10-30 16:22:52', NULL, NULL),
(76, NULL, '20240918-0001', 'Lebron', 'James', 'Bron', '09325247257', 'Sunog', 'my house is on fire', '../uploads/c16cbd9d41079ad647a0efbacefcc1f0.jpg', 'Santa Fe', 'Okoy', 'Purok Bakhawan', 5, '2024-09-18 18:02:26', '2024-10-07 11:25:58', '{\"id\":\"76\",\"team_id\":null,\"code\":\"20240918-0001\",\"lastname\":\"Lebron\",\"firstname\":\"James\",\"middlename\":\"Bron\",\"contact\":\"09325247257\",\"subject\":\"Sunog\",\"message\":\"my house is on fire\",\"image\":\"..\\/uploads\\/c16cbd9d41079ad647a0efbacefcc1f0.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Okoy\",\"sitio_street\":\"Purok Bakhawan\",\"status\":\"5\",\"date_created\":\"2024-09-18 18:02:26\",\"date_updated\":\"2024-09-19 11:41:49\",\"deleted_reports\":\"{\\\"id\\\":\\\"76\\\",\\\"team_id\\\":null,\\\"code\\\":\\\"20240918-0001\\\",\\\"lastname\\\":\\\"Lebron\\\",\\\"firstname\\\":\\\"James\\\",\\\"middlename\\\":\\\"Bron\\\",\\\"contact\\\":\\\"09325247257\\\",\\\"subject\\\":\\\"Sunog\\\",\\\"message\\\":\\\"my house is on fire\\\",\\\"image\\\":\\\"..\\\\\\/uploads\\\\\\/c16cbd9d41079ad647a0efbacefcc1f0.jpg\\\",\\\"municipalit\"}', NULL),
(77, 2, '20240919-0001', 'Steph', 'Curry', 'Karlitos', '09283239293', 'Flood', 'oracle has on fire', '../uploads/add6466412d7ab2196c8b3f2b92b1f9e.jpg', 'Santa Fe', 'Maricaban', 'Purok Danggit', 5, '2024-09-19 15:43:46', '2024-10-07 11:25:55', '{\"id\":\"77\",\"team_id\":\"2\",\"code\":\"20240919-0001\",\"lastname\":\"Steph\",\"firstname\":\"Curry\",\"middlename\":\"Karlitos\",\"contact\":\"09283239293\",\"subject\":\"Flood\",\"message\":\"oracle has on fire\",\"image\":\"..\\/uploads\\/add6466412d7ab2196c8b3f2b92b1f9e.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Maricaban\",\"sitio_street\":\"Purok Danggit\",\"status\":\"5\",\"date_created\":\"2024-09-19 15:43:46\",\"date_updated\":\"2024-10-04 20:46:17\",\"deleted_reports\":\"{\\\"id\\\":\\\"77\\\",\\\"team_id\\\":\\\"2\\\",\\\"code\\\":\\\"20240919-0001\\\",\\\"lastname\\\":\\\"Steph\\\",\\\"firstname\\\":\\\"Curry\\\",\\\"middlename\\\":\\\"Karlitos\\\",\\\"contact\\\":\\\"09283239293\\\",\\\"subject\\\":\\\"Flood\\\",\\\"message\\\":\\\"oracle has on fire\\\",\\\"image\\\":\\\"..\\\\\\/uploads\\\\\\/add6466412d7ab2196c8b3f2b92b1f9e.jpg\\\",\\\"municipali\"}', NULL),
(78, 7, '20241004-0001', 'Kurosaki', 'Ichigo', 'Kun', '09122777291', 'Fire', 'Wild fires in the middle of ocaeans', '../uploads/ca4e7d5a06944ab502dbf829d3167478.jpg', 'Bantayan', 'Lipayran', 'Purok Danggit', 5, '2024-10-04 20:38:41', '2024-10-31 15:50:01', NULL, NULL),
(79, NULL, '20241004-0002', 'Ichiro ', 'Yuda', 'Yuji', '09343243243', 'Rescue', 'fasdfsaf', '../uploads/ddb929ab25befd718d1cd929b55dfe65.jpg', 'Santa Fe', 'Okoy', 'Purok Gusaw', 5, '2024-10-04 20:44:10', '2024-10-07 11:25:49', '{\"id\":\"79\",\"team_id\":null,\"code\":\"20241004-0002\",\"lastname\":\"Ichiro \",\"firstname\":\"Yuda\",\"middlename\":\"Yuji\",\"contact\":\"09343243243\",\"subject\":\"Rescue\",\"message\":\"fasdfsaf\",\"image\":\"..\\/uploads\\/ddb929ab25befd718d1cd929b55dfe65.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Okoy\",\"sitio_street\":\"Purok Gusaw\",\"status\":\"5\",\"date_created\":\"2024-10-04 20:44:10\",\"date_updated\":\"2024-10-04 20:46:02\",\"deleted_reports\":\"{\\\"id\\\":\\\"79\\\",\\\"team_id\\\":null,\\\"code\\\":\\\"20241004-0002\\\",\\\"lastname\\\":\\\"Ichiro \\\",\\\"firstname\\\":\\\"Yuda\\\",\\\"middlename\\\":\\\"Yuji\\\",\\\"contact\\\":\\\"09343243243\\\",\\\"subject\\\":\\\"Rescue\\\",\\\"message\\\":\\\"fasdfsaf\\\",\\\"image\\\":\\\"..\\\\\\/uploads\\\\\\/ddb929ab25befd718d1cd929b55dfe65.jpg\\\",\\\"municipality\\\":\\\"Santa \"}', NULL),
(80, NULL, '20241004-0003', 'Kurosaki', 'Yuda', 'Kun', '09122777291', 'Rescue', 'hoo kabogo', '../uploads/bdf5aab32c6d73b67cddc116dc88604f.jpeg', 'Bantayan', 'Lipayran', 'Purok Guso', 5, '2024-10-04 20:51:53', '2024-10-31 19:10:04', NULL, NULL),
(81, NULL, '20241007-0001', 'Amegos', 'Coffee', 'Mix', '09343892757', 'Flood', 'unta maayo kana nga archive ka', '../uploads/6879e465942d5883d37edf3cfdf68172.jpg', 'Santa Fe', 'Langub', 'Purok Bakhaw, Mariano Street', 5, '2024-10-07 10:10:45', '2024-10-07 11:25:42', '{\"id\":\"81\",\"team_id\":null,\"code\":\"20241007-0001\",\"lastname\":\"Amegos\",\"firstname\":\"Coffee\",\"middlename\":\"Mix\",\"contact\":\"09343892757\",\"subject\":\"Flood\",\"message\":\"unta maayo kana nga archive ka\",\"image\":\"..\\/uploads\\/6879e465942d5883d37edf3cfdf68172.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Langub\",\"sitio_street\":\"Purok Bakhaw, Mariano Street\",\"status\":\"5\",\"date_created\":\"2024-10-07 10:10:45\",\"date_updated\":\"2024-10-07 11:25:26\",\"deleted_reports\":\"{\\\"id\\\":\\\"81\\\",\\\"team_id\\\":null,\\\"code\\\":\\\"20241007-0001\\\",\\\"lastname\\\":\\\"Amegos\\\",\\\"firstname\\\":\\\"Coffee\\\",\\\"middlename\\\":\\\"Mix\\\",\\\"contact\\\":\\\"09343892757\\\",\\\"subject\\\":\\\"Flood\\\",\\\"message\\\":\\\"unta maayo kana nga archive ka\\\",\\\"image\\\":\\\"..\\\\\\/uploads\\\\\\/6879e465942d5883d37edf3cfdf68172.jpg\\\",\\\"municipality\\\":\\\"Santa Fe\\\",\\\"barangay\\\":\\\"Langub\\\",\\\"sitio_street\\\":\\\"Purok Bakhaw, Mariano Street\\\",\\\"status\\\":\\\"5\\\",\\\"date_created\\\":\\\"2024-10-07 10:10:45\\\",\\\"date_updated\\\":\\\"2024-10-07 11:22:27\\\",\\\"deleted_reports\\\":\\\"{\\\\\\\\\\\\\\\"id\\\\\\\\\\\\\\\":81,\\\\\\\\\\\\\\\"team_id\\\\\\\\\\\\\\\":null,\\\\\\\\\\\\\\\"code\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"20241007-0001\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"lastname\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Amegos\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"firstname\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Coffee\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"middlename\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Mix\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"contact\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"09343892757\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"subject\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Flood\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"message\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"unta maayo kana nga archive ka\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"image\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"..\\\\\\\\\\\\\\\\\\\\\\/uploads\\\\\\\\\\\\\\\\\\\\\\/6879e465942d5883d37edf3cfdf68172.jpg\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"municipality\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Santa Fe\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"barangay\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Langub\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"sitio_street\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"Purok Bakhaw, Mariano Street\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"status\\\\\\\\\\\\\\\":5,\\\\\\\\\\\\\\\"date_created\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"2024-10-07 10:10:45\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"date_updated\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"2024-10-07 10:39:43\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\"deleted_reports\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\"{\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"id\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"81\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"team_id\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":null,\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"code\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"20241007-0001\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"lastname\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Amegos\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"firstname\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Coffee\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"middlename\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Mix\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"contact\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"09343892757\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"subject\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Flood\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"message\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"unta maayo kana nga archive ka\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"image\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"..\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\/uploads\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\/6879e465942d5883d37edf3cfdf68172.jpg\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"municipality\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Santa Fe\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"barangay\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Langub\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"sitio_street\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Purok Bakhaw, Mariano Street\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"status\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"0\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"date_created\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"2024-10-07 10:10:45\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"date_updated\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"2024-10-07 10:10:45\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"deleted_reports\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":null}\\\\\\\\\\\\\\\"}\\\"}\"}', NULL),
(82, NULL, '20241007-0002', 'Kapi', 'Bara', 'Bucks', '09343892757', 'Sunog', 'maysunog tabang ', '../uploads/350ed3e273da35211ea157e9221dbcd0.jpg', 'Santa Fe', 'Okoy', 'Purok Bakhaw, Mariano Street', 5, '2024-10-07 11:32:11', '2024-10-07 11:32:45', '{\"id\":\"82\",\"team_id\":null,\"code\":\"20241007-0002\",\"lastname\":\"Kapi\",\"firstname\":\"Bara\",\"middlename\":\"Bucks\",\"contact\":\"09343892757\",\"subject\":\"Sunog\",\"message\":\"maysunog tabang \",\"image\":\"..\\/uploads\\/350ed3e273da35211ea157e9221dbcd0.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Okoy\",\"sitio_street\":\"Purok Bakhaw, Mariano Street\",\"status\":\"0\",\"date_created\":\"2024-10-07 11:32:11\",\"date_updated\":\"2024-10-07 11:32:11\",\"deleted_reports\":null}', NULL),
(83, NULL, '20241007-0003', 'Bai', 'Nano', 'Layaog', '09489712811', 'Linog', 'adkfieqlfakj fkjadfowejf  adskfalvnclmx', '../uploads/b5848853808a382c94d4a8aa81ffd280.jpg', 'Madridejos', 'Talangnan', 'Purok litob, Mariano Street', 5, '2024-10-07 11:36:34', '2024-11-02 13:43:29', NULL, NULL),
(84, NULL, '20241007-0004', 'Bai', 'Tinoy', 'Pikar', '09489712811', 'Tsunami', 'hahahhaaaaaaaaaaaaaaaaaaaaaaaa', '../uploads/6f545635d93d65de3792377f97ca85fa.jpeg', 'Bantayan', 'Doong', 'Purok pyanas, Mariano Street', 5, '2024-10-07 11:50:14', '2024-10-31 19:16:35', NULL, NULL),
(85, NULL, '20241007-0005', 'Pisti', 'Kalibog ', 'Naha', '09489712811', 'Tsunami', 'fadfsafadf', '../uploads/ba318f59ee5c64d675d7ed7e5186872f.jpg', 'Santa Fe', 'Kinatarkan', 'Purok litob, Mariano Street', 5, '2024-10-07 19:53:46', '2024-10-08 10:21:12', '{\"id\":\"85\",\"team_id\":null,\"code\":\"20241007-0005\",\"lastname\":\"Pisti\",\"firstname\":\"Kalibog \",\"middlename\":\"Naha\",\"contact\":\"09489712811\",\"subject\":\"Tsunami\",\"message\":\"fadfsafadf\",\"image\":\"..\\/uploads\\/ba318f59ee5c64d675d7ed7e5186872f.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Kinatarkan\",\"sitio_street\":\"Purok litob, Mariano Street\",\"status\":\"5\",\"date_created\":\"2024-10-07 19:53:46\",\"date_updated\":\"2024-10-07 19:53:57\",\"deleted_reports\":\"{\\\"id\\\":\\\"85\\\",\\\"team_id\\\":null,\\\"code\\\":\\\"20241007-0005\\\",\\\"lastname\\\":\\\"Pisti\\\",\\\"firstname\\\":\\\"Kalibog \\\",\\\"middlename\\\":\\\"Naha\\\",\\\"contact\\\":\\\"09489712811\\\",\\\"subject\\\":\\\"Tsunami\\\",\\\"message\\\":\\\"fadfsafadf\\\",\\\"image\\\":\\\"..\\\\\\/uploads\\\\\\/ba318f59ee5c64d675d7ed7e5186872f.jpg\\\",\\\"municipality\\\":\\\"Santa Fe\\\",\\\"barangay\\\":\\\"Kinatarkan\\\",\\\"sitio_street\\\":\\\"Purok litob, Mariano Street\\\",\\\"status\\\":\\\"0\\\",\\\"date_created\\\":\\\"2024-10-07 19:53:46\\\",\\\"date_updated\\\":\\\"2024-10-07 19:53:46\\\",\\\"deleted_reports\\\":null}\",\"is_restored\":\"0\"}', NULL),
(86, NULL, '20241008-0001', 'Pisti', 'Tinoy', 'Layaog', '09489712811', 'Tsunami', 'fasfdas', '../uploads/00e573754512482037a355af41427fbf.jpg', 'Bantayan', 'Atop-Atop', 'Sitio tinago, Mariano Street', 5, '2024-10-08 10:09:41', '2024-11-02 08:54:20', NULL, NULL),
(87, NULL, '20241008-0002', 'Bitoon', 'Sa', 'Langit', '09489712811', 'Baha', 'Baha Sa Kadagatan', '../uploads/57d09c5e697fc04226f36c818e395e7e.jpg', 'Bantayan', 'Kangkaibe', 'Purok Bakhaw Mariano Street', 5, '2024-10-08 21:37:28', '2024-10-31 18:41:16', NULL, NULL),
(88, NULL, '20241008-0003', 'Konoha', 'Uzumaki', 'Kirito', '09343944303', 'Linog', 'You dipota diponggol', '../uploads/d4ba34dc241e16d4919ffc1992e97c0b.jpg', 'Santa Fe', 'Okoy', 'Purok Lubi / Mariano Beach Street', 5, '2024-10-08 21:47:05', '2024-10-08 21:48:36', '{\"id\":\"88\",\"team_id\":null,\"code\":\"20241008-0003\",\"lastname\":\"Konoha\",\"firstname\":\"Uzumaki\",\"middlename\":\"Kirito\",\"contact\":\"09343944303\",\"subject\":\"Linog\",\"message\":\"You dipota diponggol\",\"image\":\"..\\/uploads\\/d4ba34dc241e16d4919ffc1992e97c0b.jpg\",\"municipality\":\"Santa Fe\",\"barangay\":\"Okoy\",\"sitio_street\":\"Purok Lubi \\/ Mariano Beach Street\",\"status\":\"0\",\"date_created\":\"2024-10-08 21:47:05\",\"date_updated\":\"2024-10-08 21:47:05\",\"deleted_reports\":null,\"is_restored\":\"0\"}', NULL),
(89, 2, '20241015-0001', 'Jahnson', 'Kill', 'Mid', '00938438211', 'Baha', 'niko nikoni', '../uploads/d69767068d8e49aec585e99ab886b0cc.jpg', 'Bantayan', 'Hilotongan', 'Marciano Street', 5, '2024-10-15 09:47:37', '2024-10-31 15:55:59', NULL, NULL),
(90, NULL, '20241015-0002', 'Jino', 'The ', 'Gret', '09284891299', 'Buhawi', 'sate sate ganbare senpai', '../uploads/ff8a2fc98acac631f01c438b15f82467.jpg', 'Bantayan', 'Botigues', 'Mambakayaw Stree', 5, '2024-10-15 19:50:46', '2024-10-31 15:50:55', NULL, NULL),
(91, NULL, '20241016-0001', 'Ban', 'Na', 'Nana', '09343944303', 'Tsunami', 'nikoninkoninkona', '../uploads/cdbeb65b1124f406a08544093860f9e0.jpeg', 'Madridejos', 'San Agustin', 'Purok Bakhaw Mariano Street', 5, '2024-10-16 10:09:34', '2024-11-02 13:42:25', NULL, NULL),
(92, NULL, '20241019-0001', 'Okada', 'Itchi', 'Oda', '09123456789', 'Sunamai', 'kokororokaor', '../uploads/2488a365a12b7910e8cc7afd2f7c2ef6.jpg', 'Bantayan', 'Lipayran', 'Purok Dangit', 5, '2024-10-19 09:52:47', '2024-10-31 15:50:11', NULL, NULL),
(93, NULL, '20241019-0002', 'Kakaa', 'Kikiki', 'Kokoko', '09123456789', 'Sunamai', 'fadeqsgh4', '../uploads/af622cbcadb45b61e7d5587dd8b679c0.jpg', 'Bantayan', 'Kabac', 'Fase Gase', 5, '2024-10-19 10:30:04', '2024-10-31 20:31:36', NULL, NULL),
(94, 7, '20241020-0001', 'Hoo ', 'Kahapo ', 'Ngkurso', '09123456789', 'Buhawi', 'jaakeiwlqocamfka  jkdfasiefw ', '../uploads/55edc5c6a7b2d902ac10bab5712ed7b8.jpg', 'Santa Fe', 'Poblacion', 'Batiancila Street', 4, '2024-10-20 11:31:52', '2024-10-31 23:19:07', NULL, NULL),
(95, NULL, '20241031-0001', 'Uzumaki', 'Boruto', 'Nra', '09123456789', 'Sharni', 'fasdf', '../uploads/4408f11368a24533824dd227245aed06.jpg', 'Bantayan', 'Hilotongan', 'Fasdfsa', 5, '2024-10-31 15:55:06', '2024-10-31 19:10:42', NULL, NULL),
(96, 2, '20241031-0002', 'John ', 'Booker', 'Routledge', '09123828483', 'Flood', 'Theres a flood in outer banks', '../uploads/a31e3ab58e200804054a13d515b5e708.jpg', 'Bantayan', 'Sungko', 'Purok Lubi', 5, '2024-10-31 20:50:04', '2024-11-02 16:14:55', NULL, NULL),
(97, 12, '20241031-0003', 'Carrera', 'Kie', 'Jj', '09399573911', 'Fire', 'fadekakl', '../uploads/80d1371f24ffe454e9701e6c40a5ff44.jpg', 'Bantayan', 'Kabac', 'Fsd', 5, '2024-10-31 22:37:39', '2024-11-02 16:18:52', NULL, NULL),
(98, NULL, '20241102-0001', 'Pope', 'Ki', 'Bon', '09488429494', 'Tsunami', 'Hello ', '../uploads/42d1309f71c83459faf32116ca38525d.jpg', 'Santa Fe', 'Hilantagaan', 'Purok Manlot', 0, '2024-11-02 13:40:55', '2024-11-02 13:40:55', NULL, NULL),
(99, NULL, '20241102-0002', 'Je', 'Ri', 'Ko', '09294948294', 'Flood', 'no balance ', '../uploads/c95f045960df3f246b2986ab1004309b.jpg', 'Bantayan', 'Lipayran', 'Manlot Street', 5, '2024-11-02 15:57:59', '2024-11-02 16:18:46', NULL, NULL),
(100, NULL, '20241102-0003', 'Mi', 'A', 'MO', '09294948294', 'Flood', 'fadfe', '../uploads/5110f5eed8817a36d3652ac08659a96d.jpg', 'Bantayan', 'Hilotongan', 'Malot', 5, '2024-11-02 16:17:33', '2024-11-02 16:18:23', NULL, NULL),
(101, NULL, '20241104-0001', 'Ban', 'Toy', 'Layaog', '09343944303', 'Eartquake', 'hello can please help us because we are stranded here inside the building', '../uploads/61b5f8a88f657f1167e9a04a2c5fcdaf.jpeg', 'Bantayan', 'Guiwanon', 'Lumboy ', 0, '2024-11-04 16:46:14', '2024-11-04 21:24:59', NULL, NULL),
(102, 11, '20241104-0002', 'Totoy', 'Bibo', 'Otso', '09224710248', 'Baha', 'walang its a prank', '../uploads/4194bc5378233a2ba68237f085a7fab0.jpg', 'Bantayan', 'Doong', 'Purok Bantoy', 0, '2024-11-04 17:12:02', '2024-11-06 14:37:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  `municipality_id` int(11) DEFAULT NULL,
  `municipality_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`, `municipality_id`, `municipality_logo`) VALUES
(1, 'name', 'Online Fire Reporting System', NULL, NULL),
(6, 'short_name', 'BANTAYAN FIRE STATION', NULL, NULL),
(11, 'logo', 'uploads/logo.png?v=1730393452', NULL, NULL),
(13, 'user_avatar', 'uploads/user_avatar.jpg', NULL, NULL),
(14, 'cover', 'uploads/cover.png?v=1730032502', NULL, NULL),
(17, 'phone', '(032)420-9070', NULL, NULL),
(18, 'mobile', '09224048279', NULL, NULL),
(19, 'email', 'madridejosbfp@gmail.com', NULL, NULL),
(20, 'address', 'Poblacion, Madridejos, Cebu', NULL, NULL),
(21, 'facebook', 'https://bantayan-bfp.com/', NULL, NULL),
(24, 'district_logo_madridejos', 'uploads/district_logo_madridejos.jpg', NULL, NULL),
(25, 'district_logo_bantayan', 'uploads/district_logo_bantayan.jpg', NULL, NULL),
(26, 'district_logo_stafe', 'uploads/santafe_logo.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_list`
--

CREATE TABLE `team_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `district` varchar(255) DEFAULT NULL,
  `leader_name` text NOT NULL,
  `leader_contact` text NOT NULL,
  `members` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `municipality` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_list`
--

INSERT INTO `team_list` (`id`, `code`, `district`, `leader_name`, `leader_contact`, `members`, `delete_flag`, `date_created`, `date_updated`, `municipality`) VALUES
(2, 'F-1014', 'Bantayan', 'Johnny Deep', '09654789123', 'Member 101, Member 102, Member 103, Member 104', 0, '2022-05-21 09:44:15', '2024-10-01 09:16:36', NULL),
(7, 'K-043135', 'Santa Fe', 'Roger', '09358275838', 'Red Hair, Marco, Ace, White Beard', 0, '2024-07-15 21:18:36', '2024-09-11 15:45:47', NULL),
(9, 'RJ-45', 'Santa Fe', 'Trafalgar', '09122222222', 'BIPO, CHOPPER, USOP, ZORO', 0, '2024-10-15 09:39:53', '2024-10-15 09:39:53', NULL),
(10, 'BR-93', 'Madridejos', 'Boyaks', '09282819582', 'Ace, Gon, Kin, Yas', 0, '2024-10-15 12:00:47', '2024-10-15 12:00:47', NULL),
(11, '75-VP', 'Bantayan', 'VEGAPUNK', '09318924723', 'VP0, VP1, VP2, VP3', 0, '2024-10-15 20:00:20', '2024-10-15 20:00:20', NULL),
(12, 'M-41', 'Bantayan', 'PJ', '09832957328', 'P1, P2, P3, P4', 0, '2024-10-17 06:42:52', '2024-10-17 06:42:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `district` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `district`, `email`, `password`, `reset_token`, `token_expiry`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`, `otp_code`, `otp_expiry`, `role`) VALUES
(10, 'Bantayan ', '', 'BFP', 'Bantayan-RVII', 'Bantayan', 'bantayanbfp@gmail.com', '2e7c98c8bc62d3ba105faaa51eba2d3e', NULL, NULL, 'uploads/avatars/10.png?v=1730373976', NULL, 1, '2024-10-06 22:16:59', '2024-10-31 19:26:16', NULL, NULL, NULL),
(11, 'Madridejos', '', 'BFP', 'Madridejos-RVII', 'Madridejos', 'madridejosbfp@gmail.com', '33f52a03489d9611e00bfe954e2a71fa', NULL, NULL, 'uploads/avatars/11.png?v=1728224493', NULL, 1, '2024-10-06 22:21:33', '2024-10-31 19:29:16', NULL, NULL, NULL),
(12, 'SantaFe', '', 'BFP', 'SantaFe-RVII', 'Santa Fe', 'santafebfp@gmail.com', '6876f7176bfb68c41c1793c9ce0becd1', NULL, NULL, 'uploads/avatars/12.png?v=1730393364', NULL, 1, '2024-10-06 22:24:28', '2024-11-01 00:49:24', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events_list`
--
ALTER TABLE `events_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_list`
--
ALTER TABLE `history_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_list`
--
ALTER TABLE `request_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id_fk_rl` (`team_id`),
  ADD KEY `idx_deleted_reports` (`deleted_reports`(768));

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_list`
--
ALTER TABLE `team_list`
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
-- AUTO_INCREMENT for table `events_list`
--
ALTER TABLE `events_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `history_list`
--
ALTER TABLE `history_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_list`
--
ALTER TABLE `request_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `team_list`
--
ALTER TABLE `team_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_list`
--
ALTER TABLE `history_list`
  ADD CONSTRAINT `request_id_fh_hl` FOREIGN KEY (`request_id`) REFERENCES `request_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `request_list`
--
ALTER TABLE `request_list`
  ADD CONSTRAINT `team_id_fk_rl` FOREIGN KEY (`team_id`) REFERENCES `team_list` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"ofrs_db\",\"table\":\"users\"},{\"db\":\"ofrs_db\",\"table\":\"events_list\"},{\"db\":\"ofrs_db\",\"table\":\"officers\"},{\"db\":\"ofrs_db\",\"table\":\"team_list\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-11-28 23:02:08', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
