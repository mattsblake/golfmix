<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header();

global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('mobile-single.php');

} else { ?>
		
		
<?php if ( have_posts() ) while ( have_posts() ) : the_post();

$course_id= get_post_meta($post->ID, 'course_id',1);
include('courses_call.php'); 

endwhile;

if($_REQUEST['share'] == '1'){ include('share.php'); } 

?>		

		<!--content-->
			<div id="content">
			<div id="left-col" itemscope itemtype="http://schema.org/GolfCourse">
			
				<div class="course-details">
					<h1 itemprop="name"><?php the_title();?><span class="star-spa-review">Reviews (<span  itemprop="reviewCount"><?php comments_number('0','1','%'); ?></span>)</span></h1>
					
					<?php 
					global $featured_course, $featured_twitter, $featured_facebook, $featured_foursquare;
					$featured_course = get_post_meta(get_the_ID(), 'featured_course', 1);
					$featured_facebook = get_post_meta(get_the_ID(), 'featured_facebook', 1);
					$featured_twitter = get_post_meta(get_the_ID(), 'featured_twitter', 1);
					$featured_foursquare = get_post_meta(get_the_ID(), 'featured_foursquare', 1);

	
					
					if($featured_course=='yes' && ($featured_facebook || $featured_twitter || $featured_foursquare)) { ?>
						<ul class="featured-social">
							<?php if($featured_facebook) { ?><a href="<?php echo $featured_facebook; ?>" target="_blank"><li class="facebook">Facebook</li></a><?php } ?>
							<?php if($featured_twitter) { ?><a href="<?php echo $featured_twitter; ?>" target="_blank"><li class="twitter">Twitter</li></a><?php } ?>
							<?php if($featured_foursquare) { ?><a href="<?php echo $featured_foursquare; ?>0" target="_blank"><li class="foursquare">Foursquare</li></a><?php } ?>
						</ul>
					<?php } ?>

					<a href="<?php echo get_permalink(); ?>#addreview" class="rate-first">Write a Review</a>
					
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=75&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:20px;" allowTransparency="true" class="fb-like"></iframe>
										
					
					<ul class="course-info">
						<address itemscope itemtype="http://schema.org/PostalAddress">
						<li><streetaddress itemprop="streetAddress"><?php echo $c_address1; ?>&nbsp;<?php echo $c_address2; ?></streetaddress>&nbsp;&nbsp;<city itemprop="addressLocality"><?php echo $c_city; ?></city>, <state itemprop="addressRegion"><?php echo $c_state; ?></state> <zip itemprop="postalCode"><?php echo $c_zip; ?></zip></li>
						</address>
						<li class="phone" itemprop="telephone"><?php echo $c_phone; ?></li>
						<li class="website"><a href="http://<?php echo $c_site; ?>" target="_new" itemprop="url"><?php echo $c_site; ?></a></li>
					</ul>
							
															
							<?php if($c_overseeding) { ?>
								<a href="http://golfmix.com/2011-arizona-golf-course-overseeding-schedule/" class="overseeding"><div><p>Overseeding Alert: <?php echo $c_overseeding; ?></p></div></a>
							<?php } ?>
							
							
						<div id="featured-photos" <?php if($featured_course=='yes') { echo 'class="big"'; } ?>>				
							<?php 		
							//$auth = md5('SECRET'.get_the_ID());
							global $turn_flickr_off;
							$turn_flickr_off = get_post_meta(get_the_ID(), 'turn_flickr_off', 1);

							global $tee_time_link;
							$tee_time_link = get_post_meta(get_the_ID(), 'tee_time_link', 1);
							
							global $blocked_photos;
							$blocked_photos = explode(',',get_post_meta(get_the_ID(), 'blocked_photos', 1));
							//$blocked_photos = array(get_post_meta(get_the_ID(), 'blocked_photos', 1));
										
							global $c_name_encode;
							$c_name_encode = str_replace(" ", "+", $c_name);							
							if(isset($_REQUEST['api'])) { echo $c_name_encode; }		
										
							require_once("phpflickr/phpFlickr.php");
							$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
							
							$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"10"));
							
							if(isset($_REQUEST['api'])) { print_r($recent); }
							
							if($recent['total'] > 0  && $turn_flickr_off == '') {
							
							foreach ($recent['photo'] as $photo) {
								// Restrict Bad Photos
								$pid = $photo['id'];
								if(in_array($pid, $blocked_photos)) { continue; }
															
								$pcount = $pcount + 1;
																
								if($pcount < 4 ) {
									$pid = $photo['id'];
									$pserver = $photo['server'];
									$pfarm = $photo['farm'];
									$ptitle = $photo['title'];
									$psecret = $photo['secret'];
									$powner = $photo['owner'];
									
									$puri = 'http://www.flickr.com/photos/'.$powner.'/'.$pid;

									?>
												<div id="photo-<?php echo $pcount; ?>" class="photo"><img <?php if($pcount == 1) { echo 'itemprop="photo"'; }?> src="http://farm<?php echo $pfarm; ?>.static.flickr.com/<?php echo $pserver; ?>/<?php echo $pid; ?>_<?php echo $psecret; ?>_z.jpg" alt="<?php echo $ptitle; ?>"/>
													<a href="<?php echo $puri; ?>" target="_blank"><div class="flickr_attribution"></div></a>
												</div>		
									<?php }
										}
									}  else { ?>
												<div id="photo-5" class="photo"><img itemprop="photo"src="<?php echo get_bloginfo('template_url').'/images/golfmix_icon_big.jpg'; ?>" alt="<?php the_title(); ?>"/></div>										
									<?php } ?>			
							</div>							

						<div class="rating-cont" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        	<span itemprop="reviewCount" style="display:none;"><?php comments_number('0','1','%'); ?></span>
                        	<span itemprop="ratingValue" style="display:none;"><?php echo get_average_rating(); ?></span>
                        	<span itemprop="bestRating" style="display:none;">5</span>
                        	<span class="ratings-heading">Ratings :</span>
							<?php //echo ratings_table(); 
								echo ratings_list();
							?>
                        </div>
                            
						<div class="cources-detail-cont">
                        	<span class="course-detail-heading" id="amenities">Course Details :</span>
								<ul>
									<?php if($hide) { ?><li><span>Tee Times :</span>Mon-Fri  (7 am - 6 pm)</li><?php } ?>
									<?php if($hide) { ?><li><span>Yardage :</span>2590 m </li><?php } ?>
									<li><span>Facility Type:</span><?php echo $c_type;?></li>
									<li itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span>Green Fees :</span><price itemprop="price"><?php echo $c_feewe; ?></price></li>
									<li><span>Course Designer :</span><?php echo $c_designer; ?> - <?php echo $c_year; ?></li>
									<?php if($c_pro) { ?><li><span>Course Pro :</span><?php echo $c_pro; ?></li><?php } ?>
									<li><span>Facilities :</span><?php if($c_gps) { echo 'GPS Distance System, '; } if($c_tee) { echo 'Driving Range ('.$c_tee.' Tees)'; }?></li>
									<?php if($hide) { ?><li><span>Par :</span>34</li><?php } ?>
									<li><span>Holes :</span><?php echo 'Regulation - '.$c_reg; ?></li>
								</ul>

							<?php if($tee_time_link) { ?><a href="<?php echo $tee_time_link; ?>" class="book-tee-time" target="_new">Book a Tee Time!</a><?php } ?>


                        </div>
                            
						
									
						

                             
                             <br clear="all" />
                                <?php 
                                $quick_facts = get_the_content();
                                if($quick_facts) {
                                	$quick_facts = nl2br($quick_facts);
                                    $quick_facts_more = $quick_facts; 
                                	$quick_facts = substr_replace($quick_facts,'…',200,-1) . "<a id='quick-facts-more'>more</a><br />";
                                	
                                ?>
								<div class="quick-fact-box">
									<a href="#" class="quick-fact">quick facts</a>
									<p class="quick-facts-start"><?php echo $quick_facts; ?></p>
									<p class="quick-facts-more"><?php echo $quick_facts_more; ?></p>
									
									<br class="clear" />
								</div>
								<?php } ?>
								<br class="clear" />

                                <div class="reviews-box">
                                	<ul>
                                    	<li><a href="#addreview" class="write-review">write a review</a></li>
                                        <li style="display:none;"><a href="#" class="print-review">print this review</a></li>
                                        <li><a href="/contact" class="report-inacccurate-info">report inaccurate course info</a></li>
                                    </ul>
                                </div>
                                <div class="social-links-container">
                                	<ul>
                                        <li><a name="fb_share" share_url="<?php the_permalink();?>" class="facebook-links">facebook</a></li>
                                        <li><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Check out these reviews of <?php the_title(); ?>&via=golfmix" class="twitter-links" target="_blank">twitter</a></li>
                                        <li><a href="<?php the_permalink();?>/feed/" class="rss-links">rss</a></li>
                                    </ul>
                                </div>
                                <?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
                               
                                <br class="clear" />
					</div>
					
						<?php if($featured_course=='yes' || isset($_REQUEST['fb'])) { } else { include('ads_content_468x60.php'); } ?>

					
						<?php if($beta) { ?>
						<div class="inner-page-search-box">
							<span class="inner-page-search"><input type="text" value="Search Reviews" onfocus="if(this.value=='Search Reviews'){this.value=''};" onblur="if(this.value==''){this.value='Search Reviews'};" /></span>
							<span><input type="submit" value="" class="inner-page-search-btn" /></span>
						</div>
							<br class="clear" />
						<?php } ?>

					<br class="clear" /> 
					
				<div class="reviews-comment-1" style="display:none;">
					<div class="reviews-comment-top"></div>
					<div class="reviews-comment-cen">
							<div class="inner-reviwes-left">
							<h3>reviews for <?php the_title();?></h3>
							</div>
							<div class="inner-reviews-right">
							<ul>
									<li>Sort by:</li>
									<li><a class="active" href="#">Trend</a></li>
									<li><a href="#">Date</a></li>
									<li><a href="#">Rating</a></li>
								</ul>
							</div>
							<br class="clear" />
							
						</div>
					<div class="reviews-comment-bot"></div>
				</div>
				
					<div class="inner-page-all-reviews-container" id="reviews">
					<div class="inner-reviwes-left">
							<h3>All Reviews <span>(<?php comments_number('0','1','%'); ?>)</span></h3>
						</div>
					<div class="inner-reviews-right">
							<ul>
							<li>Sort by</li>
							<li>[<a class="active" href="#">Date</a>]</li>
							<li>[<a href="#">Rating</a>]</li>
						</ul>
						</div>
					<br class="clear" />
				</div>
				
									<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
										<?php// the_content();?>
										<?php comments_template( '', true ); ?>
									<?php endwhile; // end of the loop. ?>
									
							<?php //if($beta) { ?>
							<script>
								$('#commentform').submit(function() {
								 	 if ($("input#1_rating").val() !== "0" && $("input#2_rating").val() !== "0" && $("input#3_rating").val() !== "0" && $("input#4_rating").val() !== "0" && $("input#5_rating").val() !== "0" && $("input#6_rating").val() !== "0" && $("textarea#comment").val() !== "" && $("input#_iti_ccf_post_plays").val() !== ""  && $("input#_iti_ccf_post_average_score").val() !== "") {
								 	 	$('#loader').show();
								 	 	$('#left-col .new-reviwes-bot table.ratings').hide();
								 	 	$('input#submit').hide();
								 	 	$('#review_form').hide();
								 	 	//$('input#submit').attr('disabled', 'disabled');
								        return true;
								      } else {
								      	alert("Please fill in all ratings categories and fields.");
								     	return false;
								      }
								      return false;
								});
								
								$('#quick-facts-more').click(function() {
								  $('.quick-facts-start').hide();
								  $('.quick-facts-more').show("fast");
								});	
							</script>
							<?php //} ?>


				</div>
				</div>
				
			<?php get_sidebar(); ?>
				
			<div class="clear"></div>
		</div>
			<!--/content--> 
	<?php } ?>
	
	<?php get_footer(); ?>
