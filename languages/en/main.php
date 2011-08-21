<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
if(!isset($LANG_LOAD)){ die('Error: Cannot access directly.'); }

//breadcrumbs
$_lang['B_MAINSITE']            = 'Site Home';
$_lang['B_REGISTER']            = 'Register';

$_lang['B_UCP']                 = 'User Control Panel';
$_lang['B_ACP']                 = 'Admin Control Panel';

//header lang vars
$_lang['L_MAINTENANCE']         = 'This website is in maintenance mode.';
$_lang['L_BREADCRUMB']          = 'You are here:';

$_lang['L_LOGIN']               = 'Login';
$_lang['L_LOGOUT']              = 'Logout';
$_lang['L_UCP']                 = 'User Control Panel';
$_lang['L_ACP']                 = 'Admin Control Panel';

//footer lang vars
$_lang['L_PAGE_GEN']            = '[ Queries: <b>%s</b> | SQL Time: <b>%s</b> | Page Generation Time: <b>%s</b> | Memory Usage: <b>%s</b> | Next Cron Update: <b>%s</b> ]';
$_lang['L_SITE_COPYRIGHT']      = '%s Powered By %s V%s';
$_lang['TPL_INFO']              = 'Theme %s by %s V%s';

//debug lang vars
$_lang['MSG_INFO']              = 'Information';
$_lang['MSG_FAIL']              = 'Failed';
$_lang['MSG_ERR']               = 'Error';
$_lang['MSG_OK']                = 'Successful';

$_lang['MSG_NO_PIN']            = 'Your PIN is not set. You cannot login to the admin control panel at this time.<br />Please make sure you set one in your User Control Panel.';
$_lang['L_CAPTCHA_DESC']        = 'This question is for testing whether you are a human visitor and to prevent automated spam submissions.';

$_lang['L_REG_SUCCESS_EMAIL']   = 'Your registration has been successful. The administrator has asked that you validate your email before being allowed to login. Please do this now, if you have no email in your inbox, check your junk & spam boxes. Otherwise wait a while and then contact the administrator.';
$_lang['L_REG_SUCCESS_NO_EMAIL']= 'Your registration has been successful. You may now login with your username and password.';

//forms
$_lang['L_USERNAME']            = 'Username';
$_lang['L_PIN']                 = 'PIN';
$_lang['L_PIN_DESC']            = 'This is the PIN you set yourself in the user control panel. If you haven\'t set a PIN as yet, please do so.';
$_lang['L_PASSWORD']            = 'Password';
$_lang['L_REMBER_ME']           = 'Remember Me';

//log stuff
$_lang['LOG_CREATED_USER']      = 'We\'ve done it! <a href="%s">%s</a>, he..he lives! Giovanni will be impressed at the power this creature wields...';

//menu titles
$_lang['M_MAIN_MENU']           = 'Main Menu';
$_lang['M_LOGIN']               = 'Login';
$_lang['M_USER_MENU']           = 'User Menu';
$_lang['M_WIO']                 = 'Who Is Online';
$_lang['M_ANNOUNCEMENT']        = 'Announcement';
$_lang['M_STATS']               = 'CMS Statistics';
$_lang['M_AFFILIATES']          = 'Affiliates';
$_lang['M_UMOD']                = 'User Moderation';

//menu blocks
$_lang['L_INVALID_FUNCTION']    = '<b>Fatal Error</b>: Function <i>%s</i> was not found.';

//who is online block
$_lang['L_KEY']                 = 'User Key:';
$_lang['L_USERS_ONLINE']        = 'Users Online:';
$_lang['L_NO_ONLINE_USERS']     = 'There are currently no users online.';

//logon block
$_lang['L_LAST_VISIT']          = 'Last Visit: %s';
$_lang['L_REMME']               = 'Remember Me';

