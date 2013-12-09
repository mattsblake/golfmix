<?php

/**

 * The Header for our theme.

 *

 * Displays all of the <head> section and everything up till <div id="main">

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php
	
	if(is_page('428') && is_user_logged_in()) { 
	
		echo 'Your Profile';
		
	} else  {

		global $page, $paged;
		
		if(isset($_REQUEST['q'])) { echo $_REQUEST['q'].' Golf Courses | '; } else { 
	
			if ( $paged >= 2 || $page >= 2 )
		
				echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
			
		}
		
		if(isset($_REQUEST['location'])){  echo $_REQUEST['location'] .' Golf Courses | '; } 
			
		wp_title();

	}

	?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<?php
require_once("Mobile_Detect.php");
global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { ?>

	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-mobile.css?v=1.2" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	
	<?php wp_head(); ?>
	
	<?php if(is_page('Search')) { ?>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCzc4jt-um_yTQ4Gl9fBS4W8DPRg1CsfQA&sensor=false"></script>
    <?php } ?>

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-21045136-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
</head>
<?php if(is_page('Search')) { ?><body onload="initialize()" onunload="GUnload()"><?php } else { ?><body><?php } ?>
	<?php if((is_page(array('428','861')) || is_singular('post')) && !isset($_REQUEST['app'])) { } else { ?>
	<style>
	body {
		width:100%;
	}
	</style>
	
	<?php $this_uri = trim($_SERVER['REQUEST_URI']); 
		if(isset($_REQUEST['debug'])) { echo $this_uri; }
	?>
	
	<div id="header"><a href="<?php bloginfo('url'); ?>" id="logo">golfmix</a><?php if(stristr($this_uri, 'arizona') === FALSE) { ?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>?app=no" class="back">&#171; Back</a><?php } ?><?php if(is_page('Search') && stristr($this_uri,'map') === FALSE) { ?><a href="<?php echo get_bloginfo('url').'/search/?'.$_SERVER['QUERY_STRING']; ?>&map=1" class="back" style="right: 10px;left: auto;">Map</a><?php } elseif(is_page('Search')) { ?><a href="<?php echo get_bloginfo('url').'/search/?'.str_replace('&map=1','',$_SERVER['QUERY_STRING']); ?>" class="back" style="right: 10px;left: auto;">List</a><?php } ?>
</div>
	
	<?php if(is_page('819')) { } else { ?>
	<div id="search">
		<form method="get" class="mobile-search" action="<?php bloginfo('url'); ?>/search/" autocomplete="off">
			<input type="submit" id="filter" value="Filter">
			<input name="q" id="q" value="<?php if(isset($_GET['q'])) { echo wp_specialchars($_GET['q']); } else { echo 'Find a golf course'; } ?>">
			<input type="hidden" name="app" id="app" value="no">
			<input type="submit" name="search" value="Search">
		</form>
		<script>
			$("#q").focus( function() {
				$(this).val('');	
			});
		</script>
	</div>
	<?php } ?>

	<?php } ?>



<?php } else { ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=1.8" />

<?php if(isset($_REQUEST['fb'])) { ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/style-fb.css" />
<?php } ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta property="og:title" content="<?php wp_title(); ?>"/>
<meta property="og:url" content="<?php if(is_single()||is_page()) { the_permalink(); } else { bloginfo('url'); } ?>"/>
<meta property="og:site_name" content="golfmix"/>
<meta property="fb:admins" content="10105391"/>
<meta property="og:description"
      content="<?php if(is_page()) { the_title(); } elseif(is_single()) { echo 'Reviews of '.get_the_title().', from regular golfers just like you.  Read & write your own reviews at www.golfmix.com.'; } else { echo "golfmix is the ultimate resource to help you decide where to play golf in arizona.  read and write reviews of every course in the state.  whether you're a scratch or you shoot 115, there are golfers like you sharing their thoughts and ratings of tracks all across arizona.  join the movement!"; } ?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=9" />


<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/jquery.ad-gallery.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/stylesheet.css" />



<?php

	/* We add some JavaScript to pages with the comment form

	 * to support sites with threaded comments (when in use).

	 */

	if ( is_singular() && get_option( 'thread_comments' ) )

		wp_enqueue_script( 'comment-reply' );



	/* Always have wp_head() just before the closing </head>

	 * tag of your theme, or you will break many plugins, which

	 * generally use this hook to add elements to <head> such

	 * as styles, scripts, and meta tags.

	 */

wp_head();

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>


