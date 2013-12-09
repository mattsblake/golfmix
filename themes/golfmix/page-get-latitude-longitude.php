<?php
/**
 * Template Name: Latitude Longitude
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="content">
      <div class="content-data">

<?php
// Run these queries in the DB: UPDATE wp_postmeta SET meta_value = REPLACE(meta_value,']]>','') WHERE meta_value LIKE '%]]>%'
// UPDATE wp_postmeta SET meta_value = REPLACE(meta_value,'<![CDATA[','') WHERE meta_value LIKE '%<![CDATA[%'

global $post;
include('./wp-admin/admin-functions.php');
$args = array( 'numberposts' => 400, 'offset'=> 0);
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post);

		$course_id= get_post_meta($post->ID, 'course_id',1);
		include('courses_call.php'); 
		
		if($c_address1) {
		$map_search = $c_address1.' ' . $c_address2 . ', '.$c_city.', '.$c_state.' '.$c_zip;
		$map_search = str_replace(' ','+',$map_search);
		$mapapi = 'http://where.yahooapis.com/geocode?q='.$map_search.'&appid=dj0yJmk9NGVyVlBCNEIzRG9PJmQ9WVdrOVRVOVZZV0ZSTkhNbWNHbzlNVFkwTnpVMk1UUTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD01YQ--';
		//echo $mapapi;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $mapapi);
		$data = curl_exec($ch);
		curl_close($ch);
		$map = new SimpleXMLElement($data);
		$longitude = $map->Result->longitude;
		$latitude =  $map->Result->latitude;
	}

?>
	<p><?php echo $post->ID.','.$latitude.','.$longitude; ?></p>
<?php endforeach; ?>

		

</div>
      <div id="right-col">
					<div class="daily-box-container">
					<div class="inner-map-area">
							<div id="map_canvas" style="width: 427px; height:416px"></div>
							<a href="#" class="map-anker">View Larger Map/Directions >></a> </div>
					<div class="box-holder">
							<div class="daily-box-top">
							<h3>top  courses</h3>
						</div>
							<div class="daily-box-bottom-2">
							<div class="top-courses-box">
							<br class="clear" />

								<?php rs_comparison_table(5, '',"12"); ?>
									
								</div>
						</div>
							<br class="clear" />
						</div>
					<div class="box-holder">
							<div class="daily-box-top">
							<h3>sponsored ads</h3>
						</div>
							<div class="daily-box-bottom-2">
							<div class="top-courses-box"> <img src="<?php bloginfo( 'template_url' ); ?>/images/sponsor-ad-image.jpg" alt="" border="0" /> </div>
						</div>
							<br class="clear" />
						</div>
				</div>
				</div>
      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
