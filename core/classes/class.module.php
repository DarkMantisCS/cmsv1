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

		if(preg_match('!images/(.*?)!i', $this->action)){
			$imagesTypes = array('jpg', 'gif', 'png', 'jpeg', 'jfif', 'jpe', 'bmp', 'ico', 'tif', 'tiff');
			if(in_array($this->ext, $imagesTypes) && is_readable(cmsROOT.'modules/'.$this->module.'/images/'.$this->filename)){
				header('Content-Type: image/'.$this->ext);
				include(cmsROOT.'modules/'.$this->module.'/images/'.$this->filename);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}
		if(preg_match('!scripts/(.*?)!i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
				header('Content-Type: application/x-javascript');
				include(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}
		if(preg_match('!styles/(.*?)!i', $this->action)){
			if(file_exists(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra)){
				header('Content-Type: text/css');
				include(cmsROOT.'modules/'.$this->module.'/'.$this->action.$this->extra);
				exit;
			}else{
				$this->throwHTTP('404');
			}
		}

	}

	function moduleExists() { }
	function moduleInstalled() { }
}

?>