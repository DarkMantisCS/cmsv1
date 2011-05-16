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
* @author      xLink
*/
class cache extends coreClass{

	var $cacheToggle = '';
	var $output = array();
	var $cacheDir = '';

	function __construct($args=array()) {
		$this->cacheToggle = doArgs('useCache', false, $args);
		$this->cacheDir = doArgs('cacheDir', '', $args);
	}

	/**
	 * Sets up a new cache file
	 *
	 * @version     1.0
	 * @since       1.0.0
	 * @author      xLink
	 */
	function initCache($name, $file, $query, &$result, $callback=null){
		if($this->cacheToggle && is_file($this->cacheDir . $file)){
			include($this->cacheDir . $file);
			$result = $$name;

		}else if($callback!==null){
			eval('$result = '.$callback.'();');

		}else{
			$result = $this->generateCache($name, $file, $query);
		}

		return true;
	}

	/**
	 * Regenerates a cache file
	 *
	 * @version     1.0
	 * @since       1.0.0
	 * @author      xLink
	 */
	function regenerateCache($file){
		//if its present, remove it
		if(is_readable($this->cacheDir.'cache_'.$file.'.php')){
			unlink($this->cacheDir.'cache_'.$file.'.php');
		}

		//regenerate a new cache file
		$fn = ${$file.'_db'};
		newCache($file, $fn);
	}

	/**
	 * Generates a loadable array based on sql query
	 *
	 * @version     1.0
	 * @since       1.0.0
	 * @author      xLink
	 */
	function generateCache($name, $file, $query){
		unset($this->output);

		//query db
		$query = $this->objSQL->prepare($query);
		$query = $this->objSQL->getTable($query);

		//check to make sure it worked
		if(!$query){ $this->output = false; }

		//loop through each row of the returned array
		if(is_array($query) && !is_empty($query)){
			foreach($query as $row){
				$nline = array();

				//and through each column of the row
				foreach($row as $k => $v){
					if(!is_number($k) && $k!='0'){
						$nline[$k] = $v;
					}
				}

				//grab generated array
				$this->output[] = $nline;
			}
		}

		//if we can cache it
		if($this->cacheToggle) {
			//lets!
			$fp = @fopen($this->cacheDir . $file, 'wb');
				if(!$fp){ return false; }

			fwrite($fp, '<?php'."\n"."if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }".
						"\n".'$'.$name.' = '.var_export($this->output, true).';'.
						"\n".'?>');
			fclose($fp);
		}

		//return the array directly, so its ready for use straight away
		return $this->output;
	}

    function generate_statistics_cache(){
    //grab some info to put into the stat file
		$this->objSQL->recordMessage('Cache: Recalculating Statistics', 'WARNING');
		//total members in db
			$total_members  = $this->objSQL->getInfo('users');
		//last user info, for the stat menu
			$query = $this->objSQL->prepare('SELECT id, username FROM $Pusers ORDER BY id DESC LIMIT 1');
			$last_user      = $this->objSQL->getLine($query);
		//online members and guests
			$query = $this->objSQL->prepare('SELECT DISTINCT username FROM $Ponline WHERE username != "Guest"');
			$online_users   = $this->objSQL->getTable($query);

			$query = $this->objSQL->prepare('SELECT DISTINCT ip_address FROM $Ponline WHERE username = "Guest"');
			$online_guests  = $this->objSQL->getTable($query);
		//get cron updates
			$query = $this->objSQL->prepare('SELECT * FROM $Pstatistics');
			$cron = $this->objSQL->getTable($query);

		if($cron){
			foreach($cron as $i){
				if($i['variable']=='hourly_cron'){ 	$hourly = $i['value']; }
				if($i['variable']=='weekly_cron'){ 	$weekly = $i['value']; }
				if($i['variable']=='daily_cron'){ 	$daily = $i['value']; }
				if($i['variable']=='site_opened'){ 	$started = $i['value']; }
			}
		}

		$this->output = array(
			'site_opened' 		=> $started,
			'total_members' 	=> $total_members,
			'last_user_id' 		=> $last_user['id'],
			'last_user_user' 	=> $last_user['username'],
			'online_users' 		=> count($online_users),
			'online_guests' 	=> count($online_guests),

			'hourly_cron' 		=> $hourly,
			'daily_cron' 		=> $daily,
			'weekly_cron' 		=> $weekly,

		);

		if($this->cache_toggle) {
			$fp = @fopen($this->cache_dir . 'cache_statistics.php', 'wb');
			if(!$fp){ return false; }

			fwrite($fp, '<?php'."\n"."if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}".
				"\n".'$statistics_db = ' . var_export(@$this->output, true).';'."\n".
				'?>');
			fclose($fp);
		}

		return @$this->output;
    }


}
?>