<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles page generation
 *
 * @version 	1.0
 * @since 		1.0.0
 * @author 		xLink
 */
class login extends coreClass{

	public function onlineData(){
		if(isset($this->onlineData)){
			return $this->onlineData;
		}

		$query = $this->objSQL->prepare('SELECT * FROM `$Ponline` WHERE userkey="%s"', $_SESSION['user']['userkey']);
		return $this->onlineData = $this->objSQL->getLine($query);
	}

}
?>