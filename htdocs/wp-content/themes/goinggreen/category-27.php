

	
<?php
 
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'custom_loop');
 
function custom_loop() {
global $post;
$args = array ('category_name' => 'Lake Conditions');
query_posts ($args);
?>
 
<h1 class="page-title"><?php
$category = get_the_category();
echo $category[0]->cat_name;
?></h1>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
 
<div class="post type-post hentry">
<h2 class="entry-title"><?php the_title(); ?></h2>
 



	<?php 
$img_id = get_post_meta($post->ID, 'ecpt_risquedebloom', true);
if ($img_id == 'faible') { ?>
    <div class="condition"><img src="http://dotpress.ca/wp-content/uploads/2011/08/okay.png" style="border-style: none"/></div>
<?php } 

elseif ($img_id == 'moyen') { ?>
    <div class="condition"><img src="http://dotpress.ca/wp-content/uploads/2011/08/attention.png" style="border-style: none"/></div>
<?php } 


else { ?>

 <div class="condition"><img src="http://dotpress.ca/wp-content/uploads/2011/08/haut.png" style="border-style: none"/></div>
<?php } 

?>
  <p><?php printf(__('Condition: %s', 'cater_post'),'<strong>' .get_post_meta($post->ID, 'ecpt_statut', true). '</strong>');?><br />
<?php printf(__('Secchi: %s', 'cater_post'),'<strong>' .get_post_meta($post->ID, 'ecpt_secchi', true). '</strong>');?><br />
<?php printf(__('Transparency: %s', 'cater_post'),'<strong>' .get_post_meta($post->ID, 'ecpt_transparence', true). '</strong>');?><br />
<?php printf(__('Temperature: %s', 'cater_post'),'<strong>' .get_post_meta($post->ID, 'ecpt_temperature', true). '</strong>');?><br />
<?php printf(__('Risk of bloom: %s', 'cater_post'),'<strong>' .get_post_meta($post->ID, 'ecpt_risquedebloom', true). '</strong>');?></p>
<div class="prod-list-content">
<?php the_excerpt(); ?>
<div class="frontpage"></div>	
<!-- .prod-list-content -->
 
</div><!-- .entry-summary -->
 
</div><!-- .post -->
 
<?php endwhile; ?>
<?php endif; ?>
 
<?php
}
genesis();
?>
