<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}
define('PANEL_CHECK', 1);

//this determines what panels we want to use here...
$panels = array('admin', 'mod', 'user');

switch($mode){
    case in_array($mode, $panels):
        if(is_empty($action)){ $action = 'index'; }

        //kill the menu and grab the panel
        $objPage->setMenu(false);
        $objTPL->set_filenames(array(
            'panel' => 'modules/core/template/panel.global.tpl'
        ));

        //make sure they have the correct privs
        $break = false;
        #if($mode=='admin'   && !User::$IS_ADMIN){   $break = true; }
        if($mode=='mod'     && !User::$IS_MOD){     $break = true; }
        if($mode=='user'    && !User::$IS_ONLINE){  $break = true; }

        if($break){
            msg('FAIL', 'Error: Permissions Denial.', '_CONTENT');
            $objTPL->parse('panel', false);
            break;
        }
        $controlPanel = $mode;

        //make sure the panel name is valid
        if(!preg_match('_([a-zA-Z0-9]*)_is', $action, $panel)){
            msg('FAIL', 'Error: Could not find Panel.', '_CONTENT'); break;
        } $panel = $panel[1];

        //set some vars
        $path = cmsROOT.'modules/core/panels/'.$mode.'/'.$panel;
        $url = str_replace('?save', '', $objCore->config('global', 'url'));
        $saveUrl = $url.'?save';
        $uid = (User::$IS_MOD ? doArgs('uid', $objUser->grab('id'), $_GET, 'is_number') : $objUser->grab('id'));

        // mode will change based on what we want, set it to null to begin with, then check for mode, and then for save
        $mode = null;
        $mode = doArgs('mode', $mode, $_GET, 'quickEmpty');
        $mode = doArgs('save', $mode, $_GET, 'quickEmpty');
        function quickEmpty($arg){
            return !is_empty($arg);
        }

        if(!defined('NOMENU')){
            if(!is_readable(cmsROOT.'modules/core/handler.panelTabs.php')){
                hmsgDie('FAIL', 'Error: Missing Panel Menu File...Cannot Continue.');
            } include(cmsROOT.'modules/core/handler.panelTabs.php');
        }

        $file = $path.'/panel.'.$panel.'.php';
        if(!is_file($file) || !is_readable($file)){
            $objCore->throwHTTP(404);
        }else{ include_once($file); }


        if(!$objTPL->isHandle('body')){
            msg('FAIL', 'Error: Panel did not output any content.', '_CONTENT');
        }

        $objTPL->assign_var('_CONTENT', $objTPL->output('body', false));
        $objTPL->parse('panel', false);
    break;

    default:
        $objCore->throwHTTP(404);
    break;
}

?>