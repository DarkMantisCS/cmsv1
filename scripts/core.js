// Setup the dynamic Grid Sys
var ADAPT_CONFIG = {
  // Where is your CSS?
  path: '/'+cmsROOT+'images/',

  /* false = Only run once, when page first loads.
   * true = Change on window resize and page tilt.
   */
  dynamic: true,

  /* First range entry is the minimum.
   * Last range entry is the maximum.
   * Separate ranges by "to" keyword.
   */
  range: [
    '0px to 760px = grid.mobile.css',
    '760px to 980px = grid.720.css',
    '980px to 1280px = grid.960.css',
    '1280px to 1600px = grid.1200.css',
    '1600px to 1920px = grid.1560.css',
    '1920px = grid.fluid.css'
  ]
};

function updateClock(){
	if(!$('clock')){ return; }
	$('clock').update(date('l H:i:s a', time())).writeAttribute('title', date('jS F Y', time()));
	setTimeout(updateClock, 1000);
}

function inBetween($begin, $end, $contents) {
	$pos1 = strpos($contents, $begin);
	if($pos1 !== false){
		$pos1 += strlen($begin);
		$pos2 = strpos($cotents, $end, $pos1);
		if($pos2 !== false){
			$substr = substr($contents, $pos1, $pos2 - $pos1);
			return $substr;
		}
	}
	return false;
}

function inWindow(url, title, width, height){
    var title = title || '';
    var url = url || '';
    var width = width || 400;
    var height = height || window.viewport.height-200;

    if(empty(url)){
        return false;
    }

      myLightWindow.activateWindow({
    	   href: 	url,
    	   title: 	title,
    	   width: 	width > window.viewport.width ?  window.viewport.width : width,
    	   height: 	height > window.viewport.height ? window.viewport.height : height
      });
    return false;
}

function notify(message, header, sticky){
    growler.growl(message, {
    	header: header || "",
		sticky: Boolean(sticky)
	});
}


window.viewport = {
    height: function() {
        return document.viewport.getHeight();
    },

    width: function() {
        return document.viewport.getWidth();
    },

    scrollTop: function() {
        return $(window).scrollTop();
    },

    scrollLeft: function() {
        return $(window).scrollLeft();
    }
};

ResizeableTextarea = Class.create();
ResizeableTextarea.prototype = {
    initialize: function(element, options) {
        this.element = $(element);
        this.size = parseFloat(this.element.getStyle('height') || '100');
        this.options = Object.extend({
            inScreen: true,
            resizeStep: 10,
            minHeight: this.size
        }, options || {});
        Event.observe(this.element, "keyup", this.resize.bindAsEventListener(this));
        if ( !this.options.inScreen ) {
            this.element.style.overflow = 'hidden';
        }
        this.element.setAttribute("wrap","virtual");
        this.resize();
    },
    resize : function(){
        this.shrink();
        this.grow();
    },
    shrink : function(){
        if ( this.size <= this.options.minHeight ){
            return;
        }
        if ( this.element.scrollHeight <= this.element.clientHeight) {
            this.size -= this.options.resizeStep;
            this.element.style.height = this.size+'px';
            this.shrink();
        }
    },
    grow : function(){
        if ( this.element.scrollHeight > this.element.clientHeight ) {
            if ( this.options.inScreen && (20 + this.element.offsetTop + this.element.clientHeight) > document.body.clientHeight ) {
                return;
            }
            this.size += (this.element.scrollHeight - this.element.clientHeight) + this.options.resizeStep;
            this.element.style.height = this.size+'px';
            this.grow();
        }
    }
}


function catchTab(item, e){
   if(navigator.userAgent.match("Gecko")){ c=e.which; }else{ c=e.keyCode; }

   if(c==9){
       replaceSelection(item,"	"); //basically 1 tab == 4 spaces
       setTimeout("$('"+item.id+"').focus();",0);
       return false;
   }
}

function setSelectionRange(input, selectionStart, selectionEnd) {
    if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    } else if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    }
}

// replace the text area contents with original plus our new TAB
function replaceSelection(input, replaceString) {
   if (input.setSelectionRange) {
       var selectionStart = input.selectionStart;
       var selectionEnd = input.selectionEnd;
       input.value = input.value.substring(0, selectionStart) + replaceString + input.value.substring(selectionEnd);

       if (selectionStart != selectionEnd){
           setSelectionRange(input, selectionStart, selectionStart + replaceString.length);
       }else{
           setSelectionRange(input, selectionStart + replaceString.length, selectionStart + replaceString.length);
       }

   }else if (document.selection) {
       var range = document.selection.createRange();

       if (range.parentElement() == input) {
           var isCollapsed = range.text == '';
           range.text = replaceString;

            if (!isCollapsed)  {
               range.moveStart('character', -replaceString.length);
               range.select();
           }
       }
   }
}

function makeReplyForm(formId){
    formArea = $$('#'+formId)[0];
    txtArea = $$('#'+formId+' textarea')[0];
    sendButton = $$('#'+formId+' #submit')[0];

	var show = function(){
        sendButton.show();
        formArea.addClassName('row_color2');
    }

	var hide = function(){
        if(empty(txtArea.value)){
            sendButton.hide();
        }
        formArea.removeClassName('row_color2');
    }

	txtArea.observe('focus', show);
	txtArea.observe('blur', hide);
	txtArea.observe('init:blur', hide);
	txtArea.fire('init:blur');

    formArea.observe('click', function(){ txtArea.focus(); });
}

function updateDimensions(){
    $$('img[class="bbcode_img"]').each(function (ele){
        var needed = {width: 500};
    	var curImg = $(ele).getDimensions();
    	if(curImg.width > needed.width){
    		var newWidth = 328;
    		var scaleFactor = newWidth/curImg.width;
    		var newHeight = scaleFactor*curImg.height;
    		$(ele).writeAttribute({width: newWidth, height: newHeight});
    		$(ele).wrap('a', {'href': $(ele).readAttribute('src'), 'class': 'lightwindow', 'title': 'Resized Image: Click to open fullscreen'});
    	}
    });
}


document.observe('dom:loaded', function(){
	$$('textarea').each(function (txtarea){
		if(!txtarea.hasClassName('noResize')){
			txtarea.onkeyup = new ResizeableTextarea(txtarea);
		}

		if(!txtarea.hasClassName('noTab')){
			txtarea.writeAttribute('onkeydown', 'return catchTab(this, event)');
		}
    });
    updateDimensions();

	if($('clock')){ updateClock(); }
});
