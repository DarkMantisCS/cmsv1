<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

//
//--Before we begin, lets define some stuff up
//
    //Lets set a simple error template up till we have the template engine going
    $errorTPL = '<h3>%s</h3> <p>%s Killing Process...</p>';
	@set_magic_quotes_runtime(false);
    
    //if we havent a session, lets start one up
    if(!isset($_SESSION)) session_start();

    define('cmsVERSION', '1.x.x');
    if(!defined('cmsDEBUG')) define('cmsDEBUG', false);

    //cmsROOT - The Internal way of finding things
    //for internal use, use cmsROOT, for external use, eg js and html paths, use root();
    define('cmsROOT', (isset($cms_root) && !empty($cms_root) ? $cms_root : NULL));
    
    //so the rest of the CMS knows where we are running from.
    define('LOCALHOST', ((isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost') ? true : false));

    //define the error reporting level, dont want PHP errors on the live version now do we :)
    error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
//
//--Include the core CMS files needed 
//
    //Kill the killSwitch
    $file = cmsROOT.'killCMS';
    if(is_writable($file)){ unlink($file); }

    //The config file
    $file = cmsROOT.'core/config.php';
    if(is_file($file) && file_get_contents($file)!='' && !isset($_SESSION['allow_config'])){
        die(sprintf($errorTPL, 'Fatal Error', 'CMS has already been installed. Cannot run installer.'));
    }

    $file = cmsROOT.'core/constants.php';
    if(!is_readable($file)){
        die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the constants file.'));
    }else{ require_once($file); }

    $file = cmsROOT.'core/debugFunctions.php';
    if(!is_readable($file)){
        function dump(){} function getExecInfo(){} function memoryUsage(){}
    }else{ require_once($file); }


    //kill magic quotes
    $test = get_magic_quotes_gpc();
    if($test){
        function stripslashes_deep($value){
            $value = is_array($value) 
                        ? array_map('stripslashes_deep', $value)
                        : stripslashes($value);
    
            return $value;
        }
    
        $_POST      = array_map('stripslashes_deep', $_POST);
        $_GET       = array_map('stripslashes_deep', $_GET);
        $_COOKIE    = array_map('stripslashes_deep', $_COOKIE);
        $_REQUEST   = array_map('stripslashes_deep', $_REQUEST);
    }

    $file = cmsROOT.'core/baseFunctions.php';
    if(!is_readable($file)){
        die(sprintf($errorTPL, 'Fatal Error - 404', 'We have been unable to locate/read the baseFunctions file.'));
    }else{ require_once($file); }
    
    //set error handler
    set_error_handler('cmsError');

    //set the default timezone
    if(function_exists('date_default_timezone_set')){
        date_default_timezone_set('Europe/London'); //ive set it to London, as i use the GMdate functions 
    }

            
//
//--Classes Including
//
    $file = cmsROOT.'classes/raw.classes.php';
    if(!is_readable($file)){
        $classes = array(
                          //Teir 1 classes - _NEEDED_ classes
                            'sql', 'cache', 'tpl', 'page', 'user', 'login',
                          //Teir 2 classes - required classes
                            'form', 'time',
                          //Teir 3 classes - required classes
                            'comments', 'pagination', 'rating'
                        );
        
        foreach($classes as $file){
            $file = cmsROOT.'core/classes/class.'.$file.'.php';
            if(!is_readable($file)){
                msgDie('FAIL', 'Fatal Error: Cannot open '.$file.' for include.');
            }else{ require($file); }
        }

    }
    
    //include what Libary files are needed.
        //geshi has been modified slightly to work better with the CMS
        $file = cmsROOT.'core/lib/geshi/class.geshi.php';
        if(!is_readable($file)){
            msgDie('FAIL', sprintf($errorTPL, 'Fatal Error', 'Cannot open '.$file.' for include.'));
        }else{ require($file); }
        
        //NBBC has been modified to remove some of the errors in E_ALL mode.
        $file = cmsROOT.'core/lib/nbbc/class.nbbc.php';
        if(!is_readable($file)){
            msgDie('FAIL', sprintf($errorTPL, 'Fatal Error', 'Cannot open '.$file.' for include.'));
        }else{ require($file); }
        
//
//--Define new instances of the included classes
//
    //
    //--Language Setup
    //
        $language = isset($config['site']['language']) ? $config['site']['language'] : 'en';
        if(isset($_SESSION['user']['language'])){
            if(is_dir(cmsROOT.'language/'.$_SESSION['user']['language'].'/') &&
               is_readable(cmsROOT.'language/'.$_SESSION['user']['language'].'/main.php')){
                    $language = $_SESSION['user']['language'];
            }
        }
        if(!is_dir(cmsROOT.'language/'.$language.'/') || !is_readable(cmsROOT.'language/'.$language.'/main.php')){
            msgDie('FAIL', sprintf($errorTPL, 'Fatal Error', 'Cannot open '.(cmsROOT.'language/'.$language.'/main.php').' for include.'));
        }else{ require(cmsROOT.'language/'.$language.'/main.php'); }
    //
    //--SQL Setup
    //
        $objSQL = false;

    //
    //--Set the rest of the classes up
    //
        $objTPL     = new Template('.', false, '');
            $objTPL->setVar('objSQL', (is_object($objSQL) ? $objSQL : false));
            
        $objUser    = new User;
            $objUser->setVar('objSQL', (is_object($objSQL) ? $objSQL : false));
            
        $objForm    = new Form;
        $objTime    = new Time;
            $objTime->setVar('config', $config);
            $objTime->setVar('objUser', $objUser);

        $objBBCode = new BBCode;
        $objBBCode->SetDebug(true);
        $objBBCode->SetDetectURLs(false);
        $objBBCode->ClearSmileys();
        $objBBCode->SetSmileyDir('/'.root().'images/smilies');
        include(cmsROOT.'core/bbcode_tags.php');

?>