<?php get_header(); ?>



<?php do_action( 'genesis_before_content_sidebar_wrap' ); ?>

<div id="content-sidebar-wrap">



	<?php do_action( 'genesis_before_content' ); ?>

	

	<div id="content" class="hfeed">		

		<div class="featured-home">

	<?php

// added by <yourname here> in order to add the slideshow using the frontpage-slideshow plugin

echo do_shortcode('[FrontpageSlideshow fs_cats=6 fs_slides=3 fs_main_width=600px fs_main_height=192px fs_slide_width=425px fs_buttons_width=175px fs_placeholder_height=145px fs_button_normal_color=transparent fs_button_hover_color=transparent fs_button_current_color=transparent fs_main_color=transparent fs_font_color=#333 fs_main_background_image=http://renaissancelbl.com/wp-content/uploads/2011/08/feature_bg.jpg fs_button_hover_background_image=http://renaissancelbl.com/wp-content/uploads/2011/09/active_tab.png fs_current_button_background_image=http://renaissancelbl.com//wp-content/uploads/2011/09/active_tab.png fs_pause_duration=6000]');

?>

		

		

		

			<?php if (!dynamic_sidebar('Homepage')) : ?>

			

				

					<div class="wrap">

					

					

					

					

					

					

					

<div class="frontpage"></div>					

					

						<p>	
						<?php 

						query_posts('cat=7&posts_per_page=3'); ?>


<?php while (have_posts()) : the_post(); ?>



<!-- this is where the title of the Lead Story gets printed -->

<div class="frontpage">

<div id="featured-home">



<!-- this is where the excerpt of the Lead Story gets printed -->



</div>





<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2> 

<div style="float:left;"><a href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?></a></div>

<?php the_excerpt('get_the_excerpt', 'new_trim_excerpt');
 ?>

</div>

<?php endwhile; ?></p>
<div class="navigation">
  <?php if (ICL_LANGUAGE_CODE == 'fr')
{ ?>
		
<a href="../category/nouvelles/">Toutes les nouvelles >>></a><br />

<?php }
 elseif (ICL_LANGUAGE_CODE == 'en')
{ ?>
 <a href="../en/category/latest-news/">All the News >>></a><br />

<?php }

?>

   </div>


					</div><!-- end .wrap -->
				</div><!-- end .widget -->
			<?php endif; ?>

		<!-- end #featured-home -->					



	</div><!-- end #content -->

	<?php do_action( 'genesis_after_content' ); ?>

	



</div><!-- end #content-sidebar-wrap -->

<?php do_action( 'genesis_after_content_sidebar_wrap' ); ?>



<?php get_footer(); ?>