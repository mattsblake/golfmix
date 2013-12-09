<?php

/**

 * Template Name: Homepage

 *

 * This is the most generic template file in a WordPress theme

 * and one of the two required files for a theme (the other being style.css).

 * It is used to display a page when nothing more specific matches a query. 

 * E.g., it puts together the home page when no home.php file exists.

 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */



get_header(); ?>

<!--content-->

<?php 
global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('mobile-index.php');

} else { ?>

<?php if(isset($_REQUEST['beta'])) {$beta = true; } ?>

		<div id="content">

			<div id="left-col">

			
			<?php include('featured-slider.php');  ?>


			<div class="reviews-container">

				<div class="reviews-top">

					<div class="recent-reviews-heading">

						<h3>recent reviews</h3>

					</div>

				</div>
				<div class="reviews-center">

				<?php

$live = true;



$duplicates = array();
$args = array(
	'status' => 'approve',
	'number' => '35'
	//'cat' => 12, // use post_id, not post_ID
);
$comments = get_comments($args);
foreach($comments as $comment) :


	// Check to see if this user already has one on the front page:
	//if($beta) { print_r($duplicates); }
	$find_user = array_search($comment->user_id, $duplicates);
	//if($_REQUEST['beta']) { print_r($find_user); }
	if(is_numeric($find_user) == true) { continue; } else { $duplicates[] = $comment->user_id; }
	//if($_REQUEST['beta']) { print_r($duplicates); }
	$count_recent_comments = $count_recent_comments + 1;
	if($count_recent_comments > 5) {continue;}
	
	//$plays = get_the_author_meta( 'plays', $comment->user_id );
	//$average_score = get_the_author_meta( 'average_score', $comment->user_id );
	
	$plays = get_cimyFieldValue($comment->user_id, 'PLAYS');
	$average_score = get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE');

?>
<div class="recent-post-box">


						<div class="post-box-col-1">

							<span>

								<?php echo get_avatar( $comment, '95' ); ?>

							
									<em>Average Score : <?php if($average_score) { echo $average_score; } else { $average_score = get_comment_meta(get_comment_ID(),"_iti_ccf_post_average_score");  echo $average_score[0]; } ?> </em><em>Plays : <?php if($plays) { echo $plays; } else { $plays = get_comment_meta(get_comment_ID(),"_iti_ccf_post_plays");  echo ucfirst($plays[0]); } ?></em>
</span>

						</div>
						
						<div class="post-box-col-4">
                               <div class="top-courses-col-13">
												<ul>
													<li><a  name="fb_share" share_url="<?php echo get_permalink($comment->comment_post_ID);?>" class="rss-link-3">Facebook Share</a></li>
													<li><a href="http://twitter.com/share?url=<?php echo get_permalink($comment->comment_post_ID); ?>&text=Check out this review of <?php echo get_the_title($comment->comment_post_ID); ?>&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix" target="_blank">Twitter Share</a></li>
													<li style="display:none;"><a href="#" class="refresh-link-3">Email Link</a></li>
												</ul>
								</div>


							<br class="clear" />

							<a href="<?php getCustomField('bookateetimelink'); ?>" class="tea-time-btn">BOOK A TEE TIME</a>

						</div>						

						<div class="post-box-col-2">
                            
							<h4><?php echo($comment->comment_author); ?> <span>reviewed</span> <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo get_the_title($comment->comment_post_ID);?></a></h4>

							

							<span class="clock-box"><?php echo get_comment_date(); // ' '. get_comment_time(); ?></span>

							<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#reviews" class="comments"><?php $comments_count = wp_count_comments($comment->comment_post_ID); echo $comments_count->approved; ?>&nbsp;reviews</a>

						</div>

						<div class="post-box-col-3">
                           <?php if (function_exists('comment_ratings_list')) comment_ratings_list($comment); ?>
							
						</div>


						<p style="width:469px;"><?php echo substr_replace($comment->comment_content, '&#8230; <a href="'.get_permalink($comment->comment_post_ID).'#review-'.($comment->comment_ID).'">more &rarr;</a>', 400 ); ?> <?php // echo ($comment->comment_content) ?></p>
						
						<br class="clear" />


					</div>
		<?php endforeach; ?></div>

				

				<div class="reviews-bottom"></div>
				</div>

			<?php include('cities-list.php'); ?>	


			<br class="clear" />
				
			<?php include('ads_content_468x60.php'); ?>
				

			</div>

			</div>

			<?php get_sidebar(); ?>

			

			<div class="clear"></div>

		</div>

		<!--/content--> 

		
<?php } ?>
	

	<?php get_footer(); ?>



