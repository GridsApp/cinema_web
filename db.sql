-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2025 at 08:02 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

CREATE TABLE `access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `access_tokens`
--

INSERT INTO `access_tokens` (`id`, `created_at`, `updated_at`, `deleted_at`, `token`, `user_id`, `expires_at`, `ip`, `type`) VALUES
(1, '2024-11-20 12:01:05', '2024-11-20 12:01:05', NULL, '1|c9ceee8ebdc660588f075fc86f385d3baaa479a0c3608b5a7a8bbff1498483f8', '1', '2025-05-20 11:01:05', '127.0.0.1', 'USER'),
(2, '2024-11-20 12:02:03', '2024-11-20 12:02:03', NULL, '1|8d5be63bfb0738c2ef2ae070c5013b11c58a094b5d359daffa267a62cbbbf0cb', '1', '2025-05-20 11:02:03', '127.0.0.1', 'USER'),
(3, '2024-12-05 08:51:59', '2024-12-05 08:51:59', NULL, 'POS|1|e0f198a54e8a970c91a0ccf365e9b1e116a9ddbf848db6ef686a845da258181e', '1', '2025-06-05 07:51:59', '127.0.0.1', 'POS'),
(4, '2024-12-05 08:53:23', '2024-12-05 08:53:23', NULL, 'POS|1|6f379171a3f10c06503bdd185e6ea9f68219bfa92c34c624735d996570b664f5', '1', '2025-06-05 07:53:23', '127.0.0.1', 'POS'),
(5, '2024-12-05 09:17:35', '2024-12-05 09:17:35', NULL, 'POS|1|7aceb219db47ef7aff86cab7ada948044e71c814166d127123a5dbfec36bf3b3', '1', '2025-06-05 08:17:35', '127.0.0.1', 'POS'),
(6, '2024-12-05 09:23:46', '2024-12-05 09:23:46', NULL, 'USER|9|6ca0ddd96c09745956424ae9f509a238985b3c0bcd052b0d7625387e45affd15', '9', '2025-06-05 08:23:46', '127.0.0.1', 'USER'),
(7, '2024-12-06 09:00:13', '2024-12-06 09:00:13', NULL, 'POS|1|b59bbd3d619f37bb24ed87d752b2263cb3314fbc04db9a5bf16a6f0a32984efe', '1', '2025-06-06 08:00:13', '127.0.0.1', 'POS'),
(8, '2024-12-06 09:02:20', '2024-12-06 09:02:20', NULL, 'POS|1|e8d1ada2fa8c3442a1f228bc52a4a3c80ae88f31333416f3844274c248511b07', '1', '2025-06-06 08:02:20', '127.0.0.1', 'POS'),
(9, '2024-12-06 09:50:33', '2024-12-06 09:50:33', NULL, 'POS|5|252d49f2db3af31734f5941be0eab25a014ad4ef112f4f36e7ddbe782d68fcfe', '5', '2025-06-06 08:50:33', '127.0.0.1', 'POS'),
(10, '2024-12-06 09:53:30', '2024-12-06 09:53:30', NULL, 'POS|5|ea25d8a22eb6e2396e1cbc766bbcda217ecadd75269dc425e1b3d7511b8e441a', '5', '2025-06-06 08:53:30', '127.0.0.1', 'POS'),
(11, '2024-12-06 09:53:35', '2024-12-06 09:53:35', NULL, 'POS|5|5faad5ff2070bf4285cc9c6ed422e03d869b6eabac60bd7cd9ad866f5702d34a', '5', '2025-06-06 08:53:35', '127.0.0.1', 'POS'),
(12, '2024-12-10 13:31:11', '2024-12-10 13:31:11', NULL, 'USER|18|d233b9624aefaa57405dea42a5bfc16b342e07f65d49117048d12bea94b74fe9', '18', '2025-06-10 12:31:11', '127.0.0.1', 'USER'),
(13, '2024-12-10 14:11:55', '2024-12-10 14:11:55', NULL, 'USER|18|d25ca371691eb78320a93a87f9807c6e3876d5f3f82f861b9b0588da4b40dd51', '18', '2025-06-10 13:11:55', '127.0.0.1', 'USER'),
(14, '2024-12-10 14:12:10', '2024-12-10 14:12:10', NULL, 'USER|18|f5beb89c77dcf2d3c8d64387ac3364017b80ade45eb7c8179297e3fac1360cba', '18', '2025-06-10 13:12:10', '127.0.0.1', 'USER'),
(15, '2024-12-12 10:32:54', '2024-12-12 10:32:54', NULL, 'USER|18|0c5ec60bc87663f9fe468131f3dd321fe0d0b80c70e796c855311f32bf5a1779', '18', '2025-06-12 09:32:54', '127.0.0.1', 'USER'),
(16, '2024-12-12 10:50:27', '2024-12-12 10:50:27', NULL, 'USER|18|90f92f26e33c09d977358537b3b7149438f5a0993e8ad81f64ccab7e831fb537', '18', '2025-06-12 09:50:27', '127.0.0.1', 'USER'),
(17, '2024-12-12 10:58:14', '2024-12-12 10:58:14', NULL, 'USER|2|a011492b63fa012e09a87bae2abaec63b7056ad6f60408d28d26a7e61f221e57', '2', '2025-06-12 09:58:14', '127.0.0.1', 'USER'),
(18, '2024-12-12 11:05:59', '2024-12-12 11:05:59', NULL, 'USER|19|61f0920d830184d9ca9a40e61a5c80d6dbae9bc05cc537ca249d5bc116febe0b', '19', '2025-06-12 10:05:59', '127.0.0.1', 'USER'),
(19, '2024-12-12 11:06:29', '2024-12-12 11:06:29', NULL, 'USER|19|aa536efbdab722d1a84baadb39474542f397c9e8317aeb053e4156214b492221', '19', '2025-06-12 10:06:29', '127.0.0.1', 'USER'),
(20, '2024-12-12 11:07:12', '2024-12-12 11:07:12', NULL, 'USER|19|e78e87e8fbab3c0909b2c7e4ae013fd80df0d5413f67fafa25744e1289536534', '19', '2025-06-12 10:07:12', '127.0.0.1', 'USER'),
(21, '2024-12-12 11:07:31', '2024-12-12 11:07:31', NULL, 'USER|19|42b257980e5c7617133fdd2fc73aa7fb4a19ee878650c33284147aa0e971ced0', '19', '2025-06-12 10:07:31', '127.0.0.1', 'USER'),
(22, '2024-12-12 11:07:58', '2024-12-12 11:07:58', NULL, 'USER|19|1fa3998625d630fcc386c1888619991764cb2be4eb5668e91affa8e2c8a0eaf2', '19', '2025-06-12 10:07:58', '127.0.0.1', 'USER'),
(23, '2024-12-17 12:37:14', '2024-12-17 12:37:14', NULL, 'POS|1|90ac78521c1b128ab7b2fb76d8441b44aab36dfd0b938eeb3afbd70f59779013', '1', '2025-06-17 11:37:14', '127.0.0.1', 'POS'),
(24, '2024-12-19 05:57:29', '2024-12-19 05:57:29', NULL, 'POS|1|081a5807c11bd411ac1b439794519cda97630981494d437e979d6e065a5c1615', '1', '2025-06-19 04:57:29', '127.0.0.1', 'POS'),
(25, '2024-12-23 05:57:19', '2024-12-23 05:57:19', NULL, 'KIOSK|1|11baea3214b684b76cf22614caf11b70850ccdb2d4c9dd4c7ca657fffa9af9c3', '1', '2025-06-23 04:57:19', '127.0.0.1', 'KIOSK'),
(26, '2024-12-24 07:36:30', '2024-12-24 07:36:30', NULL, 'USER|10|55a9a959e62c02b77add3d9292c76286fb22f890d650cf85a7c66ec66ab29562', '10', '2025-06-24 06:36:30', '127.0.0.1', 'USER'),
(27, '2024-12-24 07:38:31', '2024-12-24 07:38:31', NULL, 'USER|10|e4845abd494eead324a471acb3db28ddae1b8360faa53c08a22227227f2947e4', '10', '2025-06-24 06:38:31', '127.0.0.1', 'USER'),
(28, '2024-12-30 10:54:40', '2024-12-30 10:54:40', NULL, 'KIOSK|1|fc38aca30e1bfa7413be021a5aad144ffe51e44453d94db1722d155a11961c68', '1', '2025-06-30 09:54:40', '127.0.0.1', 'KIOSK'),
(29, '2024-12-30 13:13:58', '2024-12-30 13:13:58', NULL, 'POS|1|e3dcc6246894d85a6e953138eda4651bcb40502565b00b06e5c6c28ae4d7ce9b', '1', '2025-06-30 12:13:58', '127.0.0.1', 'POS'),
(30, '2025-01-02 12:29:28', '2025-01-02 12:29:28', NULL, 'POS|1|805aec05f1c9af5a5429957977cbf71ebbc55f01ad9056e4f2dddfdd5324a74d', '1', '2025-07-02 11:29:28', '127.0.0.1', 'POS'),
(31, '2025-01-02 12:29:49', '2025-01-02 12:29:49', NULL, 'POS|1|bef0533f873e2954e1f1d0eb4fc24cee507244206ecee19382309f921f914fc6', '1', '2025-07-02 11:29:49', '127.0.0.1', 'POS'),
(32, '2025-01-02 12:29:50', '2025-01-02 12:29:50', NULL, 'POS|1|f71f75a13f444298d46db8c2ae06c2d663ee83fc5baef8127fe227166594c093', '1', NULL, '127.0.0.1', 'POS'),
(33, '2025-01-02 12:40:33', '2025-01-02 12:46:25', NULL, 'POS|1|098c2619c77fef8a81f02d4af0904e3eaf104f12f1b52de1f7736d8011d33412', '1', '2025-01-02 12:46:25', '127.0.0.1', 'POS'),
(34, '2025-01-02 12:48:55', '2025-01-02 12:49:04', NULL, 'POS|1|f876d33190cc871df6a20f07bd975f7d2ee1ef1a536e7fc7a9fd9a417c420d6f', '1', '2025-01-02 12:49:04', '127.0.0.1', 'POS'),
(35, '2025-01-02 12:52:45', '2025-01-02 12:52:50', NULL, 'POS|1|f6101ab17bbc97c3c1aa7a5978db7f38e0d02cdd948e5147f02679c199d9a3d1', '1', '2025-01-02 12:52:50', '127.0.0.1', 'POS'),
(36, '2025-01-02 12:54:43', '2025-01-02 12:54:48', NULL, 'POS|1|d00370e22745ed3c2f3995d43d8e0349fb06cb4e27988297e8f547f3b3e367c3', '1', '2025-01-02 12:54:48', '127.0.0.1', 'POS'),
(37, '2025-01-02 12:56:24', '2025-01-02 12:56:24', NULL, 'POS|1|37304eb418839cb1b703b3f367a5b1829a57663cfb60a1572eabbd0f1c051ac3', '1', '2025-07-02 11:56:24', '127.0.0.1', 'POS'),
(38, '2025-01-02 12:56:57', '2025-01-02 12:56:57', NULL, 'POS|1|1af78652e99bf41fd0a557658e95da618eb09c0f454d51ab4d499e1d37a7cf3c', '1', '2025-07-02 11:56:57', '127.0.0.1', 'POS'),
(39, '2025-01-02 12:56:59', '2025-01-02 12:56:59', NULL, 'POS|1|3fdff01366909644dde5403216a8e093760daf9775a458407b7daf6ae7ff80ee', '1', '2025-07-02 11:56:59', '127.0.0.1', 'POS'),
(40, '2025-01-02 12:57:16', '2025-01-02 12:57:16', NULL, 'POS|1|ce1fca66364e72ede608033e6fafaffb93ab8df7368abfb355a7392c0dc4c083', '1', '2025-07-02 11:57:16', '127.0.0.1', 'POS'),
(41, '2025-01-02 12:57:25', '2025-01-02 12:57:25', NULL, 'POS|1|3891c784ff159495d4329d5865d26835e3c3a900206d8d66707b7f55c35c1589', '1', '2025-07-02 11:57:25', '127.0.0.1', 'POS'),
(42, '2025-01-02 12:57:42', '2025-01-02 12:57:42', NULL, 'POS|1|ff5c5da623ee62304469c42fb265f259261b9146830cfde194e19f32ed48ee47', '1', '2025-07-02 11:57:42', '127.0.0.1', 'POS'),
(43, '2025-01-02 13:04:35', '2025-01-02 13:04:47', NULL, 'POS|1|08ac5c9864982ef6b88bde155a023c89092e0ebec793f97f79d55ad3c96dea5e', '1', '2025-01-02 13:04:47', '127.0.0.1', 'POS'),
(44, '2025-01-02 13:35:02', '2025-01-02 13:35:02', NULL, 'POS|1|4fa005a41a19bf3683b4b5c4943ff837508f447f71f563f47a34cfb28162d512', '1', '2025-07-02 12:35:02', '127.0.0.1', 'POS'),
(45, '2025-01-02 13:35:22', '2025-01-02 13:35:22', NULL, 'POS|1|95cf5ade352214cf94cd4131f8d3a3337a14f938f5fc6aca8b7d6fe42f9d1147', '1', '2025-07-02 12:35:22', '127.0.0.1', 'POS');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `web_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint DEFAULT '0',
  `label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_fr` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `address_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `image`, `description`, `web_prefix`, `latitude`, `longitude`, `address`, `number`, `display`, `label_en`, `label_fr`, `label_ar`, `description_en`, `description_fr`, `description_ar`, `address_en`, `address_fr`, `address_ar`) VALUES
(1, '2024-11-04 05:39:54', '2024-11-20 06:22:58', NULL, NULL, '672de4410566f.jpg', 'ABC Dbaye', 'dbaye', '33.321313', '44.352895', NULL, '07808030002', 1, 'ABC Dbaye', 'ABC Dbaye fr', 'ABC Dbaye ar', 'ABC Dbaye', 'ABC Dbaye', 'ABC Dbaye', 'Dbaye Highway', 'Dbaye Highway', 'Dbaye Highway'),
(2, '2024-11-04 05:40:00', '2024-11-12 09:13:23', NULL, NULL, '67333853833af.jpg', 'ABC Verdun', 'verdun', '33.332023515066425', '44.45249749203745', NULL, '+9647808030002', 1, 'ABC Verdun', 'ABC Verdun', 'ABC Verdun', 'ABC Verdun', 'ABC Verdun', 'ABC Verdun', 'Verdun', 'Verdun', 'Verdun'),
(3, '2024-11-04 05:40:08', '2024-11-12 09:14:28', NULL, NULL, '6733389477e41.jpg', 'ABC Ashrafiye', 'ashrafiye', '33.31277147646704', '44.36406450242093', NULL, '+9647808030002', 1, 'ABC Ashrafiye', 'ABC Ashrafiye', 'ABC Ashrafiye', 'ABC Ashrafiye', 'ABC Ashrafiye', 'ABC Ashrafiye', 'Ashrafieh', 'Ashrafieh', 'Ashrafieh'),
(4, '2024-11-12 09:15:56', '2024-11-12 09:15:56', NULL, NULL, '673338ec5892f.jpg', 'City Center', 'City Center', '324324', '4234235', NULL, '321324145135', 1, 'City Center', 'City Center', 'City Center', 'City Center', 'City Center', 'City Center', 'City Center', 'City Center', 'City Center');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1734429870),
('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1734429870;', 1734429870);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_coupons`
--

