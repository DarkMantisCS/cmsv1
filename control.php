<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', 1);
define('cmsDEBUG', 1);
include_once('core/core.php');

/**
 * Essentially with the rewrite action, _GET variables are ignored
 * this reverses that, so anything passed to the page via _GET is
 * usable as normal
 */
$url = explode('?', $_SERVER['REQUEST_URI']);
if(isset($url[1])){
    //backup the _GET array parse_str overwrites the $_GET array
    $GET = $_GET;
    //parse the _GET vars from the url
    parse_str($url[1], $_GET);
    //and merge away :D
    $_GET = array_merge($GET, $_GET);
}
#echo dump($_GET);

$mode   = doArgs('__mode', 	 null, $_GET);
$module = doArgs('__module', 'core', $_GET);
$action = doArgs('__action', null, $_GET);
$extra  = doArgs('__extra', null, $_GET);

if(false){
	echo dump($mode) . dump($module) . dump($action) . dump($extra);
}

//user isnt even logged in lets 404 them
if(!User::$IS_ONLINE){
	$objCore->throwHTTP(404);
}

//make sure they are getting at the right panel
$checkMode = array('admin', 'mod', 'user');
if(!in_array($mode, $checkMode)){
    hmsgDie('FAIL', 'Error: Unknown Panel Group');
}

$objPage->addPagecrumb(array(
	array('url' => '/'.root().$mode.'/', 'name' => ucwords($mode).' Control Panel')
));

//check for admin panel
if($mode == 'admin' && $objUser->grab('userlevel') == ADMIN){

    if(LOCALHOST){
    	$_SESSION['acp']['adminAuth'] = true;
    }

    //check to see if theyre authed
    if($_SESSION['acp']['adminAuth']!=true && !LOCALHOST){
        $_SESSION['acp']['doAdminCheck'] = true;
        $objPage->redirect('/'.root().'login.php', 0, 0);
        hmsgDie('FAIL', 'Error: You need to be auth\'d to access this area.');
    }

    //we also need to update the timestamp
    $_SESSION['acp']['adminTimeout'] = time();
	$objPage->setVar('acpMode', true);
}

if($mode == 'mod' && !User::$IS_MOD){
    $objPage->redirect('/'.root().'index.php', 0, 2);
    hmsgDie('FAIL', 'Error: Your permissions do not let you access this area.');
}
if($mode == 'user' && !User::$IS_ONLINE){
    $objPage->redirect('/'.root().'login.php', 0, 2);
    hmsgDie('FAIL', 'Error: You need to be logged in to access this area.');
}


//if the desktop files are there then we'll load that and we need to switch to alt mode :D
if(is_dir($objPage->acpThemeROOT) && $mode == 'admin'){
	if(!empty($module) && $objCore->loadModule('core', true, $mode)){
	    $objModule = new core($objCore);
	    $objModule->doAction(($module=='core' ? '' : $module));
	}else{
	    $objCore->throwHTTP(404);
	}

//else we stick to sensible mode
}else{
	//if we are tryin to load a core panel..
	if(strtolower($module)=='core'){
	    require(cmsROOT.'modules/core/handler.panels.php');
	}else{
	    if(!empty($module) && $objPage->loadModule($module, true, $mode)){
	        $objModule = new $module($objCore);
	        $objModule->doAction($action);
		}else{
		    $objCore->throwHTTP(404);
		}
	}
}

//check if we need to force simple mode
$doSimple = false;
if(isset($_GET['ajax']) || HTTP_AJAX || $objPage->getVar('tplMode')){
	$doSimple = true;
}

$objPage->showHeader($doSimple);
    if($__eval = $objTPL->output(($objTPL->isHandle('panel') ? 'panel' : 'body'))){
        msgDie('FAIL', 'No output received from module.');
    }
$objPage->showFooter($doSimple);