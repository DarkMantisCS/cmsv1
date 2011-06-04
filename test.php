<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NO_MENU', 0);
include_once('core/core.php');

$objPage->setMenu('core', 'default');
$objPage->showHeader();

#$objUser->setSessions(1);


$objPage->showFooter();
?>