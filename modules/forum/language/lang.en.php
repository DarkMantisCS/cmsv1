<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
if(!isset($LANG_LOAD)){ die('Error: Cannot access directly.'); }

//breadcrumbs and page titles
$_lang['B_FORUM']						= 'Forum';
$_lang['B_POST_THREAD']					= 'Posting a thread to %s';
$_lang['B_POST_REPLY']					= 'Posting a reply to %s';
$_lang['P_PERMISSION_DENIED']			= 'Permisisons Denial';

//menu titles
$_lang['M_LATEST_POST'] 				= 'Latest Forum Posts';
$_lang['M_TOP_USER']					= 'Top Posters';

//auth info
$_lang['L_Auth_Anonymous_Users']        = '<b>anonymous users</b>';
$_lang['L_Auth_Registered_Users']       = '<b>registered users</b>';
$_lang['L_Auth_Users_granted_access']   = '<b>users granted special access</b>';
$_lang['L_Auth_Moderators']             = '<b>moderators</b>';
$_lang['L_Auth_Administrators']         = '<b>administrators</b>';
$_lang['L_AUTH_MSG']					= 'Sorry! You need to be a %s to view this thread.';
$_lang['L_AUTH_POST']					= 'Sorry, only %s can post here.';
$_lang['L_VIEW_GUEST']					= 'Sorry! You are not logged in. Please register or login to view the rest of the topic.';
$_lang['L_LOCKED']						= 'Sorry, this thread has been locked.';

//stats
$_lang['L_STATS']						= 'Stats and such';
$_lang['L_POSTS']						= 'Posts';
$_lang['L_THREADS']						= 'Threads';
$_lang['L_NO_POST']						= 'No posts';
$_lang['L_NO_REPLYS']					= 'No replies yet.';
$_lang['L_TOT_POSTS']					= 'Total Posts';
$_lang['L_TOT_THREADS']					= 'Total Threads';
$_lang['L_TOT_MEMBERS']					= 'Total Members';
$_lang['L_NEW_MEMBER']					= 'Newest Member';
$_lang['L_LEGEND']						= 'Group Legend: %s';

//threads
$_lang['L_CAT_NF']						= 'Category Not Found';
$_lang['L_THEAD_NF']					= 'Thread Not Found';
$_lang['L_THREAD_TITLE']				= 'Thread Title';
$_lang['L_POST_REPLY']					= 'Post Reply';
$_lang['L_QUICKREPLY']					= 'Quick Reply';
$_lang['L_THREAD_LOCKED']				= 'Thread Locked';
$_lang['L_LOGGED']						= 'Logged';

$_lang['L_LOCK']						= 'Lock';
$_lang['L_UNLOCK']						= 'Unlock';
$_lang['L_DELETE']						= 'Delete';
$_lang['L_MOVE']						= 'Move';
$_lang['L_QUOTE']						= 'Quote this post.';

$_lang['L_AUTHOR']						= 'Author';
$_lang['L_VIEWS']						= 'Views';
$_lang['L_LASTPOST']					= 'Latest Post';
$_lang['L_NO_THREADS']					= 'There doesn\'t seem to be any threads here.';

$_lang['L_POST_COUNT']					= '<strong>Post Count:</strong> %d';
$_lang['L_POSTED_ON']					= '<strong>Posted On:</strong> %s';
$_lang['L_LOCATION']              		= '<strong>Location:</strong> %s';
$_lang['L_USERS_IP']              		= '<strong>Users IP:</strong> %s';
$_lang['L_EDITED']						= 'Post Has Been Edited %d Times. Last Edited By %s.';


$_lang['L_WATCH_THREAD']				= 'Watch Thread';
$_lang['L_UNWATCH_THREAD']				= 'Unwatch Thread';

$_lang['L_STICKY']						= '<b>Sticky</b>: %s';
$_lang['L_ANNOUNCEMENT']				= '<b>Announcement</b>: %s';
$_lang['L_POST']						= 'Post:';

//post page
$_lang['L_OPTIONS']						= 'Options';
$_lang['L_QUICK_REPLY']					= 'Quick Reply';
$_lang['L_QR_LOCK_THREAD']				= 'Lock thread after post.';
$_lang['L_QR_PLACEHOLDER']				= 'Post a Quick Reply...';
$_lang['L_POST_BODY']             		= 'Message Body';
$_lang['L_WATCH_THREAD']             	= 'Watch this thread for replies?';
$_lang['L_AUTO_LOCK']             		= 'Auto Lock the thread?';

$_lang['L_PREVIEW']             		= 'Preview Post';

//notify
$_lang['L_THREAD_NOTIFY']				= 'Thread Reply Notification';
$_lang['L_THREAD_NOTIFY']				= 'Thread Reply Notification';
$_lang['L_USER_POSTED']					= '%s has posted a reply to %s. This was posted at %s';

//blocks
$_lang['L_SUBCATS']						= 'Sub Categories';
$_lang['L_TITLE']						= 'Title';
$_lang['L_AUTHOR']						= 'Author';


//forum stats
$_lang['L_USERSONOFF']          		= 'In total there are %d Users and %d Guests online.';
$_lang['L_USERSONLINE24']       		= '%d Users online in the past 24 hours: %s';
$_lang['L_NO_POSTS']					= 'There are no posts.';
$_lang['L_NO_ID']                 		= 'Category ID %s cannot be found. If you know of its existance, then it could be a permissions issue. '.
											'Please login or consult with a member of staff to verify you have the correct permissions.';
$_lang['L_PERMS']						= 'Sorry, but only %s can read topics in this forum.';

//icons
$_lang['I_NO_POSTS']            		= 'No New Posts';
$_lang['I_NEW_POSTS']           		= 'New Posts';
$_lang['I_LOCKED']              		= 'Locked';
$_lang['I_STICKY']              		= 'Sticky';
$_lang['I_ANNOUNCEMENT']        		= 'Announcement';

?>