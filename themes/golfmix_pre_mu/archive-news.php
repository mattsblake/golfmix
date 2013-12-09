<?php
// Archive for news

get_header(); ?>
		
<?php query_posts( 'post_type=news' );  ?>

<!--content-->
			<div id="content">
			<div id="left-col">
		<div class="reviews-container1">

<?php if ( have_posts() ) : ?>
	<h1 class="page-title">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date('Y') ); ?>
<?php else : ?>
				<?php _e( 'Arizona Golf News', 'twentyten' ); ?>
<?php endif; ?>
			</h1>

	<?php while ( have_posts() ) : the_post();	
		
		include('entry-content.php');
		
	  endwhile; 
	  
	  ?>
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
		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->
			
		</div>
<?php get_footer(); ?>
