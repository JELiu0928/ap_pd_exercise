-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-10-13 09:21:53
-- 伺服器版本： 10.4.25-MariaDB
-- PHP 版本： 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `backend`
--

-- --------------------------------------------------------

--
-- 資料表結構 `basic_ams_role`
--

DROP TABLE IF EXISTS `basic_ams_role`;
CREATE TABLE `basic_ams_role` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '此權限是否啟用',
  `user_id` int(11) NOT NULL COMMENT '[FK] 後台使用者',
  `is_ams` int(11) NOT NULL COMMENT '4否4否用有ams犬鮮',
  `a_or_m` int(11) NOT NULL COMMENT '1最大使用者2部分管理者',
  `is_cms` int(11) NOT NULL COMMENT 'CMS 管理權限是否啟用',
  `is_cms_temp` int(11) NOT NULL COMMENT 'CMS Template 管理權限是否啟用',
  `is_crs` int(11) NOT NULL COMMENT 'CMS Review 管理權限是否啟用',
  `is_fms` int(11) NOT NULL COMMENT 'FMS 管理權限是否啟用',
  `is_web` int(11) NOT NULL COMMENT 'Website Analyitcs 管理權限是否啟用',
  `is_google` int(11) NOT NULL COMMENT 'Google Analyitcs 管理權限是否啟用',
  `is_message` int(11) NOT NULL COMMENT 'Message 管理權限是否啟用',
  `is_fantasy` int(11) NOT NULL COMMENT 'Fantasy Account 管理權限是否啟用',
  `is_fantasy_setting` int(11) NOT NULL COMMENT 'Fantasy Setting 管理權限是否啟用',
  `is_autoredirect` int(11) NOT NULL COMMENT '是否可管理301轉址',
  `is_log` int(11) NOT NULL COMMENT '是否可查看LOG紀錄',
  `is_cover_page` int(11) NOT NULL,
  `is_cms_template` int(11) NOT NULL,
  `is_cms_template_ma` int(11) NOT NULL,
  `is_cms_template_setting` int(11) NOT NULL,
  `is_cover_page_setting` int(11) NOT NULL,
  `is_crs_role` int(11) NOT NULL,
  `is_folder` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_overview_crs` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `create_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ams 相關編輯權限';

--
-- 傾印資料表的資料 `basic_ams_role`
--

