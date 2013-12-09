<?php //generate top rated nearby

		if(isset($_REQUEST['ajax'])) {
			require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
		}
		
		global $city_only, $distance, $limit, $sortby, $lon, $lat, $exclude, $page, $per;
		if(isset($_REQUEST['city'])) { $city_only = $_REQUEST['city']; }
		if(isset($_REQUEST['distance'])) { $distance = $_REQUEST['distance']; } else { $distance = 500;}
		if(isset($_REQUEST['limit'])) { $limit = $_REQUEST['limit']; } else { $limit = 5;}
		if(isset($_REQUEST['sortby'])) { $sortby = $_REQUEST['sortby']; }
		if(isset($_REQUEST['lon'])) { $lon = $_REQUEST['lon']; } else { $lon = '-112.07428'; }
		if(isset($_REQUEST['lat'])) { $lat = $_REQUEST['lat']; } else { $lat = '33.448631'; }
		if(isset($_REQUEST['p'])) { $exclude = $_REQUEST['p']; }
		if(isset($_REQUEST['per'])) { $per = $_REQUEST['per']; }
		if(isset($_REQUEST['page'])) { $page = $_REQUEST['page']; }
		if(isset($_REQUEST['style'])) { $style = $_REQUEST['style']; }


		include('search_by_zip.php');
		//print_r($nearby);
		include('top_rated.php');
		if(!$nearby) { 
			echo '<h3>No top courses nearby!</h3>';
			exit;
		} else { 
			array_splice($nearby, $limit); 
		}
		
		if($style=='page') {
		$args = array( 'post__in'=> $nearby, 'orderby' => 'post__in', 'numberposts' => $limit, 'paged' => $page, 'posts_per_page' => $per, 'exclude' => $exclude, 'year' => '2011');
		} else {
		$args = array( 'post__in'=> $nearby, 'orderby' => 'post__in', 'numberposts' => $limit, 'paged' => $page, 'posts_per_page' => $per, 'exclude' => $exclude);
		}

		
		$count = 0;
		
		$myposts = query_posts( $args );
		echo "<ul>";
		foreach( $myposts as $post ) :	setup_postdata($post);
		
				$count = $count + 1;

				$image = get_bloginfo('template_url').'/images/golfmix_icon_med.jpg';
				
				$course_id= get_post_meta($post->ID, 'course_id',1);
				include('courses_call.php'); 

				global $turn_flickr_off;
				$turn_flickr_off = null;
				$turn_flickr_off = get_post_meta($post->ID, 'turn_flickr_off', 1);
				
				global $blocked_photos;
				$blocked_photos = explode(',',get_post_meta(get_the_ID(), 'blocked_photos', 1));
				

				global $c_name_encode;
				$c_name_encode = str_replace(" ", "+", $c_name);							
				require_once("/home/golfmix/public_html/wp-content/themes/golfmix/phpflickr/phpFlickr.php");
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
 				
				if($sortby == 'value') { $value = $ratings["Value"]; }
				else if($sortby == 'conditions') { $value = $ratings["Course Conditions"]; }
				else if($sortby == 'design') { $value = $ratings["Design"]; }
				else if($sortby == 'amenities') { $value = $ratings["Amenities"]; }
				else if($sortby == 'pace') { $value = $ratings["Pace of Play"]; }
				else { $value = $ratings["<strong>Overall Experience</strong>"]; }
 
 				//echo 'value'.$value.'last'.$last_value;
 				
 				$value = number_format($value, 2, '.', '');
 
 				if($value == $last_value && $count !== 1) {$count = $count - 1; $tie = $tie + 1;} else {
 					$count = $count + $tie;
 					$tie = 0;
 				}
 
				if($style=='page') {
				
					include('result-course.php');
				
				} else { 
				$str='
				<li class="li-course">
				<div class="top-courses-col-1"><div class="img-container"><img border="0" alt="" src='. $image.'></div></div>
				<div class="top-courses-col-2">
				<h5><div class="rank">'.$count.'</div><a href="'. get_permalink($post->ID) .'">'.$post->post_title.'</a></h5>
				 	<ul>
						<li>'. $c_address1 .'</li>
						<li>'. $c_address2 .'</li>
						<li>'. $c_city .', '. $c_state .' '. $c_zip .'</li>
						<li>'. $c_phone .'</li>
						<li><a href="http://'. $c_site .'" target="_blank">'. $c_site .'</a></li>
					</ul>
			</div>
				<div class="top-courses-col-3">
				<ul>
					<li><a  name="fb_share" share_url="'.get_permalink($post->ID).'" class="rss-link-3">Facebook Share</a></li>
					<li><a href="http://twitter.com/share?url='.get_permalink($post->ID).'&text=Check out this review of '.get_the_title($post->ID).'&via=golfmix" class="email-link-3" data-count="none" data-via="golfmix">Twitter Share</a></li>
					<li><a href="#" class="refresh-link-3">Email Link</a></li>
				</ul>				
					<div style="color: #EE780E;margin-top:7px;">Reviews ('.get_comments_number().')</div>
					<div style="margin-top:7px;">'.num_to_stars($value).'</div>
				</div>
			</li>
				';
				print($str);
				}
				$i++;
			endforeach;
			
			echo "</ul>";
?>