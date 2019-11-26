-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2019 at 07:04 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `combined_modules`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `userName` varchar(30) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userName`, `password`) VALUES
(1000, 'abcd', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `api_table`
--

CREATE TABLE `api_table` (
  `id` int(2) NOT NULL,
  `salt` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_table`
--

INSERT INTO `api_table` (`id`, `salt`) VALUES
(1, '9572ebca35bb293297d9699e473add1cdbf2a6a2'),
(2, '52819573c775b14a6c442d53effee3d35a69a44f'),
(3, '38d5488fd7499a251b85921fb53f3c7f1793ff73');

-- --------------------------------------------------------

--
-- Table structure for table `cart_table`
--

CREATE TABLE `cart_table` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `source_id` int(11) NOT NULL,
  `items_added` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart_table`
--

INSERT INTO `cart_table` (`id`, `customer_id`, `source_id`, `items_added`, `time_stamp`) VALUES
(4, 1, 1, '[{\"id\":1,\"quantity\":1,\"name\":\"mobile\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', '2019-10-14 17:31:48'),
(7, 2, 1, 'null', '2019-10-15 02:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(3) NOT NULL,
  `cat_id` varchar(10) NOT NULL,
  `Category_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_id`, `Category_name`) VALUES
(1, '1', 'mobiles'),
(2, '2', 'Laptops'),
(3, '3', 'watches'),
(4, '4', 'shoes');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `coupon_code` varchar(8) DEFAULT NULL,
  `MaxusePC` int(2) NOT NULL,
  `Discount%` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `category_id`, `coupon_code`, `MaxusePC`, `Discount%`) VALUES
(1, 1, 'BOX100', 2, '20'),
(2, 2, 'GAME500', 2, '30'),
(3, 3, 'AC5000', 2, '10'),
(4, 4, 'MOB3000', 2, '15');

-- --------------------------------------------------------

--
-- Table structure for table `couponsubscription`
--

CREATE TABLE `couponsubscription` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `UseCount` int(11) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `couponsubscription`
--

INSERT INTO `couponsubscription` (`id`, `customer_id`, `coupon_id`, `UseCount`, `time_stamp`) VALUES
(1, 1, 2, 2, '2019-10-15 07:12:41'),
(2, 1, 1, 2, '2019-10-15 07:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `customertable`
--

CREATE TABLE `customertable` (
  `id` int(3) NOT NULL,
  `customer_mobile` varchar(12) DEFAULT NULL,
  `DateOfJoining` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customertable`
--

INSERT INTO `customertable` (`id`, `customer_mobile`, `DateOfJoining`) VALUES
(181, '7025459380', '2019-10-17 09:42:17'),
(182, '7025459381', '2019-10-17 11:43:27'),
(183, '8113997239', '2019-11-26 13:13:52'),
(184, '8113997240', '2019-11-26 13:16:09'),
(185, '7025459387', '2019-11-26 13:45:15'),
(186, '7025459388', '2019-11-26 14:11:06'),
(187, '70254593856', '2019-11-26 17:45:46');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `deliveryBoyId` int(11) NOT NULL,
  `getItems` text NOT NULL,
  `Accepted` varchar(10) NOT NULL,
  `Cancelled` varchar(10) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `customer_id`, `deliveryBoyId`, `getItems`, `Accepted`, `Cancelled`, `time_stamp`) VALUES
