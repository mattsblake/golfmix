<?php

//echo 'turned off';
//exit;

set_time_limit(600);
ini_set('memory_limit', '600M');

require( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php');

global $wpdb;
//$wpdb->show_errors();
//define( 'DIEONDBERROR', true );


$start = $_REQUEST['start'];
$end = $_REQUEST['end'];
$limit = $_REQUEST['limit'];

if(!$start) { $start = 0; }
if(!$end) { $end = 0; }

$courses = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `courses` WHERE `STATE_PROVINCE` LIKE %s LIMIT $start,$limit", 'MI' ) );
 
//$wpdb->print_error();
 
//w3tc_dbcache_flush();

switch_to_blog(3);

foreach ($courses as $course) {

	//echo 'Course: '.$course->COMPANY.'<br />';
	echo '<br />';

	    //Matt's Account Generic Account
	    $authorID = 1;
	   	    
	    $title = $course->COMPANY;
	    	    
	    $args = array( 'name' => $title );
		$already_posted = get_posts( $args );
	   	if(!empty($already_posted)) { echo 'Already Have This'; continue; }
	    
		$myPost = array(
			'post_status' => 'publish',
			'post_type' => 'post',
			'post_author' => $authorID,
			'post_title' => $title,
			'post_content'  => $content,
			'post_content_filtered' => '',
			'comment_status' => 'open',
			'ping_status' => 'closed',
			'tags_input'     => $tags,
			'post_date'  => $post_date,
			'filter' => true	
			);
					
		//-- Create the new post
		$newPostID = '';
		$newPostID = wp_insert_post($myPost);
		//print_r($newPostID);
		
		$permalink = get_permalink( $newPostID );
		echo '<a href="'.$permalink.'" target="_blank">'.$permalink.'</a>';
		
		add_post_meta($newPostID, 'course_id', $course->COURSE_ID);
		$wpdb->update( 
			'courses', 
			array( 
				'POST_ID' => $newPostID,	// string
			), 
			array( 'COURSE_ID' => $course->COURSE_ID ) 
		);
			
}

restore_current_blog();	


if(isset($start) && (isset($end) || isset($limit))) {
	if(isset($limit)) {
		$nstart = $start + $limit;
		$nend = $limit;
		echo '<br /><br /><h2><a href="http://golfmix.com/wp-content/themes/golfmix_v2/utilities/create-new-posts.php?start='.$nstart.'&limit='.$nend.'">Next Page</a></h2>';
	} else {
		$nstart = $end - 1;  
		$nend = $nstart + ($end - $start);	
		echo '<br /><br /><h2><a href="http://golfmix.com/wp-content/themes/golfmix_v2/utilities/create-new-posts.php?start='.$nstart.'&end='.$nend.'">Next Page</a></h2>';
	}
}

//end this
exit;
?>