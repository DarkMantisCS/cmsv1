<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
* MySQL Driver support for the SQLBase
*
* @version		1.0
* @since		1.0.0
* @author		xLink
*/
class mysql extends coreClass implements SQLBase{

	/**
	 * Sets up a new MySQL Class
	 *
	 * @version	1.0
	 * @since	1.0.0
	 * @author	xLink
	 *
	 * @param	array	$config
	 *
	 * @return	bool
	 */
	public function __construct($config=array()) {
		if(is_empty($config)){
			return false;
		}

		$this->db = array(
			'host'		=> doArgs('host', 		'', $config, 'is_empty'),
			'username'	=> doArgs('username', 	'', $config, 'is_empty'),
			'password'	=> doArgs('password', 	'', $config, 'is_empty'),
			'database'	=> doArgs('database', 	'', $config, 'is_empty'),
			'prefix'	=> doArgs('prefix', 	'', $config, 'is_empty'),
		);

		return true;
	}

	/**
	 * Sets up a connection to the database
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   bool 	$debug
	 * @param   bool 	$logging
	 *
	 * @return  bool
	 */
	public function connect($persistent=false, $debug=false, $logging=false) {
		$this->error = false;
		$this->failed = false;
		$this->debug = $debug;
		$this->logging = $logging;
		$this->persistent = $persistent;

		if($this->persistent == true) {
			$this->link_id = @mysql_pconnect($this->db['host'], $this->db['username'], $this->db['password']);
			if($this->link_id == false) {
				$this->persistent = false;
			}
		}

		if($this->persistent == false) {
			$this->link_id = @mysql_connect($this->db['host'], $this->db['username'], $this->db['password']);
		}

		if($this->link_id){
			$this->errorMsg = 'Cannot connect to the database - verify username and password.';
			return false;
		}

		$this->selectDb($this->db['database']);
		if($this->failed){
			$this->errorMsg = 'Cannot select database - check user permissions.';
			return false;
		}

		if($this->persistent == false && !defined('NO_DB')) {
			$this->recordMessage('CMS is not using a persistant connection with the database.', 'WARNING');
		}

		return true;
	}

	/**
	 * Disconnects the current connection
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 */
	public function disconnect(){
		$this->freeResult();
		if($this->persistent == false){
			mysql_close($this->link_id);
		}

		if($this->debug){
			$queries = 0;
			$queries_failed = 0;
			foreach($this->debugtext as $row) {
				if($row['time'] != '---------') {
					$this->link_time += $row['time'];
					$queries++;
				}
				if($row['status'] == 'error') $queries_failed++;
			}

			$this->queries_executed = $queries + $queries_failed;
			$this->debugtext[] = array(
				'query' => '<span style="color:green"><b>REPORT:</b></span> {'.$this->queries_executed.'} queries executed, {'.$queries.
								'} succeded and {'.$queries_failed.'} failed in '.substr($this->link_time, 0, 7).' seconds',
				'time' => '---------',
				'status' => 'ok',
			);
		}
	}

	/**
	 * Escapes a string ready for the database
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	mixed 	$string
	 *
	 * @return 	mixed
	 */
	public function escape($string){
		if(function_exists('mysql_real_escape_string') && $this->link_id) {
			if(is_array($string)){
				recursiveArray($string, 'mysql_real_escape_string');
				return $string;
			}

			return mysql_real_escape_string($string);
		} else {
			if(is_array($string)){
				recursiveArray($string, 'mysql_escape_string');
				return $string;
			}

			return mysql_escape_string($string);
		}
	}

	/**
	 * Retreives the last error reported
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @return 	string
	 */
	public function getError() {
		return mysql_error($this->link_id);
	}

	/**
	 * Selects the database for use
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$db
	 *
	 * @return 	bool
	 */
	public function selectDb($db) {
		return mysql_select_db($db, $this->link_id) or $this->recordMessage(null, 'ERROR');
	}

	/**
	 * Selects the database for use
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 */
	public function freeResult() {
		if(isset($this->results) && is_resource($this->results)) {
			mysql_free_result($this->results);
			unset($this->results);
		}
	}

