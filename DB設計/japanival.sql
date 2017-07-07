-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 7 月 07 日 14:25
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `japanival`
--
CREATE DATABASE IF NOT EXISTS `japanival` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `japanival`;

-- --------------------------------------------------------

--
-- テーブルの構造 `caht_rooms`
--

CREATE TABLE `caht_rooms` (
  `chat_room_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `accept_user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `e_name` int(255) NOT NULL,
  `e_start_date` date NOT NULL,
  `e_end_date` date NOT NULL,
  `e_prefecture` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_postal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_venue` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_access` text CHARACTER SET utf8 NOT NULL,
  `e_o_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_o_tel` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_o_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `explanation` text CHARACTER SET utf8 NOT NULL,
  `priority` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `start_year` int(11) NOT NULL,
  `year_p` int(11) DEFAULT NULL,
  `year_pp` int(11) DEFAULT NULL,
  `year_ppp` int(11) DEFAULT NULL,
  `attendance_p` int(11) DEFAULT NULL,
  `attendance_pp` int(11) DEFAULT NULL,
  `attendance_ppp` int(11) DEFAULT NULL,
  `official_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `related_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`event_id`, `o_id`, `e_name`, `e_start_date`, `e_end_date`, `e_prefecture`, `e_postal`, `e_address`, `e_venue`, `e_access`, `e_o_name`, `e_o_tel`, `e_o_email`, `explanation`, `priority`, `start_year`, `year_p`, `year_pp`, `year_ppp`, `attendance_p`, `attendance_pp`, `attendance_ppp`, `official_url`, `related_url`, `created`, `modified`) VALUES
