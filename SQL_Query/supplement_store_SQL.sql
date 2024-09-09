-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 07, 2024 at 02:13 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE supplement_store;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
USE supplement_store;
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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(2, 'How to Choose the Right Multivitamin', NULL, 'When selecting a multivitamin, consider...', 3, 'blog_post', '2024-09-05 23:40:24', '2024-09-09 00:37:12'),
(3, 'Benefits of Omega-3 Fatty Acids', NULL, 'Omega-3s are crucial for heart and brain health...', 3, 'blog_post', '2024-09-05 23:40:24', '2024-09-05 23:40:24'),
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`id`, `user_id`, `dispute_type`, `order_id`, `product_id`, `message`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(9, 5, 'order', 4, 0, 'i have a problem about this order', NULL, 'resolved', '2024-09-09 07:01:08', '2024-09-09 07:34:46');

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
(1, 99, '2024-09-09 05:07:03'),
(2, 199, '2024-09-07 01:31:10'),
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(1, 5, 3, 'Hi, could you suggest a good protein supplement for beginners?', '2024-09-05 23:40:24'),
(2, 3, 5, 'I recommend starting with whey protein, it’s great for beginners and pros alike.', '2024-09-05 23:40:24'),
(3, 5, 3, 'ok thanks', '2024-09-08 05:18:09'),
(4, 7, 0, 'hello', '2024-09-09 01:07:12'),
(5, 7, 5, 'hi', '2024-09-09 01:07:30'),
(6, 5, 3, 'hello test message', '2024-09-09 03:05:19'),
(7, 7, 5, 'hello again from admin', '2024-09-09 03:10:37'),
(8, 7, 5, 'hello again from admin', '2024-09-09 03:11:21'),
(9, 8, 3, 'hello', '2024-09-09 03:24:28'),
(10, 7, 8, 'hello doe', '2024-09-09 03:24:50');

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`, `shipping_address`, `billing_address`, `payment_status`) VALUES
(1, 1, 59.98, 'pending', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(2, 1, 29.99, 'shipped', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(3, 2, 15.49, 'delivered', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(4, 5, 15.49, 'shipped', '2024-09-06 07:53:08', '2024-09-09 06:49:33', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(5, 5, 15.49, 'shipped', '2024-09-07 01:31:10', '2024-09-07 01:33:08', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(6, 7, 29.99, 'pending', '2024-09-09 01:22:07', '2024-09-09 01:22:07', 'some addr', 'some addr', 'paid');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 29.99),
(2, 2, 2, 1, 15.49),
(3, 3, 3, 1, 12.99),
(4, 4, 2, 1, 15.49),
(5, 5, 2, 1, 15.49),
(6, 6, 1, 1, 29.99);

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
(1, 'Whey Protein', 'High-quality whey protein powder for muscle recovery.', 'detailed description', 29.99, 'Protein', 'pfp.png', '2024-09-05 23:40:24', '2024-09-09 05:07:03', 'brand1', 5.00),
(2, 'Multivitamin', 'Daily multivitamin supplement for overall health.', NULL, 15.49, 'Vitamins', 'multivitamin.jpg', '2024-09-05 23:40:24', '2024-09-07 01:41:58', 'brand1', 2.50),
(3, 'Omega-3 Fish Oil', 'Omega-3 fish oil capsules to support heart health.', NULL, 12.99, 'Oils', 'omega3_fish_oil.jpg', '2024-09-05 23:40:24', '2024-09-07 00:49:07', 'brand2', 5.00),
(4, 'Creatine Monohydrate', 'Creatine for enhanced performance and strength.', NULL, 19.99, 'Performance', 'creatine_monohydrate.jpg', '2024-09-05 23:40:24', '2024-09-06 05:22:41', 'brand2', 0.00);

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
(1, 1, 1, 5, 'Great product, excellent for muscle recovery!', '2024-09-05 23:40:24'),
(2, 2, 2, 4, 'Good daily multivitamin, but a bit pricey.', '2024-09-05 23:40:24'),
(3, 1, 3, 5, 'Fish oil really helped with my heart health.', '2024-09-05 23:40:24'),
(6, 5, 2, 1, 'test', '2024-09-07 01:41:50');

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
(8, 'john_doe', 'john doe', 'john.doe@example.com', 'nutritional_expert', '$2y$10$Up7x0tr3ucSc0f7D1zEs8.tP/IeSwthDLjj//0n2oUyeLR7V16ob2', '2024-09-09 03:24:11', 'yes'),
(3, 'jane_smith', 'Jane Smith', 'jane.smith@example.com', 'nutritional_expert', 'hashed_password_3', '2024-09-05 23:40:24', 'no'),
(5, 'Himan', 'Himan Manduja', 'hghimanmanduja@gmail.com', 'registered', '$2y$10$PErG.7yD4BZSLk47TZmuVu2ASQrR1wxvVeODipyAXXNsPs5MOQ7Bm', '2024-09-06 00:44:38', 'no'),
(7, 'admin', 'admin', 'admin@admin.com', 'admin', '$2y$10$LRYBh75259kMxLj/cWmITOLSSIygGyIjWMcArByZ/yi3cEVEUohfa', '2024-09-09 00:29:57', 'no');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

