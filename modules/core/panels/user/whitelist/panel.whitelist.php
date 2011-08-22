<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
$objPage->setTitle(langVar('B_UCP').' > '.langVar('L_WHITELIST_PANEL'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_WHITELIST_PANEL')) ));
$objTPL->set_filenames(array(
    'body' => 'modules/core/template/panels/panel.settings.tpl'
));

//grab the user info we need
$user = $objUser->getUserInfo($uid);
$uid = $objUser->grab('id');

switch(strtolower($mode)){
    default:
        //set some security crap
        $_SESSION['site']['panel']['sessid'] = $sessid = $objUser->mkPassword($uid.time());
        $_SESSION['site']['panel']['id'] = $uid;

        $yn = array(1=>langVar('L_ENABLED'), 0=>langVar('L_DISABLED'));

        $objTPL->assign_block_vars('msg', array(
            'MSG' => msg('INFO', langVar('L_IPRANGE_DESC'), 'return'),
        ));

        $fieldSet = array();
        $fieldSet[langVar('L_WHITELIST_PANEL')] = $objForm->radio('whitelist', $yn, $user['whitelist']);

        $ips = json_decode(stripslashes($user['whitelisted_ips']));
        if(is_array($ips) && !is_empty($ips)){
            foreach($ips as $no => $ip){
                $fieldSet[langVar('L_IPRANGE', ($no+1))] = $objForm->inputbox('range[]', 'text', (isset($ip) ? $ip : ''));
            }
        }
        $fieldSet[langVar('L_NEWRANGE')] = $objForm->inputbox('range[]', 'text', null);

        $objForm->outputForm(array(
            'FORM_START'    => $objForm->start('panel', array('method' => 'POST', 'action' => $saveUrl)),
            'FORM_END'      => $objForm->finish(),

            'FORM_TITLE'    => langVar('L_WEBSITE_PANEL'),
            'FORM_SUBMIT'   => $objForm->button('submit', 'Submit'),
            'FORM_RESET'    => $objForm->button('reset', 'Reset'),

            'HIDDEN'        => $objForm->inputbox('sessid', 'hidden', $sessid).$objForm->inputbox('id', 'hidden', $uid),
        ),
        array(
            'field' => $fieldSet,
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

        $update = array(); $error = array();
        $ranges = doArgs('range', false, $_POST);
            if(!$ranges || !is_array($ranges)){ hmsgDie('FAIL', 'Error: Cannot verify information.'); }

        $set = array();
        foreach($ranges as $r){
            if(is_empty($r)){ continue; }
            $r = explode('.', $r);
            $cur = array();
            foreach($r as $mask){
                if((is_number($mask) && $mask <= 255) || $mask == '*'){
                    $cur[] = $mask;
                }
            }
            if(count($cur) == 4){
                $set[] = implode('.', $r);
            }else{
                $error[] = implode('.', $r).' was invalid';
            }
        }

        if(!is_empty($set)){
            $update['whitelisted_ips'] = json_encode($set);
        }

        if(doArgs('whitelist', false, $_POST, 'is_number') != $user['whitelist']){
            $update['whitelist'] = $_POST['whitelist'];
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
        hmsgDie('OK', implode('<br />', $updateMsg).
                        langVar('L_PRO_UPDATE_SUCCESS').
                        (!is_empty($error) ? '<br />but...'.implode($error) : null));
    break;
}

$objTPL->parse('body', false);
?>