CREATE TABLE `cart_coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `coupon_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_imtiyaz`
--

CREATE TABLE `cart_imtiyaz` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_seats`
--

CREATE TABLE `cart_seats` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `seat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `movie_show_id` bigint UNSIGNED DEFAULT NULL,
  `zone_id` bigint UNSIGNED DEFAULT NULL,
  `price` double DEFAULT NULL,
  `imtiyaz_phone` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `week` double DEFAULT NULL,
  `screen_type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theater_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movie_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_topups`
--

CREATE TABLE `cart_topups` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE `cms_users` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `email`, `password`) VALUES
(1, '2024-11-05 11:22:27', '2024-11-05 12:33:54', NULL, 'Hovig Senekjiann', 'hovig@thewebaddicts.com', 'e807f1fcf82d132f9bb018ca6738a19f'),
(2, '2024-11-05 11:49:41', '2024-11-05 11:49:41', NULL, 'Nourhane Sarieddine', 'nourhane.sarieddine@thewebaddicts.com', 'e807f1fcf82d132f9bb018ca6738a19f');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_flat` double DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `created_at`, `updated_at`, `deleted_at`, `code`, `discount_flat`, `expires_at`, `label`, `used_at`, `order_id`) VALUES
(1, '2024-12-03 12:00:27', '2024-12-30 08:47:26', NULL, 'DICS10', 10000, '2024-12-31 10:56:00', 'TheWebAddicts', NULL, NULL),
(2, '2024-12-26 13:37:43', '2025-01-02 07:31:01', NULL, 'HS100', 5000, '2025-02-08 15:37:00', 'TheWebAddicts', '2025-01-02 07:31:01', 39);

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_image` text COLLATE utf8mb4_unicode_ci,
  `commission_settings` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `main_image`, `commission_settings`) VALUES
(1, '2024-11-13 08:58:36', '2024-11-13 08:58:36', '2024-12-23 08:25:17', 'dewfr', NULL, NULL),
(2, '2024-12-19 05:43:29', '2024-12-26 08:09:46', NULL, 'Italia Films Ind', NULL, '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}'),
(3, '2024-12-23 11:55:15', '2024-12-23 11:55:15', '2024-12-26 08:10:07', 'Distributor Waleed', NULL, '{\"defaultPercentage\":\"35\",\"conditions\":[\"50\",\"45\"]}'),
(4, '2024-12-26 08:11:28', '2024-12-26 08:11:28', NULL, 'Eagle Films', NULL, '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `question_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_en` text COLLATE utf8mb4_unicode_ci,
  `answer_fr` text COLLATE utf8mb4_unicode_ci,
  `answer_ar` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `created_at`, `updated_at`, `deleted_at`, `question`, `answer`, `question_en`, `question_fr`, `question_ar`, `answer_en`, `answer_fr`, `answer_ar`) VALUES
(1, '2024-11-08 08:04:19', '2024-11-12 08:02:45', '2024-11-12 09:00:34', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui, ea!', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit aliquam soluta nisi, sed quasi debitis doloremque expedita dolorem laudantium natus.', 'fdvefv', 'fvbv', 'gbtbwrgb', 'fdverg', 'vretbv', 'bwetrb'),
(2, '2024-11-08 08:04:19', '2024-11-08 08:04:19', '2024-11-12 09:00:34', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui, ea!', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit aliquam soluta nisi, sed quasi debitis doloremque expedita dolorem laudantium natus.', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2024-11-08 10:00:39', '2024-11-08 10:00:39', '2024-11-08 10:01:19', 'ewwe', 'wqrq', NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2024-11-12 08:02:32', '2024-11-12 08:02:32', '2024-11-12 09:00:34', NULL, NULL, 'fdesfrw', 'vref', 'ervfew', 'ewrqgvt4', 'vfewrv', 'wferveft'),
(5, '2024-11-12 09:08:59', '2024-11-12 11:10:38', NULL, NULL, NULL, 'Who is the best man in Iraqi Cinema?', 'Who is the best man in Iraqi Cinema?', 'من هو أفضل رجل في السينما العراقية؟', 'All our team is the best', 'All our team is the best', 'All our team is the best'),
(6, '2024-11-12 09:09:44', '2024-11-12 09:09:44', NULL, NULL, NULL, 'Why going to Iraqi Cinema ', 'Why going to Iraqi Cinema ', 'Why going to Iraqi Cinema ', 'Iraqi cinema is the best one in the region', 'Iraqi cinema is the best one in the region', 'Iraqi cinema is the best one in the region');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informative_pages`
--

CREATE TABLE `informative_pages` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_en` longtext COLLATE utf8mb4_unicode_ci,
  `content_fr` longtext COLLATE utf8mb4_unicode_ci,
  `content_ar` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informative_pages`
--

