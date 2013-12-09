<?php
 // Search by zip, lat, or city
global $zip, $distance, $lat, $lon, $city, $q, $nearby, $market_coverage;

if(isset($_REQUEST['debug'])) { echo 'Search by zip page:<br /> q:'.$q.'<br />zip:'.$zip.'<br />lat:'.$lat.'<br />lon:'.$lon;}

 
if($zip) {
  
	if(isset($_REQUEST['debug'])) { } else { $wpdb->hide_errors(); }
	$result = $wpdb->get_row( "SELECT LATITUDE, LONGITUDE FROM zipcodes WHERE zipcode='".$zip."'", ARRAY_A);
	if(isset($_REQUEST['debug'])) {print_r($result);}
		
	if($result) { 
	
		$nearby_courses = $wpdb->get_results( "SELECT POST_ID, (3959* ACOS( COS( RADIANS(".$result['LATITUDE'].") ) * COS( RADIANS( LATITUDE ) ) * COS( RADIANS( ".$result['LONGITUDE']." ) - RADIANS(LONGITUDE) ) + SIN( RADIANS(".$result['LATITUDE'].") ) * SIN( RADIANS( LATITUDE ) ) ) ) AS DISTANCE FROM courses HAVING DISTANCE<=".$distance." ORDER BY DISTANCE", ARRAY_A);   
		
		foreach($nearby_courses as $course) {
			$nearby[]=$course['POST_ID'];
		}
	
	}
 
} else if($city) {
 
	$wpdb->hide_errors();
	$result = $wpdb->get_row( "SELECT LATITUDE, LONGITUDE FROM zipcodes WHERE city='".$city."'", ARRAY_A);
		
	if($result) { 
	
		$nearby_courses = $wpdb->get_results( "SELECT POST_ID, (3959* ACOS( COS( RADIANS(".$result['LATITUDE'].") ) * COS( RADIANS( LATITUDE ) ) * COS( RADIANS( ".$result['LONGITUDE']." ) - RADIANS(LONGITUDE) ) + SIN( RADIANS(".$result['LATITUDE'].") ) * SIN( RADIANS( LATITUDE ) ) ) ) AS DISTANCE FROM courses WHERE LOCCITY LIKE '".$city."' HAVING DISTANCE<=".$distance." ORDER BY DISTANCE", ARRAY_A);   
		
		foreach($nearby_courses as $course) {
			$nearby[]=$course['POST_ID'];
		}
	
	} 
 

} else if($city_only) {
 
	$wpdb->hide_errors();
	$nearby_courses = $wpdb->get_results( "SELECT POST_ID FROM courses WHERE LOCCITY LIKE '".$city_only."' AND LOCSTATE LIKE '".$market_coverage."'", ARRAY_A); 
	
	foreach($nearby_courses as $course) {
		$nearby[]=$course['POST_ID'];
	}	
 
} else if($q) {
 
	$wpdb->hide_errors();
	$nearby_courses = $wpdb->get_results( "SELECT POST_ID  FROM courses WHERE COMPANY LIKE '%".$q."%' AND LOCSTATE LIKE '".$market_coverage."'", ARRAY_A); 
	
	foreach($nearby_courses as $course) {
		$nearby[]=$course['POST_ID'];
	}	
 

 
} else {

	$nearby_courses = $wpdb->get_results( "SELECT POST_ID, (3959* ACOS( COS( RADIANS(".$lat.") ) * COS( RADIANS( LATITUDE ) ) * COS( RADIANS( ".$lon." ) - RADIANS(LONGITUDE) ) + SIN( RADIANS(".$lat.") ) * SIN( RADIANS( LATITUDE ) ) ) ) AS DISTANCE FROM courses HAVING DISTANCE<=".$distance." ORDER BY DISTANCE", ARRAY_A);   
	
	//print_r($nearby_courses);
	
	foreach($nearby_courses as $course) {
		$nearby[]=$course['POST_ID'];
	}
	


}		

if(isset($_REQUEST['debug'])) {print_r($nearby);}
?>