	/**
	 * Gets the specified table prefix
	 *
	 * @version	1.0
	 * @since	1.0.0
	 * @author	xLink
	 *
	 * @param	string	$mode
	 *
	 * @return	string
	 */
	function prefix($mode='') {
		if(isset($this->prefix[$mode])){
			return $this->prefix[$mode];
		}
		if(is_empty($mode) || $mode==0){
			return $this->db['prefix'];
		}

		return false;
	}

	/**
	 * Adds a new prefix to the collection, useful for bridging projects
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$mode
	 * @param	string 	$prefix
	 *
	 * @return 	bool
	 */
	function addPrefix($mode, $prefix){
		if($mode == 0){
			return false;
		}

		$this->prefix[$mode] = $prefix;

		return true;
	}

	/**
	 * Adds a new prefix to the collection, useful for bridging projects
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$db
	 *
	 * @return 	bool
	 */
	public function prepare(){
		//grab the functions args
		$args = func_get_args();

		//replace $P with the table prefix
		$query = str_replace('$P', $this->prefix(), $args[0]);

		//escape the rest of the arguments
		$args = $this->escape($args);

		//make sure the query is 'normal'
		$args[0] = $query;

		//return thru sprintf
		return (count($args)>1 ? call_user_func_array('sprintf', $args) : $query);
	}

	/**
	 * Queries the database
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param	string 	$log
	 *
	 * @return 	resource
	 */
	public function query($query, $log = false) {
		$this->freeResult();

		$this->query_time = microtime(true);

		if($log){ $this->recordLog($query, $log, User::getIP()); }

		$this->results = mysql_query($query, $this->link_id) or $this->recordMessage(mysql_error(), 'WARNING');

		if($this->debug){
			$a = debug_backtrace();
			$file = $a[1];
			if(isset($file['args'])){
				foreach($file['args'] as $k => $v){
					$file['args'][$k] = (is_array($v) ? serialize($v) : $v);
				}
			}

			$query = secureMe($query);
			$pinpoint = '<br /><div class="content padding"><strong>'.realpath($file['file']).'</strong> @ <strong>'.$file['line'].
							'</strong> // Affected '.mysql_affected_rows().' rows.. <br /> '.$file['function'].'(<strong>\''.
							(isset($file['args']) ? secureMe(implode('\', \'', $file['args'])) : null).'\'</strong>); </div>';
			$this->debugtext[] = array('query' => $query.$pinpoint, 'time' => substr((microtime(true) - $this->query_time), 0, 7), 'status' => 'ok');
		}else{
			$this->debugtext[] = array('query' => $query, 'time' => null, 'status' => 'ok');
		}


		return $this->results;
	}

	/**
	 * Gets a row count from a table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$table
	 * @param	string 	$clause
	 * @param 	string 	$log
	 *
	 * @return 	int
	 */
	public function getInfo($table, $clause=null, $log=false){
		$statement = 'SELECT COUNT(*) FROM `$P'.$table.'`';
		if(!is_empty($clause)){
			$statement .= ' WHERE '.$clause;
		}

		$line = $this->getLine($statement, $log);

		return $line['COUNT(*)'];
	}

	/**
	 * Gets a row count from a table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$table
	 * @param 	string 	$field
	 * @param	string 	$clause
	 * @param 	string 	$log
	 *
	 * @return 	string
	 */
	public function getValue($table, $field, $clause=null, $log=false){
		$statement = 'SELECT %1$s FROM `$P%2$s`';
		if(!is_empty($clause)){
			$statement .= ' WHERE '.$clause;
		}
		$statement .= ' LIMIT 1;';

		$statement = $this->prepare($statement, $field, $table);
		$line = $this->getLine($statement, $log);

		return $line[$field];
	}

	/**
	 * Gets a row from a table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	string 	$log
	 *
	 * @return 	array
	 */
	public function getLine($query, $log=false) {
		$this->query($query, $log);

		if(!is_resource($this->results)) {
			$this->recordMessage('getLine: ('.$query.')', 'ERROR');
		} else {
			$line = mysql_fetch_assoc($this->results);
			$this->freeResult();
			return $line;
		}

		return false;
	}

	/**
	 * Returns query results in the form of an array
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	string 	$log
	 *
	 * @return 	array
	 */
	public function getTable($query, $log=false) {
		$this->query($query, $log);

		if(!is_resource($this->results)) {
			$this->recordMessage('getTable: ('.$query.')', 'ERROR');
		} else {
			$table = array();
			while($line = mysql_fetch_assoc($this->results)) {
				$table[] = $line;
			}
			$this->freeResult();
			return $table;
		}

		return false;
	}

