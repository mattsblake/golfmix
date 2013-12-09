<?php
/**
 * Template Name: Golf Course Listings
 */

get_header(); 

//$sortby = urldecode($wp_query->query_vars['sortby']);
//$find = urldecode($wp_query->query_vars['find']);

global $wp_query;

$sortby = strtoupper($_REQUEST['sortby']);
$city_location = $_REQUEST['location'];

if($city_location == null) { $city_location = ucwords((str_replace('-',' ',$wp_query->query_vars['location']))); }
if($sortby == null) 	   { $sortby = strtoupper($wp_query->query_vars['sortby']); }

?>

		<div id="content">

     			
<div id="left-col">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1 class="page-title"><?php if($city_location){ echo $city_location .' '; } the_title(); if($sortby){ echo  ' "'.$sortby.'"'; }?></h1>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link" style="float:right;">', '</span>' ); ?>
<?php endwhile; // end of the loop. ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if($city_location || $sortby) {?>
<div style="margin-left:5px;margin-bottom:20px;">
	<?php echo '<a href="'.get_permalink().'">Golf Courses</a> &raquo; '; 
	if($city_location){ echo $city_location; } elseif($sortby) { echo $sortby; }
	?>
</div>
<?php } ?>

<?php if(!$city_location) { ?>
<h2 class="sortby">Browse by Name</h2>
<ul class="sortbyletter">
<?php foreach(range('a','z') as $letter) { ?>
	<li><a href="<?php echo get_permalink().'sort/'.$letter; ?>" <?php if(ucfirst($letter) == $sortby) { echo 'style="font-size:bold;"';} ?> ><?php echo ucfirst($letter); ?></a></li>
<?php } ?>	
</ul>
<div style="clear:both;width:100%;height:20px;"></div>

<?php } ?>

<?php if(!$sortby && !$city_location) { ?>
	<h2 class="sortby">Browse by City</h2>
	<ul class="sortbycity">
	<?php 
	global $market_coverage; 
	$locations = $wpdb->get_col($wpdb->prepare("SELECT LOCCITY FROM courses WHERE LOCSTATE LIKE '$market_coverage' GROUP BY LOCCITY"));
	
	$locations = array_unique($locations);
	sort($locations);
	$total = count($locations);
	$total = $total/3;
	$total = $total+1;
	
	foreach($locations as $location) { 
		$count = $count + 1;
		?>
			<li><a href="<?php echo get_permalink().strtolower(str_replace(' ','-',$location)); ?>" ><?php echo $location; ?></a></li>
	<?php
		if($count > $total) { $count = 1; echo '</ul><ul class="sortbycity">'; }
	 } ?>
	</ul>
<div style="clear:both;width:100%;height:20px;"></div>
<?php } ?>

<?php if(!$sortby && !$city_location) { ?>
	<h2 class="sortby">Browse by Zip</h2>
	<ul class="sortbycity">
	<?php 
	global $market_coverage; 
	$zips = $wpdb->get_col($wpdb->prepare("SELECT LOCZIP FROM courses WHERE LOCSTATE LIKE '$market_coverage' GROUP BY LOCZIP"));
	
	$zips = array_unique($zips);
	sort($zips);
	$total = count($zips);
	$total = $total/3;
	$total = $total+1;
	$count = 0;
		
	foreach($zips as $zip) { 
		$count = $count + 1;
		?>
			<li><a href="<?php echo get_permalink().strtolower(str_replace(' ','-',$zip)); ?>" ><?php echo $zip; ?></a></li>
	<?php
		if($count > $total) { $count = 1; echo '</ul><ul class="sortbycity">'; }
	 } ?>
	</ul>
<?php } ?>

	<div class="clear"></div>

</div>

<?php
//$args = array( 'numberposts' => -1);
$args = array( 'numberposts' => 1);
$posts = get_posts( $args );
foreach($posts as $post) : setup_postdata($post); 
	$fistletter = substr(get_the_title($post->ID),0,1);
	$course_id= get_post_meta($post->ID, 'course_id',1);
	include('courses_call.php'); 
	
	if($fistletter == $sortby || $city_location == $c_city || $city_location = $c_zip) {  		
		include('search-course-setup.php');
		include('result-course.php');
	} 

endforeach; 

?>

	<?php posts_nav_link('&nbsp;', '<div class="post_nav" style="float:left;">previous page</div>', '<div class="post_nav" style="float:right;">next page</div>'); ?>

	
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
