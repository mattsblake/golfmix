					<?php
					switch_to_blog($switched);
					$duplicates = array();
					$args = array(
						'status' => 'approve',
						'number' => '25'
						//'cat' => 12, // use post_id, not post_ID
					);
					$comments = get_comments($args);
					foreach($comments as $comment) :
						
						// Check to see if this user already has one on the front page:
						$find_user = array_search($comment->user_id, $duplicates);
						if(is_numeric($find_user) == true) { continue; } else { $duplicates[] = $comment->user_id; }
						$count_recent_comments = $count_recent_comments + 1;
						if($count_recent_comments > 7) {continue;}
						
						$plays = get_cimyFieldValue($comment->user_id, 'PLAYS');
						$average_score = get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE');
					
						include('review-result.php');
					
					endforeach; 
					
					restore_current_blog()
					?>
										
					<script>
					$(".recent-review").click( function() {
						$(this).addClass("show");
					});
					$(".recent-review.show").click( function() {
						$(this).removeClass("show");
					});
					</script>