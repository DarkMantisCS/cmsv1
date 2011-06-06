<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', 1);
define('cmsDEBUG', 1);
include_once('core/core.php');

/**
 * grab the 'request_string' from the url itself
 * at this point php wont auto parse the _GET vars
 * cause of the rewrite actions..in the url, so we
 * have to do it :D
 */

//explode the url
$url = explode('?', $_SERVER['REQUEST_URI']);
if(isset($url[1])){
    //parse the _GET vars from the url
    parse_str($url[1], $_nGET);
    //and merge the new GET with the old one :D
    $_GET = array_merge($_nGET, $_GET);
}

$module = isset($_GET['__module'])                              ? $_GET['__module'] : '';
$action = isset($_GET['__action']) && !empty($_GET['__action']) ? $_GET['__action'] : '';
$extra  = isset($_GET['__extra'])                               ? $_GET['__extra']  : '';

if(!preg_match('#install($|/)#i', $action)){
    if(!empty($module) && $objCore->loadModule($module, true)){
        $objModule = new $module($objCore);
        $objModule->doAction($action);
    }else{
        $objCore->throwHTTP(404);
    }
}else{
    $objCore->autoLoadModule('core', $objModule);
    $objModule->installModule($module);
}

$tplMode = $objPage->getVar('tplMode');
$objPage->showHeader((!$tplMode&&!isset($_GET['ajax']) ? false : true));
    if($__eval = $objTPL->output('body')){
        msgDie('FAIL', 'No output received from module.');
    }
$objPage->showFooter((!$tplMode&&!isset($_GET['ajax']) ? false : true));
?>