<?php if(is_single() && get_post_type() == 'post') { ?>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/jquery.ad-gallery.js"></script>

	<script type="text/javascript">

	$(function() {

	$('img.image1').data('ad-desc', 'Whoa! This description is set through elm.data("ad-desc") instead of using the longdesc attribute.<br>And it contains <strong>H</strong>ow <strong>T</strong>o <strong>M</strong>eet <strong>L</strong>adies... <em>What?</em> That aint what HTML stands for? Man...');

	$('img.image1').data('ad-title', 'Title through $.data');

	$('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');

	$('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');

	var galleries = $('.ad-gallery').adGallery();

	$('#switch-effect').change(

	 function() {

	   galleries[0].settings.effect = $(this).val();

	   return false;

	 }

	);

	$('#toggle-slideshow').click(

	 function() {

	   galleries[0].slideshow.toggle();

	   return false;

	 }

	);

	$('#toggle-description').click(

	 function() {

	   if(!galleries[0].settings.description_wrapper) {

		galleries[0].settings.description_wrapper = $('#descriptions');

	   } else {

		galleries[0].settings.description_wrapper = false;

	   }

	   return false;

	 }

	);

	});

</script>
<?php } ?>

<?php if(is_home() || is_front_page()) { } elseif(is_single() && get_post_type() !== 'blog' ) { ?>

	<?php 
	if ( have_posts() ) while ( have_posts() ) : the_post();
	
	$course_id= get_post_meta($post->ID, 'course_id',1);
	include('courses_call.php'); 
	
	endwhile;
	
	
	
	if($c_address1) {
		//$map_search = $c_address1.' ' . $c_address2 . ', '.$c_city.', '.$c_state.' '.$c_zip;
		//$map_search = str_replace(' ','+',$map_search);
		//$mapapi = 'http://where.yahooapis.com/geocode?q='.$map_search.'&appid=dj0yJmk9NGVyVlBCNEIzRG9PJmQ9WVdrOVRVOVZZV0ZSTkhNbWNHbzlNVFkwTnpVMk1UUTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD01YQ--';
		//echo $mapapi;
		//$ch = curl_init();
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_URL, $mapapi);
		//$data = curl_exec($ch);
		//curl_close($ch);
		//$map = new SimpleXMLElement($data);
		//$longitude = $map->Result->longitude;
		//$latitude =  $map->Result->latitude;
		$longitude = $c_longitude;
		$latitude = $c_latitude;
		$map_link = $c_name;
		$map_link = str_replace(' ','+',$map_link);
	}
	?>
	
	
	 <script src="http://maps.google.com?file=api&amp;v=2.x&amp;key=ABQIAAAAz2Z6CVDYyBzkJnfmk-LVzBTw2Dem2yglPhcKkFd0PCPxkdXJwBSPDh9FUY867JwlwdRcqq_yt3t8nA" type="text/javascript"></script>
	<script type="text/javascript">
	   function initialize() {
		  var map = new GMap2(document.getElementById("map_canvas"));
		  var point = new GLatLng(<?php echo $latitude.','.$longitude;?>);
		  map.setCenter(point, 14);
		  map.setMapType(G_NORMAL_MAP);
		  var marker = new GMarker(point);
		  map.addOverlay(marker);  
	      map.setUIToDefault();
	
	      // Enable the additional map types within
	      map.enableRotation();
	      
	    }
	    
	    $(document).ready(function(){
	    	var maplink = $(".map-anker").attr('href');
	    	maplink = maplink + '<?php echo $map_link; ?>';
	    	$(".map-anker").attr('href', maplink);
	    });
	    
	    </script>
	
	
	
	<script type="text/javascript" language="javascript">
	
	$(document).ready(function(){
	
	$(".tab-main ul li a").click(function(){
	
	$(".tab-main").find(".active").removeClass("active");
	
	$(this).addClass("active");
	
	});
	
	});
	
	</script>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script>
	
	<script type="text/javascript">
	
		$(document).ready(function(){
	
			$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
	
		});
	
	</script>

<?php } ?>


<?php if(is_page('Search')) { ?>

<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCzc4jt-um_yTQ4Gl9fBS4W8DPRg1CsfQA&sensor=false"></script>

<?php } ?>

<!--[if IE 6]>

<script src="<?php bloginfo( 'template_url' ); ?>/png/png-fix.js" type="text/javascript"></script>

<script src="<?php bloginfo( 'template_url' ); ?>/png/png.js" type="text/javascript"></script>

<![endif]-->

<!--[if lt IE 7]>

<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>

<![endif]-->

<?php if(is_home() || is_category()) { ?>
<!-- Share Scripts -->
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<?php } ?>

