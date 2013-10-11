<?php
/*
Plugin Name: Lake Category Posts Widget
Plugin URI: http://jameslao.com/2011/03/24/category-posts-widget-3-2/
Description: Adds a widget that can display posts from a single category.
Author: James Lao	
Version: 3.2
Author URI: http://jameslao.com/
*/

// Register thumbnail sizes.

class CategoryPosts extends WP_Widget {

function CategoryPosts() {
	parent::WP_Widget(false, $name='Category Posts');
}

function my_css() {
echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') .'/wp-content/plugins/lake-category-posts/cat-posts.css" />' . "\n";
}

/**
 * Displays category posts widget on blog.
 */
function widget($args, $instance) {
	global $post;
	$post_old = $post; // Save the post object.
	
	extract( $args );
	

	
	// If not title, use the name of the category.
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
  }

  $valid_sort_orders = array('date', 'title', 'comment_count', 'random');
  if ( in_array($instance['sort_by'], $valid_sort_orders) ) {
    $sort_by = $instance['sort_by'];

  } else {
    // by default, display latest first
    $sort_by = 'date';
    $sort_order = 'DESC';
  }
	
	// Get array of post info.
  $cat_posts = new WP_Query(
    "showposts=" . 1 . 
    "&cat=" . 12 .
    "&orderby=" . $sort_by

  );

	// Excerpt length filter
	$new_excerpt_length = create_function('$length', "return " . $instance["excerpt_length"] . ";");
	if ( $instance["excerpt_length"] > 0 )
		add_filter('excerpt_length', $new_excerpt_length);
	
	echo $before_widget;
	

	
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
		
	?>
	
<div class="conditions">			
			
	

				<?php 
$img_id = get_post_meta($post->ID, 'graphic', true);
if ($img_id == 'Avis') { ?>
    <div class="condition"><img src="/wp-content/plugins/lake-category-posts/images/secchi_avis.png" /></div>
<?php } 

elseif ($img_id == 'Jaune') { ?>
    <div class="condition"><img src="/wp-content/plugins/lake-category-posts/images/secchi_jaune1.png" /></div>
<?php } 

elseif ($img_id == 'Rouge') { ?>
    <div class="condition"><img src="/wp-content/plugins/lake-category-posts/images/secchi_warning1.png" /></div>
<?php } 

else { ?>

 <div class="condition"><img src="/wp-content/plugins/lake-category-posts/images/secchi_ok1.png" /></div>
<?php } 

?>		
			
			
<h4 id="conditions-title"><?php the_title(); ?></h4>				
			



<?php
  // Get the original post ID (in my case the english one)
  $o_ID = icl_object_id($post->ID, 'post', true, 'en'); ?>
<?php if (ICL_LANGUAGE_CODE == 'fr')
{ ?>
 
<p><?php echo('Statut:'), '<br />' .'<strong>' .get_post_meta($post->ID, 'status', true). '</strong>';?></p>
<p><?php echo('Secchi: '),'<strong>' .get_post_meta($post->ID, 'secchi', true). '</strong>';?></p>
<p><?php echo('Transparence: '),'<strong>' .get_post_meta($post->ID, 'transparency', true). '</strong>';?></p>
<p><?php echo('Temp&eacute;rature: '),'<strong>' .get_post_meta($post->ID, 'temperature', true). '</strong>';?></p>
<p><?php echo('Risque de bloom: '),'<strong>' .get_post_meta($post->ID, 'bloom', true). '</strong>';?></p>
<p class="wrap"><?php echo('Commentaires: '),'<strong>' .get_post_meta($post->ID, 'lakecomments', true). '</strong>';?></p>

<?php }
 elseif (ICL_LANGUAGE_CODE == 'en')
{ ?>


<p><?php echo('Condition:'), '<br />' .'<strong>' .get_post_meta($post->ID, 'status', true). '</strong>';?></p>
<p><?php echo('Secchi: '),'<strong>' .get_post_meta($post->ID, 'secchi', true). '</strong>';?></p>
<p><?php echo('Transparency: '),'<strong>' .get_post_meta($post->ID, 'transparency', true). '</strong>';?></p>
<p><?php echo('Temperature: '),'<strong>' .get_post_meta($post->ID, 'temperature', true). '</strong>';?></p>
<p><?php echo('Risk of bloom: '),'<strong>' .get_post_meta($post->ID, 'bloom', true). '</strong>';?></p>
<p class="wrap"><?php echo('Comments: '),'<strong>' .get_post_meta($post->ID, 'lakecomments', true). '</strong>';?></p>

<?php }

?>
			<?php if ( $instance['excerpt'] ) : ?>
			
<br />
<div class="liens">	
<?php if (ICL_LANGUAGE_CODE == 'fr')
{ ?>	
<a href="http://renaissancelbl.com/conditions-actuelles-du-lac/">&nbsp; Plus sur les conditions actuelles >>></a><br />
<a href="http://renaissancelbl.com/historiques-des-conditions-du-lac/">&nbsp; Plus sur l&rsquo;historique des conditions >>></a>
<?php }
 elseif (ICL_LANGUAGE_CODE == 'en')
{ ?>
 <a href="http://renaissancelbl.com/en/lake-conditions-at-the-present-time/">&nbsp; More about present conditions >>></a><br />
<a href="http://renaissancelbl.com/en/history-of-lake-conditions/">&nbsp; See the history of lake conditions >>></a>
<?php }

?>

