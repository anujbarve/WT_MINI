-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 07, 2024 at 08:53 AM
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
-- Table structure for table `ListMembers`
--

CREATE TABLE `ListMembers` (
  `MemberID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `ListID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ListTodos`
--

CREATE TABLE `ListTodos` (
  `ListTodoID` int NOT NULL,
  `ListID` int DEFAULT NULL,
  `TodoID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SharedLists`
--

CREATE TABLE `SharedLists` (
  `ListID` int NOT NULL,
  `RoomID` varchar(50) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text,
  `CreatorID` int DEFAULT NULL,
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 'New Todo', 'New NOW', 'completed', 3, '2024-04-07 08:06:31', '2024-04-07 08:06:36', 0),
(2, 'Nova Todo', 'Nova Descriptino\r\n', 'completed', 5, '2024-04-07 08:17:11', '2024-04-07 08:17:17', 517640),
(3, 'Anno Todo', 'Anno Todo', 'pending', 4, '2024-04-07 08:17:39', '2024-04-07 08:17:39', 517640);

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
(4, 'anno', '$2y$10$sAvdF7jOmhqTbaL0rRRdjuqCSBNYcbJkyPJ6toE3f5qmBrOfG/DzK', 622176),
(5, 'nova', '$2y$10$KcoVsFHvafKHX8E9IP.4H.wByzJh9jBhMaw5bAD4g4meMP5scclQy', 517640);

-- --------------------------------------------------------

--
-- Table structure for table `UserTodos`
--

CREATE TABLE `UserTodos` (
  `UserTodoID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `TodoID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ListMembers`
--
ALTER TABLE `ListMembers`
  ADD PRIMARY KEY (`MemberID`),
  ADD UNIQUE KEY `UserID` (`UserID`,`ListID`),
  ADD KEY `ListID` (`ListID`);

--
-- Indexes for table `ListTodos`
--
ALTER TABLE `ListTodos`
  ADD PRIMARY KEY (`ListTodoID`),
  ADD UNIQUE KEY `ListID` (`ListID`,`TodoID`),
  ADD KEY `TodoID` (`TodoID`);

--
-- Indexes for table `SharedLists`
--
ALTER TABLE `SharedLists`
  ADD PRIMARY KEY (`ListID`),
  ADD UNIQUE KEY `RoomID` (`RoomID`);

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
-- Indexes for table `UserTodos`
--
ALTER TABLE `UserTodos`
  ADD PRIMARY KEY (`UserTodoID`),
  ADD UNIQUE KEY `UserID` (`UserID`,`TodoID`),
  ADD KEY `TodoID` (`TodoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ListMembers`
--
ALTER TABLE `ListMembers`
  MODIFY `MemberID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ListTodos`
--
ALTER TABLE `ListTodos`
  MODIFY `ListTodoID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SharedLists`
--
ALTER TABLE `SharedLists`
  MODIFY `ListID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Todos`
--
ALTER TABLE `Todos`
  MODIFY `TodoID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `UserTodos`
--
ALTER TABLE `UserTodos`
  MODIFY `UserTodoID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ListMembers`
--
ALTER TABLE `ListMembers`
  ADD CONSTRAINT `ListMembers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `ListMembers_ibfk_2` FOREIGN KEY (`ListID`) REFERENCES `SharedLists` (`ListID`);

--
-- Constraints for table `ListTodos`
--
ALTER TABLE `ListTodos`
  ADD CONSTRAINT `ListTodos_ibfk_1` FOREIGN KEY (`ListID`) REFERENCES `SharedLists` (`ListID`),
  ADD CONSTRAINT `ListTodos_ibfk_2` FOREIGN KEY (`TodoID`) REFERENCES `Todos` (`TodoID`);

--
-- Constraints for table `UserTodos`
--
ALTER TABLE `UserTodos`
  ADD CONSTRAINT `UserTodos_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `UserTodos_ibfk_2` FOREIGN KEY (`TodoID`) REFERENCES `Todos` (`TodoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
