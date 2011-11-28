<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');}
if(!defined('PANEL_CHECK')){die('Error: Cannot include panel from current location.');}

//setup some vars we are gonna need
$corePanels = array();
$vars = $objPage->getVar('tplVars');

//check to see which panel group we need
if(User::$IS_ADMIN){    $corePanels['admin'] = cmsROOT.'modules/core/panels/admin/';   }
if(User::$IS_MOD){      $corePanels['mod']   = cmsROOT.'modules/core/panels/mod/';     }
if(User::$IS_USER){     $corePanels['user']  = cmsROOT.'modules/core/panels/user/';    }

//setup the tabs
$tabs = 'modules/core/panels/'.$controlPanel.'/menu.php';
if(!is_file($tabs) || !is_readable($tabs)){
    hmsgDie('FAIL', 'Error: Tabs for this panel don\'t exist.');
}
$menuTabs = parse_ini_file($tabs, true);
if(!is_array($menuTabs) || !count($menuTabs)){
    hmsgDie('FAIL', 'Error: Tabs setup failed.');
}

$tabs = array();
//make sure we are in a good mode
$array = array('user', 'mod', 'admin');
if(count($config['modules']) && in_array($controlPanel, $array)){
    foreach($menuTabs as $parentKey => $v){
        if(is_array($v)){
            foreach($v as $key => $value){
                if($key != 'info'){
                    $tabs[$parentKey][$key] = $value;
                }
            }
        }
    }

    $assign = NULL;
    //run thru the installed modules
    foreach($config['modules'] as $module){
        //make sure its enabled and not core
        if($module['enabled']==false || strtolower($module['name'])=='core'){ continue; }
        //run a few checks and add it to the list
        $modulePath = cmsROOT.'modules/'.$module['name'].'/';
        if(is_dir($modulePath) &&
           is_readable($modulePath.'/cfg.php') &&
           is_readable($modulePath.'/'.$controlPanel.'.'.$module['name'].'.php')){
                include($modulePath.'/cfg.php');
                $tabs['Modules'][$mod_name] = $controlPanel.'/'.$module['name'].'/';
        }
    }
}

$menu = null;
if(!is_empty($tabs)){
    $_class = 'on';
    $_tab = '<li class="%3$s">%1$s <ul class="grid_8 sub">'."\n".'%2$s</ul></li>'."\n";
    $_subTab = '<li>%s</li>'."\n";
    $_link = '<a href="%s">%s</a>';

    foreach($tabs as $tab => $links){
        $subTabs = null;
        $tab = stripslashes($tab);

        $on = false;
        foreach($links as $subTitle => $subLink){
            $subLink = '/'.root().$subLink;
            $link = sprintf($_link, $subLink, $subTitle);
            $subTabs .= sprintf($_subTab, $link);

            if($config['global']['fullPath'] == $subLink){
                $on = true;
            }
        }
        $menu .= sprintf($_tab, $tab, $subTabs, ($on === true ? $_class : null));
    }

}

$objPage->addCSSFile('/'.root().'images/panels.css');

$objTPL->set_filenames(array(
    'tabs' => 'modules/core/template/panels/panel.panel_tabs.tpl'
));

$objTPL->assign_vars(array(
    'TABS' => $menu,
));

$objTPL->parse('tabs', false);
?>