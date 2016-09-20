-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-06-12 09:16:36
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iscut`
--

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `c_id` char(7) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `credit` decimal(5,2) NOT NULL,
  `least_grade` tinyint(1) UNSIGNED NOT NULL,
  `off_year` smallint(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`c_id`, `c_name`, `credit`, `least_grade`, `off_year`) VALUES
('1234567', 'C++高级程序设计', '4.00', 1, NULL),
('2345678', '数据库', '4.00', 2, NULL),
('3456789', '体育', '2.00', 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `enrol`
--

CREATE TABLE `enrol` (
  `s_id` char(30) NOT NULL,
  `c_id` char(7) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `year` smallint(4) NOT NULL,
  `grade` smallint(3) UNSIGNED DEFAULT NULL,
  `t_id` char(5) NOT NULL,
  `enrol_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `enrol`
--

INSERT INTO `enrol` (`s_id`, `c_id`, `semester`, `year`, `grade`, `t_id`, `enrol_id`) VALUES
('1234567891', '1234567', '2', 2016, 100, '12345', 3),
('1234567891', '2345678', '2', 2016, NULL, '12348', 4),
('1234567891', '3456789', '2', 2016, NULL, '23456', 5);

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE `manager` (
  `m_id` char(7) NOT NULL,
  `pass` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`m_id`, `pass`) VALUES
('1234567', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `s_id` char(10) NOT NULL,
  `s_name` char(30) NOT NULL,
  `gender` enum('男','女') NOT NULL,
  `enter_year` char(4) NOT NULL,
  `s_class` char(50) NOT NULL,
  `pass` char(40) NOT NULL,
  `enter_age` tinyint(2) NOT NULL,
  `dep_name` char(50) NOT NULL DEFAULT '学院'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`s_id`, `s_name`, `gender`, `enter_year`, `s_class`, `pass`, `enter_age`, `dep_name`) VALUES
('1234567891', '黄豪', '男', '2010', '计算机科学与技术', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 15, '计算机科学与工程');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `t_id` char(5) NOT NULL,
  `t_name` char(30) NOT NULL,
  `pass` char(40) NOT NULL,
  `dep_name` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`t_id`, `t_name`, `pass`, `dep_name`) VALUES
('12345', '徐雪妙', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '计算机科学与工程'),
('12348', '黄豪', '124', '计算机'),
('22222', '雨小文', '43814346e21444aaf4f70841bf7ed5ae93f55a9d', ''),
('22255', '马小康', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', '计算机'),
('23456', '黄小豪', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '计算机科学与工程'),
('54999', '急急急', '59129aacfb6cebbe2c52f30ef3424209f7252e82', ''),
('55555', 'Whitney Houston', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', ''),
('56789', '洋芋', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '');

-- --------------------------------------------------------

--
-- 表的结构 `teaches`
--

CREATE TABLE `teaches` (
  `t_id` char(5) NOT NULL,
  `c_id` char(7) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `year` smallint(4) NOT NULL,
  `teaches_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teaches`
--

INSERT INTO `teaches` (`t_id`, `c_id`, `semester`, `year`, `teaches_id`) VALUES
('12345', '1234567', '2', 2016, 1),
('12348', '2345678', '2', 2016, 3),
('22222', '1234567', '1', 2015, 2),
('23456', '3456789', '2', 2016, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `enrol`
--
ALTER TABLE `enrol`
  ADD PRIMARY KEY (`enrol_id`),
  ADD UNIQUE KEY `c_id` (`c_id`,`s_id`,`t_id`,`semester`,`year`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`teaches_id`),
  ADD UNIQUE KEY `t_id` (`t_id`,`c_id`,`semester`,`year`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `enrol`
--
ALTER TABLE `enrol`
  MODIFY `enrol_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `teaches`
--
ALTER TABLE `teaches`
  MODIFY `teaches_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
