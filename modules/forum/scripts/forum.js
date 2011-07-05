//if(User.IS_ONLINE){
	$('tr[class*="highlight"]').mouseover(function() {
		$(this).effect("highlight", {color: Page.highlight_color}, 1000);
	});
//}

$('td[data-url]').each(function() {
	var url = $(this).attr('data-url');

	if(!empty(url)){
		window.status = url;
		$(this).attr({
			onClick: 'document.location = "'+url+'";',
			style: 'cursor: pointer'
		});
	}
});
