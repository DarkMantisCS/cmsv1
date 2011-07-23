<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die("INDEX_CHECK not defined."); }
$objPage->setTitle(langVar('B_UCP').' > '.langVar('L_WEBSITE_PANEL'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_WEBSITE_PANEL')) ));
$objTPL->set_filenames(array(
	'body' => "modules/core/template/panels/panel.settings.tpl"
));

//grab the user info we need
$user = $objUser->getUserInfo($uid);
$uid = $objUser->grab('id');

switch(strtolower($mode)){
	default:

		//set some security crap
		$_SESSION['site']['panel']['sessid'] = $sessid = $objUser->mkPasswd($uid.time());
		$_SESSION['site']['panel']['id'] = $uid;

		//generate a list of themes
		$tpl = array();
		$dir = cmsROOT.'themes/';
		if(is_readable($dir)){
			foreach (getFiles($dir) as $file){
				if($file!='.' && $file!='..' && $file['name']!='index.php' && $file['name']!='index.html'){
					if (file_exists($dir.$file['name'].'/cfg.php')){
						include ($dir.$file['name'].'/cfg.php');
						$tpl[$file['name']] = $mod_name.' V'.$mod_version;
					}
				}
			}
		}

		//generate a list of timezones
		$timezone_array = array(
			'-12.0', '-11.0', '-10.0', '-9.0', '-8.0',
			'-7.0', '-6.0', '-5.0', '-4.0', '-3.5', '-2.0',
			'-1.0', '0.0', '1.0', '2.0', '3.0', '3.5', '4.0',
			'4.5', '5.0', '5.5', '6.0', '6.5', '7.0',
			'8.0', '9.0', '9.5', '10.0', '11.0', '12.0'
		);

		$tcount = count($timezone_array);
		$timezone = '';
		$timezone .= '<select name="timezone">'."\n";
		$option = "\t".'<option value="%1$s"%2$s>GMT %1$s</option>'."\n";
		foreach($timezone_array as $tzone){
			$timezone .= sprintf($option, $tzone, ($user['timezone']===$tzone ? ' selected="selected"' : ''));
		}
		$timezone .= '</select>';

        //get list of groups
		$sMembers = array();
		$query = $objSQL->getTable($objSQL->prepare(
			'SELECT DISTINCT g.id, g.name, g.color, g.type
				FROM `$Pgroups` g, `$Pgroup_subs` gs
				WHERE gs.uid ="%d" AND g.id = gs.gid AND gs.pending = 0
				ORDER BY g.order ASC',
			$uid
		));

		$sMembers = '';
		$sMembers .= '<select name="primary_group">'."\n";
        $sMembers .= "\t".'<option value="0">CMS Pick</option>'."\n";
		$option = "\t".'<option value="%1$s" style="color: %2$s"%4$s>%3$s</option>'."\n";
        foreach($query as $row){
			$sMembers .= sprintf($option, $row['id'], $row['color'], $row['name'], ($user['primary_group'] == $row['id'] ? ' selected="selected"' : ''));
        }
		$sMembers .= '</select>';


        $yn = array(1=>langVar('L_YES'), 0=>langVar('L_NO'));

		$objForm->outputForm(array(
			'FORM_START' 	=> $objForm->start('panel', array('method' => 'POST', 'action' => $saveUrl)),
			'FORM_END'	 	=> $objForm->finish(),

			'FORM_TITLE' 	=> langVar('L_WEBSITE_PANEL'),
			'FORM_SUBMIT'	=> $objForm->button('submit', 'Submit'),
			'FORM_RESET' 	=> $objForm->button('reset', 'Reset'),

			'HIDDEN' 		=> $objForm->inputbox('sessid', 'hidden', $sessid).$objForm->inputbox('id', 'hidden', $uid),
		),
		array(
			'field' => array(
				langVar('L_ACCT_SETTINGS') 		=> '_header_',
	            langVar('L_SEX')				=> $objForm->radio('sex', array(0=>langVar('L_SEX_U'), 1=>langVar('L_SEX_M'), 2=>langVar('L_SEX_F')), $user['sex']),
				langVar('L_PRIV_EMAIL')	    	=> $objForm->radio('show_email', $yn, $user['show_email']),

				langVar('L_SITE_SETTINGS') 		=> '_header_',
	            langVar('L_USER_COLORING')		=> $sMembers,
	            langVar('L_TIMEZONE')			=> $timezone,
				langVar('L_SITE_TEMPLATE')		=> $objForm->select('theme', $tpl, $user['template']),

				langVar('L_FORUM_SETTINGS')		=> '_header_',
				langVar('L_QUICK_REPLIES')		=> $objForm->radio('quick_reply', $yn, $user['forum_quickreply']),
	            langVar('L_AUTO_WATCH')	    	=> $objForm->radio('auto_watch', $yn, $user['forum_autowatch']),
			),
			'desc' => array(
				langVar('L_EMAIL') => $email,
			),
			'errors' => $_SESSION['site']['panel']['error'],
		),
		array(
			'header' => '<h4>%s</h4>',
			'dedicatedHeader' => true,
		));
	break;

	case 'save':
		if (!HTTP_POST && !HTTP_AJAX){
			hmsgDie('FAIL', 'Error: Cannot verify information.');
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

		//check Tzone
		$timezone_array = array(
			'-12.0', '-11.0', '-10.0', '-9.0', '-8.0',
			'-7.0', '-6.0', '-5.0', '-4.0', '-3.5', '-2.0',
			'-1.0', '0.0', '1.0', '2.0', '3.0', '3.5', '4.0',
			'4.5', '5.0', '5.5', '6.0', '6.5', '7.0',
			'8.0', '9.0', '9.5', '10.0', '11.0', '12.0'
		);

		$timezone = doArgs('timezone', false, $_POST);
		if(in_array($timezone, $timezone_array) && $timezone!=$user['timezone']){
			$update['timezone'] = $timezone;
		}

		$theme = doArgs('theme', false, $_POST);
		if(is_readable(cmsROOT.'themes/'.$theme.'/') && $theme!=$user['theme']){
			$update['theme'] = $theme;
		}

		$lang = doArgs('language', false, $_POST);
		if(is_readable(cmsROOT.'languages/'.$lang.'/') && $lang!=$user['language']){
			$update['language'] = $lang;
		}

		$vars = array('sex' => 'sex', 'forum_quickreply' => 'quick_reply', 'show_email' => 'show_email', 'forum_autowatch' => 'auto_watch');
		foreach($vars as $setting => $var){
			if(doArgs($var, false, $_POST, 'is_number')!=$user[$setting]){
				$update[$setting] = $_POST[$var];
			}
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

    	//if update is empty
		if($noUpdate){
	        $objPage->redirect($url, 3);
			hmsgDie('FAIL', implode('<br />', $updateMsg).langVar('L_NO_CHANGES'));
		}

        $objUser->reSetSessions($uid);

    	unset($_SESSION['site']['panel']);
        $objPage->redirect($url, 3);
        hmsgDie('OK', implode('<br />', $updateMsg).langVar('L_PRO_UPDATE_SUCCESS'));
	break;
}

$objTPL->parse('body', false);
?>