(15, 1, 1, '[{\"id\":1,\"quantity\":1,\"name\":\"laptop\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'true', 'true', '2019-10-11 07:11:04'),
(26, 2, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"laptop\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'false', 'false', '2019-10-11 07:06:22'),
(27, 1, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"desktop\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'true', 'false', '2019-10-23 08:47:38'),
(28, 1, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"desktop\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'true', 'false', '2019-10-23 08:47:41'),
(29, 1, 2, '[{\"id\":2,\"quantity\":1,\"name\":\"television\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'false', 'true', '2019-11-05 08:47:43'),
(30, 1, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"television\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'false', 'false', '2019-11-06 08:47:48'),
(31, 1, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"shampoo\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'true', 'false', '2019-11-06 08:47:51'),
(32, 1, 2, '[{\"id\":2,\"quantity\":1,\"name\":\"shampoo\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'false', 'true', '2019-11-21 08:47:54'),
(33, 1, 1, '[{\"id\":2,\"quantity\":1,\"name\":\"mobile\"},{\"id\":2,\"quantity\":1,\"name\":\"mobile\"}]', 'false', 'false', '2019-11-21 08:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `deliveryinfo`
--

CREATE TABLE `deliveryinfo` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `HomeAddress` text DEFAULT NULL,
  `WorkAddress` text DEFAULT NULL,
  `Other` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliveryinfo`
--

INSERT INTO `deliveryinfo` (`id`, `customer_id`, `HomeAddress`, `WorkAddress`, `Other`) VALUES
(1, 1, '{\"customerAddress\":\"103\\/06\\r\\nIncubation Center\\r\\nHMT. Kalamaserry\",\"deliveryPincode\":\"123456\",\"landmark\":\"AISAT\",\"mobileNumber\":\"9546897565\"}', '{\"customerAddress\":\"work\\/103-11c-06\",\"deliveryPincode\":\"4567889\",\"landmark\":\"Aisat\",\"mobileNumber\":\"[object Object]\"}', '{\"customerAddress\":\"kochi\",\"deliveryPincode\":\"1234\",\"landmark\":\"aisat\",\"mobileNumber\":\"123456776\"}');

-- --------------------------------------------------------

--
-- Table structure for table `distributor_table`
--

CREATE TABLE `distributor_table` (
  `id` int(3) NOT NULL,
  `dist_id` int(10) NOT NULL,
  `dist_name` varchar(20) DEFAULT NULL,
  `dist_mobile` varchar(10) DEFAULT NULL,
  `joined_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `coordinates` varchar(50) NOT NULL,
  `rating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributor_table`
--

INSERT INTO `distributor_table` (`id`, `dist_id`, `dist_name`, `dist_mobile`, `joined_date`, `coordinates`, `rating`) VALUES
(1, 1, 'classic', '7894561230', '2019-10-18 10:19:29', '{\"latitude\":\"10.050628\",\"longitude\":\"76.331167\"}', 5),
(2, 2, 'metro', '1234567890', '2019-10-18 10:19:29', '{\"latitude\":\"10.054074\",\"longitude\":\"76.332875\"}', 4),
(3, 3, 'plannet', '1478963250', '2019-10-18 10:19:29', '{\"latitude\":\"9.843232\",\"longitude\":\"76.327082\"}', 3),
(4, 4, 'modern', '8528528528', '2019-10-18 10:19:29', '{\"latitude\":\"10.088467\",\"longitude\":\"76.362737\"}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `product_name` varchar(20) DEFAULT NULL,
  `product_image` varchar(20) DEFAULT NULL,
  `product_price` int(10) DEFAULT NULL,
  `max_discount` int(11) NOT NULL,
  `min_discount` int(11) NOT NULL,
  `product_tags` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `dist_id`, `product_name`, `product_image`, `product_price`, `max_discount`, `min_discount`, `product_tags`) VALUES
(1000, 1, 1, 'Desktop', 'demo.jpg', 10000, 1, 100, 'OK Ok'),
(1001, 1, 1, 'Desktop', 'demo.jpg', 10000, 1, 100, 'OK Ok'),
(1004, 1, 1, 'Mobile', 'BOHC29211.jpg', 15000, 1000, 500, 'Cheap, HD quality'),
(1005, 1, 1, 'ToolBox', 'IMG_9042.JPG', 800, 200, 80, 'Light Weight, Easy to use'),
(1006, 1, 1, 'Mobile', 'BOHC2921.jpg', 15000, 1000, 500, 'Cheap, HD quality'),
(1007, 1, 1, 'laptop', 'demo.jpg', 30000, 20, 10, 'ok'),
(1008, 1, 1, 'laptop', 'demo.jpg', 30000, 20, 10, 'ok'),
(1009, 1, 1, 'laptop', 'demo.jpg', 30000, 20, 10, 'ok'),
(1010, 1, 1, 'laptop', 'demo.jpg', 30000, 20, 10, 'ok'),
(1011, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1012, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1013, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1014, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1015, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1016, 1, 1, 'Remote', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1017, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1018, 1, 1, 'Bottle', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1019, 1, 1, 'watch', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1020, 1, 1, 'charger', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1021, 1, 1, 'sticky notes', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1022, 1, 1, 'books', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1023, 1, 1, 'tape', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1024, 1, 1, 'tissue', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1025, 1, 1, 'pen', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1026, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1027, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1028, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1029, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1030, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1031, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1032, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1033, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1034, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality'),
(1035, 1, 1, 'speaker', 'demo.jpg', 10000, 20, 5, 'high quality');

-- --------------------------------------------------------

--
-- Table structure for table `verificationtable`
--

CREATE TABLE `verificationtable` (
  `id` int(3) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `otp_code` varchar(5) DEFAULT NULL,
  `verified_status` varchar(15) NOT NULL,
  `verify_expiry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `verificationtable`
--

INSERT INTO `verificationtable` (`id`, `customer_id`, `otp_code`, `verified_status`, `verify_expiry`) VALUES
(272, 181, 'T97YK', 'verified', '1574775691'),
(273, 182, 'NEUKO', 'verified', '1571313202'),
(274, 183, 'W02QE', '', '1574774072'),
(275, 184, 'C3KDU', 'verified', '1574774419'),
(276, 185, 'W7XFS', '', '1574775955'),
(277, 186, 'PSWBT', 'not-verified', '1574777593'),
(278, 187, 'OFWZ1', 'verified', '1574790498');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_table`
--
ALTER TABLE `api_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customertable`
--
ALTER TABLE `customertable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributor_table`
--
ALTER TABLE `distributor_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verificationtable`
--
ALTER TABLE `verificationtable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_table`
--
ALTER TABLE `api_table`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customertable`
--
ALTER TABLE `customertable`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `distributor_table`
--
ALTER TABLE `distributor_table`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1036;

--
-- AUTO_INCREMENT for table `verificationtable`
--
ALTER TABLE `verificationtable`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
