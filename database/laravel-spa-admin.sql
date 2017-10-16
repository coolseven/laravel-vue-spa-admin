-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        10.1.26-MariaDB - mariadb.org binary distribution
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 laravel_spa_admin 的数据库结构
DROP DATABASE IF EXISTS `laravel_spa_admin`;
CREATE DATABASE IF NOT EXISTS `laravel_spa_admin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `laravel_spa_admin`;

-- 导出  表 laravel_spa_admin.auth_logs 结构
DROP TABLE IF EXISTS `auth_logs`;
CREATE TABLE IF NOT EXISTS `auth_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限变更日志';

-- 正在导出表  laravel_spa_admin.auth_logs 的数据：~0 rows (大约)
DELETE FROM `auth_logs`;
/*!40000 ALTER TABLE `auth_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_logs` ENABLE KEYS */;

-- 导出  表 laravel_spa_admin.auth_roles 结构
DROP TABLE IF EXISTS `auth_roles`;
CREATE TABLE IF NOT EXISTS `auth_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `display_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该角色的展示顺序',
  `routes` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '该角色拥有的前端路由地址集合',
  `menus` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '该角色拥有的左侧菜单树的菜单树(json字符串)',
  `apis` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '该角色拥有的接口地址集合',
  `is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '该角色是否已禁用，0-未禁用 ， 1-已禁用',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '角色创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '角色最近一次修改时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '角色删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理后台的角色表';

-- 正在导出表  laravel_spa_admin.auth_roles 的数据：~2 rows (大约)
DELETE FROM `auth_roles`;
/*!40000 ALTER TABLE `auth_roles` DISABLE KEYS */;
INSERT INTO `auth_roles` (`id`, `name`, `description`, `display_order`, `routes`, `menus`, `apis`, `is_disabled`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(3, '开发组', '开发组拥有除财务打款外的大部分权限', 0, '', '[{"name":"欢迎页","type":"route","path":"\\/welcome","parent":"根菜单","selected":true},{"name":"权限管理","type":"folder","path":"","parent":"根菜单","children":[{"name":"角色管理","type":"route","path":"\\/auth\\/roles","parent":"权限管理","selected":true},{"name":"用户管理","type":"route","path":"\\/auth\\/users","parent":"权限管理","selected":true}],"selected":true},{"name":"系统设置","type":"folder","path":"","parent":"根菜单","children":[{"name":"系统菜单","type":"route","path":"\\/system\\/menus","parent":"系统设置","selected":true}],"selected":true}]', '[{"description":"用户登入","uri":"api\\/user\\/login"},{"description":"用户登出","uri":"api\\/user\\/logout"},{"description":"信息更新","uri":"api\\/session\\/sync"},{"description":"分页获取角色","uri":"api\\/auth\\/roles\\/paginate"},{"description":"获取全部角色","uri":"api\\/auth\\/roles\\/all"},{"description":"获取指定角色的菜单集合","uri":"api\\/auth\\/role\\/menus"},{"description":"添加一个新角色","uri":"api\\/auth\\/role\\/create"},{"description":"获取指定角色的基本信息","uri":"api\\/auth\\/role\\/basic"},{"description":"获取指定角色的用户集合","uri":"api\\/auth\\/role\\/users"},{"description":"将指定用户排除出用户组","uri":"api\\/auth\\/role\\/detachUser"},{"description":"更新指定角色的菜单集合","uri":"api\\/auth\\/role\\/modifyMenus"},{"description":"获取指定角色的接口集合","uri":"api\\/auth\\/role\\/apis"},{"description":"更新指定角色的接口集合","uri":"api\\/auth\\/role\\/modifyApis"},{"description":"分页获取用户","uri":"api\\/auth\\/users\\/paginate"},{"description":"用户退出角色","uri":"api\\/auth\\/user\\/detachRole"},{"description":"删除指定用户","uri":"api\\/auth\\/user\\/delete"},{"description":"创建新用户","uri":"api\\/auth\\/user\\/create"},{"description":"更新用户资料","uri":"api\\/auth\\/user\\/modify"},{"description":"更新系统菜单","uri":"api\\/auth\\/menus\\/save"},{"description":"获取系统菜单","uri":"api\\/auth\\/menus\\/all"},{"description":"删除指定的角色","uri":"api\\/auth\\/role\\/delete"}]', 0, '2017-09-14 17:25:02', '2017-09-15 18:25:17', NULL),
	(4, '运营组', '运营组拥有运营相关权限', 0, '', '[{"name":"欢迎页","type":"route","path":"\\/welcome","parent":"根菜单","selected":true}]', '[{"description":"用户登入","middleware":"app.api","uri":"api\\/user\\/login"},{"description":"用户登出","middleware":"app.api","uri":"api\\/user\\/logout"},{"description":"信息更新","middleware":"app.api","uri":"api\\/session\\/sync"}]', 0, '2017-09-14 17:26:07', '2017-09-14 17:27:22', NULL);
/*!40000 ALTER TABLE `auth_roles` ENABLE KEYS */;

-- 导出  表 laravel_spa_admin.auth_role_user 结构
DROP TABLE IF EXISTS `auth_role_user`;
CREATE TABLE IF NOT EXISTS `auth_role_user` (
  `auth_user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `auth_role_id` int(11) unsigned NOT NULL COMMENT '角色id',
  UNIQUE KEY `auth_users_id_auth_roles_id` (`auth_user_id`,`auth_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户和角色的多对多关联表';

-- 正在导出表  laravel_spa_admin.auth_role_user 的数据：~9 rows (大约)
DELETE FROM `auth_role_user`;
/*!40000 ALTER TABLE `auth_role_user` DISABLE KEYS */;
INSERT INTO `auth_role_user` (`auth_user_id`, `auth_role_id`) VALUES
	(1, 3),
	(1, 4),
	(2, 3),
	(3, 3),
	(3, 4);
/*!40000 ALTER TABLE `auth_role_user` ENABLE KEYS */;

-- 导出  表 laravel_spa_admin.auth_users 结构
DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE IF NOT EXISTS `auth_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名，作为登录名',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '用户最近一次修改时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '用户删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理后台的用户表';

-- 正在导出表  laravel_spa_admin.auth_users 的数据：~6 rows (大约)
DELETE FROM `auth_users`;
/*!40000 ALTER TABLE `auth_users` DISABLE KEYS */;
INSERT INTO `auth_users` (`id`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '胡中园', '$2y$10$a5sm5EJJpeVNumKAlv9yfuDMTSp2Pka8CqNdi7K1KJa1xB6y/OPfC', '2017-09-01 17:24:05', '2017-09-03 16:16:45', NULL),
	(2, '开发者', '$2y$10$orciovXSOpgNUIRLnbgs1.cnJWjslFNIoqhFTBXc14Ny.3F7F1NXC', '2017-09-01 17:25:05', '2017-09-11 19:42:46', NULL),
	(3, '123456', '$2y$10$1TilyQyVySlwHo/gexEfNuu.4IM0kcErolAeFeyN5kZ2MpeGHjW7C', '2017-09-01 17:25:39', '2017-09-14 17:32:14', NULL);
/*!40000 ALTER TABLE `auth_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
