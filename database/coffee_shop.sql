-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 05, 2023 lúc 12:03 PM
-- Phiên bản máy phục vụ: 10.4.25-MariaDB
-- Phiên bản PHP: 7.4.30

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
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id_account` int(10) UNSIGNED NOT NULL,
  `fullname_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_account` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_account` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_online` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id_account`, `fullname_account`, `username_account`, `email_account`, `password_account`, `otp_account`, `id_role`, `is_online`, `created_at`, `updated_at`) VALUES
(1, 'Kiều Đặng Bảo Sơn', 'son', 'baooson3005@gmail.com', '69b21e9c5b38d7c34449a5b290363487', 123456, 5, 1, '2023-08-27 11:08:11', '2023-09-02 16:27:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id_category` int(10) UNSIGNED NOT NULL,
  `name_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_parent_category` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id_category`, `name_category`, `id_parent_category`, `created_at`, `updated_at`) VALUES
(1, 'Cà phê & Đồ uống', 0, '2023-08-21 14:57:33', '2023-08-21 15:55:23'),
(2, 'Bánh mì & Bánh ngọt', 0, '2023-08-21 14:59:57', '2023-08-21 14:59:57'),
(3, 'Ăn sáng & Ăn trưa', 0, '2023-08-21 15:00:31', '2023-08-21 15:00:31'),
(4, 'Đồ ăn vặt', 0, '2023-08-21 15:00:49', '2023-08-21 15:00:49'),
(5, 'Bánh mì', 2, '2023-08-21 15:01:01', '2023-08-21 15:01:01'),
(6, 'Bánh ngọt', 2, '2023-08-21 15:01:25', '2023-08-21 15:01:25'),
(7, 'Bánh mì & Bánh bao', 3, '2023-08-21 15:02:12', '2023-08-21 15:02:12'),
(8, 'Salad', 3, '2023-08-21 15:02:21', '2023-08-21 15:02:21'),
(9, 'Bò bít tết', 3, '2023-08-21 15:02:28', '2023-08-21 15:02:28'),
(10, 'Mì Ý', 3, '2023-08-21 15:02:39', '2023-08-21 15:02:39'),
(11, 'Pasta', 4, '2023-08-21 16:00:50', '2023-08-21 16:00:50'),
(15, 'Cà phê phin', 1, '2023-08-24 14:34:19', '2023-08-24 14:34:19'),
(16, 'Cà phê pha máy', 1, '2023-08-24 14:34:30', '2023-08-24 14:34:30'),
(17, 'Cà phê giấy lọc', 1, '2023-08-24 14:34:39', '2023-08-24 14:34:39'),
(18, 'Cà phê ủ lạnh', 1, '2023-08-24 14:34:46', '2023-08-24 14:34:46'),
(19, 'Trà ấm', 1, '2023-08-24 14:34:53', '2023-08-24 14:34:53'),
(20, 'Trà hoa quả', 1, '2023-08-24 14:35:01', '2023-08-24 14:35:01'),
(21, 'Nước ép hoa quả', 1, '2023-08-24 14:35:11', '2023-08-24 14:35:11'),
(22, 'Sinh tố', 1, '2023-08-24 14:35:18', '2023-08-24 14:35:18'),
(23, 'Đá xay', 1, '2023-08-24 14:35:24', '2023-08-24 14:36:05'),
(24, 'Đồ uống khác', 1, '2023-08-24 14:35:39', '2023-08-24 14:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(10) UNSIGNED NOT NULL,
  `image_customer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gentle_customer` tinyint(4) NOT NULL,
  `email_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_customer` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_customer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_vip` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_notes`
--

CREATE TABLE `detail_notes` (
  `id_detail` int(10) UNSIGNED NOT NULL,
  `id_note` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `code_note` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ingredient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_ingredient` float NOT NULL,
  `price_ingredient` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `detail_notes`
--

INSERT INTO `detail_notes` (`id_detail`, `id_note`, `id_unit`, `code_note`, `name_ingredient`, `quantity_ingredient`, `price_ingredient`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'LKU1MR', 'Cà phê', 2, 66000, '2023-08-31 14:27:27', '2023-08-31 14:27:27'),
(2, 1, 1, 'LKU1MR', 'Sữa đặc Ngôi sao Phương Nam', 4, 62000, '2023-08-31 14:27:27', '2023-08-31 14:27:27'),
(15, 3, 2, 'P0OOZ3', 'Cà phê bột Trung Nguyên loại I', 680, 58000, '2023-09-03 14:14:40', '2023-09-03 14:14:40'),
(16, 3, 1, 'P0OOZ3', 'Sữa đặc Ngôi sao Phương Nam', 4, 62000, '2023-09-03 14:14:40', '2023-09-03 14:14:40'),
(17, 3, 5, 'P0OOZ3', 'Plain Croissant', 5, 28000, '2023-09-03 14:14:40', '2023-09-03 14:14:40'),
(18, 4, 2, 'MTAGIO', 'Sữa đặc Ngôi sao Phương Nam', 2448, 62000, '2023-09-03 14:46:59', '2023-09-03 14:46:59'),
(19, 4, 1, 'MTAGIO', 'Cà phê bột Trung Nguyên loại I', 0.68, 58000, '2023-09-03 14:46:59', '2023-09-03 14:46:59'),
(20, 4, 1, 'MTAGIO', 'Sữa đặc Ngôi sao Phương Nam', 3.6, 62000, '2023-09-03 15:09:16', '2023-09-03 15:09:16');

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` int(10) UNSIGNED NOT NULL,
  `id_product` int(11) NOT NULL,
  `image_gallery` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_product`, `image_gallery`, `created_at`, `updated_at`) VALUES
