			<div class="course">
				<div class="course-image">
					<?php 
							$image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large');
							if($image_img_tag) { ?> 
							<img src="<?php echo $image_img_tag[0]; ?>" alt="<?php the_title(); ?>" width="147" class="search-image" />
						<?php } else { ?> 
							<img src="<?php bloginfo('template_url'); ?>/images/golfmix_icon_med.jpg" alt="<?php the_title(); ?>" width="147" class="search-image" />
						<?php } ?>
				</div>
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="course-social top-courses-col-13">
					<ul>
						<li><a  name="fb_share" share_url="<?php the_permalink();?>" class="rss-link-3">Facebook Share</a></li>
						<li><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Check out this review of <?php the_title(); ?>&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix">Twitter Share</a></li>
					</ul>						
				</div>
				<div class="course-info" style="width: 435px;">
					<?php the_excerpt(); ?>
					<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
												
				</div>
				<div class="clear"></div>						
			</div>