<?php if($blog_id !== '1') { global $switched; switch_to_blog(1); } ?>

<div class="daily-box-top"><h3>Review of the Week</h3></div>
				<div class="daily-box-bottom-2">
							<?php 
							
								global $options;
								foreach ($options as $value) {
								    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
								}
								date_default_timezone_set('America/Phoenix');
								$time = date("m/d/Y");
								if(isset($_REQUEST['beta'])) {echo $time.$gm_date1;}
							
								if($time == $gm_date1) { 
									$review_post_id = $gm_postid1;
									$review_id = $gm_email1;
									$prize_course_name = $gm_prizename1;
									$prize_link = $gm_prizeurl1;
									$date = 1;
								} elseif($time == $gm_date2) {
									$review_post_id = $gm_postid2;
									$review_id = $gm_email2;
									$prize_course_name = $gm_prizename2;
									$prize_link = $gm_prizeurl2;
									$date = 2;
								}
								elseif($time == $gm_date3) { 
									$review_post_id = $gm_postid3;
									$review_id = $gm_email3;
									$prize_course_name = $gm_prizename3;
									$prize_link = $gm_prizeurl3;
									$date = 3;
								}
								
								if(isset($_REQUEST['beta'])) {echo $date;}
								
								
								if(isset($_REQUEST['beta'])) { echo $review_post_id; }
								
								if(!$date) {
									if($gm_postid1) {
										$review_post_id = $gm_postid1;
										$review_id = $gm_email1;
										$prize_course_name = $gm_prizename1;
										$prize_link = $gm_prizeurl1;
									} elseif($gm_postid2) {
										$review_post_id = $gm_postid2;
										$review_id = $gm_email2;
										$prize_course_name = $gm_prizename2;
										$prize_link = $gm_prizeurl2;
									} elseif($gm_postid3) {
										$review_post_id = $gm_postid3;
										$review_id = $gm_email3;
										$prize_course_name = $gm_prizename3;
										$prize_link = $gm_prizeurl3;
									}
								}
															
								$args = array('status' => 'approve', 'number' => '1','order' => 'ASC','post_id' => $review_post_id, 'author_email' => $review_id );
								$comments = get_comments($args);
								foreach($comments as $comment) :
							?>
								<div class="reacent-image-box"><?php echo get_avatar( $comment->comment_author_email); ?></div>
								<div class="review-info">
									<h3><a href="<?php echo get_permalink($review_post_id); ?>#reviews"><?php echo get_the_title($review_post_id); ?></a></h3>
									<p>By <a href="<?php echo get_permalink($review_post_id); ?>#reviews"> <?php echo($comment->comment_author); ?></a></p>
									<p><strong>Overall Experience:</strong> <?php echo num_to_stars(get_average_comment_rating($comment->comment_ID)); ?></p>
								</div>
								
								<div class="review-excerpt"><?php echo substr_replace($comment->comment_content, '&#8230; <a href="'.get_permalink($review_post_id).'#review-'.($comment->comment_ID).'">more &rarr;</a>', 170 ); ?></div>
								
								<div class="review-congrats">Congratulations to <?php echo($comment->comment_author); ?>!  Want a chance to win next week's giveaway? <a href="<?php bloginfo('url'); ?>/write-a-review">Write a review now</a>.</div> 
								
								<?php endforeach; ?>
								
	
							</div>
							<?php if($blog_id !== '1') { restore_current_blog(); } ?>