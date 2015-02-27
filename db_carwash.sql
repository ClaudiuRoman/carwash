-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2015 at 11:06 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.17-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_carwash`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licence_plate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_subscription` tinyint(1) NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `wash_washCounter` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `licence_plate`, `has_subscription`, `started_at`, `wash_washCounter`) VALUES
(1, 'BT01PHP', 0, NULL, 0),
(2, 'BT02PHP', 0, NULL, 0),
(3, 'BT03PHP', 1, '2015-02-22 11:59:45', 0),
(4, 'BT04PHP', 1, '2015-02-06 12:36:13', 0),
(5, 'BT05PHP', 1, '2015-02-21 05:34:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E52FFDEE2B5CA896` (`receipt_id`),
  KEY `IDX_E52FFDEE19EB6921` (`client_id`),
  KEY `IDX_E52FFDEEA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `user_id`, `receipt_id`, `created_at`) VALUES
(1, 5, 1, NULL, '2015-02-26 07:21:50'),
(2, 5, 1, NULL, '2015-02-26 20:46:21'),
(3, 1, 1, NULL, '2015-02-26 02:48:23'),
(4, 4, 1, NULL, '2015-02-26 16:41:09'),
(5, 1, 2, NULL, '2015-02-27 07:29:23'),
(6, 5, 2, NULL, '2015-02-26 02:13:00'),
(7, 1, 1, NULL, '2015-02-26 19:37:15'),
(8, 5, 3, NULL, '2015-02-27 04:39:43'),
(9, 2, 3, NULL, '2015-02-27 03:57:38'),
(10, 1, 3, NULL, '2015-02-27 16:19:44'),
(11, 5, 1, NULL, '2015-02-27 22:14:07'),
(12, 4, 2, NULL, '2015-02-26 03:22:08'),
(13, 3, 2, NULL, '2015-02-27 06:20:52'),
(14, 1, 3, NULL, '2015-02-27 22:20:09'),
(15, 4, 1, NULL, '2015-02-27 02:33:50'),
(16, 4, 2, NULL, '2015-02-27 17:13:23'),
(17, 2, 2, NULL, '2015-02-26 13:12:21'),
(18, 1, 2, NULL, '2015-02-27 04:41:25'),
(19, 5, 2, NULL, '2015-02-27 03:50:04'),
(20, 1, 2, NULL, '2015-02-27 20:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `IDX_2530ADE68D9F6D38` (`order_id`),
  KEY `IDX_2530ADE64584665A` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`) VALUES
(1, 2),
(2, 1),
(3, 4),
(4, 1),
(5, 4),
(6, 4),
(7, 3),
(8, 1),
(9, 1),
(10, 5),
(11, 4),
(12, 6),
(13, 3),
(14, 6),
(15, 4),
(16, 3),
(17, 4),
(18, 2),
(19, 5),
(20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'inside', 39),
(2, 'outside', 28),
(3, 'engine', 47),
(4, 'detailing', 24),
(5, 'rims', 43),
(6, 'waxing', 23);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `criteria` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `criteria`, `active`) VALUES
(1, 'Promotion 1', 5, 0),
(2, 'Promotion 2', 3, 0),
(3, 'Promotion 3', 6, 0),
(4, 'Promotion 4', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE IF NOT EXISTS `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `first_name`, `last_name`) VALUES
(1, 'user-1', 'user-1', 'user-1', 'user-1', 1, '2xnq5uw10q804w8gw4ocgwkockgg88w', 'UHiqdE4d072Iu6hOyb6H00EOqkk8axeY/kKbcDyrbbFDSm7d/PArZg6I7SmIEw6r8Mqyj+FEpY/YCEzaXde97w==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'Adrien', 'Halvorson'),
(2, 'user-2', 'user-2', 'user-2', 'user-2', 1, '5q0b0gddw8g88ksggckoso0c4gggww0', 'njVjEMAaOz8kTdaroUhLeI2Z7LM/tB87xisny4MqHI/KT/xpwtOxAy7ZNndK9Y17977+UcqNf3pAvDYJ7Q7cMw==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'Fletcher', 'Heaney'),
(3, 'user-3', 'user-3', 'user-3', 'user-3', 1, '9dpsbskioqo0g80oow0sgwosgwkw4ss', 'P+/QjFaj3UNFOogamIoQRYWNTflcaFJjqdlbfY2GWbKOQyehUW5UyFKR92CO8V+tSqycsa9qiizNRKtYUPFsWg==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'Nakia', 'Beahan');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE2B5CA896` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`),
  ADD CONSTRAINT `FK_E52FFDEE19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `FK_2530ADE64584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2530ADE68D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
