-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2011 at 05:50 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
('site', 'theme', 'darc'),
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
('site', 'google_analytics', ''),
('time', 'default_format', 'jS F h:ia'),
('time', 'dst', '1'),
('time', 'timezone', '0.0'),
('site', 'theme_override', '1'),
('user', 'username_change', '0'),
('login', 'max_login_tries', '8'),
('login', 'remember_me', '1'),
('login', 'max_whitelist', '5'),
('rss', 'global_limit', '15'),
('forum', 'news_category', '2'),
('forum', 'sortable_categories', '0'),
('ajax', 'settings', 'forum_eip,forum_sortables'),
('site', 'smilie_pack', 'default'),
('email', 'E_LOGIN_ATTEMPTS', 'Hello {USERNAME},\r\n\r\nWe''ve become aware of somebody, if not yourself, trying to login to your account with incorrect details.\r\n\r\nYour account has been locked for security purposes.\r\n\r\nTo Reactivate your account, please click the link below, or copy and paste it into your address bar.\r\n\r\n[url]{URL}[/url]\r\n\r\n~{SITE_NAME}'),
('login', 'lockout_time', '15'),
('site', 'internetCalls', '0'),
('login', 'ip_lock', '0'),
('forum', 'guest_restriction', '0'),
('email', 'E_USER_POSTED', 'Hello {USERNAME},\r\n\r\n{AUTHOR} has posted a reply to [b]{THREAD_NAME}[/b]. This was posted at {TIME}.\r\n\r\nYou can view the topic by visiting the following URL: [url]{THREAD_URL}[/url].\r\n\r\n~{SITE_NAME}'),
('forum', 'post_edit_time', '3600');

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

--
-- Dumping data for table `cscms_forum_auth`
--

