-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2024 at 03:43 AM
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
-- Database: `quiz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `category_name` varchar(222) NOT NULL,
  `base_points` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `event_id`, `category_name`, `base_points`, `date_added`, `archive`) VALUES
(413, 145, 'Easy', 10, '2024-06-17', 0),
(414, 145, 'Medium', 20, '2024-06-17', 0),
(415, 145, 'Hard', 30, '2024-06-17', 0),
(420, 145, 'Tie Breaker', 50, '2024-06-17', 0),
(427, 146, 'Easy', 20, '2024-06-18', 0),
(428, 146, 'Hard', 50, '2024-06-18', 0),
(429, 147, 'Easy', 50, '2024-06-19', 0),
(430, 147, 'Meduim', 100, '2024-06-19', 0),
(431, 147, 'Hard', 150, '2024-06-19', 0),
(432, 147, 'Tie Breaker', 200, '2024-06-19', 0),
(433, 151, 'Easy', 10, '2024-06-20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `question_image` varchar(1000) DEFAULT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `choice_1` varchar(255) DEFAULT NULL,
  `choice_2` varchar(255) DEFAULT NULL,
  `choice_3` varchar(255) DEFAULT NULL,
  `choice_4` varchar(255) DEFAULT NULL,
  `timer` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `archive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question_type`, `question_image`, `correct_answer`, `choice_1`, `choice_2`, `choice_3`, `choice_4`, `timer`, `status`, `archive`) VALUES
(184, 413, 'Multiple Choice', 'uploads/E1.JPG', 'Paris', 'Berlin', 'Madrid', 'Paris', 'Rome', '00:00:10', 2, 0),
(185, 413, 'Multiple Choice', 'uploads/E2.JPG', '4', '3', '4', '5', '6', '00:00:30', 2, 0),
(186, 414, 'Multiple Choice', 'uploads/M1.JPG', 'Mars', 'Earth', 'Mars', 'Jupiter', 'Venus', '00:00:30', 2, 0),
(187, 414, 'Multiple Choice', 'uploads/M2.JPG', 'Skin', 'Heart', 'Liver', 'Skin', 'Lungs', '00:00:02', 2, 0),
(188, 415, 'Multiple Choice', 'uploads/H1.JPG', 'Albert Einstein', 'Isaac Newton', 'Nikola Tesla', 'Albert Einstein', 'Galileo Galilei', '00:00:30', 2, 0),
(189, 415, 'Multiple Choice', 'uploads/H2.JPG', 'Au', 'Au', 'Ag', 'Pb', 'Fe', '00:00:30', 2, 0),
(190, 420, 'Multiple Choice', 'uploads/T1.JPG', '53', '51', '53', '59', '61', '00:00:05', 2, 0),
(191, 427, 'Multiple Choice', 'uploads/E1.JPG', 'Paris', 'Paris', 'Bangkok', 'Madrid', 'Washington', '00:00:10', 2, 0),
(192, 428, 'Multiple Choice', 'uploads/M1.JPG', 'Mars', 'Earth', 'Venus', 'Kelper 22b', 'Mars', '00:00:10', 0, 0),
(193, 429, 'Multiple Choice', 'uploads/H2.JPG', 'Mars', 'Earth', 'Pluto', 'Moon', 'Mars', '00:00:20', 0, 0),
(194, 433, 'Multiple Choice', 'uploads/E1.JPG', 'Paris', 'Manila', 'Jakarta', 'Paris', 'Taipe', '00:00:20', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_event`
--

CREATE TABLE `quiz_event` (
  `id` bigint(20) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `quizmaster_code` varchar(50) NOT NULL,
  `participant_code` varchar(50) NOT NULL,
  `audience_code` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `status` smallint(11) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `url_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_event`
--

INSERT INTO `quiz_event` (`id`, `event_title`, `quizmaster_code`, `participant_code`, `audience_code`, `date`, `status`, `userID`, `url_address`) VALUES
(145, 'Database Quiz Bee', 'QMyv03yzb8j', 'PCvafvbovjl', 'AC267axvpkr', '2024-06-17 04:04:24', 3, 12, '43PBAoSRo3MKAUYDo1gKxdBw9RgSAeCUZNO'),
(146, 'SAP Quiz Bee', 'QMavgnsj5n3', 'PCr8w65walu', 'ACp48g6zhim', '2024-06-18 01:01:07', 3, 12, 'SHfORKYiVwj3KrJeC0VP'),
(147, 'Java Quiz', 'QM43svisf8r', 'PCa8cgsb51x', 'AC84kwcvq7c', '2024-06-19 13:27:54', 1, 12, 'VgMYsYyoX44vIjILV5fWke69wTSswjBCxlyrRo9'),
(150, 'QQ', 'QMb15dd6uh9', 'PCuwii5juwd', 'ACd7245vtt0', '2024-06-20 03:10:05', 0, 28, 'RXZckTzMLMlmTKm1ABdLNDKX6Vq2eAn7FgEjOkiG0s7GsTxqvsfmb'),
(151, 'ICT Quiz', 'QMlcya1a72k', 'PCk1f6ox8qf', 'ACrsbss32af', '2024-06-20 03:25:35', 1, 30, 'RwgO7LlgtsdzupU1CtfBYc9rJ5ai9zwxriA3tKxHwc8lr7Lt2Xovs');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_master`
--

CREATE TABLE `quiz_master` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `quizmaster_name` varchar(255) NOT NULL,
  `url_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_master`
--

INSERT INTO `quiz_master` (`id`, `event_id`, `quizmaster_name`, `url_address`) VALUES
(91, 146, '1', 'y5qcvhw7KXBrJxlXGydheCJrCF6G28bBzKm'),
(92, 145, '1', 'ZqTnx2J2xM4JZawrhw5QakPenaeqoVzFEE7qRwySk'),
(93, 151, 'Juan Tamad', 'dB2ZYMU1AD64AKrLwD5WXBEwWWIbWtwBJ7fFQoS7Ivyof4U9ireD9VqAnLnM');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `team_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `event_id`, `team_name`) VALUES
(61, 145, 'Fairy Tail'),
(63, 145, 'Shadow Garden'),
(65, 145, 'Full Stack'),
(66, 145, 'Front'),
(67, 146, 'Shadow Garden'),
(70, 146, '1'),
(71, 151, 'Jun Jun');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) NOT NULL,
  `team_id` bigint(20) NOT NULL,
  `team_member` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `team_id`, `team_member`) VALUES
