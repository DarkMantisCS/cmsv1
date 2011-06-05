<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles everything modules!
 *
 * @version 	2.0
 * @since 		1.0.0
 * @author 		xLink
 */
class Module extends coreClass{

	private $modules = array();

	function __construct(Core $objCore) {

		$this->objPage  	= $objCore->objPage;
		$this->objSQL   	= $objCore->objSQL;
		$this->objTPL   	= $objCore->objTPL;
		$this->objUser  	= $objCore->objUser;
		$this->objTime  	= $objCore->objTime;
		$this->objForm 		= $objCore->objForm;
		$this->objComments  = $objCore->objComments;
		$this->objLogin 	= $objCore->objLogin;


		if(isset($_GET['ajax'])){
			$this->objPage->setTplSimple(true);
		}

		// Retrieve info from config
		if(is_file(cmsROOT.'modules/'.$this->module.'/cfg.php')){
			require cmsROOT.'modules/'.$this->module.'/cfg.php';
			$this->modLocation = '/'.root().substr( $mod_dir, 2);
			$this->extLocation = $this->objPage->getSetting('global', 'url').substr($mod_dir, 2);
		}

		if(preg_match('/images\/(.*?)/i', $this->action)){
			$imagesTypes = array('jpg', 'gif', 'png', 'jpeg', 'jfif', 'jpe', 'bmp', 'ico', 'tif', 'tiff');
			if(in_array($this->ext, $imagesTypes) && is_readable(cmsROOT.'modules/'.$this->module.'/images/'.$this->filename)){
				header('Content-Type: image/'.$this->ext);
				include(cmsROOT.'modules/'.$this->module.'/images/'.$this->filename);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}
		if(preg_match('/scripts\/(.*?)/i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
				header('Content-Type: application/x-javascript');
				include(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}
		if(preg_match('/styles\/(.*?)/i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
				header('Content-Type: text/css');
				include(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}
	}

	/**
	 * Check if a module exists in the file structure
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Jesus
	 *
	 * @param 	string 	$moduleName
	 *
	 * @return 	bool
	 */
	public function moduleExists( $moduleName )
	{
		if( is_empty($moduleName) || !is_dir( cmsROOT.'modules/'.$moduleName ) )
		{
			return false;
		}

		$files = getFiles( cmsROOT.'modules/'.$moduleName );
		if( is_empty( $files ) )
		{
			return false;
		}
		return true;
	}


	/**
	 * Get the list of modules from the database
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Jesus
	 *
	 * @param 	string 	$moduleName
	 *
	 * @return 	bool
	 */
	private function getModuleListCache( $moduleName )
	{
		// Check the argument is valid
		if( is_empty( $moduleName ) )
		{
			return false;
		}

		// If the result already exists, then gogo fetch.
		if( array_key_exists($moduleName, $this->cached) )
		{
			return true;
		}
		else
		{
			// Else query the database and find it
			$modules = $this->objSQL->getTable( $this->objSQL->prepare(
				'SELECT * FROM `$Pmodules`'
			));

			if( is_empty( $modules ) )
			{
				return false;
			}

			foreach($modules as $module)
			{
				$this->modules[$module['name']] = $module;
			}

			return true;
		}
	}

	/**
	 * Check if a module is installed or not
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Jesus
	 *
	 * @param 	string 	$moduleName
	 *
	 * @return 	bool
	 */
	public function moduleInstalled( $moduleName )
	{
		$this->getModuleListCache( $moduleName );

		// Check the module exists in cache
		if( !array_key_exists( $moduleName, $this->modules ) )
		{
			return false;
		}

		if( $this->modules[$moduleName]['enabled'] == '1' )
		{
			return true;
		}

		return false;
	}

	/**
	 * Gets relevent data from a module
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Jesus
	 *
	 * @param 	array
	 *
	 * @return 	bool
	 */
	function getModuleData( $moduleName )
	{
		$this->getModuleListCache( $moduleName );

		// Check the module exists in cache
		if( !array_key_exists( $moduleName, $this->modules ) )
		{
			return false;
		}

		return $this->modules[$moduleName];
	}

	/**
	 * Gets relevent data from a module using its
	 * 	module hash as a reference
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  Jesus
	 *
	 * @param 	array
	 *
	 * @return 	bool
	 */
	function getModuleDataByHash( $moduleHash ) { }
}

?>