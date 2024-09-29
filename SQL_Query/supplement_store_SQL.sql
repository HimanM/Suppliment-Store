-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 29, 2024 at 08:03 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(79, 5, 4, 8),
(78, 5, 0, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `image_url`, `body`, `author_id`, `type`, `created_at`, `updated_at`) VALUES
(2, 'How to Choose the Right Multivitamin', '71EPsTan5AL.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi sapien, dictum in imperdiet in, dapibus non libero. Quisque et purus vel turpis maximus venenatis. Integer vel euismod augue, non tempus sapien. Aliquam vitae magna nibh. Donec ut tempus risus. Sed posuere dignissim luctus. Sed vehicula libero non ipsum condimentum, a rutrum felis faucibus. Donec sagittis, felis ut fringilla elementum, odio lorem fermentum ipsum, at porttitor lorem enim quis urna. Nam mattis tellus purus, sit amet vulputate risus rutrum feugiat. Nullam hendrerit purus vitae lectus mattis, vitae viverra enim pharetra. Proin nec mi nisi.\n\nCras vitae odio fermentum enim lobortis tincidunt. Nullam dictum ipsum libero, sit amet dignissim tellus eleifend sit amet. Proin erat nibh, porttitor quis lorem ac, iaculis ullamcorper sapien. Phasellus posuere blandit neque, in facilisis ipsum porta eu. Etiam eu mollis justo, nec aliquam magna. Fusce in erat nulla. Mauris nec ante sed massa blandit tincidunt. Praesent eget pulvinar lorem, ac ultrices lectus. Quisque lobortis eget enim vestibulum aliquam.', 3, 'blog_post', '2024-09-05 23:40:24', '2024-09-25 08:25:25'),
(19, 'The Power of Vitamin C in Boosting Immunity', 'lemons-can-be-healthful-and-refreshing.png', 'Vitamin C has long been recognized as one of the most essential vitamins for strengthening the immune system. As an antioxidant, it helps to protect cells from damage by free radicals, which can weaken the body’s defenses. Regular consumption of foods high in vitamin C or taking supplements can lead to improved white blood cell production, which plays a crucial role in fighting infections. Citrus fruits, bell peppers, and strawberries are common sources of this vitamin, but when dietary intake isn’t sufficient, vitamin C supplements can provide an easy solution. For those constantly on the go, daily vitamin C intake ensures that your body stays fortified against common colds and flu. Moreover, vitamin C is involved in collagen production, which is vital for skin health and healing wounds.', 7, 'article', '2024-09-26 15:28:27', '2024-09-26 15:28:27'),
(20, 'Omega-3 Fatty Acids: The Key to Heart Health', 'Benefits-of-Fish-Oil-for-Body-Building-Featured-Image-720x360.jpg', 'Omega-3 fatty acids are well known for their heart-protective properties. Found primarily in fatty fish like salmon, tuna, and mackerel, these essential fats reduce inflammation, lower blood pressure, and reduce the risk of heart disease. If you\'re not getting enough Omega-3s through your diet, fish oil supplements are a popular alternative. Studies show that individuals who regularly consume Omega-3s have a lower chance of experiencing heart attacks and strokes. Omega-3s are also beneficial for brain function, particularly in older adults, helping to ward off memory-related conditions such as Alzheimer\'s.', 7, 'article', '2024-09-26 15:30:11', '2024-09-26 15:30:11'),
(21, 'The Importance of Zinc in Skin Health', 'hlt-tier-3-garden-of-life-ahuang-046-85f49bc0457c499c841d3b1cee071bcf.jpeg', 'Zinc is an often overlooked mineral that plays a significant role in skin health. Whether it’s fighting off acne or speeding up the healing of wounds, zinc is a critical nutrient. Zinc acts as an antioxidant, helping to reduce inflammation and protect skin cells from environmental stress. It’s also essential for maintaining collagen production, which keeps your skin firm and youthful. Foods like spinach, nuts, and seeds contain zinc, but for individuals with severe acne or skin issues, a zinc supplement can be a valuable addition to their skincare routine.', 7, 'article', '2024-09-26 15:33:39', '2024-09-26 15:33:39'),
(22, 'The Benefits of Vitamin D in Boosting Immunity', 'e1b5a6cf-2989-4522-9c5c-84836d597ac2.jpg', 'Vitamin D is often called the \"sunshine vitamin\" because our bodies produce it in response to sunlight. It plays a crucial role in bone health by helping with the absorption of calcium. But what many people don\'t know is that vitamin D also has a powerful effect on the immune system. In a world where staying healthy is a top priority, understanding how to boost immunity naturally has become more important than ever. This article delves into how vitamin D strengthens the immune system, helping the body ward off infections.\r\n\r\nThe immune system is our body\'s first line of defense against harmful pathogens like bacteria and viruses. While factors like genetics, diet, and lifestyle choices all contribute to immune health, vitamin D stands out as a critical nutrient. Studies have shown that vitamin D can enhance the pathogen-fighting effects of monocytes and macrophages—white blood cells that play an essential part in the immune defense. It also decreases inflammation, further supporting immune response.\r\n\r\nPeople with low levels of vitamin D are more susceptible to infections, including the common cold and flu. In fact, research has linked vitamin D deficiency to increased risks of respiratory infections, particularly in the winter months when sunlight exposure is lower, leading to a natural decrease in vitamin D levels. For those looking to naturally boost their immune system, making sure to get enough vitamin D is essential.\r\n\r\nSo, how can one increase vitamin D intake? Sun exposure is the most natural way, but dietary supplements and vitamin D-rich foods like fatty fish, cheese, and egg yolks are also excellent sources. Even fortified foods like milk and cereals can help you meet your daily requirements. If you\'re unable to get enough sun exposure or are at risk of deficiency, it\'s advisable to consult with a healthcare provider for supplements. Remember, maintaining optimal vitamin D levels year-round is key to supporting your overall health.\r\n\r\nIn conclusion, while vitamin D is well known for its role in bone health, its immune-boosting capabilities should not be overlooked. As we continue to navigate global health challenges, ensuring that your body has adequate levels of this essential vitamin can provide the immune system with the necessary support to fend off harmful pathogens.', 7, 'article', '2024-09-26 15:45:39', '2024-09-26 15:45:39'),
(23, 'A Comprehensive Guide to Pre-Workout Supplements for Bodybuilding', 'Stack-Image-1-Morgan-Walsh-sidebar.png', 'Pre-workout supplements have become essential for many bodybuilders and fitness enthusiasts looking to maximize their performance and endurance in the gym. Understanding which ingredients to look for and how these supplements enhance your workouts can dramatically improve your results.\r\n\r\nPre-workouts typically contain a blend of ingredients designed to improve energy, focus, endurance, and blood flow to muscles. The most common ingredients include caffeine, beta-alanine, creatine, and nitric oxide boosters such as arginine. Each of these plays a unique role in supporting muscle performance during high-intensity workouts.\r\n\r\nFor example, caffeine stimulates the central nervous system, increasing energy and focus, while beta-alanine helps buffer lactic acid buildup in muscles, reducing fatigue. Creatine boosts ATP production, supplying the muscle cells with more energy for short bursts of activity, like lifting heavy weights.\r\n\r\nTo use pre-workout supplements effectively, it’s essential to consume them 30-45 minutes before hitting the gym. This allows enough time for the ingredients to be absorbed into your bloodstream, maximizing their effects during your workout.\r\n\r\nIt’s also important to start with a smaller dose, particularly if you\'re sensitive to caffeine, and gradually increase the dosage based on your tolerance. Make sure to stay hydrated, as pre-workouts can dehydrate you due to their stimulatory effects.\r\n\r\nIn conclusion, pre-workouts are a powerful tool in any bodybuilder\'s arsenal. However, it\'s crucial to understand how to use them effectively and responsibly for maximum gains.', 7, 'guide', '2024-09-26 15:51:28', '2024-09-26 15:51:28'),
(24, 'The Ultimate Muscle-Building Supplement Guide', 'vwh-detail-nutricost-creatine-monohydrate-micronized-powder-jthompson-0320-c435615ae11b4cb0802d1ef156c7ddaf.jpeg', 'Creatine is one of the most researched and effective supplements for bodybuilding. Used by athletes for decades, it has been proven to significantly increase muscle mass, strength, and exercise performance.\r\n\r\nThis guide will break down everything you need to know about creatine: how it works, how to use it, and how it fits into your overall bodybuilding strategy.\r\n\r\nCreatine is stored in your muscles and is used to produce ATP, the primary energy currency during short, intense bursts of activity like weightlifting. By increasing the availability of creatine in your muscles through supplementation, you can lift heavier weights for longer periods of time, leading to greater muscle growth.\r\n\r\nThe standard dosage for creatine is 5 grams per day. Many bodybuilders also opt for a \"loading phase,\" where they take 20 grams per day for the first week to saturate their muscles quickly. After the loading phase, they return to the 5 grams maintenance dose.\r\n\r\nIt’s important to stay well-hydrated while taking creatine, as it draws water into the muscle cells, which can lead to dehydration if you\'re not drinking enough fluids. Additionally, pairing creatine with a carbohydrate-rich meal can increase its uptake by muscles.\r\n\r\nCreatine is a staple supplement in bodybuilding, thanks to its ability to promote muscle growth, strength, and performance.', 7, 'guide', '2024-09-26 15:54:12', '2024-09-26 15:54:12'),
(25, 'The Best Supplements for Post-Workout Recovery', 'ewl-tier-3-bolde-bottle-dburreson-2-13-7eb1402f614d423bbc9a38d82467085c.jpeg', 'Post-workout recovery is just as important as the workout itself when it comes to building muscle. The right supplements can accelerate recovery, reduce muscle soreness, and improve muscle growth.\r\n\r\nThe key supplements for post-workout recovery include protein, BCAAs, and glutamine. Protein is essential for repairing and rebuilding muscle fibers that are broken down during exercise. Whey protein is especially effective because it\'s quickly absorbed, delivering amino acids to the muscles when they\'re needed most.\r\n\r\nBCAAs (branched-chain amino acids) like leucine, isoleucine, and valine are also crucial for recovery. These amino acids are particularly effective in promoting muscle protein synthesis and reducing muscle breakdown.\r\n\r\nGlutamine, an amino acid, helps replenish muscle glycogen and supports the immune system, which can become suppressed during intense exercise. Taking a glutamine supplement after a workout can speed up recovery and reduce muscle soreness.\r\n\r\nTo maximize recovery, it’s best to take these supplements within 30 minutes of finishing your workout, during the so-called \"anabolic window\" when your body is most receptive to nutrients.\r\n\r\nIncorporating these post-workout recovery supplements into your regimen will help you recover faster and build more muscle.', 7, 'guide', '2024-09-26 15:56:42', '2024-09-26 15:56:42'),
(26, 'A Beginner\'s Guide to Using Protein Powders for Muscle Gain', '7fcc6d_.png', 'Protein powders are the go-to supplement for anyone looking to build muscle. They provide a convenient and efficient way to increase your daily protein intake, which is essential for muscle growth.\r\n\r\nThere are several types of protein powders available, each with its own benefits. Whey protein is the most popular option because it’s quickly absorbed and rich in branched-chain amino acids (BCAAs), which are critical for muscle recovery. Casein protein, on the other hand, is absorbed slowly, making it ideal for consumption before bed to support muscle repair during sleep.\r\n\r\nPlant-based protein powders like pea, rice, and hemp protein are great alternatives for vegans and those with lactose intolerance. While these plant proteins may not have as complete an amino acid profile as whey, they are still effective for muscle building when combined properly.\r\n\r\nTo use protein powders effectively, aim for 1.6-2.2 grams of protein per kilogram of body weight per day. If you\'re not able to meet this through food alone, supplement with protein shakes.\r\n\r\nFor optimal muscle gain, consume a protein shake within 30 minutes of finishing your workout. You can also have a shake between meals or before bed, depending on your total protein needs for the day.', 7, 'guide', '2024-09-26 15:58:22', '2024-09-26 15:58:22'),
(27, 'Essential Bodybuilding Supplements for Cutting and Fat Loss', '60-fat-burner-l-carnitine-capsule-fat-loss-special-supplements-7-original-imagg6ar4fszg3fj.png', 'When it comes to cutting fat while preserving muscle, the right supplements can make a significant difference. This guide will cover the essential supplements for cutting and fat loss, including fat burners, CLA, and L-carnitine.\r\n\r\nFat burners typically contain ingredients like caffeine, green tea extract, and synephrine, all of which help increase metabolism and promote fat loss. Caffeine also acts as a mild appetite suppressant, making it easier to stick to a calorie deficit.\r\n\r\nCLA (conjugated linoleic acid) is a type of fatty acid that helps the body use fat as energy while preserving lean muscle mass. Studies have shown that CLA can improve body composition by increasing fat loss and promoting muscle retention.\r\n\r\nL-carnitine is another powerful supplement for cutting. It helps transport fatty acids into the mitochondria of your cells, where they are burned for energy. This can lead to increased fat burning during exercise, making L-carnitine an effective tool during a cutting phase.\r\n\r\nThese supplements should be used in conjunction with a well-planned diet and exercise program for best results. Remember, no supplement can outwork a bad diet, so ensure you\'re eating at a calorie deficit while maintaining high protein intake to preserve muscle.', 7, 'guide', '2024-09-26 15:59:48', '2024-09-26 15:59:48');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`id`, `user_id`, `dispute_type`, `order_id`, `product_id`, `message`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(19, 5, 'order', 14, 0, 'Test Dispute regrading Order 14', 'Test Dispute Image.png', 'resolved', '2024-09-28 09:55:14', '2024-09-28 10:00:59');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `health_schedule`
--

