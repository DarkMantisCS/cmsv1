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
    define('HTTP_GET',     ($_SERVER['REQUEST_METHOD']=='GET' ? true : false));

//Hook Priority Constants
    define('LOW',     1);
    define('MED',     2);
    define('HIGH',     3);

//Profile() Settings
    define('LINK', 0);
    define('NO_LINK', 1);
    define('RAW', 2);
    define('RETURN_USER', 3);

//User levels
    define('BANNED',    -1);
    define('GUEST',        0);
    define('USER',         1); //DONT CHANGE THIS
    define('MOD',        2); //OR THIS...i kill you DEAD!
    define('ADMIN',        3);

//Group settings
    define('GROUP_OPEN',     0);
    define('GROUP_CLOSED',    1);
    define('GROUP_HIDDEN',    2);

//ACL settings
    define('AUTH_LIST_ALL', 0);
    define('AUTH_ALL', 0);

    define('AUTH_REG', 1);
    define('AUTH_ACL', 2);
    define('AUTH_MOD', 3);
    define('AUTH_ADMIN', 5);

    define('AUTH_VIEW', 1);
    define('AUTH_READ', 2);
    define('AUTH_POST', 3);
    define('AUTH_REPLY', 4);
    define('AUTH_EDIT', 5);
    define('AUTH_DELETE', 6);
    define('AUTH_MOVE', 7);
    define('AUTH_SPECIAL', 8);

//Avalible in 2.5.7+
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
?>