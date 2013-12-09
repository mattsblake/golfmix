				<?php query_posts('orderby=date&order=DESC&post_type=blog&tag=featured&posts_per_page=4'); ?>
			   	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php  $image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'medium'); ?>	
					<div class="entry-blog">
					<div class="entry-image-wrapper">
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" /></a>
					</div>
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				</div>
				<?php endwhile; ?>