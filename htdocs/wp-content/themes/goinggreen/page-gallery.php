<?php /*
Template Name: Gallery
*/ ?>
<?php
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); // Removes breadcrumbs
remove_action('genesis_post_title','genesis_do_post_title'); // Removes post title
remove_action('genesis_post_content', 'genesis_do_post_content'); // Removes content
add_action('genesis_post_content', 'child_do_home_content'); // Adds your custom home page code
function child_do_home_content() { ?>

 <?php echo do_shortcode('[gallery columns="4" size="thumbnail" link="file" ]'); ?>


<?php }
?>
<?php genesis(); ?>