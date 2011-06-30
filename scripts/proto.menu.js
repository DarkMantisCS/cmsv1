/**
 * @description 	A jQuery port of a prototype.js based context menu
 * @orig-author 	Juriy Zaytsev; kangax [at] gmail [dot] com; http://thinkweb2.com/projects/prototype/
 * @ported-by 		xLink; Cybershade.org
 */

(function($){
	$.protoMenu = {};

	$.protoMenu.add = function(params){
		return protoMenu.add(params || {});
	}

	$.protoMenu.options = {
		selector: '.contextmenu',
		className: 'protoMenu',
		pageOffset: 25,
		fade: false,
		zIndex: 100,
		beforeShow: function(){},
		beforeHide: function(){},
		beforeSelect: function(){}
	}

	var protoMenu = {
		e: $.noop(),
		ie: $.browser.msie,

		callbacks: [],
		shim: null,
		container: null,

		add: function(params){
			if(!params.selector || !params.className || !params.menuItems){
				throw 'You need to fill out the first 3 params: "selector", "className" and "menuItems"';
			}
			$.protoMenu.options = jQuery.extend($.protoMenu.options, params);

			protoMenu.shim = jQuery('<iframe/>', {
				style: 'position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);display:none',
				src: 'javascript:false;',
				frameborder: 0
			});

			protoMenu.container = jQuery('<div/>', {
				class: $.protoMenu.options.className,
				style: 'display:none'
			});

			var list = jQuery('<ul/>');
			$.each($.protoMenu.options.menuItems, function(i, item) {
				protoMenu.callbacks[i] = item.callback;
				list.append(jQuery('<li/>', {class: (item.separator ? 'separator' : '')}).append(
					item.separator
						? ''
						: jQuery('<a/>', {
							href: '#',
							title: item.name,
							'class': (item.className || '') + (item.disabled ? ' disabled' : ' enabled'),
							'data-id': i
						  }).bind('click', function(e){ protoMenu.onClick(e); })
							.bind('contextmenu', function() { return false; })
							.text(item.name)
				)
			)});
			$(document.body).append(this.container.append(list));
			if(this.ie){ $(document.body).append(protoMenu.shim) }

			$(document).click(function(e){
				if($(protoMenu.container).is(':visible') && e.which!=3){
					$.protoMenu.options.beforeHide(e);
					if(this.ie){ $(protoMenu.shim).hide(); }
					$(protoMenu.container).hide();
				}
			});

			$($.protoMenu.options.selector).mousedown(function(e){
				var click = $.browser.opera ? 1 : 3;

				if(e.which == click){
					if($.browser.opera && !e.ctrlKey) { return; }
					console.log($.browser, $.browser.opera, e.ctrlKey);
					protoMenu.show(e);
				}
			});


			$($.protoMenu.options.selector).bind('contextmenu', function() { return false; });
		},

		show: function(e){
			e.preventDefault();
			e.stopPropagation();

			$.protoMenu.options.beforeShow(e);
			var x = e.clientX;
			var y = e.clientY;
			var vpOff = {'top': viewport.scrollTop()};
			var vpDim = {'height': viewport.height(), 'width': viewport.width()};
			var elDim = {'height': $(protoMenu.container).height(), 'width': $(protoMenu.container).width()};
			var elOff = {
				left: (((x + elDim.width + $.protoMenu.options.pageOffset) > vpDim.width
							? (vpDim.width - elDim.width - $.protoMenu.options.pageOffset) : x)+1) + 'px',
				top: (((y - vpOff.top + elDim.height) > vpDim.height && (y - vpOff.top) > elDim.height
							? (y - elDim.height) : y)+1) + 'px'
			};

			protoMenu.container.css(elOff).css({zIndex: $.protoMenu.options.zIndex});
			if(protoMenu.ie) {
				$(protoMenu.shim).css(jQuery.extend(jQuery.extend(elDim, elOff), {zIndex: $.protoMenu.options.zIndex - 1})).show();
			}
			$(protoMenu.container).show();
			this.event = e;
		},

		onClick: function(e){
			e.preventDefault();
			e.stopPropagation();

			var id = $(e.target).attr('data-id');
			var callback = protoMenu.callbacks[id];
			if(typeof callback != undefined
				&& !$(e.target).hasClass('disabled')){

				$.protoMenu.options.beforeSelect(e);
				if(protoMenu.ie){ $(protoMenu.shim).hide(); }
				$(protoMenu.container).hide();
				callback(this.event);
			}

		}
	}
})(jQuery);