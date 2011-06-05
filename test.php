<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NO_MENU', 0);
$_SERVER['REQUEST_METHOD'] = 'POST';
include_once('core/core.php');

$objPage->setMenu('core', 'default');
$objPage->showHeader();


session_destroy();

$objPage->showFooter();
?>