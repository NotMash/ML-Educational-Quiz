-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2021 at 08:13 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `HistoryID` int(11) NOT NULL,
  `TestID` int(11) DEFAULT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `Mark` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionID` int(11) NOT NULL,
  `Question` longtext NOT NULL,
  `WrongAnswerA` longtext NOT NULL,
  `WrongAnswerB` longtext NOT NULL,
  `WrongAnswerC` longtext NOT NULL,
  `Answer` longtext NOT NULL,
  `Difficulty` int(11) NOT NULL,
  `TopicID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionID`, `Question`, `WrongAnswerA`, `WrongAnswerB`, `WrongAnswerC`, `Answer`, `Difficulty`, `TopicID`) VALUES
(29, 'Easy Question 1', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 1, 1),
(30, 'Easy Question 2', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 2, 2),
(31, 'Easy Question 3', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 3, 3),
(32, 'Easy Question 4', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 4, 1),
(33, 'Medium Question 1', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 5, 2),
(34, 'Medium Question 2', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 6, 3),
(35, 'Medium Question 3', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 7, 1),
(36, 'Medium Question 4', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 8, 2),
(37, 'Medium Question 5', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 9, 3),
(38, 'Hard Question 1', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 10, 1),
(39, 'Hard Question 2', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 11, 2),
(40, 'Hard Question 3', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 12, 3),
(41, 'Hard Question 4', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 13, 1),
(42, 'Hard Question 5', 'Wrong Answer A', 'Wrong Answer B', 'Wrong Answer C', 'Correct Answer', 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `FirstName`, `LastName`, `Username`, `Password`) VALUES
(1, 'Bob', 'The Builder', 'bob', 'bob'),
(2, 'Robbie', 'Mendoza', 'rob', 'rob'),
(3, 'Berat', 'Oneil', 'berat', 'berat');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `TestID` int(11) NOT NULL,
  `TestDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `TotalMarks` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `testtopic`
--

CREATE TABLE `testtopic` (
  `TestTopicID` int(11) NOT NULL,
  `TestID` int(11) DEFAULT NULL,
  `TopicID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `TopicID` int(11) NOT NULL,
  `TopicName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`TopicID`, `TopicName`) VALUES
(1, 'Algebra'),
(2, 'Calculus'),
(3, 'Trigonometry');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `TestID` (`TestID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `TopicID` (`TopicID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`TestID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `testtopic`
--
ALTER TABLE `testtopic`
  ADD PRIMARY KEY (`TestTopicID`),
  ADD KEY `TestID` (`TestID`),
  ADD KEY `TopicID` (`TopicID`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`TopicID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `HistoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `TestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testtopic`
--
ALTER TABLE `testtopic`
  MODIFY `TestTopicID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `TopicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`TestID`) REFERENCES `test` (`TestID`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `question` (`QuestionID`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`);

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`);

--
-- Constraints for table `testtopic`
--
ALTER TABLE `testtopic`
  ADD CONSTRAINT `testtopic_ibfk_1` FOREIGN KEY (`TestID`) REFERENCES `test` (`TestID`),
  ADD CONSTRAINT `testtopic_ibfk_2` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
