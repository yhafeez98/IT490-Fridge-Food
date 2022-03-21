-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2022 at 10:28 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `test_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `is_active` int(11) NOT NULL,
                            `created_at` datetime DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuisines`
--

INSERT INTO `cuisines` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
                                                                                   (1, 'Indian', 1, '2022-03-20 19:13:41', '2022-03-20 19:13:41'),
                                                                                   (2, 'Chinese', 1, '2022-03-20 19:13:41', '2022-03-20 19:13:41'),
                                                                                   (3, 'Italian', 1, '2022-03-20 19:13:41', '2022-03-20 19:13:41'),
                                                                                   (4, 'French', 1, '2022-03-20 19:13:41', '2022-03-20 19:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `favourite_recipe`
--

CREATE TABLE `favourite_recipe` (
                                    `id` int(11) NOT NULL,
                                    `recipe_id` int(11) NOT NULL,
                                    `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
                           `id` bigint(20) UNSIGNED NOT NULL,
                           `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `ready_in_minutes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `summary` text COLLATE utf8mb4_unicode_ci,
                           `servings` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `cuisines` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `user_id` int(11) DEFAULT NULL,
                           `status` int(11) DEFAULT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `email` varchar(500) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `created_at` datetime NOT NULL,
                         `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
                                                                                        (1, 'admin', 'admin@admin.com', 'admin', '2022-03-20 18:42:18', '2022-03-20 18:42:18'),
                                                                                        (2, 'Fitzgerald Rush', 'dipopat@mailinator.com', 'password', '2022-03-20 19:52:30', '2022-03-20 19:52:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite_recipe`
--
ALTER TABLE `favourite_recipe`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
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
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favourite_recipe`
--
ALTER TABLE `favourite_recipe`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
