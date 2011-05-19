<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//some HTTP definitions
	define('HTTP_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
							&& (isset($_SERVER['HTTP_X_CMS_IS']) && strtolower($_SERVER['HTTP_X_CMS_IS']) == 'cybershade')
								? true
								: false));
	define('HTTP_POST', ($_SERVER['REQUEST_METHOD']=='POST' ? true : false));
	define('HTTP_GET', 	($_SERVER['REQUEST_METHOD']=='GET' ? true : false));

//Hook Priority Constants
	define('LOW', 	1);
	define('MED', 	2);
	define('HIGH', 	3);

//User levels
	define('BANNED',	-1);
	define('GUEST',		0);
	define('USER', 		1); //DONT CHANGE THIS
	define('MOD',		2); //OR THIS...i kill you DEAD!
	define('ADMIN',		3);

?>