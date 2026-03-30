-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 10:27 AM
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
-- Database: `lost_found`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` enum('lost','found') NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `date_reported` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_resolved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_approved` tinyint(1) DEFAULT 0,
  `contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `title`, `description`, `category`, `status`, `location`, `date_reported`, `image`, `is_resolved`, `created_at`, `is_approved`, `contact`) VALUES
(4, 3, 'walpaper', '', 'Other', 'found', 'adbu', '2026-03-05', 'img_69a979b7688a7.png', 0, '2026-03-05 12:40:23', 1, NULL),
(9, 3, 'chip', 'silver', 'Electronics', 'found', 'panbazar', '2026-03-05', 'img_69a98deead4b0.png', 0, '2026-03-05 14:06:38', 1, '512463'),
(10, 3, 'bell', '', '', 'lost', '', '2026-03-05', '', 0, '2026-03-05 14:16:26', 0, ''),
(11, 2, 'watch', 'silver and orange apple watch', 'Electronics', 'lost', 'adbu room 204', '2026-03-05', 'img_69a992a134a15.jpg', 0, '2026-03-05 14:26:41', 1, '741258963');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 1, 'A new item has been reported: aemeath', 'http://localhost/lost_found/index.php', 0, '2026-03-05 14:04:49'),
(2, 3, 'A new item has been reported: aemeath', 'http://localhost/lost_found/index.php', 1, '2026-03-05 14:04:49'),
(4, 1, 'A new item has been reported: chip', 'http://localhost/lost_found/index.php', 0, '2026-03-05 14:06:38'),
(5, 2, 'A new item has been reported: chip', 'http://localhost/lost_found/index.php', 1, '2026-03-05 14:06:38'),
(7, 1, 'A new item has been reported: bell', 'http://localhost/lost_found/index.php', 0, '2026-03-05 14:16:26'),
(8, 2, 'A new item has been reported: bell', 'http://localhost/lost_found/index.php', 1, '2026-03-05 14:16:26'),
(10, 1, 'A new item has been reported: watch', 'http://localhost/lost_found/index.php', 0, '2026-03-05 14:26:41'),
(11, 3, 'A new item has been reported: watch', 'http://localhost/lost_found/index.php', 0, '2026-03-05 14:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@lostfound.com', 'admin', 'admin', '2026-03-05 06:05:16'),
(2, 'admin1', 'admin@gmail.com', '$2y$10$foMiGr7EC5hBtX3yc9ueS.N6iTi/O8/98wijWnik2ggU2OiVZOr.e', 'admin', '2026-03-05 06:07:55'),
(3, 'user1', 'user@gmail.com', '$2y$10$wn6M3h54OSHeUrUJuQaNYev4/CW7YJl9WWM/DWW3shgDr8qclILzy', 'user', '2026-03-05 06:09:42'),
(5, 'user2', 'copycap92@gmail.com', '$2y$10$JK8VNeR3nJFJBMuvDZQPnOEhwQYHDpSf453Hr8IsnYuPyxpiWYcOG', 'user', '2026-03-29 10:21:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
