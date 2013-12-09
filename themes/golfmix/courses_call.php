<?php
 // Call Course Table for Golf Course Info
 
 $wpdb->hide_errors();
 $result = $wpdb->get_row( "SELECT * FROM courses WHERE COURSE_ID LIKE '".$course_id."'", ARRAY_A);

 //print_r($result);
	
 if(!$result) { 
 
 	//echo '<strong>Missing Course ID '.get_the_title().'</strong>';
 
 } else { 	
								
	$c_name = $result['COMPANY'];			 
	$c_address1 = $result['LOCADD1'];		 
	$c_address2 = $result['LOCADD2'];		 
	$c_city = $result['LOCCITY'];			
	$c_state = $result['LOCSTATE'];			 
	$c_zip = $result['LOCZIP'];
	$c_zip = substr($c_zip, 0, 5);				 
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
	//$c_overseeding = $result['OVERSEEDING'];	
	$c_latitude = $result['LATITUDE'];
	$c_longitude = $result['LONGITUDE'];
	
	if($c_feewe <= 50) { $c_feewe = '$'; } 
	elseif( $c_feewe <= 100) { $c_feewe = '$$'; } 
	elseif( $c_feewe <= 200) { $c_feewe = '$$$'; }
	else { $c_feewe = '$$$$'; }
	
	
	if($c_type == 'PE') { $c_type='Private'; }
	elseif($c_type == 'PR') { $c_type='Private'; }
	elseif($c_type == 'PN') { $c_type='Private'; }
	elseif($c_type == 'DF') { $c_type='Public'; }
	elseif($c_type == 'MU') { $c_type='Public'; }
	elseif($c_type == 'SP') { $c_type='Semi-Private'; }
	
	$c_facilities = '';
	if($c_gps) { $c_facilities .= 'GPS Distance System, '; } 
	if($c_tee) { $c_facilities .=  'Driving Range ('.$c_tee.' Tees)'; }
 }
 
global $featured_course, $featured_twitter, $featured_facebook, $featured_foursquare;
$featured_course = get_post_meta(get_the_ID(), 'featured_course', 1);
$featured_facebook = get_post_meta(get_the_ID(), 'featured_facebook', 1);
$featured_twitter = get_post_meta(get_the_ID(), 'featured_twitter', 1);
$featured_foursquare = get_post_meta(get_the_ID(), 'featured_foursquare', 1);
	   		
?>