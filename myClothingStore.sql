-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2024 at 09:50 PM
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

DROP TABLE IF EXISTS `Admins`;
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

DROP TABLE IF EXISTS `Buyers`;
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
(1, 2, 4.5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
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
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
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
(1, 1, 1, 'new', 'pending', 'Men\'s Jacket', '', 49.99, 10, '', '', '', '', '', '2024-10-02 12:00:00'),
(2, 1, 2, 'used', 'approved', 'Women\'s Dress', '', 29.99, 5, '', '', '', '', '', '2024-10-02 12:00:00'),
(3, 1, 3, 'refurbished', 'pending', 'Children\'s T-Shirt', '', 15.00, 20, '', '', '', '', '', '2024-10-02 12:00:00'),
(4, 1, 4, 'new', 'rejected', 'Vintage Jeans', '', 59.99, 2, '', '', '', '', '', '2024-10-02 12:00:00'),
(5, 1, 5, 'used', 'pending', 'Designer Handbag', '', 199.99, 3, '', '', '', '', '', '2024-10-02 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Product_Images`
--

DROP TABLE IF EXISTS `Product_Images`;
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
(1, 1, 'fashion-1283863_1280.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(2, 2, 'freedom-1712590_1280.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(3, 3, 'toddler-7233172_1280.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(4, 4, 'woman-2799490_1280.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00'),
(5, 5, 'handbag-600398_1280.jpg', '2024-10-02 10:00:00', '2024-10-02 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Sellers`
--

DROP TABLE IF EXISTS `Sellers`;
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
(1, 5, 4.9, 15);

-- --------------------------------------------------------

--
-- Table structure for table `Shipping_Addresses`
--

DROP TABLE IF EXISTS `Shipping_Addresses`;
CREATE TABLE `Shipping_Addresses` (
  `shipping_address_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `recipient_name` varchar(100) NOT NULL,
  `address_line_1` varchar(100) NOT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `default_address` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

DROP TABLE IF EXISTS `Transactions`;
CREATE TABLE `Transactions` (
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `buyer_id` int(11) UNSIGNED NOT NULL,
  `seller_id` int(11) UNSIGNED NOT NULL,
  `payment_status` enum('Pending','Completed','Failed','Cancelled') NOT NULL,
  `transaction_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `shipping_status` enum('Pending','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `shipping_address` text NOT NULL,
  `payment_method` enum('Credit Card','Debit Card','PayPal','Bank Transfer') NOT NULL,
  `review_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `buyer_rating` float(2,1) DEFAULT NULL,
  `seller_rating` float(2,1) DEFAULT NULL,
  `buyer_feedback` text DEFAULT NULL,
  `seller_feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transaction_Products`
--

DROP TABLE IF EXISTS `Transaction_Products`;
CREATE TABLE `Transaction_Products` (
  `transaction_product_id` int(11) UNSIGNED NOT NULL,
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
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
(1, 'johndoe', 'john.doe@example.com', '$2y$10$K5y1YfD9GbeSefl6lrOnueRM/dXkUEZXaZHg1JCzOPce81HTTFTnO', 'John', 'Doe', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(2, 'janesmith', 'jane.smith@example.com', '$2y$10$/jazn/SLyK9b5SibrVM.DuZRAUZxnSjQhpCTr5/OG9g4Nztgy/F8i', 'Jane', 'Smith', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(3, 'bobjohnson', 'bob.johnson@example.com', '$2y$10$XPhkyrLrR79ph2kTDaB9ieG7KnjNxkkt6Q.LcIbL1C83PJ7nTSIEe', 'Bob', 'Johnson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(4, 'alicewilliams', 'alice.williams@example.com', '$2y$10$ewH51aciEINKBrS0rTnbDuAGm1lbR09NcS56pMaACiyoWK5seoEQW', 'Alice', 'Williams', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(5, 'charliebrown', 'charlie.brown@example.com', '$2y$10$ADhIoBTt8ng5gpeS/m0leOhmEjEtjfwu1yJGVb6UtH/9RU6p3FWym', 'Charlie', 'Brown', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(6, 'davidmiller', 'david.miller@example.com', '$2y$10$AWdw5nLUSNeC3ZxW2Hd4V.WRdxwZ3P4Ucx5wzgmpLQy7pP15YyIGC', 'David', 'Miller', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(7, 'sarajohnson', 'sara.johnson@example.com', '$2y$10$nC1W3zSf4ZHM8A14MmMC8Od0lEXfvAceCix8ms8cAw/gc4xAheOR2', 'Sara', 'Johnson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(8, 'kevinsmith', 'kevin.smith@example.com', '$2y$10$N5rrx0ZOOp.SLUGo.jBn8O.7n3DuF9piFRREDX76BZGmhp4yAeN.S', 'Kevin', 'Smith', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(9, 'lindawilson', 'linda.wilson@example.com', '$2y$10$TyLZKiXrqHvVzih82VV9yuon5DfJz/kO0lZWYx8mvv0yCG9bU7prG', 'Linda', 'Wilson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00'),
(10, 'markthompson', 'mark.thompson@example.com', '$2y$10$R/V4u4t6AJTtuB4Umkgqke3dDlGs6PXJuPZ9wbf4eUrklokGnuzIy', 'Mark', 'Thompson', '', '', '2024-09-30 10:00:00', '2024-09-30 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist_Items`
--

DROP TABLE IF EXISTS `Wishlist_Items`;
CREATE TABLE `Wishlist_Items` (
  `wishlist_item_id` int(11) UNSIGNED NOT NULL,
  `buyer_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Buyers`
--
ALTER TABLE `Buyers`
  ADD PRIMARY KEY (`buyer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

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
-- Indexes for table `Shipping_Addresses`
--
ALTER TABLE `Shipping_Addresses`
  ADD PRIMARY KEY (`shipping_address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `Transactions_ibfk_1` (`buyer_id`),
  ADD KEY `Transactions_ibfk_2` (`seller_id`);

--
-- Indexes for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  ADD PRIMARY KEY (`transaction_product_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `Transaction_Products_ibfk_2` (`product_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `Wishlist_Items`
--
ALTER TABLE `Wishlist_Items`
  ADD PRIMARY KEY (`wishlist_item_id`),
  ADD KEY `Wishlist_Items_ibfk_1` (`buyer_id`),
  ADD KEY `Wishlist_Items_ibfk_2` (`product_id`);

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
  MODIFY `buyer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Product_Images`
--
ALTER TABLE `Product_Images`
  MODIFY `product_image_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Sellers`
--
ALTER TABLE `Sellers`
  MODIFY `seller_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Shipping_Addresses`
--
ALTER TABLE `Shipping_Addresses`
  MODIFY `shipping_address_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `transaction_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  MODIFY `transaction_product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Wishlist_Items`
--
ALTER TABLE `Wishlist_Items`
  MODIFY `wishlist_item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Admins`
--
ALTER TABLE `Admins`
  ADD CONSTRAINT `Admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Buyers`
--
ALTER TABLE `Buyers`
  ADD CONSTRAINT `Buyers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `Transactions_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `Buyers` (`buyer_id`),
  ADD CONSTRAINT `Transactions_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`);

--
-- Constraints for table `Transaction_Products`
--
ALTER TABLE `Transaction_Products`
  ADD CONSTRAINT `Transaction_Products_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `Transactions` (`transaction_id`),
  ADD CONSTRAINT `Transaction_Products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);

--
-- Constraints for table `Wishlist_Items`
--
ALTER TABLE `Wishlist_Items`
  ADD CONSTRAINT `Wishlist_Items_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `Buyers` (`buyer_id`),
  ADD CONSTRAINT `Wishlist_Items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