	</div>	
</div>	
				<?php endif; ?>
			
			<?php if ( $instance['comment_num'] ) : ?>
			<p class="comment-num">(<?php comments_number(); ?>)</p>
			<?php endif; ?>
		
	<?php
	}
	

	
	echo $after_widget;

	remove_filter('excerpt_length', $new_excerpt_length);
	
	$post = $post_old; // Restore the post object.
}


/**
 * The configuration form.
 */
function form($instance) {
?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		
		
		<p>
			<label for="<?php echo $this->get_field_id("num"); ?>">
				<?php _e('Number of posts to show'); ?>:
				<input style="text-align: center;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo absint($instance["num"]); ?>" size='3' />
			</label>
    </p>

    <p>
			<label for="<?php echo $this->get_field_id("sort_by"); ?>">
        <?php _e('Sort by'); ?>:
        <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
          <option value="date"<?php selected( $instance["sort_by"], "date" ); ?>>Date</option>
          <option value="title"<?php selected( $instance["sort_by"], "title" ); ?>>Title</option>
          <option value="comment_count"<?php selected( $instance["sort_by"], "comment_count" ); ?>>Number of comments</option>
          <option value="random"<?php selected( $instance["sort_by"], "random" ); ?>>Random</option>
        </select>
			</label>
    </p>
		
		<p>
			<label for="<?php echo $this->get_field_id("asc_sort_order"); ?>">
        <input type="checkbox" class="checkbox" 
          id="<?php echo $this->get_field_id("asc_sort_order"); ?>" 
          name="<?php echo $this->get_field_name("asc_sort_order"); ?>"
          <?php checked( (bool) $instance["asc_sort_order"], true ); ?> />
				<?php _e( 'Reverse sort order (ascending)' ); ?>
			</label>
    </p>

		<p>
			<label for="<?php echo $this->get_field_id("title_link"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("title_link"); ?>" name="<?php echo $this->get_field_name("title_link"); ?>"<?php checked( (bool) $instance["title_link"], true ); ?> />
				<?php _e( 'Make widget title link' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("excerpt"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"], true ); ?> />
				<?php _e( 'Show post excerpt' ); ?>
			</label>
		</p>
		
		
		
	
		
		<p>
			<label for="<?php echo $this->get_field_id("date"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
				<?php _e( 'Show post date' ); ?>
			</label>
		</p>
		


<?php

}

}

add_action( 'widgets_init', create_function('', 'return register_widget("CategoryPosts");') );

?>
