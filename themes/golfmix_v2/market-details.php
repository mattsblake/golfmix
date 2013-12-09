<?php
// Market Details
global $blog_id;
global $market_name;
global $market_coverage;
global $market_distance;
global $market_lat;
global $market_lon;

$result = $wpdb->get_row( "SELECT *  FROM `market_details` WHERE `blog_id` LIKE '".$blog_id."'", ARRAY_A);

//print_r($result);

if($result) { 
	$market_name = $result['market_name']; 
	$market_coverage = $result['market_coverage']; 
	$market_distance = $result['market_distance']; 
	$market_lat = $result['market_lat']; 
	$market_lon = $result['market_lon']; 

} else { 
	$market_name = 'Arizona';
	$market_coverage = 'AZ';
	$market_distance = 500;
	$market_lat = '33.448631'; 
	$market_lon = '-112.07428'; 
}
?>