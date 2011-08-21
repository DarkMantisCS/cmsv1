<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
if(!defined('INDEX_CHECK')){ die('Error: Cannot access directly.'); }
if(!defined('PANEL_CHECK')){ die('Error: Cannot include panel from current location.'); }
$objPage->setTitle(langVar('B_ACP').' > '.langVar('L_SYS_INFO'));
$objPage->addPagecrumb(array( array('url' => $url, 'name' => langVar('L_SYS_INFO')) ));
$objTPL->set_filenames(array(
    'body' => 'modules/core/template/panels/panel.sysinfo.tpl'
));

    //grab some shite about GD
    if(function_exists('gd_info')){
        $a = gd_info(); $gdVer = preg_replace('/[[:alpha:][:space:]()]+/', '', $a['GD Version']);
    }else{
        $gdVer = 'Not Installed.';
    }

    //figure out which DB extensions are avalible
    $dbList = null;
    $dbTests = array('mysql_connect', 'mysqli_connect', 'pg_connect', 'mssql_connect', 'sqlite_open');
    foreach($dbTests as $test){
        if(function_exists($test) && is_callable($test)){
            $db = explode('_', $test);

            switch($db[0]){
                default:
                    $dbList[] = $db[0];
                break;

                case 'mysql':
                    $dbList[] = $db[0].' ('.mysql_get_server_info().')';
                break;

                case 'mysqli':
                    $dbList[] = $db[0].' (Server: '.mysqli_get_server_version().', Client: '.mysqli_get_client_version().')';
                break;

                case 'sqlite':
                    $dbList[] = $db[0].' ('.sqlite_libversion().')';
                break;

                case 'pg':
                    $dbList[] = 'postgre ('.pg_version().')';
                break;
            }
        }
    }

    if(class_exists('SQLite3', false) && is_callable(array('SQLite3', 'open'))){
        $ver = SQLite3::version();
        $dbList[] = 'SQLite3 ('.$ver['versionString'].')';
    }


    //gather some debug content :)
    $content = '
;--System Setup
    OS Info: "'.php_uname().'"
    OS Quick: "'.PHP_OS.'"
    CMS Version: "'.cmsVERSION.'"
    PHP Version: "'.PHP_VERSION.'" ('.(@ini_get('safe_mode') == '1' || strtolower(@ini_get('safe_mode')) == 'on' ?
                                            'Safe Mode Enabled' : 'Safe Mode Disabled').')

    Avalible DB Support: '."\n\t\t - ".implode("\n\t\t - ", $dbList).'

    GD Version: "'.$gdVer.'"

;--CMS Setup
    URL: "'.$objCore->config('global', 'rootUrl').'"
    root(): "/'.root().'"
    cmsROOT: "'.cmsROOT.'"
    https?: "'.($objCore->config('global', 'secure') ? 'true' : 'false').'"

'.json_encode($objSQL->getTable(
    'SELECT * FROM `$Pconfig`
    WHERE array NOT IN("cms", "db", "email")
        AND var NOT IN("analytics", "registry_update")
        AND var NOT LIKE "%s"
    ORDER BY array, var ASC',
    '%captcha_%'
)).'';

    //and output
    include($path.'/cfg.php');
    $objTPL->assign_vars(array(
        'ADMIN_MODE'    => $mod_name,
        'MSG'            => msg('INFO', 'This panel is ment to be an informative guide to help both you as end users and also us as the developers of this CMS. Please be careful about sharing this information as it can be useful to hackers as much as its useful for us developers to debug your problems.', 'return'),
        'CONTENT'       => $objForm->textarea('sysInfo', $content, array('style'=>'width: 99%;border:0;')),
    ));

$objTPL->parse('body', false);
?>