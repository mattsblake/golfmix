<?php
//Overseeding Add new

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
wp();	

global $wpdb;

$golfcourses = $wpdb->get_results("SELECT post_id, company, overseeding FROM overseeding_13 WHERE overseeding NOT LIKE ''", ARRAY_A);
//print_r($golfcourses);
//exit;

foreach($golfcourses as $course) {
	
	if($course['overseeding'] !== '' && $course['overseeding'] !== null) {
	
		//echo $course['company'].$course['overseeding'].'<br />';continue;
		
		$wpdb->update( 
			'courses', 
			array( 
				'overseeding' => $course['overseeding'],	// string
			), 
			array( 'post_id' => $course['post_id'] )
		);		
		echo $course['company'].' has been updated'; 
	
	}
}
?>