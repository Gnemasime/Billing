-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 04:20 PM
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
-- 
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('paid','unpaid','overdue') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `resident_id`, `service_type`, `amount_due`, `due_date`, `status`, `created_at`) VALUES
(1, 2, 'Water', 50.00, '2024-09-01', 'unpaid', '2024-08-16 18:17:50'),
(2, 1, 'Electricity', 75.50, '2024-09-05', 'paid', '2024-08-16 18:17:50'),
(3, 1, 'Sewage', 30.00, '2024-09-10', 'overdue', '2024-08-16 18:17:50'),
(4, 2, 'water', 45.00, '2024-09-01', 'unpaid', '2024-09-01 06:30:11'),
(5, 2, 'electricity', 60.50, '2024-09-03', 'paid', '2024-09-01 06:30:11'),
(6, 2, 'water', 35.75, '2024-07-05', 'overdue', '2024-09-01 06:30:11'),
(7, 5, 'electricity', 1200.00, '2024-09-07', 'unpaid', '2024-09-01 06:30:11'),
(8, 4, 'water', 55.25, '2024-09-10', 'unpaid', '2024-09-01 06:30:11'),
(9, 4, 'electricity', 75.00, '2024-09-12', 'unpaid', '2024-09-01 06:30:11'),
(10, 5, 'water', 42.50, '2024-09-15', 'unpaid', '2024-09-01 06:30:11'),
(11, 5, 'electricity', 85.00, '2024-09-18', 'paid', '2024-09-01 06:30:11'),
(12, 6, 'water', 65.00, '2024-09-20', 'overdue', '2024-09-01 06:30:11'),
(13, 6, 'electricity', 95.50, '2024-08-22', 'unpaid', '2024-09-01 06:30:11'),
(14, 2, 'water', 55.25, '2024-09-25', 'paid', '2024-09-01 06:30:11'),
(15, 2, 'electricity', 45.00, '2024-09-27', 'unpaid', '2024-09-01 06:30:11'),
(16, 4, 'water', 35.00, '2024-09-29', 'paid', '2024-09-01 06:30:11'),
(17, 2, 'electricity', 115.75, '2024-09-01', 'unpaid', '2024-09-01 06:30:11'),
(18, 4, 'water', 60.00, '2024-10-03', 'unpaid', '2024-09-01 06:30:11'),
(19, 4, 'electricity', 70.00, '2024-10-05', 'overdue', '2024-09-01 06:30:11'),
(20, 5, 'water', 48.50, '2024-10-07', 'unpaid', '2024-09-01 06:30:11'),
(21, 5, 'electricity', 90.00, '2024-10-09', 'paid', '2024-09-01 06:30:11'),
(22, 6, 'water', 75.00, '2024-10-11', 'paid', '2024-09-01 06:30:11'),
(23, 6, 'electricity', 450.50, '2024-10-13', 'unpaid', '2024-09-01 06:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`) VALUES
(1, 'water'),
(2, 'electricity');

-- --------------------------------------------------------

--
-- Table structure for table `tariffs`
--

CREATE TABLE `tariffs` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tariffs`
--

INSERT INTO `tariffs` (`id`, `service_id`, `rate`, `unit`) VALUES
(1, 1, 50.00, '100'),
(2, 2, 15.00, '10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usage_amount`
--

CREATE TABLE `usage_amount` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `amount_used` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `id_number`, `first_name`, `last_name`, `user_type`, `meter_number`, `usage_amount`) VALUES
(1, 'user@example.com', '$2y$10$e0NRLwrjzI9wrM2LOtRCle7OZ.KxKrKypuTuh0nFME8y8MpoT6Fom', 'user', NULL, NULL, NULL, 'residential', '5432', 0.00),
(2, 'user@test.com', '$2y$10$svv.5D9JXQyn94yT8ChA5O.2x4sSCSur.r852e6ddYb7RRwOmgmDC', 'user', '0839966775890', 'Simesihle', '0', 'residential', '4892782892992', 0.00),
(3, 'codesteps.info24@yahoo.com', '$2y$10$f8LQa2fW6nHt1wMNd3qhv.A5WWzdQUg3rGwwGgE0ATfr9Z6O2RxMO', 'admin', NULL, NULL, NULL, 'residential', '', 0.00),
(4, 'edgytrends131@gmail.com', '$2y$10$JBwUWqx/bxEQtDtXR.ZDeesguaY58wtSogGcxQb7NM9oBzy3wh0O.', 'user', NULL, 'Samkelo', 'Sokhela', 'residential', '647972901900', 0.00),
(5, 'user2@test.com', '$2y$10$G3IhEamnJDyXsVysgKo1NuGhe5bb8hw/QdSvRIa9tg3YfYRYOX/rO', 'user', NULL, 'Yonela', 'Mdaka', 'residential', '74647929882992', 0.00),
(6, 'user1@test.com', '$2y$10$essRd3EhPzijN0qhdrrznu6SS9Lz6KvgWQ9UI3BLaazwPBLh6MwkO', 'user', NULL, 'Siphosethu', 'Nqweniso', 'residential', '74647929882647', 0.00),
(7, '22123521@dut4life.ac.za', '$2y$10$y.NAzPInzYxTF.QKeY6ac.XwJN6A6pQyEd5iUadhoUa2cfysCw10e', 'admin', '0310105705090', 'Simesihle', 'Ntshangase', 'residential', '74647929882891', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `usage_amount`
--
ALTER TABLE `usage_amount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usage_amount`
--
ALTER TABLE `usage_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD CONSTRAINT `tariffs_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usage_amount`
--
ALTER TABLE `usage_amount`
  ADD CONSTRAINT `usage_amount_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usage_amount_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
