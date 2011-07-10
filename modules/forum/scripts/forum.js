if(typeof Page != undefined){
	$$('tr[class*="highlight"]').each(function(ele){
	    $(ele.id).observe('mouseover', function(){
			var trClass = $(ele.id).hasClassName('row_color1') ? Page.row_color1 : Page.row_color2;
			new Effect.Highlight(ele.id, {
		        startcolor: Page.row_highlight,
		        endcolor: trClass,
		        restorecolor: trClass,
		        duration: 1
			});
	    });
	});
}


$$('td[data-url]').each(function(ele) {
	var url = ele.readAttribute('data-url');

	if(!empty(url)){
		window.status = url;
		ele.writeAttribute({
			onclick: 'document.location = "'+url+'";',
			style: 'cursor: pointer'
		});
	}
});

document.observe('dom:loaded', function(){


	if($('qreply')){
		makeReplyForm('qreply');
		/*$$('a[href=#qreply]')[0].observe('click', function(){
			$$('#qreply textarea')[0].focus();
		});*/
	}
});
