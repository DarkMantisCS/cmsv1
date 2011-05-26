<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
{_META}
<title>{PAGE_TITLE} || {SITE_TITLE}</title>
{_JS_HEADER}
<link rel="stylesheet" id="adapt" />
{_CSS}
<link rel="stylesheet" href="/{THEME_ROOT}style.css" type="text/css" />

<!--[if lte IE 8]>
<script src="http://localhost/cms/scripts/html5.js" type="text/javascript"></script>
<![endif]-->
</head>

<body>
<div id="site-wrapper" class="container_12 clearfix">
	<header id="banner">
	<!-- BEGIN __MSG -->
		<div id="topBar"><div class="boxred">{__MSG.MESSAGE}</div></div>
		<div class="clear">&nbsp;</div>
	<!-- END __MSG -->
		<div id="topBar">
			<div class="float-left">{L_WELCOME}
				<!-- BEGIN IS_ONLINE -->
				 - <a href="{U_UCP}">{L_UCP}</a>
				<!-- END IS_ONLINE -->
				<!-- BEGIN IS_ADMIN -->
				 - <a href="{U_ACP}">{L_ACP}</a>
				<!-- END IS_ADMIN -->
			</div>
			<div class="float-right">
				<!-- BEGIN IS_ONLINE -->
				<a href="{U_LOGOUT}">{L_LOGOUT}</a> || 
				<!-- END IS_ONLINE -->
				<!-- BEGIN IS_NOT_LOGGED_IN -->
				<a href="{U_LOGIN}">{L_LOGIN}</a> || 
				<!-- END IS_NOT_LOGGED_IN -->
				<div id="clock" class="iblock">{TIME}</div>
			</div>
		</div>
		<div id="logo">&nbsp;</div>
		
		<nav><ul>{TPL_MENU}</ul></nav>
	</header>

	<nav id="breadcrumbs">
		<span><strong>{L_BREADCRUMB}</strong>: </span><span class="path">{BREADCRUMB}</span>
	</nav>

	<section id="content" class="grid_12">
	<!-- BEGIN menu -->
		<aside id="sidebar" class="grid_3">
	<!-- END menu -->
			<!-- BEGIN left_menu -->
			<div class="sideMenu">
				<header class="title"><h3>{left_menu.TITLE}</h3></header>
				<section class="content">{left_menu.CONTENT}</section>
			</div>
			<!-- END left_menu -->
			<!-- BEGIN right_menu -->
			<div class="sideMenu">
				<header class="title"><h3>{right_menu.TITLE}</h3></header>
				<section class="content">{right_menu.CONTENT}</section>
			</div>
			<!-- END right_menu -->
	<!-- BEGIN menu -->
		</aside>
	<!-- END menu -->

		<!-- BEGIN no_menu -->
		<div id="pageContent" class="grid_12">
		<!-- END no_menu -->
		<!-- BEGIN menu -->
		<div id="pageContent" class="grid_9">
		<!-- END menu -->