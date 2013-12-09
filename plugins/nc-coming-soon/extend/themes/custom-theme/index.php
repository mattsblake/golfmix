<?php $theme_url = WP_CONTENT_URL. '/plugins/' . plugin_basename(dirname(__FILE__)); ?>
<html>
    <head>
        <title><?php echo get_option_nc_cs_top('seo_title'); ?></title>
        <meta charset="utf-8" />
        <meta name="description" content="<?php echo get_option_nc_cs_top('seo_description'); ?>" />
        <meta name="keywords" content="<?php echo get_option_nc_cs_top('seo_keywords'); ?>" />
        <link rel="shortcut icon" href="<?php echo get_option_nc_cs_top('favicon') ?>" />
     	<link rel="stylesheet" href="<?php echo $theme_url; ?>/style.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/rounded.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/theme.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/twitter.min.js"></script>  
        
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> 
		
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
    <?php if(isset($_REQUEST['color'])) { ?>
	    <style>
	    	#coming_soon_box h4 {color: #333;}
	    	#coming_soon_box h2 {color: #111;}
	   		#coming_soon_box { background: rgba(250, 250, 250, 0.792969);color: #333;}
	    </style>
    <?php } ?>
    
		<div style='position: absolute; z-index: 10; width: 100%'> 
			<div class='container' id='coming_soon_page'> 
				<img alt="Logo-huge" id="coming_soon_logo" src="http://golfmix.com/images/golfmix.png" style="<?php if(isset($_REQUEST['hide'])) { echo 'display:none;';} ?>"/> 
				<div class='clearfix' id='coming_soon_box'>
				<?php if(isset($_REQUEST['login'])) { ?>
					<h2>Log in to access the site in private beta.</h2>
					<?php login_with_ajax() ?>
					<div style="float: right;margin-top: -25p">
					<?php jfb_output_facebook_btn(); jfb_output_facebook_init(); jfb_output_facebook_callback(); ?>
					</div>
				<?php } elseif(isset($_REQUEST['register'])) { ?>
					<h2>Register for a golfmix account:</h2>
					 <?php 
					 	$args = array('form_id' => 'registerform'); 
						wp_login_form($args); 
					 ?>
					<div style="position:absolute;right:0;bottom:20px;">
					<?php jfb_output_facebook_btn(); jfb_output_facebook_init(); jfb_output_facebook_callback(); ?>
					</div>
				<?php } elseif(!isset($_REQUEST['referred_by'])) { ?>
					
					<?php //echo nc_cs_email(); ?>
					<?php wpnewsletter_opt_in('registerform'); ?>
					
				 <?php } else { ?>
						<h2>Thanks! Want to get an early invitation?</h2>
						<p>
						Invite at least
						<strong>3</strong>
						friends using the link below. The more friends you invite, the sooner you'll get access!
						</p>
						<p style="margin-bottom:10px">To share with your friends, click "Share" and "Tweet":</p>
						<a href="http://www.facebook.com/sharer.php?u=http://golfmix.com/?referred_by=<?php echo $_REQUEST['referred_by']; ?>" name="fb_share" share_url="http://golfmix.com/?referred_by=<?php echo $_REQUEST['referred_by']; ?>" style="display: block; float: left; margin-top: -1px; margin-right: -176px; margin-bottom: 0px; margin-left: 176px; text-decoration: none; " type="button"><span class="FBConnectButton FBConnectButton_Small" style="cursor:pointer;"><span class="FBConnectButton_Text">Share</span></span></a>
						<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
						<iframe allowtransparency="true" frameborder="0" scrolling="no" tabindex="0" class="twitter-share-button twitter-count-none" src="http://platform0.twitter.com/widgets/tweet_button.html?_=1295910580430&amp;count=none&amp;lang=en&amp;related=golfmix&amp;text=%40golfmix%20is%20launching%20soon%20and%20I'm%20one%20of%20the%20first%20in%20line!%20Join%20me%20at%20&amp;url=http://golfmix.com/?referred_by=<?php echo $_REQUEST['referred_by']; ?>" style="width: 55px; height: 20px; " title="Twitter For Websites: Tweet Button"></iframe>
						<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
						<p style="margin:10px 0">Or copy and paste the following link to share wherever you want!</p>
						<input id="code" name="code" style="width:370px;float:none;margin:0 auto;" type="text" value="http://golfmix.com/?referred_by=<?php echo $_REQUEST['referred_by']; ?>">
					<?php } ?>
				</div> 
			</div> 
		</div> 
		<div id="supersize" style="display: block; width: 1800px; height: 1600px; "><img class="activeslide" src="<?php echo $theme_url; ?>/images/tpc3.jpg" style=" width: 1800px; left: 0px; top: -600.5px; <?php if(isset($_REQUEST['hide'])) { echo 'display:none;';} ?>"></div>
		
		<div class="attribution">
			<strong>TPC Scottsdale</strong><br />
			The Stadium Course<br />
			<em>Hole #16</em>
		</div>
   
		
    </body>
</html>