<?php if(isset($_REQUEST['beta'])) { global $beta; $beta = true; } ?>


<script type='text/javascript' src='http://partner.googleadservices.com/gampad/google_service.js'>
</script>
<script type='text/javascript'>
GS_googleAddAdSenseService("ca-pub-2177055306714894");
GS_googleEnableAllServices();
</script>
<script type='text/javascript'>
GA_googleAddSlot("ca-pub-2177055306714894", "Footer_728x90");
GA_googleAddSlot("ca-pub-2177055306714894", "Header_468x60");
GA_googleAddSlot("ca-pub-2177055306714894", "Sidebar_300x250");
</script>
<script type='text/javascript'>
GA_googleFetchAds();
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21045136-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php if(isset($_REQUEST['fb'])) { ?>
  	<meta http-equiv="Content-Type" content="text/html;
charset=iso-8859-1" />
		<script type="text/javascript">
		window.fbAsyncInit = function() {
		FB.Canvas.setSize();
		}
		// Do things that will sometimes call sizeChangeCallback()
		function sizeChangeCallback() {
		FB.Canvas.setSize();
		}
		</script>
		
</head>

<body <?php body_class(); ?>>
	
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script>
		FB.init({
		appId : '149725578415723',
		status : false, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml : true // parse XFBML
		});
		
		$(function() {
		    $('a[href^=http]').click( function() {
		        window.open(this.href);
		        return false;
		    });
		});
		</script>

<?php } else { ?>
</head>

<?php if((is_single() && get_post_type() == 'post') || is_page('Search')) { ?><body onload="initialize()" onunload="GUnload()"><?php } else { ?><body><?php } ?>

<?php } ?>

<div id="wrapper">

	<div id="inner-wrapper"> 

		<!--header-->

		<div id="header">

			<div class="logo"><a href="<?php bloginfo( 'home' ); ?>/"><img src="<?php bloginfo( 'template_url' ); ?>/images/gm-logo.jpg" alt="" border="0" /></a></div>
		

			<div class="login-box">

				<ul>
					<!-- mclude /wp-content/themes/golfmix/login-links.php --><!-- /mclude -->
					<?php include('login-links.php'); ?>
					<li style="clear:both;"><a class="appstore" href="http://itunes.apple.com/us/app/golfmix/id497402587?ls=1&mt=8" target="_blank">app store</a></li>
					<li><a class="twitter" href="http://www.twitter.com/golfmix" target="_blank">twitter</a></li>
					<li><a class="facebook" href="http://www.facebook.com/golfmix" target="_blank">facebook</a></li>
					<li><a class="rss" href="<?php bloginfo('rss2_url');?>" target="_blank">rss</a></li>
				</ul>

				<br class="clear" />

			</div>

			<br class="clear" />

		</div>

		<!--/header--> 

		

		<!--menu-->

		<div id="outer-menu-cont">
			<div id="menu-cont-center">
				<div id="top-row">
					<div id="menu">
						<?php  wp_nav_menu(array('menu'=>'Navigation','container'=>'ul'));?>
					</div>
				</div>
				<div id="bottom-row">
						<form method="get" class="custom_search widget custom_search_custom_fields__search" action="<?php bloginfo('url');?>/search/" autocomplete="off">
							<div class="searchform-params">
							<div class="TextField"><div class="searchform-param"><label class="searchform-label">Find a Golf Course in Arizona</label><span class="searchform-input-wrapper"><input name="q" id="q" value="Course, City or Zip"></span></div></div>
							</div>
							<div class="searchform-controls">
								<input type="submit" name="search" value="Search">
							</div>
						</form>
						<script>
							$("#q").focus( function() {
								$(this).val('');	
							});
						</script>
					<?PHP //if(function_exists('register_sidebar')&&dynamic_sidebar('Search')){} ?>
					
					<div class="contact-links-box">
						<ul>
							<li><a href="<?php bloginfo('url');?>/contact?issue=bug" class="email-link">Report a Bug</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/menu--> 
		
			
			<div class="featured_giveaway">
				<?PHP if(function_exists('register_sidebar')&&dynamic_sidebar('Featured Header')){} else { ?>
				<strong><strong><a href="http://golfmix.com/blog/welcome-to-golfmix/">Welcome to arizona's golfmix!</a></strong> Tomorrow's <strong>review of the day </strong> will win an Arron Oberholser autographed golfmix hat. To enter, <a href="http://golfmix.com/write-a-review">write a review</a>!
				<?php } ?>
			</div>

<?php } ?>