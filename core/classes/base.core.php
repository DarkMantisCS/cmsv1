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
				include($path[0]);

				//grab the class name from the file and make sure it exists before continuing
				$class = inBetween('.', '.php', $path[0]);
					if(!class_exists($class)){ continue; }

				//set the class to new var and continue
				if(!isset($path[1])){ $path[1] = array(); }
				$this->$var = new $class($path[1]);
				$this->classes[$var] = $this->$var;
			}else{
				die('Error: Couldn\'t load '.$var.'; File not found.');
			}
		}

		//loop through the classes after they have been all init'd
		foreach($classes as $objName => $args){
			//loop through the list again
			foreach($classes as $class => $args){
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
    function config($array, $setting, $default=null){
        global $config;

        return doArgs($setting, $default, $config[$array]);
    }


}
?>