(0, 0, 0, '0000-00-00', '0000-00-00', '東京都', '1700002', '豊島区', 'ラーメン', '', 'うめ', '000', 'uuu', '説明文です', NULL, 2001, 0, 0, 0, 0, 0, 0, '', '', '2017-07-01 22:16:39', '2017-07-01 14:16:39'),
(0, 0, 0, '2017-06-12', '2017-06-13', '千葉', '111-1111', '千葉市', '千葉', '', 'いいい', '0000-999', 'kjkjlj', '説明文です', NULL, 1999, 0, 0, 0, 0, 0, 0, '', '', '2017-07-01 22:41:55', '2017-07-01 14:41:55'),
(0, 0, 0, '2017-06-12', '2017-06-13', '千葉', '111-1111', '千葉市', '千葉', '', 'いいい', '0000-999', 'kjkjlj', '説明文です', NULL, 1999, 0, 0, 0, 0, 0, 0, '', '', '2017-07-02 12:10:51', '2017-07-02 04:10:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `event_categories`
--

CREATE TABLE `event_categories` (
  `e_category_Id` int(11) NOT NULL,
  `e_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `event_categories`
--

INSERT INTO `event_categories` (`e_category_Id`, `e_category`) VALUES
(1, 'spring'),
(2, 'summer'),
(3, 'fall'),
(4, 'winter'),
(5, 'flower'),
(6, 'sakura'),
(7, 'food_drink'),
(8, 'alcohol'),
(9, 'strange_festival'),
(10, '50years_lasting'),
(11, '100years_lasting');

-- --------------------------------------------------------

--
-- テーブルの構造 `event_connects`
--

CREATE TABLE `event_connects` (
  `e_category_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `event_movies`
--

CREATE TABLE `event_movies` (
  `e_movie_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `e_mov_url` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `event_pics`
--

CREATE TABLE `event_pics` (
  `e_pic_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `e_pic_path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `event_pics`
--

INSERT INTO `event_pics` (`e_pic_id`, `event_id`, `e_pic_path`, `created`) VALUES
(1, 0, '20170701154558スクリーンショット 2017-07-01 20.46.45.png', '2017-07-01 22:16:39'),
(2, 0, '20170701164151スクリーンショット 2017-07-01 22.41.39.png', '2017-07-01 22:41:55'),
(3, 0, '20170702061044スクリーンショット 2017-07-01 22.41.39.png', '2017-07-02 12:10:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `joins`
--

CREATE TABLE `joins` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `read_flag` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `news_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `news_comment` text CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `notification_user_id` int(11) NOT NULL,
  `notification_category_id` int(11) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- テーブルの構造 `notification_categories`
--

CREATE TABLE `notification_categories` (
  `notification_category_id` int(11) NOT NULL,
  `notification_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `notification_categories`
--

INSERT INTO `notification_categories` (`notification_category_id`, `notification_category`) VALUES
(1, 'message'),
(2, 'like'),
(3, 'review');

-- --------------------------------------------------------

--
-- テーブルの構造 `organizers`
--

CREATE TABLE `organizers` (
  `o_id` int(11) NOT NULL,
  `o_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_f_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_l_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_pref` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_postal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_tel` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_intro` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `o_pic` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `organizers`
--

INSERT INTO `organizers` (`o_id`, `o_name`, `o_f_name`, `o_l_name`, `o_email`, `o_pref`, `o_postal`, `o_address`, `o_tel`, `o_password`, `o_intro`, `o_pic`, `created`, `modified`) VALUES
(1, 'umetani', 'umetani', '', 'umetani@gmail.com', '東京都', '1700002', '豊島区巣鴨', '09050896307', '56ca78f2319ab20ed3c881bb89f02d608111bb69', '', '20170704145241japanival_logo_red_black_cropped (1).png', '2017-07-04 20:52:41', '2017-07-04 12:52:41'),
(2, 'yumetani', 'yumetani', '', 'yumetani@gmail.com', '東京都', '1700002', '豊島区巣鴨', '09050896307', 'ff594fca1a4bc1ad86f227c2bf9df5210c5a8a1e', '', '20170704145834スクリーンショット 2017-07-01 20.46.45.png', '2017-07-04 20:58:34', '2017-07-04 12:58:34');

-- --------------------------------------------------------

--
-- テーブルの構造 `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `request_category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- テーブルの構造 `request_categories`
--

CREATE TABLE `request_categories` (
  `request_category_id` int(11) NOT NULL,
  `request_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- テーブルのデータのダンプ `request_categories`
--

INSERT INTO `request_categories` (`request_category_id`, `request_category`) VALUES
(1, 'inquiry'),
(2, 'navigation'),
(3, 'accompany');

-- --------------------------------------------------------

--
-- テーブルの構造 `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `review_photos`
--

CREATE TABLE `review_photos` (
  `review_pic_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `review_pic_path` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_flag` int(11) NOT NULL,
  `f_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `l_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nationality` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `self_intro` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pic_path` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `user_flag`, `f_name`, `l_name`, `nickname`, `email`, `nationality`, `gender`, `password`, `self_intro`, `pic_path`, `created`, `modified`) VALUES
(1, 0, '', '', 'manager', 'manager@gmail.com', 'Afganistan', 'male', '1a8565a9dc72048ba03b4156be3e569f22771f23', '管理者です。', '20170705130810japanival_icon.png', '2017-07-05 19:08:10', '2017-07-05 11:08:39'),
(2, 1, '', '', 'umetani', 'umetani@gmail.com', 'Albania', 'female', '56ca78f2319ab20ed3c881bb89f02d608111bb69', 'umetani', '20170705130941スクリーンショット 2017-07-03 18.41.01.png', '2017-07-05 19:09:41', '2017-07-05 11:09:41'),
(3, 1, '', '', 'uumetani', 'uumetani@gmail.com', 'Afganistan', 'male', '4a9318160a56a36c151476167f282968c8de6b74', 'ユーザーです', '20170705140040japanival_icon.png', '2017-07-05 20:00:40', '2017-07-05 12:00:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caht_rooms`
--
ALTER TABLE `caht_rooms`
  ADD PRIMARY KEY (`chat_room_id`);

--
-- Indexes for table `event_movies`
--
ALTER TABLE `event_movies`
  ADD PRIMARY KEY (`e_movie_id`);

--
-- Indexes for table `event_pics`
--
ALTER TABLE `event_pics`
  ADD PRIMARY KEY (`e_pic_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_categories`
--
ALTER TABLE `notification_categories`
  ADD PRIMARY KEY (`notification_category_id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_photos`
--
ALTER TABLE `review_photos`
  ADD PRIMARY KEY (`review_pic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caht_rooms`
--
ALTER TABLE `caht_rooms`
  MODIFY `chat_room_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_movies`
--
ALTER TABLE `event_movies`
  MODIFY `e_movie_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_pics`
--
ALTER TABLE `event_pics`
  MODIFY `e_pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification_categories`
--
ALTER TABLE `notification_categories`
  MODIFY `notification_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `review_photos`
--
ALTER TABLE `review_photos`
  MODIFY `review_pic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
