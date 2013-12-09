<?php
/**
 * Template Name: Top Rated Test 2012
 *
 */

get_header(); ?>

		<div id="content">
		
			<div id="left-col">
			
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<h1 class="best-of-header"><?php the_title(); ?></h1>
			<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link" style="float:right;">', '</span>' ); ?>
			<?php include('share-buttons.php'); ?>
			
			<?php //the_content(); ?>
			<?php endwhile; // end of the loop. ?>
							
			<?php $input = array("overall", "value", "conditions", "design", "amenities", "pace");
				  $rand = trim($input[0]);
			?>
			
			<div class="top-courses-arizona">
			
			<h2><?php echo $market_name; ?>'s Top Rated Golf Courses by the golfmix community</h2>
			
			

			<?php
			//<select id="topcourses_city" style="float:left;">
			//	<option value="" selected>Arizona</option>
			//	<?php  
			//	$locations = $wpdb->get_col($wpdb->prepare("SELECT LOCCITY FROM courses"));
			//	$locations = array_unique($locations);
			//	sort($locations);
			//	foreach($locations as $location) {
			//		echo '<option value="'.$location.'">'.$location.'</option>';
			//	} 
			//	?/>
			//</select>
			?>
			
			<div style="float:right;">
		
				<label id="topcourses_label">Sort by Category:</label>
			
				<select id="topcourses_select_big">
					<option value="overall" <?php if($rand == 'overall') { echo 'selected'; } ?>>Overall Experience</option>
					<option value="value"<?php if($rand == 'value') { echo 'selected'; } ?>>Value</option>
					<option value="conditions"<?php if($rand == 'conditions') { echo 'selected'; } ?>>Course Conditions</option>
					<option value="design"<?php if($rand == 'design') { echo 'selected'; } ?>>Design</option>
					<option value="amenities"<?php if($rand == 'amenities') { echo 'selected'; } ?>>Amenities</option>
					<option value="pace"<?php if($rand == 'pace') { echo 'selected'; } ?>>Pace of Play</option>
				</select>
			
			</div>
			
			<br class="clear" />
			
			<script>
			$('#topcourses_select_big, #topcourses_city').change(function() {
			 	 	$('#main-loader').show();
			 	 	$('#top-courses-list-big').hide();
			 	 	var sortby = $('select#topcourses_select_big').val();
			 	 	//var location = $('select#topcourses_city').val(); 
			 	 	var location = 'Arizona';
			 	 	$.ajax({
					  type: "POST",
					  url: "<?php bloginfo('template_url'); ?>/top_rated_xml.php",
					  data: "ajax=1&market=<?php echo $market_coverage; ?>&lat=<?php echo $market_lat; ?>&lon=<?php echo $market_lon; ?>&distance=<?php echo $market_distance; ?>&limit=18&per=18&style=page&year=2012&sortby="+sortby,
					  success: function(html){
						 $('#main-loader').hide();										    
						 $("#top-courses-list-big").html(html).show();
					  }
					});

			});
			</script>

		
			<br class="clear" />
			<div id="main-loader" style="display:none;"><img src="http://golfmix.com/wp-content/themes/golfmix/images/ajax-loader.gif" style="margin: 13px 350px;" /></div>

				
			<div id="top-courses-list-big">
				<?php 
				include(get_bloginfo('template_url').'/top_rated_xml.php?ajax=1&market='.$market_coverage.'&lat='.$market_lat.'&lon='.$market_lon.'&distance='.$market_distance.'&limit=18&per=18&style=page&year=2012&sortby='.$rand); 
				?>
			</div>
			
			<br class="clear" />
		
		</div>

      
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
