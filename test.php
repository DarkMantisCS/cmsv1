<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NOMENU', 0);
include_once('core/core.php');

$objPage->setMenu('core', 'default');

$objPage->showHeader();


$objPage->showFooter();
?>