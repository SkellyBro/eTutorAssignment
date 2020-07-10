-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2018 at 06:45 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etutoringdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `userID` tinyint(255) NOT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`userID`, `userName`) VALUES
(2, 'Sarah1');

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `assignID` tinyint(255) NOT NULL,
  `tutorID` tinyint(255) NOT NULL,
  `studentID` tinyint(255) NOT NULL,
  `adminID` tinyint(255) NOT NULL,
  `assignmentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`assignID`, `tutorID`, `studentID`, `adminID`, `assignmentDate`) VALUES
(1, 3, 4, 2, '2018-09-30 21:23:22'),
(2, 3, 6, 2, '2018-10-01 05:17:48'),
(3, 5, 7, 2, '2018-10-26 19:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogID` tinyint(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(255) NOT NULL,
  `uploadedBy` tinyint(2) NOT NULL DEFAULT '0',
  `dateUploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateLastEdited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogID`, `title`, `content`, `uploadedBy`, `dateUploaded`, `dateLastEdited`) VALUES
(1, 'Test blog1', 'Editing this thing.jsdbckjshbcuoadcjxnm', 3, '2018-10-14 02:59:57', '2018-10-14 19:20:44'),
(2, 'Test blog1', 'this is my first blog, editing test.', 3, '2018-10-14 03:24:04', '2018-10-14 17:26:06'),
(3, 'TestEdit', 'TestEditComment', 3, '2018-10-14 03:24:59', '2018-10-18 15:43:39'),
(6, 'Jsnow test blog ', 'Testing student blog.', 8, '2018-10-14 18:55:59', '0000-00-00 00:00:00'),
(7, 'EditTest', 'editTest', 4, '2018-10-18 15:28:42', '2018-10-18 15:39:15'),
(8, 'Test2', 'test', 4, '2018-10-18 15:29:11', '0000-00-00 00:00:00'),
(9, 'Test2', 'test', 4, '2018-10-18 15:30:18', '0000-00-00 00:00:00'),
(10, 'Test2', 'test', 4, '2018-10-18 15:30:35', '0000-00-00 00:00:00'),
(11, 'Test2', 'test', 4, '2018-10-18 15:31:03', '0000-00-00 00:00:00'),
(12, 'Test2', 'test', 4, '2018-10-18 15:32:42', '0000-00-00 00:00:00'),
(13, 'TestTitle', 'TestContent', 5, '2018-10-23 18:58:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `blogcomments`
--

CREATE TABLE `blogcomments` (
  `commentID` tinyint(255) NOT NULL,
  `blog` tinyint(255) NOT NULL,
  `commentDetails` varchar(255) NOT NULL,
  `madeBy` tinyint(255) NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogcomments`
--

INSERT INTO `blogcomments` (`commentID`, `blog`, `commentDetails`, `madeBy`, `commentDate`) VALUES
(1, 1, 'testing blog comment!!', 3, '2018-10-28 07:23:43'),
(2, 12, 'hello', 4, '2018-10-30 20:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` tinyint(255) NOT NULL,
  `document` tinyint(255) NOT NULL,
  `commentDetails` varchar(255) NOT NULL,
  `madeBy` tinyint(255) NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` tinyint(255) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `taughtBy` tinyint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `courseName`, `taughtBy`) VALUES
(102, 'Mobile Development', 3),
(103, 'Java Development', 5);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `documentID` tinyint(255) NOT NULL,
  `documentTitle` varchar(255) NOT NULL,
  `documentDescription` varchar(255) NOT NULL,
  `documentName` varchar(255) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uploadedBy` tinyint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`documentID`, `documentTitle`, `documentDescription`, `documentName`, `uploadDate`, `uploadedBy`) VALUES
(3, 'Hello', 'World', '1140748BSc CIS Course Descriptions (1).pdf', '2018-10-18 04:00:00', 4),
(4, 'Hello', 'World2', '1280823BSc CIS Course Descriptions.pdf', '2018-10-26 04:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `meetingID` tinyint(255) NOT NULL,
  `meetingHost` tinyint(255) NOT NULL,
  `meetingAttendee` tinyint(255) NOT NULL,
  `meetingDate` date NOT NULL,
  `meetingTime` time NOT NULL,
  `meetingType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`meetingID`, `meetingHost`, `meetingAttendee`, `meetingDate`, `meetingTime`, `meetingType`) VALUES
(1, 3, 4, '2018-10-28', '09:00:00', 'Online'),
(2, 3, 4, '2018-10-30', '00:00:10', 'online'),
(3, 3, 4, '2018-10-30', '00:00:10', 'online'),
(4, 3, 4, '2018-10-30', '00:00:12', 'online'),
(5, 3, 4, '2018-10-31', '00:00:10', 'online'),
(6, 3, 4, '2018-11-01', '00:00:10', 'online'),
(7, 3, 4, '2018-11-01', '00:00:08', 'online'),
(9, 3, 4, '2018-12-12', '08:00:00', 'online'),
(10, 3, 4, '2018-12-12', '08:00:00', 'online'),
(11, 3, 4, '2018-11-01', '12:00:00', 'online'),
(12, 3, 4, '2018-11-02', '08:00:00', 'online');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` tinyint(4) NOT NULL,
  `sender` tinyint(4) NOT NULL,
  `recipient` tinyint(4) NOT NULL,
  `messageTitle` varchar(255) NOT NULL,
  `contentDetails` varchar(255) NOT NULL,
  `messageDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `sender`, `recipient`, `messageTitle`, `contentDetails`, `messageDate`) VALUES
(3, 3, 4, 'Hello', 'wvnesvpioewnvsoiavndw', '2018-10-01'),
(6, 3, 4, 'Hello', 'Did you get this message?', '2018-10-15'),
(7, 3, 4, 'Hello', 'Hope you are doing well.', '2018-10-15'),
(8, 4, 3, 'School Schedule', 'Do we have a session on Wednesday??', '2018-10-16'),
(9, 3, 4, 'Hello', 'World', '2018-10-17'),
(10, 3, 4, 'Hello', 'World', '2018-10-17'),
(11, 4, 3, 'Test', 'Content', '2018-10-24'),
(12, 3, 4, 'Test', 'Test', '2018-10-23'),
(13, 4, 3, 'Hello', 'hello', '2018-10-29'),
(14, 4, 3, 'Hello', 'hello', '2018-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `positionId` tinyint(255) NOT NULL,
  `positionName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`positionId`, `positionName`) VALUES
(1, 'Administrator'),
(2, 'Student'),
(3, 'Tutor');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `replyID` tinyint(4) NOT NULL,
  `sender` tinyint(4) NOT NULL,
  `recipient` tinyint(4) NOT NULL,
  `messageTitle` varchar(255) NOT NULL,
  `contentDetails` varchar(255) NOT NULL,
  `messageID` tinyint(4) NOT NULL,
  `messageDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`replyID`, `sender`, `recipient`, `messageTitle`, `contentDetails`, `messageID`, `messageDate`) VALUES
(4, 3, 4, '8686570947', 'reply', 8, '2018-10-29'),
(5, 3, 4, 'title', 'desc', 8, '2018-10-29'),
(6, 3, 4, 'title', 'desc', 8, '2018-10-29'),
(9, 3, 4, 'title', 'desc', 8, '2018-10-29'),
(10, 4, 3, 'TestTitle', 'TestDesc', 3, '2018-10-29'),
(11, 4, 3, 'TestTitle', 'TestDesc', 3, '2018-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `userID` tinyint(255) NOT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`userID`, `userName`) VALUES
(4, 'Peterq'),
(6, 'JSparrow'),
(7, 'SPersad');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `userID` tinyint(255) NOT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`userID`, `userName`) VALUES
(3, 'stephine1'),
(5, 'jane85');

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `userID` tinyint(255) NOT NULL,
  `position` tinyint(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`userID`, `position`, `firstName`, `lastName`, `gender`, `email`, `password`, `dateOfBirth`, `address`, `phoneNumber`) VALUES
(2, 1, 'Sarah', 'Jhonson', 'Female', 'sj@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '1980-01-19', '#33 blue street', '3217654'),
(3, 3, 'Stephanie', 'Ramdass', 'Female', 'sr@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '1987-09-09', '#54 white street', '7755577'),
(4, 2, 'Peter', 'Quill', 'Male', 'realstarlord@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '1997-04-02', '#67 galaxy road', '3466532'),
(5, 3, 'Jane', 'Walker', 'Female', 'jw@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '1985-10-12', '#112 White Hart lane', '7868821'),
(6, 2, 'Jack', 'Sparrow', 'Male', 'js@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '1997-12-12', '12 Todd Street', '898-1923'),
(7, 2, 'Shivan ', 'Persad', 'Male', 'sp@gmail.com', 'password', '1998-10-29', '#99 Random Street', '713 - 6476');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`userName`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`assignID`),
  ADD KEY `tutorID` (`tutorID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `uploadedBy` (`uploadedBy`);

--
-- Indexes for table `blogcomments`
--
ALTER TABLE `blogcomments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `blog` (`blog`),
  ADD KEY `madeBy` (`madeBy`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD UNIQUE KEY `commentID` (`commentID`),
  ADD KEY `madeBy` (`madeBy`),
  ADD KEY `document` (`document`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `taughtBy` (`taughtBy`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`documentID`),
  ADD UNIQUE KEY `documentID` (`documentID`),
  ADD KEY `uploadedBy` (`uploadedBy`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`meetingID`),
  ADD UNIQUE KEY `meetingID` (`meetingID`),
  ADD KEY `meetingHost` (`meetingHost`),
  ADD KEY `meetingAttendee` (`meetingAttendee`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`),
  ADD UNIQUE KEY `messageID` (`messageID`),
  ADD KEY `sender` (`sender`),
  ADD KEY `recipient` (`recipient`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`positionId`),
  ADD UNIQUE KEY `positionId` (`positionId`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`replyID`),
  ADD UNIQUE KEY `replyID` (`replyID`),
  ADD KEY `sender` (`sender`),
  ADD KEY `recipient` (`recipient`),
  ADD KEY `messageID` (`messageID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`userName`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`userName`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `position` (`position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `assignID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `blogcomments`
--
ALTER TABLE `blogcomments`
  MODIFY `commentID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` tinyint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `documentID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `meetingID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `positionId` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `replyID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `userID` tinyint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `assign`
--
ALTER TABLE `assign`
  ADD CONSTRAINT `assign_ibfk_1` FOREIGN KEY (`tutorID`) REFERENCES `tutor` (`userID`),
  ADD CONSTRAINT `assign_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`userID`),
  ADD CONSTRAINT `assign_ibfk_3` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`userID`);

--
-- Constraints for table `blogcomments`
--
ALTER TABLE `blogcomments`
  ADD CONSTRAINT `blogcomments_ibfk_1` FOREIGN KEY (`blog`) REFERENCES `blog` (`blogID`),
  ADD CONSTRAINT `blogcomments_ibfk_2` FOREIGN KEY (`madeBy`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`madeBy`) REFERENCES `useraccount` (`userID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`document`) REFERENCES `documents` (`documentID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`taughtBy`) REFERENCES `tutor` (`userID`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `meeting_ibfk_1` FOREIGN KEY (`meetingHost`) REFERENCES `tutor` (`userID`),
  ADD CONSTRAINT `meeting_ibfk_2` FOREIGN KEY (`meetingAttendee`) REFERENCES `student` (`userID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `useraccount` (`userID`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `useraccount` (`userID`),
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `useraccount` (`userID`),
  ADD CONSTRAINT `reply_ibfk_3` FOREIGN KEY (`messageID`) REFERENCES `message` (`messageID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `useraccount` (`userID`);

--
-- Constraints for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `useraccount_ibfk_1` FOREIGN KEY (`position`) REFERENCES `position` (`positionId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
