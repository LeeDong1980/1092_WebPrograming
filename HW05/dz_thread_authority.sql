-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2021 年 05 月 18 日 03:17
-- 伺服器版本： 10.3.16-MariaDB
-- PHP 版本： 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `id16582870_leedong_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dz_thread_authority`
--

CREATE TABLE `dz_thread_authority` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nickname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `root_thread_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ownerauthority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `dz_thread_authority`
--

INSERT INTO `dz_thread_authority` (`id`, `board_id`, `time`, `nickname`, `title`, `content`, `root_thread_id`, `ip`, `ownerauthority`) VALUES
(14, 2, '2021-05-18 02:32:03', 'LeeDong', 'sdddsdsd', 'asdasdas', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001),
(29, 3, '2021-05-18 02:54:40', 'LeeDong', 'dddddaaaa', 'aasassas', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001),
(30, 3, '2021-05-18 02:54:43', 'LeeDong', 'dasd', 'asdasd', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001),
(31, 1, '2021-05-18 02:56:04', 'LeeDong', 'asdad', '13123', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001),
(32, 1, '2021-05-18 02:56:07', 'LeeDong', '1231', '222', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001),
(33, 1, '2021-05-18 02:56:11', 'LeeDong', '333', '111', 0, '2402:7500:5df:2261:15eb:a8dc:ec9:7e63', 100001);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `dz_thread_authority`
--
ALTER TABLE `dz_thread_authority`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `dz_thread_authority`
--
ALTER TABLE `dz_thread_authority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
