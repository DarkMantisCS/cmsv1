<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
define('INDEX_CHECK', 1);
define('cmsDEBUG', 1);
include 'core/core.php';
$objPage->setTitle(langVar('B_REGISTER'));

//no need for them to be here
if(User::$IS_ONLINE){ $objPage->redirect('/'.root().'index.php'); }

//add our JS in here for the register
$objPage->addJSFile('/'.root().'scripts/register.js');

//setup breadcrumbs
$objPage->addPagecrumb(array(
	array('url' => '/'.root().'register.php',  'name' => langVar('B_REGISTER')),
));

if(!$objPage->config('site', 'allow_register')){
    hmsgDie('INFO', 'Error: An administrator has disabled Registrations.');
}

$objPage->showHeader();

if(!HTTP_POST){
echo $objForm->outputForm(array(
		'FORM_START' => $objForm->start('register', array('method'=>'POST', 'action'=>'?')),
		'FORM_END'	 => $objForm->finish(),

		'FORM_TITLE' => 'User Registration',
		'FORM_SUBMIT'=> $objForm->button('submit', 'Submit'),
		'FORM_RESET' => $objForm->button('reset', 'Reset'),
	),
	array(
		'field' => array(
			'User Info'			=> '_header_',
			'Username' 			=> $objForm->inputbox('username', 'text', '', array('extra' => 'maxlength="20" size="20"', 'required'=>true)),
			'Password' 			=> $objForm->inputbox('pwd', 'password', null, array('required'=>true)),
			'Confirm Password' 	=> $objForm->inputbox('pwd2', 'password', null, array('required'=>true)),

			'Email' 			=> $objForm->inputbox('email', 'text', '', array('required'=>true)),

			'Captcha'			=> '_header_',
			'Recaptcha'			=> $objForm->loadCaptcha('captcha'),
		),
		'desc' => array(
			'Username' 			=> 'This field can be [a-zA-Z0-9-_.]',
			'Recaptcha'			=> $objForm->loadCaptcha('desc').'<br />'.langVar('L_CAPTCHA_DESC'),
		),
	));
}else{

	if(is_empty($_POST)){
		$objPage->redirect($objCore->config('global', 'fullPath'), 0, 3);
		hmsgdie('FAIL', 'Error: Please use the form to submit your registration request');
	}

    //do some checks on the username
    if(!$objUser->verifyUsername($username)){
        $_error[] = 'You have chosen an Username with invalid characters in. Please choose another one.';
    }


}


$objPage->showFooter();
?>