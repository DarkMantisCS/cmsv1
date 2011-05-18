<?php
define('INDEX_CHECK', true);
include_once('core/core.php');

$objPage->setTheme('default');
$objPage->setThemeVars();
$objPage->setMenu('core', 'default');

$objPage->showHeader();


$objPage->showFooter();
?>