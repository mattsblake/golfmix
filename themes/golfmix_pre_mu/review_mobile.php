<?php 
//$comment->comment_ID	
//$comment->comment_author
//get_avatar( $comment->comment_author_email, 101 )				
//trim(get_cimyFieldValue($comment->user_id, 'PLAYS'))
//trim(get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE'))			
//$comment->comment_date)
//$comment->comment_content)
//$comment->comment_ID
	
$ratings = get_comment_ratings($comment->comment_ID);
$rating = $ratings["<strong>Overall Experience</strong>"];
//$rating = number_format($rating, 2, '.', '');
//$rating = explode(".", $rating);

?>
<div class="review">
	<div class="reviewer-rating">
		<?php echo $rating; ?>
	</div>
	<div class="reviewer-image">
		<?php echo get_avatar( $comment->comment_author_email, 65 ); ?>
	</div>		
	<div class="reviewer-info">
		<h4><?php echo $comment->comment_author; ?></h4>
		<span class="date"><?php wp_time_since(0, strtotime($comment->comment_date)); ?></span><br />
		<span>Average Score:</span> <?php echo trim(get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE')); ?><br />
		<span>Plays:</span> <?php echo trim(get_cimyFieldValue($comment->user_id, 'PLAYS')); ?>
	</div>
	<?php if(isset($_REQUEST['review_id'])) { ?>
	<div class="course-details">
		<div class="course-left">
			<h4>Ratings:</h4>
			<ul class="ratings">
				<li><span>Value:</span> <?php echo num_to_stars_mobile($ratings["Value"]); ?></li>
				<li><span>Design:</span> <?php echo num_to_stars_mobile($ratings["Design"]); ?></li>
				<li><span>Course Conditions:</span> <?php echo num_to_stars_mobile($ratings["Course Conditions"]); ?></li>
				<li><span>Amenities:</span> <?php echo num_to_stars_mobile($ratings["Amenities"]); ?></li>
				<li><span>Pace of Play:</span> <?php echo num_to_stars_mobile($ratings["Pace of Play"]); ?></li>
				<li class="overall"><span>Overall Experience:</span> <?php echo num_to_stars_mobile($ratings["<strong>Overall Experience</strong>"]); ?></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>	
	<?php } ?>
	<div class="review-content <?php if(!isset($_REQUEST['review_id'])) { echo 'arrow'; } ?>">
	<?php if(!isset($_REQUEST['review_id']) && isset($_REQUEST['app'])) { echo '<a href="http://golfmix.com/m/r/?review_id='.$comment->comment_ID.'&app=no">'; } elseif(!isset($_REQUEST['review_id']) && !isset($_REQUEST['review_id'])) { echo '<a href="http://golfmix.com/m/r/?review_id='.$comment->comment_ID.'">'; } ?>
		<?php if(!isset($_REQUEST['review_id'])) { 
				echo substr_replace($comment->comment_content, '…', 125, -1);
			  } else {
				echo nl2br($comment->comment_content);		  
			  }
	    ?>
	    <?php if(!isset($_REQUEST['review_id'])) { echo '</a>'; } ?>
	</div>
	<div class="clear"></div>
</div>
