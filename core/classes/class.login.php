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


	//whitelist data


	//login & out, & remember me

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
			$this->error('Cookie not found');
			return false;
		}

		//this should return something not empty...
		$cookie = unserialize($_COOKIE['login']);
			if(is_empty($cookie)){ return false; }

		//verify we have the data we need
		$values = array('uData', 'uIP', 'uAgent');
		foreach($values as $e){
			if(!isset($cookie[$e]) && !is_empty($cookie[$e])){
				$this->error('Cookie didn\'t contain expected information.');
				return false;
			}
		}

		//uData should be 5 chars in length
		if(strlen($cookie['uData']) != 5){
			$this->error('Cookie didn\'t contain expected information.');
			return false;
		}

		//make sure the IP has the right IP of the client
		if($this->config('login', 'ip_lock') && $cookie['user_ip'] !== User::getIP()){
			$this->error('Cookie didn\'t contain expected information.');
			return false;
		}

		//and make sure the useragent matches the client
		if($cookie['uAgent'] != md5($_SERVER['HTTP_USER_AGENT'].$config['db']['ckeauth'])){
			$this->error('Cookie didn\'t contain expected information.');
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
		$query = $this->objSQL->prepare(implode(" \n", $query));
		$query = $this->objSQL->getLine($query);

		if(!$query || is_empty($query)){
			$this->error('Could not query for userkey');
			return false;
		}

		//untangle the user id from the query
        $query['uid'] = explode(':', $query['uid']);

		if(!isset($query['uid'][1]) || is_empty($query['uid'][1])){
			$this->error('No ID Exists');
			return false;
		}

		//now try and grab the user's info
		$this->userData = $this->objUser->getUserInfo($query['uid'][1]);
			if(!is_empty($this->userData)){
				$this->error('No user exists with that ID');
				return false;
			}

		//now check to make sure users info is valid before letting em login properly
		if(!$this->activeCheck()){
			$this->error('User isn\'t active.');
			return false;
		}

		if(!$this->banCheck()){
			$this->error('User is banned.');
			return false;
		}

		if(!$this->whiteListCheck()){
			$this->error('You\'re IP dosent match the whitelist.');
			return false;
		}

		//everything seems fine, log them in
		$this->objUser->setSessions($this->userData['id'], true);
		$this->objUser->newOnlineUser('Online System: AutoLogin Sequence Activated for '.$this->userData['username']);
		return true;
	}
}
?>