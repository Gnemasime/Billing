-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 09:41 PM
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
-- Database: `municipal_billing`
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usage_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `resident_id`, `service_type`, `amount_due`, `due_date`, `status`, `created_at`, `usage_amount`) VALUES
(7, 5, 'electricity', 1200.00, '2024-09-07', 'unpaid', '2024-09-01 06:30:11', 0.00),
(8, 4, 'water', 55.25, '2024-09-10', 'unpaid', '2024-09-01 06:30:11', 0.00),
(9, 4, 'electricity', 75.00, '2024-09-12', 'unpaid', '2024-09-01 06:30:11', 0.00),
(10, 5, 'water', 42.50, '2024-09-15', 'unpaid', '2024-09-01 06:30:11', 0.00),
(11, 5, 'electricity', 85.00, '2024-09-18', 'paid', '2024-09-01 06:30:11', 0.00),
(12, 6, 'water', 65.00, '2024-09-20', 'overdue', '2024-09-01 06:30:11', 0.00),
(13, 6, 'electricity', 95.50, '2024-08-22', 'unpaid', '2024-09-01 06:30:11', 0.00),
(16, 4, 'water', 35.00, '2024-09-29', 'paid', '2024-09-01 06:30:11', 0.00),
(18, 4, 'water', 60.00, '2024-10-03', 'unpaid', '2024-09-01 06:30:11', 0.00),
(19, 4, 'electricity', 70.00, '2024-10-05', 'overdue', '2024-09-01 06:30:11', 0.00),
(20, 5, 'water', 48.50, '2024-10-07', 'unpaid', '2024-09-01 06:30:11', 0.00),
(21, 5, 'electricity', 90.00, '2024-10-09', 'paid', '2024-09-01 06:30:11', 0.00),
(22, 6, 'water', 75.00, '2024-10-11', 'paid', '2024-09-01 06:30:11', 0.00),
(23, 6, 'electricity', 450.50, '2024-10-13', 'unpaid', '2024-09-01 06:30:11', 0.00),
(24, 6, 'electricity', 1000.00, '2024-09-27', 'unpaid', '2024-09-02 15:06:19', 0.00),
(31, 5, 'electricity', 1200.00, '2024-09-07', 'unpaid', '2024-09-01 04:30:11', 0.00),
(32, 4, 'water', 55.25, '2024-09-10', 'unpaid', '2024-09-01 04:30:11', 0.00),
(33, 4, 'electricity', 75.00, '2024-09-12', 'unpaid', '2024-09-01 04:30:11', 0.00),
(34, 5, 'water', 42.50, '2024-09-15', 'unpaid', '2024-09-01 04:30:11', 0.00),
(35, 5, 'electricity', 85.00, '2024-09-18', 'paid', '2024-09-01 04:30:11', 0.00),
(36, 6, 'water', 65.00, '2024-09-20', 'overdue', '2024-09-01 04:30:11', 0.00),
(37, 6, 'electricity', 95.50, '2024-08-22', 'unpaid', '2024-09-01 04:30:11', 0.00),
(40, 4, 'water', 35.00, '2024-09-29', 'paid', '2024-09-01 04:30:11', 0.00),
(42, 4, 'water', 60.00, '2024-10-03', 'unpaid', '2024-09-01 04:30:11', 0.00),
(43, 4, 'electricity', 70.00, '2024-10-05', 'overdue', '2024-09-01 04:30:11', 0.00),
(44, 5, 'water', 48.50, '2024-10-07', 'unpaid', '2024-09-01 04:30:11', 0.00),
(45, 5, 'electricity', 90.00, '2024-10-09', 'paid', '2024-09-01 04:30:11', 0.00),
(46, 6, 'water', 75.00, '2024-10-11', 'paid', '2024-09-01 04:30:11', 0.00),
(47, 6, 'electricity', 450.50, '2024-10-13', 'unpaid', '2024-09-01 04:30:11', 0.00),
(48, 6, 'electricity', 1000.00, '2024-09-27', 'unpaid', '2024-09-02 13:06:19', 0.00);

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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `bill_id`, `payment_amount`, `payment_date`) VALUES
(3, 11, 85.00, '2024-09-18 07:15:00'),
(5, 21, 90.00, '2024-10-09 06:00:00'),
(6, 22, 75.00, '2024-10-11 14:45:00'),
(10, 7, 1200.00, '2024-09-08 12:00:00'),
(11, 8, 55.25, '2024-09-11 08:00:00'),
(12, 9, 75.00, '2024-09-13 07:30:00'),
(13, 10, 42.50, '2024-09-16 13:00:00'),
(14, 12, 65.00, '2024-09-21 09:00:00'),
(15, 13, 95.50, '2024-08-23 14:00:00'),
(16, 16, 35.00, '2024-09-30 07:45:00'),
(26, 31, 90.00, '2024-09-13 22:00:00'),
(27, 32, 65.00, '2024-09-14 22:00:00'),
(28, 33, 110.00, '2024-09-14 22:00:00'),
(29, 34, 50.00, '2024-09-14 22:00:00'),
(30, 35, 130.00, '2024-09-14 22:00:00'),
(31, 36, 70.00, '2024-09-15 22:00:00'),
(32, 37, 140.00, '2024-09-15 22:00:00'),
(35, 40, 60.00, '2024-09-16 22:00:00'),
(37, 42, 85.00, '2024-09-17 22:00:00'),
(38, 43, 95.00, '2024-09-17 22:00:00'),
(39, 44, 50.00, '2024-09-17 22:00:00'),
(40, 45, 130.00, '2024-09-17 22:00:00');

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

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'admin',
  `id_number` varchar(20) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `user_type` enum('residential','commercial','industrial') NOT NULL DEFAULT 'residential',
  `meter_number` varchar(255) NOT NULL,
  `usage_amount` decimal(10,2) DEFAULT 0.00,
  `date_of_birth` date DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `id_number`, `first_name`, `last_name`, `user_type`, `meter_number`, `usage_amount`, `date_of_birth`, `city`, `postcode`, `state`) VALUES
