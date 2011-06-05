<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')) {
	die('Error: Cannot access directly.');
}

/**
 * This class handles everything modules!
 *
 * @version 	2.0
 * @since 		1.0.0
 * @author 		xLink
 */
class Module extends coreClass {

	private $modules = array();
	public $modConf = array();

	private $modules = array();

	function __construct(Core $objCore) {

		//global the classes for this module
		$this->objPage 		= $objCore->objPage;
		$this->objSQL 		= $objCore->objSQL;
		$this->objTPL 		= $objCore->objTPL;
		$this->objUser 		= $objCore->objUser;
		$this->objTime 		= $objCore->objTime;
		$this->objForm 		= $objCore->objForm;
		$this->objComments 	= $objCore->objComments;
		$this->objLogin 	= $objCore->objLogin;

		if(isset($_GET['ajax'])) {
			$this->objPage->setTplSimple(true);
		}

		// Retrieve info from config
		if(is_readable(cmsROOT . 'modules/' . $this->module . '/cfg.php')) {
			require cmsROOT . 'modules/' . $this->module . '/cfg.php';

			$this->modConf['path'] = '/' . root() . substr($mod_dir, 2);
		}

<<<<<<< HEAD
		if(preg_match('/images\/(.*?)/i', $this->action)){
=======
		//specify some deafult actions
		if(preg_match('/images\/(.*?)/i', $this->action)) {
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
			$imagesTypes = array('jpg', 'gif', 'png', 'jpeg', 'jfif', 'jpe', 'bmp', 'ico', 'tif', 'tiff');
			if(in_array($this->ext, $imagesTypes) && is_readable(cmsROOT . 'modules/' . $this->module . '/images/' . $this->filename)) {
				header('Content-Type: image/' . $this->ext);
				include (cmsROOT . 'modules/' . $this->module . '/images/' . $this->filename);
				exit;
			} else {
				$this->throwHTTP('404');
			}
		}
<<<<<<< HEAD
		if(preg_match('/scripts\/(.*?)/i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
=======
		if(preg_match('/scripts\/(.*?)/i', $this->action)) {
			if(file_exists(cmsROOT . 'modules/' . $this->module . '/' . $this->action . $this->extra)) {
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
				header('Content-Type: application/x-javascript');
				include (cmsROOT . 'modules/' . $this->module . '/' . $this->action . $this->extra);
				exit;
			} else {
				$this->throwHTTP('404');
			}
		}
<<<<<<< HEAD
		if(preg_match('/styles\/(.*?)/i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
=======
		if(preg_match('/styles\/(.*?)/i', $this->action)) {
			if(file_exists(cmsROOT . 'modules/' . $this->module . '/' . $this->action . $this->extra)) {
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
				header('Content-Type: text/css');
				include (cmsROOT . 'modules/' . $this->module . '/' . $this->action . $this->extra);
				exit;
			} else {
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
<<<<<<< HEAD
	public function moduleExists( $moduleName )
	{
		if( is_empty($moduleName) || !is_dir( cmsROOT.'modules/'.$moduleName ) )
		{
			return false;
		}

		$files = getFiles( cmsROOT.'modules/'.$moduleName );
		if( is_empty( $files ) )
		{
=======
	public function moduleExists($moduleName) {
		if(is_empty($moduleName) || !is_dir(cmsROOT . 'modules/' . $moduleName)) {
			return false;
		}

		$files = getFiles(cmsROOT . 'modules/' . $moduleName);
		if(is_empty($files)) {
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
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
<<<<<<< HEAD
	private function getModuleListCache( $moduleName )
	{
		// Check the argument is valid
		if( is_empty( $moduleName ) )
		{
=======
	private function getModuleListCache($moduleName){
		// Check the argument is valid
		if(is_empty($moduleName)){
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
			return false;
		}

		// If the result already exists, then gogo fetch.
<<<<<<< HEAD
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
=======
		if(!isset($this->modules[$moduleName])){
			return true;
		} else {
			// Else query the database and find it
			$modules = $this->objSQL->getTable($this->objSQL->prepare('SELECT * FROM `$Pmodules`'));
				if(!$modules){ return false; }

			foreach($modules as $module){
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
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
<<<<<<< HEAD
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
=======
	public function moduleInstalled($moduleName){
		$this->getModuleListCache($moduleName);

		// Check the module exists in cache
		if(!isset($this->modules[$moduleName])){
			return false;
		}

		if($this->modules[$moduleName]['enabled'] == '1'){
>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c
			return true;
		}

		return false;
	}
<<<<<<< HEAD

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
=======

>>>>>>> efc6742f55911f24460b3a01fe66d94aab0b420c

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
	function getModuleData($moduleName){
		$this->getModuleListCache($moduleName);

		// Check the module exists in cache
		if(!isset($this->modules[$moduleName])){
			return false;
		}

		return $this->modules[$moduleName];
	}
}
?>