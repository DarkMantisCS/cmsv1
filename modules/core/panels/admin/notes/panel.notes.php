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
));

$mode = doArgs('mode', false, $_GET);

$objTPL->assign_vars(array(
    'ADMIN_MODE' => langVar('L_NOTIFICATIONS'),
));

$objTPL->assign_block_vars('msg', array(
    'MSG' => msg('INFO', 'This panel is currently incomplete, please check panel source for info on this panel.', 'return'),
));

/* TODO:
hmmmm :P

*/

$objTPL->parse('body', false);
?>