-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2017 at 08:17 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pigeons`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `bill_amount` decimal(10,0) NOT NULL,
  `vat_tax` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `paid_amount` decimal(10,0) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `bank_name` varchar(30) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `payment_date` datetime NOT NULL,
  `entry_by` int(11) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `booking_id`, `bill_amount`, `vat_tax`, `discount`, `total_amount`, `paid_amount`, `payment_type`, `bank_name`, `invoice_no`, `payment_date`, `entry_by`, `entry_date`) VALUES
(1, 2, '100', 0, 5, '95', '80', '', '', '', '0000-00-00 00:00:00', 1, '2017-11-12 06:28:33'),
(2, 6, '200', 0, 0, '200', '500', '', '', '', '0000-00-00 00:00:00', 1, '2017-11-12 06:33:04'),
(3, 5, '200', 0, 0, '200', '800', '', '', '', '0000-00-00 00:00:00', 1, '2017-11-12 06:34:19'),
(4, 3, '100', 0, 0, '100', '250', '', '', '', '0000-00-00 00:00:00', 1, '2017-11-12 06:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` bigint(20) NOT NULL,
  `service_point_id` int(11) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `collected_time` timestamp NULL DEFAULT NULL,
  `collected_by` bigint(20) NOT NULL,
  `delivery_classes` varchar(20) NOT NULL,
  `booking_status` varchar(20) NOT NULL,
  `approve_by` int(11) NOT NULL,
  `approve_date` date NOT NULL,
  `delivery_status` varchar(20) NOT NULL,
  `entry_by` bigint(20) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `service_point_id`, `customer_id`, `request_time`, `collected_time`, `collected_by`, `delivery_classes`, `booking_status`, `approve_by`, `approve_date`, `delivery_status`, `entry_by`, `entry_date`) VALUES
(1, 1, 7, '2017-10-28 07:35:07', NULL, 0, '', 'Booked', 1, '2017-11-02', '', 1, '2017-10-28 07:35:07'),
(2, 1, 9, '2017-10-31 06:19:19', NULL, 0, '', 'Booked', 1, '2017-11-05', '', 1, '2017-10-31 06:19:19'),
(3, 1, 9, '2017-11-04 04:46:43', NULL, 0, '', 'Booked', 0, '0000-00-00', '', 1, '2017-11-04 04:46:43'),
(4, 1, 8, '2017-11-05 09:50:21', NULL, 0, '', 'Rejected', 1, '2017-11-05', '', 1, '2017-11-05 09:50:21'),
(5, 1, 7, '2017-11-05 11:54:49', NULL, 0, '', 'Booked', 0, '0000-00-00', '', 1, '2017-11-05 11:54:49'),
(6, 1, 9, '2017-11-06 05:56:02', NULL, 0, '', 'Booked', 0, '0000-00-00', '', 1, '2017-11-06 05:56:02'),
(7, 1, 8, '2017-11-06 06:47:54', NULL, 0, '', 'Booked', 0, '0000-00-00', '', 1, '2017-11-06 06:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(300) NOT NULL,
  `packet_size` varchar(100) NOT NULL,
  `packet_weight` varchar(20) NOT NULL,
  `purchase_invoice` varchar(200) NOT NULL,
  `packet_qty` int(11) NOT NULL,
  `pick_up_time` datetime NOT NULL,
  `receive_amount` decimal(10,2) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone` varchar(15) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `receiver_address` varchar(200) NOT NULL,
  `delivery_status` varchar(20) NOT NULL,
  `delivery_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `product_category_id`, `product_name`, `product_description`, `packet_size`, `packet_weight`, `purchase_invoice`, `packet_qty`, `pick_up_time`, `receive_amount`, `receiver_name`, `receiver_phone`, `receiver_email`, `receiver_address`, `delivery_status`, `delivery_time`) VALUES
