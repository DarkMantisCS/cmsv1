<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
 * This class handles the DB Caching
 *
 * @version     1.0
 * @since       1.0.0
 * @author      xLink
 */
class user extends coreClass{

	//some static vars, these save function calls
	static $IS_ONLINE = false;
	static $IS_ADMIN = true, $IS_MOD = false, $IS_USER = false;

	/**
	 * Sets the current user to online
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author 	xLink
	 *
	 * @param 	bool $value
	 *
	 * @return 	bool
	 */
	public function setIsOnline($value=true){
		return self::$IS_ONLINE = $value;
	}

	/**
	 * Returns the status of the current user
	 * Note: This function is depreciated, it has been left here purely for old code.
	 *
	 * @deprecated 	true
	 *
	 * @return 		bool
	 */
	function is_online(){ return self::$IS_ONLINE; }
	function isUserOnline($uid){
		return self::$IS_ONLINE;
	}

	/**
	 * Inserts a users info into the database.
	 *
	 * @version 1.1
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param	array $userInfo   Array of the users details.
	 *
	 * @return  int               ID of the user that was inserted.
	 */
	public function register(array $userInfo){
		//Check all the args are good and valid
		$userInfo['username'] 		= doArgs('username', 	false, 	$userInfo);
		$userInfo['password'] 		= doArgs('password', 	false, 	$userInfo);
		$userInfo['email'] 			= doArgs('email', 		false, 	$userInfo);

		//if we have a false, in the above array, we has a problem
		if(in_array(false, $userInfo)){
			$this->setError('UserInfo has a false value');
			return false;
		}

		//add some extra stuff in before we submit it
		$userInfo['password'] 		= $this->mkPasswd($userInfo['password']);
		$userInfo['register_date'] 	= time();
		$userInfo['usercode'] 		= substr(md5(time()), 0, 6);
		$userInfo['primary_group'] 	= $this->config('site', 'user_group');
		$userInfo['theme'] 			= $this->config('site', 'theme');

		//active needs to be the opposite of whatever 'register_verification' is...
		$userInfo['active']			= !$this->config('site', 'register_verification');

		//Implement a hook before a users' registration has completed
		$this->objPlugins->hook('CMSUser_Before_Registered', $userInfo);

		$insert_id = $this->objSQL->insertRow('users', $userInfo, langVar(
			'LOG_CREATED_USER',
			sprintf('/%smodules/profile/%s', root(), $userInfo['username']),
			$userInfo['username']
		));

		//Implement a hook after a users' registration has completed
		$this->objPlugins->hook('CMSUser_After_Registered', $insert_id);

		if(!$insert_id){
			$this->setError('insert_id has a false value, SQL: '.mysql_error());
			return false;
		}

		$result = (is_number($insert_id) ? $insert_id : false);

		unset($userInfo, $insert_id);
		return $result;
    }

	/**
	 * Returns a setting's value set on the current user
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	string $setting
	 *
	 * @return  mixed
	 */
	public function grab($setting){
		global $config;

		return doArgs($setting, false, $config['global']['user']);
	}

	/**
	 * Retrieves information about a given user
	 *
	 * @version 1.1
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	string $uid		Either Username of UserID
	 * @param	string $field	Name of the field wanted or * for all
	 *
	 * @return  mixed			Field requested or whole user information.
	 */
	public function getUserInfo($uid, $field='*'){
		//test for a few bad fields
		$badFields = array('password', 'pin');
		if(in_array($field, $badFields)){
			$this->setError('Field is blacklisted.');
			return false;
		}

		//we need to populate the query
		if(!isset($this->userInfo[$uid])){
			//figure out if they gave us a username or a user id
			$user = (is_number($uid) ? 'u.id = "%s" ' : 'u.username = "%s" ');

			$query = $this->objSQL->prepare('SELECT u.*, e.*, u.id as id, o.timestamp '.
											'FROM `$Pusers` u '.
												'LEFT JOIN `$Puser_extras` e '.
													'ON u.id = e.uid '.
												'LEFT JOIN `$Ponline` o '.
													'ON u.id = o.uid '.
											'WHERE '.$user.' '.
											'LIMIT 1;', $uid);
			$info = $this->objSQL->getLine($query);
			if(!$info){
				$this->setError('User query failed. SQL: '. mysql_error()."\n".$query);
				return false;
			}

			//these are blacklisted, no point putting em out
			unset($info['password'], $info['pin']);

			//this is so the cache will work even if they give you a username first time and uid the second
			$this->userInfo[$info['username']] = $info;
			$this->userInfo[$info['id']] = $info;
			unset($info);
		}

		//if we didnt want it all then make sure the bit they wanted is there
		if($field != '*'){
			if(isset($this->userInfo[$uid][$field])){
				return $this->userInfo[$uid][$field];
			}else{
				//if what they wanted isnt there, no point returning the whole thing, might confuse a few people
				$this->setError('Requested field dosen\'t exist.');
				return false;
			}
		}

		//worst case, return the entire user
		return $this->userInfo[$uid];
	}

