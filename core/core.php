<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

//
//--Before we begin, lets define some stuff up
//
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
    define('cmsROOT', (isset($cmsROOT) && !empty($cmsROOT) ? $cmsROOT : NULL));

    //so we can turn errors off if we are not running locally
    define('LOCALHOST', (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost') ? true : false);

    //define the error reporting level, dont want PHP errors on the live version now do we :)
    error_reporting(LOCALHOST ? E_ALL & ~E_NOTICE | E_STRICT : 0);

	//if the killCMS file is present we need to kill execution right here
    if(is_file(cmsROOT.'killCMS')){
        die(sprintf($errorTPL, 'Fatal Error', 'This CMS has detected a Security Flaw. Please Upgrade to the latest version.'));
    }

    //check if we have config
/*
	$file = cmsROOT.'core/config.php';
    if(!is_file($file)){
        die(sprintf($errorTPL, 'Fatal Error', 'This seems to be your first time running. Are you looking for <a href="install/">Install/</a> ?'));
    }

    //make sure the file is readable, if so require it
    if(!is_readable($file)){
        die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the configuration file.'));
    }else{ require_once($file); }
*/
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

    //kill magic quotes completely
    if(@get_magic_quotes_gpc()){
	    /**
	     * Stripslashes recursively through an array
	     *
	     * @version	1.0
	     * @since   1.0.0
	     *
	     * @param   array	$value
	     *
	     * @return 	array
	     */
        function stripslashes_deep($value){
            return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
        }

		//strip all the global arrays
        $_POST      = array_map('stripslashes_deep', $_POST);
        $_GET       = array_map('stripslashes_deep', $_GET);
        $_COOKIE    = array_map('stripslashes_deep', $_COOKIE);
        $_REQUEST   = array_map('stripslashes_deep', $_REQUEST);
    }

    $file = cmsROOT.'core/baseFunctions.php';
    if(!is_readable($file)){
        die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the baseFunctions file.'));
    }else{ require_once($file); }

