-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 15, 2025 at 02:56 PM
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
-- Database: `c2c_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`profile_id`, `user_id`, `phone`, `address`, `status`) VALUES
(1, 1, '90094517', 'Boon Lay', 'active'),
(2, 4, '87651234', 'Hougang ', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cleaner_profiles`
--

CREATE TABLE `cleaner_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `preferred_cleaning_time` enum('morning','afternoon','evening') NOT NULL,
  `cleaning_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `expertise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleaner_profiles`
--

INSERT INTO `cleaner_profiles` (`profile_id`, `user_id`, `phone`, `address`, `experience`, `preferred_cleaning_time`, `cleaning_frequency`, `language_preference`, `rating`, `status`, `expertise`) VALUES
(2, 2, '91213343', 'Sengkang Ave 12', '5 years', 'evening', 'weekly', 'tamil', 5.0, 'active', 1),
(3, 8, '87651234', 'Clementi Ave 8', '2 years', 'evening', 'monthly', 'mandarin', 3.5, 'active', 4),
(5, 9, '98761234', 'Jurong West', '3 years', 'morning', 'weekly', 'english', 4.0, 'active', 3),
(6, 10, '87651234', 'Toa Payoh', '3 years', 'evening', 'biweekly', 'english', 4.5, 'active', 2),
(7, 16, '88779901', 'Lakeside', '2.5 years', 'morning', 'weekly', 'english', 3.5, 'active', 5);

-- --------------------------------------------------------

--
-- Table structure for table `cleaning_services`
--

