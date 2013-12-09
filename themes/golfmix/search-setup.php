<?php 
$input = array( 'ID' => $_REQUEST['id'],'Q' => $_REQUEST['q'], 'PER' => $_REQUEST['per'], 'PAGE' => $_REQUEST['page'], 'REVIEWS' => $_REQUEST['reviews'], 'REVIEW_ID' => $_REQUEST['r_id'], 'ZIP' => $_REQUEST['zip'], 'DISTANCE' => $_REQUEST['distance'], 'LAT' => $_REQUEST['lat'], 'LON' => $_REQUEST['lon'], 'CITY' => $_REQUEST['city'], 'FEATURED' => $_REQUEST['featured'], 'SORTBY' => $_REQUEST['sortby'], 'LIMIT' => $_REQUEST['limit'], 'FILTER' => $_REQUEST['filter']);

	if(isset($_REQUEST['debug'])) { print_r($input); }


	global $zip, $distance, $lat, $lon, $city, $q;

	if($input['Q'] !== null) {	
		$is_zip = preg_match("#[0-9]{5}#", $input['Q']);
		$is_city = $wpdb->get_results( "SELECT DISTINCT `CITY` FROM `courses`", ARRAY_A);
		foreach($is_city as $findcity){ $cities[] = $findcity['CITY']; }
				
		if($is_zip == 1) { $zip = $input['Q']; }
		elseif(in_array(ucfirst($input['Q']), $cities) !== FALSE ) { $city = $input['Q']; }
		else { $q =  $input['Q']; }
		
		
	} else {
		$zip = $input['ZIP'];
		$city = $input['CITY'];
		$lat = $input['LAT'];
		$lon = $input['LON'];
	}
	
	if(isset($_REQUEST['debug'])) { echo 'q:'.$q.'<br />zip:'.$zip.'<br />lat:'.$lat.'<br />lon:'.$lon;}

			
	if($input['DISTANCE'] !== null) { $distance = $input['DISTANCE']; } else { $distance = 10;}

	include('search_by_zip.php');
	global $nearby;
	if(isset($_REQUEST['debug'])) {print_r($nearby);}
	
	global $api_search;
	if($distance < 50 ) { $api_search = 'true'; }
	
	if($input['SORTBY'] == 'price' && $nearby !== null) { include('filter_by_price.php'); } 
	elseif($input['SORTBY'] !== null && $nearby !== null) { include('top_rated.php'); }
	
	if(!$nearby) { 

		$args = array( 'meta_key' => 'yeild_no', 'meta_value' => 'results' );

	} else { 
		$total = $nearby;
		foreach($nearby as $near) {
			$list.= $near.',';
		}
		$list = substr($list, 0, -1);
		if(isset($_REQUEST['debug'])) { print_r($nearby); }
		
		global $paged;
     	if($input['PAGE'] !== null) { $paged = $input['PAGE'];}
     	if(empty($paged) || $paged == 0) { $paged = 1; }
		if(isset($_REQUEST['debug'])) { echo 'page:'.$paged; }

		$args = array( 'post__in'=> $nearby, 'orderby' => 'post__in', 'posts_per_page' => 10, 'paged' => $paged );
		
	}
			
			global $search_query;
			$search_query = new WP_Query($args);
?>