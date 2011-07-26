<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
if(!defined('PANEL_CHECK')){ die('Error: Cannot include panel from current location.'); }
$objPage->setTitle(langVar('B_ACP').' > '.langVar('L_OVERVIEW'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_OVERVIEW')) ));
$objTPL->set_filenames(array(
	'body'  => 'modules/core/template/panels/panel.admin_overview.tpl',
	#'wio'   => 'modules/core/user/sessions/template/sessions.tpl',
	'stats' => 'modules/core/template/panels/panel.stats.tpl',
));

$mode = doArgs('mode', false, $_GET);

$objTPL->assign_vars(array(
    'ADMIN_MODE' => langVar('L_SITE_OVERVIEW'),
));

//if we have been asked to kill a user session
if($mode == 'sessionKill'){
	$id = doArgs('id', false, $_GET, 'is_number');

	//and the id isnt false
	if($id){
		//verify the id actually exists
		$query = $objSQL->getLine($objSQL->prepare('SELECT * FROM `$Ponline` WHERE id ="%d" LIMIT 1;'));
		if($query){
			//and set it to kill, the CMS will do the rest
			unset($update);
			$update['mode'] = 'kill';

			$objSQL->updateRow('online', $update, array('id ="%d"', $query['id']));
		}
	}
}

//
//-- Updater code
//

/**
 * This section of the code will check for updates, and notify the administrator(s) upon login
 * that they need to upgrade the CMS copy. Im still sort of debating whether this could be done
 * transparently and apply all the updates without the admin's knowledge, problem here is ofc
 * that the modules and local code updates could break if the CMS auto updates itself..hmmm
 */

//
//-- Updater code
//

$objTPL->parse('body', false);
?>