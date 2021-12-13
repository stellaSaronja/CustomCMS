-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2021 at 04:47 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `custom_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `payment_type`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(0, 2, 'aasdfsdf', '', '140.00', '2021-12-03 23:52:47', '2021-12-03 23:52:47', NULL),
(0, 2, 'aasdfsdf', '', '140.00', '2021-12-03 23:54:44', '2021-12-03 23:54:44', NULL),
(0, 2, 'aasdfsdf', '', '140.00', '2021-12-03 23:56:32', '2021-12-03 23:56:32', NULL),
(0, 2, 'aasdfsdf', '', '140.00', '2021-12-03 23:59:10', '2021-12-03 23:59:10', NULL),
(0, 2, 'aasdfsdf', '', '140.00', '2021-12-04 00:03:19', '2021-12-04 00:03:19', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 00:07:00', '2021-12-04 00:07:00', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 00:10:39', '2021-12-04 00:10:39', NULL),
(0, 2, 'aasdfsdf', '', '23.00', '2021-12-04 00:12:36', '2021-12-04 00:12:36', NULL),
(0, 2, 'aasdfsdf', '', '23.00', '2021-12-04 00:17:29', '2021-12-04 00:17:29', NULL),
(0, 2, 'aasdfsdf', '', '23.00', '2021-12-04 00:18:43', '2021-12-04 00:18:43', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:49:29', '2021-12-04 12:49:29', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:49:42', '2021-12-04 12:49:42', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:49:51', '2021-12-04 12:49:51', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:51:29', '2021-12-04 12:51:29', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:52:06', '2021-12-04 12:52:06', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:52:14', '2021-12-04 12:52:14', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:52:29', '2021-12-04 12:52:29', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:52:41', '2021-12-04 12:52:41', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:52:52', '2021-12-04 12:52:52', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:53:13', '2021-12-04 12:53:13', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:53:24', '2021-12-04 12:53:24', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:53:41', '2021-12-04 12:53:41', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:53:54', '2021-12-04 12:53:54', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:54:10', '2021-12-04 12:54:10', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:54:33', '2021-12-04 12:54:33', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:54:41', '2021-12-04 12:54:41', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:54:55', '2021-12-04 12:54:55', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:56:07', '2021-12-04 12:56:07', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:56:30', '2021-12-04 12:56:30', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:57:07', '2021-12-04 12:57:07', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:57:13', '2021-12-04 12:57:13', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:57:27', '2021-12-04 12:57:27', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:57:39', '2021-12-04 12:57:39', NULL),
(0, 2, 'aasdfsdf', '', '46.00', '2021-12-04 12:57:52', '2021-12-04 12:57:52', NULL),
(0, 2, 'aasdfsdf', '', '23.00', '2021-12-04 15:44:41', '2021-12-04 15:44:41', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-05 15:38:12', '2021-12-05 15:38:12', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-05 15:42:28', '2021-12-05 15:42:28', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-05 15:42:53', '2021-12-05 15:42:53', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 11:58:05', '2021-12-06 11:58:05', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 11:58:13', '2021-12-06 11:58:13', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 11:59:19', '2021-12-06 11:59:19', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:16:44', '2021-12-06 20:16:44', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:18:37', '2021-12-06 20:18:37', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:18:42', '2021-12-06 20:18:42', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:22:19', '2021-12-06 20:22:19', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:22:45', '2021-12-06 20:22:45', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:22:57', '2021-12-06 20:22:57', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:23:36', '2021-12-06 20:23:36', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-06 20:24:05', '2021-12-06 20:24:05', NULL),
(0, 2, 'Landstraße', '', '23.00', '2021-12-11 18:18:58', '2021-12-11 18:18:58', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-11 18:21:11', '2021-12-11 18:21:11', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-11 18:21:16', '2021-12-11 18:21:16', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-11 18:22:24', '2021-12-11 18:22:24', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-11 18:22:36', '2021-12-11 18:22:36', NULL),
(0, 2, 'Landstraße', '', '20.00', '2021-12-11 18:22:39', '2021-12-11 18:22:39', NULL),
(0, 2, 'Landstraße', '', '46.00', '2021-12-13 12:13:19', '2021-12-13 12:13:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 2, 2, '23.00', '2021-12-04 00:03:19', '2021-12-04 00:03:19', NULL),
(2, 0, 4, 1, '25.00', '2021-12-04 00:03:19', '2021-12-04 00:03:19', NULL),
(3, 0, 3, 3, '23.00', '2021-12-04 00:03:19', '2021-12-04 00:03:19', NULL),
(4, 0, 2, 2, '23.00', '2021-12-04 00:07:00', '2021-12-04 00:07:00', NULL),
(5, 0, 2, 2, '23.00', '2021-12-04 00:10:39', '2021-12-04 00:10:39', NULL),
(6, 0, 2, 1, '23.00', '2021-12-04 00:12:36', '2021-12-04 00:12:36', NULL),
(7, 0, 2, 1, '23.00', '2021-12-04 00:17:29', '2021-12-04 00:17:29', NULL),
(8, 0, 2, 1, '23.00', '2021-12-04 12:49:30', '2021-12-04 12:49:30', NULL),
(9, 0, 3, 1, '23.00', '2021-12-04 12:49:30', '2021-12-04 12:49:30', NULL),
(10, 0, 2, 1, '23.00', '2021-12-04 15:44:41', '2021-12-04 15:44:41', NULL),
(11, 0, 6, 1, '20.00', '2021-12-05 15:38:12', '2021-12-05 15:38:12', NULL),
(12, 0, 3, 1, '23.00', '2021-12-05 15:42:28', '2021-12-05 15:42:28', NULL),
(13, 0, 2, 1, '23.00', '2021-12-06 11:58:06', '2021-12-06 11:58:06', NULL),
(14, 0, 2, 1, '23.00', '2021-12-06 11:59:19', '2021-12-06 11:59:19', NULL),
(15, 0, 3, 1, '23.00', '2021-12-06 20:16:44', '2021-12-06 20:16:44', NULL),
(16, 0, 2, 1, '23.00', '2021-12-11 18:18:58', '2021-12-11 18:18:58', NULL),
(17, 0, 1, 1, '20.00', '2021-12-11 18:21:11', '2021-12-11 18:21:11', NULL),
(18, 0, 2, 2, '23.00', '2021-12-13 12:13:19', '2021-12-13 12:13:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `images` longtext NOT NULL DEFAULT '\'[]\'',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `images`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Magnolia', 'Magnolia tote bag is a simple, yet stylish bag for your everyday life. The simplicity makes it look good with every outfit. Whether you are grocery shopping or out on a picnic, this bag does it all.', 'Tote bags', '20.00', 'magnolia.jpg', '2021-11-28 16:10:57', '2021-12-13 15:46:01', '2021-12-13 15:46:01'),
(2, 'Outlined face', 'This tote bag has an outlined face drawn on it. It depicts the beauty of humans in a simple yet beautiful drawing. This bag is perfect for accompanying you in your everyday life.', 'Tote bags', '23.00', 'face.jpg', '2021-11-28 16:14:45', '2021-12-11 18:00:01', NULL),
(3, 'Librarian', 'Librarian tote bag is a simple bag with a statement. Whether you´re a bookworm, a fashionista, or a literal librarian, this bag is perfect for you.', 'Tote bags', '23.00', 'librarian.jpg', '2021-11-28 16:14:56', '2021-12-11 18:00:20', NULL),
(4, 'Black with white lines', 'This black tote bag with simple white lines is guaranteed to look good with every outfit of yours. The white lining gives it a little sass and makes it look more interesting.', 'Tote bags', '25.00', 'black.jpg', '2021-11-28 16:16:28', '2021-12-11 18:01:04', NULL),
(5, 'Pride', 'Flaunt your pride with this rainbow LGBTQIA+ tote bag. Whether you are a part of the community or just an ally, you can spread awareness and support the LGBT community with this awesome bag. It is a statement as much as a fashion piece.', 'Tote bags', '25.00', 'pride.jpg', '2021-11-28 16:16:28', '2021-12-11 18:02:34', NULL),
(6, 'Coffee', '\"But first, coffee\" tote bag is perfect for people who don´t start their mornings without a caffeinated boost of energy. This bag depicts your way of life perfectly so that everyone knows not to bother you before your first, and very much needed, cup of coffee.', 'Tote bags', '20.00', 'coffeeWhite.jpg', '2021-11-28 16:18:01', '2021-12-11 18:02:52', NULL),
(7, 'Women', 'This tote bag with two women of color drawn on it is sure to start conversations. You could be a femenist, a human supporting POCs, or a fashionista wanting to spread a message. Whatever you are, this bag is guaranteed to look good on you.', 'Tote bags', '23.00', 'women.jpg', '2021-11-28 16:14:33', '2021-12-11 18:03:05', NULL),
(8, 'Pure white', 'For days when you need simplicity, or maybe just want a clean slate to do your own drawings and decorations on, this purely white bag can give it all to you. You choose your own look.', 'Tote bags', '20.00', 'pureWhite.jpg', '2021-11-28 16:19:57', '2021-12-11 18:03:23', NULL),
(9, 'Accent red', 'This tote bag is simple yet nowhere close to looking boring. The slight pop of red gives it an interesting and fashionable look. Go about your day while this cool piece will take care of keeping all of your things in place.', 'Tote bags', '23.00', 'accentRed.jpg', '2021-11-28 16:19:57', '2021-12-11 18:03:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `surname`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`, `is_admin`) VALUES
(2, 'goreza', 'Lee Nash', 'Chase', 'cederapaca@mailinator.com', '$2y$10$6uEPy1Kwsa9/rOtc2z8H9./hGeqHgs0RR/QHyvjyk.6JpyQEJYat2', '2021-12-01 18:28:00', '2021-12-07 20:48:38', NULL, 1),
(3, 'gare', 'Gareth Noel', 'Poole', 'wifon@mailinator.com', '$2y$10$jpGgQaoiXkatv1ppi8HiWObXI/SWYgM7hmBVDU6qepJiu2NhZrIAq', '2021-12-01 18:45:02', '2021-12-01 18:45:02', NULL, NULL),
(4, 'jhalliday', 'James', 'Halliday', 'jhalliday@sth.com', '$2y$10$RJkkGrRFzn2FADF21uXEqOgSDF8sAKTLIDz3LHaLjBlB0mow2ZISu', '2021-12-01 18:58:52', '2021-12-01 18:58:52', NULL, NULL),
(5, 'muqefeq', 'Marny Alford', 'Greene', 'powyluxajo@mailinator.com', '$2y$10$y8FUNtwF9i8DMCZdpbHpmO8ozb1SpyPi5axlR6WYs6yS4jUPTaEde', '2021-12-01 21:09:27', '2021-12-01 21:09:27', NULL, NULL),
(9, 'nysyriq', 'Fallon Humphrey', 'Richardson', 'vevac@mailinator.com', '$2y$10$a58Tm29DYDJvhDW1tJszEefC3N3awfhyYyEOCvwPBltV8fanKLfN.', '2021-12-01 21:15:11', '2021-12-01 21:15:11', NULL, NULL),
(10, 'codog', 'Cassidy Bates', 'Heath', 'fubu@mailinator.com', '$2y$10$dl11Pl4vZUIDSULbyGyEtujy.Q7dsNARVfsqj5f7viW.hLeuN8uly', '2021-12-01 21:15:42', '2021-12-01 21:15:42', NULL, NULL),
(11, 'pperic', 'petar', 'Peric', 'pperic@negdje.com', '$2y$10$qpP5AJS86koZDjyjD74EnuVJjJvkq1b9f02GWRMM9Mckonk1VFvx.', '2021-12-13 12:12:09', '2021-12-13 12:12:09', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
