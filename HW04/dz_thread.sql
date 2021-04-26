-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 04 月 26 日 20:46
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
-- 資料表結構 `dz_thread`
--

CREATE TABLE `dz_thread` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nickname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `content` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `root_thread_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `dz_thread`
--

INSERT INTO `dz_thread` (`id`, `board_id`, `time`, `nickname`, `title`, `content`, `root_thread_id`, `ip`) VALUES
(94, 1, '2021-04-26 20:30:55', 'LeeDong', 'asdasda', 'aaaaasdsadas', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(95, 2, '2021-04-26 20:31:59', 'popo', 'asdasd', 'aaaasdddddd', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(96, 0, '2021-04-26 20:32:08', 'popo', NULL, 'asadddada', 94, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(97, 2, '2021-04-26 20:44:45', 'LeeDong', 'asdsddddddd', 'asdqqweqweqw', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(98, 0, '2021-04-26 20:44:50', 'LeeDong', NULL, 'qweqweq', 97, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(99, 0, '2021-04-26 20:44:53', 'LeeDong', NULL, 'deadqweqe', 97, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(100, 3, '2021-04-26 20:45:16', 'Kerifosa', 'qweqwesdada', 'asdasda', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(101, 3, '2021-04-26 20:45:20', 'Kerifosa', 'asdada', 'aasda', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(102, 0, '2021-04-26 20:45:39', 'Takasila', NULL, 'ssdadad', 101, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(103, 0, '2021-04-26 20:45:41', 'Takasila', NULL, 'asdadda', 101, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038'),
(104, 2, '2021-04-26 20:45:55', 'Takasila', 'asdasda', 'eeeeeee', 0, '2402:7500:4d1:3b59:f89e:fdf3:9f39:4038');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `dz_thread`
--
ALTER TABLE `dz_thread`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `dz_thread`
--
ALTER TABLE `dz_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
