<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', 1);
define('cmsDEBUG', 1);
include_once('core/core.php');

$module = $objCore->config('site', 'default_module');
if(is_dir(cmsROOT.'modules/'.$module.'/') && is_readable(cmsROOT.'modules/'.$module.'/cfg.php')){
	if(!preg_match('/function\sshowMain\(/is', file_get_contents(cmsROOT.'modules/'.$module.'/class.'.$module.'.php'))){
		$module = 'core';
	}
	include(cmsROOT.'modules/'.$module.'/class.'.$module.'.php');
	$objModule = new $module($objPage, $objSQL, $objTPL, $objUser, $objTime, $objForm, $objComments);
	$objModule->showMain();  
}else{
	hmsgDie('FAIL', 'Sorry you dont have the correct permissions to access the '.$module.' Module.');
}

$objPage->showHeader();
	if(!$objTPL->get_html('body')){
		msgDie('FAIL', 'No output received from module.');
	}else{
		echo $objTPL->get_html('body');
	}
$objPage->showFooter();
?>