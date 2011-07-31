<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

$sql = array();
$now = $objSQL->escape(time());
$version = $objSQL->escape(str_replace('V', '', $version));
$admUsername = $objSQL->escape($_SESSION['adm']['username']);
$admPasswd = $objSQL->escape($objUser->mkPasswd($_SESSION['adm']['password']));
$admEmail = $objSQL->escape($_SESSION['adm']['email']);
$admKey = $objSQL->escape(randcode(6));
$ckeauth = $objSQL->escape(randcode(6));
$dst = date('I')==0 ? 1 : 0;
$timezone = 0;
//$userIp = getIP();

    $fields = array('title', 'slogan', 'description', 'keywords', 'captcha_pub', 'captcha_priv', 'time');
    foreach($fields as $f){
        if(isset($_SESSION['POST'][$f]) && !is_empty($_SESSION['POST'][$f])){ ${$f} = $objSQL->escape($_SESSION['POST'][$f]); continue; }
    }

//
//--Core System
//

//--Config
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_config`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_config` (
      `array` varchar(20) NOT NULL DEFAULT '',
      `var` text NOT NULL,
      `value` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_config` (`array`, `var`, `value`) VALUES
    ('cms', 'name', 'Cybershade CMS'),
    ('db', 'ckeauth', '$ckeauth'),
    ('site', 'title', '$title'),
    ('site', 'slogan', '$slogan'),
    ('site', 'theme', 'default'),
    ('site', 'language', 'en'),
    ('site', 'keywords', '{$keywords}'),
    ('site', 'description', '{$description}'),
    ('site', 'max_login_tries', '5'),
    ('site', 'timeformat', '{$time}'),
    ('site', 'dst', '{$dst}'),    
    ('site', 'timezone', '{$tz}'),
    ('site', 'template_override', '1'),
    ('site', 'auto_login', '1'),
    ('site', 'ips_max_before_ban', '5'),
    ('site', 'default_module', 'forum'),
    ('site', 'closed', '0'),
    ('site', 'disabledMsg', 'Administrator has closed this website.'),
    ('site', 'admin_email', '{$_SESSION[adm][email]}'),
    ('site', 'usernamechange', '0'),
    ('site', 'fc_update', '{$now}'),
    ('site', 'paginate', '10'),
    ('site', 'emailOnRegister', '1'),
    ('site', 'allowRegister', '1'),
    ('forum', 'news_cat', '2'),
    ('site', 'max_whitelist', '5'),
    ('forum', 'quick_replys', '1'),
    ('rss', 'global_limit', '15'),
    ('forum', 'sortables', '1'),
    ('admin', 'notes', ''),
    ('ajax', 'settings', 'forum_eip,forum_sortables'),
    ('site', 'user_group', '3'),
    ('site', 'analytics', ''),
    ('site', 'captcha_pub', '$captcha_pub'),
    ('site', 'captcha_priv', '$captcha_priv');
SQL;

//--FileHashes
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_filehashes`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_filehashes` (
      `filepath` text NOT NULL,
      `hash` varchar(60) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL;

//--Logs
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_logs`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_logs` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `uid` int(10) NOT NULL DEFAULT '0',
      `username` varchar(50) DEFAULT NULL,
      `description` text NOT NULL,
      `query` text,
      `refer` varchar(255) DEFAULT NULL,
      `date` int(10) unsigned NOT NULL DEFAULT '0',
      `ip_address` varchar(15) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
SQL;

//--Groups
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_groups`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_groups` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `type` int(11) NOT NULL DEFAULT '1',
      `name` varchar(100) NOT NULL DEFAULT '',
      `description` text NOT NULL,
      `moderator` int(11) NOT NULL DEFAULT '0',
      `single_user_group` int(1) NOT NULL DEFAULT '1',
      `color` varchar(50) NOT NULL,
      `order` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_groups` (`id`, `type`,  `name`,         `description`,      `moderator`, `single_user_group`,   `color`,    `order`) VALUES
                            (1,     1,      'Admin',        'Site Administrator',   1,              1,              '#ff0000',  1),
                            (2,     1,      'Mods',         'Site Moderator',       1,              1,              '#146eca',  2),
                            (3,     0,      'Users',        'Registered User',      1,              0,              '#b7b7b7',  3);
SQL;

//--Group Subscriptions
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_group_subs`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_group_subs` (
      `uid` int(11) NOT NULL,
      `gid` int(11) NOT NULL,
      `pending` int(1) NOT NULL DEFAULT '1',
      KEY `gid` (`gid`),
      KEY `uid` (`uid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_group_subs` (`uid`, `gid`, `pending`) VALUES 
    (1, 1, 0), (1, 2, 0), (1, 3, 0);
SQL;

//--CMS Menus
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_menu_blocks`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_menu_blocks` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uniqueId` varchar(10) NOT NULL,
      `module` text NOT NULL,
      `function` text NOT NULL,
      `position` int(11) NOT NULL DEFAULT '0',
      `order` int(11) NOT NULL DEFAULT '0',
      `perms` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      UNIQUE KEY `uniqueId` (`uniqueId`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_menu_blocks` (`id`, `uniqueId`, `module`, `function`, `position`, `order`, `perms`) VALUES
    (1, 'jv1h9w6m2y', 'NULL', 'NULL', 0, 0, 0),
    (2, 'x91z6yvmrw', 'core', 'affiliates', 0, 0, 0),
    (3, 'ndxhzj9w54', 'core', 'wio', 0, 0, 0),
    (4, 'n4fym8r9gd', 'forum', 'forum_posts', 0, 0, 0),
    (5, '9rgtdk2zv8', 'login', 'login', 0, 0, 0),
    (6, '15k8dhnf9c', 'core', 'test', 0, 0, 0),
    (7, 'qy234gu773', 'pm', 'boxStatus', 0, 0, 0);
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_menus`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_menus` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(50) DEFAULT NULL,
      `link` text,
      `lname` varchar(50) DEFAULT NULL,
      `blank` int(1) NOT NULL DEFAULT '0',
      `disporder` int(11) NOT NULL DEFAULT '0',
      `color` varchar(20) DEFAULT NULL,
      `perms` int(1) NOT NULL DEFAULT '0',
      `external` int(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_menus` (`id`, `name`, `link`, `lname`, `blank`, `disporder`, `color`, `perms`, `external`) VALUES
    (1, 'menu_mm', 'index.php', 'Site home', 0, 1, NULL, 0, 0),
    (2, 'menu_mm', 'admin/', 'Admin Panel', 0, 10, '#FF0000', 3, 0),
    (3, 'menu_mm', 'modules/forum/', 'Forum', 0, 2, NULL, 0, 0),
    (5, 'menu_mm', 'modules/pm/', 'Private Messages', 0, 3, NULL, 1, 0),
    (6, 'menu_mm', 'user/', 'User Control Panel', 0, 4, NULL, 1, 0),
    (7, 'menu_mm', 'mod/', 'Moderator Panel', 0, 9, NULL, 3, 0),
    (8, 'main_nav', 'index.php', 'Site Home', 0, 1, NULL, 0, 0),
    (9, 'main_nav', 'modules/profile/view/', 'Profile', 0, 2, NULL, 1, 0),
    (10, 'main_nav', 'modules/forum/', 'Forum', 0, 3, NULL, 0, 0),
    (11, 'main_nav', 'modules/articles/', 'Articles', 0, 4, NULL, 0, 0),
    (12, 'main_nav', 'modules/codebase/', 'Codebase', 0, 5, NULL, 0, 0),
    (13, 'main_nav', 'modules/pastebin/', 'PasteBin', 0, 6, NULL, 0, 0);
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_menu_setups`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_menu_setups` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `module` varchar(30) NOT NULL,
      `pageId` text NOT NULL,
      `menuId` varchar(10) NOT NULL,
      `params` longtext,
      `order` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_menu_setups` (`id`, `module`, `pageId`, `menuId`, `params`, `order`) VALUES
    (1,     'core', 'default',  'jv1h9w6m2y', 'menu_name=mm\r\nmenu_title=Main Menu\r\ntest = 1', 1),
    (2,     'core', 'default',  'x91z6yvmrw', 'menu_title=Affiliates\r\nlimit=6\r\nperRow=2', 3),
    (3,     'core', 'default',  'ndxhzj9w54', 'menu_title=m_wio', 4),
    (4,     'forum','default',  'jv1h9w6m2y', 'menu_name=mm\r\nmenu_title=Main Menu\r\ntest = 1', 0),
    (5,     'forum','default',  'n4fym8r9gd', 'menu_title=m_latest_post\r\nlimit=5', 0),
    (6,     'forum','default',  'ndxhzj9w54', 'menu_title=m_wio', 0),
    (7,     'core', 'default',  '9rgtdk2zv8', 'menu_title=m_login', 2),
    (8,     'core', 'test',     'x91z6yvmrw', 'menu_title=Affiliates\r\nlimit=6\r\nperRow=2', 1),
    (9,     'pm',   'default',  'qy234gu773', 'menu_title=Private Messages', 1),
    (10,    'pm',   'default',  'jv1h9w6m2y', 'menu_name=mm\r\nmenu_title=Main Menu\r\ntest = 1', 0);
SQL;

//--Affiliate System
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_affiliates`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_affiliates` (
      `id` int(5) NOT NULL AUTO_INCREMENT,
      `img` text NOT NULL,
      `title` text NOT NULL,
      `url` text NOT NULL,
      `in` int(11) NOT NULL DEFAULT '0',
      `out` int(11) NOT NULL DEFAULT '0',
      `active` int(1) NOT NULL DEFAULT '0',
      `showOnMenu` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_affiliates` (`id`, `img`, `title`, `url`, `in`, `out`, `active`, `showOnMenu`) VALUES
    (1, 'http://www.cybershade.org/images/aff.gif', 'CybershadeCMS', 'http://cybershade.org', 0, 0, 1, 1);
SQL;

//--Notifications
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_notifications`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_notifications` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL,
      `type` int(1) NOT NULL DEFAULT '0',
      `msg` text,
      `time` int(11) NOT NULL,
      `read` int(11) NOT NULL DEFAULT '0',
      `module` varchar(30) DEFAULT NULL,
      `title` text,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
SQL;
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_notification_settings`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_notification_settings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `module` varchar(50) DEFAULT NULL,
      `name` varchar(50) NOT NULL,
      `desc` text,
      `default` varchar(50) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_notification_settings` (`id`, `module`, `name`, `desc`, `default`) VALUES
    (1, 'forum', 'forumReplies', 'Forum Replies', '1');
SQL;

//--Comments
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_comments`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_comments` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `module` varchar(100) NOT NULL,
      `moduleid` int(11) NOT NULL,
      `author` int(11) NOT NULL,
      `comment` text NOT NULL,
      `posted` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;

//--Online Table
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_online`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_online` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL,
      `username` varchar(100) DEFAULT NULL,
      `ip_address` varchar(15) DEFAULT NULL,
      `timestamp` int(11) NOT NULL,
      `location` text NOT NULL,
      `referer` varchar(255) DEFAULT NULL,
      `language` varchar(5) NOT NULL,
      `useragent` text NOT NULL,
      `login_attempts` int(2) NOT NULL DEFAULT '0',
      `login_time` int(11) NOT NULL,
      `userkey` varchar(32) DEFAULT NULL,
      `mode` enum('active','kill','ban','update') NOT NULL DEFAULT 'active',
      PRIMARY KEY (`id`),
      UNIQUE KEY `userkey` (`userkey`),
      KEY `username` (`username`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;

//--Ban Table
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_banned`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_banned` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_ip` varchar(15) NOT NULL DEFAULT '',
      `ban_time` int(11) NOT NULL DEFAULT '0',
      `ban_untill` int(11) NOT NULL DEFAULT '0',
      `reason` text,
      `whoby` int(11) NOT NULL DEFAULT '0',
      `url` text,
      PRIMARY KEY (`id`),
      UNIQUE KEY `user_ip` (`user_ip`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;
SQL;

//--File Registry Table
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_fileregistry`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_fileregistry` (
      `filename` varchar(255) NOT NULL,
      `hash` varchar(64) NOT NULL,
      PRIMARY KEY (`filename`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL;

//--Hooks
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_plugins`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_plugins` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(50) NOT NULL,
      `filePath` text NOT NULL,
      `author` varchar(50) NOT NULL,
      `priority` enum('1','2','3') NOT NULL DEFAULT '1',
      `enabled` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL;

//--Stats
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_statistics`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_statistics` (
      `variable` varchar(255) NOT NULL DEFAULT '',
      `value` text NOT NULL,
      PRIMARY KEY (`variable`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_statistics` (`variable`, `value`) VALUES
    ('site_opened', '{$now}'),
    ('online_record', '0'),
    ('hourly_cron', '{$now}'),
    ('daily_cron', '{$now}'),
    ('weekly_cron', '{$now}');
SQL;

//--Modules
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_modules`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_modules` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) DEFAULT NULL,
      `enabled` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_modules` (`name`, `enabled`) VALUES
    ('core', 1),
    ('pm', 1),
    ('forum', 1),
    ('shoutbox', 1),
    ('group', '1'),
    ('profile', '1');
SQL;


//
//--Core Modules
//

//--Forum
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_forum_cats`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_forum_cats` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `parentid` int(11) NOT NULL DEFAULT '0',
      `title` varchar(255) NOT NULL,
      `desc` text,
      `order` int(11) NOT NULL DEFAULT '0',
      `mods` text,
      `last_poster` int(15) NOT NULL DEFAULT '0',
      `last_post_id` int(11) NOT NULL DEFAULT '0',
      `thread_count` int(11) NOT NULL DEFAULT '0',
      `post_count` int(11) NOT NULL DEFAULT '0',
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
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC ;
SQL;
$sql[] = <<<SQL
INSERT INTO `cs_forum_cats` (`parentid`, `title`, `desc`, `order`, `mods`, `last_poster`, `last_post_id`, `thread_count`, `post_count`, `auth_view`, `auth_read`, `auth_post`, `auth_reply`, `auth_edit`, `auth_del`, `auth_move`, `auth_special`, `auth_mod`) VALUES
    (0, 'Test Parent Category', NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
    (1, 'Test Forum', 'Test Forum', 1, NULL, 1, 1, 1, 0, 0, 1, 1, 1, 1, 3, 3, 3, 0);
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_forum_threads`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_forum_threads` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `cat_id` int(11) NOT NULL DEFAULT '0',
      `author` int(15) NOT NULL DEFAULT '0',
      `subject` varchar(255) NOT NULL DEFAULT '',
      `posted` int(11) NOT NULL DEFAULT '0',
      `topic_post_id` int(11) NOT NULL DEFAULT '0',
      `last_post_id` int(11) NOT NULL DEFAULT '0',
      `last_poster` int(15) NOT NULL DEFAULT '0',
      `locked` int(1) NOT NULL DEFAULT '0',
      `mode` int(1) NOT NULL DEFAULT '0',
      `views` int(1) NOT NULL DEFAULT '0',
      `replies` int(1) NOT NULL DEFAULT '0',
      `move_id` int(11) NOT NULL DEFAULT '0',
      `oldid` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC ;
SQL;
$sql[] = <<<SQL
INSERT INTO `cs_forum_threads` (`cat_id`, `author`, `subject`, `posted`, `topic_post_id`, `last_post_id`, `last_poster`, `locked`, `mode`, `views`, `replies`, `move_id`) VALUES
    (2, 1, 'Test Thread', {$now}, 1, 1, {$now}, 0, 0, 0, 0, 0);
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_forum_posts`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_forum_posts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `thread_id` int(2) NOT NULL DEFAULT '0',
      `author` int(15) DEFAULT '0',
      `subject` varchar(255) DEFAULT NULL,
      `post` text,
      `posted` int(15) NOT NULL DEFAULT '0',
      `poster_ip` varchar(15) NOT NULL DEFAULT '',
      `edited` int(5) NOT NULL DEFAULT '0',
      `edited_by` int(15) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      KEY `thread_id` (`thread_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC ;
SQL;
$sql[] = <<<SQL
INSERT INTO `cs_forum_posts` (`thread_id`, `author`, `subject`, `post`, `posted`, `poster_ip`, `edited`, `edited_by`) VALUES
(1, 1, 'Test Thread', 'Welcome to Cybershade CMS. Install seems to have worked so you can reorder the forum from the admin panel.', {$now}, '{$userIp}', 0, 0);
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_forum_watch`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_forum_watch` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL DEFAULT '0',
      `thread_id` int(11) NOT NULL DEFAULT '0',
      `seen` int(1) NOT NULL DEFAULT '1',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;

$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_forum_auth`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_forum_auth` (
      `group_id` int(11) NOT NULL,
      `cat_id` int(11) NOT NULL,
      `auth_view` int(1) NOT NULL DEFAULT '0',
      `auth_read` int(1) NOT NULL DEFAULT '0',
      `auth_post` int(1) NOT NULL DEFAULT '0',
      `auth_reply` int(1) NOT NULL DEFAULT '0',
      `auth_edit` int(1) NOT NULL DEFAULT '0',
      `auth_del` int(1) NOT NULL DEFAULT '0',
      `auth_move` int(1) NOT NULL DEFAULT '0',
      `auth_special` int(1) NOT NULL DEFAULT '0',
      `auth_mod` int(1) NOT NULL DEFAULT '0'
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL;

//--PM Sys
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_pm`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_pm` (
      `id` int(100) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `author` int(11) NOT NULL DEFAULT '0',
      `recipient` int(11) NOT NULL DEFAULT '0',
      `message` text NOT NULL,
      `inBox` int(1) NOT NULL DEFAULT '1',
      `read` set('1','0') NOT NULL DEFAULT '0',
      `replied` set('1','0') NOT NULL DEFAULT '0',
      `parent` int(100) NOT NULL DEFAULT '0',
      `sent` int(15) NOT NULL DEFAULT '0',
      `rm_recipient` int(1) NOT NULL DEFAULT '0',
      `rm_author` int(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;

//--Shoutbox
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_shoutbox`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_shoutbox` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL DEFAULT '0',
      `time` int(11) NOT NULL DEFAULT '0',
      `message` text,
      `ip` varchar(15) NOT NULL DEFAULT '',
      `color` int(6) DEFAULT NULL,
      `module` varchar(50) NOT NULL DEFAULT 'NULL',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;

//
//--User Stuff
//

//--Userkeys
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_userkeys`;
SQL;
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_userkeys` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` varchar(11) NOT NULL DEFAULT '0',
      `user_agent` text NOT NULL,
      `user_ip` varchar(15) NOT NULL DEFAULT '',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    DROP TABLE IF EXISTS `cs_users`;
SQL;

//--Users
$sql[] = <<<SQL
    CREATE TABLE IF NOT EXISTS `cs_users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(100) NOT NULL DEFAULT '',
      `password` varchar(40) NOT NULL DEFAULT '',
      `pin` varchar(32) DEFAULT NULL,
      `email` varchar(100) NOT NULL DEFAULT '',
      `avatar` text,
      `signature` text,
      `title` text,
      `template` varchar(50) NOT NULL DEFAULT 'default',
      `contactInfo` text,
      `sex` int(1) NOT NULL DEFAULT '0',
      `about` text,
      `interests` text,
      `birthday` varchar(11) NOT NULL DEFAULT '00/00/0000',
      `banned` int(1) NOT NULL DEFAULT '0',
      `usercode` varchar(6) NOT NULL DEFAULT '',
      `userlevel` int(11) NOT NULL DEFAULT '0',
      `colorgroup` int(8) NOT NULL DEFAULT '0',
      `active` int(11) NOT NULL DEFAULT '0',
      `login_attempts` int(5) NOT NULL DEFAULT '0',
      `pin_attempts` int(5) NOT NULL DEFAULT '0',      
      `hidden` int(11) NOT NULL DEFAULT '0',
      `ipaddress` varchar(15) NOT NULL DEFAULT '',
      `useragent` text,
      `timestamp` int(11) NOT NULL DEFAULT '0',
      `cms_location` text,
      `pm_limit` int(11) NOT NULL DEFAULT '15',
      `registerdate` int(11) NOT NULL DEFAULT '0',
      `timezone` decimal(5,1) NOT NULL DEFAULT '0.0',
      `language` char(2) NOT NULL DEFAULT 'en',
      `attachsig` int(1) NOT NULL DEFAULT '0',
      `showemail` int(1) NOT NULL DEFAULT '0',
      `autologin` int(1) NOT NULL DEFAULT '0',
      `reffered` int(11) NOT NULL DEFAULT '0',
      `postcount` int(11) NOT NULL DEFAULT '0',
      `threads` int(11) NOT NULL DEFAULT '0',
      `posts` int(11) NOT NULL DEFAULT '0',
      `codes` int(11) NOT NULL DEFAULT '0',
      `articles` int(11) NOT NULL DEFAULT '0',
      `comments` int(11) NOT NULL DEFAULT '0',
      `autowatch` int(1) NOT NULL DEFAULT '0',
      `reparray` text NOT NULL,
      `whitelist` int(1) NOT NULL DEFAULT '0',
      `whitelisted_ips` text,
      `warn_level` int(11) NOT NULL DEFAULT '0',
      `password_update` int(1) NOT NULL DEFAULT '0',
      `quick_replys` int(1) NOT NULL DEFAULT '0',
      `forum_order` text,
      `article_view` int(1) NOT NULL DEFAULT '0',
      `notes` text NOT NULL,
      `codebase_view` int(1) NOT NULL DEFAULT '0',
      `floodProtectSB` int(11) NOT NULL DEFAULT '0',
      `topicUpdate` text,
      `ajax_settings` text,
      `notificationSettings` text,
      `paginationStyle` int(2) NOT NULL DEFAULT '1',
      PRIMARY KEY (`id`),
      UNIQUE KEY `username` (`username`),
      KEY `email` (`email`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
SQL;
$sql[] = <<<SQL
    INSERT INTO `cs_users` (`username`, `password`, `email`, `avatar`, `signature`, `title`, `template`, `contactInfo`, `sex`, `about`, `interests`, `birthday`, `banned`, `usercode`, `userlevel`, `colorgroup`, `active`, `login_attempts`, `hidden`, `ipaddress`, `useragent`, `timestamp`, `cms_location`, `pm_limit`, `registerdate`, `timezone`, `language`, `attachsig`, `showemail`, `autologin`, `reffered`, `postcount`, `threads`, `posts`, `codes`, `articles`, `comments`, `autowatch`, `reparray`, `whitelist`, `whitelisted_ips`, `warn_level`, `password_update`, `quick_replys`, `forum_order`, `article_view`, `notes`, `codebase_view`, `floodProtectSB`, `topicUpdate`, `ajax_settings`, `notificationSettings`, `paginationStyle`) VALUES
('{$admUsername}', '{$admPasswd}', '{$admEmail}', NULL, NULL, NULL, 'default', NULL, 0, NULL, NULL, '00/00/0000', 0, '{$admKey}', 3, 0, 1, 0, 0, '', NULL, {$now}, NULL, 15, {$now}, '0.0', 'en', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, 0, 0, 0, NULL, 0, '', 0, 0, NULL, NULL, NULL, 1);
SQL;

?>