(1, 1, 3, 'Mobile', 'Nokia 1120', '5x5', '.5kg', '1509176098.png', 1, '0000-00-00 00:00:00', '0.00', 'Abdur rahim', '0189798797897', 'rahim@gmail.com', 'Barishal', '', NULL),
(2, 2, 2, 'Baby diapper', 'Cotton pant diapper', '5x5x2', '2kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Mrs. Shanaj Begum', '018646545', '', 'Shibgonj, satkhira.', '', NULL),
(3, 2, 1, 'Office letter', 'letter', '5x5x5', '100g', '', 1, '0000-00-00 00:00:00', '0.00', 'Mr. kamal', '01564654', '', 'Rajshahi', '', NULL),
(4, 3, 2, 'Baby shirt', 'todler Shirt', '5x5x2', '1kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Sheuly Akhter', '01654645', '', 'Kishorgonj', '', NULL),
(5, 4, 4, 'sfsfsf', 'werwerw', 'werw', '43', '', 1, '0000-00-00 00:00:00', '0.00', 'werwerw', '3242342', '', 'erwerwer', '', NULL),
(6, 5, 1, 'Baby shirt', 'todler Shirt', '5x5x2', '20kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Sheuly Akhter', '01654645', '', 'Shibgonj, satkhira, Bangladesh', '', NULL),
(7, 5, 2, 'Mobile', 'Samsung', '5x5x2', '.5kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Jillour Rahman', '3242342', '', 'Shaheb bazar, Rajshahi, Bangladesh', '', NULL),
(8, 5, 1, 'Office letter', 'letter', '5x5', '2kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Mr. Rahman', '321654465', '', 'Shaheb bazar, Rajshahi, Bangladesh', '', NULL),
(9, 5, 3, 'Payment Order', 'fdfs', '5x5', '2kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Sheuly Akhter', '01654645', '', 'Shaheb bazar, Rajshahi, Bangladesh', '', NULL),
(10, 5, 4, 'Baby diapper', 'Cotton pant diapper', '10x10', '2kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Mr. Rahman', '064654556', '', 'Shaheb bazar, Rajshahi, Bangladesh', '', NULL),
(11, 5, 2, 'Baby shirt', 'Cotton pant diapper', '5x5', '34', '', 1, '0000-00-00 00:00:00', '0.00', 'Sheuly Akhter', '01654645', '', 'Shaheb bazar, Borishal, Bangladesh', '', NULL),
(12, 6, 1, 'Letter', 'Office letter', '10x10', '20kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Sheuly Akhter', '354353453', '', 'Hajigonj, chandpur.', '', NULL),
(13, 7, 2, 'Baby shirt', 'Cotton pant diapper', '10x10', '2kg', '', 1, '0000-00-00 00:00:00', '0.00', 'Jillour Rahman', '01654645', '', 'Shaheb bazar, Rajshahi, Bangladesh', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `entry_by` bigint(20) NOT NULL,
  `entry_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `phone`, `email`, `entry_by`, `entry_date`) VALUES
(1, 'ARS Consortium limited', 'Rahman Bhavan, Mohakhali, Dhaka.', '01844188244', 'info@arsconsortium.com', 1, '2017-10-28 11:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session` varchar(100) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `logon_datetime` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `session`, `ip_address`, `logon_datetime`, `last_update`) VALUES
(1, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 17:18:30', '2017-10-22 09:18:30'),
(2, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 17:24:44', '2017-10-22 09:24:44'),
(3, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 18:02:56', '2017-10-22 10:02:56'),
(4, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 18:25:52', '2017-10-22 10:25:52'),
(5, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 18:34:56', '2017-10-22 10:34:56'),
(6, 1, 'rm0k1lbk3foqqj8oouca7667n0', '::1', '2017-10-22 20:32:32', '2017-10-22 12:32:32'),
(7, 1, '2ge1bfpil8mgq1s33jcecg1al4', '::1', '2017-10-23 14:35:27', '2017-10-23 06:35:27'),
(8, 1, '2ge1bfpil8mgq1s33jcecg1al4', '::1', '2017-10-23 19:15:14', '2017-10-23 11:15:14'),
(9, 1, 'lr4umaf6mhcvtml5h3huo6pbu0', '::1', '2017-10-24 12:18:25', '2017-10-24 04:18:25'),
(10, 1, 'lr4umaf6mhcvtml5h3huo6pbu0', '::1', '2017-10-24 16:16:31', '2017-10-24 08:16:31'),
(11, 1, 'lr4umaf6mhcvtml5h3huo6pbu0', '::1', '2017-10-24 17:12:04', '2017-10-24 09:12:04'),
(12, 1, 'ts005fd1cllbeld89760sf2pn3', '::1', '2017-10-25 12:34:02', '2017-10-25 04:34:03'),
(13, 1, 'g0gmfthein7jiq1rmqofjejgu2', '::1', '2017-10-26 12:48:25', '2017-10-26 04:48:25'),
(14, 1, 'i3epi2lgfqrcu4bo13033vu8v3', '::1', '2017-10-26 14:43:42', '2017-10-26 06:43:42'),
(15, 1, 'qjn7lb6d4rcmbvvuqbcgepnut7', '::1', '2017-10-26 16:38:18', '2017-10-26 08:38:18'),
(16, 1, '3l4aj09q33mbjuidn9b60r1ue4', '::1', '2017-10-26 20:28:56', '2017-10-26 12:28:56'),
(17, 1, '44fkavvb1ib6io5u3k3ttbrf52', '::1', '2017-10-28 12:58:57', '2017-10-28 04:58:57'),
(18, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:13:03', '2017-10-31 05:13:03'),
(19, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:13:43', '2017-10-31 05:13:43'),
(20, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:13:54', '2017-10-31 05:13:54'),
(21, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:16:33', '2017-10-31 05:16:33'),
(22, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:17:10', '2017-10-31 05:17:10'),
(23, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:18:12', '2017-10-31 05:18:12'),
(24, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 12:18:22', '2017-10-31 05:18:22'),
(25, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 13:29:06', '2017-10-31 06:29:06'),
(26, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 13:32:12', '2017-10-31 06:32:12'),
(27, 1, 'mu4s1ac9srbia9nqs13p2msqq5', '::1', '2017-10-31 19:19:14', '2017-10-31 12:19:14'),
(28, 1, 'cj3j9bb8oeuhvn2b2lkssf6gi7', '::1', '2017-11-01 11:44:46', '2017-11-01 04:44:51'),
(29, 1, 'r0dta0p9n44ugp5f2svtcoa9v3', '::1', '2017-11-01 17:09:52', '2017-11-01 10:09:52'),
(30, 1, 'p53jfr66jjrpihm3umdqagnbg4', '::1', '2017-11-02 12:21:50', '2017-11-02 05:21:50'),
(31, 1, 'p53jfr66jjrpihm3umdqagnbg4', '::1', '2017-11-02 19:20:22', '2017-11-02 12:20:22'),
(32, 1, 'p53jfr66jjrpihm3umdqagnbg4', '::1', '2017-11-02 19:39:05', '2017-11-02 12:39:05'),
(33, 1, 'p53jfr66jjrpihm3umdqagnbg4', '::1', '2017-11-02 19:40:21', '2017-11-02 12:40:21'),
(34, 1, '2goo2k7n3m7ppqnemf9mugk062', '::1', '2017-11-04 10:43:00', '2017-11-04 03:43:00'),
(35, 1, 'evs2skm5b1qpga6dhj9206tov7', '::1', '2017-11-04 16:05:10', '2017-11-04 09:05:10'),
(36, 1, '1b30kies6eg8rj38pbmaqiarg1', '::1', '2017-11-04 19:39:28', '2017-11-04 12:39:28'),
(37, 1, 'jptipk4p56ctrdnvjt3b4t64e6', '::1', '2017-11-05 11:57:47', '2017-11-05 04:57:47'),
(38, 1, 'jptipk4p56ctrdnvjt3b4t64e6', '::1', '2017-11-05 13:06:21', '2017-11-05 06:06:21'),
(39, 1, 'jptipk4p56ctrdnvjt3b4t64e6', '::1', '2017-11-05 16:24:10', '2017-11-05 09:24:10'),
(40, 1, 'ofp6e4obhb4pi5tkihs188rof6', '::1', '2017-11-05 18:48:04', '2017-11-05 11:48:04'),
(41, 1, 'msqktq321og9lkf0v6fetaauv6', '192.168.2.137', '2017-11-05 18:49:58', '2017-11-05 11:49:58'),
(42, 1, 'dnigoeoqcafhuos1tm0u9g25u1', '::1', '2017-11-06 12:11:39', '2017-11-06 05:11:39'),
(43, 1, 'dnigoeoqcafhuos1tm0u9g25u1', '::1', '2017-11-06 12:53:24', '2017-11-06 05:53:24'),
(44, 1, 'dnigoeoqcafhuos1tm0u9g25u1', '::1', '2017-11-06 13:25:15', '2017-11-06 06:25:15'),
(45, 1, 'dnigoeoqcafhuos1tm0u9g25u1', '::1', '2017-11-06 15:05:45', '2017-11-06 08:05:45'),
(46, 1, '0vo7oo5p5k0s5q71f7f42fdj15', '::1', '2017-11-06 15:08:55', '2017-11-06 08:08:55'),
(47, 1, 'vb5sl7egbee597pkd2l5nrklj7', '::1', '2017-11-06 17:09:20', '2017-11-06 10:09:20'),
(48, 1, 'vb5sl7egbee597pkd2l5nrklj7', '::1', '2017-11-06 17:09:52', '2017-11-06 10:09:52'),
(49, 1, 'vb5sl7egbee597pkd2l5nrklj7', '::1', '2017-11-06 17:19:38', '2017-11-06 10:19:38'),
(50, 1, 'vb5sl7egbee597pkd2l5nrklj7', '::1', '2017-11-06 18:54:47', '2017-11-06 11:54:47'),
(51, 1, '8nlti6phpkhiuvv3j4p0lttm97', '::1', '2017-11-06 18:57:54', '2017-11-06 11:57:54'),
(52, 1, 'a09of3790gj4r4hgl44bhqc494', '::1', '2017-11-07 12:29:17', '2017-11-07 05:29:17'),
(53, 1, 'a09of3790gj4r4hgl44bhqc494', '::1', '2017-11-07 12:53:57', '2017-11-07 05:53:57'),
(54, 1, 'a09of3790gj4r4hgl44bhqc494', '::1', '2017-11-07 15:45:55', '2017-11-07 08:45:55'),
(55, 1, '18q2b5ivq9bpj7to1msv89nu95', '::1', '2017-11-07 16:25:59', '2017-11-07 09:25:59'),
(56, 1, '6ballririk0mojkn1q081cnm97', '::1', '2017-11-08 17:25:04', '2017-11-08 10:25:05'),
(57, 1, 'oo29g60vlb3s7kjn9gb0ne8l02', '::1', '2017-11-08 18:15:54', '2017-11-08 11:15:54'),
(58, 1, 'nqrauunne6qhdupm3m7ik1dga3', '::1', '2017-11-09 12:21:29', '2017-11-09 05:21:30'),
(59, 1, 'nqrauunne6qhdupm3m7ik1dga3', '::1', '2017-11-09 14:46:21', '2017-11-09 07:46:21'),
(60, 1, 'p3l6hu233qrldq8pbaj7d4tfq5', '::1', '2017-11-12 11:59:22', '2017-11-12 04:59:22'),
(61, 1, 'oqrupk8rrvhlgu9m7jlmj3uo91', '::1', '2017-11-16 12:58:32', '2017-11-16 05:58:32'),
(62, 1, '85qfnrbijib1hvcoohbilkidr1', '::1', '2017-11-16 19:02:37', '2017-11-16 12:02:37'),
(63, 1, 'ecno4vocdri06am99ds2i0h8r5', '::1', '2017-11-18 12:01:29', '2017-11-18 05:01:29'),
(64, 1, 'r85me9d92upkqpruma4o9gt3h1', '::1', '2017-11-19 13:32:09', '2017-11-19 06:32:09'),
(65, 1, '9vbvm8spu6atdb5hhrtmt0e3j4', '::1', '2017-11-20 12:45:58', '2017-11-20 05:45:59'),
(66, 1, '6dvs087p91ugh00umpf6mg9kf3', '::1', '2017-11-21 12:09:28', '2017-11-21 05:09:28'),
(67, 1, '6dvs087p91ugh00umpf6mg9kf3', '::1', '2017-11-21 12:23:01', '2017-11-21 05:23:01'),
(68, 1, '6dvs087p91ugh00umpf6mg9kf3', '::1', '2017-11-21 12:25:22', '2017-11-21 05:25:22'),
(69, 1, '6dvs087p91ugh00umpf6mg9kf3', '::1', '2017-11-21 14:35:34', '2017-11-21 07:35:34'),
(70, 1, 'f91d8gbm0i11tv2lsil7nvvet0', '::1', '2017-11-22 11:36:05', '2017-11-22 04:36:07'),
(71, 1, 'f91d8gbm0i11tv2lsil7nvvet0', '::1', '2017-11-22 19:00:55', '2017-11-22 12:00:55'),
(72, 1, 'tgkld5e6if0788p2c45dab9h37', '::1', '2017-11-23 13:34:44', '2017-11-23 06:34:44'),
(73, 1, 'tgkld5e6if0788p2c45dab9h37', '::1', '2017-11-23 16:30:38', '2017-11-23 09:30:39'),
(74, 1, 'v8hn7kulc45sofdrh2fk8fpgb6', '::1', '2017-11-23 17:43:22', '2017-11-23 10:43:23'),
(75, 1, 'v8hn7kulc45sofdrh2fk8fpgb6', '::1', '2017-11-23 18:02:57', '2017-11-23 11:02:57'),
(76, 1, 'c6f7jp10hf14din098qlh93sa1', '::1', '2017-11-25 11:47:37', '2017-11-25 04:47:37'),
(77, 1, 'c6f7jp10hf14din098qlh93sa1', '::1', '2017-11-25 18:49:50', '2017-11-25 11:49:50'),
(78, 1, 'qebrtnvk3ss3760h2ni26mtqc1', '::1', '2017-11-26 13:33:42', '2017-11-26 06:33:42'),
(79, 1, 'ckeinc5qjfj06o4orqk278nhk6', '::1', '2017-11-27 11:32:14', '2017-11-27 04:32:16'),
(80, 1, '9pgfitnvlt88edt0tupcnbr0i7', '::1', '2017-11-30 14:36:44', '2017-11-30 07:36:45'),
(81, 1, 'me0rbl4j6cad3fnq4u35ba6ir6', '::1', '2017-12-03 13:33:40', '2017-12-03 06:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `comment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `comment`) VALUES
(1, 'Documents', ''),
(2, 'Products', ''),
(3, 'Money Order', ''),
(4, 'Others', '');

-- --------------------------------------------------------

--
-- Table structure for table `service_point`
--

CREATE TABLE `service_point` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_point`
--

INSERT INTO `service_point` (`id`, `name`, `contact_person`, `address`, `phone`, `email`) VALUES
(1, 'Head Office', 'Aksh ahmed', 'Mohakhali flyover, Petrolpump', '0154654654', 'info@gmail.com'),
(2, 'Dhanmondi', 'Raju', '21, panthpath, KS Tower, ', '03213265454', 'raju@gmail.com'),
(3, 'Mohammadpur', 'Abdur rashid', '222, townhal, Mohammadpur', '0121313', 'mohammadpur@letsgobd.com'),
(4, 'Mirpur', 'Jamal Ahmed', '10, Mirpur-2.', '06546546', 'mirpur@letsgobd.com');

-- --------------------------------------------------------

--
-- Table structure for table `temp_booking_details`
--

CREATE TABLE `temp_booking_details` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `service_point_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(300) NOT NULL,
  `packet_size` varchar(100) NOT NULL,
  `packet_weight` varchar(20) NOT NULL,
  `purchase_invoice` varchar(200) NOT NULL,
  `packet_qty` varchar(20) NOT NULL,
  `pick_up_time` datetime NOT NULL,
  `receive_amount` decimal(10,2) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone` varchar(15) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `receiver_address` varchar(200) NOT NULL,
  `booking_status` varchar(20) NOT NULL DEFAULT 'Request',
  `entry_by` bigint(20) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `service_point_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_type` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Inactive',
  `full_name` varchar(50) NOT NULL,
  `mailing_address` varchar(200) NOT NULL,
  `entry_by` bigint(20) NOT NULL,
  `entry_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `service_point_id`, `user_name`, `password`, `email`, `phone`, `user_type`, `status`, `full_name`, `mailing_address`, `entry_by`, `entry_date`) VALUES
(1, 1, 'farukh', 'e10adc3949ba59abbe56e057f20f883e', 'umor@yahoo.com', '0469598989', 1, 'Inactive', '', '', 1, '2017-10-16 12:02:38'),
(2, 1, 'Hamid', 'e10adc3949ba59abbe56e057f20f883e', 'khan@gmail.com', '34634643', 2, 'Inactive', 'Akhter Hamid Khan', 'dhaka.', 1, '2017-10-18 16:53:11'),
(3, 1, '', '', '', '', 0, 'Inactive', '', '', 1, '2017-10-23 18:41:13'),
(7, 1, 'khamal', '', 'kamal@yahoo.com', '+88 654 654 665', 4, 'Inactive', 'Khamal Ahmed', 'dhaka', 1, '2017-10-24 13:30:31'),
(8, 1, 'farid', '', 'farid@gmail.com', '+88 016 987 878', 4, 'Inactive', 'Farid ahmed', 'Barishal', 1, '2017-10-24 15:19:52'),
(9, 1, 'babyshop', '', 'babyshop@gmail.com', '+88 013 216 546', 4, 'Active', 'Monowara aperals', 'mirpur, dhaka', 1, '2017-10-26 13:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'User'),
(4, 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(10) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `reg_no` varchar(30) NOT NULL,
  `status` varchar(15) NOT NULL,
  `entry_by` int(11) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle_type`, `brand`, `model`, `reg_no`, `status`, `entry_by`, `entry_date`) VALUES
(1, 'Bike', 'Honda', 'CBZ', 're-5412', 'T', 1, '2017-11-27 06:53:28'),
(2, 'Car', 'Toyota', 'Nissan', 'reg-646465', 'T', 1, '2017-11-27 06:53:28'),
(3, 'Bike', 'Yahama', 'FZ', 'reg-3454', 'T', 1, '2017-11-27 06:53:28'),
(4, 'Pickup Van', 'TATA', 'model', 'reg-464', 'F', 1, '2017-11-30 07:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_managment`
--

CREATE TABLE `vehicle_managment` (
  `id` bigint(20) NOT NULL,
  `booking_details_id` bigint(20) NOT NULL,
  `vehicle_id` bigint(20) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `start_location` int(11) NOT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `end_location` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `entry_by` int(11) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_managment`
--

INSERT INTO `vehicle_managment` (`id`, `booking_details_id`, `vehicle_id`, `start_time`, `start_location`, `end_time`, `end_location`, `comment`, `entry_by`, `entry_date`) VALUES
(1, 4, 4, '2017-11-19 10:04:01', 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 10:02:49'),
(2, 5, 2, NULL, 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 11:55:54'),
(3, 3, 1, NULL, 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 11:56:54'),
(4, 1, 2, NULL, 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 11:59:12'),
(5, 9, 2, NULL, 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 11:59:53'),
(6, 2, 1, NULL, 0, '0000-00-00 00:00:00', 0, '0', 1, '2017-11-19 12:00:21'),
(7, 13, 1, NULL, 0, NULL, 0, '0', 1, '2017-11-20 09:15:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_point`
--
ALTER TABLE `service_point`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_booking_details`
--
ALTER TABLE `temp_booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- Indexes for table `vehicle_managment`
--
ALTER TABLE `vehicle_managment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_details_id` (`booking_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_point`
--
ALTER TABLE `service_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `temp_booking_details`
--
ALTER TABLE `temp_booking_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_managment`
--
ALTER TABLE `vehicle_managment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
