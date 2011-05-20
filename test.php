<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NOMENU', 0);
include_once('core/core.php');

$objPage->setTheme('default');
$objPage->setThemeVars();
$objPage->setMenu('core', 'default');

$objPage->showHeader();

$a = $objUser->grab('timezone');
echo dump($a, 'test');

$objPage->showFooter();
?>