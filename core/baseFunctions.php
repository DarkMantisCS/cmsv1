<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

    /**
     * Used to determine the base path of the CMS installation;
     *
     * @version	1.0
     * @since   1.0.0
     * @author  Jesus
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
     * Handles securing input/output
     *
     * @version	1.0
     * @since   1.0.0
     * @author  xLink
     *
     * @param   string 	$string
     * @param 	string	$mode
     *
     * @return 	string
     */
    function secureMe($string, $mode='html') {
        switch($mode) {
            case 'html':
                $string = html_entity_decode($string);
                $string = htmlspecialchars($string);
            break;

            case 'url':
                $string = urlencode($string);
            break;

            case 'sql':
                $string = mysql_real_escape_string($string);
            break;

            case 'langVar':
            	$string = htmlspecialchars($string);
            	$string = str_replace(array('&gt;', '&lt;', '&amp;', '&quot;'), array('>', '<', '&', '"'), $string);
            break;

            default: break;
        }

        return $string;
    }

    /**
     * Determines whether to set
     *
     * @version	1.0
     * @since   1.0.0
     * @author  xLink
     *
     * @param   string 	$key
     * @param 	string	$defaultValue
     * @param 	array	$args
     * @param 	string	$callback
     *
     * @return 	string
     */
    function doArgs($key, $defaultValue, $args, $callback=false){

    	$extra = true;
    	if($callback !== false){
    		$extra = (is_callable($callback) ? call_user_func($callback, $args[$key]) : false);
    	}

        return (isset($args[$key]) && $extra ? $args[$key] : $defaultValue);
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
        if(setCookie($name, $value, $expire, '', '', false, true)){
        	$_COOKIE[$name] = $value;
        	return true;
        }

        return false;
    }


    /**
     * Checks to see if the var is empty, checks against NULL, empty array and false
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
        if(is_null($var) || empty($var) || $var=='') { return true; }
        if(is_array($var) && !count($var)) { return true; }
        if($var===false){ return true; }

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
        return ctype_digit((string)$number) ? true : false;
    }


?>