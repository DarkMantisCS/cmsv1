<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
include_once('core/core.php');

$objPage->setTheme('default');
$objPage->setThemeVars();
$objPage->setMenu('core', 'default');

$objPage->showHeader();


$objPage->showFooter();
?>