INSERT INTO `informative_pages` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `content`, `label_en`, `label_fr`, `label_ar`, `content_en`, `content_fr`, `content_ar`, `slug`) VALUES
(1, '2024-11-08 12:11:26', '2024-11-08 12:58:47', '2024-11-12 09:00:40', 'Terms And Conditions', '<p><strong style=\"color: inherit;\">1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2024-11-08 12:57:49', '2024-11-08 13:08:56', '2024-11-12 09:00:40', 'Privacy Policy', '<p><strong>1-Customer registration: The User must have an account on Iraqi Cinema Application.The account should include Full name , mobile &amp; email address</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Last updated: Nov 2024</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation and Definitions</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Definitions</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the purposes of this Privacy Policy:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Account</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means a unique account created for You to access our Service or parts of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Affiliate</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means an entity that controls, is controlled by or is under common control with a party, where \"control\" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Application</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the software program provided by the Company downloaded by You on any electronic device, named IraqiCinema App</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Company</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;(referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to IraqiCinema App.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Country</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to: Iraq</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Device</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any device that can access the Service such as a computer, a cellphone or a digital tablet.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;is any information that relates to an identified or identifiable individual.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to the Application.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service Provider</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</span></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Collecting and Using Your Personal Data</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Types of Data Collected</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Email address</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">First name and last name</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Phone number</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Address, State, Province, ZIP/Postal code, City</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</span></li></ol><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data is collected automatically when using the Service.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Location Data.</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We collect location data such as information about your device’s location, which can be either precise or imprecise. How much information we collect depends on the type and settings of the device you use to access the Services. For example, we may use GPS and other technologies to collect geolocation data that tells us your current location (based on your IP address). You can opt out of allowing us to collect this information either by refusing access to the information or by disabling your Location setting on your device. However, if you choose to opt out, you may not be able to use certain aspects of the Services.</span></p><p><br></p><p><br></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information Collected while Using the Application</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Application, in order to provide features of Our Application, We may collect, with Your prior permission:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information regarding your location</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use this information to provide features of Our Service, to improve and customize Our Service. The information may be uploaded to the Company\'s servers and/or a Service Provider\'s server or it may be simply stored on Your device.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You can enable or disable access to this information at any time, through Your Device settings.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Use of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may use Personal Data for the following purposes:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide and maintain our Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">, including to monitor the usage of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your Account:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the performance of a contract:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To contact You:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your requests:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To attend and manage Your requests to Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For other purposes</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may share Your personal information in the following situations:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Service Providers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Affiliates:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With business partners:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our business partners to offer You certain products, services or promotions.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With other users:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Your consent</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may disclose Your personal information for any other purpose with Your consent.</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Retention of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Transfer of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</span></p><h2><strong style=\"background-color: inherit; color: inherit;\"><a href=\"https://iraqicinema.net/cms/form/edit/28a69025-1198-11ed-ba5e-42010a960004/615/2?path=https%3A%2F%2Firaqicinema.net%2Fcms%2Fgrid%2F28a69025-1198-11ed-ba5e-42010a960004%2F615%2Fpage-paragraphs#accountDelete\" rel=\"noopener noreferrer\" target=\"_blank\">Account Deletion:</a></strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You may choose to delete your user account at any time. To do so, please navigate to your user profile section/page within the app and select the option to delete your account.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Please note that once your account has been deleted, all of your personal data and account information will be permanently removed from our system. This process cannot be undone, and you will not be able to access your account or retrieve any of your data once it has been deleted.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions or concerns about deleting your account, please contact our support team for assistance.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Disclosure of Your Personal Data</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Business Transactions</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Law enforcement</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Other legal requirements</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Comply with a legal obligation</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect and defend the rights or property of the Company</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Prevent or investigate possible wrongdoing in connection with the Service</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect the personal safety of Users of the Service or the public</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect against legal liability</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Security of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Detailed Information on the Processing of Your Personal Data</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Service Providers We use may have access to Your Personal Data. These third-party vendors collect, store, use, process and transfer information about Your activity on Our Service in accordance with their Privacy Policies.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage, Performance and Miscellaneous</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may use third-party Service Providers to provide better improvement of our Service.</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places</strong></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places is a service that returns information about places using HTTP requests. It is operated by Google</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places service may collect information from You and from Your Device for security purposes.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The information gathered by Google Places is held in accordance with the Privacy Policy of Google:&nbsp;</span><a href=\"https://www.google.com/intl/en/policies/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"background-color: inherit; color: rgb(51, 122, 183);\">https://www.google.com/intl/en/policies/privacy/</a></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Children\'s Privacy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Links to Other Websites</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Changes to this Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Contact Us</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions about this Privacy Policy, You can contact us: IraqiCinema Support</span></p><p><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2024-11-12 09:10:35', '2024-11-13 06:45:52', NULL, NULL, NULL, 'Terms and conditions', 'Terms and conditions French', 'Terms and conditions Arabic', '<p><strong style=\"color: inherit;\">1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p>', '<p><strong style=\"color: inherit;\">French1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p>', '<p><strong style=\"color: inherit;\">Arabic1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><br></p><p><strong style=\"color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p>', 'terms-and-conditions');
INSERT INTO `informative_pages` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `content`, `label_en`, `label_fr`, `label_ar`, `content_en`, `content_fr`, `content_ar`, `slug`) VALUES
(4, '2024-11-12 09:11:02', '2024-11-12 13:12:41', NULL, NULL, NULL, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Last updated: Nov 2024</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation and Definitions</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Definitions</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the purposes of this Privacy Policy:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Account</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means a unique account created for You to access our Service or parts of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Affiliate</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means an entity that controls, is controlled by or is under common control with a party, where \"control\" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Application</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the software program provided by the Company downloaded by You on any electronic device, named IraqiCinema App</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Company</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;(referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to IraqiCinema App.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Country</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to: Iraq</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Device</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any device that can access the Service such as a computer, a cellphone or a digital tablet.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;is any information that relates to an identified or identifiable individual.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to the Application.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service Provider</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</span></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Collecting and Using Your Personal Data</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Types of Data Collected</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Email address</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">First name and last name</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Phone number</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Address, State, Province, ZIP/Postal code, City</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</span></li></ol><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data is collected automatically when using the Service.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Location Data.</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We collect location data such as information about your device’s location, which can be either precise or imprecise. How much information we collect depends on the type and settings of the device you use to access the Services. For example, we may use GPS and other technologies to collect geolocation data that tells us your current location (based on your IP address). You can opt out of allowing us to collect this information either by refusing access to the information or by disabling your Location setting on your device. However, if you choose to opt out, you may not be able to use certain aspects of the Services.</span></p><p><br></p><p><br></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information Collected while Using the Application</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Application, in order to provide features of Our Application, We may collect, with Your prior permission:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information regarding your location</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use this information to provide features of Our Service, to improve and customize Our Service. The information may be uploaded to the Company\'s servers and/or a Service Provider\'s server or it may be simply stored on Your device.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You can enable or disable access to this information at any time, through Your Device settings.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Use of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may use Personal Data for the following purposes:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide and maintain our Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">, including to monitor the usage of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your Account:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the performance of a contract:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To contact You:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your requests:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To attend and manage Your requests to Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For other purposes</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may share Your personal information in the following situations:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Service Providers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Affiliates:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With business partners:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our business partners to offer You certain products, services or promotions.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With other users:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Your consent</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may disclose Your personal information for any other purpose with Your consent.</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Retention of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Transfer of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</span></p><h2><strong style=\"background-color: inherit; color: inherit;\"><a href=\"https://iraqicinema.net/cms/form/edit/28a69025-1198-11ed-ba5e-42010a960004/615/2?path=https%3A%2F%2Firaqicinema.net%2Fcms%2Fgrid%2F28a69025-1198-11ed-ba5e-42010a960004%2F615%2Fpage-paragraphs#accountDelete\" rel=\"noopener noreferrer\" target=\"_blank\">Account Deletion:</a></strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You may choose to delete your user account at any time. To do so, please navigate to your user profile section/page within the app and select the option to delete your account.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Please note that once your account has been deleted, all of your personal data and account information will be permanently removed from our system. This process cannot be undone, and you will not be able to access your account or retrieve any of your data once it has been deleted.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions or concerns about deleting your account, please contact our support team for assistance.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Disclosure of Your Personal Data</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Business Transactions</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Law enforcement</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Other legal requirements</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Comply with a legal obligation</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect and defend the rights or property of the Company</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Prevent or investigate possible wrongdoing in connection with the Service</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect the personal safety of Users of the Service or the public</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect against legal liability</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Security of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Detailed Information on the Processing of Your Personal Data</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Service Providers We use may have access to Your Personal Data. These third-party vendors collect, store, use, process and transfer information about Your activity on Our Service in accordance with their Privacy Policies.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage, Performance and Miscellaneous</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may use third-party Service Providers to provide better improvement of our Service.</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places</strong></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places is a service that returns information about places using HTTP requests. It is operated by Google</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places service may collect information from You and from Your Device for security purposes.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The information gathered by Google Places is held in accordance with the Privacy Policy of Google:&nbsp;</span><a href=\"https://www.google.com/intl/en/policies/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"background-color: inherit; color: rgb(51, 122, 183);\">https://www.google.com/intl/en/policies/privacy/</a></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Children\'s Privacy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Links to Other Websites</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Changes to this Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Contact Us</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions about this Privacy Policy, You can contact us: IraqiCinema Support</span></p><p><br></p>', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Last updated: Nov 2024</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation and Definitions</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Definitions</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the purposes of this Privacy Policy:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Account</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means a unique account created for You to access our Service or parts of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Affiliate</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means an entity that controls, is controlled by or is under common control with a party, where \"control\" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Application</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the software program provided by the Company downloaded by You on any electronic device, named IraqiCinema App</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Company</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;(referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to IraqiCinema App.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Country</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to: Iraq</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Device</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any device that can access the Service such as a computer, a cellphone or a digital tablet.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;is any information that relates to an identified or identifiable individual.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to the Application.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service Provider</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</span></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Collecting and Using Your Personal Data</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Types of Data Collected</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Email address</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">First name and last name</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Phone number</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Address, State, Province, ZIP/Postal code, City</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</span></li></ol><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data is collected automatically when using the Service.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Location Data.</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We collect location data such as information about your device’s location, which can be either precise or imprecise. How much information we collect depends on the type and settings of the device you use to access the Services. For example, we may use GPS and other technologies to collect geolocation data that tells us your current location (based on your IP address). You can opt out of allowing us to collect this information either by refusing access to the information or by disabling your Location setting on your device. However, if you choose to opt out, you may not be able to use certain aspects of the Services.</span></p><p><br></p><p><br></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information Collected while Using the Application</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Application, in order to provide features of Our Application, We may collect, with Your prior permission:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information regarding your location</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use this information to provide features of Our Service, to improve and customize Our Service. The information may be uploaded to the Company\'s servers and/or a Service Provider\'s server or it may be simply stored on Your device.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You can enable or disable access to this information at any time, through Your Device settings.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Use of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may use Personal Data for the following purposes:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide and maintain our Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">, including to monitor the usage of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your Account:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the performance of a contract:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To contact You:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your requests:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To attend and manage Your requests to Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For other purposes</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may share Your personal information in the following situations:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Service Providers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Affiliates:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With business partners:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our business partners to offer You certain products, services or promotions.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With other users:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Your consent</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may disclose Your personal information for any other purpose with Your consent.</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Retention of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Transfer of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</span></p><h2><strong style=\"background-color: inherit; color: inherit;\"><a href=\"https://iraqicinema.net/cms/form/edit/28a69025-1198-11ed-ba5e-42010a960004/615/2?path=https%3A%2F%2Firaqicinema.net%2Fcms%2Fgrid%2F28a69025-1198-11ed-ba5e-42010a960004%2F615%2Fpage-paragraphs#accountDelete\" rel=\"noopener noreferrer\" target=\"_blank\">Account Deletion:</a></strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You may choose to delete your user account at any time. To do so, please navigate to your user profile section/page within the app and select the option to delete your account.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Please note that once your account has been deleted, all of your personal data and account information will be permanently removed from our system. This process cannot be undone, and you will not be able to access your account or retrieve any of your data once it has been deleted.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions or concerns about deleting your account, please contact our support team for assistance.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Disclosure of Your Personal Data</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Business Transactions</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Law enforcement</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Other legal requirements</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Comply with a legal obligation</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect and defend the rights or property of the Company</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Prevent or investigate possible wrongdoing in connection with the Service</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect the personal safety of Users of the Service or the public</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect against legal liability</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Security of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Detailed Information on the Processing of Your Personal Data</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Service Providers We use may have access to Your Personal Data. These third-party vendors collect, store, use, process and transfer information about Your activity on Our Service in accordance with their Privacy Policies.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage, Performance and Miscellaneous</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may use third-party Service Providers to provide better improvement of our Service.</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places</strong></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places is a service that returns information about places using HTTP requests. It is operated by Google</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places service may collect information from You and from Your Device for security purposes.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The information gathered by Google Places is held in accordance with the Privacy Policy of Google:&nbsp;</span><a href=\"https://www.google.com/intl/en/policies/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"background-color: inherit; color: rgb(51, 122, 183);\">https://www.google.com/intl/en/policies/privacy/</a></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Children\'s Privacy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Links to Other Websites</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Changes to this Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Contact Us</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions about this Privacy Policy, You can contact us: IraqiCinema Support</span></p><p><br></p>', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);\">1- Customer Registration: The user must have an account on Iraqi Cinema Application. The account should include Full name, mobile &amp; email address.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">2- Seats Booking: The user can access movie show times, choose the number of seats from the available seats with 3D Glasses if needed and move to the other step.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">3- Booking Confirmation: once the seats are chosen, the user must proceed with the payment in order to confirm his booking.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">4- Refund Policy: No Refund Will Be MADE unless Iraqi Cinema was not able to provide the service. The refund will be made electronically same as the payment.</strong></p><p><br></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema booking system might experience some issues due to the internet service provider interruption in Iraq or any other technical problems; we strongly recommend moving from one step to another slowly.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Iraqi Cinema customer support phone number is +964 780 803 0002 and working hours are from 12:00 AM to 9:00 PM.</strong></p><p><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">NO BOOKING is allowed over the phone.</strong></p><p><br></p><p><br></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Last updated: Nov 2024</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation and Definitions</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Interpretation</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Definitions</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the purposes of this Privacy Policy:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Account</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means a unique account created for You to access our Service or parts of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Affiliate</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means an entity that controls, is controlled by or is under common control with a party, where \"control\" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Application</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the software program provided by the Company downloaded by You on any electronic device, named IraqiCinema App</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Company</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;(referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to IraqiCinema App.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Country</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to: Iraq</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Device</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any device that can access the Service such as a computer, a cellphone or a digital tablet.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;is any information that relates to an identified or identifiable individual.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to the Application.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Service Provider</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</span></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Collecting and Using Your Personal Data</strong></h1><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Types of Data Collected</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Personal Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Email address</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">First name and last name</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Phone number</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Address, State, Province, ZIP/Postal code, City</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</span></li></ol><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data is collected automatically when using the Service.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Location Data.</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We collect location data such as information about your device’s location, which can be either precise or imprecise. How much information we collect depends on the type and settings of the device you use to access the Services. For example, we may use GPS and other technologies to collect geolocation data that tells us your current location (based on your IP address). You can opt out of allowing us to collect this information either by refusing access to the information or by disabling your Location setting on your device. However, if you choose to opt out, you may not be able to use certain aspects of the Services.</span></p><p><br></p><p><br></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information Collected while Using the Application</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">While using Our Application, in order to provide features of Our Application, We may collect, with Your prior permission:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Information regarding your location</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We use this information to provide features of Our Service, to improve and customize Our Service. The information may be uploaded to the Company\'s servers and/or a Service Provider\'s server or it may be simply stored on Your device.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You can enable or disable access to this information at any time, through Your Device settings.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Use of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may use Personal Data for the following purposes:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide and maintain our Service</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">, including to monitor the usage of our Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your Account:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For the performance of a contract:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To contact You:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To provide You</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">To manage Your requests:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;To attend and manage Your requests to Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For other purposes</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</span></li></ol><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may share Your personal information in the following situations:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Service Providers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">For business transfers:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Affiliates:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With business partners:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;We may share Your information with Our business partners to offer You certain products, services or promotions.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With other users:</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">&nbsp;when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">With Your consent</strong><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">: We may disclose Your personal information for any other purpose with Your consent.</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Retention of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Transfer of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</span></p><h2><strong style=\"background-color: inherit; color: inherit;\"><a href=\"https://iraqicinema.net/cms/form/edit/28a69025-1198-11ed-ba5e-42010a960004/615/2?path=https%3A%2F%2Firaqicinema.net%2Fcms%2Fgrid%2F28a69025-1198-11ed-ba5e-42010a960004%2F615%2Fpage-paragraphs#accountDelete\" rel=\"noopener noreferrer\" target=\"_blank\">Account Deletion:</a></strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You may choose to delete your user account at any time. To do so, please navigate to your user profile section/page within the app and select the option to delete your account.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Please note that once your account has been deleted, all of your personal data and account information will be permanently removed from our system. This process cannot be undone, and you will not be able to access your account or retrieve any of your data once it has been deleted.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions or concerns about deleting your account, please contact our support team for assistance.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Disclosure of Your Personal Data</strong></h2><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Business Transactions</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Law enforcement</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</span></p><h3><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Other legal requirements</strong></h3><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Comply with a legal obligation</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect and defend the rights or property of the Company</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Prevent or investigate possible wrongdoing in connection with the Service</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect the personal safety of Users of the Service or the public</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Protect against legal liability</span></li></ol><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Security of Your Personal Data</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Detailed Information on the Processing of Your Personal Data</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The Service Providers We use may have access to Your Personal Data. These third-party vendors collect, store, use, process and transfer information about Your activity on Our Service in accordance with their Privacy Policies.</span></p><h2><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Usage, Performance and Miscellaneous</strong></h2><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may use third-party Service Providers to provide better improvement of our Service.</span></p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places</strong></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places is a service that returns information about places using HTTP requests. It is operated by Google</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Google Places service may collect information from You and from Your Device for security purposes.</span></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">The information gathered by Google Places is held in accordance with the Privacy Policy of Google:&nbsp;</span><a href=\"https://www.google.com/intl/en/policies/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"background-color: inherit; color: rgb(51, 122, 183);\">https://www.google.com/intl/en/policies/privacy/</a></li></ol><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Children\'s Privacy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Links to Other Websites</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Changes to this Privacy Policy</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</span></p><h1><strong style=\"background-color: rgb(255, 255, 255); color: inherit;\">Contact Us</strong></h1><p><span style=\"background-color: rgb(255, 255, 255); color: inherit;\">If you have any questions about this Privacy Policy, You can contact us: IraqiCinema Support</span></p><p><br></p>', 'privacy-policy');
INSERT INTO `informative_pages` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `content`, `label_en`, `label_fr`, `label_ar`, `content_en`, `content_fr`, `content_ar`, `slug`) VALUES
(5, '2024-11-12 13:11:26', '2024-11-12 13:11:26', '2024-11-13 06:42:53', NULL, NULL, 'dweaffew   nefbwjbfeajhbrhgergtbre', 'gergsegergh', 'gwersgtwger', '<p>thhgergerh</p>', '<p>herg</p>', '<p>trhhg</p>', 'dweaffew-nefbwjbfeajhbrhgergtbre');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `created_at`, `updated_at`, `deleted_at`, `image`, `label`, `price`, `branch_id`) VALUES
(1, NULL, '2024-12-04 07:32:11', NULL, '6750219b7fdaa.jpg', 'Popcorn', 10000, '1'),
(2, NULL, '2024-12-04 07:33:32', NULL, '675021ecb54b8.png', 'Glasses', 30000, '3');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kiosk_users`
--

CREATE TABLE `kiosk_users` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kiosk_users`
--

INSERT INTO `kiosk_users` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `username`, `passcode`, `pincode`, `branch_id`, `access_token`, `role`) VALUES
(1, '2024-12-23 05:57:14', '2024-12-23 05:57:14', NULL, 'nourhane sarieddine', 'nourhane2002', 'changeme', '1234', '3', NULL, 'cashier');

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

CREATE TABLE `marital_status` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `movie_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condensed_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `duration` double DEFAULT NULL,
  `cast_id` text COLLATE utf8mb4_unicode_ci,
  `director_id` bigint UNSIGNED DEFAULT NULL,
  `genre_id` text COLLATE utf8mb4_unicode_ci,
  `language_id` bigint UNSIGNED DEFAULT NULL,
  `age_rating_id` bigint UNSIGNED DEFAULT NULL,
  `main_image` text COLLATE utf8mb4_unicode_ci,
  `cover_image` text COLLATE utf8mb4_unicode_ci,
  `youtube_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `imdb_rating` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imdb_vote` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distributor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_settings` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `created_at`, `updated_at`, `deleted_at`, `movie_key`, `name`, `condensed_name`, `description`, `duration`, `cast_id`, `director_id`, `genre_id`, `language_id`, `age_rating_id`, `main_image`, `cover_image`, `youtube_video`, `release_date`, `imdb_rating`, `imdb_vote`, `distributor_id`, `commission_settings`) VALUES
