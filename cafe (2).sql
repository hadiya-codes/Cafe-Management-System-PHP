-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 03:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_item`
--

CREATE TABLE `food_item` (
  `f_id` int(11) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `f_description` varchar(255) DEFAULT NULL,
  `f_price_small` decimal(8,2) NOT NULL,
  `f_price_medium` decimal(8,2) NOT NULL,
  `f_price_large` decimal(8,2) NOT NULL,
  `f_image` varchar(255) NOT NULL,
  `m_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_item`
--

INSERT INTO `food_item` (`f_id`, `f_name`, `f_description`, `f_price_small`, `f_price_medium`, `f_price_large`, `f_image`, `m_id`) VALUES
(1, 'Cheese French Pizza', 'Manhattan Classic Cheese Pizza with your choice of sauce and crust.', 44.00, 49.00, 54.00, 'jkjkkk.jpg', 1),
(2, 'Pepperoni Pizza', 'Get our classic Pepperoni pizza with your choice of sauce and crust.', 51.00, 56.00, 61.00, '7777.jpg', 1),
(3, 'Vegetarian Pizza', 'Tomato Sauce, Mozzarella, Green Pepper, Onions, Fresh Mushrooms and Tomatoes.', 61.00, 66.00, 71.00, 'p1.jpg', 1),
(4, 'Rustica Pizza', 'The tomato sauce, mozzarella cheese, the sausage, crispy bacon, roasted red peppers, and black olives.', 20.00, 25.00, 30.00, 'rrr.jpg', 1),
(5, 'Delicious Pizza', 'A mix of Porcini Mushrooms, the Decadent Truffle Paste with Mushrooms and Caramelized Onions.', 35.00, 40.00, 45.00, '899.jpg', 1),
(7, 'White Sause Pasta', 'A creamy and comforting Italian dish made with penne or other pasta tossed in a rich, velvety white sauce (béchamel) made from butter, milk, and flour, often flavored with garlic, herbs, and cheese.', 95.00, 100.00, 105.00, 'white.jpeg', 1),
(8, 'Red Sause Pasta', 'A classic Italian-style pasta made with a tangy and flavorful tomato-based sauce, simmered with garlic, herbs, and spices.', 21.00, 26.00, 31.00, 'red.jpeg', 1),
(9, 'Crunch Cheese Burger', 'A deliciously crispy burger featuring a crunchy golden patty, layered with melted cheese, fresh lettuce, tomatoes, and signature sauces, all packed in a soft toasted bun for the perfect bite every time.', 195.00, 200.00, 205.00, 'burger.jpeg', 1),
(10, 'Grilled Juicy Sandwich', 'Golden-brown grilled bread stuffed with fresh and tasty fillings. Served hot & crispy.', 100.00, 150.00, 200.00, 'sandwich.png', 1),
(11, 'Zinger Club Sandwich', 'Golden-brown crisp bread stuffed with fresh and tasty fillings. Served hot & crispy.', 150.00, 180.00, 230.00, 'club.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `local_customer`
--

CREATE TABLE `local_customer` (
  `l_id` int(15) NOT NULL,
  `l_name` varchar(25) NOT NULL,
  `l_address` text DEFAULT NULL,
  `l_phoneNo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `local_customer`
--

