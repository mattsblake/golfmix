<?php
/**
 * Template Name: Ratings Template
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
$args = array( 'numberposts' => 400, 'offset'=> 0, 'category' => 6, 'exclude' => '151,2,3,6' );
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post);

	$wp_meta = array(
	'_rs_categories' => '<![CDATA[a:6:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";}]]>',
	'_rs_icon' => 'http://',
	'_rs_link' => 'http://'
	 );
	
	foreach($wp_meta as $metakey=>$metavalue) {
	$_POST = array();
	$_POST['metakeyinput'] = $metakey;
	$_POST['metavalue'] = $metavalue;
	add_meta($post->ID);
	}

?>
	<p></p><?php the_title(); ?> Done</p>
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
