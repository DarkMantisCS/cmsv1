<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//
//--Before we begin, lets define some stuff up
//
	$START_CMS_LOAD = microtime(true);
	//Lets set a simple error template up till we have the template engine going
	$errorTPL = '<h3>%s</h3> <p>%s Killing Process...</p>';
	@set_magic_quotes_runtime(false);

	//if we havent a session, lets start one up
	if(!isset($_SESSION)){ session_start(); }

	//setup a few things, these are kept out of the constants.php file cause we need em before thats included.
	define('cmsVERSION', '1.0.0');
	if(!defined('cmsDEBUG')){
		define('cmsDEBUG', false);
	}

	/**
	 * cmsROOT - Internal way of getting to the project root
	 * @note for internal use, use cmsROOT, for external use, eg js and html paths, use root();
	 */
	define('cmsROOT', (isset($cmsROOT) && !empty($cmsROOT) ? $cmsROOT : null)); unset($cmsROOT);

	//so we can turn errors off if we are not running locally
	define('LOCALHOST', (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost') ? true : false);

	//define the error reporting level, dont want PHP errors on the live version now do we :)
	error_reporting(LOCALHOST ? E_ALL & ~E_NOTICE | E_STRICT : 0);

	//if the killCMS file is present we need to kill execution right here
	if(is_file(cmsROOT.'killCMS')){
		die(sprintf($errorTPL, 'Fatal Error', 'This CMS has detected a Security Flaw. Please Upgrade to the latest version.'));
	}

	//check if we have config
	$file = cmsROOT.'core/config.php';
	if(!is_file($file)){
		die(sprintf($errorTPL, 'Fatal Error', 'This seems to be your first time running. Are you looking for <a href="install/">Install/</a> ?'));
	}

	//make sure the file is readable, if so require it
	if(!is_readable($file)){
		die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the configuration file.'));
	}else{ require_once($file); }


	//we need constants.php, same deal as above
	$file = cmsROOT.'core/constants.php';
	if(!is_readable($file)){
		die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the constants file.'));
	}else{ require_once($file); }


	$redoHandler = false;
	$file = cmsROOT.'core/debugFunctions.php';
	if(!is_readable($file)){
		function dump(){} function getExecInfo(){} function memoryUsage(){}
	}else{ $redoHandler = true; require_once($file); }


	$file = cmsROOT.'core/baseFunctions.php';
	if(!is_readable($file)){
		die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the baseFunctions file.'));
	}else{ require_once($file); }

	//kill magic quotes completely
	if(@get_magic_quotes_gpc()){
		//strip all the global arrays
		recursiveArray($_POST, 		'stripslashes');
		recursiveArray($_GET, 		'stripslashes');
		recursiveArray($_COOKIE, 	'stripslashes');
		recursiveArray($_REQUEST, 	'stripslashes');
	}

	(LOCALHOST ? set_error_handler('cmsError') : '');
	if($redoHandler && cmsDEBUG == true){
		set_error_handler('error_handler');
		set_exception_handler('exception_handler');
		register_shutdown_function('fatal_error_handler');
	}unset($redoHandler);

	//set the default timezone
	if(function_exists('date_default_timezone_set')){
		date_default_timezone_set('Europe/London'); //ive set it to London, as i use the GMdate functions
	}

//
//--Classes Setup
//
	$classDir = cmsROOT.'core/classes/';
	$classes = array();
	//$classes[$varName] => array($classPath, [args array('var'=>'value')])

	//load in outside classes
	$classFiles = array('base.core.php', 'base.sql.php', 'class.phpass.php');#, 'class.recaptcha.php');
		foreach($classFiles as $file){
			$file = $classDir.$file;
			if(!is_file($file) || !is_readable($file)){
				msgDie('FAIL', sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the '.$file.' file.'));
			}else{ require_once($file); }
		}
	$objCore = new coreClass;

	//cache setup
	$cachePath = cmsROOT.'cache/';
	if(is_dir($cachePath) && !is_writable($cachePath)){ @chmod($cachePath, 0775); }
	if(!is_writable($cachePath)){
		msgDie('FAIL', sprintf($errorTPL, 'Fatal Error', 'Could not set CHMOD permissions on "<i>cache/</i>" set to 775 to continue.'));
	}

	$cacheWritable = (is_writable($cachePath) ? true : false);

	//try and load in the sql driver
	$file = $classDir.'driver.'.$config['db']['driver'].'.php';
	if(is_file($file) && is_readable($file)){
		$classes['objSQL']		= array($file, $config['db']);
	}

	//if its still unset, default back to mysql
	if(!isset($classes['objSQL'])){
		$classes['objSQL']		= array($classDir.'driver.mysql.php', $config['db']);
	}
	$classes['objCache']		= array($classDir.'class.cache.php', array(
									'useCache' 	=> $cacheWritable,
									'cacheDir' 	=> $cachePath
								));

	$objCore->setup($classes);
	unset($classes);

	$objCore->objSQL->connect(true, false, false);
	unset($config['db']);
//
//--Cache Vars init
//
		//if it didnt, check to see which of the files didnt get added and try to get them manually
		if(!isset($config_db)){ 			newCache('config', $config_db); }

		//We have no configuration DB, and the one generated was NULL...
		if(!isset($config_db) || $config_db===NULL || empty($config_db)){
			//this will only happen if the CMS wasnt installed properly
			//or hasnt got access to her original tables
			msgDie('FAIL', sprintf($errorTPL, 'Fatal Error',
				'Cannot load CMS Configuration, make sure installation ran properly and mySQL user has access to tables.'));
		}

		//generate an array with names of files that should be added to the master config array()
		//NULL _SHOULD_ be the last 'file'
		$cache_gen  = array('menus', 'menu_setups', 'menu_blocks', 'groups', 'bans', 'group_subscriptions', 'statistics', 'modules', 'plugins', NULL);

		if(!isset($menus_db)){ 				newCache('menus', $menus_db); }
		if(!isset($menu_setups_db)){ 		newCache('menu_setups', $menu_setups_db); }
		if(!isset($menu_blocks_db)){ 		newCache('menu_blocks', $menu_blocks_db); }
		if(!isset($groups_db)){ 			newCache('groups', $groups_db); }
		if(!isset($bans_db)){ 				newCache('bans', $bans_db); }
		if(!isset($user_permissions_db)){ 	newCache('group_subscriptions', $user_permissions_db); }
		if(!isset($statistics_db)){ 		newCache('statistics', $statistics_db); }
		if(!isset($modules_db)){ 			newCache('modules', $modules_db); }
		if(!isset($plugins_db)){ 			newCache('plugins', $plugins_db); }

		//sort through the configuration crap, spit out a useable version :D
		foreach($config_db as $array){ $config[$array['array']][$array['var']] = $array['value']; }
		unset($config_db);
echo dump($config);
		//set all the *_db vars above into the $config array
		$x = 0;
		while($var = $cache_gen[$x]){
			if(!is_empty($var)){
				$gen = NULL;
				$gen = isset(${$var.'_db'}) ? ${$var.'_db'} : NULL;

				if(!is_array($gen) || is_empty($gen) || $gen===false){
					$config[$var] = NULL;
				}else{
					foreach($gen as $k => $v){ $config[$var][$k] = $v; }
				}
			}

			unset(${$var.'_db'});
			$x++;
		}

		//clean the variable pool, keeping things nice and tidy
		unset($cache_gen, $var);

		//do a few checks on the cache, see whats what
		if(is_empty($config['menu_blocks']) && !defined('NOMENU')){
			 define('NOMENU', true);
		}

	$classes['objTPL']			= array($classDir.'class.template.php', array(
									'root' 		=> '.',
									'useCache' 	=> $cacheWritable,
									'cacheDir' 	=> $cachePath.'template/'
								));

	$classes['objPlugins']		= array($classDir.'class.plugins.php');
	$classes['objPage'] 		= array($classDir.'class.page.php');
	$classes['objUser'] 		= array($classDir.'class.user.php');
	$classes['objForm'] 		= array($classDir.'class.form.php');
	$objCore->setup($classes);

	//globalise the class names
	foreach($objCore->classes as $objName => $args){ $$objName = $objCore->$objName; }
	unset($classes, $objCore->classes);
