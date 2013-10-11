<?php get_header(); ?>



	<?php genesis_before_content(); ?>
	<?php genesis_before_loop(); ?>
	<div id="content">
	<h2 class="entry-title"><?php _e("Glossary", 'genesis'); ?></h2>
	
<?php if (function_exists('wp_snap')) { echo wp_snap('cat=34=true&firstload=tous'); } ?><br /><br /><br />



	
		
		<div class="post hentry">

<div class="entry-content">



			
		<?php genesis_loop(); ?>
		
		

	
		
		
</div>
<p><!-- end .entry-content --></p>
</div>
<p><!-- end .post --><br />
       </p>


	</div><!-- end #content -->
	




<?php get_footer(); ?>