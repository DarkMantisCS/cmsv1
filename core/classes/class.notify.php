<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles notifications across the system
 *
 * @version 	1.0
 * @since 		1.0.0
 * @author 		xLink
 */
class notify extends coreClass{

	/**
	 * Outputs the notifications to the user
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	int 	$id  		ID of the notification
	 * @param	string	$message	Message to output in the notification
	 * @param	string	$title		Title of the notification
	 * @param	bool	$sticky		Whether to dissapear or stay on screen
	 */
	public function outputNotification($id, $msg, $title, $sticky=false){
		$msg = addslashes($msg);
		$msg = str_replace(array("\t"),
							array(''),
							html_entity_decode($msg));

		$this->objPage->addJSCode('showNotification("'.$id.'", "'.$msg.'", "'.$title.'", '.$sticky.');');
	}

	/**
	 * Set all notifications or a specific one to read
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	int 	$notifID 	ID of the notification or 0
	 * @param	bool	$module		Message to output in the notification
	 * @param	int 	$uid		0 for current user, or UID of user
	 *
	 * @return 	bool
	 */
	public function clearNotifications($notifID=0, $module=false, $uid=0){
		$user = ($uid==0 ? $this->objUser->grab('id') : $this->objUser->getUserInfo($uid));

		$updateClause = array();
		$updateClause[0] = 'uid="%s"';
		$updateClause[1] = $user;

		$update['read'] = time();

		$log = 'Notification System: All notifcations for '.$this->objUser->getUserInfo($uid, 'username').' set to read.';
		if(is_number($notifID) && $notifID > 0){
			$updateClause[0] .= ($module===true ? ' module_id="%s"' : ' id="%s"');
			$updateClause[] = $notifID;
			$log = null;
		}

		$query = $this->objSQL->updateRow('notifications', $update, $updateClause, $log);
		if(!$query){
			$this->setError('Cannot set Notification(s) as read. SQL: '.$this->objSQL->getError());
			return false;
		}

		return true;
	}

	/**
	 * Gets all notifications for the user
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	bool 	$read	true to return read notifications
	 * 							false to return unread
	 * 							and null to return all notifications
	 * @param	int 	$uid	0 for current user, or UID of user
	 */
	public function getNotifications($read=null, $uid=0){
		if($read===true){ 			$read = ' and `read`="1"'; }
		else if($read===false){ 	$read = ' and `read`="0"'; }

		$user = ($uid==0 ? $this->objUser->grab('id') : $this->objUser->getUserInfo($uid));
		if(is_empty($user)){
			$this->setError('Invalid User ID.');
			return false;
		}

		$query = $this->objSQL->getTable($this->objSQL->prepare(
			'SELECT * FROM `$Pnotifications` WHERE uid="%s"' . $read,
			$user['uid']
		));

		if(!$query || !is_array($query)){ return false; }
		return $query;
	}

	/**
	 * Sends a notification to the user
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param	int		$uid		0 for current user, or UID of user
	 * @param	string	$message	Message to output in the notification
	 * @param	int		$moduleID	ID that corresponds with the content peice for that module
	 *
	 * @return 	bool
	 */
	public function notifyUser($uid, $message, $moduleId=0){
		global $objModule;

		$user = $this->objUser->getUserInfo($uid);
		if(is_empty($user)){
			$this->setError('Invalid User ID.');
			return false;
		}

		$insert['uid'] 			= $user['uid'];
		$insert['type'] 		= 0; //not implemented yet
		$insert['body'] 		= secureMe($message);
		$insert['timestamp'] 	= time();
		$insert['title'] 		= !is_empty($title) ? $title : null;
		$insert['module'] 		= $objModule->module;
		$insert['module_id'] 	= is_number($moduleId) ? $moduleId : 0;

		$insert = $this->objSQL->insertRow('notifications', $insert);

		if(!mysql_affected_rows()){
			$this->setError('Inserting notification failed. SQL: '.$this->objSQL->getError());
			return false;
		}
		return true;
	}

	/**
	 * Outputs a notification straight to the browser
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param	int		$uid		0 for current user, or UID of user
	 * @param	string	$message	Message to output in the notification
	 * @param	int		$moduleID	ID that corresponds with the content peice for that module
	 */
	public function sendNotify($message, $title, $sticky=false){
		$this->objPage->addJSCode('notify("'.addslashes($message).'", "'.$title.'", '.(!$sticky ? 'false' : 'true').');'."\n");
	}

}

?>