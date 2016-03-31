-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 31, 2016 at 06:15 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

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
-- Table structure for table `class`
--

CREATE TABLE `class` (
`classID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseID` int(10) DEFAULT NULL,
  `time` time NOT NULL,
  `description` text NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `title`, `courseID`, `time`, `description`, `location`) VALUES
(1, 'Learning About Nothing', 1, '09:30:00', 'Period 1 for the class.', 'Barrows Hall'),
(2, 'Learning About Nothing', 1, '11:30:00', 'Another class later in the day', 'Neville Hall'),
(5, 'NMD102', 2, '10:11:13', 'We do stuff in this class', 'Boardman 203'),
(13, 'ELO', 2, '16:20:00', 'Elooooo', 'Middlefield');

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
-- Table structure for table `course`
--

CREATE TABLE `course` (
`courseID` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `courseCode` varchar(6) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteriaID`, `title`, `description`, `rating`, `comment`) VALUES
(1, '5 Min Lecture', 'Better not be boring. It''s worth 100% of your grade.', 0, '0'),
(6, 'TEST 1', 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum .', 0, ''),
(7, 'TEST 2', 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum .', 0, ''),
(8, 'TEST 1', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 0, ''),
(9, 'TEST 2', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 0, ''),
(10, 'PEER TEST 1', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 0, ''),
(11, 'PEER TEST 2', 'LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. LOREM IPSUM. ', 0, ''),
(12, 'Intuitive Interface\r\nNavigation', '', 0, ''),
(13, 'Narrative \r\nObjectives', '', 0, ''),
(14, 'Creativity', '', 0, ''),
(15, 'Critical Thinking', '', 0, ''),
(16, 'Interaction', '', 0, ''),
(17, 'Bonus', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_selection`
--

CREATE TABLE `criteria_selection` (
  `criteriaID` int(11) NOT NULL,
  `selectionID` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria_selection`
--

INSERT INTO `criteria_selection` (`criteriaID`, `selectionID`, `value`) VALUES
(12, 1, 1),
(12, 2, 2),
(12, 3, 3),
(12, 4, 4),
(12, 5, 5),
(13, 6, 1),
(13, 7, 2),
(13, 8, 3),
(13, 9, 4),
(13, 10, 5),
(14, 11, 1),
(14, 12, 2),
(14, 13, 3),
(14, 14, 4),
(14, 15, 5),
(15, 16, 1),
(15, 17, 2),
(15, 18, 3),
(15, 19, 4),
(15, 20, 5),
(16, 21, 1),
(16, 22, 2),
(16, 23, 3),
(16, 24, 4),
(16, 25, 5),
(17, 26, 1),
(17, 27, 2),
(17, 28, 3),
(17, 29, 4),
(17, 30, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

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
(35, 12),
(35, 13),
(35, 14),
(35, 15),
(35, 16),
(35, 17),
(36, 8),
(36, 9),
(36, 12),
(36, 13),
(36, 14),
(36, 15),
(36, 16),
(36, 17),
(38, 10),
(38, 11),
(38, 12),
(38, 13),
(38, 14),
(38, 15),
(38, 16),
(38, 17);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_parent`
--

CREATE TABLE `evaluation_parent` (
  `parentID` int(11) NOT NULL,
  `childID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `selection`
--

CREATE TABLE `selection` (
`selectionID` int(11) NOT NULL,
  `description` varchar(120) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `selection`
--

INSERT INTO `selection` (`selectionID`, `description`) VALUES
(1, 'Interface confusing. Difficult to navigate'),
(2, 'Some instructions on how to navigate project'),
(3, 'Interface/Nav supported the project goals'),
(4, 'Some good ideas embedded in Navigation/Interface'),
(5, 'Very intuitive. Navigation supported learning and entertainment'),
(6, 'Narrative Objectives showed little thought'),
(7, 'The project shows a small amount of Narrative '),
(8, 'The project shows a moderate amount of Narrative '),
(9, 'The project shows a good amount of thoughtfulness and Narrative '),
(10, 'The project shows an exceptional amount of thoughtfulness and Narrative '),
(11, 'The project shows little thought or creativity'),
(12, 'The project shows a small amount of creativity'),
(13, 'The project shows a moderate amount of creativity'),
(14, 'The project shows a good amount of thoughtfulness and creativity'),
(15, 'The project shows an exceptional amount of thoughtfulness and creativity'),
(16, 'The project shows meaningful thought about narrative '),
(17, 'The project Shows a small amount of critical thinking about deeper meanings presented in the project ideas'),
(18, 'The project shows a moderate ability to think critically about meanngs presented in the project’s ideas and themes'),
(19, 'The project shows a good ability to think critically about the meanings presented in the project ideas and themes'),
(20, 'The project shows a great amount of critical thinking. The project shows a deep understanding about the themes and meani'),
(21, 'The project shows a complete lack interaction'),
(22, 'The project shows a minimal amount of interaction'),
(23, 'The project shows a moderate amount of interaction'),
(24, 'The project shows a solid amount of interaction'),
(25, 'The project shows an outstanding and deep interaction'),
(26, 'The project has no bonus criteria '),
(27, 'The project shows 1 bonus criteria '),
(28, 'The project shows 2 bonus criteria'),
(29, 'The project shows 3 bonus criteria'),
(30, 'The project shows 4 or more bonus criteria ');

-- --------------------------------------------------------

--
-- Table structure for table `student_group`
--

CREATE TABLE `student_group` (
`student_groupID` int(11) NOT NULL,
  `assignmentID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

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
 ADD KEY `classID` (`classID`), ADD KEY `assignmentID` (`assignmentID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
 ADD PRIMARY KEY (`classID`), ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `class_user`
--
ALTER TABLE `class_user`
 ADD KEY `userID` (`userID`), ADD KEY `classID` (`classID`);

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
 ADD PRIMARY KEY (`evaluationID`), ADD KEY `criteriaID` (`criteriaID`);

--
-- Indexes for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
 ADD KEY `evaluationID` (`evaluationID`,`criteriaID`);

--
-- Indexes for table `selection`
--
ALTER TABLE `selection`
 ADD PRIMARY KEY (`selectionID`);

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
 ADD KEY `evaluationID` (`evaluationID`), ADD KEY `userID` (`userID`);

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
MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
MODIFY `criteriaID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
MODIFY `evaluationID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `selection`
--
ALTER TABLE `selection`
MODIFY `selectionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
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