//other stuff
$_lang['L_PER_DAY']             = '<strong>Per Day</strong>: %d';
$_lang['L_EDIT']                = 'Edit';
$_lang['L_DELETE']              = 'Delete';
$_lang['L_COMMENTS']            = 'Comments: %s';

//control panels
$_lang['L_OVERVIEW']            = 'Overview';
$_lang['L_SITE_OVERVIEW']       = 'Website Overview';
$_lang['L_SYS_INFO']            = 'System Information';
$_lang['L_CORE_SETTINGS']       = 'Core Settings';

$_lang['L_SET_UPDATED']         = 'Successfully updated settings. Returning you to the panel.';
$_lang['L_SET_NOT_UPDATED']     = 'Error: Some settings were not saved.<br />%s<br />Redirecting you back.';

//UCP: default
$_lang['L_ACCOUNT_PANEL']       = 'Account Settings';

$_lang['L_EMAIL']               = 'Email Address';
$_lang['L_CHANGE_EMAIL']        = '<font color="red">Warning:</font> If you change your email address,<br />'.
                                    'you will be logged out and required to activate<br /> your user account again.';

$_lang['L_CHANGE_PWDS']         = 'Change Account Password';
$_lang['F_NEW_PASS_CONF']       = 'Password Change Confirmation';
$_lang['L_OLD_PASSWD']          = 'Old Password';
$_lang['L_NEW_PASSWD']          = 'New Password';
$_lang['L_CONF_PASSWD']         = 'Confirm New Password';

$_lang['L_PIN_UPDATE']          = 'PIN Code Update';
$_lang['L_NEW_PIN_CONF']        = 'PIN Update Confirmation';
$_lang['L_OLD_PIN']             = 'Old PIN Code';
$_lang['L_NEW_PIN']             = 'New PIN Code';
$_lang['L_CONF_PIN']            = 'Verify New PIN Code';

$_lang['L_USERNAME_UPDATE']     = 'The username you chose contained incorrect characters.';
$_lang['L_EMAIL_UPDATE']        = 'Your email address has been changed.';
$_lang['L_EMAIL_ACTIVATION']    = 'Your email address has been changed. You must now reactivate your account with the email that has been sent to your email address.';
$_lang['L_PASS_WRONG']          = 'The passwords you have entered do not match.';
$_lang['L_INVALID_PASS']        = 'The old password you provided is incorrect. Cannot update your password.';
$_lang['L_CHANGED_PASS']        = 'Password has been updated.';
$_lang['L_PIN_UPDATE_OK']       = 'PIN has been updated.';
$_lang['L_PIN_UPDATE_FAIL']     = 'Could not update PIN, Old PIN or Password given was incorrect.';

//UCP: general
$_lang['L_WEBSITE_PANEL']       = 'Website Settings';

$_lang['L_SITE_SETTINGS']       = 'Site Wide Settings';
$_lang['L_FORUM_SETTINGS']      = 'Forum Settings';

$_lang['L_SEX']                 = 'Sex';
$_lang['L_SEX_F']               = 'Female';
$_lang['L_SEX_M']               = 'Male';
$_lang['L_SEX_U']               = 'Unknown';

$_lang['L_USER_COLORING']       = 'Username Coloring';
$_lang['L_SITE_TEMPLATE']       = 'Site Template';
$_lang['L_QUICK_REPLY']         = 'Quick Reply';
$_lang['L_PRIV_EMAIL']          = 'Make Email Private';
$_lang['L_AUTO_WATCH']          = 'Auto Watch Threads';
$_lang['L_TIMEZONE']            = 'Timezone';
$_lang['L_QUICK_REPLIES']       = 'Quick Replies';

//UCP global langvars
$_lang['L_PRO_UPDATE_SUCCESS']  = 'Profile update was successful.';
$_lang['L_REQUIRED_INFO']       = 'Required Information';
$_lang['L_NO_CHANGES']          = 'There are no changes to be made.';

$_lang['L_YES']                 = 'Yes';
$_lang['L_NO']                  = 'No';

