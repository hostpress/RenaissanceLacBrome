(function ($) {

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
	if (typeof value != 'undefined') { // name and value given, set cookie
		options = options || {};
		if (value === null) {
			value = '';
			options.expires = -1;
		}
		var expires = '';
		if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
				date = new Date();
				date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
			} else {
				date = options.expires;
			}
			expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
		}
		// CAUTION: Needed to parenthesize options.path and options.domain
		// in the following expressions, otherwise they evaluate to undefined
		// in the packed version for some reason...
		var path = options.path ? '; path=' + (options.path) : '';
		var domain = options.domain ? '; domain=' + (options.domain) : '';
		var secure = options.secure ? '; secure' : '';
		document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	} else { // only name given, get cookie
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				// Does this cookie string begin with the name we want?
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}
};
/**
 * Font Resizer Function
 */
function Fontresizer (settings) {
	var that = this;

	// Ticker Settings
	that.settings = that.validate_settings(settings);

	if (that.settings) {

		/*
		 * 1. Create Ticker Skeleton
		 */
		that.ticker = that.createTicker();

		/*
		 * 2. Insert the Ticker
		 */
		that.insert_ticker();

		/*
		 * 3. Load Ticker Style
		 */
		that.load_style();

		/*
		 * 4. Load Ticker Configuration
		 */
		that.load_config();

		/*
		 * 5. Load Ticker Events
		 */
		that.load_events();

	}
}

/*
 * Does some validation on the settings
 */
Fontresizer.prototype.validate_settings = function(set) {
	/*
	 * 1. Affected Elements
	 */
	if (set.affected_elements === '') {
		set.affected_elements = set.html_elements;
	}
	/*
	 * 2. Initial Size
	 */
	if (set.initial_size === '' || set.initial_size === 0) {
		set.initial_size = parseInt($(set.html_elements).css('font-size'),10);
	}
	// Line Height
	set.line_height = parseInt($(set.html_elements).css('line_height'), 10);
	/*
	 * 3. Increment
	 */
	if (set.increment === '') {
		set.increment = 3;
	}
	/*
	 * 4. Min/Max Size
	 */
	if (set.min_size === '') {
		set.min_size = 10;
	}
	if (set.max_size === '') {
		set.max_size = 35;
	}
	/*
	 * 5. Cookies duration
	 */
	if (set.cookies_duration === '' || parseInt(set.cookies_duration,10) === NaN) {
		set.cookies_duration = 15;
	}
	/*
	 * 6. HTML Elements
	 */
	if (!$(set.html_elements).length) {
		set = false;
	}
	return set;
};
/*
 * 1. Create Ticker Skeleton
 */
Fontresizer.prototype.createTicker = function() {
	/* Container DIVs */
	var $container_div = $('<div></div>', {
		id:'fontresizer_container'
	});

	var $larger_div = $('<div></div>', {
		id:'fontresizer_larger'
	});
	var $smaller_div = $('<div></div>', {
		id:'fontresizer_smaller'
	});

	/* Merge Smaller and Larger */
	$container_div.append($larger_div).append($smaller_div);

	/* Return the Ticker skeleton */
	return $container_div;
};
/*
 * 2. Insert the Ticker in the page
 */
Fontresizer.prototype.insert_ticker = function() {
	var that = this;
	$(that.settings.html_elements).append(that.ticker);
};
/*
 * 3. Load Ticker Style
 */
Fontresizer.prototype.load_style = function() {
	var head = $('head');
	var that = this;

	/*
	 * Load the CSS File
	 */
	var css = document.createElement('link');
	css.type = 'text/css';
	css.rel = 'stylesheet';
	css.href = that.settings.src_dir + 'client/styles/' + that.settings.ticker_style + '/style.css';
	head.append(css);

	/*
	 * Load the JavaScript File
	 */
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = that.settings.src_dir + 'client/styles/' + that.settings.ticker_style + '/style.js';
	head.append(script);
};
/*
 * 4. Load Ticker configuration
 */
Fontresizer.prototype.load_config = function() {
	var that = this;
	/*
	 * Cookie Management
	 */
	if($.cookie('font-resizer') && $.cookie('font-resizer-line')) {
		/*
		 * Load the initial size from the cookie
		 */
		that.settings.initial_size = that.cookie.load().fontsize;
		that.settings.line_height = that.cookie.load().lineheight;
	} else {
		/*
		 * Create the cookie
		 */
		that.cookie.save(that.settings.initial_size, that.settings.line_height, that.settings.cookies_duration);
	}
	/*
	 * Load the initial size and line height
	 */
	if (that.settings.initial_size != 0) {
		$(that.settings.affected_elements).css('font-size', that.settings.initial_size + 'px');
		$(that.settings.affected_elements).css('line-height', that.settings.line_height + 'px');
	}
}
/*
 * 5. Load Ticker Events
 */
Fontresizer.prototype.load_events  = function() {
	var that = this;
	var el = $(that.settings.affected_elements);

	/*
	 * A+ Button
	 */
	$('#fontresizer_larger_button').live('click', function() {
		if (that.settings.max_size > fontsize()) {
			var line_height = parseInt(el.css('line-height'), 10);
			// Increment Font Size
			el.css('font-size', (fontsize()+parseInt(that.settings.increment,10)) + 'px');
			// Adjust Line Height
			el.css('line-height', (line_height+parseInt(that.settings.increment,10)) + 'px');
			// Memorize the values
			that.cookie.save(fontsize(),  parseInt(el.css('line-height'), 10));
		}
			return false;
	});
	/*
	 * A- Button
	 */
	$('#fontresizer_smaller_button').live('click', function() {
		if (that.settings.min_size < fontsize()) {
		var line_height = parseInt(el.css('line-height'), 10);
		// Increment Font Size
		el.css('font-size', (fontsize()-parseInt(that.settings.increment,10)) + 'px');
		// Adjust Line Height
		el.css('line-height', (line_height-parseInt(that.settings.increment,10)) + 'px');
		// Memorize the values
		that.cookie.save(fontsize(),  parseInt(el.css('line-height'), 10));
		}
		return false;
	});
	/*
	 * Reset Button
	 */
	$('#fontresizer_reset_button').live('click', function() {
		el.css('font-size', that.settings.initial_size + 'px');
		that.cookie.save(fontsize(), that.settings.duration);
		return false;
	});
	/*
	 * return the current font size
	 */
	function fontsize() {
		var size = parseInt(el.css('font-size'),10);
		if (isNaN(size) || size == 0) {
			size = that.settings.initial_size;
		}
		return size;
	}

}
/*
 * Cookies management
 */
Fontresizer.prototype.cookie = {
	load : function() {
		return {
			fontsize:parseInt($.cookie('font-resizer'),10),
			lineheight:parseInt($.cookie('font-resizer-line'))
		}
	},
	save : function(size, line_height) {
		if (fontresizer_settings.enable_cookies === '1') {
			$.cookie('font-resizer', size, {
				expires : parseInt(fontresizer_settings.cookies_duration, 10)
			});
			$.cookie('font-resizer-line', line_height, {
				expires : parseInt(fontresizer_settings.cookies_duration, 10)
			});
		}
	}
}
$(document).ready( function() {
	var ticker = new Fontresizer(fontresizer_settings);
});
})(jQuery);
