<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die("INDEX_CHECK not defined."); }
if(!defined('PANEL_CHECK')){ die('Error: Cannot include panel from current location.'); }
$objTPL->set_filenames(array(
	'body' => 'modules/core/template/panels/panel.user_index.tpl'
));


$objTPL->parse('body', false);
?>