	/**
	 * Retrieves the UID from the username.
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	string $username 	Username used to retreive the UID
	 *
	 * @return  int					The UID that was returned, Or 0 if it failed.
	 */
	public function getUsernameById($username){
		$return = $this->getUserInfo($username, 'id');

		if($return === false){ return 0; }
		return $return;
	}

	/**
	 * Retrieves the Username from the UID.
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	int $uid		UID used to retreive the Username
	 *
	 * @return  string			The username that was returned, Or Guest if it failed.
	 */
	public function getIdByUsername($uid){
		$return = $this->getUserInfo($uid, 'username');

		if($return === false){ return 'Guest'; }
		return $return;
	}

	/**
	 * Updates the users on-site location
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @return  bool	True on Successful Update
	 */
	function updateLocation() {
		// generate the array for the db update
		$update['timestamp'] 	= time();
		$update['location'] 	= secureMe(doArgs('REQUEST_URI', null, $_SERVER));
		$update['referer'] 		= secureMe(doArgs('HTTP_REFERER', null, $_SERVER));

		//force the location system to ignore js and css files, these like to be the entry in the database which isnt useful
		if(preg_match('/(scripts|styles|js|css|xml)/sm', $update['location'])) {
			unset($update['location']);
		}

		if(isset($_SESSION['user']['userkey'])) {
			$this->objSQL->updateRow('online', $update, array('`userkey` = "%s"', $_SESSION['user']['userkey']));
			$result = (is_number(mysql_affected_rows()) ? true : false);
		}

		unset($update);
		return false;
	}

	/**
	 * Generates a hash from the $string var.
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param   string $string
	 * @param   string $salt
	 *
	 * @return  string                Password Hashed Input
	 */
	function mkPasswd($string, $salt=null) {
		// Use the new portable password hashing framework
		$objPass = new phpass(8, false);

		// Hash the password
		$hashed = $objPass->HashPassword($salt.$string);

		unset($objPass, $string, $salt);
		return $hashed;
	}

	/**
	 * Updates the users settings according to $settings.
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	mixed 	$uid 			Username or UID.
	 * @param	array 	$settings 		An array of settings, (columnName => value).
	 *
	 * @return  bool 					True if settings were fully updated, False if they wasnt.
	 */
	function updateUserSettings($uid, array $setting){
		unset($setting['id'], $setting['uid'], $setting['password'], $setting['pin']);

		if(!count($setting)){
			$this->setError('No setting changes detected. Make sure the array you gave was populated. '.
								'The following columns are blacklisted from being updated with this function: '.
								'id, uid, password, pin ');
			return false;
		}

		//make sure user exists first
		$user = $this->getUserInfo($uid, 'id');
			if(!$user){ return false; }

		//grab the columns for users and user_extras tables
		if(!isset($this->userColumns)){ 	$this->userColumns 	= $this->objSQL->getColumns('users'); }
		if(!isset($this->extraColumns)){ 	$this->extraColumns = $this->objSQL->getColumns('user_extras'); }
			if(!$this->userColumns || !$this->extraColumns){
				$this->setError('Could not get columns. SQL: '.mysql_error());
				return false;
			}

		//run thru the array given to us and assign them to the array needed
		$userUpdate = $extraUpdate = array();
		foreach($setting as $column => $value){
			if(in_array($column, $this->userColumns)){
				$userUpdate[$column] = $value;
				continue;
			}

			if(in_array($column, $this->extraColumns)){
				$extraUpdate[$column] = $value;
				continue;
			}
		}

		if(!count($userUpdate) && !count($extraUpdate)){
			$this->setError('Could not find any fields in $settings to update. Aborting.');
			return false;
		}

		//now run the updates, and if all goes well return true
		if(count($userUpdate)){
			$return = $this->objSQL->updateRow('users', $userUpdate, array('id = "%s" ', $user));
				if($return===false){
					$this->setError('User update portion failed. SQL: '.mysql_error());
					return false;
				}
		}

		if(count($extraUpdate)){
			$return = $this->objSQL->updateRow('user_extras', $extraUpdate, array('uid = "%s" ', $user));
				if($return===false){
					$this->setError('Extras update portion failed. SQL: '.mysql_error());
					return false;
				}
		}

		unset($return, $user, $userUpdate, $extraUpdate, $userColumns, $extraColumns);
		return true;
	}



	public function checkPermissions() {
		return true;
	}

	/**
	 * Returns the IP Address of the user, it will get IP from the proxy client if needed.
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	mixed $uid 		Username or UID.
	 *
	 * @return  mixed 			IP address of user.
	 */
	public static function getIP(){
		if 		(getenv('HTTP_X_FORWARDED_FOR')){ $ip = getenv('HTTP_X_FORWARDED_FOR'); }
		else if (getenv('HTTP_X_FORWARDED'))	{ $ip = getenv('HTTP_X_FORWARDED'); }
		else if (getenv('HTTP_FORWARDED_FOR'))	{ $ip = getenv('HTTP_FORWARDED_FOR'); }
		else									{ $ip = $_SERVER['REMOTE_ADDR']; }

		return $ip;
	}

}
?>