INSERT INTO `cscms_forum_auth` (`group_id`, `cat_id`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_del`, `auth_move`, `auth_special`, `auth_mod`) VALUES
(4, 15, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 12, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 13, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 6, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 8, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 9, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 14, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 4, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 10, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 11, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 12, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 8, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 9, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 10, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 11, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(6, 14, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 16, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 12, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 13, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 6, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 8, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 9, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 14, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 10, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 11, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 16, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 15, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(7, 15, 1, 1, 1, 1, 1, 1, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cscms_forum_cats`
--

INSERT INTO `cscms_forum_cats` (`id`, `parent_id`, `title`, `desc`, `order`, `last_post_id`, `postcounts`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_del`, `auth_move`, `auth_special`, `auth_mod`) VALUES
(1, 0, 'General', NULL, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 'Suggestions, Ideas and Feedback', 'A dedicated place to discuss all the suggestions, ideas and give feedback.', 2, 3, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(3, 1, 'Introductions', 'Introduce yourself to the rest of the community.', 1, 2, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(4, 1, 'Lounge', 'A place to talk about anything and everything.', 3, 0, 1, 1, 1, 1, 1, 1, 3, 3, 3, 0),
(5, 0, 'Community Projects', NULL, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 5, 'Project Talk', 'Push your ideas for community projects here.', 1, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(7, 0, 'Cybershade CMS', NULL, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 7, 'Core Development', 'Talk about the core CMS development here.', 1, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(9, 7, 'Modules', 'Get help with your module development here.', 2, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(10, 7, 'Plugins / Hooks', 'Hooks allow you to expand the funcitonality of the core without disrupting the internal code.', 3, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(11, 7, 'Themes and Templates', 'Unsure how the override system works? or how to setup your theme? Ask Here.', 4, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 0),
(12, 4, 'Programmer''s Lounge', 'A place to talk 1''s and 0''s', 0, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 3),
(13, 4, 'Designer''s Lounge', 'Creative conversation at its best.', 0, 0, 1, 0, 0, 1, 1, 1, 3, 3, 3, 3),
(14, 5, 'CScreenie', 'Screenshot program written by [user]Biber[/user] to help make Dev''s lives easier with screenshotting. \r\n[url]http://cscreenie.sourceforge.net/[/url]', 2, 0, 1, 0, 0, 1, 1, 1, 1, 3, 3, 3),
(15, 1, 'Staff Hangout', 'Place for Staff to talk etc', 4, 0, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3),
(16, 7, 'Support', 'Use this forum for getting support on a new install. [b]WARNING[/b]: We will not support installations that have had their core edited.', 5, 0, 1, 0, 0, 1, 1, 1, 1, 3, 3, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cscms_forum_posts`
--

INSERT INTO `cscms_forum_posts` (`id`, `thread_id`, `author`, `post`, `timestamp`, `poster_ip`, `edited`, `edited_uid`) VALUES
(1, 1, 11, 'testing 123 etc\r\n[code=''python'']\r\nprint(''Hi'')\r\n[/code]\r\n[h3]test[/h3]\r\n', 1311651634, '180.181.105.33', 0, 0),
(2, 1, 1, 'test reply, now with edit test too :)', 1311652786, '86.25.34.38', 1, 1),
(3, 2, 11, '[list]\r\n[*]Fancy dropdown boxes don''t disappear after selecting an option in Chromium\r\n[*]Trying to edit a post, upon submission leads to a CMS 404 error\r\n[*]Image tags when previewed don''t resize and fuck up the whole pages formatting\r\n[*]Forum dropdown switcher is white text on a white background, thus options are not visible.\r\n[*]Update PIN checkbox in the UCP, sometimes hides the PIN update fields upon ticking. The opposite of what it should do.\r\n[*]Invalid HTML5 etc, mainly because of the font tag being used where CSS should be used instead.\r\n[*]I don''t like the site menu at the top, the black on black buttons just seems awful imo.\r\n[/list]', 1311653872, '180.181.105.33', 0, 0);

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
  `last_uid` int(11) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) NOT NULL DEFAULT '0',
  `mode` int(1) NOT NULL DEFAULT '0',
  `views` int(1) NOT NULL DEFAULT '0',
  `old_cat_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cscms_forum_threads`
--

INSERT INTO `cscms_forum_threads` (`id`, `cat_id`, `author`, `subject`, `timestamp`, `first_post_id`, `last_uid`, `locked`, `mode`, `views`, `old_cat_id`) VALUES
(1, 3, 11, 'harro', 1311651634, 1, 1, 0, 0, 6, 0),
(2, 2, 11, 'CMS issues', 1311653872, 3, 11, 0, 0, 18, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cscms_forum_watch`
--


-- --------------------------------------------------------

--
-- Table structure for table `cscms_groups`
--

CREATE TABLE IF NOT EXISTS `cscms_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin,
  `moderator` int(11) unsigned NOT NULL DEFAULT '0',
  `single_user_group` tinyint(1) NOT NULL DEFAULT '1',
  `color` varchar(20) COLLATE utf8_bin NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cscms_groups`
--

INSERT INTO `cscms_groups` (`id`, `type`, `name`, `description`, `moderator`, `single_user_group`, `color`, `order`) VALUES
(1, 1, 'Admin', 'Site Administrator', 1, 1, '#ff0000', 1),
(2, 1, 'Mods', 'Site Moderator', 1, 0, '#146eca', 3),
(3, 0, 'Users', 'Registered User', 1, 0, '#3b3b3b', 10),
(4, 1, 'Staff', 'Cybershade Staff', 1, 0, '#004577', 2),
(5, 1, 'Developers', 'Developer Crew', 1, 0, '#FF8040', 2),
(6, 1, '', 'Personal User', 4, 1, '', 255),
(7, 1, '', 'Personal User', 7, 1, '', 255);

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

--
-- Dumping data for table `cscms_group_subs`
--

INSERT INTO `cscms_group_subs` (`uid`, `gid`, `pending`) VALUES
(8, 3, 0),
(2, 3, 0),
(3, 3, 0),
(4, 3, 0),
(5, 3, 0),
(6, 3, 0),
(7, 3, 0),
(1, 3, 0),
(9, 3, 0),
(10, 3, 0),
(11, 3, 0),
(12, 3, 0),
(13, 3, 0),
(14, 3, 0),
(15, 3, 0),
(16, 3, 0),
(17, 3, 0),
(18, 3, 0),
(19, 3, 0),
(20, 3, 0),
(21, 3, 0),
(22, 3, 0),
(23, 3, 0),
(24, 3, 0),
(25, 3, 0),
(26, 3, 0),
(27, 3, 0),
(28, 3, 0),
(29, 3, 0),
(30, 3, 0),
(31, 3, 0),
(32, 3, 0),
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(2, 5, 0),
(2, 4, 0),
(8, 4, 0),
(6, 4, 0),
(7, 4, 0),
(4, 4, 0),
(3, 4, 0),
(8, 1, 0),
(8, 5, 0),
(10, 4, 0),
(10, 5, 0),
(9, 2, 0),
(4, 6, 0),
(11, 4, 0),
(11, 2, 0),
(4, 2, 0),
(16, 3, 0),
(17, 3, 0),
(18, 3, 0),
(19, 3, 0),
(7, 7, 0),
(20, 3, 0),
(5, 5, 0),
(5, 4, 0),
(21, 3, 0),
(22, 3, 0),
(23, 3, 0),
(24, 3, 0),
(25, 3, 0),
(26, 3, 0),
(27, 3, 0),
(28, 3, 0),
(29, 3, 0),
(30, 3, 0),
(31, 3, 0),
(32, 3, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=867 ;


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
  `perms` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cscms_menu_blocks`
--

INSERT INTO `cscms_menu_blocks` (`id`, `unique_id`, `module`, `function`, `position`, `perms`) VALUES
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cscms_modules`
--

INSERT INTO `cscms_modules` (`id`, `name`, `enabled`, `hash`) VALUES
(1, 'forum', 1, '7f23addd6b9d4aef7b21d6e07f029988');

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
  `read` int(11) NOT NULL DEFAULT '0',
  `module` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `module_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cscms_notifications`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=240 ;

--
-- Dumping data for table `cscms_online`
--

INSERT INTO `cscms_online` (`id`, `uid`, `username`, `ip_address`, `timestamp`, `hidden`, `location`, `referer`, `language`, `useragent`, `login_attempts`, `login_time`, `userkey`, `mode`) VALUES
(233, 1, 'xLink', '127.0.0.1', 1312129062, 0, '/cms/test.php', 'null', 'en', 'Firefox', 0, 0, '9401b4b3107957c388558c4cdcb85847', 'active');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cscms_plugins`
--

INSERT INTO `cscms_plugins` (`id`, `name`, `filePath`, `author`, `priority`, `enabled`) VALUES
(1, 'recaptcha', './plugins/cscms/hook.recaptcha.php', 'xLink', '2', 1),
(2, 'pageLoad', './plugins/cscms/hook.footer.php', 'xLink', '2', 1),
(3, 'mixpanel', './plugins/cscms/hook.mixpanel.php', 'xLink', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cscms_sqlerrors`
--

CREATE TABLE IF NOT EXISTS `cscms_sqlerrors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `query` text CHARACTER SET latin1,
  `page` text CHARACTER SET latin1,
  `vars` text CHARACTER SET latin1,
  `error` text CHARACTER SET latin1,
  `lineInfo` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=578 ;

--
-- Dumping data for table `cscms_sqlerrors`
--

INSERT INTO `cscms_sqlerrors` (`id`, `uid`, `date`, `query`, `page`, `vars`, `error`, `lineInfo`) VALUES
(1, 0, 1311447322, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1311447322'', ''/cms/'', '''', ''en'', ''Firefox'', ''fa19aeeaa942731ba7fd441be646e1eb'')', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Duplicate entry ''fa19aeeaa942731ba7fd441be646e1eb'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(2, 1, 1311447323, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(3, 1, 1311447348, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/user/', 'a:2:{s:3:"get";a:1:{s:6:"__mode";s:4:"user";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(4, 0, 1311448233, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(5, 0, 1311448701, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(6, 1, 1311451262, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(7, 1, 1311451264, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(8, 1, 1311451280, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(9, 1, 1311451286, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(10, 1, 1311451464, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(11, 1, 1311451478, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(12, 1, 1311451566, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(13, 1, 1311451583, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(14, 1, 1311451595, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(15, 1, 1311451650, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(16, 1, 1311451669, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(17, 1, 1311451680, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(18, 1, 1311451693, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(19, 1, 1311451848, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(20, 1, 1311451857, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(21, 1, 1311451873, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(22, 1, 1311452175, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(23, 1, 1311452435, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(24, 1, 1311452453, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(25, 1, 1311452597, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(26, 1, 1311452819, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(27, 1, 1311452823, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(28, 1, 1311452970, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(29, 1, 1311453253, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(30, 1, 1311453401, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(31, 1, 1311453402, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(32, 1, 1311453404, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(33, 0, 1311453429, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(34, 0, 1311507297, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(35, 0, 1311507770, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(36, 0, 1311507789, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(37, 0, 1311508002, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(38, 0, 1311508262, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(39, 0, 1311513887, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(40, 1, 1311513957, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(41, 1, 1311514112, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(42, 1, 1311514126, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(43, 1, 1311514977, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(44, 1, 1311515000, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(45, 1, 1311515807, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(46, 1, 1311516150, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(47, 1, 1311516200, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(48, 1, 1311516224, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(49, 1, 1311516737, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(50, 1, 1311516779, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(51, 1, 1311516923, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(52, 1, 1311517055, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(53, 1, 1311517067, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(54, 1, 1311517073, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(55, 1, 1311517212, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(56, 1, 1311517245, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(57, 1, 1311517605, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(58, 1, 1311517616, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(59, 1, 1311517657, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(60, 1, 1311517667, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(61, 1, 1311518408, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(62, 1, 1311518448, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(63, 1, 1311518508, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(64, 0, 1311520619, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(65, 0, 1311520626, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(66, 0, 1311520660, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(67, 0, 1311520669, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(68, 0, 1311520688, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(69, 0, 1311520709, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(70, 1, 1311524999, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(71, 0, 1311525117, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(72, 0, 1311525177, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(73, 0, 1311525181, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(74, 2, 1311525186, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(75, 9, 1311525187, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(76, 9, 1311525190, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(77, 1, 1311525322, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(78, 2, 1311525378, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(79, 2, 1311525386, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(80, 2, 1311525390, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(81, 1, 1311525473, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(82, 1, 1311525476, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(83, 1, 1311525620, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(84, 1, 1311525953, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(85, 2, 1311525996, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(86, 0, 1311526017, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(87, 9, 1311526028, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(88, 9, 1311526032, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(89, 9, 1311526075, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306342032"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(90, 1, 1311526102, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(91, 0, 1311526436, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(92, 8, 1311526451, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(93, 8, 1311526504, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(94, 8, 1311526523, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(95, 8, 1311526607, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(96, 8, 1311527034, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(97, 8, 1311527244, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(98, 8, 1311527256, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(99, 1, 1311527314, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(100, 1, 1311527411, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306343314"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(101, 9, 1311527552, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(102, 9, 1311527555, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306343552"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(103, 1, 1311527721, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306343411"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(104, 1, 1311527740, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306343721"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(105, 1, 1311527764, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(106, 1, 1311527835, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(107, 1, 1311527879, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(108, 1, 1311527946, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(109, 1, 1311528043, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(110, 1, 1311528064, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(111, 1, 1311528110, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(112, 1, 1311528125, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(113, 1, 1311528180, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(114, 1, 1311528196, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(115, 1, 1311528212, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(116, 1, 1311528270, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(117, 1, 1311528396, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(118, 1, 1311529260, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/user/', 'a:2:{s:3:"get";a:1:{s:6:"__mode";s:4:"user";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(119, 0, 1311529554, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(120, 1, 1311539233, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(121, 1, 1311539238, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(122, 1, 1311539279, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(123, 1, 1311539288, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(124, 1, 1311539309, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(125, 1, 1311539320, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(126, 1, 1311539667, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(127, 0, 1311544976, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(128, 0, 1311544990, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(129, 0, 1311545203, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(130, 0, 1311545222, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(131, 0, 1311545225, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(132, 1, 1311545237, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(133, 1, 1311545260, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(134, 1, 1311545263, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(135, 1, 1311545350, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(136, 1, 1311545417, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(137, 1, 1311545641, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(138, 0, 1311545657, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(139, 0, 1311547703, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(140, 0, 1311554309, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(141, 0, 1311557415, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(142, 0, 1311557427, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(143, 0, 1311557541, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(144, 1, 1311603825, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(145, 0, 1311604167, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/user/core/general/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:4:"user";s:8:"__module";s:4:"core";s:8:"__action";s:8:"general/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(146, 0, 1311604810, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/user/core/general/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:4:"user";s:8:"__module";s:4:"core";s:8:"__action";s:8:"general/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(147, 0, 1311604836, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(148, 0, 1311604838, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/register.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(149, 0, 1311604856, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/register.php?', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(150, 10, 1311604886, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(151, 0, 1311625100, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1311625100'', ''/cms/'', ''null'', ''en'', ''Firefox'', ''86cfc5eca7bd31bf32737abf4c7d95a6'')', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Duplicate entry ''86cfc5eca7bd31bf32737abf4c7d95a6'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(152, 1, 1311625102, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(153, 0, 1311637181, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(154, 0, 1311647859, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(155, 0, 1311648228, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/core/settings/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:4:"core";s:8:"__action";s:9:"settings/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(156, 0, 1311648242, 'SELECT u.*, e.*, u.id as id, o.timestamp, o.hidden, o.userkey FROM `cscms_users` u LEFT JOIN `cscms_user_extras` e ON u.id = e.uid LEFT JOIN `cscms_online` o ON u.id = o.uid WHERE upper( u.username ) = upper( xLink )  LIMIT 1;', '/cms/login.php?action=check', 'a:2:{s:3:"get";a:1:{s:6:"action";s:5:"check";}s:4:"post";a:5:{s:8:"username";s:5:"xLink";s:8:"password";s:4:"test";s:8:"remember";s:1:"0";s:6:"submit";s:5:"Login";s:4:"hash";s:32:"41baa31ce46bd373701c36365947e9d2";}}', 'Unknown column ''xLink'' in ''where clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(157, 0, 1311648263, 'SELECT u.*, e.*, u.id as id, o.timestamp, o.hidden, o.userkey FROM `cscms_users` u LEFT JOIN `cscms_user_extras` e ON u.id = e.uid LEFT JOIN `cscms_online` o ON u.id = o.uid WHERE upper( u.username ) = upper( xlink )  LIMIT 1;', '/cms/login.php?action=check', 'a:2:{s:3:"get";a:1:{s:6:"action";s:5:"check";}s:4:"post";a:5:{s:8:"username";s:5:"xlink";s:8:"password";s:4:"test";s:8:"remember";s:1:"0";s:6:"submit";s:5:"Login";s:4:"hash";s:32:"2a65758b75c91017486b2ddca3ea2114";}}', 'Unknown column ''xlink'' in ''where clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(158, 0, 1311648278, 'SELECT u.*, e.*, u.id as id, o.timestamp, o.hidden, o.userkey FROM `cscms_users` u LEFT JOIN `cscms_user_extras` e ON u.id = e.uid LEFT JOIN `cscms_online` o ON u.id = o.uid WHERE upper( u.username ) = upper( xlink )  LIMIT 1;', '/cms/login.php?action=check', 'a:2:{s:3:"get";a:1:{s:6:"action";s:5:"check";}s:4:"post";a:5:{s:8:"username";s:5:"xlink";s:8:"password";s:4:"1234";s:8:"remember";s:1:"0";s:6:"submit";s:5:"Login";s:4:"hash";s:32:"b5522fb1771cac17ffbcc9c905927e53";}}', 'Unknown column ''xlink'' in ''where clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430');
INSERT INTO `cscms_sqlerrors` (`id`, `uid`, `date`, `query`, `page`, `vars`, `error`, `lineInfo`) VALUES
(159, 0, 1311648314, 'SELECT u.*, e.*, u.id as id, o.timestamp, o.hidden, o.userkey FROM `cscms_users` u LEFT JOIN `cscms_user_extras` e ON u.id = e.uid LEFT JOIN `cscms_online` o ON u.id = o.uid WHERE upper( u.username ) = upper( xlink )  LIMIT 1;', '/cms/login.php?action=check', 'a:2:{s:3:"get";a:1:{s:6:"action";s:5:"check";}s:4:"post";a:5:{s:8:"username";s:5:"xlink";s:8:"password";s:4:"test";s:8:"remember";s:1:"0";s:6:"submit";s:5:"Login";s:4:"hash";s:32:"68477a6574e08e010dffc0fb4c42e89b";}}', 'Unknown column ''xlink'' in ''where clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(160, 1, 1311648418, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(161, 1, 1311648550, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/login.php?action=logout&check=cj6v22', 'a:2:{s:3:"get";a:2:{s:6:"action";s:6:"logout";s:5:"check";s:6:"cj6v22";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(162, 0, 1311648550, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(163, 1, 1311648781, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(164, 0, 1311650113, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/core/settings/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:4:"core";s:8:"__action";s:9:"settings/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(165, 1, 1311650118, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(166, 0, 1311651720, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(167, 1, 1311651983, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(168, 1, 1311652349, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(169, 1, 1311652350, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(170, 0, 1311652784, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(171, 0, 1311652786, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(172, 0, 1311652842, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(173, 0, 1311652843, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(174, 0, 1311652940, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(175, 0, 1311652941, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(176, 1, 1311697200, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(177, 0, 1311701577, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(178, 0, 1311718231, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(179, 0, 1311758413, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(180, 0, 1311758416, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(181, 0, 1311768946, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(182, 1, 1311769365, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(183, 0, 1311775424, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(184, 0, 1311775425, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(185, 0, 1311775426, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(186, 1, 1311775580, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(187, 1, 1311775713, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591580"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(188, 1, 1311775718, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591713"', '/cms/modules/forum/introductions-3/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:16:"introductions-3/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(189, 1, 1311775720, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591718"', '/cms/modules/forum/thread/harro-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(190, 1, 1311775720, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591720"', '/cms/modules/forum/thread/harro-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(191, 0, 1311775722, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(192, 0, 1311775723, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(193, 1, 1311775749, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591720"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(194, 1, 1311775783, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591749"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(195, 1, 1311775803, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591783"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(196, 1, 1311813955, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(197, 1, 1311813958, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(198, 1, 1311813961, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306591803"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(199, 1, 1311813963, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306629961"', '/cms/modules/forum/suggestions-ideas-and-feedback-2/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:33:"suggestions-ideas-and-feedback-2/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(200, 1, 1311813965, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306629963"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(201, 1, 1311813966, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306629965"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(202, 1, 1311814481, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(203, 0, 1311815204, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(204, 1, 1311815230, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(205, 1, 1311815232, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306629966"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(206, 1, 1311815251, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(207, 1, 1311815254, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631232"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(208, 1, 1311815480, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631254"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(209, 0, 1311815484, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(210, 0, 1311815487, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(211, 1, 1311815546, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631480"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(212, 0, 1311815568, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(213, 1, 1311815616, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631546"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(214, 0, 1311815621, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(215, 1, 1311815660, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631616"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(216, 0, 1311815668, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(217, 0, 1311815677, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(218, 0, 1311815697, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(219, 1, 1311815734, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306631660"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(220, 0, 1311877146, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(221, 1, 1311877155, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(222, 1, 1311877180, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(223, 1, 1311877305, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693180"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(224, 1, 1311877308, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693305"', '/cms/modules/forum/thread/harro-1.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(225, 0, 1311877309, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(226, 0, 1311877310, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(227, 1, 1311877342, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693308"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(228, 1, 1311877365, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693342"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(229, 1, 1311877503, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693365"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(230, 1, 1311877512, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693503"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(231, 1, 1311877721, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693512"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(232, 1, 1311877848, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693721"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(233, 1, 1311877868, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693848"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(234, 1, 1311877899, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693868"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(235, 1, 1311877940, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693899"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(236, 1, 1311877969, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693940"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(237, 1, 1311878070, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306693969"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(238, 1, 1311878168, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694070"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(239, 1, 1311878439, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694168"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(240, 1, 1311878574, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:4:{s:2:"id";s:1:"2";s:6:"sessid";s:34:"$J$BjzFtlywTqVOKwtQA4ElVfJAqQuO7N1";s:4:"post";s:30:"test reply, and now edit it :D";s:6:"submit";s:6:"Submit";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(241, 1, 1311878578, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694439"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(242, 1, 1311878631, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694578"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(243, 1, 1311878656, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694631"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:4:{s:2:"id";s:1:"2";s:6:"sessid";s:34:"$J$BH0.8rMscuEyqZ6wz5GNdJOaGteJdH/";s:4:"post";s:37:"test reply, now with edit test too :)";s:6:"submit";s:6:"Submit";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(244, 1, 1311878656, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694656"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(245, 0, 1311878658, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(246, 0, 1311878659, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(247, 1, 1311878825, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694656"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(248, 0, 1311878827, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(249, 0, 1311878828, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(250, 1, 1311878953, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694825"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(251, 0, 1311878955, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(252, 0, 1311878956, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(253, 1, 1311878958, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694953"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(254, 0, 1311878959, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(255, 0, 1311878961, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(256, 1, 1311879027, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306694958"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(257, 0, 1311879029, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(258, 0, 1311879030, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(259, 1, 1311879100, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695027"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(260, 0, 1311879102, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(261, 0, 1311879103, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(262, 1, 1311879130, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695100"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(263, 0, 1311879131, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(264, 0, 1311879132, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(265, 1, 1311879147, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695130"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(266, 0, 1311879148, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(267, 0, 1311879149, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(268, 1, 1311879193, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695147"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(269, 0, 1311879194, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(270, 0, 1311879195, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(271, 1, 1311879292, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695193"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(272, 0, 1311879293, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(273, 0, 1311879294, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(274, 1, 1311879331, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695292"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(275, 0, 1311879332, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(276, 0, 1311879334, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(277, 1, 1311879362, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695331"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(278, 0, 1311879364, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(279, 0, 1311879365, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(280, 1, 1311879411, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695362"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(281, 0, 1311879412, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(282, 0, 1311879413, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(283, 1, 1311879466, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695411"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(284, 0, 1311879468, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(285, 0, 1311879469, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(286, 1, 1311883570, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(287, 1, 1311883570, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306695466"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(288, 0, 1311883572, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430');
INSERT INTO `cscms_sqlerrors` (`id`, `uid`, `date`, `query`, `page`, `vars`, `error`, `lineInfo`) VALUES
(289, 0, 1311883573, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(290, 1, 1311884052, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306699570"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(291, 0, 1311884052, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(292, 0, 1311884053, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(293, 1, 1311884060, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306700052"', '/cms/modules/forum/thread/harro-1.html?mode=edit&postid=2', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"forum";s:8:"__action";s:14:"thread/harro-1";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"edit";s:6:"postid";s:1:"2";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(294, 1, 1311884064, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306700060"', '/cms/modules/forum/thread/-1.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:9:"thread/-1";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(295, 0, 1311884064, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(296, 0, 1311884065, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(297, 0, 1311988612, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(298, 0, 1311990340, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(299, 0, 1311990368, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(300, 1, 1311990410, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(301, 1, 1311990534, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(302, 1, 1311990540, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/pm/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:2:"pm";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(303, 1, 1311990545, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(304, 1, 1311990550, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(305, 1, 1311990591, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306806550"', '/cms/modules/forum/suggestions-ideas-and-feedback-2/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:33:"suggestions-ideas-and-feedback-2/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(306, 1, 1311990597, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306806591"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(307, 1, 1311990617, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306806597"', '/cms/modules/forum/thread/cms-issues-2.html?mode=move', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:4:"move";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(308, 1, 1311990620, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306806617"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(309, 1, 1311990643, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(310, 1, 1311990649, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:5:"view/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(311, 1, 1311991283, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(312, 1, 1311991287, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(313, 1, 1311991291, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(314, 1, 1311991295, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/setup/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:6:"setup/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(315, 1, 1311991335, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(316, 0, 1311991607, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(317, 1, 1311992648, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(318, 1, 1311992648, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(319, 1, 1311992657, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(320, 1, 1311992658, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(321, 1, 1311998525, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306806620"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(322, 0, 1312039900, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(323, 0, 1312040243, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(324, 1, 1312040262, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(325, 1, 1312040271, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(326, 1, 1312040550, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(327, 1, 1312050864, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(328, 1, 1312050867, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(329, 1, 1312050879, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306866867"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(330, 1, 1312051146, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306866879"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(331, 1, 1312052401, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306867146"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(332, 1, 1312052500, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306868401"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(333, 1, 1312052527, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306868500"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(334, 1, 1312053068, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306868527"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(335, 1, 1312053121, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306869068"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(336, 1, 1312053203, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306869121"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(337, 1, 1312053222, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306869203"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(338, 1, 1312054044, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306869222"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(339, 1, 1312054134, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870044"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(340, 1, 1312054170, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870134"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(341, 1, 1312054185, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870170"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(342, 1, 1312054197, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870185"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(343, 1, 1312054250, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870197"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(344, 1, 1312054260, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870250"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:57:"[img]http://imgcafe.com/view/uploads/breakingba.jpg[/img]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(345, 1, 1312054342, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870260"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(346, 1, 1312054546, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870342"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:666:"[quote=LK-]\n[list]\n[-]Fancy dropdown boxes don''t disappear after selecting an option in Chromium\n[-]Trying to edit a post, upon submission leads to a CMS 404 error\n[-]Image tags when previewed don''t resize and fuck up the whole pages formatting\n[-]Forum dropdown switcher is white text on a white background, thus options are not visible.\n[-]Update PIN checkbox in the UCP, sometimes hides the PIN update fields upon ticking. The opposite of what it should do.\n[*]Invalid HTML5 etc, mainly because of the font tag being used where CSS should be used instead.\n[*]I don''t like the site menu at the top, the black on black buttons just seems awful imo.\n[/list]\n[/quote]";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(347, 0, 1312055045, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(348, 0, 1312055047, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(349, 0, 1312055058, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(350, 0, 1312055059, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(351, 0, 1312055153, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(352, 0, 1312055155, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(353, 0, 1312055181, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(354, 0, 1312055182, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(355, 0, 1312055211, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(356, 0, 1312055212, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(357, 0, 1312055225, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(358, 0, 1312055226, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(359, 0, 1312055249, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(360, 0, 1312055250, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(361, 0, 1312055285, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(362, 0, 1312055286, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(363, 1, 1312055410, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306870546"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(364, 1, 1312055436, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871410"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(365, 1, 1312055446, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871436"', '/cms/modules/forum/ajax/eip.php?action=load&id=3&editorId=post_id_3', 'a:2:{s:3:"get";a:6:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"ajax/eip";s:7:"__extra";s:4:".php";s:6:"action";s:4:"load";s:2:"id";s:1:"3";s:8:"editorId";s:9:"post_id_3";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(366, 1, 1312055452, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871446"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(367, 1, 1312055456, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871452"', '/cms/modules/forum/ajax/eip.php?action=load&id=3&editorId=post_id_3', 'a:2:{s:3:"get";a:6:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"ajax/eip";s:7:"__extra";s:4:".php";s:6:"action";s:4:"load";s:2:"id";s:1:"3";s:8:"editorId";s:9:"post_id_3";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(368, 1, 1312055623, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871456"', '/cms/modules/forum/thread/cms-issues-2.html?mode=last_page', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:9:"last_page";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(369, 1, 1312055627, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871623"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(370, 1, 1312055663, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871627"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(371, 1, 1312055668, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:6:{s:2:"id";s:1:"2";s:6:"sessid";s:34:"$J$BHVOMfqjFxeLUg.U7A3O5jE9XXOPOP1";s:1:"x";s:2:"10";s:1:"y";s:1:"8";s:4:"post";s:0:"";s:12:"watch_thread";s:0:"";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(372, 1, 1312055670, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871663"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(373, 1, 1312055673, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:6:{s:2:"id";s:1:"2";s:6:"sessid";s:34:"$J$Bvg.7Nq9pARg8qyrJN3haRK6OaHRLX0";s:4:"post";s:0:"";s:12:"watch_thread";s:0:"";s:1:"x";s:2:"11";s:1:"y";s:1:"9";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(374, 1, 1312055675, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871670"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(375, 1, 1312055677, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871675"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(376, 1, 1312055745, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:6:{s:2:"id";s:1:"2";s:6:"sessid";s:34:"$J$BgSAJGwVjMDfB9l5YhQZuNd/fnPqj2.";s:4:"post";s:0:"";s:12:"watch_thread";s:0:"";s:1:"x";s:2:"18";s:1:"y";s:1:"9";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(377, 1, 1312055747, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871677"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(378, 1, 1312056143, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(379, 1, 1312056167, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(380, 1, 1312056742, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(381, 1, 1312056792, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(382, 1, 1312057083, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(383, 1, 1312057083, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(384, 1, 1312057142, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(385, 1, 1312057142, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(386, 1, 1312057146, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(387, 1, 1312057155, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(388, 1, 1312057155, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(389, 1, 1312057197, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(390, 1, 1312057198, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(391, 1, 1312057287, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(392, 1, 1312057287, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(393, 1, 1312057290, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(394, 1, 1312057290, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(395, 1, 1312057301, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(396, 1, 1312057301, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(397, 1, 1312057399, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(398, 1, 1312057399, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(399, 1, 1312057453, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(400, 1, 1312057453, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(401, 1, 1312057480, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(402, 1, 1312057480, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(403, 1, 1312057925, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(404, 1, 1312057979, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="15"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(405, 1, 1312057979, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(406, 1, 1312058038, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(407, 1, 1312058041, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(408, 1, 1312058051, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/?save', 'a:2:{s:3:"get";a:5:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";s:4:"save";s:0:"";}s:4:"post";a:3:{s:13:"news_category";s:1:"2";s:9:"sortables";s:1:"0";s:6:"submit";s:6:"Submit";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(409, 1, 1312058055, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(410, 1, 1312058065, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="2"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(411, 1, 1312058065, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(412, 1, 1312058069, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306871747"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(413, 1, 1312058089, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n				ON p.id = t.topic_post_id\n				\n				WHERE t.cat_id ="2"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.topic_post_id'' in ''on clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(414, 1, 1312058089, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(415, 1, 1312058119, 'SELECT t.*, p.post as post\n				FROM `cscms_forum_threads` t\n				\n				LEFT JOIN `cscms_forum_posts` p\n					ON p.id = t.first_post_id\n				\n				WHERE t.cat_id ="2"\n				GROUP BY t.id\n				ORDER BY t.posted DESC \n				LIMIT 4', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Unknown column ''t.posted'' in ''order clause''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(416, 1, 1312058119, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456');
INSERT INTO `cscms_sqlerrors` (`id`, `uid`, `date`, `query`, `page`, `vars`, `error`, `lineInfo`) VALUES
(417, 1, 1312058141, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(418, 1, 1312058191, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(419, 1, 1312058206, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(420, 1, 1312058324, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(421, 1, 1312058348, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(422, 1, 1312058381, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(423, 1, 1312058390, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(424, 1, 1312058423, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(425, 1, 1312058434, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(426, 1, 1312062659, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(427, 1, 1312062702, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(428, 1, 1312062719, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(429, 1, 1312062743, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(430, 1, 1312062812, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(431, 1, 1312062849, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(432, 1, 1312063208, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(433, 1, 1312063236, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(434, 1, 1312063247, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(435, 1, 1312063866, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(436, 1, 1312063955, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(437, 1, 1312063999, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(438, 1, 1312064042, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(439, 1, 1312064056, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(440, 1, 1312064114, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(441, 1, 1312064127, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(442, 1, 1312064151, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(443, 1, 1312064228, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(444, 1, 1312064268, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(445, 1, 1312064332, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(446, 1, 1312064341, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(447, 1, 1312064376, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(448, 1, 1312064404, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(449, 1, 1312064418, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(450, 1, 1312064454, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(451, 1, 1312064470, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(452, 1, 1312064517, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(453, 1, 1312064523, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(454, 1, 1312064570, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(455, 1, 1312064587, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(456, 1, 1312064660, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(457, 1, 1312064703, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(458, 1, 1312064708, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(459, 1, 1312064749, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(460, 1, 1312064773, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(461, 1, 1312064854, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(462, 1, 1312064885, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(463, 1, 1312064913, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(464, 1, 1312064943, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(465, 1, 1312064966, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(466, 1, 1312064996, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(467, 1, 1312065017, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(468, 1, 1312065028, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(469, 0, 1312065028, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065028'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''5b27f7dedafd9a06b66fce2a1df49d61'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''5b27f7dedafd9a06b66fce2a1df49d61'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(470, 1, 1312065255, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(471, 0, 1312065259, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065259'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''4dbeb3e6ed1370b803cc7a3cc9703d1c'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''4dbeb3e6ed1370b803cc7a3cc9703d1c'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(472, 1, 1312065282, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(473, 0, 1312065285, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065285'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''a2d54381a4eb8acc1e7f3bdcfd3154c9'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''a2d54381a4eb8acc1e7f3bdcfd3154c9'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(474, 1, 1312065328, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(475, 0, 1312065332, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065332'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''15276062abf74e2df679a982d7ccf7e4'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''15276062abf74e2df679a982d7ccf7e4'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(476, 1, 1312065396, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(477, 0, 1312065400, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065400'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''c31e28b316cb7e3981634d5830b7000d'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''c31e28b316cb7e3981634d5830b7000d'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(478, 1, 1312065543, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(479, 0, 1312065546, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065546'', ''/cms/modules/forum/scripts/forum.js'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''22d986f516dc60fbf58101cfd8c7030a'')', '/cms/modules/forum/scripts/forum.js', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:13:"scripts/forum";s:7:"__extra";s:3:".js";}s:4:"post";a:0:{}}', 'Duplicate entry ''22d986f516dc60fbf58101cfd8c7030a'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(480, 0, 1312065571, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(481, 1, 1312065572, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(482, 0, 1312065575, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312065575'', ''/cms/scripts/user.js.php'', ''http://localhost/cms/modules/forum/thread/cms-issues-2.html'', ''en'', ''Firefox'', ''ef0adf692246a6b1e0314f29ce5ca068'')', '/cms/scripts/user.js.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Duplicate entry ''ef0adf692246a6b1e0314f29ce5ca068'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(483, 0, 1312065634, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(484, 0, 1312065649, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(485, 1, 1312065664, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(486, 0, 1312065669, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(487, 1, 1312065690, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(488, 1, 1312065700, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(489, 1, 1312065734, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(490, 1, 1312065779, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(491, 1, 1312065820, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(492, 1, 1312066011, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(493, 1, 1312066031, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(494, 1, 1312066081, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(495, 1, 1312066146, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(496, 1, 1312066198, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(497, 1, 1312066228, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(498, 1, 1312066297, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(499, 1, 1312066297, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(500, 1, 1312066307, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(501, 1, 1312066966, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(502, 1, 1312066988, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(503, 1, 1312067049, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(504, 1, 1312067588, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(505, 1, 1312067598, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(506, 1, 1312067608, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(507, 1, 1312067620, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(508, 1, 1312067836, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(509, 1, 1312067848, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(510, 1, 1312067873, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(511, 1, 1312067904, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(512, 1, 1312067922, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(513, 1, 1312067956, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(514, 1, 1312068068, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(515, 1, 1312068086, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(516, 1, 1312068111, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884086"', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(517, 1, 1312068125, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884111"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(518, 1, 1312068199, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884125"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(519, 1, 1312068251, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884199"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(520, 1, 1312068271, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884251"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(521, 0, 1312068276, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(522, 1, 1312068353, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884271"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(523, 1, 1312068374, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884353"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(524, 1, 1312068412, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306884374"', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(525, 0, 1312072464, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(526, 0, 1312075976, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(527, 0, 1312076249, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(528, 0, 1312077211, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:1:{s:7:"payload";s:88:"{"target":"Insight_Plugin_Tester","action":"TestClient","args":{"time":"1312077210882"}}";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(529, 0, 1312077236, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:1:{s:7:"payload";s:88:"{"target":"Insight_Plugin_Tester","action":"TestClient","args":{"time":"1312077234974"}}";}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(530, 0, 1312077470, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(531, 1, 1312077669, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(532, 1, 1312077770, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(533, 1, 1312078046, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/config/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:7:"config/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(534, 1, 1312078054, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(535, 1, 1312078056, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/setup/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:6:"setup/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(536, 1, 1312078228, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/setup/edit/?id=1&mode=Edit', 'a:2:{s:3:"get";a:6:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:11:"setup/edit/";s:7:"__extra";s:0:"";s:2:"id";s:1:"1";s:4:"mode";s:4:"Edit";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(537, 1, 1312078232, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/admin/forum/setup/', 'a:2:{s:3:"get";a:4:{s:6:"__mode";s:5:"admin";s:8:"__module";s:5:"forum";s:8:"__action";s:6:"setup/";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(538, 0, 1312083568, 'UPDATE `cscms_users` u SET u.last_active =\r\n				(SELECT o.timestamp\r\n					FROM `cscms_online` o\r\n					WHERE o.uid = u.id)\r\n			WHERE EXISTS\r\n				(SELECT oo.timestamp\r\n					FROM `cscms_online` oo\r\n					WHERE oo.uid = u.id)', '/cms/modules/forum/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Subquery returns more than 1 row', 'D:\\Web Drive\\www\\cms\\core\\cron.php:49'),
(539, 0, 1312083580, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(540, 0, 1312085427, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(541, 0, 1312085473, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(542, 0, 1312097534, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(543, 0, 1312097626, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(544, 0, 1312101806, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(545, 0, 1312101860, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/profile/view/xLink', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:7:"profile";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(546, 0, 1312101863, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/index.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(547, 0, 1312101865, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/register.php', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(548, 0, 1312101892, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(549, 0, 1312104824, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(550, 0, 1312104835, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(551, 0, 1312104928, 'SELECT COUNT(*) as count FROM `cscms_comments` WHERE author = "1"', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_comments'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:430'),
(552, 0, 1312104930, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/sig/view/xLink.png', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:3:"sig";s:8:"__action";s:10:"view/xLink";s:7:"__extra";s:4:".png";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(553, 0, 1312106478, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(554, 0, 1312106488, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(555, 1, 1312113831, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(556, 1, 1312117142, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(557, 1, 1312117152, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306933142"', '/cms/modules/forum/thread/cms-issues-2.html?mode=reply', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:5:".html";s:4:"mode";s:5:"reply";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(558, 1, 1312117161, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306933152"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:0:"";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(559, 1, 1312117170, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306933161"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:0:"";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(560, 1, 1312117172, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= "1306933170"', '/cms/modules/forum/preview/?ajax', 'a:2:{s:3:"get";a:4:{s:8:"__module";s:5:"forum";s:8:"__action";s:8:"preview/";s:7:"__extra";s:0:"";s:4:"ajax";s:0:"";}s:4:"post";a:1:{s:8:"post_val";s:4:"rawr";}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(561, 0, 1312118208, 'INSERT HIGH_PRIORITY INTO `cscms_online` (`uid`, `username`, `ip_address`, `timestamp`, `location`, `referer`, `language`, `useragent`, `userkey`) VALUES (''0'', ''Guest'', ''127.0.0.1'', ''1312118208'', ''/cms/'', ''null'', ''en'', ''Firefox'', ''9401b4b3107957c388558c4cdcb85847'')', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Duplicate entry ''9401b4b3107957c388558c4cdcb85847'' for key ''userkey''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:505'),
(562, 1, 1312118209, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(563, 1, 1312119834, 'SELECT id, cat_id, last_poster FROM `cscms_forum_threads` WHERE last_poster >= ""', '/cms/modules/forum/thread/cms-issues-2.html.html', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"forum";s:8:"__action";s:19:"thread/cms-issues-2";s:7:"__extra";s:10:".html.html";}s:4:"post";a:0:{}}', 'Unknown column ''last_poster'' in ''field list''', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456');
INSERT INTO `cscms_sqlerrors` (`id`, `uid`, `date`, `query`, `page`, `vars`, `error`, `lineInfo`) VALUES
(564, 1, 1312119845, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(565, 1, 1312119883, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(566, 1, 1312120471, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/groups', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(567, 1, 1312120486, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/group/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"group";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(568, 1, 1312120761, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/group/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"group";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(569, 1, 1312120771, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/group/', 'a:2:{s:3:"get";a:3:{s:8:"__module";s:5:"group";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(570, 1, 1312120777, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/modules/group/?memberOf=%2Fcms%2Fmodules%2Fgroup%2Fviewgroup%2F5&submit=View+Information', 'a:2:{s:3:"get";a:5:{s:8:"__module";s:5:"group";s:8:"__action";s:0:"";s:7:"__extra";s:0:"";s:8:"memberOf";s:30:"/cms/modules/group/viewgroup/5";s:6:"submit";s:16:"View Information";}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(571, 0, 1312121412, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(572, 0, 1312121413, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(573, 0, 1312121418, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(574, 0, 1312121418, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(575, 0, 1312121422, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(576, 0, 1312121477, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456'),
(577, 0, 1312121774, 'SELECT * FROM cscms_affiliates WHERE active = 1 AND showOnMenu = 1 ORDER BY rand() LIMIT 6;', '/cms/', 'a:2:{s:3:"get";a:0:{}s:4:"post";a:0:{}}', 'Table ''cscms.cscms_affiliates'' doesn''t exist', 'D:\\Web Drive\\www\\cms\\core\\classes\\driver.mysql.php:456');

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
('daily_cron', '1312075054'),
('hourly_cron', '1312128588'),
('site_opened', '1305563308'),
('weekly_cron', '1311616462');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=19 ;

--
-- Dumping data for table `cscms_userkeys`
--

INSERT INTO `cscms_userkeys` (`id`, `uData`, `uAgent`, `uIP`) VALUES
(1, 'f37db:1', 'a75260f9c46ed9ade4e45bf4f4d02b13', '127.0.0.1'),
(2, 'cdd4a:1', '1dc383ebed26406ca886bae9c1eb1140', '127.0.0.1'),
(3, '8b294:1', 'a75260f9c46ed9ade4e45bf4f4d02b13', '127.0.0.1'),
(4, '0c0d9:1', 'a75260f9c46ed9ade4e45bf4f4d02b13', '127.0.0.1'),
(5, 'e32a2:1', '919f5e84baaecf459c66a73381d76490', '127.0.0.1'),
(6, '4797c:1', '919f5e84baaecf459c66a73381d76490', '127.0.0.1'),
(7, 'a90b9:9', 'f28b4be0663a2db3251e8519c92f5d09', '77.70.92.24'),
(8, '4c9cd:1', '9a7687fa1cfb8b85b3c9215f10b5fb36', '127.0.0.1'),
(9, 'dbccc:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(10, '4af37:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(11, '0702b:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(12, 'e1b38:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(13, '999a1:9', 'fcbe49ccb26952f491c509c5ae7c1ecc', '77.70.92.24'),
(14, '02bd5:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(15, 'c5760:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(16, 'c5ad6:1', '892487ed2dfc499bfc0e7a4b75a4f597', '69.29.116.153'),
(17, '5945a:1', '9b9a7e4033077cbf0c8dafd2f2764900', '127.0.0.1'),
(18, '91218:1', '9a7687fa1cfb8b85b3c9215f10b5fb36', '127.0.0.1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;

--
-- Dumping data for table `cscms_users`
--

INSERT INTO `cscms_users` (`id`, `username`, `password`, `pin`, `register_date`, `last_active`, `usercode`, `email`, `show_email`, `avatar`, `title`, `language`, `timezone`, `theme`, `hidden`, `active`, `userlevel`, `banned`, `primary_group`, `login_attempts`, `pin_attempts`, `autologin`, `reffered_by`, `password_update`, `whitelist`, `whitelisted_ips`, `warnings`) VALUES
(1, 'xLink', '$J$B.z.J7Lgi8SYHchlaBAOLfbXsS99Of/', '9ba021a151291bec35f37a0069e97766', 1303401493, 1312128588, 'cj6v22', 'xLink@cybershade.org', 0, '/images/avatars/1/a120f4904ac3cbf66a28b6f8587e58c5.png', '`The one`', '', '0.0', 'darc', 0, 1, 3, 0, 0, 0, 0, 1, 0, 0, 0, NULL, 0),
(2, 'Infy', '$J$BOvCVZlGIwmMtaDmHAydr59M.EBdbm/', NULL, 1303409373, 0, 'snxj4c', 'infinity@cybershade.org', 0, '/images/avatars/2/bcb9751cf069b8b7ecd061d308e75e44.png', NULL, 'en', '2.0', 'def2cs', 0, 1, 2, 0, 5, 3, 0, 1, 0, 0, 0, NULL, 0),
(3, 'Jath', '$J$Bg5opNsHHmo5uph7Duki2ZQJL4v2yt1', NULL, 1303409997, 0, '7dxttv', 'jath@cybershade.org', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 2, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(4, 'Biber', '$J$BvTmeQ7PyB9z25Q6QDm762SOxG.p0Z.', NULL, 1303410985, 0, 'xrm32j', 'biber@cybershade.org', 0, 'http://i.imgur.com/QvvyH.png', NULL, 'en', '0.0', 'def2cs', 0, 0, 2, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(5, 'whoami', '$J$B.0JpK2YEsK45.Y9Wml/l7s6vB6enT1', NULL, 1303411013, 0, 'by79nj', 'whoami@cybershade.org', 0, 'http://k.min.us/ilcMu4.png', NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(6, 'Scub', '$J$BA6gr7NMDNViM8kZyaudB0CSH.ZgFo1', NULL, 1303411055, 0, 'c7yzg8', 'scub@cybershade.org', 0, 'http://api.ning.com/files/nX9ljBN6iu2u9hptXDSF-3Ns7KLAXWUhlYLK732aO8gCEodrDVRNqbYRb1j3J2gMZASBj41WQxtq2Tp9kDuHvW2178uh4r4r/800pxDEATH_NOTE_L_wallpaper.jpg', 'Digital Ninja', 'en', '0.0', 'def2cs', 0, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(7, 'Louve', '$J$BnCiwWrsiy/KKVGMnS9L/iVVVB/rjc.', '640c2baf856c0ef658cc247d95111d54', 1303411104, 0, 'kf2y48', 'louve@darchoods.net', 0, 'http://www.filecluster.com/media/avatars/avatar_default_150x150.jpg', 'Thy Network Janitor', 'en', '-8.0', 'def2cs', 0, 1, 3, 0, 0, 0, 0, 1, 0, 0, 0, NULL, 0),
(8, 'Jesus', '$J$B.z.J7Lgi8SYHchlaBAOLfbXsS99Of/', '2b2a97838566a466d03b929c6caafd8c', 1303411125, 0, 'r2wfg9', 'Jesus@cybershade.org', 0, '/images/avatars/8/9468f6859c468888d2b5096ecfdd78d4.png', 'That ''SEXY'', Whoring m''fucka', 'en', '0.0', 'def2cs', 0, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(9, 'aroticoz', '$J$Bnla9.616vg8jQSF/bv/iioghMC4qm/', '07dd4fc9747f86159f4205e19b03bb87', 1303412302, 1310590461, 'xnw6g3', 'arotix@darchoods.net', 0, 'http://a4.sphotos.ak.fbcdn.net/hphotos-ak-snc6/205209_1957878742618_1112225654_32323460_373191_n.jpg', NULL, 'en', '2.0', 'def2cs', 0, 1, 2, 0, 2, 0, 0, 1, 0, 0, 0, NULL, 0),
(10, 'DarkMantis', '$J$BVAHJhe6u9xqOf/BiI4H05QTDSNUkg.', 'cc9f0cfb1cf84ccaf499a0bc4b2ed06e', 1303474906, 1311604936, 'sgxb8x', 'darkmantis@cybershade.org', 0, 'http://cdn1.iconfinder.com/data/icons/SOPHISTIQUENIGHT/networking/png/256/spyware.png', 'Me &gt; Jesus!', '', '1.0', 'default', 0, 1, 3, 0, 5, 3, 0, 0, 0, 0, 0, NULL, 0),
(11, 'LK-', '$J$BI6EN75IZCRvCweRQx8boT60SCNWyi.', '0ce9820c6ea7544918a22f6c1da3d17f', 1303625967, 0, 'b59tb7', 'lk07805@gmail.com', 0, 'http://i.imgur.com/YUz9l.gif', NULL, 'en', '10.0', 'def2cs', 0, 1, 3, 0, 4, 0, 0, 1, 0, 0, 0, NULL, 0),
(12, 'SCD', '$J$Btu.HaSvvQc624dq8PHXrChbuUOH.l0', NULL, 1304097030, 0, 'dkmx1j', 'cs@sam.33mail.com', 0, NULL, NULL, 'en', '0.0', 'default', 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, NULL, 0),
(13, 'StormyDragon', '$J$BVJNAW50iDgIrejbld59PNu8tvgYGK1', NULL, 1304104917, 0, '2ncwvh', 'stormydragon@btinternet.com', 0, '/images/avatars/13/ca428fc0f78b3e04f3ea772e49b83bef.jpg', NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(14, 'RichieC', '$J$B0NqzJ0JPxNfDG39oA7bpRf248QwsG.', NULL, 1304164405, 0, '1h2z28', 'rclifford@cybershade.org', 0, NULL, NULL, 'en', '1.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(15, 'Emil', '$J$Ba9/8b7JAWZXPjQ5AWJfJiLHEK7l.50', NULL, 1304175725, 0, 's7mf2d', 'emil.hars@hotmail.com', 0, 'http://api.ning.com/files/ULRVerVGSe6oo7-AI3BV*TTpmgQv1PuIGi9y6c2zcAFF6*hsEnNzdRSyNc*OgrJdlOrOS8XFczI3JHcxUNNsEe3uCd6YqXxz/clown.gif_320_320_256_9223372036854775000_0_1_0.gif', NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(16, 'Rottweiler7', '$J$BVLzb33ASIdrv7ahJHH6fV3dc01M1t1', NULL, 1304188069, 0, 'kvytcb', 'rotw3il3r@hotmail.com', 0, NULL, NULL, 'en', '2.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(17, 'iLike', '$J$BSKIM3YivFRB74MIPwDYd1Rnl4VdUV.', NULL, 1304278447, 0, 'v83szt', 'robedino@gmail.com', 0, NULL, NULL, 'en', '1.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(18, 'philkill', '$J$BjJZ1F6wTxeER4fmjzH3/.wznHti8X/', NULL, 1304295889, 0, 'n5bzc5', 'philkill@live.co.uk', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(19, 'Matt', '$J$BrDCHgNLgdPutGmYRorRKhj5eQQTIz.', NULL, 1304392872, 0, 'xh617n', 'creata.physics@gmail.com', 0, NULL, NULL, 'en', '-6.0', 'default', 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, NULL, 0),
(20, 'TheRaven', '$J$BMHwAXdf4PBAgz5CmWfG2UDhNK42xP/', NULL, 1304682471, 0, 'dh23y5', 'darkfanta@live.com', 0, NULL, NULL, 'en', '2.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(21, 'Prince', '$J$BrV3PrQxvMzL..LNw5U65.qBFjLHxl/', NULL, 1305185716, 0, '8wn4k7', 'endworfin@live.com', 0, 'C:\\Users\\Owner\\Desktop\\avatar.jpg', NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(22, 'drsexbot', '$J$BUPRguGDA//TkWqKdZNfqoWw3G.Ej01', NULL, 1305190383, 0, 'kskh92', 'doctor.sexbot@gmail.com', 0, 'http://www.deviantart.com/download/23723878/Lone_Sandshrew_by_stardroidjean.png', NULL, 'en', '-8.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(23, 'narada', '$J$BlyUEVrQI4xGSx.CF9g87AykBmFJ75.', NULL, 1305386760, 0, 'ys71f8', 'narada@archlinux.us', 0, '/images/avatars/23/d7bcb9e50cc1ce447ed3c17aacba9ef4.gif', NULL, 'en', '-6.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(24, 'ahandy', '$J$BxyNZdYSGiLVnnEyrHlpfmlmWy9DMG1', NULL, 1305478263, 0, 'j9cyss', 'andyabihaydar2@gmail.com', 0, NULL, NULL, 'en', '3.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(25, 'Krado', '$J$Bx5TE9q50In7x/Xkx5C1kFIkmpD6uD1', NULL, 1305556575, 0, 'jhdkkc', 'rouge24218@yahoo.co.uk', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(26, 'Jasper', '$J$B.iQ0z4N2FHXJKDHy3s2V/gkbWDLnY1', NULL, 1305920464, 0, '43wtwx', 'jasper@vanderstoop.nl', 0, NULL, NULL, 'en', '1.0', 'def2cs', 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(27, 'gKreator', '$J$BRaIZpkS0EVZf6wcNMjD0WsyiJdetG.', NULL, 1306089661, 0, '7vf52x', 'gKreator404@gmail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(28, 'chiders', '$J$BrqcDRwfxRo8jVkf5K92bscsJNAlg6/', NULL, 1306957262, 0, 'x8tmch', 'michael24687@hotmail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(29, 'Cro', '$J$BOtMVnhLWLGVpUuz9trqFlpKpWz1Ha0', NULL, 1307507815, 0, 'xs637f', 'croshadow3@gmail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0),
(30, 'TheChannel', '$J$BA1/9AmZIPTCwzoQLEE9204er/JetX0', NULL, 1308487756, 0, '92f5nz', 'strobenova@gmail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(31, 'CDT', '$J$BbGxWbViB9QwoHDEjk5/1CFElitdU7.', NULL, 1308968200, 0, 'w15g2g', 'bigben.cdt@gmail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 1, 0, 0, 0, NULL, 0),
(32, 'Beta', '$J$BSFghHSAmZrssVAUgHW1d5fM3BKCLN.', NULL, 1309435144, 0, '7d4n71', 'calebw96@ymail.com', 0, NULL, NULL, 'en', '0.0', 'def2cs', 0, 1, 0, 0, 3, 0, 0, 0, 0, 0, 0, NULL, 0);

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
  `forum_show_sigs` tinyint(1) NOT NULL DEFAULT '0',
  `forum_autowatch` tinyint(1) NOT NULL DEFAULT '0',
  `forum_quickreply` tinyint(1) NOT NULL DEFAULT '0',
  `forum_cat_order` text COLLATE utf8_bin,
  `forum_tracker` text COLLATE utf8_bin,
  `pagination_style` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_2` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cscms_user_extras`
--

INSERT INTO `cscms_user_extras` (`uid`, `birthday`, `sex`, `contact_info`, `about`, `interests`, `signature`, `usernotes`, `ajax_settings`, `notification_settings`, `forum_show_sigs`, `forum_autowatch`, `forum_quickreply`, `forum_cat_order`, `forum_tracker`, `pagination_style`) VALUES
(1, '00/00/0000', 0, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 0, NULL, NULL, 0),
-- --------------------------------------------------------