<?php if ( have_posts() ) while ( have_posts() ) : the_post();

	$course_id= get_post_meta($post->ID, 'course_id',1);
	include('courses_call.php'); 
	
	endwhile;
	 
	$ratings = get_ratings($post->ID);
	$rating = $ratings["<strong>Overall Experience</strong>"];
	$rating = number_format($rating, 2, '.', '');
	$rating = explode(".", $rating);
	$rating[1] = '.'.$rating[1];
	$rating_blank = 'no';
	
	if($rating_cat == '') {$rating_cat = 'Overall';}
	
	if($rating[0]=='0') { 
	$rating[0] = 'N/A'; 
	$rating[1] = '';
	$rating_cat = '';
	$rating_blank = 'yes';
	}
	
	$map_link = $c_name;
	$map_link = str_replace(' ','+',$map_link);
		
	//$auth = md5('SECRET'.get_the_ID());
	global $turn_flickr_off;
	$turn_flickr_off = get_post_meta(get_the_ID(), 'turn_flickr_off', 1);

	global $tee_time_link;
	$tee_time_link = get_post_meta(get_the_ID(), 'tee_time_link', 1);
	
	global $blocked_photos;
	$blocked_photos = explode(',',get_post_meta(get_the_ID(), 'blocked_photos', 1));
	//$blocked_photos = array(get_post_meta(get_the_ID(), 'blocked_photos', 1));
				
	global $c_name_encode;
	$c_name_encode = str_replace(" ", "+", $c_name);							
	if(isset($_REQUEST['api'])) { echo $c_name_encode; }		
				
	require_once("phpflickr/phpFlickr.php");
	$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");
	
	$recent = $f->photos_search(array("text"=>"'".$c_name_encode."'","sort"=>"relevance", "per_page"=>"10"));
	
	if(isset($_REQUEST['api'])) { print_r($recent); }
	
	if($recent['total'] > 0  && $turn_flickr_off == '') {
	
	foreach ($recent['photo'] as $photo) {
		// Restrict Bad Photos
		$pid = $photo['id'];
		if(in_array($pid, $blocked_photos)) { continue; }
									
		$pcount = $pcount + 1;
										
		if($pcount < 2 ) {
			$pid = $photo['id'];
			$pserver = $photo['server'];
			$pfarm = $photo['farm'];
			$ptitle = $photo['title'];
			$psecret = $photo['secret'];
			$powner = $photo['owner'];
			
			$photo_url = 'http://farm'.$pfarm.'.static.flickr.com/'.$pserver.'/'.$pid.'_'.$psecret.'_z.jpg';
	    }
   }
   
   } else {
   
   		$photo_url = '';
   }
?>
	<div class="course-page">
		<div class="course-head">
			<div class="course-rating<?php if($rating_blank == 'yes') { echo ' blank'; } ?>"><?php echo $rating[0]; ?><span><?php echo $rating[1]; ?></span><div class="rating-cat"><?php echo $rating_cat; ?></div></div>
			
			<div class="course-info">
				<h1><?php the_title(); ?></h1>
				<ul>
					<li><img src="<?php bloginfo('template_url'); ?>/images/mobile/review_icon.png"/><?php comments_number('0 Reviews','1 Review','% Reviews');  ?>&nbsp;&nbsp;<?php echo $c_feewe; ?></li>
					<li><a href="http://<?php echo $c_site; ?>" target="_new" itemprop="url"><?php echo $c_site; ?></a></li>
				</ul>
			</div>
		</div>

		<div class="course-content">
			
			<?php if($photo_url !== '') { ?>
			<div class="course-feature-image">
				<img src="<?php echo $photo_url; ?>" />
			</div>
			<?php } ?>
		
			<?php 
			$comments = get_comments('post_id='.$post->ID.'&number=1');
			if($comments !== '') {
				foreach($comments as $comment) :
					$avatar = get_avatar( $comment->comment_author_email, 101 );
					if(!strpos('/avatars',$avatar)) { $avatar = str_replace('/avatars','http://golfmix.com/avatars',$avatar); }
				?>			
				<div class="course-details">
						<div class="course-left">
								<div class="reviewer-image">
									<?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
								</div>
							<a href="<?php echo get_bloginfo('url').'/m/r/?id='.$post->ID; if(isset($_REQUEST['app'])) { echo '&app=no'; }?>"/>	
								<div class="reviews">
									<strong>Read Reviews</strong><br />
									<?php echo substr_replace($comment->comment_content, '…', 40, -1); ?>
								</div>	
							</a>				
						</div>
				</div>
				<?php endforeach; 
			}
			?>


			<div class="course-details">
				<div class="course-right">
					<h4 style="margin-bottom:0;">Ratings:</h4>
					<ul class="ratings">
						<li><span>Value:</span> <?php echo num_to_stars_mobile($ratings["Value"]) ?></li>
						<li><span>Design:</span> <?php echo num_to_stars_mobile($ratings["Design"]) ?></li>
						<li><span>Course Conditions:</span> <?php echo num_to_stars_mobile($ratings["Course Conditions"]) ?></li>
						<li><span>Amenities:</span><?php echo num_to_stars_mobile($ratings["Amenities"]) ?></li>
						<li><span>Pace of Play:</span> <?php echo num_to_stars_mobile($ratings["Pace of Play"]) ?></li>
						<li class="overall"><span>Overall Experience:</span><?php echo num_to_stars_mobile($ratings["<strong>Overall Experience</strong>"]) ?></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="course-details">
				<div class="course-left">
					<h4>Course Details:</h4>
					<ul>
						<?php if($hide) { ?><li><span>Tee Times :</span>Mon-Fri  (7 am - 6 pm)</li><?php } ?>
						<?php if($hide) { ?><li><span>Yardage :</span>2590 m </li><?php } ?>
						<li><span>Facility Type:</span> <?php echo $c_type;?></li>
						<li itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span>Green Fees :</span> <price itemprop="price"><?php echo $c_feewe; ?></price></li>
						<li><span>Course Designer :</span> <?php echo $c_designer; ?> - <?php echo $c_year; ?></li>
						<?php if($c_pro) { ?><li><span>Course Pro :</span> <?php echo $c_pro; ?></li><?php } ?>
						<li><span>Facilities :</span> <?php if($c_gps) { echo 'GPS Distance System, '; } if($c_tee) { echo 'Driving Range ('.$c_tee.' Tees)'; }?></li>
						<?php if($hide) { ?><li><span>Par :</span>34</li><?php } ?>
						<li><span>Holes :</span> <?php echo 'Regulation - '.$c_reg; ?></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>

			<div class="course-details">
				<div class="course-left">
					<h4>Map:</h4>
					<a href="http://google.com/maps?q=<?php echo $map_link; ?>">
						<div class="click-thru">
							<?php echo $c_address1; ?> <?php echo $c_city; ?>, <?php echo $c_state; ?> <?php echo $c_zip; ?>
						</div>
					</a>
				</div>
			</div>
			
			<div class="course-details">
				<div class="course-left">
					<h4>Phone:</h4>
					<div class="click-thru">
						<?php echo $c_phone; ?>
					</div>
				</div>
				</a>
			</div>		
		</div>
		
		

	</div>