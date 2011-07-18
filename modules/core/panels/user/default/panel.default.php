<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die("INDEX_CHECK not defined."); }
$objPage->setTitle(langVar('B_UCP').' > '.langVar('L_ACCOUNT_PANEL'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_ACCOUNT_PANEL')) ));
$objTPL->set_filenames(array(
	'body' => "modules/core/template/panels/panel.editprofile.tpl"
));

//grab the user info we need
$user = $objUser->getUserInfo($uid);
$uid = $objUser->grab('id');

switch(strtolower($mode)){
	default:

		//set some security crap
		$_SESSION['site']['panel']['sessid'] = $sessid = $objUser->mkPasswd($uid.time());
		$_SESSION['site']['panel']['id'] = $uid;

		//assign some vars
		$disabled = (!$objCore->config('site', 'username_change') ? true : false);
		$email = $objCore->config('site', 'register_verification') ? wordwrap(langVar('L_CHANGE_EMAIL'), 80) : '';


		$vars = array(
			langVar('L_REQUIRED_INFO') 	=> '_header_',
			langVar('L_USERNAME') 		=> $objForm->inputbox('username', 'text', $user['username'],
												array('extra' => 'maxlength="20" size="20"', 'class'=>'icon username','disabled'=>$disabled)),
			langVar('L_EMAIL') 			=> $objForm->inputbox('email', 'text', $user['email'], array('class'=>'icon email')),

			langVar('L_CHANGE_PWDS')	=> '_header_',
			langVar('F_NEW_PASS_CONF')	=> $objForm->checkbox('chk_pass_conf', '1', false),

			langVar('L_OLD_PASSWD')		=> $objForm->inputbox('old_pass', 'password', array('class'=>'icon password')),
			langVar('L_NEW_PASSWD')		=> $objForm->inputbox('new_pass', 'password', array('class'=>'icon password')),
			langVar('L_NEW_PASSWD_CONF')=> $objForm->inputbox('conf_pass', 'password', array('class'=>'icon password')),
		);

		if($user['userlevel'] == ADMIN){
            $objTPL->assign_block_vars('msg', array(
                'MSG' => msg('INFO', 'If you are updating your PIN you need to check the button, and input both your old PIN and _ALSO_ your password in the LAST Password box else it will not work.<br />If this is the first time you are adding your PIN, leave Old Pin Number blank.', 'return'),
            ));

    		$vars += array(
    			langVar('L_PIN_UPDATE')		=> '_header_',
    			langVar('L_NEW_PIN_CONF')	=> $objForm->checkbox(0, 'conf_pin', '1'),
                langVar('L_OLD_PIN')		=> $objForm->inputbox('old_pin', 'password', '', array('autocomplete'=>false)),
                langVar('L_NEW_PIN')		=> $objForm->inputbox('new_pin', 'password', '', array('autocomplete'=>false)),
    		);
        }

		$objForm->outputForm(array(
			'FORM_START' 	=> $objForm->start('panel', array('method' => 'POST', 'action' => $saveUrl)),
			'FORM_END'	 	=> $objForm->finish(),

			'FORM_TITLE' 	=> langVar('L_ACCT_SETTINGS'),
			'FORM_SUBMIT'	=> $objForm->button('submit', 'Submit'),
			'FORM_RESET' 	=> $objForm->button('reset', 'Reset'),

			'HIDDEN' 		=> $objForm->inputbox('sessid', 'hidden', $sessid).$objForm->inputbox('id', 'hidden', $uid),
		),
		array(
			'field' => $vars,
			'desc' => array(
				langVar('L_EMAIL') => $email,
			),
			'errors' => $_SESSION['site']['panel']['error'],
		),
		array(
			'header' => '<h5>%s</h5>',
			'dedicatedHeader' => true,
		));
	break;

	case 'save':
		if (!HTTP_POST && !HTTP_AJAX){
			hmsgDie('FAIL', 'Error: Cannot verify information.');
		}

		if(!doArgs('id', false, $_SESSION['site']['user_edit'])){
			hmsgDie('FAIL', 'Error: There was a problem with the information you submitted. Please try again.');
		}

		//security check 1
        if(doArgs('id', false, $_POST) != $_SESSION['site']['panel']['id']){
            hmsgDie('FAIL', 'Error: I cannot remember what you were saving...hmmmm');
        }
        //security check 2
        if(doArgs('sessid', false, $_POST) != $_SESSION['site']['panel']['sessid']){
            hmsgDie('FAIL', 'Error: I have conflicting information here, cannot continue.');
        }

    //
    //-- Gather Info
    //
		$update = array();
		$returnMsg = array();

		//if usernames are editable, Verify the username
		$username = doArgs('username', false, $_POST);
        if(!is_empty($username) && $username != $user['username'] && $objCore->config('user', 'username_change')){
            if($objUser->validateUsername($username)){
                $update['username'] = $username;
            }else{
                $returnMsg[] = langVar('L_USERNAME_UPDATE');
            }
        }


		//check the validity of the email in both respects
		$email = doArgs('email', false, $_POST);
		if(!is_empty($email) && $email != $user['email']){
			$emailCheck = $objSQL->getInfo('users', array('email="%s"', $email));
			if($objUser->validateEmail($email) && !$emailCheck){
				$update['email'] = $email;
    			$returnMsg[] = ($objCore->config('site', 'register_verification') ? langVar('L_EMAIL_ACTIVATION') : langVar('L_EMAIL_UPDATE'));
			}
		}


		//make sure that the confirmation checkbox is set
		$updatePass = false;
		$passConf = doArgs('chk_pass_conf', false, $_POST);
		if($passConf){
			$oldPass 	= doArgs('old_pass', false, $_POST);
			$newPass 	= doArgs('new_pass', false, $_POST);
			$confPass 	= doArgs('conf_pass', false, $_POST);

			//make sure all the password boxes are full
			if($oldPass!==false && $newPass!==false && $confPass!==false){
				if($this->objUser->CheckPassword($oldPass, $user['password']) && (md5($newPass) == md5($confPass))) {
					$objUser->setPassword($user['id'], $newPass);
					$updatePass = true;
				}else{
					$returnMsg[] = langVar('L_PASS_WRONG');
				}
			}else{
				$returnMsg[] = langVar('L_INVALID_PASS');
			}
		}

		//check to see if the user has admin permissions
		//User::$IS_ADMIN is only set once they log into the ACP
		$updatePin = false;
		if($user['userlevel'] == ADMIN){
			$oldPass 	= doArgs('old_pass', false, $_POST);
			$oldPin 	= doArgs('old_pin', false, $_POST);
			$newPin 	= doArgs('new_pin', false, $_POST);
			$confPin 	= doArgs('conf_pin', false, $_POST);

			//make sure the info is valid
			if($oldPin!==false && $newPin!==false && $confPin!==false && $oldPass!==false){
				if($this->objUser->CheckPassword($oldPass, $user['password']) && (md5($newPass) == md5($confPass))) {
					$doIt = false;

					//if the PIN has already been set, then check to make sure they have given is the old PIN
	                if(!is_empty($user['pin'])){
	                	//checky check
	                    if(md5($oldPin.$objCore->config('db', 'ckeauth')) == $user['pin']){
	                        $doIt = true;
	                    }else{
	                        $returnMsg[] = langVar('L_PIN_UPDATE_FAIL');
	                    }

					//else we dont need to check as we have nothing to check against
	                }else{ $doIt = true; }

	                //update the PIN
	                if($doIt === true){
	                    $objUser->setPIN($user['id'], $newPin);
	                    $updatePin = true;
	                }

				}else{
                    $returnMsg[] = langVar('L_PIN_UPDATE_FAIL');
				}
			}
		}


		//if errors
		if(!is_empty($returnMsg)){
			$_SESSION['site']['panel']['error'] = $returnMsg;
			$objPage->redirect($url);
			exit;
		}

		$noUpdate = true;
		//if we have stuff to update
		if(count($update)){
			//try the update
			$update = $objUser->updateUserSettings($uid, $update);
				if(!$update){
					$_SESSION['site']['panel']['error'] = array($objUser->error());
					$objPage->redirect($url);
					exit;
				}
			$noUpdate = false;
		}

		if($passConf && $updatePass){ $noUpdate = false; }
		if($pinConf && $updatePIN){ $noUpdate = false; }

    	//if update is empty
		if($noUpdate){
			hmsgDie('FAIL', implode('<br />', $updateMsg).langVar('L_NO_CHANGES'));
		}

		//if email changed, and email verification is on, log the user out
		if(!is_empty($update['email']) && $objPage->getSetting('site', 'register_verification')){
            $objLogin->logout($objUser->grab('usercode'));
	        $objPage->redirect('/'.root().'index.php');
	        exit;
        }

        $objUser->reSetSessions($uid);

    	unset($_SESSION['site']['panel']);
        $objPage->redirect($url, 3);
        hmsgDie('OK', implode('<br />', $updateMsg).langVar('L_PRO_UPDATE_SUCCESS'));
	break;
}

$objTPL->parse('body', false);
?>