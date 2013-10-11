<?php
/**
 * Template Name: Cat
 */
remove_action( 'genesis_loop', 'genesis_do_loop' ); // Remove default loop
//add_action('genesis_post_content','the_content');  // Adds your custom page code/content before loop
add_action( 'genesis_loop', 'category_page' ); // Do custom loop
function category_page() {
    //add_action('genesis_standard_loop');

    child_grid_loop_helper();
   
}
function child_grid_loop_helper() {
    global $paged;
    $cat = 1; // set default category
    if (function_exists('genesis_grid_loop')) {
        if (function_exists('genesis_get_custom_field')){
            $cat = genesis_get_custom_field('category'); // set from custom field when building page
        }

        //*/
        //set non-featured grid_args
        $grid_args_rest = array(
            'features' => 0,
            //'feature_image_size' => 'child_thumb',
            //'feature_image_class' => 'aligncenter post-image',
           'feature_content_limit' => 300,
            //'grid_image_size' => 'child_thumb',
            //'grid_image_class' => 'aligncenter post-image',
            'grid_content_limit' => 450,
            //'more' => '',
            'posts_per_page' => 8,
            'post_type' => 'post',
            'cat' => $cat,
            'paged' => $paged
        );
      //assuming that features won't go beyond 1 page
      // genesis_grid_loop( $grid_args_rest );
     //  /*
        if ( ($grid_args_featured['paged'] > 1) || ($grid_args_past['paged'] > 1) )
            genesis_grid_loop( $grid_args_rest ); //do not show featured after page 1
        else {
          
            genesis_grid_loop( $grid_args_rest );
        }
        //*/
    } else {
        genesis_standard_loop();
    }
}
genesis();