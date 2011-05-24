<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NOMENU', 0);
include_once('core/core.php');

$objPage->setTheme('default');
$objPage->setThemeVars();
$objPage->setMenu('core', 'default');

$objPage->showHeader();

?>

<div class="padding" style="background-color: #f1f1f1;">
<br /><br />
<input type="text" value="" /><a class="medium blue button">&nbsp;</a>
<br /><br />
</div>

<?php

$objPage->showFooter();
?>