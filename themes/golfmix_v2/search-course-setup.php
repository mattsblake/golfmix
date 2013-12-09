<?php
	global $count;
	$count = $count + 1;
	
	if($nearby_courses !== null) {
		$key = recursiveArraySearch($nearby_courses, $post->ID);
		$distance_from = $nearby_courses[$key]['DISTANCE'];
		$distance_from = number_format($distance_from, 2, '.', '');
	}

	
	$image = get_bloginfo('template_url').'/images/golfmix_icon_med.jpg';
	
	global $detect;
	$detect = new Mobile_Detect();
	if ($detect->isMobile() && !$detect->isIpad()) { 
		$image = get_bloginfo('template_url').'/images/golfmix_avatar.gif';
	}
	
	$course_id= get_post_meta($post->ID, 'course_id',1);
	include('courses_call.php'); 
	
	global $turn_flickr_off;
	$turn_flickr_off = null;
	$turn_flickr_off = get_post_meta($post->ID, 'turn_flickr_off', 1);
	
	global $blocked_photos;
	$blocked_photos = explode(',',get_post_meta(get_the_ID(), 'blocked_photos', 1));
	
	
	global $c_name_encode;
	$c_name_encode = str_replace(" ", "+", $c_name);							
	require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/themes/golfmix/phpflickr/phpFlickr.php");
	$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
	$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"5"));
																			
	if($recent['total'] > 0 && $turn_flickr_off == '') {
					
	$pcount = 0;
	foreach ($recent['photo'] as $photo) {
		$pid = $photo['id'];
		if(in_array($pid, $blocked_photos)) { continue; }
	
		$pcount = $pcount + 1;
		if($pcount == 1) {
			$pid = $photo['id'];
			$pserver = $photo['server'];
			$pfarm = $photo['farm'];
			$ptitle = $photo['title'];
			$psecret = $photo['secret'];
			$powner = $photo['owner'];
						
			$puri = 'http://www.flickr.com/photos/'.$powner.'/'.$pid;
	
			$image = 'http://farm'.$pfarm.'.static.flickr.com/'.$pserver.'/'.$pid.'_'.$psecret.'_z.jpg';
		}
	}
	} 
	
	$last_value = $value;
	
	$ratings = get_ratings($post->ID);
		
	global $value;

		
	if($sortby == 'value') { $value = $ratings["Value"]; }
	else if($sortby == 'conditions') { $value = $ratings["Course Conditions"]; }
	else if($sortby == 'design') { $value = $ratings["Design"]; }
	else if($sortby == 'amenities') { $value = $ratings["Amenities"]; }
	else if($sortby == 'pace') { $value = $ratings["Pace of Play"]; }
	else { $value = $ratings["<strong>Overall Experience</strong>"]; }
	
		//echo 'value'.$value.'last'.$last_value;
		
		$value = number_format($value, 2, '.', '');
			
		if($value == $last_value && $count !== 1 && $value !== '0.00') {$count = $count - 1; $tie = $tie + 1;} else {
			$count = $count + $tie;
			$tie = 0;
		}
		
		global $search_format;
		$search_format = 'true';
 ?>