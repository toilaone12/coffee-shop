-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 17, 2023 lúc 06:11 PM
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
-- Cấu trúc bảng cho bảng `coupon`
--

CREATE TABLE `coupon` (
  `id_coupon` int(10) UNSIGNED NOT NULL,
  `name_coupon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_coupon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_coupon` int(11) NOT NULL,
  `type_coupon` tinyint(4) NOT NULL,
  `discount_coupon` int(11) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `is_buy` int(11) DEFAULT NULL,
  `is_price` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon`
--

INSERT INTO `coupon` (`id_coupon`, `name_coupon`, `code_coupon`, `quantity_coupon`, `type_coupon`, `discount_coupon`, `expiration_time`, `is_buy`, `is_price`, `created_at`, `updated_at`) VALUES
(1, 'Mã khuyến mãi cho người mua lần đầu', 'FIRSTBUY15', 1000, 1, 15000, '2062-12-30 09:45:00', 1, NULL, '2023-09-06 03:13:35', '2023-09-06 08:05:04'),
(2, 'Mã khuyến mãi cho người mua 3 sản phẩm trở lên', 'OVER3PRODUCT', 10000, 0, 20, '2024-12-06 10:20:00', 0, 0, '2023-09-06 03:20:47', '2023-09-06 03:20:47'),
(3, 'Mã giảm giá tháng 10', 'COUPONT10', 50, 1, 15000, '2023-10-31 23:59:00', 0, 100000, '2023-09-06 04:59:12', '2023-09-06 04:59:12');

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
(3, '2023_09_05_105352_create_fee', 3),
(4, '2023_09_05_223339_create_coupon', 4),
(5, '2023_09_06_154812_create_review', 5),
(6, '2023_09_11_142633_create_news', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id_new` int(10) UNSIGNED NOT NULL,
  `image_new` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_new` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_new` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle_new` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_new` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_new` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id_new`, `image_new`, `title_new`, `slug_new`, `subtitle_new`, `content_new`, `view_new`, `created_at`, `updated_at`) VALUES
