<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<!--content-->
			<div id="content"
			<div id="left-col">
		<div class="reviews-container1">

<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
	<?php while ( have_posts() ) : the_post();	
		
		include('search-course-setup.php');
		include('result-course.php');
		
	  endwhile; ?>
				<!--end-->
	
	
	<?php posts_nav_link('&nbsp;', '<div class="post_nav" style="float:left;">previous page</div>', '<div class="post_nav" style="float:right;">next page</div>'); ?>
		
				
				
				
				
			
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
						
					</div>
				</div>  
<?php endif; ?>
			</div> 
					
				</div>
			<div id="right-col">
					<div class="daily-box-container">
					<div class="box-holder">
							<div class="daily-box-top">
							<h3>top  courses</h3>
						</div>
							<div class="daily-box-bottom-2">
							<div class="top-courses-box">
									<br class="clear" />
									<?php wp_reset_query(); ?>
								<?php rs_comparison_table(5); ?>
								</div>
						</div>
							<br class="clear" />
						</div>
				</div>
				</div>
			<div class="clear"></div>
		</div>
			<!--/content--> 
			
		</div>
<?php get_footer(); ?>
