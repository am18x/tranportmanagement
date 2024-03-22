-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2024 at 03:54 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transport_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `num_of_items` int(10) NOT NULL,
  `vehical_number` varchar(30) NOT NULL,
  `source` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `driver_id`, `num_of_items`, `vehical_number`, `source`, `destination`) VALUES
(1, 2, 200, 'MH 09 S 4455', 'Bidri', 'Kolhapur');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `salary` varchar(10) NOT NULL,
  `license` varchar(50) NOT NULL,
  `vehical_id` int(11) DEFAULT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `username`, `fullname`, `email`, `address`, `phone_no`, `salary`, `license`, `vehical_id`, `password`) VALUES
(2, 'Rohan@123', 'Rohan Dhere', 'sp1788771@gmail.com', 'Sonali Road, Bidri, Tal-Kagal, Dist-Kolhapur.\r\nShivshakti Nivas', '9403365600', '34000', 'Rohan@123.pdf', NULL, 'Rohan@1234'),
(3, 'Pranav@1234', 'Pranav', 'pranav1234@gmail.com', 'Sonali Road', '9403365600', '20444', 'Pranav@1234.pdf', 2, 'Pranav@1234');

-- --------------------------------------------------------

--
-- Table structure for table `driver_payment`
--

CREATE TABLE `driver_payment` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `amount_payed` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `payer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver_payment`
--

INSERT INTO `driver_payment` (`id`, `driver_id`, `salary`, `amount_payed`, `remaining`, `payer_id`, `date`) VALUES
(1, 2, '20000.00', '2000.00', '18000.00', 2, '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `product_name`, `price`, `quantity`, `total_value`) VALUES
(1, 'Widget', '200.00', 6, '1200.00'),
(2, 'Tire', '200.00', 300, '60000.00');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `username`, `fullname`, `email`, `phone_no`, `password`) VALUES
(1, 'Shiv@1234', 'Shivprasad Patil', 'sp1788771@gmail.com', '9403365600', '$2y$10$X/CGEcdFPeO7l3GN5A'),
(2, 'Shiv@1234', 'Shivprasad Patil', 'sp1788771@gmail.com', '9403365600', 'Shiv@1234'),
(3, 'Aftab@1234', 'Shivprasad Patil', 'sp1788771@gmail.com', '9403365600', '$2y$10$4WwJH2EF1HLN.YTMw9'),
(4, 'Aftab@1234', 'Aftab Mulla', 'aftab@gmail.com', '8275674950', 'Aftab@1234');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('UPI','Cash','Cheque') DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `bill_id`, `amount`, `payment_method`, `receiver`, `date`) VALUES
(1, 1, '43040.00', 'Cash', 1, '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehical_number` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `driver_id`, `vehical_number`, `source`, `destination`, `date`) VALUES
(1, 2, 'MH 09 S 4455', 'Bidri', 'Kolhapur', '2024-03-06'),
(2, 2, 'MH 09 S 4456', 'Bidri', 'Kolhapur', '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `vehical`
--

CREATE TABLE `vehical` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `vehical_number` varchar(20) NOT NULL,
  `vehical_name` varchar(30) NOT NULL,
  `registration` varchar(30) NOT NULL,
  `insurance` varchar(30) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehical`
--

INSERT INTO `vehical` (`id`, `owner_id`, `vehical_number`, `vehical_name`, `registration`, `insurance`, `date`) VALUES
(2, 1, 'MH 09 S 4455', 'Bolero', 'reg.pdf', 'insu.pdf', '2024-02-20 13:37:33'),
(3, 1, 'MH 09 S 4456', 'Bolero', '3_registration.pdf', '3_insurance.pdf', '0000-00-00 00:00:00'),
(4, 1, 'MH 09 S 4459', 'Bolero', 'MH 09 S 4459_registration.pdf', 'MH 09 S 4459_insurance.pdf', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehical_id` (`vehical_id`);

--
-- Indexes for table `driver_payment`
--
ALTER TABLE `driver_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `payer_id` (`payer_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehical`
--
ALTER TABLE `vehical`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_owner` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_payment`
--
ALTER TABLE `driver_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehical`
--
ALTER TABLE `vehical`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driver_payment`
--
ALTER TABLE `driver_payment`
  ADD CONSTRAINT `driver_payment_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `driver_payment_ibfk_2` FOREIGN KEY (`payer_id`) REFERENCES `owner` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `owner` (`id`);

--
-- Constraints for table `vehical`
--
ALTER TABLE `vehical`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
