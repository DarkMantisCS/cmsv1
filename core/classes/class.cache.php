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
		$args = array(
			'useCache' 	=> doArgs('useCache', false, $args),
			'cacheDir'	=> doArgs('cacheDir', '', $args),
		);

        $this->cacheToggle = $args['useCache'];
        $this->cacheDir = $args['cacheDir'];
    }

    /**
     * Sets up a new cache file
     *
	 * @version     1.0
	 * @since       1.0.0
	 * @author      xLink
	 */
    function initCache($name, $file, $query, &$result, $callback=NULL){
        if($this->cacheToggle && is_file($this->cacheDir . $file)){
            include ($this->cacheDir . $file);
            $result = $$name;

        }else if($callback!==NULL){
            eval('$result = '.$callback.'();');

        }else{
            $result = $this->generate_cache($name, $file, $query);
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
        $query = $this->objSQL->getTable($query);

		//check to make sure it worked
        if(!$query){
            $this->output = false;
            return false;
        }

		//loop through each row of the returned array
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

}
?>