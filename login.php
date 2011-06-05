<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', 1);
define('cmsDEBUG', 1);
define('cmsCLOSED', 1);
define('NO_MENU', 1);
include_once('core/core.php');

//set some vars
$mode = doArgs('action', 'index', $_GET);
$acpCheck = isset($_SESSION['acp']['doAdminCheck']) ? true : false;

$objPage->setTitle('Login');

switch($mode){
    default:
    case 'index':
		if(User::$IS_ONLINE && !$acpCheck){
			$objPage->redirect('/'.root().'index.php');
		}

	    $objTPL->set_filenames(array(
	    	'body' => 'modules/core/template/login.tpl'
	    ));

	    if(!empty($_SESSION['login']['error'])){
	    	$L_ERROR = $_SESSION['login']['error'];
	    	$_SESSION['login']['error'] = '';

			$objTPL->assign_block_vars('form_error', array());
	    }

	    //we do want let them auto login? acpCheck auto disables it
	    if($objCore->config('login', 'remember_me') && !$acpCheck){
			$objTPL->assign_block_vars('remember_me', array());
        }

		//but enables the pin portion of the form
        if($acpCheck){ $objTPL->assign_block_vars('pin', array()); }

		$hash = md5(time().'userkey');
    	$_SESSION['login']['cs_hash'] = $hash;

    	$good = array('0x08');
	    $userValue = ($acpCheck ? $objUser->grab('username') : '');
        $submit = ($acpCheck ? '' : 'loginChecker();return false;');

    	$objTPL->assign_vars(array(
			'FORM_START' 		=> $objForm->start('login', array('method' => 'POST', 'action' => '/'.root().'login.php?action=check')),
			'FORM_END'			=> $objForm->inputbox('hash', 'hidden', $hash) . $objForm->finish(),

			'L_USERNAME' 		=> langVar('L_USERNAME'),
			'F_USERNAME'		=> $objForm->inputbox('username', 'text', $userValue, array('class'=>'username', 'br'=>true, 'disabled'=>$acpCheck)),

			'L_PASSWORD' 		=> langVar('L_PASSWORD'),
			'F_PASSWORD'		=> $objForm->inputbox('password', 'password', '', array('class'=>'password', 'br'=>true)),

			'L_PIN'				=> langVar('L_PIN'),
			'L_PIN_DESC'		=> langVar('L_PIN_DESC'),
			'F_PIN'			    => $objForm->inputbox('pin', 'password', '', array('class'=>'pin', 'br'=>true, 'autocomplete'=>false)),


			'L_REMBER_ME'		=> langVar('L_REMBER_ME'),
			'F_REMBER_ME'		=> $objForm->select('remember', array('0'=>'No Thanks', '1'=>'Forever'), array('selected'=>0)),

	        'L_ERROR'           => $L_ERROR,

	  		'F_SUBMIT'			=> $objForm->button('submit', 'Login'),
		));

		$objTPL->parse('body', false);
	break;
}

$objPage->showHeader(isset($_GET['ajax']) ? true : false);
if($objTPL->output('body')){
    msgDie('FAIL', 'No output received.');
}
$objPage->showFooter(isset($_GET['ajax']) ? true : false);
?>