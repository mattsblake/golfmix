<?php
require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );

$term = wp_specialchars($_REQUEST['s']);

$width = $_REQUEST['width'];
if(!$width) {$width = 320;}
$width_add = $width - 5;

$height = $_REQUEST['height'];

$style = $_REQUEST['style'];

$type = $_REQUEST['type'];

$review = $_REQUEST['review'];


if(isset($_REQUEST['id'])) { 
//echo $_REQUEST['id'];
$the_query = new WP_Query('p=' . $_REQUEST['id']. '&post_count=1');
} else {
$the_query = new WP_Query('s=' . $term. '&post_count=1&post_type=post');
}

// The Loop
while ( $the_query->have_posts() ) : $the_query->the_post();
$count = $count + 1;
	if($count < 2) { 
		echo '<div><iframe src="http://golfmix.com/widget/?id='.get_the_ID().'&style='.$style.'&width='.$width_add.'&type='.$type.'&review='.$review.'" width="'.$width.'" height="'.$height.'" scrolling="no" style="margin:20px auto;padding:0;" class="gm_widget" id="'.get_the_ID().'"></iframe></div>';
	}
endwhile;

// Reset Post Data
wp_reset_postdata();
?>