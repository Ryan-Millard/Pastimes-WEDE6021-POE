-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2024 at 01:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pastimes`
--
CREATE DATABASE IF NOT EXISTS `pastimes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pastimes`;

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `admin_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`admin_id`, `user_id`, `role`) VALUES
(1, 1, 'Super Admin'),
(2, 4, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `Buyers`
--

CREATE TABLE `Buyers` (
  `buyer_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `buyer_rating` float DEFAULT NULL,
  `total_purchases` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Buyers`
--

INSERT INTO `Buyers` (`buyer_id`, `user_id`, `buyer_rating`, `total_purchases`) VALUES
(1, 2, 4.5, 10),
(2, 3, 2.5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Men\'s Clothing', 'Second-hand men\'s apparel'),
(2, 'Women\'s Clothing', 'Second-hand women\'s apparel'),
(3, 'Children\'s Clothing', 'Second-hand children\'s apparel'),
(4, 'Vintage Clothing', 'Second-hand vintage styles'),
(5, 'Designer Clothing', 'Second-hand designer brands');

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `seen_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`message_id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `seen`, `seen_at`) VALUES
(1, 1, 2, 'Hello. How are you?', '2024-11-06 07:00:00', 0, NULL),
(2, 2, 1, 'I\'m good. Thanks for asking!', '2024-11-06 07:05:00', 0, NULL),
(3, 1, 3, 'Hey. Are you available for a meeting?', '2024-11-06 07:10:00', 0, '2024-11-06 07:15:00'),
(4, 3, 1, 'Yes. I\'m free. Let\'s talk later.', '2024-11-06 07:12:00', 0, '2024-11-06 07:16:00'),
(5, 2, 3, 'Can you send me the report?', '2024-11-06 07:20:00', 0, NULL),
(6, 3, 2, 'Sure. I\'ll send it to you shortly.', '2024-11-06 07:25:00', 0, '2024-11-06 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `product_id` int(11) UNSIGNED NOT NULL,
  `seller_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `product_condition` enum('new','used','refurbished') NOT NULL,
  `product_status` enum('pending','approved','rejected') NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `date_listed` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`product_id`, `seller_id`, `category_id`, `product_condition`, `product_status`, `product_name`, `description`, `price`, `quantity_available`, `size`, `color`, `brand`, `material`, `tags`, `date_listed`) VALUES
(1, 1, 1, 'new', 'approved', 'Men\'s Jacket', '', 49.99, 10, '', '', '', '', '', '2024-10-02 12:00:00'),
(2, 3, 2, 'used', 'approved', 'Women\'s Dress', '', 29.99, 5, '', '', '', '', '', '2024-10-02 12:00:00'),
(3, 1, 3, 'refurbished', 'approved', 'Children\'s T-Shirt', '', 15.00, 20, '', '', '', '', '', '2024-10-02 12:00:00'),
(4, 2, 4, 'new', 'approved', 'Vintage Jeans', '', 59.99, 2, '', '', '', '', '', '2024-10-02 12:00:00'),
(5, 3, 5, 'used', 'approved', 'Designer Handbag', '', 199.99, 3, '', '', '', '', '', '2024-10-02 12:00:00'),
(6, 3, 2, 'used', 'pending', 'Leather Jacket', '', 500.00, 7, '', '', '', '', '', '2024-11-01 12:00:00'),
(7, 3, 2, 'refurbished', 'pending', 'Blue Jacket', '', 295.15, 2, 'small', 'blue', '', '', '', '2024-11-01 12:00:00'),
(8, 1, 1, 'new', 'pending', 'Light Blue Men\'s Cotton Shirt', '', 250.00, 4, 'medium', 'blue', '', '', '', '2024-11-01 12:00:00'),
(9, 1, 3, 'new', 'pending', 'Children\'s Shirts (Assorted Colors)', '', 148.75, 4, '', '', '', '', '', '2024-11-01 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Product_Images`
--

CREATE TABLE `Product_Images` (
  `product_image_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `product_image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Product_Images`
--

INSERT INTO `Product_Images` (`product_image_id`, `product_id`, `product_image_url`, `created_at`, `updated_at`) VALUES
(1, 1, '6735e6fe9aa1d.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(2, 2, '6735e6feba9f9.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(3, 3, '6735e6feca730.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(4, 4, '6735e6fee209f.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(5, 5, '6735e6fef0b89.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(6, 6, '6735e6ff09d8b.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(7, 7, '6735e6ff14b43.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(8, 8, '6735e6ff1ff38.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(9, 9, '6735e6ff2890f.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Sellers`
--

CREATE TABLE `Sellers` (
  `seller_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `seller_rating` float DEFAULT NULL,
  `total_sales` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Sellers`
--

INSERT INTO `Sellers` (`seller_id`, `user_id`, `seller_rating`, `total_sales`) VALUES
(1, 5, 4.9, 15),
(2, 7, 2.2, 35),
(3, 10, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `buyer_id` int(11) UNSIGNED NOT NULL,
  `transaction_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` enum('Credit Card','Debit Card','PayPal','Bank Transfer') NOT NULL,
  `reference_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`transaction_id`, `buyer_id`, `transaction_datetime`, `total_price`, `shipping_address`, `payment_method`, `reference_number`) VALUES
(1, 1, '2024-11-10 12:00:00', 150.00, '123 Main St City Country', 'Credit Card', 'REF-2024-000001-69f021e607bea1701544abe9589b0e0d'),
(2, 2, '2024-11-11 14:30:00', 200.75, '456 Oak St Town Country', 'PayPal', 'REF-2024-000002-e95cd34d641bb6b492828b3b47776b8c'),
(3, 1, '2024-11-12 16:00:00', 99.99, '789 Pine St Village Country', 'Debit Card', 'REF-2024-000003-519ba427fa76d7f746a0eb71e20430b3'),
(4, 2, '2024-11-13 10:15:00', 250.00, '101 Maple St Suburb Country', 'Bank Transfer', 'REF-2024-000004-903e55aeb8504e1a826a49cce07ac7e9'),
(5, 1, '2024-11-14 18:45:00', 300.25, '202 Birch Rd City Country', 'Credit Card', 'REF-2024-000005-de3d73ef76ff2a69c97f93e21536c366'),
(6, 2, '2024-11-15 09:30:00', 120.50, '303 Cedar Blvd Town Country', 'PayPal', 'REF-2024-000006-5312aca35cb508280c0369c9875f6822'),
(7, 1, '2024-11-16 11:00:00', 450.00, '404 Elm St Village Country', 'Debit Card', 'REF-2024-000007-eee575f85bc6833c4991e7713337d2ab'),
(8, 1, '2024-11-17 15:30:00', 350.00, '505 Oakwood Ave Suburb Country', 'Bank Transfer', 'REF-2024-000008-719adfcab00dc0012659ca80f570e4e5');

-- --------------------------------------------------------

--
-- Table structure for table `Transaction_Products`
--

CREATE TABLE `Transaction_Products` (
  `transaction_product_id` int(11) UNSIGNED NOT NULL,
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Transaction_Products`
--

INSERT INTO `Transaction_Products` (`transaction_product_id`, `transaction_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 2, 3, 3),
(4, 2, 4, 1),
(5, 3, 5, 1),
(6, 4, 1, 2),
(7, 4, 2, 1),
(8, 5, 3, 4),
(9, 6, 4, 2),
(10, 6, 5, 1),
(11, 7, 1, 3),
(12, 7, 2, 2),
(13, 8, 2, 1),
(14, 8, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `bio`, `phone_number`, `registration_date`, `last_login`) VALUES
(1, 'johndoe', 'john.doe@example.com', '$2y$10$WDUUGu6Wv5M7PDocUln8duuTE/8K2eWAoEmjAWzQvZJLnG8dR9DyG', 'John', 'Doe', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(2, 'janesmith', 'jane.smith@example.com', '$2y$10$ijTfmkTwKrdcaeUCWg1G6uqgbdZTvT4QuL4Avbzd0Ak2o12OrK3yW', 'Jane', 'Smith', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(3, 'bobjohnson', 'bob.johnson@example.com', '$2y$10$d62BGLxE2.Z4jR7HCMyP/u8z1oX0LI0GRN8P4JwAY3dAdZBp9K2bG', 'Bob', 'Johnson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(4, 'alicewilliams', 'alice.williams@example.com', '$2y$10$BPlAIOvKhpXWYPdpROe0ouHTvgR03sMgLf0eMYaRAljLlVrrtZgwO', 'Alice', 'Williams', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(5, 'charliebrown', 'charlie.brown@example.com', '$2y$10$J5VM50Gl.b7qRGy3JxUHouLehTQ7W1/cXNbp3dniOj06x/dNLH1Qy', 'Charlie', 'Brown', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(6, 'davidmiller', 'david.miller@example.com', '$2y$10$6wm49SSMbnuJITEwkjjcxuBWt/AE37doqkboEVq50uQqwG1ng7y6y', 'David', 'Miller', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(7, 'sarajohnson', 'sara.johnson@example.com', '$2y$10$0faKR01o7PN4Nj1ePbPsX.Ds5DgfdQLi1/.gga1WQMbXBg4tIiLsG', 'Sara', 'Johnson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(8, 'kevinsmith', 'kevin.smith@example.com', '$2y$10$CeQ.I.Wo5uVpB0FFXdbiIOQVpefWwHtvslWPdMnLpPepwwACh0HvS', 'Kevin', 'Smith', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(9, 'lindawilson', 'linda.wilson@example.com', '$2y$10$YrlbApHz.FX/LPkgdljk2u4ml5UvJe8jAPLxio56Qi9Dd6n9YP66e', 'Linda', 'Wilson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(10, 'markthompson', 'mark.thompson@example.com', '$2y$10$V9DthPzgSCOVIKRvly0gIu3l0xYBTeKHKUnVFlaJqHX5okjn7PJgq', 'Mark', 'Thompson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist`
--

CREATE TABLE `Wishlist` (
  `wishlist_item_id` int(11) UNSIGNED NOT NULL,
  `buyer_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Wishlist`
--

INSERT INTO `Wishlist` (`wishlist_item_id`, `buyer_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 1, 5, 1),
(4, 2, 1, 4),
(6, 2, 3, 1),
(7, 2, 4, 6),
(8, 2, 5, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `Admins_ibfk_1` (`user_id`);

--
-- Indexes for table `Buyers`
--
ALTER TABLE `Buyers`
  ADD PRIMARY KEY (`buyer_id`),
  ADD KEY `Buyers_ibfk_1` (`user_id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `Product_Images`
--
ALTER TABLE `Product_Images`
  ADD PRIMARY KEY (`product_image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Sellers`
--
ALTER TABLE `Sellers`
  ADD PRIMARY KEY (`seller_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  ADD PRIMARY KEY (`transaction_product_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD PRIMARY KEY (`wishlist_item_id`),
  ADD UNIQUE KEY `unique_wishlist_item` (`buyer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `admin_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Buyers`
--
ALTER TABLE `Buyers`
  MODIFY `buyer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Product_Images`
--
ALTER TABLE `Product_Images`
  MODIFY `product_image_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Sellers`
--
ALTER TABLE `Sellers`
  MODIFY `seller_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `transaction_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  MODIFY `transaction_product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Wishlist`
--
ALTER TABLE `Wishlist`
  MODIFY `wishlist_item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Admins`
--
ALTER TABLE `Admins`
  ADD CONSTRAINT `Admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Buyers`
--
ALTER TABLE `Buyers`
  ADD CONSTRAINT `Buyers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`),
  ADD CONSTRAINT `Products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

--
-- Constraints for table `Product_Images`
--
ALTER TABLE `Product_Images`
  ADD CONSTRAINT `Product_Images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `Sellers`
--
ALTER TABLE `Sellers`
  ADD CONSTRAINT `Sellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `fk_buyer_id` FOREIGN KEY (`buyer_id`) REFERENCES `Buyers` (`buyer_id`);

--
-- Constraints for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`),
  ADD CONSTRAINT `fk_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `Transactions` (`transaction_id`);

--
-- Constraints for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD CONSTRAINT `Wishlist_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `Buyers` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