INSERT INTO `local_customer` (`l_id`, `l_name`, `l_address`, `l_phoneNo`) VALUES
(1, 'Maryam', 'Taj Town', '0329xxxxxxx'),
(2, 'Liaqat', 'Taj Town kamoke', '0323xxxxxxx'),
(3, 'Hadiya', 'near bypass gujranwala', '0327xxxxxxx'),
(4, 'Alina', 'garden town gujranwala', '0321xxxxxxx'),
(5, 'Ali', 'model town gujranwala', '0326xxxxxxx'),
(6, 'Ayesha', 'pindi road', '0327xxxxxxx'),
(11, 'Hadiya Nasir', 'Taj Town', '03006969637'),
(24, 'Maryam', 'Taj Town', '03006969637'),
(25, 'Minahil', 'Risen Market', '0324655576'),
(26, 'Minahil', 'Risen Market', '0324655576'),
(27, 'Naeem', 'Risen Market', '0324655576'),
(28, 'Naeem', 'Gulshan-e-Pizza', '0324687576'),
(29, 'Arshad', 'Gulshan-e-Pizza', '0324687573'),
(30, 'Arshad', 'Gulshan-e-Pizza', '0324687573'),
(31, 'Zoya', 'anmol cng', '0324687573'),
(32, 'Fatima', 'Garden Town', '03246875762'),
(33, 'Eman', 'Model town', '03286876762'),
(34, 'Eman', 'Model town', '03286876762'),
(35, 'Maryam Liaqat', 'Taj Town,kamoke', '0324-7113866');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `m_id` int(15) NOT NULL,
  `m_name` varchar(25) NOT NULL,
  `m_address` text DEFAULT NULL,
  `m_email` varchar(25) DEFAULT NULL,
  `m_password` varchar(20) NOT NULL,
  `m_phoneNo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`m_id`, `m_name`, `m_address`, `m_email`, `m_password`, `m_phoneNo`) VALUES
(1, 'Sadaf Naeem', 'Gujranwala', 'sadaf.naeem@gift.edu.pk', 'admin123', '03001234567');

-- --------------------------------------------------------

--
-- Table structure for table `order_bill`
--

CREATE TABLE `order_bill` (
  `bill_id` int(15) NOT NULL,
  `bill_amount` varchar(25) DEFAULT NULL,
  `bill_tax` varchar(15) DEFAULT NULL,
  `bill_time` varchar(15) NOT NULL,
  `o_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_bill`
--

INSERT INTO `order_bill` (`bill_id`, `bill_amount`, `bill_tax`, `bill_time`, `o_id`) VALUES
(1, '240', '24', '2025-08-08 15:1', 1),
(2, '560', '56', '2025-08-08 15:1', 2),
(3, '264', '26.4', '2025-08-08 15:1', 3),
(4, '180', '18', '2025-08-08 15:1', 4),
(5, '50', '5', '2025-08-08 15:1', 5),
(6, '108', '10.8', '2025-08-08 15:1', 6),
(7, '200', '20', '2025-08-08 15:1', 7),
(8, '66', '6.6', '2025-08-08 15:2', 8),
(9, '460', '46', '2025-08-08 15:2', 6),
(10, '138', '13.8', '2025-08-08 15:2', 10),
(11, '460', '46', '2025-08-08 15:2', 11),
(13, '56', '5.6', '2025-08-11 21:0', 13),
(18, '728', '72.8', '2025-08-11 21:1', 18),
(39, '104', '10.4', '2025-08-11 22:1', 39),
(45, '200', '20', '2025-08-13 04:2', 45),
(46, '200', '20', '2025-08-13 04:2', 46),
(47, '200', '20', '2025-08-13 04:2', 47),
(48, '62', '6.2', '2025-08-13 04:2', 48),
(49, '62', '6.2', '2025-08-13 04:2', 49),
(50, '62', '6.2', '2025-08-13 04:2', 50),
(51, '62', '6.2', '2025-08-13 04:3', 51),
(52, '100', '10', '2025-08-13 04:3', 52),
(53, '100', '10', '2025-08-13 04:3', 53),
(54, '360', '36', '2025-08-28 20:0', 54),
(55, '800', '80', '2025-08-28 20:0', 55),
(56, '390', '39', '2025-08-28 20:0', 56),
(57, '160', '16', '2025-08-29 11:1', 57),
(58, '52', '5.2', '2025-08-29 14:0', 58),
(59, '52', '5.2', '2025-08-29 14:0', 59),
(60, '147', '14.7', '2025-12-10 12:4', 60);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `o_id` int(15) NOT NULL,
  `o_qty` int(10) DEFAULT NULL,
  `l_id` int(15) DEFAULT NULL,
  `r_id` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`o_id`, `o_qty`, `l_id`, `r_id`) VALUES
(1, 6, 1, NULL),
(2, 10, 2, NULL),
(3, 4, 3, NULL),
(4, 5, 4, NULL),
(5, 2, 5, NULL),
(6, 3, 6, NULL),
(7, 5, NULL, 1),
(8, 1, NULL, 2),
(10, 3, NULL, 4),
(11, 10, NULL, 5),
(13, 1, NULL, 6),
(18, 13, 11, NULL),
(39, 4, 24, NULL),
(45, 1, 25, NULL),
(46, 1, 26, NULL),
(47, 1, 27, NULL),
(48, 2, 28, NULL),
(49, 2, NULL, 14),
(50, 2, 29, NULL),
(51, 2, 30, NULL),
(52, 1, 31, NULL),
(53, 1, NULL, 15),
(54, 2, NULL, 16),
(55, 4, NULL, 17),
(56, 2, NULL, 18),
(57, 4, 32, NULL),
(58, 2, 33, NULL),
(59, 2, 34, NULL),
(60, 3, 35, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(15) NOT NULL,
  `amount_paid` varchar(25) DEFAULT NULL,
  `p_method` varchar(15) DEFAULT NULL,
  `p_time` varchar(15) NOT NULL,
  `bill_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `amount_paid`, `p_method`, `p_time`, `bill_id`) VALUES
