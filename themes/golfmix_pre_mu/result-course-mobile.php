<?php  
	global $value;
	$rating = $value;
	$rating = number_format($rating, 2, '.', '');
	$rating = explode(".", $rating);
	$rating[1] = '.'.$rating[1];
	$rating_blank = 'no';
	
	if($rating_cat == '') {$rating_cat = 'Overall';}

	if($rating[0]=='0') { 
	$rating[0] = 'N/A'; 
	$rating[1] = '';
	$rating_cat = '';
	$rating_blank = 'yes';
	}
?>
					<div class="course">
						<div class="course-rating-wrapper">
							<div class="course-rating<?php if($rating_blank == 'yes') { echo ' blank'; } ?>"><?php echo $rating[0]; ?><span><?php echo $rating[1]; ?></span><div class="rating-cat"><?php echo $rating_cat; ?></div></div>
						</div>
						<div class="course-image">
							<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" border="0" />
							<?php if($recent['total'] > 0 && $turn_flickr_off == '') { ?><a href="<?php echo $puri; ?>" target="_blank"><div class="flickr_attribution bestof"></div></a><?php } ?>
						</div>
						<a href="<?php the_permalink(); if(isset($_REQUEST['app'])) { echo '?&app=no'; } ?>">
							<div class="course-info">
								<h4><?php the_title(); ?></h4>
								<ul>
									<li><?php //echo $c_address1; ?> <?php echo $c_city; ?>, <?php echo $c_state; ?><?php //echo $c_zip; ?>&nbsp;&nbsp;<img src="<?php bloginfo('template_url'); ?>/images/mobile/map_grey.png"/><?php echo $distance_from; ?> miles</li>
									<li><img src="<?php bloginfo('template_url'); ?>/images/mobile/review_icon.png"/><?php comments_number('0 Reviews','1 Review','% Reviews');  ?>&nbsp;&nbsp;<?php echo $c_feewe; ?></li>
								</ul>
							</div>
						</a>
					</div>