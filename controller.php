<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NO_MENU', 0);
include_once('core/core.php');


$var = substr( $config['global']['url'], strlen($config['global']['rootUrl']) );

$objPage->setMenu('core', 'default');
$objPage->showHeader();

$objURL->parseURL();

$objPage->showFooter();
?>