(1, '264', 'Card Payment', '2025-08-08 15:1', 1),
(2, '616', 'Cash on deliver', '2025-08-08 15:1', 2),
(3, '290.4', 'Cash on deliver', '2025-08-08 15:1', 3),
(4, '198', 'Card Payment', '2025-08-08 15:1', 4),
(5, '55', 'Card Payment', '2025-08-08 15:1', 5),
(6, '118.8', 'Cash on deliver', '2025-08-08 15:1', 6),
(7, '220', 'Cash on deliver', '2025-08-08 15:1', 7),
(8, '72.6', 'Card Payment', '2025-08-08 15:2', 8),
(9, '506', 'Cash on deliver', '2025-08-08 15:2', 9),
(10, '151.8', 'Card Payment', '2025-08-08 15:2', 10),
(11, '506', 'Card Payment', '2025-08-08 15:2', 11),
(13, '61.6', 'Cash on deliver', '2025-08-11 21:0', 13),
(18, '800.8', 'Card Payment', '2025-08-11 21:1', 18),
(39, '114.4', 'Cash on deliver', '2025-08-11 22:1', 39),
(45, '220', 'Cash on deliver', '2025-08-13 04:2', 45),
(46, '220', 'Cash on deliver', '2025-08-13 04:2', 46),
(47, '220', 'Cash on deliver', '2025-08-13 04:2', 47),
(48, '68.2', 'Cash on deliver', '2025-08-13 04:2', 48),
(49, '68.2', 'Cash on deliver', '2025-08-13 04:2', 49),
(50, '68.2', 'Cash on deliver', '2025-08-13 04:2', 50),
(51, '68.2', 'Cash on deliver', '2025-08-13 04:3', 51),
(52, '110', 'Card Payment', '2025-08-13 04:3', 52),
(53, '110', 'Card Payment', '2025-08-13 04:3', 53),
(54, '396', 'Card Payment', '2025-08-28 20:0', 54),
(55, '880', 'Cash on deliver', '2025-08-28 20:0', 55),
(56, '429', 'Cash on deliver', '2025-08-28 20:0', 56),
(57, '176', 'Cash on deliver', '2025-08-29 11:1', 57),
(58, '57.2', 'Card Payment', '2025-08-29 14:0', 58),
(59, '57.2', 'Card Payment', '2025-08-29 14:0', 59),
(60, '161.7', 'Cash on deliver', '2025-12-10 12:4', 60);

