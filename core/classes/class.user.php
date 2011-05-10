<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles the DB Caching
 *
 * @version     1.0
 * @since       1.0.0
 * @author      Jesus
 */
class user extends coreClass
{
    private $is_online = false;
	public $groups, $permissions;

	/**
	 * Variables to cache within the class, Cuts down on SQL Queries
	 */
    private $gUbI           = array();
    private $gIbU           = array();

    private $sortedPerms    = array();
    private $profile        = array();
    private $userLevels     = array();

    /**
     * The constructor for the User Class
     *
     * @version	1.0
     * @since  0.8.0
     *
     * @return void
     */
    public function __construct() { }

    /**
     * Sets the current user to online
     *
     * @version	1.0
     * @since   0.8.0
     *
     * @return bool
     */
    public function setIsOnline($value = true){
        return $this->is_online = $value;
    }

    /**
     * Returns the status of the current user
     *
     * @version	1.0
     * @since   0.8.0
     *
     * @return void
     */
    function is_online(){
        return $this->is_online;
    }

	/**
     * Inserts a users info into the database.
     *
     * @version 1.0
     * @since   0.8.0
     *
     * @param	array $userInfo   Array of the users details.
     *
     * @return  int               Id of the user that was inserted.
     */
    function registerUser(array $userInfo){
    	// Check all the args are good and valid
        $userInfo = array(
            'username'      => doArgs('username', 	false, 	$userInfo),
            'password'      => doArgs('password', 	false, 	$userInfo),
            'email'      	=> doArgs('email', 		false, 	$userInfo),
            'sex'      		=> doArgs('sex', 		false, 	$userInfo),
            'location'    	=> doArgs('location', 	false, 	$userInfo),
            'timezone'    	=> doArgs('timezone', 	false, 	$userInfo),
        );

        if( in_array(false, $userInfo) )
        {
        	return false;
        }

        // Implement a hook before a users' registration has completed
        $this->objPlugins->hook( 'CMSUser_Before_Registered', $userInfo );

        $insertID = $this->objSQL->insertRow( 'users', $userInfo, langVar(
			'LOG_CREATED_USER',
			sprintf('/%smodules/profile/%s', root(), $userInfo['username']),
			$userInfo['username']
		));

        // Implement a hook after a users' registration has completed
		$this->objPlugins->hook( 'CMSUser_After_Registered', $insertID );

		return ( is_number( $insertID ) ? $insertID : false );
    }

    /**
     * Retreives the UID from the username.
     *
     * @version 1.0
     * @since   0.7.0
     *
     * @param	string $username      Username used to retreive the UID
     *
     * @return  int                   The UID that was returned, Or 0 if it failed.
     */
    public function getIdByUsername($username)
	{
        // Is this query already cached?
        if(isset($this->gIbU[$username]))
		{
        	return $this->gIbU[$username];
		}

        if($username==$this->grab('username'))
		{
        	$this->gIbU[$uid]=$this->grab('id'); return $this->gIbU[$uid];
		}

        $test = $this->objSQL->getValue('users', 'id', "username = '".$username."'");
        $this->gIbU[$username] = $test!==NULL ? $test : 0;

        return $this->gIbU[$username];
	}

    /**
     * Retreives the Username from the UID.
     *
     * @version 1.0
     * @since   0.7.0
     *
     * @param	int $uid      UID used to retreive the Username
     *
     * @return  string        The username that was returned, Or Guest if it failed.
     */
	public function getUsernameById($uid)
	{
        // Is this query already cached?
        if(isset($this->gUbI[$uid]))
		{
        	return $this->gUbI[$uid];
		}

        if($uid==$this->grab('id'))
		{
        	$this->gUbI[$uid]=$this->grab('username'); return $this->gUbI[$uid];
		}

        $test = $this->objSQL->getValue('users', 'username', "id = '".$uid."'");
        $this->gUbI[$uid] = $test!==NULL ? $test : 'Guest';

        return $this->gUbI[$uid];
	}

