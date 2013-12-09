<?php

/**

 * The Sidebar containing the primary and secondary widget areas.

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */

?>



		<div id="right-col">

				<div class="daily-box-container">
				
				<?php if(is_singular('post')) { ?>
					<div class="inner-map-area">
							<div id="map_canvas"></div>
							<a href="http://google.com/maps?q=<?php echo $map_search; ?>" class="map-anker" target="_blank">View Larger Map/Directions >></a> </div>
				<?php } ?>
				
					<?php include('promos.php'); ?>

						
					<div class="box-holder" id="featured-deal">
						<?php include('deal-of-week.php'); ?>
						<br class="clear" />
					</div>								

					<?php global $featured_course; if($featured_course!=='yes') { ?>
					<div class="box-holder" id="review-of-the-day">
						<?php include('review-of-day.php'); ?>
						<br class="clear" />
					</div>
					<?php } ?>
				
					<div class="box-holder" id="email-subscribe">
						<?php include('subscribe.php'); ?>
					</div>
					
				
					
					<?php if(isset($_REQUEST['beta'])) { ?>
					<iframe src="http://golfmix.com/widget/?id=267&review=1305&style=g&width=335" width="340" height="195" scrolling="no" style="margin:20px 0;padding:0;"></iframe>
					<?php } ?>

					
					<?php if($featured_course!=='yes') { ?>

					<div class="box-holder">
						<div class="daily-box-top">
							<h3>sponsored ads</h3>
						</div>

						<div class="daily-box-bottom-2">
							<div class="top-courses-box" style="width:300px;height:250px;margin:10px auto;">
							<script type='text/javascript'>
							GA_googleFillSlot("Sidebar_300x250");
							</script>
							</div>
						</div>
					<br class="clear" />
					</div>
					<?php } ?>
										

					<?php if($featured_course!=='yes') { ?>
					<div class="box-holder">
						<div class="daily-box-top"><h3>top <?php if(is_single() && get_post_type() == 'post') { echo 'nearby'; } else { echo '<strong>arizona</strong>'; }?> courses</h3></div>

						<div class="daily-box-bottom-2">
							<div class="top-courses-box">
								<?php $input = array("overall", "value", "conditions", "design", "amenities", "pace");
									  shuffle($input);
									  $rand = trim($input[0]);
									  
									  $course_id= get_post_meta($post->ID, 'course_id',1);
									  include('courses_call.php'); 
								?>
								<select id="topcourses_select">
									<option value="overall" <?php if($rand == 'overall') { echo 'selected'; } ?>>Overall Experience</option>
									<option value="value"<?php if($rand == 'value') { echo 'selected'; } ?>>Value</option>
									<option value="conditions"<?php if($rand == 'conditions') { echo 'selected'; } ?>>Course Conditions</option>
									<option value="design"<?php if($rand == 'design') { echo 'selected'; } ?>>Design</option>
									<option value="amenities"<?php if($rand == 'amenities') { echo 'selected'; } ?>>Amenities</option>
									<option value="pace"<?php if($rand == 'pace') { echo 'selected'; } ?>>Pace of Play</option>
								</select>
								<script>
								$('#topcourses_select').change(function() {
								 	 	$('#sidebar-loader').show();
								 	 	$('#top-courses-list').hide();
								 	 	var sortby = $('select#topcourses_select').val(); 
								 	 	$.ajax({
										  type: "POST",
										  url: "<?php bloginfo('template_url'); ?>/top_rated_xml.php",
										  data: "ajax=1<?php if(is_single() && get_post_type() == 'post') { echo '&distance=10&p='.$post->ID.'&lon='.$c_longitude.'&lat='.$c_latitude; } ?>&sortby="+sortby,
										  success: function(html){
											 $('#sidebar-loader').hide();										    
											 $("#top-courses-list").html(html).show();
										  }
										});

								});
								</script>
								<br class="clear" />
								<div id="sidebar-loader" style="display:none;"><img src="http://golfmix.com/wp-content/themes/golfmix/images/ajax-loader.gif" style="margin: 13px 135px;" /></div>

									
								<div id="top-courses-list">
									<?php 
									if(is_single() && get_post_type() == 'post') {									 
										$top_courses = get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&distance=10&p='.$post->ID.'&lon='.$c_longitude.'&lat='.$c_latitude.'&sortby='.$rand; 

									} else {
										$top_courses = get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&sortby='.$rand; 
									}
										echo print_top_courses($top_courses);
									?>
								</div>

							</div>

						</div>

					<br class="clear" />

					</div>
					<?php } ?>


					
					<div class="box-holder">
						<div class="daily-box-top">
							<h3>find us on facebook</h3>
						</div>			
						
						<div class="daily-box-bottom-2">
							<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fgolfmix&amp;width=305&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=false&amp;height=250" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:250px;margin:10px auto;" allowTransparency="true"></iframe>
						</div>
						<br class="clear" />
					</div>

				</div>

			</div>
			
		<div class="clear"></div>