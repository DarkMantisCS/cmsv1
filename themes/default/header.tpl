<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
{_META}
<title>{PAGE_TITLE} || {SITE_TITLE}</title>
{_JS_HEADER}
{_CSS}
<link rel="stylesheet" href="/{THEME_ROOT}style.css" type="text/css" />
<!-- BEGIN no_menu -->
<style>
	#pageContent{ width:100%; }
</style>
<!-- END no_menu -->
</head>

<body>
<div id="site">
	<!-- BEGIN __MSG -->
	<div id="topBar" class="boxred">{__MSG.MESSAGE}</div>
    <!-- END __MSG -->
	<div id="topBar">
    	<div class="float-left">{WELCOME}
		<!-- BEGIN IS_ONLINE -->
         - {UCP_LINK}
        <!-- END IS_ONLINE -->
		<!-- BEGIN IS_ADMIN -->
         - {ACP_LINK}
        <!-- END IS_ADMIN -->
        </div>
    	<div class="float-right">
		<!-- BEGIN IS_ONLINE -->
        {LOGOUT} || 
        <!-- END IS_ONLINE -->
		<!-- BEGIN IS_NOT_LOGGED_IN -->
        {LOGIN} ||
        <!-- END IS_NOT_LOGGED_IN -->
        <div id="clock" class="iblock">{TIME}</div>
        </div>
    </div>
        
    <div id="header">
    	<div id="logo">&nbsp;</div>
    </div>
    
    <div id="nav">
    	<ul>{TPL_MENU}</ul>
    </div>

    <div id="container">
    <div id="wrapper">
        <div id="breadcrumbs" class="content padding">
            <span><strong>You are here</strong>: </span><span class="path">{BREADCRUMB}</span> 
        </div>
    <!-- BEGIN menu -->
    
        <div id="sidebar">
    <!-- END menu -->
            <!-- BEGIN left_menu -->
            <div class="sideMenu">
                <div class="title corners">
                    <div class="padding" style="font-size:12px;"><h3>{left_menu.TITLE}</h3></div>
                </div>
                <span id="content" class="corners">{left_menu.CONTENT}</span>
            </div>
            <!-- END left_menu -->
            <!-- BEGIN right_menu -->
            <div class="sideMenu">
                <div class="title corners">
                    <div class="padding" style="font-size:12px;"><h3>{right_menu.TITLE}</h3></div>
                </div>
                <span id="content" class="corners">{right_menu.CONTENT}</span>
            </div>
            <!-- END right_menu -->
    <!-- BEGIN menu -->
        </div>
        
    <!-- END menu -->
        <div id="pageContent">