(1, '2024-11-14 10:49:00', '2024-12-26 08:11:48', NULL, 'tt8542964', 'Sleeping Dogs', 'Sleeping Dogs', 'An ex-homicide detective with memory loss is forced to solve a brutal murder, only to uncover chilling secrets from his forgotten past.', 110, '[\"1\",\"2\",\"3\"]', 1, '[\"1\",\"2\",\"3\"]', 1, 1, '6735f1ac3e463.jpg', NULL, NULL, '2024-03-22', '6.1', '14,275', '4', '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}'),
(2, '2024-11-14 10:49:33', '2024-12-26 08:11:56', NULL, 'tt22375054', 'Strange Darling', 'Strange Darling', 'Nothing is what it seems when a twisted one-night stand spirals into a serial killer\'s vicious murder spree.', 97, '[\"4\",\"5\",\"6\"]', 2, '[\"4\",\"3\"]', 1, 1, '6735f1d5cf3d2.jpg', NULL, NULL, '2024-08-23', '7.2', '17,514', '4', '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}'),
(3, '2024-11-14 10:50:08', '2024-12-26 08:12:03', NULL, 'tt29268110', 'Smile 2', 'Smile 2', 'About to embark on a world tour, global pop sensation Skye Riley begins experiencing increasingly terrifying and inexplicable events. Overwhelmed by the escalating horrors and the pressures of fame, Skye is forced to face her past.', 127, '[\"7\",\"8\",\"9\"]', 3, '[\"4\",\"2\",\"3\"]', 1, 1, '6735f1fc7806b.jpg', NULL, NULL, '2024-10-18', '7.2', '21,791', '2', '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}'),
(4, '2024-11-14 10:50:31', '2024-12-26 08:12:10', NULL, 'tt27526845', 'Arzé', 'Arzé', 'Arzé, a single mother, takes her teenage son on a journey across sectarian Beirut in search of their stolen scooter, their only source of livelihood.', 90, '[\"10\",\"11\",\"12\"]', 4, '[\"5\",\"6\"]', 2, 1, '6735f213958db.jpg', NULL, NULL, '2024-08-22', 'N/A', '60', '4', '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}'),
(5, '2024-11-14 10:50:55', '2024-11-14 10:50:55', NULL, 'tt2674426', 'Me Before You', 'Me Before You', 'A girl in a small town forms an unlikely bond with a recently-paralyzed man she\'s taking care of.', 110, '[\"13\",\"14\",\"15\"]', 5, '[\"6\",\"7\"]', 3, 2, '6735f22713793.jpg', NULL, NULL, '2016-06-03', '7.4', '297,251', NULL, NULL),
(6, '2024-11-14 10:51:35', '2024-12-26 08:12:17', NULL, 'tt6472976', 'Five Feet Apart', 'Five Feet Apart', 'Stella spends most of her time in the hospital as a cystic fibrosis patient. Her life is full of routines, boundaries and self-control -- all of which get put to the test when she meets Will, a charming boy who has the same illness.', 116, '[\"16\",\"17\",\"18\"]', 6, '[\"6\",\"7\"]', 3, 2, '6735f244a20ce.jpg', NULL, NULL, '2019-03-15', '7.2', '86,553', '4', '{\"defaultPercentage\":\"40\",\"conditions\":[\"50\",\"45\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `movie_age_ratings`
--

CREATE TABLE `movie_age_ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_age_ratings`
--

INSERT INTO `movie_age_ratings` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, '2024-11-14 10:48:55', '2024-11-14 10:48:55', NULL, '15'),
(2, NULL, NULL, NULL, '13+');

-- --------------------------------------------------------

--
-- Table structure for table `movie_casts`
--

CREATE TABLE `movie_casts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_casts`
--

INSERT INTO `movie_casts` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `image`) VALUES
(1, NULL, '2024-12-10 12:17:11', NULL, 'Russell Crowe', '67584d675a01d.jpg'),
(2, NULL, '2024-12-10 12:17:21', NULL, 'Karen Gillan', '67584d711d1fa.png'),
(3, NULL, '2024-12-10 12:17:32', NULL, 'Marton Csokas', '67584d7bab7fd.jpg'),
(4, NULL, NULL, NULL, 'Willa Fitzgerald', NULL),
(5, NULL, NULL, NULL, 'Kyle Gallner', NULL),
(6, NULL, NULL, NULL, 'Madisen Beaty', NULL),
(7, NULL, NULL, NULL, 'Naomi Scott', NULL),
(8, NULL, NULL, NULL, 'Rosemarie DeWitt', NULL),
(9, NULL, NULL, NULL, 'Lukas Gage', NULL),
(10, NULL, NULL, NULL, 'Diamand Abou Abboud', NULL),
(11, NULL, NULL, NULL, 'Betty Taoutel', NULL),
(12, NULL, NULL, NULL, 'Bilal Al Hamwi', NULL),
(13, NULL, NULL, NULL, 'Emilia Clarke', NULL),
(14, NULL, NULL, NULL, 'Sam Claflin', NULL),
(15, NULL, NULL, NULL, 'Janet McTeer', NULL),
(16, NULL, NULL, NULL, 'Haley Lu Richardson', NULL),
(17, NULL, NULL, NULL, 'Cole Sprouse', NULL),
(18, NULL, NULL, NULL, 'Moises Arias', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movie_directors`
--

CREATE TABLE `movie_directors` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_directors`
--

INSERT INTO `movie_directors` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`) VALUES
(1, NULL, NULL, NULL, 'Adam Cooper'),
(2, NULL, NULL, NULL, 'JT Mollner'),
(3, NULL, NULL, NULL, 'Parker Finn'),
(4, NULL, NULL, NULL, 'Mira Shaib'),
(5, NULL, NULL, NULL, 'Thea Sharrock'),
(6, NULL, NULL, NULL, 'Justin Baldoni');

-- --------------------------------------------------------

--
-- Table structure for table `movie_favorites`
--

CREATE TABLE `movie_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `movie_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_favorites`
--

INSERT INTO `movie_favorites` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `movie_id`) VALUES
(6, '2024-11-19 13:38:55', '2024-11-19 13:38:55', NULL, 1, 1),
(11, '2024-11-20 12:47:47', '2024-11-20 12:47:47', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_genres`
--

INSERT INTO `movie_genres` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, NULL, NULL, NULL, 'Crime'),
(2, NULL, NULL, NULL, 'Mystery'),
(3, NULL, NULL, NULL, 'Thriller'),
(4, NULL, NULL, NULL, 'Horror'),
(5, NULL, NULL, NULL, 'Comedy'),
(6, NULL, NULL, NULL, 'Drama'),
(7, NULL, NULL, NULL, 'Romance');

-- --------------------------------------------------------

--
-- Table structure for table `movie_languages`
--

CREATE TABLE `movie_languages` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_languages`
--

INSERT INTO `movie_languages` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, NULL, NULL, NULL, 'English'),
(2, NULL, NULL, NULL, 'Arabic'),
(3, NULL, NULL, NULL, 'English, French');

-- --------------------------------------------------------

--
-- Table structure for table `movie_shows`
--

CREATE TABLE `movie_shows` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `movie_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_id` bigint UNSIGNED DEFAULT NULL,
  `screen_type_id` bigint UNSIGNED DEFAULT NULL,
  `theater_id` bigint UNSIGNED DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` tinyint DEFAULT '0',
  `end_time_id` bigint UNSIGNED DEFAULT NULL,
  `duration` double DEFAULT NULL,
  `system_id` text COLLATE utf8mb4_unicode_ci,
  `week` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_shows`
--

