<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//Highlight and Row Stuff
//row_color1 and 2 should be the same in the css files
$tpl['row_highlight']       = '#bebebe';


$i = '/'.root().Page::$THEME_ROOT.'buttons/';
$img = '/'.root().'images/bbcode/';

$tpl['IMG_locked']          = $i.'locked_old.png';
$tpl['IMG_moved']           = $i.'redirected.png';
$tpl['IMG_posts_new']       = $i.'new.png';
$tpl['IMG_posts_old']       = $i.'old.png';
$tpl['IMG_announcement_new']= $i.'redir_new.png';
$tpl['IMG_announcement_old']= $i.'redir_old.png';
$tpl['IMG_sticky_new']      = $i.'sticky.png';
$tpl['IMG_sticky_old']      = $i.'sticky.png';
$tpl['IMG_subForum_new']    = $i.'bullet.gif';
$tpl['IMG_subForum_old']    = $i.'bullet.gif';

$tpl['FIMG_post_edit']      = $i.'edit.png';
$tpl['FIMG_post_move']      = $i.'move.png';
$tpl['FIMG_post_del']       = $i.'delete.png';
$tpl['FIMG_locked']         = $i.'lock.png';
$tpl['FIMG_unlocked']       = $i.'unlock.png';

$tpl['FIMG_reply']          = $img.'comments.png';

$tpl['PM_compose']			= $i.'sendpm.gif';
$tpl['PM_reply']			= $i.'reply_small.gif';

$tpl['IMG_expand']          = $i.'maximize.png';
$tpl['IMG_retract']         = $i.'minimize.png';

$tpl['USER_ONLINE']         = $i.'online.png';
$tpl['USER_OFFLINE']        = $i.'offline.png';
$tpl['USER_HIDDEN']         = $i.'hidden.png';

$objPage->updateTplVars($tpl);
unset($tpl);
?>