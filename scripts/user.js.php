<?php
/*======================================================================*\
||              Cybershade CMS - Your CMS, Your Way                     ||
\*======================================================================*/
header('content-type: application/x-javascript');
define('INDEX_CHECK', true);
define('NO_LOG', true);

$cmsROOT = '../';
include_once($cmsROOT.'core/core.php');

if(!User::$IS_ONLINE){ die(); }
if(is_readable('/'.Page::$THEME_ROOT.'extras.php')){ include '/'.Page::$THEME_ROOT.'extras.php'; }
$vars = $objPage->getVar('tplVars');
?>
var User = {
	username: "<?php echo $objUser->grab('username'); ?>",

	IS_ONLINE: 	<?php echo (User::$IS_ONLINE ? 'true' : 'false'); ?>,
	IS_MOD: 	<?php echo (User::$IS_MOD ? 'true' : 'false'); ?>,
	IS_ADMIN: 	<?php echo (User::$IS_ADMIN ? 'true' : 'false'); ?>

};

var Page = {
	highlight_color: "<?php echo $vars['row_highlight']; ?>"
}

function showNotification(id, message, header, sticky){
	$.gritter.add({
		id : id,
		title : header || "",
		text : message,
		sticky : Boolean(sticky),
		before_open: function(){
			console.log(this);
			$(this).attr('id', 'notify-'+id);
		}
	});
}

/*$.periodic({period: 5000, decay: 1.2, max_period: 60000}, function() {
	$.ajax({
		url: '/'+cmsROOT+'scripts/ajax.php?action=grabNewNotifications',
		complete: this.ajax_complete,
		dataType: 'script'
	});
});*/


var avatarMenu = [
	{ name: "Avatar Options", className: "title", disabled: true },
	{ name: "Remove", className: "ava_remove", callback: function(){ console.log(this); } },
	{ name: "Upload New", className: "ava_upload", callback: function(){ console.log(this); } },
	{ name: "Off Link New", className: "ava_offlink", callback: function(){ console.log(this); } },
	{ separator: true },
	{ name: "More User Preferences", className: "title", callback: function(){ document.location = "/"+root+"user/"; } }
];

$(document).ready(function(){
	//if($("user_autocomplete")){ usernameAutocomplete($("#user_autocomplete").attr('data-input')); }


	//context menu on the users own avatar frames
	$.protoMenu.add({
	    selector: "#"+User.username+"_avatar",
	    className: "menu cms",
	    menuItems: avatarMenu
	});

	$("img[class=avatar]:not([avatar~="+User.username+"])").each(function (ava){
		var user = ava.attr("data-avatar");

		$.protoMenu.add({
			selector: "#"+user+"_avatar",
			className: "menu cms",
			menuItems: [
				{ name: user+" Avatar Options", className: "title", disabled: true },
				{ name: "Remove Avatar", className: "ava_reset", callback: function(){
					inWindow("/"+cmsROOT+"modules/profile/avatar/?action=reset&username="+user, "Reset Avatar", 400, 100);
				}}
			]
		});
	});



});