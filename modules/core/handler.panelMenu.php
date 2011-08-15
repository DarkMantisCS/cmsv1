<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}
if(!defined('PANEL_CHECK')){die('Error: Cannot include panel from current location.');}

$corePanels = array(); $mode = $_mode; $vars = $objPage->getVar('tplVars');
if(User::$IS_ADMIN){   $corePanels['admin'] = cmsROOT.'modules/core/panels/admin/';   }
if(User::$IS_MOD){     $corePanels['mod']   = cmsROOT.'modules/core/panels/mod/';     }
if(User::$IS_USER){    $corePanels['user']  = cmsROOT.'modules/core/panels/user/';    }
$objTPL->assign_block_vars('_PMENU', array());
foreach($corePanels as $pTitle => $modePath){
    $assign = NULL;
    $panels = getFiles($modePath);
    foreach($panels as $p){
        if(!preg_match('/^([a-zA-Z0-9]*)$/is', $p['name']) || $p['name']=='index'){ continue; }
        if(is_dir($modePath.$p['name']) && is_file($modePath.$p['name'].'/cfg.php')){
            include($modePath.$p['name'].'/cfg.php');
            $assign .= '<li><a href="/'.root().$pTitle.'/core/'.$p['name'].'/"'.($p['name']==$panel ? ' class="active"' : null).'> '.$mod_name.'</a></li>';
        }
    }

    $objTPL->assign_block_vars('_PMENUS', array(
        'URL'       => '/'.root().$pTitle.'/',
        'TITLE'     => ucwords($pTitle).' Panel',
        'CONTENT'   => $assign,
        'CLASS'     => ($mode==$pTitle ? ' active' : ''),
    ));
}

$array = array('user', 'mod', 'admin');
if(count($config['modules']) && in_array($mode, $array)){
    $assign = NULL;
    foreach($config['modules'] as $module){
        if($module['enabled']==false || strtolower($module['name'])=='core'){ continue; }
        if(is_dir(cmsROOT.'modules/'.$module['name'].'/') &&
           is_readable(cmsROOT.'modules/'.$module['name'].'/cfg.php') &&
           is_readable(cmsROOT.'modules/'.$module['name'].'/'.$mode.'.'.$module['name'].'.php')){
                include(cmsROOT.'modules/'.$module['name'].'/cfg.php');
                $assign .= '<li><a href="/'.root().$mode.'/'.$module['name'].'/">'.$mod_name.'</a></li>';
        }
    }

    $objTPL->assign_block_vars('_PMENUS', array(
        'URL'       => '#',
        'TITLE'     => 'Modules ('.$mode.')',
        'CONTENT'   => $assign,
        'CLASS'     => '',
    ));
}

?>