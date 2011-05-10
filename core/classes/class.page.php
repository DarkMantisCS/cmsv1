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

	static $THEME = '', $THEME_ROOT = '';
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
			$theme = $this->config('site', 'theme');
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
		self::$THEME_ROOT = cmsROOT.'themes/'.$theme.'/';

		return true;
	}

	/**
	 * Loads the theme header up
	 *
	 * @version 2.0
	 * @since 	1.0.0
	 *
	 * @param 	bool $simple
	 */
	function showHeader($simple=false){
		if($this->header['completed']){ return; }

		//figure out which version of the header we wanna use
		$header = ($simple ? 'simple_header.tpl' : 'header.tpl');

		//set simpleTpl, so anything that needs to output layout other than these funcs know what to expect
		$tplVar = ($this->getVar('simpleTpl')===true ? true : ($simple===true ? true : false) );
		$this->setVar('simpleTpl', $tplVar);

		//set the page header template file
		$this->objTPL->set_filenames(array(
			'tpl_header' => self::$THEME_ROOT . $header
		));

		//set $nl as a new line
		$nl = "\n";

	//
	//--Load Meta Definitions
	//
		//generate an array of meta lines
		$metaArray = array(
			'author' 			=> $this->config('cms', 'name', 'Cybershade CMS'),
			'description' 		=> $this->config('site', 'description'),
			'keywords'			=> $this->config('site', 'keywords'),
			'copyright'			=> langVar('L_SITE_COPYRIGHT', $this->config('site', 'title'), $this->config('cms', 'name'), cmsVERSION),
			'generator'			=> $this->config('cms', 'name').' v'.cmsVERSION,
			'ROBOTS'			=> 'INDEX, FOLLOW',
			'GOOGLEBOT'			=> 'INDEX, FOLLOW',
		);

		//add a hook to it so it can be added to
        $this->objPlugins->hook('CMSPage_meta', $metaArray);

        //set a default value, and go with it
        $meta = '<meta http-equiv="content-language" content="'.$this->config('site', 'language').'" />'.$nl;
        if(count($metaArray)){
			foreach($metaArray as $name => $value){
				$meta .= sprintf('<meta name="%s" content="%s" />', $name, $array).$nl;
			}
		}
		$meta .= '<link rel="alternate" type="application/atom+xml" title="'.$this->config('site', 'title').' '.langVar('RSS_FEED').'" href="/'.root().'rss.php" />'.$nl;

	//
	//--Load JS
	//
		$jsFiles[] = '/'.root().'scripts/protolicous-min.js';
		$jsFiles[] = '/'.root().'scripts/jquery-min.js';
		$jsFiles[] = '/'.root().'scripts/extras-min.js';
		$jsFiles = array_merge($jsFiles, $this->jsFiles);

		//if the template has an extras.js add it
		if(file_exists(page::$THEME_ROOT . 'extras.js')){
			$jsFiles[] = '/'.root().'themes/'. page::$THEME .'/extras.js';
		}

        //only add the user js file if theyre logged in
        if(user::$IS_ONLINE){
            $jsFiles[] = '/'.root().'user.php';
        }

		//hook here too
        $this->objPlugins->hook('CMSPage_jsFiles', $jsFiles);

		$analyticsKey = secureMe($this->config('site', 'analytics', ''), 'alphaNum');
		if(!is_empty($analyticsKey)){
	        $jsCode[] = 'var _gaq = _gaq || []; '.
						'_gaq.push(["_setAccount", "'.$analyticsKey.'"]); '.
						'_gaq.push(["_trackPageview"]); '.

						'(function() { '.
						    'var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true; '.
						    'ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js"; '.
						    'var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s); '.
						'})(); ';
		}

echo dump($jsFiles, $file);













	}

	/**
	 * Loads the theme footer and debug up if needed
	 *
	 * @version 2.0
	 * @since 	1.0.0
	 *
	 * @param 	bool $simple
	 */
	function showFooter($simple=false){

	}

	/**
	 * Loads the inital vars for the tpls
	 *
	 * @version 2.0
	 * @since 	1.0.0
	 */
	function setThemeVars(){
		$vars = $this->getVar('tplVars');

		//incude extras.php from the theme if it exists
		$extras = Page::$THEME_ROOT.'extras.php';
		if(is_readable($extras)){ include($extras); }

		//define array of vars that we want
		$vars = array(
			'ROOT'				=> root(),
			'THEME_ROOT'		=> self::$THEME_ROOT,

			'SITE_NAME'			=> $this->config('site', 'site_name'),

			'ROW_COLOR1'		=> $vars['row_color1'],
			'ROW_COLOR2'		=> $vars['row_color2'],

			'USERNAME'			=> $this->objUser->grab('username'),

			'U_LOGIN'			=> '/'.root().'login.php',
			'U_LOGOUT'			=> '/'.root().'login.php?action=logout&check='.$this->objUser->grab('usercode'),
		);

		//hook onto the array to allow others to add to this list
		$this->objPlugins->hook('CMSCore_global_tplvars', $vars);

		//if user is online, set the IS_ONLINE, and IS_LOGGED_IN blocks
		if(User::$IS_ONLINE){
			$this->objTPL->assign_block_vars('IS_ONLINE', array());
			$this->objTPL->assign_block_vars('IS_LOGGED_IN', array());
		}

		//if user is not online, set the NOT_LOGGED_IN
		if(!User::$IS_ONLINE){
			$this->objTPL->assign_block_vars('NOT_LOGGED_IN', array());
		}

		//if user is logged in, and is admin
		if(User::$IS_ONLINE && $this->objUser->checkPermissions($this->objUser->grab('id'), ADMIN)){
			$this->objTPL->assign_block_vars('IS_ADMIN', array());
		}

		//merge, assign and unset ^_^
		$vars = (!is_empty($_more_vars) && is_array($_more_vars) ? array_merge($vars, $_more_vars) : $vars);
		$this->objTPL->assign_vars($vars);
		unset($vars);
	}
}
?>