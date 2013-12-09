<?php

/**

 * The template for displaying the footer.

 *

 * Contains the closing of the id=main div and all content

 * after.  Calls sidebar-footer.php for bottom widgets.

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */

?>

	<!--footer-->
<?php
global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 
?>

<div id="sub-footer">&copy; 2011-12 golfmix, Inc. - <a href="<?php bloginfo('url'); ?>?full=1">Full Site</a></div>

<div id="footer"><?php if(is_single()) { ?><a href="<?php bloginfo('url'); ?>/m/a/?id=<?php echo the_id(); ?><?php if(isset($_REQUEST['app'])) { echo '&app=no'; } ?>" class="back left" />Review this course</a><?php } else { ?><a href="<?php bloginfo('url'); ?>/login?action=register" class="back left"><?php if(!is_user_logged_in()) { echo 'Register'; } else { echo 'My Profile'; } ?></a><?php } ?><?php if(is_user_logged_in()) { ?><a href="<?php echo wp_logout_url(''); ?><?php if(isset($_REQUEST['app'])) { echo '&app=no'; } ?>" class="back right" />Logout</a><?php } else { ?><a href="<?php echo wp_login_url( home_url() ); ?><?php if(isset($_REQUEST['app'])) { echo '&app=no'; } ?>" class="back right" />Login</a><?php } ?></div>



<?php } elseif($detect->isMobile() && !$detect->isIpad()) { ?>	


<?php } else { ?>	

</div> <!--inner wrapper-->

	<div id="footer">

		<div class="footer-nav">
			
			<?php include('cities-list.php'); ?>

			<div class="footer-about">
				<h3>About Us</h3>
				<?php wp_nav_menu(array('menu'=>'Footer_nav','container'=>'ul'));?>
			</div>
			
			<div class="social-link-box-2">
				<h3>Follow Us</h3>
				<ul>
					<li><a class="face-book-icon" href="http://www.facebook.com/golfmix" target="_blank">Find us on Facebook</a></li>
					<li><a class="twitter-icon" href="http://www.twitter.com/golfmix" target="_blank">Follow us on Twitter</a></li>
					<li><a class="rss-icon" href="<?php bloginfo('rss2_url');?>" target="_blank">Subscribe to our RSS</a></li>
				</ul>
			</div>
			
			<div class="footer-logo"></div>
			
			<div class="clear"></div>
			
			<p><a href="<?php bloginfo('url'); ?>/terms-of-service"  style="color:white;">Terms of Services</a> | <a href="<?php bloginfo('url'); ?>/privacy-policy" style="color:white;">Privacy Policy</a><span>&copy;2011-12&nbsp;golfmix.com.  All Rights Reserved.</span></p>


		</div>
		

		<div class="clear"></div>

	</div>

	<!--/footer--> 

</div>

<div id="feedback"><a href="<?php bloginfo('url'); ?>/contact?issue=feedback"><img src="<?php bloginfo('template_url'); ?>/images/feedback.png" /></a></div>
<?php } ?>

<?php

	/* Always have wp_footer() just before the closing </body>

	 * tag of your theme, or you will break many plugins, which

	 * generally use this hook to reference JavaScript files.

	 */



	wp_footer();

?>
</body>

</html>

