<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles everything modules!
 *
 * @version 	2.0
 * @since 		1.0.0
 * @author 		xLink
 */
class Module extends coreClass{

	function __construct() {

	}

	public function _error($err=000){
		$msg = NULL;
		switch($err){
			default:
			case 000:
				$msg = 'Something went wrong, we cannot determine what.';
			break;

			case 400:
				header("HTTP/1.0 400 Bad Request");
				$this->objPage->setTitle('Error 400 - Bad Request');
				$msg = 'Error 400 - The server did not understand your request.' .
						' If the error persists contact an administrator with details on how to replicate the error.';
			break;

			case 403:
				header("HTTP/1.0 403 Forbidden");
				$this->objPage->setTitle('Error 403 - Forbidden');
				$msg = 'Error 403 - You have been denied access to the requested page.';
			break;

			case 404:
				header("HTTP/1.0 404 Not Found");
				$this->objPage->setTitle('Error 404 - Page Not Found');
				$msg = 'Error 404 - The file you were looking for cannot be found.';
			break;

			case 500:
				header("HTTP/1.0 500 Internal Server Error");
				$this->objPage->setTitle('Error 500 - Internal Server Error');
				$msg = 'Error 500 - Oops it seems we have broken something..   ';
			break;
		}

		hmsgDie('FAIL', $msg);
	}


}

?>