    /**
     * Retrieves the current users' ajax settings
     *
     * @version 1.0
     * @since   0.7.0
     *
     * @param	string	$setting	Setting Key
     *
     * @return  mixed
     */
    function ajaxSettings($setting)
	{
        global $config;

        if(!isset($this->uAjaxSettings))
		{
            $this->uAjaxSettings = $this->grab('ajax_settings');
        }

        if(!isset($this->uAjaxSettings) || is_empty($this->uAjaxSettings))
		{
            $this->uAjaxSettings = $_SESSION['user']['ajax_settings'] = $this->objSQL->getValue('users', 'ajax_settings', 'id = '.$this->grab('id'));
        }

        if($_SESSION['user']['ajax_settings']===NULL || empty($_SESSION['user']['ajax_settings'])){ return false; }

        $ajaxSettings = unserialize($_SESSION['user']['ajax_settings']);
        if(!is_array($ajaxSettings)){ return false; }

        if(in_array($setting, $ajaxSettings)){
            return $ajaxSettings[$setting];
        }
        return false;
    }

    /**
     * Returns an online indicator according to $timestamp.
     *
     * @version 1.0
     * @since   0.7.0
     *
     * @param	int $timestamp      The timestamp of the user
     * @param	bool $hidden        Whether or not the user should be hidden
     *
     * @return  string              The Online, Offline or Hidden Indicator in HTML.
     */
    function onlineIndicator($timestamp, $hidden=false, $returnType='img')
	{
        $vars = $this->objPage->getVar('tplVars');

        // make a default img to return, everybody by default are offline
        $string = '<img src="%s" title="%s" />';
		$type = 'USER_OFFLINE';
		$raw = '0';

		// timestamp is not set, return offline img
		if(!(int)$timestamp)
		{
			return (strcmp($returnType, 'raw')==0 ? $raw : $img);
		}

		// check whether they are 'online'
		if($timestamp >= time::mod_time(time(), 0, 20, 0, 'TAKE')) {

			// do they want to be hidden
			if($hidden) {
    			//do you have enough perms to see whether they are online or not?
				if($this->checkPermissions($this->grab('id'), MOD)) {

					//oh you do?
					$type = 'USER_HIDDEN';
					$raw = '-1';
				} else {

					//haha didnt think so..
					$type = 'USER_OFFLINE';
					$raw = '0';
				}
			}else{//ahh not hidden then
				$type = 'USER_ONLINE';
				$raw = '1';
			}
		}
		$img = sprintf( $string, $vars[$type], langVar($type) );
        return (strcmp($returnType, 'raw')==0 ? $raw : $img);
    }

