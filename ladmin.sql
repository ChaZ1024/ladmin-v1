-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-12-05 10:20:35
-- 服务器版本： 5.7.22-log
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ladmin`
--

-- --------------------------------------------------------

--
-- 表的结构 `la_admins`
--

CREATE TABLE `la_admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `account` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员账号',
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员密码',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员手机号码',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员邮箱',
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '管理员头像',
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '管理员状态　１为正常，０为禁用',
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录ＩＰ',
  `last_time` datetime NOT NULL DEFAULT '2018-11-27 07:27:27' COMMENT '最后登录时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `super` tinyint(4) DEFAULT '0' COMMENT '是否为超级管理员'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_admins`
--

INSERT INTO `la_admins` (`id`, `account`, `password`, `phone`, `email`, `avatar`, `status`, `last_ip`, `last_time`, `created_at`, `updated_at`, `super`) VALUES
(1, 'admin', '$2y$10$ch/bO8tBmuC1KallzMWtgu9FuV.DolY4qUJhCcyaUJIOD5mT1L2Ce', '18018260613', '328103224@qq.com', '/storage/uploads/5x0hOWw8xeHi5bGhSX.jpeg', 1, '', '2018-11-27 07:27:27', NULL, '2018-12-02 18:49:14', 1),
(2, 'test1', '$2y$10$LwXHMs.08fwQb.5SoVhb2eumLD7BjP/nstutL3.DoE.8aaW0X3LtW', '18018260611', '328103224@qq.com', '/storage/uploads/IyXZMj6MYTCANaDOun.jpeg', 1, '', '2018-11-27 07:27:27', '2018-12-02 18:22:24', '2018-12-03 22:26:44', 0);

-- --------------------------------------------------------

--
-- 表的结构 `la_admin_role`
--

