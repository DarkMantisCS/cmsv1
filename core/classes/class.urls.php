<?php

/**
 * @author Daniel Noel-Davies
 * @copyright 2011
 */

class urls extends coreClass {

	function __construct() { }
	function __deconstruct() { }

	function addURL( $url, $dataHash ) { }
	function removeURL( $url )
	{
		$result = $this->objSQL->deleteRow( 'urls', array('url' => $url) );
		return ( is_numeric( $result ) ? true : false );
	}

	function removeURLbyData( $dataHash )
	{
		$result = $this->objSQL->deleteRow( 'urls', array('datahash' => $dataHash) );
		return ( is_numeric( $result ) ? true : false );
	}

	function getURL( $dataHash )
	{
		$result = $this->objSQL->getLine($objSQL->prepare('SELECT * FROM `$Purls` WHERE `datahash` = \'%s\'', $dataHash));
		if( is_empty( $result ) )
		{
			return false;
		}
		return $result['url'];
	}

	function addModuleURL( $url, $modID, $function, $args )
	{
		$result = $this->objSQL->insertRow('urls', array(
			'url'	=> $url,
			'datahash'	=> $this->generateModuleHash( $modID, $function, $args )
		));

		if( is_numeric( $result ) )
		{
			return true;
		}

		return false;
	}

	function removeModuleURL( $modID, $function, $args ) { }
	function getModuleURL( $modID, $function, $args ) { }

	/** ToDo **/
	function addFileURL( $filename, $path, $headers ) { }
	function removeFileURL() { }
	function getFileURL() { }

	function generateModuleHash( $modID, $function, $args )
	{
		if( is_array($args) )
		{
			$args = implode(',', $args);
		}

		$empty = 'MOD:{%s}:%s{%s}';
		return sprintf($modID, $function, $args);
	}

	function generateFileHash() { } // Todo
	function getDataByURL( $url )
	{
		$result = $this->objSQL->getLine($this->objSQL->prepare('SELECT * FROM `$Purls` WHERE `url` = \'%s\'', $url));
		if( is_empty( $result ) )
		{
			return false;
		}
		return $result;
	}

	function execModule( $datahash ) { }
	function execFile( $datahash ) { }

	/**
	 * Handle the current URL and deal with what needs to be dealt with.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Daniel Noel-Davies
	 *
	 * @param 	string 	$url
	 *
	 * @return 	void
	 */
	function parseURL( $url=NULL )
	{
		global $config;

		$url = ( is_empty($url)
				?	substr( $config['global']['url'], strlen($config['global']['rootUrl']))
				:	$url
		);

		$action = '';
		$found = false;
		while( $found == false )
		{
			$result = $this->getDataByURL($url);
			if( !is_array( $result ) )
			{
				// Check if this isn't a generic URL
				if( !strpos( $url, '/' ) ) return false;
				$action = substr( $url, strrpos($url, '/') ) . $action;
			}
			else
			{
				$found = true;
			}
		}
		if( $found === true )
		{
			$modules = $this->objSQL->getTable( $this->objSQL->prepare('SELECT * FROM `$P`modules') );
			echo dump( $action, 'action' );
			echo dump( $url, 'url' );
			echo dump( $result, 'result' );
			echo dump( $modules, 'Modules' );
		}
	}
}
?>