-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2025 at 07:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accomodation`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `role` enum('user','owner','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `bio`, `avatar`, `is_active`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Système', 'admin@hebergement.cm', '+237 677 00 00 00', NULL, NULL, 1, 'admin', NULL, '$2y$12$lGE8VSk41tg6op7fXCZNHOyffw9.L0BIeqti4PHA8X2lwQc1g6HAu', NULL, '2025-12-05 20:41:24', '2025-12-05 20:41:24'),
(2, 'Hôtel du Plateau', 'plateau@hebergement.cm', '+237 677 11 11 11', 'Hôtel de luxe au cœur de Ngaoundéré', NULL, 1, 'owner', NULL, '$2y$12$QxeH9ddfv5huGQ10DaHRf.pnyvucvTwR5K2ehZKioXZXO0x6NDLd6', NULL, '2025-12-05 20:41:24', '2025-12-05 20:41:24'),
(3, 'Auberge Mardock', 'mardock@hebergement.cm', '+237 677 22 22 22', 'Auberge conviviale et abordable', NULL, 1, 'owner', NULL, '$2y$12$7xwxZpykOHhXpDwui0U1fe4YTZV0qPT3pcfJ59HIPfllSdDyvReLS', NULL, '2025-12-05 20:41:24', '2025-12-05 20:41:24'),
(4, 'Jean Dupont', 'jean@example.com', '+237 677 33 33 33', NULL, NULL, 1, 'user', NULL, '$2y$12$yAGuiTWbvybAc32zjQRW3uRPrXeu0A66l5drzq4.BHXij4B1.oKca', NULL, '2025-12-05 20:41:25', '2025-12-05 20:41:25'),
(5, 'EvoDev', 'calebyangcyd@gmail.com', '+237698448024', NULL, 'avatars/NrepIZ8HmdtPLTSZDTUjHhtcNSGyOCxP1QnQdhuy.jpg', 1, 'user', NULL, '$2y$12$IxXoOOT8DxIAf9hoU11vtO.CeTt7XUdFaQ.77m8ZojhdWgK6EzJ7O', NULL, '2025-12-05 21:29:49', '2025-12-05 21:30:18'),
(6, 'Mutuelle MIUT', 'yangdamakoacaleb@gmail.com', '+237699885521', 'my name is useless', 'avatars/Ql7SLgywWSiTUAWX3C8wF7rekbqVhVBI0eLn51ns.jpg', 1, 'owner', NULL, '$2y$12$9hbUk/MvuqezmpYtRdOJWeL22vMJcb//i16fqABWnmnU0SnEe7cgy', NULL, '2025-12-06 07:30:03', '2025-12-09 06:21:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_is_active_index` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
