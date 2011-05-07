<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//some HTTP definitions
    define('HTTP_AJAX', (
                            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') &&
                            (isset($_SERVER['HTTP_X_CMS_IS']) && strtolower($_SERVER['HTTP_X_CMS_IS']) == 'cybershade')
	                            ? true
	                            : false)
                        );
    define('HTTP_POST', ($_SERVER['REQUEST_METHOD']=='POST' ? true : false));
    define('HTTP_GET', 	($_SERVER['REQUEST_METHOD']=='GET' ? true : false));

?>