<?php
/**
 * Template Name: Mobile Deal of the Week
 *
**/
get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div class="recent-reviews"><?php the_title(); ?></div> 
	
	<div class="reviews">
	
		<?php the_content(); ?> 
	
	</div>
	
<?php endwhile; // end of the loop. ?>

</body>