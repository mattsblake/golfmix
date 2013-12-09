<?php 
// Take a list of post IDs and filter by Overall Rating or Specific Category

//print_r($nearby);

if($sortby == null ) { $sortby = $input['SORTBY']; }

foreach($nearby as $post_id) {
		
		if($post_id == $exclude){ continue; }
		
		$course_id= get_post_meta($post_id, 'course_id',1);
		$wpdb->hide_errors();
		$result = $wpdb->get_row( "SELECT FEEWE FROM courses WHERE COURSE_ID = ".$course_id."", ARRAY_A);
					
		if(!$result) { } else { 	
			$c_feewe = $result['FEEWE'];
			if($c_feewe <= 50) { $c_feewe = '$'; } 
			elseif( $c_feewe <= 100) { $c_feewe = '$$'; } 
			elseif( $c_feewe <= 200) { $c_feewe = '$$$'; }
			else { $c_feewe = '$$$$'; }
		}

		
		$sort_by_price[]= array(
			'post_id' => $post_id, 
			'price' => $c_feewe
		);
	
		
}

//print_r($sort_by_price);

usort($sort_by_price, 'sortByPrice');
 function sortByPrice($a, $b) {
   return strcmp($a['price'], $b['price']);
 }
 
$nearby = '';

foreach($sort_by_price as $price_array) {

	$nearby[]=$price_array['post_id'];

} 
 
if($input['FILTER'] == 'high') { $nearby = array_reverse($nearby); }

//print_r($nearby);

?>