INSERT INTO `health_schedule` (`id`, `user_id`, `schedule_type`, `title`, `description`, `reminder_time`, `created_at`, `updated_at`) VALUES
(7, 5, 'meal', 'Meal Plan Test', 'Meal Plan Test Description', '18:36:00', '2024-09-25 12:23:12', '2024-09-25 13:04:10'),
(8, 5, 'supplement', 'Sample Suppliment Intake', 'Sample Suppliment Intake Description', '20:30:00', '2024-09-28 13:04:54', '2024-09-28 13:04:54');

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
(1, 20, '2024-09-28 09:44:42'),
(2, 197, '2024-09-25 08:26:49'),
(4, 80, '2024-09-28 05:38:23'),
(5, 46, '2024-09-28 07:36:12'),
(6, 40, '2024-09-28 04:59:39'),
(7, 60, '2024-09-28 05:00:41'),
(8, 66, '2024-09-28 07:36:12'),
(9, 30, '2024-09-28 05:09:46'),
(10, 25, '2024-09-28 05:14:31'),
(11, 55, '2024-09-28 05:15:16'),
(12, 45, '2024-09-28 05:15:47'),
(13, 65, '2024-09-28 05:17:47'),
(14, 88, '2024-09-28 09:17:09'),
(16, 80, '2024-09-28 05:07:29'),
(17, 150, '2024-09-28 05:07:29'),
(18, 120, '2024-09-28 05:07:29'),
(19, 90, '2024-09-28 05:07:29'),
(20, 110, '2024-09-28 05:07:29'),
(21, 130, '2024-09-28 05:07:29'),
(22, 200, '2024-09-28 05:07:29'),
(23, 250, '2024-09-28 05:07:29'),
(24, 70, '2024-09-28 05:07:29');

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(1, 5, 3, 'Hi, could you suggest a good protein supplement for beginners?', '2024-09-05 23:40:24'),
(2, 3, 5, 'I recommend starting with whey protein, it’s great for beginners and pros alike.', '2024-09-05 23:40:24'),
(3, 5, 3, 'ok thanks', '2024-09-08 05:18:09'),
(33, 7, 5, 'asdasdasd', '2024-09-29 18:55:43'),
(29, 8, 3, 'Hi', '2024-09-22 12:28:58'),
(30, 5, 3, 'hello', '2024-09-22 12:40:31'),
(31, 5, 3, 'REVIEW-04: Verify only logged-in users can submit reviews.', '2024-09-28 08:40:52'),
(32, 7, 5, 'REVIEW-04: Verify only logged-in users can submit reviews. Message from Admin', '2024-09-28 08:43:45'),
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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(39, 7, 'We closed your dispute', 0, '2024-09-28 10:01:01'),
(37, 5, 'Order Placed - Order #14', 1, '2024-09-28 07:36:18'),
(38, 5, 'We have sent you an email regarding the dispute.', 1, '2024-09-28 09:22:07'),
(36, 5, 'Order Placed - Order #13', 1, '2024-09-28 07:28:19'),
(35, 5, 'Dear Customer,\n\nYour order status has been updated to delivered.\n\nThank you for shopping with us.', 0, '2024-09-27 07:35:00'),
(32, 5, 'Reminder set for Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday at 07:55', 1, '2024-09-25 12:23:12'),
(33, 5, 'Order Placed - Order #12', 1, '2024-09-26 21:07:26'),
(34, 7, 'The product \'Whey Protein\' (ID: 1) is low on inventory. Currently, only 6 left.', 0, '2024-09-27 05:47:22'),
(29, 5, 'You Have A New Message', 0, '2024-09-22 11:47:59'),
(30, 0, 'You Have A New Message', 0, '2024-09-22 12:22:53'),
(31, 5, 'Order Placed - Order #11', 1, '2024-09-25 08:26:51'),
(27, 5, 'Order Placed - Order #9', 1, '2024-09-21 09:17:41'),
(28, 5, 'Order Placed - Order #10', 1, '2024-09-21 14:41:21'),
(25, 5, 'Order Placed - Order #7', 1, '2024-09-21 09:15:43'),
(26, 5, 'Order Placed - Order #8', 1, '2024-09-21 09:15:45'),
(24, 7, 'The product \'Whey Protein\' (ID: 1) is low on inventory. Currently, only 9 left.', 1, '2024-09-15 13:01:45'),
(40, 5, 'Reminder set for Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday at 20:30', 0, '2024-09-28 13:04:54');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`, `shipping_address`, `billing_address`, `payment_status`) VALUES
(1, 1, 59.98, 'pending', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(2, 1, 29.99, 'shipped', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(3, 2, 15.49, 'delivered', '2024-09-05 23:40:24', '2024-09-05 23:40:24', '', '', 'pending'),
(4, 5, 15.49, 'delivered', '2024-09-06 07:53:08', '2024-09-27 07:34:58', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(5, 5, 15.49, 'shipped', '2024-09-07 01:31:10', '2024-09-07 01:33:08', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', '3/601, Thotupolathenna rd,Dehigasthalawa,Balangoda', 'paid'),
(6, 7, 29.99, 'pending', '2024-09-09 01:22:07', '2024-09-09 01:22:07', 'some addr', 'some addr', 'paid'),
(7, 5, 105.46, 'cancelled', '2024-09-21 09:15:41', '2024-09-21 14:52:30', 'asdasd', 'asdasd', 'paid'),
(11, 5, 30.98, 'pending', '2024-09-25 08:26:49', '2024-09-25 08:26:49', 'random adress', 'random adress', 'paid'),
(9, 5, 29.99, 'cancelled', '2024-09-21 09:17:39', '2024-09-21 14:51:27', 'asdasd', 'asdasd', 'paid'),
(10, 5, 29.99, 'cancelled', '2024-09-21 14:41:19', '2024-09-21 14:52:40', 'asd', 'asd', 'paid'),
(12, 5, 89.97, 'pending', '2024-09-26 21:07:24', '2024-09-26 21:07:24', 'test', 'test', 'paid'),
(14, 5, 80000.00, 'delivered', '2024-09-28 07:36:12', '2024-09-28 07:46:06', '16/46, Lady Lavinia, 1st Templers MW, Templers Road, Mount Lavinia', '16/46, Lady Lavinia, 1st Templers MW, Templers Road, Mount Lavinia', 'paid');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(11, 11, 2, 2, 15.49),
(12, 12, 1, 3, 29.99),
(15, 14, 5, 2, 30000.00),
(14, 13, 8, 2, 10000.00),
(16, 14, 8, 2, 10000.00);

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `detailed_description`, `price`, `category`, `image_url`, `created_at`, `updated_at`, `brand`, `rating`) VALUES
(1, 'Whey Protein', 'High-quality whey protein powder for muscle recovery.', 'detailed description', 8956.34, 'Protein', 'whey.png', '2024-09-05 23:40:24', '2024-09-28 09:44:42', 'brand1', 5.00),
(2, 'Multivitamin', 'Daily multivitamin supplement for overall health.', NULL, 4627.44, 'Vitamins', 'vitamin.png', '2024-09-05 23:40:24', '2024-09-28 04:56:35', 'brand1', 4.00),
(4, 'Creatine Monohydrate', 'Creatine for enhanced performance and strength.', NULL, 5970.89, 'Performance', 'Creatine Monohydrat.jpg', '2024-09-05 23:40:24', '2024-09-28 05:38:23', 'BodyTech', 0.00),
(5, 'Optimum Nutrition Gold Standard Whey', 'High-quality whey protein for muscle building.', 'Optimum Nutrition Gold Standard 100% Whey Protein is one of the best-selling protein powders in the world, offering a blend of whey protein isolate, concentrate, and peptides for muscle recovery and growth.', 30000.00, 'Protein', 'Optimum Nutrition Gold Standard Whey.png', '2024-09-28 04:49:17', '2024-09-28 08:29:28', 'Optimum Nutrition', 5.00),
(6, 'MuscleTech Nitro-Tech', 'Whey protein isolate with added creatine.', 'Nitro-Tech by MuscleTech is a protein supplement designed for both athletes and bodybuilders. It contains whey protein peptides and isolate to aid in muscle growth and recovery.', 28000.00, 'Protein', 'MuscleTech Nitro-Tech.jpg', '2024-09-28 04:49:17', '2024-09-28 04:59:39', 'MuscleTech', NULL),
(7, 'GNC Mega Men Multivitamin', 'Daily multivitamin for men.', 'GNC Mega Men Multivitamin contains essential vitamins and minerals that support overall health, muscle function, and energy production.', 12000.00, 'Vitamins', 'GNC Mega Men Multivitamin.png', '2024-09-28 04:49:17', '2024-09-28 05:00:41', 'GNC', NULL),
(8, 'Centrum Silver Women', 'Multivitamin for women over 50.', 'Centrum Silver Women is a daily multivitamin supplement specifically formulated for women aged 50 and above to support heart, brain, and eye health.', 10000.00, 'Vitamins', 'Centrum Silver Women.jpg', '2024-09-28 04:49:17', '2024-09-28 05:01:24', 'Centrum', NULL),
(9, 'BSN True-Mass', 'Mass gainer for muscle growth.', 'BSN True-Mass is a high-calorie mass gainer designed for individuals looking to increase muscle mass, offering a balanced blend of proteins, carbs, and healthy fats.', 45000.00, 'Mass Gainer', 'BSN TrueMass.jpg', '2024-09-28 04:49:17', '2024-09-28 05:09:46', 'BSN', NULL),
(10, 'Dymatize Super Mass Gainer', 'Calorie-dense mass gainer for building mass.', 'Dymatize Super Mass Gainer provides 1280 calories per serving, with a high amount of protein and carbs to help in rapid muscle growth and recovery.', 42000.00, 'Mass Gainer', 'Dymatize Super Mass Gainer.jpg', '2024-09-28 04:49:17', '2024-09-28 05:14:31', 'Dymatize', NULL),
(11, 'Animal Pak Multivitamin', 'Comprehensive multivitamin for athletes.', 'Animal Pak by Universal Nutrition is a powerful multivitamin supplement that supports athletes with vitamins, minerals, antioxidants, and digestive enzymes.', 15000.00, 'Multivitamin', 'Animal Pak Multivitamin.jpg', '2024-09-28 04:49:17', '2024-09-28 05:15:16', 'Universal Nutrition', NULL),
(12, 'MusclePharm Combat Protein Powder', 'Protein powder with a blend of 5 proteins.', 'MusclePharm Combat Protein Powder features a blend of fast and slow digesting proteins to provide a sustained release of amino acids for muscle repair.', 27000.00, 'Protein', 'MusclePharm Combat Protein Powder.jpg', '2024-09-28 04:49:17', '2024-09-28 05:15:47', 'MusclePharm', NULL),
(13, 'Garden of Life Vitamin Code Women', 'Organic multivitamin for women.', 'Garden of Life Vitamin Code Women is a whole-food multivitamin formulated to meet the needs of active women, supporting energy, reproductive health, and immunity.', 11000.00, 'Vitamins', 'Garden of Life Vitamin Code Women.jpg', '2024-09-28 04:49:17', '2024-09-28 05:17:47', 'Garden of Life', NULL),
(14, 'Cellucor C4 Original Pre-Workout', 'Explosive pre-workout energy supplement.', 'C4 Original by Cellucor is a popular pre-workout supplement that delivers energy, focus, and endurance with ingredients like beta-alanine and creatine nitrate.', 8000.00, 'Pre-Workout', 'Cellucor C4 Original Pre-Workout.jpg', '2024-09-28 04:49:17', '2024-09-28 09:17:09', 'Cellucor', NULL),
(16, 'Nordic Naturals Ultimate Omega', 'High-potency omega-3 fish oil supplement.', 'Nordic Naturals Ultimate Omega is a concentrated fish oil supplement with a high dose of EPA and DHA to support heart, brain, and joint health.', 18000.00, 'Oils', 'path/to/image12.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Nordic Naturals', NULL),
(17, 'NOW Foods Vitamin D-3 5000 IU', 'High-potency vitamin D supplement.', 'NOW Foods Vitamin D-3 provides 5000 IU of vitamin D, which supports immune function and promotes calcium absorption for bone health.', 4200.00, 'Vitamins', 'path/to/image13.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'NOW Foods', NULL),
(18, 'Nature Made Fish Oil 1200 mg', 'Omega-3 supplement for heart health.', 'Nature Made Fish Oil contains 1200 mg of omega-3s, providing EPA and DHA, which help support a healthy heart.', 8500.00, 'Oils', 'path/to/image14.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Nature Made', NULL),
(19, 'Jarrow Formulas B-Right Complex', 'Balanced B-complex for energy and metabolism.', 'Jarrow Formulas B-Right Complex is a low-odor vitamin B complex that promotes energy production and supports cardiovascular health.', 6500.00, 'Vitamins', 'path/to/image15.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Jarrow Formulas', NULL),
(20, 'Optimum Nutrition Amino Energy', 'Pre-workout and amino acid supplement.', 'Optimum Nutrition Amino Energy provides essential amino acids and caffeine for energy, focus, and muscle recovery.', 7200.00, 'Pre-Workout', 'path/to/image16.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Optimum Nutrition', NULL),
(21, 'Nature\'s Way Alive! Multivitamin', 'Daily multivitamin for overall health.', 'Nature\'s Way Alive! Multivitamin is packed with essential vitamins, minerals, and antioxidants to support overall health and well-being.', 12500.00, 'Multivitamin', 'path/to/image17.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Nature\'s Way', NULL),
(22, 'ON Creatine Monohydrate', 'Pure creatine monohydrate for strength and power.', 'Optimum Nutrition Creatine Monohydrate helps increase muscle strength, power, and performance during high-intensity training.', 6800.00, 'Supplements', 'path/to/image18.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Optimum Nutrition', NULL),
(23, 'Quest Nutrition Protein Bar', 'High-protein bar with low sugar.', 'Quest Nutrition Protein Bar is a convenient, high-protein, low-sugar snack with 20g of protein and minimal carbohydrates.', 2500.00, 'Protein', 'path/to/image19.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Quest Nutrition', NULL),
(24, 'Vega One Organic All-In-One Shake', 'Plant-based protein and nutrient shake.', 'Vega One Organic All-In-One Shake is a plant-based meal replacement shake that provides protein, greens, vitamins, and minerals in one serving.', 16500.00, 'Protein', 'path/to/image20.jpg', '2024-09-28 05:07:29', '2024-09-28 05:07:29', 'Vega', NULL);

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
(7, 1, '2024-09-09 01:22:19'),
(5, 23, '2024-09-28 07:28:19'),
(5, 17, '2024-09-28 07:28:19'),
(5, 19, '2024-09-28 07:28:19'),
(5, 8, '2024-09-28 07:28:19'),
(5, 13, '2024-09-28 07:28:19'),
(5, 7, '2024-09-28 07:28:19'),
(5, 24, '2024-09-28 07:28:19'),
(5, 12, '2024-09-28 07:28:19'),
(5, 6, '2024-09-28 07:28:19'),
(5, 5, '2024-09-28 07:28:19');

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
(7, 5, 3, 5, 'Very Good Product', '2024-09-25 08:41:30'),
(9, 5, 5, 5, 'REVIEW-01: Verify user can submit a review for a purchased product.', '2024-09-28 08:29:27');

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
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(43, 6, 'Saturday'),
(42, 6, 'Thursday'),
(28, 7, 'Monday'),
(29, 7, 'Tuesday'),
(30, 7, 'Wednesday'),
(31, 7, 'Thursday'),
(32, 7, 'Friday'),
(33, 7, 'Saturday'),
(34, 7, 'Sunday'),
(35, 8, 'Monday'),
(36, 8, 'Tuesday'),
(37, 8, 'Wednesday'),
(38, 8, 'Thursday'),
(39, 8, 'Friday'),
(40, 8, 'Saturday'),
(41, 8, 'Sunday');

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
  `verification_code` varchar(255) DEFAULT NULL,
  `is_verified` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `role`, `password`, `created_at`, `offer_notifications`, `verification_code`, `is_verified`) VALUES
(21, 'newuser', 'newsuer', 'new@user.com', 'registered', '$2y$10$m34.eUACKgVubztpjs8ZK.CnTtk6kAv42UjNA27kqcIndteZwb69a', '2024-09-28 19:11:48', 'no', NULL, 'yes'),
(3, 'jane_smith', 'Jane Test', 'jane.smith@example.com', 'nutritional_expert', '$2y$10$Up7x0tr3ucSc0f7D1zEs8.tP/IeSwthDLjj//0n2oUyeLR7V16ob2', '2024-09-05 23:40:24', 'no', NULL, 'yes'),
(5, 'Himan', 'Himan M', 'hghimanmanduja@gmail.com', 'registered', '$2y$10$u6KQoT2RX.HVPsyvpnBYa.HLVA71YaOi9Tbt7vaoEqmmHkhQayBIm', '2024-09-06 00:44:38', 'no', NULL, 'yes'),
(7, 'admin', 'admin', 'admin@admin.com', 'admin', '$2y$10$LRYBh75259kMxLj/cWmITOLSSIygGyIjWMcArByZ/yi3cEVEUohfa', '2024-09-09 00:29:57', 'no', NULL, 'yes');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