(49, 63, 'Delta'),
(50, 63, 'Alpha'),
(53, 65, 'Pedro'),
(54, 65, 'Maria'),
(55, 66, 'Buboy'),
(56, 67, 'Alpha'),
(57, 67, 'Popo'),
(60, 70, '1'),
(61, 71, 'Jon jon'),
(62, 71, 'Jonel');

-- --------------------------------------------------------

--
-- Table structure for table `team_score`
--

CREATE TABLE `team_score` (
  `id` bigint(20) NOT NULL,
  `team_id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_score`
--

INSERT INTO `team_score` (`id`, `team_id`, `question_id`, `score`) VALUES
(137, 65, 186, 0),
(138, 66, 184, 10),
(139, 66, 190, 50),
(140, 66, 185, 10),
(141, 66, 186, 20),
(142, 66, 187, 20),
(143, 66, 188, 30),
(144, 66, 189, 30),
(145, 67, 191, 20),
(146, 71, 194, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `url_address` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `email`, `password`, `url_address`, `date`) VALUES
(12, 'Organizer', 'organizer@gmail.com', '@12345678', 'ZVWqqwcipXsqgOKZ2fjzgU8BJQ65j', '2024-06-17 04:03:00'),
(27, 'reynald', 'reynald@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Gv87WQpAl', '2024-06-19 23:51:52'),
(28, 'Organizers', 'oraganizers@gmail.com', '63157ec36ea28fc3c65ddcd4067e6b11', '9wGcRKcj', '2024-06-20 02:29:42'),
(30, 'Organizer 1', 'organizer1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'lkLcqFLaZRnuWLJ7fow1R3h3AESu3liNBQ', '2024-06-20 03:22:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category_Quiz_Event` (`event_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Questions_Category` (`category_id`);

--
-- Indexes for table `quiz_event`
--
ALTER TABLE `quiz_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Quiz_Event_User` (`userID`);

--
-- Indexes for table `quiz_master`
--
ALTER TABLE `quiz_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Quiz_Master_Quiz_Event` (`event_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Team_Quiz_Event` (`event_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Team_Members_Team` (`team_id`);

--
-- Indexes for table `team_score`
--
ALTER TABLE `team_score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Team_Score_Team` (`team_id`),
  ADD KEY `Team_Score_Questions` (`question_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Url_Address` (`url_address`),
  ADD KEY `User_Name` (`username`),
  ADD KEY `Password` (`password`),
  ADD KEY `Date` (`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `quiz_event`
--
ALTER TABLE `quiz_event`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `quiz_master`
--
ALTER TABLE `quiz_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `team_score`
--
ALTER TABLE `team_score`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `Category_Quiz_Event` FOREIGN KEY (`event_id`) REFERENCES `quiz_event` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `Questions_Category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `quiz_event`
--
ALTER TABLE `quiz_event`
  ADD CONSTRAINT `Quiz_Event_User` FOREIGN KEY (`userID`) REFERENCES `user_account` (`id`);

--
-- Constraints for table `quiz_master`
--
ALTER TABLE `quiz_master`
  ADD CONSTRAINT `Quiz_Master_Quiz_Event` FOREIGN KEY (`event_id`) REFERENCES `quiz_event` (`id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `Team_Quiz_Event` FOREIGN KEY (`event_id`) REFERENCES `quiz_event` (`id`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `Team_Members_Team` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);

--
-- Constraints for table `team_score`
--
ALTER TABLE `team_score`
  ADD CONSTRAINT `Team_Score_Questions` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `Team_Score_Team` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
