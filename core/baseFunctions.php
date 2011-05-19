<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

	/**
	 * Custom error handler for the cms.
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 */
	function cmsError(){
		$args = func_get_args();
		$filename = explode((stristr(PHP_OS, 'WIN') ? '\\' : '/'), $args[2]);
		if($args[0]!=8){
			$msg = '<b>CMS Error:</b> <i>'.$args[1].'</i> in <b>'.(defined('IS_ADMIN')&&IS_ADMIN ? $args[2] : $filename[(count($filename)-1)]).'</b> on line <b>'.$args[3].'</b>';
			if(defined('INSTALLER')){
				die($msg);
			}else{
				msg('ERR', $msg, null, null, null, false);
			}
		}
	}

	/**
	 * Used to determine the base path of the CMS installation;
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	Jesus
	 *
	 * @return 	string
	 */
	function root(){
		global $_SERVER;
		$path = str_replace('\\', '/', __FILE__);
		$newPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
		$newPath = substr($newPath, 0, strrpos($newPath, 'core/baseFunctions.php'));
		if(substr($newPath, 0, 1) == '/'){ $newPath = substr($newPath, 1); }
		return ($newPath != '' && $newPath != '/' ? $newPath : '');
	}

	/**
	 * Joins a path together using proper directory separators
	 * Taken from: http://www.php.net/manual/en/ref.dir.php
	 *
	 * @since 1.0.0
	 */
	function joinPath(){
		$args = func_get_args();
		return implode(DIRECTORY_SEPARATOR, $args);
	}


	/**
	 * Handles securing input/output
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string 	$string
	 * @param 	string	$mode
	 *
	 * @return 	string
	 */
	function secureMe($string, $mode='html') {
		switch(strtolower($mode)) {
			case 'html':
				$string = htmlspecialchars($string);
			break;

			case 'url':
				$string = urlencode($string);
			break;

			case 'sql':
				$string = mysql_real_escape_string($string);
			break;

			case 'langvar':
				$string = htmlspecialchars($string);
				$string = str_replace(array('&gt;', '&lt;', '&amp;', '&quot;'), array('>', '<', '&', '"'), $string);
			break;

			case 'num':
				if(!ctype_digit((string)$string)){
					$string = preg_replace('/[^0-9]/', '', $string);
				}
			break;

			case 'alphanum':
				if(!ctype_alnum((string)$string)){
					$string = preg_replace('/[^a-zA-Z0-9-_]/', '', $string);
				}
			break;

			default: break;
		}

		return $string;
	}

	/**
	 * Determines whether to set
	 *
	 * @version	1.0
	 * @since 	1.0.0
	 * @author 	xLink
	 *
	 * @param 	string 	$key
	 * @param 	string	$defaultValue
	 * @param 	array	$args
	 * @param 	string	$callback
	 *
	 * @return 	string
	 */
	function doArgs($key, $defaultValue, $args, $callback=false){
		$extra = true; //set this to true so the end result will work

		//if we have a callback then exec
		if($callback !== false){
			$extra = (is_callable($callback) ? call_user_func($callback, $args[$key]) : false);
		}

		//test and return a value
		return (isset($args[$key]) && $extra ? $args[$key] : $defaultValue);
	}

	/**
	 * Turns a string SEO Friendly
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param	string	$text
	 *
	 * @return 	string
	 */
	function seo($text){
		$text = strtr($text, array('&amp' => ' and ', '/' => '-', '.' => '-'));
		$text = html_entity_decode($text);

		static $search, $replace;
			if (!$search) {
				$search = $replace = array();
				// Get the HTML entities table into an array
				$trans = get_html_translation_table(HTML_ENTITIES);
				// Go through the entity mappings one-by-one
				foreach ($trans as $literal => $entity) {
					// Make sure we don't process any other characters such as fractions, quotes etc:
					if (ord($literal) >= 192) {
						// Get the accented form of the letter
						$search[] = $literal;
						// Get e.g. 'E' from the string '&Eacute'
						$replace[] = $entity[1];
					}
				}
			}
			str_replace($search, $replace, $text);

			$text = trim(preg_replace('/[^a-z \d\-]/i', '', $text));
			$text = strtr(strtolower($text), array(' ' => '-'));
			$text = preg_replace('/[\-]{2,}/', '-', $text);
			$text = rtrim($text, '-');
			if(is_number($text)) { $text = 'number-'.$text; } // numeric names would confuse everything
	 	return $text;
	}


	/**
	 * Run a function recursivly through an array
	 * http://www.php.net/manual/en/function.array-walk-recursive.php#99639
	 *
	 * @version	1.0
	 * @since  	1.0.0
	 * @author 	bradbeattie [at] gmail [dot] com
	 *
	 * @param 	array 	$array
	 * @param 	string	$function Callback
	 * @param 	array	$parameters
	 *
	 * @return 	string
	 */
	function recursiveArray(&$array, $function, $parameters = array()) {
		$reference_function = function(&$value, $key, $userdata) {
			$parameters = array_merge(array($value), $userdata[1]);
			$value = call_user_func_array($userdata[0], $parameters);
		};
		array_walk_recursive($array, $reference_function, array($function, $parameters));
	}

	/**
	 * Set a cookie, this cookie shouldnt be accessable via scripting languages such as JS.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$name
	 * @param 	string	$value
	 * @param 	int		$expire
	 *
	 * @return 	bool
	 */
	function set_cookie($name, $value, $expire){
		//if cookie got set, then temp set it in PHP so its accessable before the next page reload
		if(setCookie($name, $value, $expire, '', '', false, true)){
			$_COOKIE[$name] = $value;
			return true;
		}

		return false;
	}


	/**
	 * Checks to see if the var is empty, checks against null, empty array and false
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string	$var
	 *
	 * @return 	bool
	 */
	function is_empty($var) {
		if(is_null($var) || empty($var) || (is_string($var) && trim($var)=='')){ return true; }
		if(is_array($var) && !count($var)){ return true; }
		if($var === false){ return true; }

		return false;
	}


	/**
	 * Checks to see if the var is a number (0-9 only)
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$number
	 *
	 * @return 	bool
	 */
	function is_number($number){
		return (ctype_digit((string)$number) ? true : false);
	}

	/**
	 * Retreives part of a string
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param   string 	$begin
	 * @param   string 	$end
	 * @param   string 	$contents
	 *
	 * @return 	string
	 */
	function inBetween($begin, $end, $contents) {
		$pos1 = strpos($contents, $begin);
		if($pos1 !== false){
			$pos1 += strlen($begin);
			$pos2 = strpos($contents, $end, $pos1);
			if($pos2 !== false){
				$substr = substr($contents, $pos1, $pos2 - $pos1);
				return $substr;
			}
		}
		return false;
	}

	/**
	 * Sends an email to the intended target
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string 	$to
	 * @param   string 	$subject
	 * @param   string 	$message
	 *
	 * @return 	bool
	 */
	function sendMail($to, $subject, $message, $dontDie=false){
		global $config;

		if(_mailer($to, $config['site']['admin_email'], $subject, $message)){
			return true;
		}

		if($dontDie){ return false; }
		msgDie('FAIL', 'Error: Could not send email. If this is unexpected please contact the administrator of this website.');
	}

	/**
	 * Sends an email to the intended target
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 * @access 	private
	 *
	 * @param   string 	$to
	 * @param   string 	$from
	 * @param   string 	$subject
	 * @param   string 	$message
	 *
	 * @return 	bool
	 */
	function _mailer($to, $from, $subject, $message){
		$server = $_SERVER['HTTP_HOST'];

		//set headers for the email
		$headers[] = 'From: NoReply <'.$from.'> ';
		$headers[] = 'Reply-To: NoReply <'.$from.'> ';
		$headers[] = 'Return-Path: NoReply <'.$from.'> ';
		$headers[] = 'Date: '.date('r', time()).' ';
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Message-ID: <'.md5(uniqid(time())).'@'.$server.'> ';
		$headers[] = 'Content-Type: text/html; charset="iso-8859-1" ';
		$headers[] = 'X-Mailer: PHP v'.phpversion().' ';
		$headers[] = 'X-Priority: 3 ';
		$headers[] = 'X-MSMail-Priority: Normal ';
		$headers[] = 'X-MimeOLE: Produced By CybershadeCMS '.cmsVERSION.' ';

		if(@mail($to, $subject, $message, implode("\n", $headers))){
			return true;
		}

		return false;
	}

	/**
	 * Returns a list of all directories and files
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param   string 	$path
	 *
	 * @return 	array
	 */
	function getFiles($path) {
		$files = array();
		$fileNames = array();
		$i = 0;

		if(!is_dir($path)){ return array(); }

		if($dh = opendir($path)) {
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..') { continue; }
				$fullpath = $path . '/' . $file;
				$fkey = strtolower($file);
				while(array_key_exists($fkey, $fileNames)) {
				$fkey .= ' ';
				}

				$a = stat($fullpath);
				$files[$fkey]['size'] = $a['size'];
				$files[$fkey]['sizetext'] = ($a['size'] > 0) ? formatBytes($a['size']) : '-';
				$files[$fkey]['name'] = $file;
				$files[$fkey]['type'] = filetype($fullpath);
				$fileNames[$i++] = $fkey;
			}
			closedir($dh);
		} else {
			die('Cannot open directory: ' . $path);
		}

		if(is_empty($fileNames)){ return array(); }

		sort($fileNames, SORT_STRING);
		$sortedFiles = array();
		$i = 0;
		foreach($fileNames as $f) {
			$sortedFiles[$i++] = $files[$f];
		}

		return $sortedFiles;
	}

	/**
	 * Quickly generate a readable filesize
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param   int		$size
	 *
	 * @return 	string
	 */
	function formatBytes($size) {
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++){
			$size /= 1024;
		}

		return round($size, 2).$units[$i];
	}

	/**
	 * Attempts to figure out what browser the string is relating to
	 *
	 * @version	2.0
	 * @since   1.0.0
	 *
	 * @param   string 	$useragent
	 *
	 * @return 	string
	 */
	function getBrowser($useragent){
		// BE CAREFUL WHEN MODIFYING AS THE ORDER DOES MATTER!
		if(strpos($useragent, 'Nintendo Wii') !== false){ 	return 'Nintendo Wii'; }
		if(strpos($useragent, 'Nitro') !== false){ 			return 'Nintendo DS'; }
		if(strpos($useragent, 'Opera') !== false){ 			return 'Opera'; }
		if(strpos($useragent, 'iPhone') !== false){ 		return 'iPhone'; }
		if(strpos($useragent, 'Chrome') !== false){ 		return 'Chrome'; }
		if(strpos($useragent, 'Netscape') !== false){ 		return 'Netscape'; }
		if(strpos($useragent, 'OmniWeb') !== false){ 		return 'OmniWeb'; }
		if(strpos($useragent, 'Safari') !== false){ 		return 'Safari'; }
		if(strpos($useragent, 'Konqueror') !== false){ 		return 'Konqueror'; }
		if(strpos($useragent, 'Minimo') !== false){ 		return 'Minimo'; }
		if(strpos($useragent, 'Galeon') !== false){ 		return 'Galeon'; }
		if(strpos($useragent, 'Phoenix') !== false){ 		return 'Phoenix'; }
		if(strpos($useragent, 'Firefox') !== false){ 		return 'Firefox'; }
		if(strpos($useragent, 'SeaMonkey') !== false){ 		return 'SeaMonkey'; }
		if(strpos($useragent, 'NetPositive') !== false){ 	return 'NetPositive'; }
		if(strpos($useragent, 'PalmOS') !== false){ 		return 'Novarra'; }
		if(strpos($useragent, 'Avant Browser') !== false){ 	return 'Avant Browser'; }
		if(strpos($useragent, 'PSP') !== false){ 			return 'PlayStation Portable'; }
		if(strpos($useragent, 'PLAYSTATION') !== false){ 	return 'PlayStation'; }
		if(strpos($useragent, 'Camino') !== false){ 		return 'Camino'; }
		if(strpos($useragent, 'OffByOne') !== false){ 		return 'Off By One'; }
		if(strpos($useragent, 'PIE') !== false){ 			return 'Pocket Internet Explorer'; }
		if(strpos($useragent, 'WebTV') !== false){ 			return 'WebTV'; }
		if(strpos($useragent, 'MSIE') !== false){ 			return 'Internet Explorer'; }
		if(strpos($useragent, 'Jeeves') !== false){ 		return 'Ask Bot'; }
		if(strpos($useragent, 'googlebot') !== false){ 		return 'Google Bot'; }
		if(strpos($useragent, 'grub') !== false){ 			return 'Grub Crawler'; }
		if(strpos($useragent, 'Yahoo!') !== false){ 		return 'Yahoo! Slurp'; }
		if(strpos($useragent, 'Slurp') !== false){ 			return 'Inktomi Slurp'; }
		if(strpos($useragent, 'w3m') !== false){ 			return 'w3m'; }
		if(strpos($useragent, 'Lynx') !== false){ 			return 'Lynx'; }
		if(strpos($useragent, 'ELinks') !== false){ 		return 'ELinks'; }
		if(strpos($useragent, 'Links') !== false){			return 'Links'; }
		if(strpos($useragent, 'Googlebot') !== false){ 		return 'Google Bot'; }
		if(strpos($useragent, 'msnbot') !== false){ 		return 'MSN Bot'; }
		if(strpos($useragent, 'ia_archiver') !== false){ 	return 'Alexa Bot'; }
		if(strpos($useragent, 'Baiduspider') !== false){ 	return 'Baidu Spider'; }
		if(strpos($useragent, 'curl') !== false){ 			return 'cURL Bot'; }
		if(strpos($useragent, 'GameSpy') !== false){ 		return 'GameSpy HTTP'; }
		if(strpos($useragent, 'Gigabot') !== false){ 		return 'Giga Bot'; }
		if(strpos($useragent, 'Scooter') !== false){ 		return 'Scooter Bot'; }
		if(strpos($useragent, 'Wget') !== false){ 			return 'wget'; }
		if(strpos($useragent, 'Yahoo') !== false){ 			return 'Yahoo Crawler'; }
		if(strpos($useragent, 'Android') !== false){ 		return 'Android'; }
		if(strpos($useragent, 'iCab') !== false){ 			return 'iCab'; }
		if(strpos($useragent, 'AvantGo') !== false){ 		return 'AvantGo'; }
		if(strpos($useragent, 'amaya') !== false){ 			return 'Amaya'; }
		if(strpos($useragent, 'Mozilla') !== false){ 		return 'Mozilla'; }
		if(strpos($useragent, 'America Online Browser') !== false){ return 'AOL Explorer'; }

		return $useragent;
	}


	/**
	 * Returns a language var ready to be used on the page.
	 *
	 * @version	2.0
	 * @since	1.0.0
	 *
	 * @param	string 	$langVar
	 * @param	...
	 *
	 * @return 	string
	 */
	function langVar(){
		global $_lang;

		//get how many arguments the function received
		$args = func_get_args();
		$var = $args[0]; //the lang var should be the first argument anyways

		$var = doArgs($var, null, $_lang); //get the corresponding lang var

		//quick test to make sure the lang var exists
		if(is_empty($var)){ return false; }

			//swap the first argument for the language var
			foreach($args as $k => $v){ $vars[$k] = ($k==0 ? $var : $v); }

		if(is_array($var)){
			foreach($var as $k => $v){
				$var[secureMe($k, 'langVar')] = secureMe($v, 'langVar');
			}
		}else{
			$var = secureMe($var, 'langVar');
		}
		return count($args)>1 ? call_user_func_array('sprintf', $vars) : $var;
	}

	/**
	 * Adds a language file to the global language array
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param   string 	$file
	 *
	 * @return 	bool
	 */
	function translateFile($file){
		global $_lang;

		if(is_file($file) && is_readable($file)){
			include_once($file);
			return true;
		}
		return false;
	}

	/**
	 * Central place to call the cache calls from.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @param   string 	$file
	 * @param   var 	$new_file
	 */
	function newCache($file, &$new_file){
		global $objCore;
		switch($file){
			case 'config':
				$objCore->objCache->initCache('config_db',			'cache_config.php',
					'SELECT * FROM $Pconfig', $new_file);
			break;
			case 'groups':
				$objCore->objCache->initCache('groups_db',			'cache_groups.php',
					'SELECT * FROM $Pgroups ORDER BY `order` ASC', $new_file);
			break;
			case 'bans':
				$objCore->objCache->initCache('bans_db',			'cache_bans.php',
					'SELECT * FROM $Pbanned', $new_file);
			break;
			case 'menus':
				$objCore->objCache->initCache('menus_db',			'cache_menus.php',
					'SELECT * FROM $Pmenus ORDER BY `order` ASC', $new_file);
			break;
			case 'menu_setups':
				$objCore->objCache->initCache('menu_setups_db',		'cache_menu_setups.php',
					'SELECT * FROM $Pmenu_setups ORDER BY `order` ASC', $new_file);
			break;
			case 'menu_blocks':
				$objCore->objCache->initCache('menu_blocks_db',		'cache_menu_blocks.php',
					'SELECT * FROM $Pmenu_blocks', $new_file);
			break;
			case 'group_subscriptions':
				$objCore->objCache->initCache('user_permissions_db','cache_group_subscriptions.php',
					'SELECT * FROM $Pgroup_subs', $new_file);
			break;
			case 'modules':
				$objCore->objCache->initCache('modules_db',			'cache_modules.php',
					'SELECT * FROM $Pmodules', $new_file);
			break;
			case 'plugins':
				$objCore->objCache->initCache('plugins_db',			'cache_plugins.php',
					'SELECT * FROM $Pplugins', $new_file);
			break;

		//
		//--Use Callback functions to generate the required configuations
		//
			case 'statistics':
				$objCore->objCache->initCache('statistics_db',		'cache_statistics.php',
					NULL, $new_file, 'Cache::generate_statistics_cache');
			break;
		}
	}

	/**
	 * Parse an .ini string into a useable array
	 *
	 * @version 1.0
	 * @since 	1.0.0
	 *
	 * @param 	string 	$string
	 * @param 	bool 	$processSelections
	 *
	 * @return 	string
	 */
    function parseMenuParams($str, $processSections=false){
		$lines 	= explode("\n", $str);
		$return = array();
		$inSect = false;

		//make sure we have something to play with first
		if(!count($lines)){ return false; }

		foreach($lines as $line){
			$line = trim($line);

			//make sure $line isnt empty, or starts with a comment
			if(is_empty($line) || $line[0] == '#' || $line[0] == ';'){ continue; }

			//test to see if we are in a section
			if($line[0] == '[' && $endIdx = strpos($line, ']')){
				$inSect = substr($line, 1, $endIdx-1);
				continue;
			}

			//We dont use "=== false" because value 0 is not valid as well
			if(!strpos($line, '=')){ continue; }

			$tmp = explode('=', $line, 2);
			if($processSections && $inSect){
				$return[$inSect][trim($tmp[0])] = ltrim($tmp[1]);
			}else{
				$return[trim($tmp[0])] = ltrim($tmp[1]);
			}
		}
		return $return;
	}

	/**
	 * Configures the Menu system and outputs the requested version
	 *
	 * @version 3.5
	 * @since 	1.0.0
	 *
	 * @param 	string $module
	 * @param 	string $page_id
	 *
	 * @return 	bool
	 */
	function show_menu($module, $page_id='default'){
		global $config, $objCore;

		//either this or globalling a shit ton of vars?
		$objUser = $objCore->objUser;
		$objSQL = $objCore->objSQL;
		$objTPL = $objCore->objTPL;

		//if we havent got what we need, attempt to grab it
		if(!isset($config['menu_setups']) || $config['menu_setups']===NULL){
			$query = 'SELECT * FROM $Pmenu_setups WHERE module = "%s" AND page_id = "%s" ORDER BY `order` ASC';
			$config['menu_setups'] = $objSQL->getTable($objSQL->prepare($query, $module, $page_id));
		}

        //make sure we have something to play with
        if(is_empty($config['menu_setups'])){ return false; }

        //sort out where the menus are supposed to go
        $menu = array();
        foreach($config['menu_setups'] as $row){
			//if its not on the side wer looking for, move on
			if(strtolower($module) != strtolower($row['module']) || $page_id != $row['page_id']){ continue; }

			//set the menu position in the array, default to the left side
			switch($row['position']){
				default:
				case 0: $menu['left'][] 	= $row; break;
				case 1: $menu['right'][] 	= $row; break;
				case 2: $menu['center'][] 	= $row; break;
			}
        }

		//no point continuing if we arnt populated
		if(is_empty($menu)){ return false; }

		//loop thru left right and center
		foreach($menu as $k => $menuBlock){
			foreach($menuBlock as $row){
				//loop thru the block lookin for the right one
				foreach($config['menu_blocks'] as $menu){
					//if its not the one we need, continue
					if(strtolower($menu['unique_id']) != strtolower($row['menu_id'])){ continue; }

					//now check if we can call the function
					if(!function_exists($menu['function'])){
						if(is_empty($menu['module'])){ $menu['module'] = 'core'; }
						if(is_file(cmsROOT.'modules/'.$menu['module'].'/block.php')){
							include_once cmsROOT.'modules/'.$menu['module'].'/block.php';
						}
					}
					break; //just so the foreach dosent write over $menu
				}

				//check perms, no point processing that info if they cant view it anyway
				if(!$objUser->checkPermissions($objUser->grab('id'), $menu['perms'])){
					continue;
				}

				$i = $row['id'];
				if(isset($_cachee[$i]) && !is_empty($_cache[$i])){
					$content = $_cache[$i];
				}else{
                    //parse the params for this menu block..
                    $params = (is_empty($row['params']) ? array() : parseMenuParams($row['params']));

                    //set various things up accordingly
                    $title = doArgs('menu_title', $params['menu_title'], $params);
					$content = langVar('INVALID_FUNCTION', $menu['function'].'()');

					//can we call the function or do we have to generate from get_menu()?
					if(is_callable($menu['function']) && $objUser->checkPermissions($objUser->grab('id'), $menu['perms'])){
						//we wanna add in some custom params
						$params += array(
							'uniqueId' 	=> $menu['uniqueId'],
							'block' 	=> $k.'_menu',
							'title' 	=> $title
						);

						//call the function
						$content = call_user_func($menu['function'], $params);

					}else if(is_empty($menu['function']) || $menu['function']=='NULL'){
						//switch so we get the right menu
						switch($params['menu_name']){
							case 'NULL':        /* Dont do anythin to this one */                       break;
							case 'main_menu':   $params['menu_name'] = 'menu_mm';                       break;
							default:            $params['menu_name'] = 'menu_'.$params['menu_name'];    break;
						}

                        //get the menu
                        $return = get_menu($params['menu_name'], 'link');
                        if(!is_empty($return)){
                        	$content = $return;
						}
					}
					//do this so we dont have to keep processing the same menu
        			$_cache[$i] = $content;
				}
				//output it on the template
    			$objTPL->assign_block_vars($k.'_menu', array(
    				'TITLE'            => $title,
    				'CONTENT'          => $content,
    			));
			}
            //let the page class know we've been busy and to show the menu
            return true;
        }
        //nothing happened, so return false
        return false;
	}

	/**
	 * Returns the menu links for a specific menu
	 *
	 * @version 2.0
	 * @since 	1.0.0
	 *
	 * @param 	string $name
	 * @param 	string $returnType
	 *
	 * @return 	array/string
	 */
	function get_menu($menu_id, $returnType='link'){
		global $objUser, $config;

		//set some inital vars
		$return = ($returnType=='array' ? array() : '');
		$i = 0;

		if(is_empty($config['menus'])){ return $return; }

		foreach($config['menus'] as $menu){
			//make sure we have the right name
			if(strtolower($menu_id) != strtolower($menu['menu_id'])){ continue; }

			//make sure the current users permissions covers this menu item
			if(!$objUser->checkPermissions($objUser->grab('id'), $menu['perms'])){ continue; }

			$link = $menu['external']==1 ? $menu['link_value'] : '/'.root().$menu['link_value'];
			$blank = $menu['blank']==1 ? ' target="_blank"' : '';

			$start = $stop = '';
			if(!is_empty($menu['link_color'])){
				$start = '<font style="color: '.$menu['link_color'].';">';
				$stop = '</font>';
			}

			//setup the return value based on what we wanted
			if($returnType=='array'){
				$return[$i]['full_link'] = '<a href="'.$link.'"'.$blank.'>'.$start.$menu['link_name'].$stop.'</a>';
				$return[$i]['options']['link'] = $link;
				$return[$i]['options']['name'] = $menu['link_name'];
				$return[$i]['options']['blank'] = $blank;
				$return[$i]['options']['color'] = $menu['link_color'];
			}else{
				$return .= '<a href="'.$link.'"'.$blank.'>'.$start.$menu['link_name'].$stop.'</a><br />'."\n";
			}
			$i++;
        }
    	return $return;
    }


