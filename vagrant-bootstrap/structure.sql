-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 30, 2016 at 03:49 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignmentID`, `title`, `description`) VALUES
(1, 'Learn About Otters', 'A project about otters'),
(3, 'Edutainment', 'Do some stuff'),
(17, 'Art Blast', 'Blast some art');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_class`
--

CREATE TABLE `assignment_class` (
  `classID` int(10) NOT NULL,
  `assignmentID` int(10) NOT NULL,
  `dueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_class`
--

INSERT INTO `assignment_class` (`classID`, `assignmentID`, `dueDate`) VALUES
(5, 3, '2016-03-31'),
(5, 17, '2016-04-05');

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
-- Table structure for table `assignment_evaluation`
--

CREATE TABLE `assignment_evaluation` (
  `assignmentID` int(11) NOT NULL,
  `evaluationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_evaluation`
--

INSERT INTO `assignment_evaluation` (`assignmentID`, `evaluationID`) VALUES
(3, 35),
(17, 36),
(17, 38);

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
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseID` int(10) NOT NULL,
  `time` time NOT NULL,
  `description` text NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `title`, `courseID`, `time`, `description`, `location`) VALUES
(1, 'Learning About Nothing', 1, '09:30:00', 'Period 1 for the class.', 'Barrows Hall'),
(2, 'Learning About Nothing', 1, '11:30:00', 'Another class later in the day', 'Neville Hall'),
(5, 'NMD102', 2, '10:11:13', 'We do stuff in this class', 'Boardman 203');

-- --------------------------------------------------------

--
-- Table structure for table `class_user`
--

CREATE TABLE `class_user` (
  `classID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `userType` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_user`
--

INSERT INTO `class_user` (`classID`, `userID`, `userType`) VALUES
(5, 50, 'Instructor'),
(5, 11, 'Student'),
(5, 12, 'Student'),
(5, 1, 'Student');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`contentID`, `name`, `format`, `size`, `location`) VALUES
(1, 'Otter Powerpoint', 'ppt', '156000000', '/users/1/ottrppt');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseCode` varchar(6) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `title`, `courseCode`, `description`) VALUES
(1, 'Learning About Nothing', 'BORING', 'Another class where you do work but never seem to gain any knowledge from it. Basically paying money to do work for no gain... seems... cheap.'),
(2, 'New Media 102', 'NMD102', 'Here''s stuff');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteriaID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `ratingRange` int(5) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteriaID`, `title`, `description`, `ratingRange`, `rating`, `comment`) VALUES
(1, '5 Min Lecture', 'Better not be boring. It''s worth 100% of your grade.', 100, 0, '0'),
(6, 'TEST 1', 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum .', 5, 0, ''),
(7, 'TEST 2', 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum .', 5, 0, ''),
(8, 'TEST 1', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 5, 0, ''),
(9, 'TEST 2', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 5, 0, ''),
(10, 'PEER TEST 1', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 5, 0, ''),
(11, 'PEER TEST 2', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 5, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluationID` int(11) NOT NULL,
  `criteriaID` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  `evaluation_type` varchar(15) NOT NULL,
  `target_userID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`evaluationID`, `criteriaID`, `done`, `evaluation_type`, `target_userID`, `groupID`) VALUES
(35, 1, 0, 'Group', 0, 1),
(36, 1, 0, 'Group', 0, 2),
(38, 1, 0, 'Peer', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_criteria`
--

CREATE TABLE `evaluation_criteria` (
  `evaluationID` int(11) NOT NULL,
  `criteriaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_criteria`
--

INSERT INTO `evaluation_criteria` (`evaluationID`, `criteriaID`) VALUES
(35, 6),
(35, 7),
(36, 8),
(36, 9),
(38, 10),
(38, 11);

-- --------------------------------------------------------

--
-- Table structure for table `part`
--

CREATE TABLE `part` (
  `partID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `part`
--

INSERT INTO `part` (`partID`, `title`, `description`) VALUES
(1, 'A power-point slideshow', 'About how otters exist');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectID`, `title`, `description`, `assignmentID`) VALUES
(1, 'Otters', 'A project about otters', 1);

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
-- Table structure for table `student_group`
--

CREATE TABLE `student_group` (
  `student_groupID` int(11) NOT NULL,
  `assignmentID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_group`
--

INSERT INTO `student_group` (`student_groupID`, `assignmentID`, `name`) VALUES
(1, 1, 'Group 1'),
(2, 1, 'Group 2');

-- --------------------------------------------------------

--
-- Table structure for table `student_group_user`
--

CREATE TABLE `student_group_user` (
  `student_groupID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_group_user`
--

INSERT INTO `student_group_user` (`student_groupID`, `userID`) VALUES
(1, 1),
(2, 11),
(2, 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `firstName`, `lastName`, `middleInitial`, `userType`, `email`, `password`) VALUES
(1, 'Bob', 'Dole', 'Q', 'Student', 'bob@dole.com', 'password'),
(11, 'steve', 'leighton', 'r', 'Student', 'serk@email.com', 'derka'),
(12, 'tyler', 'dubay', 'a', 'Student', 'email@yahoo.com', 'hello'),
(50, 'Mike', 'Scott', '', 'Instructor', 'mike.scott@maine.edu', 'hashed');

-- --------------------------------------------------------

--
-- Table structure for table `user_evaluation`
--

CREATE TABLE `user_evaluation` (
  `userID` int(11) NOT NULL,
  `evaluationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_evaluation`
--

INSERT INTO `user_evaluation` (`userID`, `evaluationID`) VALUES
(12, 35),
(1, 36),
(11, 38);

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
-- Indexes for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
  ADD KEY `evaluationID` (`evaluationID`,`criteriaID`);

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
-- Indexes for table `student_group`
--
ALTER TABLE `student_group`
  ADD PRIMARY KEY (`student_groupID`);

--
-- Indexes for table `student_group_user`
--
ALTER TABLE `student_group_user`
  ADD KEY `student_group_user_ibfk_1` (`student_groupID`);

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
  MODIFY `assignmentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `contentID` int(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteriaID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluationID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `part`
--
ALTER TABLE `part`
  MODIFY `partID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `student_group`
--
ALTER TABLE `student_group`
  MODIFY `student_groupID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
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
-- Constraints for table `student_group_user`
--
ALTER TABLE `student_group_user`
  ADD CONSTRAINT `student_group_user_ibfk_1` FOREIGN KEY (`student_groupID`) REFERENCES `student_group` (`student_groupID`);

--
-- Constraints for table `user_evaluation`
--
ALTER TABLE `user_evaluation`
  ADD CONSTRAINT `user_evaluation_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `user_evaluation_ibfk_2` FOREIGN KEY (`evaluationID`) REFERENCES `evaluation` (`evaluationID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
