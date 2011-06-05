<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * Handles logging in and out for the user, and admin control panel
 *
 * @version 	2.0
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



	//setup checks for various data
	function attemptsCheck($dontUpdate=false){
		if($this->onlineData['login_time'] >= time()){
			return false;

		}elseif($this->onlineData['login_attempts'] > $this->config('site', 'max_login_tries')){
			if($this->onlineData['login_time'] == '0'){
				$this->objSQL->updateRow('online', array(
					'login_time' 		=> $this->objTime->mod_time(time(), 0, 15),
					'login_attempts'	=> '0'
				), 'userkey = "'.$_SESSION['user']['userkey'].'"');
			}
			return false;
		}

		if($dontUpdate){ return true; }

		if($this->userData['login_attempts'] >= $this->config('site', 'max_login_tries')){
			if($this->userData['login_attempts'] == $this->config('site', 'max_login_tries')){
				$this->objUser->updateUserSettings($this->userData['id'], array('active' => '0'));
				sendEMail($this->userData['email'], 'E_LOGIN_ATTEMPTS', array(
					'username' => $this->userData['username'],
					'url' => $this->config('global', 'rootUrl').'login.php?action=active&un='.$this->userData['id'].'&check='.$this->userData['usercode']
				));
			}
			return false;
		}

		return true;
	}


	//whitelist data


	//login & out, & remember me
	public function doLogin($log=false, $ajax=false){
		//make sure we have a post
		if(!HTTP_POST){
			$this->setError('No POST action detected');
			return false;
		}

		//verify username and password are set and not empty
		$username = doArgs('username', null, $_POST);
		$password = doArgs('password', null, $_POST);
		if(is_empty($username) || is_empty($password)){
			$this->setError('Username or password is empty');
			return false;
		}

		//check login attempts
		if(!$this->attemptsCheck(true)){
			$this->error('0x03', $ajax);
		}

		//grab user info
		$this->userData = $this->objUser->getUserInfo($username);
		$this->postData = array(
			'username' => $username,
			'password' => $password,
		);

		//no need to run these if we are in acp mode
        if($acpCheck === FALSE){
        	if(!$this->checkUserInfo()){   $this->error('0x02', $ajax); }
        	if(!$this->whiteListCheck()){  $this->error('0x04', $ajax); }
        	if(!$this->activeCheck()){     $this->error('0x05', $ajax); }
        	if(!$this->banCheck()){        $this->error('0x06', $ajax); }
        }

		if(!$this->attemptsCheck()){   	$this->error('0x03', $ajax); }
		if(!$this->passwdCheck($ajax)){ $this->error('0x07', $ajax); }

		//if this is aan acp check
		if($acpCheck){
			//verify the pin
			if(is_empty($this->userData['pin']) || !$this->verifyPin()){
				$this->error('0x10', $ajax);
			}

			//update attempts to 0
			unset($settings);
			$settings['pin_attempts'] = '0';
			$settings['login_attempts'] = '0';
			$this->objUser->updateUserSettings($this->userData['id'], $settings,
				'Online System: Administration Privileges given to '.$this->userData['username'].'');

			//no need for this to be set anymore
			unset($_SESSION['acp']['doAdminCheck'], $settings);

			//set a session for the acp auth
			$_SESSION['acp']['adminAuth'] = true;
			$_SESSION['acp']['adminTimeout'] = time();

			//redirect em straight to the acp panel if not ajax'd else get JS to do it
			if(!$ajax){
				$objPage->redirect('/'.root().'admin/', 0);
			}else{
				die('dcne');
			}
			return;
		}

		$uniqueKey = substr(md5($this->userData['id'].time()), 0, 5);

		// Add Hooks for Login Data
		$this->userData['password_plaintext'] = $this->postData['password'];
		$this->objPlugins->execHook('CMSLogin_onSuccess', $this->userData);

		$this->objSQL->updateRow('online',
									array('uid' => $this->userData['id'], 'username' => $this->userData['username']),
									array('userkey = "%s"', $_SESSION['user']['userkey']),
									'Online System: '.$this->userData['username'].' Logged in'
								);

		$this->objUser->setSessions($this->userData['id']);
		$this->objUser->updateLocation();

		//make sure we want em to be able to auto login first
		if($this->config('site', 'auto_login')){
			if(doArgs('remember', false, $_POST)){
				$this->objUser->updateUserSettings($this->userData['id'], array('autologin'=>1));

	    		$cookieArray = array(
	    			'uData'		=> $uniqueKey,
	    			'uIP'		=> User::getIP(),
	    			'uAgent'	=> md5($_SERVER['HTTP_USER_AGENT'].$this->config('db', 'ckeauth'))
				);

				set_cookie('login', serialize($cookieArray), $this->objTime->mod_time(time(), 0, 0, 24*365*10));
				$cookieArray['uData'] .= ':'.$this->userData['id']; //add the uid into the db
				$this->objSQL->insertRow('userkeys', $cookieArray, 0,
					'Online System: RememberMe cookie set for '.$this->userData['username'].'.');

				unset($cookieArray);
			}
		}

		//redirect em straight to the index if not ajax'd else get JS to do it
    	if(!$ajax){
	    	$objPage->redirect(doArgs('HTTP_REFERER', '/'.root().'index.php', $_SERVER), 0);
    	}else{
    		die('done');
    	}
	}

	/**
	 * Makes sure the cookie is valid
	 *
	 * @version 1.0
	 * @since   1.0.0
	 * @author	Jesus
	 *
	 * @return  bool
	 */
	public function checkRememberMeCookie(){

		//make sure we have a cookie to begin with
		if(is_empty(doArgs('login', null, $_COOKIE))){
			$this->setError('Cookie not found');
			return false;
		}

		//this should return something not empty...
		$cookie = unserialize($_COOKIE['login']);
			if(is_empty($cookie)){
				$this->setError('Cookie didn\'t contain expected information.');
				return false;
			}

		//verify we have the data we need
		$values = array('uData', 'uIP', 'uAgent');
		foreach($values as $e){
			if(!isset($cookie[$e]) && !is_empty($cookie[$e])){
				$this->setError('Cookie didn\'t contain expected information.');
				return false;
			}
		}

		//uData should be 5 chars in length
		if(strlen($cookie['uData']) != 5){
			$this->setError('Cookie didn\'t contain expected information.');
			return false;
		}

		//make sure the IP has the right IP of the client
		if($this->config('login', 'ip_lock') && $cookie['user_ip'] !== User::getIP()){
			$this->setError('Cookie didn\'t contain expected information.');
			return false;
		}

		//and make sure the useragent matches the client
		if($cookie['uAgent'] != md5($_SERVER['HTTP_USER_AGENT'].$this->config('db', 'ckeauth'))){
			$this->setError('Cookie didn\'t contain expected information.');
			return false;
		}

		//setup the query
		unset($query);
		$query[] = 'SELECT uid FROM `$Puserkeys`';
		$query[] = 		'WHERE uid LIKE "%'.secureMe($cookie['uData'], 'MRES').':%';
		$query[] = 			'AND user_agent = "'.secureMe($cookie['uAgent'], 'MRES').'"';

		if($this->config('login', 'ip_lock')){
			$query[] = 		'AND user_ip = "'.secureMe($cookie['uIP'], 'MRES').'"';
		}

		$query[] = 'LIMIT 1;';

		//prepare and exec
		$query = $this->objSQL->prepare(implode(' ', $query));
		$query = $this->objSQL->getLine($query);

		if(!$query || is_empty($query)){
			$this->setError('Could not query for userkey');
			return false;
		}

		//untangle the user id from the query
        $query['uid'] = explode(':', $query['uid']);

		if(!isset($query['uid'][1]) || is_empty($query['uid'][1])){
			$this->setError('No ID Exists');
			return false;
		}

		//now try and grab the user's info
		$this->userData = $this->objUser->getUserInfo($query['uid'][1]);
			if(!is_empty($this->userData)){
				$this->setError('No user exists with that ID');
				return false;
			}

		//now check to make sure users info is valid before letting em login properly
		if($this->userData['autologin'] == 0){
			$this->setError('User isn\'t set to autologin.');
			return false;
		}

		if(!$this->activeCheck()){
			$this->setError('User isn\'t active.');
			return false;
		}

		if(!$this->banCheck()){
			$this->setError('User is banned.');
			return false;
		}

		if(!$this->whiteListCheck()){
			$this->setError('You\'re IP dosent match the whitelist.');
			return false;
		}

		//everything seems fine, log them in
		$this->objUser->setSessions($this->userData['id'], true);
		$this->objUser->newOnlineUser('Online System: AutoLogin Sequence Activated for '.$this->userData['username']);
		return true;
	}
}
?>