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
