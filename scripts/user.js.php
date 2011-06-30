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
var IS_ONLINE = "<?php echo (User::$IS_ONLINE ? 'true' : 'false'); ?>",
	IS_MOD = "<?php echo (User::$IS_MOD ? 'true' : 'false'); ?>",
	IS_ADMIN = "<?php echo (User::$IS_ADMIN ? 'true' : 'false'); ?>";

function showNotification(id, message, header, sticky){
	$.gritter.add({
		id		: id,
		title	: header || "",
		text	: message,
		sticky	: Boolean(sticky),
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

$(document).ready(function(){
	//if($("user_autocomplete")){ usernameAutocomplete($("#user_autocomplete").attr('data-input')); }

});