-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2023 at 10:37 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `bill_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `order_id` varchar(10) NOT NULL,
  `create_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `pay_mode` varchar(10) NOT NULL,
  `pay_status` varchar(10) NOT NULL,
  `pay_date` date NOT NULL,
  `upload_slip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `order_id`, `create_date`, `amount`, `pay_mode`, `pay_status`, `pay_date`, `upload_slip`, `cheque_date`) VALUES
('B00001', 'OR00001', '2022-04-19', '120000.00', 'Cheque', 'Reject', '2022-04-19', 'B00001.jpg', '2022-04-19'),
('B00002', 'OR00001', '2022-04-19', '1012085.00', 'Cash', 'Paid', '2022-04-19', '', '0000-00-00'),
('B00003', 'OR00002', '2022-04-19', '10000.00', 'Cash', 'Paid', '2022-04-19', '', '0000-00-00'),
('B00004', 'OR00002', '2022-04-19', '206750.00', 'Bank', 'Paid', '2022-04-19', 'B00004.jpg', '0000-00-00'),
('B00005', 'OR00001', '2022-05-05', '843200.00', 'Cash', 'Paid', '2022-05-05', '', '0000-00-00'),
('B00006', 'OR00007', '2022-05-16', '185250.00', 'Bank', 'Paid', '2022-05-16', 'B00006.jpg', '0000-00-00'),
('B00007', 'OR00008', '2022-05-16', '1500.00', 'Cash', 'Paid', '2022-05-16', '', '0000-00-00'),
('B00008', 'OR00008', '2022-05-16', '343350.00', 'Cash', 'Paid', '2022-05-16', '', '0000-00-00'),
('B00009', 'OR00009', '2022-05-16', '54450.00', 'Cash', 'Paid', '2022-05-16', '', '0000-00-00'),
('B00010', 'OR00009', '2022-05-16', '490050.00', 'Cash', 'Paid', '2022-05-16', '', '0000-00-00'),
('B00011', 'OR00010', '2022-05-16', '5000.00', 'Cash', 'Paid', '2022-05-16', '', '0000-00-00'),
('B00012', 'OR00010', '2022-05-16', '117500.00', 'Cheque', 'Reject', '2022-05-16', 'B00012.png', '2022-06-11'),
('B00013', 'OR00013', '2022-05-20', '54000.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00014', 'OR00011', '2022-05-20', '110000.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00015', 'OR00002', '2022-05-20', '8520.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00016', 'OR00003', '2022-05-20', '39200.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00017', 'OR00010', '2022-05-20', '117500.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00018', 'OR00004', '2022-05-20', '318500.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00019', 'OR00005', '2022-05-20', '156750.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00020', 'OR00012', '2022-05-20', '50000.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00021', 'OR00013', '2022-05-20', '13500.00', 'Cash', 'Paid', '2022-05-20', '', '0000-00-00'),
('B00022', 'OR00014', '2022-05-21', '500000.00', 'Cash', 'Paid', '2022-05-21', '', '0000-00-00'),
('B00023', 'OR00015', '2022-05-22', '1200.00', 'Cash', 'Paid', '2022-05-22', '', '0000-00-00'),
('B00024', 'OR00016', '2022-05-22', '74000.00', 'Cash', 'Paid', '2022-05-22', '', '0000-00-00'),
('B00025', 'OR00016', '2022-05-22', '1000.00', 'Cheque', 'Paid', '2022-05-22', 'B00025.jpg', '2022-05-25'),
('B00026', 'OR00017', '2022-05-22', '500.00', 'Cash', 'Paid', '2022-05-22', '', '0000-00-00'),
('B00027', 'OR00018', '2022-05-23', '1500.00', 'Cash', 'Paid', '2022-05-23', '', '0000-00-00'),
('B00028', 'OR00019', '2022-05-24', '33250.00', 'Cash', 'Paid', '2022-05-24', '', '0000-00-00'),
('B00029', 'OR00020', '2022-05-24', '25000.00', 'Cash', 'Paid', '2022-05-24', '', '0000-00-00'),
('B00030', 'OR00023', '2022-05-25', '10000.00', 'Cheque', 'Paid', '2022-05-25', 'B00030.jpg', '2022-05-25'),
('B00031', 'OR00021', '2022-05-26', '1500.00', 'Cash', 'Paid', '2022-05-26', '', '0000-00-00'),
('B00032', 'OR00022', '2022-05-26', '25000.00', 'Cash', 'Paid', '2022-05-26', '', '0000-00-00'),
('B00033', 'OR00026', '2022-05-26', '12040.00', 'Bank', 'Paid', '2022-05-26', 'B00033.jpg', '0000-00-00'),
('B00034', 'OR00030', '2022-11-23', '1062700.00', 'Cash', 'Paid', '2022-11-23', '', '0000-00-00'),
('B00035', 'OR00036', '2022-11-27', '125000.00', 'Cash', 'Paid', '2022-11-27', '', '0000-00-00'),
('B00036', 'OR00036', '2022-11-27', '1250005.00', 'Cash', 'Paid', '2022-11-27', '', '0000-00-00'),
('B00037', 'OR00025', '2022-11-27', '25000.00', 'Cash', 'Paid', '2022-11-27', '', '0000-00-00'),
('B00038', 'OR00039', '2022-11-27', '36050.00', 'Cash', 'Paid', '2022-11-27', '', '0000-00-00'),
('B00039', 'OR00038', '2022-12-06', '121864.80', 'Bank', 'Pending', '2022-12-06', 'B00039.jpg', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` varchar(10) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
('CAT03', '3D- Printing and Crafting'),
('CAT02', 'Cloths'),
('CAT01', 'Furniture'),
('CAT04', 'Art Selections'),
('CAT05', 'building prototype'),
('CAT06', 'cad planning'),
('CAT07', 'Ceiling Designing'),
('CAT08', 'Ingraining & Embossing');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `mobile` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `nic`, `dob`, `gender`, `mobile`, `email`, `address`) VALUES
('CUS0001', 'Rukshan', '983630640v', '1998-12-28', 'Male', 769861092, 'rukshan1122@gmail.com', 'jaffna'),
('CUS0003', 'Thivaharan', '921251511V', '1992-05-04', 'Male', 789654852, 'thiva1995@gmail.com', 'Jaffna'),
('CUS0002', 'Akshay', '921251518V', '1992-05-04', 'Male', 769861091, 'rukshan1122@gmail.com', 'jaffna'),
('CUS0005', 'Thiva', '928251508V', '1992-11-20', 'Female', 769861092, 'thiva1995@gmail.com', 'Jaffna'),
('CUS0006', 'Latha', '928251788V', '1992-11-20', 'Female', 771234567, 'latha1995@gmail.com', 'Jaffna'),
('CUS0007', 'Selvakumar', '641251518V', '1964-03-09', 'Male', 776137315, 'selvakumar@gmail.com', 'Kondavil Jaffna'),
('CUS0008', 'Ram', '983630611v', '0000-00-00', '', 778521234, 'ram@gmail.com', 'colombo'),
('CUS0009', 'vimal', '986532000V', '1998-06-01', 'Female', 772484759, 'ddd@gmail.com', 'jaffna'),
('CUS0010', 'rk yyyyrukshan', '986532070V', '1998-06-01', 'Female', 771234569, 'rukshan1122@gmail.com', 'jaffna'),
('CUS0011', 'rk yyyyrukshan', '986532070V', '0000-00-00', '', 771234569, 'rukshan1122@gmail.com', 'jaffna');

-- --------------------------------------------------------

--
-- Table structure for table `custom_order`
--

