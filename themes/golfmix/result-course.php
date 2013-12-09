					<?php global $search_format; ?>
					<div class="course">
						<div class="course-image">
							<img src="<?php echo $image; ?>" alt="" border="0"  style="height:120px;width:147px;" class="search-image"/>
							<?php if($recent['total'] > 0 && $turn_flickr_off == '') { ?><a href="<?php echo $puri; ?>" target="_blank"><div class="flickr_attribution bestof"></div></a><?php } ?>
						</div>
						<h4><?php if($search_format !== 'true') { ?><div class="rank-big"><?php echo $count; ?></div><?php } ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="reviews" style="margin-left:10px;"><?php if($search_format !== 'true') { echo '(Average Rating '.$value.')'; } else { comments_number('','(1 Review)','(% Reviews)'); }?></span></h4>
						<div class="course-social top-courses-col-13">
							<ul>
								<li><a  name="fb_share" share_url="<?php the_permalink();?>" class="rss-link-3">Facebook Share</a></li>
								<li><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Check out this review of <?php the_title(); ?>&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix">Twitter Share</a></li>
							</ul>						
						</div>
						<div class="course-info">
							<ul>
								<li><?php echo $c_address1; ?></li>
								<li><?php echo $c_address2; ?></li>
								<li><?php echo $c_city; ?>, <?php echo $c_state; ?> <?php echo $c_zip; ?></li>
								<li><?php echo $c_phone; ?></li>
								<li><a href="http://<?php echo $c_site; ?>"  target="_blank"><?php echo $c_site; ?></a></li>
							</ul>
							
							<?php $rating_fields = get_ratings();
							if($rating_fields["Overall Rating"]!="0") {  ?>
							<div style="clear:left;width:100%;height:20px;"></div>
							<a href="<?php echo get_permalink(); ?>#addreview" class="rate-first">Write a Review</a>
							<?php } ?>
							
							<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
						<div class="course-ratings">
							<?php 
							if(isset($_REQUEST['debug'])) { echo $rating_fields["<strong>Overall Experience</strong>"]; }
							if($rating_fields["<strong>Overall Experience</strong>"]!== 0) {  ?>
							<ul class="ratings">
								<li <?php if($sortby == 'value') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Value:</label> <span class="rating_value"><?php echo num_to_stars($ratings["Value"]); ?></span></li>
								<li <?php if($sortby == 'conditions') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Course Conditions:</label> <span class="rating_value"><?php echo num_to_stars($ratings["Course Conditions"]); ?></span></li>
								<li <?php if($sortby == 'design') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Design:</label> <span class="rating_value"><?php echo num_to_stars($ratings["Design"]); ?></span></li>
								<li <?php if($sortby == 'amenities') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Amenities:</label> <span class="rating_value"><?php echo num_to_stars($ratings["Amenities"]); ?></span></li>
								<li <?php if($sortby == 'pace') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Pace of Play:</label> <span class="rating_value"><?php echo num_to_stars($ratings["Pace of Play"]); ?></span></li>
								<li <?php if($sortby !== 'value' && $sortby !== 'conditions' && $sortby !== 'design' && $sortby !== 'amenities' && $sortby !== 'pace') { echo 'class="over-all-rating-box-1"'; }?>><label class="rating_label">Overall Experience:</label> <span class="rating_value"><?php echo num_to_stars($ratings["<strong>Overall Experience</strong>"]); ?></span></li>
							</ul>
							<?php } else { echo '<div style="height:75px;width:100%;float:right;clear:right;"><a href="'.get_permalink().'" class="rate-first" style="float:right;">Be the first to review this course!</a></div>'; } ?>
							<div class="clear"></div>						
						</div>
						<div class="clear"></div>						
					</div>