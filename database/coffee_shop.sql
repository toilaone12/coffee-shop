-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 25, 2023 lúc 12:31 PM
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
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `fullname_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_online` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, 1, 'storage/gallery/related-a2b-1-1692958032.jpg', '2023-08-25 10:07:12', '2023-08-25 10:07:12'),
(4, 1, 'storage/gallery/share-1692958032.jpg', '2023-08-25 10:07:12', '2023-08-25 10:07:12'),
(5, 1, 'storage/gallery/home-1692958032.jpg', '2023-08-25 10:07:12', '2023-08-25 10:07:12');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2023_08_20_101033_create_supplier', 1),
(5, '2023_08_20_101549_create_admin', 1),
(6, '2023_08_21_213642_create_category', 2),
(7, '2023_08_22_215140_create_slide', 3),
(8, '2023_08_24_205413_create_product', 4),
(9, '2023_08_25_161252_create_gallery', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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
  `quantity_product` int(11) NOT NULL,
  `quantity_sold_product` int(11) DEFAULT NULL,
  `price_product` int(11) NOT NULL,
  `description_product` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_reviews_product` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id_product`, `id_category`, `image_product`, `name_product`, `subname_product`, `quantity_product`, `quantity_sold_product`, `price_product`, `description_product`, `number_reviews_product`, `created_at`, `updated_at`) VALUES
(1, 15, 'storage/product/ca-phe-den-1692888289.jpg', 'Cà phê đen', 'Black Coffee Filter', 10, NULL, 35000, '<p>Black Coffee Filter</p>', NULL, '2023-08-24 14:44:49', '2023-08-24 14:44:49');

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

--
-- Đang đổ dữ liệu cho bảng `slide`
--

INSERT INTO `slide` (`id_slide`, `image_slide`, `name_slide`, `slug_slide`, `created_at`, `updated_at`) VALUES
(2, 'storage/khaitruong-1692720174.jpg', 'ảnh khai trương', 'khai-truong', '2023-08-22 16:02:55', '2023-08-22 16:02:55'),
(3, 'storage/gioi-thieu-menu-1692805319.jpg', 'menu cua hang', 'gioi thieu menu', '2023-08-23 14:34:23', '2023-08-23 15:41:59');

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
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

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
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