DROP TABLE IF EXISTS `custom_order`;
CREATE TABLE IF NOT EXISTS `custom_order` (
  `image_id` varchar(10) NOT NULL,
  `order_id` varchar(10) NOT NULL,
  `image` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `expect_price` decimal(10,2) NOT NULL,
  `accept_price` varchar(10) DEFAULT NULL,
  `quantity` int NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`image_id`,`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `custom_order`
--

INSERT INTO `custom_order` (`image_id`, `order_id`, `image`, `description`, `expect_price`, `accept_price`, `quantity`, `status`) VALUES
('OI00001', 'OR00039', 'OR00039_OI00001.jpg', ' sdddddd', '15550.00', '15550.00', 1, 'Accepted'),
('OI00001', 'OR00038', 'OR00038_OI00001.jpg', ' dxc', '25666.00', '25666.00', 7, 'Accepted'),
('OI00001', 'OR00036', 'OR00036_OI00001.jpg', ' fgg', '250001.00', '250001.00', 5, 'Accepted'),
('OI00003', 'OR00030', 'OR00030_OI00003.jpg', ' bcf', '5000.00', NULL, 21, 'Rejected'),
('OI00002', 'OR00030', 'OR00030_OI00002.jpg', ' dxvxcvc', '25895.00', NULL, 5, 'Rejected'),
('OI00001', 'OR00030', 'OR00030_OI00001.jpg', ' Ceiling', '15550.00', '15550.00', 1, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `user_name` varchar(12) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `password` varchar(5000) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `attempt` int NOT NULL,
  `code` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_name`, `user_id`, `password`, `user_type`, `status`, `attempt`, `code`) VALUES
('983630666v', 'ST003', '358fb931fefb61ae789563e81b0b2f3e', 'Clerk', 'Active', 0, 0),
('983630640v', 'CUS0001', '2819dfc174262051c1745ad5f50d344c', 'Customer', 'Active', 0, 5483),
('983645600v', 'ST006', '5e92391e6491f59a6be89a16db93351f', 'Clerk', 'Active', 0, 0),
('983630523v', 'ST005', 'e29b3a1aa60b02f102566beff8d3f7c8', 'Clerk', 'Active', 0, 0),
('983630600v', 'ST001', '2f8eaa0fd882f84ba4461a907a2bc427', 'Admin', 'Active', 0, 0),
('983630604v', 'ST002', '58682c09c541a552a8e6c1cba243fed6', 'Clerk', 'Active', 0, 0),
('983630704v', 'ST004', 'e10adc3949ba59abbe56e057f20f883e', 'Customer', 'Deleted', 0, 3987),
('921251518V', 'CUS0002', '9dd4802875bf866923f5da30e259ef62', 'Customer', 'Active', 0, 4753),
('921251511V', 'CUS0003', 'c5b90126da19c7ec03dada03ddba0aba', 'Customer', 'Active', 1, 6047),
('985632855v', 'ST008', '3e99279aa57fb7b42b8a9f34271b8aa2', 'Worker', 'Active', 0, 0),
('928251508V', 'CUS0005', '6d0232bdc43e1c0a823db098d3989a14', 'Customer', 'Active', 0, 8248),
('921251711V', 'ST007', '58a38a1f8426c1e9ab0e785aed830439', 'Clerk', 'Active', 0, 0),
('928251788V', 'CUS0006', '1edbbe2dbab51b694f3a7bf5369e09d1', 'Customer', 'Active', 0, 0),
('645698744V', 'CUS0007', 'ae21ddfdaa7a5ae0603d27433acd176e', 'Customer', 'Active', 0, 5277),
('943630500v', 'ST009', '4657c5e9cafeedaeda34664443cb3aae', 'Worker', 'Active', 0, 0),
('913625600v', 'ST010', '5777b7ac9eacac2fdb41a6bf6a2319a0', 'Worker', 'Active', 0, 0),
('953632155v', 'ST011', 'ff4a535206821054f1838a12b46b7e99', 'Clerk', 'Active', 0, 0),
('983630611v', 'CUS0008', '2f8eaa0fd882f84ba4461a907a2bc427', 'Customer', 'Pending', 0, 6658),
('983635600v', 'ST012', 'e10adc3949ba59abbe56e057f20f883e', 'Worker', 'Active', 0, 0),
('983650711V', 'ST013', '28d76ae1487be705bd7f22fb40bc59c9', 'Clerk', 'Active', 0, 0),
('983630123v', 'ST014', '1bea23c83b4966b02a202c3c326eaac9', 'Worker', 'Active', 0, 0),
('986532070V', 'CUS0010', '55aec5309df86ab58e9d5c72e445b66d', 'Customer', 'Pending', 0, 2479),
('986532070V', 'CUS0011', '55aec5309df86ab58e9d5c72e445b66d', 'Customer', 'Pending', 0, 4535);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `message_id` varchar(10) NOT NULL,
  `from_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `to_id` varchar(10) NOT NULL,
  `message_date` date NOT NULL,
  `message_time` time NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `inbox_delete` int NOT NULL,
  `send_delete` int NOT NULL,
  `read_status` int NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `from_id`, `to_id`, `message_date`, `message_time`, `subject`, `message`, `inbox_delete`, `send_delete`, `read_status`) VALUES
('MSG0009', 'ST001', 'CUS0001', '2022-05-22', '18:45:34', 'hi hello', 'hi', 0, 0, 0),
('MSG0008', 'ST001', 'ST007', '2022-05-10', '11:52:16', 'Query about product', 'is chairs are available?', 1, 1, 0),
('MSG0005', 'ST001', 'ST003', '2022-01-07', '13:41:16', 'test', 'Details Needed', 1, 1, 0),
('MSG0006', 'ST001', 'ST002', '2022-01-07', '22:01:28', 'test', 'From Staff', 1, 1, 0),
('MSG0007', 'ST001', 'ST005', '2022-01-07', '22:09:29', 'test', 'Apply for a Leave ', 1, 1, 0),
('MSG0012', 'ST002', 'CUS0001', '2022-05-22', '21:09:47', 'query', 'send all staff details', 1, 1, 0),
('MSG0010', 'ST001', 'CUS0001', '2022-05-22', '19:23:59', 'hi', 'hello', 1, 0, 0),
('MSG0011', 'ST001', 'ST002', '2022-05-22', '20:52:56', 'Query', 'Send all customer details', 1, 1, 0),
('MSG0013', 'CUS0001', 'ST001', '2022-05-22', '23:37:53', 'query', 'is any sale available?\r\n', 1, 1, 0),
('MSG0014', 'ST001', 'CUS0001', '2022-05-23', '11:48:03', 'Acknowledgement', 'thankyou, we receive your payment', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `create_date` date NOT NULL,
  `order_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `customer_id`, `create_date`, `order_address`, `status`, `description`, `start_date`, `finish_date`) VALUES
