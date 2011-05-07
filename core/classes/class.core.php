<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }

/**
 * Group Class designed to allow easier access to expand on the group system implemented
 *
 * @version     1.0
 * @since       1.0.0
 * @author      xLink
 */
abstract class CoreClass{

	public function __construct(){ }

    /**
     * Sets a variable with a value
     *
     * @version	1.0
     * @since   1.0.0
     * @author  xLink
     *
     * @param   string 	$var
     * @param   mixed	$value
     */
	public function setVar($var, $value){
		$this->$var = $value;
	}

    /**
     * Returns a var's value
     *
     * @version	1.0
     * @since   1.0.0
     * @author  xLink
     *
     * @param   string 	$var
     *
     * @return  mixed
     */
	public function getVar($var){
		return (isset($this->$var) ? $this->$var : false);
	}

}
?>