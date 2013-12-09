<?php
/**
 * Template Name: Mobile Nearby
 *
**/
if(!isset($_REQUEST['app'])) {

global $post;
include('./wp-admin/admin-functions.php');	
	
?>
<head>	
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-mobile.css?v=1" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<title>Deal of the Week - golfmix.com</title>
	
	<?php //wp_head(); ?>
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
<body>
<?php } else { get_header(); } ?>

<script type="text/javascript">

$(document).ready( function() {
        
    // Check for geoLocation Support
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(renderPosition, renderError);
    } else {
        $('#geoResults').html('Your browser does not support geolocation.');
    }
    
    //jQuery to render the output
    function renderPosition(position) {
                
        window.location= "<?php bloginfo("url"); ?>/search/?lat="+position.coords.latitude+"&lon="+position.coords.longitude+"&app=no";
        
    }
    
    function renderError() {
    	$('#geoResults').html('We could not get your location. Please try a search.');
    }

});
    
</script>

<div id="geoResults"><div style="margin:20px auto;width:30px;"><img src="<?php bloginfo('template_url')?>/images/ajax-loader.gif" style="width:30px;" /></div></div>


</body>