    /**
     * Returns a reference to a users profile using one of the formats
     *
     * @version 1.0
     * @since   0.0.0
     *
     * @param	mixed	$uid        Username or UID.
	 * @param	string	$mode        0 | LINK      => Username colored and linked to profile.
 	*                   	         1 | NOLINK    => Username colored but not linked.
 	*                              	 2 | RAW       => Username not colored or linked.
     * @return string
     */
    function profile($uid, $mode=LINK, $uquery=NULL)
	{
        // Is this already cached?
        if(isset($this->profile[$mode][$uid])){return $this->profile[$mode][$uid];}

        if($uid!==GUEST)
		{
            if (!isset($this->cacheUsers[$uid]))
			{
                $where = is_number($uid) ? 'u.id = \'%s\'' : 'u.username = \'%s\'';

                if($uquery === NULL && !isset($cacheUsers[$uid]['username'])){

                	// grab the user row to see which color they want
                    $query = sprintf('SELECT u.id, u.username, u.banned, g.name, g.description, g.color
		                        FROM $Pusers u
		                        JOIN $Pgroups g
		                            ON g.id = u.colorgroup
		                        WHERE %s
		                        LIMIT 1', $where);
                    $uquery = $this->objSQL->getLine($this->objSQL->prepare($query, $uid));

                }
    			if (!isset($uquery['username']))
				{
    				// If there was a problem before, we don't want a blank username!
    				$uquery = $this->objSQL->getLine($this->objSQL->prepare(sprintf(
    					'SELECT u.id, u.username, u.banned FROM $Pusers u WHERE %s', $where
					), $uid));
    			}

                // we apparently didn't get a useable response from the DB, they shall be my Guest :)
                if(!$uquery){ $this->profile[$mode][$uid] = $mode==RETURN_USER ? $uid : 'Guest'; return $this->profile[$mode][$uid]; }
    			$this->cacheUsers[$uid]['username'] = $uquery['username'];


    			if (isset($uquery['color'])){
                    $this->cacheUsers[$uid]['group'] = array( 'name'           => $uquery['name'],
                                                              'description'    => $uquery['description'],
                                                              'color'          => $uquery['color']);
                }else{
                    $where = is_number($uid) ? 'ug.uid = %d' : 'u.username = \'%s\' AND ug.uid = u.id';
                    $query = $this->objSQL->getTable($this->objSQL->prepare(sprintf('
                        SELECT g.* FROM group_subs ug
                            JOIN $Pusers u
                                ON u.id = ug.uid
                            JOIN $Pgroups g
								ON ug.gid = g.id

                        WHERE %s AND ug.pending = 0
                        ORDER BY g.`order` ASC
                    ', $where), $uid));

    				$curr = 10000000000000;
                    if(count($query)){
        				foreach($query as $row){
        					// If our new group in the list is a higher order number, it's color takes precedence
        					if ($row['order'] < $curr){
        						$curr = $row['order'];
                                $this->cacheUsers[$uid]['group'] = array( 'name'           => $row['name'],
                                                                          'description'    => $row['description'],
                                                                          'color'          => $row['color']);
        					}
        				}
                    }
    				if(!isset($this->cacheUsers[$uid]['group'])){
                        foreach($this->groups as $g){
                            if($g['single_user_group']==0){
        				        if((int)$g['id']==(int)$config['site']['user_group']){
                                    $userGroup = array( 'name'           => $g['name'],
                                                        'description'    => $g['description'],
                                                        'color'          => $g['color']);
                                }
                            }
                        }
    				    $this->cacheUsers[$uid]['group'] = $userGroup;
    				}

                }
                if($this->cacheUsers[$uid]['banned']==1){
                    $mode = -1;
                }
            }

            $user = $this->cacheUsers[$uid]['username'];
            $group = $this->cacheUsers[$uid]['group'];

            $color = ' style="color: '.$group['color'].';"';
            $color = (!is_empty($group['color']) ? $color : NULL);

            $title = ' title="'.$group['description'].'"';
            $title = (!is_empty($group['description']) ? $title : NULL);

            $font = '<font class="username"%s%s>%s</font>';

            $banned = sprintf($font, ' style="text-decoration: line-through;" ', $title, $user);
            $user_link = '<a href="/'.root().'modules/profile/view/'.$user.'" rel="nofollow">'.sprintf($font, $color, $title, $user).'</a>';
            $user_nlink = sprintf($font, $color, $title, $user);
            $user_raw = $user;

    		if($is_banned){$mode = 3;}

    		switch($mode){
                case -1:    $this->profile[$mode][$uid] = $banned;      break;

    		    default:
                case 0:     $this->profile[$mode][$uid] = $user_link;   break;
                case 3:
                case 1:     $this->profile[$mode][$uid] = $user_nlink;  break;
                case 2:     $this->profile[$mode][$uid] = $user_raw;    break;
                case 4:     $this->profile[$mode][$uid] = $uid;         break;
            }

        }else{
            $this->profile[$mode][$uid] = $mode==RETURN_USER ? $uid : 'Guest';
        }

        $this->profile[$mode][$uquery[(is_number($uid) ? 'username' : 'id')]]  = $this->profile[$mode][$uid];
        $this->cacheUsers[$uquery[(is_number($uid) ? 'username' : 'id')]]      = $this->cacheUsers[$uid];
        return $this->profile[$mode][$uid];
    }


/**
 *
 * todo
 *
 */
    function level($user, $query=NULL){
       return;
    }

    /**
     * Parses a Users Avatar.
     *
     * @version 1.0
     * @since   0.7.0
     *
     * @param	mixed	$uid		Username or UID.
     * @param	int		$size		Height and Width Setting for the returned avatar.
     *
     * @return  string				Fully Parsed Avatar
     */
    function parseAvatar($uid, $size=100, $query=NULL){
	    if(isset($this->avatar[$uid])){return sprintf($this->avatar[$uid], $size, $size);}
        $_avatar = '/'.root().'images/no_avatar.png';

        //check to see if we have a queries results in the argument we can use
        if($query === NULL){
            $where = is_number($uid) ? "id = ".$uid : "username = '".$uid."'";
            $query = $this->objSQL->getLine($this->objSQL->prepare('SELECT username, avatar FROM $Pusers WHERE $where LIMIT 1'));
        }
        if(!is_array($query)){
        	$this->avatar[$uid] = '<img src="%s" height="%d" width="%d" class="avatar" />';
            return sprintf($this->avatar[$uid], $_avatar, $size, $size);
        }

        $avatar = $this->DoImage($query['avatar']);
        $avatar = $avatar!==false ? $avatar : $_avatar;
        $username = $query['username'];
        $username_avatar = $query['username'].'_avatar';
        $user = strtolower($username);

        $this->avatar[$uid] = sprintf(
			'<a href="%s" class="lightwindow" title="%s" avatar="%s"><img src="%1$s" height="%d" width="%d" name="%s" id="%s" title="%1$s" class="avatar" avatar="%s" /></a>',
			$avatar, langVar('USERS_AVATAR', $username), $user, $size, $size, $username_avatar, $username_avatar, $username
		);
        return $this->avatar[$uid];
    }

    /**
     * Returns the validity of an image
     *
     * @version 1.0
     * @since   0.8.0
     *
     * @param	string	$content	URL of an image
     *
     * @return  Mixed				Return the image url on success
     */
	 function DoImage($content) {
    	global $objBBCode;
        if(!isset($objBBCode)){
			if(is_empty($content)){ return false; }
			return htmlspecialchars($content);
        }
        $content = trim($objBBCode->UnHTMLEncode(strip_tags($content)));
        if (preg_match("/\\.(?:gif|jpeg|jpg|jpe|png)$/", $content)) {
            if (preg_match("/^[a-zA-Z0-9_][^:]+$/", $content)) {
                if (!preg_match("/(?:\\/\\.\\.\\/)|(?:^\\.\\.\\/)|(?:^\\/)/", $content)) {
                    $info = @getimagesize($content);
                    if ($info[2] == IMAGETYPE_GIF || $info[2] == IMAGETYPE_JPEG || $info[2] == IMAGETYPE_PNG) {
                        return htmlspecialchars($content);
                    }
                }
            } else if ($objBBCode->IsValidURL($content, false)) {
                return htmlspecialchars($content);
            }
        }
        return false;
    }

    /**
     * Returns the validity of an email address
     *
     * @version 1.0
     * @since   0.8.0
     *
     * @param	string	$content	Email Address
     *
     * @return  Bool				True if email address is valid
     */
    function DoEmail($content) {
        global $objBBCode;
        $content = strtolower($content);
        $email = $objBBCode->UnHTMLEncode(strip_tags($content));
        if ($objBBCode->IsValidEmail($email)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Returns the validity of a CYSha Username
     *
     * @version 1.0
     * @since   0.8.0
     *
     * @param	string	$usernameA username to be checked
     *
     * @return  Bool				True if is valid username
     */
    function verifyUsername($username){
        if(strlen($username) > 25 || strlen($username) < 2){ return false; }
        if(preg_match('#[^a-z0-9_\-@^]#i', $username)){ return false; }

        return true;
    }

    /**
     * Sets the users password.
     *
     * @version 1.0
     * @since   0.8.0
     *
     * @param	mixed $uid            Username or UID.
     * @param	string $password      Plaintext version of the password.
     *
     * @return  bool                  True on success
     */
    function setPassword($uid, $password, $log=NULL){
        $array['password'] = $this->mkPasswd($password);
        $array['forgotpassword'] = 0;

        if($this->updateUserSettings($uid, $array, $log)){
            $this->objPlugins->execHook('CMSCore_userPasswordChanged', func_get_args());
            return true;
        }
        return false;
    }

    /**
     * Generates a hash from the $password var.
     *
     * @version 2.0
     * @since   0.1.0
     *
     * @param   string $password
     * @param   string $salt
     *
     * @return  string                Password Hashed Input
     */
    function mkPasswd($string, $salt=NULL, $ajax=false)
	{
    	// Use the new portable password hashing framework
        $objPass = new phpass(8, false);

        // Hash the password
        $hashed = $objPass->HashPassword($string);

        return $hashed;
    }

    /**
     * Checks if the username exists in the database.
     *
     * @version 2.0
     * @since   0.6.0
     *
     * @param	string $username      Username to be checked
     *
     * @return  bool                  True if it exists, False if it dosent.
     */
    function usernameExists($username)
	{
        $id = $this->objSQL->getValue('users', 'id', 'username="'.$this->objSQL->escape($username).'"');

        if(!is_empty($id) && $id > 0){ return true; }
        return false;
    }

    /**
     * Checks if the email exists in the database.
     *
     * @version 2.0
     * @since   0.6.0
     *
     * @param	string $email     Email to be checked
     *
     * @return  bool              True if it exists, False if it dosent.
     */
    function emailExists($email)
	{
        $id = $this->objSQL->getValue('users', 'email', 'email ="'.$this->objSQL->escape($email).'"');

        if($id!==NULL && !empty($id)){ return true; }
        return false;
    }

    // REALLY TIRED, Will carry on this class tomorrow... well in like 19 hrs. :/
}
?>