(3, 1, 'storage/gallery/banner-utt-1693024246.jpg', '2023-08-25 10:07:12', '2023-08-26 04:30:47'),
(5, 1, 'storage/gallery/capture-1693024260.jpg', '2023-08-25 10:07:12', '2023-08-26 04:31:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ingredients`
--

CREATE TABLE `ingredients` (
  `id_ingredient` int(20) UNSIGNED NOT NULL,
  `id_unit` int(50) NOT NULL,
  `name_ingredient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_ingredient` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ingredients`
--

INSERT INTO `ingredients` (`id_ingredient`, `id_unit`, `name_ingredient`, `quantity_ingredient`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cà phê', 2000, '2023-09-03 10:49:36', '2023-09-03 16:17:02'),
(2, 1, 'Sữa đặc Ngôi sao Phương Nam', 14.048, '2023-09-03 10:49:36', '2023-09-03 15:10:41'),
(3, 2, 'Cà phê bột Trung Nguyên loại I', 2040, '2023-09-03 14:15:16', '2023-09-03 15:10:41'),
(4, 5, 'Plain Croissant', 5, '2023-09-03 14:24:01', '2023-09-03 14:24:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_09_05_104614_create_order', 1),
(2, '2023_09_05_105352_create_payment', 2),
(3, '2023_09_05_105352_create_fee', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notes`
--

CREATE TABLE `notes` (
  `id_note` int(10) UNSIGNED NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `code_note` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_note` int(11) NOT NULL,
  `status_note` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notes`
--

INSERT INTO `notes` (`id_note`, `id_supplier`, `code_note`, `name_note`, `quantity_note`, `status_note`, `created_at`, `updated_at`) VALUES
(1, 3, 'LKU1MR', 'Phiếu ngày 31/08/2023', 2, 1, '2023-08-31 14:27:27', '2023-09-03 10:49:36'),
(3, 3, 'P0OOZ3', 'Phiếu ngày 03/09/2023', 3, 1, '2023-09-03 14:14:40', '2023-09-03 14:24:01'),
(4, 2, 'MTAGIO', 'Phiếu ngày 03/09/2023', 3, 1, '2023-09-03 14:46:59', '2023-09-03 15:10:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_payment` int(11) NOT NULL,
  `code_order` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_order` int(11) NOT NULL,
  `status_order` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id_product` int(10) UNSIGNED NOT NULL,
  `id_category` int(11) NOT NULL,
  `image_product` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subname_product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_product` int(11) NOT NULL,
  `description_product` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_reviews_product` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id_product`, `id_category`, `image_product`, `name_product`, `subname_product`, `price_product`, `description_product`, `number_reviews_product`, `created_at`, `updated_at`) VALUES
(1, 15, 'storage/product/ca-phe-den-1692888289.jpg', 'Cà phê đen', 'Black Coffee Filter', 35000, '<p>Black Coffee Filter</p>', NULL, '2023-08-24 14:44:49', '2023-08-24 14:44:49'),
(3, 15, 'storage/product/ca-phe-nau-1693817752.jpg', 'Cà phê nâu', 'Milk Coffee Filter', 35000, '<p>Milk Coffee Filter</p>', NULL, '2023-09-04 08:55:54', '2023-09-04 08:55:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recipe`
--

CREATE TABLE `recipe` (
  `id_recipe` int(10) UNSIGNED NOT NULL,
  `id_product` int(11) NOT NULL,
  `component_recipe` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `recipe`
--

INSERT INTO `recipe` (`id_recipe`, `id_product`, `component_recipe`, `created_at`, `updated_at`) VALUES
(1, 3, '[{\"id_ingredient\":\"2\",\"id_unit\":\"2\",\"quantity_recipe_need\":\"20\"},{\"id_ingredient\":\"3\",\"id_unit\":\"2\",\"quantity_recipe_need\":\"20\"}]', '2023-09-04 09:57:58', '2023-09-04 09:57:58'),
(3, 1, '[{\"id_ingredient\":\"3\",\"id_unit\":\"2\",\"quantity_recipe_need\":\"25\"}]', '2023-09-04 15:54:29', '2023-09-04 15:54:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id_role` int(10) UNSIGNED NOT NULL,
  `name_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id_role`, `name_role`, `created_at`, `updated_at`) VALUES
(5, 'Quản lý', '2023-08-29 15:23:03', '2023-08-29 15:23:03'),
(7, 'Nhân viên bán hàng', '2023-08-29 15:39:48', '2023-08-29 15:39:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slide`
--

CREATE TABLE `slide` (
  `id_slide` int(10) UNSIGNED NOT NULL,
  `image_slide` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_slide` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_slide` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(10) UNSIGNED NOT NULL,
  `name_supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_supplier` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `name_supplier`, `phone_supplier`, `address_supplier`, `created_at`, `updated_at`) VALUES
(2, 'Thái Công', '0387221123', 'Thành Phố Hồ Chí Minh', '2023-08-20 08:18:35', '2023-08-20 08:18:35'),
(3, 'WinEco', '0399123331', 'Thành Phố Hồ Chí Minh', '2023-08-20 17:26:31', '2023-08-20 17:26:31'),
(4, 'asdsad', '0387221124', 'asdasdasd', '2023-08-23 15:43:09', '2023-08-23 15:48:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `units`
--

CREATE TABLE `units` (
  `id_unit` int(10) UNSIGNED NOT NULL,
  `fullname_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `units`
--

INSERT INTO `units` (`id_unit`, `fullname_unit`, `abbreviation_unit`, `created_at`, `updated_at`) VALUES
(1, 'Kilogram', 'Kg', '2023-08-30 09:55:42', '2023-08-30 09:55:42'),
(2, 'Gram', 'g', '2023-08-30 09:56:02', '2023-08-30 09:56:02'),
(3, 'Liter', 'l', '2023-08-30 09:56:10', '2023-08-30 09:56:10'),
(4, 'Milliliter', 'ml', '2023-08-30 09:56:17', '2023-08-30 09:56:17'),
(5, 'Chiếc/Cái/Cốc', 'c', '2023-08-30 09:56:40', '2023-08-30 10:13:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_account`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Chỉ mục cho bảng `detail_notes`
--
ALTER TABLE `detail_notes`
  ADD PRIMARY KEY (`id_detail`);

--
-- Chỉ mục cho bảng `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`id_fee`);

--
-- Chỉ mục cho bảng `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Chỉ mục cho bảng `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id_ingredient`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id_note`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Chỉ mục cho bảng `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id_recipe`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Chỉ mục cho bảng `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id_slide`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Chỉ mục cho bảng `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id_unit`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id_account` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `detail_notes`
--
ALTER TABLE `detail_notes`
  MODIFY `id_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `fee`
--
ALTER TABLE `fee`
  MODIFY `id_fee` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id_ingredient` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `notes`
--
ALTER TABLE `notes`
  MODIFY `id_note` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id_recipe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `slide`
--
ALTER TABLE `slide`
  MODIFY `id_slide` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
