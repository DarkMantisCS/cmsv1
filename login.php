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
$acpCheck = doArgs('doAdminCheck', false, $_SESSION['acp']);

$objPage->setTitle('Login');
switch($mode){
    default:
    case 'index':
	    $hidden = null;
		if(User::$IS_ONLINE && !$acpCheck){
			$objPage->redirect('/'.root().'index.php');
		}

		//grab the referer so we can redirect them later
		$_SESSION['login']['referer'] = $_SERVER['HTTP_REFERER'];

	    $objTPL->set_filenames(array(
	    	'body' => 'modules/core/template/login.tpl'
	    ));

		//if we are going to the acp
		if($acpCheck){
			//make sure they have a PIN set first...
			if(is_empty($objSQL->getValue('users', 'pin', array('id = "%s"', $objUser->grab('id'))))){
				$_SESSION['login']['error'] = langVar('MSG_NO_PIN');
			}
		}

	    if(!empty($_SESSION['login']['error'])){
			$objTPL->assign_block_vars('form_error', array('ERROR'=>$_SESSION['login']['error'], 'CLASS'=>doArgs('class', 'boxred', $_SESSION['login'])));
	    	$_SESSION['login']['error'] = '';
	    }

	    //we do want let them auto login? acpCheck auto disables it
	    if($objCore->config('login', 'remember_me') && !$acpCheck){
			$objTPL->assign_block_vars('remember_me', array());
        }

		//but enables the pin portion of the form
        if($acpCheck){ $objTPL->assign_block_vars('pin', array()); }

		$hash = md5(time().'userkey');
    	$_SESSION['login']['cs_hash'] = $hash;

	    $userValue = ($acpCheck ? $objUser->grab('username') : '');
        $submit = ($acpCheck ? '' : 'loginChecker();return false;');

		if($acpCheck){
			$hidden .= $objForm->inputbox('username', 'hidden', $userValue);
		}

    	$objTPL->assign_vars(array(
			'FORM_START' 		=> $objForm->start('login', array('method' => 'POST', 'action' => '/'.root().'login.php?action=check')),
			'FORM_END'			=> $hidden . $objForm->inputbox('hash', 'hidden', $hash) . $objForm->finish(),

			'L_USERNAME' 		=> langVar('L_USERNAME'),
			'F_USERNAME'		=> $objForm->inputbox('username', 'text', $userValue, array('class'=>'username', 'br'=>true, 'disabled'=>$acpCheck, 'required'=>(!$acpCheck))),

			'L_PASSWORD' 		=> langVar('L_PASSWORD'),
			'F_PASSWORD'		=> $objForm->inputbox('password', 'password', '', array('class'=>'password', 'br'=>true, 'required'=>(!$acpCheck))),

			'L_PIN'				=> langVar('L_PIN'),
			'L_PIN_DESC'		=> langVar('L_PIN_DESC'),
			'F_PIN'			    => $objForm->inputbox('pin', 'password', '', array('class'=>'pin', 'br'=>true, 'autocomplete'=>false)),


			'L_REMBER_ME'		=> langVar('L_REMBER_ME'),
			'F_REMBER_ME'		=> $objForm->select('remember', array('0'=>'No Thanks', '1'=>'Forever'), array('selected'=>0)),

	  		'F_SUBMIT'			=> $objForm->button('submit', 'Login'),
		));

		$objTPL->parse('body', false);
	break;

	case 'check':
        if(!HTTP_POST){
        	$objPage->redirect('?');
		}
    	if(User::$IS_ONLINE && !$acpCheck && !isset($_GET['ajax'])){
    		$objPage->redirect('/'.root().'index.php');
		}

    	$objLogin->doLogin((isset($_GET['ajax'])&&HTTP_AJAX ? true : false));
	break;

	case 'active':
		if(!isset($_GET['un']) || !isset($_GET['check'])){
			hmsgDie('FAIL', 'Cannot activate your account, Please use all the url sent to you in the email');
		}else{
            if($objUser->getUserInfo($_GET['un'], 'active')==1){
                hmsgDie('Info', 'You account is already active.');
            }

            if($objLogin->activateAccount($_GET['un'], $_GET['check'])){
				$objLogin->doError('0x08');
			}else{
				// Make this into a form
				hmsgDie('FAIL', contentParse('Cannot activate your account.
				Please email the site administrator at [email]'.$objCore->config('site', 'admin_email').'[/email]'));
			}
		}
	break;

	case 'logout':
		$objLogin->logout($_GET['check']);
	break;
}

$objPage->showHeader(isset($_GET['ajax']) ? true : false);
if($objTPL->output('body')){
    msgDie('FAIL', 'No output received.');
}
$objPage->showFooter(isset($_GET['ajax']) ? true : false);
?>