INSERT INTO `basic_ams_role` (`id`, `is_active`, `user_id`, `is_ams`, `a_or_m`, `is_cms`, `is_cms_temp`, `is_crs`, `is_fms`, `is_web`, `is_google`, `is_message`, `is_fantasy`, `is_fantasy_setting`, `is_autoredirect`, `is_log`, `is_cover_page`, `is_cms_template`, `is_cms_template_ma`, `is_cms_template_setting`, `is_cover_page_setting`, `is_crs_role`, `is_folder`, `updated_at`, `is_overview_crs`, `created_at`, `create_id`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '2022-05-13 13:50:46', 0, '2018-08-31 10:49:01', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `basic_autoredirect`
--

DROP TABLE IF EXISTS `basic_autoredirect`;
CREATE TABLE `basic_autoredirect` (
  `id` int(11) NOT NULL COMMENT '編號',
  `w_rank` int(11) NOT NULL COMMENT '排序',
  `is_reviewed` int(11) NOT NULL COMMENT '審核',
  `is_preview` int(11) NOT NULL COMMENT '預覽',
  `is_visible` int(11) NOT NULL COMMENT '顯示',
  `wait_del` int(11) NOT NULL COMMENT '申請刪除',
  `branch_id` int(11) NOT NULL COMMENT '分館',
  `parent_id` int(11) NOT NULL COMMENT '上層',
  `second_id` int(11) NOT NULL COMMENT '上層',
  `old_url` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '舊網址',
  `new_url` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '新網址',
  `active301` int(11) NOT NULL,
  `updated_at` datetime NOT NULL COMMENT '更新時間',
  `created_at` datetime NOT NULL COMMENT '建立時間',
  `create_id` int(11) NOT NULL COMMENT '建立者'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='網站重定向設定';

--
-- 傾印資料表的資料 `basic_autoredirect`
--

INSERT INTO `basic_autoredirect` (`id`, `w_rank`, `is_reviewed`, `is_preview`, `is_visible`, `wait_del`, `branch_id`, `parent_id`, `second_id`, `old_url`, `new_url`, `active301`, `updated_at`, `created_at`, `create_id`) VALUES
(5, 0, 0, 0, 1, 0, 1, 0, 0, 'http://backend-leon.test/admin.php', 'http://backend-leon.test/tw', 0, '2022-05-11 16:01:35', '2022-05-11 16:01:35', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `basic_branch_origin`
--

DROP TABLE IF EXISTS `basic_branch_origin`;
CREATE TABLE `basic_branch_origin` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '是否開啟',
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館名稱',
  `en_title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館英文名稱',
  `url_title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館 網址標題',
  `local_set` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館擁有語系(json)',
  `local_review_set` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館語系是否要審核(json)',
  `blade_template` int(11) NOT NULL COMMENT '分館blade模板',
  `create_id` int(11) NOT NULL COMMENT '創建分館者',
  `edit_user` int(11) NOT NULL COMMENT '最後更新者',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分館(基本 最高者)' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_branch_origin`
--

INSERT INTO `basic_branch_origin` (`id`, `is_active`, `title`, `en_title`, `url_title`, `local_set`, `local_review_set`, `blade_template`, `create_id`, `edit_user`, `updated_at`, `created_at`) VALUES
(1, 1, '總覽', 'backend-leon', 'backend-leon', '[\"tw\",\"en\"]', '[\"\"]', 2, 1, 1, '2022-07-07 18:01:13', '2019-04-17 11:10:19');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_branch_origin_unit`
--

DROP TABLE IF EXISTS `basic_branch_origin_unit`;
CREATE TABLE `basic_branch_origin_unit` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '是否正常開啟',
  `origin_id` int(11) NOT NULL COMMENT '屬於哪個分館[FK]',
  `create_id` int(11) NOT NULL,
  `locale` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '語系',
  `unit_set` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '開啟哪些單元for這個分館(json)(FK  to Key)',
  `unit_show` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '前台顯示哪些單元(json)(FK to Key)',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分館基本設定(json)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分館開啟單元與前台開啟之單元(分語系)' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_branch_origin_unit`
--

INSERT INTO `basic_branch_origin_unit` (`id`, `is_active`, `origin_id`, `create_id`, `locale`, `unit_set`, `unit_show`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 'tw', '{\"1\":\"1\"}', '', '', '2022-07-07 18:01:35', '2022-07-07 18:03:03'),
(2, 1, 1, 0, 'en', '{\"1\":\"1\"}', '', '', '2022-07-07 18:01:35', '2022-07-07 18:02:29');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_child`
--

DROP TABLE IF EXISTS `basic_cms_child`;
CREATE TABLE `basic_cms_child` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL COMMENT 'basic_cms_menu_use.id',
  `is_rank` int(11) NOT NULL COMMENT '是否有rank',
  `create_id` int(11) NOT NULL,
  `child_model` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '兒子model名稱',
  `child_key` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '連接key',
  `leon_key` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='兒子';

--
-- 傾印資料表的資料 `basic_cms_child`
--

INSERT INTO `basic_cms_child` (`id`, `menu_id`, `is_rank`, `create_id`, `child_model`, `child_key`, `leon_key`, `created_at`, `updated_at`) VALUES
(1, 3, 0, 0, 'BackendMainContent', 'parent_id', 0, '2022-07-04 11:51:21', '2022-07-04 11:51:21');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_child_son`
--

DROP TABLE IF EXISTS `basic_cms_child_son`;
CREATE TABLE `basic_cms_child_son` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `model_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '資料表名稱',
  `child_id` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `child_key` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '連接key名稱',
  `leon_key` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='兒子的兒子';

--
-- 傾印資料表的資料 `basic_cms_child_son`
--

INSERT INTO `basic_cms_child_son` (`id`, `is_active`, `model_name`, `child_id`, `create_id`, `child_key`, `leon_key`, `updated_at`, `created_at`) VALUES
(1, 1, 'BackendMainContentImage', 1, 0, 'parent_id', 0, '2022-07-04 11:52:26', '2022-07-04 11:52:26');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_data_auth`
--

DROP TABLE IF EXISTS `basic_cms_data_auth`;
CREATE TABLE `basic_cms_data_auth` (
  `id` int(11) NOT NULL,
  `cms_role_id` int(11) NOT NULL COMMENT 'cms_role.id',
  `menu_id` int(11) NOT NULL COMMENT 'basic_cms_menu.id',
  `create_id` int(11) NOT NULL,
  `data_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '可管理資料id(json)',
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '語系'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='設定帳號在某個單元，只能管理某些資料' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_cms_data_auth`
--

INSERT INTO `basic_cms_data_auth` (`id`, `cms_role_id`, `menu_id`, `create_id`, `data_id`, `lang`) VALUES
(1, 2, 2, 0, '[\"2\",\"pass\"]', 'en'),
(2, 2, 3, 0, '[\"2\",\"pass\"]', 'en');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_menu`
--

DROP TABLE IF EXISTS `basic_cms_menu`;
CREATE TABLE `basic_cms_menu` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL COMMENT '排序',
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `branch_id` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL,
  `use_id` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名稱',
  `key_id` int(11) NOT NULL COMMENT '[FK]',
  `type` int(11) NOT NULL COMMENT '類型',
  `is_content` int(11) NOT NULL COMMENT '(暫開)',
  `parent_id` int(11) NOT NULL COMMENT '歸屬於何menu之下 Self_id',
  `has_auth` int(11) NOT NULL COMMENT '分類權限用  =id的時候開起選單',
  `domain_name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '各單元路由名稱',
  `model` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Model Name',
  `view_prefix` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'view路徑',
  `filter` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '篩選條件',
  `options_group` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json_group` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_type` int(11) NOT NULL COMMENT '1品牌總覽2各分館',
  `leon_key` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='cms Menu(CRS同用)';

--
-- 傾印資料表的資料 `basic_cms_menu`
--

INSERT INTO `basic_cms_menu` (`id`, `w_rank`, `is_active`, `branch_id`, `is_parent`, `use_id`, `title`, `key_id`, `type`, `is_content`, `parent_id`, `has_auth`, `domain_name`, `model`, `view_prefix`, `filter`, `options_group`, `json_group`, `use_type`, `leon_key`, `create_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, '資料1', 1, 1, 0, 0, 0, 'news', '', '', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2019-09-22 00:00:00'),
(2, 1, 1, 1, 0, 2, '總覽分類', 1, 3, 0, 1, 2, '', 'BackendMainCategory', 'branch_backend_main.category', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-05-24 11:43:57'),
(3, 2, 1, 1, 0, 4, '資料型態', 1, 3, 0, 1, 3, '', 'BackendMainType', 'branch_backend_main.type', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-07-07 18:03:03'),
(4, 3, 1, 1, 0, 3, '總覽資料', 1, 3, 0, 1, 3, '', 'BackendMain', 'branch_backend_main.main', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-07-07 18:03:03');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_menu_use`
--

DROP TABLE IF EXISTS `basic_cms_menu_use`;
CREATE TABLE `basic_cms_menu_use` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL COMMENT '排序',
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `branch_id` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL,
  `use_id` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名稱',
  `key_id` int(11) NOT NULL COMMENT '[FK]',
  `type` int(11) NOT NULL COMMENT '類型',
  `is_content` int(11) NOT NULL COMMENT '(暫開)',
  `parent_id` int(11) NOT NULL COMMENT '歸屬於何menu之下 Self_id',
  `has_auth` int(11) NOT NULL COMMENT '分類權限用',
  `domain_name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '各單元路由名稱',
  `model` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Model Name',
  `view_prefix` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'view路徑',
  `filter` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '篩選條件',
  `options_group` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json_group` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_type` int(11) NOT NULL COMMENT '1品牌總覽2各分館',
  `leon_key` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='cms Menu(CRS同用)';

--
-- 傾印資料表的資料 `basic_cms_menu_use`
--

INSERT INTO `basic_cms_menu_use` (`id`, `w_rank`, `is_active`, `branch_id`, `is_parent`, `use_id`, `title`, `key_id`, `type`, `is_content`, `parent_id`, `has_auth`, `domain_name`, `model`, `view_prefix`, `filter`, `options_group`, `json_group`, `use_type`, `leon_key`, `create_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, '資料1', 1, 1, 0, 0, 0, 'news', '', '', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2019-09-22 00:00:00'),
(2, 1, 1, 1, 0, 2, '總覽分類', 1, 3, 0, 1, 2, '', 'BackendMainCategory', 'branch_backend_main.category', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-05-24 11:43:57'),
(3, 3, 1, 1, 0, 3, '總覽資料', 1, 3, 0, 1, 4, '', 'BackendMain', 'branch_backend_main.main', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-05-24 11:43:57'),
(4, 2, 1, 1, 0, 4, '資料型態', 1, 3, 0, 1, 4, '', 'BackendMainType', 'branch_backend_main.type', '', '', '', 2, 0, 0, '2019-09-22 00:00:00', '2022-05-24 11:43:57');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_parent`
--

DROP TABLE IF EXISTS `basic_cms_parent`;
CREATE TABLE `basic_cms_parent` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL COMMENT '[FK]',
  `parent_model` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '爸爸model name',
  `parent_key` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '爸爸key',
  `parent_option` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用爸爸哪個欄位當名稱',
  `foreign_key` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '連接key',
  `create_id` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `with_m` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `with_db` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `with_name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leon_key` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_parent_son`
--

DROP TABLE IF EXISTS `basic_cms_parent_son`;
CREATE TABLE `basic_cms_parent_son` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `model_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '關連model name',
  `parent_id` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `child_key` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '關連用key',
  `leon_key` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='爸爸鵝外關連的兒子';

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_permission`
--

DROP TABLE IF EXISTS `basic_cms_permission`;
CREATE TABLE `basic_cms_permission` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `cms_role_id` int(11) NOT NULL COMMENT '[FK]',
  `cms_menu_id` int(11) NOT NULL COMMENT '[FK]',
  `create_id` int(11) NOT NULL,
  `is_edit` int(11) NOT NULL COMMENT '是否可以編輯',
  `is_add` int(11) NOT NULL COMMENT '是否可以新增',
  `is_delete` int(11) NOT NULL COMMENT '是否可以刪除',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `basic_cms_permission`
--

INSERT INTO `basic_cms_permission` (`id`, `is_active`, `cms_role_id`, `cms_menu_id`, `create_id`, `is_edit`, `is_add`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 0, 1, 1, 1, '2022-07-07 18:02:40', '2022-07-07 18:02:40'),
(2, 1, 2, 2, 0, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_cms_role`
--

DROP TABLE IF EXISTS `basic_cms_role`;
CREATE TABLE `basic_cms_role` (
  `id` int(11) NOT NULL,
  `branch_unit_id` int(11) NOT NULL COMMENT '分館語系ID',
  `type` int(11) NOT NULL COMMENT '1品牌總覽2分館',
  `branch_manage` int(11) NOT NULL COMMENT '是否有分館管理權限',
  `user_id` int(11) NOT NULL COMMENT '使用者[FK]',
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `is_review_edit` int(11) NOT NULL COMMENT '無審核權限編輯不需再審核',
  `create_id` int(11) NOT NULL,
  `roles` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='cms 權限' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_cms_role`
--

INSERT INTO `basic_cms_role` (`id`, `branch_unit_id`, `type`, `branch_manage`, `user_id`, `is_active`, `is_review_edit`, `create_id`, `roles`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 0, 7, 1, 1, 0, '{\"1\":\";1;1;1;1\",\"2\":\";1;1;1;1\",\"3\":\";1;1;1;1\",\"4\":\";1;1;1;1\"}', '2022-07-07 17:14:44', '2022-07-07 17:15:14'),
(2, 2, 2, 0, 1, 1, 1, 0, '{\"1\":\";1;1;1;1\",\"2\":\";1;1;1;1\",\"3\":\";1;1;1;1\",\"4\":\";1;1;1;1\"}', '2022-07-07 18:02:40', '2022-07-07 18:02:40');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_country_codes`
--

DROP TABLE IF EXISTS `basic_country_codes`;
CREATE TABLE `basic_country_codes` (
  `id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `basic_country_codes`
--

INSERT INTO `basic_country_codes` (`id`, `country`, `codes`) VALUES
(1, '中國', '+86'),
(2, '愛爾蘭', '+353'),
(3, '中非共和國', '+236'),
(4, '意大利', '+39'),
(5, '帕勞', '+680'),
(6, '敘利亞', '+963'),
(7, '丹麥', '+45'),
(8, '教廷（梵蒂岡城）', '+379'),
(9, '不丹', '+975'),
(10, '東帝汶', '+670'),
(11, '布基納法索', '+226'),
(12, '沙特阿拉伯', '+966'),
(13, '布隆迪', '+257'),
(14, '澤西島', '+44'),
(15, '澳門', '+853'),
(16, '希臘', '+30'),
(17, '孟加拉國', '+880'),
(18, '法屬圭亞那', '+594'),
(19, '喀麥隆', '+237'),
(20, '法國', '+33'),
(21, '法羅島', '+298'),
(22, '泰國', '+66'),
(23, '南非', '+27'),
(24, '波多黎各', '+1'),
(25, '塔吉克斯坦', '+992'),
(26, '波斯尼亞和黑塞哥維那', '+387'),
(27, '卡塔爾', '+974'),
(28, '波蘭', '+48'),
(29, '塞內加爾', '+221'),
(30, '挪威', '+47'),
(31, '塞拉利昂', '+232'),
(32, '智利', '+56'),
(33, '塞浦路斯', '+357'),
(34, '柬埔寨', '+855'),
(35, '塞爾維亞', '+381'),
(36, '海地', '+509'),
(37, '塞舌爾', '+248'),
(38, '約旦', '+962'),
(39, '俄國', '+7'),
(40, '索馬里', '+252'),
(41, '保加利亞', '+359'),
(42, '納瓦薩島', '+1'),
(43, '納米比亞', '+264'),
(44, '克羅地亞', '+385'),
(45, '緬甸', '+95'),
(46, '巴布亞新幾內亞', '+675'),
(47, '瑞典', '+46'),
(48, '巴巴多斯', '+1 246'),
(49, '瑞士', '+41'),
(50, '巴勒斯坦領土', '+970'),
(51, '直布羅陀', '+350'),
(52, '巴哈馬', '+1 242'),
(53, '盧旺達', '+250'),
(54, '巴基斯坦', '+92'),
(55, '盧森堡', '+352'),
(56, '巴拿馬', '+507'),
(57, '瓜德羅普', '+590'),
(58, '巴拉圭', '+595'),
(59, '立陶宛', '+370'),
(60, '巴林', '+973'),
(61, '秘魯', '+51'),
(62, '科威特', '+965'),
(63, '巴西', '+55'),
(64, '科摩羅', '+269'),
(65, '哈薩克斯坦', '+76'),
(66, '科索沃', '+383'),
(67, '哥倫比亞', '+57'),
(68, '科科斯群島', '+618'),
(69, '哥斯達黎加', '+506'),
(70, '科特迪瓦', '+225'),
(71, '以色列', '+972'),
(72, '維爾京群島', '+1'),
(73, '委內瑞拉', '+58'),
(74, '特克斯和凱科斯群島', '+649'),
(75, '安哥拉', '+244'),
(76, '特立尼達和多巴哥', '+1 868'),
(77, '安圭拉', '+1 264'),
(78, '安提瓜和巴布達', '+1 268'),
(79, '牙買加', '+1 876'),
(80, '安道爾', '+376'),
(81, '福克蘭群島', '+500'),
(82, '剛果共和國', '+242'),
(83, '羅馬尼亞', '+40'),
(84, '剛果民主共和國', '+243'),
(85, '美國', '+1'),
(86, '吉布提', '+253'),
(87, '突尼斯', '+216'),
(88, '吉爾吉斯斯坦', '+996'),
(89, '烏克蘭', '+380'),
(90, '冰島', '+354'),
(91, '烏干達', '+256'),
(92, '列支敦士登', '+423'),
(93, '烏拉圭', '+598'),
(94, '利比亞', '+218'),
(95, '烏茲別克斯坦', '+998'),
(96, '利比里亞', '+231'),
(97, '白俄羅斯', '+375'),
(98, '尼加拉瓜', '+505'),
(99, '百慕大', '+1 441'),
(100, '尼日利亞', '+234'),
(101, '玻利維亞', '+591'),
(102, '尼日爾', '+227'),
(103, '贊比亞', '+260'),
(104, '尼泊爾', '+977'),
(105, '阿富汗', '+93'),
(106, '印度', '+91'),
(107, '阿塞拜疆', '+994'),
(108, '印度尼西亞', '+62'),
(109, '阿根廷', '+54'),
(110, '台灣', '+886'),
(111, '阿拉伯聯合酋長國', '+971'),
(112, '危地馬拉', '+502'),
(113, '阿曼', '+968'),
(114, '坦桑尼亞', '+255'),
(115, '阿爾巴尼亞', '+355'),
(116, '古巴', '+53'),
(117, '阿爾及利亞', '+213'),
(118, '多哥', '+228'),
(119, '阿魯巴', '+297'),
(120, '多明尼加共和國', '+1 809'),
(121, '蘇丹', '+249'),
(122, '多米尼加', '+1 767'),
(123, '蘇里南', '+597'),
(124, '墨西哥', '+52'),
(125, '開曼群島', '+1 345'),
(126, '奧地利', '+43'),
(127, '薩爾瓦多', '+503'),
(128, '佛得角', '+238'),
(129, '聖巴泰勒米', '+590'),
(130, '伯利茲', '+501'),
(131, '聖多美和普林西比', '+239'),
(132, '伊拉克', '+964'),
(133, '聖基茨和尼維斯', '+1 869'),
(134, '伊朗', '+98'),
(135, '聖文森特和格林納丁斯', '+1 784'),
(136, '幾內亞', '+224'),
(137, '聖盧西亞', '+1 758'),
(138, '幾內亞比紹', '+245'),
(139, '聖皮埃爾密克隆', '+508'),
(140, '乍得', '+235'),
(141, '聖馬丁', '+590'),
(142, '也門', '+967'),
(143, '聖馬力諾', '+378'),
(144, '岡比亞', '+220'),
(145, '聖誕島', '+618'),
(146, '德國', '+49'),
(147, '聖赫勒拿', '+290'),
(148, '團圓', '+262'),
(149, '荷屬安的列斯', '+599'),
(150, '圭亞那', '+592'),
(151, '荷蘭', '+31'),
(152, '匈牙利', '+36'),
(153, '葡萄牙', '+351'),
(154, '土庫曼斯坦', '+993'),
(155, '蒙古', '+976'),
(156, '土耳其國', '+90'),
(157, '蒙特塞拉特', '+1 664'),
(158, '亞美尼亞', '+374'),
(159, '肯尼亞', '+254'),
(160, '加拿大', '+1'),
(161, '英屬維爾京群島', '+1 284'),
(162, '加納', '+233'),
(163, '英國', '+44'),
(164, '加蓬', '+241'),
(165, '黑山', '+382'),
(166, '博茨瓦納', '+267'),
(167, '黎巴嫩', '+961'),
(168, '埃塞俄比亞', '+251'),
(169, '越南', '+84'),
(170, '埃及', '+20'),
(171, '馬其頓', '+389'),
(172, '厄瓜多爾', '+593'),
(173, '馬來西亞', '+60'),
(174, '厄立特里亞', '+291'),
(175, '馬拉維', '+265'),
(176, '格林納達', '+473'),
(177, '馬恩島', '+44'),
(178, '格魯吉亞', '+995'),
(179, '馬提尼克', '+596'),
(180, '格陵蘭', '+299'),
(181, '馬約特', '+262'),
(182, '根西島', '+44'),
(183, '馬爾代夫', '+960'),
(184, '津巴布韋', '+263'),
(185, '馬達加斯加', '+261'),
(186, '洪都拉斯', '+504'),
(187, '馬里', '+223'),
(188, '毛里塔尼亞', '+222'),
(189, '馬耳他', '+356'),
(190, '毛里求斯', '+230'),
(191, '香港', '+852'),
(192, '比利時', '+32'),
(193, '西撒哈拉', '+212'),
(194, '西班牙', '+34'),
(195, '斯威士蘭', '+268'),
(196, '老撾', '+856'),
(197, '斯洛伐克', '+421'),
(198, '貝寧', '+229'),
(199, '斯洛文尼亞', '+386'),
(200, '菲律賓', '+63'),
(201, '斯瓦爾巴特群島', '+47'),
(202, '斯里蘭卡', '+94'),
(203, '芬蘭', '+358'),
(204, '文萊', '+673'),
(205, '萊索托', '+266'),
(206, '新加坡', '+65'),
(207, '韓國', '+82'),
(208, '斐濟', '+679'),
(209, '韓國，北方', '+850'),
(210, '日本', '+81'),
(211, '莫桑比克', '+258'),
(212, '捷克共和國', '+420'),
(213, '摩洛哥', '+212'),
(214, '赤道幾內亞', '+240'),
(215, '摩納哥', '+377'),
(216, '摩爾多瓦', '+373'),
(217, 'Jan Mayen', '+47'),
(218, '拉脫維亞', '+371'),
(219, '愛沙尼亞', '+372');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_crs_permission`
--

DROP TABLE IF EXISTS `basic_crs_permission`;
CREATE TABLE `basic_crs_permission` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `crs_role_id` int(11) NOT NULL COMMENT '[FK]',
  `cms_menu_id` int(11) NOT NULL COMMENT '[FK]',
  `is_add_review` int(11) NOT NULL COMMENT '是否可以審核新增',
  `is_delete_review` int(11) NOT NULL COMMENT '是否可以審核刪除',
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `basic_crs_role`
--

DROP TABLE IF EXISTS `basic_crs_role`;
CREATE TABLE `basic_crs_role` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT '[FK]',
  `type` int(11) NOT NULL COMMENT '1品牌總覽2分館',
  `branch_manage` int(11) NOT NULL COMMENT '是否有分館管理審核權限(暫開)',
  `user_id` int(11) NOT NULL COMMENT '使用者[FK]',
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `is_mail` int(11) NOT NULL COMMENT '是否接收通知信',
  `create_id` int(11) NOT NULL,
  `roles` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='crs 權限';

--
-- 傾印資料表的資料 `basic_crs_role`
--

INSERT INTO `basic_crs_role` (`id`, `branch_id`, `type`, `branch_manage`, `user_id`, `is_active`, `is_mail`, `create_id`, `roles`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 0, 1, 1, 0, 1, '{\"1\":\";1\",\"2\":\";1\",\"3\":\";0\",\"4\":\";0\"}', '2020-04-15 17:48:22', '2020-12-10 18:27:32');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_data_city`
--

DROP TABLE IF EXISTS `basic_data_city`;
CREATE TABLE `basic_data_city` (
  `id` int(11) NOT NULL,
  `geo_id` int(11) NOT NULL DEFAULT 0 COMMENT '所屬區域',
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名稱',
  `w_rank` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_island` int(11) NOT NULL COMMENT '是否離島	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='城市' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_data_city`
--

INSERT INTO `basic_data_city` (`id`, `geo_id`, `name`, `w_rank`, `is_island`) VALUES
(1, 1, '基隆市', 1, 0),
(2, 1, '臺北市', 2, 0),
(3, 1, '新北市', 3, 0),
(4, 2, '桃園市', 4, 0),
(5, 2, '新竹市', 5, 0),
(6, 2, '新竹縣', 6, 0),
(7, 2, '苗栗縣', 7, 0),
(8, 3, '臺中市', 3, 0),
(9, 3, '彰化縣', 9, 0),
(10, 3, '南投縣', 10, 0),
(11, 4, '雲林縣', 11, 0),
(12, 4, '嘉義市', 12, 0),
(13, 4, '嘉義縣', 13, 0),
(14, 4, '臺南市', 14, 0),
(15, 5, '高雄市', 15, 0),
(16, 5, '屏東縣', 16, 0),
(17, 6, '宜蘭縣', 17, 0),
(18, 6, '花蓮縣', 18, 0),
(19, 6, '臺東縣', 19, 0),
(20, 7, '澎湖縣', 20, 0),
(21, 7, '金門縣', 21, 0),
(22, 7, '連江縣', 22, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `basic_data_city_region`
--

DROP TABLE IF EXISTS `basic_data_city_region`;
CREATE TABLE `basic_data_city_region` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT 0 COMMENT '所屬城市',
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名稱',
  `post` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '郵遞區號',
  `w_rank` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_island` int(11) NOT NULL COMMENT '是否離島'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='鄉/鎮/市/區' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `basic_data_city_region`
--

INSERT INTO `basic_data_city_region` (`id`, `city_id`, `name`, `post`, `w_rank`, `is_island`) VALUES
(1, 1, '仁愛區', '200', 1, 0),
(2, 1, '信義區', '201', 2, 0),
(3, 1, '中正區', '202', 3, 0),
(4, 1, '中山區', '203', 4, 0),
(5, 1, '安樂區', '204', 5, 0),
(6, 1, '暖暖區', '205', 6, 0),
(7, 1, '七堵區', '206', 7, 0),
(8, 2, '中正區', '100', 1, 0),
(9, 2, '大同區', '103', 2, 0),
(10, 2, '中山區', '104', 3, 0),
(11, 2, '松山區', '105', 4, 0),
(12, 2, '大安區', '106', 5, 0),
(13, 2, '萬華區', '108', 6, 0),
(14, 2, '信義區', '110', 7, 0),
(15, 2, '士林區', '111', 8, 0),
(16, 2, '北投區', '112', 9, 0),
(17, 2, '內湖區', '114', 10, 0),
(18, 2, '南港區', '115', 11, 0),
(19, 2, '文山區', '116', 12, 0),
(20, 3, '萬里區', '207', 1, 0),
(21, 3, '金山區', '208', 2, 0),
(22, 3, '板橋區', '220', 3, 0),
(23, 3, '汐止區', '221', 4, 0),
(24, 3, '深坑區', '222', 5, 0),
(25, 3, '石碇區', '223', 6, 0),
(26, 3, '瑞芳區', '224', 7, 0),
(27, 3, '平溪區', '226', 8, 0),
(28, 3, '雙溪區', '227', 9, 0),
(29, 3, '貢寮區', '228', 10, 0),
(30, 3, '新店區', '231', 11, 0),
(31, 3, '坪林區', '232', 12, 0),
(32, 3, '烏來區', '233', 13, 0),
(33, 3, '永和區', '234', 14, 0),
(34, 3, '中和區', '235', 15, 0),
(35, 3, '土城區', '236', 16, 0),
(36, 3, '三峽區', '237', 17, 0),
(37, 3, '樹林區', '238', 18, 0),
(38, 3, '鶯歌區', '239', 19, 0),
(39, 3, '三重區', '241', 20, 0),
(40, 3, '新莊區', '242', 21, 0),
(41, 3, '泰山區', '243', 22, 0),
(42, 3, '林口區', '244', 23, 0),
(43, 3, '蘆洲區', '247', 24, 0),
(44, 3, '五股區', '248', 25, 0),
(45, 3, '八里區', '249', 26, 0),
(46, 3, '淡水區', '251', 27, 0),
(47, 3, '三芝區', '252', 28, 0),
(48, 3, '石門區', '253', 29, 0),
(49, 4, '中壢區', '320', 1, 0),
(50, 4, '平鎮區', '324', 2, 0),
(51, 4, '龍潭區', '325', 3, 0),
(52, 4, '楊梅區', '326', 4, 0),
(53, 4, '新屋區', '327', 5, 0),
(54, 4, '觀音區', '328', 6, 0),
(55, 4, '桃園區', '330', 7, 0),
(56, 4, '龜山區', '333', 8, 0),
(57, 4, '八德區', '334', 9, 0),
(58, 4, '大溪區', '335', 10, 0),
(59, 4, '復興區', '336', 11, 0),
(60, 4, '大園區', '337', 12, 0),
(61, 4, '蘆竹區', '338', 13, 0),
(62, 5, '東區', '300', 1, 0),
(63, 5, '北區', '300', 2, 0),
(64, 5, '香山區', '300', 3, 0),
(65, 6, '竹北市', '302', 1, 0),
(66, 6, '湖口鄉', '303', 2, 0),
(67, 6, '新豐鄉', '304', 3, 0),
(68, 6, '新埔鎮', '305', 4, 0),
(69, 6, '關西鎮', '306', 5, 0),
(70, 6, '芎林鄉', '307', 6, 0),
(71, 6, '寶山鄉', '308', 7, 0),
(72, 6, '竹東鎮', '310', 8, 0),
(73, 6, '五峰鄉', '311', 9, 0),
(74, 6, '橫山鄉', '312', 10, 0),
(75, 6, '尖石鄉', '313', 11, 0),
(76, 6, '北埔鄉', '314', 12, 0),
(77, 6, '峨眉鄉', '315', 13, 0),
(78, 7, '竹南鎮', '350', 1, 0),
(79, 7, '頭份市', '351', 2, 0),
(80, 7, '三灣鄉', '352', 3, 0),
(81, 7, '南庄鄉', '353', 4, 0),
(82, 7, '獅潭鄉', '354', 5, 0),
(83, 7, '後龍鎮', '356', 6, 0),
(84, 7, '通霄鎮', '357', 7, 0),
(85, 7, '苑裡鎮', '358', 8, 0),
(86, 7, '苗栗市', '360', 9, 0),
(87, 7, '造橋鄉', '361', 10, 0),
(88, 7, '頭屋鄉', '362', 11, 0),
(89, 7, '公館鄉', '363', 12, 0),
(90, 7, '大湖鄉', '364', 13, 0),
(91, 7, '泰安鄉', '365', 14, 0),
(92, 7, '銅鑼鄉', '366', 15, 0),
(93, 7, '三義鄉', '367', 16, 0),
(94, 7, '西湖鄉', '368', 17, 0),
(95, 7, '卓蘭鎮', '369', 18, 0),
(96, 8, '中區', '400', 1, 0),
(97, 8, '東區', '401', 2, 0),
(98, 8, '南區', '402', 3, 0),
(99, 8, '西區', '403', 4, 0),
(100, 8, '北區', '404', 5, 0),
(101, 8, '北屯區', '406', 6, 0),
(102, 8, '西屯區', '407', 7, 0),
(103, 8, '南屯區', '408', 8, 0),
(104, 8, '太平區', '411', 9, 0),
(105, 8, '大里區', '412', 10, 0),
(106, 8, '霧峰區', '413', 11, 0),
(107, 8, '烏日區', '414', 12, 0),
(108, 8, '豐原區', '420', 13, 0),
(109, 8, '后里區', '421', 14, 0),
(110, 8, '石岡區', '422', 15, 0),
(111, 8, '東勢區', '423', 16, 0),
(112, 8, '和平區', '424', 17, 0),
(113, 8, '新社區', '426', 18, 0),
(114, 8, '潭子區', '427', 19, 0),
(115, 8, '大雅區', '428', 20, 0),
(116, 8, '神岡區', '429', 21, 0),
(117, 8, '大肚區', '432', 22, 0),
(118, 8, '沙鹿區', '433', 23, 0),
(119, 8, '龍井區', '434', 24, 0),
(120, 8, '梧棲區', '435', 25, 0),
(121, 8, '清水區', '436', 26, 0),
(122, 8, '大甲區', '437', 27, 0),
(123, 8, '外埔區', '438', 28, 0),
(124, 8, '大安區', '439', 29, 0),
(125, 9, '彰化市', '500', 1, 0),
(126, 9, '芬園鄉', '502', 2, 0),
(127, 9, '花壇鄉', '503', 3, 0),
(128, 9, '秀水鄉', '504', 4, 0),
(129, 9, '鹿港鎮', '505', 5, 0),
(130, 9, '福興鄉', '506', 6, 0),
(131, 9, '線西鄉', '507', 7, 0),
(132, 9, '和美鎮', '508', 8, 0),
(133, 9, '伸港鄉', '509', 9, 0),
(134, 9, '員林市', '510', 10, 0),
(135, 9, '社頭鄉', '511', 11, 0),
(136, 9, '永靖鄉', '512', 12, 0),
(137, 9, '埔心鄉', '513', 13, 0),
(138, 9, '溪湖鎮', '514', 14, 0),
(139, 9, '大村鄉', '515', 15, 0),
(140, 9, '埔鹽鄉', '516', 16, 0),
(141, 9, '田中鎮', '520', 17, 0),
(142, 9, '北斗鎮', '521', 18, 0),
(143, 9, '田尾鄉', '522', 19, 0),
(144, 9, '埤頭鄉', '523', 20, 0),
(145, 9, '溪州鄉', '524', 21, 0),
(146, 9, '竹塘鄉', '525', 22, 0),
(147, 9, '二林鎮', '526', 23, 0),
(148, 9, '大城鄉', '527', 24, 0),
(149, 9, '芳苑鄉', '528', 25, 0),
(150, 9, '二水鄉', '530', 26, 0),
(151, 10, '南投市', '540', 1, 0),
(152, 10, '中寮鄉', '541', 2, 0),
(153, 10, '草屯鎮', '542', 3, 0),
(154, 10, '國姓鄉', '544', 4, 0),
(155, 10, '埔里鎮', '545', 5, 0),
(156, 10, '仁愛鄉', '546', 6, 0),
(157, 10, '名間鄉', '551', 7, 0),
(158, 10, '集集鎮', '552', 8, 0),
(159, 10, '水里鄉', '553', 9, 0),
(160, 10, '魚池鄉', '555', 10, 0),
(161, 10, '信義鄉', '556', 11, 0),
(162, 10, '竹山鎮', '557', 12, 0),
(163, 10, '鹿谷鄉', '558', 13, 0),
(164, 11, '斗南鎮', '630', 1, 0),
(165, 11, '大埤鄉', '631', 2, 0),
(166, 11, '虎尾鎮', '632', 3, 0),
(167, 11, '土庫鎮', '633', 4, 0),
(168, 11, '褒忠鄉', '634', 5, 0),
(169, 11, '東勢鄉', '635', 6, 0),
(170, 11, '台西鄉', '636', 7, 0),
(171, 11, '崙背鄉', '637', 8, 0),
(172, 11, '麥寮鄉', '638', 9, 0),
(173, 11, '斗六市', '640', 10, 0),
(174, 11, '林內鄉', '643', 11, 0),
(175, 11, '古坑鄉', '646', 12, 0),
(176, 11, '莿桐鄉', '647', 13, 0),
(177, 11, '西螺鎮', '648', 14, 0),
(178, 11, '二崙鄉', '649', 15, 0),
(179, 11, '北港鎮', '651', 16, 0),
(180, 11, '水林鄉', '652', 17, 0),
(181, 11, '口湖鄉', '653', 18, 0),
(182, 11, '四湖鄉', '654', 19, 0),
(183, 11, '元長鄉', '655', 20, 0),
(184, 12, '東區', '600', 1, 0),
(185, 12, '西區', '600', 2, 0),
(186, 13, '番路鄉', '602', 1, 0),
(187, 13, '梅山鄉', '603', 2, 0),
(188, 13, '竹崎鄉', '604', 3, 0),
(189, 13, '阿里山鄉', '605', 4, 0),
(190, 13, '中埔鄉', '606', 5, 0),
(191, 13, '大埔鄉', '607', 6, 0),
(192, 13, '水上鄉', '608', 7, 0),
(193, 13, '鹿草鄉', '611', 8, 0),
(194, 13, '太保市', '612', 9, 0),
(195, 13, '朴子市', '613', 10, 0),
(196, 13, '東石鄉', '614', 11, 0),
(197, 13, '六腳鄉', '615', 12, 0),
(198, 13, '新港鄉', '616', 13, 0),
(199, 13, '民雄鄉', '621', 14, 0),
(200, 13, '大林鎮', '622', 15, 0),
(201, 13, '溪口鄉', '623', 16, 0),
(202, 13, '義竹鄉', '624', 17, 0),
(203, 13, '布袋鎮', '625', 18, 0),
(204, 14, '中西區', '700', 1, 0),
(205, 14, '東區', '701', 2, 0),
(206, 14, '南區', '702', 3, 0),
(207, 14, '北區', '704', 4, 0),
(208, 14, '安平區', '708', 5, 0),
(209, 14, '安南區', '709', 6, 0),
(210, 14, '永康區', '710', 7, 0),
(211, 14, '歸仁區', '711', 8, 0),
(212, 14, '新化區', '712', 9, 0),
(213, 14, '左鎮區', '713', 10, 0),
(214, 14, '玉井區', '714', 11, 0),
(215, 14, '楠西區', '715', 12, 0),
(216, 14, '南化區', '716', 13, 0),
(217, 14, '仁德區', '717', 14, 0),
(218, 14, '關廟區', '718', 15, 0),
(219, 14, '龍崎區', '719', 16, 0),
(220, 14, '官田區', '720', 17, 0),
(221, 14, '麻豆區', '721', 18, 0),
(222, 14, '佳里區', '722', 19, 0),
(223, 14, '西港區', '723', 20, 0),
(224, 14, '七股區', '724', 21, 0),
(225, 14, '將軍區', '725', 22, 0),
(226, 14, '學甲區', '726', 23, 0),
(227, 14, '北門區', '727', 24, 0),
(228, 14, '新營區', '730', 25, 0),
(229, 14, '後壁區', '731', 26, 0),
(230, 14, '白河區', '732', 27, 0),
(231, 14, '東山區', '733', 28, 0),
(232, 14, '六甲區', '734', 29, 0),
(233, 14, '下營區', '735', 30, 0),
(234, 14, '柳營區', '736', 31, 0),
(235, 14, '鹽水區', '737', 32, 0),
(236, 14, '善化區', '741', 33, 0),
(237, 14, '大內區', '742', 34, 0),
(238, 14, '山上區', '743', 35, 0),
(239, 14, '新市區', '744', 36, 0),
(240, 14, '安定區', '745', 37, 0),
(241, 15, '新興區', '800', 1, 0),
(242, 15, '前金區', '801', 2, 0),
(243, 15, '苓雅區', '802', 3, 0),
(244, 15, '鹽埕區', '803', 4, 0),
(245, 15, '鼓山區', '804', 5, 0),
(246, 15, '旗津區', '805', 6, 0),
(247, 15, '前鎮區', '806', 7, 0),
(248, 15, '三民區', '807', 8, 0),
(249, 15, '楠梓區', '811', 9, 0),
(250, 15, '小港區', '812', 10, 0),
(251, 15, '左營區', '813', 11, 0),
(252, 15, '仁武區', '814', 12, 0),
(253, 15, '大社區', '815', 13, 0),
(254, 15, '東沙群島', '817', 14, 0),
(255, 15, '南沙群島', '819', 15, 0),
(256, 15, '岡山區', '820', 16, 0),
(257, 15, '路竹區', '821', 17, 0),
(258, 15, '阿蓮區', '822', 18, 0),
(259, 15, '田寮區', '823', 19, 0),
(260, 15, '燕巢區', '824', 20, 0),
(261, 15, '橋頭區', '825', 21, 0),
(262, 15, '梓官區', '826', 22, 0),
(263, 15, '彌陀區', '827', 23, 0),
(264, 15, '永安區', '828', 24, 0),
(265, 15, '湖內區', '829', 25, 0),
(266, 15, '鳳山區', '830', 26, 0),
(267, 15, '大寮區', '831', 27, 0),
(268, 15, '林園區', '832', 28, 0),
(269, 15, '鳥松區', '833', 29, 0),
(270, 15, '大樹區', '840', 30, 0),
(271, 15, '旗山區', '842', 31, 0),
(272, 15, '美濃區', '843', 32, 0),
(273, 15, '六龜區', '844', 33, 0),
(274, 15, '內門區', '845', 34, 0),
(275, 15, '杉林區', '846', 35, 0),
(276, 15, '甲仙區', '847', 36, 0),
(277, 15, '桃源區', '848', 37, 0),
(278, 15, '那瑪夏區', '849', 38, 0),
(279, 15, '茂林區', '851', 39, 0),
(280, 15, '茄萣區', '852', 40, 0),
(281, 16, '屏東市', '900', 1, 0),
(282, 16, '三地門鄉', '901', 2, 0),
(283, 16, '霧臺鄉', '902', 3, 0),
(284, 16, '瑪家鄉', '903', 4, 0),
(285, 16, '九如鄉', '904', 5, 0),
(286, 16, '里港鄉', '905', 6, 0),
(287, 16, '高樹鄉', '906', 7, 0),
(288, 16, '鹽埔鄉', '907', 8, 0),
(289, 16, '長治鄉', '908', 9, 0),
(290, 16, '麟洛鄉', '909', 10, 0),
(291, 16, '竹田鄉', '911', 11, 0),
(292, 16, '內埔鄉', '912', 12, 0),
(293, 16, '萬丹鄉', '913', 13, 0),
(294, 16, '潮州鎮', '920', 14, 0),
(295, 16, '泰武鄉', '921', 15, 0),
(296, 16, '來義鄉', '922', 16, 0),
(297, 16, '萬巒鄉', '923', 17, 0),
(298, 16, '崁頂鄉', '924', 18, 0),
(299, 16, '新埤鄉', '925', 19, 0),
(300, 16, '南州鄉', '926', 20, 0),
(301, 16, '林邊鄉', '927', 21, 0),
(302, 16, '東港鎮', '928', 22, 0),
(303, 16, '琉球鄉', '929', 23, 0),
(304, 16, '佳冬鄉', '931', 24, 0),
(305, 16, '新園鄉', '932', 25, 0),
(306, 16, '枋寮鄉', '940', 26, 0),
(307, 16, '枋山鄉', '941', 27, 0),
(308, 16, '春日鄉', '942', 28, 0),
(309, 16, '獅子鄉', '943', 29, 0),
(310, 16, '車城鄉', '944', 30, 0),
(311, 16, '牡丹鄉', '945', 31, 0),
(312, 16, '恆春鎮', '946', 32, 0),
(313, 16, '滿州鄉', '947', 33, 0),
(314, 17, '宜蘭市', '260', 1, 0),
(315, 17, '頭城鎮', '261', 2, 0),
(316, 17, '礁溪鄉', '262', 3, 0),
(317, 17, '壯圍鄉', '263', 4, 0),
(318, 17, '員山鄉', '264', 5, 0),
(319, 17, '羅東鎮', '265', 6, 0),
(320, 17, '三星鄉', '266', 7, 0),
(321, 17, '大同鄉', '267', 8, 0),
(322, 17, '五結鄉', '268', 9, 0),
(323, 17, '冬山鄉', '269', 10, 0),
(324, 17, '蘇澳鎮', '270', 11, 0),
(325, 17, '南澳鄉', '271', 12, 0),
(326, 17, '釣魚臺列嶼', '290', 13, 0),
(327, 18, '花蓮市', '970', 1, 0),
(328, 18, '新城鄉', '971', 2, 0),
(329, 18, '秀林鄉', '972', 3, 0),
(330, 18, '吉安鄉', '973', 4, 0),
(331, 18, '壽豐鄉', '974', 5, 0),
(332, 18, '鳳林鎮', '975', 6, 0),
(333, 18, '光復鄉', '976', 7, 0),
(334, 18, '豐濱鄉', '977', 8, 0),
(335, 18, '瑞穗鄉', '978', 9, 0),
(336, 18, '萬榮鄉', '979', 10, 0),
(337, 18, '玉里鎮', '981', 11, 0),
(338, 18, '卓溪鄉', '982', 12, 0),
(339, 18, '富里鄉', '983', 13, 0),
(340, 19, '台東市', '950', 1, 0),
(341, 19, '綠島鄉', '951', 2, 0),
(342, 19, '蘭嶼鄉', '952', 3, 0),
(343, 19, '延平鄉', '953', 4, 0),
(344, 19, '卑南鄉', '954', 5, 0),
(345, 19, '鹿野鄉', '955', 6, 0),
(346, 19, '關山鎮', '956', 7, 0),
(347, 19, '海端鄉', '957', 8, 0),
(348, 19, '池上鄉', '958', 9, 0),
(349, 19, '東河鄉', '959', 10, 0),
(350, 19, '成功鎮', '961', 11, 0),
(351, 19, '長濱鄉', '962', 12, 0),
(352, 19, '太麻里鄉', '963', 13, 0),
(353, 19, '金峰鄉', '964', 14, 0),
(354, 19, '大武鄉', '965', 15, 0),
(355, 19, '達仁鄉', '966', 16, 0),
(356, 20, '馬公市', '880', 1, 0),
(357, 20, '西嶼鄉', '881', 2, 0),
(358, 20, '望安鄉', '882', 3, 0),
(359, 20, '七美鄉', '883', 4, 0),
(360, 20, '白沙鄉', '884', 5, 0),
(361, 20, '湖西鄉', '885', 6, 0),
(362, 21, '金沙鎮', '890', 1, 0),
(363, 21, '金湖鎮', '891', 2, 0),
(364, 21, '金寧鄉', '892', 3, 0),
(365, 21, '金城鎮', '893', 4, 0),
(366, 21, '烈嶼鄉', '894', 5, 0),
(367, 21, '烏坵鄉', '896', 6, 0),
(368, 22, '南竿鄉', '209', 1, 0),
(369, 22, '北竿鄉', '210', 2, 0),
(370, 22, '莒光鄉', '211', 3, 0),
(371, 22, '東引鄉', '212', 4, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `basic_fantasy_users`
--

DROP TABLE IF EXISTS `basic_fantasy_users`;
CREATE TABLE `basic_fantasy_users` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `account` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '帳號',
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名、稱呼',
  `lock_ip` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '限制IP登入',
  `mail` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '郵件',
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `identity` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '河河',
  `photo_image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '大頭照(file_id)',
  `fms_admin` int(11) NOT NULL COMMENT 'fms最大權限者',
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備住說明',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='後台帳號列表';

--
-- 傾印資料表的資料 `basic_fantasy_users`
--

INSERT INTO `basic_fantasy_users` (`id`, `is_active`, `create_id`, `account`, `name`, `lock_ip`, `mail`, `password`, `identity`, `photo_image`, `fms_admin`, `note`, `updated_at`, `created_at`) VALUES
(1, 1, 0, 'WDD', 'WDD', '', '', '$2y$10$Psj0QtrJBDZbUqg/d/cWnuyOrNdTiRxc83J73bkc0uZdbmREbQ2A2', '', '', 1, '', '2022-06-28 17:35:49', '2022-06-28 17:35:34');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_fms_file`
--

DROP TABLE IF EXISTS `basic_fms_file`;
CREATE TABLE `basic_fms_file` (
  `id` int(11) NOT NULL,
  `file_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` int(11) NOT NULL COMMENT '資料夾ID',
  `branch_id` int(11) NOT NULL,
  `is_branch` int(11) NOT NULL,
  `is_private` int(11) NOT NULL COMMENT '私人是否',
  `can_use` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '有權限使用的使用者',
  `create_id` int(11) NOT NULL,
  `private_user` int(11) NOT NULL COMMENT '[FK]私人宣示者',
  `created_user` int(11) NOT NULL COMMENT '[FK]',
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '檔案名稱',
  `url_name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '自訂網址名稱',
  `alt` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'alt',
  `real_route` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '實體路徑',
  `real_m_route` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '縮圖實體路徑',
  `base_64` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'base64(寬壓50)',
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '類型',
  `size` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '尺寸(bytes)',
  `dpi` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'DPI',
  `resolution` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '解析度',
  `img_w` int(11) NOT NULL,
  `img_h` int(11) NOT NULL,
  `share_group` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_edit_user` int(11) DEFAULT 0,
  `is_delete` int(11) NOT NULL COMMENT '軟刪除',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='擋案';

-- --------------------------------------------------------

--
-- 資料表結構 `basic_fms_folder`
--

DROP TABLE IF EXISTS `basic_fms_folder`;
CREATE TABLE `basic_fms_folder` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL COMMENT '上層',
  `self_level` int(11) NOT NULL COMMENT '自己第幾層',
  `is_private` int(11) NOT NULL COMMENT '是否私人',
  `can_use` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '有權限使用的使用者',
  `last_edit_user` int(11) NOT NULL COMMENT '最後編輯的人',
  `is_delete` int(11) NOT NULL COMMENT '軟刪除',
  `w_rank` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `key_id` int(11) NOT NULL COMMENT '[FK]',
  `branch_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='FMS 第零層資料夾結構';

-- --------------------------------------------------------

--
-- 資料表結構 `basic_log_data`
--

DROP TABLE IF EXISTS `basic_log_data`;
CREATE TABLE `basic_log_data` (
  `id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `table_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '使用資料表名稱',
  `data_id` int(11) DEFAULT 0 COMMENT '被編輯資料id',
  `user_id` int(11) DEFAULT 0 COMMENT '使用者id',
  `log_type` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `ChangeData` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classname` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `basic_log_data`
--

INSERT INTO `basic_log_data` (`id`, `create_time`, `table_name`, `data_id`, `user_id`, `log_type`, `ChangeData`, `classname`, `user_name`, `ip`) VALUES
(1, '2022-07-07 17:59:56', NULL, 0, 1, 'login', NULL, 'Login', 'WDD', '127.0.0.1');

-- --------------------------------------------------------

--
-- 資料表結構 `basic_option_item`
--

DROP TABLE IF EXISTS `basic_option_item`;
CREATE TABLE `basic_option_item` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '是否啟用',
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名稱',
  `key_value` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT '[FK]分舘ID',
  `option_set_id` int(11) NOT NULL COMMENT '[FK]捨於哪一個選項',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='選項 項目';

-- --------------------------------------------------------

--
-- 資料表結構 `basic_option_set`
--

DROP TABLE IF EXISTS `basic_option_set`;
CREATE TABLE `basic_option_set` (
  `id` int(11) NOT NULL,
  `is_edit` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='選擇大項目設置';

-- --------------------------------------------------------

--
-- 資料表結構 `basic_web_key`
--

DROP TABLE IF EXISTS `basic_web_key`;
CREATE TABLE `basic_web_key` (
  `id` int(11) NOT NULL,
  `is_setting` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '單元名稱',
  `keyval` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '辨別key',
  `branch_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leon_key` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='單元分類用key';

--
-- 傾印資料表的資料 `basic_web_key`
--

INSERT INTO `basic_web_key` (`id`, `is_setting`, `create_id`, `w_rank`, `title`, `keyval`, `branch_id`, `leon_key`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 'main', '1', '1', 0, '2019-09-22 00:00:00', '2019-09-22 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_mains`
--

DROP TABLE IF EXISTS `en_backend_mains`;
CREATE TABLE `en_backend_mains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_ids`)),
  `type_id` int(11) NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分頁名稱',
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hidden h1 標籤',
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享標題',
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享敘述',
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享預覽圖片',
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FB PIXEL',
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '結構化標籤',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `en_backend_mains`
--

INSERT INTO `en_backend_mains` (`id`, `title`, `subtitle`, `img`, `content`, `date`, `category_ids`, `type_id`, `fantasy_hide`, `w_rank`, `is_reviewed`, `is_preview`, `is_visible`, `wait_del`, `temp_url`, `url_name`, `branch_id`, `create_id`, `seo_title`, `seo_h1`, `seo_keyword`, `seo_meta`, `og_title`, `og_description`, `og_img`, `ga_code`, `gtm_code`, `fb_code`, `structured`, `created_at`, `updated_at`) VALUES
(1, '01', '', '', '', '2022-07-03', '[\"2\"]', 1, 0, 12, 0, 0, 0, 0, '', '', 1, 7, '', '', '', '', '', '', '', '', '', '', '', '2022-07-06 03:05:34', '2022-07-06 03:07:28'),
(2, '02', '', '', '', '2022-07-08', '[\"1\",\"2\"]', 1, 0, 12, 0, 0, 0, 0, '', '', 1, 7, '', '', '', '', '', '', '', '', '', '', '', '2022-07-06 03:05:46', '2022-07-06 03:07:02'),
(5, '03', '', '', '', '0000-00-00', '[\"1\",\"2\",\"3\"]', 2, 0, 12, 0, 0, 0, 0, '', '', 1, 7, '', '', '', '', '', '', '', '', '', '', '', '2022-07-06 05:52:29', '2022-07-06 05:52:30'),
(6, '02_(複製5)', '', '', '', '2022-07-08', '[\"1\",\"2\"]', 1, 0, 12, 0, 0, 0, 0, '', '_(複製5)', 1, 7, '', '', '', '', '', '', '', '', '', '', '', '2022-07-06 09:17:33', '2022-07-06 09:17:33');

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_main_categories`
--

DROP TABLE IF EXISTS `en_backend_main_categories`;
CREATE TABLE `en_backend_main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `en_backend_main_categories`
--

INSERT INTO `en_backend_main_categories` (`id`, `title`, `subtitle`, `img`, `content`, `fantasy_hide`, `w_rank`, `is_reviewed`, `is_preview`, `is_visible`, `wait_del`, `temp_url`, `url_name`, `branch_id`, `create_id`, `created_at`, `updated_at`) VALUES
(1, 'ca-01', '', '', '', 0, 12, 0, 0, 0, 0, '', '', 1, 7, '2022-07-06 03:04:47', '2022-07-06 03:04:47'),
(2, 'ca-02', '', '', '', 0, 12, 0, 0, 0, 0, '', '', 1, 7, '2022-07-06 03:04:54', '2022-07-06 03:04:55'),
(3, 'ca-03', '', '', '', 0, 12, 0, 0, 0, 0, '', '', 1, 7, '2022-07-06 03:05:03', '2022-07-06 03:05:03');

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_main_contents`
--

DROP TABLE IF EXISTS `en_backend_main_contents`;
CREATE TABLE `en_backend_main_contents` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `create_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_swiper` int(11) NOT NULL COMMENT '圖片是否為輪播',
  `is_slice` int(11) NOT NULL COMMENT '內文色塊是否對齊邊際',
  `img_row` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'x1' COMMENT '多圖並排 x1, x2, x3, x4, x5',
  `img_firstbig` int(11) NOT NULL COMMENT '第一順位 img 強制 100% 放大',
  `img_merge` int(11) NOT NULL COMMENT '隱藏 img 間距及 Description',
  `img_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'img比例設定 x11, x34, x43, x169',
  `img_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 垂直對其設定',
  `description_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 描述文字顏色設定',
  `description_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'center',
  `article_style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落樣式',
  `article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',
  `article_sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落副標題',
  `article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',
  `instagram_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊底色設定',
  `article_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊垂直對其方式設定',
  `full_img` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊底圖設定',
  `full_img_rwd` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊RWD底圖設定',
  `full_size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊尺寸設定: s, m, l',
  `full_box_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull=Box, Box區塊顏色設定',
  `h_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字顏色設定',
  `h_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字對齊方式設定',
  `subh_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字顏色設定',
  `subh_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字對齊方式設定',
  `p_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字顏色設定',
  `p_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字對齊方式設定',
  `button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button文字',
  `button_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button連結',
  `link_type` int(11) NOT NULL COMMENT '連結開啟方式',
  `button_color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_color_hover` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_textcolor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'buttton 文字顏色設定',
  `button_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_textalign` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `swiper_num` int(11) NOT NULL DEFAULT 1 COMMENT '一次出現幾張圖片',
  `swiper_autoplay` int(11) NOT NULL COMMENT '是否開啟自動播放',
  `swiper_loop` int(11) NOT NULL DEFAULT 1,
  `swiper_arrow` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用左右箭頭按鈕',
  `swiper_nav` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用下方切換選單',
  `temp_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='段落編輯器';

--
-- 傾印資料表的資料 `en_backend_main_contents`
--

INSERT INTO `en_backend_main_contents` (`id`, `w_rank`, `is_visible`, `branch_id`, `created_at`, `updated_at`, `create_id`, `parent_id`, `is_swiper`, `is_slice`, `img_row`, `img_firstbig`, `img_merge`, `img_size`, `img_flex`, `description_color`, `description_align`, `article_style`, `article_title`, `article_sub_title`, `article_inner`, `instagram_content`, `article_color`, `article_flex`, `full_img`, `full_img_rwd`, `full_size`, `full_box_color`, `h_color`, `h_align`, `subh_color`, `subh_align`, `p_color`, `p_align`, `button`, `button_link`, `link_type`, `button_color`, `button_color_hover`, `button_textcolor`, `button_align`, `btn_textalign`, `swiper_num`, `swiper_autoplay`, `swiper_loop`, `swiper_arrow`, `swiper_nav`, `temp_url`) VALUES
(1, 1, 1, 1, '2022-07-07 16:23:54', '2022-07-07 16:23:54', 0, 6, 0, 0, '0', 0, 0, '0', '0', '', '0', 'typeBasic', '', '', '', '', '', '0', '', '', '0', '', '', '0', '', '0', '', '0', '', '', 0, '', '', '', '0', '', 0, 0, 0, 0, 0, 'qzDOM');

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_main_content_images`
--

DROP TABLE IF EXISTS `en_backend_main_content_images`;
CREATE TABLE `en_backend_main_content_images` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_reviewed` int(11) NOT NULL,
  `is_preview` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `temp_url` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `video` text COLLATE utf8_unicode_ci NOT NULL,
  `video_img` text COLLATE utf8_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `second_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_main_sets`
--

DROP TABLE IF EXISTS `en_backend_main_sets`;
CREATE TABLE `en_backend_main_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分頁名稱',
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hidden h1 標籤',
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享標題',
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享敘述',
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享預覽圖片',
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FB PIXEL',
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '結構化標籤',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `en_backend_main_types`
--

DROP TABLE IF EXISTS `en_backend_main_types`;
CREATE TABLE `en_backend_main_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `en_backend_main_types`
--

INSERT INTO `en_backend_main_types` (`id`, `title`, `subtitle`, `img`, `content`, `fantasy_hide`, `w_rank`, `is_reviewed`, `is_preview`, `is_visible`, `wait_del`, `temp_url`, `url_name`, `branch_id`, `create_id`, `created_at`, `updated_at`) VALUES
(1, 'tp-01', '', '', '', 0, 12, 0, 0, 0, 0, '', '', 1, 7, '2022-07-06 03:05:10', '2022-07-06 03:05:25'),
(2, 'tp-02', '', '', '', 0, 12, 0, 0, 0, 0, '', '', 1, 7, '2022-07-06 03:05:18', '2022-07-06 03:05:19');

-- --------------------------------------------------------

--
-- 資料表結構 `en_main_with_category`
--

DROP TABLE IF EXISTS `en_main_with_category`;
CREATE TABLE `en_main_with_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `en_main_with_category`
--

INSERT INTO `en_main_with_category` (`id`, `main_id`, `category_id`, `fantasy_hide`, `w_rank`, `is_reviewed`, `is_preview`, `is_visible`, `wait_del`, `temp_url`, `url_name`, `branch_id`, `create_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(2, 2, 1, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(3, 2, 2, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(8, 5, 1, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(9, 5, 2, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(10, 5, 3, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(11, 6, 1, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL),
(12, 6, 2, 0, 12, 0, 0, 0, 0, '', '', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `en_website`
--

DROP TABLE IF EXISTS `en_website`;
CREATE TABLE `en_website` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `en_website`
--

INSERT INTO `en_website` (`id`, `title`, `url_name`, `branch_id`, `seo_title`, `seo_h1`, `seo_keyword`, `seo_meta`, `og_title`, `og_description`, `og_img`, `ga_code`, `gtm_code`, `fb_code`, `structured`) VALUES
(1, '首頁', 'home', 1, 'Home', '', '', '', '', '', '', '', '', '', '\"auth\" : \"wayne\"');

-- --------------------------------------------------------

--
-- 資料表結構 `leon_database`
--

DROP TABLE IF EXISTS `leon_database`;
CREATE TABLE `leon_database` (
  `id` int(11) NOT NULL COMMENT '編號',
  `db_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `db_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名稱',
  `db_data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '資料',
  `other_data` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='leon_database' ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `leon_database`
--

INSERT INTO `leon_database` (`id`, `db_note`, `db_name`, `db_data`, `other_data`) VALUES
(1, '網站基本設定', 'website', '[{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"網站名稱\",\"name\":\"w_title\",\"type\":\"varchar\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"網站LOGO\",\"name\":\"o_img_logo\",\"type\":\"varchar\",\"formtype\":\"imageGroup_all\",\"model\":\"\",\"tip\":\"電腦版 75x65 手機板 75x35\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"頁尾網站LOGO\",\"name\":\"o_img_logo_scroll\",\"type\":\"varchar\",\"formtype\":\"\",\"model\":\"\",\"tip\":\"適當大小\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"FB網址\",\"name\":\"url_fb\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"IG網址\",\"name\":\"url_ig\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"twitter網址\",\"name\":\"url_twitter\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"youtube網址\",\"name\":\"url_youtube\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"LINE網址\",\"name\":\"url_line\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"微信QR Code\",\"name\":\"o_img_wechat\",\"type\":\"varchar\",\"formtype\":\"imageGroup\",\"model\":\"\",\"tip\":\"x\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"1\",\"is_visible\":\"0\",\"is_rank\":\"0\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isShareModel\":\"0\"}'),
(2, '資料分類', 'news_class', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isPermission\":\"1\"}'),
(3, '資料內容', 'news', '[{\"show\":\"true\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"內容\",\"name\":\"w_text\",\"type\":\"text\",\"formtype\":\"textArea\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"按鈕\",\"name\":\"w_radio\",\"type\":\"int\",\"formtype\":\"radio_btn\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單選\",\"name\":\"news_class_id\",\"type\":\"int\",\"formtype\":\"select2\",\"model\":\"news_class\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"多選\",\"name\":\"news_class_mulit\",\"type\":\"text\",\"formtype\":\"select2Multi\",\"model\":\"news_class\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單圖\",\"name\":\"o_img\",\"type\":\"varchar\",\"formtype\":\"imageGroup\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"顏色\",\"name\":\"w_color\",\"type\":\"varchar\",\"formtype\":\"colorPicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"日期\",\"name\":\"w_date\",\"type\":\"varchar\",\"formtype\":\"datePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"檔案\",\"name\":\"o_file\",\"type\":\"varchar\",\"formtype\":\"filePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_visible\":\"1\",\"is_rank\":\"0\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isShareModel\":\"0\",\"isPermission\":\"0\"}'),
(4, '資料項目', 'news_tag', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\"}'),
(5, '資料分類1', 'news_class1', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isPermission\":\"1\"}'),
(6, '資料內容1', 'news1', '[{\"show\":\"true\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"內容\",\"name\":\"w_text\",\"type\":\"text\",\"formtype\":\"textArea\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"按鈕\",\"name\":\"w_radio\",\"type\":\"int\",\"formtype\":\"radio_btn\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單選\",\"name\":\"news_class_id\",\"type\":\"int\",\"formtype\":\"select2\",\"model\":\"news_class1\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"多選\",\"name\":\"news_class_mulit\",\"type\":\"text\",\"formtype\":\"select2Multi\",\"model\":\"news_class1\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單圖\",\"name\":\"o_img\",\"type\":\"varchar\",\"formtype\":\"imageGroup\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"顏色\",\"name\":\"w_color\",\"type\":\"varchar\",\"formtype\":\"colorPicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"日期\",\"name\":\"w_date\",\"type\":\"varchar\",\"formtype\":\"datePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"檔案\",\"name\":\"o_file\",\"type\":\"varchar\",\"formtype\":\"filePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_visible\":\"1\",\"is_rank\":\"0\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isShareModel\":\"0\",\"isPermission\":\"0\"}'),
(7, '資料項目1', 'news_tag1', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\"}'),
(8, '資料分類2', 'news_class2', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isPermission\":\"1\"}'),
(9, '資料內容2', 'news2', '[{\"show\":\"true\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"內容\",\"name\":\"w_text\",\"type\":\"text\",\"formtype\":\"textArea\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"按鈕\",\"name\":\"w_radio\",\"type\":\"int\",\"formtype\":\"radio_btn\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單選\",\"name\":\"news_class_id\",\"type\":\"int\",\"formtype\":\"select2\",\"model\":\"news_class2\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"多選\",\"name\":\"news_class_mulit\",\"type\":\"text\",\"formtype\":\"select2Multi\",\"model\":\"news_class2\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單圖\",\"name\":\"o_img\",\"type\":\"varchar\",\"formtype\":\"imageGroup\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"顏色\",\"name\":\"w_color\",\"type\":\"varchar\",\"formtype\":\"colorPicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"日期\",\"name\":\"w_date\",\"type\":\"varchar\",\"formtype\":\"datePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"檔案\",\"name\":\"o_file\",\"type\":\"varchar\",\"formtype\":\"filePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_visible\":\"1\",\"is_rank\":\"0\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isShareModel\":\"0\",\"isPermission\":\"0\"}'),
(10, '資料項目2', 'news_tag2', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\"}'),
(11, '資料分類3', 'news_class3', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isPermission\":\"1\"}'),
(12, '資料內容3', 'news3', '[{\"show\":\"true\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"內容\",\"name\":\"w_text\",\"type\":\"text\",\"formtype\":\"textArea\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"按鈕\",\"name\":\"w_radio\",\"type\":\"int\",\"formtype\":\"radio_btn\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單選\",\"name\":\"news_class_id\",\"type\":\"int\",\"formtype\":\"select2\",\"model\":\"news_class3\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"多選\",\"name\":\"news_class_mulit\",\"type\":\"text\",\"formtype\":\"select2Multi\",\"model\":\"news_class3\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"單圖\",\"name\":\"o_img\",\"type\":\"varchar\",\"formtype\":\"imageGroup\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"顏色\",\"name\":\"w_color\",\"type\":\"varchar\",\"formtype\":\"colorPicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"true\",\"search\":\"true\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"日期\",\"name\":\"w_date\",\"type\":\"varchar\",\"formtype\":\"datePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"},{\"show\":\"false\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"檔案\",\"name\":\"o_file\",\"type\":\"varchar\",\"formtype\":\"filePicker\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_visible\":\"1\",\"is_rank\":\"0\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\",\"isShareModel\":\"0\",\"isPermission\":\"0\"}'),
(13, '資料項目3', 'news_tag3', '[{\"show\":\"true\",\"batch\":\"false\",\"search\":\"false\",\"son\":\"false\",\"disable\":\"false\",\"note\":\"標題\",\"name\":\"w_title\",\"type\":\"text\",\"formtype\":\"textInput\",\"model\":\"\",\"tip\":\"\",\"tab\":\"\",\"img\":\"\"}]', '{\"is_onepage\":\"0\",\"is_rank\":\"0\",\"is_visible\":\"1\",\"isDelete\":\"0\",\"isCreate\":\"0\",\"isExport\":\"1\",\"isClone\":\"0\"}');

-- --------------------------------------------------------

--
-- 資料表結構 `leon_menu`
--

DROP TABLE IF EXISTS `leon_menu`;
CREATE TABLE `leon_menu` (
  `id` int(11) NOT NULL COMMENT '編號',
  `db_data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '資料',
  `w_setting` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='leon_menu';

--
-- 傾印資料表的資料 `leon_menu`
--

INSERT INTO `leon_menu` (`id`, `db_data`, `w_setting`) VALUES
(1, '[{\"contentx\":\"\",\"contenta\":\"資料1\",\"id\":\"\",\"children\":[{\"contenta\":\"資料分類\",\"id\":\"News_class\"},{\"contenta\":\"資料內容\",\"id\":\"News\",\"children\":[{\"contenta\":\"資料項目\",\"id\":\"News_tag\"}]}]},{\"contentx\":\"\",\"contenta\":\"資料2\",\"id\":\"\",\"children\":[{\"contenta\":\"資料分類1\",\"id\":\"News_class1\"},{\"contenta\":\"資料內容1\",\"id\":\"News1\",\"children\":[{\"contenta\":\"資料項目1\",\"id\":\"News_tag1\"}]}]},{\"contentx\":\"\",\"contenta\":\"資料3\",\"id\":\"\",\"children\":[{\"contenta\":\"資料分類2\",\"id\":\"News_class2\"},{\"contenta\":\"資料內容2\",\"id\":\"News2\",\"children\":[{\"contenta\":\"資料項目2\",\"id\":\"News_tag2\"}]}]},{\"contentx\":\"\",\"contenta\":\"資料4\",\"id\":\"\",\"children\":[{\"contenta\":\"資料分類3\",\"id\":\"News_class3\"},{\"contenta\":\"資料內容3\",\"id\":\"News3\",\"children\":[{\"contenta\":\"資料項目3\",\"id\":\"News_tag3\"}]}]},{\"contenta\":\"網站基本設定\",\"id\":\"Website\"}]', '{\"is_review\":\"0\",\"sub_domain\":\"preview,www\"}');

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2022_07_01_161705_create_backend_main_sets_table', 1),
(16, '2022_07_01_161720_create_backend_main_categories_table', 1),
(17, '2022_07_01_161740_create_backend_mains_table', 1),
(18, '2022_07_05_155043_create_backend_main_types_table', 1),
(19, '2022_07_05_155428_create_main_with_categories_table', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `mysession`
--

DROP TABLE IF EXISTS `mysession`;
CREATE TABLE `mysession` (
  `session_key` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_expiry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 傾印資料表的資料 `mysession`
--

INSERT INTO `mysession` (`session_key`, `session_data`, `session_expiry`) VALUES
('4l8kckttd5203glc8b9qrcdkm9', '', 1653363824),
('aj3b1qooieucp3oa1ldrhdq4sh', '', 1653291050);

-- --------------------------------------------------------

--
-- 資料表結構 `sample_second_table`
--

DROP TABLE IF EXISTS `sample_second_table`;
CREATE TABLE `sample_second_table` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `create_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_swiper` int(11) NOT NULL COMMENT '圖片是否為輪播',
  `is_slice` int(11) NOT NULL COMMENT '內文色塊是否對齊邊際',
  `img_row` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'x1' COMMENT '多圖並排 x1, x2, x3, x4, x5',
  `img_firstbig` int(11) NOT NULL COMMENT '第一順位 img 強制 100% 放大',
  `img_merge` int(11) NOT NULL COMMENT '隱藏 img 間距及 Description',
  `img_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'img比例設定 x11, x34, x43, x169',
  `img_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 垂直對其設定',
  `description_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 描述文字顏色設定',
  `description_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'center',
  `article_style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落樣式',
  `article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',
  `article_sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落副標題',
  `article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',
  `instagram_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊底色設定',
  `article_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊垂直對其方式設定',
  `full_img` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊底圖設定',
  `full_img_rwd` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊RWD底圖設定',
  `full_size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊尺寸設定: s, m, l',
  `full_box_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull=Box, Box區塊顏色設定',
  `h_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字顏色設定',
  `h_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字對齊方式設定',
  `subh_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字顏色設定',
  `subh_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字對齊方式設定',
  `p_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字顏色設定',
  `p_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字對齊方式設定',
  `button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button文字',
  `button_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button連結',
  `link_type` int(11) NOT NULL COMMENT '連結開啟方式',
  `button_color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_color_hover` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_textcolor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'buttton 文字顏色設定',
  `button_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_textalign` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `swiper_num` int(11) NOT NULL DEFAULT 1 COMMENT '一次出現幾張圖片',
  `swiper_autoplay` int(11) NOT NULL COMMENT '是否開啟自動播放',
  `swiper_loop` int(11) NOT NULL DEFAULT 1,
  `swiper_arrow` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用左右箭頭按鈕',
  `swiper_nav` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用下方切換選單',
  `temp_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='段落編輯器';

-- --------------------------------------------------------

--
-- 資料表結構 `sample_three_table`
--

DROP TABLE IF EXISTS `sample_three_table`;
CREATE TABLE `sample_three_table` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_reviewed` int(11) NOT NULL,
  `is_preview` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `temp_url` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `video` text COLLATE utf8_unicode_ci NOT NULL,
  `video_img` text COLLATE utf8_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `second_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_mains`
--

DROP TABLE IF EXISTS `tw_backend_mains`;
CREATE TABLE `tw_backend_mains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_ids`)),
  `type_id` int(11) NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分頁名稱',
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hidden h1 標籤',
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享標題',
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享敘述',
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享預覽圖片',
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FB PIXEL',
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '結構化標籤',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_main_categories`
--

DROP TABLE IF EXISTS `tw_backend_main_categories`;
CREATE TABLE `tw_backend_main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_main_contents`
--

DROP TABLE IF EXISTS `tw_backend_main_contents`;
CREATE TABLE `tw_backend_main_contents` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `create_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_swiper` int(11) NOT NULL COMMENT '圖片是否為輪播',
  `is_slice` int(11) NOT NULL COMMENT '內文色塊是否對齊邊際',
  `img_row` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'x1' COMMENT '多圖並排 x1, x2, x3, x4, x5',
  `img_firstbig` int(11) NOT NULL COMMENT '第一順位 img 強制 100% 放大',
  `img_merge` int(11) NOT NULL COMMENT '隱藏 img 間距及 Description',
  `img_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'img比例設定 x11, x34, x43, x169',
  `img_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 垂直對其設定',
  `description_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img 描述文字顏色設定',
  `description_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'center',
  `article_style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落樣式',
  `article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',
  `article_sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落副標題',
  `article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',
  `instagram_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊底色設定',
  `article_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊垂直對其方式設定',
  `full_img` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊底圖設定',
  `full_img_rwd` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊RWD底圖設定',
  `full_size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊尺寸設定: s, m, l',
  `full_box_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull=Box, Box區塊顏色設定',
  `h_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字顏色設定',
  `h_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字對齊方式設定',
  `subh_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字顏色設定',
  `subh_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字對齊方式設定',
  `p_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字顏色設定',
  `p_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字對齊方式設定',
  `button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button文字',
  `button_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button連結',
  `link_type` int(11) NOT NULL COMMENT '連結開啟方式',
  `button_color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_color_hover` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `button_textcolor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'buttton 文字顏色設定',
  `button_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_textalign` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `swiper_num` int(11) NOT NULL DEFAULT 1 COMMENT '一次出現幾張圖片',
  `swiper_autoplay` int(11) NOT NULL COMMENT '是否開啟自動播放',
  `swiper_loop` int(11) NOT NULL DEFAULT 1,
  `swiper_arrow` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用左右箭頭按鈕',
  `swiper_nav` int(11) NOT NULL DEFAULT 1 COMMENT '是否啟用下方切換選單',
  `temp_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='段落編輯器';

--
-- 傾印資料表的資料 `tw_backend_main_contents`
--

INSERT INTO `tw_backend_main_contents` (`id`, `w_rank`, `is_visible`, `branch_id`, `created_at`, `updated_at`, `create_id`, `parent_id`, `is_swiper`, `is_slice`, `img_row`, `img_firstbig`, `img_merge`, `img_size`, `img_flex`, `description_color`, `description_align`, `article_style`, `article_title`, `article_sub_title`, `article_inner`, `instagram_content`, `article_color`, `article_flex`, `full_img`, `full_img_rwd`, `full_size`, `full_box_color`, `h_color`, `h_align`, `subh_color`, `subh_align`, `p_color`, `p_align`, `button`, `button_link`, `link_type`, `button_color`, `button_color_hover`, `button_textcolor`, `button_align`, `btn_textalign`, `swiper_num`, `swiper_autoplay`, `swiper_loop`, `swiper_arrow`, `swiper_nav`, `temp_url`) VALUES
(1, 1, 1, 1, '2022-07-04 18:07:55', '2022-07-04 18:07:55', 0, 2, 0, 0, '0', 0, 0, '0', '0', '', '0', 'typeBasic', '', '', '', '', '', '0', '', '', '', '', '', '0', '', '', '', '0', '', '', 0, '', '', '', '0', '', 0, 0, 0, 1, 1, '65v5n');

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_main_content_images`
--

DROP TABLE IF EXISTS `tw_backend_main_content_images`;
CREATE TABLE `tw_backend_main_content_images` (
  `id` int(11) NOT NULL,
  `w_rank` int(11) NOT NULL,
  `is_reviewed` int(11) NOT NULL,
  `is_preview` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `create_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `temp_url` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `video` text COLLATE utf8_unicode_ci NOT NULL,
  `video_img` text COLLATE utf8_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `second_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_main_sets`
--

DROP TABLE IF EXISTS `tw_backend_main_sets`;
CREATE TABLE `tw_backend_main_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分頁名稱',
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hidden h1 標籤',
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享標題',
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享敘述',
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社群分享預覽圖片',
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FB PIXEL',
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '結構化標籤',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_backend_main_types`
--

DROP TABLE IF EXISTS `tw_backend_main_types`;
CREATE TABLE `tw_backend_main_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_main_with_category`
--

DROP TABLE IF EXISTS `tw_main_with_category`;
CREATE TABLE `tw_main_with_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `fantasy_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '後台隱藏不顯示',
  `w_rank` int(11) NOT NULL DEFAULT 12 COMMENT '排序',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '審核',
  `is_preview` tinyint(1) NOT NULL DEFAULT 0 COMMENT '預覽',
  `is_visible` tinyint(1) NOT NULL DEFAULT 0 COMMENT '前台是否顯示',
  `wait_del` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申請刪除',
  `temp_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設網址名稱',
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '網址名稱',
  `branch_id` int(11) NOT NULL DEFAULT 1 COMMENT '分館ID',
  `create_id` int(11) NOT NULL COMMENT 'Fantasy User ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `tw_website`
--

DROP TABLE IF EXISTS `tw_website`;
CREATE TABLE `tw_website` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ga_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gtm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `structured` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `tw_website`
--

INSERT INTO `tw_website` (`id`, `title`, `url_name`, `branch_id`, `seo_title`, `seo_h1`, `seo_keyword`, `seo_meta`, `og_title`, `og_description`, `og_img`, `ga_code`, `gtm_code`, `fb_code`, `structured`) VALUES
(1, '首頁', 'home', 1, 'Home', '', '', '', '', '', '', '', '', '', '\"auth\" : \"wayne\"');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `basic_ams_role`
--
ALTER TABLE `basic_ams_role`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_autoredirect`
--
ALTER TABLE `basic_autoredirect`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_branch_origin`
--
ALTER TABLE `basic_branch_origin`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_branch_origin_unit`
--
ALTER TABLE `basic_branch_origin_unit`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_child`
--
ALTER TABLE `basic_cms_child`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_child_son`
--
ALTER TABLE `basic_cms_child_son`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_data_auth`
--
ALTER TABLE `basic_cms_data_auth`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_menu`
--
ALTER TABLE `basic_cms_menu`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_menu_use`
--
ALTER TABLE `basic_cms_menu_use`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_parent`
--
ALTER TABLE `basic_cms_parent`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_parent_son`
--
ALTER TABLE `basic_cms_parent_son`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_permission`
--
ALTER TABLE `basic_cms_permission`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_cms_role`
--
ALTER TABLE `basic_cms_role`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_country_codes`
--
ALTER TABLE `basic_country_codes`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_crs_permission`
--
ALTER TABLE `basic_crs_permission`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_crs_role`
--
ALTER TABLE `basic_crs_role`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_data_city`
--
ALTER TABLE `basic_data_city`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_data_city_region`
--
ALTER TABLE `basic_data_city_region`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_fantasy_users`
--
ALTER TABLE `basic_fantasy_users`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_fms_file`
--
ALTER TABLE `basic_fms_file`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_fms_folder`
--
ALTER TABLE `basic_fms_folder`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_log_data`
--
ALTER TABLE `basic_log_data`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_option_item`
--
ALTER TABLE `basic_option_item`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_option_set`
--
ALTER TABLE `basic_option_set`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `basic_web_key`
--
ALTER TABLE `basic_web_key`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_mains`
--
ALTER TABLE `en_backend_mains`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_main_categories`
--
ALTER TABLE `en_backend_main_categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_main_contents`
--
ALTER TABLE `en_backend_main_contents`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_main_content_images`
--
ALTER TABLE `en_backend_main_content_images`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_main_sets`
--
ALTER TABLE `en_backend_main_sets`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_backend_main_types`
--
ALTER TABLE `en_backend_main_types`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_main_with_category`
--
ALTER TABLE `en_main_with_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `en_website`
--
ALTER TABLE `en_website`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leon_database`
--
ALTER TABLE `leon_database`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leon_menu`
--
ALTER TABLE `leon_menu`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mysession`
--
ALTER TABLE `mysession`
  ADD PRIMARY KEY (`session_key`);

--
-- 資料表索引 `sample_second_table`
--
ALTER TABLE `sample_second_table`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sample_three_table`
--
ALTER TABLE `sample_three_table`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_mains`
--
ALTER TABLE `tw_backend_mains`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_main_categories`
--
ALTER TABLE `tw_backend_main_categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_main_contents`
--
ALTER TABLE `tw_backend_main_contents`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_main_content_images`
--
ALTER TABLE `tw_backend_main_content_images`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_main_sets`
--
ALTER TABLE `tw_backend_main_sets`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_backend_main_types`
--
ALTER TABLE `tw_backend_main_types`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_main_with_category`
--
ALTER TABLE `tw_main_with_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tw_website`
--
ALTER TABLE `tw_website`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_ams_role`
--
ALTER TABLE `basic_ams_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_autoredirect`
--
ALTER TABLE `basic_autoredirect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_branch_origin`
--
ALTER TABLE `basic_branch_origin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_branch_origin_unit`
--
ALTER TABLE `basic_branch_origin_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_child`
--
ALTER TABLE `basic_cms_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_child_son`
--
ALTER TABLE `basic_cms_child_son`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_data_auth`
--
ALTER TABLE `basic_cms_data_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_menu`
--
ALTER TABLE `basic_cms_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_menu_use`
--
ALTER TABLE `basic_cms_menu_use`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_parent`
--
ALTER TABLE `basic_cms_parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_parent_son`
--
ALTER TABLE `basic_cms_parent_son`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_permission`
--
ALTER TABLE `basic_cms_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_cms_role`
--
ALTER TABLE `basic_cms_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_country_codes`
--
ALTER TABLE `basic_country_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_crs_permission`
--
ALTER TABLE `basic_crs_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_crs_role`
--
ALTER TABLE `basic_crs_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_data_city`
--
ALTER TABLE `basic_data_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_data_city_region`
--
ALTER TABLE `basic_data_city_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_fantasy_users`
--
ALTER TABLE `basic_fantasy_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_fms_file`
--
ALTER TABLE `basic_fms_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_fms_folder`
--
ALTER TABLE `basic_fms_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_log_data`
--
ALTER TABLE `basic_log_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_option_item`
--
ALTER TABLE `basic_option_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_option_set`
--
ALTER TABLE `basic_option_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `basic_web_key`
--
ALTER TABLE `basic_web_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_mains`
--
ALTER TABLE `en_backend_mains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_main_categories`
--
ALTER TABLE `en_backend_main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_main_contents`
--
ALTER TABLE `en_backend_main_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_main_content_images`
--
ALTER TABLE `en_backend_main_content_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_main_sets`
--
ALTER TABLE `en_backend_main_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_backend_main_types`
--
ALTER TABLE `en_backend_main_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_main_with_category`
--
ALTER TABLE `en_main_with_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `en_website`
--
ALTER TABLE `en_website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `leon_database`
--
ALTER TABLE `leon_database`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `leon_menu`
--
ALTER TABLE `leon_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sample_second_table`
--
ALTER TABLE `sample_second_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sample_three_table`
--
ALTER TABLE `sample_three_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_mains`
--
ALTER TABLE `tw_backend_mains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_main_categories`
--
ALTER TABLE `tw_backend_main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_main_contents`
--
ALTER TABLE `tw_backend_main_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_main_content_images`
--
ALTER TABLE `tw_backend_main_content_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_main_sets`
--
ALTER TABLE `tw_backend_main_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_backend_main_types`
--
ALTER TABLE `tw_backend_main_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_main_with_category`
--
ALTER TABLE `tw_main_with_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tw_website`
--
ALTER TABLE `tw_website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
