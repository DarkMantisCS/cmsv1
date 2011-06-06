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
	public function is_online(){ return self::$IS_ONLINE; }

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
			$this->setError('username, password and email are all required to continue.');
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

		if(!is_array($userInfo) || is_empty($userInfo)){
			$this->setError('$userInfo is no longer a useable array. Check plugins attached to CMSUser_Before_Register.');
			return false;
		}

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

		//add a new row into user_extras for this users settings
		unset($insert);
		$insert['uid'] = $insert_id;
		$this->objSQL->insertRow('user_extras', $insert);

		//register the user into the group
		$this->objGroups->joinGroup($insert_id, $userInfo['primary_group'], 0);

		unset($userInfo, $insert_id);
		return $insert_id;
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
		$backCalls = debug_backtrace();

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

			//if wer being called from the login class, then give em the password and pin, everywhere else can stuff it
			if($backCalls[1]['function'] == 'doLogin' && $backCalls[1]['class'] == 'login'){
				return $info;
			}

			//these are blacklisted, no point putting em out
			unset($info['password'], $info['pin'], $info['uid']);

			//this is so the cache will work even if they give you a username first time and uid the second
			$this->userInfo[$info['username']] = $info;
			$this->userInfo[$info['id']] = $info;
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

		unset($info);
		//worst case, return the entire user
		return $this->userInfo[$uid];
	}


	/**
	 * Determines whether the user is online or not.
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param	mixed $uid 	Username used to retreive the UID
	 *
	 * @return  bool
	 */
	public function isUserOnline($uid){
		$ts = $this->getUserInfo($uid, 'timestamp');

		return (is_empty($ts) ? false : true);
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
	public function updateLocation(){
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
			$result = (mysql_affected_rows() ? true : false);
		}

		unset($update);
		return $result;
	}

	/**
	 * Generates a hash from the $string var.
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param   string $password
	 * @param   string $hash
	 *
	 * @return  string                Password Hashed Input
	 */
	public function mkPasswd($string, $salt=null){
		// Use the new portable password hashing framework
		$objPass = new phpass(8, true);

		// Hash the password
		$hashed = $objPass->HashPassword($salt.$string);

		unset($objPass, $password, $hash);
		return $hashed;
	}

	/**
	 * Verifies the password
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param   string $password
	 * @param   string $hash
	 *
	 * @return  bool
	 */
	public function checkPasswd($password, $hash){
		//use the new portable password hashing framework
		$objPass = new phpass(8, true);

		//verify the password
		$hashed = $objPass->CheckPassword($password, $hash);

		//and return
		unset($objPass, $password, $hash);
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
	public function updateUserSettings($uid, array $setting, $log=false){
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

		if($log!==false){
			$this->objSQL->recordLog('', $log);
		}


		unset($return, $user, $userUpdate, $extraUpdate, $userColumns, $extraColumns);
		return true;
	}

	/**
	 * Check to see if the username is a valid one.
	 *
	 * @version 1.0
	 * @since   0.8.0
	 * @author 	xLink
	 *
	 * @param 	$username
	 *
	 * @return 	bool
	 */
	public function validateUsername($username, $existCheck=false){
		if(strlen($username) > 25 || strlen($username) < 2){
			$this->setError('Username dosen\'t fall within usable length parameters. Between 2 and 25 characters long.');
			return false;
		}
		if(preg_match('~[^a-z0-9_\-@^]~i', $username)){
			$this->setError('Username dosen\'t validate. Please ensure that you are using no special characters etc.');
			return false;
		}
		if($existCheck==true && $this->getUserInfo($username, 'username')){
			$this->setError('Username alerady exists. Please make sure your username is unique.');
			return false;
		}

		return true;
	}

	/**
	 * Check to see if the email is a valid one.
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author 	xLink
	 *
	 * @param 	$email
	 *
	 * @return 	bool
	 */
	public function validateEmail($email) {
		global $objBBCode;

		$email = strtolower($email);
		$email = $objBBCode->UnHTMLEncode(strip_tags($email));

		if(!$objBBCode->IsValidEmail($email)){
			return false;
		}
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
		if 		($_SERVER['HTTP_X_FORWARDED_FOR']){ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		else if ($_SERVER['HTTP_X_FORWARDED']){ 	$ip = $_SERVER['HTTP_X_FORWARDED']; }
		else if ($_SERVER['HTTP_FORWARDED_FOR']){ 	$ip = $_SERVER['HTTP_FORWARDED_FOR']; }
		else{										$ip = $_SERVER['REMOTE_ADDR']; }

		return $ip;
	}

	/**
	 * Sets and Updates the user position on the website. Also allows for automated actions
	 *
	 * @version 2.0
	 * @since   1.0.0
	 * @author	xLink
	 */
	public function tracker(){
		global $config;

		$update = false; $rmCookie = false;
		$action = null; $logout = false;

		//if user is online
		if(User::$IS_ONLINE){
			//make sure they still have a key
			$action = 'check user key, and reset if needed';
			if(is_empty(doArgs('userkey', null, $config['global']['user']))){
				$this->newKey(); //give em one if they havent
			}

			//force update
			$update = true;
		}else{
			//check for remember me cookie
			if(!is_empty(doArgs('login', null, $_COOKIE))){
		 		//try and remember who they are, this sometimes is hard, but we try anyway
				if($this->objLogin->runRememberMe()){
					$action = 'remove remember me cookie';
					$rmCookie = true;

				//you should be logged in now, so redirect
				}else{
					$action = 'redirecting upon successful login';
					$this->objPage->redirect($config['global']['fullUrl'], 0);
					exit;
				}
			}else{
				$online = $this->objLogin->onlineData();

				if(!is_array($online)){
					$action = 'register new guest';
					$this->newOnlineSession();
				}else{
					$action = 'update guest';
					$update = true;
				}
			}
		}

		if($update == true){
			//grab the online table data
			$online = $this->objLogin->onlineData();

			if(isset($online['mode'])){
				switch($online['mode']){
					default:
					case 'active':
						$action = 'update user location';

						//make sure the user dosent have guest identification if hes logged in
						if(User::$IS_ONLINE && $online['username'] == 'Guest'){
	                        $this->objSQL->deleteRow('online', 'userkey = "'.$this->grab('userkey').'"');
	                        $this->newOnlineSession(false);
						}

						//now thats sorted, update
						$this->updateLocation();

					break;

					//we have been ordered to terminate >:}
					case 'kill':
						$action = 'kill user';

						//and log em out
						$logout = true;
					break;

					case 'ban':
						$action = 'ban user';

						//ban the user account if they are online
						if(User::$IS_ONLINE){
							$this->banUser($objUser->grab('id'));

						//ban the ip if they are a guest
						}else{
							$this->banIP(User::getIP());
						}

						$logout = true;
					break;

					case 'update':
	                    $action = 'update user info';
	                    //so we want to grab a new set of sessions
						if(User::$IS_ONLINE){
	                    	#$this->objLogin->setSessions($objUser->grab('id'));
						}

	                    //and notify the user telling them, this notification wont be persistant though
	                    #$objUser->notify('Your information has been updated. Changes around the site reflect these changes.', 'Profile Update');

	                    //update the online table so we dont have any problems
	                    $this->objSQL->updateRow('online', array('mode'=>'active'), array('userkey = "%s"', $objUser->grab('userkey')));

					break;
				}

			//user has no mode set...wtf?
			}else{
	            $action = 're-reg user info';

	            //insert users info back into the online table
	            $this->newOnlineSession(false);
			}

			if($logout && User::$IS_ONLINE){
				//remove their online row
                $this->objSQL->deleteRow('online', array('userkey = "%s"', $objUser->grab('userkey')));

				//and log em out properly
				#$objLogin->logout($objUser->grab('usercode'));

				//remove their cookie so auto login dosent kick in
				$rmCookie = true;
			}

		}

		//remove the cookie if needed
		if($rmCookie){
			$action = 'rm remember me cookie';
			setcookie('login', '', time()-31536000);
			unset($_COOKIE['login']);
		}

		//unset the admin auth after 20 mins of no acp activity
		if(IS_ADMIN && isset($_SESSION['acp']['adminTimeout'])){
			if(time() >= $this->objTime->mod_time($_SESSION['acp']['adminTimeout'], 0, 20)){
				unset($_SESSION['acp']);
			}
		}
		unset($update, $rmCookie, $action, $logout);
	}

	/**
	 * Sets a new key for the user
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 */
	public function newKey(){
		//grab the old key before we overwrite it
		$oldKey = $_SESSION['user']['userkey'];

		//set a new one and update it in the db
		$_SESSION['user']['userkey'] = md5('userkey'.substr(0, 6, microtime(true)));
		$this->objSQL->updateRow('online', array('userkey' => $_SESSION['user']['userkey']), array('userkey = "%s"', $oldKey));

		return $_SESSION['user']['userkey'];
	}

	/**
	 * Sets the online session for the tracker
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	xLink
	 *
	 * @param 	string $log
	 *
	 * @return 	bool
	 */
    public function newOnlineSession($log=NULL){
		$insert['uid']           = $this->grab('id');
		$insert['username']      = $this->grab('username');
		$insert['ip_address']    = User::getIP();
		$insert['timestamp']     = time();
		$insert['location']      = secureMe($this->config('global', 'fullPath'));
		$insert['referer']       = secureMe($this->config('global', 'referer'));
		$insert['language']      = secureMe($this->config('site', 'language'));
		$insert['useragent']     = secureMe($this->config('global', 'browser'));
		$insert['userkey']       = isset($_SESSION['user']['userkey']) ? $_SESSION['user']['userkey'] : $this->newKey();

        if($this->objSQL->insertRow('online', $insert, 0, $log)){
            $this->objCache->generate_statistics_cache();
            return true;
        }
        return false;
    }

	/**
	 * Sets the user session on login
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param 	mixed	$uid 		Username or UserID
	 * @param 	string 	$autoLogin
	 *
	 * @return 	bool
	 */
	public function setSessions($uid, $autoLogin=false){

		//grab the user info
		$userInfo = $this->getUserInfo($uid);
			if($userInfo === false || is_empty($userInfo)){ return false; }

		//grab timestamp before we clear the array
		$timestamp = doArgs('last_active', time(), $_SESSION['user']);

		//reset the user part of the session
		$_SESSION['user'] = array();
		$_SESSION['user'] = $userInfo;
		$_SESSION['user']['last_active'] = $timestamp;
		$_SESSION['user']['userkey'] = $this->newKey();
		session_regenerate_id(true);

		//if we are auto logging in, then update last_active
		if($autoLogin){
			$update['last_active'] = time();
			$this->objSQL->updateRow('users', $update, array('id = "%s"', $uid));
		}
    }

	/**
	 * Resets the users sessions
	 * 		if current user, then just do it,
	 * 		if not, then set flag in online table to do it
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @param 	mixed	$uid	UserID
	 */
    public function reSetSessions($uid){
        if($uid == $this->grab('id')){
            $this->setSessions($uid);
        }else{
            unset($update);
            $update['mode'] = 'update';
            $this->ObjSQL->updateRow('online', $update, array('uid = "%s"', $uid));
        }
    }


	public function profile() {
		return 'Guest';
	}


	public function checkPermissions() {
		return true;
	}

}
?>