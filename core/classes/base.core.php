<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
 * Group Class designed to allow easier access to expand on the group system implemented
 *
 * @version 	1.0
 * @since 		1.0.0
 * @author 		xLink
 */
class coreClass{

	/**
	 * Autoloads the $classes
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	bool 	$classes
	 */
	final public function setup($classes=false){
		if(!is_array($classes)){ return false; }

		//loop through $classes for loading purposes
		foreach($classes as $var => $path){
			//make sure the file is there
			if(file_exists($path[0]) && is_readable($path[0])){
				//require the file
				include_once($path[0]);

				//explode the filename, so we dont get interference pre-filename
				$fileName = explode('/', $path[0]);

				//grab the class name from the file and make sure it exists before continuing
				$class = inBetween('.', '.php', end($fileName));
					if(!class_exists($class)){ continue; }

				//set the class to new var and continue
				if(!isset($path[1])){ $path[1] = array(); }
				$this->$var = new $class($path[1]);
				$this->classes[$var] = $this->$var;
			}else{
				die('Error: Couldn\'t load '.$var.'; File not found.');
			}
		}

		if(is_empty($this->classes)){
			$this->setError('No Classes Defined');
			return false;
		}

		//loop through the classes after they have been all init'd
		foreach($this->classes as $objName => $args){
			//loop through the list again
			foreach($this->classes as $class => $args){
				//if this one is == parent, skip it..
				if($objName == $class){ continue; }

				//assign $class, to the parent $objName so all classes can see eachother
				$this->$objName->setVar($class, $this->$class);
			}
		}
		return true;
	}

	/**
	 * Sets a variable with a value
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string 	$var
	 * @param 	mixed	$value
	 */
	public function setVar($var, $value){
		$this->$var = $value;
	}

	/**
	 * Sets multiple variables with values
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	array 	$array
	 */
	public function setVars($array){
		if(!is_array($array)){ return false; }

		foreach($array as $k => $v){
			$this->$k = $v;
		}
		return true;
	}

	/**
	 * Returns a var's value
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string 	$var
	 *
	 * @return 	mixed
	 */
	public function getVar($var){
		return (isset($this->$var) ? $this->$var : false);
	}


	/**
	 * Returns a config variable
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string 	$array
	 * @param 	string 	$setting
	 * @param 	mixed 	$default
	 *
	 * @return 	mixed
	 */
    public function config($array, $setting, $default=null){
        global $config;

        return doArgs($setting, $default, $config[$array]);
    }

	/**
	 * Returns the last error set.
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @return  string
	 */
    public function error(){
    	return $this->_error;
	}

	/**
	 * Allows for an error to be set just before returning false
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string $msg
	 */
    public function setError($msg){
    	$this->_error = (string)$msg;
	}

	/**
	 * Throws a HTTP Error Code and a pretty CMS Page
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	int	$error
	 */
	public function throwHTTP($error=000){
		$msg = NULL;
		switch($error){
			default:
			case 000:
				$msg = 'Something went wrong, we cannot determine what. HTTP Error: '.$error;
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