(3, 'codesteps.info24@yahoo.com', '$2y$10$f8LQa2fW6nHt1wMNd3qhv.A5WWzdQUg3rGwwGgE0ATfr9Z6O2RxMO', 'admin', NULL, NULL, NULL, 'residential', '', 0.00, NULL, NULL, NULL, NULL),
(4, 'edgytrends131@gmail.com', '$2y$10$JBwUWqx/bxEQtDtXR.ZDeesguaY58wtSogGcxQb7NM9oBzy3wh0O.', 'user', NULL, 'Samkelo', 'Sokhela', 'residential', '647972901900', 0.00, NULL, NULL, NULL, NULL),
(5, 'user2@test.com', '$2y$10$G3IhEamnJDyXsVysgKo1NuGhe5bb8hw/QdSvRIa9tg3YfYRYOX/rO', 'user', NULL, 'Yonela', 'Mdaka', 'residential', '74647929882992', 0.00, NULL, NULL, NULL, NULL),
(6, 'user1@test.com', '$2y$10$essRd3EhPzijN0qhdrrznu6SS9Lz6KvgWQ9UI3BLaazwPBLh6MwkO', 'user', NULL, 'Siphosethu', 'Nqweniso', 'residential', '', 0.00, '1992-02-29', 'Durban, South Africa', '4001', 'KwaZulu-Natal'),
(7, '22123521@dut4life.ac.za', '$2y$10$y.NAzPInzYxTF.QKeY6ac.XwJN6A6pQyEd5iUadhoUa2cfysCw10e', 'admin', '0310105705090', 'Simesihle', 'Ntshangase', 'residential', '74647929882891', 0.00, NULL, NULL, NULL, NULL),
(8, 'jane.doe@example.com', '$2y$10$Tl7Fgl66MkvXzAeJItH7sOK5a/WreLkiXTOUs2AqGZwwz5knM4h3O', 'user', '0723456789012', 'Jane', 'Doe', 'commercial', '9876543212345', 0.00, NULL, NULL, NULL, NULL),
(9, 'john.smith@example.com', '$2y$10$0EFvFjL1cXSOO5tZCdwfduh1X5BF0nN8Fh7rC.m9.Qv2pZlt55Fyi', 'user', '0823456789012', 'John', 'Smith', 'industrial', '8765432109876', 0.00, NULL, NULL, NULL, NULL),
(10, 'alice.jones@example.com', '$2y$10$g6Abd9Gz/zOGyOevD8tiueEG3oeDLJ/eD5aWZjslzOD5HRud1X22q', 'user', '0798765432109', 'Alice', 'Jones', 'residential', '6543210987654', 0.00, NULL, NULL, NULL, NULL),
(11, 'bob.brown@example.com', '$2y$10$YDzZ7x97S89C7O8FkE5xAOaTj7Jn6aA2FStBFW8iOLZ0SzvXUlI56', 'user', '0765432109876', 'Bob', 'Brown', 'commercial', '5432109876543', 0.00, NULL, NULL, NULL, NULL),
(12, 'carol.white@example.com', '$2y$10$Z6OkTcLQ4BzMVo2KN6vGuGyV.aYXhA5z.A3v8jqivYsJ9jFz5LCOS', 'user', '0834567890123', 'Carol', 'White', 'industrial', '4321098765432', 0.00, NULL, NULL, NULL, NULL),
(13, 'dave.green@example.com', '$2y$10$TrLmk2NTwofIE6o6x0nPRe8X0lBeKx3IQQs5CE8ml1L5v6Ym66xOG', 'user', '0723456789012', 'Dave', 'Green', 'residential', '3210987654321', 0.00, NULL, NULL, NULL, NULL),
(14, 'eve.adams@example.com', '$2y$10$zJ9Y5pX2zkJQotDSgVi5e.J3DGBFrHB7byNqW38R6Wkt9ZQoShwYS', 'user', '0856789012345', 'Eve', 'Adams', 'commercial', '2109876543210', 0.00, NULL, NULL, NULL, NULL),
(15, 'frank.harris@example.com', '$2y$10$PvUeek5DO4fqfQ92B8u8tO.D2fddTjY2vR4ntQzLRaPTFEXuCXgyG', 'user', '0723456789123', 'Frank', 'Harris', 'industrial', '1098765432109', 0.00, NULL, NULL, NULL, NULL),
(16, 'grace.martin@example.com', '$2y$10$2gldcO1B/Tg6XFAO9NPM7Oxl.BCqswTZTxETtP.qg5ZQwGpGBhO2C', 'user', '0798765432108', 'Grace', 'Martin', 'residential', '0987654321098', 0.00, NULL, NULL, NULL, NULL),
(17, 'henry.clark@example.com', '$2y$10$zG7HWLz5eqL8X9EUMPU4gOEPA5Odo/IzGvOkOa/HanGZ0O9fK64cy', 'user', '0823456789123', 'Henry', 'Clark', 'commercial', '9876543210123', 0.00, NULL, NULL, NULL, NULL),
(18, 'isaac.davis@example.com', '$2y$10$6M7B2nhL4Sqa7sT3pMRRbuE8OmyHvFvOq9ZYc4U1iX0ANj3UM6s2O', 'user', '0745678901234', 'Isaac', 'Davis', 'residential', '8765432101234', 0.00, NULL, NULL, NULL, NULL),
(19, 'julia.morris@example.com', '$2y$10$kg7CneBB.PdrMxRT25WZ0u2kVdfZZ1rVfMdr8n1xuAka7QGdfvUeG', 'user', '0756789012345', 'Julia', 'Morris', 'commercial', '7654321098765', 0.00, NULL, NULL, NULL, NULL),
(20, 'kelly.rogers@example.com', '$2y$10$hC/zxNcYBd1A0FB5Q8LRnORik3AkYfD0.g8zZC9OGp88W/e2Pi9sS', 'user', '0734567890123', 'Kelly', 'Rogers', 'industrial', '6543210987654', 0.00, NULL, NULL, NULL, NULL),
(21, 'luke.walker@example.com', '$2y$10$F5CmgFW/LZndLkJ3N4DAuS2Hj5UzrESM6otExCxZWkjLV7aJr/cR.', 'user', '0723456789234', 'Luke', 'Walker', 'residential', '5432109876543', 0.00, NULL, NULL, NULL, NULL),
(22, 'mia.lee@example.com', '$2y$10$zwV2by2ArjF6vc3KzOErTiw2.PyCxKi06OpryB6tfMQQJrFZjC/FO', 'user', '0845678901234', 'Mia', 'Lee', 'commercial', '4321098765432', 0.00, NULL, NULL, NULL, NULL),
(23, 'nathan.kim@example.com', '$2y$10$RfJbPLSuK5AyITk3CnJ..D03yU/7gfF8O/06MwqQhKoJ3TxqWqghO', 'user', '0856789013456', 'Nathan', 'Kim', 'industrial', '3210987654321', 0.00, NULL, NULL, NULL, NULL),
(24, 'olivia.james@example.com', '$2y$10$5B/SM/Q.MrgC7.PpI1FsCOTegbZgM8PjAuZzLJjFAjX4D5wdI.9ty', 'user', '0723456789345', 'Olivia', 'James', 'residential', '2109876543210', 0.00, NULL, NULL, NULL, NULL),
(25, 'peter.carter@example.com', '$2y$10$TtA0pW.bR30TuGXYV9bhOaAk/rJ9OgNT8HtGz8C4NBP2D0wPHDfwu', 'user', '0756789014567', 'Peter', 'Carter', 'commercial', '1098765432109', 0.00, NULL, NULL, NULL, NULL),
(26, 'quinn.evans@example.com', '$2y$10$7lE2G1RY0W6CEhhxFAl3Wu8J3P61f9jvKmz8aMlPVsCmtz.Dz32uq', 'user', '0789012345678', 'Quinn', 'Evans', 'industrial', '0987654321098', 0.00, NULL, NULL, NULL, NULL),
(27, 'rachel.miller@example.com', '$2y$10$KxIPhZP02E5nqI/UkBW04.fVev6InVY0LPSMDjKKfZ.L3FZ7Mx1Uu', 'user', '0734567890456', 'Rachel', 'Miller', 'residential', '9876543210987', 0.00, NULL, NULL, NULL, NULL),
(28, 'steve.taylor@example.com', '$2y$10$e68NiVWm5J11dWTeOgjmPeMG.N4y4OXKxn2a9RQK/UMXKVRm.eApS', 'user', '0756789015678', 'Steve', 'Taylor', 'commercial', '8765432109876', 0.00, NULL, NULL, NULL, NULL),
(29, 'tina.anderson@example.com', '$2y$10$8/eQ6dmy5GcK0ovwvJuZlO/2owI0xn.kRM2LUM1P6I5/E.MRNSOZm', 'user', '0823456789234', 'Tina', 'Anderson', 'industrial', '7654321098765', 0.00, NULL, NULL, NULL, NULL),
(30, 'victor.wilson@example.com', '$2y$10$8TnaFPGdtXSBw5ejT8qWiuZRczQfdGCfz9kRATMEcx0m/6UkAqRaS', 'user', '0834567890345', 'Victor', 'Wilson', 'residential', '6543210987654', 0.00, NULL, NULL, NULL, NULL),
(31, 'wendy.scott@example.com', '$2y$10$knGdJ7Tj.ZgMKsR8z6K5aOvRdvYlzHniABlnhKg8yphmGQ7tZK0lG', 'user', '0745678902345', 'Wendy', 'Scott', 'commercial', '5432109876543', 0.00, NULL, NULL, NULL, NULL),
(32, 'xander.morris@example.com', '$2y$10$ToWJXGmhk57WwG8WES1uqNLO7NV/X.q2I2R0AWKtnQFB4mOqRJkru', 'user', '0798765432109', 'Xander', 'Morris', 'industrial', '4321098765432', 0.00, NULL, NULL, NULL, NULL),
(33, 'yara.harris@example.com', '$2y$10$M9Dr1pAnbAK8vWd.B3vleOAa3bPO1Y7J1sHh4xU7Zc9upwbP7NxaS', 'user', '0856789012345', 'Yara', 'Harris', 'residential', '3210987654321', 0.00, NULL, NULL, NULL, NULL),
(34, 'zachary.lee@example.com', '$2y$10$X9tHAvDjjYX3ef/xHaqA/O4XT8X/nYfJ6zH9FzJeUt9hCF1iB4Ch.', 'user', '0723456789456', 'Zachary', 'Lee', 'commercial', '2109876543210', 0.00, NULL, NULL, NULL, NULL),
(35, 'anna.martin@example.com', '$2y$10$Wy6IrjK0Zdz1y3Wx0b.EEujFOgXy7H52RyKLZeQGyTiHo/H6Q2HYi', 'user', '0734567890567', 'Anna', 'Martin', 'industrial', '1098765432109', 0.00, NULL, NULL, NULL, NULL),
(36, 'brian.garcia@example.com', '$2y$10$VD3Sz.G9mt7N3qlo2XmnC/tIMD/QgBUEOfJg6qlA0emvUB3Uk/iZ2', 'user', '0745678903456', 'Brian', 'Garcia', 'residential', '0987654321098', 0.00, NULL, NULL, NULL, NULL),
(37, 'catherine.smith@example.com', '$2y$10$J4DlvQ0DFKrJKZlFhU6B9u8A1yDLjSlxeBo0a2Fz7Pa7R5p6pJZi.', 'user', '0756789013456', 'Catherine', 'Smith', 'commercial', '9876543210123', 0.00, NULL, NULL, NULL, NULL),
(38, 'daniel.martin@example.com', '$2y$10$Fi6bDk6RVF1LrmRMYzQUweK8HErjzn/ikgWgH9Jz1.eP4u1NzJ.i', 'user', '0789012345678', 'Daniel', 'Martin', 'industrial', '8765432109876', 0.00, NULL, NULL, NULL, NULL),
(39, 'ella.johnson@example.com', '$2y$10$PAGoyUMU8BNzFFY6pE73IebqMcMtJ/KLlhLfAdwL6Dfx7DzzW1rT.', 'user', '0823456789345', 'Ella', 'Johnson', 'residential', '7654321098765', 0.00, NULL, NULL, NULL, NULL),
(40, 'finn.davis@example.com', '$2y$10$ltFfRDgPrY9sWn6pWe4YfEx4zybRAymHtJS8Gg2LjOCzDAuM0V8y6', 'user', '0834567890456', 'Finn', 'Davis', 'commercial', '6543210987654', 0.00, NULL, NULL, NULL, NULL),
(74, 'user@example.com', '$2y$10$e0NRLwrjzI9wrM2LOtRCle7OZ.KxKrKypuTuh0nFME8y8MpoT6Fom', 'user', NULL, NULL, NULL, 'residential', '5432', 0.00, NULL, NULL, NULL, NULL),
(75, 'user@test.com', '$2y$10$svv.5D9JXQyn94yT8ChA5O.2x4sSCSur.r852e6ddYb7RRwOmgmDC', 'user', '0839966775890', 'Simesihle', '0', 'residential', '4892782892992', 0.00, NULL, NULL, NULL, NULL),
(76, 'xulu101@gmail.com', '$2y$10$Vf7KSe9XYjJubsy3Y9oqsOrQ5l12W8sHMS1.lfeNzZdXIaTdNiJ6m', 'user', NULL, 'setha', 'xulu', 'residential', '12345678910', 0.00, NULL, NULL, NULL, NULL),
(77, 'junior@admin.com', '$2y$10$UR9auuz9H5av5COSPJmWuOw.rwAOvNQk2OsnJ8M4vnGf6F60UBYqK', 'junioradmi', NULL, 'Blake', 'Havens', 'residential', '', 0.00, NULL, NULL, NULL, NULL),
(78, 'admin@admin.com', '$2y$10$yyNJRctsZeetOqpGgKeysOlKp6K8JkmZpPGsdWPredRBBFmBkjaRa', 'junioradmi', '0310105895098', 'Enno', 'Kunene', 'residential', '', 0.00, NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `usage_amount`
--
ALTER TABLE `usage_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
