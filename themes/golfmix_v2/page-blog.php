<?php
/**
 * Template Name: Blog
 */

get_header(); ?>
		
<?php query_posts( 'post_type=blog' );  ?>

<!--content-->
			<div id="content"></div>
			<div id="left-col">
		<div class="reviews-container1">

<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
	<?php while ( have_posts() ) : the_post();	
		
		?>
		<div class="reviews-container1">

					<div class="reviews-top">
							<div class="search-recent-reviews-heading shrink-head">
							<h4><a href="<?PHP the_permalink(); ?>"><?php the_title(); ?></a><span class="reviews" style="margin-left:10px;"></span></h4>
						</div>
							<div class="post-box-col-4">
								<div class="top-courses-col-13">
									<ul>
										<li><a  name="fb_share" share_url="<?php the_permalink();?>" class="rss-link-3">Facebook Share</a></li>
										<li><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Check out this review of <?php the_title(); ?>&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix">Twitter Share</a></li>
										<li><a href="#" class="refresh-link-3">Email Link</a></li>
									</ul>
								</div>
						</div>
						</div>
					<div class="reviews-center">
							<div class="recent-post-box border-none1">
								<div class="post-box-col-1 search-post-box-col-1"> 
									<?php 
									$image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large');
									if($image_img_tag !== '') { ?> 
									<img src="<?php echo $image_img_tag[0]; ?>" alt="<?php the_title(); ?>" width="147" class="search-image" />
								<?php } else { ?> 
									<img src="<?php bloginfo('template_url'); ?>/images/golfmix_icon_med.jpg" alt="<?php the_title(); ?>" width="147" class="search-image" />
								<?php } ?>
								</div>
							<div class="post-box-col-2 search-post-box-col-2">									
										<ul>
											<li><?php the_excerpt(); ?></li>
										</ul>
									
																		
									<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

									
								</div>
							
							<br class="clear" />
							
						</div>
						</div>
					<div class="reviews-bottom">
						
					</div>
				</div>		
		
				
		<?PHP 
		
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
				
		<?php get_sidebar(); ?>

      <br class="clear" />
    <!--/content-->
			
<?php get_footer(); ?>
