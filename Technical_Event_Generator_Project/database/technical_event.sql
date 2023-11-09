-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 03:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technical_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE `candidate_details` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `candidate_name` varchar(255) DEFAULT NULL,
  `candidate_details` text DEFAULT NULL,
  `candidate_photo` text DEFAULT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`id`, `event_id`, `candidate_name`, `candidate_details`, `candidate_photo`, `inserted_by`, `inserted_on`) VALUES
(7, 8, 'Pratyush Bhushan', 'MCA Student', '../assets/images/candidate_photos/5552_8958WIN_20230302_08_17_47_Pro.jpg', 'Admin', '2023-10-15'),
(8, 10, 'Mannu Pratyush', 'MCA Student', '../assets/images/candidate_photos/9964_4343Mannu pic.jpeg', 'Admin', '2023-10-15'),
(9, 9, 'Mannu Pratyush', 'MCA Student', '../assets/images/candidate_photos/2225_3407Mannu pic.jpeg', 'Admin', '2023-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `registered_candidate`
--

CREATE TABLE `registered_candidate` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `even_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_candidate`
--

INSERT INTO `registered_candidate` (`id`, `event_id`, `even_id`, `candidate_id`, `event_date`, `event_time`) VALUES
(2, 2, 3, 2, '2022-11-01', '09:47:46'),
(3, 2, 4, 2, '2022-11-01', '09:53:38'),
(4, 2, 5, 3, '2022-11-01', '09:54:05'),
(5, 6, 9, 4, '2023-10-12', '03:34:28'),
(6, 8, 9, 7, '2023-10-15', '10:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `tech_event`
--

CREATE TABLE `tech_event` (
  `id` int(11) NOT NULL,
  `event_topic` varchar(255) DEFAULT NULL,
  `no_of_candidates` int(11) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `inserted_by` varchar(255) DEFAULT NULL,
  `inserted_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tech_event`
--

INSERT INTO `tech_event` (`id`, `event_topic`, `no_of_candidates`, `starting_date`, `ending_date`, `status`, `inserted_by`, `inserted_on`) VALUES
(8, 'Java Quiz', 3, '2023-10-15', '2023-10-17', 'Active', 'Admin', '2023-10-15'),
(9, 'Python Quiz', 3, '2023-10-15', '2023-10-20', 'Active', 'Admin', '2023-10-15'),
(10, 'C++ Quiz', 10, '2023-10-18', '2023-10-23', 'InActive', 'Admin', '2023-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `user_role` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `contact_no`, `password`, `user_role`) VALUES
(2, 'Admin', '7654566973', 'a9993e364706816aba3e25717850c26c9cd0d89d', 'Admin'),
(9, 'abc', '1234', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Voter'),
(11, 'Mannu Kumar', '12204749', '70c723401e6f7fcd1ec5294850d48b364acc2add', 'Voter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_candidate`
--
ALTER TABLE `registered_candidate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tech_event`
--
ALTER TABLE `tech_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registered_candidate`
--
ALTER TABLE `registered_candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tech_event`
--
ALTER TABLE `tech_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
