-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 09:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaint`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_name`, `password`, `id`) VALUES
('admin', 'admin', 1),
('Chanchal', 'chancjangid', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category`) VALUES
('Electric supply'),
('Other'),
('Power line'),
('Road conditions'),
('Stray animals'),
('Street light'),
('Water supply');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `s_no` int(11) NOT NULL,
  `category` varchar(150) NOT NULL,
  `description` varchar(300) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `dt_resolve` timestamp NULL DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `resolved_by_admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `s_no`, `category`, `description`, `address`, `city`, `state`, `pincode`, `dt`, `dt_resolve`, `resolved`, `resolved_by_admin_id`) VALUES
(2, 13, 'Street light', 'lights dont work at all', 'behind union bank', 'barmer', 'Rajasthan', 344001, '2023-08-01 09:48:56', '2023-08-02 01:43:54', 1, 1),
(3, 13, 'Street light', 'lights dont work at all', 'behind union bank', 'barmer', 'Rajasthan', 344001, '2023-08-01 09:53:41', '2023-08-02 01:44:09', 1, 1),
(4, 14, 'Water supply', 'It is not timely', 'E 83, Lal Bahadur Nagar ( West) SL Marg', 'jaipur', 'rajasthan', 302018, '2023-08-02 01:06:53', '2023-08-02 01:43:41', 1, 1),
(5, 9, 'Power line', 'Their is no appropriate power supply', 'Ballabhbari, Gumanpura', 'Kota', 'rajasthan', 324007, '2023-08-02 01:11:39', '2023-08-02 01:44:06', 1, 1),
(6, 11, 'Electric supply', 'The lights are being cut regurlarly enough. Exams of our children are ahead. PLease help !!', 'Old Housing Board, Housing Board', 'Pali', 'rajasthan', 306401, '2023-08-02 01:11:39', NULL, 0, NULL),
(7, 2, 'Stray animals', 'A lot of dead cows are thrown in our street and is increasing the infections.', 'Khuri', 'jaisalmer', 'rajasthan', 345001, '2023-08-02 01:14:45', NULL, 0, NULL),
(8, 19, 'Road conditions', 'All the roads are broken due to heavy rains.', 'Queens Rd, Moti Nagar, Nityanand Nagar, Vaishali Nagar', 'jaipur', 'rajasthan', 302021, '2023-08-02 01:14:45', '2023-08-02 01:44:04', 1, 1),
(9, 17, 'Power line', 'The road is only half built and the workers have stopped the work already', 'Station Rd, Jail Well Mohalla', 'bikaner', 'rajasthan', 334001, '2023-08-02 01:40:35', '2023-08-02 01:43:51', 1, 1),
(10, 6, 'Water supply', 'There is no water in our locality for past two days.Please help!!', 'Bapu Market\r\n', 'jaipur', 'rajasthan', 302003, '2023-08-02 01:18:35', NULL, 0, NULL),
(11, 7, 'Other', 'My neighbours are not good', '33, University Rd, Pahada', 'udaipur', 'rajasthan', 313001, '2023-08-02 01:24:41', '2023-08-02 01:43:59', 1, 1),
(12, 8, 'Stray animals ', 'The amount of stray animals have increased rapidly in our locality and the municipal is not giving any attention', '13 & 14, PRATAP NAGAR SEC. 3,[], NEAR LAXMI MISHTAN BHANDAR, TONK ROAD,', 'jaipur', 'rajasthan', 302022, '2023-08-02 01:24:41', '2023-08-03 06:40:31', 1, 2),
(13, 20, 'Electric supply', 'The wires are all jumbled and it is not safe ', 'Rishi Shiv Raj Market,Opp.Janta Sweet Home, Rly Station Road', 'jodhpur', 'rajasthan', 342001, '2023-08-02 01:30:05', NULL, 0, NULL),
(14, 12, 'Power line', 'There are voltage issues ', 'Chitrakoot Scheme', 'jaipur', 'rajasthan', 302021, '2023-08-02 01:30:05', '2023-08-03 06:40:29', 1, 2),
(15, 4, 'Road conditions', 'the roads are not being made even after complaining in the municipal', 'St Mary\'s School Rd', 'Mt. abu', 'rajasthan', 307501, '2023-08-02 01:35:14', '2023-08-03 06:22:29', 1, 1),
(16, 4, 'Street light', 'All the street lights are broken', 'St Mary\'s School Rd', 'Mt. abu', 'rajasthan', 307501, '2023-08-02 01:35:14', '2023-08-02 01:43:49', 1, 1),
(17, 13, 'Street light', 'lights dont work at all', 'behind union bank', 'barmer', 'Rajasthan', 344001, '2023-08-01 09:48:56', '0000-00-00 00:00:00', 0, NULL),
(18, 3, 'Street light', 'lights dont work at all', 'behind union bank', 'barmer', 'Rajasthan', 344001, '2023-08-01 09:48:56', '0000-00-00 00:00:00', 0, NULL),
(19, 12, 'Electric supply', 'The wires are all jumbled and it is not safe ', 'Rishi Shiv Raj Market,Opp.Janta Sweet Home, Rly Station Road', 'jodhpur', 'rajasthan', 342001, '2023-08-02 01:30:05', '2023-08-02 01:44:51', 1, 1),
(20, 19, 'Road conditions', 'the roads are not being made even after complaining in the municipal', 'St Mary\'s School Rd', 'Mt. abu', 'rajasthan', 307501, '2023-08-02 01:35:14', NULL, 0, NULL),
(21, 18, 'Road conditions', 'the roads are not being made even after complaining in the municipal', 'St Mary\'s School Rd', 'Mt. abu', 'rajasthan', 307501, '0000-00-00 00:00:00', '2023-08-02 01:43:47', 1, 1),
(22, 5, 'Other', 'My neighbours are not good', '33, University Rd, Pahada', 'udaipur', 'rajasthan', 313001, '2023-08-02 01:42:41', '2023-08-03 06:22:36', 1, 1),
(23, 11, 'Street light', 'lights dont work at all', 'behind union bank', 'barmer', 'Rajasthan', 344001, '2023-08-01 01:48:56', '2023-08-03 06:40:26', 1, 2),
(24, 13, 'Water supply', 'There is no water in our locality for past two days.Please help!!', 'Bapu Market\r\n', 'jaipur', 'rajasthan', 302003, '2023-08-02 01:48:35', '2023-08-02 01:43:43', 1, 1),
(25, 1, 'Electric supply', 'The wires are all jumbled and it is not safe ', 'Rishi Shiv Raj Market,Opp.Janta Sweet Home, Rly Station Road', 'jodhpur', 'rajasthan', 342001, '2023-08-02 01:49:05', NULL, 0, NULL),
(26, 15, 'Stray animals ', 'The amount of stray animals have increased rapidly in our locality and the municipal is not giving any attention', '13 & 14, PRATAP NAGAR SEC. 3,[], NEAR LAXMI MISHTAN BHANDAR, TONK ROAD,', 'jaipur', 'rajasthan', 302022, '2023-08-02 01:49:41', '2023-08-02 01:43:44', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `s_no` int(20) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_no` bigint(20) NOT NULL,
  `adhar_no` bigint(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`s_no`, `username`, `email`, `phone_no`, `adhar_no`, `password`, `dt`) VALUES
(1, 'Chanchal', 'cj34@gmail.com', 2147483647, 2147483647, '4567@', '2023-07-31 10:10:56'),
(2, 'Sunita', 'sunita@gmail.com', 1098750000, 888833336666, '234', '2023-07-31 10:25:49'),
(3, 'Hema', 'hema@gmail.com', 8674000011, 555577770000, 'hello', '2023-07-31 10:26:29'),
(4, 'Sumit', 'Sumitag@gmail.com', 1098750000, 666689793411, 'sionara', '2023-07-31 10:27:30'),
(5, 'Vishal', 'visHal@gmail.com', 5388000051, 555577771111, '23v45', '2023-07-31 10:28:24'),
(6, 'Rahul', 'rahuljoshi@gmail.com', 8674000045, 455578883023, 'abcd', '2023-07-31 10:29:10'),
(7, 'Shweta', 'shetaM@gmail.com', 5634890001, 777733332456, 'thanks', '2023-07-31 10:46:37'),
(8, 'Hemant', 'hemantchoudhary@gmail.com', 8602446811, 888833336624, '8642', '2023-07-31 11:53:02'),
(9, 'Pankaj Jangid', 'pankajjangid42@gmail.com', 8239159834, 234678909876543, '4567@', '2023-07-31 13:36:21'),
(10, 'Pankaj', 'pank@gmail.com', 2345678909, 1234569876543, '4567@', '2023-07-31 13:40:51'),
(11, 'Pankaj J', 'psdoifb@gmail.com', 3456789876, 9876543245, '4567@', '2023-07-31 13:42:30'),
(12, 'Sheetal', 'shee@gmail.com', 65434565, 3456765443552, '4567@', '2023-07-31 13:47:09'),
(13, 'Muskaan', 'mus@gmail.com', 98765678, 98765678876, '1234', '2023-07-31 13:58:31'),
(14, 'Heena', 'heena@hmail.com', 7654345678, 987654567876, '1234', '2023-07-31 14:31:09'),
(15, 'Ramesh', 'ramesh@gmail.com', 5648000271, 444563731000, 'ramesh1234', '2023-08-02 06:21:12'),
(16, 'Suresh Kumar', 'sureshk@gmail.com', 8435262700, 444563731111, 'sk1234', '2023-08-02 06:25:38'),
(17, 'Mahesh Hari', 'mh@gmail.com', 3888990000, 444477774567, 'maheshari', '2023-08-02 06:26:32'),
(18, 'Reena Kumari', 'reenakumari45@gmail.com', 9875460002, 222244446666, 'reena', '2023-08-02 06:27:31'),
(19, 'Teena Singh', 'teenasingh32@gmail.com', 4681012422, 555566662222, 'teena32', '2023-08-02 06:28:51'),
(20, 'Surekha Kumari', 'surekhak@gmail.com', 9678420000, 999900003456, 'surekha', '2023-08-02 06:30:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s_no` (`s_no`),
  ADD KEY `category` (`category`),
  ADD KEY `resolved_by_admin_id` (`resolved_by_admin_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`s_no`),
  ADD UNIQUE KEY `adhar_no` (`adhar_no`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `s_no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`s_no`) REFERENCES `signup` (`s_no`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`category`),
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`resolved_by_admin_id`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