('OR00001', 'CUS0001', '2022-04-19', 'Jaffna', 'Accepted', 'Deliver Within the Time Period', '2022-04-20', '2022-05-07'),
('OR00002', 'CUS0001', '2022-04-19', 'Jaffna', 'Accepted', 'Finish Quickly', '2022-04-19', '2022-04-25'),
('OR00003', 'CUS0001', '2022-05-08', 'jaffna', 'Accepted', 'Furniture', '2022-05-08', '2022-06-11'),
('OR00004', 'CUS0003', '2022-05-12', 'jaffna', 'Accepted', 'deliver quick', '2022-05-18', '2022-06-04'),
('OR00005', 'CUS0007', '2022-05-14', 'jaffna', 'Accepted', 'crystal material', '2022-06-03', '2022-07-09'),
('OR00011', 'CUS0002', '2022-05-18', 'jaffna', 'Accepted', 'suit', '2022-05-21', '2022-06-04'),
('OR00007', 'CUS0003', '2022-05-16', 'jaffna', 'Accepted', 'quick delivery', '2022-06-03', '2022-08-11'),
('OR00008', 'CUS0001', '2022-05-16', 'jaffna', 'Accepted', 'Quick delivery', '2022-05-19', '2022-05-23'),
('OR00009', 'CUS0001', '2022-05-16', 'jaffna', 'Accepted', '11 statues', '2022-05-19', '2022-06-11'),
('OR00010', 'CUS0003', '2022-05-16', 'jaffna', 'Accepted', 'statues metal alloy', '2022-06-25', '2022-07-04'),
('OR00012', 'CUS0001', '2022-05-19', 'jaffna', 'Accepted', 'deliver quickly and safe', '2022-05-31', '2022-06-11'),
('OR00013', 'CUS0001', '2022-05-20', 'Colombo', 'Accepted', 'Medium size coat', '2022-05-20', '2022-06-11'),
('OR00014', 'CUS0001', '2022-05-21', 'jaffna', 'Accepted', 'Crystal statues', '2022-05-21', '2022-05-28'),
('OR00015', 'CUS0001', '2022-05-22', 'Colombo', 'Accepted', 'Black color suit and coat.', '2022-05-22', '2022-05-29'),
('OR00016', 'CUS0001', '2022-05-22', 'colombo', 'Accepted', 'pack safety', '2022-05-22', '2022-06-10'),
('OR00017', 'CUS0001', '2022-05-22', 'jaffna', 'Accepted', '----', '2022-05-22', '2022-05-29'),
('OR00018', 'CUS0001', '2022-05-23', 'jaffna', 'Accepted', 'Deliver within the time period', '2022-05-23', '2022-06-06'),
('OR00019', 'CUS0001', '2022-05-23', 'Colombo', 'Accepted', 'Pack safely', '2022-05-23', '2022-06-11'),
('OR00020', 'CUS0001', '2022-05-24', 'Colombo', 'Accepted', 'deliver Without any crack', '2022-05-24', '2022-06-11'),
('OR00021', 'CUS0003', '2022-05-24', 'jaffna', 'Accepted', 'medium color blue t-shirt', '2022-05-24', '2022-06-07'),
('OR00022', 'CUS0006', '2022-05-24', 'kandy', 'Accepted', 'modern light ceiling ', '2022-05-24', '2022-05-30'),
('OR00023', 'CUS0001', '2022-05-25', 'jaffna', 'Accepted', 'Black suit\r\n', '2022-05-25', '2022-06-08'),
('OR00024', 'CUS0001', '2022-05-25', 'colombo', 'Rejected', 'Modern black coat', '2022-05-25', '2022-06-08'),
('OR00025', 'CUS0001', '2022-05-26', 'colombo', 'Accepted', 'one crystal statue', '2022-05-26', '2022-06-09'),
('OR00026', 'CUS0001', '2022-05-26', 'jaffna', 'Accepted', 'wooden cupboard', '2022-05-29', '2022-06-11'),
('OR00027', 'CUS0001', '2022-05-26', 'colombo', 'Accepted', 'white suit', '2022-05-26', '2022-07-06'),
('OR00028', 'CUS0005', '2022-05-26', 'jaffna', 'Accepted', 'colorful scarf', '2022-05-27', '2022-06-10'),
('OR00030', 'CUS0001', '2022-11-23', 'jaffna', 'Accepted', 'fg', '2022-11-23', '2022-12-31'),
('OR00036', 'CUS0008', '2022-11-27', 'jaffna', 'Accepted', 'cccccccccccc', '2022-11-30', '2022-12-02'),
('OR00037', 'CUS0001', '2022-11-27', 'jaffna', 'Accepted', 'fdddsdf\r\n', '2022-11-27', '2023-01-01'),
('OR00038', 'CUS0001', '2022-11-27', 'jaffna', 'Accepted', 'ccccccc\r\n', '2022-11-27', '2022-12-10'),
('OR00039', 'CUS0001', '2022-11-27', 'jaffna', 'Accepted', 'order', '2022-11-27', '2023-02-25'),
('OR00040', 'CUS0005', '2022-11-30', 'jaffna', 'Accepted', '3D Paintings', '2022-11-30', '2023-05-06'),
('OR00041', 'CUS0003', '2022-11-30', 'jaffna', 'Accepted', 'Wood Statue\r\n', '2022-11-30', '2023-05-12'),
('OR00042', 'CUS0003', '2022-12-13', 'jaffna', 'Accepted', 'Crystal Vase\r\n', '2022-12-13', '2023-07-29'),
('OR00043', 'CUS0002', '2022-12-13', 'jaffna', 'Accepted', 'care', '2022-12-31', '2023-03-01'),
('OR00044', 'CUS0001', '2022-12-13', 'jaffna', 'Accepted', 'Care\r\n', '2022-12-13', '2023-05-26'),
('OR00045', 'CUS0007', '2022-12-13', 'jaffna', 'Accepted', 'sddgdf\r\n', '2022-12-13', '2023-02-04'),
('OR00046', 'CUS0001', '2023-01-13', 'jaffna', 'Accepted', 'ok', '2023-01-13', '2023-02-11'),
('OR00047', 'CUS0001', '2023-02-27', 'jaffna', 'Accepted', 'ffgdf', '2023-02-27', '2023-03-11'),
('OR00048', 'CUS0002', '2023-02-27', 'jaffna', 'Accepted', 'dfgdfgdfgdfgf', '2023-02-27', '2023-06-16'),
('OR00049', 'CUS0003', '2023-02-27', 'jaffna', 'Accepted', 'fgfgfgfg', '2023-02-27', '2023-03-11'),
('OR00050', 'CUS0001', '2023-02-28', 'jaffna', 'Accepted', 'gdfgdfgdf', '2023-02-28', '2023-05-20'),
('OR00051', 'CUS0002', '2023-03-28', 'jaffna', 'Accepted', 'mghjh', '2023-03-28', '2023-04-08'),
('OR00052', 'CUS0001', '2023-04-01', 'jaffna', 'Accepted', 'ghghjj', '2023-04-19', '2023-04-29'),
('OR00053', 'CUS0002', '2023-04-05', 'jaffna', 'Accepted', 'sdfg', '2023-04-05', '2023-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `order_pause`
--

DROP TABLE IF EXISTS `order_pause`;
CREATE TABLE IF NOT EXISTS `order_pause` (
  `order_id` varchar(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`order_id`,`start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_pause`
--

INSERT INTO `order_pause` (`order_id`, `start_date`, `end_date`, `reason`) VALUES
('OR00046', '2023-03-30', '2023-04-04', 'waiting for tools'),
('OR00051', '2023-03-16', '2023-04-29', 'Waiting for Raw material.'),
('OR00051', '2023-03-28', '2023-12-28', 'Implementing'),
('OR00030', '2023-04-06', '0000-00-00', 'waiting for raw material'),
('OR00052', '2023-04-01', '2023-04-30', 'sdfsdfsdfsdfsdssdfsf'),
('OR00053', '2023-04-06', '2023-11-11', 'Pending raw material');

-- --------------------------------------------------------

--
-- Table structure for table `order_process`
--

DROP TABLE IF EXISTS `order_process`;
CREATE TABLE IF NOT EXISTS `order_process` (
  `order_id` varchar(10) NOT NULL,
  `actual_start_date` date NOT NULL,
  `actual_end_date` date DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_process`
--

INSERT INTO `order_process` (`order_id`, `actual_start_date`, `actual_end_date`, `status`) VALUES
('OR00001', '2022-04-19', '2022-04-19', 'Completed'),
('OR00002', '2022-04-19', '2022-05-18', 'Completed'),
('OR00003', '2022-05-08', '2022-05-08', 'Completed'),
('OR00004', '2022-05-12', '2022-05-12', 'Completed'),
('OR00005', '2022-05-14', '2022-05-18', 'Completed'),
('OR00006', '2022-05-15', '2022-05-15', 'Completed'),
('OR00007', '2022-05-16', '2022-05-16', 'Completed'),
('OR00008', '2022-05-16', '2022-05-18', 'Completed'),
('OR00009', '2022-05-16', '2022-05-16', 'Completed'),
('OR00010', '2022-05-16', '2022-05-16', 'Completed'),
('OR00011', '2022-05-18', '2022-05-18', 'Completed'),
('OR00013', '2022-05-20', '2022-05-20', 'Completed'),
('OR00012', '2022-05-20', '2022-05-20', 'Completed'),
('OR00014', '2022-05-21', '2022-05-21', 'Completed'),
('OR00015', '2022-05-22', '2022-05-22', 'Completed'),
('OR00016', '2022-05-22', '2022-05-22', 'Completed'),
('OR00017', '2022-05-22', '2022-05-22', 'Completed'),
('OR00018', '2022-05-23', '2022-05-23', 'Completed'),
('OR00019', '2022-05-23', '2022-05-23', 'Completed'),
('OR00020', '2022-05-24', '2022-05-24', 'Completed'),
('OR00021', '2022-05-24', '2022-05-24', 'Completed'),
('OR00022', '2022-05-24', '2022-05-24', 'Completed'),
('OR00023', '2022-05-25', '2022-05-25', 'Completed'),
('OR00025', '2022-05-26', '2022-05-26', 'Completed'),
('OR00026', '2022-05-26', '2022-05-26', 'Completed'),
('OR00027', '2022-05-26', '2022-11-27', 'Completed'),
('OR00028', '2022-05-26', NULL, 'Progress'),
('OR00030', '2022-11-23', NULL, 'Progress'),
('OR00036', '2022-11-27', '2022-11-27', 'Completed'),
('OR00037', '2022-11-27', NULL, 'Progress'),
('OR00038', '2022-11-27', NULL, 'Completed'),
('OR00039', '2022-11-27', '2022-11-27', 'Completed'),
('OR00040', '2022-11-30', NULL, 'Progress'),
('OR00041', '2022-11-30', NULL, 'Progress'),
('OR00042', '2022-12-13', NULL, 'Progress'),
('OR00043', '2022-12-13', NULL, 'Progress'),
('OR00044', '2022-12-13', NULL, 'Progress'),
('OR00046', '2023-01-13', NULL, 'Progress'),
('OR00047', '2023-02-27', NULL, 'Progress'),
('OR00048', '2023-02-27', NULL, 'Progress'),
('OR00049', '2023-02-27', NULL, 'Progress'),
('OR00050', '2023-02-28', NULL, 'Progress'),
('OR00051', '2023-03-28', NULL, 'Progress'),
('OR00052', '2023-04-01', NULL, 'Progress'),
('OR00053', '2023-04-05', NULL, 'Progress');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `order_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`) VALUES
('OR00001', 'P0004', 10),
('OR00001', 'P0005', 5),
('OR00001', 'P0002', 13),
('OR00001', 'P0007', 23),
('OR00001', 'P0003', 57),
('OR00001', 'P0010', 5),
('OR00001', 'P0011', 23),
('OR00002', 'P0002', 5),
('OR00002', 'P0004', 5),
('OR00003', 'P0002', 2),
('OR00004', 'P0015', 13),
('OR00005', 'P0005', 45),
('OR00006', 'P0003', 1),
('OR00007', 'P0007', 13),
('OR00008', 'P0005', 11),
('OR00009', 'P0015', 11),
('OR00009', 'P0016', 11),
('OR00010', 'P0015', 5),
('OR00011', 'P0017', 11),
('OR00012', 'P0016', 2),
('OR00013', 'P0018', 45),
('OR00014', 'P0016', 20),
('OR00015', 'P0031', 1),
('OR00016', 'P0016', 3),
('OR00017', 'P0008', 1),
('OR00018', 'P0018', 1),
('OR00019', 'P0033', 1),
('OR00020', 'P0016', 1),
('OR00021', 'P0018', 1),
('OR00022', 'P0010', 1),
('OR00023', 'P0017', 1),
('OR00024', 'P0043', 1),
('OR00025', 'P0016', 1),
('OR00026', 'P0002', 1),
('OR00027', 'P0017', 1),
('OR00028', 'P0001', 13),
('OR00029', 'P0041', 222),
('OR00030', 'P0005', 5),
('OR00031', 'P0041', 5),
('OR00032', 'P0016', 32),
('OR00033', 'P0016', 2),
('OR00034', 'P0016', 1),
('OR00035', 'P0018', 3),
('OR00036', 'P0016', 5),
('OR00037', 'P0016', 225),
('OR00038', 'P0016', 5),
('OR00039', 'P0039', 1),
('OR00039', 'P0042', 150),
('OR00040', 'P0009', 1),
('OR00041', 'P0016', 1),
('OR00042', 'P0005', 1),
('OR00043', 'P0002', 2),
('OR00044', 'P0016', 2),
('OR00045', 'P0002', 2),
('OR00046', 'P0016', 1),
('OR00047', 'P0052', 1),
('OR00048', 'P0053', 3),
('OR00049', 'P0005', 2),
('OR00050', 'P0018', 1),
('OR00051', 'P0033', 1),
('OR00052', 'P0002', 1),
('OR00053', 'P0016', 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_product_delivery`
--

DROP TABLE IF EXISTS `order_product_delivery`;
CREATE TABLE IF NOT EXISTS `order_product_delivery` (
  `order_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_product_delivery`
--

INSERT INTO `order_product_delivery` (`order_id`, `product_id`, `quantity`) VALUES
('OR00001', 'P0011', 23),
('OR00001', 'P0003', 57),
('OR00001', 'P0002', 5),
('OR00001', 'P0004', 10),
('OR00001', 'P0005', 5),
('OR00001', 'P0007', 23),
('OR00001', 'P0010', 5),
('OR00002', 'P0002', 5),
('OR00002', 'P0004', 5),
('OR00003', 'P0002', 2),
('OR00004', 'P0015', 13),
('OR00005', 'P0005', 5),
('OR00006', 'P0003', 1),
('OR00007', 'P0007', 13),
('OR00008', 'P0005', 11),
('OR00009', 'P0015', 11),
('OR00009', 'P0016', 11),
('OR00010', 'P0015', 5),
('OR00011', 'P0017', 11),
('OR00013', 'P0018', 45),
('OR00012', 'P0016', 2),
('OR00014', 'P0016', 20),
('OR00015', 'P0031', 1),
('OR00016', 'P0016', 3),
('OR00017', 'P0008', 1),
('OR00018', 'P0018', 1),
('OR00019', 'P0033', 1),
('OR00020', 'P0016', 1),
('OR00021', 'P0018', 1),
('OR00022', 'P0010', 1),
('OR00023', 'P0017', 1),
('OR00025', 'P0016', 1),
('OR00026', 'P0002', 11),
('OR00027', 'P0017', 1),
('OR00030', 'P0005', 5),
('OR00036', 'P0016', 5),
('OR00039', 'P0042', 150),
('OR00039', 'P0039', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_worker`
--

DROP TABLE IF EXISTS `order_worker`;
CREATE TABLE IF NOT EXISTS `order_worker` (
  `order_id` varchar(10) NOT NULL,
  `worker_id` varchar(10) NOT NULL,
  `assign_date` date NOT NULL,
  PRIMARY KEY (`order_id`,`worker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_worker`
--

INSERT INTO `order_worker` (`order_id`, `worker_id`, `assign_date`) VALUES
('OR00002', 'ST008', '2022-04-19'),
('OR00005', 'ST009', '2022-05-14'),
('OR00013', 'ST010', '2022-05-20'),
('OR00016', 'ST012', '2022-05-22'),
('OR00026', 'ST008', '2022-05-26'),
('OR00026', 'ST010', '2022-05-26'),
('OR00027', 'ST010', '2022-05-26'),
('OR00030', 'ST009', '2022-11-23'),
('OR00038', 'ST009', '2022-11-27'),
('OR00030', 'ST014', '2022-11-23'),
('OR00030', 'ST008', '2022-11-23'),
('OR00038', 'ST010', '2022-11-27'),
('OR00040', 'ST008', '2022-11-30'),
('OR00040', 'ST009', '2022-11-30'),
('OR00047', 'ST008', '2023-02-27'),
('OR00048', 'ST009', '2023-02-27'),
('OR00048', 'ST008', '2023-02-27'),
('OR00049', 'ST009', '2023-02-27'),
('OR00049', 'ST008', '2023-02-27'),
('OR00049', 'ST012', '2023-02-27'),
('OR00050', 'ST009', '2023-02-28'),
('OR00051', 'ST008', '2023-03-28'),
('OR00051', 'ST012', '2023-03-28'),
('OR00051', 'ST009', '2023-03-28'),
('OR00051', 'ST010', '2023-03-28'),
('OR00051', 'ST014', '2023-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` varchar(10) NOT NULL,
  `subcategory_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `material` text NOT NULL,
  `minimum_alert` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `subcategory_id`, `name`, `description`, `material`, `minimum_alert`) VALUES
('P0002', 'SCAT004', 'cupboard', ' Wood Designed Cupboard ', 'wood', 10),
('P0001', 'SCAT011', 'Scarf', 'cotton Scarf (Multiple color)', 'cotton', 35),
('P0003', 'SCAT006', 'Wool Carpet', ' Wool cloth', 'wool', 10),
('P0004', 'SCAT009', 'Shirt', ' Formal or Non Formal Shirts', 'cotton', 50),
('P0005', 'SCAT014', 'vase', ' Any Material Handcrafts', 'Any Material', 15),
('P0006', 'SCAT001', 'Chairs', ' Wood Chairs Any Size', 'wood', 13),
('P0007', 'SCAT021', 'Mall Design', ' Mall Overview Prototype ', 'Plastic', 15),
('P0008', 'SCAT026', ' Building Drawing', ' Draft Cad Drawing', 'Paper', 23),
('P0009', 'SCAT020', '3D Paintings', '3D Painting  ', 'Any Material', 11),
('P0010', 'SCAT032', 'Light Ceiling', ' Light Ceiling', 'Any Material', 5),
('P0011', 'SCAT034', 'Three D Ingraining & Embossing', 'Three D wood Ingraining Design', 'wood', 50),
('P0021', 'SCAT022', ' Infrastructure prototype', ' plastic material', 'plastic', 11),
('P0022', 'SCAT024', 'interior design', ' wood material', 'wood ', 13),
('P0023', 'SCAT025', 'Outline Design', ' wood ', 'plastic', 21),
('P0020', 'SCAT023', 'Exterior prototype', 'plastic alloy ', 'plastic', 15),
('P0016', 'SCAT013', 'Statue', ' Any Material Statue', 'Any Material', 50),
('P0017', 'SCAT010', 'suit', ' Material cloth cotton', 'cotton', 50),
('P0018', 'SCAT009', 'T Shirt', ' cotton material t-shirt for men', 'cotton', 10),
('P0019', 'SCAT001', 'Bean Bag chair', '  woodmaterial', 'wood', 50),
('P0024', 'SCAT017', 'Realistic painting', ' 3D painting', 'Any material', 11),
('P0025', 'SCAT028', 'Technical Drawing', 'model cad drawing can modify as your wish ', '-----', 11),
('P0026', 'SCAT027', 'Object Drawing	', 'It\'s an infrastructure of an object', '-----', 13),
('P0027', 'SCAT029', 'mechanical draft', ' structure of an model', '-----', 11),
('P0028', 'SCAT019', 'printed painting', ' 3d printed painting', '3d printing', 21),
('P0029', 'SCAT017', 'Drawing', ' pencil drawing (3D look)', 'pencil drawing', 25),
('P0030', 'SCAT010', 'pants', 'Formal wear  Cotton material pants', 'Cotton', 25),
('P0031', 'SCAT010', 'Suit with coat', ' Cotton material suit for men', 'Cotton', 31),
('P0032', 'SCAT002', 'Glass Table', ' The glass table is fully made of glass and the stand is made of steel', 'Glass and Steel', 13),
('P0033', 'SCAT003', 'Sofa', ' Cushion sofa set with accessories', 'Cushion', 11),
('P0034', 'SCAT005', 'curtain', 'Gradient color and various material curtains', 'Any material', 51),
('P0035', 'SCAT034', 'Ingrain and Emboss', ' Ingrain and Emboss things for decoration', 'plastic', 50),
('P0036', 'SCAT012', 'sweater', ' cotton sweater ', 'Cotton', 55),
('P0037', 'SCAT032', 'Modern ceiling', 'Modern ceiling  multi color various materials for decoration', 'Any material', 5),
('P0038', 'SCAT033', 'casual ceiling', ' casual ceiling with multiple colors and various materials', 'Any material', 5),
('P0039', 'SCAT031', 'Wood Ceiling', '	Wood ceiling with multiple colors', 'wood', 11),
('P0040', 'SCAT022', 'building prototype', 'The model of a building able to modify ', 'plastic', 11),
('P0041', 'SCAT015', 'coins', ' coins for decorate hall', 'Any material', 10),
('P0042', 'SCAT016', 'paper works', ' paper works for kids\' party', 'paper', 11),
('P0043', 'SCAT008', 'Coat', ' cotton coat', 'Cotton', 11),
('P0044', 'SCAT002', 'Tables', ' tables any material', 'Any material', 11),
('P0045', 'SCAT017', 'Two D painting', 'plain  Two D painting ', 'Cotton', 11),
('P0046', 'SCAT007', 'wool bed sheet', 'Wool material large size', 'wool', 11),
('P0047', 'SCAT036', 'Plastic Ingrain  Emboss', 'Plastic material elements for Decoration ', 'plastic', 11),
('P0048', 'SCAT035', 'wood ingrain and emboss', 'wood ingrain and emboss for decoration', 'wood', 11),
('P0049', 'SCAT032', 'Metal ceiling', 'metal ceiling with various chromium colors', 'metal(Any)', 11),
('P0050', 'SCAT018', 'Oil painting', 'oil painting for decorate hall\r\n ', 'oil', 5),
('P0051', 'SCAT030', 'Area Cad Drawing', 'It\'s a sample Area Drawing able to customize as your wish.', '----', 11),
('P0052', 'SCAT009', 'shirt', 'denim shirt', 'denim', 10),
('P0053', 'SCAT008', 'coat', ' black coat', 'cotton', 13),
('P0054', 'SCAT002', 'sofa', ' asfd', 'leather', 10);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
  `image_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `image` varchar(15) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`image_id`, `product_id`, `image`) VALUES
('IMG00010', 'P0004', 'IMG00010.jpg'),
('IMG00045', 'P0028', 'IMG00045.jpg'),
('IMG00008', 'P0003', 'IMG00008.jpeg'),
('IMG00007', 'P0002', 'IMG00007.jpg'),
('IMG00037', 'P0020', 'IMG00037.jpg'),
('IMG00036', 'P0001', 'IMG00036.jpeg'),
('IMG00004', 'P0001', 'IMG00004.jpeg'),
('IMG00044', 'P0027', 'IMG00044.jpg'),
('IMG00011', 'P0005', 'IMG00011.jpg'),
('IMG00043', 'P0026', 'IMG00043.jpg'),
('IMG00013', 'P0006', 'IMG00013.jpg'),
('IMG00014', 'P0007', 'IMG00014.jpg'),
('IMG00015', 'P0007', 'IMG00015.jpg'),
('IMG00016', 'P0008', 'IMG00016.jpg'),
('IMG00042', 'P0025', 'IMG00042.jpg'),
('IMG00018', 'P0009', 'IMG00018.jpg'),
('IMG00019', 'P0009', 'IMG00019.jpg'),
('IMG00020', 'P0009', 'IMG00020.jpg'),
('IMG00021', 'P0009', 'IMG00021.jpg'),
('IMG00022', 'P0010', 'IMG00022.jpg'),
('IMG00023', 'P0010', 'IMG00023.jpg'),
('IMG00024', 'P0010', 'IMG00024.jpg'),
('IMG00025', 'P0010', 'IMG00025.jpg'),
('IMG00026', 'P0011', 'IMG00026.jpg'),
('IMG00027', 'P0012', 'IMG00027.jpg'),
('IMG00028', 'P0013', 'IMG00028.jpg'),
('IMG00029', 'P0014', 'IMG00029.jpg'),
('IMG00030', 'P0014', 'IMG00030.jpg'),
('IMG00031', 'P0014', 'IMG00031.jpg'),
('IMG00032', 'P0014', 'IMG00032.jpg'),
('IMG00033', 'P0015', 'IMG00033.jpg'),
('IMG00034', 'P0016', 'IMG00034.jpg'),
('IMG00038', 'P0021', 'IMG00038.jpg'),
('IMG00039', 'P0022', 'IMG00039.jpg'),
('IMG00040', 'P0023', 'IMG00040.jpg'),
('IMG00041', 'P0024', 'IMG00041.jpg'),
('IMG00046', 'P0029', 'IMG00046.jpg'),
('IMG00047', 'P0030', 'IMG00047.jpg'),
('IMG00048', 'P0017', 'IMG00048.jpg'),
('IMG00049', 'P0018', 'IMG00049.jpg'),
('IMG00050', 'P0019', 'IMG00050.jpg'),
('IMG00051', 'P0032', 'IMG00051.jpg'),
('IMG00052', 'P0033', 'IMG00052.jpg'),
('IMG00053', 'P0034', 'IMG00053.jpg'),
('IMG00054', 'P0035', 'IMG00054.jpg'),
('IMG00055', 'P0036', 'IMG00055.jpg'),
('IMG00056', 'P0037', 'IMG00056.jpg'),
('IMG00057', 'P0038', 'IMG00057.jpg'),
('IMG00058', 'P0039', 'IMG00058.jpg'),
('IMG00059', 'P0040', 'IMG00059.jpg'),
('IMG00060', 'P0041', 'IMG00060.jpg'),
('IMG00061', 'P0044', 'IMG00061.jpg'),
('IMG00062', 'P0042', 'IMG00062.jpg'),
('IMG00063', 'P0045', 'IMG00063.jpg'),
('IMG00064', 'P0046', 'IMG00064.jpg'),
('IMG00065', 'P0047', 'IMG00065.jpg'),
('IMG00066', 'P0048', 'IMG00066.jpg'),
('IMG00067', 'P0031', 'IMG00067.jpg'),
('IMG00068', 'P0049', 'IMG00068.jpg'),
('IMG00069', 'P0010', 'IMG00069.jpg'),
('IMG00070', 'P0043', 'IMG00070.jpg'),
('IMG00071', 'P0050', 'IMG00071.jpg'),
('IMG00072', 'P0051', 'IMG00072.jpg'),
('IMG00073', 'P0022', 'IMG00073.jpg'),
('IMG00074', 'P0007', 'IMG00074.jpg'),
('IMG00076', 'P0053', 'IMG00076.jpg'),
('IMG00075', 'P0052', 'IMG00075.jpg'),
('IMG00077', 'P0054', 'IMG00077.jpg'),
('IMG00078', 'P0054', 'IMG00078.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

DROP TABLE IF EXISTS `product_price`;
CREATE TABLE IF NOT EXISTS `product_price` (
  `product_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `offer` decimal(10,2) NOT NULL,
  PRIMARY KEY (`product_id`,`start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`product_id`, `start_date`, `end_date`, `price`, `offer`) VALUES
('P0006', '2022-04-19', NULL, '50000.00', '2.00'),
('P0005', '2022-04-19', NULL, '33000.00', '5.00'),
('P0004', '2022-04-19', '2022-05-01', '25000.00', '5.00'),
('P0003', '2022-04-19', NULL, '1500.00', '3.00'),
('P0002', '2022-04-19', NULL, '20000.00', '2.00'),
('P0001', '2022-04-19', NULL, '100.00', '0.00'),
('P0007', '2022-04-19', NULL, '15000.00', '5.00'),
('P0008', '2022-04-19', NULL, '500.00', '0.00'),
('P0009', '2022-04-19', NULL, '25000.00', '2.00'),
('P0010', '2022-04-19', NULL, '55000.00', '0.00'),
('P0011', '2022-04-19', NULL, '31000.00', '5.00'),
('P0012', '2022-04-19', NULL, '100000.00', '5.00'),
('P0013', '2022-04-19', NULL, '25000.00', '0.00'),
('P0014', '2022-04-19', NULL, '75000.00', '2.00'),
('P0015', '2022-04-20', NULL, '25000.00', '2.00'),
('P0016', '2022-04-20', NULL, '25000.00', '0.00'),
('P0017', '2022-05-05', NULL, '10000.00', '0.00'),
('P0018', '2022-05-05', NULL, '1200.00', '0.00'),
('P0019', '2022-05-05', NULL, '2000.00', '0.00'),
('P0020', '2022-05-05', NULL, '1000.00', '3.00'),
('P0024', '2022-05-18', NULL, '1255.00', '2.00'),
('P0021', '2022-05-18', NULL, '500.00', '0.00'),
('P0022', '2022-05-18', NULL, '1500.00', '5.00'),
('P0023', '2022-05-18', NULL, '750.00', '0.00'),
('P0025', '2022-05-18', '2022-05-22', '1500.00', '0.00'),
('P0026', '2022-05-18', '2022-05-22', '500.00', '0.00'),
('P0027', '2022-05-18', '2022-05-22', '500.00', '0.00'),
('P0028', '2022-05-19', NULL, '2275.00', '5.00'),
('P0029', '2022-05-19', NULL, '1550.00', '3.00'),
('P0030', '2022-05-19', '2022-05-19', '3500.00', '0.00'),
('P0031', '2022-05-19', '2022-05-19', '2500.00', '0.00'),
('P0032', '2022-05-19', NULL, '5000.00', '0.00'),
('P0033', '2022-05-19', NULL, '35000.00', '5.00'),
('P0034', '2022-05-19', NULL, '2500.00', '0.00'),
('P0035', '2022-05-19', NULL, '750.00', '0.00'),
('P0036', '2022-05-19', NULL, '1200.00', '0.00'),
('P0037', '2022-05-19', NULL, '25000.00', '3.00'),
('P0038', '2022-05-19', NULL, '17000.00', '0.00'),
('P0039', '2022-05-19', NULL, '13000.00', '0.00'),
('P0040', '2022-05-19', NULL, '1520.00', '0.00'),
('P0041', '2022-05-19', NULL, '75.00', '0.00'),
('P0042', '2022-05-19', NULL, '50.00', '0.00'),
('P0043', '2022-05-19', '2022-05-19', '2500.00', '0.00'),
('P0044', '2022-05-19', '2022-05-19', '5000.00', '0.00'),
('P0045', '2022-05-20', NULL, '550.00', '0.00'),
('P0046', '2022-05-20', NULL, '500.00', '0.00'),
('P0044', '2022-05-20', NULL, '15000.00', '0.00'),
('P0047', '2022-05-20', NULL, '275.00', '0.00'),
('P0048', '2022-05-20', NULL, '755.00', '0.00'),
('P0018', '2022-05-20', NULL, '1500.00', '0.00'),
('P0030', '2022-05-20', NULL, '1200.00', '0.00'),
('P0031', '2022-05-20', NULL, '1200.00', '0.00'),
('P0051', '2022-05-22', NULL, '750.00', '0.00'),
('P0049', '2022-05-20', NULL, '50000.00', '5.00'),
('P0010', '2022-05-20', NULL, '25000.00', '0.00'),
('P0043', '2022-05-20', NULL, '1500.00', '0.00'),
('P0050', '2022-05-20', NULL, '1600.00', '0.00'),
('P0027', '2022-05-23', NULL, '700.00', '0.00'),
('P0025', '2022-05-23', NULL, '1500.00', '0.00'),
('P0026', '2022-05-23', NULL, '650.00', '0.00'),
('P0052', '2022-05-26', NULL, '900.00', '0.00'),
('P0053', '2022-05-26', NULL, '1500.00', '0.00'),
('P0054', '2022-11-23', NULL, '25000.00', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE IF NOT EXISTS `purchase` (
  `purchase_id` varchar(10) NOT NULL,
  `supplier_id` varchar(10) NOT NULL,
  `purchase_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `pay_mode` varchar(10) NOT NULL,
  `pay_status` varchar(10) NOT NULL,
  `upload_slip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `supplier_id`, `purchase_date`, `amount`, `pay_mode`, `pay_status`, `upload_slip`) VALUES
('PUR0005', 'SUP002', '2022-05-05', '238000.00', 'Bank', 'Paid', 'PUR0005.jpg'),
('PUR0004', 'SUP004', '2022-05-05', '452000.00', 'Bank', 'Paid', 'PUR0004.jpg'),
('PUR0003', 'SUP006', '2022-05-05', '7100000.00', 'Bank', 'Paid', 'PUR0003.jpg'),
('PUR0001', 'SUP005', '2022-04-19', '1625000.00', 'Cash', 'Paid', NULL),
('PUR0006', 'SUP003', '2022-05-05', '135000.00', 'Bank', 'Paid', 'PUR0006.jpg'),
('PUR0007', 'SUP006', '2022-05-05', '40000.00', 'Bank', 'Paid', 'PUR0007.jpg'),
('PUR0008', 'SUP005', '2022-05-05', '102500.00', 'Cash', 'Paid', NULL),
('PUR0009', 'SUP006', '2022-05-05', '77600.00', 'Cash', 'Paid', NULL),
('PUR0010', 'SUP006', '2022-05-05', '62500.00', 'Cash', 'Paid', NULL),
('PUR0011', 'SUP003', '2022-05-05', '100750.00', 'Cash', 'Paid', NULL),
('PUR0012', 'SUP001', '2022-05-05', '1250000.00', 'Cash', 'Paid', NULL),
('PUR0013', 'SUP005', '2022-05-19', '80560.00', 'Cash', 'Paid', NULL),
('PUR0014', 'SUP006', '2022-05-19', '136165.00', 'Cash', 'Paid', NULL),
('PUR0015', 'SUP005', '2022-05-19', '37500.00', 'Cash', 'Paid', NULL),
('PUR0016', 'SUP002', '2022-05-20', '2925740.00', 'Cash', 'Paid', NULL),
('PUR0017', 'SUP002', '2022-05-20', '177900.00', 'Cash', 'Paid', NULL),
('PUR0018', 'SUP006', '2022-05-20', '1375000.00', 'Cash', 'Paid', NULL),
('PUR0020', 'SUP006', '2022-05-20', '514950.00', 'Cash', 'Paid', NULL),
('PUR0021', 'SUP004', '2022-05-20', '522000.00', 'Cash', 'Paid', NULL),
('PUR0022', 'SUP006', '2022-05-20', '1050000.00', 'Cash', 'Paid', NULL),
('PUR0023', 'SUP004', '2022-05-20', '675000.00', 'Cash', 'Paid', NULL),
('PUR0024', 'SUP006', '2022-05-20', '675000.00', 'Cash', 'Paid', NULL),
('PUR0025', 'SUP003', '2022-05-20', '2170000.00', 'Cash', 'Paid', NULL),
('PUR0026', 'SUP005', '2022-05-20', '443475.00', 'Cash', 'Paid', NULL),
('PUR0027', 'SUP004', '2022-05-20', '1015000.00', 'Cash', 'Paid', NULL),
('PUR0029', 'SUP006', '2022-05-21', '90000.00', 'Cash', 'Paid', NULL),
('PUR0030', 'SUP005', '2022-05-22', '35750.00', 'Cash', 'Paid', NULL),
('PUR0031', 'SUP005', '2022-05-26', '3750.00', 'Bank', 'Paid', 'PUR0031.jpg'),
('PUR0032', 'SUP006', '2022-11-23', '76000000.00', 'Bank', 'Paid', 'PUR0032.jpg'),
('PUR0033', 'SUP006', '2022-11-27', '200500.00', 'Cash', 'Paid', NULL),
('PUR0034', 'SUP005', '2022-11-27', '6566000.00', 'Cash', 'Paid', NULL),
('PUR0035', 'SUP006', '2022-11-27', '177500.00', 'Cash', 'Paid', NULL),
('PUR0036', 'SUP005', '2022-11-27', '532500.00', 'Cash', 'Paid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product`
--

DROP TABLE IF EXISTS `purchase_product`;
CREATE TABLE IF NOT EXISTS `purchase_product` (
  `purchase_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`purchase_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_product`
--

INSERT INTO `purchase_product` (`purchase_id`, `product_id`, `quantity`, `purchase_price`) VALUES
('PUR0001', 'P0010', 30, '75000.00'),
('PUR0001', 'P0007', 45, '13000.00'),
('PUR0001', 'P0009', 5, '25000.00'),
('PUR0001', 'P0002', 9, '50000.00'),
('PUR0001', 'P0004', 2, '5000.00'),
('PUR0001', 'P0005', 10, '5000.00'),
('PUR0001', 'P0013', 5, '155000.00'),
('PUR0002', 'P0004', 51, '75000.00'),
('PUR0002', 'P0006', 43, '175000.00'),
('PUR0002', 'P0008', 5, '7500.00'),
('PUR0003', 'P0004', 500, '2800.00'),
('PUR0003', 'P0002', 100, '35000.00'),
('PUR0003', 'P0009', 200, '11000.00'),
('PUR0004', 'P0017', 50, '1500.00'),
('PUR0004', 'P0018', 120, '2500.00'),
('PUR0004', 'P0008', 2, '1000.00'),
('PUR0004', 'P0006', 50, '1500.00'),
('PUR0005', 'P0019', 20, '2000.00'),
('PUR0005', 'P0004', 50, '2000.00'),
('PUR0005', 'P0017', 50, '1000.00'),
('PUR0005', 'P0008', 2, '2000.00'),
('PUR0005', 'P0020', 2000, '22.00'),
('PUR0006', 'P0010', 2, '25000.00'),
('PUR0006', 'P0013', 5, '15000.00'),
('PUR0006', 'P0020', 4, '1000.00'),
('PUR0006', 'P0001', 50, '120.00'),
('PUR0007', 'P0017', 20, '2000.00'),
('PUR0008', 'P0004', 20, '2000.00'),
('PUR0008', 'P0015', 125, '500.00'),
('PUR0009', 'P0016', 20, '100.00'),
('PUR0009', 'P0015', 258, '250.00'),
('PUR0009', 'P0003', 12, '925.00'),
('PUR0010', 'P0011', 50, '1250.00'),
('PUR0011', 'P0007', 50, '1220.00'),
('PUR0011', 'P0011', 53, '750.00'),
('PUR0012', 'P0010', 50, '25000.00'),
('PUR0013', 'P0021', 53, '1520.00'),
('PUR0014', 'P0008', 69, '750.00'),
('PUR0014', 'P0016', 57, '250.00'),
('PUR0014', 'P0005', 55, '253.00'),
('PUR0014', 'P0041', 450, '75.00'),
('PUR0014', 'P0042', 450, '50.00'),
('PUR0015', 'P0017', 25, '1500.00'),
('PUR0016', 'P0011', 55, '100.00'),
('PUR0016', 'P0003', 55, '200.00'),
('PUR0016', 'P0034', 57, '350.00'),
('PUR0016', 'P0001', 150, '25.00'),
('PUR0016', 'P0036', 120, '300.00'),
('PUR0016', 'P0024', 45, '1000.00'),
('PUR0016', 'P0029', 45, '950.00'),
('PUR0016', 'P0022', 63, '750.00'),
('PUR0016', 'P0020', 99, '450.00'),
('PUR0016', 'P0023', 123, '250.00'),
('PUR0016', 'P0008', 120, '220.00'),
('PUR0016', 'P0026', 120, '150.00'),
('PUR0016', 'P0025', 142, '120.00'),
('PUR0016', 'P0027', 125, '120.00'),
('PUR0016', 'P0039', 45, '10000.00'),
('PUR0016', 'P0010', 50, '25000.00'),
('PUR0016', 'P0038', 53, '15000.00'),
('PUR0016', 'P0035', 452, '150.00'),
('PUR0017', 'P0032', 100, '1500.00'),
('PUR0017', 'P0044', 45, '500.00'),
('PUR0017', 'P0021', 45, '120.00'),
('PUR0018', 'P0033', 55, '25000.00'),
('PUR0019', 'P0045', 511, '250.00'),
('PUR0019', 'P0021', 10, '1520.00'),
('PUR0019', 'P0018', 150, '750.00'),
('PUR0019', 'P0030', 120, '900.00'),
('PUR0019', 'P0004', 120, '1220.00'),
('PUR0019', 'P0003', 500, '200.00'),
('PUR0020', 'P0046', 500, '150.00'),
('PUR0020', 'P0009', 123, '650.00'),
('PUR0020', 'P0010', 12, '30000.00'),
('PUR0024', 'P0043', 450, '1500.00'),
('PUR0021', 'P0021', 52, '750.00'),
('PUR0022', 'P0049', 21, '50000.00'),
('PUR0023', 'P0043', 450, '1500.00'),
('PUR0025', 'P0037', 43, '25000.00'),
('PUR0025', 'P0010', 15, '50000.00'),
('PUR0025', 'P0039', 15, '23000.00'),
('PUR0026', 'P0031', 25, '7000.00'),
('PUR0026', 'P0030', 75, '950.00'),
('PUR0026', 'P0047', 150, '250.00'),
('PUR0026', 'P0028', 80, '450.00'),
('PUR0026', 'P0045', 45, '980.00'),
('PUR0026', 'P0048', 175, '455.00'),
('PUR0027', 'P0031', 145, '7000.00'),
('PUR0028', 'P0050', 120, '750.00'),
('PUR0029', 'P0050', 120, '750.00'),
('PUR0030', 'P0051', 55, '650.00'),
('PUR0031', 'P0016', 5, '750.00'),
('PUR0032', 'P0016', 500, '150000.00'),
('PUR0032', 'P0033', 5, '200000.00'),
('PUR0033', 'P0016', 75, '1000.00'),
('PUR0033', 'P0005', 251, '500.00'),
('PUR0034', 'P0043', 91, '1000.00'),
('PUR0034', 'P0004', 150, '1500.00'),
('PUR0034', 'P0033', 250, '25000.00'),
('PUR0035', 'P0009', 355, '500.00'),
('PUR0036', 'P0043', 355, '1500.00');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `order_id` varchar(10) NOT NULL,
  `review_date` date NOT NULL,
  `rate` int NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`order_id`, `review_date`, `rate`, `comment`) VALUES
('OR00001', '2022-04-19', 4, 'Fair Enough'),
('OR00023', '2022-05-25', 5, 'Deal is Fair and service was awesome'),
('OR00026', '2022-05-26', 4, 'good');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `mobile` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `designation` varchar(10) NOT NULL,
  `join_date` date NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `nic`, `dob`, `gender`, `mobile`, `email`, `designation`, `join_date`, `address`) VALUES
('ST008', 'amali', '985632855v', '1998-03-03', 'Female', 778569235, 'am@gmail.com', 'Worker', '2022-04-13', 'jaffna'),
('ST007', 'Thivaharan', '921251711V', '1992-05-04', 'Male', 778523695, 'thiva1995@gmail.com', 'Clerk', '2022-01-31', 'Jaffna'),
('ST005', 'kapilan', '983630523v', '1998-12-28', 'Male', 778569321, 'kapilan@gmail.com', 'Clerk', '2021-12-16', 'jaffna'),
('ST004', 'RK', '983630704v', '1998-12-28', 'Male', 778569321, 'rukshan1122@gmail.com', 'Clerk', '2021-12-01', 'Jaffna'),
('ST003', 'Siva', '983630666v', '1998-12-28', 'Male', 778569237, 'rukshan@gmail.com', 'Clerk', '2021-12-30', 'jaffna'),
('ST002', 'RK', '983630604v', '1998-12-28', 'Male', 778965234, 'rk1122@gmail.com', 'Clerk', '2021-12-28', 'Jaffna'),
('ST006', 'kabilan', '983645600v', '1998-12-29', 'Male', 778956236, 'sdfsdf@gmail.com', 'Clerk', '2021-12-30', ''),
('ST001', 'Rukmanghan', '983630600v', '1998-12-28', 'Male', 769861092, 'rukshan1122@gmail.com', 'Admin', '2021-12-28', 'Jaffna'),
('ST009', 'Jhon', '943630500v', '1994-12-28', 'Male', 778569777, 'john@gmail.com', 'Worker', '2022-04-19', 'jaffna'),
('ST010', 'Kathir', '913625600v', '1991-12-27', 'Male', 778569111, 'kathir@gmail.com', 'Worker', '2022-04-19', 'Jaffna'),
('ST011', 'Ram', '953632155v', '1995-12-28', 'Male', 758963025, 'ram@gmail.com', 'Clerk', '2022-04-19', 'Jaffna'),
('ST012', 'Arun', '983635600v', '1998-12-28', 'Male', 739861092, 'tharun@gmail.com', 'Worker', '2022-04-27', 'jaffna'),
('ST013', 'Veera', '983650711V', '1998-12-30', 'Male', 778523697, 'veera@gmail.com', 'Clerk', '2022-04-29', 'jaffna'),
('ST014', 'Ben', '983630123v', '1998-12-28', 'Male', 761236548, 'ben@gmail.com', 'Worker', '2022-05-26', 'Colombo');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `product_id` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`product_id`, `quantity`) VALUES
('P0004', 707),
('P0002', 586),
('P0005', 549),
('P0007', 199),
('P0009', 360),
('P0010', 582),
('P0013', 199),
('P0006', 505),
('P0008', 588),
('P0017', 132),
('P0018', 73),
('P0019', 637),
('P0020', 2103),
('P0001', 659),
('P0015', 354),
('P0003', 578),
('P0016', 853),
('P0011', 158),
('P0021', 98),
('P0041', 450),
('P0042', 300),
('P0022', 63),
('P0023', 123),
('P0024', 45),
('P0025', 142),
('P0026', 120),
('P0027', 125),
('P0029', 45),
('P0034', 57),
('P0035', 452),
('P0036', 120),
('P0038', 53),
('P0039', 59),
('P0032', 100),
('P0044', 45),
('P0033', 309),
('P0046', 500),
('P0040', 1555),
('P0049', 21),
('P0043', 1346),
('P0037', 43),
('P0028', 80),
('P0030', 75),
('P0031', 169),
('P0045', 45),
('P0047', 150),
('P0048', 175),
('P0050', 120),
('P0051', 55);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcategory_id` varchar(10) NOT NULL,
  `category_id` varchar(10) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL,
  PRIMARY KEY (`subcategory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `category_id`, `subcategory_name`) VALUES
('SCAT010', 'CAT02', 'suit'),
('SCAT009', 'CAT02', 'shirt'),
('SCAT008', 'CAT02', 'coat'),
('SCAT007', 'CAT02', 'wool bed sheet'),
('SCAT006', 'CAT02', 'carpet'),
('SCAT005', 'CAT02', 'Curtain'),
('SCAT004', 'CAT01', 'Cupboards'),
('SCAT003', 'CAT01', 'Sofa set'),
('SCAT002', 'CAT01', 'Tables'),
('SCAT001', 'CAT01', 'Chairs'),
('SCAT011', 'CAT02', 'Scarf'),
('SCAT012', 'CAT02', 'Sweater'),
('SCAT013', 'CAT03', 'Statues'),
('SCAT014', 'CAT03', 'Vase'),
('SCAT015', 'CAT03', 'Coins'),
('SCAT016', 'CAT03', 'paper works'),
('SCAT017', 'CAT04', 'Paintings'),
('SCAT018', 'CAT04', 'Oil Painting'),
('SCAT019', 'CAT04', 'Printed Paintings'),
('SCAT020', 'CAT04', '3D Paintings'),
('SCAT021', 'CAT05', 'Mall Design'),
('SCAT022', 'CAT05', 'Building Design'),
('SCAT023', 'CAT05', 'Exterior Design'),
('SCAT024', 'CAT05', 'Interior Design'),
('SCAT025', 'CAT05', 'Outline Design'),
('SCAT026', 'CAT06', 'Building Drawing'),
('SCAT027', 'CAT06', 'Object Drawing'),
('SCAT028', 'CAT06', 'Technical Drawing'),
('SCAT029', 'CAT06', 'Mechanical Drawing'),
('SCAT030', 'CAT06', 'Area Drawing'),
('SCAT031', 'CAT07', 'Wood Ceiling'),
('SCAT032', 'CAT07', 'Modern Ceiling'),
('SCAT033', 'CAT07', 'Casual Ceiling'),
('SCAT034', 'CAT08', 'Three D Ingraining & Embossing'),
('SCAT035', 'CAT08', 'Wood Ingraining & Embossing'),
('SCAT036', 'CAT08', 'Plastic Ingraining & Embossing'),
('SCAT037', 'CAT09', 'glass'),
('SCAT038', 'CAT10', 'hfh');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` int NOT NULL,
  `land` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `mobile`, `land`, `email`, `address`) VALUES
('SUP006', 'Tharun', 770258963, 212211144, 'tharun@gmail.com', 'jaffna'),
('SUP005', 'Joshua', 715845998, 212225896, 'joshua@gmail.com', 'colombo'),
('SUP004', 'Alex', 785236410, 212225555, 'alex@yahoo.com', 'colombo'),
('SUP003', 'Ganesh', 758956214, 212214566, 'ganesh@gmail.com', 'jaffna'),
('SUP002', 'Vimal', 779563252, 212215896, 'vimal@gmail.com', 'jaffna'),
('SUP001', 'Arun', 778965230, 212225831, 'arun@gmail.com', 'jaffna');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
