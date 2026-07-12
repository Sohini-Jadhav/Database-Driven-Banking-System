-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2026 at 06:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mybank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `account_type` enum('Savings','Current','Fixed Deposit') NOT NULL,
  `balance` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive','Blocked') DEFAULT 'Active',
  `branch_code` varchar(10) DEFAULT NULL,
  `available_balance` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `customer_id`, `account_number`, `account_type`, `balance`, `status`, `branch_code`, `available_balance`) VALUES
(1, 1, '1000000001', 'Savings', 24000.00, 'Active', 'BR001', 24000.00),
(2, 2, '1000000002', 'Current', 45000.00, 'Active', 'BR002', 45000.00),
(3, 3, '1000000003', 'Savings', 16000.00, 'Active', 'BR003', 16000.00),
(4, 4, '1000000004', 'Current', 54000.00, 'Inactive', 'BR004', 54000.00),
(5, 5, '1000000005', 'Savings', 10000.00, 'Active', 'BR005', 10000.00),
(6, 6, '1000000006', 'Savings', 35000.00, 'Blocked', 'BR001', 35000.00),
(7, 7, '1000000007', 'Current', 72000.00, 'Active', 'BR002', 72000.00),
(8, 8, '1000000008', 'Savings', 13000.00, 'Active', 'BR003', 13000.00),
(9, 9, '1000000009', 'Savings', 28000.00, 'Active', 'BR004', 28000.00),
(11, 12, '1000000010', 'Current', 9000.00, 'Inactive', 'BR003', 9000.00);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('Admin','Manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password_hash`, `full_name`, `email`, `phone`, `role`) VALUES
(7, 'sohini', '$2y$10$jfozmWBP8maI9x2f22fm0.TG8lT4v7C7mxDglgAkRmTgYWfA6Bpxi', 'Sohini Jadhav', 'sohinijadhav3131@gmail.com', '9356957322', 'Admin'),
(8, 'swati', '$2y$10$U2.HAqnR1hbhvD/zZVdxX.rR6yRqpYJP5hV51hi2.cW/xJ0tuyfPe', 'Swati Shekhar Jadhav', 'swati@gmail.com', '7588301718', 'Admin'),
(9, 'shraddha', '$2y$10$IRbfgxfmOiVL9zKd7MwZM.anEAKqYZjT5um1/8mX9IqqbNCKVYh5i', 'Shraddha Kapoor', 'shraddha@gmail.com', '9876543213', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_code` varchar(10) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `manager_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_code`, `branch_name`, `branch_address`, `phone`, `ifsc_code`, `location`, `manager_name`) VALUES
('BR001', 'Mumbai Main Branch', 'Mumbai', '9876511111', 'MYBK0001001', 'Mumbai', 'Amit Sharma'),
('BR002', 'Delhi Branch', 'Delhi', '9876522222', 'MYBK0001002', 'Delhi', 'Raj Verma'),
('BR003', 'Pune Branch', 'Pune', '9876533333', 'MYBK0001003', 'Pune', 'Neha Patil'),
('BR004', 'Bangalore Branch', 'Bangalore', '9876544444', 'MYBK0001004', 'Bangalore', 'Arjun Rao'),
('BR005', 'Chennai Branch', 'Chennai', '9876555555', 'MYBK0001005', 'Chennai', 'Priya Singh');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `full_name`, `email`, `phone`, `created_at`, `address`, `dob`) VALUES
(1, 'Rahul Sharma', 'rahul@gmail.com', '9876500001', '2026-07-07 11:12:50', NULL, NULL),
(2, 'Priya Verma', 'priya@gmail.com', '9876500002', '2026-07-07 11:12:50', NULL, NULL),
(3, 'Amit Kumar', 'amit@gmail.com', '9876500003', '2026-07-07 11:12:50', NULL, NULL),
(4, 'Sneha Patel', 'sneha@gmail.com', '9876500004', '2026-07-07 11:12:50', NULL, NULL),
(5, 'Rohan Singh', 'rohan@gmail.com', '9876500005', '2026-07-07 11:12:50', NULL, NULL),
(6, 'Anjali Gupta', 'anjali@gmail.com', '9876500006', '2026-07-07 11:12:50', NULL, NULL),
(7, 'Karan Mehta', 'karan@gmail.com', '9876500007', '2026-07-07 11:12:50', NULL, NULL),
(8, 'Neha Joshi', 'neha@gmail.com', '9876500008', '2026-07-07 11:12:50', NULL, NULL),
(9, 'Vikram Rao', 'vikram@gmail.com', '9876500009', '2026-07-07 11:12:50', NULL, NULL),
(10, 'Pooja Nair', 'pooja@gmail.com', '9876500010', '2026-07-07 11:12:50', NULL, NULL),
(11, 'Sohini Jadhav', 'sohinijadhav3131@gmail.com', '9356957322', '2026-07-08 08:54:50', NULL, NULL),
(12, 'Tina Sonar', 'tina@gmail.com', '9890668609', '2026-07-11 16:35:17', 'cidco,nashik', '2010-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

CREATE TABLE `customer_login` (
  `login_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_login`
--

INSERT INTO `customer_login` (`login_id`, `customer_id`, `username`, `password_hash`, `created_at`) VALUES
(1, 1, 'rahul123', 'Rahul@123', '2026-07-07 11:12:50'),
(2, 2, 'priya123', 'Priya@123', '2026-07-07 11:12:50'),
(3, 3, 'amit123', 'Amit@123', '2026-07-07 11:12:50'),
(4, 4, 'sneha123', 'Sneha@123', '2026-07-07 11:12:50'),
(5, 5, 'rohan123', 'Rohan@123', '2026-07-07 11:12:50'),
(6, 6, 'anjali123', 'Anjali@123', '2026-07-07 11:12:50'),
(7, 7, 'karan123', 'Karan@123', '2026-07-07 11:12:50'),
(8, 8, 'neha123', 'Neha@123', '2026-07-07 11:12:50'),
(9, 9, 'vikram123', 'Vikram@123', '2026-07-07 11:12:50'),
(10, 10, 'pooja123', 'Pooja@123', '2026-07-07 11:12:50'),
(11, 11, 'sohini', '$2y$10$glhJQTRw0/.P6B/J0h7mh.GCQKuaCnIAIyjVUf1VKliIvaUsXX5LS', '2026-07-08 08:54:50'),
(12, 12, 'tina02', '$2y$10$Z/KiFK7lm3UwEs.lEW12fubaBAKGFuYYCxHMazvDs8omouQduZw9K', '2026-07-11 16:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `loan_type` enum('Home Loan','Car Loan','Education Loan','Personal Loan','Business Loan') NOT NULL,
  `principal_amount` decimal(12,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `tenure_months` int(11) NOT NULL,
  `status` enum('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `customer_id`, `account_id`, `loan_type`, `principal_amount`, `interest_rate`, `tenure_months`, `status`) VALUES
(1, 1, 1, 'Home Loan', 2500000.00, 7.20, 240, 'APPROVED'),
(2, 2, 2, 'Personal Loan', 300000.00, 8.50, 36, 'PENDING'),
(3, 3, 3, 'Education Loan', 600000.00, 6.50, 84, 'APPROVED'),
(4, 4, 4, 'Car Loan', 850000.00, 9.10, 60, 'REJECTED'),
(5, 5, 5, 'Business Loan', 1800000.00, 10.25, 180, 'APPROVED'),
(6, 6, 6, 'Home Loan', 3200000.00, 7.20, 300, 'PENDING'),
(7, 7, 7, 'Car Loan', 950000.00, 9.00, 72, 'APPROVED'),
(8, 8, 8, 'Education Loan', 450000.00, 6.50, 60, 'PENDING'),
(9, 9, 9, 'Personal Loan', 275000.00, 8.50, 24, 'REJECTED'),
(11, 1, 1, 'Home Loan', 1000000.00, 7.00, 48, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `transaction_ref` varchar(30) NOT NULL,
  `from_account` varchar(20) NOT NULL,
  `to_account` varchar(20) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `transaction_type` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `transaction_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `customer_id`, `transaction_ref`, `from_account`, `to_account`, `amount`, `transaction_type`, `status`, `narration`, `transaction_date`) VALUES
(1, 1, 'TXN100001', '1000000001', '1000000002', 5000.00, 'TRANSFER', 'SUCCESS', 'Rent', '2026-07-07 16:55:58'),
(2, 2, 'TXN100002', '1000000002', '1000000003', 2000.00, 'TRANSFER', 'SUCCESS', 'Bill Payment', '2026-07-07 16:55:58'),
(3, 3, 'TXN472927', '1000000003', '1000000004', 1000.00, 'TRANSFER', 'SUCCESS', 'Money Transfer', '2026-07-07 16:57:40'),
(4, 1, 'TXN561534', '1000000001', '1000000005', 1000.00, 'TRANSFER', 'SUCCESS', 'Money Transfer', '2026-07-07 17:08:06'),
(5, 12, 'TXN609124', '1000000010', '1000000008', 1000.00, 'TRANSFER', 'SUCCESS', 'Money Transfer', '2026-07-11 22:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `branch_code` (`branch_code`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `transaction_ref` (`transaction_ref`),
  ADD KEY `fk_transaction_customer` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_login`
--
ALTER TABLE `customer_login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`branch_code`) REFERENCES `branches` (`branch_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD CONSTRAINT `customer_login_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transaction_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
