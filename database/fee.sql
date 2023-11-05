-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 04, 2023 lúc 12:57 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fee`
--

CREATE TABLE `fee` (
  `id_fee` int(10) UNSIGNED NOT NULL,
  `radius_fee` int(11) NOT NULL,
  `weather_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `fee`
--

INSERT INTO `fee` (`id_fee`, `radius_fee`, `weather_condition`, `fee`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sun', 0, '2023-09-05 08:38:48', '2023-09-05 08:38:48'),
(2, 1, 'Rain', 3000, '2023-09-05 08:39:41', '2023-09-05 08:39:41'),
(3, 3, 'Sun', 10000, '2023-09-05 08:40:09', '2023-09-05 08:40:09'),
(4, 3, 'Rain', 13000, '2023-09-05 08:40:22', '2023-09-05 08:40:22'),
(5, 5, 'Sun', 12000, '2023-09-05 08:40:38', '2023-09-05 08:40:38'),
(6, 5, 'Rain', 15000, '2023-09-05 08:40:51', '2023-09-05 08:40:51');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`id_fee`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `fee`
--
ALTER TABLE `fee`
  MODIFY `id_fee` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
