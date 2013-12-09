<?php
/**
 * Template Name: Widget
 *
 **/
//get_header();

$w_id = $_REQUEST['id']; 
$w_width = $_REQUEST['width'];
$w_height = $_REQUEST['height'];
$w_style = $_REQUEST['style'];
if(isset($_REQUEST['type'])) { $w_type = $_REQUEST['type']; } else { $w_type = $_REQUEST['review']; }
if($w_type == 'review') { $w_type = $_REQUEST['review'];}
 
if(!$w_id) { $w_id = 'Missing ID'; }
if(!$w_style) { $w_style = 'orange_small'; } elseif($w_style=='g') { $w_style = 'grey_small'; }
?>

<style>
	body {
		width:<?php if($w_width) { echo $w_width; } else { echo '200'; } ?>px;
		height:<?php if($w_height) { echo $w_height.'px'; } else { echo 'auto'; } ?>;
		margin:0;
		padding:0;
	}
	#widget {
		width:<?php if($w_width) { echo $w_width; } else { echo '200'; } ?>px;
		height:<?php if($w_height) { echo $w_height.'px'; } else { echo 'auto'; } ?>;
		background: #fff;
	}
	#widget a {
		text-decoration: none;	
	}
	.orange_small {
		border:2px solid #ececec;
		border-radius:7px;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
	}
	.orange_small h1 {
		color: white;
		font-size: 17px;
		font-weight: normal;
		font-family: arial;
		text-transform: uppercase;
		text-align: center;	
		margin: 0;
		padding: 5px 10px;
	    height: 80px;
		background: #ff6f01;
		background-image: url(<?php bloginfo('template_url'); ?>/images/logo_white_small.png);
		background-position: 50% 29px;
		background-repeat: no-repeat;
		/*background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fb862d), to(#ff6f01));
	    background: -webkit-linear-gradient(top, #fb862d, #ff6f01);*/
	    background: -moz-linear-gradient(top, #fb862d, #ff6f01);
	    background: -ms-linear-gradient(top, #fb862d, #ff6f01);
	    background: -o-linear-gradient(top, #fb862d, #ff6f01);
	}
	.grey_small {
		border:2px solid #ff6f01;
		border-radius:7px;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		margin-top:10px;
	}
	.grey_small #logo_small {
		background: transparent url(<?php bloginfo('template_url'); ?>/images/logo_small.png) no-repeat top left;
		margin-top: -16px;
		width: 100%;
		height: 51px;
		margin-left: -5px;
	}
	.grey_small h1 {
		text-indent: -1000000px;
		margin: 0;
		padding: 5px 10px;
	    height: 35px;
		background: #e4e3e2;
	    background: -moz-linear-gradient(top, #f1f1f0, #e4e3e2);
	    background: -ms-linear-gradient(top, #f1f1f0, #e4e3e2);
	    background: -o-linear-gradient(top, #f1f1f0, #e4e3e2);
	    border-radius: 4px 4px 0 0;
	   	-moz-border-radius: 4px 4px 0 0;
	   	-webkit-border-radius: 4px 4px 0 0;
	}
	h2 {
		padding:0;
		margin: 20px 5px 7px;
		text-align: center;
	}
	h2 a{
		color: #272626;
		font-size: 17px;
		font-family: arial;
		font-weight:bold;
		text-decoration: none;
	}
	.overall_rating {
		width: 165px;
		height: 15px;
		margin: 0 auto 15px;
		border: 1px solid #DDD;
		-moz-border-radius: 16px;
		-webkit-border-radius: 16px;
		border-radius: 16px;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f6f6f6', endColorstr='#E2E2E2');
		background: -webkit-gradient(linear, left top, left bottom, from(#F6F6F6), to(#E2E2E2));
		background: -moz-linear-gradient(top, #F6F6F6, #E2E2E2);
		font-family: arial;
		font-size: 11px;
		font-weight: bold;
		padding: 6px;
		vertical-align: top;
	}
	.naked_rating {
		width: 60px;
		margin: 15px auto;
	}
	.review_snippet {
		color: #666;
		font-size:15px;
		font-family: arial;
		font-style:italic;
		text-align: center;
		margin: 0 5px;
	}
	ul.ratings {
	position: relative !important;
	right: 0;
	top: 0;
	float: right;
	width: 200px;
	}
	ul.ratings li {
	float:left;
	margin-left: 5px;
	}
	ul.ratings li label {
	display:inline-block;
	width:107px;
	}
	.rating_label {
	font-family: Arial;
	font-size: 12px;
	padding: 4px 4px 1px 4px;
	text-align: right;
	white-space: nowrap;
	color: #4B4843;
	}
	.rating_value {
	padding: 1px 3px;
	}
	.over-all-rating-box-1 {
	width: 187px !important;
	height: 22px;
	margin-bottom: 5px;
	border: 1px solid #DDD;
	-moz-border-radius: 16px;
	-webkit-border-radius: 16px;
	border-radius: 16px;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f6f6f6', endColorstr='#E2E2E2');
	background: -webkit-gradient(linear, left top, left bottom, from(#F6F6F6), to(#E2E2E2));
	background: -moz-linear-gradient(top, #F6F6F6, #E2E2E2);
	}
	.over-all-rating-box-1 .rating_label {
	padding:4px;
	vertical-align: bottom;
	}
	.over-all-rating-box-1 .rating_value {
	font-size: 14pt;
	}
	</style>	
<?php 
if($w_id !== 'Missing ID') {
	global $post;
	$args = array( 'numberposts' => 1, 'include' => $w_id );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ) :	setup_postdata($post);
		
		$course_id= get_post_meta($post->ID, 'course_id',1);
		include('courses_call.php'); 
	?>
	<div id="widget" class="<?php echo $w_style; ?>">
		<a href="<?php the_permalink(); ?>" target="_blank">
		<h1><div id="logo_small"></div><?php if(isset($_REQUEST['best'])) { echo $_REQUEST['best']; } else { echo 'Recommended On';} ?></h1>
	
		<h2><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title();?></a></h2>
		<?php if($w_type=='all') { ?>
			<?php echo ratings_list(); ?>
			<div style="clear:both;"></div>
		<?php } elseif($w_type) { ?>
			<div class="review_snippet">
				<?php $comment = get_comment( $w_type );?> 
				"<?php echo $comment->comment_content; ?>"
			</div>
			<div class="naked_rating"><?php echo num_to_stars(get_average_rating($post->ID)); ?></div>
		<?php } else { ?>
			<div class="overall_rating">Overall Experience: <?php echo num_to_stars(get_average_rating($post->ID)); ?></div>
		<?php } ?>
		
		</a>
	</div>
	
	<?php endforeach; ?>
<?php } else { ?>
	<style>
	#widget {
		height: 336px;
		overflow: hidden;
	}
	ul {
	    list-style:none;
	    padding:0;
	    margin:0;
	}
	ul li {
	    float:left;
	    list-style: none;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #666;
	}
	ul li.li-course {
	    margin:2px 0;
	    width:100%;
	}
	ul li.li-course:nth-child(5) {
		display: none;
	}
	.top-courses-col-1 {
	    width: 33%;
		float: left;
	}
	.top-courses-col-1 .img-container {
	    height: 45px;
		width: 90%;
		overflow: hidden;
		margin:5px;
	}
	.top-courses-col-1 .img-container img {
	    width: 100%;
	}
	.top-courses-col-2 {
	    width:65%;
	    float:right;
	}
	.top-courses-col-2 h5 {
	    font-family:Arial, Helvetica, sans-serif;
	    font-size:12px;
	    color:#414040;
	    font-weight:normal;
	    text-transform:uppercase;
	    padding:0;
	    margin: 5px 0 0 0;
	}
	.top-courses-col-2 ul {
		display: none;
	}
	.top-courses-col-2 p {
	    font-family:Arial, Helvetica, sans-serif;
	    font-size:11px;
	    color:#4f4c4c;
	    font-weight:normal;
	}
	.top-courses-col-2 a {
	    font-family:Arial, Helvetica, sans-serif;
	    font-size:11px;
	    color:#4f4c4c;
	    text-decoration:none;
	}
	.top-courses-col-2 a:hover {
	    text-decoration:underline;
	}
	.top-courses-col-3 {
	    width: 65%;
		float: right;
		padding: 0;
	}
	.top-courses-col-3 div {
		margin-top:4px !important;
		font-size:11px;
	}
	
	.top-courses-col-3 ul {
	    list-style:none;
	    padding:0;
	    display: none;
	}
	</style>
	<div id="widget" class="<?php echo $w_style; ?>">
		<h1><div id="logo_small"></div>Top Courses</h1>
		<?php rs_comparison_table(5); ?>
		<div style="clear:both;height:5px;"></div>
	</div>
<?php } ?>