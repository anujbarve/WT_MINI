-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 07, 2024 at 01:57 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini`
--

-- --------------------------------------------------------

--
-- Table structure for table `RoomUsers`
--

CREATE TABLE `RoomUsers` (
  `UserID` int NOT NULL,
  `RoomID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `RoomUsers`
--

INSERT INTO `RoomUsers` (`UserID`, `RoomID`) VALUES
(1, 396617),
(2, 396617),
(3, 396617);

-- --------------------------------------------------------

--
-- Table structure for table `Todos`
--

CREATE TABLE `Todos` (
  `TodoID` int NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text,
  `Status` enum('pending','doing','completed') DEFAULT 'pending',
  `CreatorID` int DEFAULT NULL,
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RoomID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Todos`
--

INSERT INTO `Todos` (`TodoID`, `Title`, `Description`, `Status`, `CreatorID`, `CreatedAt`, `UpdatedAt`, `RoomID`) VALUES
(5, 'Complete WT Practicals', 'Complete WT Practicals', 'completed', 2, '2024-04-07 12:48:54', '2024-04-07 13:28:11', 506082),
(6, 'Complete Mini Project', 'Complete it asap', 'completed', 1, '2024-04-07 12:49:31', '2024-04-07 13:28:13', 506082),
(10, 'Study this by vishal', 'Study this by vishal', 'pending', 3, '2024-04-07 13:53:46', '2024-04-07 13:53:46', 396617);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `RoomID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `RoomID`) VALUES
(1, 'anuj', '$2y$10$6vDmu6phq3uBZrZ09IDZ/eXLATYEe.RzAwDAamTMET/OTWuoSUxWa', 396617),
(2, 'pratik', '$2y$10$LWnoYA/6wcKhsG0ExY8mQuINii2E4EwCwU20K8XkzGThhwW6k37l6', 506082),
(3, 'vishal', '$2y$10$9ZKQeXVmITLMhW5VfL7COu5TiRI9SCTtWWq4Tgf8M/PWoQ6p5NPOu', 112693);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `RoomUsers`
--
ALTER TABLE `RoomUsers`
  ADD PRIMARY KEY (`UserID`,`RoomID`);

--
-- Indexes for table `Todos`
--
ALTER TABLE `Todos`
  ADD PRIMARY KEY (`TodoID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Todos`
--
ALTER TABLE `Todos`
  MODIFY `TodoID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
