<?php
/**
 * Template Name: Courses XML
 *
**/

// create doctype
$dom = new DOMDocument("1.0");

// display document in browser as plain text 
// for readability purposes
header("Content-Type: text/xml");

$input = array( 'ID' => $_REQUEST['id'],'Q' => $_REQUEST['query'], 'PER' => $_REQUEST['per'], 'PAGE' => $_REQUEST['page'], 'REVIEWS' => $_REQUEST['reviews'], 'REVIEW_ID' => $_REQUEST['r_id'], 'ZIP' => $_REQUEST['zip'], 'DISTANCE' => $_REQUEST['distance'], 'LAT' => $_REQUEST['lat'], 'LON' => $_REQUEST['lon'], 'CITY' => $_REQUEST['city'], 'FEATURED' => $_REQUEST['featured'], 'SORTBY' => $_REQUEST['sortby'], 'LIMIT' => $_REQUEST['limit'], 'FILTER' => $_REQUEST['filter']);
//print_r($input);

// create root element
$root = $dom->createElement("rss");
$dom->appendChild($root);

// create attribute node
$version = $dom->createAttribute("version");
$root->appendChild($version);

// create attribute value node
$versionvalue = $dom->createTextNode("2.0");
$version->appendChild($versionvalue);

// create child element
$channel = $dom->createElement("channel");
$root->appendChild($channel);

// title
$feedtitle = $dom->createElement("title");
$channel->appendChild($feedtitle);

$text = $dom->createTextNode("golfmix courses");
$feedtitle->appendChild($text);

// description
$description = $dom->createElement("description");
$channel->appendChild($description);

$text = $dom->createTextNode("golfmix courses xml");
$description->appendChild($text);

// items:

global $post;
include('./wp-admin/admin-functions.php');
include('market-details.php');

if($input['ID'] !== null) {
	$args = array( 'p'=> $input['ID'] );
} else if($input['Q'] !== null || $input['ZIP'] !== null || $input['CITY'] !== null || ($input['LAT'] !== null && $input['LON'] !== null)) {
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
		
	if($input['DISTANCE'] !== null) { $distance = $input['DISTANCE']; } else { $distance = 10;}
	//if($input['LIMIT'] !== null) { $limit = $input['LIMIT']; } else { $limit = 10;}

	include('search_by_zip.php');
	//print_r($nearby);
	global $api_search;
	if($distance < 50 ) { $api_search = 'true'; }
	
	if($input['SORTBY'] == 'price' && $nearby !== null) { include('filter_by_price.php'); } 
	elseif($input['SORTBY'] !== null && $nearby !== null) { include('top_rated.php'); }
	if(!$nearby) { 
		$error = $dom->createElement("error");
		$channel->appendChild($error);
		$error->appendChild($dom->createTextNode("No Results Nearby"));
		
		echo $dom->saveXML();
		exit;
	} else { 
		$total = $nearby;
		//print_r($nearby);
		//array_splice($nearby, $limit); 
	}
	$args = array( 'post__in'=> $nearby, 'orderby' => 'post__in', 'paged' => $input['PAGE'], 'posts_per_page' => 10);
} else if($input['FEATURED'] !== null) {
	$args = array( 'meta_key' => 'featured_course', 'meta_value' => 'yes','post_type'=> 'post','numberposts' => 10,'orderby' => 'id', 'order' => 'ASC', 'paged' => $input['PAGE']);
} else {
	$args = array(  'post_type'=> 'post','numberposts' => -1, 'offset'=> 0, 'orderby' => 'id', 'order' => 'ASC');
}