CREATE TABLE `cleaning_services` (
  `job_id` int(11) NOT NULL,
  `cleaner_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('offered','suspended') NOT NULL DEFAULT 'offered',
  `views` int(11) NOT NULL DEFAULT 0,
  `shortlisted` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleaning_services`
--

INSERT INTO `cleaning_services` (`job_id`, `cleaner_id`, `title`, `description`, `price`, `status`, `views`, `shortlisted`, `category_id`) VALUES
(1, 2, 'Dog grooming', 'Stress free & gentle experience', 50.00, 'offered', 3, 0, 1),
(2, 2, 'Cat grooming', 'Stress free & gentle experience', 50.00, 'offered', 2, 0, 1),
(3, 10, 'High rise window cleaning ', 'Cleaning of high rise window', 30.00, 'offered', 3, 0, 2),
(4, 2, 'Formal wear ironing', 'Blazer or gown ', 30.00, 'offered', 2, 0, 5),
(5, 9, 'Wooden Furniture ', 'Shine your wooden furniture ', 45.00, 'offered', 2, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_jobs`
--

CREATE TABLE `confirmed_jobs` (
  `match_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `cleaner_id` int(11) NOT NULL,
  `homeowner_id` int(11) NOT NULL,
  `matched_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `status` enum('confirmed','completed') NOT NULL DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confirmed_jobs`
--

INSERT INTO `confirmed_jobs` (`match_id`, `job_id`, `cleaner_id`, `homeowner_id`, `matched_date`, `completion_date`, `status`) VALUES
(1, 3, 10, 3, '2025-05-12', '2025-05-12', 'completed'),
(2, 2, 2, 11, '2025-05-12', '2025-05-12', 'completed'),
(3, 1, 2, 11, '2025-05-12', '2025-05-13', 'completed'),
(4, 3, 10, 11, '2025-05-12', '2025-05-13', 'completed'),
(5, 4, 2, 12, '2025-05-12', '2025-05-13', 'completed'),
(6, 3, 10, 14, '2025-05-13', '2025-05-14', 'completed'),
(7, 5, 9, 14, '2025-05-14', '2025-05-14', 'completed'),
(10, 1, 2, 3, '2025-05-15', '2025-05-15', 'completed'),
(11, 5, 9, 12, '2025-05-15', '2025-05-15', 'completed'),
(12, 5, 9, 12, '2025-05-15', NULL, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `homeowner_id` int(11) NOT NULL,
  `cleaner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `homeowner_id`, `cleaner_id`) VALUES
(22, 3, 2),
(23, 3, 10),
(18, 12, 2),
(19, 12, 8),
(20, 12, 9),
(24, 14, 2),
(21, 14, 9);

-- --------------------------------------------------------

--
-- Table structure for table `homeowner_profiles`
--

CREATE TABLE `homeowner_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` varchar(50) NOT NULL,
  `preferred_cleaning_time` enum('morning','afternoon','evening') NOT NULL,
  `cleaning_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homeowner_profiles`
--

INSERT INTO `homeowner_profiles` (`profile_id`, `user_id`, `phone`, `address`, `preferred_cleaning_time`, `cleaning_frequency`, `language_preference`, `status`) VALUES
(6, 3, '87879090', 'Jurong east', 'afternoon', 'monthly', 'english', 'active'),
(7, 12, '90124321', 'Kallang', 'evening', 'weekly', 'english', 'active'),
(8, 11, '90124321', 'Lorong Chuan', 'evening', 'weekly', 'mandarin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `manager_profiles`
--

CREATE TABLE `manager_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_profiles`
--

INSERT INTO `manager_profiles` (`profile_id`, `user_id`, `phone`, `address`, `status`) VALUES
(1, 4, '90890987', 'Serangoon ', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`category_id`, `name`, `description`, `status`) VALUES
(1, 'Pet grooming', 'Dedicated for all pet lovers', 'active'),
(2, 'Window cleaning', 'High rise window cleaning', 'active'),
(3, 'Furniture cleaning', 'All types of furniture', 'active'),
(4, 'Mopping ', 'Small to medium house size ', 'active'),
(5, 'Ironing ', 'Any type of clothes of ironing service', 'active'),
(6, 'Car wash', 'Exterior cleaning only', 'active'),
(7, 'Pet grooming', 'Dedicated for all pet lovers', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `service_views`
--

CREATE TABLE `service_views` (
  `view_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `homeowner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_views`
--

INSERT INTO `service_views` (`view_id`, `job_id`, `homeowner_id`) VALUES
(1, 1, 3),
(3, 1, 11),
(11, 1, 14),
(2, 2, 3),
(4, 2, 11),
(5, 3, 3),
(6, 3, 11),
(8, 3, 14),
(7, 4, 12),
(12, 4, 14),
(10, 5, 12),
(9, 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `shortlists`
--

CREATE TABLE `shortlists` (
  `shortlist_id` int(11) NOT NULL,
  `homeowner_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shortlists`
--

INSERT INTO `shortlists` (`shortlist_id`, `homeowner_id`, `job_id`) VALUES
(3, 3, 1),
(4, 3, 2),
(5, 3, 3),
(2, 11, 1),
(1, 11, 2),
(6, 12, 4),
(8, 12, 5),
(7, 14, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','cleaner','homeowner','manager') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Ridhwan', 'Ridhwanp@gmail.com', 'Pass12345', 'admin', 'active'),
(2, 'Angelica', 'Angelica@gmail.com', 'Pass1234', 'cleaner', 'active'),
(3, 'Phoo', 'Phoo@gmail.com', 'Pass1234', 'homeowner', 'active'),
(4, 'Mei Yuen', 'My@gmail.com', 'Pass1234', 'manager', 'active'),
(5, 'Harshita', 'Harshita@gmail.com', 'Pass1234', 'admin', 'active'),
(8, 'Cleaner2', 'Cleaner2@gmail.com', 'Pass1234', 'cleaner', 'active'),
(9, 'Waldo', 'Waldo@gmail.com', 'Pass1234', 'cleaner', 'active'),
(10, 'John', 'John@gmail.com', 'Pass1234', 'cleaner', 'active'),
(11, 'Harry', 'Harryp@gmail.com', 'Pass1234', 'homeowner', 'active'),
(12, 'Ronald', 'Ronald@gmail.com', 'Pass1234', 'homeowner', 'active'),
(13, 'Paul', 'Paul@gmail.com', 'Pass1234', 'cleaner', 'active'),
(14, 'Wilson', 'Wilson@gmail.com', 'Pass1234', 'homeowner', 'active'),
(16, 'Tim', 'Tim@gmail.com', 'Pass1234', 'cleaner', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_cleaner_profiles_expertise` (`expertise`);

--
-- Indexes for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `cleaner_id` (`cleaner_id`),
  ADD KEY `cleaning_services_ibfk_2` (`category_id`);

--
-- Indexes for table `confirmed_jobs`
--
ALTER TABLE `confirmed_jobs`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `cleaner_id` (`cleaner_id`),
  ADD KEY `homeowner_id` (`homeowner_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `unique_favorite` (`homeowner_id`,`cleaner_id`),
  ADD KEY `cleaner_id` (`cleaner_id`);

--
-- Indexes for table `homeowner_profiles`
--
ALTER TABLE `homeowner_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `service_views`
--
ALTER TABLE `service_views`
  ADD PRIMARY KEY (`view_id`),
  ADD UNIQUE KEY `job_id` (`job_id`,`homeowner_id`),
  ADD KEY `homeowner_id` (`homeowner_id`);

--
-- Indexes for table `shortlists`
--
ALTER TABLE `shortlists`
  ADD PRIMARY KEY (`shortlist_id`),
  ADD UNIQUE KEY `homeowner_id` (`homeowner_id`,`job_id`),
  ADD KEY `shortlists_ibfk_2` (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `confirmed_jobs`
--
ALTER TABLE `confirmed_jobs`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `homeowner_profiles`
--
ALTER TABLE `homeowner_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_views`
--
ALTER TABLE `service_views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shortlists`
--
ALTER TABLE `shortlists`
  MODIFY `shortlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  ADD CONSTRAINT `cleaner_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cleaner_profiles_expertise` FOREIGN KEY (`expertise`) REFERENCES `service_categories` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  ADD CONSTRAINT `cleaning_services_ibfk_1` FOREIGN KEY (`cleaner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cleaning_services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `confirmed_jobs`
--
ALTER TABLE `confirmed_jobs`
  ADD CONSTRAINT `confirmed_jobs_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `cleaning_services` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmed_jobs_ibfk_2` FOREIGN KEY (`cleaner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmed_jobs_ibfk_3` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`cleaner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homeowner_profiles`
--
ALTER TABLE `homeowner_profiles`
  ADD CONSTRAINT `homeowner_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  ADD CONSTRAINT `manager_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_views`
--
ALTER TABLE `service_views`
  ADD CONSTRAINT `service_views_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `cleaning_services` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_views_ibfk_2` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shortlists`
--
ALTER TABLE `shortlists`
  ADD CONSTRAINT `shortlists_ibfk_1` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shortlists_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `cleaning_services` (`job_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
