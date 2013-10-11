<?php

// Start the engine

require_once(TEMPLATEPATH.'/lib/init.php');


add_action( 'admin_head', 'showhiddencustomfields' );

function showhiddencustomfields() {
    echo "<link rel='stylesheet' media='screen,projection' type='text/css' href='http://renaissancelbl.com/wp-content/themes/goinggreen/admin-custom-file.css'>";
}

// Add new image sizes

add_image_size('Featured Image', 590, 330, TRUE);

add_image_size('Featured Thumb', 100, 100, TRUE);

add_theme_support( 'post-thumbnails' );

set_post_thumbnail_size( 100, 100, true );



if ( function_exists( 'add_theme_support' ) ) {

	add_theme_support( 'post-thumbnails' );

        set_post_thumbnail_size( 100, 100 ); // default Post Thumbnail dimensions   

}





if ( function_exists( 'add_image_size' ) ) { 

	add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)

	add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)

}



add_theme_support('genesis-admin-menu');









remove_filter('get_the_excerpt', 'wp_trim_excerpt');

add_filter('get_the_excerpt', 'new_trim_excerpt');




if (ICL_LANGUAGE_CODE == 'fr')
{ 
		
function new_trim_excerpt($text) {

	$raw_excerpt = $text;

	if ( '' == $text ) {

		$text = get_the_content('');



		$text = strip_shortcodes( $text );



		$text = apply_filters('the_content', $text);

		$text = str_replace(']]>', ']]&gt;', $text);

		

		$text = strip_tags($text, '<p><big><a><small><em><i><b><u><strong>');

		$excerpt_length = apply_filters('excerpt_length', 75);

		$excerpt_more = apply_filters('excerpt_more', ' ' . '<a href="'.get_permalink().'">...Lire suite >>></a>');

		 str_replace('[...]','<a href="'.get_permalink().'">...Lire suite >>></a>', $text);

		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);

		if ( count($words) > $excerpt_length ) {

			array_pop($words);

			$text = implode(' ', $words);

			$text = $text . $excerpt_more;

		} else {

			$text = implode(' ', $words);

		}

	}

	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);

}


 }
 elseif (ICL_LANGUAGE_CODE == 'en')
{ 
 function new_trim_excerpt($text) {

	$raw_excerpt = $text;

	if ( '' == $text ) {

		$text = get_the_content('');



		$text = strip_shortcodes( $text );



		$text = apply_filters('the_content', $text);

		$text = str_replace(']]>', ']]&gt;', $text);

		

		$text = strip_tags($text, '<p><big><a><small><em><i><b><u><strong>');

		$excerpt_length = apply_filters('excerpt_length', 75);

		$excerpt_more = apply_filters('excerpt_more', ' ' . '<a href="'.get_permalink().'">...Read More >>></a>');

		 str_replace('[...]','<a href="'.get_permalink().'">...Read More >>></a>', $text);

		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);

		if ( count($words) > $excerpt_length ) {

			array_pop($words);

			$text = implode(' ', $words);

			$text = $text . $excerpt_more;

		} else {

			$text = implode(' ', $words);

		}

	}

	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);

}

}
















// Add top menu

add_action( 'init', 'register_my_menu' );



function register_my_menu() {

	register_nav_menu( 'top-menu', __( 'Top Menu' ) );

}



// Add footer menu

add_action( 'init', 'register_footer_menu' );



function register_footer_menu() {

	register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );

}



add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');

function custom_footer_creds_text($creds) {

 $creds = '[footer_copyright]' . '&nbsp;' . get_bloginfo('name') . ' &bull;  [footer_loginout]';

 return  $creds;

}





// Add rounded header

add_action('genesis_after_header', 'goinggreen_round_header_graphic'); 

function goinggreen_round_header_graphic() {

    require(CHILD_DIR.'/after-header.php');

}



// Add widgeted footer section

add_action('genesis_before_footer', 'goinggreen_include_footer_widgets'); 

function goinggreen_include_footer_widgets() {

    require(CHILD_DIR.'/footer-widgeted.php');

}



// Register widget areas





genesis_register_sidebar(array(

	'name'=>'Footer #1',

	'description' => 'This is the first column of the footer section.',

	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'

));

genesis_register_sidebar(array(

	'name'=>'Footer #2',

	'description' => 'This is the second column of the footer section.',

	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'

));

genesis_register_sidebar(array(

	'name'=>'Footer #3',

	'description' => 'This is the third column of the footer section.',

	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'

));



// get the the role object

$role_object = get_role( 'editor' );



// add $cap capability to this role object

$role_object->add_cap( 'edit_theme_options' );







 // Unregister other site layouts

genesis_unregister_layout( 'sidebar-content' );

genesis_unregister_layout( 'content-sidebar-sidebar' );

genesis_unregister_layout( 'sidebar-sidebar-content' );

genesis_unregister_layout( 'sidebar-content-sidebar' );





/** Remove secondary sidebar */

unregister_sidebar( 'Homepage' );

unregister_sidebar( 'sidebar-alt' );





// Force layout on category

add_filter('genesis_pre_get_option_site_layout', 'be_category_layout');

function be_category_layout($opt) {

    if ( is_category() || is_archive() )

        $opt = 'content-sidebar';

    return $opt;

}



// Force layout on home

add_filter('genesis_pre_get_option_site_layout', 'be_home_layout');

function be_home_layout($opt) {

    if ( is_home() ) //May also be is_front_page()

        $opt = 'content-sidebar';

    return $opt;

}



  





