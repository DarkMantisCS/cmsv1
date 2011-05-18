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
 * @author      Jesus
 */
class user extends coreClass{

	//some static vars, these save function calls
	static $IS_ONLINE = false;
	static $IS_ADMIN = false, $IS_MOD = false, $IS_USER = false;

	/**
	 * Sets the current user to online
	 *
	 * @version	1.0
	 * @since   1.0.0
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
	 * Returns a value set on the current user
	 *
	 * @version 2.0
	 * @since   1.0.0
	 *
	 * @param	string $uid		Either Username of UserID
	 *
	 * @return  mixed			Field requested or whole user information.
	 */
	public function grab($key){
		global $config;

		return doArgs($value, false, $config['global']);
	}

	/**
	 * Retrieves information about a given user
	 *
	 * @version 1.1
	 * @since   1.0.0
	 *
	 * @param	string $uid		Either Username of UserID
	 *
	 * @return  mixed			Field requested or whole user information.
	 */
	public function getUserInfo($uid, $field='*'){
		//figure out if they gave us a username or a user id
		$user = (is_number($uid) ? '`id` = "%s" ' : '`username` = "%s" ');

		//test for a few bad fields
		$badFields = array('password', 'pin');
		if(in_array($field, $badFields)){
			$this->setError('Field is blacklisted.');
			return false;
		}

		//we need to populate the query
		if(!isset($this->userInfo[$uid])){
			$query = $this->objSQL->prepare('SELECT u.*, e.*, u.id as id, o.timestamp '.
											'FROM `$Pusers` as u '.
											'LEFT JOIN `$Puser_extras` as e '.
												'ON u.id = e.uid '.
											'LEFT JOIN `$Ponline` as o '.
												'ON u.id = o.uid '.
											'WHERE '.$user.' '.
											'LIMIT 1;', $uid);
			$info = $this->objSQL->getLine($query);
			if(!$info){
				$this->setError('User query failed. SQL: '. mysql_error());
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
		if($field != '*' && isset($this->userInfo[$uid][$field])){
			return $this->userInfo[$uid][$field];
		}else{
			//if what they wanted isnt there, no point returning the whole thing, might confuse a few people
			$this->setError('Requested field dosen\'t exist.');
			return false;
		}

		//worst case, return the entire user
		return $this->userInfo[$uid];
	}

	/**
	 * Retrieves the UID from the username.
	 *
	 * @version 2.0
	 * @since   1.0.0
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
	 * @since   0.7.0
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
	 * Generates a hash from the $password var.
	 *
	 * @version 2.0
	 * @since   1.0.0
	 *
	 * @param   string $password
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





	public function checkPermissions() {
		return true;
	}


}
?>