/* vertigro v1.2.2
   Automatically grow your textarea vertically.
   Copyright (C) 2011 paul pham <http://aquaron.com/jquery/vertigro>

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
$.fn.vertigro = function($max, $div) {
	var _uncountlinks = function($text) {
		var _parts = $text.split(' '), _sum = 0;
		$.each(_parts, function() {
			if (this.substr(0, 7) === 'http://') {
				_sum += this.length;
			}
		});
		return _sum;
	};
	var _grow = function($e) {
		if ($max && $div) {
			if ($(this).val().length > $max && $e.which !== 8) {
				var _len = _uncountlinks($(this).val());
				$max = $(this).data('max') + _len;
				return false;
			}
			$($div).html($max - $(this).val().length);
		} else if (
			($max && this.clientHeight >= $max) ||
				this.scrollHeight > $(window).height() - 250) {

			if ($(this).data('maxreached')) {
				return true;
			}

			$(this)
				.data('maxreached', true)
				.css('overflow', 'auto')
				.height($(window).height() - 250);

			return false;
		}

		var _h =
			parseInt($(this).css('lineHeight').replace(/px$/, ''), 10) ||
			20;

		if (this.clientHeight < this.scrollHeight) {
			$(this).height(this.scrollHeight + _h);
		}
	};
	return this.filter('textarea').each(function() {
		$(this)
			.data('max', $max || 0)
			.css('overflow', 'hidden')
			.bind('keydown keyup change', _grow);

		return true;
	});
};
})(jQuery);
