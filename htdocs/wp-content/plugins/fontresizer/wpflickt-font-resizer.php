<?php
/*
 Plugin Name: Font Resizer - Easy Font Resizing for WordPress
 Plugin URI: http://wpflickt.com/fontresizer
 Description: Font Resizer allows visitors to resize their fonts and remember their choices.
 Author: Abid Omar
 Version: 1.2
 */

/*
 * Plug-in Class Holder
 */
if(!class_exists('wpfontresizer')) {
	class wpfontresizer {
		/*
		 * Plug-in Variables
		 */
		public $version = "1.2";
		public $wp_version = "3.0";

		/*
		 * Class Constructor
		 */
		function __construct() {
			/*
			 * 1. Plug-in requirements
			 */
			if($this -> check_requirements() === false) {
				return ;
			}

			/*
			 * 2. Declare Constants and load dependencies
			 */
			$this -> define_constants();

			/*
			 * 3. Admin Panel
			 */
			$this -> admin_panel();

			/*
			 * 4. Hooks
			 */
			register_activation_hook($this -> plugin_name, array(&$this, 'activate'));
			register_deactivation_hook($this -> plugin_name, array(&$this, 'deactivate'));
			register_uninstall_hook($this -> plugin_name, wpfontresizer::uninstall());

			/*
			 * 5. Actions
			 */
			if (!is_admin()) {
				add_action('plugins_loaded', array(&$this, 'start'));
			}
		}

		/*
		 * Checks if the WordPress Setup complies with the plug-in requirements
		 */
		function check_requirements() {
			global $wp_version;
			if(!version_compare($wp_version, $this -> wp_version, '>=')) {
				add_action('admin_notices', create_function('', 'global $wpfototag; printf (\'<div id="message" class="error"><p><strong>\' . __(\'Sorry, Font-Resizer requires WordPress %s or higher\', "font-resizer" ) . \'</strong></p></div>\', $wpfontresizer->wp_version );'));
				return false;
			}
			return true;
		}

		/*
		 * Define Global Constants for the plug-in
		 */
		function define_constants() {
			/* Plug-in Base Name [wpflickt-font-resizer/wpflickt-font-resizer.php] */

			$this -> plugin_name = plugin_basename(__FILE__);
			/* Base Plug-in URI [F:\dev\font-resizer\wp-content\plugins\wpflickt-font-resizer]*/
			$this -> dir = dirname(__FILE__);

			/*
			 * Define Global Paths
			 */
			/* [wpflickt-font-resizer] */
			define('FONTRESIZER_FOLDER', plugin_basename(dirname(__FILE__)));
			/* [F:/dev/font-resizer/wp-content/plugins/wpflickt-font-resizer/] */
			define('FONTRESIZER_ABSPATH', trailingslashit(str_replace("\\", "/", WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)))));
			/* [http://localhost/font-resizer/wp-content/plugins/wpflickt-font-resizer/] */
			define('FONTRESIZER_URLPATH', trailingslashit(WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__))));
			/* [http://localhost/font-resizer/wp-admin/] */
			define('FONTRESIZER_ADMINPATH', get_admin_url());
			//

		}

		/*
		 * Admin Panel
		 */
		function admin_panel() {
			if(is_admin()) {
				/* Creates an instance of the Admin Panel Class */
				require_once ($this -> dir . '/admin/admin.php');
				$this -> AdminPanel = new fontresizerAdminPanel();
			}
		}

		/*
		 * Plug-in Setup Hooks
		 */

		/* Activate Plug-in */
		function activate() {
			/* Check if the plug-in is running for the first time */
			if(!get_option('fontresizer_installed')) {
				/* Set the Default Settings Value */
				$settings = array('html_elements' => 'BODY', 'affected_elements' => 'BODY', 'ticker_style' => 'default', 'initial_size' => 0, 'increment' => 3, 'min_size'=>10, 'max_size'=>35, 'enable_cookies' => true, 'cookies_duration' => 30);
				add_option('fontresizer_settings', $settings);

				/* Set the Default Styles */
				$styles = array('default', 'minim', 'press');
				add_option('fontresizer_styles', $styles);

				/* Plug-in Installed */
				update_option('fontresizer_installed', true);
			}
		}

		/* Deactivate Plug-in */
		function deactivate() {

		}

		/* Uninstall Plug-in */
		public static function uninstall() {
			delete_option('fontresizer_installed');
		}

		/*
		 * Start the Plug-in
		 */
		function start() {
			/*
			 * Load JS and CSS files
			 */
			wp_enqueue_script('fontresizer-core', FONTRESIZER_URLPATH . 'client/core.js', array('jquery'), '1.4.0');
			wp_enqueue_style('fontresizer-style', FONTRESIZER_URLPATH . 'client/style.css');

			/*
			 * Load Plug-in Configuration to JavaScript
			 */
			$settings = get_option('fontresizer_settings');
			$settings['src_dir'] = FONTRESIZER_URLPATH;
			wp_localize_script('fontresizer-core', 'fontresizer_settings', $settings);
		}

	}

}

/*
 * Start the plug-in
 */
global $wpfontresizer;
$wpfontresizer = new wpfontresizer();
?>