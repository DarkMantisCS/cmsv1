<?php
define('INDEX_CHECK', true);
define('cmsDEBUG', 1);
define('NOMENU', 0);
include_once('core/core.php');

$objPage->setTheme('default');
$objPage->setThemeVars();
$objPage->setMenu('core', 'default');

$objPage->showHeader();

#$objForm->required('username', 'password');

$objTPL->set_filenames(array(
	'body' => 'modules/core/template/formOutput.tpl',
));

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
							'Recaptcha'			=> $objForm->loadCaptcha('desc'),
						),
					));



$objPage->showFooter();
?>