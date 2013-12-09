<?php 
global $market_distance;

global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('mobile-index.php');

} else { ?>

<div id="content">

	<div id="featured-top">
		<div id="featured-bestof">
			<h3>Best of golfmix <span>as reviewed by golfers</span><?php $input = array("overall", "value", "conditions", "design", "amenities", "pace");
				  shuffle($input);
				  $rand = trim($input[0]);
			?>
			<select id="topcourses_select_big">
				<option value="overall" <?php if($rand == 'overall') { echo 'selected'; } ?>>Overall Experience</option>
				<option value="value"<?php if($rand == 'value') { echo 'selected'; } ?>>Value</option>
				<option value="conditions"<?php if($rand == 'conditions') { echo 'selected'; } ?>>Course Conditions</option>
				<option value="design"<?php if($rand == 'design') { echo 'selected'; } ?>>Design</option>
				<option value="amenities"<?php if($rand == 'amenities') { echo 'selected'; } ?>>Amenities</option>
				<option value="pace"<?php if($rand == 'pace') { echo 'selected'; } ?>>Pace of Play</option>
			</select>
			</h3>

			<script>
			$('#topcourses_select_big').change(function() {
			 	 	$('#main-loader').show();
			 	 	$('#best-of-list').hide();
			 	 	var sortby = $('select#topcourses_select_big').val();
			 	 	//var location = $('select#topcourses_city').val(); 
			 	 	var location = 'Arizona';
			 	 	$.ajax({
					  type: "POST",
					  url: "<?php bloginfo('template_url'); ?>/top_rated_xml.php",
					  data: "ajax=1&market=<?php echo $market_coverage; ?>&lat=<?php echo $market_lat; ?>&lon=<?php echo $market_lon; ?>&distance=<?php echo $market_distance; ?>&limit=10&per=10&style=featured&sortby="+sortby,
					  success: function(html){
						 $('#main-loader').hide();										    
						 $("#best-of-list").html(html).show();
					  }
					});

			});
			</script>
			
			<div id="main-loader" style="display:none;"><img src="http://golfmix.com/wp-content/themes/golfmix/images/ajax-loader.gif" style="margin: 15px 280px;" /></div>

			<div id="best-of-list">
				<?php 
				$best_of = get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&market='.$market_coverage.'&lat='.$market_lat.'&lon='.$market_lon.'&distance='.$market_distance.'&limit=10&per=10&style=featured&sortby='.$rand; 
				echo print_top_courses($best_of);

				//$myGetData = '?ajax=1&distance=500&limit=10&per=10&style=featured&sortby='.$rand;
				//file_get_contents(get_bloginfo('template_url').'/top_rated_xml.php'.$myGetData);
				?>
			</div><!--best-of-list-->
		
		</div>
		
		<div id="featured-right">
			<?php include('promos.php'); ?>
			<div id="featured-events">
				<div class="box-holder box-home">
					<div class="daily-box-top"><h3>Upcoming Local Events<a href="<?php bloginfo('url'); ?>/events-calendar">Calendar</a></h3></div>
					<div class="daily-box-bottom-2">
						<?php echo do_shortcode('[eventlist limit=5 noresults="No Events Available"]'); ?>
					</div>
				</div>
			</div>		
		</div>

	</div>
	<div id="featured-mid">
		<div class="box-holder box-home">
			<div class="daily-box-top"><h3>Latest Video & Blogs<a href="<?php bloginfo('url'); ?>/blog">More</a></h3></div>
			<div class="daily-box-bottom-2">
				<?php include('recent-blogs.php'); ?>
			</div>
		</div>
		<div id="mid-box">
			<div class="box-holder box-home" id="review-of-the-day">
				<?php include('review-of-day.php'); ?>
			</div>

			<div class="box-holder box-home" id="email-subscribe">
				<?php include('subscribe.php'); ?>
			</div>
		</div><!--End Midbox-->
				
		<div class="box-home" id="featured-deal">
			<?php include('deal-of-week.php'); ?>
			<br class="clear" />
		</div>	
	</div>
	
	<div id="featured-courses">
        <?php query_posts('cat=6&tag=featured&posts_per_page=5&orderby=rand');
        	if ( have_posts() ) while ( have_posts() ) : the_post();
				$image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large');?>
				<div class="featured-course">
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" class="course-photo"></a>
					<a href="<?php the_permalink(); ?>" class="course-name"><?php the_title(); ?></a>
					<span><?php echo num_to_stars(get_average_rating($post->ID)); ?></span>
				</div>			
        <?php endwhile; ?>
	</div>
	
	<div id="featured-bottom">
		<div id="featured-reviews">
				<div class="box-holder box-home">
					<div class="daily-box-top"><h3>Recent Reviews</h3></div>
					<div class="daily-box-bottom-2">
						<?php include('recent-reviews.php'); ?>
					</div>
				</div>
		</div>
		<div id="featured-ads">
			<script type='text/javascript'>
			GA_googleFillSlot("Sidebar_300x250");
			</script>
			<div class="clear" style="height:15px;width:100%;"></div>
			<script type='text/javascript'>
			GA_googleFillSlot("Homepage_300x250");
			</script>
		</div>
	
	</div>

	<div class="clear"></div>
</div><!--/content--> 

<?php } ?>