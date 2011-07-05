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

document.observe('dom:loaded', function(){
	//$("select").selectBox();

	if($('clock')){ updateClock(); }
});
