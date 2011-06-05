<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NO_MENU', 0);
$_SERVER['REQUEST_METHOD'] = 'POST';
include_once('core/core.php');

$objPage->setMenu('core', 'default');
$objPage->showHeader();

$vars = array(
	'USERNAME' => 'rawr ;)',
	'URL' => 'google.com',
);
$message = $objCore->config('email', 'E_LOGIN_ATTEMPTS');

$email = parseMenuParams($message);
echo dump($email);
$objTPL->assign_vars($vars);
$objTPL->parseString('email', $message, false);

$str = $objTPL->get_html('email');
echo dump($str);

echo $str;






/*
$_POST['username'] = 'xLink';
$_POST['password'] = 'k3rk2r3';
$error = $objLogin->doLogin();
if(!$error){
	msgDie('FAIL', $objLogin->error());
}
*/
$objPage->showFooter();
?>