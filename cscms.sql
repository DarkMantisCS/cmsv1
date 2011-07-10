-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2011 at 07:03 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cscms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cscms_config`
--

CREATE TABLE IF NOT EXISTS `cscms_config` (
  `array` varchar(30) COLLATE utf8_bin NOT NULL,
  `var` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin,
  KEY `array` (`array`,`var`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cscms_config`
--

INSERT INTO `cscms_config` (`array`, `var`, `value`) VALUES
('site', 'title', 'Cysha'),
('cms', 'name', 'Cybershade CMS'),
('site', 'slogan', 'Fragging Your Mother'),
('site', 'theme', 'default'),
('site', 'language', 'en'),
('site', 'keywords', 'rarw'),
('site', 'description', 'rawr'),
('db', 'ckeauth', 'dmcgjm'),
('site', 'admin_email', 'xLink@cybershade.org'),
('site', 'site_closed', '0'),
('site', 'closed_msg', 'Administrator has closed this website.'),
('site', 'register_verification', '1'),
('site', 'index_module', 'forum'),
('site', 'registry_update', '1303735825'),
('site', 'allow_register', '1'),
('site', 'default_pagination', '10'),
('site', 'user_group', '3'),
('site', 'captcha_pub', '6LeoEcMSAAAAAENceaWHaFaRhpDdH4bBHTAQMp6f'),
('site', 'captcha_priv', '6LeoEcMSAAAAAFfgBGpZxJUFBdOqKPRBPpzF7wju'),
('site', 'analytics', ''),
('time', 'default_format', 'jS F h:ia'),
('time', 'dst', '1'),
('time', 'timezone', '0.0'),
('theme', 'theme_override', '0'),
('user', 'username_change', '0'),
('login', 'max_login_tries', '5'),
('login', 'remember_me', '1'),
('login', 'max_whitelist', '5'),
('rss', 'global_limit', '15'),
('forum', 'news_category', '2'),
('forum', 'sortable_categories', '1'),
('admin', 'index_notes', ''),
('ajax', 'settings', 'forum_eip,forum_sortables'),
('site', 'smilie_pack', 'default'),
('email', 'E_LOGIN_ATTEMPTS', 'Hello {USERNAME},\r\n\r\nWe''ve become aware of somebody, if not yourself, trying to login to your account with incorrect details.\r\n\r\nYour account has been locked for security purposes.\r\n\r\nTo Reactivate your account, please click the link below, or copy and paste it into your address bar.\r\n\r\n\r\n[url]{URL}[/url]'),
('login', 'lockout_time', '15'),
('site', 'internetCalls', '0'),
('login', 'ip_lock', '0'),
('forum', 'guest_restriction', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cscms_fileregistry`
--

CREATE TABLE IF NOT EXISTS `cscms_fileregistry` (
  `filename` varchar(255) COLLATE utf8_bin NOT NULL,
  `hash` char(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cscms_fileregistry`
--


-- --------------------------------------------------------

--
-- Table structure for table `cscms_forum_auth`
--

CREATE TABLE IF NOT EXISTS `cscms_forum_auth` (
  `group_id` int(11) unsigned NOT NULL,
  `cat_id` int(11) unsigned NOT NULL DEFAULT '0',
  `auth_view` int(1) NOT NULL DEFAULT '0',
  `auth_read` int(1) NOT NULL DEFAULT '0',
  `auth_post` int(1) NOT NULL DEFAULT '0',
  `auth_reply` int(1) NOT NULL DEFAULT '0',
  `auth_edit` int(1) NOT NULL DEFAULT '0',
  `auth_del` int(1) NOT NULL DEFAULT '0',
  `auth_move` int(1) NOT NULL DEFAULT '0',
  `auth_special` int(1) NOT NULL DEFAULT '0',
  `auth_mod` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_forum_cats`
--

CREATE TABLE IF NOT EXISTS `cscms_forum_cats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` text COLLATE utf8_bin,
  `order` int(3) NOT NULL DEFAULT '0',
  `last_post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `postcounts` int(1) NOT NULL DEFAULT '1',
  `auth_view` int(1) NOT NULL DEFAULT '0',
  `auth_read` int(1) NOT NULL DEFAULT '0',
  `auth_post` int(1) NOT NULL DEFAULT '0',
  `auth_reply` int(1) NOT NULL DEFAULT '0',
  `auth_edit` int(1) NOT NULL DEFAULT '0',
  `auth_del` int(1) NOT NULL DEFAULT '0',
  `auth_move` int(1) NOT NULL DEFAULT '0',
  `auth_special` int(1) NOT NULL DEFAULT '0',
  `auth_mod` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_forum_posts`
--

CREATE TABLE IF NOT EXISTS `cscms_forum_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) unsigned NOT NULL DEFAULT '0',
  `author` int(11) unsigned NOT NULL DEFAULT '0',
  `post` text COLLATE utf8_bin,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `poster_ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `edited` int(5) NOT NULL DEFAULT '0',
  `edited_uid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`),
  KEY `author` (`author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_forum_threads`
--

CREATE TABLE IF NOT EXISTS `cscms_forum_threads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) unsigned NOT NULL DEFAULT '0',
  `author` int(11) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `first_post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `last_post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) NOT NULL DEFAULT '0',
  `mode` int(1) NOT NULL DEFAULT '0',
  `views` int(1) NOT NULL DEFAULT '0',
  `old_cat_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_forum_watch`