-- --------------------------------------------------------

--
-- Table structure for table `registered_customer`
--

CREATE TABLE `registered_customer` (
  `r_id` int(15) NOT NULL,
  `r_name` varchar(25) NOT NULL,
  `r_address` text DEFAULT NULL,
  `r_phoneNo` varchar(15) DEFAULT NULL,
  `register_date` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_customer`
--

INSERT INTO `registered_customer` (`r_id`, `r_name`, `r_address`, `r_phoneNo`, `register_date`) VALUES
(1, 'Ahmad', 'Taj Town', '0328_xxxxxxx', '2025-08-08 15:1'),
(2, 'Rimsha', 'City Housing', '0326_xxxxxxx', '2025-08-08 15:2'),
(4, 'Maryam', 'Model town', '0324_xxxxxxx', '2025-08-08 15:2'),
(5, 'Muhammad Ali', 'taj town', '0321_xxxxxxx', '2025-08-08 15:2'),
(6, 'hadiya nasir', 'taj town', '03006969637', '2025-08-11 09:0'),
(14, 'Naeem', 'Gulshan-e-Pizza', '0324687576', '2025-08-13 04:2'),
(15, 'Zara', 'anmol cng', '0324687573', '2025-08-13 04:3'),
(16, 'amna', 'near garden town Gujranwala', '03246875234', '2025-08-28 20:0'),
(17, 'Ali', 'Model town', '03346875762', '2025-08-28 20:0'),
(18, 'Muqaddas', 'Gulshan-e-Pizza', '03268987621', '2025-08-28 20:0');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `r_id` int(15) NOT NULL,
  `r_amount` varchar(25) DEFAULT NULL,
  `r_time` varchar(15) NOT NULL,
  `registered_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`r_id`, `r_amount`, `r_time`, `registered_id`) VALUES
(1, '220', '2025-08-08 15:1', 1),
(2, '72.6', '2025-08-08 15:2', 2),
(4, '151.8', '2025-08-08 15:2', 4),
(5, '506', '2025-08-08 15:2', 5),
(6, '61.6', '2025-08-11 21:0', 6),
(14, '68.2', '2025-08-13 04:2', 14),
(15, '110', '2025-08-13 04:3', 15),
(16, '396', '2025-08-28 20:0', 16),
(17, '880', '2025-08-28 20:0', 17),
(18, '429', '2025-08-28 20:0', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_item`
--
ALTER TABLE `food_item`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `local_customer`
--
ALTER TABLE `local_customer`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_email` (`m_email`);

--
-- Indexes for table `order_bill`
--
ALTER TABLE `order_bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `fk_bill_order` (`o_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `fk_order_local` (`l_id`),
  ADD KEY `fk_order_registered` (`r_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `fk_payment_bill` (`bill_id`);

--
-- Indexes for table `registered_customer`
--
ALTER TABLE `registered_customer`
  ADD PRIMARY KEY (`r_id`),
  ADD UNIQUE KEY `r_phoneNo` (`r_phoneNo`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `fk_request_registered` (`registered_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_item`
--
ALTER TABLE `food_item`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `local_customer`
--
ALTER TABLE `local_customer`
  MODIFY `l_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `m_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_bill`
--
ALTER TABLE `order_bill`
  MODIFY `bill_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `o_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `registered_customer`
--
ALTER TABLE `registered_customer`
  MODIFY `r_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `r_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_bill`
--
ALTER TABLE `order_bill`
  ADD CONSTRAINT `fk_bill_order` FOREIGN KEY (`o_id`) REFERENCES `order_detail` (`o_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_local` FOREIGN KEY (`l_id`) REFERENCES `local_customer` (`l_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_registered` FOREIGN KEY (`r_id`) REFERENCES `registered_customer` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_bill` FOREIGN KEY (`bill_id`) REFERENCES `order_bill` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `fk_request_registered` FOREIGN KEY (`registered_id`) REFERENCES `registered_customer` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
