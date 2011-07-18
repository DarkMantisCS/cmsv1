<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('INDEX_CHECK not defined.');}
define('PANEL_CHECK', 1);

$panels = array('admin', 'mod', 'user');
switch($mode){
case in_array($mode, $panels):
    if(is_empty($action)){ $action = 'index'; }

    //kill the menu and grab the panel
    $objPage->setMenu(false);
    $objTPL->set_filenames(array(
    	'panel' => 'modules/core/template/panel.global.tpl'
    ));

	//make sure they have the correct privs
    $break = false;
    if($mode=='admin' && !User::$IS_ADMIN){ $break = true; }
    if($mode=='mod' && !User::$IS_MOD){ $break = true; }
    if($mode=='user' && !User::$IS_ONLINE){ $break = true; }

    if($break){
    	msg('FAIL', 'Error: Permissions Denial.', '_CONTENT');
		$objTPL->parse('panel', false);
		break;
	}

	//make sure the panel name is valid
	if(!preg_match('_([a-zA-Z0-9]*)_is', $action, $panel)){
	    msg('FAIL', 'Error: Could not find Panel.', '_CONTENT'); break;
	} $panel = $panel[1];

	//set some vars
	$path = cmsROOT.'modules/core/panels/'.$mode.'/'.$panel;
    $saveUrl = $objCore->config('global', 'url').'?save';
    $url = str_replace('?save', '', $objCore->config('global', 'url'));
    $uid = (User::$IS_MOD && doArgs('uid', false, $_GET, 'is_number')) ? $_GET['uid'] : $objUser->grab('id');

	if(isset($_GET['mode']) && !is_empty($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	if(isset($_GET['save']) && is_empty($_GET['save'])){
		$mode = 'save';
	}

    if(!is_file($path.'/panel.'.$panel.'.php') || !is_file($path.'/cfg.php')){
		msg('FAIL', 'Error: Invalid Panel Selection.', '_CONTENT');
	}

	$_mode = $mode;
	include_once($path.'/panel.'.$panel.'.php');

	if(!defined('NOMENU')){
		if(!is_file(cmsROOT.'modules/core/handler.panelMenu.php')){
			hmsgDie('FAIL', 'Error: Missing Panel Menu File...Cannot Continue.');
		} include(cmsROOT.'modules/core/handler.panelMenu.php');
	}

	if(!$objTPL->isHandle('body')){
		msg('FAIL', 'Error: Panel did not output any content.', '_CONTENT');
	}

	$objTPL->assign_var('_CONTENT', $objTPL->output('body', false));
    $objTPL->parse('panel', false);
break;

default:
    $this->throwHTTP(404);
break;
}

?>