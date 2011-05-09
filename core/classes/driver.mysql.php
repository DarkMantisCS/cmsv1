<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
 * MySQL Driver support for the SQLBase
 *
 * @version     1.0
 * @since       1.0.0
 * @author      xLink
 */
class mysql extends coreClass implements SQLBase{

	public function __construct($config=array()) {
		if(is_empty($config)){
			return false;
		}

		$this->db = array(
			'host'		=> doArgs('host', '', $config),
			'username'	=> doArgs('username', '', $config),
			'password'	=> doArgs('password', '', $config),
			'database'	=> doArgs('database', '', $config),
			'prefix'	=> doArgs('prefix', '', $config),
		);
	}

    public function connect($debug=false, $logging=false) {
        $this->error = false;
        $this->failed = false;
        $this->debug = $debug;
        $this->logging = $logging;

        if($this->persistent == true) {
            $this->link_id = @mysql_pconnect($this->db['host'], $this->db['username'], $this->db['password']);
            if($this->link_id == false) {
                $this->persistent = false;
            }
        }

        if($this->persistent == false) {
            $this->link_id = @mysql_connect($this->db['host'], $this->db['username'], $this->db['password']);
        }

        if($this->failed){
            $this->errorMsg = 'Cannot connect to the database - verify username and password.';
            return false;
        }

        $this->selectDb($this->db['database']);
        if($this->failed){
            $this->errorMsg = 'Cannot select database - check user permissions.';
            return false;
        }

        if($this->persistent == false && !defined('NO_DB')) {
            $this->record_message('CMS is not using a persistant connection with the database.', 'WARNING');
        }

        return true;
    }

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

    public function getError() {
        return mysql_error($this->link_id);
    }

    public function selectDb($db) {
        @mysql_select_db($db, $this->link_id) or $this->record_message(NULL, 'ERROR');
    }

    public function freeResult() {
        if(isset($this->results) && is_resource($this->results)) {
            mysql_free_result($this->results);
            unset($this->results);
        }
    }

    function prefix($mode='') {
        if(isset($this->prefix[$mode])){
            return $this->prefix[$mode];
        }
        if(is_empty($mode) || $mode==0){
            return $this->db['prefix'];
        }

        return false;
    }

    function addPrefix($mode, $prefix){
    	if($mode == 0){
    		return false;
		}

        $this->prefix[$mode] = $prefix;

        return true;
    }

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
		return call_user_func_array('sprintf', $args);
	}

    public function query($query, $log = false) {
        $this->freeResult();

        $this->query_time = microtime(true);

        if($log){ $this->record_mysql($query, $log, User::getIP()); }

        $this->results = mysql_query($query, $this->link_id) or $this->record_message(mysql_error(), 'WARNING');

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
							(isset($file['args']) ? secureMe(implode('\', \'', $file['args'])) : NULL).'\'</strong>); </div>';
            $this->debugtext[] = array('query' => $query.$pinpoint, 'time' => substr((microtime(true) - $this->query_time), 0, 7), 'status' => 'ok');
        }else{
            $this->debugtext[] = array('query' => $query, 'time' => NULL, 'status' => 'ok');
        }


        return $this->results;
    }


    public function getInfo($table, $clause=null, $log=false){
    	$statement = 'SELECT COUNT(*) FROM `$P'.$table.'`';
    	if(!is_empty($clause)){
    		$statement .= ' WHERE '.$clause;
    	}

    	$line = $this->getLine($statement, $log);

        return $line['COUNT(*)'];
    }

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

    public function getLine($query, $log=false) {
        $this->query($query, $log);

        if(!is_resource($this->results)) {
            $this->record_message('getLine: ('.$query.')', 'ERROR');
        } else {
            $line = mysql_fetch_assoc($this->results);
            $this->freeResult();
            return $line;
        }
        return false;
    }

    public function getTable($query, $log=false) {
        $this->query($query, $log);

        if(!is_resource($this->results)) {
            $this->record_message('getTable: ('.$query.')', 'ERROR');
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


    function insertRow($table, $array, $log = false){
    	if(is_empty($array)){ return false; }

        $comma = null;
        $listOfValues = null;
        $listOfElements = null;

        foreach($array as $elem => $value) {
        	if($value === null){
        		$listOfValues .= $comma .'NULL';
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

	function updateRow($table, $array, $clause, $log=false){
    	if(is_empty($array)){ return false; }

		$query = 'UPDATE `$P%1$s` SET';

		foreach($array as $index => $value){
			if($value === null){
				$query .= '`'.$index.'`=NULL, ';
			}else{
				$query .= '`'.$index.'`=\''.$this->escape($value).'\', ';
			}
		}

		$query = substr($query, 0, -2).' WHERE '.$clause.' LIMIT 1';

		$this->query($this->prepare($query, $table), $log);
		return mysql_affected_rows();
	}

    public function deleteRow($table, $clause, $log=false){
        $this->query($this->prepare('SELECT FROM `$P$s` WHERE %s', $table, $clause), $log);

        return mysql_affected_rows($this->link_id);
    }

}

?>