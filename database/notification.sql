-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2023 lúc 06:24 PM
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
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `id_notification` int(10) UNSIGNED NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`id_notification`, `id_account`, `id_customer`, `content`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Bạn đã thêm chức vụ Nhân viên pha chế', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 14:58:40', '2023-11-28 15:35:06'),
(2, 1, 0, 'Bạn đã sửa chức vụ Thu ngân thành Thu ngân', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 14:59:03', '2023-11-28 15:35:15'),
(3, 1, 0, 'Bạn đã sửa chức vụ Thu ngân thành Nhân viên pha chế', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 14:59:45', '2023-11-28 15:35:29'),
(4, 1, 0, 'Bạn đã thêm chức vụ Thu ngan', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:00:19', '2023-11-28 15:40:08'),
(5, 1, 0, 'Bạn đã xóa chức vụ Nhân viên pha chế', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:02:49', '2023-11-28 15:42:09'),
(6, 1, 0, 'Bạn đã thêm chức vụ \"Nhân viên pha chế\"', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:04:23', '2023-11-28 15:42:11'),
(7, 1, 0, 'Bạn đã thêm chức vụ \"Thu ngan\"', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:04:27', '2023-11-28 15:42:12'),
(8, 1, 0, 'Bạn đã xóa chức vụ \"Nhân viên pha chế\"', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:07:34', '2023-11-28 15:42:13'),
(9, 1, 0, 'Bạn đã xóa chức vụ \"Thu ngan\"', 'http://127.0.0.1:8000/admin/role/list', 1, '2023-11-28 15:07:34', '2023-11-28 15:42:15'),
(10, 1, 0, 'Bạn đã đăng ký cho tài khoản \"nga\"', 'http://127.0.0.1:8000/admin/account/list', 1, '2023-11-28 15:52:20', '2023-11-28 15:52:37'),
(11, 1, 0, 'Bạn đã cập nhật lại thông tin', 'http://127.0.0.1:8000/admin/account/setting', 1, '2023-11-28 16:35:46', '2023-11-28 16:39:27'),
(12, 1, 0, 'Bạn đã xóa tài khoản \"nga\"', 'http://127.0.0.1:8000/admin/account/list', 0, '2023-11-28 16:41:41', '2023-11-28 16:41:41'),
(13, 1, 0, 'Bạn đã thêm \"Đồ uống\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 16:45:30', '2023-11-28 16:45:30'),
(14, 1, 0, 'Bạn đã cập nhật từ \"Đồ uống\" thành \"Đồ uống\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 16:46:18', '2023-11-28 16:46:18'),
(15, 1, 0, 'Bạn đã xóa danh mục \"Đồ uống\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 16:46:30', '2023-11-28 16:46:30'),
(16, 1, 0, 'Bạn đã xóa danh mục \"Bò bít tết\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 16:46:39', '2023-11-28 16:46:39'),
(17, 1, 0, 'Bạn đã xóa danh mục \"Mì Ý\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 16:46:39', '2023-11-28 16:46:39'),
(18, 1, 0, 'Bạn đã thêm đơn vị tính \"Con\"', 'http://127.0.0.1:8000/admin/units/list', 0, '2023-11-28 17:00:20', '2023-11-28 17:00:20'),
(19, 1, 0, 'Bạn đã cập nhật đơn vị tính từ \"Con\" thành \"Conc\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 17:08:56', '2023-11-28 17:08:56'),
(20, 1, 0, 'Bạn đã xóa đơn vị tính \"Conc\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 17:09:04', '2023-11-28 17:09:04'),
(21, 1, 0, 'Bạn đã xóa đơn vị tính \"Milliliter\"', 'http://127.0.0.1:8000/admin/category/list', 0, '2023-11-28 17:09:10', '2023-11-28 17:09:10'),
(22, 1, 0, 'Bạn đã xóa đơn vị tính \"Chiếc/Cái/Cốc\"', 'http://127.0.0.1:8000/admin/category/list', 1, '2023-11-28 17:09:10', '2023-11-28 17:12:46'),
(23, 1, 0, 'Bạn đã thêm sản phẩm \"á\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:23:22', '2023-11-28 17:23:22'),
(24, 1, 0, 'Bạn đã cập nhật từ \"á\" thành \"áđá\"', 'http://127.0.0.1:8000/admin/product/list', 1, '2023-11-28 17:23:40', '2023-11-28 17:23:51'),
(25, 1, 0, 'Bạn đã xóa sản phẩm\"áđá\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:05', '2023-11-28 17:24:05'),
(26, 1, 0, 'Bạn đã xóa sản phẩm\"Cà phê đen\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(27, 1, 0, 'Bạn đã xóa sản phẩm\"Cà phê nâu\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(28, 1, 0, 'Bạn đã xóa sản phẩm\"Plain Croissant\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(29, 1, 0, 'Bạn đã xóa sản phẩm\"Cà phê Bạc xỉu\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(30, 1, 0, 'Bạn đã xóa sản phẩm\"Almond Croissant\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(31, 1, 0, 'Bạn đã xóa sản phẩm\"Ham & Cheese Croissant\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(32, 1, 0, 'Bạn đã xóa sản phẩm\"Cà phê kem béo\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(33, 1, 0, 'Bạn đã xóa sản phẩm\"Bacon & Cheese Baguette\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(34, 1, 0, 'Bạn đã xóa sản phẩm\"Charsiu Baguette\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16'),
(35, 1, 0, 'Bạn đã xóa sản phẩm\"Chocolate Croissant\"', 'http://127.0.0.1:8000/admin/product/list', 0, '2023-11-28 17:24:16', '2023-11-28 17:24:16');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notification`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notification` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