if($input['REVIEWS'] !== null) {

	$reviews = $dom->createElement("reviews");
	$channel->appendChild($reviews);
	
	if($input['PAGE'] !== null) { $offset = ($input['PAGE']*10)-10; } else { $offset = 0; }
	
	if($input["REVIEW_ID"] !== null) {
		$comment = & get_comment($input["REVIEW_ID"]);
		
		include('review_xml.php');				

	} else {
		$comment_args = array(
		    'number' => 10,
		    'offset' => $offset,
		    'order' => 'DESC',
		    'status' => 'approve'
		);
		$comments = get_comments($comment_args);
			
		foreach($comments as $comment) :
					
			include('review_xml.php');				
			
		endforeach;
	}


} else {

//print_r($total);
$total_results = $dom->createElement("total_results");
$channel->appendChild($total_results);
$total_results->appendChild($dom->createTextNode(count($total)));

$courses = $dom->createElement("courses");
$channel->appendChild($courses);

//$myposts = get_posts( $args );
$myposts = query_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post);

	$course_id= get_post_meta($post->ID, 'course_id',1);
	include('courses_call.php'); 
	$featured_course = get_post_meta($post->ID, 'featured_course', 1);
	$featured_facebook = get_post_meta($post->ID, 'featured_facebook', 1);
	$featured_twitter = get_post_meta($post->ID, 'featured_twitter', 1);
	$featured_foursquare = get_post_meta($post->ID, 'featured_foursquare', 1);
	$tee_time_link = get_post_meta($post->ID, 'tee_time_link', 1);
	
	if($nearby_courses !== null) {
			$key = recursiveArraySearch($nearby_courses, $post->ID);
			$distance_from = $nearby_courses[$key]['DISTANCE'];
			$distance_from = number_format($distance_from, 2, '.', '');
	}
	
	// create child element	
	$item = $dom->createElement("course");
	$courses->appendChild($item);

	if(isset($_REQUEST['r']) && $_REQUEST['r'] == '2') { } else {
	
	$name = $dom->createElement("name");
	$item->appendChild($name);	
	
	$id = $dom->createElement("id");
	$item->appendChild($id);	

	$search_distance = $dom->createElement("distance");
	$item->appendChild($search_distance);	
	$search_distance->appendChild($dom->createTextNode($distance_from));

	$rating = $dom->createElement("ratings");
	$item->appendChild($rating);	
	
		$ratings = get_ratings($post->ID);
		//print_r($ratings);

		$count = $dom->createElement("review_count");
		$rating->appendChild($count);
		$count->appendChild($dom->createTextNode(get_comments_number()));

		if($input['ID'] !== null || $input['SORTBY'] == 'value') {
		$value = $dom->createElement("value");
		$rating->appendChild($value);
		$value->appendChild($dom->createTextNode($ratings["Value"]));
		}

		if($input['ID'] !== null || $input['SORTBY'] == 'conditions') {
		$conditions = $dom->createElement("course_conditions");
		$rating->appendChild($conditions);
		$conditions->appendChild($dom->createTextNode($ratings["Course Conditions"]));
		}

		if($input['ID'] !== null || $input['SORTBY'] == 'design') {
		$design = $dom->createElement("design");
		$rating->appendChild($design);
		$design->appendChild($dom->createTextNode($ratings["Design"]));
		}

		if($input['ID'] !== null || $input['SORTBY'] == 'amenities') {
		$amenities = $dom->createElement("amenities");
		$rating->appendChild($amenities);
		$amenities->appendChild($dom->createTextNode($ratings["Amenities"]));
		}

		if($input['ID'] !== null || $input['SORTBY'] == 'pace') {
		$pace = $dom->createElement("pace_of_play");
		$rating->appendChild($pace);
		$pace->appendChild($dom->createTextNode($ratings["Pace of Play"]));
		}

		$overall = $dom->createElement("overall_experience");
		$rating->appendChild($overall);
		$overall->appendChild($dom->createTextNode($ratings["<strong>Overall Experience</strong>"]));	
		
	$course_location = $dom->createElement("course_location");
	$item->appendChild($course_location);		
	
		$address1 = $dom->createElement("address1");
		$course_location->appendChild($address1);
	
		$address2 = $dom->createElement("address2");
		$course_location->appendChild($address2);	
	
		$city = $dom->createElement("city");
		$course_location->appendChild($city);
		
		$state = $dom->createElement("state");
		$course_location->appendChild($state);	
	
		$zip = $dom->createElement("zip");
		$course_location->appendChild($zip);
	
		$latitude = $dom->createElement("latitude");
		$course_location->appendChild($latitude);
	
		$longitude = $dom->createElement("longitude");
		$course_location->appendChild($longitude);
	
	$course_info = $dom->createElement("course_info");
	$item->appendChild($course_info);
	
	$fees = $dom->createElement("green_fees");
	$course_info->appendChild($fees);	
	
	if($input['ID'] !== null) {
	
	$phone = $dom->createElement("phone");
	$course_info->appendChild($phone);
	$phone->appendChild($dom->createTextNode($c_phone));

	$website = $dom->createElement("website");
	$course_info->appendChild($website);	
	$website->appendChild($dom->createTextNode($c_site));	

	$type = $dom->createElement("facility_type");
	$course_info->appendChild($type);	
	$type->appendChild($dom->createTextNode($c_type));
	
	$cat = $dom->createElement("cat");
	$course_info->appendChild($cat);		
	$cat->appendChild($dom->createTextNode($c_cat));		

	$designer = $dom->createElement("designer");
	$course_info->appendChild($designer);		
	$designer->appendChild($dom->createTextNode($c_designer.' - '.$c_year));

	$holes = $dom->createElement("holes");
	$course_info->appendChild($holes);		
	$holes->appendChild($dom->createTextNode('Regulation - '.$c_reg));

	$facilities = $dom->createElement("facilities");
	$course_info->appendChild($facilities);		
	$facilities->appendChild($dom->createTextNode($c_facilities));
	
		if($featured_course == 'yes') {	
	
		$featured = $dom->createElement("featured");
		$course_info->appendChild($featured);

			$f_teetime = $dom->createElement("tee_time_url");
			$featured->appendChild($f_teetime);
			$f_teetime->appendChild($dom->createTextNode($tee_time_link));

			$f_facebook = $dom->createElement("facebook_url");
			$featured->appendChild($f_facebook);
			$f_facebook->appendChild($dom->createTextNode($featured_facebook));

			$f_twitter = $dom->createElement("twitter_url");
			$featured->appendChild($f_twitter);
			$f_twitter->appendChild($dom->createTextNode($featured_twitter));
			
			$f_foursquare = $dom->createElement("foursquare_url");
			$featured->appendChild($f_foursquare);
			$f_foursquare->appendChild($dom->createTextNode($featured_foursquare));
	
			$f_quickfacts = $dom->createElement("quick_facts");
			$featured->appendChild($f_quickfacts);
			$f_quickfacts->appendChild($dom->createTextNode(get_the_content($post->ID)));
	
		}
	
	}	

	
		$turn_flickr_off = get_post_meta($post->ID, 'turn_flickr_off', 1);
		$blocked_photos = explode(',',get_post_meta($post->ID, 'blocked_photos', 1));
		$c_name_encode = str_replace(" ", "+", $c_name);							
		require_once("phpflickr/phpFlickr.php");
		$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
		$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"10"));
		if($recent['total'] > 0  && $turn_flickr_off == '') {
		
		$photos = $dom->createElement("photos");
		$course_info->appendChild($photos);
		
		$pcount = 0;
									
		foreach ($recent['photo'] as $photo) {
			// Restrict Bad Photos
			$pid = $photo['id'];
			if(in_array($pid, $blocked_photos)) { continue; }
			
			$pcount = $pcount + 1;
			
			if(($pcount < 5 && $input['ID'] !== null) || ($pcount < 2)) {
				$pid = $photo['id'];
				$pserver = $photo['server'];
				$pfarm = $photo['farm'];
				$ptitle = $photo['title'];
				$psecret = $photo['secret'];
				$powner = $photo['owner'];
				
				$puri = 'http://www.flickr.com/photos/'.$powner.'/'.$pid;
			
				if($input['ID'] !== null) {
					$photo_url = 'http://farm'.$pfarm.'.static.flickr.com/'.$pserver.'/'.$pid.'_'.$psecret.'_z.jpg';
				} else {
					$photo_url = 'http://farm'.$pfarm.'.static.flickr.com/'.$pserver.'/'.$pid.'_'.$psecret.'_s.jpg';
				}
								
				$photo = $dom->createElement("photo");
				$photos->appendChild($photo);
												
				$photo->appendChild($dom->createTextNode($photo_url));	
				
				// create attribute node
				//$photo_link = $dom->createAttribute("flickr_link");
				//$photo->appendChild($photo_link);
				//$photo_link->appendChild($dom->createTextNode($puri));					
				
			}
		}
		
		}
	
		 		
	// create text nodes
	$text = $dom->createTextNode($c_name);
	$name->appendChild($text);
	
	$text = $dom->createTextNode($post->ID);
	$id->appendChild($text);	
	
	
	$text = $dom->createTextNode($c_city);
	$city->appendChild($text);
	
	$text = $dom->createTextNode($c_state);
	$state->appendChild($text);

	$text = $dom->createTextNode(substr($c_zip, 0, 5));
	$zip->appendChild($text);

	$text = $dom->createTextNode($c_latitude);
	$latitude->appendChild($text);

	$text = $dom->createTextNode($c_longitude);
	$longitude->appendChild($text);
	
	$text = $dom->createTextNode($c_feewe);
	$fees->appendChild($text);	
		
	$text = $dom->createTextNode($c_address1);
	$address1->appendChild($text);

	$text = $dom->createTextNode($c_address2);
	$address2->appendChild($text);
	
	
	}
	
	if(isset($_REQUEST['r']) && $input['ID'] !== null) {
		$reviews = $dom->createElement("reviews");
		$item->appendChild($reviews);
		
		if($_REQUEST['r'] == '2') { $number = ''; } else { $number = '1'; }
	
		$comments = get_comments('post_id='.$post->ID.'&number='.$number);
	
		foreach($comments as $comment) :
			
			include('review_xml.php');				
			
		endforeach;
	}
	
	
endforeach;

}

// save and display tree
echo $dom->saveXML();
?>