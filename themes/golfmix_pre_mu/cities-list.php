				<div class="courses-box-by-city">

					<div class="recent-reviews-heading">
						<h3>browse courses by city</h3>
					</div>

					<div class="city-list-container">

						<div class="city-list">
							<ul class="sortbycity">
								<?php  
								$locations = $wpdb->get_col($wpdb->prepare("SELECT LOCCITY FROM courses"));
								
								$locations = array_count_values($locations); 
							  	arsort($locations);
							  	//print_r($locations);
								
								$count = 0;
								foreach($locations as $key => $val) {
									$location = $key; 
									$count = $count + 1;
									if($count <= 15) {
									?>
										<li><a href="<?php echo get_bloginfo('url').'/golf-courses?location='.$location; ?>" ><?php echo $location; ?></a></li>
								<?php
									if($count == 5 || $count == 10) { echo '</ul><ul class="sortbycity">'; }
									}
								 } ?>
							</ul>
						</div>

					</div>

					<div class="city-search-box">

						<ul>

						<?php //get_search_form(); ?>
						</ul>

					</div>

				</div>