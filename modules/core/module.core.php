<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if (!defined('INDEX_CHECK')) die("INDEX_CHECK not defined.");

class core extends Module{

	function doAction(){


	}



	function getNotifications(){
		$notifcations = $this->objNotify->get(false);
		if(!$notifications){
			return false;
		}
	}

	function clearNotification($notifyID){
		$this->objNotify->clear($notifyID);
	}
}
?>