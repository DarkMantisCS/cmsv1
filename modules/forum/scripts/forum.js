function toggleMenu(id){
	var img = $('img_'+id);
    var imgMode = img.readAttribute('data-mode');

	img.writeAttribute({
		'src': '/'+THEME_ROOT+'buttons/'+(imgMode==0 ? 'minimize' : 'maximize')+'.png',
		'data-mode': imgMode==0 ? '1' : '0'
	});

	new Effect.toggle($('f_'+id), 'slide');
	//updateCats();
}

function grabState(){
	var str = ''; var count = 0;
	$$('img[data-mode]').each(function(img) {
		and = count++==0 ? '' : '&';
		mode = img.readAttribute('data-mode')==0 ? 0 : 1;
		str = str+and+img.readAttribute('name')+'='+mode;
	});
	return str;
}

function updateCats(){
	if(!User.IS_ONLINE){ return; }
	new Ajax.Request('/'+cmsROOT+'modules/forum/ajax/sortForum.php', {
		method: 'post',
		parameters: {
			order: Sortable.serialize('sortable_forums'),
			state: grabState()
		}
	});
}


function doBBCode(ele){
    var textarea = $$('textarea')[0];
    var code = ele.readAttribute('data-code');
    if(empty(code)){ return false; }

    var check = code.indexOf('|');
    if(check == -1){
        addText(textarea, code, code);
    }else{
        var code = explode('|', code);
        addText(textarea, code[0], code[1]);
    }
	return false;
}

function addText(ele, txt1, txt2) {
	textarea = $(ele);
	var selection = new Selection(textarea);
	var focus = {x:0, y:0};

	if(document.selection){
		var str = txt1 + selection.getText() + txt2;
	} else if (textarea.selectionStart || textarea.selectionStart == '0') {
		var value = textarea.getValue();

		var str = value.substring(0, textarea.selectionStart);
			if(textarea.selectionStart!=0 || textarea.selectionEnd!=0){
				focus.x = strlen(str+txt1);
			}else{
				focus.x = focus.y = strlen(str+txt1);
			}
		str += txt1 + selection.getText();
			if(textarea.selectionStart!=0 || textarea.selectionEnd!=0){
				focus.y = strlen(str);
			}
		str += txt2+ value.substring(textarea.selectionEnd, strlen(value));
	}

	textarea.value = str;
	if(focus!=0){
		selection.setCaret(focus.x, focus.y);
		textarea.focus();
	}
	return false;
}

function emoticon(ele) {
    var textarea = $$('textarea')[0];
	addText(textarea, ' '+(ele.readAttribute('data-code')), ' ');
	return false;
}

function doPreview(){
	new Ajax.Updater('preview', '/'+cmsROOT+'modules/forum/preview/?ajax', {method: 'post', parameters: {post_val: $F('post')}});
	setTimeout(function () { togglePreview(); } , 550);
}
function togglePreview(){
	$('preview', 'post-content').invoke('toggle');
}

document.observe('dom:loaded', function(){
	if(User.IS_ONLINE && $('sortable_forums')){
		Sortable.create('sortable_forums', {scroll:window, tag:'div', handle: 'cat_handle',
			onUpdate: function () {
				updateCats();
			}
		});
	}

	$$('img[data-mode]').each(function(img) {
		img.writeAttribute({'onclick': 'toggleMenu(this.name);'});
	});

	//smilies
	$$('input[data-code][class*=smilie]').each(function(img) {
		img.writeAttribute({'onclick': 'emoticon(this); return false;'});
	});

	//bb buttons
	$$('input[class*=bbButton]').each(function(e){
	    e.writeAttribute({'onclick': 'doBBCode(this); return false;'});
	});


	//make all td's with data-url's on em clickable
	$$('td[data-url]').each(function(ele) {
		var url = ele.readAttribute('data-url');

		if(!empty(url)){
			ele.writeAttribute({
				onclick: 'document.location = "'+url+'";',
				style: 'cursor: pointer'
			});
		}
	});

	if($('qreply')){
		makeReplyForm('qreply');
		/*$$('a[href=#qreply]')[0].observe('click', function(){
			$$('#qreply textarea')[0].focus();
		});*/
	}
});
