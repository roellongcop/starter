-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2021 at 07:47 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_starter`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_backups`
--

CREATE TABLE `tbl_backups` (
  `id` bigint(20) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `tables` text,
  `description` text,
  `slug` varchar(255) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_backups`
--

INSERT INTO `tbl_backups` (`id`, `filename`, `tables`, `description`, `slug`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1624520833', '{\"tbl_backups\":\"tbl_backups\",\"tbl_files\":\"tbl_files\",\"tbl_ips\":\"tbl_ips\",\"tbl_logs\":\"tbl_logs\",\"tbl_migrations\":\"tbl_migrations\",\"tbl_model_files\":\"tbl_model_files\",\"tbl_notifications\":\"tbl_notifications\",\"tbl_queues\":\"tbl_queues\",\"tbl_roles\":\"tbl_roles\",\"tbl_sessions\":\"tbl_sessions\",\"tbl_settings\":\"tbl_settings\",\"tbl_themes\":\"tbl_themes\",\"tbl_user_metas\":\"tbl_user_metas\",\"tbl_users\":\"tbl_users\",\"tbl_visit_logs\":\"tbl_visit_logs\"}', 'Description', '1624520833', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE `tbl_files` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `extension` varchar(16) NOT NULL,
  `size` bigint(20) NOT NULL,
  `location` text,
  `token` varchar(255) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_files`
--

INSERT INTO `tbl_files` (`id`, `name`, `extension`, `size`, `location`, `token`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'default-image_200', 'png', 1606, 'default/default-image_200.png', 'default-6ccb4a66-0ca3-46c7-88dd-default', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13'),
(2, 'default-backup', 'sql', 81341, 'default/default-backup.sql', 'default-OxFBeC2Dzw1624513904-default', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ips`
--

CREATE TABLE `tbl_ips` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ips`
--

INSERT INTO `tbl_ips` (`id`, `name`, `description`, `type`, `slug`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '191.168.1.1', 'testing IP', 1, '19116811', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `model_id` bigint(20) NOT NULL DEFAULT '0',
  `request_data` text,
  `change_attribute` text,
  `method` varchar(32) NOT NULL,
  `url` text,
  `action` varchar(256) NOT NULL,
  `controller` varchar(256) NOT NULL,
  `table_name` varchar(256) NOT NULL,
  `model_name` varchar(256) NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `browser` varchar(128) DEFAULT NULL,
  `os` varchar(128) DEFAULT NULL,
  `device` varchar(128) DEFAULT NULL,
  `server` text,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`id`, `user_id`, `model_id`, `request_data`, `change_attribute`, `method`, `url`, `action`, `controller`, `table_name`, `model_name`, `ip`, `browser`, `os`, `device`, `server`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"_csrf\":\"QRS8RhBMyW_SC_JgnkJIV1eVxNvzXQdX9rmFpI9AOKgzX8kBWz-MA7xNwlnQESI1D_Sb6aJuTTuzgLzL6nkO0Q==\",\"LoginForm\":{\"username\":\"developer@developer.com\",\"password\":\"developer@developer.com\"}}', '{\"user_id\":null,\"ip\":null,\"action\":null,\"record_status\":null,\"created_at\":null,\"updated_at\":null,\"created_by\":null,\"updated_by\":null,\"id\":null}', 'POST', 'http://localhost:8080//site/login', 'login', 'site', 'visit_logs', 'VisitLog', '::1', 'Chrome', 'Windows', 'Computer', '{\"DOCUMENT_ROOT\":\"C:\\\\laragon\\\\www\\\\starter\\\\web\",\"REMOTE_ADDR\":\"::1\",\"REMOTE_PORT\":\"53724\",\"SERVER_SOFTWARE\":\"PHP 7.4.8 Development Server\",\"SERVER_PROTOCOL\":\"HTTP\\/1.1\",\"SERVER_NAME\":\"localhost\",\"SERVER_PORT\":\"8080\",\"REQUEST_URI\":\"\\/dashboard\",\"REQUEST_METHOD\":\"GET\",\"SCRIPT_NAME\":\"\\/index.php\",\"SCRIPT_FILENAME\":\"C:\\\\laragon\\\\www\\\\starter\\\\web\\\\index.php\",\"PATH_INFO\":\"\\/dashboard\",\"PHP_SELF\":\"\\/index.php\\/dashboard\",\"HTTP_HOST\":\"localhost:8080\",\"HTTP_CONNECTION\":\"keep-alive\",\"HTTP_CACHE_CONTROL\":\"max-age=0\",\"HTTP_SEC_CH_UA\":\"\\\" Not;A Brand\\\";v=\\\"99\\\", \\\"Google Chrome\\\";v=\\\"91\\\", \\\"Chromium\\\";v=\\\"91\\\"\",\"HTTP_SEC_CH_UA_MOBILE\":\"?0\",\"HTTP_UPGRADE_INSECURE_REQUESTS\":\"1\",\"HTTP_USER_AGENT\":\"Mozilla\\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/91.0.4472.77 Safari\\/537.36\",\"HTTP_ACCEPT\":\"text\\/html,application\\/xhtml+xml,application\\/xml;q=0.9,image\\/avif,image\\/webp,image\\/apng,*\\/*;q=0.8,application\\/signed-exchange;v=b3;q=0.9\",\"HTTP_SEC_FETCH_SITE\":\"none\",\"HTTP_SEC_FETCH_MODE\":\"navigate\",\"HTTP_SEC_FETCH_USER\":\"?1\",\"HTTP_SEC_FETCH_DEST\":\"document\",\"HTTP_ACCEPT_ENCODING\":\"gzip, deflate, br\",\"HTTP_ACCEPT_LANGUAGE\":\"en-US,en;q=0.9,la;q=0.8\",\"HTTP_COOKIE\":\"_ga=GA1.1.407239226.1600821663; debug-bar-tab=ci-timeline; debug-bar-state=minimized; fpestid=Ff_-ZGvswuV27XqYVgDFEd0fvEqQ7pasvbVfIEO5DQpJWsJaQ1bzIX9beYi6_HEfIAqd8g; PHPSESSID=n7mqbe78d7vrjdcun8m9oqvd11; _csrf=7e359696465f5ba6fd7b8c33041c4d6d4b96d48272cbe12371c3131ea84dfb69a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22WMOrqqjCkes0q4R86NNyOyJE_ZkduEj_%22%3B%7D\",\"REQUEST_TIME_FLOAT\":1623125700.650181,\"REQUEST_TIME\":1623125700}', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migrations`
--

CREATE TABLE `tbl_migrations` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migrations`
--

INSERT INTO `tbl_migrations` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1623744833),
('m200912_033904_create_users_table', 1623744836),
('m200912_035017_create_roles_table', 1623744836),
('m200913_060425_create_logs_table', 1623744837),
('m200913_060445_create_visit_logs_table', 1623744838),
('m200913_060452_create_files_table', 1623744839),
('m200924_130808_create_ips_table', 1623744839),
('m201111_135954_create_settings_table', 1623744840),
('m201129_112459_create_backups_table', 1623744840),
('m201201_043253_create_sessions_table', 1623744841),
('m201229_073837_create_user_meta_table', 1623744842),
('m210111_014007_create_themes_table', 1623744843),
('m210116_162927_create_model_files_table', 1623744844),
('m210314_045639_seed_themes_table', 1623744844),
('m210524_085128_create_queues_table', 1623744845),
('m210524_104252_create_notifications_table', 1623744846),
('m210528_064716_seed_roles_table', 1623744846),
('m210528_070049_seed_users_table', 1623744848),
('m210611_020152_seed_files_table', 1623744848);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_model_files`
--

CREATE TABLE `tbl_model_files` (
  `id` bigint(20) NOT NULL,
  `model_id` bigint(20) NOT NULL DEFAULT '0',
  `file_id` bigint(20) NOT NULL DEFAULT '0',
  `model_name` varchar(255) NOT NULL,
  `extension` varchar(16) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_model_files`
--

INSERT INTO `tbl_model_files` (`id`, `model_id`, `file_id`, `model_name`, `extension`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'User', 'jpg', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13'),
(2, 1, 2, 'Backup', 'sql', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `message` text,
  `link` text,
  `type` varchar(128) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`id`, `user_id`, `message`, `link`, `type`, `token`, `status`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'You\'ve Change your password', 'http://localhost:8080//user/my-password', 'notification_change_password', 'TftF853osh1623298888', 0, 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13'),
(2, 1, 'You\'ve Change your password', 'http://localhost:8080//user/my-password', 'notification_change_password', 'TftF853osh1623298888', 1, 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_queues`
--

CREATE TABLE `tbl_queues` (
  `id` bigint(20) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `job` blob,
  `pushed_at` int(11) NOT NULL,
  `ttr` int(11) NOT NULL,
  `delay` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) UNSIGNED NOT NULL DEFAULT '1024',
  `reserved_at` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `done_at` int(11) DEFAULT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_queues`
--

INSERT INTO `tbl_queues` (`id`, `channel`, `job`, `pushed_at`, `ttr`, `delay`, `priority`, `reserved_at`, `attempt`, `done_at`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'default', '', 1623377345, 300, 0, 1024, NULL, NULL, NULL, 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `main_navigation` text,
  `role_access` text,
  `module_access` text,
  `slug` varchar(255) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `name`, `main_navigation`, `role_access`, `module_access`, `slug`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'developer', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"14\":\"in-active-data\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'developer', 1, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08'),
(2, 'superadmin', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"14\":\"in-active-data\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'superadmin', 1, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08'),
(3, 'admin', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"14\":\"in-active-data\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'admin', 1, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08'),
(4, 'inactiverole', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"14\":\"in-active-data\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'inactiverole', 0, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08'),
(5, 'nouser', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"14\":\"in-active-data\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'nouser', 0, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08'),
(6, 'developernoiactiverole', '{\"1\":{\"label\":\"Dashboard\",\"link\":\"\\/dashboard\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2\":{\"label\":\"Users\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"2.1\":{\"label\":\"List\",\"link\":\"\\/user\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"2.2\":{\"label\":\"User Meta\",\"link\":\"\\/user-meta\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"3\":{\"label\":\"Files\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"3.1\":{\"label\":\"List\",\"link\":\"\\/file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.2\":{\"label\":\"My Files\",\"link\":\"\\/my-files\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"3.3\":{\"label\":\"Model Files\",\"link\":\"\\/model-file\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"4\":{\"label\":\"System\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"4.1\":{\"label\":\"Roles\",\"link\":\"\\/role\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.2\":{\"label\":\"Backups\",\"link\":\"\\/backup\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.3\":{\"label\":\"Sessions\",\"link\":\"\\/session\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.4\":{\"label\":\"Logs\",\"link\":\"\\/log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.5\":{\"label\":\"Visit Logs\",\"link\":\"\\/visit-log\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"4.6\":{\"label\":\"Queues\",\"link\":\"\\/queue\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"5\":{\"label\":\"Settings\",\"link\":\"#\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\",\"sub\":{\"5.1\":{\"label\":\"List\",\"link\":\"\\/setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.2\":{\"label\":\"My Settings\",\"link\":\"\\/my-setting\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.3\":{\"label\":\"General Setting\",\"link\":\"\\/setting\\/general\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.4\":{\"label\":\"Ip\",\"link\":\"\\/ip\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"},\"5.5\":{\"label\":\"Themes\",\"link\":\"\\/theme\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}},\"6\":{\"label\":\"Notifications\",\"link\":\"\\/notification\",\"icon\":\"<i class=\\\"fa fa-cog\\\"><\\/i>\"}}', '[]', '{\"backup\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"12\":\"download\",\"3\":\"duplicate\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"11\":\"restore\",\"1\":\"view\"},\"dashboard\":[\"index\"],\"file\":{\"16\":\"change-photo\",\"7\":\"change-record-status\",\"8\":\"bulk-action\",\"3\":\"create\",\"6\":\"delete\",\"0\":\"display\",\"15\":\"download\",\"4\":\"duplicate\",\"11\":\"export-csv\",\"10\":\"export-pdf\",\"12\":\"export-xls\",\"13\":\"export-xlsx\",\"17\":\"in-active-data\",\"1\":\"index\",\"19\":\"my-files\",\"18\":\"my-image-files\",\"9\":\"print\",\"5\":\"update\",\"14\":\"upload\",\"2\":\"view\"},\"ip\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"model-file\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"notification\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"2\":\"create\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"11\":\"in-active-data\",\"0\":\"index\",\"6\":\"print\",\"1\":\"view\"},\"queue\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"role\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"0\":\"index\",\"13\":\"my-role\",\"8\":\"print\",\"4\":\"update\",\"1\":\"view\"},\"session\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"},\"setting\":{\"4\":\"change-record-status\",\"5\":\"bulk-action\",\"3\":\"delete\",\"8\":\"export-csv\",\"7\":\"export-pdf\",\"9\":\"export-xls\",\"10\":\"export-xlsx\",\"12\":\"general\",\"13\":\"in-active-data\",\"0\":\"index\",\"11\":\"my-setting\",\"6\":\"print\",\"2\":\"update\",\"1\":\"view\"},\"site\":{\"5\":\"about\",\"4\":\"contact\",\"1\":\"index\",\"2\":\"login\",\"3\":\"logout\",\"0\":\"reset-password\"},\"theme\":{\"12\":\"activate\",\"5\":\"change-record-status\",\"6\":\"bulk-action\",\"2\":\"create\",\"4\":\"delete\",\"9\":\"export-csv\",\"8\":\"export-pdf\",\"10\":\"export-xls\",\"11\":\"export-xlsx\",\"13\":\"in-active-data\",\"0\":\"index\",\"7\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"user\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"16\":\"dashboard\",\"5\":\"delete\",\"3\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"17\":\"in-active-data\",\"0\":\"index\",\"15\":\"my-account\",\"13\":\"my-password\",\"8\":\"print\",\"14\":\"profile\",\"4\":\"update\",\"1\":\"view\"},\"user-meta\":{\"6\":\"change-record-status\",\"7\":\"bulk-action\",\"2\":\"create\",\"5\":\"delete\",\"4\":\"duplicate\",\"10\":\"export-csv\",\"9\":\"export-pdf\",\"11\":\"export-xls\",\"12\":\"export-xlsx\",\"13\":\"filter\",\"14\":\"in-active-data\",\"0\":\"index\",\"8\":\"print\",\"3\":\"update\",\"1\":\"view\"},\"visit-log\":{\"3\":\"change-record-status\",\"4\":\"bulk-action\",\"2\":\"delete\",\"7\":\"export-csv\",\"6\":\"export-pdf\",\"8\":\"export-xls\",\"9\":\"export-xlsx\",\"10\":\"in-active-data\",\"0\":\"index\",\"5\":\"print\",\"1\":\"view\"}}', 'developernoiactiverole', 0, 0, 0, '2021-06-24 07:47:08', '2021-06-24 07:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sessions`
--

CREATE TABLE `tbl_sessions` (
  `id` varchar(40) NOT NULL,
  `expire` bigint(20) DEFAULT NULL,
  `data` blob,
  `user_id` bigint(20) DEFAULT '0',
  `ip` varchar(32) DEFAULT NULL,
  `browser` varchar(128) DEFAULT NULL,
  `os` varchar(128) DEFAULT NULL,
  `device` varchar(128) DEFAULT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sessions`
--

INSERT INTO `tbl_sessions` (`id`, `expire`, `data`, `user_id`, `ip`, `browser`, `os`, `device`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
('in2jfqrqoj5d6luo7qleggimid', 1624520833, '', 2, '::1', 'Chrome', 'Windows', 'Computer', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  `slug` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `name`, `value`, `slug`, `type`, `sort_order`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'timezone', 'Asia/Manila', 'timezone', 'general', 0, 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_themes`
--

CREATE TABLE `tbl_themes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `base_path` text,
  `base_url` text,
  `path_map` text,
  `bundles` text,
  `slug` varchar(255) NOT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_themes`
--

INSERT INTO `tbl_themes` (`id`, `name`, `description`, `base_path`, `base_url`, `path_map`, `bundles`, `slug`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Demo1 Main', 'keen/sub/demo1/main', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo1-main', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(2, 'Demo1 Main Fluid', 'keen/sub/demo1/fluid', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo1-main-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(3, 'Light', 'keen/sub/demo1/light', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/light\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/light\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'light', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(4, 'Light Fluid', 'keen/sub/demo1/lightFluid', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/lightFluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/light\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/lightFluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/light\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'light-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(5, 'Dark', 'keen/sub/demo1/dark', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/dark\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/dark\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'dark', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(6, 'Dark Fluid', 'keen/sub/demo1/darkFluid', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/darkFluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/dark\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/darkFluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/dark\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'dark-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(7, 'No-aside Light', 'keen/sub/demo1/noAsideLight', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'no-aside-light', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(8, 'No-aside Light Fluid', 'keen/sub/demo1/noAsideLightFluid', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLightFluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLightFluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'no-aside-light-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(9, 'No-aside Dark', 'keen/sub/demo1/noAsideDark', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideDark\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideDark\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'no-aside-dark', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(10, 'No-aside Dark Fluid', 'keen/sub/demo1/noAsideDarkFluid', '@app/themes/keen/sub/demo1/main/assets/assets', '@web/themes/keen/sub/demo1/main', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideDarkFluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideDarkFluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/noAsideLight\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo1\\/main\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'no-aside-dark-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(11, 'Starter', 'starter', '@app/assets/', '@web/themes/starter', '{\"@app\\/views\":[\"@app\\/views\"],\"@app\\/widgets\":[\"@app\\/widgets\"]}', '[]', 'starter', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(12, 'Demo2 Fixed', 'keen/sub/demo2/fixed', '@app/themes/keen/sub/demo2/fixed/assets/assets', '@web/themes/keen/sub/demo2/fixed', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo2-fixed', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(13, 'Demo2 Fluid', 'keen/sub/demo2/fluid', '@app/themes/keen/sub/demo2/fixed/assets/assets', '@web/themes/keen/sub/demo2/fixed', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo2\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo2\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo2\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo2-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(14, 'Demo3 Fixed', 'keen/sub/demo3/fixed', '@app/themes/keen/sub/demo3/fixed/assets/assets', '@web/themes/keen/sub/demo3/fixed', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo3-fixed', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04'),
(15, 'Demo3 Fluid', 'keen/sub/demo3/fluid', '@app/themes/keen/sub/demo3/fixed/assets/assets', '@web/themes/keen/sub/demo3/fixed', '{\"@app\\/views\":[\"@app\\/themes\\/keen\\/sub\\/demo3\\/fluid\\/views\",\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/views\",\"@app\\/themes\\/keen\\/views\"],\"@app\\/widgets\":[\"@app\\/themes\\/keen\\/sub\\/demo3\\/fluid\\/widgets\",\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/widgets\",\"@app\\/themes\\/keen\\/widgets\"]}', '{\"yii\\\\web\\\\JqueryAsset\":{\"jsOptions\":{\"position\":1},\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"js\":[\"plugins.bundle.js\"]},\"yii\\\\bootstrap\\\\BootstrapAsset\":{\"sourcePath\":\"@app\\/themes\\/keen\\/sub\\/demo3\\/fixed\\/assets\\/assets\\/plugins\\/global\\/\",\"css\":[\"plugins.bundle.css\"]}}', 'demo3-fluid', 1, 0, 0, '2021-06-15 00:14:04', '2021-06-15 00:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL DEFAULT '0',
  `username` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_hint` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `slug` varchar(255) NOT NULL,
  `is_blocked` tinyint(2) NOT NULL DEFAULT '0',
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `role_id`, `username`, `email`, `auth_key`, `password_hash`, `password_hint`, `password_reset_token`, `verification_token`, `access_token`, `status`, `slug`, `is_blocked`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'developer', 'developer@developer.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd31', '$2y$13$vFn.4HQ8TmgjupZZuI7d7OgdelWOK4Hw3nSVg8ODJgFlhAIZUuPGy', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994601', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994601', 'access-fGurkHEAh4OSAT6BuC66_1621994601', 10, 'developer', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(2, 2, 'superadmin', 'superadmin@superadmin.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd32', '$2y$13$D64qB5VeRMqnguqsL00m9e2/LBo9HKr9Jk1y/w.G8p8qE/MVEcB3i', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994602', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994602', 'access-fGurkHEAh4OSAT6BuC66_1621994602', 10, 'superadmin', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(3, 3, 'admin', 'admin@admin.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd33', '$2y$13$J2cQn1FTJoDSpY9j0Rcxt.1h7cJnIAFiFdFfW6zFOOEw4IK0ElbCy', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994603', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994603', 'access-fGurkHEAh4OSAT6BuC66_1621994603', 10, 'admin', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(4, 1, 'blockeduser', 'blockeduser@blockeduser.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd34', '$2y$13$9l5P1VBQcWGkjZIPfuF9QuzpZ0NIE3FWKWL.L/D7Ob/2kkvF0sByq', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994604', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994604', 'access-fGurkHEAh4OSAT6BuC66_1621994604', 10, 'blockeduser', 1, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(5, 1, 'notverifieduser', 'notverifieduser@notverifieduser.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd35', '$2y$13$t4wp1k5QnOCGSViA7qyL5uPhh7ygG6DoPP3.RWloNhPA97uzsqinC', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994605', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994605', 'access-fGurkHEAh4OSAT6BuC66_1621994605', 9, 'notverifieduser', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(6, 1, 'inactiveuser', 'inactiveuser@inactiveuser.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd36', '$2y$13$I1QSII.B4IECz6pE6GZsT.YJjVLytZfEWCipjMZIyOPTuI0Smnq7a', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994606', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994606', 'access-fGurkHEAh4OSAT6BuC66_1621994606', 10, 'inactiveuser', 0, 0, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(7, 4, 'inactiveroleuser', 'inactiveroleuser@inactiveroleuser.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd37', '$2y$13$dRxYqja3b1oovynJDTde3eWdVRZOR6ZrGj.N5LVNbIJuRFPnYlXne', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994607', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994607', 'access-fGurkHEAh4OSAT6BuC66_1621994607', 10, 'inactiveroleuser', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12'),
(8, 6, 'noinactiveroleuser', 'noinactiveroleuser@noinactiveroleuser.com', 'nq74j8c0ETbVr60piMEj6HWSbnVqYd37', '$2y$13$iThWKxpE1rGYRUnBCNo3WegKObJTJQ7FfA71ZMCM5/SZYRNPWV8fy', 'Same as Email', 'lhOjDuhePXXncJJgjCNfS8NFee2HYWsp_1621994608', 'T3w4HHxCXcU-fGurkHEAh4OSAT6BuC66_1621994608', 'access-fGurkHEAh4OSAT6BuC66_1621994608', 10, 'noinactiveroleuser', 0, 1, 0, 0, '2021-06-24 07:47:12', '2021-06-24 07:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_metas`
--

CREATE TABLE `tbl_user_metas` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` text,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_metas`
--

INSERT INTO `tbl_user_metas` (`id`, `user_id`, `name`, `value`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'profile', '{\"user_id\":1,\"first_name\":\"admin_firstname\",\"last_name\":\"admin_lastname\"}', 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visit_logs`
--

CREATE TABLE `tbl_visit_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `action` tinyint(2) NOT NULL DEFAULT '0',
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_visit_logs`
--

INSERT INTO `tbl_visit_logs` (`id`, `user_id`, `ip`, `action`, `record_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '::1', 0, 1, 1, 1, '2021-06-24 07:47:13', '2021-06-24 07:47:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_backups`
--
ALTER TABLE `tbl_backups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_files`
--
ALTER TABLE `tbl_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `tbl_ips`
--
ALTER TABLE `tbl_ips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `model_id` (`model_id`);

--
-- Indexes for table `tbl_migrations`
--
ALTER TABLE `tbl_migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tbl_model_files`
--
ALTER TABLE `tbl_model_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_queues`
--
ALTER TABLE `tbl_queues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `channel` (`channel`),
  ADD KEY `priority` (`priority`),
  ADD KEY `reserved_at` (`reserved_at`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_sessions`
--
ALTER TABLE `tbl_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_themes`
--
ALTER TABLE `tbl_themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `verification_token` (`verification_token`),
  ADD UNIQUE KEY `access_token` (`access_token`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `tbl_user_metas`
--
ALTER TABLE `tbl_user_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_visit_logs`
--
ALTER TABLE `tbl_visit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_backups`
--
ALTER TABLE `tbl_backups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_files`
--
ALTER TABLE `tbl_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ips`
--
ALTER TABLE `tbl_ips`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_model_files`
--
ALTER TABLE `tbl_model_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_queues`
--
ALTER TABLE `tbl_queues`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_themes`
--
ALTER TABLE `tbl_themes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user_metas`
--
ALTER TABLE `tbl_user_metas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_visit_logs`
--
ALTER TABLE `tbl_visit_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
