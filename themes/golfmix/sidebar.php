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

			<?php if(!is_user_logged_in() && $beta) { ?>
				
				<div class="face-book-login-box">

					<ul>
					<?php wp_login_form(array('value_username'=>'Username', 'redirect' => '/', 'id_username' => 'username', 'value_password' => 'password')); ?>
					<?php if($beta) { ?><a href="<?php bloginfo('url'); ?>/login?action=register"><div style="float:left;" class="login-btn">Register</div></a><?php } ?>
					<div style="float:right;margin-top:8px;margin-right: 13px;"><?php
					//Show a "Login with Facebook" button
					jfb_output_facebook_btn();
					
					//Initialize the Facebook API (and any login buttons on the page)
					jfb_output_facebook_init();
					
					//Output the JS callback that redirects us to process_login.php
					jfb_output_facebook_callback();
					?></div>
					</ul>

				</div>	
				
				<script>
					jQuery('#username').focus( function {
						jQuery(this).val('');
						jQuery('#user_pass').val('');
					});
					jQuery('#user_pass').focus( function {
						jQuery(this).val('');
						jQuery('#username').val('');
					});
				
				</script>
				
				
			<?php } ?>
			
			
			
			

				<div class="daily-box-container">
				
				<?php if(is_singular('post')) { ?>
					<div class="inner-map-area">
							<div id="map_canvas"></div>
							<a href="http://google.com/maps?q=<?php echo $map_search; ?>" class="map-anker" target="_blank">View Larger Map/Directions >></a> </div>
			<?php } ?>
						
					<div class="box-holder">

						<div class="daily-box-top">

							<h3>Deal of the Week</h3>

						</div>

						<div class="daily-box-bottom-2">
							<?php 
							$count = 0;
							$args = array( 'numberposts' => 1, 'offset'=> 0, 'post_type' => 'deals' );
							$deals = get_posts( $args );
							foreach( $deals as $post ) :	setup_postdata($post);
								$deal_company = get_post_meta($post->ID, 'deal_company', true);
								$deal_logo = get_post_meta($post->ID, 'deal_logo', true);
								$deal_image = get_post_meta($post->ID, 'deal_image', true);
								$deal_link = get_post_meta($post->ID, 'deal_link', true);
								$deal_video = get_post_meta($post->ID, 'deal_video', true);
								$deal_promo_code = get_post_meta($post->ID, 'deal_promo_code', true);
								$deal_retail = get_post_meta($post->ID, 'deal_retail', true);
								$deal_price = get_post_meta($post->ID, 'deal_price', true);
								if($deal_retail !== '' && $deal_price !== '') { 
									$deal_discount = $deal_price/$deal_retail; 
									$deal_discount = number_format($deal_discount, 2, '.', '');
									$deal_discount = str_replace('0.','',$deal_discount); 
									$deal_discount.='%';
								}
							
							?>
								<?php if($deal_logo !== '') { ?><img src="<?php echo $deal_logo; ?>" class="deal-logo"/><?php } ?>
								<div class="deal-title"><?php the_title(); ?></div>
								<?php if($deal_discount !== '' && $turnoff == 'true') { ?><div class="deal-percent"><?php echo $deal_discount; ?> off!</div><?php } ?>
								<?php if($deal_video !== '') { ?><div class="deal-video"><iframe width="300" height="182" src="<?php echo $deal_video; ?>" frameborder="0" allowfullscreen></iframe></div>
								<?php } elseif($deal_image !== '') { ?><div class="deal-image"><img src="<?php echo $deal_image; ?>" /></div><?php } ?>
								
								<?php if($deal_promo_code !== '') { ?><div class="deal-promo"><em><strong><?php echo 'Promo code: '.$deal_promo_code;?></strong></em></div><?php } ?>
								<a href="<?php the_permalink(); ?>" class="deal-more" id="more">Learn More</a>
								
							<?php endforeach; ?>	
													
						</div>

						<br class="clear" />

					</div>								

					<div class="box-holder">

						<div class="daily-box-top">

							<h3>review of the day</h3>

						</div>

						<div class="daily-box-bottom-1">
												
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
							//$comment = get_comment('1281');
							foreach($comments as $comment) :
						?>

							<div class="reacent-image-box"><?php echo get_avatar( $comment->comment_author_email); ?></div>

							<div class="reacent-text-box">

								<h3><a href="<?php echo get_permalink($review_post_id); ?>#reviews"><?php echo get_the_title($review_post_id); ?></a></h3>
							</div>
							
							<div class="reacent-text-box 2">

								<a href="<?php echo get_permalink($review_post_id); ?>#reviews">By <?php echo($comment->comment_author); ?></a>

							</div>
						
						

							<div class="daily-star-box">

								<ul>
									<?php if (function_exists('comment_ratings_list')) comment_ratings_list($comment); ?>
								</ul>

							</div>
							

								<p><?php echo substr_replace($comment->comment_content, '&#8230; <a href="'.get_permalink($review_post_id).'#review-'.($comment->comment_ID).'">more &rarr;</a>', 200 ); ?></p>
							
							<?php 
							//<h5 style="clear:both;margin-top:10px;font-style:italic;padding-top: 17px;">Congratulations to <?php echo($comment->comment_author); ?/>!  You win a sleve of Dixon eco-friendly golf balls<?php //<a href="<?php echo $prize_link; ?/>"><?php echo $prize_course_name; ?/></a>?/>!  Want a chance to win tomorrow's giveaway? <a href="<?php bloginfo('url'); ?/>/write-a-review">Write a review now</a>.</h5> 
							?>
							
							<?php endforeach; ?>
							

						</div>

					<br class="clear" />

				</div>
				
					<div class="box-holder">

						<div class="daily-box-top">

							<h3>subscribe to our mailing list</h3>

						</div>

						<div class="daily-box-bottom-2">

							<!-- Begin MailChimp Signup Form -->
							<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
							<style type="text/css">
								#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
								#mc_embed_signup #mce-EMAIL {width:100%;}
								#mc_embed_signup #mc-embedded-subscribe {float:right;}	
							</style>
							<div id="mc_embed_signup">
							<form action="http://golfmix.us2.list-manage.com/subscribe/post?u=ebdbd5f6c4b497cc7b73b37a5&amp;id=0b6883a48a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
								<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
								<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
							</div>
							
							<!--End mc_embed_signup-->
							
						</div>

					<br class="clear" />

					</div>
					
				
			
			<?php if($beta) { ?>

					<div class="box-holder">

						<div class="daily-box-top">

							<h3>Weekly Deal</h3>

						</div>

						

						<?PHP if(function_exists('register_sidebar')&&dynamic_sidebar('Deal of the day')){} ?>

						

					<br class="clear" />

					</div>
			<?php } ?>
					
					<?php if($beta) { ?>
					<div class="box-holder">
						<div class="daily-box-top">
							<h3>recent pictures/videos near you</h3>
						</div>
						<div class="daily-box-bottom-2">
							<div class="reacent-picture-box">
								<ul>
									<?php	
									
									$aquery = 'SELECT * FROM wp_ngg_gallery' ;	
									$gallery = $wpdb->get_results($aquery);
									
									if ($gallery) :
										foreach ($gallery as $galry) :
											$gallerypath = $galry->path;
											$galleryid = $galry->gid;				
											$gallerytitle = $galry->title;	
											$desc = $galry->galdesc;
																
													
									$galleryquery = "SELECT * FROM wp_ngg_pictures WHERE galleryid = '$galleryid' order by pid desc LIMIT 1" ;
									$images = $wpdb->get_results($galleryquery);
										
										$slidercounter = 1 ;
										foreach ($images as $picture) :
											$imagepath = $picture->filename;					
											if ($images) : 
											?>
											 <!--column-one ends-->
											 		  
											  	<li><a href="?page_id=98"><img src="<?php bloginfo('siteurl');?>/<?php echo $gallerypath; ?>/<?php echo $imagepath;?>"  alt="" border="0" width="50" height="50"  /></a></li>
											  
											<?php			
										$slidercounter ++ ;
										endif ;
										endforeach;
									endforeach;
									endif ;	
								
								?>
	
									
								</ul>
								<br class="clear" />
								
							</div>
						</div>
					<br class="clear" />
					</div>
					<?php } ?>
					
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
										


					<div class="box-holder">

						<div class="daily-box-top">

							<h3>top <?php if(is_single() && get_post_type() == 'post') { echo 'nearby'; } else { echo '<strong>arizona</strong>'; }?> courses</h3>
							
	
						</div>

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
										include(get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&distance=10&p='.$post->ID.'&lon='.$c_longitude.'&lat='.$c_latitude.'&sortby='.$rand); 

									} else {
										include(get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&sortby='.$rand); 
									}?>
								</div>

							</div>

						</div>

					<br class="clear" />

					</div>
					


					
					<div class="box-holder">
					
						<div class="daily-box-top">

							<h3>find us on facebook</h3>

						</div>			
						
						<div class="daily-box-bottom-2">
		
							<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fgolfmix&amp;width=305&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=false&amp;height=250" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:250px;margin:10px auto;" allowTransparency="true"></iframe>
							
						</div>
						
					<br class="clear" />
					
					</div>
					
					<?php if($beta) { ?>
					<div class="box-holder">
					
						<div class="daily-box-top">

							<h3>follow us on twitter</h3>

						</div>			
						
						<div class="daily-box-bottom-2">
		
						<script src="http://widgets.twimg.com/j/2/widget.js"></script>
						<script>
						new TWTR.Widget({
						  version: 2,
						  type: 'profile',
						  rpp: 11,
						  interval: 7000,
						  width: 310,
						  height: 300,
						  theme: {
						    shell: {
						      background: '#ffffff',
						      color: '#383138'
						    },
						    tweets: {
						      background: '#ffffff',
						      color: '#333333',
						      links: '#f0ad39'
						    }
						  },
						  features: {
						    scrollbar: false,
						    loop: true,
						    live: true,
						    hashtags: true,
						    timestamp: true,
						    avatars: false,
						    behavior: 'default'
						  }
						}).render().setUser('golfmix').start();
						</script>			
										
						</div>
						
					<br class="clear" />
					
					</div>
					<?php } ?>

					

										

				</div>

			</div>