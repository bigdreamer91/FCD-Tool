-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2018 at 09:56 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fcd_decomposition_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes_repo`
--

CREATE TABLE `classes_repo` (
  `project_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class_name` varchar(5000) DEFAULT NULL,
  `class_attr` varchar(5000) DEFAULT NULL,
  `uml_mapped` varchar(45) DEFAULT NULL,
  `uml_mapped_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes_repo`
--

INSERT INTO `classes_repo` (`project_id`, `class_id`, `class_name`, `class_attr`, `uml_mapped`, `uml_mapped_id`) VALUES
(4, 1, 'Login', 'user_name, user_password', 'yes', 2),
(4, 2, 'Video Record', 'video_id, video_description, video_category, video_data, uploader_id', 'yes', 6),
(4, 3, 'Upload Function', '', 'yes', 10),
(4, 4, 'Video Gallery', '', 'yes', 14),
(4, 5, 'Ratings Record', 'user_id, video_id, ratings', 'yes', 18),
(4, 6, 'Ratings Function', '', 'yes', 22),
(4, 7, 'Home Page', '', 'yes', 26),
(4, 8, 'Video server', 'request_video', 'yes', 30),
(4, 9, 'send video details gateway', '', 'yes', 34),
(4, 10, 'get video gateway', '', 'yes', 38),
(4, 11, 'Video data function', '', 'yes', 42),
(4, 12, 'Video Player', '', 'yes', 46),
(4, 13, 'Register', 'register_details', 'yes', 50),
(4, 14, 'Comment Function', 'user_id, video_id, comment', 'yes', 54),
(4, 15, 'Subscribe', 'user_id, video_id, subscribe_id', 'yes', 58),
(4, 16, 'Follow', '', 'yes', 62),
(4, 17, 'Favorite', '', 'yes', 66),
(4, 18, 'Playlist', '', 'yes', 70),
(4, 19, 'User Record', '', 'yes', 74),
(4, 20, 'search videos', '', 'yes', 78),
(4, 21, 'Video Page', '', 'yes', 82),
(4, 22, 'User Profile Page', '', 'yes', 86),
(4, 23, 'Player Component Main', '', 'yes', 90),
(4, 24, 'Player Component Sub', '', 'yes', 94);

-- --------------------------------------------------------

--
-- Table structure for table `fcd_header_table_repo`
--

CREATE TABLE `fcd_header_table_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `fcd_header_id` int(11) NOT NULL,
  `level_num` int(11) DEFAULT NULL,
  `fcd_name` varchar(45) DEFAULT NULL,
  `fcd_description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fcd_header_table_repo`
--

