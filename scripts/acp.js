$(document).ready(function(){ 
	$(window).resize(function() {
		var winWidth = $(window).width();

		if(winWidth>1024){ 
			$('div#sidebar').show();
			$('div#content').removeClass('noSidebar');
		}else{
			$('div#sidebar').hide();
			$('div#content').addClass('noSidebar');
		}
	});
	
	$(window).trigger('resize');
	
});