-- phpMyAdmin SQL Dump
-- version 4.5.0-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2016 at 06:54 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `projecteval`;

USE `projecteval`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projecteval`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignmentID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_class`
--

CREATE TABLE `assignment_class` (
  `classID` int(10) NOT NULL,
  `assignmentID` int(10) NOT NULL,
  `dueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_criteria`
--

CREATE TABLE `assignment_criteria` (
  `assignmentID` int(10) NOT NULL,
  `criteriaID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_parts`
--

CREATE TABLE `assignment_parts` (
  `assignmentID` int(60) NOT NULL,
  `PartID` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_project`
--

CREATE TABLE `assignment_project` (
  `assignmentID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseID` int(10) NOT NULL,
  `time` time NOT NULL,
  `description` text NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_user`
--

CREATE TABLE `class_user` (
  `classID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `userType` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `contentID` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `format` varchar(30) NOT NULL,
  `size` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseCode` varchar(6) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteriaID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `ratingRange` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluationID` int(11) NOT NULL,
  `criteriaID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(120) NOT NULL,
  `evaluatorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `part`
--

CREATE TABLE `part` (
  `partID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `part_content`
--

CREATE TABLE `part_content` (
  `partID` int(11) NOT NULL,
  `contentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `part_criteria`
--

CREATE TABLE `part_criteria` (
  `partID` int(11) NOT NULL,
  `criteriaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `part_evaluation`
--

CREATE TABLE `part_evaluation` (
  `partID` int(11) NOT NULL,
  `evaluationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projectID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `assignmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_assignment`
--

CREATE TABLE `project_assignment` (
  `projectID` int(11) NOT NULL,
  `assignmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_evaluation`
--

CREATE TABLE `project_evaluation` (
  `projectID` int(11) NOT NULL,
  `evaluationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_part`
--

CREATE TABLE `project_part` (
  `projectPartID` int(11) NOT NULL,
  `projectID` int(10) NOT NULL,
  `partID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

CREATE TABLE `project_user` (
  `projectID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `role` varchar(60) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `middleInitial` char(1) NOT NULL,
  `userType` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_evaluation`
--

CREATE TABLE `user_evaluation` (
  `userID` int(11) NOT NULL,
  `evaluationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignmentID`);

--
-- Indexes for table `assignment_class`
--
ALTER TABLE `assignment_class`
  ADD KEY `classID` (`classID`),
  ADD KEY `assignmentID` (`assignmentID`);

--
-- Indexes for table `assignment_criteria`
--
ALTER TABLE `assignment_criteria`
  ADD KEY `assignmentID` (`assignmentID`),
  ADD KEY `criteriaID` (`criteriaID`);

--
-- Indexes for table `assignment_parts`
--
ALTER TABLE `assignment_parts`
  ADD KEY `assignmentID` (`assignmentID`),
  ADD KEY `PartID` (`PartID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `class_user`
--
ALTER TABLE `class_user`
  ADD KEY `userID` (`userID`),
  ADD KEY `classID` (`classID`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`contentID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteriaID`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluationID`),
  ADD KEY `criteriaID` (`criteriaID`);

--
-- Indexes for table `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`partID`);

--
-- Indexes for table `part_content`
--
ALTER TABLE `part_content`
  ADD KEY `partID` (`partID`),
  ADD KEY `contentID` (`contentID`);

--
-- Indexes for table `part_criteria`
--
ALTER TABLE `part_criteria`
  ADD KEY `partID` (`partID`),
  ADD KEY `criteriaID` (`criteriaID`);

--
-- Indexes for table `part_evaluation`
--
ALTER TABLE `part_evaluation`
  ADD KEY `partID` (`partID`),
  ADD KEY `evaluationID` (`evaluationID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projectID`);

--
-- Indexes for table `project_assignment`
--
ALTER TABLE `project_assignment`
  ADD KEY `projectID` (`projectID`),
  ADD KEY `assignmentID` (`assignmentID`);

--
-- Indexes for table `project_evaluation`
--
ALTER TABLE `project_evaluation`
  ADD KEY `projectID` (`projectID`),
  ADD KEY `evaluationID` (`evaluationID`);

--
-- Indexes for table `project_part`
--
ALTER TABLE `project_part`
  ADD PRIMARY KEY (`projectPartID`),
  ADD KEY `projectID` (`projectID`),
  ADD KEY `partID` (`partID`);

--
-- Indexes for table `project_user`
--
ALTER TABLE `project_user`
  ADD KEY `projectID` (`projectID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_evaluation`
--
ALTER TABLE `user_evaluation`
  ADD KEY `evaluationID` (`evaluationID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `contentID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteriaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `part`
--
ALTER TABLE `part`
  MODIFY `partID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment_class`
--
ALTER TABLE `assignment_class`
  ADD CONSTRAINT `assignment_class_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`),
  ADD CONSTRAINT `assignment_class_ibfk_2` FOREIGN KEY (`assignmentID`) REFERENCES `assignment` (`assignmentID`);

--
-- Constraints for table `assignment_criteria`
--
ALTER TABLE `assignment_criteria`
  ADD CONSTRAINT `assignment_criteria_ibfk_1` FOREIGN KEY (`assignmentID`) REFERENCES `assignment` (`assignmentID`),
  ADD CONSTRAINT `assignment_criteria_ibfk_2` FOREIGN KEY (`criteriaID`) REFERENCES `criteria` (`criteriaID`);

--
-- Constraints for table `assignment_parts`
--
ALTER TABLE `assignment_parts`
  ADD CONSTRAINT `assignment_parts_ibfk_1` FOREIGN KEY (`assignmentID`) REFERENCES `assignment` (`assignmentID`),
  ADD CONSTRAINT `assignment_parts_ibfk_2` FOREIGN KEY (`PartID`) REFERENCES `part` (`partID`);

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`);

--
-- Constraints for table `class_user`
--
ALTER TABLE `class_user`
  ADD CONSTRAINT `class_user_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `class_user_ibfk_2` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`criteriaID`) REFERENCES `criteria` (`criteriaID`);

--
-- Constraints for table `part_content`
--
ALTER TABLE `part_content`
  ADD CONSTRAINT `part_content_ibfk_1` FOREIGN KEY (`partID`) REFERENCES `part` (`partID`),
  ADD CONSTRAINT `part_content_ibfk_2` FOREIGN KEY (`contentID`) REFERENCES `content` (`contentID`);

--
-- Constraints for table `part_criteria`
--
ALTER TABLE `part_criteria`
  ADD CONSTRAINT `part_criteria_ibfk_1` FOREIGN KEY (`partID`) REFERENCES `part` (`partID`),
  ADD CONSTRAINT `part_criteria_ibfk_2` FOREIGN KEY (`criteriaID`) REFERENCES `criteria` (`criteriaID`);

--
-- Constraints for table `part_evaluation`
--
ALTER TABLE `part_evaluation`
  ADD CONSTRAINT `part_evaluation_ibfk_1` FOREIGN KEY (`partID`) REFERENCES `part` (`partID`),
  ADD CONSTRAINT `part_evaluation_ibfk_2` FOREIGN KEY (`evaluationID`) REFERENCES `evaluation` (`evaluationID`);

--
-- Constraints for table `project_assignment`
--
ALTER TABLE `project_assignment`
  ADD CONSTRAINT `project_assignment_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`),
  ADD CONSTRAINT `project_assignment_ibfk_2` FOREIGN KEY (`assignmentID`) REFERENCES `assignment` (`assignmentID`);

--
-- Constraints for table `project_evaluation`
--
ALTER TABLE `project_evaluation`
  ADD CONSTRAINT `project_evaluation_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`),
  ADD CONSTRAINT `project_evaluation_ibfk_2` FOREIGN KEY (`evaluationID`) REFERENCES `evaluation` (`evaluationID`);

--
-- Constraints for table `project_part`
--
ALTER TABLE `project_part`
  ADD CONSTRAINT `project_part_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`),
  ADD CONSTRAINT `project_part_ibfk_2` FOREIGN KEY (`partID`) REFERENCES `part` (`partID`);

--
-- Constraints for table `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `project_user_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`),
  ADD CONSTRAINT `project_user_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `user_evaluation`
--
ALTER TABLE `user_evaluation`
  ADD CONSTRAINT `user_evaluation_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `user_evaluation_ibfk_2` FOREIGN KEY (`evaluationID`) REFERENCES `evaluation` (`evaluationID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