INSERT INTO `movie_shows` (`id`, `created_at`, `updated_at`, `deleted_at`, `movie_id`, `date`, `time_id`, `screen_type_id`, `theater_id`, `group`, `color`, `visibility`, `end_time_id`, `duration`, `system_id`, `week`) VALUES
(1, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-26', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(2, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-27', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(3, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-28', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(4, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-29', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(5, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-31', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(6, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2025-01-01', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(7, '2024-12-26 12:23:06', '2024-12-26 12:23:06', NULL, 4, '2024-12-30', 1, 1, 1, '676d66ca064b7', '#e70808', 1, 6, 90, NULL, 1),
(9, '2025-01-02 13:48:00', '2025-01-02 13:48:00', NULL, 6, '2025-01-02', 1, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(10, '2025-01-02 13:48:00', '2025-01-02 14:00:56', NULL, 6, '2025-01-03', 9, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(11, '2025-01-02 13:48:00', '2025-01-02 13:48:44', NULL, 6, '2025-01-03', 1, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(12, '2025-01-02 13:48:00', '2025-01-02 13:48:46', NULL, 6, '2025-01-04', 1, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(13, '2025-01-02 13:48:00', '2025-01-02 13:48:00', NULL, 6, '2025-01-06', 1, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(14, '2025-01-02 13:48:00', '2025-01-02 13:48:21', NULL, 6, '2025-01-02', 9, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(15, '2025-01-02 13:48:00', '2025-01-02 13:48:00', NULL, 6, '2025-01-08', 1, 1, 1, '6776b5305c6f6', '#f93e98', 1, 8, 116, NULL, 1),
(16, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-02', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(17, '2025-01-02 13:49:18', '2025-01-02 13:49:27', NULL, 4, '2025-01-02', 23, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(18, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-04', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(19, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-05', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(20, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-06', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(21, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-07', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2),
(22, '2025-01-02 13:49:18', '2025-01-02 13:49:18', NULL, 4, '2025-01-08', 17, 2, 1, '6776b57e01352', '#9f0909', 1, 22, 90, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `movie_show_theaters`
--

CREATE TABLE `movie_show_theaters` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `movie_show_id` bigint UNSIGNED DEFAULT NULL,
  `theater_map` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `system_id` text COLLATE utf8mb4_unicode_ci,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` bigint UNSIGNED DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `pos_user_id` bigint UNSIGNED DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `printed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `updated_at`, `deleted_at`, `system_id`, `barcode`, `payment_method_id`, `reference`, `user_id`, `pos_user_id`, `total_price`, `printed_at`) VALUES
(1, '2025-01-02 08:33:04', '2025-01-02 13:41:43', NULL, '2', '97675381615084457', 2, '0T26A5TRA8U01G', NULL, 1, NULL, '2025-01-02 13:41:43'),
(2, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, '2', '86686787414277166', 4, 'L5YEPCRKPMWARK', 10, 1, NULL, NULL),
(3, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, '2', '55870766220945368', 4, 'RXKKMYXIM8WAHW', 10, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_coupons`
--

CREATE TABLE `order_coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `coupon_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `price` double DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_seats`
--

CREATE TABLE `order_seats` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `seat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `price` double DEFAULT NULL,
  `gained_points` double DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `refunded_cashier_id` bigint UNSIGNED DEFAULT NULL,
  `refunded_manager_id` bigint UNSIGNED DEFAULT NULL,
  `movie_show_id` bigint UNSIGNED DEFAULT NULL,
  `zone_id` bigint UNSIGNED DEFAULT NULL,
  `movie_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen_type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theater_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `week` double DEFAULT NULL,
  `imtiyaz_phone` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_seats`
--

INSERT INTO `order_seats` (`id`, `created_at`, `updated_at`, `deleted_at`, `seat`, `label`, `order_id`, `price`, `gained_points`, `refunded_at`, `refunded_cashier_id`, `refunded_manager_id`, `movie_show_id`, `zone_id`, `movie_id`, `screen_type_id`, `theater_id`, `date`, `time_id`, `week`, `imtiyaz_phone`) VALUES
(1, '2025-01-02 08:33:04', '2025-01-02 08:34:51', NULL, 'A1', 'Club Seat', 1, 10000, 10000, '2025-01-02 08:34:51', 1, 2, 6, 6, '4', '1', '1', '2025-01-01', '1', 1, NULL),
(2, '2025-01-02 08:33:04', '2025-01-02 09:27:54', NULL, 'A2', 'Club Seat', 1, 10000, 10000, '2025-01-02 09:27:54', 1, 2, 6, 6, '4', '1', '1', '2025-01-01', '1', 1, NULL),
(3, '2025-01-02 08:33:04', '2025-01-02 09:28:58', NULL, 'A1', 'Club Seat', 1, 10000, 10000, '2025-01-02 09:28:58', 1, 2, 5, 6, '4', '1', '1', '2024-12-31', '1', 1, NULL),
(4, '2025-01-02 08:33:04', '2025-01-02 08:33:04', NULL, 'A2', 'Club Seat', 1, 10000, 10000, NULL, NULL, NULL, 5, 6, '4', '1', '1', '2024-12-31', '1', 1, NULL),
(5, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, 'A3', 'Club Seat', 2, 10000, 10000, NULL, NULL, NULL, 5, 6, '4', '1', '1', '2024-12-31', '1', 1, NULL),
(6, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, 'A4', 'Club Seat', 2, 10000, 10000, NULL, NULL, NULL, 5, 6, '4', '1', '1', '2024-12-31', '1', 1, NULL),
(7, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, 'A5', 'Club Seat', 3, 10000, 10000, NULL, NULL, NULL, 5, 6, '4', '1', '1', '2024-12-31', '1', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_topups`
--

CREATE TABLE `order_topups` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_attempts`
--

CREATE TABLE `payment_attempts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `payment_method_id` bigint UNSIGNED DEFAULT NULL,
  `converted_at` timestamp NULL DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_attempts`
--

INSERT INTO `payment_attempts` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `amount`, `payment_method_id`, `converted_at`, `action`, `completed_at`, `reference`, `pos_user_id`) VALUES
(1, '2024-12-27 06:41:40', '2024-12-27 06:41:40', NULL, 10, 20000, 2, '2024-12-27 06:41:40', 'COMPLETE_ORDER', '2024-12-27 06:41:40', '1', NULL),
(2, '2024-12-27 06:59:53', '2024-12-27 06:59:53', NULL, 10, 0, 2, '2024-12-27 06:59:53', 'COMPLETE_ORDER', '2024-12-27 06:59:53', '2', NULL),
(3, '2024-12-27 07:01:28', '2024-12-27 07:01:28', NULL, 10, 0, 2, '2024-12-27 07:01:28', 'COMPLETE_ORDER', '2024-12-27 07:01:28', '3', NULL),
(4, '2024-12-27 07:02:28', '2024-12-27 07:02:28', NULL, 10, 0, 2, '2024-12-27 07:02:28', 'COMPLETE_ORDER', '2024-12-27 07:02:28', '4', NULL),
(5, '2024-12-27 07:05:27', '2024-12-27 07:05:27', NULL, 10, 20000, 2, '2024-12-27 07:05:27', 'COMPLETE_ORDER', '2024-12-27 07:05:27', '5', NULL),
(6, '2024-12-27 07:07:09', '2024-12-27 07:07:09', NULL, 10, 20000, 2, '2024-12-27 07:07:09', 'COMPLETE_ORDER', '2024-12-27 07:07:09', '6', NULL),
(7, '2024-12-27 07:11:42', '2024-12-27 07:11:42', NULL, 10, 20000, 2, '2024-12-27 07:11:42', 'COMPLETE_ORDER', '2024-12-27 07:11:42', '7', NULL),
(8, '2024-12-27 07:13:54', '2024-12-27 07:13:54', NULL, 10, 20000, 2, '2024-12-27 07:13:54', 'COMPLETE_ORDER', '2024-12-27 07:13:54', '8', NULL),
(9, '2024-12-27 07:21:16', '2024-12-27 07:21:16', NULL, 10, 20000, 2, '2024-12-27 07:21:16', 'COMPLETE_ORDER', '2024-12-27 07:21:16', '9', NULL),
(10, '2024-12-27 07:41:59', '2024-12-27 07:41:59', NULL, 10, 100000, 2, '2024-12-27 07:41:59', 'COMPLETE_ORDER', '2024-12-27 07:41:59', '10', NULL),
(11, '2024-12-27 09:05:01', '2024-12-27 09:05:01', NULL, 10, 20000, 2, NULL, 'COMPLETE_ORDER', NULL, '1', NULL),
(12, '2024-12-27 09:08:34', '2024-12-27 09:08:34', NULL, 10, 0, 2, '2024-12-27 09:08:34', 'COMPLETE_ORDER', '2024-12-27 09:08:34', '1', NULL),
(13, '2024-12-30 08:44:47', '2024-12-30 08:44:47', NULL, 10, 40000, 2, NULL, 'COMPLETE_ORDER', NULL, '5', NULL),
(14, '2024-12-30 08:45:21', '2024-12-30 08:45:21', NULL, 10, 40000, 2, NULL, 'COMPLETE_ORDER', NULL, '5', NULL),
(15, '2024-12-30 08:45:43', '2024-12-30 08:45:43', NULL, 10, 40000, 2, NULL, 'COMPLETE_ORDER', NULL, '5', NULL),
(16, '2024-12-30 08:45:46', '2024-12-30 08:45:46', NULL, 10, 40000, 2, NULL, 'COMPLETE_ORDER', NULL, '5', NULL),
(17, '2024-12-30 08:47:26', '2024-12-30 08:47:26', NULL, 10, 40000, 2, '2024-12-30 08:47:26', 'COMPLETE_ORDER', '2024-12-30 08:47:26', '5', NULL),
(18, '2024-12-30 13:24:16', '2024-12-30 13:24:16', NULL, NULL, 5000, 2, '2024-12-30 13:24:16', 'COMPLETE_ORDER', '2024-12-30 13:24:16', '9', 1),
(19, '2024-12-30 14:07:05', '2024-12-30 14:07:05', NULL, NULL, 5000, 2, '2024-12-30 14:07:05', 'COMPLETE_ORDER', '2024-12-30 14:07:05', '11', 1),
(20, '2024-12-31 08:46:10', '2024-12-31 08:46:10', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '15', 1),
(21, '2024-12-31 08:47:07', '2024-12-31 08:47:07', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '15', 1),
(22, '2024-12-31 08:47:20', '2024-12-31 08:47:20', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(23, '2024-12-31 08:47:30', '2024-12-31 08:47:30', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(24, '2024-12-31 08:49:39', '2024-12-31 08:49:39', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(25, '2024-12-31 08:50:41', '2024-12-31 08:50:41', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(26, '2024-12-31 08:56:42', '2024-12-31 08:56:42', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(27, '2024-12-31 08:56:47', '2024-12-31 08:56:47', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '16', 1),
(28, '2024-12-31 09:01:19', '2024-12-31 09:01:19', NULL, NULL, 5000, 2, NULL, 'COMPLETE_ORDER', NULL, '1', 1),
(29, '2024-12-31 09:01:30', '2024-12-31 09:01:30', NULL, NULL, 5000, 2, '2024-12-31 09:01:30', 'COMPLETE_ORDER', '2024-12-31 09:01:30', '1', 1),
(30, '2024-12-31 09:03:14', '2024-12-31 09:03:14', NULL, NULL, 10000, 2, '2024-12-31 09:03:14', 'COMPLETE_ORDER', '2024-12-31 09:03:14', '2', 1),
(31, '2024-12-31 09:34:58', '2024-12-31 09:34:58', NULL, NULL, 20000, 2, '2024-12-31 09:34:58', 'COMPLETE_ORDER', '2024-12-31 09:34:58', '3', 1),
(32, '2024-12-31 09:37:04', '2024-12-31 09:37:04', NULL, NULL, 20000, 2, '2024-12-31 09:37:04', 'COMPLETE_ORDER', '2024-12-31 09:37:04', '1', 1),
(33, '2024-12-31 09:39:29', '2024-12-31 09:39:29', NULL, NULL, 20000, 2, '2024-12-31 09:39:29', 'COMPLETE_ORDER', '2024-12-31 09:39:29', '1', 1),
(34, '2024-12-31 10:47:05', '2024-12-31 10:47:06', NULL, NULL, 130000, 2, '2024-12-31 10:47:06', 'COMPLETE_ORDER', '2024-12-31 10:47:06', '2', 1),
(35, '2024-12-31 10:58:07', '2024-12-31 10:58:07', NULL, NULL, 30000, 2, '2024-12-31 10:58:07', 'COMPLETE_ORDER', '2024-12-31 10:58:07', '1', 1),
(36, '2025-01-02 05:13:35', '2025-01-02 05:13:35', NULL, NULL, 95000, 2, '2025-01-02 05:13:35', 'COMPLETE_ORDER', '2025-01-02 05:13:35', '1', 1),
(37, '2025-01-02 06:56:20', '2025-01-02 06:56:20', NULL, NULL, 70000, 2, '2025-01-02 06:56:20', 'COMPLETE_ORDER', '2025-01-02 06:56:20', '4', 1),
(38, '2025-01-02 06:58:05', '2025-01-02 06:58:05', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '5', 1),
(39, '2025-01-02 06:58:10', '2025-01-02 06:58:10', NULL, NULL, 10000, 2, '2025-01-02 06:58:10', 'COMPLETE_ORDER', '2025-01-02 06:58:10', '5', 1),
(40, '2025-01-02 07:00:24', '2025-01-02 07:00:24', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '6', 1),
(41, '2025-01-02 07:01:05', '2025-01-02 07:01:05', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '6', 1),
(42, '2025-01-02 07:01:13', '2025-01-02 07:01:13', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '6', 1),
(43, '2025-01-02 07:01:22', '2025-01-02 07:01:22', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '6', 1),
(44, '2025-01-02 07:01:45', '2025-01-02 07:01:45', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '7', 1),
(45, '2025-01-02 07:02:03', '2025-01-02 07:02:03', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '7', 1),
(46, '2025-01-02 07:02:16', '2025-01-02 07:02:16', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '8', 1),
(47, '2025-01-02 07:02:43', '2025-01-02 07:02:43', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '8', 1),
(48, '2025-01-02 07:02:58', '2025-01-02 07:02:58', NULL, NULL, 10000, 2, '2025-01-02 07:02:58', 'COMPLETE_ORDER', '2025-01-02 07:02:58', '9', 1),
(49, '2025-01-02 07:03:40', '2025-01-02 07:03:40', NULL, NULL, 10000, 2, '2025-01-02 07:03:40', 'COMPLETE_ORDER', '2025-01-02 07:03:40', '10', 1),
(50, '2025-01-02 07:05:20', '2025-01-02 07:05:20', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '11', 1),
(51, '2025-01-02 07:05:32', '2025-01-02 07:05:32', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '11', 1),
(52, '2025-01-02 07:05:51', '2025-01-02 07:05:51', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '12', 1),
(53, '2025-01-02 07:06:24', '2025-01-02 07:06:24', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '13', 1),
(54, '2025-01-02 07:08:25', '2025-01-02 07:08:25', NULL, NULL, 10000, 2, NULL, 'COMPLETE_ORDER', NULL, '14', 1),
(55, '2025-01-02 07:09:13', '2025-01-02 07:09:13', NULL, NULL, 10000, 2, '2025-01-02 07:09:13', 'COMPLETE_ORDER', '2025-01-02 07:09:13', '15', 1),
(56, '2025-01-02 07:10:15', '2025-01-02 07:10:15', NULL, NULL, 10000, 2, '2025-01-02 07:10:15', 'COMPLETE_ORDER', '2025-01-02 07:10:15', '16', 1),
(57, '2025-01-02 07:10:54', '2025-01-02 07:10:54', NULL, NULL, 10000, 2, '2025-01-02 07:10:54', 'COMPLETE_ORDER', '2025-01-02 07:10:54', '17', 1),
(58, '2025-01-02 07:11:25', '2025-01-02 07:11:25', NULL, NULL, 10000, 2, '2025-01-02 07:11:25', 'COMPLETE_ORDER', '2025-01-02 07:11:25', '18', 1),
(59, '2025-01-02 07:11:50', '2025-01-02 07:11:50', NULL, NULL, 10000, 2, '2025-01-02 07:11:50', 'COMPLETE_ORDER', '2025-01-02 07:11:50', '19', 1),
(60, '2025-01-02 07:12:10', '2025-01-02 07:12:10', NULL, NULL, 0, 2, '2025-01-02 07:12:10', 'COMPLETE_ORDER', '2025-01-02 07:12:10', '20', 1),
(61, '2025-01-02 07:12:54', '2025-01-02 07:12:54', NULL, NULL, 10000, 2, '2025-01-02 07:12:54', 'COMPLETE_ORDER', '2025-01-02 07:12:54', '21', 1),
(62, '2025-01-02 07:13:14', '2025-01-02 07:13:14', NULL, NULL, 10000, 2, '2025-01-02 07:13:14', 'COMPLETE_ORDER', '2025-01-02 07:13:14', '22', 1),
(63, '2025-01-02 07:14:09', '2025-01-02 07:14:09', NULL, NULL, 10000, 2, '2025-01-02 07:14:09', 'COMPLETE_ORDER', '2025-01-02 07:14:09', '23', 1),
(64, '2025-01-02 07:14:36', '2025-01-02 07:14:36', NULL, NULL, 10000, 2, '2025-01-02 07:14:36', 'COMPLETE_ORDER', '2025-01-02 07:14:36', '24', 1),
(65, '2025-01-02 07:15:34', '2025-01-02 07:15:34', NULL, NULL, 10000, 2, '2025-01-02 07:15:34', 'COMPLETE_ORDER', '2025-01-02 07:15:34', '25', 1),
(66, '2025-01-02 07:16:28', '2025-01-02 07:16:28', NULL, NULL, 10000, 2, '2025-01-02 07:16:28', 'COMPLETE_ORDER', '2025-01-02 07:16:28', '26', 1),
(67, '2025-01-02 07:16:56', '2025-01-02 07:16:56', NULL, NULL, 10000, 2, '2025-01-02 07:16:56', 'COMPLETE_ORDER', '2025-01-02 07:16:56', '27', 1),
(68, '2025-01-02 07:18:17', '2025-01-02 07:18:17', NULL, NULL, 10000, 2, '2025-01-02 07:18:17', 'COMPLETE_ORDER', '2025-01-02 07:18:17', '28', 1),
(69, '2025-01-02 07:19:00', '2025-01-02 07:19:00', NULL, NULL, 10000, 2, '2025-01-02 07:19:00', 'COMPLETE_ORDER', '2025-01-02 07:19:00', '29', 1),
(70, '2025-01-02 07:19:34', '2025-01-02 07:19:34', NULL, NULL, 10000, 2, '2025-01-02 07:19:34', 'COMPLETE_ORDER', '2025-01-02 07:19:34', '30', 1),
(71, '2025-01-02 07:20:07', '2025-01-02 07:20:07', NULL, NULL, 10000, 2, '2025-01-02 07:20:07', 'COMPLETE_ORDER', '2025-01-02 07:20:07', '31', 1),
(72, '2025-01-02 07:20:30', '2025-01-02 07:20:30', NULL, NULL, 10000, 2, '2025-01-02 07:20:30', 'COMPLETE_ORDER', '2025-01-02 07:20:30', '32', 1),
(73, '2025-01-02 07:21:25', '2025-01-02 07:21:25', NULL, NULL, 15000, 2, '2025-01-02 07:21:25', 'COMPLETE_ORDER', '2025-01-02 07:21:25', '33', 1),
(74, '2025-01-02 07:22:46', '2025-01-02 07:22:46', NULL, NULL, 13000, 2, '2025-01-02 07:22:46', 'COMPLETE_ORDER', '2025-01-02 07:22:46', '34', 1),
(75, '2025-01-02 07:31:01', '2025-01-02 07:31:01', NULL, NULL, 7000, 2, '2025-01-02 07:31:01', 'COMPLETE_ORDER', '2025-01-02 07:31:01', '35', 1),
(76, '2025-01-02 07:48:53', '2025-01-02 07:48:53', NULL, NULL, 20000, 2, '2025-01-02 07:48:53', 'COMPLETE_ORDER', '2025-01-02 07:48:53', '37', 1),
(77, '2025-01-02 08:33:04', '2025-01-02 08:33:04', NULL, NULL, 40000, 2, '2025-01-02 08:33:04', 'COMPLETE_ORDER', '2025-01-02 08:33:04', '1', 1),
(78, '2025-01-02 08:51:45', '2025-01-02 08:51:45', NULL, NULL, 20000, 4, NULL, 'COMPLETE_ORDER', NULL, '2', 1),
(79, '2025-01-02 08:55:32', '2025-01-02 08:55:32', NULL, NULL, 20000, 4, NULL, 'COMPLETE_ORDER', NULL, '2', 1),
(80, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, NULL, 20000, 4, '2025-01-02 08:56:08', 'COMPLETE_ORDER', '2025-01-02 08:56:08', '2', 1),
(81, '2025-01-02 09:01:08', '2025-01-02 09:01:08', NULL, NULL, 10000, 4, NULL, 'COMPLETE_ORDER', NULL, '3', 1),
(82, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, NULL, 10000, 4, '2025-01-02 09:01:28', 'COMPLETE_ORDER', '2025-01-02 09:01:28', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `image`, `key`, `system_id`) VALUES
(1, NULL, '2024-12-12 13:57:00', NULL, 'Online Payment', '675aebac92a24.jpeg', 'OP', 1),
(2, NULL, '2024-12-19 10:03:30', NULL, 'Cash Payment\n', '675aebb8f21ec.png', 'CASH', 2),
(3, '2024-12-10 05:53:40', '2024-12-12 13:59:50', NULL, 'Wallet Payment', '675aec567bfa5.jpeg', 'WP', 1),
(4, '2024-12-19 10:04:18', '2024-12-19 10:05:43', NULL, 'Wallet Payment', NULL, 'WP-POS', 2),
(5, '2024-12-19 10:05:33', '2024-12-19 10:05:33', NULL, 'Switch', NULL, 'CC-DC', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pos_users`
--

CREATE TABLE `pos_users` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pos_users`
--

INSERT INTO `pos_users` (`id`, `created_at`, `updated_at`, `deleted_at`, `password`, `username`, `branch_id`, `pincode`, `access_token`, `passcode`, `name`, `role`) VALUES
(1, '2024-12-03 07:10:58', '2024-12-03 10:49:20', NULL, '$2y$12$osvtUnfUieYCImxaD5mCUuOXuPGTf36bI9fmWTeejB43aW4JA5VXG', 'nourhane2002', 1, '12345', '0b0373dc09283b217f56d30eb6361f1116a70deb4218ea6627eb81d5ee114785', 'changeme', 'Nourhane Sarieddine', 'cashier'),
(2, '2024-12-03 07:27:17', '2024-12-03 08:52:44', NULL, '$2y$12$T5c36KEDhG/WglI2w7pYU.hP1lvg02gB6Ea7rPs7BQaUo8vBTfJLK', 'hovig1995', 1, '12345', NULL, 'changeme', 'Hovig Senekjian', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `price_groups`
--

CREATE TABLE `price_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_groups`
--

INSERT INTO `price_groups` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, '2024-11-14 10:52:43', '2024-11-14 10:52:43', NULL, 'REG'),
(2, '2024-11-14 10:52:51', '2024-11-14 10:52:51', NULL, 'MAX'),
(3, '2024-11-14 10:52:55', '2024-11-14 10:52:55', NULL, 'ATMOS'),
(4, '2024-12-02 11:54:52', '2024-12-02 11:55:52', '2024-12-23 08:22:56', 'Testadsasda'),
(5, '2024-12-23 08:23:19', '2024-12-23 08:23:19', NULL, 'VIP');

-- --------------------------------------------------------

--
-- Table structure for table `price_group_zones`
--

CREATE TABLE `price_group_zones` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_group_id` bigint UNSIGNED DEFAULT NULL,
  `default` tinyint DEFAULT '0',
  `price_settings` longtext COLLATE utf8mb4_unicode_ci,
  `condensed_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_group_zones`
--

INSERT INTO `price_group_zones` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `color`, `price_group_id`, `default`, `price_settings`, `condensed_label`) VALUES
(1, NULL, '2024-12-26 08:28:20', NULL, 'Default', '#6b7280', 1, 1, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Default'),
(2, NULL, '2024-12-26 08:28:26', NULL, 'Default', '#6b7280', 2, 1, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Default'),
(3, NULL, '2024-12-26 08:28:30', NULL, 'Default', '#6b7280', 3, 1, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Default'),
(4, '2024-11-14 10:53:33', '2024-12-26 08:24:16', NULL, 'Club Seat', '#c40808', 1, NULL, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Club'),
(5, '2024-11-14 10:53:57', '2024-12-26 08:24:24', NULL, 'Club Seat', '#3014bd', 2, NULL, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Club'),
(6, '2024-11-14 10:54:12', '2024-12-26 08:24:31', NULL, 'Club Seat', '#246b63', 3, NULL, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Club'),
(7, NULL, '2024-12-26 08:28:36', NULL, 'Default', '#6b7280', 5, 1, '{\"defaultPrice\":\"10000\",\"conditions\":[{\"day\":\"monday\",\"price\":\"5000\"}]}', 'Default'),
(10, '2024-12-30 14:47:24', '2024-12-30 14:47:24', NULL, 'Club 1', '#ec0909', 3, NULL, '{\"defaultPrice\":\"15000\",\"conditions\":[]}', 'Club 1'),
(11, '2024-12-30 14:47:43', '2024-12-30 14:47:43', NULL, 'Club 2', '#09ec77', 3, NULL, '{\"defaultPrice\":\"13000\",\"conditions\":[]}', 'Club 2'),
(12, '2024-12-30 14:48:05', '2024-12-30 14:48:05', NULL, 'Club 3', '#111ed4', 3, NULL, '{\"defaultPrice\":\"12000\",\"conditions\":[]}', 'Club 3');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_seats`
--

CREATE TABLE `reserved_seats` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `movie_show_id` bigint UNSIGNED DEFAULT NULL,
  `seat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reserved_seats`
--

INSERT INTO `reserved_seats` (`id`, `created_at`, `updated_at`, `deleted_at`, `movie_show_id`, `seat`) VALUES
(4, '2025-01-02 08:33:04', '2025-01-02 08:33:04', NULL, 5, 'A2'),
(5, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, 5, 'A3'),
(6, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, 5, 'A4'),
(7, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, 5, 'A5');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeem_points` double DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `one_time_usage` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `created_at`, `updated_at`, `deleted_at`, `title`, `redeem_points`, `image`, `description`, `one_time_usage`) VALUES
(1, '2024-11-20 13:23:33', '2024-11-21 09:44:48', NULL, 'Double Club Seat Ticket', 300, '673dfef558f09.jpg', 'Get Popcorn + Pepsi Medium for free by redeeming 50 points !', 1),
(2, '2024-11-20 13:25:02', '2024-11-20 13:25:02', NULL, '3D Glasses', 20, '673dff4e064a4.png', 'Redeem 200 points and get a free VIP ticket', 0);

-- --------------------------------------------------------

--
-- Table structure for table `screen_types`
--

CREATE TABLE `screen_types` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_fr` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `screen_types`
--

INSERT INTO `screen_types` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `label_en`, `label_ar`, `label_fr`, `description_en`, `description_fr`, `description_ar`) VALUES
(1, '2024-12-23 11:47:23', '2024-12-23 11:47:23', NULL, '2D', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2024-11-14 10:47:42', '2024-12-23 07:43:45', NULL, '3D', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2024-11-14 10:47:33', '2024-12-23 07:43:27', NULL, 'مدبلج', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE `slideshows` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `cta_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_en` text COLLATE utf8mb4_unicode_ci,
  `text_fr` text COLLATE utf8mb4_unicode_ci,
  `text_ar` text COLLATE utf8mb4_unicode_ci,
  `cta_label_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_label_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_label_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link_fr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slideshows`
--

INSERT INTO `slideshows` (`id`, `created_at`, `updated_at`, `deleted_at`, `image`, `text`, `cta_label`, `cta_link`, `label`, `label_en`, `label_fr`, `label_ar`, `text_en`, `text_fr`, `text_ar`, `cta_label_en`, `cta_label_fr`, `cta_label_ar`, `cta_link_en`, `cta_link_fr`, `cta_link_ar`) VALUES
(1, '2024-11-20 13:01:53', '2024-12-10 08:58:37', NULL, '673df9e19e0bc.jpg', NULL, NULL, NULL, NULL, 'Gladiator 2', 'Gladiator 2', 'Gladiator 2', 'Showing Now	', 'Showing Now	', 'يعرض الآن	', 'Watch Trailer', 'Watch Trailer', 'شاهد الإعلان', 'https://youtu.be/zT2DgQiLlD4', 'https://youtu.be/zT2DgQiLlD4', 'https://youtu.be/zT2DgQiLlD4'),
(2, '2024-12-10 09:00:00', '2024-12-10 09:00:00', NULL, '67581f3040976.jpg', NULL, NULL, NULL, NULL, 'Wicked', 'Wicked', 'Wicked ar', 'Showing Now', 'Showing Now', 'Showing Now ar', 'Watch Trailer', 'Watch Trailer', 'Watch Trailer ar', 'https://youtu.be/MMoPAepF5cI', 'https://youtu.be/MMoPAepF5cI', 'https://youtu.be/MMoPAepF5cI');

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, NULL, NULL, NULL, 'APP'),
(2, NULL, NULL, NULL, 'POS'),
(3, NULL, NULL, NULL, 'Website'),
(4, NULL, NULL, NULL, 'Kiosk'),
(5, NULL, NULL, NULL, 'CMS');

-- --------------------------------------------------------

--
-- Table structure for table `theaters`
--

CREATE TABLE `theaters` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `hall_number` double DEFAULT NULL,
  `price_group_id` bigint UNSIGNED DEFAULT NULL,
  `theater_map` longtext COLLATE utf8mb4_unicode_ci,
  `nb_seats` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theaters`
--

INSERT INTO `theaters` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`, `branch_id`, `hall_number`, `price_group_id`, `theater_map`, `nb_seats`) VALUES
(1, '2024-11-20 07:31:53', '2024-12-30 14:48:55', NULL, 'Theater 1', 3, 1, 3, '[[{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A1\",\"row\":\"A\",\"column\":1},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A2\",\"row\":\"A\",\"column\":2},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A3\",\"row\":\"A\",\"column\":3},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A4\",\"row\":\"A\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A5\",\"row\":\"A\",\"column\":5},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A6\",\"row\":\"A\",\"column\":6},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A7\",\"row\":\"A\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"A8\",\"row\":\"A\",\"column\":8},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"A9\",\"row\":\"A\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B1\",\"row\":\"B\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B2\",\"row\":\"B\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B3\",\"row\":\"B\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B4\",\"row\":\"B\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B5\",\"row\":\"B\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B6\",\"row\":\"B\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B7\",\"row\":\"B\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B8\",\"row\":\"B\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"B9\",\"row\":\"B\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C1\",\"row\":\"C\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C2\",\"row\":\"C\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C3\",\"row\":\"C\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C4\",\"row\":\"C\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C5\",\"row\":\"C\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C6\",\"row\":\"C\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C7\",\"row\":\"C\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C8\",\"row\":\"C\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"C9\",\"row\":\"C\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D1\",\"row\":\"D\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D2\",\"row\":\"D\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D3\",\"row\":\"D\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D4\",\"row\":\"D\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D5\",\"row\":\"D\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D6\",\"row\":\"D\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D7\",\"row\":\"D\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D8\",\"row\":\"D\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"D9\",\"row\":\"D\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#ec0909\",\"zone\":10,\"code\":\"E1\",\"row\":\"E\",\"column\":1},{\"isSeat\":true,\"color\":\"#09ec77\",\"zone\":11,\"code\":\"E2\",\"row\":\"E\",\"column\":2},{\"isSeat\":true,\"color\":\"#111ed4\",\"zone\":12,\"code\":\"E3\",\"row\":\"E\",\"column\":3},{\"isSeat\":true,\"color\":\"#246b63\",\"zone\":6,\"code\":\"E4\",\"row\":\"E\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"E5\",\"row\":\"E\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"E6\",\"row\":\"E\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"E7\",\"row\":\"E\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"E8\",\"row\":\"E\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"E9\",\"row\":\"E\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F1\",\"row\":\"F\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F2\",\"row\":\"F\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F3\",\"row\":\"F\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F4\",\"row\":\"F\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F5\",\"row\":\"F\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F6\",\"row\":\"F\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F7\",\"row\":\"F\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F8\",\"row\":\"F\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"F9\",\"row\":\"F\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G1\",\"row\":\"G\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G2\",\"row\":\"G\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G3\",\"row\":\"G\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G4\",\"row\":\"G\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G5\",\"row\":\"G\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G6\",\"row\":\"G\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G7\",\"row\":\"G\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G8\",\"row\":\"G\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"G9\",\"row\":\"G\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H1\",\"row\":\"H\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H2\",\"row\":\"H\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H3\",\"row\":\"H\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H4\",\"row\":\"H\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H5\",\"row\":\"H\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H6\",\"row\":\"H\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H7\",\"row\":\"H\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H8\",\"row\":\"H\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"H9\",\"row\":\"H\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I1\",\"row\":\"I\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I2\",\"row\":\"I\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I3\",\"row\":\"I\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I4\",\"row\":\"I\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I5\",\"row\":\"I\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I6\",\"row\":\"I\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I7\",\"row\":\"I\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I8\",\"row\":\"I\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"I9\",\"row\":\"I\",\"column\":9}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J1\",\"row\":\"J\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J2\",\"row\":\"J\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J3\",\"row\":\"J\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J4\",\"row\":\"J\",\"column\":4},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":3,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J5\",\"row\":\"J\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J6\",\"row\":\"J\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J7\",\"row\":\"J\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J8\",\"row\":\"J\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":3,\"code\":\"J9\",\"row\":\"J\",\"column\":9}]]', 90),
(2, '2024-11-25 09:03:10', '2024-12-02 12:09:40', NULL, 'Theater 2', 1, 2, 1, '[[{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A1\",\"row\":\"A\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A2\",\"row\":\"A\",\"column\":2},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A3\",\"row\":\"A\",\"column\":3}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B1\",\"row\":\"B\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B2\",\"row\":\"B\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B3\",\"row\":\"B\",\"column\":3}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C1\",\"row\":\"C\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C2\",\"row\":\"C\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C3\",\"row\":\"C\",\"column\":3}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D1\",\"row\":\"D\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D2\",\"row\":\"D\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D3\",\"row\":\"D\",\"column\":3}]]', 12),
(3, '2024-11-25 10:03:18', '2024-12-02 12:09:46', NULL, 'Theater 3', 2, 3, 1, '[[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"A1\",\"row\":\"A\",\"column\":1},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A2\",\"row\":\"A\",\"column\":2},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A3\",\"row\":\"A\",\"column\":3},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A4\",\"row\":\"A\",\"column\":4},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"A5\",\"row\":\"A\",\"column\":5}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B1\",\"row\":\"B\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B2\",\"row\":\"B\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B3\",\"row\":\"B\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B4\",\"row\":\"B\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B5\",\"row\":\"B\",\"column\":5}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C1\",\"row\":\"C\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C2\",\"row\":\"C\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C3\",\"row\":\"C\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C4\",\"row\":\"C\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C5\",\"row\":\"C\",\"column\":5}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D1\",\"row\":\"D\",\"column\":1},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D2\",\"row\":\"D\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D3\",\"row\":\"D\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D4\",\"row\":\"D\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D5\",\"row\":\"D\",\"column\":5}]]', 20),
(4, '2024-11-25 10:12:07', '2024-12-02 12:09:49', NULL, 'Theater 4', 4, 4, 1, '[[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"A4\",\"row\":\"A\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"A3\",\"row\":\"A\",\"column\":3},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"A2\",\"row\":\"A\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"A1\",\"row\":\"A\",\"column\":1}],[{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X2\",\"row\":\"X\",\"column\":2},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X1\",\"row\":\"X\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null}],[{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null}],[{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C2\",\"row\":\"C\",\"column\":2},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C1\",\"row\":\"C\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D4\",\"row\":\"D\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D3\",\"row\":\"D\",\"column\":3},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D2\",\"row\":\"D\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D1\",\"row\":\"D\",\"column\":1}]]', 12),
(5, '2024-12-23 11:40:31', '2024-12-23 11:40:31', NULL, 'Theater 10', 4, 10, 1, '[[{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X16\",\"row\":\"X\",\"column\":16},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X15\",\"row\":\"X\",\"column\":15},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X14\",\"row\":\"X\",\"column\":14},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X13\",\"row\":\"X\",\"column\":13},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X12\",\"row\":\"X\",\"column\":12},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X11\",\"row\":\"X\",\"column\":11},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X10\",\"row\":\"X\",\"column\":10},{\"isSeat\":true,\"color\":\"#c40808\",\"zone\":4,\"code\":\"X9\",\"row\":\"X\",\"column\":9},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X8\",\"row\":\"X\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X7\",\"row\":\"X\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X6\",\"row\":\"X\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X5\",\"row\":\"X\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X4\",\"row\":\"X\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X3\",\"row\":\"X\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X2\",\"row\":\"X\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"X1\",\"row\":\"X\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B16\",\"row\":\"B\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B15\",\"row\":\"B\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B14\",\"row\":\"B\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B13\",\"row\":\"B\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B12\",\"row\":\"B\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B11\",\"row\":\"B\",\"column\":11},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B10\",\"row\":\"B\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B9\",\"row\":\"B\",\"column\":9},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B8\",\"row\":\"B\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B7\",\"row\":\"B\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B6\",\"row\":\"B\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B5\",\"row\":\"B\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B4\",\"row\":\"B\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B3\",\"row\":\"B\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B2\",\"row\":\"B\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"B1\",\"row\":\"B\",\"column\":1},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C18\",\"row\":\"C\",\"column\":18},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C17\",\"row\":\"C\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C16\",\"row\":\"C\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C15\",\"row\":\"C\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C14\",\"row\":\"C\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C13\",\"row\":\"C\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C12\",\"row\":\"C\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C11\",\"row\":\"C\",\"column\":11},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C10\",\"row\":\"C\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C9\",\"row\":\"C\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C8\",\"row\":\"C\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C7\",\"row\":\"C\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C6\",\"row\":\"C\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C5\",\"row\":\"C\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C4\",\"row\":\"C\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C3\",\"row\":\"C\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C2\",\"row\":\"C\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"C1\",\"row\":\"C\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D17\",\"row\":\"D\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D16\",\"row\":\"D\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D15\",\"row\":\"D\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D14\",\"row\":\"D\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D13\",\"row\":\"D\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D12\",\"row\":\"D\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D11\",\"row\":\"D\",\"column\":11},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D10\",\"row\":\"D\",\"column\":10},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D9\",\"row\":\"D\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D8\",\"row\":\"D\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D7\",\"row\":\"D\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D6\",\"row\":\"D\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D5\",\"row\":\"D\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D4\",\"row\":\"D\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D3\",\"row\":\"D\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D2\",\"row\":\"D\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"D1\",\"row\":\"D\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E16\",\"row\":\"E\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E15\",\"row\":\"E\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E14\",\"row\":\"E\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E13\",\"row\":\"E\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E12\",\"row\":\"E\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E11\",\"row\":\"E\",\"column\":11},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E10\",\"row\":\"E\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E9\",\"row\":\"E\",\"column\":9},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E8\",\"row\":\"E\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E7\",\"row\":\"E\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E6\",\"row\":\"E\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E5\",\"row\":\"E\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E4\",\"row\":\"E\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E3\",\"row\":\"E\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E2\",\"row\":\"E\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"E1\",\"row\":\"E\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F17\",\"row\":\"F\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F16\",\"row\":\"F\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F15\",\"row\":\"F\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F14\",\"row\":\"F\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F13\",\"row\":\"F\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F12\",\"row\":\"F\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F11\",\"row\":\"F\",\"column\":11},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F10\",\"row\":\"F\",\"column\":10},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F9\",\"row\":\"F\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F8\",\"row\":\"F\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F7\",\"row\":\"F\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F6\",\"row\":\"F\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F5\",\"row\":\"F\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F4\",\"row\":\"F\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F3\",\"row\":\"F\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F2\",\"row\":\"F\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"F1\",\"row\":\"F\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G18\",\"row\":\"G\",\"column\":18},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G17\",\"row\":\"G\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G16\",\"row\":\"G\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G15\",\"row\":\"G\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G14\",\"row\":\"G\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G13\",\"row\":\"G\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G12\",\"row\":\"G\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G11\",\"row\":\"G\",\"column\":11},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G10\",\"row\":\"G\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G9\",\"row\":\"G\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G8\",\"row\":\"G\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G7\",\"row\":\"G\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G6\",\"row\":\"G\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G5\",\"row\":\"G\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G4\",\"row\":\"G\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G3\",\"row\":\"G\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G2\",\"row\":\"G\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"G1\",\"row\":\"G\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H18\",\"row\":\"H\",\"column\":18},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H17\",\"row\":\"H\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H16\",\"row\":\"H\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H15\",\"row\":\"H\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H14\",\"row\":\"H\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H13\",\"row\":\"H\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H12\",\"row\":\"H\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H11\",\"row\":\"H\",\"column\":11},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H10\",\"row\":\"H\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H9\",\"row\":\"H\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H8\",\"row\":\"H\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H7\",\"row\":\"H\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H6\",\"row\":\"H\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H5\",\"row\":\"H\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H4\",\"row\":\"H\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H3\",\"row\":\"H\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H2\",\"row\":\"H\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"H1\",\"row\":\"H\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I18\",\"row\":\"I\",\"column\":18},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I17\",\"row\":\"I\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I16\",\"row\":\"I\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I15\",\"row\":\"I\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I14\",\"row\":\"I\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I13\",\"row\":\"I\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I12\",\"row\":\"I\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I11\",\"row\":\"I\",\"column\":11},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I10\",\"row\":\"I\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I9\",\"row\":\"I\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I8\",\"row\":\"I\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I7\",\"row\":\"I\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I6\",\"row\":\"I\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I5\",\"row\":\"I\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I4\",\"row\":\"I\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I3\",\"row\":\"I\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I2\",\"row\":\"I\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"I1\",\"row\":\"I\",\"column\":1}],[{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J18\",\"row\":\"J\",\"column\":18},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J17\",\"row\":\"J\",\"column\":17},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J16\",\"row\":\"J\",\"column\":16},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J15\",\"row\":\"J\",\"column\":15},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J14\",\"row\":\"J\",\"column\":14},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J13\",\"row\":\"J\",\"column\":13},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J12\",\"row\":\"J\",\"column\":12},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J11\",\"row\":\"J\",\"column\":11},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":false,\"color\":\"#6b7280\",\"zone\":1,\"code\":null,\"row\":null,\"column\":null},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J10\",\"row\":\"J\",\"column\":10},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J9\",\"row\":\"J\",\"column\":9},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J8\",\"row\":\"J\",\"column\":8},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J7\",\"row\":\"J\",\"column\":7},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J6\",\"row\":\"J\",\"column\":6},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J5\",\"row\":\"J\",\"column\":5},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J4\",\"row\":\"J\",\"column\":4},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J3\",\"row\":\"J\",\"column\":3},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J2\",\"row\":\"J\",\"column\":2},{\"isSeat\":true,\"color\":\"#6b7280\",\"zone\":1,\"code\":\"J1\",\"row\":\"J\",\"column\":1}]]', 172);

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `created_at`, `updated_at`, `deleted_at`, `label`) VALUES
(1, NULL, NULL, NULL, '12:00'),
(2, NULL, NULL, NULL, '12:15'),
(3, NULL, NULL, NULL, '12:30'),
(4, NULL, NULL, NULL, '12:45'),
(5, NULL, NULL, NULL, '13:00'),
(6, NULL, NULL, NULL, '13:15'),
(7, NULL, NULL, NULL, '13:30'),
(8, NULL, NULL, NULL, '13:45'),
(9, NULL, NULL, NULL, '14:00'),
(10, NULL, NULL, NULL, '14:15'),
(11, NULL, NULL, NULL, '14:30'),
(12, NULL, NULL, NULL, '14:45'),
(13, NULL, NULL, NULL, '15:00'),
(14, NULL, NULL, NULL, '15:15'),
(15, NULL, NULL, NULL, '15:30'),
(16, NULL, NULL, NULL, '15:45'),
(17, NULL, NULL, NULL, '16:00'),
(18, NULL, NULL, NULL, '16:15'),
(19, NULL, NULL, NULL, '16:30'),
(20, NULL, NULL, NULL, '16:45'),
(21, NULL, NULL, NULL, '17:00'),
(22, NULL, NULL, NULL, '17:15'),
(23, NULL, NULL, NULL, '17:30'),
(24, NULL, NULL, NULL, '17:45'),
(25, NULL, NULL, NULL, '18:00'),
(26, NULL, NULL, NULL, '18:15'),
(27, NULL, NULL, NULL, '18:30'),
(28, NULL, NULL, NULL, '18:45'),
(29, NULL, NULL, NULL, '19:00'),
(30, NULL, NULL, NULL, '19:15'),
(31, NULL, NULL, NULL, '19:30'),
(32, NULL, NULL, NULL, '19:45'),
(33, NULL, NULL, NULL, '20:00'),
(34, NULL, NULL, NULL, '20:15'),
(35, NULL, NULL, NULL, '20:30'),
(36, NULL, NULL, NULL, '20:45'),
(37, NULL, NULL, NULL, '21:00'),
(38, NULL, NULL, NULL, '21:15'),
(39, NULL, NULL, NULL, '21:30'),
(40, NULL, NULL, NULL, '21:45'),
(41, NULL, NULL, NULL, '22:00'),
(42, NULL, NULL, NULL, '22:15'),
(43, NULL, NULL, NULL, '22:30'),
(44, NULL, NULL, NULL, '22:45'),
(45, NULL, NULL, NULL, '23:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` text COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `date_marriage` date DEFAULT NULL,
  `login_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified` timestamp NULL DEFAULT NULL,
  `phone_verified` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status_id` bigint UNSIGNED DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `dom` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `email`, `phone`, `profile_picture`, `password`, `date_birth`, `date_marriage`, `login_provider`, `gender_id`, `email_verified`, `phone_verified`, `token`, `marital_status_id`, `gender`, `dob`, `dom`) VALUES
(10, '2024-12-03 07:28:48', '2024-12-03 07:28:48', NULL, 'Nourhane Sarieddine', 'nourhanesarieddine@gmail.com', '+96181684331', NULL, '$2y$12$1bZ1Fbp04YLd7eEQif2mwemeDI8dJ2xWQpzyAMcFIP6OncgR6.qkW', NULL, NULL, NULL, NULL, NULL, NULL, '3578e6d91a626d22e0d443a13aecf50ab9b50d8a6c82afc4603c08f7a454e5f8', NULL, NULL, NULL, NULL),
(23, '2025-01-02 09:04:50', '2025-01-02 09:04:50', NULL, 'test', 'test@gmail.com', '+96171611035', NULL, '$2y$12$d90ylqEbGdBfd0RRk0T0dus8IiKrWkgSF3e3UVK5g7gb2.l/L1Joq', NULL, NULL, NULL, NULL, NULL, NULL, '2b1abd590d6c601ab9a485735352e5b4d93c20b037907b108d5dec372d3ac9aa', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_cards`
--

CREATE TABLE `user_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci,
  `disabled_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_cards`
--

INSERT INTO `user_cards` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `barcode`, `type`, `disabled_at`) VALUES
(1, '2024-11-20 12:01:05', '2025-01-02 06:26:25', NULL, '10', '1080108010801080', 'physical', NULL),
(17, '2025-01-02 09:04:50', '2025-01-02 09:04:50', NULL, '23', '79096421874427124', 'physical', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_loyalty_transactions`
--

CREATE TABLE `user_loyalty_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `user_card_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_loyalty_transactions`
--

INSERT INTO `user_loyalty_transactions` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `amount`, `description`, `type`, `user_card_id`, `balance`, `reference`) VALUES
(1, '2024-11-21 05:53:57', '2024-11-21 05:53:57', NULL, '1', '100', 'nourhane', 'in', '1', '100', NULL),
(2, '2024-11-21 05:54:05', '2024-11-21 05:54:05', NULL, '1', '100', 'nourhane', 'in', '1', '200', NULL),
(3, '2024-11-21 05:55:33', '2024-11-21 05:55:33', NULL, '1', '100', 'nourhane', 'in', '1', '300', NULL),
(4, '2024-11-21 05:55:34', '2024-11-21 08:33:21', NULL, '1', '100', 'nourhane', 'in', '1', '80', NULL),
(5, '2024-11-21 08:36:48', '2024-11-21 08:36:48', NULL, '1', '100', 'nourhane', 'in', '1', '180', NULL),
(6, '2024-11-21 08:37:01', '2024-11-21 08:37:01', NULL, '1', '1000', 'nourhane', 'in', '1', '1180', NULL),
(7, '2024-11-21 08:37:23', '2024-11-21 12:31:56', NULL, '1', '180', 'nourhane', 'out', '1', '60', NULL),
(8, '2024-11-21 13:01:01', '2024-11-21 13:01:01', NULL, '1', '1000', 'nourhane', 'in', '1', '1060', NULL),
(9, '2024-11-21 13:01:03', '2024-11-25 06:18:39', NULL, '1', '1000', 'nourhane', 'in', '1', '1320', NULL),
(10, '2024-11-25 06:26:06', '2024-11-25 06:26:06', NULL, '1', '300', 'Redeem Reward', 'out', '1', '1020', '1'),
(11, '2024-12-05 14:10:30', '2024-12-05 14:10:30', NULL, '9', '12000', 'Add points from tickets', 'in', '5', '12000', '4'),
(12, '2024-12-12 12:14:15', '2024-12-12 12:14:15', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '40000', '15'),
(13, '2024-12-12 13:14:56', '2024-12-12 13:14:56', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '80000', '16'),
(14, '2024-12-12 13:59:52', '2024-12-12 13:59:52', NULL, '19', '80000', 'Add points from tickets', 'in', '13', '160000', '17'),
(15, '2024-12-12 23:27:46', '2024-12-12 23:27:46', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '200000', '18'),
(16, '2024-12-12 23:51:32', '2024-12-12 23:51:32', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '240000', '19'),
(17, '2024-12-16 05:59:18', '2024-12-16 05:59:18', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '280000', '20'),
(18, '2024-12-16 06:00:29', '2024-12-16 06:00:29', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '320000', '21'),
(19, '2024-12-16 06:00:55', '2024-12-16 06:00:55', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '360000', '22'),
(20, '2024-12-16 06:01:15', '2024-12-16 06:01:15', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '400000', '23'),
(21, '2024-12-16 06:01:54', '2024-12-16 06:01:54', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '440000', '24'),
(22, '2024-12-16 06:02:26', '2024-12-16 06:02:26', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '480000', '25'),
(23, '2024-12-16 06:03:55', '2024-12-16 06:03:55', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '520000', '26'),
(24, '2024-12-16 06:04:50', '2024-12-16 06:04:50', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '560000', '27'),
(25, '2024-12-16 06:06:17', '2024-12-16 06:06:17', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '600000', '28'),
(26, '2024-12-16 12:17:22', '2024-12-16 12:17:22', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '640000', '29'),
(27, '2024-12-16 12:18:49', '2024-12-16 12:18:49', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '680000', '30'),
(28, '2024-12-16 12:28:02', '2024-12-16 12:28:02', NULL, '19', '40000', 'Add points from tickets', 'in', '13', '720000', '31'),
(29, '2024-12-24 07:33:06', '2024-12-24 07:33:06', NULL, '10', '0', 'Add points from tickets', 'in', '1', '0', '46'),
(30, '2024-12-24 07:37:21', '2024-12-24 07:37:21', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '40000', '47'),
(31, '2024-12-24 07:39:59', '2024-12-24 07:39:59', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '80000', '48'),
(32, '2024-12-24 07:43:12', '2024-12-24 07:43:12', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '120000', '49'),
(33, '2024-12-24 07:48:47', '2024-12-24 07:48:47', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '160000', '50'),
(34, '2024-12-26 07:27:06', '2024-12-26 07:27:06', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '200000', '56'),
(35, '2024-12-26 07:33:24', '2024-12-26 07:33:24', NULL, '10', '40000', 'Add points from tickets', 'in', '1', '240000', '62'),
(36, '2024-12-27 06:41:40', '2024-12-27 06:41:40', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '260000', '1'),
(37, '2024-12-27 06:59:53', '2024-12-27 06:59:53', NULL, '10', '0', 'Add points from tickets', 'in', '1', '260000', '2'),
(38, '2024-12-27 07:01:28', '2024-12-27 07:01:28', NULL, '10', '0', 'Add points from tickets', 'in', '1', '260000', '3'),
(39, '2024-12-27 07:02:28', '2024-12-27 07:02:28', NULL, '10', '0', 'Add points from tickets', 'in', '1', '260000', '4'),
(40, '2024-12-27 07:05:27', '2024-12-27 07:05:27', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '280000', '5'),
(41, '2024-12-27 07:07:09', '2024-12-27 07:07:09', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '300000', '6'),
(42, '2024-12-27 07:11:42', '2024-12-27 07:11:42', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '320000', '7'),
(43, '2024-12-27 07:13:54', '2024-12-27 07:13:54', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '340000', '8'),
(44, '2024-12-27 07:21:16', '2024-12-27 07:21:16', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '360000', '9'),
(45, '2024-12-27 07:41:59', '2024-12-27 07:41:59', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '380000', '10'),
(46, '2024-12-27 09:08:34', '2024-12-27 09:08:34', NULL, '10', '0', 'Add points from tickets', 'in', '1', '380000', '2'),
(47, '2024-12-30 08:45:21', '2024-12-30 08:45:21', NULL, '10', '10000', 'Add points from tickets', 'in', '1', '390000', '4'),
(48, '2024-12-30 08:47:26', '2024-12-30 08:47:26', NULL, '10', '10000', 'Add points from tickets', 'in', '1', '400000', '7'),
(49, '2024-12-31 10:47:05', '2024-12-31 10:47:05', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '420000', '3'),
(50, '2025-01-02 06:56:20', '2025-01-02 06:56:20', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '440000', '2'),
(51, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, '10', '20000', 'Add points from tickets', 'in', '1', '460000', '2'),
(52, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, '10', '10000', 'Add points from tickets', 'in', '1', '470000', '3');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `pos_user_id` bigint UNSIGNED DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` bigint UNSIGNED DEFAULT NULL,
  `total_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `reward_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_rewards`
--

INSERT INTO `user_rewards` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `reward_id`, `code`, `used_at`) VALUES
(1, '2024-11-25 06:26:06', '2024-11-25 06:26:06', NULL, 1, 1, 'POVANP1BCK9WPZ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pos_user_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `created_at`, `updated_at`, `deleted_at`, `pos_user_id`, `type`) VALUES
(1, '2025-01-02 13:04:35', '2025-01-02 13:04:35', NULL, 1, 'LOGIN'),
(2, '2025-01-02 13:04:47', '2025-01-02 13:04:47', NULL, 1, 'LOGOUT'),
(3, '2025-01-02 13:35:02', '2025-01-02 13:35:02', NULL, 1, 'LOGIN'),
(4, '2025-01-02 13:35:22', '2025-01-02 13:35:22', NULL, 1, 'LOGIN');

-- --------------------------------------------------------

--
-- Table structure for table `user_verify_tokens`
--

CREATE TABLE `user_verify_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_wallet_transactions`
--

CREATE TABLE `user_wallet_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_card_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionable_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_wallet_transactions`
--

INSERT INTO `user_wallet_transactions` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `amount`, `description`, `type`, `reference`, `user_card_id`, `balance`, `gateway_reference`, `transactionable_id`, `transactionable_type`, `system_id`) VALUES
(4, '2024-12-24 05:40:44', '2024-12-24 05:40:44', NULL, '10', '10000', 'From CMS', 'in', 'CMS', '1', '10000', NULL, '2', 'twa\\cmsv2\\Models\\CmsUser', '5'),
(5, '2024-12-24 07:05:53', '2024-12-24 07:05:53', NULL, '10', '5000', 'Test', 'in', 'CMS', '1', '15000', NULL, '2', 'twa\\cmsv2\\Models\\CMSUser', '5'),
(6, '2024-12-24 07:15:03', '2024-12-24 07:15:03', NULL, '10', '10000', 'Testing', 'in', NULL, '1', '25000', NULL, '2', 'twa\\cmsv2\\Models\\CMSUser', '5'),
(7, '2024-12-24 07:33:06', '2024-12-24 07:33:06', NULL, '10', '50000', 'Recharge wallet', 'in', '46', '1', '75000', NULL, '1', 'App\\Models\\PosUser', '2'),
(8, '2024-12-24 07:48:47', '2024-12-24 07:48:47', NULL, '10', '40000', 'Wallet deducted for order', 'out', '50', '1', '35000', NULL, '10', 'App\\Models\\User', '1'),
(9, '2024-12-27 07:41:59', '2024-12-27 07:41:59', NULL, '10', '50000', 'Recharge wallet', 'in', '10', '1', '85000', NULL, '10', 'App\\Models\\User', '1'),
(10, '2024-12-30 08:47:26', '2024-12-30 08:47:26', NULL, '10', '5000', 'Recharge wallet', 'in', '7', '1', '90000', NULL, '10', 'App\\Models\\User', '1'),
(11, '2024-12-31 10:47:06', '2024-12-31 10:47:06', NULL, '10', '50000', 'Recharge wallet', 'in', '3', '1', '140000', NULL, '1', 'App\\Models\\PosUser', '2'),
(12, '2025-01-02 06:56:20', '2025-01-02 06:56:20', NULL, '10', '50000', 'Recharge wallet', 'in', '2', '1', '190000', NULL, '1', 'App\\Models\\PosUser', '2'),
(13, '2025-01-02 08:56:08', '2025-01-02 08:56:08', NULL, '10', '20000', 'Wallet deducted for order', 'out', '2', '1', '170000', NULL, '1', 'App\\Models\\PosUser', '2'),
(14, '2025-01-02 09:01:28', '2025-01-02 09:01:28', NULL, '10', '10000', 'Wallet deducted for order', 'out', '3', '1', '160000', NULL, '1', 'App\\Models\\PosUser', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_tokens`
--
ALTER TABLE `access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_coupons`
--
ALTER TABLE `cart_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_imtiyaz`
--
ALTER TABLE `cart_imtiyaz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_seats`
--
ALTER TABLE `cart_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seat` (`seat`,`movie_show_id`);

--
-- Indexes for table `cart_topups`
--
ALTER TABLE `cart_topups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informative_pages`
--
ALTER TABLE `informative_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kiosk_users`
--
ALTER TABLE `kiosk_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marital_status`
--
ALTER TABLE `marital_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_age_ratings`
--
ALTER TABLE `movie_age_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_casts`
--
ALTER TABLE `movie_casts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_directors`
--
ALTER TABLE `movie_directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_favorites`
--
ALTER TABLE `movie_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_languages`
--
ALTER TABLE `movie_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_shows`
--
ALTER TABLE `movie_shows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_show_theaters`
--
ALTER TABLE `movie_show_theaters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_coupons`
--
ALTER TABLE `order_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_seats`
--
ALTER TABLE `order_seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_topups`
--
ALTER TABLE `order_topups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_attempts`
--
ALTER TABLE `payment_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_users`
--
ALTER TABLE `pos_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_groups`
--
ALTER TABLE `price_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_group_zones`
--
ALTER TABLE `price_group_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserved_seats`
--
ALTER TABLE `reserved_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `movie_show_id` (`movie_show_id`,`seat`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screen_types`
--
ALTER TABLE `screen_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshows`
--
ALTER TABLE `slideshows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theaters`
--
ALTER TABLE `theaters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_loyalty_transactions`
--
ALTER TABLE `user_loyalty_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_verify_tokens`
--
ALTER TABLE `user_verify_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_wallet_transactions`
--
ALTER TABLE `user_wallet_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_tokens`
--
ALTER TABLE `access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_coupons`
--
ALTER TABLE `cart_coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_imtiyaz`
--
ALTER TABLE `cart_imtiyaz`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_seats`
--
ALTER TABLE `cart_seats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_topups`
--
ALTER TABLE `cart_topups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informative_pages`
--
ALTER TABLE `informative_pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kiosk_users`
--
ALTER TABLE `kiosk_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marital_status`
--
ALTER TABLE `marital_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie_age_ratings`
--
ALTER TABLE `movie_age_ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movie_casts`
--
ALTER TABLE `movie_casts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `movie_directors`
--
ALTER TABLE `movie_directors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie_favorites`
--
ALTER TABLE `movie_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movie_genres`
--
ALTER TABLE `movie_genres`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `movie_languages`
--
ALTER TABLE `movie_languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movie_shows`
--
ALTER TABLE `movie_shows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `movie_show_theaters`
--
ALTER TABLE `movie_show_theaters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_coupons`
--
ALTER TABLE `order_coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_seats`
--
ALTER TABLE `order_seats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_topups`
--
ALTER TABLE `order_topups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_attempts`
--
ALTER TABLE `payment_attempts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pos_users`
--
ALTER TABLE `pos_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `price_groups`
--
ALTER TABLE `price_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `price_group_zones`
--
ALTER TABLE `price_group_zones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reserved_seats`
--
ALTER TABLE `reserved_seats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `screen_types`
--
ALTER TABLE `screen_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slideshows`
--
ALTER TABLE `slideshows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `theaters`
--
ALTER TABLE `theaters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_loyalty_transactions`
--
ALTER TABLE `user_loyalty_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_verify_tokens`
--
ALTER TABLE `user_verify_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_wallet_transactions`
--
ALTER TABLE `user_wallet_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
