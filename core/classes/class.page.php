<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}

/**
 * This class handles page generation
 *
 * @version 	1.0
 * @since 		1.0.0
 * @author 		xLink
 */
class page extends coreClass{

	static $THEME = '', $THEME_DIR = '';
	private $jsFiles = array(), $cssFiles = array(), $jsCode  = array(), $cssCode = array();
	private $tplVars = array(), $pageCrumbs = array();

	/**
	 * Init page class, and set some
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   array  $args
	 */
	public function __construct($args=array()){
		$this->setVars(array(
			'simpleTpl' => false,
			'pageTitle'	=> '',
		));
	}

	/**
	 * Starts the page timer.
	 *
	 * @version	1.0
	 * @since   1.0.0
	 *
	 * @return 	int
	 */
	function doPageTimer(){
		return microtime(true);
	}

	/**
	 * Sets the current Page's title
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string  $value
	 */
	public function setTitle($value){
		$this->setVar('pageTitle', secureMe($value));
	}

	/**
	 * Merges values with tplVars
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string  $value
	 */
	public function updateTplVars(array $values){
		$this->tplVars = array_merge($this->tplVars, $values);
	}

	/**
	 * Adds a JS File to be output
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string  $file
	 */
	public function addJSFile($file){
		if(!is_array($file)){
			$file = array($file);
		}
		if(!is_array($this->jsFiles)){
			$this->jsFiles = array();
		}

		$this->jsFiles = array_merge($this->jsFiles, $file);
	}

	/**
	 * Adds a CSS File to be output
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string  $file
	 */
	public function addCSSFile($file){
		if(!is_array($file)){
			$file = array($file);
		}
		if(!is_array($this->cssFiles)){
			$this->cssFiles = array();
		}

		$this->cssFiles = array_merge($this->cssFiles, $file);
	}

	/**
	 * Adds a string of JS to be output
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string $code
	 */
	public function addJSCode($code){
		if(!is_array($code)){
			$code = array($code);
		}
		if(!is_array($this->jsCode)){
			$this->jsCode = array();
		}

		$this->jsCode = array_merge($this->jsCode, $code);
	}

	/**
	 * Adds a string of CSS to be output
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   string $code
	 */
	public function addCSSCode($code){
		if(!is_array($code)){
			$code = array($code);
		}
		if(!is_array($this->cssCode)){
			$this->cssCode = array();
		}

		$this->cssCode = array_merge($this->cssCode, $code);
	}

	/**
	 * Adds a pagecrumb to the array
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @param   array 	$value
	 */
	function addPagecrumb(array $value){
		$this->pageCrumbs = array_merge($this->pageCrumbs, $value);
	}

	/**
	 * Outputs the pagecrumbs
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink
	 *
	 * @return 	string
	 */
	function showPagecrumbs(){
		$breadcrumbs = $this->pageCrumbs;
		if(is_empty($breadcrumbs)){ return null; }

		//setup some vars
		$counter = count($breadcrumbs);
		$x = $counter;
		$return = '';
		$glue = ' >> ';

		//loop through each breadcrumb
		foreach ($breadcrumbs as $k => $link) {
			//if its empty, minus one to $x, and continue
			if(is_empty($link['name'])){
				$x--;
			}else{
				//set the string up
				$string = '<a href="%s">%s</a>';

				//secure the string up
				$link['name'] = secureMe($link['name']);

				//if its the last one, make it bold
				if(($x-1) == $k){ $link['name'] = '<b>'. $link['name'] .'</b>'; }

				//set the string up properly
				$return .= sprintf($string, $link['url'], $link['name']);

				//set the glue if its not the last one
				if(($x-1) != $k){ $return .= $glue; }
			}
		}

		return $return;
	}

	/**
	 * Redirect using PHP Header function or JS redirect
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink

	 * @param	string	$location
	 * @param	int		$mode - Definitions - 1=>GET['redirect'], 2=>HTTP_REFFERER, => 0=>$location
	 * @param	int 	$time
	 */
	public function redirect($location=null, $mode=null, $time=0){
		switch($mode) {
			case GET:
				$url = doArgs('redirect', $location, $_GET);
			break;

			case REFFERER:
				$url = doArgs('HTTP_REFERER', $location, $_SERVER);
			break;

			case 0:
			default:
				$url = $location;
			break;
		}

		//check to see weather headers have already been sent, this prevents us from using the header() function
		if(!headers_sent() && $time==0) {
			header('Location: '.$url); exit;
		} else { //headers have already been sent, so use a JS and even META equivalent
			echo '<script type="text/javascript">';
			if($time!=0){
				echo 'function redirect(){';
			}
			echo '  window.location.href="'.$url.'";';
			if($time!=0){
				echo '} setTimeout(\'redirect()\', '.($time*1000).');';
			}
			echo '</script>';
			echo '<noscript>';
			echo '  <meta http-equiv="refresh" content="'.$time.';url='.$url.'" />';
			echo '</noscript>';
		}
	}


	/**
	 * Set the Page Theme
	 *
	 * @version	1.0
	 * @since   1.0.0
	 * @author  xLink

	 * @param	string	$location
	 * @param	int		$mode - Definitions - 1=>GET['redirect'], 2=>HTTP_REFFERER, => 0=>$location
	 * @param	int 	$time
	 */
	public function setTheme($theme=null){
		if(is_empty($theme)){
			$theme = $config['site']['theme'];
		}

		if(User::$IS_ONLINE &&
			$this->objUser->grab('theme') &&
			is_dir(cmsROOT.'themes/'.$this->objUser->grab('theme').'/')){

			$theme = $this->objUser->grab('theme');
		}

		if($config['site']['template_override']){
			if(!is_dir(cmsROOT.'themes/'.$theme.'/')){
				$theme = 'default';
			}
		}

		if(!is_dir(cmsROOT.'themes/'.$theme.'/') || !is_readable(cmsROOT.'themes/'.$theme.'/cfg.php')){
			return false;
		}

		self::$THEME = $theme;
		self::$THEME_DIR = cmsROOT.'themes/'.$theme.'/';

		return true;
	}

	function showHeader($simple=false){

	}

	function showFooter($simple=false){

	}

	function setInitVars(){
		$vars = $this->getVar('tplVars');

		$extras = page::$THEME.'extras.php';
		if(is_readable($extras)){ include($extras); }
	}
}
?>