--

CREATE TABLE IF NOT EXISTS `cscms_forum_watch` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `thread_id` int(11) unsigned NOT NULL DEFAULT '0',
  `seen` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_groups`
--

CREATE TABLE IF NOT EXISTS `cscms_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin,
  `moderator` int(11) unsigned NOT NULL DEFAULT '0',
  `single_user_group` tinyint(1) NOT NULL DEFAULT '1',
  `color` varchar(20) COLLATE utf8_bin NOT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cscms_groups`
--

INSERT INTO `cscms_groups` (`id`, `type`, `name`, `description`, `moderator`, `single_user_group`, `color`, `order`) VALUES
(1, 1, 'Admin', 'Administrator', 1, 0, '', 1),
(2, 1, 'Mod', 'Moderator', 1, 0, '', 3),
(3, 0, 'User', 'Registered User', 1, 0, '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_group_subs`
--

CREATE TABLE IF NOT EXISTS `cscms_group_subs` (
  `uid` int(11) unsigned NOT NULL,
  `gid` int(11) NOT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '1',
  KEY `gid` (`gid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_logs`
--

CREATE TABLE IF NOT EXISTS `cscms_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `query` text COLLATE utf8_bin,
  `refer` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_logs`
--

CREATE TABLE IF NOT EXISTS `cscms_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `query` text COLLATE utf8_bin,
  `refer` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_menus`
--

CREATE TABLE IF NOT EXISTS `cscms_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `link_value` tinytext COLLATE utf8_bin,
  `link_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `link_color` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `blank` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `perms` int(1) NOT NULL DEFAULT '0',
  `external` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cscms_menus`
--

INSERT INTO `cscms_menus` (`id`, `menu_id`, `link_value`, `link_name`, `link_color`, `blank`, `order`, `perms`, `external`) VALUES
(1, 'menu_mm', 'index.php', 'Site home', NULL, 0, 1, 0, 0),
(2, 'menu_mm', 'admin/', 'Admin Panel', '#FF0000', 0, 10, 3, 0),
(3, 'menu_mm', 'modules/forum/', 'Forum', NULL, 0, 2, 0, 0),
(4, 'menu_mm', 'modules/pm/', 'Private Messages', NULL, 0, 3, 1, 0),
(5, 'menu_mm', 'user/', 'User Control Panel', NULL, 0, 4, 1, 0),
(6, 'menu_mm', 'mod/', 'Moderator Panel', NULL, 0, 9, 3, 0),
(7, 'main_nav', 'index.php', 'Site Home', NULL, 0, 1, 0, 0),
(8, 'main_nav', 'modules/profile/view/', 'Profile', NULL, 0, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_menu_blocks`
--

CREATE TABLE IF NOT EXISTS `cscms_menu_blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` char(10) COLLATE utf8_bin NOT NULL,
  `module` text COLLATE utf8_bin,
  `function` text COLLATE utf8_bin,
  `position` tinyint(2) NOT NULL DEFAULT '0',
  `order` tinyint(2) NOT NULL DEFAULT '0',
  `perms` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cscms_menu_blocks`
--

INSERT INTO `cscms_menu_blocks` (`id`, `unique_id`, `module`, `function`, `position`, `order`, `perms`) VALUES
(1, 'jv1h9w6m2y', NULL, NULL, 0, 0),
(2, 'x91z6yvmrw', 'core', 'affiliates', 0, 0),
(3, 'ndxhzj9w54', 'core', 'wio', 0, 0),
(4, 'n4fym8r9gd', 'forum', 'forum_posts', 0, 0),
(5, '9rgtdk2zv8', 'login', 'login', 0, 0),
(6, '343fwfwr34', 'forum', 'forum_users', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_menu_setups`
--

CREATE TABLE IF NOT EXISTS `cscms_menu_setups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) COLLATE utf8_bin NOT NULL,
  `page_id` text COLLATE utf8_bin NOT NULL,
  `menu_id` char(10) COLLATE utf8_bin NOT NULL,
  `params` longtext COLLATE utf8_bin,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cscms_menu_setups`
--

INSERT INTO `cscms_menu_setups` (`id`, `module`, `page_id`, `menu_id`, `params`, `order`) VALUES
(1, 'core', 'default', 'jv1h9w6m2y', 'menu_name=mm\r\nmenu_title=Main Menu', 1),
(2, 'core', 'default', 'x91z6yvmrw', 'menu_title=M_AFFILIATES\r\nlimit=6\r\nperRow=2', 3),
(3, 'core', 'default', 'ndxhzj9w54', 'menu_title=m_wio', 4),
(4, 'forum', 'default', 'jv1h9w6m2y', 'menu_name=mm\r\nmenu_title=Main Menu', 1),
(5, 'forum', 'default', 'n4fym8r9gd', 'menu_title=m_latest_post\r\nlimit=5', 3),
(6, 'forum', 'default', 'ndxhzj9w54', 'menu_title=m_wio', 4),
(7, 'core', 'default', '9rgtdk2zv8', 'menu_title=m_login', 2),
(8, 'forum', 'default', '343fwfwr34', 'menu_title=M_TOP_USER\r\nlimit=5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_modules`
--

CREATE TABLE IF NOT EXISTS `cscms_modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `hash` char(32) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_notifications`
--

CREATE TABLE IF NOT EXISTS `cscms_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `body` text COLLATE utf8_bin,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `module_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_notification_settings`
--

CREATE TABLE IF NOT EXISTS `cscms_notification_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `setting` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `default` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cscms_notification_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `cscms_online`
--

CREATE TABLE IF NOT EXISTS `cscms_online` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ip_address` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `timestamp` int(11) NOT NULL,
  `hidden` int(1) NOT NULL DEFAULT '0',
  `location` text COLLATE utf8_bin NOT NULL,
  `referer` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_bin NOT NULL,
  `useragent` text COLLATE utf8_bin NOT NULL,
  `login_attempts` tinyint(2) NOT NULL DEFAULT '0',
  `login_time` int(11) NOT NULL,
  `userkey` char(32) COLLATE utf8_bin DEFAULT NULL,
  `mode` enum('active','kill','ban','update') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userkey` (`userkey`),
  KEY `uid` (`uid`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_plugins`
--

CREATE TABLE IF NOT EXISTS `cscms_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `filePath` text COLLATE utf8_bin NOT NULL,
  `author` varchar(50) COLLATE utf8_bin NOT NULL,
  `priority` enum('1','2','3') COLLATE utf8_bin NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cscms_plugins`
--

INSERT INTO `cscms_plugins` (`id`, `name`, `filePath`, `author`, `priority`, `enabled`) VALUES
(1, 'recaptcha', './plugins/cscms/hook.recaptcha.php', 'xLink', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_sqlerrors`
--

CREATE TABLE IF NOT EXISTS `cscms_sqlerrors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `query` text,
  `page` text,
  `vars` text,
  `error` text,
  `lineInfo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_statistics`
--

CREATE TABLE IF NOT EXISTS `cscms_statistics` (
  `variable` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`variable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cscms_statistics`
--

INSERT INTO `cscms_statistics` (`variable`, `value`) VALUES
('daily_cron', '1309006962'),
('hourly_cron', '1309026655'),
('site_opened', '1305563308'),
('weekly_cron', '1308577493');

-- --------------------------------------------------------

--
-- Table structure for table `cscms_userkeys`
--

CREATE TABLE IF NOT EXISTS `cscms_userkeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uData` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `uAgent` char(32) COLLATE utf8_bin NOT NULL,
  `uIP` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uData`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `cscms_users`
--

CREATE TABLE IF NOT EXISTS `cscms_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` char(34) COLLATE utf8_bin DEFAULT NULL,
  `pin` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `register_date` int(11) NOT NULL DEFAULT '0',
  `last_active` int(11) NOT NULL DEFAULT '0',
  `usercode` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `show_email` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `language` char(5) COLLATE utf8_bin NOT NULL DEFAULT 'en',
  `timezone` decimal(5,1) NOT NULL DEFAULT '0.0',
  `theme` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'default',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `userlevel` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `primary_group` int(5) NOT NULL DEFAULT '0',
  `login_attempts` int(3) NOT NULL DEFAULT '0',
  `pin_attempts` int(3) NOT NULL DEFAULT '0',
  `autologin` tinyint(1) NOT NULL DEFAULT '0',
  `reffered_by` int(11) unsigned NOT NULL DEFAULT '0',
  `password_update` tinyint(1) NOT NULL DEFAULT '0',
  `whitelist` tinyint(1) NOT NULL DEFAULT '0',
  `whitelisted_ips` text COLLATE utf8_bin,
  `warnings` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `usercode` (`usercode`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

--
-- Dumping data for table `cscms_users`
--

INSERT INTO `cscms_users` (`id`, `username`, `password`, `pin`, `register_date`, `last_active`, `usercode`, `email`, `show_email`, `avatar`, `title`, `language`, `timezone`, `theme`, `hidden`, `active`, `userlevel`, `banned`, `primary_group`, `login_attempts`, `pin_attempts`, `autologin`, `reffered_by`, `password_update`, `whitelist`, `whitelisted_ips`, `warnings`) VALUES
(1, 'xLink', '$J$Ba7IPvsuwII7oXXQbSgZeyzdFWuStA0', '5b7a4286775601aa8430065e59982c91', 1307310965, 1309026777, 'e071a0', 'xLink@cybershade.org', 0, NULL, NULL, 'en', '0.0', 'default', 0, 1, 3, 0, 3, 1, 0, 1, 0, 0, 0, NULL, 0),
(2, 'test', '$J$B.jI0lqt6UqSl0lQ721sxmmEciwdPM.', NULL, 1308230910, 0, '072746', 'test@test.org', 0, NULL, NULL, 'en', '0.0', 'default', 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_user_extras`
--

CREATE TABLE IF NOT EXISTS `cscms_user_extras` (
  `uid` int(11) unsigned NOT NULL,
  `birthday` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00/00/0000',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `contact_info` text COLLATE utf8_bin,
  `about` text COLLATE utf8_bin,
  `interests` text COLLATE utf8_bin,
  `signature` text COLLATE utf8_bin,
  `usernotes` text COLLATE utf8_bin NOT NULL,
  `ajax_settings` text COLLATE utf8_bin,
  `notification_settings` text COLLATE utf8_bin,
  `forum_show_sigs` tinyint(1) NOT NULL DEFAULT '1',
  `forum_autowatch` tinyint(1) NOT NULL DEFAULT '0',
  `forum_quickreply` tinyint(1) NOT NULL DEFAULT '0',
  `forum_cat_order` text COLLATE utf8_bin,
  `forum_tracker` text COLLATE utf8_bin,
  `pagination_style` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cscms_user_extras`
--

INSERT INTO `cscms_user_extras` (`uid`, `birthday`, `sex`, `contact_info`, `about`, `interests`, `signature`, `usernotes`, `ajax_settings`, `notification_settings`, `forum_show_sigs`, `forum_autowatch`, `forum_quickreply`, `forum_cat_order`, `forum_tracker`, `pagination_style`) VALUES
(1, '21/12/1990', 0, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 0, NULL, NULL, 1),
(2, '00/00/0000', 0, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 0, NULL, NULL, 1);
