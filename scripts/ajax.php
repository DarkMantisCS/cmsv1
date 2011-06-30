<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', true);
define('cmsDEBUG', false);
define('cmsCLOSED', true);
define('NO_LOG', true);

$cmsROOT = '../';
include_once($cmsROOT.'core/core.php');

//assign some vars
$mode       = doArgs('action', null, $_GET);
$username   = $objSQL->escape(doArgs('username', null, $_POST));
$email      = $objSQL->escape(doArgs('email', null, $_POST));

if(!HTTP_AJAX){ die('Failed.'); }

switch($mode){
    case 'grabNewNotifications':
    	//grab the notifications for the user
    	$notes = $objNotify->get(false);
	    	if(!$notes){ die(); }


		//see if we have any to output
    	$return = '';
    	foreach($notes as $note){
    	    $return .= 'if(!isset($("notify-'.$note['id'].'"))){ '. $objNotify->output($note['id'], $note['msg'], $note['title'], true).' }';
    	}

    	die($return);
    break;
}
?>