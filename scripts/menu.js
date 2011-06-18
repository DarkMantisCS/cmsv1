/* 
	Simple JQuery Accordion menu.
	Copyright 2007 by Marco van Hylckama Vlieg

	web: http://www.i-marco.nl/weblog/
	email: marco@i-marco.nl

	Free for non-commercial use
*/

$(document).ready(function(){ 
	$('#menu ul').hide();
	$('#menu li.active ul').show();
	$('#menu li a').click(function() {
		var checkElement = $(this).next(); var parentElement = $(this).parent();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#menu ul:visible').slideUp('normal');$('#menu li.active').removeClass('active');
			checkElement.slideDown('normal'); parentElement.addClass('active');
			return false;
		}
	});
});