$_lang['L_ENABLED']             = 'Enabled';
$_lang['L_DISABLED']            = 'Disabled';

//UCP: contact info
$_lang['L_CONTACT_INFO']        = 'Contact Information';

//ACP: core settings
$_lang['L_SITE_CONFIG']         = 'Website Configuration';
$_lang['L_CUSTOMIZE']           = 'Customization';
$_lang['L_REG_LOGIN']           = 'Registration / Login';

$_lang['L_SITE_TITLE']          = 'Site Title';
$_lang['L_SITE_SLOGAN']         = 'Site Slogan';
$_lang['L_ADMIN_EMAIL']         = 'Administrator Email';
$_lang['L_INDEX_MODULE']        = 'Index Default Module';
$_lang['L_SITE_TZ']             = 'Site Timezone';
$_lang['L_DST']                 = 'Daylight Saving Time';
$_lang['L_DEF_DATE_FORMAT']     = 'Default Date Format';
$_lang['L_DEF_LANG']            = 'Default Language';
$_lang['L_DEF_THEME']           = 'Default Theme';
$_lang['L_THEME_OVERRIDE']      = 'Override Site Theme';
$_lang['L_ALLOW_REGISTER']      = 'Allow Registrations';
$_lang['L_EMAIL_ACTIVATE']      = 'Email Activation';
$_lang['L_MAX_LOGIN_TRIES']     = 'Max Login Tries';
$_lang['L_USERNAME_EDIT']       = 'Editable Usernames';
$_lang['L_GANALYTICS']          = 'Google Analytics Key';

$_lang['L_DESC_IMODULE']        = 'This setting controls the active functionality you have running on the website index(home page). For more advanced configuration check the module Administration panel.';
$_lang['L_DESC_SITE_TZ']        = 'This will change the time globally across the site, unless the user has overridden it.';
$_lang['L_DESC_DEF_DATE']       = 'The default date format. You can use [url="?mode=dateFormats"]date formats[/url] for more information about configuring it.';
$_lang['L_DESC_DEF_THEME']      = 'This will be the theme guests and users who havent configured their profiles will see.';
$_lang['L_DESC_THEME_OVERRIDE'] = 'If this is enabled [b]ALL users[/b] will see the default theme';
$_lang['L_DESC_ALLOW_REGISTER'] = 'If disabled, users will not be allowed to register on the website.';
$_lang['L_DESC_EMAIL_ACTIVATE'] = 'Make the users have to validate their accounts via email before being allowed to login.';
$_lang['L_DESC_MAX_LOGIN']      = 'Once a user exceeds this, he is banned for a predefined time.';
$_lang['L_DESC_REMME']          = 'If disabled, users will not be allowed to use the remember me to automatically login.';
$_lang['L_DESC_GANALYTICS']     = 'This allows you to use Google Analytics directly with the CMS.';

//ACP: reCaptcha
$_lang['L_RECAPTCHA']           = 'reCaptcha';
$_lang['L_RECAPTCHA_SETTINGS']  = 'reCaptcha Settings';

$_lang['L_PUB_KEY']             = 'Public Key';
$_lang['L_PRIV_KEY']            = 'Private Key';

//ACP: Site Maintenance
$_lang['L_MAINTENANCE']         = 'Site Maintenance';
$_lang['L_MAIN_DESC']           = 'This section enables you to disable the website whilst you work on it. It will be unavalible to everyone apart from logged in administrators. The login form will also be enabled just incase your logged out for any reason.';
$_lang['L_DISABLE_SITE']        = 'Disable Site';
$_lang['L_DISABLE_MSG']         = 'Disable Message';

//ACP: Module Management
$_lang['L_MOD_MANAGE']          = 'Module Management';

