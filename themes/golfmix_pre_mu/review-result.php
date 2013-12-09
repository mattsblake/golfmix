						<div class="recent-review" id="review-<?php comment_ID(); ?>" itemprop="reviews" itemscope itemtype="http://schema.org/Review"><?php
			//			<meta property="og:title" content="<?php echo get_the_title($comment->comment_post_ID) ?/>"/>
			//			<meta property="og:url" content="<//?php echo get_permalink($comment->comment_post_ID).'#review-'.$comment->comment_ID;?/>"/>
			//			<meta property="og:site_name" content="golfmix"/>
			//			<meta property="fb:admins" content="10105391"/>
			//			<meta property="og:description" content="<//?php echo $comment->comment_content; ?/>"/>
			//			<meta property="og:type" content="<?php echo $comment->comment_content; ?/>"/>
	     ?>
							<div class="reviewer">
								<?php echo get_avatar( $comment, '90' ); ?>
								<span>Average Score: <?php if($average_score) { echo $average_score; } else { $average_score = get_comment_meta(get_comment_ID(),"_iti_ccf_post_average_score");  echo $average_score[0]; } ?></span>
								<span>Plays: <?php if($plays) { echo $plays; } else { $plays = get_comment_meta(get_comment_ID(),"_iti_ccf_post_plays");  echo ucfirst($plays[0]); } ?></span>
							</div>
							<div class="review-info">
								<h4><author itemprop="author"><?php echo($comment->comment_author); ?></author> <?php if(is_single()) {?><span>wrote:</span><?php } else { ?><span>reviewed</span> <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo get_the_title($comment->comment_post_ID);?></a><a href="<?php echo get_permalink($comment->comment_post_ID); ?>#reviews" class="reviews"><?php $comments_count = wp_count_comments($comment->comment_post_ID); echo '('.$comments_count->approved.'&nbsp;reviews)'; ?></a><?php } ?></h4>
								<span class="clock-box" itemprop="datePublished" content="<?php echo get_comment_date(); ?>"><?php echo get_comment_date(); ?></span>
								 <rating  itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
						          	 <span itemprop="ratingValue" style="display:none;"><?php echo get_average_comment_rating(); ?></span>
						     		 <span itemprop="bestRating" style="display:none;">5</span>
									<ul class="ratings">
										<?php $ratings = get_comment_ratings($comment->comment_ID); //print_r($ratings); ?>
										<li><strong>Overall Experience:</strong> <?php echo num_to_stars($ratings['<strong>Overall Experience</strong>']); ?></li>
										<li>Course Conditions: <?php echo num_to_stars($ratings['Course Conditions']); ?></li>
										<li>Value: <?php echo num_to_stars($ratings['Value']); ?></li>
										<li>Design: <?php echo num_to_stars($ratings['Design']); ?></li>
										<li>Amenities: <?php echo num_to_stars($ratings['Amenities']); ?></li>									
										<li>Pace of Play: <?php echo num_to_stars($ratings['Pace of Play']); ?></li>								
									</ul>
								 </rating>	
								<p itemprop="description"><?php if(is_single()) { echo $comment->comment_content; } else { echo substr_replace($comment->comment_content, '&#8230; <a href="'.get_permalink($comment->comment_post_ID).'#review-'.($comment->comment_ID).'">read more</a>', 400 ); } ?></p>
							</div>
						</div>