	/**
	 * Inserts a row into specified table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	array 	$array
	 * @param 	string 	$log
	 *
	 * @return 	array
	 */
	function insertRow($table, $array, $log = false){
		if(is_empty($array)){ return false; }

		$comma = null;
		$listOfValues = null;
		$listOfElements = null;

		foreach($array as $elem => $value) {
			if($value === null){
				$listOfValues .= $comma .'null';
			}else{
				$listOfValues .= $comma .'\''. (string)$value .'\'';
			}

			$listOfElements .= $comma .'`'. $elem .'`';
			$comma = ',';
		}

		$query = 'INSERT HIGH_PROORITY INTO `$P%1$s` (%2$s) VALUES(%3$s)';
		$query = $this->prepare($query, $table, $listOfElements, $listOfValues);
		$this->query($query, $log);
		return mysql_insert_id($this->link_id);
	}

	/**
	 * Updates a table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	array 	$array
	 * @param 	string 	clause
	 * @param 	string 	$log
	 *
	 * @return 	array
	 */
	function updateRow($table, $array, $clause, $log=false){
		if(is_empty($array)){ return false; }

		$query = 'UPDATE `$P%1$s` SET';

		foreach($array as $index => $value){
			if($value === null){
				$query .= '`'.$index.'`=null, ';
			}else{
				$query .= '`'.$index.'`=\''.$this->escape($value).'\', ';
			}
		}

		$query = substr($query, 0, -2).' WHERE '.$clause.' LIMIT 1';

		$this->query($this->prepare($query, $table), $log);
		return mysql_affected_rows();
	}

	/**
	 * Deletes row(s) form a table
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	string 	clause
	 * @param 	string 	$log
	 *
	 * @return 	array
	 */
	public function deleteRow($table, $clause, $log=false){
		$this->query($this->prepare('SELECT FROM `$P$s` WHERE %s', $table, $clause), $log);

		return mysql_affected_rows($this->link_id);
	}

	/**
	 * Records a message in the footer debug
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$message
	 * @param 	string 	$mode
	 */
	function recordMessage($message, $mode=false) {
		$this->failed = true;
		if($this->debug) {
			$a = debug_backtrace();
			$file = $a[2];
			if(isset($file['args'])){
				foreach($file['args'] as $k => $v){
					$file['args'][$k] = (is_array($v) ? serialize($v) : $v);
				}
			}

			$message = secureMe($message);
			$pinpoint = '<br /><div class="content padding"><strong>'.realpath($file['file']).'</strong> @ <strong>'.$file['line'].
							'</strong> // Affected '.mysql_affected_rows().' rows.. <br /> '.$file['function'].'(<strong>\''.
							(isset($file['args']) ? secureMe(implode('\', \'', $file['args'])) : null).'\'</strong>); </div>';

			if($mode == 'WARNING'){
				$this->debugtext[] = array(
					'query'		=> '<span style="color:orange"><b>WARNING:</b></span> '.$message.$pinpoint,
					'time'		=> '---------',
					'status'	=> 'warning'
				);
			} else {
				$max = count($this->debugtext);
				$this->debugtext[$max - 1] = array(
					'query'		=> '<span style="color:red"><b>ERROR:</b></span> '.$message.$pinpoint,
					'time'		=> '---------',
					'status'	=> 'error'
				);
			}
		}
	}

	/**
	 * Records a sql query in the database with a log message
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param 	string 	$query
	 * @param 	string 	$log
	 */
	function recordLog($query, $log) {
		global $config;

		$uid = '0';
		$username = 'Guest';

		if(isset($config['global']['user']['id']) && isset($config['global']['user']['username'])) {
			$uid = $config['global']['user']['id'];
			$username = $config['global']['user']['username'];
		}

		$info['uid'] 			= $uid;
		$info['username'] 		= $username;
		$info['description'] 	= $log;
		$info['query'] 			= $query;
		$info['refer'] 			= stripslashes($_SERVER['HTTP_REFERER']);
		$info['date'] 			= time();
		$info['ip_address'] 	= User::GetIP();

		$this->insertRow('logs', $info, false);
	}
}

?>