(4, 'storage/news/3-mo-hinh-kinh-doanh-ca-phe-take-away-pho-bien-hien-nay-1694942318.jpg', '3 MÔ HÌNH KINH DOANH CÀ PHÊ TAKE AWAY PHỔ BIẾN HIỆN NAY', '3-mo-hinh-kinh-doanh-ca-phe-take-away-pho-bien-hien-nay', 'Bạn đang băn khoăn không biết nên lựa chọn mô hình nào để kinh doanh cà phê take away? Hãy tham khảo những đặc điểm nổi bật của mô hình quán cafe take away dưới đây, Harper 7 Coffee tin việc đưa ra quyết định lựa chọn của bạn sẽ dễ dàng hơn rất nhiều.', '<p>Bạn đang băn khoăn không biết nên lựa chọn mô hình nào để kinh doanh cà phê take away? Hãy tham khảo những đặc điểm nổi bật của&nbsp;<strong>mô hình quán cafe take away&nbsp;</strong>dưới đây, Harper 7 Coffee&nbsp;tin việc đưa ra quyết định lựa chọn của bạn sẽ dễ dàng hơn rất nhiều.</p>\r\n\r\n<p>Kinh doanh cafe take away là hình thức kinh doanh cần ít vốn đầu tư, dễ sinh lời. Tuy vậy để kinh doanh hiệu quả, bạn cần nắm vững và chuẩn bị tốt các bước cần thiết trước khi triển khai. Bài viết 13 Bước để mở quán&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-take-away\">cafe take away</a>&nbsp;thành công của Bonjour Coffee sẽ giúp ích cho bạn.</p>\r\n\r\n<p><strong>MỤC LỤC</strong></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/mo-hinh-quan-cafe-take-away/#Mo_hinh_xe_ca_phe_take_away_duong_pho\">1.&nbsp;Mô hình xe cà phê take away đường phố</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/mo-hinh-quan-cafe-take-away/#Mo_hinh_quan_cafe_take_away\">2.&nbsp;Mô hình quán cafe take away</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/mo-hinh-quan-cafe-take-away/#Mo_hinh_quan_cafe_take_away_nhuong_quyen\">3.&nbsp;Mô hình quán cafe take away nhượng quyền</a></p>\r\n\r\n<h2><strong>Mô hình xe cà phê take away đường phố</strong></h2>\r\n\r\n<p>Một trong các mô hình quán cà phê take away phổ biến trên thị trường hiện nay chính là kinh doanh xe cà phê. Điều gì ở mô hình này có thể khiến nó trở nên hấp dẫn như vậy?</p>\r\n\r\n<h3><strong>Xe cafe take away đường phố là gì?</strong></h3>\r\n\r\n<p>Đây được xem là mô hình kinh doanh cà phê take away thể hiện rõ bản chất của cà phê mang đi nhất hiện nay. “Quán” cà phê của mô hình này chỉ đơn giản là một chiếc xe nhỏ gọn với đầy đủ các dụng cụ và nguyên liệu pha chế. Xe cà phê take away có thể đứng bán ở nhiều vị trí khác nhau như:lề đường, góc phố…</p>\r\n\r\n<p><img alt=\"mô hình xe cà phê take away\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-xe-ca-phe-mang-di.jpg\" style=\"height: 680px; width: 680px;\"></p>\r\n\r\n<p>Mô hình xe cà phê mang đi nhiều cơ động, chi phí đầu tư vừa phải.</p>\r\n\r\n<h3><strong>Ưu, nhược điểm khi kinh doanh xe cà phê take away</strong></h3>\r\n\r\n<p>Hiện nay, hoạt động kinh doanh xe cà phê take away đang có một số ưu và nhược điểm mà bạn cần phải lưu ý trước khi quyết định lựa chọn.</p>\r\n\r\n<p><strong><em>Ưu điểm</em></strong></p>\r\n\r\n<ul>\r\n	<li>Trong&nbsp;<strong>các mô hình quán cafe take away&nbsp;</strong>thì đây được xem là hoạt động kinh doanh cần ít vốn nhất.</li>\r\n	<li>Đây cũng là mô hình kinh doanh cà phê không phải tốn chi phí thuê mặt bằng và không cần cả việc đầu tư bàn ghế hay các trang thiết bị hiện đại.</li>\r\n	<li>Giá thành rẻ, dễ “lấy lòng” được nhiều đối tượng khách hàng, nhất là những người có thu nhập thấp như: công nhân, sinh viên,…</li>\r\n	<li>Với một chiếc xe nhỏ gọn, bạn có thể di chuyển đến mọi nơi mà mình muốn để tiếp cận khách hàng được dễ hơn. Từ đó, nó có thể giúp việc kinh doanh trở nên thuận lợi hơn.</li>\r\n	<li>Mô hình này có thể đáp ứng được yêu cầu tiện lợi, nhanh gọn mà khách hàng yêu cầu trong việc cung cấp thức uống.</li>\r\n</ul>\r\n\r\n<p><img alt=\"Mô hình xe cà phê mang đi\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-xe-ca-phe-take-away.jpg\" style=\"height: 480px; width: 680px;\"></p>\r\n\r\n<p>Nếu chọn kinh doanh cà phê bằng xe take away, bạn nên chú ý khâu thiết kế tiện lợi, thu hút.</p>\r\n\r\n<p><strong><em>Nhược điểm</em></strong></p>\r\n\r\n<ul>\r\n	<li>Hoạt động kinh doanh xe cà phê take away sẽ gặp khó khăn trong những ngày thời tiết không tốt, đặc biệt là mưa.</li>\r\n	<li>Việc pha chế ngay tại chỗ, ở nơi đông xe, đông người có thể khiến khách hàng e ngại về vấn đề an toàn vệ sinh thực phẩm.</li>\r\n</ul>\r\n\r\n<h2><strong>Mô hình quán cafe&nbsp;take away</strong></h2>\r\n\r\n<h3><strong>Quán cà phê take away là gì?</strong></h3>\r\n\r\n<p>Thực tế thì mô hình quán cà phê take away cũng gần giống với những quán cà phê truyền thống khác. Điểm khác biệt cơ bản nhất là diện tích của các quán này nhỏ hơn và nhiều quán cũng không bày trí bàn ghế phục vụ khách tại chỗ mà chỉ đáp ứng nhu cầu mang đi của khách hàng.</p>\r\n\r\n<p><img alt=\"Mô hình quán cà phê take away\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-quan-cafe-mang-di.jpg\" style=\"height: 509px; width: 680px;\"></p>\r\n\r\n<p>Lựa chọn mô hình quán cà phê khi bạn có nguồn vốn và đối tượng khách ổn định.</p>\r\n\r\n<h3><strong>Ưu, nhược điểm khi kinh doanh theo mô hình quán cafe take away</strong></h3>\r\n\r\n<p><strong><em>Ưu điểm</em></strong></p>\r\n\r\n<ul>\r\n	<li>Mô hình này mang đến sự phục vụ tiện lợi, nhanh chóng đến khách hàng, nhất là những khách hàng bận rộn.</li>\r\n	<li>Thiết kế quán cà phê rất bắt mắt giúp tăng khả năng hút khách một cách hiệu quả.</li>\r\n	<li>So với mô hình xe cà phê take away thì mô hình quán sẽ thể hiện được tính chuyên nghiệp và giúp khách hàng có sự yên tâm hơn về chất lượng.</li>\r\n	<li>Khách hàng sẽ có không gian để ngồi trò chuyện hay để xe trong lúc chờ pha chế thức uống.</li>\r\n</ul>\r\n\r\n<p><img alt=\"Mô hình quán cà phê mang đi\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-quan-cafe-take-away.jpg\" style=\"height: 900px; width: 600px;\"></p>\r\n\r\n<p>Nên thiết kế quán có phong cách phù hợp đối tượng khách hàng.</p>\r\n\r\n<p><strong><em>Nhược điểm</em></strong></p>\r\n\r\n<ul>\r\n	<li>Đây là mô hình cần bỏ ra nhiều công sức nhất trong&nbsp;<strong>các mô hình quán cafe take away&nbsp;</strong>hiện nay. Bạn phải tự mình bỏ vốn, tìm mặt bằng, thiết kế quán, gây dựng thương hiệu, tìm đối tượng khách hàng phù hợp.</li>\r\n	<li>Chi phí khá lớn nên bạn cần phải cân nhắc trước khi lựa chọn.</li>\r\n	<li>Ngoài việc quản lý quán thì bạn còn cần phải biết cách quản lý và tuyển nhân viên để đảm bảo việc kinh doanh không gặp quá nhiều khó khăn.</li>\r\n</ul>\r\n\r\n<h2><strong>Mô hình quán cafe take away nhượng quyền&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;</h2>\r\n\r\n<h3><strong>Cà phê take away nhượng quyền là gì?</strong></h3>\r\n\r\n<p>Cà phê nhượng quyền là hình thức kinh doanh cà phê bằng cách mua lại thương hiệu đã được gây dựng sẵn trên thị trường. Khi đó, người chủ quán cần đảm bảo tuân thủ các điều kiện về cách pha chế, phong cách thiết kế quán, vị trí kinh doanh, diện tích quán,… theo yêu cầu của thương hiệu nhượng quyền.</p>\r\n\r\n<p><img alt=\"Mô hình cà phê take away nhượng quyền.\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-kinh-daonh-ca-phe-nhuong-quyen.jpg\" style=\"height: 449px; width: 680px;\"></p>\r\n\r\n<p>Kinh doanh theo mô hình quán cà phê take away nhượng quyền bạn tận dụng được uy tín thương hiệu.</p>\r\n\r\n<h3><strong>Ưu, nhược điểm khi kinh doanh cafe take away nhượng quyền</strong></h3>\r\n\r\n<p><strong><em>Ưu điểm</em></strong></p>\r\n\r\n<p>Lý do khiến cà phê nhượng quyền là một trong các mô hình quán cafe take away được ưa chuộng nhất hiện nay chính là nó có nhiều ưu điểm rất vượt trội như:</p>\r\n\r\n<ul>\r\n	<li>Mô hình này sẽ giảm thiểu những rủi ro phát sinh trong việc: tìm ý tưởng kinh doanh, xác định đối tượng khách.</li>\r\n	<li>Không tốn thời gian gây dựng thương hiệu và có sẵn một lượng khách hàng đông đảo của thương hiệu cà phê được nhượng quyền.</li>\r\n	<li>Tiết kiệm chi phí quảng cáo.</li>\r\n	<li>Được mua nguyên liệu chất lượng với giá tốt do bên nhượng quyền hỗ trợ.</li>\r\n	<li>Không cần phải đau đầu với ý tưởng thiết kế, trang trí quán hay lên menu của quán vì tất cả đã có thương hiệu nhượng quyền lo.</li>\r\n</ul>\r\n\r\n<p><img alt=\"Quán cafe take away nhượng quyền\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/08/Mo-hinh-cafe-take-away-nhuong-quyen.jpg\" style=\"height: 436px; width: 680px;\"></p>\r\n\r\n<p>Bạn cần chuẩn bị nguồn kinh phí đủ lớn để có thể mua nhượng quyền các thương hiệu cà phê lớn.</p>\r\n\r\n<p><strong><em>Nhược điểm</em></strong></p>\r\n\r\n<ul>\r\n	<li>Hoạt động kinh doanh quán cà phê take away của bạn sẽ bị hạn chế về tính sáng tạo cũng như menu thức uống không thể thay đổi theo ý tưởng của bạn.</li>\r\n	<li>Chi phí đầu tư và mua thương hiệu cao nên bạn sẽ phải chịu áp lực kinh tế khá lớn.</li>\r\n</ul>\r\n\r\n<p>Trên đây là thông tin về ưu, nhược điểm của mô hình quán cafe take away mà bạn có thể lựa chọn khi “dấn thân” vào thị trường này. Nghiên cứu kỹ để tìm ra mô hình phù hợp với điều kiện kinh doanh của bạn. Chúc bạn thành công.</p>', 0, '2023-09-17 09:18:39', '2023-09-17 14:42:37'),
(5, 'storage/news/ca-phe-arabica-nguon-goc-dac-diem-huong-vi-1694942482.jpg', 'CÀ PHÊ ARABICA – NGUỒN GỐC, ĐẶC ĐIỂM, HƯƠNG VỊ', 'ca-phe-arabica-nguon-goc-dac-diem-huong-vi', 'Nhắc đến cà phê Arabica người ta nghĩ ngay đến dòng cà phê với hương trái cây tự nhiên, hương hoa, vị mật ong, thể chất cân bằng và hậu vị ngọt. Vậy Arabica bắt nguồn từ đâu, đặc điểm của dòng cà phê này như thế nào sẽ được Bonjour Coffee trình bày trong bài viết sau đây.', '<p><img alt=\"Cà phê Arabica – Nguồn gốc, đặc điểm, hương vị\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/ca-phe-Arabica.jpg\" style=\"height:600px; width:900px\" /></p>\r\n\r\n<p>Nhắc đến cà phê Arabica người ta nghĩ ngay đến dòng cà phê với hương trái cây tự nhiên, hương hoa, vị mật ong, thể chất cân bằng và hậu vị ngọt. Vậy Arabica bắt nguồn từ đâu, đặc điểm của dòng cà phê này như thế nào sẽ được Bonjour Coffee trình bày trong bài viết sau đây.</p>\r\n\r\n<p>Bên cạnh đó, để hiểu hơn về cà phê, bạn có thể tham khảo bài viết&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe/\">tổng quan kiến thức cà phê</a>. Đây là bài viết tóm tắt thông tin cơ bản, tuy nhiên nó là cơ sở cho các bạn bắt đầu tìm hiểu về cà phê.</p>\r\n\r\n<p><strong>MỤC LỤC (Click để đọc nhanh)</strong>&nbsp;&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#\">Ẩn</a>&nbsp;</p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#So_luoc_ve_dong_Arabica\">1.&nbsp;Sơ lược về dòng Arabica</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Nguon_goc_lich_su_Arabica\">2.&nbsp;Nguồn gốc lịch sử Arabica</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Dac_diem_sinh_hoc_cay_ca_phe_Arabica\">3.&nbsp;Đặc điểm sinh học cây cà phê Arabica</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Cac_dong_cafe_Arabica_pho_bien\">4.&nbsp;Các dòng cafe Arabica phổ biến</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Vung_trong_Arabica_tren_the_gioi\">5.&nbsp;Vùng trồng Arabica trên thế giới</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Vung_trong_Arabica_o_Viet_Nam\">6.&nbsp;Vùng trồng Arabica ở Việt Nam</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Dac_diem_huong_vi_ca_phe_Arabica\">7.&nbsp;Đặc điểm hương vị cà phê Arabica</a></p>\r\n\r\n<p><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/#Thuong_thuc_ca_phe_Arabica\">8.&nbsp;Thưởng thức cà phê Arabica</a></p>\r\n\r\n<h2><strong>Sơ lược về dòng Arabica</strong></h2>\r\n\r\n<p>Cà phê Arabica có tên khoa học là Coffea Arabica. Ở Việt Nam dòng cafe có tên gọi khác là cà phê Chè. Arabica có hương vị phong phú, chua thanh, vị trái cây, hậu vị ngọt và thể chất cân bằng. Thành phần caffeine trong hạt cà phê này chỉ chiếm từ 1 – 2 %, thấp hơn nhiều so với Robusta.</p>\r\n\r\n<p><img alt=\"Arabica là gì\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/Arabica-la-gi.jpeg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cà phê Arabica còn có tên gọi khác là cà phê Chè.</p>\r\n\r\n<h2><strong>Nguồn gốc lịch sử Arabica</strong></h2>\r\n\r\n<p>Cái tên Arabica có nguồn gốc xa xôi từ bán đảo Arabica Peninsula tại Ả Rập. Nhiều câu chuyện kể lại rằng, loại cafe này xuất hiện lần đầu tiên tại Ethiopia của Châu Phi. Sau khi du nhập vào bán đảo Arabica của Ả Rập đã được xem là một thức uống bí truyền. Vì thế, bán đảo này đã dần được biết đến là nơi độc quyền về cafe Arabica. Có thể, cũng vì thực tế này mà tên gọi của hạt cà phê này được lấy theo tên của bán đảo Ả Rập.</p>\r\n\r\n<p>Cây cà phê Arabica được trồng đầu tiên bởi những người Ả Rập từ thế kỷ 14. Tuy vậy, đến thế kỷ thứ 17 – thế kỷ 18, giống cà phê này đã được phổ biến nhiều nơi. Cho đến nay,&nbsp;<strong>Arabica</strong>&nbsp;chiếm đến 70% sản lượng cafe trên toàn thế giới.</p>\r\n\r\n<h2><strong>Đặc điểm sinh học cây cà phê Arabica</strong></h2>\r\n\r\n<p>Arabica sinh trưởng tốt tại độ cao 900 – 2000m so với mực nước biển, lượng mưa 1,500-2,500mm/năm, nhiệt độ thích hợp từ 15- 25 độ C. Arabica có tán cây nhỏ, lá có hình dạng oval và màu xanh đậm, quả cà phê có hình bầu dục. Khi trưởng thành, cây có thể đạt độ cao từ 2,5m – 4,5m. Thậm chí, có nhiều cây mọc trong điều kiện hoang dã có thể đạt tới chiều cao 10m.</p>\r\n\r\n<p>Cà phê Arabica có giá trị kinh tế cao nhưng khó trồng và chăm sóc, năng suất thấp, khả năng chống chịu sâu bệnh kém. Thời gian thu hoạch thường là từ 3 – 4 năm sau khi trồng. Arabica có tuổi thọ khoảng 25 năm tuổi. Ở điều kiện tự nhiên, cây cà phê này có thể đạt tới tuổi thọ 70 năm.</p>\r\n\r\n<p><img alt=\"cây cà phê Arabica\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/ca-phe-Arabica.jpeg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Arabica sinh trưởng tốt tại độ cao 900 – 2000m so với mực nước biển</p>\r\n\r\n<h2><strong>Các dòng cafe Arabica phổ biến</strong></h2>\r\n\r\n<p>Cafe Arabica rất đa dạng chủng loại. Có khoảng 125 giống cà phê thuộc chi Arabica. Các dòng phổ biến và được nhiều người biến đến như: Typica, Bourbon, Heirloom, Catimor hay Catuai. Mỗi dòng Arabica sẽ có những đặc điểm hương vị khi thưởng thức. Ngoài ra, mỗi loại cũng sẽ có yêu cầu canh tác khác nhau nên sản lượng cũng như vùng miền phân bố cũng không giống nhau.&nbsp;</p>\r\n\r\n<h3><strong><em>Typica</em></strong></h3>\r\n\r\n<p>Typica được xem là giống cà phê đầu tiên được khám phá và trồng tại Ethiopia. Tại Việt Nam, dòng cà phê này được người Pháp trồng tại Cầu Đất, Đà Lạt vào những năm 1857.</p>\r\n\r\n<p>Typica có vị chua nhẹ, trong trẻo, thể chất dày và hậu vị ngọt sâu. Tuy có giá tri cao nhưng đây là giống cà phê có năng suất trồng không cao, khả năng chống chịu sâu bệnh kém.&nbsp;</p>\r\n\r\n<h3><strong><em>Bourbon</em></strong></h3>\r\n\r\n<p>Nếu nói đến các chi cafe Arabica thì Bourbon được xem là một trong những dòng cafe đột biến tư nhiên được phát hiện đầu tiên tại đảo Bourbon. Bourbon thích hợp ở độ cao 1000 – 1600 mét so với mực nước biển.&nbsp;</p>\r\n\r\n<p>Bourbon có vị ngọt đặc trưng, hương trái cây, hậu vị thanh ngọt, thể chất nhẹ nhàng, cân bằng. Mặc dù sở hữu hương vị không ai sánh bằng nhưng hiện nay, tại thị trường Việt, cafe Bourbon không phổ biến. Do đặc tính khó trồng, sức đề kháng không cao nên người trồng cafe Việt đã dần thay thế chúng bằng giống cafe khác cho năng suất tốt hơn.&nbsp;</p>\r\n\r\n<p><img alt=\"Yellow Bourbon\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/Arabica-Bourbon.jpg\" style=\"height:454px; width:680px\" /></p>\r\n\r\n<p>Dòng cà phê Yellow Bourbon.</p>\r\n\r\n<h3><em><strong>Heirloom</strong></em></h3>\r\n\r\n<p>Heirloom là dòng cà phê bản địa của Ethiopia. Đây là giống cà phê mọc hoang dại và tự nhiên trong vùng rừng núi. Dòng cà phê Heirloom có sản lượng thấp nhưng được đánh giá cao về chất lượng. Chúng sở hữu bộ gen tự nhiên quý giá, giúp gia tăng hương vị phong phú và có khả năng chống chịu sâu bênh cao.&nbsp;</p>\r\n\r\n<h3><strong><em>Catimor&nbsp;</em></strong></h3>\r\n\r\n<p>Thực ra, Catimor là một giống cafe lai tạo của Arabica. Nó có đặc điểm với hạt hơi dài.&nbsp;Lý do khiến Catimor là một trong những dòng cafe Arabica phổ biến chính là bởi đặc tính rất dễ trồng. Hơn thế nữa, năng suất thu hoạch cũng rất cao. Đặc biệt, giống cafe hạt này còn có khả năng chống chịu sâu bệnh tốt.</p>\r\n\r\n<p>Tuy nhiên, theo đánh giá của các tín đồ sành về cafe thì hương vị mà Catimor mang lại trong từng ly cafe vẫn chưa có được đẳng cấp như loại Cà phê Arabica khác. Hương vị của dòng cafe Catimor vẫn chưa thể thỏa mãn được những đòi hỏi đẳng cấp của người đam mê thức uống này.</p>\r\n\r\n<h3><strong><em>Catuai</em></strong></h3>\r\n\r\n<p>Xuất hiện lần đầu tiên trên thế giới vào năm 1972 tại Brazin; chủng cafe Catuai được biết đến là kết quả lai tạo giữa cây Caturra vàng (cafe Arabica thuần chủng) và cây Mundo Novo (cafe lai từ Bourbon và Typica). Tại Việt Nam, giống cafe này được ghi nhận lần đầu tiên vào năm 1980 khi du nhập từ Cu Ba.</p>\r\n\r\n<p>Đặc điểm nổi bật của Catuai chính là có dáng cây nhỏ. Quả của cây bám rất chắc trên cành, không dễ bị rụng. Bên cạnh đó, nhân của giống cà phê này có dạng tròn tương đồng với cafe Catimor. Tuy nhiên, lượng nhân có hạt dài cũng xuất hiện nhiều do sự không đồng nhất về giống.</p>\r\n\r\n<p>Mặt khác, đây là chủng cafe thích hợp để trồng ở vùng núi có độ cao từ 1000 – 1200m cách mặt nước biển, Bên cạnh đó, cà phê Catuai có khả năng chống chịu sâu bệnh tốt. Nhưng ngược lại, khả năng thích nghi với môi trường sương muối của chúng lại rất kém. Yêu cầu công sức chăm sóc cũng rất cao. Chính vì vậy, ngay cả khi năng suất cà phê cao thì xét một cách tổng thể, việc trồng chủng cà phê này cũng không mang về nhiều lợi nhuận.</p>\r\n\r\n<h2><strong>Vùng trồng Arabica trên thế giới</strong></h2>\r\n\r\n<p>Nhắc đến Arabica là nhắc đến giống cafe có sức tiêu thụ rất lớn trên thế giới. Với đặc điểm ưa thích sống ở khu vực có đất đai màu mỡ, nhiệt độ khoảng 20 độ C và lượng mưa trong năm đạt mức tiêu chuẩn. Hiện nay, cà phê Arabica đang được không ít quốc gia trên toàn cầu chọn trồng và trở thành một trong những nơi đứng đầu về xuất khẩu cà phê. Có thể kể đến như:</p>\r\n\r\n<h3><strong><em>Brazil</em></strong></h3>\r\n\r\n<p>Với thâm niên hơn 150 năm, Brazil được xem là đồn điền cà phê trên thế giới. Với diện tích trồng cafe đạt mức 100.000 ha. Mỗi năm, quốc gia này đạt sản lượng với hơn 2,5 triệu tấn cafe Arabica.</p>\r\n\r\n<p><img alt=\"Arabica Brazil\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/Arabica-Brazin.jpeg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Brazil được xem là đồn điền cà phê của thế giới.</p>\r\n\r\n<h3><strong><em>Colombia</em></strong></h3>\r\n\r\n<p>Ngay cả khi các nhân tố về nhiệt độ cũng như lượng mưa tại Colombia không đạt tiêu chuẩn thì quốc gia này vẫn có được sản lượng khoảng 810.000 tấn/năm. Đây là một trong những nguồn cung cafe nói chung và cà phê Arabica nói riêng lớn thứ 3 trên thế giới.</p>\r\n\r\n<h3><strong><em>Ethiopia</em></strong></h3>\r\n\r\n<p>Đây là nơi đầu tiên ghi nhận sự xuất hiện của giống cà phê Arabica. Với hơn 1000 năm qua, người dân ở đây đã xem việc trồng cafe là công việc chính. Mỗi năm, sản lượng cafe thu hoạch được ở đây đạt khoảng 384.000 tấn. Đồng thời, cafe cũng chiếm đến 28% lượng hàng xuất khẩu mỗi năm ở khu vực này.</p>\r\n\r\n<h3><strong><em>Ấn Độ</em></strong></h3>\r\n\r\n<p>Ấn Độ ghi nhận đạt sản lượng cà phê khoảng 348.000 tấn/năm. Trong số đó, 80% lượng cà phê trồng được đều xuất khẩu sang Châu Âu hay Nga. Khu vực trồng cafe phổ biến nhất ở quốc gia này là phía Nam Ấn Độ.</p>\r\n\r\n<h3><strong><em>Mexico</em></strong></h3>\r\n\r\n<p>Mexico được biết đến là quốc gia có khả năng sản xuất ra giống Arabica chất lượng cao. Sản lượng mỗi năm đạt khoảng 234.000 tấn. Tuy nhiên, đa số cafe trồng được đều xuất khẩu sang Mỹ.</p>\r\n\r\n<h2><strong>Vùng trồng Arabica ở Việt Nam</strong></h2>\r\n\r\n<h3><strong><em>Đà Lạt</em></strong></h3>\r\n\r\n<p>Được đánh giá là “thiên đường” của cà phê Arabica; Cầu Đất, Đà Lạt sở hữu cao nguyên trung phần với diện tích đất đỏ bazan rộng lớn. Bên cạnh đó, ở Đà Lạt có vị trí cao 1500m so với mặt nước biển. Thời tiết mát mẻ quanh năm. Nhiệt độ cao nhất trong năm cũng không quá 33 độ C.</p>\r\n\r\n<p><img alt=\"Arabica-cau-dat\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/Arabica-cau-dat-1.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cầu Đất được xem là vùng trồng Arabica nổi tiếng của Việt Nam.</p>\r\n\r\n<h3><strong><em>Sơn La</em></strong></h3>\r\n\r\n<p>Đây là khu vực có hơn 100 năm lịch sử trồng cafe Arabica. Sơn La có nhiều lợi thế về thời tiết như: lượng mưa trong năm lớn, nhiệt độ không quá cao, đất đối núi… Chính ưu thế này đã giúp nhiều vùng ở đây có sản lượng cà phê trồng hằng năm rất lớn như: Chiềng Ban, Sinh Ban…</p>\r\n\r\n<h3><strong><em>Nghệ An</em></strong></h3>\r\n\r\n<p>Nằm ở khu vực Trung Bộ, Nghệ An mặc dù không có kiểu thời tiết mát mẻ nhưng vẫn là khu vực có sản lượng cafe Arabica lớn trong cả nước. Nổi bật nhất là ở khu vực Phù Quỳ. Giống cafe Arabica được trồng nhiều nhất ở đây là Catimor. Dù không có vị ngọt hậu đặc biệt như Bourbon nhưng giống cafe này lại sở hữu hương vị mặn chát độc đáo cùng hương thơm sâu lắng.</p>\r\n\r\n<h2><strong>Đặc điểm hương vị cà phê Arabica</strong></h2>\r\n\r\n<p>Nếu bạn là một tín đồ của&nbsp;<strong>Arabica</strong>&nbsp;thì không thể không biết hương vị đặc trưng của giống cafe này. Theo đánh giá của các chuyên gia,&nbsp;<a href=\"https://bonjourcoffee.vn/ca-phe-nguyen-chat.html\">cà phê</a>&nbsp;Arabica có vị chua thanh được hòa cùng chút đắng nhẹ. Mùi hương thoang thoảng, thanh tao. Khi pha, nước cafe sẽ có màu nâu nhạt và hơi nghiêng về hổ phách.&nbsp;Thực tế cho thấy, hương vị của&nbsp;<strong>cà phê Arabica</strong>&nbsp;sẽ có sự ảnh hưởng của các yếu tố thổ nhưỡng, khí hậu.&nbsp;</p>\r\n\r\n<p><img alt=\"hương vị cà phê Arabica\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/07/thuong-thuc-ca-phe-Arabica.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Arabica có hương trái cây tự nhiên, vị ngọt sâu, thể chất cân bằng.</p>\r\n\r\n<h2><strong>Thưởng thức cà phê Arabica</strong></h2>\r\n\r\n<p>Do đặc điểm hương vị của mình, hạt cà phê nguyên chất Arabica có thể được sử dụng để pha chế theo các phương pháp: Pour over, Moka, Syphon.. Các phương pháp pha này nhằm mục đích thưởng thức trọn vẹn hương vị cà phê Arabica nguyên chất mà không cần dùng (hoặc rất ít) sữa hoặc đường.</p>\r\n\r\n<p>Bên cạnh đó, bạn cũng có thể phối trộn cà phê Arabica với Robusta để tăng hương thơm, giảm vị đắng khi pha cà phê phin, Capuchino, Espresso…&nbsp;</p>\r\n\r\n<p>Hiểu về cà phê giúp bạn có cách thưởng thức cà phê tốt hơn. Với những thông tin chia sẻ thú vị về cà phê&nbsp;<strong>Arabica</strong>, Bonjour Coffee tin bạn đã có những kiến thức cơ bản nhất về loại cafe nổi tiếng này. Bonjour Coffee sẽ tiếp tục cập nhật thông tin để bạn có cái nhìn đầy đủ nhất về dòng cà phê này.</p>', 0, '2023-09-17 09:21:22', '2023-09-17 14:43:00');
INSERT INTO `news` (`id_new`, `image_new`, `title_new`, `slug_new`, `subtitle_new`, `content_new`, `view_new`, `created_at`, `updated_at`) VALUES
(6, 'storage/news/tong-quan-kien-thuc-co-ban-ve-ca-phe-danh-cho-ban-1694942583.jpg', 'TỔNG QUAN KIẾN THỨC CƠ BẢN VỀ CÀ PHÊ DÀNH CHO BẠN', 'tong-quan-kien-thuc-co-ban-ve-ca-phe-danh-cho-ban', 'Cà phê là thức uống quen thuộc ở bất kỳ nơi nào trên thế giới. Để giúp hiểu thêm về cafe, Bonjour Coffee đã biên soạn, tổng hợp kiến thức liên quan đến cà phê trong bài viết sau đây. Kiến thức này giúp bạn có cái nhìn tổng quan, từ đó có cơ sở nghiên cứu sâu hơn về sau. Tuy nhiều cố gắng, song vẫn còn những thiếu sót, Bonjour Coffee sẽ bổ sung, cập nhật thường xuyên.', '<h2><strong>Truyền thuyết cây cà phê</strong></h2>\r\n\r\n<p>Có một truyền thuyết khá thú vị về cây cafe như sau. Một chàng chăn cừu tên là Kaldi, trong một lần đưa đàn cừu đi ăn, anh quan sát thấy những con cừu ăn thứ trái cây lạ màu đỏ bỗng nhảy nhót vui vẻ bất thường. Anh nếm thử thứ trái cây lạ này bỗng cảm thấy tinh thần vô cùng sảng khoái, dồi dào năng lượng. Sau đó, anh đã báo cho các vị tu sĩ. Thoạt đầu họ nghĩ đó là thứ trái cấm đã đưa quỷ dữ đưa đến và quyết định đem đốt thứ hạt này. Tuy nhiên mùi hương toả ra từ những hạt lạ khi bị đốt khiến họ muốn nếm thử. Quả thật, tinh thần của họ sảng khoái lạ thường. Họ quyết định biến nó thành một thứ thức uống trước mỗi buổi hành lễ.</p>\r\n\r\n<p><img alt=\"nguồn gốc cây cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/lich-su-ca-phe-300x209.jpg\" style=\"height:474px; width:680px\" /></p>\r\n\r\n<p>Cây cà phê được cho là có nguồn gốc từ đất nước Ethiopia xa xôi.</p>\r\n\r\n<p>Tuy nhiên đó chỉ là truyền thuyết. Sự thật thì cây cà phê có nguồn gốc ở Ethiopia (trước đây có tên là Kaffa). Chính những người nô lệ bị bắt từ Ethiopia sang Ai Cập đã mang loại quả này đi theo. Sau đó chúng nhanh chóng trở thành thứ thức uống được người Ai Cập hết sức ưa chuộng.&nbsp;</p>\r\n\r\n<p>Đến thế kỷ thứ 18, những người Hà Lan đầu tiên đã mang được cà phê ra ngoài lãnh thổ Ai Cập và đến trồng ở xứ Martinique. Sau đó người Pháp và Brazil cũng mang được loại quả này về quê hương của mình. Đó là bước đầu để cây cà phê được trồng ở khắp nơi trên thế giới.&nbsp;</p>\r\n\r\n<h2><strong>Vành đai cà phê</strong></h2>\r\n\r\n<p>Cây cà phê có thể được trồng nhiều nơi, nhiều khu vực trên thế giới. Tuy nhiên chỉ có những vùng nằm trong vành đai cà phê; nơi hội đủ những điều kiện về thổ nhưỡng, độ cao, khí hậu và thời tiết,… cây cà phê mới sinh trưởng, phát triển tốt và tạo ra những hạt cafe chất lượng, hương vị phong phú.</p>\r\n\r\n<p><img alt=\"vành đai cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/12/vanh-dai-ca-phe.jpg\" style=\"height:404px; width:680px\" /></p>\r\n\r\n<p>Cây cafe chỉ sinh trưởng và phát triển tốt khi nằm trong vành đai cà phê.</p>\r\n\r\n<p>Vành đai cafe chính là khu vực nằm dọc theo đường xích đạo, giữa đường vĩ tuyến 23 độ Bắc và vĩ tuyến 23 độ Nam. Những vùng đất nằm trong ranh giới này kết hợp với độ cao 500-2,000 mét so với mực nước biển, thổ nhưỡng giàu dinh dưỡng, khí hậu nhiệt đới nóng ẩm, lượng mưa phù hợp là điều kiện lý tưởng để cây cafe sinh trưởng và phát triển.</p>\r\n\r\n<h2><strong>Các nước trồng cà phê trên thế giới</strong></h2>\r\n\r\n<p>Trên thế giới có khoảng 75 quốc gia nằm trong vành đai cà phê nhưng chỉ có 60 quốc gia có thể trồng cà phê. Trong đó:</p>\r\n\r\n<ul>\r\n	<li>Châu Phi là cái nôi của cà phê. Vùng đất này có đa dạng giống và chủng loại, nơi bảo tồn những nguồn gen đặc thù có giá trị. Các quốc gia trồng cafe ở Châu Phi có thể kể đến như Ethiopia, Uganda, Kenya, Tanzania,…</li>\r\n</ul>\r\n\r\n<p><img alt=\"Bản đồ các nước trồng cà phê trên thế giới\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/12/Bang-do-ca-phe-the-gioi.jpg\" style=\"height:416px; width:680px\" /></p>\r\n\r\n<p>Minh hoạ bản đồ các nước trồng cafe trên thế giới.</p>\r\n\r\n<ul>\r\n	<li>Châu Mỹ được xem là trang trại cà phê thế giới. Cà phê ở đây có hương vị êm dịu và cân bằng, hương hoa, cam, chanh, thể chất nhẹ. Các nước trồng và xuất khẩu cà phê: Brazil, Colombia, Honduras, Mexico, …</li>\r\n	<li>Châu Á chỉ khoảng 8 quốc gia trồng cà phê, trong đó có Việt Nam, Indonesia, Ấn Độ, Trung Quốc, Yemen,… &nbsp;Hương vị&nbsp;<a href=\"https://bonjourcoffee.vn/ca-phe-nguyen-chat.html\">cà phê</a>&nbsp;của Châu Á có mùi đất đặc trưng, hương vị ngọt, hương chocolate, hơi đắng, thể chất đậm.</li>\r\n</ul>\r\n\r\n<h2><strong>Hương vị cà phê theo độ cao</strong></h2>\r\n\r\n<p>Độ cao là yếu tố tiên quyết tác động đến chất lượng cà phê. Độ cao có tầm quan trọng như chính nguồn giống. Cây cà phê được canh tác ở vị trí càng cao thì chu kỳ sinh trưởng càng kéo dài, sự tích lũy dinh dưỡng trong hạt diễn ra chậm, kết quả là hương vị phong phú hơn, hạt cứng chắc và nặng hơn.</p>\r\n\r\n<p><img alt=\"Độ cao ảnh hưởng đến chất lượng hạt cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/12/Huong-vi-cafe-theo-do-cao.jpg\" style=\"height:350px; width:680px\" /></p>\r\n\r\n<p>Hương vị cà phê phụ thuộc vào độ cao nơi trồng cây cà phê.</p>\r\n\r\n<p>Tất nhiên ngoài độ cao thì chất lượng đất, lượng mưa, khí hậu,… cũng là yếu tố quyết định chất lượng hạt cafe. Tuy nhiên về cơ bản thì tính chất hạt cafe biến đổi theo độ cao như sau:</p>\r\n\r\n<ul>\r\n	<li>600m: Cà phê ở độ cao này thường có vị đắng đậm, hương vị đơn giản.</li>\r\n	<li>600 – 760m: Tại độ cao này cafe có hương vị nhạt, mùi đất.</li>\r\n	<li>760 – 910m: Lúc này cafe&nbsp; bắt đầu có vị ngọt, êm dịu.</li>\r\n	<li>910 – 1200m: Tại độ cao này cà phê có đặc trưng cam chanh, chocolate, vanilla.</li>\r\n	<li>1200 – 1600m: Cà phê có hương vị phong phú, hương trái cây, hương hoa.&nbsp;</li>\r\n</ul>\r\n\r\n<h2><strong>Cà phê du nhập vào Việt Nam</strong></h2>\r\n\r\n<p>Năm 1857, người Pháp đã mang giống cafe Chè (Arabica) từ Bourbon sang trồng ở các tỉnh phía Bắc và miền Trung như Xuân Mai, Sơn Tây, Quảng trị, Bố Trạch,… Tuy nhiên năng suất của cây cà phê ở những vùng này rất thấp, chỉ khoảng 400 – 500 kg/1 hecta. Sau đó họ đã mang hạt cafe giống đi trồng ở rất nhiều nơi, lập các đồn điền ở các tỉnh miền Nam và Tây Nguyên.</p>\r\n\r\n<p>Bên cạnh đó, các loại cà phê mới như Robusta (cà phê Vối), Mitcharichia (cà phê Mít) cũng được đem đi trồng thử nghiệm. Từ đó cafe trở thành loại cây công nghiệp phổ biến nhất ở Việt Nam.</p>\r\n\r\n<h2><strong>Vùng trồng cà phê ở Việt Nam</strong></h2>\r\n\r\n<p>Ngày đó người Pháp đem thử nghiệm cafe tại các đồn điền trên khắp cả nước. Các vùng có khí hậu thuận lợi cho cafe phát triển đã được mở rộng, những vùng cho năng suất thấp sẽ bị loại bỏ. Đồng thời họ cũng đã tìm ra được nơi trồng thích hợp cho mỗi giống cafe.</p>\r\n\r\n<p>Hiện nay ở Việt Nam có rất nhiều vùng trồng được cà phê, có thể kể đến như: Thanh Hóa, Nghệ An, Hà Tĩnh, Tây Nguyên, Nam bộ. Tuy nhiên, xét về điều kiện khí hậu thì các tỉnh thuộc Tây Nguyên là thích hợp nhất cho cây cafe phát triển. Vì vậy, loại cây này được trồng nhiều ở đây. Các đồn điền cà phê với năng suất rất cao, chất lượng cà phê hảo hạng được ra đời, đặc biệt là Đắk Lắk và Gia Lai.</p>\r\n\r\n<p><img alt=\"vùng trồng cà phê Việt Nam\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/vung-trong-cafe-300x169.jpg\" style=\"height:382px; width:680px\" /></p>\r\n\r\n<p>Tại Việt Nam thì cà phê được trồng nhiều ở vùng Tây Nguyên.</p>\r\n\r\n<p>Tuy vậy, những giống cafe ngon nhất, với chất lượng cao nhất được biết đến thường có xuất xứ từ Đà Lạt, Lâm Đồng. Điều kiện về độ cao, nhiệt độ, nguồn nước và ánh sáng nơi đây là vô cùng thuận lợi cho các loại cây hàng đầu như Moka, Bourbon sinh sống.</p>\r\n\r\n<h2><strong>Các dòng cà phê phổ biến ở Việt Nam</strong></h2>\r\n\r\n<p>Điều kiện khí hậu nhiệt đới gió mùa tại Việt Nam rất phù hợp cho cây cafe phát triển, đặc biệt là&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cac-loai-ca-phe/\">các loại cà phê</a>&nbsp;có chất lượng cao như: Arabica, Robusta, Cherry.&nbsp;</p>\r\n\r\n<h3><strong>Cà phê Arabica</strong></h3>\r\n\r\n<p>Arabica thuộc họ Rubiaceae, chi Coffea, tiếng Việt được gọi là cà phê Chè do đặc điểm của nó là lá nhỏ, thân cây thấp giống như cây chè ở Việt Nam. Arabica có nguồn gốc từ Tây Nam Ethiopia. Sau đó theo chân người Pháp đến Việt Nam. Đây chính là loại cafe được trồng đầu tiên ở nước ta.</p>\r\n\r\n<p>Trong họ cafe, Arabica có rất nhiều giống khác nhau và hầu như chúng đều là những loại cà phê hảo hạng nhất. Có thể kể đến một số cái tên như: Typica, Bourbon, Caturra, Catuai,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-catimor/\">Catimor</a>,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-moka/\">Moka</a>.</p>\r\n\r\n<p><img alt=\"cafe Arabica\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/Arabica-Coffee-300x205.jpg\" style=\"height:465px; width:680px\" /></p>\r\n\r\n<p>Dòng cafe Arabica chỉ thích hợp ở độ cao phù hợp, tuy có sản lượng thấp nhưng cho hương thơm đặc biệt.</p>\r\n\r\n<p><strong>Xem thêm:&nbsp;</strong></p>\r\n\r\n<ul>\r\n	<li><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica/\">Cà phê Arabica là gì? Đặc điểm dòng cà phê Arabica như thế nào</a></li>\r\n	<li><a href=\"https://bonjourcoffee.vn/blog/ca-phe-robusta/\">Cà phê Robusta là gì? Tìm hiểu đặc điểm dòng cà phê Robusta</a></li>\r\n</ul>\r\n\r\n<h3>Robusta</h3>\r\n\r\n<p>Có đến 39% sản lượng cafe trên thế giới là thuộc dòng Robusta (<a href=\"https://onlinelibrary.wiley.com/doi/abs/10.1111/gcb.15097\">1</a>). Thân cây của Robusta cao hơn, nhiều nhánh và lá cây to hơn so với Arabica.</p>\r\n\r\n<p>Hương vị của Robusta không được đánh giá cao bằng Arabica. Tuy nhiên, đặc điểm nổi bật của giống cafe này chính là hàm lượng caffeine rất cao, chiếm khoảng 2 – 4% hạt cafe trong khi Arabica chỉ có 1 – 2,5%.</p>\r\n\r\n<p><img alt=\"Cà phê Robusta\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/Robusta-Coffee-300x199.jpg\" style=\"height:450px; width:680px\" /></p>\r\n\r\n<p>Robusta có khả năng kháng bệnh tốt, cho năng suất cao, đặc biệt có hàm lượng cafein cao hơn Arabica.</p>\r\n\r\n<p><strong>Xem thêm:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-arabica-robusta\">Cà phê Arabica và Robusta – 11 Điểm khác biệt giữa hai dòng cafe</a></p>\r\n\r\n<h3><strong>Cà phê Cherry</strong></h3>\r\n\r\n<p>Cherry hay còn gọi là cà phê Chari, cà phê Mít có nguồn gốc từ Ubangui Chari, gần sa mạc lớn nhất thế giới Sahara. Chính vì vậy loại cây này có đặc điểm khá cao lớn, thân và lá to để chứa nước và có thể sinh trường tốt ở những nơi thời tiết khô hạn.</p>\r\n\r\n<p>Quả của Chari to hơn những giống khác tuy nhiên năng suất lại không cao. Về mùi vị thì nó cũng không được đánh giá cao bằng Arabica hay Robusta nên ngày nay được trồng rất ít ở nước ta.&nbsp;</p>\r\n\r\n<p>Ngoài các giống cà phê kể trên, trên thị trường còn nhắc nhiều đến dòng&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-culi/\">Culi</a>&nbsp;đột biến, mang cả hương vị của cafe Arabica và Robusta.</p>\r\n\r\n<h2><strong>Hoa cà phê</strong></h2>\r\n\r\n<p>Hoa cafe chỉ nảy mầm trong điều kiện nhiệt độ thấp hoặc được cung cấp nước sau một thời gian khô hạn kéo dài khoảng 2 đến 3 tháng. Thông thường những mùa có khí hậu nắng nóng xen kẽ mưa sau vài tháng sẽ giúp hoa cafe nở đúng lúc, cho năng suất cao hơn.</p>\r\n\r\n<p><img alt=\"Hoa cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/Hoa-ca-phe-300x198.jpg\" style=\"height:450px; width:680px\" /></p>\r\n\r\n<p>Hoa cà phê ngoài kết trái hình thành hạt cafe còn cho mật.</p>\r\n\r\n<p>Biết được nguyên lý nở của hoa cà phê, người trồng sẽ có biện pháp cung cấp nước và chất dinh dưỡng thích hợp để tăng năng suất của mùa vụ. Tuy nhiên cần lưu ý tránh thời tiết xấu, mưa kéo dài, đặc biệt là sương muối sẽ làm hoa cafe bị thối, làm giảm đáng kể năng suất.</p>\r\n\r\n<h2><strong>Cấu tạo và thành phần của quả cà phê</strong></h2>\r\n\r\n<h3><strong>Cấu tạo của quả cafe</strong></h3>\r\n\r\n<p>Trong một quả cafe có 6 phần chính: cuống, vỏ quả, vỏ thịt, vỏ trấu, vỏ lụa và nhân hay còn gọi là hạt cà phê.</p>\r\n\r\n<p>Phần cuống cafe</p>\r\n\r\n<p>Là phần liên kết giữa quả và cành cây, cuống cà phê cần phải dẻo dai. Điều này giúp quả cafe không bị rụng do tác động tự nhiên bên ngoài nhưng phải giòn để dễ thu hái.</p>\r\n\r\n<p>Vỏ quả</p>\r\n\r\n<p>Đây là lớp bỏ ngoài cùng của trái cafe, có chức năng bao bọc và bảo vệ các phần bên trong. Khi chưa chín, vỏ cà phê sẽ có màu xanh lá cây và khi chín sẽ chuyển dần sang màu đỏ hoặc vàng tùy giống cà phê. Phần vỏ của các loại Arabica sẽ mềm và nhỏ hơn so với Robusta và Chari.</p>\r\n\r\n<p>Vỏ thịt</p>\r\n\r\n<p>Vỏ thịt của cà phê có vị ngọt nhẹ, có thể ăn được. Trong cách tạo nên cafe Chồn, con chồn sẽ ăn và hấp thụ phần vỏ thịt và thải phần nhân ra. Phần vỏ thịt của Arabica có vị ngọt và mềm nhất, trong khi đó cà phê Chari có vỏ thịt dày hơn cả.</p>\r\n\r\n<p><img alt=\"Cấu tạo hạt cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/thanh-phan-hoa-hoc-300x162.png\" style=\"height:366px; width:680px\" /></p>\r\n\r\n<p>Hạt cà phê có cấu tạo gồm nhiều lớp khác nhau.</p>\r\n\r\n<p>Phần vỏ trấu</p>\r\n\r\n<p>Đây là lớp vỏ khá cứng sau khi được phơi khô để bảo vệ nhân cafe. Sau khi thu hoạch cafe, người ta sẽ loại bỏ đi vỏ ngoài. Vỏ thịt và phần chất nhờn, chỉ còn vỏ trấu và hạt bên trong. Khi chế biến, lớp vỏ trấu này cũng được loại bỏ và có thể dùng để làm chất đốt, ủ phân rất tốt.</p>\r\n\r\n<p>Lớp vỏ lụa</p>\r\n\r\n<p>Vỏ lụa là phần rất mỏng và mềm bao bọc chung quanh nhân cà phê. Mỗi loại cafe đều có màu sắc vỏ lụa khác nhau. Theo đó, vỏ của Arabica có màu trắng, cà phê Robusta có màu nâu nhạt còn lớp vỏ lụa của cafe Chari thì có màu vàng nhạt.</p>\r\n\r\n<p>Nhân cafe</p>\r\n\r\n<p>Đây chính là thành phần tạo nên giá trị cho cây cafe. Nhân cà phê được chia thành 2 phần: phần ngoài cứng gồm những tế bào nhỏ chứa chất dầu, phần trong có những tế bào lớn và tương đối mềm. Ngoại trừ những trường hợp như cafe chỉ có 1 nhân, hoặc hy hữu là 3 nhân thì đa số mỗi hạt cà phê đều có 2 phần bằng nhau.</p>\r\n\r\n<h3><strong>Thành phần hóa học của quả cafe</strong></h3>\r\n\r\n<p>Trong một quả cà phê hoàn chỉnh sẽ có rất nhiều thành phần khác nhau. Mỗi thành phần đều rất quan trọng để tạo nên hương vị cho nhân cafe.</p>\r\n\r\n<p>Vỏ quả</p>\r\n\r\n<p>Trong phần vỏ quả cafe có chứa nhiều chất Antoxian nên khi chín quả thường có màu đỏ. Ngoài ra phần vỏ quả còn chứa nhiều các chất như caffeine, Alkaloid, Tannin và rất nhiều loại enzim khác.</p>\r\n\r\n<p>Vỏ thịt</p>\r\n\r\n<p>Lớp vỏ thịt chứa chủ yếu là các chất nhớt và những tế bào mềm. Phần này chứa rất nhiều đường khiến quả cafe có vị ngọt, bên cạnh đó là chất hỗ trợ quá trình lên men Pectinase khiến vị của nhân cà phê ngon hơn.</p>\r\n\r\n<p>Vỏ trấu</p>\r\n\r\n<p>Vì được bao bọc ngay bên ngoài nhân nên lớp vỏ trấu cũng được thừa hưởng một lượng caffeine đáng kể, lên đến 0.4% trọng lượng quả cafe.</p>\r\n\r\n<p>Nhân cà phê</p>\r\n\r\n<p>Trong nhân cafe chín hoàn toàn, lượng nước chiếm đến 10 – 12%, sau đó là 10 – 13% Lipid, 9 – 11% Protein, 5 – 10% đường và 3 – 5% tinh bột. Mỗi chủng loại cà phê đều có thành phần hóa học khác biệt tạo nên hương vị đặc trưng. Ngoài ra, nếu chế biến tối ưu thì cũng giúp cải thiện chất lượng rất nhiều.</p>\r\n\r\n<h3><strong>Đặc trưng các chất có trong nhân cà phê</strong></h3>\r\n\r\n<p>Nước</p>\r\n\r\n<p>Khi sấy khô, cafe đạt chuẩn phải có từ 10 – 12% nước ở dạng liên kết. Sau khi rang con số này khoảng 2 – 3%. Khi lượng nước nhiều hơn, việc bảo quản sẽ vô cùng khó khăn. Nhân cà phê sẽ bị ẩm mốc ảnh hưởng rất nặng đến chất lượng.</p>\r\n\r\n<p>Lipid</p>\r\n\r\n<p>Trong 10 – 13% Lipid của nhân cafe thì có đến 90% là chất dầu, còn lại là sáp. Đây là thành phần tạo nên độ thơm và sệt của cafe, sau khi chế biến, lượng Lipid còn lại rất ít và bám trên&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ba-ca-phe/\">bã cà phê</a>. Dùng bã này để dưỡng da rất tốt.</p>\r\n\r\n<p>Protein</p>\r\n\r\n<p>Protein trong cà phê tuy thấp nhưng lại có rất nhiều các loại axit amin tốt. Khi rang, lượng Protein này sẽ bị cháy và tạo ra mùi thơm đặc trưng và mùi vị của cafe có rất nhiều đóng góp của thành phần này.</p>\r\n\r\n<p>Các chất khoáng</p>\r\n\r\n<p>Hàm lượng chất khoáng trong nhân cafe chiếm từ 3 – 5% chủ yếu là các loại như Magie, Kali, Nito, Photpho, Clo, Sắt, lưu huỳnh,… Những loại cafe ngon thường có rất ít hàm lượng chất khoáng vì chúng ảnh hưởng không tốt cho mùi vị cả cà phê.</p>\r\n\r\n<p>Caffeine</p>\r\n\r\n<p>Đây chính là đặc trưng khiến cafe khác biệt với những loại quả và hạt khác. Caffeine chính là nguồn gốc của những lợi ích từ việc uống cà phê, giúp tinh thần thoải mái và tràn đầy năng lượng. Lượng caffeine trong các loại cafe là khác nhau, trong đó Robusta có hàm lượng caffeine cao nhất.</p>\r\n\r\n<h2><strong>Các phương pháp sơ chế cà phê</strong></h2>\r\n\r\n<p>Hiện nay có 3 phương pháp sơ chế cafe phổ biến là sơ chế khô, sơ chế ướt và sơ chế honey. Mỗi cách làm đều có ưu điểm và nhược điểm riêng.</p>\r\n\r\n<h3><strong>Chế biến khô</strong></h3>\r\n\r\n<p>Đây là phương pháp mà ngay sau khi thu hoạch, người ta sẽ đem phơi nguyên quả cafe dưới ánh nắng mặt trời. Phương pháp này có ưu điểm là dễ làm, không mất nhiều công sức. Tuy nhiên nó lại có nhược điểm cực kỳ lớn là khiến hạt cafe lâu khô hơn, dễ bị ẩm mốc từ bên trong. Đặc biệt là khi gặp thời tiết bất lợi, quả cà phê rất dễ xảy ra hiện tượng ẩm mốc dẫn đến chất lượng không được cao.</p>\r\n\r\n<p><img alt=\"chế biến khô\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/che-bien-kho-300x194.jpg\" style=\"height:440px; width:680px\" /></p>\r\n\r\n<p>Chế biến khô khá đơn giản chỉ phơi hạt cafe dưới ánh nắng mặt trời.</p>\r\n\r\n<p>Chính vì những nhược điểm trên mà người ta rất ít chế biến theo phương pháp này, đặc biệt là đối với những loại cà phê cao cấp như Arabica.</p>\r\n\r\n<p>Tuy nhiên, nếu chế biến khô được thực hiện đúng cách: tỉ lệ trái chín cao, phơi trên giàn, đúng thời gian và nhiệt độ, tránh ẩm mốc thì vị cà phê có thể tốt hơn các phương pháp chế biến khác.&nbsp;</p>\r\n\r\n<h3><strong>Chế biến ướt</strong></h3>\r\n\r\n<p>Đối với những loại cà phê chất lượng cao, người ta sẽ dùng phương pháp sơ chế này để đảm bảo chất lượng tốt nhất. Quá trình làm sẽ mất nhiều công sức hơn, nhưng bù lại giá trị của cafe thành phẩm sẽ cao hơn rất nhiều.</p>\r\n\r\n<p>Ngay sau khi được thu hoạch (chỉ thu hái những hạt đã chín, lượng hạt xanh phải được hạn chế đến mức tối đa), người ta sẽ đem quả cà phê đi xay xát. Sau đó cho qua nước để đãi, lọc hết lớp vỏ nhớt bên ngoài rồi đem phần nhân còn lại đi ủ để lên men. Quá trình lên men chỉ được hoàn tất khi phần vỏ trấu trở nên nhám và sạch nhớt.</p>\r\n\r\n<p><img alt=\"chế biến ướt\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/che-bien-uot-300x204.jpg\" style=\"height:462px; width:680px\" /></p>\r\n\r\n<p>Chế biến ướt là phương pháp khá phổ biến hiện nay.</p>\r\n\r\n<p>Cuối cùng nhân cafe sẽ được đem đi rửa sạch và phơi, sau đó loại bỏ lớp vỏ trấu bên ngoài là ra hạt thành phẩm.</p>\r\n\r\n<p>Quá trình phơi cũng rất công phu, không được phơi trực tiếp trên nền đất vì sẽ bị hút ẩm. Khi phơi cần rải đều để tất cả hạt được khô đều, quá trình phơi kết thúc khi cắn hạt không bị vỡ. việc này đòi hỏi kinh nghiệm khá nhiều từ người nông dân.</p>\r\n\r\n<p>Cà phê được chế biến bằng phương pháp ướt sẽ có vị trong sáng, cân bằng và thể chất nhẹ.&nbsp;&nbsp;</p>\r\n\r\n<h3><strong>Chế biến Honey</strong></h3>\r\n\r\n<p>Cách chế biến này cũng khá giống với chế biến ướt. Tuy nhiên người ta sẽ không loại bỏ hết hoặc giữ lại toàn bộ phần chất nhớt trước khi đem phơi khô. Chính điều này sẽ tạo cho nhân cafe thành phần màu nâu đen giống với mật ong, đúng với tên gọi của cách chế biến Honey.</p>\r\n\r\n<p>Những loại cà phê được chế biến theo cách này sẽ giữ lại được khá nhiều độ ngọt và tăng phần hương vị khi thưởng thức.</p>\r\n\r\n<p><img alt=\"Chế biến cafe honey\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/honey-coffee-blog-300x206.jpg\" style=\"height:467px; width:680px\" /></p>\r\n\r\n<p>Phương pháp sơ chế cafe theo kiểu honey tăng độ ngọt và giữ được hương vị cafe.</p>\r\n\r\n<p>Phương pháp chế biến Honey cho hương vị phong phú, vị ngọt, thể chất mượt mà, vị chua thanh và trái cây chín.</p>\r\n\r\n<h2><strong>Rang xay cafe</strong></h2>\r\n\r\n<h3><strong>Tại sao phải rang cà phê</strong></h3>\r\n\r\n<p>Quá trình rang sẽ tác động đến các thành phần hóa học có trong cafe, đặc biệt là caffeine, lipid và protein để biến đổi chúng, tạo nên hương thơm và mùi vị đặc trưng khi uống.</p>\r\n\r\n<p><img alt=\"rang cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/rang-ca-phe-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Ngày nay việc rang cà phê được hỗ trợ nhiều bởi công nghệ, tuy nhiên để có mẻ cafe ngon bạn cần trải qua thời gian thử nghiệm lâu dài.</p>\r\n\r\n<h3><strong>Quá trình biến đổi chất của hạt cà phê trong khi rang</strong></h3>\r\n\r\n<p>Việc rang cà phê sẽ được bắt đầu từ lúc nhiệt độ đạt 100 độ C cho đến khi kết thúc ở 240 độ C. Trong quá trình gia nhiệt này, những thành phần trong cà phê sẽ bắt đầu biến đổi:</p>\r\n\r\n<p><img alt=\"biến đổi màu sắc hạt cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/thay-doi-mau-hat-cafe-300x186.jpg\" style=\"height:422px; width:680px\" /></p>\r\n\r\n<p>Biến đổi màu sắc hạt cà phê khi rang.</p>\r\n\r\n<p>Khi đạt 100 độ C</p>\r\n\r\n<p>Lượng nước bên trong sẽ bắt đầu bốc hơi khiến nhân cafe co lại.</p>\r\n\r\n<p>Từ 0 – 150 độ C</p>\r\n\r\n<p>Lượng nước tiếp tục mất đi, nhân cafe bắt đầu thay đổi màu sắc sang vàng nhạt. Quá trình teo nhỏ vẫn tiếp tục và kèm theo đó là mùi thơm bắt đầu bốc lên.</p>\r\n\r\n<p>Từ 150 – 180 độ C</p>\r\n\r\n<p>Nếu giữ nhiệt ở mức 150 độ C, nhân cafe sẽ từ màu vàng nhạt chuyển sang nâu nhạt. Lúc này cần gia nhiệt lên 180 độ C để cafe bốc mùi thơm hơn. Quá trình teo nhỏ kết thúc, thay vào đó là việc trương nở thể tích do các thành phần bên trong bắt đầu.</p>\r\n\r\n<p>Từ 180 – 200 độ C</p>\r\n\r\n<p>Trong quá trình gia nhiệt từ 180 lên 200 độ C, hạt cà phê đã trương nở ra hết sức, mùi thơm bốc lên ngào ngạt, các thành phần bên trong đã có thể dễ dàng xay nhuyễn.&nbsp;</p>\r\n\r\n<p>Từ 200 – 210 độ C</p>\r\n\r\n<p>Hạt cà phê bắt đầu trương nở đến mức nổ tung, khói bắt đầu bốc lên tạo hương thơm ngát và lan tỏa đi xa hơn.</p>\r\n\r\n<p>Từ 210 – 230 độ C</p>\r\n\r\n<p>Hạt cà phê tiếp tục trương nở do giải phóng Cacbon dioxit và nổ nhiều hơn.</p>\r\n\r\n<p>Từ 230 – 240 độ C</p>\r\n\r\n<p>Hạt lúc này sẽ có màu nâu đậm, mùi hương nồng nàn, các thành phần bên trong cũng được biến đổi để đạt được hương bị tốt nhất. Lúc này là thích hợp nhất để đem đi xay nhuyễn và bắt đầu pha chế.</p>\r\n\r\n<p>Lưu ý, quá trình rang cafe chính là quá trình gia nhiệt cho hạt. Nhiệt độ bên trên là nhiệt độ tích luỹ bên trong hạt cafe. Tuỳ theo mục đích rang và phương pháp pha chế mà các thợ rang có thể chọn dừng quá trình rang ở nhiệt độ nào.</p>\r\n\r\n<p>Hoặc nếu thực hiện rang trên máy rang có hiển thị đồ thị nhiệt theo thời gian, người thợ rang cũng có thể kết thúc quá trình rang theo thời gian tuỳ thuộc vào mục đích pha chế.</p>\r\n\r\n<p><img alt=\"Đồ thị nhiệt của mẻ rang\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/11/Do-thi-nhiet-cua-me-rang.jpg\" style=\"height:466px; width:680px\" /></p>\r\n\r\n<p>Đồ thị nhiệt của mẻ rang (tham khảo).</p>\r\n\r\n<p><strong>Xem thêm:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-rang-ca-phe-ngon/\">Kiến thức cơ bản về rang cà phê- Cách rang cà phê tại nhà.</a></p>\r\n\r\n<h2><strong>Các loại cafe thành phẩm</strong></h2>\r\n\r\n<p>Hiện nay có rất nhiều cách chế biến khác nhau của cà phê, vì vậy có rất nhiều loại thành phẩm khác nhau. Mỗi loại đều có ưu thế riêng của mình.</p>\r\n\r\n<h3><strong>Cafe rang xay nguyên chất</strong></h3>\r\n\r\n<p>Loại cafe này được đem rang và xay ra thành bột.&nbsp;Đây là loại cafe được chế biến từ 100% hạt cà phê tự nhiên, không hề có bóng dáng của bất kỳ loại chất phụ gia nào khác như đậu, bắp hay ngũ cốc. Ưu điểm của cà phê nguyên chất là giữ được những gì đặc trưng nhất của cà phê, những người sành uống và yêu thích loại hạt này sẽ thích dùng&nbsp;cà phê nguyên chất&nbsp;rang&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-rang-moc/\">mộc</a>.&nbsp;</p>\r\n\r\n<p>Xem sản phẩm cà phê nguyên chất của Bonjour Coffee tại:&nbsp;<a href=\"https://bonjourcoffee.vn/\">https://bonjourcoffee.vn</a></p>\r\n\r\n<p><img alt=\"cà phê nguyên chất\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2021/04/ca_phe_nguyen_chat.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Nên chọn cà phê nguyên chất để pha ly cafe ngon, tốt cho sức khỏe.</p>\r\n\r\n<h3><strong>Cafe hòa tan</strong></h3>\r\n\r\n<p>Nhận thấy cafe bột rất mất thời gian để pha chế nên các nhà sản xuất đã bắt đầu nghĩ ra cách giúp người dùng thưởng thức cà phê thuận tiện hơn. Trong quá trình sản xuất, họ đã pha sẵn trong bột cafe những hương liệu, phụ gia để đạt được một mùi vị mong muốn. Người dùng chỉ cần đem bột này cho vào nước sôi, hòa lên là đã có thể thưởng thức, chỉ mất 30 giây để cho ra một ly cà phê.</p>\r\n\r\n<p><img alt=\"instant coffee cafe hòa tan.\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/cafe-hoa-tan-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cafe hòa tan ra đời nhằm phục vụ cho xã hội ngày càng bận rộn.</p>\r\n\r\n<p>Có thể thấy ưu điểm của cafe hòa tan là tính nhanh gọn, hương vị đã được pha chế và tính toán với một lượng vừa phải nên lúc nào cũng có thể thưởng thức 1 ly cà phê ngon nhất.</p>\r\n\r\n<p>Tuy nhiên nó lại có một nhược điểm khá lớn chính là các hương liệu pha vào bên trong sẽ làm mất đi phần nào vị cà phê nguyên chất.&nbsp;</p>\r\n\r\n<h3><strong>Nước giải khát cà phê</strong></h3>\r\n\r\n<p>Nếu như cả pha cafe hòa tan cũng chiếm thời gian của bạn hoặc không có điều kiện pha thì một ly nước cà phê được làm sẵn sẽ vô cùng tiện lợi. Nước cafe cũng tương tự như cafe hòa tan nhưng đã được pha sẵn, chỉ cần mở nắp là có thể uống.&nbsp;Ưu điểm của loại cafe này là tính nhanh gọn và tiện lợi.</p>\r\n\r\n<h2><strong>Các phương pháp pha cafe trên thế giới</strong></h2>\r\n\r\n<p>Cafe là loại thức uống phổ biến bậc nhất trên thế giới. Tuy nhiên không phải ở đâu người ta cũng pha chế theo một cách giống nhau mà tùy vào đặc trưng của quốc gia và gu thưởng thức mà họ có cách pha chế cho riêng mình. Có thể kể đến một số cách pha chế nổi tiếng như:</p>\r\n\r\n<h3>Espresso, Capuchino và Latte của Ý</h3>\r\n\r\n<p>Đây có thể nói là những loại đồ uống được nhiều người ưa thích nhất trên thế giới. Espresso sử dụng những loại cà phê ngon nhất, có độ sánh mịn và màu sắc tuyệt vời. Pha Espresso với sữa theo những tiêu chuẩn nhất định sẽ tạo ra Capuchino và Latte.</p>\r\n\r\n<p><img alt=\"\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/pha-che-cafe-300x201.jpg\" style=\"height:455px; width:680px\" /></p>\r\n\r\n<p>Espresso là phương pháp pha cafe đặc trưng của Ý.</p>\r\n\r\n<h3>Cà phê Buna ở Ethiopia</h3>\r\n\r\n<p>Tại quê hương của cafe, người ta rất tự hào về loại đồ uống này vì mọi loại cafe đều bắt nguồn từ một người chăn dê ở xứ sở của họ. Vì vậy cách thưởng thức cà phê ở nơi đây cũng có phần khác biệt. Người Ethiopia sẽ dùng cafe (tiếng địa phương là Buma) pha với muối hoặc bơ chứ không dùng đường và sữa như những nước khác.</p>\r\n\r\n<h3>Turk Kahvesi của Thổ Nhĩ Kỳ</h3>\r\n\r\n<p>Cách pha chế này cực kỳ đơn giản, người ta chỉ cần lấy bột cafe cho vào nước rồi đun trên bếp đến khi đủ mùi vị là được.</p>\r\n\r\n<h3>Kaffe của Đan Mạch</h3>\r\n\r\n<p>Người Đan Mạch sẽ dùng cafe nguyên chất để uống với kem hoặc sữa tươi mà không pha với bất kỳ loại tạp chất nào. Cách pha cafe này khá giống với cà phê kem của Ý.</p>\r\n\r\n<h3>Ireland của Ailen</h3>\r\n\r\n<p>Đây là một cách pha chế cafe đặc biệt của người Ailen. Họ sẽ cho vào cafe nóng một ít Whisky Ailen, đường và một ít kem phủ. Thức uống này rất phù hợp để làm ấm người cho những đêm đông lạnh giá nơi đây.</p>\r\n\r\n<p>Đặc biệt nhất là cafe phin của Việt Nam: Đây là cách pha chế phổ biến nhất ở Việt Nam. Hầu như nhà nào cũng có phin để tự pha cafe, và ở ngoài các hàng quán, hình ảnh của phin cafe đã in sâu vào tiềm thức của nhiều người.</p>\r\n\r\n<p><strong>Xem thêm:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-pha-ca-phe-ngon/\">15+ Cách pha cà phê cho quán của bạn</a>.</p>\r\n\r\n<h2><strong>Thưởng thức cafe</strong></h2>\r\n\r\n<h3><strong>Hương vị cafe</strong></h3>\r\n\r\n<p>Hương vị của cafe là một cái gì đó rất khó nói, nó dựa vào cảm nhận của nhiều người. Mỗi loại cafe đều mang trong mình một hương vị đặc trưng và tùy vào sở thích của mỗi người mà đưa ra sự lựa chọn của mình.</p>\r\n\r\n<ul>\r\n	<li>Arabica có màu nâu đẹp mắt, sánh và mịn. Khi thưởng thức, một ly Arabica hảo hạng sẽ có vị đắng nhẹ đặc trưng, mùi thơm quyến rũ, thêm vào đó là một chút chua hoặc mùi vị trái cây.</li>\r\n</ul>\r\n\r\n<p><img alt=\"uống cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/thuong-thuc-cafe-300x201.jpg\" style=\"height:456px; width:680px\" /></p>\r\n\r\n<p>Mỗi dòng cà phê có hương vị đặc trưng, cần hiểu về đặc tính này để thưởng thức cafe ngon hơn.</p>\r\n\r\n<ul>\r\n	<li>Robusta đắng đậm, không chua như Arabica.</li>\r\n</ul>\r\n\r\n<p>Chúng ta cũng có thể kết hợp Arabica và Robusta theo tỷ lệ nhất định để ly cà phê có hương vị tốt hơn.</p>\r\n\r\n<p><strong>Xem thêm:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-tron-ca-phe-ngon/\">Cách phối trộn để có ly cà phê ngon</a>.</p>\r\n\r\n<h3><strong>Lợi ích của cafe</strong></h3>\r\n\r\n<p>Trong cafe có rất nhiều caffeine là một chất có rất nhiều tác dụng đối với cơ thể, đồng thời các loại khoáng chất và hợp chất có lợi cũng đem lại cho người uống cafe thường xuyên nhiều lợi ích.</p>\r\n\r\n<p>Nói về tác động có lợi của cafe, người ta có thể kể ra hàng loạt hạng mục như: Chống buồn ngủ, giúp tinh thần sảng khoái, thoải mái hơn, ngăn ngừa ung thư, lão hóa, kéo dài tuổi thọ, làm đẹp, giảm cân,… Và rất nhiều lợi ích khác.</p>\r\n\r\n<p><img alt=\"lợi ích khi uống cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/thuong-thuc-ca-phe-300x196.jpg\" style=\"height:444px; width:680px\" /></p>\r\n\r\n<p>Uống cà phê mang lại nhiều lợi ích cho sức khỏe.</p>\r\n\r\n<p>Tuy nhiên những lợi ích trên chỉ có được khi uống ở một lượng vừa phải, trung bình 2 cốc cà phê 1 ngày. Nếu quá lạm dụng cafe, nó cũng có thể khiến người dùng mất ngủ,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/say-cafe/\">say cafe</a>, ảo thanh, nghiện cà phê, tăng huyết áp,…</p>\r\n\r\n<p><strong>Xem thêm:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/tac-dung-cua-ca-phe/\">17 Tác dụng tốt của cà phê bạn nên biết</a></p>\r\n\r\n<h2><strong>Bảo quản cafe</strong></h2>\r\n\r\n<p>Cafe dạng bột có thể được bảo quản tối đa trong 1 năm từ lúc rang và xay nếu được làm đúng cách. Đặc biệt trong vòng 14 ngày sau khi xay, cần được cho vào bao bì kín, để ở những nơi khô ráo, tránh ẩm ướt để không bị mất đi lượng caffeine và hương vị.</p>\r\n\r\n<p>Nếu tự rang xay cafe, bạn không nên cho vào các loại bì ni lông vì rất dễ bị ẩm mốc. Thay vào đó bạn có thể bảo quản cafe trong các túi có van một chiều hoặc hút chân không. Đây là một cách bảo quản cực tốt do không khí bên ngoài không thể vào trong.</p>\r\n\r\n<p><img alt=\"bảo quản cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/02/bao-quan-ca-phe-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cần có cách bảo quản cafe hợp lý để giữ được hương vị lâu hơn.</p>\r\n\r\n<h2><strong>Kết Luận</strong></h2>\r\n\r\n<p>Kiến thức về cà phê là khá nhiều, để hiểu hết và loại thức uống này từ lúc trồng cây, thu hoạch, rang xay, pha chế, bảo quản, bạn cần phải có một thời gian dài tìm hiểu. Tuy nhiên với những kiến thức tổng quan trên của Bonjour Coffee, hy vọng bạn đã có thể hiểu hơn về chúng. Khi thưởng thức cafe, bạn hãy cảm nhận những gì tinh túy nhất từ cái nắng, cái gió và những giọt mồ hôi của những người đã vất vả làm nên.</p>', 0, '2023-09-17 09:23:04', '2023-09-17 14:43:07');
INSERT INTO `news` (`id_new`, `image_new`, `title_new`, `slug_new`, `subtitle_new`, `content_new`, `view_new`, `created_at`, `updated_at`) VALUES
(7, 'storage/news/15-cach-pha-cafe-ngon-cho-quan-ca-phe-cua-ban-1694943129.jpg', '15+ CÁCH PHA CAFE NGON CHO QUÁN CÀ PHÊ CỦA BẠN', '15-cach-pha-cafe-ngon-cho-quan-ca-phe-cua-ban', 'Bạn muốn tìm hiểu về các cách pha cafe để tự mình pha một ly cà phê ngon? Bạn đang có ý định kinh doanh cafe và muốn tìm hiểu các cách pha cà phê cho quán của mình? Bạn đang muốn trở thành Barista và muốn tìm hiểu về pha chế. Nếu vậy, bài viết này chắc chắn dành cho bạn. Tại đây, Harper 7 Coffee sẽ giới thiệu hơn 15 cách pha cà phê giúp bạn có thông tin đầy đủ về các phương pháp pha chế cà phê ngon hiện nay.', '<h2><strong>Cách pha cà phê kiểu nhỏ giọt</strong></h2>\r\n\r\n<h3><strong>1. Cà phê phin</strong></h3>\r\n\r\n<p><strong>Cách pha cafe phin</strong>&nbsp;xuất hiện từ thế kỷ 19 người và là phương pháp phổ biến nhất tại Việt Nam hiện nay. Phương pháp này dựa trên nguyên tắc là nước nóng đi qua bột&nbsp;<a href=\"https://bonjourcoffee.vn/ca-phe-nguyen-chat.html\">cà phê</a>&nbsp;cho ra nước cà phê.</p>\r\n\r\n<p><img alt=\"cách pha cà phe phin\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cach-pha-ca-phe-phin-300x210.jpg\" style=\"height:477px; width:680px\" /></p>\r\n\r\n<p>Cà phê phin cách pha cafe độc đáo của người Việt Nam.</p>\r\n\r\n<p>Cafe đặc, loãng, đắng gắt hay đắng ngọt phần lớn là do tay người pha. Bên cạnh đó, chất lượng cà phê cũng vô cùng quan trọng. Bạn nên chọn cà phê&nbsp;rang xay nguyên chất&nbsp;để đảm bảo sức khoẻ và cho hương vị tuyệt hảo nhất.</p>\r\n\r\n<p>Bên cạnh kỹ thuật pha cafe,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-tron-ca-phe-ngon/\">cách phối trộn cà phê</a>&nbsp;cũng là phương pháp để cho ra ly cafe phù hợp gu khách hàng. Tùy theo khách, người sành cafe, nam giới, nữ giới hay các bạn tuổi teen mà chúng ta có tỉ lệ phối trộn cafe khác nhau.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-pha-cafe-phin/\">Hướng dẫn cách pha cà phê phin ngon hút khách</a></p>\r\n\r\n<h3><strong>2. Cà phê sữa</strong></h3>\r\n\r\n<p>Nếu bạn muốn uống cà phê sữa đá, hãy để sẵn trong chiếc ly một ít sữa, chờ từng giọt cà phê nhỏ xuống. Khi nào cà phê nhỏ hết, hãy khuấy đều cà phê, sữa và thêm ít đá. Đảm bảo rằng bạn sẽ có một ly cà phê ngon.&nbsp;</p>\r\n\r\n<p><img alt=\"cách pha cà phê sữa đá\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Ca-phe-sua-da-1-300x196.jpg\" style=\"height:445px; width:680px\" /></p>\r\n\r\n<p>Cà phê sữa đá, thức uống đặc trưng của người Sài Gòn.</p>\r\n\r\n<p>Sữa có tác dụng giảm bớt vị đắng của cà phê, gia tăng vị ngọt, tạo ra vị béo mà không làm mất hương vị ban đầu của cà phê.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-sua-da/\">Cách pha ly cà phê sữa đá ngon đậm chất Sài Gòn</a></p>\r\n\r\n<h3><strong>3. Cách pha cafe Pour over ngon</strong></h3>\r\n\r\n<p>Nguyên lý pha cà phê như sau: để nước sôi đi qua bột cà phê, bã cà phê được giữ lại trên bộ lọc còn nước cafe chảy xuống bình đựng cà phê bên dưới. Cách pha cà phê pour over cho ly cà phê đầy đủ hương vị nhất, và thường phải sử dụng cà phê Specialty để pha.&nbsp;</p>\r\n\r\n<p><img alt=\"Cafe pour over\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Pour-over-coffee-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Khi pha cafe theo kiểu Pour over, bạn sẽ cảm nhận trọn vẹn hương vị của cà phê.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê specialty xay mịn vừa</li>\r\n	<li>Phễu V60 và giấy lọc</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Bình đựng cà phê</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Dùng nước sôi 90-96 độ tráng rửa giấy lọc, phin V60 để khử mùi giấy và làm nóng phễu.</li>\r\n	<li>Đặt bình đựng cà phê và phin V60 lên cân.</li>\r\n	<li>Cân 20g hạt cà phê, cho vào máy xay vừa, sau đó cho vào phễu V60.</li>\r\n	<li>Rót 60ml nước sôi 90-96 độ C vào phin lọc theo vòng tròn chiều kim đồng hồ. Ủ cà phê trong vòng 30 giây. Rót tiếp 240ml nước sôi còn lại vào phin. Rót chậm, liên tục và theo vòng tròn trong vòng 2 phút.</li>\r\n	<li>Sau 2:00 – 2:30, cà phê đã sẵn sàng để thưởng thức.</li>\r\n</ul>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-pha-pour-over/\">Pour over là gì? Cách pha cà phê pour over ngon như thế nào?</a></p>\r\n\r\n<p>Bên cạnh cà phê Pour over, bạn có thể tham khảo cách pha&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cold-brew/\">cà phê Cold Brew</a>&nbsp;của Bonjour Coffee.&nbsp;</p>\r\n\r\n<h2><strong>Cách pha cafe kiểu nấu sôi</strong></h2>\r\n\r\n<h3><strong>4. Cách pha cà phê Moka Pot ngon</strong></h3>\r\n\r\n<p>Moka Pot thực chất là 1 chiếc bình đun cà phê có lịch sử lâu đời, hơi thiên một chút về kiểu pha dùng áp suất. Mỗi Moka Pot pha được khoảng 2-3 ly cà phê nhỏ. Nguyên lý hoạt động của Moka Pot là dùng hơi nước nóng để pha chế cà phê. Cách pha cafe Moka Pot có đôi chút khác biệt so với các phương pháp khác. Thứ nhất là bạn phải đun trực tiếp cà phê trên bếp, thứ hai là căn chỉnh kỹ lưỡng tỷ lệ nước và bột cà phê.</p>\r\n\r\n<p><img alt=\"Cafe Moka Pot\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Moka-Pot-ca-phe-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Với cách pha cafe bằng bình Moka pot bạn có thể có được một cốc “Espresso mộc mạc”.</p>\r\n\r\n<p><strong>Chuẩn bị dụng cụ</strong></p>\r\n\r\n<ul>\r\n	<li>Bột cà phê xay thô</li>\r\n	<li>Bình Moka</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót 500ml nước vào bình đáy (mực nước nằm dưới van bình).</li>\r\n	<li>Lấy 25g bột cà phê vào chén lọc, đặt chén lọc vào bình đáy và vặn chặt thân bình vào đáy bình.</li>\r\n	<li>Đặt bình lên bếp, khi nước sôi có thể mở nắp để quan sát quá trình chiết xuất cà phê.</li>\r\n	<li>Khi nước cà phê từ bình bên dưới đi lên bắt đầu nhạt dần và bong bóng nổi lên thì lấy bình ra khỏi bếp.</li>\r\n	<li>Rót cà phê ra tách và thưởng thức.</li>\r\n</ul>\r\n\r\n<h3><strong>5. Cách pha cà phê Syphon ngon</strong></h3>\r\n\r\n<p>Nguyên lý pha cà phê bằng bình pha cà phê Syphon tương đối đơn giản. Người Nhật Bản đặc biệt yêu thích cà phê Syphon, họ cho rằng: đây là cách pha cafe “tuyệt vời nhất” từ trước đến nay.</p>\r\n\r\n<p><img alt=\"cafe syphon\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Cach-pha-ca-phe-Syphon-300x182.jpg\" style=\"height:412px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê Syphon khá cầu kỳ và nghệ sĩ.</p>\r\n\r\n<p>Tuy không hiện đại như các dòng máy pha cà phê khác, bình Syphon chủ yếu dùng bằng tay (thao tác hoàn toàn thủ công), nhưng nó lại tạo ra hương vị cà phê thơm hảo hạng, giữ nguyên bản cà phê nguyên chất.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê xay thô</li>\r\n	<li>Bình Syphon</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót 250ml nước vào đáy bình (có thể rót nước nóng vào bình để quá trình xảy ra nhanh hơn).</li>\r\n	<li>Đặt màng lọc vào phễu lọc.</li>\r\n	<li>Nhẹ nhàng đặt bình lọc vào bình đáy, xiếc chặt và đặt bình Syphon lên giá đỡ.</li>\r\n	<li>Đốt đèn cồn và đợi đến khi nước bắt đầu sôi, nước sẽ từ từ đẩy lên bình lọc.</li>\r\n	<li>Khi bình lọc đã hút đầy nước, đổ 15g bột cà phê vào và khuấy nhẹ.</li>\r\n	<li>Ủ cà phê trong 60 giây.</li>\r\n	<li>Khuấy nhẹ và tắt lửa, cà phê từ từ rút xuống bình đáy.</li>\r\n	<li>Khi cà phê đã rút xuống hết bình đáy, nhẹ nhàng tháo bình lọc, rót cà phê ra tách và thưởng thức.</li>\r\n</ul>\r\n\r\n<h2><strong>Cách pha cà phê kiểu ngâm</strong></h2>\r\n\r\n<h3><strong>6. Cách pha cà phê AeroPress ngon</strong></h3>\r\n\r\n<p>Máy pha cà phê AeroPress có tên gọi khác là máy ép cà phê siêu tốc. Không chiếc máy pha cà phê nào nhanh và hiệu quả như AeroPress với thời gian pha cà phê chưa đầy 2 phút. Máy AeroPress có thiết kế nhỏ gọn, đơn giản, thích hợp pha cà phê gia đình.</p>\r\n\r\n<p><img alt=\"cafe AeroPress\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cach-pha-ca-phe-AeroPress-300x214.jpg\" style=\"height:484px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê bằng thiết bị phát minh bởi Aerobie chủ tịch Alan Adler.</p>\r\n\r\n<p>AeroPress giữ đúng hương vị của cà phê nguyên chất. Nếu bạn là người có thói quen uống cà phê mỗi ngày, hay mua ngay 1 chiếc máy AeroPress. Cách dùng AeroPress vô cùng đơn giản, đảm bảo mang đến cho bạn những ly cafe hảo hạng nhất.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê xay nhuyễn</li>\r\n	<li>Phin Aeropress</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Đặt bi-tông vào thân phin.</li>\r\n	<li>Đặt phin AeroPress lật ngược lên cân.</li>\r\n	<li>Xay 18g cà phê cho vào thân phin.</li>\r\n	<li>Rót nhanh 270 ml sôi 92-96 độ C vào thân phin. Khuấy đều và giữ phin tránh bị đổ.</li>\r\n	<li>Ủ hỗn hợp nước và cà phê 30 giây. Khuấy đều, ủ tiếp 30 giây rồi khuấy tiếp.</li>\r\n	<li>Đặt giấy lọc vào phin và vặn chặt.</li>\r\n	<li>Lật ngược phin Aerapress, nhẹ nhàng đặt lên tách và và bắt đầu ấn để chiết xuất cà phê.</li>\r\n	<li>Cà phê sẽ sẵn sàng để thưởng thức sau khoảng 20-30 giây.</li>\r\n</ul>\r\n\r\n<h3><strong>7. Cách pha cafe French Press ngon</strong></h3>\r\n\r\n<p>Nguyên lý hoạt động của bình pha cà phê French Press gần giống với phin của Việt Nam. Tuy nhiên, bình French Press có thiết kế kín và tạo ra sức ép lớn hơn với bột cà phê. Việc làm có 2 ưu điểm là: Một là không làm bay hơi cà phê; Hai là chiết xuất 100% hương vị cà phê.</p>\r\n\r\n<p><img alt=\"French Press cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/French-Press-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>French Press là một cách pha cà phê cổ điển được ưa chuộng hiện nay.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Bột cà phê xay vừa</li>\r\n	<li>Bình French Press</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót nước sôi để ủ và làm nóng bình. Sau đó đổ bỏ nước và đặt bình lên cân.</li>\r\n	<li>Xay 30 gram cà phê bỏ vào phin lọc.</li>\r\n	<li>Rót 500 ml nước sôi ở nhiệt độ 90-94 độ C vào bình.</li>\r\n	<li>Khuấy đều hỗn hợp cà phê và nước sôi.</li>\r\n	<li>Ngâm hỗ hợp trong vòng 4 phút, sau đó khuấy nhẹ bề mặt của hỗn hợp. Sử dụng muỗng nhỏ để hớt bọt nổi trên mặt bình lọc</li>\r\n	<li>Đặt tấm lọc vào bình, nhẹ nhàng ấn tấm lọc, đẩy bột cà phê xuống đáy bình.</li>\r\n	<li>Lắng cặn và thưởng thức cà phê.</li>\r\n</ul>\r\n\r\n<h2><strong>Cách pha cà phê bằng áp suất</strong></h2>\r\n\r\n<h3><strong>8. Cà phê Espresso</strong></h3>\r\n\r\n<p>Nguyên lý hoạt động của máy pha cà phê Espresso là dùng áp suất lớn nước sôi phun thẳng vào bột cà phê nguyên chất, để ép hết nguyên chất có trong bột cà phê và tạo thành dung dịch đặc sánh. Máy pha cà phê Espresso có 2 loại là máy tự động 100% và máy cơ.</p>\r\n\r\n<p><img alt=\"Espresso cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Espresso-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê Espresso</p>\r\n\r\n<p>Đối với loại máy tự động, bạn chỉ cho bột cafe vào máy, sau đó chọn chế độ pha và ấn nút khởi động. Máy Espresso hoạt động trên nguyên lý tự động 100%, không yêu cầu con người phải làm bất kỳ việc gì. Kết quả là bạn sẽ có những ly cà phê thơm ngon theo ý muốn.</p>\r\n\r\n<p>Đối với máy Espresso cơ, bạn phải thao tác khá nhiều trong quá trình pha chế cà phê. Nói đúng hơn là bạn phải túc trực bên cạnh chiếc máy, đến công đoạn nào là bạn phải can thiệp công đoạn đó.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-espresso/\">Cafe Espresso là gì? Nghệ thuật pha chế cà phê Espresso</a></p>\r\n\r\n<h3><strong>9. Cà phê Americano</strong></h3>\r\n\r\n<p>Người ta thường gọi cà phê Americano là cà phê của Người Mỹ. Nguồn gốc sâu xa của cà phê Americano bắt nguồn từ nước Ý – nơi ngự trị của cà phê Espresso. Cà phê Espresso có vị đắng nhiều. Chính vì vậy người Mỹ đã tìm mọi cách để giảm bớt vị đắng và chua của cà phê Espresso. Phương pháp duy nhất là gia tăng tỷ lệ nước trong khi pha cà phê Espresso, ngay lập tức vị chua và đắng sẽ giảm xuống.</p>\r\n\r\n<p><img alt=\"Americano Coffee\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Americano-Coffee-300x228.jpg\" style=\"height:518px; width:680px\" /></p>\r\n\r\n<p>Americano Coffee kiểu cà phê biến thể được tạo ra bởi những người lính Mỹ.</p>\r\n\r\n<p>Cà phê Americano có hương vị thơm ngon, hấp dẫn, gần giống với cà phê Espresso. Nếu thưởng thức kỹ, bạn sẽ nhận ra sự ngọt ngào đến từ cà phê Americano (điều này không có ở cà phê Espresso).</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-americano/\">Americano là gì – Cách pha cà phê Americano chuẩn Mỹ</a></p>\r\n\r\n<h2><strong>Cách pha cà phê biến thể</strong></h2>\r\n\r\n<h3><strong>10. Cà phê Capuchino</strong></h3>\r\n\r\n<p>Nếu có ai hỏi “loại cà phê nào dễ uống nhất hiện nay”, thì chắc chắn đó là cà phê Capuchino. Cà phê Capuchino thích hợp với cả phụ nữ và đàn ông, nhất là những người yêu thích đồ ngọt. Không đắng gắt như cafe đen, không đơn giản như cà phê sữa, Capuchino ngọt ngào và tinh tế hơn nhiều.</p>\r\n\r\n<p><img alt=\"Capuchino cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Capuchino-1-300x193.jpg\" style=\"height:438px; width:680px\" /></p>\r\n\r\n<p>Capuchino cách pha cà phê thu hút giới trẻ hiện nay.</p>\r\n\r\n<p>Ba nguyên liệu chính để tạo ra cà phê Capuchino là: bột cà phê nguyên chất, sữa và bọt sữa. Trong đó sữa và bọt sữa có tỷ lệ ngang bằng nhau. Cà phê Capuchino có vị ngọt bùi của sữa, một chút béo ngậy của bọt sữa, thêm chút đắng ngọt của cà phê.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-capuchino/\">Capuchino là gì? Mách bạn cách pha cafe Cappuccino ngon tại nhà</a></p>\r\n\r\n<h3><strong>11. Cafe Latte</strong></h3>\r\n\r\n<p>Cà phê Latte hay còn gọi là cafe bọt sữa. Nếu nhìn thoáng qua, bạn sẽ thấy nó giống hệt với cà phê Capuchino. Tuy nhiên, khi thưởng thức bạn sẽ nhận ra sự khác biệt cơ bản giữa cà phê Latte và Capuchino. Nếu như ở cà phê Capuchino, lượng sữa nóng và bọt sữa tương đương nhau, thì ở cà phê Latte tỷ lệ bọt sữa giảm đi bằng 1/2 lượng sữa nóng. Bên cạnh cafe Capuchino, một cách pha cà phê ngon khác cũng khá giống với Latte là Caffè&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-macchiato/\">Macchiato</a>.&nbsp;</p>\r\n\r\n<p><img alt=\"latte coffee\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/latte-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cafe Latte được tạo ra bởi các Barista tài hoa.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-latte/\">Latte là gì? Cách pha ly cafe Latte như thế nào?</a></p>\r\n\r\n<h3><strong>12. Cà phê Mocha</strong></h3>\r\n\r\n<p>Cà phê Mocha là sự kết hợp tuyệt vời giữa cà phê nguyên chất và chocolate đen. Điểm đặc biệt của cà phê Mocha là bột cà phê nguyên chất phải được pha theo kiểu Espresso (tức là dùng máy pha cà phê Espresso tự động 100%&nbsp;hoặc máy Espresso cơ tay), sau đó trộn thêm bột chocolate theo tỷ lệ nhất định. Để ly cafe Mocha trở nên thơm ngon và hấp dẫn, người ta thường cho thêm một ít bọt sữa trắng.</p>\r\n\r\n<p><img alt=\"cà phê Mocha\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cafe-mocha-300x211.jpg\" style=\"height:478px; width:680px\" /></p>\r\n\r\n<p>Cà phê Mocha</p>\r\n\r\n<p>Chocolate có tác dụng giảm vị đắng, gia tăng hương vị thơm ngon và dễ uống cho cà phê nguyên chất. Bọt sữa có vị béo ngậy, ngọt vừa khiến ly cà phê Mocha thêm phần lôi cuốn.</p>\r\n\r\n<p><strong>Xem bài viết:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-mocha/\">Cà phê Mocha là gì? Cách pha cafe Mocha nóng và đá</a></p>\r\n\r\n<h3><strong>13. Cafe Frappuccino</strong></h3>\r\n\r\n<p>Cà phê Frappuccino là một trong những sản phẩm nổi tiếng của Tập đoàn Starbucks, Mỹ. Starbucks đã tiến hành đăng ký bản quyền cho những sản phẩm của mình. Như vậy,&nbsp;<strong>cách pha cà phê</strong>&nbsp;Frappuccino là sở hữu trí tuệ riêng của Tập đoàn Starbucks. Hiểu theo cách này thì: những quán cafe không thuộc hệ thống Starbuck sẽ không bao giờ biết đến công thức pha chế cà phê Frappuccino.</p>\r\n\r\n<p><img alt=\"frappuccino cafe\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/frappuccino-1-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Frappuccino, ly cà phê hấp dẫn hàng triệu người trên thế giới.</p>\r\n\r\n<p>Cafe Frappuccino đang làm mưa làm gió trên thị trường thế giới. Cửa hàng Starbucks xuất hiện nhiều không tưởng. Lượng khách đến với họ đông đảo hơn các thương hiệu khác. Điều này chứng tỏ cà phê Frappuccino rất thơm ngon và hấp dẫn. Có như vậy mới chinh phục được hàng triệu người dân trên thế giới. Cà phê Frappuccino có nhiều vị khác nhau. Nó là sự kết hợp giữa cà phê nguyên chất với các nguyên liệu sữa, đường, kem, trứng gà, siro,..</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-frappuccino/\">Frappuccino là gì? Cách pha cafe Frappuccino chuẩn như Starbucks</a></p>\r\n\r\n<h3><strong>14. Cà phê trứng</strong></h3>\r\n\r\n<p>Cứ nghĩ rằng cà phê nguyên chất và trứng không bao giờ kết hợp được với nhau, ai ngờ lại cho ra sản phẩm tuyệt vời đến vậy. Trứng gà làm tăng độ béo ngậy của cafe, thêm chút đường (hoặc sữa) để giảm vị đắng có trong cà phê. Bạn cần một chiếc máy đánh trứng để trộn đều các nguyên liệu với nhau. Ly cà phê trứng có màu vàng của trứng gà, màu trắng của sữa hoặc kem, màu nâu đen của cà phê nguyên chất.</p>\r\n\r\n<p><img alt=\"cách pha cà phê trứng\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/ca-phe-trung-1-300x190.jpg\" style=\"height:431px; width:680px\" /></p>\r\n\r\n<p>Cà phê trứng, thức uống đặc trưng của người Hà Nội.</p>\r\n\r\n<p>Những ai đã thưởng thức cà phê trứng 1 lần sẽ muốn dùng thêm những lần tiếp theo. Hương vị đắng ngọt, bùi bùi, béo ngậy,… chắc chỉ có ở cà phê trứng.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-trung/\">Cà phê trứng – Mách bạn 3 cách làm cafe trứng ngon độc đáo</a></p>\r\n\r\n<h3><strong>15. Cà phê kem</strong></h3>\r\n\r\n<p>Lứa tuổi học trò (hay tuổi Teen) rất ít uống cà phê. Các bạn cho rằng cà phê quá đắng và khó uống, nó không “ngon lành” như những đồ uống khác. Từ khi cà phê kem xuất hiện, suy nghĩ của các bạn tuổi teen thay đổi hoàn toàn. Các bạn yêu thích cà phê hơn, và cho rằng đây là đồ uống vô cùng thú vị. Tất cả là nhờ lớp kem bên trên, thường là kem tươi, được làm từ sữa và đường.</p>\r\n\r\n<p><img alt=\"ca phe kem\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/ca-phe-kem-300x212.jpg\" style=\"height:480px; width:680px\" /></p>\r\n\r\n<p>Cà phê kem, ly cafe của giới trẻ vào những ngày hè.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-kem/\">Hướng dẫn 5 Cách làm cafe kem ngon độc đáo</a></p>\r\n\r\n<p>Ngoài ra để menu quán cà phê phong phú, bạn có thể tham khảo nhiều cách pha cà phê khác nhau của Bonjour Coffee:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-da-xay/\">cà phê đá xay</a>,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-muoi/\">cà phê muối</a>&nbsp;đặc trưng xứ Huế,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-sua-tuoi/\">cà phê sữa tươi</a>, hay món&nbsp;<a href=\"https://bonjourcoffee.vn/blog/bac-xiu/\">bạc xỉu</a>&nbsp;trứ danh.</p>\r\n\r\n<p>Trên đây là hơn 15&nbsp;<strong>cách pha cà phê&nbsp;</strong>phổ biến nhất hiện nay. Nếu bạn có ý định mở quán cafe hay trở thành nhân viên pha chế chuyên nghiệp, hãy thử ngay các&nbsp;<strong>cách pha cafe</strong>&nbsp;ở trên. Cà phê ngon, hấp dẫn, trang trí đẹp mắt chính là yếu tố thu hút khách hàng; góp phần làm nên thành công trong kinh doanh cà phê.</p>', 0, '2023-09-17 09:32:09', '2023-09-17 14:43:12'),
(8, 'storage/news/15-cach-pha-cafe-ngon-cho-quan-ca-phe-cua-ban-1694943238.jpg', '17 CÔNG DỤNG CỦA CÀ PHÊ VỚI SỨC KHOẺ BẠN NÊN BIẾT', '17-cong-dung-cua-ca-phe-voi-suc-khoe-ban-nen-biet', 'Bạn muốn tìm hiểu về các cách pha cafe để tự mình pha một ly cà phê ngon? Bạn đang có ý định kinh doanh cafe và muốn tìm hiểu các cách pha cà phê cho quán của mình? Bạn đang muốn trở thành Barista và muốn tìm hiểu về pha chế. Nếu vậy, bài viết này chắc chắn dành cho bạn. Tại đây, Harper 7 Coffee sẽ giới thiệu hơn 15 cách pha cà phê giúp bạn có thông tin đầy đủ về các phương pháp pha chế cà phê ngon hiện nay.', '<h2><strong>Cách pha cà phê kiểu nhỏ giọt</strong></h2>\r\n\r\n<h3><strong>1. Cà phê phin</strong></h3>\r\n\r\n<p><strong>Cách pha cafe phin</strong>&nbsp;xuất hiện từ thế kỷ 19 người và là phương pháp phổ biến nhất tại Việt Nam hiện nay. Phương pháp này dựa trên nguyên tắc là nước nóng đi qua bột&nbsp;<a href=\"https://bonjourcoffee.vn/ca-phe-nguyen-chat.html\">cà phê</a>&nbsp;cho ra nước cà phê.</p>\r\n\r\n<p><img alt=\"cách pha cà phe phin\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cach-pha-ca-phe-phin-300x210.jpg\" style=\"height:477px; width:680px\" /></p>\r\n\r\n<p>Cà phê phin cách pha cafe độc đáo của người Việt Nam.</p>\r\n\r\n<p>Cafe đặc, loãng, đắng gắt hay đắng ngọt phần lớn là do tay người pha. Bên cạnh đó, chất lượng cà phê cũng vô cùng quan trọng. Bạn nên chọn cà phê&nbsp;rang xay nguyên chất&nbsp;để đảm bảo sức khoẻ và cho hương vị tuyệt hảo nhất.</p>\r\n\r\n<p>Bên cạnh kỹ thuật pha cafe,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-tron-ca-phe-ngon/\">cách phối trộn cà phê</a>&nbsp;cũng là phương pháp để cho ra ly cafe phù hợp gu khách hàng. Tùy theo khách, người sành cafe, nam giới, nữ giới hay các bạn tuổi teen mà chúng ta có tỉ lệ phối trộn cafe khác nhau.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-pha-cafe-phin/\">Hướng dẫn cách pha cà phê phin ngon hút khách</a></p>\r\n\r\n<h3><strong>2. Cà phê sữa</strong></h3>\r\n\r\n<p>Nếu bạn muốn uống cà phê sữa đá, hãy để sẵn trong chiếc ly một ít sữa, chờ từng giọt cà phê nhỏ xuống. Khi nào cà phê nhỏ hết, hãy khuấy đều cà phê, sữa và thêm ít đá. Đảm bảo rằng bạn sẽ có một ly cà phê ngon.&nbsp;</p>\r\n\r\n<p class=\"text-center\"><img alt=\"cách pha cà phê sữa đá\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Ca-phe-sua-da-1-300x196.jpg\" style=\"height:445px; width:680px\" /></p>\r\n\r\n<p>Cà phê sữa đá, thức uống đặc trưng của người Sài Gòn.</p>\r\n\r\n<p>Sữa có tác dụng giảm bớt vị đắng của cà phê, gia tăng vị ngọt, tạo ra vị béo mà không làm mất hương vị ban đầu của cà phê.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-sua-da/\">Cách pha ly cà phê sữa đá ngon đậm chất Sài Gòn</a></p>\r\n\r\n<h3><strong>3. Cách pha cafe Pour over ngon</strong></h3>\r\n\r\n<p>Nguyên lý pha cà phê như sau: để nước sôi đi qua bột cà phê, bã cà phê được giữ lại trên bộ lọc còn nước cafe chảy xuống bình đựng cà phê bên dưới. Cách pha cà phê pour over cho ly cà phê đầy đủ hương vị nhất, và thường phải sử dụng cà phê Specialty để pha.&nbsp;</p>\r\n\r\n<p class=\"text-center\"><img alt=\"Cafe pour over\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Pour-over-coffee-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Khi pha cafe theo kiểu Pour over, bạn sẽ cảm nhận trọn vẹn hương vị của cà phê.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê specialty xay mịn vừa</li>\r\n	<li>Phễu V60 và giấy lọc</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Bình đựng cà phê</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Dùng nước sôi 90-96 độ tráng rửa giấy lọc, phin V60 để khử mùi giấy và làm nóng phễu.</li>\r\n	<li>Đặt bình đựng cà phê và phin V60 lên cân.</li>\r\n	<li>Cân 20g hạt cà phê, cho vào máy xay vừa, sau đó cho vào phễu V60.</li>\r\n	<li>Rót 60ml nước sôi 90-96 độ C vào phin lọc theo vòng tròn chiều kim đồng hồ. Ủ cà phê trong vòng 30 giây. Rót tiếp 240ml nước sôi còn lại vào phin. Rót chậm, liên tục và theo vòng tròn trong vòng 2 phút.</li>\r\n	<li>Sau 2:00 – 2:30, cà phê đã sẵn sàng để thưởng thức.</li>\r\n</ul>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-pha-pour-over/\">Pour over là gì? Cách pha cà phê pour over ngon như thế nào?</a></p>\r\n\r\n<p>Bên cạnh cà phê Pour over, bạn có thể tham khảo cách pha&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cold-brew/\">cà phê Cold Brew</a>&nbsp;của Bonjour Coffee.&nbsp;</p>\r\n\r\n<h2><strong>Cách pha cafe kiểu nấu sôi</strong></h2>\r\n\r\n<h3><strong>4. Cách pha cà phê Moka Pot ngon</strong></h3>\r\n\r\n<p>Moka Pot thực chất là 1 chiếc bình đun cà phê có lịch sử lâu đời, hơi thiên một chút về kiểu pha dùng áp suất. Mỗi Moka Pot pha được khoảng 2-3 ly cà phê nhỏ. Nguyên lý hoạt động của Moka Pot là dùng hơi nước nóng để pha chế cà phê. Cách pha cafe Moka Pot có đôi chút khác biệt so với các phương pháp khác. Thứ nhất là bạn phải đun trực tiếp cà phê trên bếp, thứ hai là căn chỉnh kỹ lưỡng tỷ lệ nước và bột cà phê.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"Cafe Moka Pot\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Moka-Pot-ca-phe-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Với cách pha cafe bằng bình Moka pot bạn có thể có được một cốc “Espresso mộc mạc”.</p>\r\n\r\n<p><strong>Chuẩn bị dụng cụ</strong></p>\r\n\r\n<ul>\r\n	<li>Bột cà phê xay thô</li>\r\n	<li>Bình Moka</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót 500ml nước vào bình đáy (mực nước nằm dưới van bình).</li>\r\n	<li>Lấy 25g bột cà phê vào chén lọc, đặt chén lọc vào bình đáy và vặn chặt thân bình vào đáy bình.</li>\r\n	<li>Đặt bình lên bếp, khi nước sôi có thể mở nắp để quan sát quá trình chiết xuất cà phê.</li>\r\n	<li>Khi nước cà phê từ bình bên dưới đi lên bắt đầu nhạt dần và bong bóng nổi lên thì lấy bình ra khỏi bếp.</li>\r\n	<li>Rót cà phê ra tách và thưởng thức.</li>\r\n</ul>\r\n\r\n<h3><strong>5. Cách pha cà phê Syphon ngon</strong></h3>\r\n\r\n<p>Nguyên lý pha cà phê bằng bình pha cà phê Syphon tương đối đơn giản. Người Nhật Bản đặc biệt yêu thích cà phê Syphon, họ cho rằng: đây là cách pha cafe “tuyệt vời nhất” từ trước đến nay.</p>\r\n\r\n<p><img alt=\"cafe syphon\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Cach-pha-ca-phe-Syphon-300x182.jpg\" style=\"height:412px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê Syphon khá cầu kỳ và nghệ sĩ.</p>\r\n\r\n<p>Tuy không hiện đại như các dòng máy pha cà phê khác, bình Syphon chủ yếu dùng bằng tay (thao tác hoàn toàn thủ công), nhưng nó lại tạo ra hương vị cà phê thơm hảo hạng, giữ nguyên bản cà phê nguyên chất.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê xay thô</li>\r\n	<li>Bình Syphon</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót 250ml nước vào đáy bình (có thể rót nước nóng vào bình để quá trình xảy ra nhanh hơn).</li>\r\n	<li>Đặt màng lọc vào phễu lọc.</li>\r\n	<li>Nhẹ nhàng đặt bình lọc vào bình đáy, xiếc chặt và đặt bình Syphon lên giá đỡ.</li>\r\n	<li>Đốt đèn cồn và đợi đến khi nước bắt đầu sôi, nước sẽ từ từ đẩy lên bình lọc.</li>\r\n	<li>Khi bình lọc đã hút đầy nước, đổ 15g bột cà phê vào và khuấy nhẹ.</li>\r\n	<li>Ủ cà phê trong 60 giây.</li>\r\n	<li>Khuấy nhẹ và tắt lửa, cà phê từ từ rút xuống bình đáy.</li>\r\n	<li>Khi cà phê đã rút xuống hết bình đáy, nhẹ nhàng tháo bình lọc, rót cà phê ra tách và thưởng thức.</li>\r\n</ul>\r\n\r\n<h2><strong>Cách pha cà phê kiểu ngâm</strong></h2>\r\n\r\n<h3><strong>6. Cách pha cà phê AeroPress ngon</strong></h3>\r\n\r\n<p>Máy pha cà phê AeroPress có tên gọi khác là máy ép cà phê siêu tốc. Không chiếc máy pha cà phê nào nhanh và hiệu quả như AeroPress với thời gian pha cà phê chưa đầy 2 phút. Máy AeroPress có thiết kế nhỏ gọn, đơn giản, thích hợp pha cà phê gia đình.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"cafe AeroPress\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cach-pha-ca-phe-AeroPress-300x214.jpg\" style=\"height:484px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê bằng thiết bị phát minh bởi Aerobie chủ tịch Alan Adler.</p>\r\n\r\n<p>AeroPress giữ đúng hương vị của cà phê nguyên chất. Nếu bạn là người có thói quen uống cà phê mỗi ngày, hay mua ngay 1 chiếc máy AeroPress. Cách dùng AeroPress vô cùng đơn giản, đảm bảo mang đến cho bạn những ly cafe hảo hạng nhất.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Cà phê xay nhuyễn</li>\r\n	<li>Phin Aeropress</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Đặt bi-tông vào thân phin.</li>\r\n	<li>Đặt phin AeroPress lật ngược lên cân.</li>\r\n	<li>Xay 18g cà phê cho vào thân phin.</li>\r\n	<li>Rót nhanh 270 ml sôi 92-96 độ C vào thân phin. Khuấy đều và giữ phin tránh bị đổ.</li>\r\n	<li>Ủ hỗn hợp nước và cà phê 30 giây. Khuấy đều, ủ tiếp 30 giây rồi khuấy tiếp.</li>\r\n	<li>Đặt giấy lọc vào phin và vặn chặt.</li>\r\n	<li>Lật ngược phin Aerapress, nhẹ nhàng đặt lên tách và và bắt đầu ấn để chiết xuất cà phê.</li>\r\n	<li>Cà phê sẽ sẵn sàng để thưởng thức sau khoảng 20-30 giây.</li>\r\n</ul>\r\n\r\n<h3><strong>7. Cách pha cafe French Press ngon</strong></h3>\r\n\r\n<p>Nguyên lý hoạt động của bình pha cà phê French Press gần giống với phin của Việt Nam. Tuy nhiên, bình French Press có thiết kế kín và tạo ra sức ép lớn hơn với bột cà phê. Việc làm có 2 ưu điểm là: Một là không làm bay hơi cà phê; Hai là chiết xuất 100% hương vị cà phê.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"French Press cafe\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/French-Press-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>French Press là một cách pha cà phê cổ điển được ưa chuộng hiện nay.</p>\r\n\r\n<p><strong>Chuẩn bị</strong></p>\r\n\r\n<ul>\r\n	<li>Bột cà phê xay vừa</li>\r\n	<li>Bình French Press</li>\r\n	<li>Cân tiểu ly</li>\r\n	<li>Tách cà phê</li>\r\n</ul>\r\n\r\n<p><strong>Cách pha</strong></p>\r\n\r\n<ul>\r\n	<li>Rót nước sôi để ủ và làm nóng bình. Sau đó đổ bỏ nước và đặt bình lên cân.</li>\r\n	<li>Xay 30 gram cà phê bỏ vào phin lọc.</li>\r\n	<li>Rót 500 ml nước sôi ở nhiệt độ 90-94 độ C vào bình.</li>\r\n	<li>Khuấy đều hỗn hợp cà phê và nước sôi.</li>\r\n	<li>Ngâm hỗ hợp trong vòng 4 phút, sau đó khuấy nhẹ bề mặt của hỗn hợp. Sử dụng muỗng nhỏ để hớt bọt nổi trên mặt bình lọc</li>\r\n	<li>Đặt tấm lọc vào bình, nhẹ nhàng ấn tấm lọc, đẩy bột cà phê xuống đáy bình.</li>\r\n	<li>Lắng cặn và thưởng thức cà phê.</li>\r\n</ul>\r\n\r\n<h2><strong>Cách pha cà phê bằng áp suất</strong></h2>\r\n\r\n<h3><strong>8. Cà phê Espresso</strong></h3>\r\n\r\n<p>Nguyên lý hoạt động của máy pha cà phê Espresso là dùng áp suất lớn nước sôi phun thẳng vào bột cà phê nguyên chất, để ép hết nguyên chất có trong bột cà phê và tạo thành dung dịch đặc sánh. Máy pha cà phê Espresso có 2 loại là máy tự động 100% và máy cơ.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"Espresso cafe\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Espresso-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cách pha cà phê Espresso</p>\r\n\r\n<p>Đối với loại máy tự động, bạn chỉ cho bột cafe vào máy, sau đó chọn chế độ pha và ấn nút khởi động. Máy Espresso hoạt động trên nguyên lý tự động 100%, không yêu cầu con người phải làm bất kỳ việc gì. Kết quả là bạn sẽ có những ly cà phê thơm ngon theo ý muốn.</p>\r\n\r\n<p>Đối với máy Espresso cơ, bạn phải thao tác khá nhiều trong quá trình pha chế cà phê. Nói đúng hơn là bạn phải túc trực bên cạnh chiếc máy, đến công đoạn nào là bạn phải can thiệp công đoạn đó.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-espresso/\">Cafe Espresso là gì? Nghệ thuật pha chế cà phê Espresso</a></p>\r\n\r\n<h3><strong>9. Cà phê Americano</strong></h3>\r\n\r\n<p>Người ta thường gọi cà phê Americano là cà phê của Người Mỹ. Nguồn gốc sâu xa của cà phê Americano bắt nguồn từ nước Ý – nơi ngự trị của cà phê Espresso. Cà phê Espresso có vị đắng nhiều. Chính vì vậy người Mỹ đã tìm mọi cách để giảm bớt vị đắng và chua của cà phê Espresso. Phương pháp duy nhất là gia tăng tỷ lệ nước trong khi pha cà phê Espresso, ngay lập tức vị chua và đắng sẽ giảm xuống.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"Americano Coffee\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Americano-Coffee-300x228.jpg\" style=\"height:518px; width:680px\" /></p>\r\n\r\n<p>Americano Coffee kiểu cà phê biến thể được tạo ra bởi những người lính Mỹ.</p>\r\n\r\n<p>Cà phê Americano có hương vị thơm ngon, hấp dẫn, gần giống với cà phê Espresso. Nếu thưởng thức kỹ, bạn sẽ nhận ra sự ngọt ngào đến từ cà phê Americano (điều này không có ở cà phê Espresso).</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-americano/\">Americano là gì – Cách pha cà phê Americano chuẩn Mỹ</a></p>\r\n\r\n<h2><strong>Cách pha cà phê biến thể</strong></h2>\r\n\r\n<h3><strong>10. Cà phê Capuchino</strong></h3>\r\n\r\n<p>Nếu có ai hỏi “loại cà phê nào dễ uống nhất hiện nay”, thì chắc chắn đó là cà phê Capuchino. Cà phê Capuchino thích hợp với cả phụ nữ và đàn ông, nhất là những người yêu thích đồ ngọt. Không đắng gắt như cafe đen, không đơn giản như cà phê sữa, Capuchino ngọt ngào và tinh tế hơn nhiều.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"Capuchino cafe\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/Capuchino-1-300x193.jpg\" style=\"height:438px; width:680px\" /></p>\r\n\r\n<p>Capuchino cách pha cà phê thu hút giới trẻ hiện nay.</p>\r\n\r\n<p>Ba nguyên liệu chính để tạo ra cà phê Capuchino là: bột cà phê nguyên chất, sữa và bọt sữa. Trong đó sữa và bọt sữa có tỷ lệ ngang bằng nhau. Cà phê Capuchino có vị ngọt bùi của sữa, một chút béo ngậy của bọt sữa, thêm chút đắng ngọt của cà phê.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-capuchino/\">Capuchino là gì? Mách bạn cách pha cafe Cappuccino ngon tại nhà</a></p>\r\n\r\n<h3><strong>11. Cafe Latte</strong></h3>\r\n\r\n<p>Cà phê Latte hay còn gọi là cafe bọt sữa. Nếu nhìn thoáng qua, bạn sẽ thấy nó giống hệt với cà phê Capuchino. Tuy nhiên, khi thưởng thức bạn sẽ nhận ra sự khác biệt cơ bản giữa cà phê Latte và Capuchino. Nếu như ở cà phê Capuchino, lượng sữa nóng và bọt sữa tương đương nhau, thì ở cà phê Latte tỷ lệ bọt sữa giảm đi bằng 1/2 lượng sữa nóng. Bên cạnh cafe Capuchino, một cách pha cà phê ngon khác cũng khá giống với Latte là Caffè&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-macchiato/\">Macchiato</a>.&nbsp;</p>\r\n\r\n<p class=\"text-center\"><img alt=\"latte coffee\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/latte-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Cafe Latte được tạo ra bởi các Barista tài hoa.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-latte/\">Latte là gì? Cách pha ly cafe Latte như thế nào?</a></p>\r\n\r\n<h3><strong>12. Cà phê Mocha</strong></h3>\r\n\r\n<p>Cà phê Mocha là sự kết hợp tuyệt vời giữa cà phê nguyên chất và chocolate đen. Điểm đặc biệt của cà phê Mocha là bột cà phê nguyên chất phải được pha theo kiểu Espresso (tức là dùng máy pha cà phê Espresso tự động 100%&nbsp;hoặc máy Espresso cơ tay), sau đó trộn thêm bột chocolate theo tỷ lệ nhất định. Để ly cafe Mocha trở nên thơm ngon và hấp dẫn, người ta thường cho thêm một ít bọt sữa trắng.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"cà phê Mocha\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/cafe-mocha-300x211.jpg\" style=\"height:478px; width:680px\" /></p>\r\n\r\n<p>Cà phê Mocha</p>\r\n\r\n<p>Chocolate có tác dụng giảm vị đắng, gia tăng hương vị thơm ngon và dễ uống cho cà phê nguyên chất. Bọt sữa có vị béo ngậy, ngọt vừa khiến ly cà phê Mocha thêm phần lôi cuốn.</p>\r\n\r\n<p><strong>Xem bài viết:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-mocha/\">Cà phê Mocha là gì? Cách pha cafe Mocha nóng và đá</a></p>\r\n\r\n<h3><strong>13. Cafe Frappuccino</strong></h3>\r\n\r\n<p>Cà phê Frappuccino là một trong những sản phẩm nổi tiếng của Tập đoàn Starbucks, Mỹ. Starbucks đã tiến hành đăng ký bản quyền cho những sản phẩm của mình. Như vậy,&nbsp;<strong>cách pha cà phê</strong>&nbsp;Frappuccino là sở hữu trí tuệ riêng của Tập đoàn Starbucks. Hiểu theo cách này thì: những quán cafe không thuộc hệ thống Starbuck sẽ không bao giờ biết đến công thức pha chế cà phê Frappuccino.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"frappuccino cafe\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/frappuccino-1-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Frappuccino, ly cà phê hấp dẫn hàng triệu người trên thế giới.</p>\r\n\r\n<p>Cafe Frappuccino đang làm mưa làm gió trên thị trường thế giới. Cửa hàng Starbucks xuất hiện nhiều không tưởng. Lượng khách đến với họ đông đảo hơn các thương hiệu khác. Điều này chứng tỏ cà phê Frappuccino rất thơm ngon và hấp dẫn. Có như vậy mới chinh phục được hàng triệu người dân trên thế giới. Cà phê Frappuccino có nhiều vị khác nhau. Nó là sự kết hợp giữa cà phê nguyên chất với các nguyên liệu sữa, đường, kem, trứng gà, siro,..</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cafe-frappuccino/\">Frappuccino là gì? Cách pha cafe Frappuccino chuẩn như Starbucks</a></p>\r\n\r\n<h3><strong>14. Cà phê trứng</strong></h3>\r\n\r\n<p>Cứ nghĩ rằng cà phê nguyên chất và trứng không bao giờ kết hợp được với nhau, ai ngờ lại cho ra sản phẩm tuyệt vời đến vậy. Trứng gà làm tăng độ béo ngậy của cafe, thêm chút đường (hoặc sữa) để giảm vị đắng có trong cà phê. Bạn cần một chiếc máy đánh trứng để trộn đều các nguyên liệu với nhau. Ly cà phê trứng có màu vàng của trứng gà, màu trắng của sữa hoặc kem, màu nâu đen của cà phê nguyên chất.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"cách pha cà phê trứng\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/ca-phe-trung-1-300x190.jpg\" style=\"height:431px; width:680px\" /></p>\r\n\r\n<p>Cà phê trứng, thức uống đặc trưng của người Hà Nội.</p>\r\n\r\n<p>Những ai đã thưởng thức cà phê trứng 1 lần sẽ muốn dùng thêm những lần tiếp theo. Hương vị đắng ngọt, bùi bùi, béo ngậy,… chắc chỉ có ở cà phê trứng.&nbsp;</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-trung/\">Cà phê trứng – Mách bạn 3 cách làm cafe trứng ngon độc đáo</a></p>\r\n\r\n<h3><strong>15. Cà phê kem</strong></h3>\r\n\r\n<p>Lứa tuổi học trò (hay tuổi Teen) rất ít uống cà phê. Các bạn cho rằng cà phê quá đắng và khó uống, nó không “ngon lành” như những đồ uống khác. Từ khi cà phê kem xuất hiện, suy nghĩ của các bạn tuổi teen thay đổi hoàn toàn. Các bạn yêu thích cà phê hơn, và cho rằng đây là đồ uống vô cùng thú vị. Tất cả là nhờ lớp kem bên trên, thường là kem tươi, được làm từ sữa và đường.</p>\r\n\r\n<p class=\"text-center\"><img alt=\"ca phe kem\" class=\"text-center\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2020/01/ca-phe-kem-300x212.jpg\" style=\"height:480px; width:680px\" /></p>\r\n\r\n<p>Cà phê kem, ly cafe của giới trẻ vào những ngày hè.</p>\r\n\r\n<p><strong>Xem bài viết:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/ca-phe-kem/\">Hướng dẫn 5 Cách làm cafe kem ngon độc đáo</a></p>\r\n\r\n<p>Ngoài ra để menu quán cà phê phong phú, bạn có thể tham khảo nhiều cách pha cà phê khác nhau của Bonjour Coffee:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-da-xay/\">cà phê đá xay</a>,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-muoi/\">cà phê muối</a>&nbsp;đặc trưng xứ Huế,&nbsp;<a href=\"https://bonjourcoffee.vn/blog/ca-phe-sua-tuoi/\">cà phê sữa tươi</a>, hay món&nbsp;<a href=\"https://bonjourcoffee.vn/blog/bac-xiu/\">bạc xỉu</a>&nbsp;trứ danh.</p>\r\n\r\n<p>Trên đây là hơn 15&nbsp;<strong>cách pha cà phê&nbsp;</strong>phổ biến nhất hiện nay. Nếu bạn có ý định mở quán cafe hay trở thành nhân viên pha chế chuyên nghiệp, hãy thử ngay các&nbsp;<strong>cách pha cafe</strong>&nbsp;ở trên. Cà phê ngon, hấp dẫn, trang trí đẹp mắt chính là yếu tố thu hút khách hàng; góp phần làm nên thành công trong kinh doanh cà phê.</p>', 0, '2023-09-17 09:33:58', '2023-09-17 14:43:15');
INSERT INTO `news` (`id_new`, `image_new`, `title_new`, `slug_new`, `subtitle_new`, `content_new`, `view_new`, `created_at`, `updated_at`) VALUES
(9, 'storage/news/gioi-thieu-7-mon-an-che-bien-voi-cafe-co-the-lam-tai-nha-1694961056.jpg', 'GIỚI THIỆU 7 MÓN ĂN CHẾ BIẾN VỚI CAFE CÓ THỂ LÀM TẠI NHÀ', 'gioi-thieu-7-mon-an-che-bien-voi-cafe-co-the-lam-tai-nha', 'Lấy nguồn cảm hứng từ cà phê, con người đã không ngừng sáng tạo ra rất nhiều món ăn, đồ uống độc đáo. Harper 7 Coffee giới thiệu đến bạn 7 món ăn từ cà phê có thể làm tại nhà. Nào cùng xem những món ăn đó là gì và cách chế biến như thế nào nhé!', '<h2><strong>1. Bánh flan cà phê</strong></h2>\r\n\r\n<p>Bánh flan là một trong những&nbsp;<strong>món ăn từ&nbsp;<a href=\"https://bonjourcoffee.vn/ca-phe-nguyen-chat.html\">cà phê</a></strong>&nbsp;còn được gọi với cái tên bánh Lăng hay caramen. Một loại bánh xuất xứ từ châu Âu, được hấp chín từ các thành phần chính gồm trứng, sữa, nước caramen. Cho đến nay, nó đã phổ biến tại nhiều nơi trên thế giới, trong đó có Việt Nam. Tại đây, bánh flan dần ưa chuộng như một đồ ăn tráng miệng được đông đảo bạn trẻ yêu thích.</p>\r\n\r\n<p><img alt=\"cách làm bánh flan\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/cach-lam-banh-flan-300x198.jpg\" style=\"height:449px; width:680px\" /></p>\r\n\r\n<p>Bánh flan món tráng miệng được ưa chuộng trong các buổi tiệc.</p>\r\n\r\n<p>Ngày nay, bên cạnh các nguyên liệu truyền thống, giữ nguyên bản gốc, còn xuất hiện các loại bánh flan cafe.&nbsp;</p>\r\n\r\n<p>Đối với mỗi độ tuổi và từng người, bánh flan cà phê có tác dụng sau:</p>\r\n\r\n<p><strong>Với trẻ em:&nbsp;</strong>Đây là một món ăn vặt cung cấp nhiều dinh dưỡng đối với trẻ nhỏ. Các chuyên gia cũng đưa ra khuyến cáo, một tuần lễ các bé chỉ nên thưởng thức từ 1-4 chiếc.</p>\r\n\r\n<p><strong>Đối với nam giới:&nbsp;</strong>Là đối tượng thường xuyên vận động, tập luyện thể thao. Mỗi tuần nên sử dụng ba chiếc bánh flan để cung cấp đủ dinh dưỡng, làm chắc khỏe cơ bắp, và còn rất tốt cho sinh lý ở đàn ông.</p>\r\n\r\n<p><strong>Người đang cần giảm cân:&nbsp;&nbsp;</strong>Nếu bạn là tín đồ của bánh flan, nhưng đang trong quá trình giảm cân. Bạn có thể tự làm món bánh-flan cà phê sử dụng loại sữa tươi không đường.</p>\r\n\r\n<p><strong>Xem hướng dẫn:</strong>&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-lam-banh-flan/\">Công Thức Làm Bánh Flan Cà Phê Thơm Ngon Tại Nhà</a></p>\r\n\r\n<h2><strong>2. Đông sương cà phê</strong></h2>\r\n\r\n<p>Đông sương cà phê là một&nbsp;<strong>món ăn từ cà phê</strong>&nbsp;không thể bỏ qua. Nhắc đến cái tên, chắc hẳn đã khiến cho các bạn cảm thấy vô cùng tò mò. Thực chất nó không phải thứ gì đó quá xa lạ. Bạn có thể hiểu đơn giản, đông sương cà phê là cách làm đông sương. Nhằm tạo ra một loại thạch rau câu ở dạng khối.</p>\r\n\r\n<p><img alt=\"cách làm đông sương\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/cach-lam-dong-suong-cafe-300x168.jpeg\" style=\"height:380px; width:680px\" /></p>\r\n\r\n<p>Đông sương cà phê món tráng miệng trong các bữa tiệc gia đình.</p>\r\n\r\n<p>Chúng ta có thể kết hợp cách làm đông sương với nhiều loại nguyên liệu. Trong đó, hương vị cà phê là phổ biến nhất. Nếu bạn tự tin về khả năng sáng tạo, cũng như muốn tự tay mình làm ra những món đồ ăn mới lạ. Hãy tham khảo 2 cách đông sương cà phê dưới đây.</p>\r\n\r\n<p>Đông sương cà phê đơn thuần sẽ tạo ra một loại thạch rau câu, vừa mang hương vị của cà phê. Kết hợp với nước cốt dừa ngọt ngào, thơm nức.</p>\r\n\r\n<p>Đông sương cà phê hương vị phô mai.&nbsp;Với cách đông sương cà phê này, về cơ bản cách thực hiện tương tự như đông sương cà phê đơn thuần. Chỉ khác biệt ở sự bổ sung thêm nguyên liệu sử dụng phô mai thay cho nước cốt dừa. Các bạn còn suy nghĩ gì nữa mà không lăn ngay vào bếp và thực hành thôi.</p>\r\n\r\n<p><strong>Xem hướng dẫn:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-lam-dong-suong-cafe/\">Cách Nấu Đông Sương Rau Câu Cafe Ngon, Đơn Giản</a></p>\r\n\r\n<h2><strong>3. Mứt dừa cà phê</strong></h2>\r\n\r\n<p>Mứt dừa là món mứt không thể thiếu ở các gia đình Việt vào ngày Tết. Nó chẳng khác nào món khai vị cho mọi chuyến viếng thăm, chúc tụng nhau những điều tốt lành trong dịp đầu năm. Trong cái tiết trời se lạnh của đầu xuân, được ngồi nhâm nhi một mứt dừa cùng tách trà nóng thì còn gì thú vị hơn nữa.</p>\r\n\r\n<p><img alt=\"cách làm mứt dừa cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/cach-lam-mut-dua-ca-phe-300x199.jpg\" style=\"height:451px; width:680px\" /></p>\r\n\r\n<p>Mứt dừa vị cà phê tạo hương vị mới cho ngày tết.</p>\r\n\r\n<p>Mỗi loại mứt có một hương vị riêng chẳng “đụng hàng”.Với những bạn không thích đồ ăn quá ngọt, mứt dừa vị cà phê một&nbsp;<strong>món ngon từ cà phê</strong>&nbsp;là lựa chọn không tồi. Để làm mứt dừa cà phê ngon, nguyên liệu chỉ gồm dừa, sữa đặc, đường cát trắng, vani và cuối cùng là bột cafe nguyên chất.</p>\r\n\r\n<p>Cách làm mứt dừa cà phê cũng tương tự như cách làm các loại mứt dừa truyền thống. Điểm đặc trưng và khác biệt duy nhất nằm ở hương vị cà phê đúng điệu. Mứt dừa cà phê sữa sau khi thành phẩm sẽ có màu nâu ngà ngà.</p>\r\n\r\n<p>Khi thưởng thức, bạn sẽ cảm thấy vị bùi bùi của dừa, thơm của vani, thoang thoảng vị thơm của cà phê. Nó sẽ không giống với bất cứ loại mứt nào bạn đã từng ăn. Chắc chắn thưởng thức một lần sẽ khiến bạn nhớ mãi không quên.&nbsp;</p>\r\n\r\n<p><strong>Xem hướng dẫn</strong>:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-lam-mut-dua-cafe/\">Cách Làm Mứt Dừa Vị Cà Phê Thơm Ngon Ngày Tết</a></p>\r\n\r\n<h2>4. Bánh da lợn cà phê</h2>\r\n\r\n<p>Bánh da lợn nghe khá lạ tai với người miền Bắc và Trung, song lại là một trong những món ăn ngon dân dã, quen thuộc của người miền Tây Nam Bộ. Cũng được gọi là bánh nhưng bản chất của bánh da lợn lại nhẹ nhàng hơn, dẻo dẻo mềm mại, ăn vào thanh ngọt. Vậy nên, món ăn này đã đi vào lòng của biết bao nhiêu người con nơi đây.</p>\r\n\r\n<p><img alt=\"Cách làm bánh da lợn\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/cach-lam-banh-da-lon-300x220.jpg\" style=\"height:498px; width:680px\" /></p>\r\n\r\n<p>Bánh da lợn, món ăn quen thuộc của người Việt bao đời nay.</p>\r\n\r\n<p>Trên thực tế, bánh da lợn ban đầu vốn dĩ chỉ có màu sắc đơn giản như màu trắng, màu xanh hay màu vàng. Sau này người ta lại càng nghĩ ra nhiều cách để “làm mới” cho bánh da lợn. Và bánh da lợn cà phê chính là một trong những hương vị được người ta ưng ý nhất.</p>\r\n\r\n<p>Cà phê mang lại cảm giác đắng chát mà dễ chịu. Nước cốt dừa béo nhưng lại không ngấy. Sự kết hợp này như mang đến một chút bùng nổ về vị giác, khiến món ăn càng trở nên hấp dẫn hơn. Đặc biệt là hai màu nâu trắng xen kẽ nhau tạo nên một hình thái mới cho bánh.&nbsp;</p>\r\n\r\n<p><strong>Xem hướng dẫn</strong>:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cach-lam-banh-da-lon/\">Cách Làm Bánh Da Lợn Cà Phê Thơm Ngon Đặc Sắc</a></p>\r\n\r\n<h2><strong>5. Cà phê cốt dừa</strong></h2>\r\n\r\n<p>Cafe cốt dừa là loại thức uống đang rất được giới trẻ đón nhận, bởi hương vị mới lạ và ngon miệng. Chính xác là vì vị cốt dừa béo béo ngậy ngậy, kết hợp với cà phê đắng thanh, nồng nàn. Đánh thức mọi giác quan của bạn, thay vì uống cafe sữa quá đậm vị.</p>\r\n\r\n<p>Ở Hà Nội, Cộng Cafe là địa chỉ nổi tiếng với cafe cốt dừa thơm ngon. Tuy nhiên, sẽ rất tiện lợi&nbsp;khi bạn tự tay pha chế cho mình và người thân ngay tại nhà.</p>\r\n\r\n<p><img alt=\"cà phê cốt dừa\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/ca-phe-cot-dua-300x188.jpg\" style=\"height:425px; width:680px\" /></p>\r\n\r\n<p>Hướng dẫn cách làm món cà phê cốt dừa ngon tuyệt.</p>\r\n\r\n<p>Nguyên liệu đơn giản gồm cà phê pha phin, sữa đặc, nước cốt dừa, đá xay. Cách pha chế cafe cốt dừa chỉ qua 3 bước ngắn gọn.</p>\r\n\r\n<p>Khi thưởng thức, bạn từ từ đổ hỗn hợp cốt dừa, sữa, đá đã xay lên trên. Tùy theo khẩu vị để điều chỉnh lượng cafe, sữa, cốt dừa vừa đủ.</p>\r\n\r\n<p><strong>Xem hướng dẫn</strong>:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/cafe-cot-dua/\">Cách Làm Món Cafe Cốt Dừa Siêu Ngon</a></p>\r\n\r\n<h2><strong>6. Sinh tố đá bịch cafe</strong></h2>\r\n\r\n<p>Những bạn thế hệ 8X hay 9X đời đầu có lẽ không thể quên được những túi sinh tố “thần thánh” vừa rẻ, vừa tiền lại vừa ngon. Rất phù hợp với mùa hè nóng bức, giải tỏa cơn khát tức thì.</p>\r\n\r\n<p>Cách thực hiện cũng tương tự các loại sinh tố thông thường khác. Nguyên liệu cơ bản vẫn gồm sữa tươi, đường cát, đá xay bào. Điểm khác biệt là ở thành phần cafe đen. Sự hòa quyện của vị ngọt của sữa, cùng vị đăng đắng của cà phê đen rất vừa miệng sẽ giúp bạn luôn tỉnh táo.</p>\r\n\r\n<p><img alt=\"cách làm sinh tố bịch\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/cach-lam-sinh-to-bich-300x213.jpg\" style=\"height:482px; width:680px\" /></p>\r\n\r\n<p>&nbsp;Sinh tố bịch cafe một trong những món ăn giải nhiệt ngày hè.</p>\r\n\r\n<p>Sử dụng sinh tố đá bịch mỗi ngày rất tốt và phù hợp với tất cả mọi người. Nhưng đối với những người đang mắc bệnh như viêm dạ dày thì không nên uống sinh tố cà phê.</p>\r\n\r\n<p>Ngoài ra những người bị yếu thận cũng nên hạn chế. Không nên sử dụng vào buổi tối để tránh sưng vù tay chân khi thức dậy. Lý do là vì các chất dinh dưỡng tồn đọng nhiều mà chưa kịp giải phóng hết.</p>\r\n\r\n<p><strong>Xem hướng dẫn:&nbsp;</strong><a href=\"https://bonjourcoffee.vn/blog/cach-lam-sinh-to-bich/\">Cách Làm Sinh Tố Đá Bịch Cafe Giải Nhiệt Mùa Hè</a></p>\r\n\r\n<h2><strong>7. Sữa chua đánh đá cafe</strong></h2>\r\n\r\n<p>Sữa chua đánh đá cà phê sẽ là cũng là một món từ cà phê. Nó vừa có tác dụng giúp tỉnh táo, mà còn có tác dụng tốt cho làn da.&nbsp;</p>\r\n\r\n<p><img alt=\"Sữa chua đánh đá cà phê\" src=\"https://bonjourcoffee.vn/blog/wp-content/uploads/2019/11/sua-chua-danh-da-ca-phe-300x200.jpg\" style=\"height:453px; width:680px\" /></p>\r\n\r\n<p>Hướng dẫn cách làm món sữa chua đánh đá cà phê thơm ngon.</p>\r\n\r\n<p>Đối với những người trong chế độ ăn kiêng, vẫn có thể thưởng thức sữa chua đánh đá cà phê. Bằng cách thay thế sữa chua, sữa đặc có đường sang loại không đường là được.</p>\r\n\r\n<p><strong>Xem hướng dẫn</strong>:&nbsp;<a href=\"https://bonjourcoffee.vn/blog/sua-chua-danh-da/\">3 Cách Làm Sữa Chua Đánh Đá Siêu Ngon</a></p>\r\n\r\n<p>Trên đây là 7&nbsp;<strong>món ăn từ cà phê</strong>&nbsp;mang lại cảm giác lạ miệng khi thưởng thức. Bạn chỉ cần bỏ ra một chút thời gian để thực hiện là đã có một món ăn, thức uống không kém ngoài tiệm. Lời khuyên cho tất cả những ai đang có ý định thử sức với những món ăn và đồ uống này là nên sử dụng&nbsp;cà phê hạt ngon, nguyên chất để rang xay&nbsp;để có được thành phẩm hoàn hảo nhất.</p>', 0, '2023-09-17 14:30:57', '2023-09-17 14:43:19');

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
  `code_order` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `is_special` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id_product`, `id_category`, `image_product`, `name_product`, `subname_product`, `price_product`, `description_product`, `number_reviews_product`, `is_special`, `created_at`, `updated_at`) VALUES
(1, 15, 'storage/product/ca-phe-den-1692888289.jpg', 'Cà phê đen', 'Black Coffee Filter', 35000, '<p>Black Coffee Filter</p>', NULL, 0, '2023-08-24 14:44:49', '2023-08-24 14:44:49'),
(3, 15, 'storage/product/ca-phe-nau-1693817752.jpg', 'Cà phê nâu', 'Milk Coffee Filter', 35000, '<p>Milk Coffee Filter</p>', NULL, 0, '2023-09-04 08:55:54', '2023-09-04 08:55:54'),
(4, 5, 'storage/product/plain-croissant-1694705119.jpg', 'Plain Croissant', 'Bánh sừng bò', 28000, '<p>Bánh sừng bò</p>', NULL, 1, '2023-09-14 15:25:20', '2023-09-14 15:33:57');

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
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id_review` int(10) UNSIGNED NOT NULL,
  `id_product` int(11) NOT NULL,
  `name_review` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating_review` smallint(1) DEFAULT NULL,
  `id_reply` int(11) DEFAULT NULL,
  `is_update` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id_review`, `id_product`, `name_review`, `content_review`, `rating_review`, `id_reply`, `is_update`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sơn', 'Đồ ăn khá là ngon', 4, 0, 1, NULL, '2023-09-11 16:15:44'),