INSERT INTO `fcd_header_table_repo` (`project_id`, `sprint_id`, `fcd_header_id`, `level_num`, `fcd_name`, `fcd_description`) VALUES
(4, 1, 0, 0, 'High Level Architecture', NULL),
(4, 1, 1, 1, 'Level 1 Decomposition', ''),
(4, 1, 2, 2, 'Level 2 Decomposition', ''),
(4, 4, 3, 3, 'Level 3 Decomposition', ''),
(5, 1, 0, 0, 'High Level Architecture', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `functionality_classes_methods_repo`
--

CREATE TABLE `functionality_classes_methods_repo` (
  `project_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class_method_id` int(11) NOT NULL,
  `class_method_name` varchar(5000) DEFAULT NULL,
  `existing_step_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_classes_methods_repo`
--

INSERT INTO `functionality_classes_methods_repo` (`project_id`, `class_id`, `class_method_id`, `class_method_name`, `existing_step_id`) VALUES
(4, 1, 1, 'display sigin UI', 1),
(4, 1, 2, 'validate user name and password', 2),
(4, 1, 3, 'check Login', 3),
(4, 1, 4, 'handle login success', 4),
(4, 1, 5, 'handle login failure', 5),
(4, 3, 1, 'display upload UI', 6),
(4, 3, 2, 'save video to database', 9),
(4, 3, 3, 'check if user signed in', 7),
(4, 3, 4, 'validate user input', 8),
(4, 3, 5, 'save data through gateway', 18),
(4, 4, 1, 'get list of videos in database', 10),
(4, 4, 2, 'click video in list', 11),
(4, 4, 3, 'get video data', 12),
(4, 4, 4, 'play video data in player', 13),
(4, 4, 5, 'get recommend videos', 50),
(4, 6, 1, 'display ratings UI', 14),
(4, 6, 2, 'rate video', 15),
(4, 6, 3, 'save ratings', 16),
(4, 7, 1, 'video gallery adapter', 43),
(4, 7, 2, 'display app menu', 44),
(4, 7, 3, 'display user profile menu', 45),
(4, 7, 4, 'search video adapter', 46),
(4, 9, 1, 'save data to server', 17),
(4, 10, 1, 'get data from server', 19),
(4, 11, 1, 'check for data corruption', 21),
(4, 11, 3, 'handle data transmission error', 22),
(4, 11, 4, 'get data through gateway', 20),
(4, 11, 5, 'return recommended videos', 49),
(4, 11, 6, 'return suggested videos', 62),
(4, 12, 1, 'video player UI', 28),
(4, 12, 2, 'resize video player', 23),
(4, 12, 3, 'pause', 24),
(4, 12, 4, 'skip, reverse, forward', 25),
(4, 12, 5, 'sound quality', 26),
(4, 12, 6, 'play speed', 27),
(4, 13, 1, 'display register UI', 29),
(4, 13, 2, 'handle register click event', 30),
(4, 13, 3, 'save data in register database', 31),
(4, 14, 1, 'display comment UI', 32),
(4, 14, 2, 'save comment', 33),
(4, 15, 1, 'display subscribe UI', 39),
(4, 15, 2, 'add uploader to subscribe db', 40),
(4, 16, 1, 'display follow UI', 41),
(4, 16, 2, 'add follow to database', 42),
(4, 17, 1, 'display add favorite UI', 34),
(4, 17, 2, 'save video to favorites', 35),
(4, 18, 1, 'create playlist', 36),
(4, 18, 2, 'display playlist UI', 38),
(4, 18, 3, 'save video in selected playlist', 37),
(4, 20, 1, 'display search UI', 47),
(4, 20, 2, 'autocomplete', 48),
(4, 21, 1, 'Video player', 51),
(4, 21, 2, 'comment adapter', 53),
(4, 21, 3, 'ratings adapter', 54),
(4, 21, 4, 'suggested videos adapter', 55),
(4, 21, 5, 'add to favorite adapter', 56),
(4, 21, 6, 'subscribe adapter', 57),
(4, 22, 1, 'upload video adapter', 58),
(4, 22, 2, 'playlist adapter', 59),
(4, 22, 3, 'follow adapter', 60),
(4, 22, 4, 'history adaoter', 61);

-- --------------------------------------------------------

--
-- Table structure for table `functionality_classes_repo`
--

CREATE TABLE `functionality_classes_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `functionality_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class_mapped_id` int(11) DEFAULT NULL,
  `group_mapped` varchar(45) DEFAULT NULL,
  `group_mapped_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_classes_repo`
--

INSERT INTO `functionality_classes_repo` (`project_id`, `sprint_id`, `functionality_id`, `class_id`, `class_mapped_id`, `group_mapped`, `group_mapped_id`) VALUES
(4, 1, 0, 1, 1, 'yes', 6),
(4, 1, 0, 2, 2, 'yes', 1),
(4, 1, 0, 3, 3, 'yes', 1),
(4, 1, 0, 4, 4, 'yes', 1),
(4, 1, 0, 5, 5, 'yes', 2),
(4, 1, 0, 6, 6, 'yes', 2),
(4, 1, 0, 7, 7, 'yes', 8),
(4, 1, 1, 1, 8, 'yes', 4),
(4, 1, 1, 2, 9, 'yes', 3),
(4, 1, 1, 3, 10, 'yes', 3),
(4, 1, 1, 4, 11, 'yes', 4),
(4, 1, 1, 5, 12, 'yes', 5),
(4, 2, 0, 8, 13, 'yes', 6),
(4, 2, 0, 9, 14, 'yes', 2),
(4, 2, 0, 10, 15, 'yes', 2),
(4, 2, 0, 11, 16, 'yes', 2),
(4, 2, 0, 12, 17, 'yes', 7),
(4, 2, 0, 13, 18, 'yes', 7),
(4, 2, 0, 14, 19, 'yes', 7),
(4, 3, 0, 15, 20, '', NULL),
(4, 3, 0, 16, 21, 'yes', 8),
(4, 3, 0, 17, 22, 'yes', 8),
(4, 4, 5, 1, 23, 'yes', 9),
(4, 4, 5, 2, 24, 'yes', 9);

-- --------------------------------------------------------

--
-- Table structure for table `functionality_groupings_repo`
--

CREATE TABLE `functionality_groupings_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `functionality_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_groupings_repo`
--

INSERT INTO `functionality_groupings_repo` (`project_id`, `sprint_id`, `functionality_id`, `group_id`, `group_name`) VALUES
(4, 1, 0, 1, 'Video Management'),
(4, 1, 0, 2, 'User Activity Analytics'),
(4, 1, 1, 3, 'Video Gateway'),
(4, 1, 1, 4, 'Video Data Manager'),
(4, 1, 1, 5, 'Video Player'),
(4, 2, 0, 6, 'Login / Register'),
(4, 2, 0, 7, 'User Account'),
(4, 3, 0, 8, 'Application Pages'),
(4, 4, 5, 9, 'Player Component');

-- --------------------------------------------------------

--
-- Table structure for table `functionality_list_repo`
--

CREATE TABLE `functionality_list_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `fcd_id` int(11) NOT NULL,
  `functionality_id` int(11) NOT NULL,
  `functionality_name` varchar(45) DEFAULT NULL,
  `functionality_description` varchar(45) DEFAULT NULL,
  `parent_functionality_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_list_repo`
--

INSERT INTO `functionality_list_repo` (`project_id`, `sprint_id`, `fcd_id`, `functionality_id`, `functionality_name`, `functionality_description`, `parent_functionality_id`) VALUES
(4, 1, 0, 0, 'High Level', NULL, NULL),
(4, 1, 1, 1, 'Video Management', '', 0),
(4, 1, 1, 2, 'User Activity Analytics', '', 0),
(4, 1, 2, 3, 'Video Gateway', '', 1),
(4, 1, 2, 4, 'Video Data Manager', '', 1),
(4, 1, 2, 5, 'Video Player', '', 1),
(4, 2, 1, 6, 'Login / Register', '', 0),
(4, 2, 1, 7, 'User Account', '', 0),
(4, 3, 1, 8, 'Application Pages', '', 0),
(4, 4, 3, 9, 'Player Component', '', 5),
(5, 1, 0, 0, 'High Level', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `functionality_usecases_repo`
--

CREATE TABLE `functionality_usecases_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `functionality_id` int(11) NOT NULL,
  `usecase_id` int(11) NOT NULL,
  `usecase_name` varchar(60000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_usecases_repo`
--

INSERT INTO `functionality_usecases_repo` (`project_id`, `sprint_id`, `functionality_id`, `usecase_id`, `usecase_name`) VALUES
(4, 1, 0, 1, 'Sign In'),
(4, 1, 0, 2, 'upload videos'),
(4, 1, 0, 3, 'play selected video'),
(4, 1, 0, 4, 'rate video'),
(4, 1, 1, 1, 'reliable video data storage'),
(4, 1, 1, 2, 'reliable video data play'),
(4, 1, 1, 3, 'customize video player'),
(4, 2, 0, 1, 'Register to application'),
(4, 2, 0, 2, 'comment on video'),
(4, 2, 0, 3, 'add video to favorite and playlist'),
(4, 2, 0, 4, 'subscribe to uploader'),
(4, 2, 0, 5, 'follow uploader'),
(4, 3, 0, 1, 'Home page with app menu, user profile menu and recommended videos'),
(4, 3, 0, 2, 'Video page with video player, ratings, comment, subscribe'),
(4, 3, 0, 3, 'user profile page to add playlist, favorite, upload, check history');

-- --------------------------------------------------------

--
-- Table structure for table `functionality_usecases_steps_repo`
--

CREATE TABLE `functionality_usecases_steps_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `functionality_id` int(11) NOT NULL,
  `usecase_id` int(11) NOT NULL,
  `usecase_step_id` int(11) NOT NULL,
  `usecase_mapped_step_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functionality_usecases_steps_repo`
--

INSERT INTO `functionality_usecases_steps_repo` (`project_id`, `sprint_id`, `functionality_id`, `usecase_id`, `usecase_step_id`, `usecase_mapped_step_id`) VALUES
(4, 1, 0, 1, 1, 1),
(4, 1, 0, 1, 2, 2),
(4, 1, 0, 1, 3, 3),
(4, 1, 0, 1, 4, 4),
(4, 1, 0, 1, 5, 5),
(4, 1, 0, 2, 1, 6),
(4, 1, 0, 2, 2, 7),
(4, 1, 0, 2, 3, 8),
(4, 1, 0, 2, 4, 9),
(4, 1, 0, 3, 1, 10),
(4, 1, 0, 3, 2, 11),
(4, 1, 0, 3, 3, 12),
(4, 1, 0, 3, 4, 13),
(4, 1, 0, 4, 1, 14),
(4, 1, 0, 4, 2, 15),
(4, 1, 0, 4, 3, 16),
(4, 1, 1, 1, 1, 17),
(4, 1, 1, 1, 2, 18),
(4, 1, 1, 2, 1, 19),
(4, 1, 1, 2, 2, 20),
(4, 1, 1, 2, 3, 21),
(4, 1, 1, 2, 4, 22),
(4, 1, 1, 3, 1, 23),
(4, 1, 1, 3, 2, 24),
(4, 1, 1, 3, 3, 25),
(4, 1, 1, 3, 4, 26),
(4, 1, 1, 3, 5, 27),
(4, 2, 0, 1, 1, 29),
(4, 2, 0, 1, 2, 30),
(4, 2, 0, 1, 3, 31),
(4, 2, 0, 2, 1, 32),
(4, 2, 0, 2, 2, 33),
(4, 2, 0, 3, 1, 34),
(4, 2, 0, 3, 2, 35),
(4, 2, 0, 3, 3, 36),
(4, 2, 0, 3, 4, 37),
(4, 2, 0, 3, 5, 38),
(4, 2, 0, 4, 1, 39),
(4, 2, 0, 4, 2, 40),
(4, 2, 0, 5, 1, 41),
(4, 2, 0, 5, 2, 42);

-- --------------------------------------------------------

--
-- Table structure for table `groups_repo`
--

CREATE TABLE `groups_repo` (
  `project_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_repo`
--

INSERT INTO `groups_repo` (`project_id`, `group_id`, `group_name`) VALUES
(4, 1, 'Video Management'),
(4, 2, 'User Activity Analytics'),
(4, 3, 'Video Gateway'),
(4, 4, 'Video Data Manager'),
(4, 5, 'Video Player'),
(4, 6, 'Login / Register'),
(4, 7, 'User Account'),
(4, 8, 'Application Pages'),
(4, 9, 'Player Component');

-- --------------------------------------------------------

--
-- Table structure for table `sprint_group_repo`
--

CREATE TABLE `sprint_group_repo` (
  `project_id` int(11) NOT NULL,
  `sprint_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sprint_info`
--

CREATE TABLE `sprint_info` (
  `sprint_id` int(11) NOT NULL,
  `sprint_name` varchar(45) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sprint_info`
--

INSERT INTO `sprint_info` (`sprint_id`, `sprint_name`, `project_id`) VALUES
(1, 'Sprint 1', 4),
(1, 'Sprint 1', 5),
(2, 'Sprint 2', 4),
(3, 'Sprint 3', 4),
(4, 'Sprint 4', 4);

-- --------------------------------------------------------

--
-- Table structure for table `steps_repo`
--

CREATE TABLE `steps_repo` (
  `project_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `step_name` varchar(5000) DEFAULT NULL,
  `step_reqs` varchar(5000) DEFAULT NULL,
  `step_method_notes` varchar(5000) DEFAULT NULL,
  `step_expecs` varchar(5000) DEFAULT NULL,
  `step_mapped` varchar(45) DEFAULT NULL,
  `mapped_class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `steps_repo`
--

INSERT INTO `steps_repo` (`project_id`, `step_id`, `step_name`, `step_reqs`, `step_method_notes`, `step_expecs`, `step_mapped`, `mapped_class_id`) VALUES
(4, 1, 'display sigin UI', '', '', '', 'yes', 1),
(4, 2, 'validate user name and password', '', '', '', 'yes', 1),
(4, 3, 'check Login', 'username, password', '', 'check database for login details match', 'yes', 1),
(4, 4, 'handle login success', '', '', 'redirect to Home page', 'yes', 1),
(4, 5, 'handle login failure', '', '', 'throw error', 'yes', 1),
(4, 6, 'display upload UI', '', '', '', 'yes', 3),
(4, 7, 'check if user signed in', '', '', '', 'yes', 3),
(4, 8, 'validate user input', '', '', '', 'yes', 3),
(4, 9, 'save video to database', 'video details, video data', '', 'save data in video database', 'yes', 3),
(4, 10, 'get list of videos in database', '', '', '', 'yes', 4),
(4, 11, 'click video in list', 'click event, video id', '', 'play video', 'yes', 4),
(4, 12, 'get video data', 'video id', '', 'return video data', 'yes', 4),
(4, 13, 'play video data in player', 'video data', '', '', 'yes', 4),
(4, 14, 'display ratings UI', '', '', '', 'yes', 6),
(4, 15, 'rate video', 'click event', '', 'send ratings to database', 'yes', 6),
(4, 16, 'save ratings', 'user_id, video_id, ratings', '', 'save ratings in database', 'yes', 6),
(4, 17, 'save data to server', '', '', '', 'yes', 9),
(4, 18, 'save data through gateway', '', '', '', 'yes', 3),
(4, 19, 'get data from server', '', '', '', 'yes', 10),
(4, 20, 'get data through gateway', '', '', '', 'yes', 11),
(4, 21, 'check for data corruption', '', '', '', 'yes', 11),
(4, 22, 'handle data transmission error', '', '', '', 'yes', 11),
(4, 23, 'resize video player', '', '', '', 'yes', 12),
(4, 24, 'pause', '', '', '', 'yes', 12),
(4, 25, 'skip, reverse, forward', '', '', '', 'yes', 12),
(4, 26, 'sound quality', '', '', '', 'yes', 12),
(4, 27, 'play speed', '', '', '', 'yes', 12),
(4, 28, 'video player UI', '', '', '', 'yes', 12),
(4, 29, 'display register UI', '', '', '', 'yes', 13),
(4, 30, 'handle register click event', '', '', '', 'yes', 13),
(4, 31, 'save data in register database', 'register details', '', 'save data to register database', 'yes', 13),
(4, 32, 'display comment UI', '', '', '', 'yes', 14),
(4, 33, 'save comment', 'user_id, video_id, comment_data', '', 'save comment in database', 'yes', 14),
(4, 34, 'display add favorite UI', '', '', '', 'yes', 17),
(4, 35, 'save video to favorites', 'user_id, video_id', '', 'save video to favorite database', 'yes', 17),
(4, 36, 'create playlist', 'user_id', '', 'save playlist in playlists database', 'yes', 18),
(4, 37, 'save video in selected playlist', 'user_id, playlist_id, video_id', '', 'save video to playlist db', 'yes', 18),
(4, 38, 'display playlist UI', '', '', '', 'yes', 18),
(4, 39, 'display subscribe UI', '', '', '', 'yes', 15),
(4, 40, 'add uploader to subscribe db', 'user_id, uploader_id', '', 'add to database', 'yes', 15),
(4, 41, 'display follow UI', '', '', '', 'yes', 16),
(4, 42, 'add follow to database', 'user_id, uploader_id', '', 'add to database', 'yes', 16),
(4, 43, 'video gallery adapter', '', '', '', 'yes', 7),
(4, 44, 'display app menu', '', '', '', 'yes', 7),
(4, 45, 'display user profile menu', '', '', '', 'yes', 7),
(4, 46, 'search video adapter', '', '', '', 'yes', 7),
(4, 47, 'display search UI', '', '', '', 'yes', 20),
(4, 48, 'autocomplete', '', '', '', 'yes', 20),
(4, 49, 'return recommended videos', 'video_id', '', 'return list of videos', 'yes', 11),
(4, 50, 'get recommend videos', '', '', '', 'yes', 4),
(4, 51, 'Video player adapter', '', '', '', 'yes', 21),
(4, 52, '', '', '', '', 'no', NULL),
(4, 53, 'comment adapter', '', '', '', 'yes', 21),
(4, 54, 'ratings adapter', '', '', '', 'yes', 21),
(4, 55, 'suggested videos adapter', '', '', '', 'yes', 21),
(4, 56, 'add to favorite adapter', '', '', '', 'yes', 21),
(4, 57, 'subscribe adapter', '', '', '', 'yes', 21),
(4, 58, 'upload video adapter', '', '', '', 'yes', 22),
(4, 59, 'playlist adapter', '', '', '', 'yes', 22),
(4, 60, 'follow adapter', '', '', '', 'yes', 22),
(4, 61, 'history adaoter', '', '', '', 'yes', 22),
(4, 62, 'return suggested videos', '', '', '', 'yes', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes_repo`
--
ALTER TABLE `classes_repo`
  ADD PRIMARY KEY (`project_id`,`class_id`);

--
-- Indexes for table `fcd_header_table_repo`
--
ALTER TABLE `fcd_header_table_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`fcd_header_id`);

--
-- Indexes for table `functionality_classes_methods_repo`
--
ALTER TABLE `functionality_classes_methods_repo`
  ADD PRIMARY KEY (`project_id`,`class_id`,`class_method_id`);

--
-- Indexes for table `functionality_classes_repo`
--
ALTER TABLE `functionality_classes_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`functionality_id`,`class_id`);

--
-- Indexes for table `functionality_groupings_repo`
--
ALTER TABLE `functionality_groupings_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`functionality_id`,`group_id`);

--
-- Indexes for table `functionality_list_repo`
--
ALTER TABLE `functionality_list_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`fcd_id`,`functionality_id`);

--
-- Indexes for table `functionality_usecases_repo`
--
ALTER TABLE `functionality_usecases_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`functionality_id`,`usecase_id`);

--
-- Indexes for table `functionality_usecases_steps_repo`
--
ALTER TABLE `functionality_usecases_steps_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`functionality_id`,`usecase_id`,`usecase_step_id`);

--
-- Indexes for table `groups_repo`
--
ALTER TABLE `groups_repo`
  ADD PRIMARY KEY (`project_id`,`group_id`);

--
-- Indexes for table `sprint_group_repo`
--
ALTER TABLE `sprint_group_repo`
  ADD PRIMARY KEY (`project_id`,`sprint_id`,`group_id`,`class_id`);

--
-- Indexes for table `sprint_info`
--
ALTER TABLE `sprint_info`
  ADD PRIMARY KEY (`sprint_id`,`project_id`);

--
-- Indexes for table `steps_repo`
--
ALTER TABLE `steps_repo`
  ADD PRIMARY KEY (`project_id`,`step_id`);
