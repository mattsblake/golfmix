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

				<div class="daily-box-top"><h3>Featured Offer</h3></div>
				<div class="daily-box-bottom-2">							
								<div id="ktar-promo">
									<h4>YOUR CHANCE TO WIN THE GOLF TRIP OF A LIFETIME AT PEBBLE BEACH!</h4>
									<div class="best-image-wrapper">
										<div class="best-image" style="width: 100%;height: auto;"><a href="http://www.sunhealth.org/foundation/golf-dream-trip-lexus-champions-charity-2014" target="_blank"><img src="http://golfmix.com/wp-content/uploads/2014/07/lexus-champions-for-charity-logo.png" style="width:100%;"></a></div>
									</div>
									<div class="promo-content">
									</div>
									<div class="clear"></div>
								</div>
																
								<div class="review-congrats">Win the golf trip of a lifetime to Pebble Beach at <a href="http://www.sunhealth.org/foundation/golf-dream-trip-lexus-champions-charity-2014" target="_blank">sunhealth.org</a></div> 
								
							
							</div>
							
				<div class="clear"></div>
		</div>
	</div>
<?php //exit; ?>