(2, 1, 'Tuấn', 'Đồ uống khá nhạt chưa rõ vị đắng của cà phê', 2, 0, 1, NULL, '2023-09-11 16:17:16'),
(3, 1, 'Quản trị viên', 'Cảm ơn vì đã ủng hộ', 0, 1, 0, '2023-09-11 16:15:44', '2023-09-11 16:15:44'),
(4, 1, 'Quản trị viên', 'Thành thật xin lỗi vì điều đó', 0, 2, 0, '2023-09-11 16:17:16', '2023-09-11 16:17:16');

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

--
-- Đang đổ dữ liệu cho bảng `slide`
--

INSERT INTO `slide` (`id_slide`, `image_slide`, `name_slide`, `slug_slide`, `created_at`, `updated_at`) VALUES
(5, 'storage/slide/chi-nhanh-moi-1694880305.jpg', 'Mở chi nhánh mới', 'chi-nhanh-moi', '2023-09-16 16:05:06', '2023-09-16 16:05:06'),
(6, 'storage/slide/bbq-party-1694880462.jpg', 'BBQ Party', 'bbq-party', '2023-09-16 16:07:42', '2023-09-16 16:07:42');

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
-- Chỉ mục cho bảng `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id_coupon`);

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
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_new`);

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
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`);

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
-- AUTO_INCREMENT cho bảng `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id_coupon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id_new` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id_product` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id_recipe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `slide`
--
ALTER TABLE `slide`
  MODIFY `id_slide` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
