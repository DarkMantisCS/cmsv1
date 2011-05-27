<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/

function menu_test($args){
	global $objTPL;
	$objTPL->set_filenames(array(
		$args['uniqueId'] => 'modules/core/template/defaultMenu.tpl'
	));

	$objTPL->assign_vars(array(
		'__' => dump($args, 'test'),
	));

	return $objTPL->get_html($args['uniqueId']);
}

?>