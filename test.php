<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NO_MENU', 0);
include_once('core/core.php');
$objPage->setMenu('core', 'default');
$objPage->showHeader();

$modules = $objSQL->getTable( $objSQL->prepare(
	'SELECT * FROM `$Pmodules`'
));

foreach($modules as $module)
{
	$this->cached[$module['name']] = $module;
}

$objPage->showFooter();
?>