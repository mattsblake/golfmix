			<?php if($tie == 1) { $count = $count + 1;} ?>
			<?php $featured_count = $featured_count + 1; ?>
			<?php if($featured_count > 6) { }  else { ?>
				<?php if($featured_count == 1) { ?>
					<div id="bestof-top">
				<?php } elseif($featured_count == 2) { ?>
					</div><!--bestof-top-->	
					<div id="bestof-left">
				<?php } elseif($featured_count == 4) { ?>
					</div><!--bestof-left-->
					<div id="bestof-right">
				<?php } ?>			
						<div class="bestof-course" id="best-of-<?php echo $featured_count; ?>">
							<div class="best-image-wrapper">
								<div class="best-image"><img src="<?php echo $image; ?>"></div>
								<div class="best-of-number"><?php echo $featured_count; ?></div>
								<div class="clear"></div>
							</div>
							
							<div class="best-info">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<div class="best-share">
									<a href="<?php the_permalink(); ?>#reviews"><?php comments_number('','1 Review','% Reviews'); ?><?php echo '&nbsp;|&nbsp;'; ?></a><span><?php if($featured_count < 2) { echo num_to_stars_mobile($value); } else { echo num_to_stars($value); } ?></span>
								</div>
								<?php if($count < 4) {?>
								<ul class="info">
									<li><?php echo $c_address1; ?></li>
									<li><?php echo $c_address2; ?></li>
									<li><?php echo $c_city; ?>, <?php echo $c_state; ?> <?php echo $c_zip; ?></li>
									<li><?php echo $c_phone; ?></li>
									<li><a href="http://<?php echo $c_site; ?>"  target="_blank"><?php echo $c_site; ?></a></li>
								</ul>
								<?php } ?>
								<?php if($count <2) { ?>
								<div class="best-ratings">
									<ul class="ratings">
										<li <?php if($sortby == 'value') { echo 'class="bold"'; }?>>Value:<?php echo num_to_stars($ratings["Value"]); ?></li>
										<li <?php if($sortby == 'conditions') { echo 'class="bold"'; }?>>Course Conditions:<?php echo num_to_stars($ratings["Course Conditions"]); ?></li>
										<li <?php if($sortby == 'design') { echo 'class="bold"'; }?>>Design:<?php echo num_to_stars($ratings["Design"]); ?></li>
										<li <?php if($sortby == 'amenities') { echo 'class="bold"'; }?>>Amenities:<?php echo num_to_stars($ratings["Amenities"]); ?></li>
										<li <?php if($sortby == 'pace') { echo 'class="bold"'; }?>>Pace of Play:<?php echo num_to_stars($ratings["Pace of Play"]); ?></li>
										<li <?php if($sortby !== 'value' && $sortby !== 'conditions' && $sortby !== 'design' && $sortby !== 'amenities' && $sortby !== 'pace') { echo 'class="bold"'; }?>>Overall Experience:<?php echo num_to_stars($ratings["<strong>Overall Experience</strong>"]); ?></li>
									</ul>
								</div>
								<?php } ?>
							</div>
						</div>
					<?php if($featured_count == 6) {?>	
					</div><!--bestof-right-->
					<?php } ?>
			<?php } ?>