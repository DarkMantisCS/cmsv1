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
	if(!$('#clock').length){ return; }
	$('#clock').html(date('l H:i:s a', time())).attr('title', date('jS F Y', time()));
	setTimeout(updateClock, 1000);
}

function inBetween($begin, $end, $contents) {
	$pos1 = strpos($contents, $begin);
	if($pos1 !== false){
		$pos1 += strlen($begin);
		$pos2 = strpos($contents, $end, $pos1);
		if($pos2 !== false){
			$substr = substr($contents, $pos1, $pos2 - $pos1);
			return $substr;
		}
	}
	return false;
}

$(document).ready(function(){
	$("select").selectBox();

	if($('#clock')){ updateClock(); }
});








if(jQuery) {
	jQuery(document).ready(function() {
		jQuery.fn.listAttributes = function(prefix) {
			var list = [];
			$(this).each(function() {
				console.info(this.attributes);
				var attributes = [];
				for(var key in this.attributes) {
					if(!isNaN(key)){ continue; }
					if(!prefix || this.attributes[key].name.substr(0, prefix.length) == prefix) {
						attributes.push(this.attributes[key].name);
					}
				}
				list.push(attributes);
			});
			return (list.length > 1 ? list : list[0]);
		}
	});
}