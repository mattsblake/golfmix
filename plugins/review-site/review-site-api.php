<?php

	/* 
	WP Review Site API : User-callable functions
	*/

	/*
	 * Returns a keyed array of average ratings for a specified post. If used within The Loop with 
	 * no arguments, it will return the ratings for the post being displayed. The post ID can be 
	 * overridden with the $custom_id parameter. The format of the array:
	 * array( [Category 1] => 2.5, [Category 2] => 3.2, [Category 3] => 4.5 )
	 *
	 * Use num_to_stars to convert numeric values to star images.
	 */
	function get_ratings($custom_id = null) {
		global $id, $wpdb;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$categories = get_option('rs_categories');
		
		$query = "SELECT rating_id, SUM(rating_value) / COUNT(rating_value) AS `rating_value` 
				  FROM {$wpdb->ratings} 
				  INNER JOIN {$wpdb->comments} 
				  	ON {$wpdb->comments}.comment_ID = {$wpdb->ratings}.comment_id 
				  WHERE {$wpdb->comments}.comment_post_ID = $pid 
				  	AND {$wpdb->comments}.comment_approved = 1
				  GROUP BY rating_id
				  ORDER BY rating_id";
				  	
		$result = $wpdb->get_results($query);
		
		$show = get_post_meta($pid, '_rs_categories', true);
		
		$ratings = array();
		foreach ($categories as $cid => $cat) {
			if (!empty($show) && in_array($cid, $show))		
				$ratings[$cat] = 0;
		}
				
		if (count($result) > 0) {
			foreach ($result as $rating) {
				if (!empty($show) && in_array($rating->rating_id, $show))
					$ratings[$categories[$rating->rating_id]] = $rating->rating_value;
			}
		}
				
		return $ratings;
	}


	function get_ratings_by_year($custom_id = null, $year) {
		global $id, $wpdb;
		$pid = $id;
		$pyear = $year;
		if($pyear == '') { $pyear = '2011'; }
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$categories = get_option('rs_categories');
		
		$query = "SELECT rating_id, SUM(rating_value) / COUNT(rating_value) AS `rating_value` 
				  FROM {$wpdb->ratings} 
				  INNER JOIN {$wpdb->comments} 
				  	ON {$wpdb->comments}.comment_ID = {$wpdb->ratings}.comment_id 
				  WHERE {$wpdb->comments}.comment_post_ID = $pid 
				  	AND {$wpdb->comments}.comment_approved = 1
				  	AND {$wpdb->comments}.comment_date LIKE '%$pyear%'
				  GROUP BY rating_id
				  ORDER BY rating_id";
				  	
		$result = $wpdb->get_results($query);
		
		$show = get_post_meta($pid, '_rs_categories', true);
		
		$ratings = array();
		foreach ($categories as $cid => $cat) {
			if (!empty($show) && in_array($cid, $show))		
				$ratings[$cat] = 0;
		}
				
		if (count($result) > 0) {
			foreach ($result as $rating) {
				if (!empty($show) && in_array($rating->rating_id, $show))
					$ratings[$categories[$rating->rating_id]] = $rating->rating_value;
			}
		}
				
		return $ratings;
	}
		
	/*
	 * Returns the average rating for a post
	 */
	function get_average_rating($custom_id = null) {
		global $id, $wpdb;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
			
		$ratings = get_ratings($pid);
		
		$sum = 0;
		$count = 0;
		foreach ($ratings as $rating) {
			if ($rating > 0) {
				$sum += $rating;
				$count++;		
			}
		}
			
		return ($count > 0) ? $sum / $count : 0;
	}
		
	/*
	 * Outputs an unordered list with average ratings for a specified post. If used within 
	 * The Loop with no arguments, it will display the ratings for the post being displayed. 
	 * The post ID can be overridden with the $custom_id parameter. The output format will be:
	 * 
	 * <ul class="ratings">
	 *  <li><label class="rating_label">Category 1</label> <span class="rating_value"><img src="star.png">...</span></li>
	 *  <li><label class="rating_label">Category 2</label> <span class="rating_value"><img src="star.png">...</span></li>
	 *  <li><label class="rating_label">Category 3</label> <span class="rating_value"><img src="star.png">...</span></li>
	 * </ul>
	 * 
	 */

	function ratings_list($custom_id = null, $return = false) {
		global $id, $wpdb;
		$i=1;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
					
		$ratings = get_ratings($pid);
		if (count($ratings) == 0) return;
			
		$html = '<ul class="ratings">';
		foreach ($ratings as $cat => $rating) {
			if($i<6){
				$html .= '<li>';
				}if($i==6){
				$html .= '<li class="over-all-rating-box-1">';
			}
			$html .= '<label class="rating_label">' . $cat .':</label> ';
			$html .= '<span class="rating_value">';
			
			if ($rating > 0)
				$html .= num_to_stars($rating);
			else
				$html .= 'No Ratings';
			
			$html .= '</span></li>';
		$i++;
		}
		$html .= "</ul>";
		
		if ($return)
			return $html;
		echo $html;
		
	}
	
	
		
	/*
	 * Outputs a table with average ratings for a specified post. If used within 
	 * The Loop with no arguments, it will display the ratings for the post being displayed. 
	 * The post ID can be overridden with the $custom_id parameter. The output format will be:
	 * 
	 * <table class="ratings">
	 *  <tr><td class="rating_label">Category 1</td><td class="rating_value"><img src="star.png">...</td></tr>
	 *  <tr><td class="rating_label">Category 2</td><td class="rating_value"><img src="star.png">...</td></tr>
	 *  <tr><td class="rating_label">Category 3</td><td class="rating_value"><img src="star.png">...</td></tr>
	 * </table>
	 * 
	 */
	function ratings_table($custom_id = null, $return = false) {
		global $id, $wpdb;
		$i=1;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$ratings = get_ratings($pid);
		if (count($ratings) == 0) return;
			
		$html = '<table class="ratings">';
		foreach ($ratings as $cat => $rating) {
			
			if($i<6){
				$html .= '<tr>';
			}if($i==6){
				$html .= '<tr class="over-all-rating-box-1">';
				$html .= '<td class="rating_labelleft"></td>';
			}
			
			$html .= '<td class="rating_label">' . $cat . '</td>';
			$html .= '<td class="rating_value">';
			
			if ($rating > 0)
				$html .= num_to_stars($rating);
			else
				$html .= 'No Ratings';
			
			$html .= '</td>';
			if($i==6){
				$html .= '<td class="rating_labelright"></td>';
			}
			$html .= '</tr>';
			
			
			$i++;

		}
		$html .= "</table>";

		if ($return)
			return $html;
		echo $html;

	}
	
	/*
	 * Returns a keyed array of ratings for a specified comment. The format of the array:
	 * array( [Category 1] => 2.5, [Category 2] => 3.2, [Category 3] => 4.5 )
	 *
	 * Use num_to_stars to convert numeric values to star images.
	 */
	function get_comment_ratings($custom_id = null) {
		global $wpdb, $comment;
		$pid = $comment->comment_ID;
		if (is_numeric($custom_id))
			$pid = $custom_id;
					
		$categories = get_option('rs_categories');
		
		$query = "SELECT rating_id, rating_value AS `rating_value`, {$wpdb->comments}.comment_post_ID AS `comment_post_ID`
				  FROM {$wpdb->ratings} 
				  INNER JOIN {$wpdb->comments} 
				  	ON {$wpdb->comments}.comment_ID = {$wpdb->ratings}.comment_id 
				  WHERE {$wpdb->comments}.comment_ID = $pid 
				  ORDER BY rating_id";
				  	
		$result = $wpdb->get_results($query);
		
		if (count($result) == 0) return array();
		
		$pid = $result[0]->comment_post_ID;

		$show = get_post_meta($pid, '_rs_categories', true);

		$ratings = array();
		foreach ($categories as $cid => $cat) {
			if (!empty($show) && in_array($cid, $show))		
				$ratings[$cat] = 0;
		}
				
		if (count($result) > 0) {
			foreach ($result as $rating) {
				if (!empty($show) && in_array($rating->rating_id, $show))
					$ratings[$categories[$rating->rating_id]] = $rating->rating_value;
			}
		}
		return $ratings;
	}
	
	/*
	 * Returns the average of the ratings associated with a single review
	 */
	function get_average_comment_rating($custom_id = null) {
		global $wpdb, $comment;
		$pid = $comment->comment_ID;
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$ratings = get_comment_ratings($pid);
		$sum = 0;
		$count = 0;
		foreach ($ratings as $rating) {
			if ($rating > 0) {	
				$sum += $rating;
				$count++;
			}
		}
		
		return ($count > 0) ? $sum / $count : 0;	
	}
	
	/*
	 * Outputs an unordered list with ratings given with a specified comment. If used within 
	 * the comment loop with no arguments, it will display the ratings for the comment being displayed. 
	 * The comment ID can be overridden with the $custom_id parameter. The output format will be:
	 * 
	 * <ul class="ratings">
	 *  <li><label class="rating_label">Category 1</label> <span class="rating_value"><img src="star.png">...</span></li>
	 *  <li><label class="rating_label">Category 2</label> <span class="rating_value"><img src="star.png">...</span></li>
	 *  <li><label class="rating_label">Category 3</label> <span class="rating_value"><img src="star.png">...</span></li>
	 * </ul>
	 * 
	 */
	 
	 function comment_ratings_list($custom_id = null, $return = false) {
		global $comment, $wpdb;
		$i=1;
		$cid = $comment->comment_ID;
		if (is_numeric($custom_id))
			$cid = $custom_id;
				
		$ratings = get_comment_ratings($cid);
		if (count($ratings) == 0) return;

		$html = '<ul class="ratings">';
		foreach ($ratings as $cat => $rating) {
			if($i<6){
				$html .= '<li>';
				}if($i==6){
				$html .= '<li class="over-all-rating-box-1">';
			}
			$html .= '<label class="rating_label">' . $cat . ':</label> ';
			$html .= '<span class="rating_value">';
			
			if ($rating > 0)
				$html .= num_to_stars($rating);
			else
				$html .= 'Not Rated';
			
			$html .= '</span>';
			$html .= '</li>';
			$i++;
		}
		$html .= "</ul>";
		
		if ($return)
			return $html;
		echo $html;

	}
	 
	 
	 
	 
	 
	

	
	/*
	 * Outputs a table with ratings given with a specified comment. If used within 
	 * the comment loop with no arguments, it will display the ratings for the comment being displayed. 
	 * The comment ID can be overridden with the $custom_id parameter. The output format will be:
	 * 
	 * <table class="ratings">
	 *  <tr><td class="rating_label">Category 1</td><td class="rating_value"><img src="star.png">...</td></tr>
	 *  <tr><td class="rating_label">Category 2</td><td class="rating_value"><img src="star.png">...</td></tr>
	 *  <tr><td class="rating_label">Category 3</td><td class="rating_value"><img src="star.png">...</td></tr>
	 * </table>
	 * 
	 */
	function comment_ratings_table($custom_id = null, $return = false) {
		global $comment, $wpdb;
		$i=1;
		$cid = $comment->comment_ID;
		if (is_numeric($custom_id))
			$cid = $custom_id;
				
		$ratings = get_comment_ratings($cid);
		if (count($ratings) == 0) return;
			
		$html = '<table class="ratings">';
		foreach ($ratings as $cat => $rating) {
			if($i<6){
				$html .= '<tr>';
			}if($i==6){
				$html .= '<tr class="over-all-rating-box-1">';
			}
			$html .= '<td class="rating_label-1">' . $cat . '</td>';
			$html .= '<td class="rating_value-1">';
			
			if ($rating > 0)
				$html .= num_to_stars($rating);
			else
				$html .= 'Not Rated';
			
			$html .= '</td>';
			$html .= '</tr>';
		$i++;
		}
		$html .= "</table>";
		
		if ($return)
			return $html;
		echo $html;

	}
	
	/* 
	 * Displays the HTML and JavaScript to collect star ratings within the comment form.
	 * Styled with an unordered list.
	 */
	function ratings_input_list($return = false) {
	
		global $id;
		
		$categories = get_option('rs_categories');
		$show = get_post_meta($id, '_rs_categories', true);
		if (empty($show)) return;
	
		$html = '<ul class="ratings">';
		foreach ($categories as $cid => $cat) {
			if (in_array($cid, $show)) {
				$html .= '<li>';
				$html .= '<label class="rating_label" style="float: left">' . $cat . '</label> ';
				$html .= '<div class="rating_value">';
				$html .= '<a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_1" title="1" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_2" title="2" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_3" title="3" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_4" title="4" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_5" title="5" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <input type="hidden" id="' . $cid . '_rating" name="' . $cid . '_rating" value="0" />';
				$html .= '</div>';
				$html .= '</li>';
			}
		}
		$html .= "</ul>";
		
		if ($return)
			return $html;
		echo $html;
	
	}
	
	/* 
	 * Displays the HTML and JavaScript to collect star ratings within the comment form.
	 * Styled with a table.
	 */
	function ratings_input_table($return = false) {

		global $id;
		$i;
		$categories = get_option('rs_categories');
		$show = get_post_meta($id, '_rs_categories', true);
		if (empty($show)) return;
	
		$html = '<table class="ratings" cellpadding="8">';
		foreach ($categories as $cid => $cat) {
			if (in_array($cid, $show)) {
				if($i<6){
				$html .= '<tr>';
			}if($i==6){
				$html .= '<tr class="over-all-rating-box-1">';
			}
				$html .= '<td class="rating_label">' . $cat . '</td>';
				$html .= '<td class="rating_value">';
				
				$html .= '<a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_1" title="1" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_2" title="2" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_3" title="3" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_4" title="4" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <a onclick="rateIt(this, ' . $cid . ')" id="' . $cid . '_5" title="5" onmouseover="rating(this, ' . $cid . ')" onmouseout="rolloff(this, ' . $cid . ')"></a>
	                  <input type="hidden" id="' . $cid . '_rating" name="' . $cid . '_rating" value="0" />';
					  
				$html .= '</td>';
				$html .= '</tr>';
			}
			$i++;
		}
		$html .= "</table>";	

		if ($return === true)
			return $html;
		echo $html;
	
	}
	
	/*
	* Displays the number of unique raters whose average rating for this post was 3 stars or higher
	*/
	function positive_reviews($custom_id = null) {
	
		$ratings = get_positive_negative_count($custom_id);
		echo $ratings['positive'];
		
	}
	
	/*
	* Displays the number of unique raters whose average rating for this post was less than 3 stars
	*/
	function negative_reviews($custom_id = null) {
	
		$ratings = get_positive_negative_count($custom_id);
		echo $ratings['negative'];

	}
	
	/*
	* Returns an array containing the positive and negative review counts for a post
	*/
	function get_positive_negative_count($custom_id = null) {
		global $id, $wpdb;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$categories = get_option('rs_categories');
		
		$query = "SELECT AVG(rating_value) AS `rating_value` 
				  FROM {$wpdb->ratings} 
				  INNER JOIN {$wpdb->comments} 
				  	ON {$wpdb->comments}.comment_ID = {$wpdb->ratings}.comment_id 
				  WHERE {$wpdb->comments}.comment_post_ID = $pid 
				  	AND {$wpdb->comments}.comment_approved = 1
				  	AND {$wpdb->ratings}.rating_value > 0
				  GROUP BY {$wpdb->ratings}.comment_id";

		$result = $wpdb->get_results($query);

		$positive = 0; $negative = 0;
		if (count($result) > 0) {
			foreach ($result as $row) {
				if ($row->rating_value >= 3)
					$positive++;
				else if ($row->rating_value > 0)
					$negative++;
			}
		}

		return array('positive' => $positive, 'negative' => $negative);

	}
	
	/*
	* Displays a link to the URL saved with the post for a "Visit Site" type affiliate link
	*/
	function visit_site_link($text = 'Visit This Site', $custom_id = null) {
		global $id, $wpdb;
		$pid = $id;
		if (is_numeric($custom_id))
			$pid = $custom_id;
		
		$url = get_post_meta($pid, '_rs_link', true);
		if (!empty($url) && $url != 'http://')
			echo '<a href="' . $url . '" target="_blank" rel="nofollow">' . $text . '</a>';		
	}
	
	/* Displays a post icon */
	function rs_post_icon($custom_id = null) {
		global $id;
		$pid = $id;
		if (is_numeric($custom_id)) 
			$pid = $custom_id;
		
		$icon = get_post_meta($pid, '_rs_icon', true);
		$link = get_post_meta($pid, '_rs_link', true);
		
		$html = "";
		if (!empty($icon)) {
			if (!empty($link) && $link != 'http://') 
				$html .= '<a href="' . $link . '" target="_blank" rel="nofollow">';
			$html .= '<img src="' . $icon . '" alt="Post Icon" />';
			if (!empty($link) && $link != 'http://') 
				$html .= '</a>';
		}
		
		echo $html;
	}

	/* 
	* Displays a comparison table of the top $count posts
	*/
	function rs_comparison_table($count = 5, $link_text = 'Visit Site', $category = null) {
		
		global $wpdb;
						
		$sort = get_option('rs_sort');
		if ($sort == 'default') {
			add_filter('posts_fields', 'rs_weighted_fields');
			add_filter('posts_join', 'rs_weighted_join');
			add_filter('posts_groupby', 'rs_weighted_groupby');
			add_filter('posts_orderby', 'rs_weighted_orderby');
		} else if ($sort == 'comments') {
			remove_filter('posts_orderby', 'rs_comments_orderby');
			add_filter('posts_fields', 'rs_weighted_fields');
			add_filter('posts_join', 'rs_weighted_join');
			add_filter('posts_groupby', 'rs_weighted_groupby');
			add_filter('posts_orderby', 'rs_weighted_orderby');
		}

		$params = "numberposts=$count&suppress_filters=0";
		if (!empty($category))
			$params .= '&category=' . $category;

		$posts = get_posts($params);
		
		if ($sort == 'default') {
			remove_filter('posts_fields', 'rs_weighted_fields');
			remove_filter('posts_join', 'rs_weighted_join');
			remove_filter('posts_groupby', 'rs_weighted_groupby');
			remove_filter('posts_orderby', 'rs_weighted_orderby');
		} else if ($sort == 'comments') {
			add_filter('posts_orderby', 'rs_comments_orderby');
		}
		
		if (count($posts) > 0) {
		
			$fields = get_option('rs_comparison_embed_fields');
			$fields = split(",", $fields);
			
			/*echo "<table class='comparison_table'>";
			echo "<tr>";
			echo "<th>Rank</th><th>Name</th>";
			
			/*foreach ($fields as $field) {
				echo "<th>" . $field . "</th>";
			}*/
			
			//echo "<th>Rating</th><th>More Info</th>";
			//echo "</tr>";
			
			$i = 1;		
			$class = 'alternate';
			echo "<ul>";
			foreach ($posts as $post) {
				//$class = ($class == 'alternate') ? '' : 'alternate';
				//$rating = get_average_rating($post->ID);
				
				$str1=get_post_meta($post->ID,"sociallinks", true);
				//$str3= get_post_meta($post->ID,"Block #9", true);
				$image = get_bloginfo('template_url').'/images/golfmix_icon_med.jpg';
				
				$course_id= get_post_meta($post->ID, 'course_id',1);
				 $result = $wpdb->get_row( "SELECT * FROM courses WHERE COURSE_ID = ".$course_id."", ARRAY_A);

				 if(!$result) { 
				 
				 	echo '<strong>Missing Course ID</strong>';
				 
				 } else { 	
								
					$c_name = $result['COMPANY'];			 
					$c_address1 = $result['LOCADD1'];		 
					$c_address2 = $result['LOCADD2'];		 
					$c_city = $result['LOCCITY'];			
					$c_state = $result['LOCSTATE'];			 
					$c_zip = $result['LOCZIP'];				 
					$c_phone = $result['WORK_PHONE'];	
					$c_site = $result['WEBSITE'];
					$c_type = $result['TYPE'];
					$c_cat = $result['CAT'];
					$c_reg = $result['REG'];
					$c_exe = $result['EXE'];
					$c_par3 = $result['PAR3'];
					$c_year = $result['OPYEAR'];
					$c_feewe = $result['FEEWE'];
					$c_feewd = $result['FEEWD'];
					$c_feetw = $result['FEETW'];
					$c_designer = $result['ARCHNAME'];
					$c_gps = $result['GPS'];
					$c_tee = $result['TEE'];
					$c_pro = $result['PRO'];
				 }
				 
				global $turn_flickr_off;
				$turn_flickr_off = null;
				$turn_flickr_off = get_post_meta($post->ID, 'turn_flickr_off', 1);
				

				global $c_name_encode;
				$c_name_encode = str_replace(" ", "+", $c_name);							
				require_once("/home/golfmix/public_html/wp-content/themes/golfmix/phpflickr/phpFlickr.php");
				$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
				$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"1"));
																						
				if($recent['total'] > 0 && $turn_flickr_off == '') {
								
				$pcount = 0;
				foreach ($recent['photo'] as $photo) {
					$pcount = $pcount + 1;
					if($pcount == 1) {
						$pid = $photo['id'];
						$pserver = $photo['server'];
						$pfarm = $photo['farm'];
						$ptitle = $photo['title'];
						$psecret = $photo['secret'];
				
						$image = 'http://farm'.$pfarm.'.static.flickr.com/'.$pserver.'/'.$pid.'_'.$psecret.'_z.jpg';
					}
				}
				} 

				$comments = $wpdb->get_row("SELECT comment_count as count FROM wp_posts WHERE ID = '$post->ID'");
				$commentcount = $comments->count;
				//if($commentcount == 1): $commenttext = 'Review'; endif;
				//if($commentcount > 1 || $commentcount == 0): $commenttext = 'Reviews'; endif;
 
				$str='
				<li class="li-course">
				<div class="top-courses-col-1"><div class="img-container"><img border="0" alt="" src='. $image.'></div></div>
				<div class="top-courses-col-2">
				<h5><a href='. get_permalink($post->ID) .'>'.$post->post_title.'</a></h5>
				 	<ul>
						<li>'. $c_address1 .'</li>
						<li>'. $c_address2 .'</li>
						<li>'. $c_city .', '. $c_state .' '. $c_zip .'</li>
						<li>'. $c_phone .'</li>
						<li><a href="http://'. $c_site .'" target="_blank">'. $c_site .'</a></li>
					</ul>
			</div>
				<div class="top-courses-col-3">
				<ul>
					<li><a  name="fb_share" share_url="'.get_permalink($post->ID).'" class="rss-link-3">Facebook Share</a></li>
					<li><a href="http://twitter.com/share?url='.get_permalink($post->ID).'&text=Check out this review of '.get_the_title($post->ID).'&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix">Twitter Share</a></li>
					<li><a href="#" class="refresh-link-3">Email Link</a></li>
				</ul>				
					<div style="color: #EE780E;margin-top:7px;">Reviews ('.$commentcount.')</div>
					<div style="margin-top:7px;">'.num_to_stars(get_average_rating($post->ID)).'</div>
				</div>
			</li>
				';
				print($str);
				
				
				
				//echo "<tr class='$class'>";
				//$img = WP_PLUGIN_URL . "/review-site/images/" . $i . ".png";
				//echo "<td class='comparison_rank'><img src='$img' alt='$i' /></td>";
				
				//echo "<td class='comparison_title'>" . $post->post_title . "</td>";
				
				/*foreach ($fields as $field) {
					$val = get_post_meta($post->ID, $field, true);
					echo "<td class='comparison_field'>" . $val . "</td>";
				}*/
				
				//$rating = get_average_rating($post->ID);
				
				//echo "<td class='comparison_average'>" . num_to_stars($rating) . "</td>";
				//echo "<td class='comparison_links'>";
				
				//echo "<a href='" . get_permalink($post->ID) . "'>Read Reviews</a><br />";
				//echo visit_site_link($link_text, $post->ID);
				
				//echo "</td>";
				//echo "</tr>";
				$i++;
			}
			
			echo "</ul>";
			
		}
		
	}
	
	/* Returns a Google Map */
	function rs_gmap($custom_id = null, $return = false) {
	
		global $post;
		$pid = $post->ID;
		if (is_numeric($custom_id))
			$pid = $custom_id;
	
		$width = get_option('rs_map_width');
		$height = get_option('rs_map_height');
		$zoom = get_option('rs_map_zoom');
		
		$address = get_post_meta($pid, 'mapaddress', true);
		if (empty($address)) return;

		$address = str_replace("\r\n", " ", $address);
		$address = str_replace("\r", " ", $address);
		$address = str_replace("\n", " ", $address);
		
		$html = <<<EOD

			<div id="map" style="width: $width; height: $height"></div>
			
			<script type="text/javascript">
			
				var map = new GMap(document.getElementById("map"));
				map.addControl(new GSmallZoomControl());
				map.addControl(new GMapTypeControl());
				geocoder = new GClientGeocoder();
				geocoder.getLocations("$address", mapaddr);
			
				function mapaddr(response) {
					addr = response.Placemark[0];
					point = new GLatLng(addr.Point.coordinates[1], addr.Point.coordinates[0]);
					var marker = new GMarker(point);
					map.addOverlay(marker);
					map.centerAndZoom(point, $zoom);
				}
			
			</script>
EOD;
	
		if ($return === true)
			return $html;
		echo $html;	
	
	}
	
	function round_to_half($num = 0) {
		return floor($num * 2) / 2;
	}
	
	function num_to_stars($num) {
	
		$stars = round_to_half($num);
		$num = round($num, 2);
	
		$html = "";
		for ($i = 0; $i < floor($stars); $i++)
			$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star.png" alt="' . $num . '" />';

		if (floor($stars) != $stars)
			$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star-half.png" alt="' . $num . '" />';
	
		if (ceil($stars) < 5)
			for ($i = ceil($stars); $i < 5; $i++)
				$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star-empty.png" alt="' . $num . '" />';
		
		return $html;
	}

	function num_to_stars_mobile($num) {
	
		$stars = round_to_half($num);
		$num = round($num, 2);
	
		$html = "";
		for ($i = 0; $i < floor($stars); $i++)
			$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star_filled.png" alt="' . $num . '" />';

		if (floor($stars) != $stars)
			$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star_half.png" alt="' . $num . '" />';
	
		if (ceil($stars) < 5)
			for ($i = ceil($stars); $i < 5; $i++)
				$html .= '<img src="' . WP_PLUGIN_URL . '/review-site/images/star_empty.png" alt="' . $num . '" />';
		
		return $html;
	}