//ACP: file registry
$_lang['L_FILE_REG']            = 'File Registry';
$_lang['L_DELETED']             = 'Deleted';
$_lang['L_OK']                  = 'Ok';
$_lang['L_FC_CHANGED']          = 'Changed %s ago';
$_lang['L_FILENAME']            = 'Filename';
$_lang['L_FILE_STATUS']         = 'File Status';
$_lang['L_CHECK_FH']            = 'Check File Hashes';
$_lang['L_UPDATE_FH']           = 'Update File Hashes';
$_lang['L_CHANGED_ONLY']        = 'Show Changed Files Only';

//Time Stuff
$_lang['DATETIME']['Sunday']    = 'Sunday';
$_lang['DATETIME']['Monday']    = 'Monday';
$_lang['DATETIME']['Tuesday']   = 'Tuesday';
$_lang['DATETIME']['Wednesday'] = 'Wednesday';
$_lang['DATETIME']['Thursday']  = 'Thursday';
$_lang['DATETIME']['Friday']    = 'Friday';
$_lang['DATETIME']['Saturday']  = 'Saturday';
$_lang['DATETIME']['Sun']       = 'Sun';
$_lang['DATETIME']['Mon']       = 'Mon';
$_lang['DATETIME']['Tue']       = 'Tue';
$_lang['DATETIME']['Wed']       = 'Wed';
$_lang['DATETIME']['Thu']       = 'Thu';
$_lang['DATETIME']['Fri']       = 'Fri';
$_lang['DATETIME']['Sat']       = 'Sat';
$_lang['DATETIME']['January']   = 'January';
$_lang['DATETIME']['February']  = 'February';
$_lang['DATETIME']['March']     = 'March';
$_lang['DATETIME']['April']     = 'April';
$_lang['DATETIME']['May']       = 'May';
$_lang['DATETIME']['June']      = 'June';
$_lang['DATETIME']['July']      = 'July';
$_lang['DATETIME']['August']    = 'August';
$_lang['DATETIME']['September'] = 'September';
$_lang['DATETIME']['October']   = 'October';
$_lang['DATETIME']['November']  = 'November';
$_lang['DATETIME']['December']  = 'December';
$_lang['DATETIME']['Jan']       = 'Jan';
$_lang['DATETIME']['Feb']       = 'Feb';
$_lang['DATETIME']['Mar']       = 'Mar';
$_lang['DATETIME']['Apr']       = 'Apr';
$_lang['DATETIME']['May']       = 'May';
$_lang['DATETIME']['Jun']       = 'Jun';
$_lang['DATETIME']['Jul']       = 'Jul';
$_lang['DATETIME']['Aug']       = 'Aug';
$_lang['DATETIME']['Sep']       = 'Sep';
$_lang['DATETIME']['Oct']       = 'Oct';
$_lang['DATETIME']['Nov']       = 'Nov';
$_lang['DATETIME']['Dec']       = 'Dec';
$_lang['DATETIME']['am']        = 'am';
$_lang['DATETIME']['pm']        = 'pm';

// Time Class Language Vars
$_lang['TIMEAGO_SUFFIXAGO']     = ' ago';
$_lang['TIMEAGO_SUFFIXFROMNOW'] = 'from now';
$_lang['TIMEAGO_SECONDS']       = 'less than a minute';
$_lang['TIMEAGO_MINUTE']        = 'about a minute';
$_lang['TIMEAGO_MINUTES']       = '%d minutes';
$_lang['TIMEAGO_HOUR']          = 'about an hour';
$_lang['TIMEAGO_HOURS']         = 'about %d hours';
$_lang['TIMEAGO_DAY']           = 'a day';
$_lang['TIMEAGO_DAYS']          = '%d days';
$_lang['TIMEAGO_WEEK']          = 'a week';
$_lang['TIMEAGO_WEEKS']         = '%d weeks';
$_lang['TIMEAGO_MONTH']         = 'about a month';
$_lang['TIMEAGO_MONTHS']        = '%d months';
$_lang['TIMEAGO_YEAR']          = 'about a year';
$_lang['TIMEAGO_YEARS']         = '%d years';