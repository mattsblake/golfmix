<?php
/**
 * Template Name: Widget KTAR
 *
 **/
header('X-Frame-Options: GOFORIT'); 

require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );

echo '<link rel="stylesheet" type="text/css" media="all" href="'. get_bloginfo( 'stylesheet_url' ).'?v=2.5" />';


//if($hide == true) {
?>
<style>
body {
background: transparent !important;
width: 98%;
padding: 1%;
margin:0;
}
h3 {
margin: 0;
}
p {
padding:0;
margin:0;
}
.daily-box-container {
width: 99%;
}
.box-holder {
width: 98%;
}
.daily-box-top {
height: 56px;
width: 98%;
}
.daily-box-bottom-2 {
width: 96.4%;
}
.daily-box-top h3 {
background: transparent url(http://golfmix.com/wp-content/themes/golfmix_v2/images/logo_small.png) no-repeat top left;
height: 100%;
text-indent: 94px;
line-height: 63px;
}
#review-of-the-day .review-congrats {
clear: both;
margin-top: 10px;
float: left;
}

#ktar-promo {
width:100%;
}
#ktar-promo .best-image-wrapper {
position: relative;
border: 1px solid white;
position: relative;
box-shadow: 0 1px 1px 1px #ccc;
float: left;
margin-right: 10px;
padding: 1px;
}
#ktar-promo .best-image {
width: 80px;
height: 65px;
overflow: hidden;	
}
#ktar-promo .best-image img {
width: 100px;	
}
#ktar-promo .best-of-number {
position: absolute;
z-index: 10000px;
top: -10px;
left: 10px;
padding: 6px 10px;
border-radius: 3px;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
margin-top: 6px;
font-weight: bold;
color: white;
background: #FD9540;
background: -moz-linear-gradient(top, #FD9540 0%, #F28832 45%, #EC7C26 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FD9540), color-stop(45%,#F28832), color-stop(100%,#EC7C26));
background: -webkit-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: -o-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: -ms-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fd9540', endColorstr='#ec7c26',GradientType=0 );
border: 0;
box-shadow: 0 0 1px #ccc;
text-transform: uppercase;
font-size: 14px;
}
#ktar-promo .promo-content {
	float:right;
	width: 175px;
	
}
#ktar-promo h4 {
margin: 1px auto 5px;
padding: 0;
}
#ktar-promo h4 a {
font-size: 16px;
text-transform: uppercase;
color: #333;
text-decoration: none;
margin:0;
padding:0;
}
#ktar-promo h5 {
font-size: 14px;
color: #444;
margin-top: 8px;
font-weight: normal;
text-transform: none;
font-family: Arial, Helvetica, sans-serif;	
margin:0;
padding:0;
}
#ktar-promo .clickthrough {
font-family: Arial,Helvetica,sans-serif;
float: left;
cursor: pointer;
position: relative;
padding: 6px 7px;
border-radius: 3px;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
margin-top: 5px;
font-weight: bold;
color: white;
background: #FD9540;
background: -moz-linear-gradient(top, #FD9540 0%, #F28832 45%, #EC7C26 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FD9540), color-stop(45%,#F28832), color-stop(100%,#EC7C26));
background: -webkit-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: -o-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: -ms-linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
background: linear-gradient(top, #FD9540 0%,#F28832 45%,#EC7C26 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fd9540', endColorstr='#ec7c26',GradientType=0 );
border: 0;
box-shadow: 0 0 1px #ccc;
font-size: 14px;
text-decoration: none;	
}
ul.ratings li {
float: right;
margin: 2px 0;
}
ul.ratings {
width: 100%;
padding: 0;
margin: 0;
}
ul.ratings li.bold {
font-weight: bold;
}
</style>

<div class="daily-box-container">

	<div class="box-holder" id="review-of-the-day">

				<div class="daily-box-top"><h3>Featured Course</h3></div>
				<div class="daily-box-bottom-2">
							<?php 
							
								global $options;
								foreach ($options as $value) {
								    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
								}
								date_default_timezone_set('America/Phoenix');
								$time = date("m/d/Y");
								if(isset($_REQUEST['beta'])) {echo $time.$gm_date1;}
							
								if($time == $gm_date1) { 
									$review_post_id = $gm_postid1;
									$review_id = $gm_email1;
									$prize_course_name = $gm_prizename1;
									$prize_link = $gm_prizeurl1;
									$date = 1;
								} elseif($time == $gm_date2) {
									$review_post_id = $gm_postid2;
									$review_id = $gm_email2;
									$prize_course_name = $gm_prizename2;
									$prize_link = $gm_prizeurl2;
									$date = 2;
								}
								elseif($time == $gm_date3) { 
									$review_post_id = $gm_postid3;
									$review_id = $gm_email3;
									$prize_course_name = $gm_prizename3;
									$prize_link = $gm_prizeurl3;
									$date = 3;
								}
								
								if(isset($_REQUEST['beta'])) {echo $date;}
								
								
								if(isset($_REQUEST['beta'])) { echo $review_post_id; }
								
								if(!$date) {
									if($gm_postid1) {
										$review_post_id = $gm_postid1;
										$review_id = $gm_email1;
										$prize_course_name = $gm_prizename1;
										$prize_link = $gm_prizeurl1;
									} elseif($gm_postid2) {
										$review_post_id = $gm_postid2;
										$review_id = $gm_email2;
										$prize_course_name = $gm_prizename2;
										$prize_link = $gm_prizeurl2;
									} elseif($gm_postid3) {
										$review_post_id = $gm_postid3;
										$review_id = $gm_email3;
										$prize_course_name = $gm_prizename3;
										$prize_link = $gm_prizeurl3;
									}
								}
								
								$image = get_bloginfo('template_url').'/images/golfmix_icon_med.jpg';
				
								$course_id= get_post_meta($review_post_id, 'course_id',1);
								include('courses_call.php'); 
				
								global $turn_flickr_off;
								$turn_flickr_off = null;
								$turn_flickr_off = get_post_meta($review_post_id, 'turn_flickr_off', 1);
								
								global $blocked_photos;
								$blocked_photos = explode(',',get_post_meta(get_the_ID(), 'blocked_photos', 1));
								
				
								global $c_name_encode;
								$c_name_encode = str_replace(" ", "+", $c_name);							
								require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/themes/golfmix/phpflickr/phpFlickr.php");
								$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
								$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"7"));
																										
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
								
								$ratings = get_ratings($review_post_id);

															
								$args = array('status' => 'approve', 'number' => '1','order' => 'ASC','post_id' => $review_post_id, 'author_email' => $review_id );
								$comments = get_comments($args);
								foreach($comments as $comment) :
							?>
								<div id="ktar-promo">
									<h4><a href="<?php echo get_permalink($review_post_id); ?>" target="_blank"><?php echo get_the_title($review_post_id); ?></a></h4>
									<div class="best-image-wrapper">
										<div class="best-image"><a href="<?php echo get_permalink($review_post_id); ?>" target="_blank"><img src="<?php echo $image; ?>"></a></div>
									</div>
									<div class="promo-content">
										<ul class="ratings">
											<li <?php if($sortby == 'value') { echo 'class="bold"'; }?>>Value:<?php echo num_to_stars($ratings["Value"]); ?></li>
											<li <?php if($sortby == 'conditions') { echo 'class="bold"'; }?>>Course Conditions:<?php echo num_to_stars($ratings["Course Conditions"]); ?></li>
											<li <?php if($sortby == 'design') { echo 'class="bold"'; }?>>Design:<?php echo num_to_stars($ratings["Design"]); ?></li>
											<li <?php if($sortby == 'amenities') { echo 'class="bold"'; }?>>Amenities:<?php echo num_to_stars($ratings["Amenities"]); ?></li>
											<li <?php if($sortby == 'pace') { echo 'class="bold"'; }?>>Pace of Play:<?php echo num_to_stars($ratings["Pace of Play"]); ?></li>
											<li <?php if($sortby !== 'value' && $sortby !== 'conditions' && $sortby !== 'design' && $sortby !== 'amenities' && $sortby !== 'pace') { echo 'class="bold"'; }?>>Overall Experience:<?php echo num_to_stars($ratings["<strong>Overall Experience</strong>"]); ?></li>
										</ul>
									</div>
									<div class="clear"></div>
								</div>
																
								<div class="review-congrats">Write a review to win at <a href="<?php bloginfo('url'); ?>/write-a-review" target="_blank">Arizona'a leading golf course review site!</a></div> 
								
								<?php endforeach; ?>
								
	
							</div>
							
				<div class="clear"></div>
		</div>
	</div>
<?php //exit; ?>