//
//-- MSG Functions
//
	/**
	 * Displays a formatted error on screen.
	 *
	 * @version	3.0
	 * @since   1.0.0
	 */
	function msg($msg_type, $message, $tplVar=NULL, $title=NULL){
	    global $objTPL, $objPage, $objModule;

	    if(!is_object($objTPL) || !is_object($objPage)){ echo $message; exit; }

		$handle = '__msg_'.($tplVar===NULL ? rand(0, 1000) : $tplVar);
		$handle = (is_object($objModule) && $tplVar=='body') ? 'body' : $handle;
		$objTPL->set_filenames(array(
			$handle	=> cmsROOT.'modules/core/template/message.tpl'
		));

		switch(strtolower($msg_type)){
	        case 'fail':    $img = '/'.root().'images/fail.png'; $type = 'error';    break;
	        case 'ok':      $img = '/'.root().'images/ok.png';   $type = 'status';   break;
	        case 'info':    $img = '/'.root().'images/info.png'; $type = 'warning';  break;

	        default: $img = NULL; break;
	    }

		$objTPL->assign_vars(array(
			'L_MSG_TYPE'	=> (is_empty($title) ? langVar('MSG_'.strtoupper($msg_type)) : $title),
			'L_MSG'			=> $message,
			'IMG'           => isset($img) && !is_empty($img) ? '<img src="'.$img.'" style="height: 48px; width: 48px;">' : '',
			'ALIGN'         => 'left',
			'TYPE'          => $type,
		));

	    if($tplVar===NULL){
	    	$objTPL->parse($handle);
		}else if($tplVar=='return'){
	    	return $objTPL->get_html($handle);
		}else if($handle=='body'){
	    	$objTPL->parse($handle, false);
	    }else{
	        $objTPL->assign_var_from_handle($tplVar, $handle);
		}
	}

	/**
	 * Displays a confirmation messagebox.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author 	xLink
	 *
	 * @param 	string $type
	 * @param 	string $msg
	 * @param 	string $title
	 * @param 	string $tplVar
	 *
	 * @return 	bool
	 */
	function confirmMsg($type, $msg, $title=NULL, $tplVar=NULL){
	    global $objPage, $objForm, $objUser;

		//check if we have confirmed either way yet
		if(!HTTP_POST){
			//setup redirects and session ids
			$_SESSION['site']['confirm']['return'] = (isset($_SERVER['HTTP_REFERER'])&&!is_empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'.root().'');
	        $_SESSION['site']['confirm']['sessid'] = $sessid = $objUser->mkPasswd($objUser->grab('username').time());

	        //and the form, atm its gotta be crude, it'll be sexied up for the rebuild
			$newMsg = $objForm->start('msg', 'POST', '');
			$newMsg .= $msg.'<br />';
			$newMsg .= $objForm->inputbox('hidden', $sessid, 'sessid').'<br />';
			$newMsg .= '<div align="center">'.$objForm->button('Continue', 'submit').' '.$objForm->button('Go Back', 'submit').'</div>';
			$newMsg .= $objForm->finish();

			//use msg() to output and return false so the code wont exec below
			echo msg($type, $newMsg, $tplVar, $title);

			return false;
		}else{
			//now we have confirmed, lets do a little sanity checking
			$redir = $_SESSION['site']['confirm']['return'];

			//we have the sessid
			if(!isset($_POST['sessid'])){ hmsgDie('FAIL', 'Error: Please confirm your intentions via the form.'); }
			if($_POST['sessid']!=$_SESSION['site']['confirm']['sessid']){ hmsgDie('FAIL', 'Error: Could not verify your intentions.'); }

			//dont need this anymore
			unset($_SESSION['site']['confirm']);

			//make sure we actually have the submit
			if(!isset($_POST['submit'])){ hmsgDie('FAIL', 'Error: Could not verify your intentions.'); }

			//now check for what we expect and act accordingly
			if($_POST['submit']=='Continue'){
				return true;
			}

			if($_POST['submit']=='Go Back'){
				$objPage->redirect($redir, 0, 3);
				hmsgDie('INFO', 'Redirecting you back.');
			}

			//if we get here, they tried to play us, so lets just return false anyway
			return false;
		}
	}

	/**
	 * Shows a message and then exit the current page with a footer.
	 *
	 * @version	2.0 		Updated to work with 0.8 structure
	 * @since   0.6.0
	 */
	function msgDie($msg_type, $message, $line=NULL, $file=NULL, $query=NULL, $footer=true){
	    global $objTPL, $objPage;

	    if(!is_object($objTPL) || !is_object($objPage)){ echo $message; exit; }
	    $header = $objPage->getVar('header');
	    if(!$header['completed']){ $objPage->showHeader(true); }

		$objTPL->set_filenames(array(
			'__msgBody'	=> 'modules/core/template/message.tpl'
		));

		$query = !is_empty($query) ? $query : NULL;
		$line  = !is_empty($line)  ? $line  : NULL;
		$file  = !is_empty($file)  ? $file  : NULL;

		switch(strtolower($msg_type)){
	        case 'fail':    $img = '/'.root().'images/fail.png'; $type = 'error';    break;
	        case 'ok':      $img = '/'.root().'images/ok.png';   $type = 'status';   break;
	        case 'info':    $img = '/'.root().'images/info.png'; $type = 'warning';  break;

	        default: $img = NULL; break;
	    }

		$objTPL->assign_vars(array(
			'L_MSG_TYPE'	=> langVar('MSG_'.strtoupper($msg_type)),
			'L_MSG'			=> $message,
			'QUERY'			=> $query,
			'LINE'			=> 'Line: '.$line,
			'FILE'			=> 'File: '.$file,
			'IMG'           => isset($img) && !is_empty($img) ? '<img src="'.$img.'" style="height: 48px; width: 48px;">' : '',
			'ALIGN'         => 'center',
			'TYPE'          => $type,
		));

		$gen_time = '0';
		$objTPL->parse('__msgBody');

		if($footer){
	        $objPage->showFooter(false, false);
		}
	    exit;
	}

	/**
	 * Displays the header with an error.
	 *
	 * @version	1.0
	 * @since   0.8.0
	 */
	function hmsgDie($type, $msg){
	    global $objPage;

	    $doSimple = false;
	    if(AJAX_CALL || isset($_GET['ajax']) ||$objPage->getVar('simpleTpl')){
	    	$doSimple = true;
		}

	    $objPage->showHeader($doSimple);
	    msgDie($type, $msg, '', '', '', !$doSimple);
	}


?>