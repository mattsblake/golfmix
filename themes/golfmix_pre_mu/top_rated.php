<?php 
// Take a list of post IDs and filter by Overall Rating or Specific Category

//print_r($nearby);

if($sortby == null ) { $sortby = $input['SORTBY']; }

global $api_search;
global $style;

foreach($nearby as $post_id) {

		if($style == 'page') {
				$query = "SELECT comment_id 
				  FROM wp_comments
				  WHERE wp_comments.comment_post_ID = $post_id 
				  	AND wp_comments.comment_approved = 1
				  	AND wp_comments.comment_date LIKE '%2011%'
				  ";
				  	
			$number = $wpdb->get_results($query);
			$number = count($number);
		} else {
			$number = get_comments_number($post_id);
		}
	
		if($number < 10 && $api_search !== 'true') { continue;}
		
		if($post_id == $exclude){ continue; }

		if($style == 'page') {
			$ratings = get_ratings_by_year($post_id, '2011');
		} else { 
			$ratings = get_ratings($post_id);
		}
		
		if($sortby == 'value') { $value = $ratings["Value"]; }
		else if($sortby == 'conditions') { $value = $ratings["Course Conditions"]; }
		else if($sortby == 'design') { $value = $ratings["Design"]; }
		else if($sortby == 'amenities') { $value = $ratings["Amenities"]; }
		else if($sortby == 'pace') { $value = $ratings["Pace of Play"]; }
		else { $value = $ratings["<strong>Overall Experience</strong>"]; }
		
		$course_id= get_post_meta($post_id, 'course_id',1);
		include('courses_call.php'); 
		
		$sort_by_rating[]= array(
			'post_id' => $post_id, 
			'rating' => $value,
			'price' => $c_feewe,
			'number' => $number
		);
	
		
}

//print_r($sort_by_rating);

$nearby = '';

if($sort_by_rating) {

	usort($sort_by_rating, 'sortByRating');
	
	foreach($sort_by_rating as $rating_array) {
	
		$nearby[]=$rating_array['post_id'];
	
	} 
 
	if($nearby !== '') { $nearby = array_reverse($nearby); }

}

/*Comparison to Sort by Rating */
function sortByRating($a, $b) {
return strcmp($a['rating'], $b['rating']);
}

//print_r($nearby);

?>