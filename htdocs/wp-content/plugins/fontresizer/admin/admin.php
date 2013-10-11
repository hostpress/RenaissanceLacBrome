<?php
/* Conflicts with other plugins
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('You are not allowed to call this page directly.');
}
*/

/*
 * Admin Panel Class
 */
if(!class_exists('fontresizerAdminPanel')) {
	class fontresizerAdminPanel {
		/*
		 * Constructor Function
		 */
		function __construct() {

			/*
			 * 1. Admin Menu
			 */
			add_action('admin_menu', array(&$this, 'add_menu'));

			/*
			 * 2. Load Scripts and Styles
			 */
			add_action('admin_print_scripts', array(&$this, 'load_scripts'));
			add_action('admin_print_styles', array(&$this, 'load_styles'));

			/*
			 * 3. Contextual Help
			 */
			//add_filter('contextual_help', array(&$this, 'showhelp'), 10, 3);
		}

		/*
		 * Admin Menu functionality
		 */
		function add_menu() {
global $fontresizer_admin_page;
			$fontresizer_admin_page = add_submenu_page('options-general.php', 'Font Resizer || Settings', 'Font Resizer', 'manage_options', 'fontresizer-settings', array(&$this, 'settings_page'));
add_action("load-$fontresizer_admin_page", array(&$this, 'showhelp'));
		}

		/*
		 * Load CSS files
		 */
		function load_styles() {
			wp_enqueue_style('font-resizer-admin', FONTRESIZER_URLPATH . 'admin/files/style.css', array());
		}

		/*
		 * Load JavaScript files
		 */
		function load_scripts() {
			wp_enqueue_script('font-resizer-admin', FONTRESIZER_URLPATH . 'admin/files/core.js', array('jquery'), '1.4.0');
			//wp_enqueue_script('font-resizer-jquery-addon', FONTRESIZER_URLPATH . 'admin/files/jquery.tools.min.js', array('jquery'), '1.4.0');
		}

		/*
		 * Admin Settings Page
		 */
		function settings_page() {
			/*
			 * Save the POST Form
			 */
			if(isset($_POST['submit'])) {
				/* 1. Format the Data */
				$_POST['ticker_style'] = strtolower($_POST['ticker_style']);
				if($_POST['initial_size'] == 'Default') {
					$_POST['initial_size'] = 0;
				}
				if($_POST['enable_cookies'] == 'on') {
					$_POST['enable_cookies'] = true;
				} else {$_POST['enable_cookies'] = false;
				}
				$_POST['increment'] = (int)$_POST['increment'];
				$_POST['min_size'] = (int)$_POST['min_size'];
				$_POST['max_size'] = (int)$_POST['max_size'];
				$_POST['cookies_duration'] = (int)$_POST['cookies_duration'];
				unset($_POST['submit']);

				/* 2. Update the Settings */
				update_option('fontresizer_settings', $_POST);
			}

			/* 1. Load the plug-in settings */
			$settings = get_option('fontresizer_settings', array('html_elements' => 'BODY', 'affected_elements' => 'BODY', 'ticker_style' => 'default', 'initial_size' => 0, 'increment' => 3, 'max_size'=>10, 'min_size'=>35, 'enable_cookies' => true, 'cookies_duration' => 30));
			$html_elements = $settings['html_elements'];
			$ticker_style = $settings['ticker_style'];
			$affected_elements = $settings['affected_elements'];
			$initial_size = $settings['initial_size'];
			$increment = $settings['increment'];
			$min_size = $settings['min_size'];
			$max_size = $settings['max_size'];
			$enable_cookies = $settings['enable_cookies'];
			$cookies_duration = $settings['cookies_duration'];

			/* 2. Load the Plug-in Styles */
			$styles = get_option('fontresizer_styles', array('default', 'minim', 'press'));
			$styles_html = "";
			foreach($styles as $style) {
				if($style == $ticker_style) {
					$styles_html .= "<option selected='true'>" . ucfirst($style) . "</option>";
				} else {
					$styles_html .= "<option>" . ucfirst($style) . "</option>";
				}
			}

			/* 3. Adjust some settings for the HTML Form */
			if($initial_size == 0) {
				$initial_size = "Default";
			}
			if($enable_cookies == true) {
				$enable_cookies = "checked='true'";
			} else {
				$enable_cookies = "";
			}
			/*
			 * Admin Folder
			 */
			$tip_icon_src = FONTRESIZER_URLPATH . 'admin/files/images/tip.png';
			/*
			 * HTML Page
			 */
			echo <<<END
<div class="wrap" id="font-resizer">
<div id="icon-options-general" class="icon32">
</div>
<h2>
Font Resizer Settings
</h2>
<form name="form" method="POST">
<h3>Font-Resizer Ticker</h3>
<p>Select the locations where you want the Font Resizer ticker to be inserted.</p>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
HTML Elements
</th>
<td>
<input type="text" name="html_elements" id="html_elements" value="$html_elements" title="this is a test" />
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
</tbody>
</table>
<h3>Ticker Style</h3>
<p>Select the appearence style of the font resizer ticker.</p>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
Style
</th>
<td>
<select name="ticker_style" id="ticker_style">
$styles_html
</select>
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
</tbody>
</table>
<h3>Size Settings</h3>
<p>Select the affected elements, the initial size and the increment step.</p>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
Affected Elements
</th>
<td>
<input type="text" name="affected_elements" id="affected_elements" value="$affected_elements"/>
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
<tr valign="top">
<th scope="row">
Initial Size
</th>
<td>
<input type="text" name="initial_size" id="initial_size" value="$initial_size"/>
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
<tr valign="top">
<th scope="row">
Increment
</th>
<td>
<input type="text" name="increment" id="increment" value="$increment"/> px
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
<tr valign="top">
<th scope="row">
Max Resize
</th>
<td>
Min <input type="text" name="min_size" id="min_size" value="$min_size" style="width:30px;"/> px | Max <input type="text" name="max_size" id="max_size" value="$max_size" style="width:30px;"/> px
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
</tbody>
</table>
<h3>Cookies</h3>
<p>Memorizes the user font size.</p>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">
Enable cookies
</th>
<td>
<input type="checkbox" name="enable_cookies" id="enable_cookies" $enable_cookies> Enabled</input>
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
<tr valign="top">
<th scope="row">
Duration
</th>
<td>
<input type="text" name="cookies_duration" id="cookies_duration" value="$cookies_duration"> days</input>
</td>
<td>
<!-- <img src="$tip_icon_src" class="form_tip" id="html_elements_tip"/> -->
</td>
</tr>
</tbody>
</table>
<p class="submit">
<input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes" />
</p>
</form>
</div>
END;
		}

		/*
		 * Help
		 */
		function showhelp() {
  global $fontresizer_admin_page;
    $screen = get_current_screen();

    /*
     * Check if current screen is My Admin Page
     * Don't add help tab if it's not
     */
    if ( $screen->id != $fontresizer_admin_page )
        return;

    // Add my_help_tab if current screen is My Admin Page
    $screen->add_help_tab( array(
        'id'	=> 'my_help_tab',
        'title'	=> 'Usage',
        'content'	=> "
<h3>Font Resizer Settings</h3>
<h4>Font-Resizer Ticker</h4>
<p>Font Resizer can insert a ticker automatically for you. You just need to know the element ID or Class, so that Font Resizer can detect it. Use \"#\" for elements ID and \".\" for elements classes. You can add the ticker to different elements, seperate them with a comma \",\".</p>
<p>For example, to insert the ticker inside a DIV with an ID of \"content-post\" and another one with a class name of \"comment-post\" use</p>
<pre>
#content-post, .comment-post
</pre>
<h4>Ticker Style</h4>
<p>Font Resizer supports a variety of styles. You can select only one style for all the tickers to be inserted.</p>
<p>It's possible to customize styles so they integrate well with your template. For more information, look at the Plug-in documentation.</p>
<h4>Size Settings</h4>
<ul>
<li><strong>Affected Elements</strong>: For flexibilty, Font Resizer can resize specific elements in your page. This is useful if you want to resize different divisions. If left blank, Font-Resizer will resize elements where the Ticker is placed.</li>
<li><strong>Initial Size</strong>: The initial size of the affected element. Default will leave the initial size inchanged.</li>
<li><strong>Increment</strong>: The increment step of the Ticker. (in Pixels)</li>
<li><strong>Max Size</strong>: This allows to limit the resizing of the text. Sepecify the minimum and maximum value.</li>
</ul>
<h4>Cookies</h4>
<p>Cookies memorize the user font size inside a browser cookie. This is useful so that the user doesn't have to resize the font again and work on all pages in your blog. You can enable/disable this feature and also specifiy the validity of the cookies (in Days).</p>
"
    ) );
		}

	}

}
?>