// Force layout on page documention

add_filter('genesis_pre_get_option_site_layout', 'be_pagedoc_layout');

function be_pagedoc_layout($opt) {

    if ( is_page('documentation') ) //May also be is_front_page()

        $opt = 'content-sidebar';

    return $opt;

}





// Force layout on page documention2

add_filter('genesis_pre_get_option_site_layout', 'be_pagedocs_layout');

function be_pagedocs_layout($opt) {

    if ( is_page('documentation-2') ) //May also be is_front_page()

        $opt = 'content-sidebar';

    return $opt;

}



add_filter('genesis_pre_get_option_site_layout', 'custom_category_layout');

function custom_category_layout($opt) {

    if ( is_category(8) )

    $opt = 'full-width-content';

    return $opt;

}





//  language switcher



add_action('language_header','icl_post_languages');



function icl_post_languages(){

  $languages = icl_get_languages('skip_missing=0');

    if(1 < count($languages)){

    echo __(' ');

        foreach($languages as $l){

            if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['native_name'].'</a>';

        }

      echo join(', ', $langs);





    }

}







//  widget in post [widget widget_name="Your_Custom_Widget"]

function widget($atts) {

    

    global $wp_widget_factory;

    

    extract(shortcode_atts(array(

        'widget_name' => FALSE

    ), $atts));

    

    $widget_name = wp_specialchars($widget_name);

    

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):

        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));

        

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):

            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';

        else:

            $class = $wp_class;

        endif;

    endif;

    

    ob_start();

    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,

        'before_widget' => '<div class="widgetpost">',

        'after_widget' => '</div></div>',

        'before_title' => '',

        'after_title' => ''

    ));

    $output = ob_get_contents();

    ob_end_clean();

    return $output;

    

}

add_shortcode('widget','widget'); 



add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );

 

function my_deregister_javascript() {

   if ( !is_page( array( 100, 189, 799, 917 ) ) ) {

	wp_deregister_script( 'contact-form-7' );
	wp_deregister_script( 'google-map-shortcode' );

     }

}




add_action( 'wp_print_scripts', 'my_deregister_javascriptshow', 100 );



function my_deregister_javascriptshow() {

	if (is_front_page() == 0) {

	wp_deregister_script( 'jquery-ui-effects' );

	}

}





add_action( 'wp_print_styles', 'my_deregister_styles', 100 );



function my_deregister_styles() {

	wp_deregister_style( 'contact-form-7' );

}



function fb_mce_external_languages($initArray){

   $initArray['spellchecker_languages'] = '+French=fr, English=en';

   return $initArray;

    }

  add_filter('tiny_mce_before_init', 'fb_mce_external_languages');





// 'widgets_init' action with a priority of 20.

add_action('widgets_init', 'remove_widgets', 20);

function remove_widgets() {





unregister_widget('WP_Widget_Pages');

    unregister_widget('WP_Widget_Calendar');

    unregister_widget('WP_Widget_Archives');

    unregister_widget('WP_Widget_Links');

    unregister_widget('WP_Widget_Categories');

    unregister_widget('WP_Widget_Recent_Comments');

    unregister_widget('WP_Widget_RSS');

    unregister_widget('WP_Widget_Tag_Cloud');

    unregister_widget('Genesis_eNews_Updates');

    unregister_widget('Genesis_Featured_Page');

    unregister_widget('Genesis_User_Profile_Widget');

    unregister_widget('Genesis_Menu_Pages_Widget');

    unregister_widget('Genesis_Widget_Menu_Categories');



    unregister_widget('Genesis_Latest_Tweets_Widget');

}







// Remove Genesis SEO Options and Settings widget on Edit Post/Page screen

remove_action('admin_menu', 'genesis_add_inpost_seo_box');





remove_theme_support('genesis-inpost-layouts');


/** Remove Genesis menu link */
remove_theme_support( 'genesis-admin-menu' );
/** Remove Genesis SEO Settings menu link */
remove_theme_support( 'genesis-seo-settings-menu' );




add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );






// Define Genesis Options

add_filter('genesis_options', 'define_genesis_setting_custom', 10, 2);

function define_genesis_setting_custom($options, $setting) {

    if($setting == GENESIS_SETTINGS_FIELD) {

        $options['update'] = 1;

   

        $options['content_archive_thumbnail'] = 0;

      

        }

    return $options;

}


add_action( 'wp_print_styles', 'child_add_ie7_style_sheet', 200 );
/**
 * Add a style sheet for IE7 and earlier.
 *
 * @author Gary Jones
 * @link http://dev.studiopress.com/ie-conditional-style-sheets.htm
 */
function child_add_ie7_style_sheet() {
    wp_enqueue_style( 'ie7', CHILD_URL . '/style-ie7.css', array(), '1.0' );
}
 
add_filter( 'style_loader_tag', 'child_make_ie7_style_sheet_conditional', 10, 2 );
/**
 * Add conditional comments around IE style sheet.
 *
 * @author Gary Jones & Michael Fields (@_mfields)
 * @link http://dev.studiopress.com/ie-conditional-style-sheets.htm
 *
 * @param string $tag Existing style sheet tag
 * @param string $handle Name of the enqueued style sheet
 * @return string Amended markup
 */
function child_make_ie7_style_sheet_conditional( $tag, $handle ) {
    if ( 'ie7' == $handle )
        $tag = '<!--[if lte IE 7]>' . "\n" . $tag . '<![endif]-->' . "\n";
    return $tag;
}

?>