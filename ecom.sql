-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2025 at 12:08 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int NOT NULL,
  `brand_title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Gucci'),
(2, 'Apple'),
(3, 'Samsung'),
(4, 'Nike'),
(5, 'Dairy Milk'),
(6, 'Nothing'),
(7, 'LG'),
(8, 'Sony'),
(9, 'Canon'),
(10, 'Adidas'),
(11, 'KitchenAid'),
(12, 'Hershey’s'),
(13, 'Reebok');

-- --------------------------------------------------------

--
-- Table structure for table `cateogries`
--

CREATE TABLE `cateogries` (
  `category_id` int NOT NULL,
  `category_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cateogries`
--

INSERT INTO `cateogries` (`category_id`, `category_title`) VALUES
(1, 'Food'),
(2, 'Grocery'),
(3, 'Clothes'),
(4, 'Electronics'),
(5, 'Shoes');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `created_at`) VALUES
(1, 'Parakram', 'Kharel', 'contact@parakram.me', '9865321470', 'Si-Na-Pa-20, Bhairahawa', 'Siddharthanagar', 'Lumbini', '32900', 'Nepal', '2025-10-07 10:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_mode` varchar(50) NOT NULL DEFAULT 'cod',
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `total_amount`, `payment_mode`, `status`, `created_at`) VALUES
(1, 'ORD-2001', NULL, 0.00, 'cod', 'pending', '2025-11-06 10:34:02'),
(2, 'ORD-2002', NULL, 0.00, 'card', 'paid', '2025-11-07 10:34:02'),
(3, 'ORD-2003', NULL, 0.00, 'card', 'processing', '2025-11-08 10:34:02'),
(4, 'ORD-2004', NULL, 0.00, 'cod', 'shipped', '2025-11-09 10:34:02'),
(5, 'ORD-2005', NULL, 0.00, 'card', 'delivered', '2025-11-10 10:34:02'),
(6, 'ORD-2006', NULL, 0.00, 'card', 'cancelled', '2025-11-11 10:34:02'),
(7, 'ORD-2007', NULL, 0.00, 'cod', 'pending', '2025-11-11 22:34:02'),
(8, 'ORD-2008', NULL, 0.00, 'card', 'processing', '2025-11-12 08:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(3, 1, 6, 1, 8499.00),
(4, 1, 8, 2, 10999.00),
(5, 2, 9, 2, 1499.00),
(6, 2, 10, 1, 5799.00),
(7, 3, 11, 1, 7999.00),
(8, 3, 12, 3, 2299.00),
(9, 4, 13, 1, 9999.00),
(10, 4, 14, 1, 6999.00),
(11, 4, 15, 2, 3499.00),
(12, 5, 16, 1, 11999.00),
(13, 5, 17, 2, 1799.00),
(14, 6, 18, 1, 12999.00),
(15, 7, 19, 1, 6299.00),
(16, 7, 20, 1, 4499.00),
(17, 7, 21, 1, 9999.00),
(18, 8, 22, 2, 2199.00),
(19, 8, 23, 1, 5699.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `date` timestamp NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`) VALUES
(6, 'MacBook Air', 'SPEED OF LIGHTNESS — MacBook Air with the M4 chip lets you blaze through work and play. With Apple Intelligence,* up to 18 hours of battery life,* and an incredibly portable design, you can take on anything, anywhere.', 'm4,13-inch,ssd,macbook', 4, 2, '68e4e9306ed26_mac2.jpg', '68e4e9306ed26_mac2.jpg', '68e4e93072cf0_mac3.jpg', '104200', '2025-10-07 10:19:28', 'true'),
(8, 'Nothing Phone (3a) Pro', '8 GB RAM | 128 GB ROM\r\n43.66 cm (17.19 cm) Full HD+ Display\r\n50MP (Main) + 50MP (3X Periscope)+ 8MP (Ultra-Wide) | 50MP Front Camera\r\n5000 mAh Battery\r\n7s Gen3 Processor', 'Snadragon, Nothing', 4, 6, '6913d10f2cb3e_nothing3.webp', '6913d10f302c9_nothing2.jpeg', '6913d10f33d0c_nothin1.jpeg', '62000', '2025-11-12 00:13:03', 'true'),
(9, 'Gucci Leather Jacket', 'Premium black leather jacket with embossed Gucci logo and modern fit.', 'gucci, jacket, leather, clothes', 3, 1, 'gucci_1.jpg', 'gucci_2.jpg', 'gucci_3.jpg', '799.99', '2025-11-12 00:31:14', 'true'),
(10, 'Apple iPhone 15 Pro', 'Apple iPhone 15 Pro with A17 chip, 128GB storage, titanium body, and triple camera setup.', 'iphone, apple, smartphone, electronics', 4, 2, 'iphone15_1.jpg', 'iphone15_2.jpg', 'iphone15_3.jpg', '1199.00', '2025-11-12 00:31:14', 'true'),
(11, 'Samsung Galaxy S24 Ultra', 'Samsung flagship smartphone featuring a 200MP camera, S Pen, and dynamic AMOLED display.', 'samsung, galaxy, smartphone, electronics', 4, 3, 's24ultra_1.jpg', 's24ultra_2.jpg', 's24ultra_3.jpg', '1099.00', '2025-11-12 00:31:14', 'true'),
(12, 'Nike Air Max 270', 'Comfortable running shoes with Air Max cushioning and sleek athletic design.', 'nike, shoes, running, airmax', 5, 4, 'nike_airmax270_1.jpg', 'nike_airmax270_2.jpg', 'nike_airmax270_3.jpg', '149.99', '2025-11-12 00:31:14', 'true'),
(13, 'Cadbury Dairy Milk Chocolate Bar', 'Smooth and creamy milk chocolate bar from Cadbury, a delightful treat for all ages.', 'chocolate, dairy milk, food, sweet', 1, 5, 'dairymilk_1.jpg', 'dairymilk_2.jpg', 'dairymilk_3.jpg', '2.49', '2025-11-12 00:31:14', 'true'),
(14, 'Nothing Ear (2)', 'Wireless earbuds by Nothing with clear transparent design and active noise cancellation.', 'nothing, earbuds, audio, electronics', 4, 6, 'nothingear2_1.jpg', 'nothingear2_2.jpg', 'nothingear2_3.jpg', '129.00', '2025-11-12 00:31:14', 'true'),
(15, 'Sony WH-1000XM5 Wireless Headphones', 'Industry leading noise cancelling over-ear headphones from Sony with 30 hours battery life.', 'sony, headphones, wireless, audio, electronics', 4, 8, 'sony_wh1000xm5_1.jpg', 'sony_wh1000xm5_2.jpg', 'sony_wh1000xm5_3.jpg', '399.99', '2025-11-12 00:32:47', 'true'),
(16, 'LG OLED C3 65\" Television', 'LG C3 Series 65 inch OLED 4K TV with self-lit pixels and HDMI 2.1 support.', 'lg, tv, oled, 4k, electronics', 4, 7, 'lg_oled_c3_65_1.jpg', 'lg_oled_c3_65_2.jpg', 'lg_oled_c3_65_3.jpg', '2199.00', '2025-11-12 00:32:47', 'true'),
(17, 'Adidas Ultraboost 22 Shoes', 'High performance running shoes with Boost cushioning and Primeknit upper.', 'adidas, shoes, running, ultraboost', 5, 10, 'ultraboost22_1.jpg', 'ultraboost22_2.jpg', 'ultraboost22_3.jpg', '179.99', '2025-11-12 00:32:47', 'true'),
(18, 'KitchenAid Artisan 5-Qt Mixer', 'Classic KitchenAid mixer with 5-quart bowl in vibrant red — perfect for home bakers.', 'kitchenaid, mixer, appliance, kitchen, electronics', 4, 11, 'kitchenaid_artisan5qt_1.jpg', 'kitchenaid_artisan5qt_2.jpg', 'kitchenaid_artisan5qt_3.jpg', '429.00', '2025-11-12 00:32:47', 'true'),
(19, 'Reebok Nano X4 Cross Trainer', 'Cross training shoes designed for functional workouts, durable and versatile.', 'reebok, shoes, cross-trainer, fitness', 5, 13, 'reebok_nano_x4_1.jpg', 'reebok_nano_x4_2.jpg', 'reebok_nano_x4_3.jpg', '139.99', '2025-11-12 00:32:47', 'true'),
(20, 'Canon EOS R10 Mirrorless Camera', 'Compact mirrorless camera from Canon with 24MP APS-C sensor and 4K video.', 'canon, camera, photography, electronics', 4, 9, 'canon_eos_r10_1.jpg', 'canon_eos_r10_2.jpg', 'canon_eos_r10_3.jpg', '979.00', '2025-11-12 00:32:47', 'true'),
(21, 'Hershey’s Kisses Milk Chocolates 200g', 'Bag of Hershey’s Kisses milk chocolates, great for sharing.', 'hersheys, chocolate, food, sweet, dairy', 1, 12, 'hersheys_kisses_200g_1.jpg', 'hersheys_kisses_200g_2.jpg', 'hersheys_kisses_200g_3.jpg', '5.49', '2025-11-12 00:32:47', 'true'),
(22, 'Nike Dri-FIT Legend T-Shirt', 'Comfortable Nike Dri-FIT performance t-shirt for training and sports.', 'nike, t-shirt, clothes, performance', 3, 4, 'nike_dri_fit_legend_tshirt_1.jpg', 'nike_dri_fit_legend_tshirt_2.jpg', 'nike_dri_fit_legend_tshirt_3.jpg', '29.99', '2025-11-12 00:32:47', 'true'),
(23, 'Samsung Galaxy Watch 6 Classic', 'Premium smartwatch from Samsung with rotating bezel, ECG, and long battery life.', 'samsung, smartwatch, wearables, electronics', 4, 3, 'galaxy_watch6_classic_1.jpg', 'galaxy_watch6_classic_2.jpg', 'galaxy_watch6_classic_3.jpg', '349.99', '2025-11-12 00:32:47', 'true');

-- --------------------------------------------------------

--
-- Stand-in structure for view `test`
-- (See below for the actual view)
--
CREATE TABLE `test` (
`product_id` int
,`product_title` varchar(100)
,`product_description` varchar(255)
,`product_keywords` varchar(255)
,`category_id` int
,`brand_id` int
,`product_image1` varchar(255)
,`product_image2` varchar(255)
,`product_image3` varchar(255)
,`product_price` varchar(100)
,`date` timestamp
,`status` varchar(100)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cateogries`
--
ALTER TABLE `cateogries`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `idx_orders_status_created` (`status`,`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cateogries`
--
ALTER TABLE `cateogries`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

-- --------------------------------------------------------

--
-- Structure for view `test`
--
DROP TABLE IF EXISTS `test`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `test`  AS SELECT `products`.`product_id` AS `product_id`, `products`.`product_title` AS `product_title`, `products`.`product_description` AS `product_description`, `products`.`product_keywords` AS `product_keywords`, `products`.`category_id` AS `category_id`, `products`.`brand_id` AS `brand_id`, `products`.`product_image1` AS `product_image1`, `products`.`product_image2` AS `product_image2`, `products`.`product_image3` AS `product_image3`, `products`.`product_price` AS `product_price`, `products`.`date` AS `date`, `products`.`status` AS `status` FROM `products` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
