-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 25, 2024 at 11:37 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supplement_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `author_id` int NOT NULL,
  `type` enum('article','guide','blog_post') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `image_url`, `body`, `author_id`, `type`, `created_at`, `updated_at`) VALUES
(2, 'How to Choose the Right Multivitamin', '71EPsTan5AL.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi sapien, dictum in imperdiet in, dapibus non libero. Quisque et purus vel turpis maximus venenatis. Integer vel euismod augue, non tempus sapien. Aliquam vitae magna nibh. Donec ut tempus risus. Sed posuere dignissim luctus. Sed vehicula libero non ipsum condimentum, a rutrum felis faucibus. Donec sagittis, felis ut fringilla elementum, odio lorem fermentum ipsum, at porttitor lorem enim quis urna. Nam mattis tellus purus, sit amet vulputate risus rutrum feugiat. Nullam hendrerit purus vitae lectus mattis, vitae viverra enim pharetra. Proin nec mi nisi.\n\nCras vitae odio fermentum enim lobortis tincidunt. Nullam dictum ipsum libero, sit amet dignissim tellus eleifend sit amet. Proin erat nibh, porttitor quis lorem ac, iaculis ullamcorper sapien. Phasellus posuere blandit neque, in facilisis ipsum porta eu. Etiam eu mollis justo, nec aliquam magna. Fusce in erat nulla. Mauris nec ante sed massa blandit tincidunt. Praesent eget pulvinar lorem, ac ultrices lectus. Quisque lobortis eget enim vestibulum aliquam.', 3, 'blog_post', '2024-09-05 23:40:24', '2024-09-25 08:25:25'),
(3, 'Benefits of Omega-3 Fatty Acids', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi sapien, dictum in imperdiet in, dapibus non libero. Quisque et purus vel turpis maximus venenatis. Integer vel euismod augue, non tempus sapien. Aliquam vitae magna nibh. Donec ut tempus risus. Sed posuere dignissim luctus. Sed vehicula libero non ipsum condimentum, a rutrum felis faucibus. Donec sagittis, felis ut fringilla elementum, odio lorem fermentum ipsum, at porttitor lorem enim quis urna. Nam mattis tellus purus, sit amet vulputate risus rutrum feugiat. Nullam hendrerit purus vitae lectus mattis, vitae viverra enim pharetra. Proin nec mi nisi.\n\nCras vitae odio fermentum enim lobortis tincidunt. Nullam dictum ipsum libero, sit amet dignissim tellus eleifend sit amet. Proin erat nibh, porttitor quis lorem ac, iaculis ullamcorper sapien. Phasellus posuere blandit neque, in facilisis ipsum porta eu. Etiam eu mollis justo, nec aliquam magna. Fusce in erat nulla. Mauris nec ante sed massa blandit tincidunt. Praesent eget pulvinar lorem, ac ultrices lectus. Quisque lobortis eget enim vestibulum aliquam.', 3, 'blog_post', '2024-09-05 23:40:24', '2024-09-21 06:11:47'),
(5, 'test 2 ', '', 'admib no 7', 7, 'guide', '2024-09-09 00:42:01', '2024-09-09 00:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

DROP TABLE IF EXISTS `disputes`;
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `dispute_type` enum('general','order','product') DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `message` text,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`id`, `user_id`, `dispute_type`, `order_id`, `product_id`, `message`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(11, 5, 'product', 0, 2, 'dispute ', NULL, 'pending', '2024-09-22 11:08:38', '2024-09-22 11:08:38'),
(9, 5, 'order', 4, 0, 'i have a problem about this order', NULL, 'resolved', '2024-09-09 07:01:08', '2024-09-09 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `health_schedule`
--

DROP TABLE IF EXISTS `health_schedule`;
CREATE TABLE IF NOT EXISTS `health_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `schedule_type` enum('supplement','workout','meal') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `reminder_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `health_schedule`
--

INSERT INTO `health_schedule` (`id`, `user_id`, `schedule_type`, `title`, `description`, `reminder_time`, `created_at`, `updated_at`) VALUES
(3, 5, 'meal', 'asdas', 'asdasd', '19:53:00', '2024-09-25 11:21:20', '2024-09-25 11:21:20'),
(6, 5, 'supplement', 'test', 'test', '19:01:00', '2024-09-25 11:28:26', '2024-09-25 11:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `product_id` int NOT NULL,
  `stock` int NOT NULL,
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `stock`, `last_updated`) VALUES
(1, 9, '2024-09-21 14:52:40'),
(2, 197, '2024-09-25 08:26:49'),
(3, 150, '2024-09-05 23:40:24'),
(4, 80, '2024-09-05 23:40:24');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(1, 5, 3, 'Hi, could you suggest a good protein supplement for beginners?', '2024-09-05 23:40:24'),
(2, 3, 5, 'I recommend starting with whey protein, it’s great for beginners and pros alike.', '2024-09-05 23:40:24'),
(3, 5, 3, 'ok thanks', '2024-09-08 05:18:09'),
(29, 8, 3, 'Hi', '2024-09-22 12:28:58'),
(30, 5, 3, 'hello', '2024-09-22 12:40:31'),
(28, 7, 5, 'If you have more questions please ask away : )', '2024-09-22 12:26:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(29, 5, 'You Have A New Message', 0, '2024-09-22 11:47:59'),
(30, 0, 'You Have A New Message', 0, '2024-09-22 12:22:53'),
(31, 5, 'Order Placed - Order #11', 0, '2024-09-25 08:26:51'),
(27, 5, 'Order Placed - Order #9', 1, '2024-09-21 09:17:41'),
(28, 5, 'Order Placed - Order #10', 1, '2024-09-21 14:41:21'),
(25, 5, 'Order Placed - Order #7', 1, '2024-09-21 09:15:43'),
(26, 5, 'Order Placed - Order #8', 1, '2024-09-21 09:15:45'),
(24, 7, 'The product \'Whey Protein\' (ID: 1) is low on inventory. Currently, only 9 left.', 1, '2024-09-15 13:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processed','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shipping_address` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`, `shipping_address`, `billing_address`, `payment_status`) VALUES
(1, 1, 59.98, 'pending', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(2, 1, 29.99, 'shipped', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(3, 2, 15.49, 'delivered', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(4, 5, 15.49, 'shipped', '2024-09-06 07:53:08', '2024-09-09 06:49:33', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(5, 5, 15.49, 'shipped', '2024-09-07 01:31:10', '2024-09-07 01:33:08', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(6, 7, 29.99, 'pending', '2024-09-09 01:22:07', '2024-09-09 01:22:07', 'some addr', 'some addr', 'paid'),
(7, 5, 105.46, 'cancelled', '2024-09-21 09:15:41', '2024-09-21 14:52:30', 'asdasd', 'asdasd', 'paid'),
(11, 5, 30.98, 'pending', '2024-09-25 08:26:49', '2024-09-25 08:26:49', 'random adress', 'random adress', 'paid'),
(9, 5, 29.99, 'cancelled', '2024-09-21 09:17:39', '2024-09-21 14:51:27', 'asdasd', 'asdasd', 'paid'),
(10, 5, 29.99, 'cancelled', '2024-09-21 14:41:19', '2024-09-21 14:52:40', 'asd', 'asd', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 29.99),
(2, 2, 2, 1, 15.49),
(3, 3, 3, 1, 12.99),
(4, 4, 2, 1, 15.49),
(5, 5, 2, 1, 15.49),
(6, 6, 1, 1, 29.99),
(7, 7, 1, 3, 29.99),
(8, 7, 2, 1, 15.49),
(9, 9, 1, 1, 29.99),
(10, 10, 1, 1, 29.99),
(11, 11, 2, 2, 15.49);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `detailed_description` text,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `brand` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `detailed_description`, `price`, `category`, `image_url`, `created_at`, `updated_at`, `brand`, `rating`) VALUES
(1, 'Whey Protein', 'High-quality whey protein powder for muscle recovery.', 'detailed description', 29.99, 'Protein', 'whey.png', '2024-09-05 23:40:24', '2024-09-21 06:49:28', 'brand1', 5.00),
(2, 'Multivitamin', 'Daily multivitamin supplement for overall health.', NULL, 15.49, 'Vitamins', 'vitamin.png', '2024-09-05 23:40:24', '2024-09-25 08:41:13', 'brand1', 4.00),
(3, 'Omega-3 Fish Oil', 'Omega-3 fish oil capsules to support heart health.', NULL, 12.99, 'Oils', '.png', '2024-09-05 23:40:24', '2024-09-21 06:43:08', 'brand2', 5.00),
(4, 'Creatine Monohydrate', 'Creatine for enhanced performance and strength.', NULL, 19.99, 'Performance', '.png', '2024-09-05 23:40:24', '2024-09-21 06:43:12', 'brand2', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `discount`, `start_date`, `end_date`) VALUES
(1, 'SUMMER20', 20.00, '2024-06-01', '2024-08-31'),
(2, 'FALL15', 15.00, '2024-09-01', '2024-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

DROP TABLE IF EXISTS `recommendations`;
CREATE TABLE IF NOT EXISTS `recommendations` (
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `recommended_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`user_id`, `product_id`, `recommended_at`) VALUES
(5, 1, '2024-09-05 23:40:24'),
(5, 4, '2024-09-05 23:40:24'),
(2, 2, '2024-09-05 23:40:24'),
(5, 2, '2024-09-08 06:42:13'),
(7, 1, '2024-09-09 01:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 8, 1, 5, 'Great product, excellent for muscle recovery!', '2024-09-05 23:40:24'),
(2, 3, 2, 4, 'Good daily multivitamin, but a bit pricey.', '2024-09-05 23:40:24'),
(3, 3, 3, 5, 'Fish oil really helped with my heart health.', '2024-09-05 23:40:24'),
(7, 5, 3, 5, 'Very Good Product', '2024-09-25 08:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_reminders`
--

DROP TABLE IF EXISTS `schedule_reminders`;
CREATE TABLE IF NOT EXISTS `schedule_reminders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `schedule_id` int DEFAULT NULL,
  `reminder_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_id` (`schedule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedule_reminders`
--

INSERT INTO `schedule_reminders` (`id`, `schedule_id`, `reminder_day`) VALUES
(1, 1, 'Monday'),
(2, 1, 'Tuesday'),
(3, 1, 'Wednesday'),
(4, 1, 'Thursday'),
(5, 1, 'Friday'),
(6, 1, 'Saturday'),
(7, 1, 'Sunday'),
(8, 2, 'Tuesday'),
(9, 2, 'Wednesday'),
(15, 3, 'Wednesday'),
(14, 3, 'Tuesday'),
(13, 3, 'Monday'),
(16, 3, 'Thursday'),
(17, 3, 'Friday'),
(18, 3, 'Saturday'),
(19, 3, 'Sunday'),
(20, 4, 'Saturday'),
(21, 4, 'Sunday'),
(22, 5, 'Saturday'),
(23, 5, 'Sunday'),
(27, 6, 'Thursday'),
(26, 6, 'Tuesday');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('unregistered','registered','admin','nutritional_expert') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `offer_notifications` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `role`, `password`, `created_at`, `offer_notifications`) VALUES
(8, 'john_doe', 'john doe', 'john.doe@example.com', 'registered', '$2y$10$Up7x0tr3ucSc0f7D1zEs8.tP/IeSwthDLjj//0n2oUyeLR7V16ob2', '2024-09-09 03:24:11', 'yes'),
(3, 'jane_smith', 'Jane Smith', 'jane.smith@example.com', 'nutritional_expert', 'hashed_password_3', '2024-09-05 23:40:24', 'no'),
(5, 'Himan', 'Himan Manduja', 'hghimanmanduja@gmail.com', 'registered', '$2y$10$PErG.7yD4BZSLk47TZmuVu2ASQrR1wxvVeODipyAXXNsPs5MOQ7Bm', '2024-09-06 00:44:38', 'no'),
(7, 'admin', 'admin', 'admin@admin.com', 'admin', '$2y$10$LRYBh75259kMxLj/cWmITOLSSIygGyIjWMcArByZ/yi3cEVEUohfa', '2024-09-09 00:29:57', 'no');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