CREATE TABLE `la_admin_role` (
  `admin_id` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_admin_role`
--

INSERT INTO `la_admin_role` (`admin_id`, `role_id`) VALUES
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `la_migrations`
--

CREATE TABLE `la_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_migrations`
--

INSERT INTO `la_migrations` (`id`, `migration`, `batch`) VALUES
(13, '2018_11_27_024350_create_admins_table', 1),
(14, '2018_11_27_051039_create_sys_config_table', 1),
(23, '2018_11_27_094111_create_role_table', 2),
(24, '2018_11_27_094118_create_node_table', 2),
(25, '2018_11_27_094155_create_role_node_table', 2),
(26, '2018_11_27_094207_create_admin_role_table', 2),
(31, '2018_11_30_013929_create_resource_img_table', 3),
(32, '2018_12_03_083040_create_miniapp_conf_table', 3),
(34, '2018_12_04_011326_create_shop_table', 4);

-- --------------------------------------------------------

--
-- 表的结构 `la_miniapp_conf`
--

CREATE TABLE `la_miniapp_conf` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置key',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置值',
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '配置值排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_miniapp_conf`
--

INSERT INTO `la_miniapp_conf` (`id`, `key`, `value`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'MAPP_NAME', '321321', '0', NULL, '2018-12-03 00:41:13'),
(2, 'MAPP_QRCODE', '321321', '0', NULL, '2018-12-03 00:41:13'),
(3, 'MAPP_APPID', '321321', '0', NULL, '2018-12-03 00:41:13'),
(4, 'COMPANY_APPSECRET', '321321321', '0', NULL, '2018-12-03 00:41:13');

-- --------------------------------------------------------

--
-- 表的结构 `la_node`
--

CREATE TABLE `la_node` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点名称',
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点路由',
  `pid` int(11) NOT NULL COMMENT '父级节点',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `etitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '英文节点名称',
  `icon` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'icon图标',
  `status` tinyint(4) DEFAULT '1' COMMENT '是否显示 0为不显示，1为显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_node`
--

INSERT INTO `la_node` (`id`, `title`, `router`, `pid`, `created_at`, `updated_at`, `etitle`, `icon`, `status`) VALUES
(1, '权限管理', '/auth', 0, NULL, '2018-12-02 18:46:45', 'auth', 'layui-icon-home', 1),
(2, '角色列表', '/auth/role', 1, NULL, NULL, 'authrole', NULL, 1),
(3, '管理员列表', '/auth/admin', 1, NULL, NULL, 'authadmin', NULL, 1),
(4, '节点列表', '/auth/node', 1, NULL, NULL, 'authnode', NULL, 1),
(5, '会员管理', '/member', 0, NULL, NULL, 'member', 'layui-icon-user', 1),
(6, '会员列表', '/member/list', 5, NULL, NULL, 'memberlist', NULL, 1),
(7, '会员等级', '/member/level', 5, NULL, NULL, 'memberlevel', NULL, 1),
(8, '节点添加', '/auth/node/add', 4, NULL, '2018-11-30 06:31:31', 'authnodeadd', NULL, 0),
(9, '节点删除', '/auth/node/del', 4, '2018-11-30 06:11:18', '2018-11-30 06:31:42', 'authnodedel', NULL, 0),
(11, '系统设置', '/sys', 0, '2018-11-30 06:19:50', '2018-12-02 18:13:08', 'sysconfig', 'layui-icon-set', 1),
(12, '基础设置', '/sys/base', 11, '2018-11-30 06:21:32', '2018-12-02 05:13:48', 'sysbase', NULL, 1),
(13, '小程序管理', '/miniapp', 0, '2018-11-30 06:27:09', '2018-11-30 06:28:03', 'miniapp', 'layui-icon-dialogue', 1),
(14, '基础设置', '/miniapp/conf', 13, '2018-11-30 06:30:52', '2018-12-03 00:27:47', 'miniappconf', NULL, 1),
(15, '自定义配置', '/sys/custom', 11, '2018-12-02 05:52:42', '2018-12-03 00:15:57', 'syscustom', NULL, 0),
(16, '邮件设置', '/sys/smtp', 11, '2018-12-02 05:54:08', '2018-12-02 18:13:21', 'syssmtp', NULL, 1),
(17, '商家管理', '/shop', 0, '2018-12-02 18:59:08', '2018-12-02 19:00:00', 'shop', 'layui-icon-cart-simple', 1),
(18, '商家列表', '/shop/list', 17, '2018-12-02 18:59:31', '2018-12-03 22:48:41', 'shoplist', NULL, 1),
(19, '净化器管理', '/clean', 0, '2018-12-02 19:01:04', '2018-12-02 19:01:04', 'clean', 'layui-icon-upload-drag', 1),
(20, '净化器列表', '/clean/list', 19, '2018-12-02 19:01:33', '2018-12-02 19:01:33', 'cleanlist', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `la_resource_img`
--

CREATE TABLE `la_resource_img` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `la_role`
--

CREATE TABLE `la_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名称',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '角色状态,1为正常，0为禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_role`
--

INSERT INTO `la_role` (`id`, `title`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(1, '管理员', 0, 1, NULL, '2018-11-29 23:39:43'),
(3, '老板', 0, 1, '2018-11-28 22:50:30', '2018-11-28 22:50:30');

-- --------------------------------------------------------

--
-- 表的结构 `la_role_node`
--

CREATE TABLE `la_role_node` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `node_id` int(11) NOT NULL COMMENT '节点id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_role_node`
--

INSERT INTO `la_role_node` (`role_id`, `node_id`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 8),
(3, 5),
(3, 7),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 8);

-- --------------------------------------------------------

--
-- 表的结构 `la_shop`
--

CREATE TABLE `la_shop` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户名称',
  `discription` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户介绍',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户图片',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户地址',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户电话',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户经度',
  `lon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户纬度',
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '排序',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '商户状态 1为正常  0为封禁',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_shop`
--

INSERT INTO `la_shop` (`id`, `title`, `discription`, `pic`, `address`, `phone`, `lat`, `lon`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(1, '1231231231111', 'addsafdsfadsfsdfds', '/storage/uploads/bXZjv4pSWSPFWcIFh8.jpeg', '12321321', '12312321', '312321', '321321312', '0', '1', '2018-12-03 22:40:57', '2018-12-03 23:16:13');

-- --------------------------------------------------------

--
-- 表的结构 `la_sys_config`
--

CREATE TABLE `la_sys_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '配置标题',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置key',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '配置值',
  `ctype` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '配置项类型  base 基础  custom 自定义 smtp 邮箱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '配置值排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `la_sys_config`
--

INSERT INTO `la_sys_config` (`id`, `title`, `key`, `value`, `ctype`, `created_at`, `updated_at`, `sort`) VALUES
(10, NULL, 'SYS_NAME', '大象智能', 'base', NULL, '2018-12-02 06:35:28', 0),
(11, NULL, 'SYS_DOMAIN', 'daxzn.com', 'base', NULL, '2018-12-02 06:35:28', 0),
(12, NULL, 'SYS_RECORD', '123123', 'base', NULL, '2018-12-02 06:35:28', 0),
(13, NULL, 'COMPANY_NAME', '北京大象智慧智能科技有限公司', 'base', NULL, '2018-12-02 06:35:28', 0),
(14, NULL, 'COMPANY_ADD', '常州市新北区太湖路传媒中心3号楼1908室', 'base', NULL, '2018-12-02 06:35:28', 0),
(15, NULL, 'COMPANY_PHONE', '18018260611', 'base', NULL, '2018-12-02 06:35:28', 0),
(16, NULL, 'COMPANY_EMAIL', '328103224@qq.com', 'base', NULL, '2018-12-02 06:35:28', 0),
(17, NULL, 'SYS_COPYRIGHT', '12312321321321', 'base', NULL, '2018-12-02 06:35:28', 0),
(18, '测试', 'CUSTOM_TEST', '1111111', 'custom', NULL, NULL, 0),
(19, NULL, 'SMTP_SERVER', 'smtp.163.com', 'smtp', NULL, '2018-12-03 00:24:44', 0),
(20, NULL, 'SMTP_PORT', '25', 'smtp', NULL, '2018-12-03 00:24:44', 0),
(21, NULL, 'SMTP_EMAIL', '328103224@qq.com', 'smtp', NULL, '2018-12-03 00:24:44', 0),
(22, NULL, 'SMTP_NICKNAME', 'chaz', 'smtp', NULL, '2018-12-03 00:24:44', 0),
(23, NULL, 'SMTP_PASSWORD', '123123', 'smtp', NULL, '2018-12-03 00:24:44', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `la_admins`
--
ALTER TABLE `la_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_migrations`
--
ALTER TABLE `la_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_miniapp_conf`
--
ALTER TABLE `la_miniapp_conf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_node`
--
ALTER TABLE `la_node`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_resource_img`
--
ALTER TABLE `la_resource_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_role`
--
ALTER TABLE `la_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_shop`
--
ALTER TABLE `la_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_sys_config`
--
ALTER TABLE `la_sys_config`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `la_admins`
--
ALTER TABLE `la_admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `la_migrations`
--
ALTER TABLE `la_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `la_miniapp_conf`
--
ALTER TABLE `la_miniapp_conf`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `la_node`
--
ALTER TABLE `la_node`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `la_resource_img`
--
ALTER TABLE `la_resource_img`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `la_role`
--
ALTER TABLE `la_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `la_shop`
--
ALTER TABLE `la_shop`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `la_sys_config`
--
ALTER TABLE `la_sys_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
