/* tabable v1.0.2
   Allow you to hit the TAB key inside TEXTAREAs.
   Copyright (C) 2011 paul pham <http://aquaron.com/jquery/tabable>

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
$.fn.tabable = function($o) {
	var _o = $.extend({ tab: '  ' + '  ' }, $o);

	return this.filter('textarea').each(function() {
		$(this).bind('keydown', function($e) {
			if ($e.which === 9) {
				var _t = $e.target,
					_top = _t.scrollTop || 0,
					_ss = _t.selectionStart,
					_se = _t.selectionEnd,
					_l = _o.tab.length;

				_t.value = _t.value.slice(0, _ss)
					.concat(_o.tab)
					.concat(_t.value.slice(_ss, _t.value.length));

				if (_ss === _se) {
					_t.selectionStart =
						_t.selectionEnd = _ss + _l;
				} else {
					_t.selectionStart = _ss + _l;
					_t.selectionEnd = _se + _l;
				}

				if (_top !== 0 && _t.scrollTop !== _top) {
					_t.scrollTop = _top;
				}
				return false;
			}
			return true;
		});
		return true;
	});
};
})(jQuery);
