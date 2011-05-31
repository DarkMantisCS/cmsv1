/* autoselect v1.1
   Similar to SELECT box but uses jQuery's Autocomplete.
   Copyright (C) 2011 paul pham <http://aquaron.com/jquery/autoselect>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
(function($) {
$.fn.autoselect = function($o) {
	var _o = $.extend({
		default: '',
		clearUnmatched: true,
		staticList: true
	}, $o);

	return this.each(function() {
		var _ob = $(this);

		_ob.autocomplete({
			minLength: 0,
			source: _o.source,
			select: function($e, $ui) {
				this.value = $ui.item.value;
				if ($.isFunction(_o.callback)) {
					_o.callback($e, $ui);
				}
				return false;
			}
		})
		.bind('autocompleteopen focus keypress', function($e) {
			switch ($e.type) {
				case !$(this).autocomplete('widget').is(':visible') &&
					  _o.staticList &&
				'focus':
					$(this).val(_o.default)
						   .autocomplete('search', _o.default);
					_o.staticList = false;
					break;

				case 'autocompleteopen':
					var _menu = $(this).data('autocomplete').menu;
					_menu.activate(
						$.Event({ type: 'mouseenter' }),
						_menu.element.children().first()
					);
					break;

				case !$(this).autocomplete('widget').is(':visible') &&
					  $e.which === 13 &&
				'keypress':
					if (_o.clearUnmatched) {
						$(this).val('');
					}
					return false;
			}
		});

		return true;
	});
};
}(jQuery));
